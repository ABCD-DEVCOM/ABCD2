/*********************************************************************
 * FILE cnv_csv_to_iso.c
 *      This file contains c-code to convert spreadsheet information to iso-2709.
 *      The current NVBS process for creating new data in the ABCD database relies on
 *      spreadsheets with information from relative small subsets that are imported into ABCD.
 *      This program takes a .csv file and converts it into a loadable iso-2709 file.
 *
 *      The steps in this process are:
 *       -  Convert excel xls/xlsx to csv ( interactive: Excel/ commandline: VB script or Powershell)
 *       -  Convert csv to iso ( commandline: cnv_csv_to_iso)
 *       -  Import iso in ABCD ( interactive: ABCD)
 *
 *      The format of the iso-2709 file is defined in the corresponding norm.
 *      The ABCD "beeldbank" of the NVBS requires only a subset of all options in this norm.
 *
 *      The format of the csv-file is the excel standard format
 *       -  Comma (or other) separated, some fields enclosed by double quotes ("")
 *      The structure of the csv-file:
 *       -  The first line contains the ABCD field identifiers (e.g. 100,110,....)
 *       -  The program converts FDT titles (e.g. "Copyright") into numeric FDT tags (e.g. 180).
 *       -  Following lines define the data.
 *       -  A record ends with a lineend, embedded lineends (between "") are allowed
 *       -  A data cell gives the data of the corresponding field. (may be empty)
 *       -  All records must have the same number of columns.
 *       -  ABCD has repeating fields. This program can process the phenomonon in three ways:
 *          - Multiple columns with the same tag number are allowed.
 *          - Columns of repeated tags (as given by the fdt) are split at delimiter ; (see option -r)
 *          - Columns of repeated tags (as given by the fdt) are split at an embedded lineend
 *          - All methods can be used simultaneously.
 *
 *      Compile this program for linux or windows with cygwin (bash) with the gcc compiler:
 *              gcc -o cnv_csv_to_iso cnv_csv_to_iso.c
 *              This program will produce files with LF
 *      Compiling this program for windows command line (CMD) usage:
 *          By cygwin. Creates a staticly linked executable, produce files with CRLF:
 *              i686-w64-mingw32-gcc -o cnv_csv_to_iso.exe cnv_csv_to_iso.c
 *          By MinGW. Creates a staticly linked executable, produce files with CRLF:
 *              gcc -o cnv_csv_to_iso.exe cnv_csv_to_iso.c
 *      Check source on windows with cygwin.
 *              splint cnv_csv_to_iso.c -unrecog  -nullpass -compdef -bufferoverflowhigh
 *              Gives several warnings. None serious at first inspection.
 *      Setting environment variables in bash shell (linux,cygwin,MinGW):
 *              export ABCD_FDT_FILE=<path to fdtfile>
 *
 *      Note-1: Function "setlocale" is not used here. This function is required for internationalization
 *              of the program. May influence messages to the user (with specific functions)
 *              Specific printf/fprintf: Influences the decimal point and the # modifier in format strings.
 *              Specific ispunct/is**: Influences character classification.
 *              Conclusion: As file I/O itself is not touched by "locale" the standard "C" locale is sufficient.
 *
 * AUTHOR   Fred Hommersom, q00GetLine derived from NetBSD
 * HISTORY:
 *      2018-03-04:(fho) Initial version
 *      2018-03-16:(fho) Many improvements, suitable for Linux/Windows:cygwin/Windows:MinGW
 *      2018-03-17:(fho) Remove leading spaces in embedded repeatable fields
 *      2018-03-18:(fho) Detect Byte Order Mark for UTF-8 (as produced by excel). Skip empty lines. Locale option
 *      2018-04-05:(fho) stdin,stdout,stderr, autodetect separator, LF/CR/CRLF improved
 *      2018-04-09:(fho) option -s, removed option -l, environment variables
 *      2018-04-10:(fho) print BOM in case of UTF-8 with BOM
 *      2018-04-20:(fho) Skip lines with only empty tokens
 *      2018-05-10:(fho) Replaced q00GetLine by q00GetRecord and more to facilitate embedded lineends
 *      2018-05-12:(fho) Corrected spurious error in double quote processing
 *      2018-05-16:(fho) Corrected error due to bad previous correction
 *      2018-05-17:(fho) Modified recordbuffersize 5000--> 9999 to accomodate huge record
 *      2018-05-24:(fho) Records mat have less entries as first line. More is still an err0r.
 *_____________________________________________________________________
 * Call tree    : main
 *              :   q00ReadFDT
 *              :       q00GetRecord
 *              :   q00ProcessCSV
 *              :       q00GetRecord
 *              :       q00ReplaceChars
 *              :       q00DetectSeparator
 *              :           q00TokenizeCSV
 *              :       q00TokenizeCSV
 *              :       q00CheckFDTwithCSV
 *              :       q00CheckActRepToks
 *              :       q00WriteToISOFile
 *              :           q00CreateISORecord
 *              :   q00Help
*********************************************************************/
#include <stdio.h>
#include <stdlib.h>
#ifndef S_SPLINT_S /* in cygwin unistd.h references .h files that crash splint. now skipped by splint*/
#include <unistd.h>
#endif
#include <string.h>
#include <ctype.h>
#include <errno.h>

#define VERSION "3.4 2018-06-24"
#define isStrNull(str) (str==NULL || (int)strlen(str) == 0)

typedef struct FDT {/* Struct with values read from the fdt.Only the values used by this program */
    char type[2];   /* Single character data entry Type (Field/Heading/... + terminator)*/
    int  itag;      /* Numerical value identifying the field in the record (110/120/...). */
    char *title;    /* Title or description of the field */
    int  iprincipal;/* Marks if this field is the record`s principal entry. (0=no,1=yes) */
    int  irepeating;/* Numerical value indicates if this field is repeatable (0=no,1=yes) */
} FDT;

/* items available in all modules of this file */
static int   CMDOPT8        = -1;    /* <=0 : do not split record, 1=split record in lines of 80 characters*/
static int   CMDOPTS        = -1;    /* <=0 : warn for <> signs, 1=subsitute <> signs*/
static int   MAXFDTRECORDS  = 100;  /* Current databases have < 25 lines in their fdt */
static int   MAXISORECLEN   = 9999; /* Current iso records do not exceed ~2000 characters */ 
static int   MAXCSVTOKENS   = 250;  /* Current exports have <125 columns, even with repeated fields */

static char  CSVSTRINGIND   = '"';                      /* Excel uses default the double quote */
static char* CSVDELIMITER   = NULL;                     /* Must be set to actual character */
static char* CSVDELIMITERSET= ",;:|.~!@#$%^&-_+=/\\?\t";/* Test delimiters. Excel uses default the comma */
static char* ENV_FDT_FILE   = "ABCD_FDT_FILE";          /* environment variable to specify the fdt filename (as option -d)*/ 
static char* CNVXLS_OPT_S   = "CNVXLS_OPT_S";           /* environment variable to specify option -s*/ 
static char* CNVXLS_OPT_8   = "CNVXLS_OPT_8";           /* environment variable to specify option -8*/ 
static char* IN_REDIR_NAME  = "<stdin>";                /* Dummy name to show input redirection */
static char* INTERNALERR    = "***__Internal_Error__:"; /* standard text for arraylimits etc */
static char* ISODELIMITER   = "#";                      /* Field & record separator in the ISO file, the \0 is added by strcat */
static char* OUT_REDIR_NAME = "<stdout>";               /* Dummy name to show output redirection */
static char* REPDELIMITER   = NULL;                     /* Separator for repeats in one csv field (strtok format). Must be set to actual*/

/* prototypes available in all modules of this file */
static int     q00CheckActRepToks( struct FDT fdtlines[], int numfdtlines, char *tokens[], int numtokens, int reptoks[]);
static int     q00CheckFDTwithCSV( struct FDT fdtlines[], int numfdtlines, char *tokens[], int numtokens);
static int     q00WriteToISOFile( char *isofile, FILE **fpiso,
                                  char *tagtokens[], int reptoks[], char *tokens[], int numtokens,
                                  int *numoutputrecords, int *numoutputlines);
static int     q00CreateISORecord( char *tagtokens[], int reptoks[], char *tokens[], int numtokens, char *isorecord);
static int     q00DetectSeparator( char *record, int recordnumber );
static int     q00ProcessCSV( char *csvfile, struct FDT fdtlines[], int numfdtlines, char *isofile);
static int     q00ReadFDT( char *fdtfile, int max_fdtlines, struct FDT fdtlines[], int *numlines);
static int     q00ReplaceChars( char *record, int recordnumber );
static int     q00TokenizeCSV( char *record, int recordnumber, int maxtokens, char *tokens[], int *numtokens );
static void    q00Help( int helptype);
static ssize_t q00GetRecord(char **buf, size_t *bufsiz, int *filelinenr, FILE *fp);

/*******************************************************************************
 ******************************************************************************/ 
int main( int argc, char *argv[] )
/*******************************************************************************
 * NAME:  main
 *
 * DESCRIPTION
 *   Main routine for the cnv_csv_to_iso program.
 *
 * ARGUMENTS
 *   Argument               In/Out     Description
 *   argc                   In         Count of command line arguments.
 *   argv                   In         Set of command line arguments and vals.
 *
 * RETURNS
 *   0                      - Success
 *   !0                     - Failure
 ******************************************************************************/ 
{
    int option = 0;
    int index = 0;
    char *infile = NULL;
    char *fdtfile = NULL;
    char *outfile = NULL;
    char *tmpenv = NULL;
    char tmpfilnam[1024];
    int num_fdtrecords = 0;
    struct FDT fdtrecords[MAXFDTRECORDS];
    CSVDELIMITER = strdup("autodetect"); /* avoids change of read-only string*/
    REPDELIMITER = strdup(";");          /* avoids change of read-only string*/
    /* 
    ** ----------------------------------
    ** Process the commandline arguments
    */ 
    while ( ( option = getopt( argc, argv, "vhH8Si:d:o:c:r:" ) ) != -1 ) {
        switch ( ( char ) option ) {
            case 'i':
                infile = optarg;
                break;
            case 'd':
                fdtfile = optarg;
                break;
            case 'o':
                outfile = optarg;
                break;
            case 'c':
                CSVDELIMITER = optarg;
                CSVDELIMITER[1] = '\0'; /* take only the first character */
                break;
            case 'r':
                REPDELIMITER = optarg;
                break;
            case '8':
                CMDOPT8 = 1;
                break;
            case 'S':
                CMDOPTS = 1;
                break;
            case 'v':
                q00Help( 1 );
                goto EXIT;
            case 'H':
                q00Help( 2 );
                goto EXIT;
            case 'h':
                 q00Help( 3 );
                goto EXIT;
           default:
                q00Help( 0 );
                goto EXIT;
        }
    }

    /* check spurious commandline arguments */
    for (index = optind; index < argc; index++) {
        fprintf(stderr, "*** Non-option argument %s\n", argv[index]);
        q00Help(0);
        goto EXIT_ERROR;
    }

    /*
    ** Check parameters : inputfile is required and must be readable
    ** Test first the commandline parameter.
    ** If the parameter is empty: check if stdin is redirected
    ** Yes: set dummy filename "<stdin>" as inputfilename
    ** No: error
    */
    if ( isStrNull(infile) ) {
        if  ( isatty(STDIN_FILENO) == 0 ) {
            infile = IN_REDIR_NAME;
        } else {
            fprintf(stderr, "*** Input CSV file is required ***\n");
            fprintf(stderr, "*** Use -i option or redirect standard input to this file ***\n");
            q00Help(0);
            goto EXIT_ERROR;
        }
    }

    /*
    ** Check parameters : fdtfile is required
    ** Test first the command line parameter.
    ** If the parameter is empty: check environment variable.
    ** Still empty: error
    */
    if ( isStrNull(fdtfile) ) {
        fdtfile = getenv(ENV_FDT_FILE);
        if ( isStrNull(fdtfile) ) {
            fprintf(stderr, "*** FDT file name is required. ***\n");
            fprintf(stderr, "*** Use -d option or environment variable %s ***\n", ENV_FDT_FILE);
            q00Help(0);
            goto EXIT_ERROR;
        }
    }

    /*
    ** Check parameters: output file is required
    ** Test first the command line parameter.
    ** If the parameter is empty: check if stdout is redirected
    ** Yes:Set dummy filename "<stdout>" as outputfilename
    ** No: If a valid inputfilename is present:
    **          Set the name of the outputfile to <infile>.iso
    **      Else Error  
    */
    if ( isStrNull(outfile) ) {
        if  ( isatty(STDOUT_FILENO) == 0 ) {
            outfile = OUT_REDIR_NAME;
        } else {
            if ( strcmp(infile,IN_REDIR_NAME) != 0 ) {
                strcpy( tmpfilnam, infile);
                strcat( tmpfilnam, ".iso");
                outfile = tmpfilnam;
            } else {
                fprintf(stderr, "*** Output ISO file is required ***\n");
                fprintf(stderr, "*** Use -o option or redirect standard output to this file ***\n");
                q00Help(0);
                goto EXIT_ERROR;
            }
        }
    }
    /*
    ** Delete a possible existing output file
    ** No error if file does not exist
    */
    if ( strcmp(outfile,OUT_REDIR_NAME) != 0 ) {
        if ( unlink( outfile ) != 0 && errno!=ENOENT) {
            fprintf( stderr, "*** Unable to delete existing outputfile '%s', status: %s\n", outfile,strerror(errno));
            q00Help(0);
            goto EXIT_ERROR;
        }
    }
    /*
    ** Check if the enviroment variables for cmdopt8 and cmdopts are set
    ** Note that the commandline option prevails
    */
    tmpenv = getenv(CNVXLS_OPT_S);
    if ( !isStrNull(tmpenv) && CMDOPTS <= 0 ) {
        if ( strcmp(tmpenv,"0") == 0 || strcmp(tmpenv,"n") == 0 ) {
            CMDOPTS = 0;
        } else if ( strcmp(tmpenv,"1") == 0 || strcmp(tmpenv,"y") == 0 ) {
            CMDOPTS = 1;
        } else {
            fprintf( stderr,"*** Value %s in invalid for environment variable %s\n", tmpenv, CNVXLS_OPT_S);
            q00Help(0);
            goto EXIT_ERROR;
        }
    }
    tmpenv = getenv(CNVXLS_OPT_8);
    if ( !isStrNull(tmpenv) && CMDOPT8 <= 0 ) {
        if ( strcmp(tmpenv,"0") == 0 || strcmp(tmpenv,"n") == 0 ) {
            CMDOPT8 = 0;
        } else if ( strcmp(tmpenv,"1") == 0 || strcmp(tmpenv,"y") == 0 ) {
            CMDOPT8 = 1;
        } else {
            fprintf( stderr,"*** Value %s in invalid for environment variable %s\n", tmpenv, CNVXLS_OPT_8);
            q00Help(0);
            goto EXIT_ERROR;
        }
    }

    /*
    ** Print the result of the input parameter processing
    */
    fprintf(stderr, "-i: CSV to be converted will be read from   : '%s'\n", infile);
    fprintf(stderr, "-d: Field Definition Table will be read from: '%s'\n", fdtfile);
    fprintf(stderr, "-o: Processing results will be written to   : '%s'\n", outfile);
    fprintf(stderr, "-c: Separator for elements in csv line      : '%s'\n", CSVDELIMITER);
    fprintf(stderr, "-r: Separator for repeats  in csv elements  : '%s'\n", REPDELIMITER);
    if ( CMDOPT8 <= 0 ) {
        fprintf(stderr, "-8: ISO records are written as single line\n");
    } else {
        fprintf(stderr, "-8: ISO records are split into lines of 80 characters\n");
    }
    if ( CMDOPTS <= 0 ) {
        fprintf(stderr, "-S: HTML brackets (<>) give a warning\n");
    } else {
        fprintf(stderr, "-S: HTML brackets (<>) are replaced by double angle quotation marks («»)\n");
    }

    /*
    ** -------------------------------------------------
    ** Read the fdt into a struct for further processing
    */
    fprintf(stderr, "Reading the File Definition Table: %s\n", fdtfile);
    if ( q00ReadFDT( fdtfile, MAXFDTRECORDS, fdtrecords, &num_fdtrecords ) !=0 ) goto EXIT_ERROR;
    fprintf(stderr, "Reading the File Definition Table: extracted %d lines with Field information.\n", num_fdtrecords);

    /*
    ** ------------------------------
    ** Read the csv and export to iso
    */
    fprintf(stderr, "Processing csv file : %s\n", infile);
    if ( q00ProcessCSV( infile, fdtrecords, num_fdtrecords, outfile ) !=0 ) goto EXIT_ERROR;

EXIT:
    fprintf(stderr, "Successfull completion\n");
    return(0);
EXIT_ERROR:
    fprintf(stderr, "*** Program terminated with errors. ***\n");
    return (1);
}

/*******************************************************************************
 ******************************************************************************/ 
int q00ReadFDT( char *fdtname, int max_fdtlines, FDT fdtlines[], int *numrecords)
/*
*# q00ReadFDT   Read several values from the FDT file
**  It is assumed that the FDT contains valid values: This code does not check validity.
**
**  ARGUMENT                I/O     DESCRIPTION
**      fdtname             I       String with filename of the FDT
**      max_fdtlines        I       Maximum number of lines in array of FDT structs
**      fdtlines              O     Array of structs with FDT info
**      numrecords            O     Number lines extracted from the FDT
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    FILE *fpfdt = NULL;
    char *line = NULL;  /* q00GetRecord will allocate the buffer */
    char *rest = NULL;  /* potential extra in token (impossible) */
    char *token= NULL;
    int numrecord = -1;
    int numtoken = 0;
    int filelinenr = 0;
    int valid_line = 0; /* 0=invalid, 1=valid*/
    size_t len = 0;
    ssize_t numread = 0;

    fpfdt = fopen(fdtname, "r");
    if (fpfdt == NULL) {
        fprintf(stderr, "*** Unable to open  file '%s' for \"r\", status: %s\n",
                fdtname, strerror(errno));
        return(1);
    }

    while ( (numread = q00GetRecord(&line, &len, &filelinenr, fpfdt)) >= 0) {
        token = strtok( line,"|");
        numtoken = 1;
        valid_line = 0;
        while ( token != NULL ) {
            if( numtoken == 1 ) {
                if ( strcmp(token,"F")== 0 ) {
                    numrecord++;
                    if ( numrecord >= max_fdtlines ) {
                        fprintf(stderr, "%s FDT has too many lines for internal storage configuration ***\n", INTERNALERR);
                        return 1;
                    }
                    strncpy(fdtlines[numrecord].type,token,1);
                    fdtlines[numrecord].type[1] ='\0';
                    valid_line=1;
                }
                else if (strcmp(token,"H")== 0 || strcmp(token,"OD")== 0 ) {
                    /* Head (H) and Date/time operator creating the record (OD) are ignored */
                }
                else {
                    fprintf(stderr, "*** FDT fieldtype '%s' is unknown to this program. (ignored)\n", token);
                }
            }
            if ( valid_line == 1) {
                if ( numtoken == 2 ) {
                    fdtlines[numrecord].itag=(int)strtol( token, &rest, 10);
                }
                else if ( numtoken == 3 ) {
                    fdtlines[numrecord].title = strdup(token);
                }
                else if ( numtoken == 4 ) {
                    fdtlines[numrecord].iprincipal=(int)strtol( token, &rest, 10);
                }
                else if ( numtoken == 5 ) {
                    fdtlines[numrecord].irepeating=(int)strtol( token, &rest, 10);
                }
            }
            numtoken++;
            token = strtok( NULL, "|");
        }

    }
        /* debug
            for (int i=0; i<=numrecord; i++ ) {
                printf ("FDT info: record(%d)=%s|%d|%s|%d|%d\n", i,\
                    fdtlines[i].type, fdtlines[i].itag, fdtlines[i].title,\
                    fdtlines[i].iprincipal, fdtlines[i].irepeating);
            }
        */
    /* Check correct ending of read loop */
    if (numread == -2) return 1;

    (void)fclose(fpfdt);
    if (line)  free(line);
    *numrecords = numrecord;
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
int q00ProcessCSV( char *csvfile, struct FDT fdtlines[], int numfdtlines, char *isofile)
/*
*# q00ProcessCSV   Process the csv file and write the iso file
**
**  ARGUMENT                I/O     DESCRIPTION
**      csvfile             I       String with filename of the csv file
**      fdtlines            I       Array of structs with FDT info to check the csv info
**      numfdtlines         I       Actual number of lines in array of  structs
**      isofile             I       String with filename of the iso file
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    FILE *fpcsv = NULL;
    FILE *fpiso = NULL;
    char *record = NULL;      /* q00GetRecord will allocate the buffer */
    char *firstline = NULL;   /* a duplicate of the first read record */
    char *token = NULL;
    char *tokens[MAXCSVTOKENS];
    char *tagtokens[MAXCSVTOKENS];
    int tokenrepeating[MAXCSVTOKENS];
    int i = 0;
    int numfilled = 0;
    int numtokens = 0;
    int recordnumber = 0;
    int numtagtokens = 0;
    int numoutputrecords = 0;
    int numoutputlines = 0;
    int filelinenr = 0;
    size_t len = 0;
    ssize_t numread = 0;

    /*
    ** Open the input file
    */
    if ( strcmp(csvfile, IN_REDIR_NAME) != 0 ) {
        fpcsv = fopen(csvfile, "r");
        if (fpcsv == NULL) {
            fprintf(stderr, "*** Unable to open  file '%s' for \"r\", status: %s\n",
                    csvfile, strerror(errno));
            return 1;
        }
    } else {
        fpcsv = stdin;
    } 

    while ( (numread = q00GetRecord(&record, &len, &filelinenr, fpcsv)) >=0 ) {
       recordnumber++;
       if ( recordnumber == 1 ) {
            /*
            ** Duplicate the first record as it will serve for all following data records
            */
            fprintf(stderr, "Check first line of %s for correct tags ...\n", csvfile);
            firstline = strdup( record );
            /*
            ** Remove a possible BOM from the first token (UTF-8 BOM is printed as ï»¿)
            ** The UTF-8 representation of the BOM is the (hex) byte sequence 0xEF,0xBB,0xBF
            */
            if ( *firstline == '\xef' && *(firstline+1) == '\xbb' && *(firstline+2) == '\xbf') {
                fprintf(stderr, "UTF-8 byte order mark detected at filestart. Hex value=%X%X%X\n",
                                (unsigned char)firstline[0],(unsigned char)firstline[1],(unsigned char)firstline[2]);
                fprintf(stderr, "*** UTF-8 not (yet) supported (results in garbled text in ABCD)\n");
                firstline = firstline + 3; /* this way we could proceed if we know what to do */
                return 1;
            }

            /*
            ** Check & Detect the separator. Detect in case 'autodetect' is set
            ** Tokenize the first line
            */
            if ( q00DetectSeparator( firstline, recordnumber ) !=0 ) return 1;
            if ( q00TokenizeCSV( firstline, recordnumber, MAXCSVTOKENS, tagtokens, &numtagtokens ) !=0 ) return 1;

            /*
            ** Check the tokens with the FDT and determine the repeating tokens
            */
            if ( q00CheckFDTwithCSV( fdtlines, numfdtlines, tagtokens, numtagtokens) !=0 ) return 1;
            if ( q00CheckActRepToks( fdtlines, numfdtlines, tagtokens, numtagtokens, tokenrepeating) !=0 ) return 1;
            fprintf(stderr, "Check first line of %s for correct tags: OK\n" , csvfile);
            
        } else if ( numread > 0) {
            /*
            ** This is a non-empty dataline
            ** Replace unwanted characters if necessary
            */
            if ( q00ReplaceChars( record, recordnumber ) == 1 ) return 1;

            /*
            ** Tokenize this csv record
            */
            if ( q00TokenizeCSV( record, recordnumber, MAXCSVTOKENS, tokens, &numtokens ) !=0 ) return 1;
            /*
            ** Check that the record has at least one token with some content
            */
            numfilled = 0;
            for ( i=0; i<numtokens; i++ ) {
                token = tokens[i];
                if ( ! isStrNull(token) ) numfilled++;
            }
            if ( numfilled > 0 ) {
                /* debug
                for (int i=0; i<numtagtokens; i++) fprintf(stderr, "token %2d=%s, repeating=%1d\n",i,tagtokens[i],tokenrepeating[i]) ;
                for (int i=0; i<numtokens; i++) fprintf(stderr, "token %2d=%s=\n",i,tokens[i]);
                */
                /*
                ** Check that it has the same number of tokens as the firstline
				** Excel xls and xlsx files convert slightly different to csv.
				** We assume that the first line determines the correct number of tokens, and check
				** only that next lines do not have more tokens.
				** Less tokens is considered OK (and we accept that handwritten csv's may have shifted columns).
                */
                if ( numtokens > numtagtokens ) {
                    fprintf(stderr, "*** Record %d has %d tokens, while line 1 has %d tokens. These numbers must be equal.\n",\
                            recordnumber, numtokens, numtagtokens);
                    return 1;
                }
                if ( q00WriteToISOFile( isofile, &fpiso,
                                        tagtokens, tokenrepeating, tokens, numtokens,
                                        &numoutputrecords, &numoutputlines) !=0 ) return 1;
            } else {
                fprintf(stderr,"- Skipped record %d (only empty tokens}\n", recordnumber);
            }
         } else {
            fprintf(stderr,"- Skipped record %d (empty)\n", recordnumber);
        }
    }
    /* Check correct ending of read loop */
    if (numread == -2) return 1;
    /* Close files. Dont care about errors (includes redirection)*/
    (void)fclose(fpcsv);
    if ( fpiso!=NULL) {
        (void)fclose(fpiso);
    }
    fprintf(stderr, "Processed %d records with %d lines from CSV file '%s'\n", recordnumber, filelinenr, csvfile);
    fprintf(stderr, "Written %d records in %d lines to ISO file '%s'\n", numoutputrecords, numoutputlines, isofile);
    if (record)  free(record);
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
int q00DetectSeparator( char *record, int recordnumber )
/*
*# q00DetectSeparator   Detect the separator in the csv file.
**  If global variable CSVDELIMITER is set to 'autodetect' this module will determine a
**  reasonable delimiter character from the set given by global variable CSVDELIMITERSET
**  Global CSVDELIMITER will be set if this character is found
**  Global CSVDELIMITER is not touched if not set to 'autodetect'
**
**  ARGUMENT                I/O     DESCRIPTION
**      record                I     Record from the csvfile.
**      recordnumber          I     Recordnumber of the csvfile.
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    char *tokens[MAXCSVTOKENS];
    char *tstrecord = NULL;
    char *bestdelimiter = NULL;
    int numtokens = 0;
    int bestnum = 0;
    int i = 0;

    /* Check if there is anything to process */
    if ( isStrNull(record) ) {
        fprintf(stderr, "*** Cannot check/detect a separator in an empty record\n");
        return 1;
    }
    /* Check if we have autodetection */
    if ( strcmp(CSVDELIMITER, "autodetect") == 0 ) {
        /* create changeable string for CSVDELIMITER (originally static). Too long, but don't care */
        CSVDELIMITER = strdup(CSVDELIMITERSET); 
        for ( i=0; i<(int)strlen(CSVDELIMITERSET); i++ ) {
            tstrecord = strdup(record);
            strncpy ( CSVDELIMITER, &CSVDELIMITERSET[i], 1 ) ; 
            CSVDELIMITER[1] = '\0';
            if ( q00TokenizeCSV( tstrecord, recordnumber, MAXCSVTOKENS, tokens, &numtokens ) !=0 ) return 1;
            if ( numtokens > bestnum ) {
                bestnum = numtokens;
                free(bestdelimiter);
                bestdelimiter = strdup(CSVDELIMITER);
            }
            free(tstrecord);
        }
        if ( bestnum < 2 ) {
            fprintf(stderr, "*** Only %d token(s) detected, while using best separator \'%s\' (out of %s).\n",
                            bestnum, bestdelimiter,CSVDELIMITERSET);
            fprintf(stderr, "*** Record= %s\n",record);
            fprintf(stderr, "*** Is this the correct file?\n");
            return 1;
        }
        else {
            CSVDELIMITER = strdup(bestdelimiter);
            free(bestdelimiter);
            fprintf(stderr, "- Best results in delimiter detection gives \'%s\' (%d tokens).\n", CSVDELIMITER, bestnum);
        }
    }
    else {
        if ( ispunct((char)CSVDELIMITER[0]) == 0 ) {
            fprintf(stderr, "*** Character \'%s\' cannot be used as separator for a csv file. \n",CSVDELIMITER);
            return 1;
        }
        tstrecord = strdup(record);
        if ( q00TokenizeCSV( tstrecord, recordnumber, MAXCSVTOKENS, tokens, &numtokens ) !=0 ) return 1;
        if ( numtokens <= 2) {
            fprintf(stderr, "*** Only %d token(s) detected in record, while using separator \'%s\'. \n",numtokens, CSVDELIMITER);
            fprintf(stderr, "*** Record= %s\n",record);
            fprintf(stderr, "*** Might be wrong separator (see -c option, consider default 'autodetect')\n");
            return 1;
        }
        free(tstrecord);
    }
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
int q00TokenizeCSV( char *record, int recordnumber, int maxtokens, char *tokens[], int *numtokens )
/*
*# q00TokenizeCSV   Separate a csv record into tokens.
**  Excel separates with comma's, and in case the value contains a comma the values is enclosed by quotes.
**  Example:    token1,token2,"token with ,",token with spaces,"",
**  Note: The record may contain embedded linefeeds (not processed here)
**  The inputrecord may contain a trailing separator: will be removed.
**
**  ARGUMENT                I/O     DESCRIPTION
**      record              I       record from the csvfile. Modified: zeros at token endings 
**      recordnumber        I       recordnumber of the csv file.
**      maxtokens           I       Size of array tokens
**      tokens                O     Array elements point to tokens in the csvrecord
**      numtokens             O     Number of found tokens (== elements with a value in array tokens)
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    int state = 0;          /* 0=init, 1=normal token, 2=token with quotes */
    int recordlength = 0;
    int i = 0;              /* pointer in input record */
    int tokenindex = -1;    /* initial value if nothing found */
    char testc;
    char testc2;
    
    /* Detect record size once because the code inserts zeros at token ends */
    recordlength = (int)strlen(record);
    
    /* Loop over the string to detect tokens */
    for ( i=0; i < recordlength; i++ ) {
        testc = record[i];
        if ( testc == '\0') {
            /* The loop variable i can address NULLs in case of memmoves */
            /* Tests for unclosed tokens :TBD */
        } else if ( state == 0 ) {
            /* No active token */
            if ( testc == CSVDELIMITER[0]) {
                /* empty token */
                record[i] ='\0';
                tokenindex++;
                tokens[tokenindex]=&record[i];
            } else if ( testc == CSVSTRINGIND ) {
                /* token with quotes, start new target token beyond the quote */
                tokenindex++;
                tokens[tokenindex]=&record[i+1];
                state = 2;
            } else {
                /* begin of new target token */
                tokenindex++;
                tokens[tokenindex]=&record[i];
                state = 1;
            }
        } else if ( state == 1 ) {
            /* normal token active */
            if ( testc == CSVDELIMITER[0] ) {
                /* end of token,  terminate target token */
                record[i] ='\0';
                state = 0;
            }
        } else if ( state == 2 ) {
            /* quoted token is active */
            if (  testc == CSVSTRINGIND ) {
                /* action depends on next character*/
                testc2 = record[i+1];
                if ( testc2 == CSVSTRINGIND ) {
                    /* 
                    ** If quote followed by quote: Means a single quote
                    ** Action: shift tail 1 position left and add terminator at end
                    ** Note that the loop needs no adjustment
                    */
                    memmove((void*)&record[i+1],(void*)&record[i+2], strlen(&record[i+2]));
                    record[i + strlen(&record[i+1]) ] = '\0';
                }
                else if ( testc2 == CSVDELIMITER[0] || testc2 == '\0' ) {
                    /* 
                    ** If quote followed by comma or end of the string: Means end of token
                    ** Action: terminate target token and skip the comma
                    */
                    record[i] = '\0';
                    i++;
                    state = 0;
                }
            }
        } /* end of statemachine if */
        if ( tokenindex > maxtokens ) {
            fprintf(stderr, "%s Record %d contains %d tokens: too many tokens (max=%d)\n",
                            INTERNALERR,recordnumber,tokenindex,maxtokens);
            return 1;
        }
    } /* end of loop over input record */
    *numtokens = tokenindex+1;
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
int  q00CheckFDTwithCSV( struct FDT fdtlines[], int numfdtlines, char *tokens[], int numtokens)
/*
*# q00CheckFDTwithCSV   Check that csv tokens are valid and present in the FDT.
**  The token must be 3 positions
**  The token must consist of 3 digits.
**  The token must be present in the fdt.
**
**  ARGUMENT                I/O     DESCRIPTION
**      fdtlines            I       Array of structs with FDT info to check the csv info
**      numfdtlines         I       Actual number of lines in array of  structs
**      tokens              I       Array elements pointing to tokens of the firstline
**      numtokens           I       Number of tokens in the token array
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    int ltoken      = 0;
    int ierr        = 0;
    int digerr      = 0;
    int tagfound    = 0;
    int csvtag      = 0;
    int i           = 0;
    int j           = 0;
    char *token     = NULL;

    /*
    ** For each token: if it is a title in the FDT: replace by the tagnumber
    ** Only if the token length can accommodate a tag of 3 positions
    ** This is a convenience function.
    ** If no substitution: error checks will be done by rest of the code
    */
    for ( i=0; i<numtokens; i++ ) {
        token=tokens[i];
        for ( j=0; j<=numfdtlines; j++ ) {
            if ( strcmp(token,fdtlines[j].title) == 0 && (int)strlen(token) >= 3 ) {
                fprintf(stderr, "- Column %d: value '%s' (= title in FDT) replaced by tag '%3d'\n", \
                        i+1, fdtlines[j].title, fdtlines[j].itag);
                /* sprintf adds a trailing \0, so this is safe code */
                sprintf( token,"%3d",fdtlines[j].itag);
            }
        }
    }
    /*
    ** For each token: check that the token is 3 positions
    */
    for ( i=0; i<numtokens; i++ ) {
        ltoken = (int)strlen( tokens[i]);
        if (  ltoken !=3 ) {
            fprintf(stderr, "*** Column %d of line 1 with value '%s' has %d positions. (Tags must be 3)\n",
                    i+1, tokens[i], ltoken);
            ierr++;
        }
    }
    /*
    ** For each token: check that the tokens consists of digits only
    */
    for ( i=0; i<numtokens; i++ ) {
        token=tokens[i];
        digerr = 0;
        for ( j=0; j<3; j++ ) {
            if ( ! isdigit(token[j]) ){
                digerr++;
            }
        }
        if ( digerr > 0 ) {
            fprintf(stderr, "*** Column %d of line 1 with value '%s' contains non-digits\n", i+1, tokens[i]);
            ierr++;
        }
    }
    /*
    ** For each token: check that it exists in the FDT (as tag)
    */
    for ( i=0; i<numtokens; i++ ) {
        token=tokens[i];
        tagfound = 0;
        csvtag = (int)strtol( token, (char **)NULL, 10);
        for ( j=0; j<=numfdtlines; j++ ) {
            if ( fdtlines[j].itag == csvtag) tagfound = 1;
        }
        if ( tagfound == 0 ) {
            fprintf(stderr, "*** Tagvalue '%s' in column %d of line 1 is NOT present in de FDT\n",tokens[i], i+1 );
            ierr++;
        }
    }
    if ( ierr > 0 ) return 1;
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
int  q00CheckActRepToks( struct FDT fdtlines[], int numfdtlines, char *tokens[], int numtokens, int reptoks[])
/*
*# q00CheckActRepToks   Detect which tokens in the csv are defined as Repeating in the FDT.
**  Check that non-repeating tokens appear only once
**
**  ARGUMENT                I/O     DESCRIPTION
**      fdtlines            I       Array of structs with FDT info to check the csv info
**      numfdtlines         I       Actual number of lines in array of  structs
**      tokens              I       Array elements pointing to tokens of the firstline
**      numtokens           I       Number of tokens in the token array
**      reptoks               O     Value = 0: standard tag. Value = 1: Repeating tag
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    char *token = NULL;
    int csvtag = 0;
    int ierr = 0;
    int i = 0;
    int j = 0;

    /*
    ** Determine the repeating tokens and administrate this in array reptoks
    */
    for ( i=0; i < numtokens; i++ ) {
        reptoks[i] = 0; /* default non-repeating */
        token=tokens[i]; 
        csvtag = (int)strtol( token, (char **)NULL, 10);
        for ( j=0; j<=numfdtlines; j++ ) {
            if ( fdtlines[j].itag == csvtag) reptoks[i] = fdtlines[j].irepeating;
        }
    }
    
    /*
    ** Check that non-repeating tokens appear only once
    */
    for ( i=0; i < numtokens; i++ ) {
        if ( reptoks[i] == 0) {
            for ( j=i+1; j < numtokens; j++ ) {
                if (strcmp( tokens[i], tokens[j] ) == 0 ) {
                    fprintf(stderr, "*** Column %d and %d of line 1 contain duplicate non-repeating tag '%s'\n", i+1,j+1, tokens[i]);
                    ierr++;
                }                   
            }
        }
    }
    if ( ierr > 0 ) return 1;
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
static int q00WriteToISOFile( char *isofile, FILE **fpiso,
                              char *tagtokens[], int reptoks[], char *tokens[], int numtokens,
                              int *numoutputrecords, int *numoutputlines)
/*
*# q00WriteToISOFile   Write a csvline to the ISO file
**
**  ARGUMENT                I/O     DESCRIPTION
**      isofile             I       name of the iso file
**      fpiso               I/O     Filepointer to the iso file. Opened by this procedure
**      tagtokens           I       Array elements pointing to tokens of the firstline
**      reptoks             I       Array with 'repeat' information  of tagtokens. 0: standard tag. 1: Repeating tag
**      tokens              I       Array elements pointing to tokens of the csv line
**      numtokens           I       Number of tokens in the all 3 arrays
**      numoutputrecords    I/O     Number of written output records.
**      numoutputlines      I/O     Number of written output lines.
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    char isorecord[MAXISORECLEN];
    int i=0;
    int isoreclen = 0;
    /*
    ** Open the outputfile if not done yet
    ** If the outputfile is a real file: open it.
    ** If the outputfile is redirected: set the filepointer
    */
    if ( *fpiso == NULL ) {
        if ( strcmp(isofile, OUT_REDIR_NAME) != 0 ) {
            *fpiso = fopen(isofile, "w");
            if (*fpiso == NULL) {
                fprintf(stderr, "*** Unable to open  file '%s' for \"w\", status: %s\n",
                        isofile, strerror(errno));
                return 1;
            }
        } else {
            *fpiso = stdout;
        } 
        fprintf(stderr, "Writing records to ISO file '%s'\n", isofile);
    }
    /*
    ** Create the ISO record
    */
    if ( q00CreateISORecord( tagtokens, reptoks, tokens, numtokens, isorecord) !=0 ) return 1;
    /*
    ** Export to the iso file
    */
    if ( CMDOPT8 <= 0 ) {
        /* Write record as single line */
        fprintf( *fpiso,"%s\n", isorecord);
        ++*numoutputlines;
    } else {
        /* Write record in lines of 80 characters */
        isoreclen = (int)strlen(isorecord);
        for ( i=0; i < isoreclen; i++ )
        {
            fprintf (*fpiso,"%c", isorecord[i]);
            if ( ((i+1) % 80) == 0 ) {
                fprintf (*fpiso,"\n");
                ++*numoutputlines;
            }
        }
        /* write trailing newline if not yet done in the loop */
        if ( (isoreclen % 80 ) != 0) {
            fprintf (*fpiso,"\n");
            ++*numoutputlines;
        }
    }
    ++*numoutputrecords;
    return 0;
}


/*******************************************************************************
 ******************************************************************************/ 
int  q00CreateISORecord( char *tagtokens[], int reptoks[], char *tokens[], int numtokens, char *isorecord)
/*
*# q00CreateISORecord   Create an iso record from one csvrecord
**
**  ARGUMENT                I/O     DESCRIPTION
**      tagtokens           I       Array elements pointing to tokens of the firstline
**      reptoks             I       Array with 'repeat' information  of tagtokens. 0: standard tag. 1: Repeating tag
**      tokens              I       Array elements pointing to tokens of the csv record
**      numtokens           I       Number of tokens in the all 3 arrays
**      isorecord             O     String with a single ISO record, null terminated.
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    int recordlength = 0;
    int baseaddress = 0;
    int toklen = 0;
    int i = 0;
    int startpos = 0;
    int numacttokens = 0;
    char delimstring[3];        /* space for 2 delimiters + traling 0 */
    char *token = NULL;
    char *subtoken = NULL;
    char *tag = NULL;
    char dir[MAXCSVTOKENS][13]; /* computed directory entries, size = numtokens + possible repeats */
    char *data[MAXCSVTOKENS];   /* each pointer points to an element in the csv record */

    delimstring[0] = '\n';
    delimstring[1] = REPDELIMITER[0];
    delimstring[2] = '\0';

    /*
    ** Compute the directory entries
    */
    for ( i=0; i < numtokens; i++ ) {
        token = tokens[i];
        if ( (int)strlen(token) > 0 ) {
            tag = tagtokens[i];
            /* Write directory entry (for every token 12 positions)
            ** entry = "tttllllsssss
            **          | ||  |sssss    :starting character position (Size=S, see head definition)
            **          | |llll         :total number of octets in the field (inc fieldsep),(Size=F, see head definition)
            **          ttt             :tag
            */
            if ( reptoks[i] == 0 ) {
                /* 
                ** Non-repeating token: no need to process the token
                */
                toklen = (int)strlen(token) + 1; /* including the fieldsep */
                sprintf( dir[numacttokens],"%s%04d%05d",tag,toklen,startpos);
                data[numacttokens] = tokens[i];
                
                startpos = startpos + toklen;
                numacttokens++;
                if ( numacttokens >= MAXCSVTOKENS ) {
                    fprintf(stderr, "%s q00CreateISORecord: Too many tokens  (>%d) for internal storage configuration ***\n",\
                            INTERNALERR,numacttokens);
                    return 1;
                }
            }
            else {
                /*
                ** Repeating token: one token may contain subtokens
                ** Split the token by the separator and create
                ** a directory entry for each subtoken with real data.
                */
                subtoken = strtok( token,delimstring);
                while ( subtoken != NULL ) {
                    /* Set subtoken pointer beyond leading spaces */
                    while( isspace((unsigned char)*subtoken) ) subtoken++;

                    /* write the subtoken if stil any data left */
                    if ( strlen(subtoken) > 0 ) {
                        toklen = (int)strlen(subtoken) + 1; /* including the fieldsep */
                        sprintf( dir[numacttokens],"%s%04d%05d",tag,toklen,startpos);
                        data[numacttokens] = subtoken; /* = beyond leading spaces */
                        
                        startpos = startpos + toklen;
                        numacttokens++;
                        if ( numacttokens >= MAXCSVTOKENS ) {
                            fprintf(stderr, "%s q00CreateISORecord: Too many tokens  (>%d) for internal storage configuration ***\n",\
                                    INTERNALERR,numacttokens);
                            return 1;
                        }
                    }
                    subtoken = strtok( NULL, delimstring);
                }
            }
        }
    }       

    /*
    ** Put heading information to the beginning of the iso record
    ** head = "rrrrr0000000ddddd0004500";
    **         012345678901234567890123
    **         |   |||  ||||   || ||||X :for future use(=0)
    **         |   |||  ||||   || |||Y  :length of implementation defined part(=0)
    **         |   |||  ||||   || ||S   :length of starting character position in each entry (=5)
    **         |   |||  ||||   || |F    :length of 'length of field' (=4)
    **         |   |||  ||||   |UUU :for user systems (=000)
    **         |   |||  |||ddddd    :base address of data
    **         |   |||  ||L     :identifier length (=0)
    **         |   |||  |L      :indicator length (=0)
    **         |   ||IIII       :implementation codes (=0000)
    **         |   |S           :status (=0)
    **         rrrrr            :record length
    */
    recordlength = 24 + numacttokens*(12) + startpos + 2;
    baseaddress = 24 + numacttokens*12 + 1;
    sprintf( isorecord, "%05d0000000%05d0004500",recordlength,baseaddress);
    if ( recordlength+1 >= MAXISORECLEN ) {
        fprintf(stderr, "%s q00CreateISORecord: Computed recordlength (%d) too large for buffer (%d) ***\n",\
                INTERNALERR,recordlength,MAXISORECLEN);
        return 1;
    }

    /* 
    ** Add directory information to the iso record, without separator.
    ** The directories are stored in the dir array
    ** The information is terminated by a #
    */
    for ( i=0; i < numacttokens; i++ ) {
        strcat ( isorecord, dir[i]);
    }
    strcat( isorecord, ISODELIMITER);

    /*
    ** Add data to the iso record, separated by #
    ** Pointers to the data elements are present in the data array
    */
    for ( i=0; i < numacttokens; i++ ) {
        /* debug
            fprintf(stderr, "data %d (%.3s)= %s\n",i, dir[i],data[i]);
        */
        strcat( isorecord, data[i]);
        strcat( isorecord, ISODELIMITER);
    }

    /* Add trailing record separator */
    strcat( isorecord, ISODELIMITER);
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
void q00Help( int helptype ) 
/*
*# q00Help   Prints help information.
**
**  ARGUMENT                I/O     DESCRIPTION
**      helptype            I       indicator of required help (0=short help, 1=version,2=excel format, other=usage)
**      
**  Returns:    Nothing
*/ 
{
    if ( helptype == 0 ) {
        fprintf(stderr, "*** Run this program with option -h or -H to show usage information *** \n");
    }
    else if ( helptype == 1 ) {
        fprintf(stderr, "Version %s, compiled on %s, %s\n", VERSION, __DATE__,__TIME__);
    }
    else if ( helptype == 2 ) {
        fprintf(stderr, "\
The csv file for this converter has following structure:\n\
    The format of each record is the csv format:\n\
        - Each column in the excel is transformed into a token\n\
        - A token may be enclosed by quotes (\"abcd\").\n\
        - Tokens are separated by a comma or other separator (see excel documentation)\n\
        - The trailing separator is optional\n\
        Examples:\n\
                token1,\"to ken 2\",token3,\"\",\n\
                token1,\"to ken 2\",token3,\"\"\n\n\
    The first line contains information about the target tag\n\
        - ABCD 'Tag's are numbers consisting of 3 digits (e.g. 100, 110,150,...).\n\
        - ABCD 'Titles' correspond normally 1:1 with the tags: 'Copyright'-> 180.\n\
        - Titles are allowed and will be translated by this program into the correct tag.\n\
        Example: \n\
                100,Copyright,120  ->  100,180,120\n\
        - The sequence of the tags is free: may be different from the target ABCD.\n\
        - Duplicate tags are allowed if the tag is a 'repeating' tag.\n\n\
    Each next record contains the data of a single ABCD record\n\
        - All records must have the same number of tokens as the first line (=standard excel export).\n\
        - Empty tokens are allowed (\"\").\n\
        - In tokens of repeating tags it is possible to enter 'repeats'.\n\
        - These repeats are separated by a semicolon or an other separator.\n\
        - These repeats can also be separated by a new line (alt-enter in Excel).\n\
       Examples:\n\
                \"single token\",\"Amsterdam;Rotterdam\",singleword,,\n\
                \"single token\",\"Amsterdam;;Rotterdam; Den Haag\",singleword,\"\", \n\n\
Excel specific notes on \"Save As\" -> \"CSV (delimited by..)\" :\n\
        - The separator is set in Control panel -> Region -> Advanced -> Set list separator.\n\
        - If the decimal symbol is a comma, the list separator will be a semicolon even if set otherwise!\n\
        - Saving in UTF-8 is NOT recommended\n\n\
Option -h will show how to run this program\n\
");
    }
    else {
        fprintf(stderr, "\
Function: This program converts a CSV file into an ISO-2709 file.\n\
          Intended for uploading Excel data into the ABCD database.\n\
Commandline options:\n\
          -i <csv-file>  [-d <fdt-file>] [-o <iso-file>]\n\
         [-c <csv-separator>] [-r <repeat-separator>]\n\
         [-8] [-S] [-v] [-h] [-H]\n\
  options:\n\
   -i - Path to csv inputfile to be converted to ISO-2709\n\
   -d - Path to FDT file (Field Definition Table) (e.g. snrbld.fdt)\n\
   -o - Path to iso outputfile. Default is <csv-file>.iso.\n\
   -c - Separator in the csv file. Default is '%s'.\n\
   -r - Separator for repeating fields in one csv element. Default is '%s'.\n\
   -8 - Split isorecord into lines of 80 characters. Default is no split\n\
   -S - Detect or replace HTML < and >. Default is 'detect'.\n\
   -v - version information\n\
   -h - usage/function information (this message)\n\
   -H - Info about csv file structure\n\
Environment influence:\n\
   Environment variable '%s' is the fallback for option -d <fdt-file>\n\
   Environment variable '%s' is the fallback for option -8 (values 0,n/1,y)\n\
   Environment variable '%s' is the fallback for option -S (values 0,n/1,y)\n\
   Redirected Standard input  is the fallback for option -i <csv-file>\n\
   Redirected Standard output is the fallback for option -o <iso-file>\n\
Examples: ./cnv_csv_to_iso -i myscans.csv\n\
          ./cnv_csv_to_iso  < myscans.csv -o myupload.iso\n\
          ./cnv_csv_to_iso  < myscans.csv  > myupload.iso\n\
          ./cnv_csv_to_iso -i myscans.csv -d odrfot.fdt\n\
          ./cnv_csv_to_iso -i myscans.csv -d odrfot.fdt -o myupload.iso -c ';' -8 -S\n\
",CSVDELIMITER,REPDELIMITER,ENV_FDT_FILE, CNVXLS_OPT_8, CNVXLS_OPT_S); 
    }
    
return;
}

/*******************************************************************************
 ******************************************************************************/ 
int q00ReplaceChars( char *record, int recordnumber )
/*
*# q00ReplaceChars   Check and/or replace undesired characters
**
**  ARGUMENT                I/O     DESCRIPTION
**      record              I/O     Record from the csvfile.
**      recordnumber        I       Recordnumber of the csvfile.
**  Returns:    0 (OK), 1 (NOK)
*/ 
{
    int i =0;
    int numlt = 0;
    int numgt = 0;
    char testc;
    
    /* Loop over the string to detect the bloody characters */
    for ( i=0; i < (int)strlen(record); i++ ) {
        testc = record[i];
        if ( testc == '<' ) {
            numlt++;
            if ( CMDOPTS > 0 ) {
                record[i] = '«';
            }
        } else if ( testc == '>' ) {
            numgt++;
            if ( CMDOPTS > 0 ) {
                record[i] = '»';
            }
        }
    }
    if ( numlt > 0 || numgt > 0 ) {
        if ( CMDOPTS <= 0 ) {
            fprintf( stderr, "- Record %d: Detected %d < signs, and %d > signs.\n", recordnumber,numlt,numgt);
        } else {
            fprintf( stderr, "- Record %d: Replaced %d < signs, and %d > signs.\n", recordnumber,numlt,numgt);
        }
    }       
            
    return 0;
}

/*******************************************************************************
 ******************************************************************************/ 
ssize_t q00GetRecord(char **buf, size_t *bufsiz, int *filelinenr, FILE *fp)
/*
*# q00GetRecord   Get a record from a stream
**  Standard gcc distributions have the non-standard/non-posix function 'getline'.
**  Note: This code is inspired by the NetBSD code and NOT an exact copy.
**  Functional Modifications:
**      Does NOT return the line terminators,
**      Accepts LF, CRLF and CR as terminators
**      Interpretes strings enclosed by double quotes
**      Improved error handling
**
**  In Linux we have LF   (inside "" returned as LF)
**  In DOS we have CRLF   (inside "" returned as LF)
**  In MAC we have CR     (inside "" returned as LF)
**  
**
**  ARGUMENT                I/O     DESCRIPTION
**      buf                 I/O     Record read, possibly reallocated
**      bufsiz              I/O     Size of give/reallocated buffer.
**      fp                  I       Filepointer
**  Returns:    >=0         The number of characters read, without terminating null byte
**              -1          End of file
**              -2          Other error (prints error)(e.g. io error/memory error/...)
*/
{
    static char *ptr;
    char *eptr;
    int delimiterLF = (int)'\n';
    int delimiterCR = (int)'\r';
    int delimiterDQ = (int)'"';
    int CRread      = 0;          /* 0=No unprocessed CR, 1=CR read, to be processed */
    int state       = 0;          /* 0=outside quotes, 1=inside quotes */

    if (*buf == NULL || *bufsiz == 0) {
        *bufsiz = BUFSIZ; /* BUFSIZ defined in stdio.h typical 1024/512 */
        if ((*buf = malloc(*bufsiz)) == NULL) {
            fprintf( stderr, "*** Unable to allocate memory (size=%d) during read operation\n", (int)*bufsiz);
            return -2;
        }
    }
    /* Loop over characters in the file */
    for (ptr = *buf, eptr = *buf + *bufsiz;;) {
        int c = fgetc(fp);
        if (c == EOF) {
            /*
            ** End of file and any other error
            ** End of file is accordingly to Unix convention only at line-end, but...
            ** manually edited files my end without \n: add safety trailing \0
            */
            *ptr = '\0';
            /* Test that the embedded strings are correctly terminated */
            if ( state != 0 ) {
                fprintf(stderr, "*** Read error: End of file inside an embedded string\n");
                fprintf(stderr, "*** Check for unmatched double quotes in last record\n");
                return -2;
            }
            if ( feof(fp) != 0) {
                /* end of file:return rest of string if any.
                ** Next call will return -1 characters
                ** This is a regular end of this function
                */
                if (ptr != *buf) (*filelinenr)++;
                return (ptr == *buf) ? ((ssize_t)-1) : (ssize_t)(ptr - *buf);
            } else {
                /* Any other error */
                fprintf(stderr, "*** Unexpected read error: %s\n",strerror(errno));
                return -2;
            }
        } else if (c == delimiterCR ) {
            /* A CR may be a delimiter.
            ** Next character gives solution
            */
            CRread = 1; /* remember this in case LF follows */
        } else if (c == delimiterLF) {
            /* A normal LF ends the record. 
            ** An embedded LF goes into the buffer
            */
            (*filelinenr)++;
            if ( state == 0 ) {
                /* outside string: set 0 in buffer and return */
                *ptr = '\0';
                return (ssize_t)(ptr - *buf);
            } else {
                /* inside string: set LF in buffer */
                *ptr = delimiterLF;
                ptr++;
                *ptr='\0';  /* to enable debug printing */
                CRread = 0;
            }
        } else {
            /* Any character except CR or LF
            ** If the previous was a CR:
            **    Process the CR now it is known that no LF followed it.
            ** If the character is double quote: toggle inside/outside
            ** Add character to the buffer
            */
            if ( CRread == 1 ) {
            (*filelinenr)++;
               if ( state == 0 ) {
                    /* outside string: Push current character back and return read line */
                    /*fprintf(stderr,"2c=%d,crread=%d,filepointer=%lx\n",c,CRread,ftell(fp));*/
                    if ( ungetc( c, fp ) < 0 ) {
                        fprintf(stderr,"*** Ungetc error status %s\n",strerror(errno));
                        return -1;
                    }
                    *ptr = '\0';
                    ptr++;
                    return (ssize_t)(ptr - *buf);
                } else {
                    /* inside string: set LF in buffer */
                    *ptr = delimiterLF;
                    ptr++;
                }
            }
            /* toggle the state for a delimiter */
            if ( c == delimiterDQ ) {
                if ( state == 0 ) state=1; else state=0;
            }
            /* add to buffer */
            CRread = 0;
            *ptr = (char)c;
            ptr++;
            *ptr='\0';  /* to enable debug printing */
        }

        /* Reallocate the buffer if not enough space left */
        if (ptr + 3 >= eptr) {
            char *nbuf;
            size_t nbufsiz = *bufsiz * 2;
            ssize_t d = (ssize_t)(ptr - *buf);
            if ((nbuf = realloc(*buf, nbufsiz)) == NULL) {
                fprintf( stderr, "*** Unable to reallocate memory (size=%d) during read operation\n", (int)*bufsiz);
                return -2;
            }
            *buf = nbuf;
            *bufsiz = nbufsiz;
            eptr = nbuf + nbufsiz;
            ptr = nbuf + d;
        }
    }
}
/********************* end of file ***********/