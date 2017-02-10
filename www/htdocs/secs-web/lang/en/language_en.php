<?php
/**
 * @file:		language_en.php
 * @desc:		English language file for SeCS-web
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @co-author: Wenke Adam <wenkeadam@gmail.com>
 * @since:          2009-01-04
 * @copyright:      (c) 2008 Bireme - PFI
 ******************************************************************************/
require_once("help_lang_en.php");


    /****************************************************************************************************/
    /**************************************** Editable Itens  ****************************************/
    /****************************************************************************************************/

/**
 * Top Information
 */
$BVS_LANG["appLogo"] = "ABCD";
$BVS_LANG["bannerTitle"] = "ABCD – Automation System for Libraries and Documentation Centers";

/**
 * Footer Information
 */
$BVS_LANG["institutionName"] = "BIREME - Latin-American and Caribbean Center on Health Sciences Information";
$BVS_LANG["institutionURL"]  = "http://www.bireme.org/";


    /****************************************************************************************************/
    /**************************************** System General Information  ****************************************/
    /****************************************************************************************************/

$BVS_LANG["metaCharset"] 	= "UTF-8";
$BVS_LANG["metaLanguage"] 	= "en";
$BVS_LANG["language"] 		= "English";
$BVS_LANG["dir"] 			= "ltr"; // ltr: left to right (e.g. English language); rtl: right to left (e.g. Arabic language)
$BVS_LANG["metaDescription"] = "SeCS-Web - Periodicals and Serials";
$BVS_LANG["metaKeywords"] 	 = "magazines, portal, administration, collection, periodicals, control, serials, libraries, software";
$BVS_LANG["titleApp"] = "SeCS-Web - Periodicals and Serials";


	/****************************************************************************************************/
	/**************************************** Homepage Section  ****************************************/
	/****************************************************************************************************/

$BVS_LANG["lblTitle"] = "Title";
$BVS_LANG["lblTitles"] 	= "Titles";
$BVS_LANG["lblMask"] = "Mask";
$BVS_LANG["lblMasks"] = "Masks";
$BVS_LANG["lblFacic"] = "Issues";
$BVS_LANG["lblManagerOf"]		= "Management of";
$BVS_LANG["lblTitleFacic"] = "Titles"; //alterado and Issues
$BVS_LANG["lblTitlePlusFacic"] = "Titles Plus and Issues";
$BVS_LANG["lblTotalOf"]		= "total of";
$BVS_LANG["lblTitleRegister"] = "registered titles";
$BVS_LANG["lblTypeTitle"]		= "Enter one or more words";
$BVS_LANG["lblList"]		= "List";
$BVS_LANG["lblSearch"]			= "Search";
$BVS_LANG["lblNew"] = "New";
$BVS_LANG["lblNew2"]	= "New";
$BVS_LANG["lblUtility"]		= "Utilities";
$BVS_LANG["lblAdministrat"] 	= "manage";
$BVS_LANG["lblUsers"] 			= "Users";
$BVS_LANG["lblImport"]			= "Import";
$BVS_LANG["lblGenerate"] = "generate";
$BVS_LANG["lblReports"] = "Reports";  
$BVS_LANG["lblColection"]		= "Holdings";
$BVS_LANG["lblSend"] 			= "send";
$BVS_LANG["lblHelp"]			= "Help";
$BVS_LANG["lblManual"] 		= "Manual";
$BVS_LANG["lblService"] 		= "Service";
$BVS_LANG["lblMaintance"] 		= "Maintenance";
$BVS_LANG["lblRead"] 			= "read";
$BVS_LANG["lblMyTitleRegister"] = "registered in my titles";
$BVS_LANG["lblAdmUsers"] = "<strong>Users</strong> Management";
$BVS_LANG["lblAdmLibrary"] = "<strong>Library</strong> Management";
$BVS_LANG["lblServReport"] = "Statistical <strong>Reports</strong>";
$BVS_LANG["lblServMaintance"] = "Database <strong>Maintenance</strong>";
$BVS_LANG["lblSearchTitle"] = "Search Title database";
$BVS_LANG["lblSearchTitlePlus"] = "Search Title Plus database";
$BVS_LANG["lblSearchMask"] = "Search Mask database";
$BVS_LANG["lblSearchIssue"] = "Search Issue database";
$BVS_LANG["lblSearchUsers"] = "Search Users database";
$BVS_LANG["lblSearchLibrary"] = "Search Library database";


    /*****************************************************************************************************/
	/**************************************** Common items  ****************************************/
	/****************************************************************************************************/

$BVS_LANG["mask"] = "Mask";
$BVS_LANG["facic"] = "Issues";
$BVS_LANG["title"] = "Title";
$BVS_LANG["close"] = "Close";
$BVS_LANG["login"] = "Identification";
$BVS_LANG["about"]  		= "About";
$BVS_LANG["home"] 			= "Home";
$BVS_LANG["contact"] 		= "Contact";
$BVS_LANG["rss"] 			= "RSS";
$BVS_LANG["version"] 		= "Version";
$BVS_LANG["myPreferences"] 	= "My Preferences";
$BVS_LANG["logOff"] 		= "Logout";
$BVS_LANG["adminDataOf"]	= "Administration of";
$BVS_LANG["homepage"]		= "Work Area";
$BVS_LANG["help"]			= "Help";
$BVS_LANG["lang"] = "Language";
$BVS_LANG["perPage"]		= "per page";
$BVS_LANG["titleAction"]	= "Actions";
$BVS_LANG["titleSearch"] 	= "Search";
$BVS_LANG["allIndexes"] 	= "all Indexes";
$BVS_LANG["all"]			= "all";
$BVS_LANG["registers"]		= "records found";
$BVS_LANG["lblOf"] = "of";
$BVS_LANG["lblViewOf"] 		= "View from";
$BVS_LANG["lblUntil"]		= "to";
$BVS_LANG["lbltitle"] 		= "Titles";
$BVS_LANG["lblExport"] 		= "Export";
$BVS_LANG["btNewRecord"]	= "New";
$BVS_LANG["btEdTitle"] = "Edit Title"; 
$BVS_LANG["btEdFasc"] = "Edit Issue";
$BVS_LANG["btEdMask"] = "Edit Mask"; 
$BVS_LANG["btInsTitle"] = "Insert Title";
$BVS_LANG["btInsFasc"] = "Insert Issue";
$BVS_LANG["btInsMask"] = "Insert Mask";
$BVS_LANG["btAddFasc"] = "Add Issue";
$BVS_LANG["btInsFascBetween"] = "Insert next";
$BVS_LANG["btSaveRecord"]   = "Save";
$BVS_LANG["btEditRecord"] 	= "Edit";
$BVS_LANG["btInsertRecord"] = "Insert";
$BVS_LANG["btEraserRecord"] = "Erase";
$BVS_LANG["btDeleteRecord"] = "Delete";
$BVS_LANG["btSubField"] 	= "Subfield";
$BVS_LANG["btCancelAction"] = "Cancel";
$BVS_LANG["btBackAction"]	= "Back";
$BVS_LANG["btPrevious"] 	= "Previous";
$BVS_LANG["btNext"] 		= "Next";
$BVS_LANG["btFirst"]		= "First";
$BVS_LANG["btLast"]			= "Last";
$BVS_LANG["btSearch"] 		= "Search";
$BVS_LANG["btStep"] 		= "step";
$BVS_LANG["helperSearch"] 	= "Use $ to select all records";
$BVS_LANG["helperSelectAllRecords"] = "select all listed items";
$BVS_LANG["MSG_LOADING"] 	= "<b>Wait</b> Loading data...";
$BVS_LANG["MSG_EMPTY"]      = "No records found.";
$BVS_LANG["MSG_ERROR"]		= "Data access error!";
$BVS_LANG["msgLibChange"]	= "Library successfully changed!";
$BVS_LANG["msgEmpty"]	= "No records found."; 
$BVS_LANG["msgSaving"] 	= "<b>Wait!</b> Updating...";
	/****************************************************************************************************/
	/**************************************** Title Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["btStep1"] 		= "step 1";
$BVS_LANG["btStep2"] 		= "step 2";
$BVS_LANG["btStep3"] 		= "step 3";
$BVS_LANG["btStep4"] 		= "step 4";
$BVS_LANG["btStep5"] 		= "step 5";
$BVS_LANG["btStep6"] 		= "step 6";
$BVS_LANG["btStep7"] 		= "step 7";
$BVS_LANG["btCreEdTitlePlus"] = "Create/Edit Title Plus";
$BVS_LANG["lblStep1"]="step 1 of 7: Basic information";
$BVS_LANG["lblStep2"]="step 2 of 7: Title information";
$BVS_LANG["lblStep3"]="step 3 of 7: History information";
$BVS_LANG["lblStep4"]="step 4 of 7: General information";
$BVS_LANG["lblStep5"]="step 5 of 7: Classification";
$BVS_LANG["lblStep6"]="step 6 of 7: New URL";
$BVS_LANG["lblStep7"]="step 7 of 7: VHL Information";
$BVS_LANG["lblID"] = "ID";
$BVS_LANG["lblAction"] = "Actions";
$BVS_LANG["lblFileName"] = "File Name: ";
$BVS_LANG["btSendToSeCS"] = "Send to SeCS Union Catalog";
$BVS_LANG["btSendToNationalCollection"] = "Sendo to IBICT Union Catalog";
$BVS_LANG["btOneRegister"] = "One Record";
$BVS_LANG["btAllRegisters"] = "All Records";
$BVS_LANG["btSeCSFormat"] = "SeCS Format";
$BVS_LANG["btMarcFormat"] = "Marc Format";
$BVS_LANG["btExportAllTitFormatISSN"] = "Export all titles in IBICT format";
$BVS_LANG["btExportAllTitFormatSeCS"] = "Export all titles in SeCS format";
$BVS_LANG["btExportTitleCollection"] = "Title Only";
$BVS_LANG["btExportTitlePlusCollection"] = "Title + Holdings";
$BVS_LANG["btExportSearchTitFormatISSN"] = "Export searched<br /> titles in ISSN format";
$BVS_LANG["btExportSearchTitWithoutCollection"] = "Export searched<br /> titles without holdings";
$BVS_LANG["lblExportTitle"] = "Export Titles";
$BVS_LANG["ExportCatalog"] = "Export Catalog";
$BVS_LANG["lblTitleInformation"] = "Display formats from the Title database";
$BVS_LANG["lblTitlePlusInformation"] = "See information from Title Plus database";
$BVS_LANG["lblDialogStep1"] = "Step 1 - 2";
$BVS_LANG["lblDialogStep2"] = "Step 2 - 2";
$BVS_LANG["lblIBICTId"] = "IBICT ID:";
$BVS_LANG["lblDatabase"] = "Database";
$BVS_LANG["lblliteratureType"] = "Literature Type";
$BVS_LANG["msgTitlePlusDoesNotExist"] = "This title does not exist in this library.";
$BVS_LANG["lblField180subfieldA"] = "Secondary Source";
$BVS_LANG["lblField400subfieldA"] = "Midia";
$BVS_LANG["lblCatalog"] = "Catalog";
$BVS_LANG["lblLong"] = "Long";
$BVS_LANG["lblShort"] = "Short";
$BVS_LANG["lblComplete"] = "Complete";

/*** Begin - Form Field Labels  ****/
 /***  Step 1  ***/
$BVS_LANG["lblrecordIdentification"] = "ID number";
$BVS_LANG["lblpublicationTitle"] = "Publication title";
$BVS_LANG["lblnameOfIssuingBody"] = "Issuing Body";
$BVS_LANG["lblkeyTitle"] = "Key title";
$BVS_LANG["lblabbreviatedTitle"] = "Abbreviated Key title";
$BVS_LANG["lblabbreviatedTitleMedline"] = "Abbreviated title for other databases";
$BVS_LANG["lblField180subfield"] = "Data base code";
$BVS_LANG["lblField180subfiela"] = "Abbreviated title";
 /***  Step 2  ***/
$BVS_LANG["lblsubtitle"] = "Sub-title";
$BVS_LANG["lblsectionPart"] = "Section/Part";
$BVS_LANG["lbltitleOfSectionPart"] = "Title of section/part";
$BVS_LANG["lblparallelTitle"] = "Parallel title";
$BVS_LANG["lblotherTitle"] = "Others forms of title";
$BVS_LANG["lbltitleHasOtherLanguageEditions"] = "Issued also in other language(s) as";
$BVS_LANG["lbltitleAnotherLanguageEdition"] = "Is edition in other language of";
$BVS_LANG["lbltitleHasSubseries"] = "Has subseries";
$BVS_LANG["lbltitleIsSubseriesOf"] = "Is subseries of";
$BVS_LANG["lbltitleHasSupplementInsert"] = "Has supplement or insertion";
$BVS_LANG["lbltitleIsSupplementInsertOf"] = "Is supplement or insertion of";
 /***  Step 3  ***/
$BVS_LANG["lbltitleContinuationOf"] = "Is continuation of";
$BVS_LANG["lbltitlePartialContinuationOf"] = "Is partial continuation of";
$BVS_LANG["lbltitleAbsorbed"] = "Has absorbed";
$BVS_LANG["lbltitleAbsorbedInPart"] = "Has partially absorbed";
$BVS_LANG["lbltitleFormedByTheSplittingOf"] = "Formed by the splitting of";
$BVS_LANG["lbltitleMergeOfWith"] = "Merger of .... with ...";
$BVS_LANG["lbltitleContinuedBy"] = "Continued by";
$BVS_LANG["lbltitleContinuedInPartBy"] = "Continued partially by";
$BVS_LANG["lbltitleAbsorbedBy"] = "Absorbed by";
$BVS_LANG["lbltitleAbsorbedInPartBy"] = "Absorbed partially by";
$BVS_LANG["lbltitleSplitInto"] = "Split into";
$BVS_LANG["lbltitleMergedWith"] = "Merged with";
$BVS_LANG["lbltitleToForm"] = "to form";
 /***  Step 4  ***/
$BVS_LANG["lblpublisher"] = "Publisher";
$BVS_LANG["lblplace"] = "City";
$BVS_LANG["lblcountry"] = "Country";
$BVS_LANG["lblstate"] = "State";
$BVS_LANG["lblissn"] = "ISSN";
$BVS_LANG["lblcoden"] = "CODEN";
$BVS_LANG["lblpublicationStatus"] = "Publication status";
$BVS_LANG["lblinitialDate"] = "Initial date";
$BVS_LANG["lblinitialVolume"] = "Initial volume";
$BVS_LANG["lblinitialNumber"] = "Initial  issue";
$BVS_LANG["lblfinalDate"] = "Final date";
$BVS_LANG["lblfinalVolume"] = "Final volume";
$BVS_LANG["lblfinalNumber"] = "Final issue";
$BVS_LANG["lblpublicationLevel"] = "Level of publication";
$BVS_LANG["lblalphabetTitle"] = "Title alphabet";
$BVS_LANG["lbllanguageText"] = "Text language";
$BVS_LANG["lbllanguageAbstract"] = "Abstract language";
 /***  Step 5  ***/
$BVS_LANG["lblrelatedSystems"] = "Related systems";
$BVS_LANG["lblnationalCode"] = "National code";
$BVS_LANG["lblsecsIdentification"] = "SeCS number";
$BVS_LANG["lblmedlineCode"] = "MEDLINE code";
$BVS_LANG["lblclassification"] = "Classification";
$BVS_LANG["lblclassificationCdu"] = "CDU classification";
$BVS_LANG["lblclassificationDewey"] = "Dewey classification";
$BVS_LANG["lblthematicaArea"] = "Subject Area";
$BVS_LANG["lbldescriptors"] = "DeCS Descriptors";
$BVS_LANG["lblotherDescriptors"] = "Descriptors from other thesauri";
$BVS_LANG["lblindexingCoverage"] = "Indexing coverage";
$BVS_LANG["lblmethodAcquisition"] = "Acquisition method";
$BVS_LANG["lblacquisitionPriority"] = "Priority of aquisition";
$BVS_LANG["lblnotes"] = "Notes";
$BVS_LANG["lblCoveredSubjectDB"] = "Subject coverage by Database";
$BVS_LANG["lblIndicators"] = "Indicators";
$BVS_LANG["lblSubFieldsv450"] = array("Covering Index",
                                    "Code of the secondary source",
                                    "Start Date",
                                    "Initial Volume",
                                    "Initial Issue",
                                    "End Date",
                                    "Final Volume",
                                    "Final Issue"
                                    );

 /***  Step 6  ***/
$BVS_LANG["lblurlPortal"] = "Information for Portal";
$BVS_LANG["lblurlInformation"] = "Availability";
$BVS_LANG["lblBanPeriod"] = "Period of Ban";  
 /***  Step 7  ***/
$BVS_LANG["lblspecialtyVHL"] = "VHL Specialty";
$BVS_LANG["lbluserVHL"] = "VHL user";
$BVS_LANG["lblnotesBVS"] = "VHL notes";
$BVS_LANG["lblwhoindex"] = "Indexing Center";
$BVS_LANG["lblcodepublisher"] = "Publisher code";
$BVS_LANG["lblTematicVHL"] = "Tematic VHL";
$BVS_LANG["lblTerminology"] = "Terminology";
/*** End - Form Field Labels  ****/

/*** Begin - Form Lists or Multiple Itens ***/
$BVS_LANG["optIndexesTitle"] = array("" => "",
                                    "" => "All Indexes",
                                    "TI" => "Words in Title",
                                    "TC" => "Full Title",
                                    "I" => "Identification Number",
                                    "CN" => "National Code",
                                    "SP" => "Publication Situation",
                                    "NP" => "Publication Level"
                                            );

$BVS_LANG["optOwner"] = array(""   => "",
                            "CAPES-ACS" => "CAPES-ACS",
                            "CAPES-APA" => "CAPES-APA",
                            "CAPES-AIP" => "CAPES-AIP",
                            "CAPES-BLC" => "CAPES-BLC",
                            "CAPES-GALE" => "CAPES-GALE",
                            "CAPES-HW" => "CAPES-HW",
                            "CAPES-IDEAL" => "CAPES-IDEAL",
                            "CAPES-IEEE" => "CAPES-IEEE",
                            "CAPES-OVID" => "CAPES-OVID",
                            "CAPES-SDO" => "CAPES-SDO",
                            "HINARI" => "HINARI",
                            "PROBE-ACADP" => "PROBE-ACADP",
                            "PROBE-EO" => "PROBE-EO",
                            "PROBE-SDO" => "PROBE-SDO",
                            "PROBE-GALE" => "PROBE-GALE",
                            "PROBE-HW" => "PROBE-HW",
                            "PROBE-OVID" => "PROBE-OVID",
                            "SCIELO" => "SCIELO",
                                    );
$BVS_LANG["opttypeAcess"] = array(""   => "",
                                "ALIV" => "Free",
                                "ALAP" => "Free to subscribers",
                                "AAEL" => "ONLINE subscription",
                                "ACOP" => "ONLINE/PRINT subscription",
                                );
$BVS_LANG["optcontrolNewUrl"] = array(""   => "",
                                    "LIBRE" => "Free",
                                    "IP" => "IP",
                                    "PASS" => "Password",
                                    "IP/PASS" => "IP / Password",
                                    );
							
$BVS_LANG["optMethodAcquisition"] = array(""   => "",
                                        "0" => "Unknown",
                                        "1A" => "Currently purchased",
                                        "2A" => "Currently exchanged",
                                        "3A" => "Currently donated",
                                        "1B" => "Purchase cancelled",
                                        "2B" => "Exchange cancelled",
                                        "3B" => "Donation cancelled"
                                                );
$BVS_LANG["optAcquisitionPriority"] = array(""   => "",
                                            "1" => "Essential",
                                            "2" => "Non-Essential, available in the country",
                                            "3" => "Non-Essential, available in the Region"
                                                    );
$BVS_LANG["optIndexingCoverage"] = array(""   => "",
                                        "IM" => "Index Medicus",
                                        "EM" => "Excerpta Medica",
                                        "BA" => "Biological Abstracts",
                                        "LL" => "LILACS",
                                        "AHCI" => "AHCI",
                                        "BBO" => "BBO",
                                        "CA" => "CA",
                                        "IBECS" => "IBECS",
                                        "LATINDEX" => "LATINDEX",
                                        "MEDLINE" => "MEDLINE",
                                        "PUBMED" => "PUBMED",
                                        "PSYCINFO" => "PSYCINFO",
                                        "SSCI" => "SSCI",
                                        "SCI" => "SCI",
                                        "SCIELO" => "SCIELO",
                                        "SCIE" => "SCIE",
                                        "SCIENCE CITATION INDEX" => "SCIENCE CITATION INDEX",
                                        "SCOPUS" => "SCOPUS",
                                        "NUTRITION ABSTRACTS AND REVIEWS" => "NUTRITION ABSTRACTS AND REVIEWS"
                                                );

$BVS_LANG["optLanguage"] = array(""   => "",
                                'en' => 'English',
                                'es' => 'Spanish',
                                'pt' => 'Portuguese',
                                'und' => 'Undetermined',
                                'fr' => 'French',
                                'ab' => 'Abkhazian',
                                'aa' => 'Afar',
                                'af' => 'Afrikaans',
                                'ak' => 'Akan',
                                'sq' => 'Albanian',
                                'am' => 'Amharic',
                                'ar' => 'Arabic',
                                'an' => 'Aragonese',
                                'hy' => 'Armenian',
                                'as' => 'Assamese',
                                'av' => 'Avaric',
                                'ae' => 'Avestan',
                                'ay' => 'Aymara',
                                'az' => 'Azerbaijani',
                                'bm' => 'Bambara',
                                'ba' => 'Bashkir',
                                'eu' => 'Basque',
                                'be' => 'Belarusian',
                                'bn' => 'Bengali',
                                'bh' => 'Bihari',
                                'bi' => 'Bislama',
                                'bs' => 'Bosnian',
                                'br' => 'Breton',
                                'bg' => 'Bulgarian',
                                'my' => 'Burmese',
                                'ca' => 'Catalan, Valencian',
                                'km' => 'Central Khmer',
                                'ch' => 'Chamorro',
                                'ce' => 'Chechen',
                                'ny' => 'Chichewa, Chewa, Nyanja',
                                'zh' => 'Chinese',
                                'cu' => 'Church Slavic, Old Slavonic, Church Slavonic, Old Bulgarian, Old Church Slavonic',
                                'cv' => 'Chuvash',
                                'kw' => 'Cornish',
                                'co' => 'Corsican',
                                'cr' => 'Cree',
                                'hr' => 'Croatian',
                                'cs' => 'Czech',
                                'da' => 'Danish',
                                'dv' => 'Divehi, Dhivehi, Maldivian',
                                'nl' => 'Dutch, Flemish',
                                'dz' => 'Dzongkha',
                                'eo' => 'Esperanto',
                                'et' => 'Estonian',
                                'ee' => 'Ewe',
                                'fo' => 'Faroese',
                                'fj' => 'Fijian',
                                'fi' => 'Finnish',
                                'ff' => 'Fulah',
                                'gd' => 'Gaelic, Scottish Gaelic',
                                'gl' => 'Galician',
                                'lg' => 'Ganda',
                                'ka' => 'Georgian',
                                'de' => 'German',
                                'el' => 'Greek, Modern (1453-)',
                                'gn' => 'Guarani',
                                'gu' => 'Gujarati',
                                'ht' => 'Haitian, Haitian Creole',
                                'ha' => 'Hausa',
                                'he' => 'Hebrew',
                                'hz' => 'Herero',
                                'hi' => 'Hindi',
                                'ho' => 'Hiri Motu',
                                'hu' => 'Hungarian',
                                'is' => 'Icelandic',
                                'io' => 'Ido',
                                'ig' => 'Igbo',
                                'id' => 'Indonesian',
                                'ia' => 'Interlingua (International Auxiliary Language Association)',
                                'ie' => 'Interlingue',
                                'iu' => 'Inuktitut',
                                'ik' => 'Inupiaq',
                                'ga' => 'Irish',
                                'it' => 'Italian',
                                'ja' => 'Japanese',
                                'jv' => 'Javanese',
                                'kl' => 'Kalaallisut, Greenlandic',
                                'kn' => 'Kannada',
                                'kr' => 'Kanuri',
                                'ks' => 'Kashmiri',
                                'kk' => 'Kazakh',
                                'ki' => 'Kikuyu, Gikuyu',
                                'rw' => 'Kinyarwanda',
                                'ky' => 'Kirghiz, Kyrgyz',
                                'kv' => 'Komi',
                                'kg' => 'Kongo',
                                'ko' => 'Korean',
                                'kj' => 'Kuanyama, Kwanyama',
                                'ku' => 'Kurdish',
                                'lo' => 'Lao',
                                'la' => 'Latin',
                                'lv' => 'Latvian',
                                'li' => 'Limburgan, Limburger, Limburgish',
                                'ln' => 'Lingala',
                                'lt' => 'Lithuanian',
                                'lu' => 'Luba-Katanga',
                                'lb' => 'Luxembourgish, Letzeburgesch',
                                'mk' => 'Macedonian',
                                'mg' => 'Malagasy',
                                'ms' => 'Malay',
                                'ml' => 'Malayalam',
                                'mt' => 'Maltese',
                                'gv' => 'Manx',
                                'mi' => 'Maori',
                                'mr' => 'Marathi',
                                'mh' => 'Marshallese',
                                'mo' => 'Moldavian',
                                'mn' => 'Mongolian',
                                'na' => 'Nauru',
                                'nv' => 'Navajo, Navaho',
                                'nd' => 'Ndebele, North, North Ndebele',
                                'nr' => 'Ndebele, South, South Ndebele',
                                'ng' => 'Ndonga',
                                'ne' => 'Nepali',
                                'se' => 'Northern Sami',
                                'no' => 'Norwegian',
                                'nb' => 'Norwegian Bokmaal',
                                'nn' => 'Norwegian Nynorsk, Nynorsk, Norwegian',
                                'oc' => 'Occitan (post 1500), Provençal',
                                'oj' => 'Ojibwa',
                                'or' => 'Oriya',
                                'om' => 'Oromo',
                                'os' => 'Ossetian, Ossetic',
                                'pi' => 'Pali',
                                'pa' => 'Panjabi, Punjabi',
                                'fa' => 'Persian',
                                'pl' => 'Polish',
                                'ps' => 'Pushto',
                                'qu' => 'Quechua',
                                'ro' => 'Romanian',
                                'rm' => 'Romansh',
                                'rn' => 'Rundi',
                                'ru' => 'Russian',
                                'sm' => 'Samoan',
                                'sg' => 'Sango',
                                'sa' => 'Sanskrit',
                                'sc' => 'Sardinian',
                                'sr' => 'Serbian',
                                'sn' => 'Shona',
                                'ii' => 'Sichuan Yi',
                                'sd' => 'Sindhi',
                                'si' => 'Sinhala, Sinhalese',
                                'sk' => 'Slovak',
                                'sl' => 'Slovenian',
                                'so' => 'Somali',
                                'st' => 'Sotho, Southern',
                                'su' => 'Sundanese',
                                'sw' => 'Swahili',
                                'ss' => 'Swati',
                                'sv' => 'Swedish',
                                'tl' => 'Tagalog',
                                'ty' => 'Tahitian',
                                'tg' => 'Tajik',
                                'ta' => 'Tamil',
                                'tt' => 'Tatar',
                                'te' => 'Telugu',
                                'th' => 'Thai',
                                'bo' => 'Tibetan',
                                'ti' => 'Tigrinya',
                                'to' => 'Tonga (Tonga Islands)',
                                'ts' => 'Tsonga',
                                'tn' => 'Tswana',
                                'tr' => 'Turkish',
                                'tk' => 'Turkmen',
                                'tw' => 'Twi',
                                'ug' => 'Uighur, Uyghur',
                                'uk' => 'Ukrainian',
                                'ur' => 'Urdu',
                                'uz' => 'Uzbek',
                                've' => 'Venda',
                                'vi' => 'Vietnamese',
                                'vo' => 'Volapük',
                                'wa' => 'Walloon',
                                'cy' => 'Welsh',
                                'fy' => 'Western Frisian',
                                'wo' => 'Wolof',
                                'xh' => 'Xhosa',
                                'yi' => 'Yiddish',
                                'yo' => 'Yoruba',
                                'za' => 'Zhuang, Chuang',
                                'zu' => 'Zulu'
                                );
									
$BVS_LANG["optPublicationLevel"] = array(""   => "",
                                        "CT" => "Scientific/technical",
                                        "DI" => "Outreach"
                                                );
$BVS_LANG["optAlphabetTitle"] = array(""   => "",
                                    "E" => "Chinese",
                                    "C" => "Cyrilic",
                                    "K" => "Korean",
                                    "D" => "Japanese",
                                    "Z" => "Other alphabets",
                                    "A" => "Basic Roman",
                                    "B" => "Extended Roman",
                                            );
$BVS_LANG["optFrequency"] = array(""   => "",
                                "A" => "Annual",
                                "G" => "Biennial ",
                                "S" => "Semimonthly",
                                "B" => "Bimonthly",
                                "C" => "Biweekly",
                                "D" => "Daily",
                                "U" => "Unknown Frequency",
                                "K" => "Irregular",
                                "M" => "Monthly",
                                "Z" => "Other Frequencies",
                                "T" => "Three times a year",
                                "E" => "Biweekly",
                                "W" => "Weekly",
                                "F" => "Semiannual",
                                "I" => "Three times a week",
                                "J" => "Three times a month",
                                "H" => "Triennial",
                                "Q" => "Quarterly"
                                        );
$BVS_LANG["optPublicationStatus"] = array(""   => "",
                                        "C" => "Current",
                                        "D" => "Ceased/Suspended",
                                        "?" => "Unknown"
                                                );
$BVS_LANG["optState"] = array(""   => "",
                            "AC" => "Acre",
                            "AL" => "Alagoas",
                            "AP" => "Amap&#225;",
                            "AM" => "Amazonas",
                            "BA" => "Bahia",
                            "DF" => "Distrito Federal",
                            "CE" => "Cear&#225;",
                            "ES" => "Esp&#237;rito Santo",
                            "FN" => "Fernando de Noronha",
                            "GO" => "Goi&#225;s",
                            "MH" => "Maranh&#227;o",
                            "MT" => "Mato Grosso",
                            "MS" => "Mato Grosso do Sul",
                            "MG" => "Minas Gerais",
                            "PA" => "Par&#225;",
                            "PB" => "Para&#237;ba",
                            "PR" => "Parana",
                            "PE" => "Pernambuco",
                            "PI" => "Piau&#237;",
                            "RJ" => "Rio de Janeiro",
                            "RN" => "Rio Grande do Norte",
                            "RS" => "Rio Grande do Sul",
                            "RD" => "Rond&#244;nia",
                            "RR" => "Roraima",
                            "SC" => "Santa Catarina",
                            "SP" => "S&#227;o Paulo",
                            "SE" => "Sergipe",
                            "TO" => "Tocantins"
                            );
$BVS_LANG["optCountry"] = array(""   => "",
                                "AG" => "Antigua and Barbuda",
                                "AI" => "Anguilla",
                                "AN" => "Netherlands Antilles",
                                "AR" => "Argentina",
                                "BB" => "Barbados",
                                "BO" => "Bolivia",
                                "BR" => "Brazil",
                                "BS" => "Bahamas",
                                "BZ" => "Belize",
                                "CL" => "Chile",
                                "CO" => "Colombia",
                                "CR" => "Costa Rica",
                                "CU" => "Cuba",
                                "DM" => "Dominica",
                                "DO" => "Dominican Republic",
                                "EC" => "Ecuador",
                                "FK" => "Falkland Islands (Malvinas)",
                                "GD" => "Grenada",
                                "GF" => "French Guiana",
                                "GP" => "Guadeloupe",
                                "GT" => "Guatemala",
                                "GY" => "Guyana",
                                "HN" => "Honduras",
                                "HT" => "Haiti",
                                "JM" => "Jamaica",
                                "KN" => "Saint Kitts and Nevis",
                                "KY" => "Cayman Islands",
                                "LC" => "Saint Lucia",
                                "MQ" => "Martinique",
                                "MS" => "Montserrat",
                                "MX" => "Mexico",
                                "NI" => "Nicaragua",
                                "PA" => "Panama",
                                "PE" => "Peru",
                                "PR" => "Puerto Rico",
                                "PY" => "Paraguay",
                                "SR" => "Suriname",
                                "SV" => "El Salvador",
                                "TC" => "Turks and Caicos Islands",
                                "TT" => "Trinidad and Tobago",
                                "UM" => "United States Minor Outlying Islands",
                                "US" => "United States",
                                "UY" => "Uruguay",
                                "VC" => "Saint Vincent and the Grenadines",
                                "VE" => "Venezuela",
                                "VG" => "Virgin Islands, British",
                                "AD" => "Andorra",
                                "AE" => "United Arab Emirates",
                                "AF" => "Afghanistan",
                                "AL" => "Albania",
                                "AM" => "Armenia",
                                "AO" => "Angola",
                                "AQ" => "Antarctica",
                                "AS" => "American Samoa",
                                "AT" => "Austria",
                                "AU" => "Australia",
                                "AW" => "Aruba",
                                "AX" => "&#197;land Islands",
                                "AZ" => "Azerbaijan",
                                "BA" => "Bosnia and Herzegovina",
                                "BD" => "Bangladesh",
                                "BE" => "Belgium",
                                "BF" => "Burkina Faso",
                                "BG" => "Bulgaria",
                                "BH" => "Bahrain",
                                "BI" => "Burundi",
                                "BJ" => "Benin",
                                "BL" => "Saint Barth&#233;lemy",
                                "BM" => "Bermuda",
                                "BN" => "Brunei Darussalam",
                                "BT" => "Bhutan",
                                "BV" => "Bouvet Island",
                                "BW" => "Botswana",
                                "BY" => "Belarus",
                                "CA" => "Canada",
                                "CC" => "Cocos (Keeling) Islands",
                                "CD" => "Congo, The Democratic Republic of the",
                                "CF" => "Central African Republic",
                                "CG" => "Congo",
                                "CH" => "Switzerland",
                                "CI" => "C&#244;te d'Ivoire",
                                "CK" => "Cook Islands",
                                "CM" => "Cameroon",
                                "CN" => "China",
                                "CV" => "Cape Verde",
                                "CX" => "Christmas Island",
                                "CY" => "Cyprus",
                                "CZ" => "Czech Republic",
                                "DE" => "Germany",
                                "DJ" => "Djibouti",
                                "DK" => "Denmark",
                                "DZ" => "Algeria",
                                "EE" => "Estonia",
                                "EG" => "Egypt",
                                "EH" => "Western Sahara",
                                "ER" => "Eritrea",
                                "ES" => "Spain",
                                "ET" => "Ethiopia",
                                "FI" => "Finland",
                                "FJ" => "Fiji",
                                "FM" => "Micronesia, Federated States of",
                                "FO" => "Faroe Islands",
                                "FR" => "France",
                                "GA" => "Gabon",
                                "GB" => "United Kingdom",
                                "GE" => "Georgia",
                                "GG" => "Guernsey",
                                "GH" => "Ghana",
                                "GI" => "Gibraltar",
                                "GL" => "Greenland",
                                "GM" => "Gambia",
                                "GN" => "Guinea",
                                "GQ" => "Equatorial Guinea",
                                "GR" => "Greece",
                                "GS" => "South Georgia and the South Sandwich Islands",
                                "GU" => "Guam",
                                "GW" => "Guinea-Bissau",
                                "HK" => "Hong Kong",
                                "HM" => "Heard Island and McDonald Islands",
                                "HR" => "Croatia",
                                "HU" => "Hungary",
                                "ID" => "Indonesia",
                                "IE" => "Ireland",
                                "IL" => "Israel",
                                "IM" => "Isle of Man",
                                "IN" => "India",
                                "IO" => "British Indian Ocean Territory",
                                "IQ" => "Iraq",
                                "IR" => "Iran, Islamic Republic of",
                                "IS" => "Iceland",
                                "IT" => "Italy",
                                "JE" => "Jersey",
                                "JO" => "Jordan",
                                "JP" => "Japan",
                                "KE" => "Kenya",
                                "KG" => "Kyrgyzstan",
                                "KH" => "Cambodia",
                                "KI" => "Kiribati",
                                "KM" => "Comoros",
                                "KP" => "Korea, Democratic People's Republic of",
                                "KR" => "Korea, Republic of",
                                "KW" => "Kuwait",
                                "KZ" => "Kazakhstan",
                                "LA" => "Lao People's Democratic Republic",
                                "LB" => "Lebanon",
                                "LI" => "Liechtenstein",
                                "LK" => "Sri Lanka",
                                "LR" => "Liberia",
                                "LS" => "Lesotho",
                                "LT" => "Lithuania",
                                "LU" => "Luxembourg",
                                "LV" => "Latvia",
                                "LY" => "Libyan Arab Jamahiriya",
                                "MA" => "Morocco",
                                "MC" => "Monaco",
                                "MD" => "Moldova",
                                "ME" => "Montenegro",
                                "MF" => "Saint Martin",
                                "MG" => "Madagascar",
                                "MH" => "Marshall Islands",
                                "MK" => "Macedonia, the former Yugoslav Republic of",
                                "ML" => "Mali",
                                "MM" => "Myanmar",
                                "MN" => "Mongolia",
                                "MO" => "Macao",
                                "MP" => "Northern Mariana Islands",
                                "MR" => "Mauritania",
                                "MT" => "Malta",
                                "MU" => "Mauritius",
                                "MV" => "Maldives",
                                "MW" => "Malawi",
                                "MY" => "Malaysia",
                                "MZ" => "Mozambique",
                                "NA" => "Namibia",
                                "NC" => "New Caledonia",
                                "NE" => "Niger",
                                "NF" => "Norfolk Island",
                                "NG" => "Nigeria",
                                "NL" => "Netherlands",
                                "NO" => "Norway",
                                "NP" => "Nepal",
                                "NR" => "Nauru",
                                "NU" => "Niue",
                                "NZ" => "New Zealand",
                                "OM" => "Oman",
                                "PF" => "French Polynesia",
                                "PG" => "Papua New Guinea",
                                "PH" => "Philippines",
                                "PK" => "Pakistan",
                                "PL" => "Poland",
                                "PM" => "Saint Pierre and Miquelon",
                                "PN" => "Pitcairn",
                                "PS" => "Palestinian Territory, Occupied",
                                "PT" => "Portugal",
                                "PW" => "Palau",
                                "QA" => "Qatar",
                                "RE" => "R&#233;union",
                                "RO" => "Romania",
                                "RS" => "Serbia",
                                "RU" => "Russian Federation",
                                "RW" => "Rwanda",
                                "SA" => "Saudi Arabia",
                                "SB" => "Solomon Islands",
                                "SC" => "Seychelles",
                                "SD" => "Sudan",
                                "SE" => "Sweden",
                                "SG" => "Singapore",
                                "SH" => "Saint Helena",
                                "SI" => "Slovenia",
                                "SJ" => "Svalbard and Jan Mayen",
                                "SK" => "Slovakia",
                                "SL" => "Sierra Leone",
                                "SM" => "San Marino",
                                "SN" => "Senegal",
                                "SO" => "Somalia",
                                "ST" => "Sao Tome and Principe",
                                "SY" => "Syrian Arab Republic",
                                "SZ" => "Swaziland",
                                "TD" => "Chad",
                                "TF" => "French Southern Territories",
                                "TG" => "Togo",
                                "TH" => "Thailand",
                                "TJ" => "Tajikistan",
                                "TK" => "Tokelau",
                                "TL" => "Timor-Leste",
                                "TM" => "Turkmenistan",
                                "TN" => "Tunisia",
                                "TO" => "Tonga",
                                "TR" => "Turkey",
                                "TV" => "Tuvalu",
                                "TW" => "Taiwan, Province of China",
                                "TZ" => "Tanzania, United Republic of",
                                "UA" => "Ukraine",
                                "UG" => "Uganda",
                                "UZ" => "Uzbekistan",
                                "VA" => "Holy See (Vatican City State)",
                                "VI" => "Virgin Islands, U.S.",
                                "VN" => "Viet Nam",
                                "VU" => "Vanuatu",
                                "WF" => "Wallis and Futuna",
                                "WS" => "Samoa",
                                "YE" => "Yemen",
                                "YT" => "Mayotte",
                                "ZA" => "South Africa",
                                "ZM" => "Zambia",
                                "ZW" => "Zimbabwe",
                                );
$BVS_LANG["optAgregators"] = array(
                                "CAPES-ASA" => "CAPES-ASA",
                                "CAPES-BioMed Central" => "CAPES BioMed Central",
                                "CAPES-BioOne" => "CAPES-BioOne",
                                "CAPES-Blackwell" => "CAPES-Blackwell",
                                "CAPES-BMJ Publishing Group" => "CAPES-BMJ Publishing Group",
                                "CAPES-Cambridge University Press" => "CAPES-Cambridge University Press",
                                "CAPES-EBSCO" => "CAPES-EBSCO",
                                "CAPES-Emerald" => "CAPES-Emerald",
                                "CAPES-Gale" => "CAPES-Gale",
                                "CAPES-HighWire Press" => "CAPES-HighWire Press",
                                "CAPES-Karger" => "CAPES-Karger",
                                "CAPES-ASN" => "CAPES-ASN",
                                "CAPES-Nature" => "CAPES-Nature",
                                "CAPES-Outros editores" => "CAPES-Outros editores",
                                "CAPES-Mary Ann Liebert" => "Mary Ann Liebert",
                                "CAPES-Outros editores" => "Outros editores",
                                "CAPES-OVID" => "CAPES-OVID",
                                "CAPES-Oxford University Press" => "CAPES-Oxford University Press",
                                "CAPES-PePSIC" => "CAPES-PePSIC",
                                "CAPES-PMC" => "CAPES-PMC",
                                "CAPES-Sage" => "CAPES-Sage",
                                "CAPES-SciELO" => "CAPES-SciELO",
                                "CAPES – ASCB" => "CAPES – ASCB",
                                "CAPES-Springer" => "CAPES-Springer",
                                "CAPES-SDO" => "Science Direct",
                                "CAPES-Thieme" => "CAPES-Thieme",
                                "CAPES-Wilson" => "CAPES-Wilson",
                                "CAPES-World Scientific" => "CAPES-World Scientific",
                                "CAPES-AAP" => "CAPES - AAP",
                                "CAPES-APS" => "CAPES-APS",
                                "CAPES–Academy of Operative Dentistry" => "CAPES – Academy of Operative Dentistry",
                                "CAPES–AMA" => "CAPES – AMA",
                                "CAPES-American Academy of Audiology" => "CAPES- American Academy of Audiology",
                                "CAPES-American Academy of Psychiatry and the Law",
                                "CAPES-American Association  of Critical  Care Nurses" => "CAPES- American Association  of Critical  Care Nurses",
                                "CAPES-American Association of Veterinary Laboratory Diag" => "CAPES- American Association of Veterinary Laboratory Diag",
                                "CAPES-APA" => "CAPES - APA",
                                "CAPES–Mary Ann Liebert" => "CAPES –Mary Ann Liebert",
                                "CAPES-American Society for Biochemistry and Molecular Biology",
                                "CAPES-American Society for Investigative Pathology" => "CAPES-American Society for Investigative Pathology",
                                "CAPES-American Society of Hematology" => "CAPES-American Society of Hematology",
                                "CAPES–Annual Reviews" => "CAPES – Annual Reviews",
                                "CAPES–Cold Spring Harbor Laboratory" => "CAPES – Cold Spring Harbor Laboratory",
                                "CAPES-Endocrine Society" => "CAPES-Endocrine Society",
                                "CAPES-FDI World Dental Federation" => "CAPES- FDI World Dental Federation",
                                "CAPES-Fed. of American Societies for Experimental Bi" => "CAPES- Fed. of American Societies for Experimental Bi",
                                "CAPES-Genetics Society of America" => "CAPES- Genetics Society of America",
                                "CAPES-Gerontological Society of America" => "CAPES- Gerontological Society of America",
                                "CAPES-Guilford Press" => "CAPES- Guilford Press",
                                "CAPES-Massachusetts Medical Society" => "CAPES- Massachusetts Medical Society",
                                "CAPES-Royal College of Psychiatrists" => "CAPES- Royal College of Psychiatrists",
                                "CAPES-Science Direct" => "CAPES - Science Direct",
                                "CAPES–Science Direct Massom" => "CAPES – Science Direct Massom",
                                "CAPES–Science Direct Cell Press" => "CAPES – Science Direct Cell Press",
                                "CAPES–Science Direct Clinics" => "CAPES – Science Direct Clinics",
                                "CAPES–Slack Inc." => "CAPES – Slack Inc.",
                                "CAPES–Society for Leucocyte Biology" => "CAPES – Society for Leucocyte Biology",
                                "CAPES–Wiley Blackwell" => "CAPES – Wiley Blackwell",
                                "CAPES–Benthan Science" => "CAPES – Benthan Science",
                                "CAPES–Begel House" => "CAPES – Begel House",
                                "CAPES-AIP" => "CAPES- AIP",
                                "Editor" => "Editor",
                                "Elsevier" => "Elsevier",
                                "PePSIC" => "PePSIC",
                                "PubMed" => "PubMed",
                                "SciELO" => "SciELO",
                            );
$BVS_LANG["optAccessType"] = array(
                                "Free" => "Free",
                                "Free To Subscripters" => "Free To Subscripters",
                                "Demand online subscription" => "Demand online subscription",
                                "Demand print subscription" => "Demand print subscription",
                                "Demand online/print subscription" => "Demand online/print subscription"
                               );
$BVS_LANG["optControlAccess"] = array(
                                "Free" => "Free",
                                "IP" => "IP",
                                "Password" => "Password",
                                "IP/Password" => "IP/Password"
                                );

/*** End - Form Lists or Multiple Itens ***/


	/****************************************************************************************************/
	/**************************************** Mask Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["lblCopyMaskTo"] = "Based on Mask";
$BVS_LANG["lblNone"] = "None";
$BVS_LANG["lblMaskName"] = "Mask name";
$BVS_LANG["lblNotes"] = "Scope note";
$BVS_LANG["lblFrequency"] = "Frequency";
$BVS_LANG["lblVolume"] = "Volumes";
$BVS_LANG["lblNumber"] = "Issues";
$BVS_LANG["btNewMask"] = "New Mask";
$BVS_LANG["helperMaskForm"] = "To finish entry, click Save, or click other Steps at right to continue entering data.";
$BVS_LANG["optIndexesMask"] = array("" => "All Indexes","NOM" => "Mask name", "DES" => "Description");
$BVS_LANG["optInfiniteFinite"] = array("0" => "Infinite","1" => "Finite");


	/****************************************************************************************************/
	/**************************************** Users Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["user"] = "User";
$BVS_LANG["preferences"] = "My Preferences";
$BVS_LANG["users"] = "Users";
$BVS_LANG["lblUsersAcr"] = "Initials";
$BVS_LANG["lblRole"] = "Access type";
$BVS_LANG["lblCenterCod"] = "Center Code";
$BVS_LANG["lblName"] = "Name";
$BVS_LANG["lblFullname"] = "Full name";
$BVS_LANG["lblInstitution"] = "Institution";
$BVS_LANG["lblUsersAdm"] = "User administration";
$BVS_LANG["lblFormView"] = "View Form";
$BVS_LANG["lblEmail"] = "E-mail";
$BVS_LANG["lblcPassword"] = "Confirm Password";
$BVS_LANG["btEdUsers"] = "Edit User";
$BVS_LANG["optSelValue"] = "Select a Library";
$BVS_LANG["optRole"] = array(""=> "Select a Profile", "Editor"=>"Editor"); /* , "Administrator"=>"Administrator" */
$BVS_LANG["optIndexesUsers"] = array("" => "All Indexes", "USR" => "Username", "NAM" => "Name");
$BVS_LANG["optFormView"] = array("Standard" => "Standart Form","Bireme" => "Bireme Form");
$BVS_LANG["optSysLang"] = array("en" => "English", "es" => "Spanish", "fr" => "French", "pt" => "Portuguese" );


	/****************************************************************************************************/
	/**************************************** Login Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["portuguese"] = "Portugu&#234;s";
$BVS_LANG["english"] = "English";
$BVS_LANG["espanish"] = "Espa&#241;ol";
$BVS_LANG["french"] = "Fran&#231;ais";
$BVS_LANG["lblUsername"] = "User name";
$BVS_LANG["lblPassword"] = "Password";
$BVS_LANG["lblKeepMeSigned"] = "Stay signed in until";
$BVS_LANG["lblForgetMyPassword"] = "Forgot password";
$BVS_LANG["lblLogIn"] = "Login";
$BVS_LANG["lblAdm"] = "Administrator";
$BVS_LANG["lblDoc"] = "Data Entry";
$BVS_LANG["lblLogIn"] = "Login";
$BVS_LANG["errorLogIn"] = "User and/or password invalid, please try again.";
$BVS_LANG["errorWrongLibrary"] = "You don´t have permission to access this library.";
$BVS_LANG["errorSelectLibrary"] = "Please, select a library.";
$BVS_LANG["msgFailLogin"] = "User and/or password invalid";
$BVS_LANG["msgSuccessLogOff"] = "Logged out successfully";


	/****************************************************************************************************/
	/**************************************** Error and Success Messages ****************************************/
	/****************************************************************************************************/

$BVS_LANG["msgSelectLibrary"] = "Please select a Library";
$BVS_LANG["error404"] = "Error 404 - Page not found";
$BVS_LANG["requiredField"] = "Field is mandatory";
$BVS_LANG["difPass"] = "Password and Confirm Password fields are different";
$BVS_LANG["usedMask"] = "Masks in use";
$BVS_LANG["mSuccess"] = "Success!";
$BVS_LANG["mFail"] = "Attention:";
$BVS_LANG["msg_op_fail"] = "It was not possible to complete this operation";
$BVS_LANG["sucessSaveRecord"] = "Record successfully saved";
$BVS_LANG["sucessDeleteRecord"] = "Record successfully deleted";
$BVS_LANG["failSaveRecord"] = "It was not possible to save this record";
$BVS_LANG["listActions"] = "Actions: Now you can";
$BVS_LANG["doYouComfirmThisAction"] = "Do you confirm this action?";
$BVS_LANG["confirmAction"] = "Execute action";
$BVS_LANG["confirmDelete"] = "Do you really want to delete this record?";
$BVS_LANG["actionDeleteRegister"] = "Delete Record";
$BVS_LANG["ActionTitle"] = "Actions on Title"; 
$BVS_LANG["ActionFacic"] = "Actions on Issues";
$BVS_LANG["requiredNameMask"] = "Mandatory field, enter name of New Mask";
$BVS_LANG["errorImport"] = "Upload file error";
$BVS_LANG["permissionError"] = "Permision error";
$BVS_LANG["lockError"] = "Create lock error";

	/****************************************************************************************************/
	/**************************************** Issue Section - Form and List ****************************************/
	/****************************************************************************************************/
$BVS_LANG["msgInvalidMaskForThisFacic"] = "Invalid mask for this issue";
$BVS_LANG["lblInventoryNumber"] = "Inventory Number";
$BVS_LANG["lblEAddress"] = "Electronic Address";
$BVS_LANG["lblPubTitle"] = "Publication Title";
$BVS_LANG["lblTextualDesignation"] = "Textual designation and/or specific designation";
$BVS_LANG["lblStandardizedDate"] = "Standardized Date";
$BVS_LANG["lblQtd"] = "Number of copies";
$BVS_LANG["lblColQtd"] = "Qty";
$BVS_LANG["lblPubSt"] = "Publication status";
$BVS_LANG["lblColPA"] = "P/A";
$BVS_LANG["lblPubType"] = "Publication type";
$BVS_LANG["lblColPubType"] = "Type";
$BVS_LANG["lblNote"] = "Note";
$BVS_LANG["lblYear"] = "Year";
$BVS_LANG["lblVol"] = "Volume";
$BVS_LANG["lblIssueNumber"]  = "Number";
$BVS_LANG["lblViewHldg"] = "View holdings";
$BVS_LANG["lblHldg"] = "Holdings compacted";
$BVS_LANG["lblHldgMessage"] = "Compacting...";
$BVS_LANG["msgWaiting"] = "Wait...";

$BVS_LANG["lblInsertRange"] = "Insert a range";
$BVS_LANG["lblSelectMask"] = "Please select a mask";
$BVS_LANG["optIndexesFacic"] = array("" => "", "AN" => "Year", "VF" => "Volume and Issue", "ST" => "Status" );
$BVS_LANG["optPubType"] = array("" => "Select",
                                "S" => "Supplement",
                                "NE" => "Special Issue",
                                "IN" => "Index",
                                "AN" => "Yearbook",
                                "PT" => "Part",
                                "BI" => "Supplement identified with bis",
                                "E" => "Electronic"
                                );
$BVS_LANG["optPubSt"] = array("P" => "Present",
                              "A" => "Not present",
                              "N" => "Not Published",
                              "I" => "Interrupted"
                              );



	/****************************************************************************************************/
	/**************************************** TitlePlus Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["titlePlus"] = "Title Plus";
$BVS_LANG["lblTitlePlus"] = "Title Plus";
$BVS_LANG["lblAcquisitionMethod"] = "Acquisition method";
$BVS_LANG["lblAcquisitionControl"] = "Acquisition control";
$BVS_LANG["lblExpirationSubs"] = "Expiration date";
$BVS_LANG["lblAcquisitionPriority"] = "Aquisition priority";
$BVS_LANG["lblAdmNotes"] = "Administrative Notes";
$BVS_LANG["lblProvider"] = "Vendor/Provider";
$BVS_LANG["lblProviderNotes"] = "Vendor/Provider Notes";
$BVS_LANG["lblReceivedExchange"] = "Received in Exchange of";
$BVS_LANG["lblDonorNotes"] = "Donor notes";
$BVS_LANG["lblLocationRoom"] = "Call number";
$BVS_LANG["lblEstMap"] = "Shelf Map";
$BVS_LANG["lblOwnClassif"] = "Local  Classification";
$BVS_LANG["lblOwnDesc"] = "Local  Descriptor";
$BVS_LANG["lblCreatDate"] = "Creation Date";
$BVS_LANG["lblModifDate"] = "Modification Date";
$BVS_LANG["lblDataEntryCreat"] = "Created by";
$BVS_LANG["lblDataEntryMod"] = "Modified by";
$BVS_LANG["lblissnOnline"] = "ISSN Online";
$BVS_LANG["lblActionTitPlus"] = "Actions on Title Plus";
$BVS_LANG["lblAcquisitionHistory"] = "Acquisition History";
$BVS_LANG["btInTitlePlus"] = "Insert Title Plus";
$BVS_LANG["btEdTitlePlus"] = "Edit Title Plus";
$BVS_LANG["optIndexesTitlePlus"] = array("" => "All Indexes",
                                        "I" => "Title ID",
                                        "TI" => "Words in Title",
                                        "TC" => "Full Title",
                                        "AM" => "Acquisition method",
                                        "AC" => "Acquisition control",
                                        "ES" => "Expiration date",
                                        "VE" => "Vendor/Provider",
                                        "DE" => "Local Descriptors");
$BVS_LANG["optAcquisitionMethod"] = array("1" => "Paid",
                                            "2" => "Gift",
                                            "3" => "Exchange",
                                            "4" => "Other");
$BVS_LANG["optAcquisitionControl"] = array("0"=>"Unknown",
                                            "1" => "Current",
                                            "2" => "Not Current",
                                            "3" => "Closed",
                                            "4" => "Suspended");
$BVS_LANG["optAcquisitionPriority"] = array("1" => "For titles whose acquisition is essential for the informant center",
                                            "2" => "For titles whose purchase is dispensable, it exists in the country",
                                            "3" => "For titles whose purchase is dispensable, it exists in the region");
$BVS_LANG["optValAcq"] = array("1" => "1", "2" => "2", "3" => "3", "4" => "4");
$BVS_LANG["optValAcq2"] = array("1" => "1", "2" => "2", "3" => "3");
$BVS_LANG["helpGeneralTitlePlus"] = "To delete the content of a filled in field, leave it blank and save the record";
$BVS_LANG["btnDeleteLine"] = "Button to delete the occurrence";
$BVS_LANG["btnInsertLine"] = "Button to include the occurrence";
$BVS_LANG["lblSubFieldsv913"] = array(  'Purchase History',
                                        'Payment date of signature',
                                        'Amount paid by the signature',
                                        'Year that includes the signature',
                                        'Issues that includes the signature'
                                      );


	/****************************************************************************************************/
	/**************************************** Library Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["library"] = "Library";
$BVS_LANG["lblLibrary"] = "Library";
$BVS_LANG["lblLibFullname"] = "Library full name";
$BVS_LANG["lblLibCode"] = "Library Code";
$BVS_LANG["lblAddress"] = "Address";
$BVS_LANG["lblCity"] = "City";
$BVS_LANG["lblCountry"] = "Country";
$BVS_LANG["lblPhone"] = "Phone";
$BVS_LANG["lblContact"] = "Contact";
$BVS_LANG["lblEmail"] = "Email";
$BVS_LANG["btEdLibrary"] = "Edit Library";
$BVS_LANG["optIndexesLibrary"] = array("" => "All Indexes");
$BVS_LANG["errorSpaceNotAllowed"] = "Empty Spaces not Allowed";


	/****************************************************************************************************/
	/**************************************** Report Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["report"] = "Report";
$BVS_LANG["lblReport"] = "Report";
$BVS_LANG["lblReportLib"] = "Report by Library";
$BVS_LANG["lblReportDB"] = "Report by Database";
//Report By Library
$BVS_LANG["lblTitCurrColect"] = "Titles with current holdings";
$BVS_LANG["lblTitWCurrColect"] = "Titles without current holdings";
$BVS_LANG["lblTitFinishColect"] = "Titles with finished holdings";
$BVS_LANG["lblTitWithoutColect"] = "Titles without holdings";
$BVS_LANG["lblNumTitRegLib"] = "Number of titles registered";
$BVS_LANG["lblTotIssRegLib"] = "Total of issues registered";
//Report by Database
$BVS_LANG["lblIssuesBySupplier"] = "Issues: Duplicates or Absents (by Supplier)";
$BVS_LANG["lblTitPlusBySubsExp"] = "Title Plus:  Subscription that will expire / expired";
$BVS_LANG["lblTitPlusBySupplier"] = "Title Plus:  Supplier";
$BVS_LANG["lblTotTitFreeEletronicAccess"] = "Total of titles by free eletronic access";
$BVS_LANG["lblTotTitControlEletronicAccess"] = "Total of titles by controlled or conditioned electronic access";
$BVS_LANG["lblTotTitOneColection"] = "Total of titles with one collection in catalog";
$BVS_LANG["lblTotTitMoreColection"] = "Total of titles with more than one collection in catalog";
$BVS_LANG["lblTotTitWithoutColection"] = "Total of titles with no collection in catalog";
$BVS_LANG["lblTotTitByDonation"] = "Total of titles by Donation";
$BVS_LANG["lblTotTitByPermute"] = "Total of titles by Exchange";
$BVS_LANG["lblTotTitByBuying"] = "Total of titles by Paid";
$BVS_LANG["lblIDNumber"] = "Identification Number";
$BVS_LANG["lblTotColectionBireme"] = "Total holdings registered by each library of the Bireme network";
$BVS_LANG["lblTotTitBireme"] = "Total of titles registered by each library of the Bireme network";
$BVS_LANG["optReportAdm"] = array("" => "Please, select a Database", "title" => "Title", "facic" => "Issues", "titlePlus" => "titlePlus", "holdings" => "Holdings", "mask" => "Mask", "users" => "Users", "library" => "Library");
$BVS_LANG["optReportEdt"] = array("" => "Please, select a Database", "facic" => "Issues", "titlePlus" => "titlePlus", "holdings" => "Holdings");
$BVS_LANG["optReportDoc"] = array("" => "Please, select a Database", "facic" => "Issues", "titlePlus" => "titlePlus");
$BVS_LANG["lblReportEmpty"] = "There are no itens for this report";

	/****************************************************************************************************/
	/**************************************** Maintenance Section - Form and List ****************************************/
	/****************************************************************************************************/

$BVS_LANG["maintenance"] = "Maintenance";
$BVS_LANG["lblMaintenance"] = "Maintenance";
$BVS_LANG["lblSelDB"] = "Select a database";
$BVS_LANG["lblSelLib"] = "Select a library";
$BVS_LANG["lblSelFormat"] = "Select a format";
$BVS_LANG["lblImportTit"] = "Import Titles";
$BVS_LANG["lblExportTit"] = "Export Titles";
$BVS_LANG["lblExportCatalog"] = "Export Catalog";
$BVS_LANG["lblUnlockDB"] = "Unlock Databases";
$BVS_LANG["lblInvertDB"] = "Full Inversion Databases";
$BVS_LANG["lblImportFacic"] = "Import Issues";
$BVS_LANG["optExportTit"] = array("ISO" => "ISO Format", "MARC" => "MARC Format");


?>