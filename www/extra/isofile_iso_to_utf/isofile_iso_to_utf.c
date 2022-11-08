/*********************************************************************
 * FILE isofile_iso_to_utf.c
 *      This file contains c-code to convert the character code of an iso-2709 into utf-8.
 *      Main conversion is from ISO8859-1 and Windows-1252 to UTF-8.
 *      It is possible to specify no conversion. In this case the file is only retwritten.
 *      The functionalty includes several options to format the resulting file. This is
 *      usefull to match the format for ISIS utilities (ex fixed linelength,...)
 *
 *      Compile this program for linux or windows with cygwin (bash) with the gcc compiler:
 *              gcc -o isofile_iso_to_utf isofile_iso_to_utf.c
 *              This program will produce files with LF
 *      Compiling this program for windows command line (CMD) usage:
 *          By cygwin. Creates a staticly linked executable, produce files with CRLF:
 *              i686-w64-mingw32-gcc -o isofile_iso_to_utf.exe isofile_iso_to_utf.c
 *          By MinGW. Creates a staticly linked executable, produce files with CRLF:
 *              gcc -o isofile_iso_to_utf.exe isofile_iso_to_utf.c
 *      Check source on windows with cygwin.
 *              splint isofile_iso_to_utf.c -unrecog  -nullpass -compdef -bufferoverflowhigh ...
 *              Gives several warnings. None serious at first inspection.
 *
 * AUTHOR   Fred Hommersom
 * HISTORY:
 *      2021-06-04:(fho) Initial version (1.0)
 *      2021-06-08:(fho) print feedback to stdout (1.1)
 *      2021-06-25:(fho) improve display of help (1.2)
 *_____________________________________________________________________
 * Call tree    : main
 *              :   processFile
 *              :       readLabel
 *              :       printLabel
 *              :       readDirectoryEntry
 *              :       readTerminator
 *              :       readField
 *              :       convertRecord
 *              :           convertField
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

#define VERSION "1.2"
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
} LABEL;

typedef struct DE {     /* Struct with value of Directory Entry and Fieldvalue*/
    unsigned char *cTag;         /* Tag of the DE. octet 0-2 */
    int           iDirFieldL;    /* Length of field. octets depend on iDirMapFieldL*/
    int           iDirStartPos;  /* Starting character position of field. 5 octets */
    unsigned char *cImplDefined; /* Implementation defined. Octets depend on iDirMapImplL*/
    unsigned char *cField;       /* Data field value of this entry*/
    unsigned char *cFieldCnv;    /* Converted data field value of this entry*/
} DE;

/* static items available in all modules of this file */
static const unsigned char  ChCR           = '\x0D';   /* \r - CR */
static const unsigned char  ChLF           = '\x0A';   /* \n - LF */
static const unsigned char  ChUS           = '\x1F';   /* ECMA-48 Unit Separator   / MARC21 subield delimiter   <US>/<IS1>*/
static const unsigned char  ChRS           = '\x1E';   /* ECMA-48 Record Separator / ISO-2709 field terminator  <RS>/<IS2>*/
static const unsigned char  ChGS           = '\x1D';   /* ECMA-48 Group Separator  / ISO-2709 record terminator <GS>/<IS3>*/
static const unsigned char  ChHASH         = '#';      /* Common terminator in ABCD for field and record */
static const unsigned char  AscMax         = '\x7F';   /* Maximum standard ASCII code (not assigned to anything */
static const int            MaxDeEntries   = 1000;     /* Labels have 3 positions (digits+letters) */ 

static const unsigned char* INTERNALERR    = "***__Internal_Error__:"; /* standard text for arraylimits etc */

/* items available with actual values for all modules of this file */
static int   Notsplit       = 1;        /* <=0 : do not split record, 1=split record in lines of 80 characters*/
static int   Feedback       = 0;        /* Feedback level. Integer >0*/
static int   ActRecnum      = 0;        /* Actual record number being processed */
static int   Convert        = 3;        /* Actual conversion (0=n, 1=Iso, 2= Windows, 3=both)*/
static int   Terminator     = 0;        /* Actual terminator indicator: 0=hash,1=control charaacter conform ISO*/

/* prototypes available in all modules of this file */
static void q00Help( int helptype);
static int  processFile(FILE *fpin, FILE *fpout, int *irecnum);
static int  readChars(FILE *fpin, int numchars, unsigned char *buf);
static int  readLabel(FILE *fpin, struct LABEL *label);
static void printLabel(struct LABEL label);
static int  readDirectoryEntry(FILE *fpin, struct LABEL label, int deindex, int desize, struct DE de[]);
static int  readField(FILE *fpin, int deindex, struct DE de[]);
static int  readTerminator(FILE *fpin, int type);
static int  convertRecord(struct LABEL *label, int desize, struct DE de[]);
static int  convertField(int deindex, struct DE de[]);
static int  writeRecord(FILE *fpout, struct LABEL *label, int desize, struct DE de[]);
static void getSubString(unsigned char *source, unsigned char *target,int from, int to);
static int  getSubStringInt(unsigned char *source, int from, int to);

/*
** Conversion table from ISO-8859-1 to UTF-8
** Range 00-1F are control characters and will not be present in any text
** Range 20-7E need no conversion: identical in UTF-8
** Range 7F-9F are not defined by ISO.
** Range A0-FF are given in this table.
*/
static const unsigned char CnvIsoToUtfTab[][3]={
[0xA0]={0x20,0,0}   /* */, [0xA1]={0xc2,0xa1,0}/*¡*/, [0xA2]={0xc2,0xa2,0}/*¢*/, [0xA3]={0xc2,0xa3,0}/*£*/,
[0xA4]={0xc2,0xa4,0}/*¤*/, [0xA5]={0xc2,0xa5,0}/*¥*/, [0xA6]={0xc2,0xa6,0}/*¦*/, [0xA7]={0xc2,0xa7,0}/*§*/,
[0xA8]={0xc2,0xa8,0}/*¨*/, [0xA9]={0xc2,0xa9,0}/*©*/, [0xAA]={0xc2,0xaa,0}/*ª*/, [0xAB]={0xc2,0xab,0}/*«*/,
[0xAC]={0xc2,0xac,0}/*¬*/, [0xAD]={0xc2,0xad,0}/*-*/, [0xAE]={0xc2,0xae,0}/*®*/, [0xAF]={0xc2,0xaf,0}/*¯*/,

[0xB0]={0xc2,0xb0,0}/*°*/, [0xB1]={0xc2,0xb1,0}/*±*/, [0xB2]={0xc2,0xb2,0}/*²*/, [0xB3]={0xc2,0xb3,0}/*³*/,
[0xB4]={0xc2,0xb4,0}/*´*/, [0xB5]={0xc2,0xb5,0}/*µ*/, [0xB6]={0xc2,0xb6,0}/*¶*/, [0xB7]={0xc2,0xb7,0}/*·*/,
[0xB8]={0xc2,0xb8,0}/*¸*/, [0xB9]={0xc2,0xb9,0}/*¹*/, [0xBA]={0xc2,0xba,0}/*º*/, [0xBB]={0xc2,0xbb,0}/*»*/,
[0xBC]={0xc2,0xbc,0}/*¼*/, [0xBD]={0xc2,0xbd,0}/*½*/, [0xBE]={0xc2,0xbe,0}/*¾*/, [0xBF]={0xc2,0xbf,0}/*¿*/,

[0xC0]={0xc3,0x80,0}/*À*/, [0xC1]={0xc3,0x81,0}/*Á*/, [0xC2]={0xc3,0x82,0}/*Â*/, [0xC3]={0xc3,0x83,0}/*Ã*/,
[0xC4]={0xc3,0x84,0}/*Ä*/, [0xC5]={0xc3,0x85,0}/*Å*/, [0xC6]={0xc3,0x86,0}/*Æ*/, [0xC7]={0xc3,0x87,0}/*Ç*/,
[0xC8]={0xc3,0x88,0}/*È*/, [0xC9]={0xc3,0x89,0}/*É*/, [0xCA]={0xc3,0x8a,0}/*Ê*/, [0xCB]={0xc3,0x8b,0}/*Ë*/,
[0xCC]={0xc3,0x8c,0}/*Ì*/, [0xCD]={0xc3,0x8d,0}/*Í*/, [0xCE]={0xc3,0x8e,0}/*Î*/, [0xCF]={0xc3,0x8f,0}/*Ï*/,

[0xD0]={0xc3,0x90,0}/*Ð*/, [0xD1]={0xc3,0x91,0}/*Ñ*/, [0xD2]={0xc3,0x92,0}/*Ò*/, [0xD3]={0xc3,0x93,0}/*Ó*/,
[0xD4]={0xc3,0x94,0}/*Ô*/, [0xD5]={0xc3,0x95,0}/*Õ*/, [0xD6]={0xc3,0x96,0}/*Ö*/, [0xD7]={0xc3,0x97,0}/*×*/,
[0xD8]={0xc3,0x98,0}/*Ø*/, [0xD9]={0xc3,0x99,0}/*Ù*/, [0xDA]={0xc3,0x9a,0}/*Ú*/, [0xDB]={0xc3,0x9b,0}/*Û*/,
[0xDC]={0xc3,0x9c,0}/*Ü*/, [0xDD]={0xc3,0x9d,0}/*Ý*/, [0xDE]={0xc3,0x9e,0}/*Þ*/, [0xDF]={0xc3,0x9f,0}/*ß*/,

[0xE0]={0xc3,0xa0,0}/*à*/, [0xE1]={0xc3,0xa1,0}/*á*/, [0xE2]={0xc3,0xa2,0}/*â*/, [0xE3]={0xc3,0xa3,0}/*ã*/,
[0xE4]={0xc3,0xa4,0}/*ä*/, [0xE5]={0xc3,0xa5,0}/*å*/, [0xE6]={0xc3,0xa6,0}/*æ*/, [0xE7]={0xc3,0xa7,0}/*ç*/,
[0xE8]={0xc3,0xa8,0}/*è*/, [0xE9]={0xc3,0xa9,0}/*é*/, [0xEA]={0xc3,0xaa,0}/*ê*/, [0xEB]={0xc3,0xab,0}/*ë*/,
[0xEC]={0xc3,0xac,0}/*ì*/, [0xED]={0xc3,0xad,0}/*í*/, [0xEE]={0xc3,0xae,0}/*î*/, [0xEF]={0xc3,0xaf,0}/*ï*/,

[0xF0]={0xc3,0xb0,0}/*ð*/, [0xF1]={0xc3,0xb1,0}/*ñ*/, [0xF2]={0xc3,0xb2,0}/*ò*/, [0xF3]={0xc3,0xb3,0}/*ó*/,
[0xF4]={0xc3,0xb4,0}/*ô*/, [0xF5]={0xc3,0xb5,0}/*õ*/, [0xF6]={0xc3,0xb6,0}/*ö*/, [0xF7]={0xc3,0xb7,0}/*÷*/,
[0xF8]={0xc3,0xb8,0}/*ø*/, [0xF9]={0xc3,0xb9,0}/*ù*/, [0xFA]={0xc3,0xba,0}/*ú*/, [0xFB]={0xc3,0xbb,0}/*û*/,
[0xFC]={0xc3,0xbc,0}/*ü*/, [0xFD]={0xc3,0xbd,0}/*ý*/, [0xFE]={0xc3,0xbe,0}/*þ*/, [0xFF]={0xc3,0xbf,0}/*y 2 dots*/
};

/*
** Conversion table from Windows-1252 to UTF-8
** This table covers here only the part that is not defined by the ISO table above
** Range 80-9F contains the windows specials. Some value map to black rhombus with a white question mark 
*/
static const unsigned char CnvWinToUtfTab[][4]={
[0x80]={0xe2,0x82,0xac,0}/*€*/, [0x81]={0xef,0xbf,0xbd,0}/*?*/, [0x82]={0xe2,0x80,0x9a,0}/*‚*/, [0x83]={0xc6,0x92,0,0}/*ƒ*/,
[0x84]={0xe2,0x80,0x9e,0}/*„*/, [0x85]={0xe2,0x80,0xa6,0}/*…*/, [0x86]={0xe2,0x80,0xa0,0}/*†*/, [0x87]={0xe2,0x80,0xa0,0}/*‡*/,
[0x88]={0xcb,0x86,0x0a,0}/*ˆ*/, [0x89]={0xe2,0x80,0xb0,0}/*‰*/, [0x8A]={0xc5,0xa0,0,0}/*Š*/,    [0x8B]={0xe2,0x80,0xb9,0}/*‹*/,
[0x8C]={0xc5,0x92,0,0}/*Œ*/,    [0x8D]={0xef,0xbf,0xbd,0}/*?*/, [0x8E]={0xc5,0xbd,0,0}/*Ž*/,    [0x8F]={0xef,0xbf,0xbd,0}/*?*/,

[0x90]={0xef,0xbf,0xbd,0}/*?*/, [0x91]={0xe2,0x80,0x98,0}/*‘*/, [0x92]={0xe2,0x80,0x99,0}/*’*/, [0x93]={0xe2,0x80,0x9c,0}/*“*/,
[0x94]={0xe2,0x80,0x9d,0}/*”*/, [0x95]={0xe2,0x80,0xa2,0}/*•*/, [0x96]={0xe2,0x80,0x93,0}/*–*/, [0x97]={0xe2,0x80,0x94,0}/*—*/,
[0x98]={0xcb,0x9c,0x0a,0}/*˜˜*/,  [0x99]={0xe2,0x84,0,0}/*™*/,    [0x9A]={0xcb,0x9c,0x0a,0}/*š*/, [0x9B]={0xe2,0x80,0xba,0}/*›*/,
[0x9C]={0xc5,0x93,0,0}/*œ*/,    [0x9D]={0xef,0xbf,0xbd,0}/*?*/, [0x9E]={0xc5,0xbe,0,0}/*ž*/,    [0x9F]={0xc5,0xb8,0,0}/*Ÿ*/
};

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
    int writtenrecords=0;
    char *infile = NULL;
    char *outfile = NULL;
    char *sfeedback= NULL;
    char *sconvert=NULL;
    char *sterminator=NULL;
    FILE *fpinfile = NULL;
    FILE *fpoutfile = NULL;

    /* 
    ** ----------------------------------
    ** Process the commandline arguments
    */ 
    while ( ( option = getopt( argc, argv, "vhnc:i:o:f:t:" ) ) != -1 ) {
        switch ( ( char ) option ) {
            case 'c':
                sconvert = optarg;
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
    ** Check parameters : convert is optional with values n,i,w,iw
    */
    if ( !isStrNull(sconvert) ) {
        if ( strcmp(sconvert,"n")==0) {
            Convert=0;
        } else if (strcmp(sconvert,"i")==0) {
            Convert=1;
        } else if (strcmp(sconvert,"w")==0) {
            Convert=2;
        } else if (strcmp(sconvert,"iw")==0 || strcmp(sconvert,"wi")==0) {
            Convert=3;
        } else {
            fprintf(stderr, "*** Wrong value for convert (option -c) ***\n");
            q00Help(0);
            goto EXIT_ERROR;
        }
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
        if(Convert==0) sconvert="none";
        if(Convert==1) sconvert="ISO-8859-1";
        if(Convert==2) sconvert="Windows-1252 (delta)";
        if(Convert>=3) sconvert="ISO-8859-1 + Windows-1252 (delta)";
        if(Terminator==0) sterminator="Hash (#)";
        if(Terminator>=1) sterminator="Control characters (<RS>/<GS>)";
        fprintf(stdout, "-i: ISO-2709 file to be converted will be read from : '%s'\n", infile);
        fprintf(stdout, "-o: Converted file will be written to               : '%s'\n", outfile);
        fprintf(stdout, "-c: Conversions                                     : '%s'\n", sconvert);
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
    ** Process the file
    */
    result=processFile(fpinfile, fpoutfile, &writtenrecords);
    if (result!=0) goto EXIT_ERROR;
EXIT:
    fprintf(stdout, "Successfull completion, %d records written to %s\n",writtenrecords,outfile);
    return(0);
EXIT_ERROR:
    fprintf(stdout, "*** Conversion incomplete, %d records written to %s\n",writtenrecords,outfile);
    fprintf(stderr, "*** Program terminated with errors. ***\n");
    return (1);
}
/*******************************************************************************
 ******************************************************************************/ 
int processFile(FILE *fpinfile, FILE *fpoutfile, int *writtenrecords)
{
    int retval=0;
    int dirEntryLength=0;
    int dirEntries=0;
    int checkBase=0;
    int deindex=0;
    static struct LABEL label;
    struct DE de[MaxDeEntries];
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
            dirEntryLength=3 + label.iDirMapFieldL + 5 + label.iDirMapImplL;
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
            retval=convertRecord(&label,dirEntries, de);
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
    }
    free(buf);
    return (retval);
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
int  convertRecord(struct LABEL *label, int desize, struct DE de[])
{
    int retval=0;
    int i=0;
    int j=0;
    int len=0;
    int lencnv=0;
    int lendiff=0;
    for ( i=0; i<desize; i++ ) {
        retval=convertField(i,de);
        len=de[i].iDirFieldL-1; /* fieldlength includes separator*/
        lencnv=(int)strlen(de[i].cFieldCnv);
        lendiff=lencnv-len;
        if ( lendiff!=0) {
            if ((Feedback>1)) {
                fprintf(stdout,"Record %d, tag '%s', delta=%d octets. Field='%s'\n",
                    ActRecnum, de[i].cTag,lendiff,de[i].cFieldCnv);
            }
            /* Corrigate record size */
            label->iRecLength=label->iRecLength+lendiff;
            /* Corrigate length of current directory entry */
            de[i].iDirFieldL=de[i].iDirFieldL+lendiff;
            /* Corrigate start positions of following directory entries */
            for (j=i+1; j<desize; j++ ) {
                de[j].iDirStartPos=de[j].iDirStartPos+lendiff;
            }
        }
    }
    return(retval);
}
/*******************************************************************************
 ******************************************************************************/ 
int convertField(int deindex, struct DE de[])
{
    int  retval=0;
    int  i = 0;
    int  len = de[deindex].iDirFieldL;
    unsigned char letter;
    unsigned char *buf=de[deindex].cField;

    unsigned char *bufcnv = malloc((len*3 + 1) * sizeof(char) ); /* sufficient for 3 octets utf-8*/
    de[deindex].cFieldCnv=bufcnv;

    for (; *buf!=(unsigned char)'\0'; ++buf) {
        if (*buf < AscMax || Convert==0 ) {
            *bufcnv++ = *buf;
        } else {
            letter=*buf;
            if( *buf>=(unsigned char)'\xA0' && (Convert==1||Convert==3)) {
                /*
                ** The ISO-8859-1 printable start at 0XA0
                ** all values up to FF are filled
                */
                for ( i=0;CnvIsoToUtfTab[(int)*buf][i]!=(unsigned char)'\0';i++){
                    *bufcnv++=CnvIsoToUtfTab[(int)*buf][i];
                }
            } else if (*buf>=(unsigned char)'\x80' && *buf<=(unsigned char)'\x9F' && Convert>=2) {
                /*
                ** The Windows-1252 covers almost the whole range of 8 bits
                ** Most of it is covered by ISO-8859-1
                ** This range is added to help users with old databases filled with windows based programs
                */
                for ( i=0;CnvWinToUtfTab[(int)*buf][i]!=(unsigned char)'\0';i++){
                    *bufcnv++=CnvWinToUtfTab[(int)*buf][i];
                }
            } else {
                /*
                ** If all conversions fail:
                ** show the black rhombus with a white question mark (3 bytes)
                */
                *bufcnv++=(unsigned char)'\xef';
                *bufcnv++=(unsigned char)'\xbf';
                *bufcnv++=(unsigned char)'\xbd';
            }                
        }
    }
    *bufcnv = '\0';
    return(retval);
}
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
        sprintf(tmp,"%3.3s%0*d%05d%s",
            de[i].cTag,  label->iDirMapFieldL,de[i].iDirFieldL, de[i].iDirStartPos, de[i].cImplDefined);
        strcat(buf,tmp);
        free(de[i].cTag);
        free(de[i].cImplDefined);
    }
    strcat(buf, termField);
    /*
    ** Write the data fields (with terminator)
    */
    for ( i=0;i<desize;i++ ) {
        strcat(buf,de[i].cFieldCnv);
        strcat(buf, termField);
        free(de[i].cField);
        free(de[i].cFieldCnv);
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
Function: This program converts an ISO-2709 file encoded in ISO-8859-1\n\
                           into an ISO-2709 file encoded in UTF-8.\n\
Commandline options:\n\
          -i 'iso_file_in_iso-8859-1' -o 'iso_file_in_utf-8'\n\
          [-c 'conversion'] [-f 'level'] [-t 'terminator' [-n] [-v] [-h]\n\
  options:\n\
   -c - Conversion directive. Default=iw\n\
          n  = no conversion,\n\
          i  = convert ISO8859-1\n\
          w  = convert Windows-1252 delta\n\
          iw = convert ISO8859-1 + Windows-1252 delta\n\
   -f - Feedback level directive. default=0 \n\
          0  = no additional feedback.\n\
          1  = print leader of first record\n\
          2  = print modfied fields\n\
          3  = print leaders + modified fields \n\
   -i - Path to ISO-2709 inputfile encoded in ISO-8859-1 to be converted to UTF-8 encoding.\n\
   -n - Do not split isorecord into lines of 80 characters. Default is split (required by import)\n\
   -o - Path to iso outputfile.\n\
   -t - Terminator indicator for the output file\n\
          hash = Field and record terminator the # sign (default)\n\
          norm = Conform ISO-2709: Field terminator=IS2(RS). Record terminator=IS3(GS)\n\
   -v - version information\n\
   -h - usage/function information (this message)\n\
Example 1: ./isofile_iso_to_utf -i mydownload.iso -o myupload.iso\n\
Example 2: ./isofile_iso_to_utf -i mydownload.iso -o myupload.iso  -n -t norm -f 3\n\
"); 
    }
    
return;
}

/********************* end of file ***********/