/*********************************************************************
 * FILE isofile_match_with_fdt.c
 *      This file contains c-code to match an iso-2709 file with an FDT.
 *      Database fields are described by the Field Definition Table (.fdt file)
 *      This program reads an iso-2709 file and writes a new file containing only fields that exist in the FDT.
 *
 *      It is possible to specify no conversion. In this case the file is only retwritten.
 *      The functionalty includes several options to format the resulting file. This is
 *      usefull to match the format for ISIS utilities (eg fixed linelength,...)
 *
 *      Compile this program for linux or windows with cygwin (bash) with the gcc compiler:
 *              gcc -o isofile_match_with_fdt isofile_match_with_fdt.c
 *              This program will produce files with LF
 *      Compiling this program for windows command line (CMD) usage:
 *          By cygwin. Creates a staticly linked executable, produce files with CRLF:
 *              i686-w64-mingw32-gcc -o isofile_match_with_fdt.exe isofile_match_with_fdt.c
 *          By MinGW. Creates a staticly linked executable, produce files with CRLF:
 *              gcc -o isofile_match_with_fdt.exe isofile_match_with_fdt.c
 *      Check source on windows with cygwin.
 *              splint isofile_match_with_fdt.c -unrecog  -nullpass -compdef -bufferoverflowhigh ...
 *              Gives several warnings. None serious at first inspection.
 *
 * AUTHOR   Fred Hommersom
 * HISTORY:
 *      2021-07-02:(fho) Initial version
 *_____________________________________________________________________
 * Call tree    : main
 *              :   processFile
 *              :       readLabel
 *              :       printLabel
 *              :       readDirectoryEntry
 *              :       readTerminator
 *              :       readField
 *              :       convertRecord
 *              :       writeRecord
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

#define VERSION "1.0"
#define isStrNull(str) (str==NULL || (int)strlen(str) == 0)

#ifdef __linux__ 
    #define LINEEND "\n"
#else
    #define LINEEND "\r\n"
#endif

typedef struct LABEL {  /* Struct with values of the record label. All 24 octets */
    int           iRecLength;    /* Record length (octet 0-4). Includes record terminator*/
    unsigned char *cRecStatus;   /* Record status (octet 5). Copied */
    unsigned char *cImpcodes;    /* Implementation codes (octet 6-9). Copied  */
    int           iIndicatorL;   /* Indicator length (octet 10)*/
    int           iIdentifierL;  /* Identifier length (octet 11*)*/
    int           iBaseData;     /* Base address of data (octet 12-16) */
    unsigned char *cUserSystem;  /* Positions defined by user systems (octet 17-19) */
    int           iDirMapFieldL; /* Length of field part of each entry in the directory (octet 20) */
    int           iDirMapStart;  /* Starting character position part of each entry in the directory (octet 21) */
    int           iDirMapImplL;  /* Length of the implementation-defined part of each entry in the directory (octet 22) */
    unsigned char *cReserved;    /* Reserved for future use (octet 23) */
    int           dirEntryLength;/* Computed value after reading the label */
} LABEL;

typedef struct DE {     /* Struct with value of Directory Entry and Fieldvalue*/
    unsigned char *cTag;         /* Tag of the DE. octet 0-2 */
    int           iDirFieldL;    /* Length of field. octets depend on iDirMapFieldL*/
    int           iDirStartPos;  /* Starting character position of field. 5 octets */
    unsigned char *cImplDefined; /* Implementation defined. Octets depend on iDirMapImplL*/
    unsigned char *cField;       /* Data field value of this entry*/
    int           iInValid;      /* indicator if this entry is valid to write out */
} DE;

typedef struct FDT {     /* Struct with value of FDT fields*/
    unsigned char *cTag;         /* Tag of the FDT line.Field 1 (field 0 is type letter)*/
    unsigned char *cDescription; /* Description of the FDT line.Field 2 */
    int           iRepetitive;   /* Indicator if Tag is repetitive. 0=not,1=yes. Field 4, values 0,1*/
} FDT;

/* static items available in all modules of this file */
static const unsigned char  ChCR           = '\x0D';   /* \r - CR */
static const unsigned char  ChLF           = '\x0A';   /* \n - LF */
static const unsigned char  ChUS           = '\x1F';   /* ECMA-48 Unit Separator   / MARC21 subield delimiter   <US>/<IS1>*/
static const unsigned char  ChRS           = '\x1E';   /* ECMA-48 Record Separator / ISO-2709 field terminator  <RS>/<IS2>*/
static const unsigned char  ChGS           = '\x1D';   /* ECMA-48 Group Separator  / ISO-2709 record terminator <GS>/<IS3>*/
static const unsigned char  ChHASH         = '#';      /* Common terminator in ABCD for field and record */
static const int            MaxDeEntries   = 1000;     /* Labels have 3 positions (digits+letters) */ 
static const int            MaxFdtEntries  = 1000;     /* Assume an fdt with all possible labels */
static const int            MaxInvTag      = 1000;     /* Assumed sufficient */

static const unsigned char* INTERNALERR    = "***__Internal_Error__:"; /* standard text for arraylimits etc */

/* items available with actual values for all modules of this file */
static int   Notsplit       = 1;        /* <=0 : do not split record, 1=split record in lines of 80 characters*/
static int   Feedback       = 0;        /* Feedback level. Integer >0*/
static int   ActRecnum      = 0;        /* Actual record number being processed */
static int   Terminator     = 0;        /* Actual terminator indicator: 0=hash,1=control character conform ISO*/
static int   Ghostnum       = 0;        /* Total number of ghost entries removed in all records */
static char  InvTag[1000][4];           /* List with invalid tags */
static int   InvTagNum      = 0;        /* Actual number of invalid tags */

/* prototypes available in all modules of this file */
static void q00Help( int helptype);
static int  processFile(FILE *fpin, FILE *fpout, FILE *fdt, int *irecnum);
static int  readChars(FILE *fpin, int numchars, unsigned char *buf);
static int  readLabel(FILE *fpin, struct LABEL *label);
static void printLabel(struct LABEL label);
static int  readDirectoryEntry(FILE *fpin, struct LABEL label, int deindex, int desize, struct DE de[]);
static int  readFDT(FILE *fpfdt, struct FDT fdt[], int *numfdt);
static int  readField(FILE *fpin, int deindex, struct DE de[]);
static int  readTerminator(FILE *fpin, int type);
static int  convertRecord(struct LABEL *label, int desize, struct DE de[], int numfdt, struct FDT fdt[]);
static int  convertField(int deindex, struct DE de[]);
static int  writeRecord(FILE *fpout, struct LABEL *label, int desize, struct DE de[]);
static void getSubString(unsigned char *source, unsigned char *target,int from, int to);
static int  getSubStringInt(unsigned char *source, int from, int to);
static char*       strtoke(char *str, const char *delim); /* variant of strtok */



/*******************************************************************************
 ******************************************************************************/ 
int main( int argc, char *argv[] )
/*******************************************************************************
 * NAME:  main
 *
 * DESCRIPTION
 *   Main routine for the program.
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
    int result = 0;
    int i = 0;
    int writtenrecords=0;
    char *infile = NULL;
    char *outfile = NULL;
    char *sfeedback= NULL;
    char *fdtfile=NULL;
    char *sterminator=NULL;
    FILE *fpinfile = NULL;
    FILE *fpoutfile = NULL;
    FILE *fpfdtfile = NULL;

    /* 
    ** ----------------------------------
    ** Process the commandline arguments
    */ 
    while ( ( option = getopt( argc, argv, "vhnd:i:o:f:t:" ) ) != -1 ) {
        switch ( ( char ) option ) {
            case 'd':
                fdtfile = optarg;
                break;
            case 'i':
                infile = optarg;
                break;
            case 'n':
                Notsplit = 1;
                break;
            case 'o':
                outfile = optarg;
                break;
            case 'f':
                sfeedback = optarg;
                break;
            case 't':
                sterminator = optarg;
                break;
            case 'v':
                q00Help( 1 );
                goto EXIT;
            case 'h':
                 q00Help( 2 );
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
    ** Check parameters : terminator is optional with values hash and norm
    */
    if ( !isStrNull(sterminator) ) {
        if ( strcmp(sterminator,"hash")==0) {
            Terminator=0;
        } else if (strcmp(sterminator,"norm")==0) {
            Terminator=1;
        } else {
            fprintf(stderr, "*** Wrong value for output terminator (option -t) ***\n");
            q00Help(0);
            goto EXIT_ERROR;
        }
    }

    /*
    ** Check parameters : fdtfile is required and must be readable
    */
    if ( isStrNull(fdtfile) ) {
        fprintf(stderr, "*** FDT file is required ***\n");
        q00Help(0);
        goto EXIT_ERROR;
    }
    if ( access(fdtfile,R_OK)!=0) {
        fprintf(stderr, "*** FDT file '%s' does not exist or has insufficient permissions ***\n", fdtfile);
        q00Help(0);
        goto EXIT_ERROR;
    }

    /*
    ** Check parameters : inputfile is required and must be readable
    */
    if ( isStrNull(infile) ) {
        fprintf(stderr, "*** Input ISO file is required ***\n");
        q00Help(0);
        goto EXIT_ERROR;
    }
    if ( access(infile,R_OK)!=0) {
        fprintf(stderr, "*** Input ISO file '%s' does not exist or has insufficient permissions ***\n", infile);
        q00Help(0);
        goto EXIT_ERROR;
    }

    /*
    ** Check parameters: output file is required
    */
    if ( isStrNull(outfile) ) {
        fprintf(stderr, "*** Output ISO file is required ***\n");
        q00Help(0);
        goto EXIT_ERROR;
    }
    /*
    ** Input and output must be different
    ** Not an extensive check.
    */
    if ( strcmp(infile,outfile)==0) {
        fprintf(stderr, "*** Input and Output files are equal. Must be different ***\n");
        q00Help(0);
        goto EXIT_ERROR;
    }
    /*
    ** Delete a possible existing output file
    ** No error if file does not exist
    */
    if ( unlink( outfile ) != 0 && errno!=ENOENT) {
        fprintf( stderr, "*** Unable to delete existing outputfile '%s', status: %s\n", outfile,strerror(errno));
        q00Help(0);
        goto EXIT_ERROR;
    }

    /*
    ** Check parameters: feedback level must be an integer 0-3
    */
    if ( !isStrNull(sfeedback)) {
        if (strlen(sfeedback)!=1 || isdigit(sfeedback[0])==0 ){
            fprintf( stderr, "*** Option s (feedback level) must be an integer\n");
            q00Help(0);
            goto EXIT_ERROR;
        }
        Feedback=atoi(sfeedback);
    }
 
    /*
    ** Print the result of the input parameter processing
    */
    if(Feedback>0) {
        if(Terminator==0) sterminator="Hash (#)";
        if(Terminator>=1) sterminator="Control characters (<RS>/<GS>)";
        fprintf(stdout, "-i: ISO-2709 file to be converted will be read from : '%s'\n", infile);
        fprintf(stdout, "-o: Converted file will be written to               : '%s'\n", outfile);
        fprintf(stdout, "-d: FDT with Field Definitions will be read from    : '%s'\n", infile);
        fprintf(stdout, "-t: Terminators                                     : '%s'\n", sterminator);
        if ( Notsplit <= 0 ) {
            fprintf(stdout, "-n: ISO records are written as single line\n");
        } else {
            fprintf(stdout, "-n: ISO records are split into lines of 80 characters\n");
        }
        fprintf(stdout, "-f: Feedback level                                  : '%d'\n\n", Feedback);
    }

    /*
    ** Open the input file
    */
    fpinfile = fopen(infile, "r");
    if (fpinfile == NULL) {
        fprintf(stderr, "*** Unable to open  file '%s' for 'r', status: %s\n",
                infile, strerror(errno));
        goto EXIT_ERROR;;
    }
    /*
    ** Open the ouput file (binary mode, required by MinGW, optional for Cygwin/Linux
    */
    fpoutfile = fopen(outfile, "wb");
    if (fpoutfile == NULL) {
        fprintf(stderr, "*** Unable to open  file '%s' for 'w', status: %s\n",
                outfile, strerror(errno));
        goto EXIT_ERROR;;
    }

    /*
    ** Open the fdt file
    */
    fpfdtfile = fopen(fdtfile, "r");
    if (fpfdtfile == NULL) {
        fprintf(stderr, "*** Unable to open  file '%s' for 'r', status: %s\n",
                fdtfile, strerror(errno));
        goto EXIT_ERROR;;
    }
    /*
    ** Process the file
    */
    result=processFile(fpinfile, fpoutfile, fpfdtfile, &writtenrecords);
    if (result!=0) goto EXIT_ERROR;
EXIT:
    fprintf(stdout, "Number of removed entries: %d. (entries with tags not in FDT)\n", Ghostnum);
    if (InvTagNum>0) {
        fprintf(stdout, "List of tag values not in FDT:\n");
        for (i=0;i<InvTagNum;i++) fprintf(stdout,"%s  ", InvTag[i]);
        fprintf(stdout,"\n");
    }
    fprintf(stdout, "Successfull completion, %d records written to %s\n",writtenrecords,outfile);
    return(0);
EXIT_ERROR:
    fprintf(stdout, "*** Number of removed entries: %d. (entries not in FDT)\n", Ghostnum);
    fprintf(stdout, "*** Conversion incomplete, %d records written to %s\n",writtenrecords,outfile);
    fprintf(stderr, "*** Program terminated with errors. ***\n");
    return (1);
}
/*******************************************************************************
 ******************************************************************************/ 
int processFile(FILE *fpinfile, FILE *fpoutfile, FILE *fpfdtfile, int *writtenrecords)
{
    int retval=0;
    int dirEntryLength=0;
    int dirEntries=0;
    int checkBase=0;
    int deindex=0;
    int numfdt;
    static struct LABEL label;
    struct DE de[MaxDeEntries];
    struct FDT fdt[MaxFdtEntries];
    /*
    ** Read the fdt file before anything is processed
    */
    retval = readFDT( fpfdtfile, fdt, &numfdt);
    if( retval==0 && Feedback>0) {
        fprintf(stdout, "%i tags extracted from FDT\n",numfdt);
    }
    /*
    ** Read the iso file record by record
    */
    while ( retval==0 ) {
        /*
        ** The first thing of a record is the label. A fixed length string
        */
        ActRecnum++;
        retval=readLabel(fpinfile, &label);
        if (retval==0) {
            if ((ActRecnum==1 && Feedback>0) || Feedback>2 ) printLabel(label);
        }
        if (retval==-1) break;
        /* 
        ** PreProcess directory entries
        */
        if ( retval==0 ) {
            /* 
            ** Determine the number of octets for an entry
            ** tag(=3)+length_of_field(=iDirMapFieldL)+start_pos(=5)+userdefined(=iDirMapImplL)
            */
            dirEntryLength=label.dirEntryLength;
            /*
            ** Determine number of entries to be read
            ** (end of DE's(=iBaseData) -separator(=1) - label(=24))/dirEntryLength
            */
            dirEntries= (label.iBaseData-1-24)/dirEntryLength;
            checkBase=(dirEntries*dirEntryLength)+25;
            if ( checkBase!=label.iBaseData) {
                retval=1;
                fprintf(stderr,"*** Corrupt iso file. Record %d: mismatch directory entries and Base address of data\n",
                    ActRecnum);
                fprintf(stderr,"*** Label Base addres of data %d != Computed addres %d\n",label.iBaseData,checkBase);
                fprintf(stderr,"*** Computation:Label(24)+Separator(1)+Directory entries(#=%d * size=%d)\n",dirEntries,dirEntryLength);
            }
            /*
            ** Check that the internal tables have sufficient lines
            */
            if ( dirEntries>MaxDeEntries) {
                retval=1;
                fprintf(stderr,"*** Record %d: too many directory entries for this program\n",ActRecnum);
                fprintf(stderr,"*** Computed %d entries. Program limit is %d\n",dirEntries,MaxDeEntries);
            }
        }
        /* 
        ** Read directory entries
        */
        if ( retval==0 ) {
            for (deindex=0;deindex<dirEntries && retval==0; deindex++) {
                retval = readDirectoryEntry(fpinfile, label,deindex, dirEntryLength, de); 
            }
            if (retval==0) {
                retval=readTerminator(fpinfile, 0);
            }
        }
        /* 
        ** Read the field values for the directory entries
        ** Read also the record terminator.
        */
        if ( retval==0 ) {
             for (deindex=0;deindex<dirEntries && retval==0; deindex++) {
                 retval=readField(fpinfile, deindex, de);
             }
             if (retval==0) {
                retval=readTerminator(fpinfile, 1);
             }
        }
        /*
        ** Convert the fields (and adjust the label and directory entries)
        */
        if ( retval == 0 ) {
            retval=convertRecord(&label,dirEntries, de, numfdt, fdt);
        }
        /*
        ** Finally: write the record to the output file*/
        if ( retval==0 ) {
            retval=writeRecord(fpoutfile, &label, dirEntries, de);
            if ( retval==0 )(*writtenrecords)++;
        }
    }
    if (retval==0 || retval==-1) return(0);
    return(1);
}
/*******************************************************************************
 ******************************************************************************/ 
int  readLabel(FILE *fpinfile, struct LABEL *label)
{
    int retval=0;
    int inum=0;
    unsigned char *buf=NULL;
    unsigned char *tmpCrec=NULL;
    unsigned char *tmpCimp=NULL;
    unsigned char *tmpCuse=NULL;
    unsigned char *tmpCres=NULL;
    int numchars=24;
    buf = malloc((numchars+1) * sizeof(char));
    retval=readChars(fpinfile,numchars,buf);
    if (retval==0){
        inum=getSubStringInt(buf,0,4);
        label->iRecLength=inum;
        if ( inum<=24 ){
            fprintf(stderr, "*** Record %d: Invalid value '%d' for 'Record length'\n",ActRecnum,inum);
            retval = -3;
        }

        tmpCrec = malloc((numchars+1) * sizeof(char));
        getSubString(buf, tmpCrec,5,5);
        label->cRecStatus=tmpCrec;

        tmpCimp = malloc((numchars+1) * sizeof(char));
        getSubString(buf, tmpCimp,6,9);
        label->cImpcodes=tmpCimp;
        
        inum=getSubStringInt(buf,10,10);
        label->iIndicatorL=inum; 
        
        inum=getSubStringInt(buf,11,11);
        label->iIdentifierL=inum; 
        
        inum=getSubStringInt(buf,12,16);
        label->iBaseData=inum;
        if ( inum<=24 ){
            fprintf(stderr, "*** Record %d: Invalid value '%d' for 'Base address of data'\n",ActRecnum, inum);
            retval = -3;
        }

        tmpCuse = malloc((numchars+1) * sizeof(char));
        getSubString(buf, tmpCuse,17,19);
        label->cUserSystem=tmpCuse; 
        
        inum=getSubStringInt(buf,20,20);
        label->iDirMapFieldL=inum; 
        
        inum=getSubStringInt(buf,21,21);
        label->iDirMapStart=inum;
        
        inum=getSubStringInt(buf,22,22);
        label->iDirMapImplL=inum;

        tmpCres = malloc((numchars+1) * sizeof(char));
        getSubString(buf, tmpCres,23,23);
        label->cReserved=tmpCres;
        /* 
        ** Determine the number of octets for an entry
        ** tag(=3)+length_of_field(=iDirMapFieldL)+start_pos(=5)+userdefined(=iDirMapImplL)
        */
        label->dirEntryLength=3 + label->iDirMapFieldL + 5 + label->iDirMapImplL;
    }
    free(buf);
    return (retval);
}
/*******************************************************************************
 ******************************************************************************/ 
void  printLabel(struct LABEL label)
{
    fprintf(stdout,"Label record %d:\n",ActRecnum);
    fprintf(stdout,"        0- 4: Record length           '%i'\n", label.iRecLength);
    fprintf(stdout,"        5   : Record status           '%s'\n", label.cRecStatus);
    fprintf(stdout,"        6- 9: Implementation codes    '%s'\n", label.cImpcodes);
    fprintf(stdout,"       10   : Indicator length        '%i'\n", label.iIndicatorL);
    fprintf(stdout,"       11   : Identifier length       '%i'\n", label.iIdentifierL);
    fprintf(stdout,"       12-16: Base address of data    '%i'\n", label.iBaseData);
    fprintf(stdout,"       17-19: Def. by user systems    '%s'\n", label.cUserSystem);
    fprintf(stdout,"       20   : DE:Length of field part '%i'\n", label.iDirMapFieldL);
    fprintf(stdout,"       21   : DE:Starting position    '%i'\n", label.iDirMapStart);
    fprintf(stdout,"       22   : DE:Length impl-def part '%i'\n", label.iDirMapImplL);
    fprintf(stdout,"       23   : Reserved for future     '%s'\n", label.cReserved);
    return;
}
/*******************************************************************************
 ******************************************************************************/ 
int  readDirectoryEntry(FILE *fpinfile, struct LABEL label, int deindex, int desize, struct DE de[])
{
    int retval=0;
    int inum=0;
    int endirmfl=3+label.iDirMapFieldL-1;
    unsigned char *buf=NULL;
    unsigned char *tmpCtag=NULL;
    unsigned char *tmpCimp=NULL;
    buf = malloc((desize+1) * sizeof(char));
    retval=readChars(fpinfile,desize,buf);
    if (retval==0){
        tmpCtag = malloc((3+1) * sizeof(char));
        getSubString(buf, tmpCtag,0,2);
        de[deindex].cTag=tmpCtag;

        inum=getSubStringInt(buf,3,endirmfl);
        de[deindex].iDirFieldL=inum;
        if ( inum<=0 ){
            fprintf(stderr, "*** Record %d: Invalid value '%d' for Directory entry %d, element 'Length of field'\n",
                ActRecnum, inum, deindex+1);
            retval = -3;
        }

        inum=getSubStringInt(buf,endirmfl+1,endirmfl+5);
        de[deindex].iDirStartPos=inum;
        if ( inum<0 ){
            fprintf(stderr, "*** Record %d: Invalid value '%d' for Directory entry %d, element 'Start position of field'\n",
                ActRecnum,inum, deindex+1);
            retval = -3;
        }
        /* The implementation defined part can be 0 */
        tmpCimp = malloc((label.iDirMapImplL+1) * sizeof(char));
        tmpCimp[0]='\0';
        de[deindex].cImplDefined=tmpCimp;
        if (label.iDirMapImplL>0 ){
            getSubString(buf, tmpCimp,endirmfl+6, endirmfl+6+label.iDirMapImplL-1);
            de[deindex].cImplDefined=tmpCimp;
        }
        de[deindex].iInValid=0;
    }
    free(buf);
    return (retval);
}
/*******************************************************************************
 ******************************************************************************/ 
int  readFDT( FILE *fpfdt, struct FDT fdt[], int *numfdt)
{
    int retval = 0;
    int fdtindex = 0;
    int i = 0;
    unsigned char line[256];
    unsigned char *tokens[26];
    unsigned char *tmpStr=NULL;
    unsigned char *tmpStr2=NULL;
    int numtokens=sizeof(tokens)/sizeof(char*);
    while( fgets(line, sizeof(line),fpfdt) ) {
        if (Feedback > 2) fprintf(stdout,"%s", line);
        if ( fdtindex>=MaxFdtEntries) {
            retval=1;
            fprintf(stderr,"*** Too many lines with a tag in the FDT file for this program\n");
            fprintf(stderr,"*** Program limit is %d\n",MaxFdtEntries);
            return(retval);
        }
        for (i=0; i<sizeof(numtokens); i++ ) {
            tokens[i]=NULL;
        }
        i=0;
        tokens[i]=strtoke(line,"|");
        while ( tokens[i]!=NULL ) {
            i++;
            tokens[i] = strtoke(NULL,"|");
        }
        if ( strlen(tokens[0])>0 && strlen(tokens[1])>0 ) {
            tmpStr=malloc(strlen(tokens[1])+1);
            strcpy(tmpStr,tokens[1]);
            fdt[fdtindex].cTag=tmpStr;
            tmpStr2=malloc(strlen(tokens[2])+1);
            strcpy(tmpStr2,tokens[2]);
            fdt[fdtindex].cDescription=tmpStr2;
            if ( strlen(tokens[4]) > 0 ) {
                fdt[fdtindex].iRepetitive=atoi(tokens[4]);
            } else {
                fdt[fdtindex].iRepetitive=0;
            }
            fdtindex++;
        }
    }
    fclose(fpfdt);
    if ( Feedback > 1) {
        fprintf(stdout,"==== FDT entries ====\n");
        for (i=0;i<fdtindex;i++ ) {
            fprintf(stdout,"FDT entry:%i, tag=%s (%s), R=%i\n",i,fdt[i].cTag,fdt[i].cDescription,fdt[i].iRepetitive);
        }
    }
    *numfdt=fdtindex;
    return (retval);
}
/*******************************************************************************
 ******************************************************************************/ 
char* strtoke(char *str, const char *delim)
/*
**  Variant of strtok, returns also empty tokens.
**  Copy from internet:
**  https://stackoverflow.com/questions/42315585/split-string-into-tokens-in-c-when-there-are-2-delimiters-in-a-row
*/
{
    static char *start = NULL;    /* stores string str for consecutive calls */
    char *token = NULL;           /* found token */

    if (str) start = str;         /* assign new start in case */
    if (!start) return NULL;      /* check whether text to parse left */
    token = start;                /* remember current start as found token */
    start = strpbrk(start, delim);/* find next occurrence of delim */
    if (start) *start++ = '\0';   /* replace delim with terminator and move start to follower */
    return token;
}
/*******************************************************************************
 ******************************************************************************/ 
int  readField(FILE *fpinfile, int deindex, struct DE de[])
{
    int retval=0;
    unsigned char *buf=NULL;
    int len=de[deindex].iDirFieldL;
    buf = malloc((len) * sizeof(char));
    retval=readChars(fpinfile,len-1,buf);
    if (retval==0) {
        de[deindex].cField=buf;
        retval=readTerminator(fpinfile,0);
    } else if (retval==-1) {
        fprintf(stderr,"*** ERROR unexpected EOF for record %d, Directory entry %d\n",ActRecnum,deindex);
        fprintf(stderr,"*** Entry for tag '%s' with %d characters\n",de[deindex].cTag,len-1);
        free(buf);
    }
    return (retval);
}
/*******************************************************************************
 ******************************************************************************/ 
int  readTerminator(FILE *fpinfile, int type)
/*
** Wiki: MARC 21 uses US as a subfield delimiter, RS as a field terminator and GS as a record terminator.
**  ARGUMENT                I/O     DESCRIPTION
**      fpinfile            I/O     Pointer in input file
**      type                I       Type of terminator: 0= field terminator, 1=record terminator
**  Returns:    0 (OK), 1 (NOK)
*/
{
    int retval=0;
    unsigned char buf[2];
    retval=readChars(fpinfile,1,buf);
    if (retval==0) {
        if (type==0) {
            if ( buf[0]!=ChHASH && buf[0]!=ChRS ){
                fprintf(stderr,"*** Record %d: Expected field terminator '%c' or '%x' but found '%c' = hex '%x'\n",ActRecnum,ChHASH,ChRS,buf[0],buf[0]);
                retval=1;
            }
        } else {
            if ( buf[0]!=ChHASH && buf[0]!=ChGS ){
                fprintf(stderr,"*** Record %d: Expected record terminator '%c' or '%x' but found '%c' = hex '%x'\n",ActRecnum,ChHASH,ChGS,buf[0],buf[0]);
                retval=1;
            }
        }
    }
    return (retval);
}

/*******************************************************************************
 ******************************************************************************/ 
int  readChars(FILE *fpin, int numchars, unsigned char *buf)
/*
*# readChars    Read N octets from the input file into a buffer
**  Line endings (CR/LF/CRLF) are skipped
**
**  ARGUMENT                I/O     DESCRIPTION
**      fpin                I       Pointer to inputfile
**      numchars            I       Requested number of octets
**      buf                 I/O     I: empty buffer. O: octets read, with trailing \0
**                                  Buf must be large enough to accomodate numchars+1 octets
**  Returns:    0 (OK),
**             -1 (Nothing read : immediate EOF): May be an error
**             -2 (Less than numchars read)     : Always an error. Prints an error
*/ 
{
    int retval=0;
    int numread=0;
    int iletter=0;
    unsigned char letter='\0';
    while (numread < numchars && iletter!=EOF) {
        iletter = fgetc(fpin);
        letter=(unsigned char)iletter;
        if ( letter!=ChCR && letter!=ChLF && iletter!=EOF) {
            buf[numread]=letter;
            numread++;
        }
    }
    buf[numread]='\0';
    if (numchars==0) {
        /* if nothing requested. Return=0*/
        retval=0;
    } else if (numread==0) {
        retval=-1;
    } else if (numread<numchars) {
        retval=-2;
        fprintf(stderr, "*** Record %d: Unexpected end of file. %d octets requested, %d octets found ***\n",ActRecnum, numchars,numread);
    }
    return (retval);
}
/*******************************************************************************
 ******************************************************************************/ 
void getSubString(unsigned char *source, unsigned char *target,int from, int to)
{
	int i=0,j=0;
	target[0]='\0'; 
	if(from<0) {
		fprintf(stderr, "*** Record %d: Invalid \'from\' index: %d in '%s'\n", ActRecnum, from,source);
		return;
	}
	if(to<from){
		fprintf(stderr, "*** Record %d: Invalid \'to\' index: %d in '%s'\n", ActRecnum, to,source);
		return;
	}	
	for(i=from,j=0;i<=to;i++,j++){
		target[j]=source[i];
	}
	//assign NULL at the end of string
	target[j]='\0'; 
	return;	
}
/*******************************************************************************
 ******************************************************************************/ 
int getSubStringInt(unsigned char *source, int from, int to)
{
	int retval=-1;
    int i=0;
    int numerr=0;
	unsigned char *target=malloc((11) * sizeof(char));/* sufficient for 10 digits*/
	getSubString(source,target,from,to);
    /* Check that we have digits */
    for ( i=0; i<(int)strlen(target);i++) {
        if ( !isdigit(target[i])) {
           fprintf(stderr, "*** Record %d: Invalid digit: '%c' in substring '%s' in '%s'\n",
                ActRecnum, target[i],target,source);
           numerr++;
        }
    }
    if (numerr==0) retval=atoi(target);
    free(target);
	return retval;	
}
/*******************************************************************************
 ******************************************************************************/ 
int  convertRecord(struct LABEL *label, int desize, struct DE de[], int numfdt, struct FDT fdt[])
{
    int retval=0;
    int i=0;
    int j=0;
    int k=0;
    int l=0;
    int found=0;
    int found2=0;
    char *deTag=NULL;
    char *fdtTag=NULL;
    for ( i=0; i<desize; i++ ) {
        deTag=de[i].cTag;
        /* Check that this tag is present in the fdt */
        found=0;
        for ( k=0; k<numfdt; k++ ) {
            fdtTag=fdt[k].cTag;
            if ( strcmp(deTag,fdtTag)==0 ) found=1;
        }
        if ( found==0 ) {
            /* The tag is not in the FDT */
            Ghostnum++;
            if ( Feedback > 1) fprintf(stdout,"Record %d: unknown tag: %s\n", ActRecnum, deTag);
            de[i].iInValid = 1;
            /*
            ** Corrigate record size for deleted de entry and deleted field
            */
            label->iRecLength = label->iRecLength-label->dirEntryLength - de[i].iDirFieldL;
            /*
            ** Corrigate base adress of data for deleted de entry
            */
            label->iBaseData = label->iBaseData - label->dirEntryLength;
            /*
            ** Corrigate start positions of following directory entries
            */
            for (j=i+1; j<desize; j++ ) {
                de[j].iDirStartPos = de[j].iDirStartPos - de[i].iDirFieldL;
            }
            /*
            ** Administrate the unknown tag
            ** Only if the maximum is not reached (silent ignore more)
            */
            if ( InvTagNum<MaxInvTag ) {
                found2=0;
                for (l=0; l<InvTagNum; l++) {
                    if ( strcmp(deTag, InvTag[l])==0 ) found2=1;
                }
                if ( found2==0 ){
                    InvTagNum++;
                    strcpy(InvTag[InvTagNum-1], deTag);
                }
           }
        }
    }
    return(retval);
}
/*******************************************************************************
 ******************************************************************************/ 

/*******************************************************************************
 ******************************************************************************/ 
int  writeRecord(FILE *fpout, struct LABEL *label, int desize, struct DE de[])
{
    int  retval=0;
    int  i=0;
    int  isoreclen=0;
    char termField[2]={'\0','\0'};
    char termRecord[2]={'\0','\0'};
    char *buf=NULL;
    char tmp[25]; /* large enough for de's*/
    /*
    ** set separators
    */
    if (Terminator==0) {
        termField[0]=ChHASH;
        termRecord[0]=ChHASH;
    } else {
        termField[0]=ChRS;
        termRecord[0]=ChGS;
    }
    /*
    ** Allocate a buffer large enough for the complete record*/
    buf=malloc((label->iRecLength+1) * sizeof(char));
    /*
    ** First buffer entry is the label information
    */
    sprintf(buf,"%05d%s%s%01d%01d%05d%s%01d%01d%01d%s",
        label->iRecLength,   label->cRecStatus, label->cImpcodes,   label->iIndicatorL,
        label->iIdentifierL, label->iBaseData,  label->cUserSystem, label->iDirMapFieldL,
        label->iDirMapStart, label->iDirMapImplL, label->cReserved);
    /*
    ** The directory entries
    */
    for ( i=0;i<desize;i++ ) {
        if ( de[i].iInValid == 0 ) {
            sprintf(tmp,"%3.3s%0*d%05d%s",
                de[i].cTag,  label->iDirMapFieldL,de[i].iDirFieldL, de[i].iDirStartPos, de[i].cImplDefined);
            strcat(buf,tmp);
            free(de[i].cTag);
            free(de[i].cImplDefined);
        }
    }
    strcat(buf, termField);
    /*
    ** Write the data fields (with terminator)
    */
    for ( i=0;i<desize;i++ ) {
        if ( de[i].iInValid == 0 ) {
            strcat(buf,de[i].cField);
            strcat(buf, termField);
            free(de[i].cField);
        }
    }
    strcat(buf, termRecord);
    if ( (int)strlen(buf)!=label->iRecLength) {
        fprintf(stderr,"%s. Record %d. Expected record length=%d and actual length=%d\n",
            INTERNALERR, ActRecnum, label->iRecLength, (int)strlen(buf));
        retval=1;
    }
    /*
    ** Finally write the complete buffer to the iso file
    ** Note that ABCD requires lines of exactly 80 octets, except the last line of a record (contains the remaining part)
    ** Note that ABCD does NOT like empty lines and multiple trailing empty lines.
    ** Note that UTF-8 lines look shorter (they have multiple octets/letter);
    */
    if ( Notsplit <= 0 ) {
        /* Write record as single line. Option almost never used */
        fprintf(fpout,"%s%s",buf,LINEEND);
    } else {
        /* Write record in lines of 80 characters */
        isoreclen = (int)strlen(buf);
        for ( i=0; i < isoreclen; i++ )
        {
            fprintf (fpout,"%c", buf[i]);
            if ( ((i+1) % 80) == 0 ) {
                fprintf (fpout,"%s",LINEEND);
            }
        }
        /* write trailing newline if not yet done in the loop */
        if ( (isoreclen % 80 ) != 0) {
            fprintf (fpout,"%s",LINEEND);
        }
    }
    free(label->cRecStatus);
    free(label->cImpcodes);
    free(label->cUserSystem);
    free(label->cReserved);
    free(buf);
	return retval;	
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
        fprintf(stdout, "*** Run this program with option -h or -H to show usage information *** \n");
    }
    else if ( helptype == 1 ) {
        fprintf(stdout, "Version %s, compiled on %s, %s\n", VERSION, __DATE__,__TIME__);
    }
    else {
        fprintf(stdout, "\
Function: This program reads an ISO-2709 file and removes all fields not specified in the FDT.\n\
Commandline options:\n\
           -i 'iso_file_in_iso-8859-1' -o 'iso_file_matched' -d 'fdt_file' \n\
          [-f 'level'] [-t 'terminator' [-n] [-v] [-h]\n\
  options:\n\
   -d - Path to the FDT file\n\
   -f - Feedback level directive. default=0 \n\
   -i - Path to ISO-2709 inputfile to be matched with FDT file.\n\
   -n - Do not split isorecord into lines of 80 characters. Default is split (required by import)\n\
   -o - Path to ISO-2709 outputfile.\n\
   -t - Terminator indicator for the output file\n\
          hash = Field and record terminator the # sign (default)\n\
          norm = Conform ISO-2709: Field terminator=IS2(RS). Record terminator=IS3(GS)\n\
   -v - version information\n\
   -h - usage/function information (this message)\n\
Example 1: ./isofile_match_with_fdt -i mydownload.iso -o myupload.iso -d mybase/def/en/mybase.fdt\n\
Example 2: ./isofile_match_with_fdt -i mydownload.iso -o myupload.iso -d mybase/def/en/mybase.fdt  -n -t norm -f 3\n\
"); 
    }
    
return;
}

/********************* end of file ***********/