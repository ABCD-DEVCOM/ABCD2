<?php
/**
 * @file:	help_lang_en.php
 * @desc:	Help messages in English for the ABCD - SeCS-web module
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @co-author:  Wenke Adam <wenkeadam@gmail.com>
 * @since:      2009-05-31
 * @copyright:  (c) 2009 Bireme - PFI
 ******************************************************************************/

/****************** Information for translators *************************
 *
 * This Help file is divided in Sections as follows: Mask, Issues, Users, TitlePlus and Title
 * Above each variable there is a comment indicating the field tag of the corresponding ISIS database.
 * The help messages are presented in the same order as the fields appear in the sections of the SeCS-Web interface.
 * The variable names are constructed as follows: All start with the declaration $BVS_LANG followed by a label in square brackets,
 * starting with 'help&' or 'helper' and the descriptive field name.
 * After this comes an equal sign and the help message text content in double quotes with a semicolon at the end.
 * Variable names are case sensitive.
 *
 * Example:    $BVS_LANG["helpFullname"] = "Enter user&#180;s full name";
 *
 * To make a new language version, edit the text found between the double quotes.

 * In the help text use the <br /> tag to jump lines.
 * Example:
 * $BVS_LANG["helpersectionPart"] = "Alphabetical or numerical designation of section or part, which completes the Title proper and depends on it for identification or understanding.<br />
 * Enter the term Series, Section, Part or equivalent only if it is part of title proper.<br />
 * Capitalise first letter of significant term.<br />
 * Examples:<br />
 * a) Serial Title: Bulletin signaletique<br />
 * Section/part: Section 330<br />
 * b) Serial Title: Acta pathologica et microbiologica scandinavica<br />
 * Section/part: Section A";
 */

/****************************************************************************************************/
/***************** Mask Section - Field Help messages ****************************************/
/****************************************************************************************************/

//data not recorded
$BVS_LANG["helpBasedMask"] = "Create a new mask based on a selected mask, to facilitate dataentry.<br />
This data is not recorded in the database";

//field v801
$BVS_LANG["helpMaskName"] = "Enter the name of the mask here.
Use a consistent naming pattern for all masks (as recommended
by the Periodicals Control Workshop held at BIREME, september 1989).<br />
Mask name is composed of ISDS Frequency Code, followed by number of volumes and/or
issues in a typical year.<br />
Use the code M, after volume/issue, to identify volumes or issues represented by names of months.<br />
The symbol + is used to identify volumes or issues with continuous numbering from 1 to infinity.<br /> <br />
Examples:<br />
 M1V12F<br />
 (Corresponds to: Monthly, 1 volume per year, 12 issues per volume)<br />
 Q4FM<br />
 (Corresponds to: Quarterly, four issues represented by month names, no volume numbering)<br />
 B6F+<br />
 (Corresponds to: Bimonthly, six issues per year with continuous numbering, no volume numbering)";

//field v900
$BVS_LANG["helpNotesMask"] = "Enter a descriptive text explaining further the meaning of all codes
used in the mask, such as: frequency, number of volumes per year, etc.<br />
<br />
Example:<br />
<br />
Bi-montly: 2 volumes per year, 3 issues per volume.";

//field v860
$BVS_LANG["helpVolume"] = "Fill in this field if the Mask contains a volume code.<br />
<br />
The code indicates to the System whether the sequence of the volumes of a serial is continuous (Infinite) or is reset each year (Finite).<br />
<br />
Example:<br />
Serial published quarterly with 2 volumes per year and the numbering of volumes changes every year:<br />
Sequency of volumes: Infinite<br />
<br />
Volume<br />
 1<br />
 1<br />
 2<br />
 2<br />
Sequency of volumes: Infinite";

//field v880
$BVS_LANG["helpNumber"] = "Fill in this field if the Mask contains an issue code.<br />
This code identifies the sequence of issues and informs the system whether the numbering increases continuously (Infinite) or is reset cyclically (Finite) for each volume or year. <br />
Example:<br />
Quarterly, 1 volume per year, 4 issues per volume. Issue numbering is reset annually.<br />
Numbering sequence: Finite<BR />
 Issue<br />
  1<br />
  2<br />
  3<br />
  4<br />";


/****************************************************************************************************/
/***************** Issues Section - Field Help messages   ****************************/
/****************************************************************************************************/

//field v911
$BVS_LANG["helpFacicYear"] = "Year of publication of the issue being entered.<br />
Use Arabic numerals, not Roman.<br />
Enter periods of two or more years corresponding to the same volume separated by slash (/),
using four digits for the first and two digits for the last year.<br /> <br />

For publications suspended for a period of two or more years, enter first and last year separated by slash as above, and select SUSPENDED in the STATUS OF THE ISSUE field.<br />
<br /> <br />
Examples:<br />
a) YEAR<br />
   1981<br />
<br />
b) YEAR         STATUS<br />
   1982/84      Suspended <br />";

//field v912
$BVS_LANG["helperDonorNotes"] = "Number and/or letters or words identifying the volume
of the issue being described. Use Arabic numerals, not Roman. If the identification contains alphabetic characters, enter them as well.<br />
<br />
When two or more volumes are published in the same physical binding, enter first and last volume separated by a slash.<br />
<br />
For volumes not published in a given year, enter volume numbers as above, and select NOT PUBLISHED in the STATUS OF THE ISSUE field.<br />
Information about volumes not published should be entered only if confirmed by the publisher.<br />
<br />
Examples:<br />
a) VOLUME    123<br />
b) VOLUME    123A<br />
c) VOLUME    1/2<br />
d) VOLUME    5/7<br />
<br />
e) YEAR, VOLUME, STATUS OF THE ISSUE<br />
   1981, 1, Present<br />
   1982, 2, Not present<br />
   1983, 3, Not published<br />";

//field v913
$BVS_LANG["helpFacicName"] = "Number and/or words or letters which identify the issue being entered.<br />
Use Arabic numerals, not Roman. If the id. contains letters, enter them as well.<br />
For cummulative indexes, in the YEAR field enter the years which they cover. The same applies for the VOLUME field.<br />
For editions which include two or more issues in the same physical binding, enter the first and last issue separated by a slash.<br />
For issues not published, select NOT PUBLISHED in the Publication Status field.<br />
Enter issues identified by months in the corresponding language according to their frequency.<br />
<br />
Examples:<br />
a) ISSUE     1<br />
b) ISSUE     B<br />
b) ISSUE     aug<br />
c) ISSUE     Spring";
	 
//field v910
$BVS_LANG["helpFacicMask"] = "Select the mask representing the frequency of the serial in the year in which the
issue being described was published. <br />
<br />
Example: M1V12F<br />";

//field v916
$BVS_LANG["helpFacicPubType"] = "Information about the type of issue, when different from the standard edition.<br />
<br />
Select the appropiate category. <br />
The categories are:<br />
S – Supplement<br />
PT – Issues with subdivisions<br />
NE – Special, commemorative or extra issue<br />
IN – Index<br />
AN – Yearbook<br />
BI – Supplement identified by bis<br />
E – Electronic issue<br />
<br />
When these cases do not contain issue numbering, enter only the corresponding convention.<br />
<br />
Examples:<br />
<br />
a) Special issue<br />
b) Yearbook<br />";

//field v914
$BVS_LANG["helpPubEst"] = "Status of the issue, meaning presence/absence of the issue
in the library holdings.<br />
 Select the appropriate category: <br />
<br />
P – Present – Exists in the library holdings<br />
A – Absent – Does not exist in the library holdings<br />
N – Not published – Confirmed by publisher that the issue was not published<br />
I – Interrupted – Issuing suspended for a certain period<br />
Examples:<br />
<br />
a) <br />
YEAR VOLUME ISSUE P/A<br />
1981    1     1    P<br />
1981    1     2    A<br />
1981    1     3    P<br />
<br />
b) <br />
YEAR VOLUME ISSUE P/A<br />
1980    1     2    P<br />
1981    2     1    N<br />
1981    2     2    P<br />
1982/83            I<br />
1984    3     1    P";

//field v915
$BVS_LANG["helpQtd"] = "Number of copies (in holdings) of the issue being entered.<br />
<br />
Examples:<br />
a)<br />
YEAR     VOLUME    ISSUE       P/A       QTY<br />
1985      53          1         P         1<br />
1985      53          2         P         2<br />
1985      53          3         P         2<br />
1985      53          4         P         2";

//field v925
$BVS_LANG["helptextualDesignation"] = "Heading textual and/or specific designation.";

//field v926
$BVS_LANG["helpstandardizedDate"] = "Standard date.";

//field v917
$BVS_LANG["helpInventoryNumber"] = "Enter a unique accession number (also called inventory number or barcode number) for this issue.";

//field v918
$BVS_LANG["helpEAddress"] = "URL of this issue, if accessible online.";

//field v900
$BVS_LANG["helpFacicNote"] = "Notes about the issue.<br />
Enter relevant information about any aspect of the issue being registered.<br />
Example: Issue very damaged and improper for photocopies; another copy has been requested.";


/****************************************************************************************************/
/***************** Users Administration Section - Field Help messages ****************************************/
/****************************************************************************************************/

//field v1
$BVS_LANG["helpUser"] = "Username for logging in to the SeCS-Web module.<br />";

//field v3
$BVS_LANG["helpPassword"] = "Password used for logging in to the SeCS-Web module.<br />";

//data not recorded
$BVS_LANG["helpcPassword"] = "Retype password";

//field v4   
$BVS_LANG["helpRole"] = "Enter user role.<br />
<br />
Example: Administrator, Editor, Operator";

//field v8
$BVS_LANG["helpFullname"] = "Enter user&#180;s full name.<br />
<br />
Example: <br />
Ernesto Luis Spinak";

//field v11
$BVS_LANG["helpEmail"] = "Enter user&#180;s e-mail address.<br />
<br />
Example: <br />
ernesto.spinak@bireme.org";

//field v9
$BVS_LANG["helpInstitution"] = "Enter name of institution.<br />
<br />
Examples: BIREME - PAHO/WHO - Latin-American and Caribbean Center on Health Sciences Information";

//field v5
$BVS_LANG["helpCenterCod"] = "Center Code<br />";

//field v10
$BVS_LANG["helpNotes"] = "Enter relevant notes about the user.<br />
<br />
Examples:<br />
Editor of City Library.<br />
SeCS-Web standard editor user.";

//field v12
$BVS_LANG["helpLang"] = "Select preferred interface language for this user.<br />
<br />
Example: English";

//field v2
$BVS_LANG["helpUsersAcr"] = "Enter user initials or equivalent acronym<br />
Examples: ELS";


/****************************************************************************************************/
/***************** Title Plus Section - Field Help messages ****************************************/
/****************************************************************************************************/

//field v901
$BVS_LANG["helperAcquisitionMethod"] = "Acquisition Method.<br />
Select method as appropiate.
<br />
Examples: Paid<br />
Gift<br />
Exchange<br />
Other";

//field v902
$BVS_LANG["helperAcquisitionControl"] = "Indication of the publication status. <br />
Select the option corresponding to the current status of this serial:<br />
Unknown:<br />
Current:<br />
Not current<br />
Closed<br />
Suspended";

//field v906
$BVS_LANG["helperExpirationSubs"] = "Use the attached calendar to pick the expiry date of the current subscription.<br />The date will be recorded in standard ISO format.<br />
After renewing the subscription, you must remember to enter the new expiry date in this field.";

//field v946
$BVS_LANG["helperacquisitionPriority"] = "Numeric code defining the acquisition priority
of the serial for the institution.<br />
In order to establish priorities of acquisition, consult if necessary your Library Committee, members of the academic community or other experts.<br />.<br />

Select the appropriate priority from the picklist, and the system will enter a numerical code:<br />
1 - Title is essential for the center.<br />
2 - Title is not essential for the center, because it exists in the country.<br />
3 - Title is not essential for the center, because it exists in the Region.<br />";

//field v911
$BVS_LANG["helperAdmNotes"] = "Enter here any relevant notes about this serial. Enter multiple notes on separate lines. <br /> <br />
Example: The subscription was interrupted in 2009.";

//field v905
$BVS_LANG["helperProvider"] = "Enter name of Vendor/Provider (commercial or not) for this subscription. If you don&#180;t keep a separate vendor database, add contact data and other notes in the VendorProvider Note field below.
<br />
If the Acquisition Method is Gift subscription, enter in field 912 details about conditions for the gift.";

//field v904
$BVS_LANG["helperProviderNotes"] = "Vendor/Provider Notes. Enter here any relevant information about the supplier of this serial.";

//field v903
$BVS_LANG["helperReceivedExchange"] = "Enter title of the serial you send in exchange for the current title.<br />
This field is mandatory if the Acquisition Method is Exchange.";

//field v912
$BVS_LANG["helperDonorNotes"] = "Used for gift subscriptions and subscriptions paid by external project funds or donations with conditions attached.<br />
Enter notes about the conditions of the gift or donation. <br />
This field is mandatory if the Acquisition Method is Gift.<br /><br />
Examples: <br />
a) Paid with USAID funds from project 2009/CL/Y35 <br />
b) The serial is to be kept separate from the general collection with a label indicating the name of the donor foundation. <br />
c) Free trial subscription for 2009 only.";

//field v913
$BVS_LANG["helperAcquisitionHistory"] = "Information regarding historical signatures, the amount paid by the signature, details
fascicles which includes the purchase. Subfields that compose
the data field: <br/>
(D) Date of payment of subscription <br/>
(V) Amount paid by the signature <br/>
(A) Year that includes the signature <br/>
(F) issues that includes the signature <br/>";//traduzir

$BVS_LANG["helperAcquisitionHistoryD"] = "Date of payment of subscription.";
$BVS_LANG["helperAcquisitionHistoryV"] = "Amount paid by the signature.";
$BVS_LANG["helperAcquisitionHistoryA"] = "Year that includes the signature.";
$BVS_LANG["helperAcquisitionHistoryF"] = "Issues that includes the signature.";

//field v907
$BVS_LANG["helperLocationRoom"] = "Enter the call number for the serial indicating its placement in the collection. <br />In large libraries, it may be convenient to construct call numbers  that include codes for room, section and shelf, in addition to the call number proper. <br /> <br />
Examples: <br />
a) Call number: 0557<br />
b) Call number: R2-S3-0557";

//field v908
$BVS_LANG["helperEstMap"] = "Enter the name of the graphic file containing a shelf map that shows where the serial is located.<br />
Example: RoomA1-ModuleB3.jpg ";

//field v909
$BVS_LANG["helperOwnClassif"] = "Enter classification code as used by your Center.<br />
If more than one classification code, make separate entries as needed.";

//field v910
$BVS_LANG["helperOwnDesc"] = "Enter subject headings or descriptors as used by your Center. <br />
If more than one descriptor, make separate entries as needed. <br />";



/****************************************************************************************************/
/***************** Title Section - Field Help messages ****************************************/
/****************************************************************************************************/
/*
/* This Section is divided into seven parts which correspond to the seven steps
/* in the Titles data entry form of the SeCS-web module.
/*

/***************** Step 1  ****************************************/


//field v30
$BVS_LANG["helperrecordIdentification"] = "Autofill field.<br />
Sequential number assigned and controlled by the System to identify the serial titles in the database.<br />
Enter the ID number assigned to the title you are describing.<br />
This field is used by the system to link the title record to its holdings.<br />
Examples:<br />
a) ID number: 1050<br />
b) ID number: 415";

//field v100
$BVS_LANG["helperpublicationTitle"] = "Mandatory field.<br />
Main Title or Title proper of serial in the language and format it appears, including alternative title if there is one, but excluding parallel titles and other title information.<br />
Enter Title proper transcribing all elements in the order they appear on title page or substitute, following
the spelling rules of the corresponding language.<br />
See basic entry rules in the Appendix to the <a href=javascript:showISBD(\'en\');>SeCS-Web Manual and the ISBD consolidated edition 2007</a>.<br />
Homonymous titles need a qualificator to distinguish them (language, city, year, etc.) <br /><br />
Examples:<br />
a) Serial Title: Revista chilena de neurocirugía<br />
b) Serial Title: Revista brasileira de saúde ocupacional<br />
c) Serial Title: Pediatria (São Paulo)<br />
d) Serial Title: Pediatría (Bogotá)<br />";

//field v140
$BVS_LANG["helpernameOfIssuingBody"] = "Body responsible for the intellectual content of the serial.<br />
Enter statement of responsibility as presented on title page or substitute. <br />
When a statement of responsibility includes a hierarchy, transcribe it in the order it appears in the serial, separated by commas. <br />
When a statement of responsibility, in its extended form, is an integrated part of the title proper (field 100) it is not necessary to repeat it here. <br />
See basic entry rules in <a href=javascript:showISBD(\'en\');>normas ISBD - consolidated edition 2007</a>. <br /><br />
This field is mandatory for serials with generic titles, such as: Bulletin, Yearbook, Review, etc. and corresponding
terms in other languages.<br />
In case of more than one statement of responsibility, make separate entries for each.<br />
Examples:<br />
a) Statement of responsibility: Academia Nacional de Medicina<br />
b) Statement of responsibility: Sociedade Brasileira de Cardiologia";

//field v149
$BVS_LANG["helperkeyTitle"] = "Key Title as assigned by the ISSN network together with the ISSN.
A key title can be identical to the title proper if the latter is unique.
If two titles are identical, unique key titles are constructed adding qualifiers
or identification elements such as Publisher, Place of publication, Edition, etc.<br />
Examples: <br />
ISSN 0340-0352 = IFLA journal<br />
ISSN 0268-9707 = British Library Bibliographic Services newsletter<br />
ISSN 0319-3012 = Image (Nicaragua ed.)";

//field v150
$BVS_LANG["helperabbreviatedTitle"] = "Abbreviated Key title.<br />
Enter abbreviated Key title including upper/lowercase convention and diacriticals as of
ISO 4-1984 standard and List of serial title word abbreviations.<br />
Examples:<br />
a)Serial Title: Revista brasileira de sa&#250;de ocupacional<br />
  Abbreviated Title: Rev. bras. sa&#250;de ocup.<br />
b)Serial Title: Endeavour (Spanish ed.)<br />
  Abbreviated Title: Endeavour (Span. ed.)<br />
c)Serial Title: : Pediatria (S&#227;o Paulo)<br />
  Abbreviated Title: Pediatria (S&#227;o Paulo)";

//field v180   
$BVS_LANG["helperabbreviatedTitleMedline"] = "Abbreviated Title for other databases.<br />
For retrieval and export purposes, add variant abbreviations used in  databases you collaborate with. <br />
Click the Subfield button to add Database code and abbreviated title.<br />
If more than one database, make separate entries for each.<br /> <br />

Example: for REVISTA BRASILEIRA DE ENTOMOLOGIA<br />
Databases: <br />
ISO^aRev. Bras. Entomol.
JCR^aREV BRAS ENTOMOL
MDL^aRev Bras Entomol
LL^aRev. bras. entomol.
LATINDEX^aRev. Bras. Entomol. (Impr.)
SciELO^aRev. Bras. entomol.";


/***************** Step 2  ****************************************/

//field v110
$BVS_LANG["helpersubtitle"] = "Subtitle. Information subordinated to Title proper which completes it,
qualifies it or makes it more explicit.<br />
Enter in this field information defined as subtitle only if valuable for the
identification of the serial.  <br />
For variant titles use the field &#180;Other forms of title&#180;.<br />
Examples:<br />
a) Serial Title: MMWR<br />
   SubTitle:     Morbidity and mortality weekly report";

//field v120
$BVS_LANG["helpersectionPart"] = "Alphabetical or numerical designation of section or part,
which completes the Title proper and depends on it for identification or understanding.<br />
Enter the term Series, Section, Part or equivalent only if it is a part of the title.<br />
Capitalise first letter of significant term.<br />
Examples:<br />
a) Serial Title: Bulletin signaletique<br />
   Section/part: Section 330<br />
b) Serial Title: Acta pathologica et microbiologica scandinavica<br />
   Section/part: Section A";

//field v130
$BVS_LANG["helpertitleOfSectionPart"] = "Title of section, part or supplement that completes and depends on
the Title proper for identification or understanding.<br />
Transcribe name of section, part or supplement as it appears on title page or substitute. Capitalise first letter.<br />
In the case of supplements with title identical to main title, and which constitute a new title record, enter in this field
the word &#180;Supplement&#180; to distinguish titles from one another.<br />
Examples:<br />
a) Serial Title: Acta amazonica<br />
   Title section/part: Suplemento<br />
b) Serial Title:  Bulletin signaletique<br />
   Section/part: Section 330<br />
   Title section/part: Sciences pharmacologiques";

//field v230
$BVS_LANG["helperparallelTitle"] = "Title proper of serial which also appears in other languages on titlepage or substitute.<br />
Enter parallel titles in the same sequence and form as they appear on title page or substitute, following
<a href=javascript:showISBD(\'en\');> ISBD rules -
consolidated edition 2007</a>.<br />
If more than one parallel title, make a separate entry for each.<br />
If the serial has parallel titles that include section, part or supplement in other languages, enter them sequentially
separating elements with periods (Common title. Title of section, part or supplement).<br />
In case of more than one parallel title, make separate entries clicking on the INSERT button. <br /> <br />
Examples:<br />
a) Serial Title: Archives of toxicology<br />
   Parallel title: Archiv fur Toxikologie<br />
b) Serial Title: Arzneimittel Forschung<br />
   Parallel title: Drug research";

//field v240
$BVS_LANG["helperotherTitle"] = "Variants of title proper appearing in the serial, such as: Title of cover, when different
from title page, expanded Title and other forms of Title.<br />
Include here (minor) variants of title which do not need a new record but are justified for retrieval purposes.<br />
In case of more than one variant, make a separate entry for each.<br />
Examples:<br />
a) Serial title: Boletin de la Academia Nacional de Medicina de Buenos Aires<br />
   Other forms of Title: Boletin de la Academia de Medicina de Buenos Aires<br />
b) Serial title: Folha médica<br />
   Other forms of Title: FM: a folha médica";

//field v510
$BVS_LANG["helpertitleHasOtherLanguageEditions"] = "This field links the title being described with its editions in other languages.<br />
Enter the serial title in the other language as it appears, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one edition in other language, make a separate entry for each.<br />
Examples:<br />
a) Serial title: Materia medica polona (English ed.)^x0025-5246
    Has edition in other language: Materia medica polona (Ed. Française)^x0324-8933
b) Serial title: : World health^x0043-8502
   Has edition in other language: <br />
Salud mundial^x0250-9318 <br />
Saúde do mundo^x0250-930X<br />
Santé du monde^x0250-9326";

//field v520
$BVS_LANG["helpertitleAnotherLanguageEdition"] = "This field links the title being described with editions in other languages.<br />
Enter the serial title in other language as it appears, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one edition in other language, make a separate entry for each.<br />
Examples:<br />
a) Serial title: Materia medica polona (Ed. fran&#231;aise)^x0324-8933<br />
   Is edition in other language of: Materia medica polona (English ed.)^x0025-5246<br />
b) Serial title: Salud mundial^x0250-9318<br />
   Is edition in other language of: World health^x0043-8502";

//field v530
$BVS_LANG["helpertitleHasSubseries"] = "This field links the title being described with its subseries (serials
with separate title and numbering published as part of a broader series).<br />
Enter the title of the subseries as it appears, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one subseries, make a separate entry for each.<br />
Examples:<br />
a) Serial title: Biochimica et biophysica acta^x0006-3002<br />
   Has subseries: Biochimica et biophysica acta. Biomembranes^x0005-2736";

//field v540
$BVS_LANG["helpertitleIsSubseriesOf"] = "This field links the title being described with its common (broader) title.<br />
Enter the title of the series to which this subseries belongs, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
Examples:<br />
a) Serial title: Biochimica et biophysica acta^x0924-1086<br />
Title of section/part:  Enzymology<br />
Is subseries of: Biochimica et biophysica acta^x0006-3002";

//field v550
$BVS_LANG["helpertitleHasSupplementInsert"] = "This field links the title being described with its supplements or
inserts (titles generally published with separate numbering, complementing the main Title)<br />
Enter the title of the supplement/insert, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one supplement/insert, make a separate entry for each.<br />
<br />
Examples:<br />
a)Serial title: Scandinavian journal of plastic and reconstructive surgery<br />
  Has supplement/insert: Scandinavian journal of plastic and reconstructive surgery. Supplement<br />
b) Serial title: Tubercle^x0041-3879;<br />
   Has supplement/insert: BTTA review^x0300-9602<br />";
   

//field v560
$BVS_LANG["helpertitleIsSupplementInsertOf"] = "This field links the title being described with its parent title.<br />
Enter the parent title for the supplement/insert, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>. <br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one supplement/insert, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Scandinavian journal of plastic and reconstructive surgery^x0581-9474<br />
Title of section/part: Supplement<br />
Is supplement/insert of: Scandinavian journal of plastic and reconstructive surgery^x0036-5556<br />
b) Serial title: BTTA review^x0300-9602a<br />
Is supplement/insert of: Tubercle^x0041-3879";



/***************** Step 3  ****************************************/

//field v610
$BVS_LANG["helpertitleContinuationOf"] = "This field links the title being described with its earlier
(previous) titles<br />
Enter earlier title of this serial, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one earlier title, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Revista argentina de urolog&#237;a y nefrolog&#237;a^x0048-7627<br />
Continuation of: Revista argentina de urolog&#237;a^x0325-2531<br />
b) Serial title: Revista de la Asociaci�n M&#233;dica Argentina^x0004-4830<br />
Continuation of: Revista de la Sociedad M&#233;dica Argentina^x0327-1633";

//field v620
$BVS_LANG["helpertitlePartialContinuationOf"] = "This field links the title being described with the title it is
a partial continuation of.<br />
Enter previous title of this serial, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one previous title, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Comptes rendus hebdomadaires de seances de l&#180;Academie des Sciences^x0567-655X<br />
Section/Part: Serie D<br />
Title of section/part: Sciences naturelles<br />
Partial continuation of: Comptes rendus hebdomadaires de seances de l&#180;Academie of Sciences^x0001-4036";

//field v650
$BVS_LANG["helpertitleAbsorbed"] = "This field links the title being described with title(s) it has absorbed.<br />
Enter title of absorbed serial, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one absorbed serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Revista brasileira de oftalmologia^x0034-7280<br />
Has absorbed: Boletim da Sociedade Brasileira de Oftalmologia^x0583-7820";

//field v660
$BVS_LANG["helpertitleAbsorbedInPart"] = "This field links the title being described with title(s) it has
partially absorbed.<br />
Enter title of partially absorbed serial, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one partially absorbed serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Journal of pharmacology and experimental therapeutics^x0022-3565<br />
Has partially absorbed: Pharmacological reviews^x0031-6997";

//field v670
$BVS_LANG["helpertitleFormedByTheSplittingOf"] = "This field links the title being described with titles from which
it originated by splitting<br />
Enter title of previous serial(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />.
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one previous serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Acta neurologica belgica^x0300-9009<br />
Created by the splitting of: Acta neurologica et psychiatrica belgica^x0001-6284";

//field v680
$BVS_LANG["helpertitleMergeOfWith"] = "This field links the title being described with titles which have merged
to create it.<br />
Enter title of merged serials, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
Make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Revista de psiquiatria din&#226;mica^x0034-8767<br />
Merger of... with...: Arquivos da cl&#237;nica Pinel^x0518-7311<br /> Psiquiatria (Porto Alegre)^x0552-4377<br />
b) Serial title: Gerontology^x0304-434X<br />
Merger of... with...: Gerontolog&#237;a Cl&#237;nica^x0016-8998<br /> Gerontologia^x0016-898X";

//field v710
$BVS_LANG["helpertitleContinuedBy"] = "This field links the title being described with its later title(s).<br />
Enter later title(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one later title, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Anais da Faculdade de Farmacia e Odontologia da Universidade
de S&#227;o Paulo^x0365-2181<br />
Continued by: Revista da Faculdade de Odontologia da Universidade de S&#227;o Paulo^x0581-6866";

//field v720
$BVS_LANG["helpertitleContinuedInPartBy"] = "This field links the title being described with its partial continuation(s).<br />
Enter title of later serial(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one later serial, make a separate entry for each.<br />
<br />
Examples:<br />
a)Serial title: Annales de mibrobiologie^x0300-5410<br />
Continued in part by: Annales de virologie^x0242-5017<br />
b) Serial title: Journal of clinical psychology^x0021-9762<br />
Continued in part by:  Journal of community psychology^x0090-4392";

//field v750
$BVS_LANG["helpertitleAbsorbedBy"] = "This field links the title being described with the title(s)it
was absorbed by.<br />
Enter title of absorbing serial(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one absorbing serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Boletim da Sociedade Brasileira de Oftalmologia^x0583-7820<br />
Absorbed  by: Revista brasileira de oftalmologia^x0034-7280";

//field v760
$BVS_LANG["helpertitleAbsorbedInPartBy"] = "This field links the title being described with the title(s)it was
partially absorbed by.<br />
Enter title of later serial(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one absorbing serial, make a separate entry for each.<br />
<br />
Examples:<br />
a)Serial title: Health and social service journal^x0300-8347<br />
Partially absorbed by:  Community medicine^x0300-5917";

//field v770
$BVS_LANG["helpertitleSplitInto"] = "This field links the title being described with the title(s) it has split into.<br />
Enter title of later serial(s), following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one later serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Acta neurologica et psychiatrica belgica^x0001-6284<br />
Has split into:<br />
Acta neurologica belgica^x0300-9009<br />
Acta psychiatrica belgica^x0300-8967";

//field v780
$BVS_LANG["helpertitleMergedWith"] = "This field links the title being described with the title(s) it has merged with.<br />
Enter title of serial(s) merged with, following <a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one merging serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Anais da Faculdade de Farmacia e Odontologia da Universidade de
S&#227;o Paulo^x0365-2181<br />
b) Merged with:<br />
Estomatologia e cultura^x0014-1364<br />
Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X";

//field v790
$BVS_LANG["helpertitleToForm"] = "This field links the title being described with the title resulting
from the merger.<br />
Enter title of serial resulting from the merger of titles recorded in the <b>Merged with</b> field, following
<a href=javascript:showISBD(\'en\');>ISBD rules - consolidated edition 2007</a>.<br />
Click the Subfield button, and enter the title and the ISSN in the emerging worksheet. <br />
(In the database, the subfield for ISSN is ^x and will be added automatically).<br />
If more than one resulting serial, make a separate entry for each.<br />
<br />
Examples:<br />
a) Serial title: Anais da Faculdade de Farmacia e Odontologia da Universidade de
S&#227;o Paulo^x0365-2181<br />
b) Merged with: Estomatologia e cultura^x0014-1364<br />
Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X<br />
<b>To form: Revista de odontologia da Universidade de S&#227;o Paulo^x0103-0663</b><br />
b) Serial title: Psiquiatria (Porto Alegre)^x0552-4377<br />
Merged with:  Arquivos da cl&#237;nica Pinel^x0518-7311<br />
<b>To form: Revista de psiquiatria din&#226;mica^x0034-8767</b>";


/***************** Step 4  ****************************************/

//field v480
$BVS_LANG["helperpublisher"] = "Name of publisher.<br />
Enter name of publishing agency as it appears in the serial.<br />
If the publisher is the same as statement of responsibility, it is not necessary to repeat the neme here,
except when necessary for acquisition purposes.
In case of more than one publisher, enter the first mentioned or the one that coincides with publishing place.<br />
Examples:<br />
a) Publisher: Pergamon Press<br />
b) Publisher: Plenum Press";

//field v490
$BVS_LANG["helperplace"] = "Place of publication (city) of the serial being described.<br />
Enter name of city in the language it appears in the serial.<br />
If title appears in more than one language, enter city name in the language of title proper.<br />
If place of publication cannot be determined, enter the abbreviation s.l (sine locus).<br />
Examples:<br />
a) Place of publication: S&#227;o Paulo<br />
b) Place of publication: Porto Alegre<br />
c) Place of publication: s.l";

//field v310
$BVS_LANG["helpercountry"] = "Country code of serial being described.<br />
Select country from picklist provided. The field will be filled in with the corresponding country code.<br />
Examples:<br />
a) Country of publication: Brasil<br />
b) Country of publication: Chile";

//field v320
$BVS_LANG["helperstate"] = "State code for the place of publication of the serial being described.<br />
This field is mandatory for Brazilian publications (in the VHL environment) and optional for other federated
countries.<br />
Select the state from picklist provided. The field will be filled in with the corresponding state code.<br />
Examples:<br />
a) State: Cear&#225;<br />
b) State: Minas Gerais";

//field v400
$BVS_LANG["helperissn"] = "Unique ISSN number attributed to the serial title by the International Serials Data System (ISDS).<br />
Enter the complete ISSN code, including hyphen.<br />
Click the Subfield button, and enter the ISSN and media type in the emerging worksheet. <br />
(In the database, the subfield indicator will be added automatically).<br />
When more than one ISSN number, make separate entries for each. <br />
<br />
Example: Plant varieties journal (Ottawa)<br />
ISSN-L 1188-1534 <br />
1188-1534^aprinted  <br />
1911-1479^lonline  <br />
1911-1460^lcdrom    <br />
0273-1134^zcancelled <br />";

//field v410
$BVS_LANG["helpercoden"] = "Code attributed to the serial title by the Chemical Abstracts Service (CAS) .<br />
Enter Coden in the form it appears on the serial.<br />
Examples:<br />
a) CODEN: FOMEAN<br />
b) CODEN: RCPDAF";

//field v50
$BVS_LANG["helperpublicationStatus"] = "Mandatory field. Select status of publication as Current when currently published,
Ceased/Suspended or Unknown.<br />

Example:<br />
Publication status: Current<br />";

//field v301
$BVS_LANG["helperinitialDate"] = "Year and month first issued.<br />
Enter initial publication date using standard abbreviations for months in the language
of the title proper.<br />
Month is optional. When used, month precedes year.<br />
If impossible to determine exact year first issued, enter year in the following form:<br />
1983 Known date.<br />
?983 Probable date.<br />
198? Uncertain date.<br />
19?? Uncertain decade.<br />
1??? Uncertain century.<br />
Examples:<br />
a) First issued: jan./mar. 1974<br />
b) First issued: 1987<br />
c) First issued: sep. 1988";

//field v302
$BVS_LANG["helperinitialVolume"] = "First volume issued.<br />
Enter volume number in Arabic numerals, not Roman.<br />
Omit this information if uncertain.<br />
Examples:<br />
a) First volume: 1<br />
b) First volume: 4";

//field v303
$BVS_LANG["helperinitialNumber"] = "Number of first issue of serial described.<br />
Enter issue number in Arabic numbers.<br />
Examples:<br />
a) Initial issue: 1<br />
b) Initial issue: 2";

//field v304
$BVS_LANG["helperfinalDate"] = "Year and month last issued.<br />
Enter final publication date using standard abbreviations for months in the language of the title proper.<br />
Month is optional. When used, month precedes year.<br />
Examples:<br />
a) Final issue: oct. 1984<br />
b) Final issue: 1988";

//field v305
$BVS_LANG["helperfinalVolume"] = "Final volume issued.<br />
Enter volume number in Arabic numerals, not Roman.<br />
Examples:<br />
a) Final volume: 10<br />
b) Final volume: 12 ";

//field v306
$BVS_LANG["helperfinalNumber"] = "Number of final issue of serial described.<br />
Enter issue number in Arabic numerals.<br />
Examples:<br />
a) Final issue: 7<br />
b) Final issue: 10";

//field v380
$BVS_LANG["helperfrequency"] = "Code identifying the publication frequency.<br />
Select the frequency from the picklist. The correponding one-letter code will be entered in the field.<br />
Examples:<br />
a) Current frequency: Weekly<br />
b) Current frequency: Quarterly";

//field v330
$BVS_LANG["helperpublicationLevel"] = "Category defining the intellectual level of the serial.<br />
Select one of the following:<br />
<b>Scientific/technical</b>: for serials including articles based on scientific research or the signed opinion of
experts (including clinical studies).<br />
<b>Outreach</b>: for serials including mostly unsigned articles, information notes, etc.<br /> ";

//field v340
$BVS_LANG["helperalphabetTitle"] = "Code identifying the alphabet used in the title.<br />
Select alphabets from picklist:<br />
Basic Roman: for Anglo-Saxon and Roman languages without diacriticals, such as:<br />
    English, Croatian, Latin<br />
Extended Roman: for Anglo-Saxon and Roman languages with diacriticals, such as:<br />
    Portuguese, German, French, Spanish, Italian.<br />
Cyrillic: for Slavic languages, such as:<br />
    Russian, Bulgarian, Czech,Ucrainian, Serbian, etc.<br />
Japanese<br />
Chinese<br />
Korean<br />
etc...<br />
Other<br /> <br />
Examples:<br />
a) Alphabet of title: Extended Roman<br />
b) Alphabet of title: Tamil";

//field v350
$BVS_LANG["helperlanguageText"] = "Code identifying the language used in the text of the serial,
following ISO standard 639:1988.<br />
Select language from picklist provided. The field will be filled in with the corresponding language code.<br />
If text of serial has more than one language, make a separate entry for each.<br />
Examples:<br />
a) Language of text: Portuguese<br />
b) Language of text: English<br />Spanish<br />";

//field v360
$BVS_LANG["helperlanguageAbstract"] = "Code identifying the language used in the abstracts of the serial.<br />
Select language from picklist provided. The field will be filled in with the corresponding language code.<br />
If more than one language, make a separate entry for each.<br />
Examples:<br />
a) Language of abstracts: Portuguese<br />
b) Language of abstracts: <br />English<br />Spanish<br />";


/***************** Step 5  ****************************************/

//field v40
$BVS_LANG["helperrelatedSystems"] = "Code identifying the system(s) to which the current record should be transferred.<br />
This field is mandatory for centers providing inputs to BIREME&#180;s &#180;Register of Serials in Health Sciences&#180;
and for titles indexed in LILACS and/or MEDLINE.<br />
The field is used by the system to generate the holdings data to be sent to BIREME.<br />
Enter the SeCS ID or other system code of the system the record should be sent to.<br />
If more than one system, make a separate entry for each.<br />
Examples:<br />
a) Related systems: SECS<br />
b) Related systems: CAPSALC<br />
c) Related systems: <br />SECS<br />CAPSALC";

//field v20
$BVS_LANG["helpernationalCodeo"] = "Code identifying the title in a national serials title control system
(or equivalent) to facilitate data transfer to such systems.<br />
Enter the national serial code as given by the body responsible for the national system, or equivalent.<br />
 Examples:<br />
 a) National code: 001060-X (SIPS number in the National Collective Catalog of Brasil)<br />
 b) National code: 00043/93";

//field v37
$BVS_LANG["helpersecsIdentification"] = "Title identification number in BIREME&#180;s &#180;Register of Serials in Health Sciences&#180;<br />
Enter the ID number provided by BIREME for this title.<br />
This field is mandatory for cataloguing agencies providing holdings data to BIREME<br />
The field is used by the system to generate the holdings data to be sent to BIREME.<br />
If the title is included in SECS in the &#180;Related systems&#180; field, this field should also be used.<br />
Examples:<br />
a) SECS number: 2<br />
b) SECS number: 4";


//field v430
$BVS_LANG["helperclassification"] = "Subject classification in the system adopted by the cataloguing agency.<br />
Enter the class code of the local system.<br />
If more than one class code, make a separate entry for each.<br />
Examples:<br />
a) Classification:  WA^cNLM<br />
b) Classification:  WO200<br />QT34<br />
c) Classification:  ABCD1234^cJCR";

 //field v421
$BVS_LANG["helperclassificationCdu"] = "UDC (Universal Decimal Classification)<br />
Enter a UDC classification code for this serial.<br />
Examples: <br />
159.964.2 (for Psychê; psychoanalytical journal)<br />
61:57(05) (for Revista de ciências médicas e biológicas)";

//field v422
$BVS_LANG["helperclassificationDewey"] = "DDC (Dewey Decimal Classification) <br />
Enter a Dewey classification code for this serial.<br />
Example: <br />
610.05 (for Revista de ciências médicas e biológicas)";

//field v435
$BVS_LANG["helperthematicaArea"] = "Subject headings from the <strong>CNPq table</strong> developed by
the National Council of Technological and Scientific Development of Brasil. <br />
The CNPq system uses four levels: broadest term, general term, sub-area and specialty.";

//field v440
$BVS_LANG["helperdescriptors"] = "Controlled terms used to represent the main subject matter of the serial.<br />
Participants in the BIREME network should use descriptors extracted from DeCS (Descriptors in Health Sciences).<br />
If more than one descriptor, make a separate entry for each.<br />
Enter maximum 4 descriptors.<br />
Examples:<br />
a) Descriptors: OCCUPATIONAL MEDICINE<br />
b) Descriptors: <br />NEUROLOGY<br />PEDIATRICS<br />
c) Descriptors: NEUROLOGY<br />
d) Descriptors: GYNECOLOGY<br />OBSTETRICS";

//field v441
$BVS_LANG["helperotherDescriptors"] = "Subject descriptors, defined by the cataloging agency or extracted from
other thesauri, not contained in DeCS.";

//field v450
$BVS_LANG["helperindexingCoverage"] = "Code identifying secondary information sources that index
the serial being described.<br />
Enter the code of the indexing source, followed by initial and final year, volume and issue covered.<br />
If more than one indexing source, make a separate entry for each.<br /> <br />
<br />
Examples: for Revista do Hospital das Clínicas <br />
IM^a1965^b20^c4^d2004^e59^f6
LL^a1981^b36^c1^d2004^e59^f6
SciELO^a1999^b54^c1^d2004^e59^f6";

//field v450^a
$BVS_LANG["helperindexingCoverageA"] = "register the initial date on which the paper began to be indexed on the source of reference";
//field v450^b
$BVS_LANG["helperindexingCoverageB"] = "register the initial volume in which the paper began to be indexed on the source of reference";
//field v450^c
$BVS_LANG["helperindexingCoverageC"] = "register the initial issue in which the paper began to be indexed on the source of reference";
//field v450^d
$BVS_LANG["helperindexingCoverageD"] = "register the final date on which the journal ceased to be indexed on the source of reference";
//field v450^e
$BVS_LANG["helperindexingCoverageE"] = "register the final volume in the journal ceased to be indexed on the source of reference";
//field v450^f
$BVS_LANG["helperindexingCoverageF"] = "register the final installment in the journal ceased to be indexed on the source of reference";

//field v470
$BVS_LANG["helpermethodAcquisition"] = "Alphanumeric code identifying the acquisition method of this serial at the cataloguing agency.<br />
Enter a code combining the following elements:<br />
0 - Acquisition method unknown.<br />
1 - Purchase         A - Current<br />
2 - Exchange         B - Discontinued<br />
3 - Donation<br />
Examples:<br />
 a) Acquisition method: 1A  (purchase, current)<br />
 b) Acquisition method: 3B  (donation, discontinued)";

//field v900
$BVS_LANG["helpernotes"] = "Additional notes about any aspect of the serial, its appearance or content.<br />
Enter information relevant to the agency responsible for the description of the serial, in plain language.<br />
Enter additional notes sequentially.<br />
Examples:<br />
a) Notes: Publication interrupted between 1987-1976<br />
b) Notes: Volume 104 was not issued";

//field v455 
$BVS_LANG["helperCoveredSubjectDB"] = "Controlled main subject headings used in different BIREME databases. <br />
For participants exporting records to BIREME.<br />
This field has the format DBNAME ^a DESCRIPTOR1 ; DESCRIPTOR2 <br />
<br />
Example: (for the journal MEM&#211;RIAS DO INSTITUTO OSWALDO CRUZ) <br />
JCR^aPARASITOLOGY;TROPICAL MEDICINE
MDL^aPARASITOLOGY;TROPICAL MEDICINE
SciELO^aCIENCIAS BIOLOGICAS
LL^aMEDICINA TROPICAL";

//field v850 
$BVS_LANG["helperIndicators"] = "Statistical and bibliometric indicators for scientific journals.<br />
For use in the Bireme network.<br />
The field has subfields and follows the format: DBname ^a year ^v impact factor<br />
<br />
Examples:<br />
JCR^a2007^v0.765<br />
SciELO^a2007^v0.124";

/***************** Step 6  ****************************************/

//field v999

$BVS_LANG["helperurlPortal"] = "The information for the portal consist of a URL, provider, type
and access control and time.<br/><br/>

Just click the button Subfield next to the text box to open a
new window to fill the information under the name of
field.";

//field v999^a
$BVS_LANG["helpField999SubfieldA"] = "Access type – Field v999^a <br /> <br />Defines type of access to the serial articles, with the following options:<br /><strong>Free </strong> Free access to the corresponding pages. <br /><strong>Free for subscribers</strong><strong>Demands online subscription </strong> Subscription to the online version.<strong>Demands print subscription</strong> Subscription to the printed version.<strong>Demands online/print subscription </strong>Access allowed for online or print subscribers.";

//field v999^b
$BVS_LANG["helpField999SubfieldB"] = "URL – Field 999^b <br /> <br />The URL (Uniform Resource Locator) is the full Internet address of the serial. <br /> The browser communicates with the server through TCP/IP connection on port 80, using the HTTP protocol. <br /> <br />Example: http://www.bireme.br/php/index.php";

//field v999^c
$BVS_LANG["helpField999SubfieldC"] = "Aggregator/Supplier – Field 999^c <br /> <br />Aggregators are web portals that allow fulltext search and access in several databases. <br /> Access is by expensive paid subscriptions. They are usually available at academic/research institutions. <br />The main aggregators are OVID, EBSCO and PROQUEST. In Brasil the CAPES portal gives fulltext access to several journals through agreements with universities. <br /> <br />Examples: <br />CAPES-ScIELO <br />CAPES-OVID";

//field v999^d
$BVS_LANG["helpField999SubfieldD"] = "Access control – Field 999^d <br /> <br />The means to control that the resources are only accessed by logged in users. The options are:<br /> <br />Free <br />IP <br />Password <br />IP/Password";

//field v999^e
$BVS_LANG["helpField999SubfieldsEF"] = "Period – Field 999^e and 999^f <br /> <br />Initial and final year of access to the fulltext articles. <br /><br />Example: <br />1997 to 2009";

//field v999^g
$BVS_LANG["helpField999SubfieldG"] = "Complimentary years or sample issues - Field 999^g<br /><br />Enter information about other online access sources.<br /><br />EXEMPLO:<br />";

//field v999^h - this field is not in the system
$BVS_LANG["helpField999SubfieldH"] = "Tipo de Arquivo 999^h<br /><br />Se o arquivo &#233; um pdf, HTML etc ... <br /><br />EXEMPLO:<br />Acesso gratuito atrav&#233;s de cadastro de usu&#225;rio e senha;<br />Tamb&#233;m dispon&#237;vel em outro idioma (polon&#234;s);";


//field v860
$BVS_LANG["helperurlInformation"] = "Additional information about online access to the serial and its articles.<br /> <br />
Examples: <br />
Articles available for a charge<br />
Access to Table of Contents only";

//field v861 
$BVS_LANG["helperBanPeriod"] = "Ban or Embargo <br />Period of time in which the online version of the serial and/or its articles are not released to the general public.<br />
<br />
Example:<br />
Fulltext available online from january 1995, with 6 months embargo.";

/***************** Step 7  ****************************************/

//field v436
$BVS_LANG["helperspecialtyVHL"] = "VHL specialty. Specific VHL terminology used to facilitate retrieval from
the site. <br />

Example: ^aBVSSP^bALIMENTA&#231;AO E NUTRI&#231;AO
is different from the corresponding DECS category, CIENCIAS DA NUTRICAO";

//field v445
$BVS_LANG["helperuserVHL"] = "VHL users - Code identifying the title in the VHL system, in order to
facilitate export to different thematic areas<br />
Examples: <br />
BVSSP <br />
ANVISA <br />
BVS-Evidência";

//field v910
$BVS_LANG["helpernotesBVS"] = "Reason why the serial ceased to be indexed in LILACS <br />
Example: <br />
Indexing ceased because of delay in publication. <br />
First indexed: 1981 12(3) <BR />
Last indexed: 1998 48(2)";

//field v920
$BVS_LANG["helperwhoindex"] = "Participant Center responsible for indexing this serial in LILACS  <br />
Examples:  <br />
BR1.1  <br />
AR29.1";

//field v930
$BVS_LANG["helpercodepublisher"] = "Mandatory for participants in the Bireme Network.<br />
Code assigned by Bireme to publishers of serials indexed in LILACS.
The code is composed of the ISO country code of the publisher and an ID number<br />
The system uses this code to link the LILACS titles and the publishers data in the Nmail database. It is therefore mandatory for CCs to send in the form CADASTRO DE EDITORES DE REVISTAS LILACS<br />
Examples:<br />
BR440.9<br />
AR29.9";


        /***************** ISBD - 2007 ****************************************/

$BVS_LANG["helpISBD"] = "Basic data entry rules for Serial Titles – based on ISBD – consolidated edition 2007 adapted to the SeCS-Web database environment.<br /><br />1 – When the title contains a set of initials or acronym prominently placed on the title page, and the extended form of the title also appears as part of the title, enter the initials or acronym in Publication Title (field 100) and the extended form in Subtitle (field 110). When the initials or acronym are linguistically or typographically separated from the extended form, enter the acronym in the Publication Title field, and the extended form in Other forms of Title (field 240).<br /><br />Examples:<br />a) Publication title: ABCD<br />    Subtitle: arquivos brasileiros de cirugia digestiva<br />b) Publication title: Jornal da AMRIGS.<br />    Subtitle: jornal da Associa&#231;&#227;o M&#233;dica do Rio Grande do Sul  <br /><br /><br />2 – When the stament of responsibility appears in abbreviated form as initials or acronym and as an integrated part of the title proper, it is repeated in extended form in the field 140, Issuing body if it appears in the described serial. Enter the extended form of the title in Other forms of Title (field 240)<br /><br />Examples:<br />Publication title: ALA bulletin<br />Issuing body: American Library Association<br />Other forms of Title: American Library Association bulletin.<br /><br />3 – When the serial has no other title element than the statement of responsibility, enter the statement of responsibility as title proper in Publication Title. It is not necessary to repeat the statement of responsibility in the Issuing body field.<br /><br />Example:<br />Publication title: Universidad de Antioquia<br /><br />4- When the title consists solely of a generic term such as Bulletin, Journal, Newsletter, etc. or their equivalent in other languages, and is linguistically or typographically separated from the statement of responsibility, enter the title in the form it appears and add the statement of responsibility in Issuing Body (field 140), which in this case becomes mandatory to correctly identify the serial.<br /><br />Example:<br />Publication title: Boletim<br />Issuing body: Associa&#231;&#227;o M&#233;dica Paulista<br /><br /><br />5 – For homonymous titles, add a differentiating element (qualifier) to all forms of title proper (abbreviated title, parallel title, etc.). This information should be added in brackets after the title, separated by a single space, as follows:<br /><br />5.1 – Homonymous titles with different places of publication: add place of publication (city)<br /><br />Examples:<br />Publication title: Pediatria (S&#227;o Paulo)<br />Publication title: Pediatria (Bogot&#225;)<br /><br />5.2 - Homonymous titles with the same place of publication: add place of publication (city) and year first published.<br /><br />Examples:<br />Publication title: Pediatria (S&#227;o Paulo. 1983)<br />Publication title: Pediatria (S&#227;o Paulo. 1984)<br /><br />5.3 – Serials returning to a previous title: add place of publication (city) and year first published.<br /><br />Examples:<br />Publication title: Revista m&#233;dica (1968)<br />Publication title: Revista m&#233;dica (1987)<br /><br />5.4 – Editions in different languages with homonymous titles: enter the edition according to ISO 4-1984 and &#180;List of serial title word abbreviations&#180;.<br />Examples:<br />Publication title: Abboterapia (Spanish ed.)<br />Publication title: Abboterapia (Portuguese ed.)<br />Abbreviated title: Abboterapia (Span. ed.)<br />Abbreviated title: Abboterapia (Port. ed.)<br /><br />6 – When a section, part or supplement is published separately and has a specific title which can be separated from the main title, and the specific title appears more prominently than the main title, make a separate record for the section as title proper. Add information in field 560 Is  supplement/insertion of in the record of the section, and in field 550 Has supplement/insertion in the record of the main title.<br /><br />Example:<br />Main title: Veterinary record<br />Specific title: In practice<br />a) Publication title: In practice<br />    Is supplement/insertion of: Veterinary record<br />b) Publication title: Veterinary record<br />    Has supplement/insertion: In practice<br /><br />7 – When a supplement has the same title as the main edition and a new record is made for it, differentiate it by adding Supplement in field 130 – Title of section/part.<br />Example:<br />a) Publication title: Ci&#234;ncia e cultura<br />Title of section/part: Suplemento<br />b) Publication title: Acta cir&#250;rgica brasileira<br />Title of section/part: Suplemento<br /><br />8 – When parallel titles appear on the title page or substitute,  enter as title proper the one that appears typographically prominent. When there is no typographical distinction between parallel titles, enter as title proper the one that appears first, and the rest as parallel titles in field 230. <br />Example:<br />Publication title: Progress in surgery<br />Parallel title: Progress en chirurgie";

	/****************************************************************************************************/
	/**************************************** Library Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v2
$BVS_LANG["helpLibFullname"] = "Name that identifies the library.<br />
EXAMPLE: BIREME - PAHO - WHO - Latin American and Caribbean Center on Health Sciences";

//field v1
$BVS_LANG["helpLibCode"] = "Code used to identify the library, center or unit of information.<br />
The main library that manages SeCS has the default name: MAIN<br />
<br />
EXAMPLES<br />
a) FAGRO<br />
b) Sciences<br />
<br />
Libraries belonging to the BIREME network will use the given ID code that identifies them.<br />
The code of the Library is composed of the ISO country code where it is located, followed by a number that identifies it.<br />
EXAMPLES: BR1.1";

//field v9
$BVS_LANG["helpLibInstitution"] = "Logo and name of the institution which the library or library system is an integral part.<br />
EXAMPLE: UNIFESP: Federal University of S&#227;o Paulo";

// field v3
$BVS_LANG["helpLibAddress"] = "Full address of the Library with the appropriate supplements (Street, Av, etc.).<br />
EXAMPLE: Rua Botucatu, 862 - CEP 04023-901 - Vila Clementino";

// field v4
$BVS_LANG["helpLibCity"] = "City where is located the Library.<br />
EXAMPLE: S&#227;o Paulo";

//field v5
$BVS_LANG["helpLibCountry"] = "Name of the country where is located the Library<br />
EXAMPLE: Brazil";

//field v6
$BVS_LANG["helpLibPhone"] = "Telephone number or telephone number of the responsible for the Library.<br />
EXAMPLE: (55 011) 55769876, (55 011) 55769800";

//field v7
$BVS_LANG["helpLibContact"] = "Full name of person responsible for the Library.<br />
EXAMPLE: Raquel Cristina Vargas";

//field v10
$BVS_LANG["helpLibNote"] = "Further information on the Library.<br />
Record in this field, in any language, the information that is of interest to the intelligence unit.<br />
EXAMPLE: days and hours of attention";

//field v11
$BVS_LANG["helpLibEmail"] = "E-mail address of the person responsible for the Library.<br />
EXAMPLE: raquel.araujo@bireme.org";


	/****************************************************************************************************/
	/**************************************** Homepage - Search Field Helps ****************************************/
	/****************************************************************************************************/
/*
 * Help for Title search field and Title Plus search field in homepage section
 */

//search Title database
$BVS_LANG["helpSearchTitle"] = "Search in Title Database.<br />
You can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";

//search Title Plus database
$BVS_LANG["helpSearchTitlePlus"] = "Search in Title Plus Database.<br />
You can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Some indexes have pre-defined values for search, se the search box change to a list with the available options.<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";


//search Mask database
$BVS_LANG["helpSearchMask"] = "Search in Mask Database.<br />
You can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";

//search Issue database
$BVS_LANG["helpSearchIssue"] = "Search in Issue Database.<br />
You can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";

//search Users database
$BVS_LANG["helpSearchUsers"] = "Search in Users Database.<br />
Yuo can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";

//search Library database
$BVS_LANG["helpSearchLibrary"] = "Search in Library Database.<br />
You can do a free search, withou select an specific index (option All Index) or do a search by one of the indexes
that are available in the list next to help icon.<br/>
<br/>
Only tipe one or more terms in the search box and press the button &#180;Search&#180;.<br/>
It is allowed do a search by all the itens using the symbol $<br/>
Or a trunck search with the term and the symbol $<br/>
For example a search by Brazil$, will return Brazil and Brazilian.";


?>
