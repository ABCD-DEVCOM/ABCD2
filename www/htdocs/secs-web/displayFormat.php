<?php
/**
 * @file:	displayFormat.php
 * @desc:	Main file, System Controller
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @since:      2009-11-18
 * @copyright:  (c) 2009 BIREME/PAHO/WHO - PFI
 ******************************************************************************/

require_once("./common/ini/config.ini.php");

/*
 * Erro se o usuarios nao esta logados no sistema
 */
if(!isset($_SESSION["identified"]) || $_SESSION["identified"]!=1 )
{
	die($BVS_LANG["error404"]);
}	

	//Dependendo da Base selecionada envocamos o a funcao que ira formatar os dados
	//para serem enviados ao dataset
	if(isset($_REQUEST["m"]) && !preg_match("=/=",$_REQUEST["m"])){
            switch ($_REQUEST['m']) {
                case 'facic':
                        $dataModel = new title();
                        $formatedRecords = displayFacic($dataModel);
                        break;
                case 'title':
                        $dataModel = new title();
                        $formatedRecords = displayTitle($dataModel, $_REQUEST["edit"], $_REQUEST["format"]);
                        break;
                case 'titleplus':
                        $dataModel = new titleplus();
                        $formatedRecords = displayTitlePlus($dataModel,$_REQUEST["edit"]);
                        break;
                case 'import':
                        $formatedRecords = importFile();
                        break;
                case 'reverseDB':
                        $formatedRecords = reverseDatabase();
                        break;
                case 'unlockDB':
                        $formatedRecords = unlockDatabase();
                        break;
                 case 'report':
                        $dataModel = new title();
                        $formatedRecords = report($dataModel);
                        break;
            }
	}

function report($dataModel){
//displayFormat.php?m=report&format=lblTitCurrColect
//$editRequest = "178";
//, $format
$title = $dataModel->getRecords();

    switch ($_REQUEST['format']) {
        case 'lblTitCurrColect':
                break;

    }
    
    /* Head Information */
    $content = "";
    if($title[0][30]){ $content .= "[". $title[0][30]."] "; }
    if($title[0][100]){ $content .= $title[0][100]; }
    if($title[0][110]){ $content .= ": ".$title[0][110]; }
    if($title[0][120]){ $content .= ". ".$title[0][120]; }
    if($title[0][130]){ $content .= ", ".$title[0][130]; }
    if($title[0][400]){ $content .= " (".$title[0][400].") "; }
    /*if($title[230][0]){ $content .= " = ".$title[230][0]; }
    if($title[301][0]){ $content .= ".-- Vol.".$title[301][0]; }
    if($title[302][0]){ $content .= " ( ".$title[302][0].")"; }
    if($title[303][0]){ $content .= " no.".$title[303][0]; }
    if($title[304][0]){ $content .= " no.".$title[304][0]; }
    if($title[305][0]){ $content .= " no.".$title[305][0]; }
    if($title[306][0]){ $content .= " no.".$title[306][0]; }
    if($title[490][0]){ $content .= " ".$title[490][0].":"; }
    if($title[480][0]){ $content .= " ".$title[480][0].". "; }*/
    $content .= " <br/><br/>";
    
    if($content == " <br/><br/>"){
        $content = "empty";
    }

    print $content;
}


function unlockDatabase(){

}

function reverseDatabase(){

    $strInitialPosition = stripos($_SERVER["SERVER_SOFTWARE"],"Win32");
    $serverOS = substr($_SERVER["SERVER_SOFTWARE"], $strInitialPosition, "5");
    $selectedDB = $_REQUEST["database"];
    if($selectedDB == "facic" || $selectedDB == "titlePlus" || $selectedDB == "holdings"){
        $libraryDir = $_SESSION["libraryDir"];
    }

    if($serverOS == "Win32"){
        //Variaveis para Windows
        $pathMX = BVS_DIR."\\cgi-bin\\mx";
        if(isset($libraryDir)){
            $selectedDB = $libraryDir."\\".$selectedDB;
        }
        $pathDB = BVS_DIR."\\bases\\secs-web\\".$selectedDB;
    }else{
        //Variaveis para Linux
        $pathMX = BVS_DIR."/cgi-bin/mx";
        if(isset($libraryDir)){
            $selectedDB = $libraryDir."/".$selectedDB;
        }
        $pathDB = BVS_DIR."/bases/secs-web/".$selectedDB;
    }

    $reverseCommand = $pathMX." ".$pathDB." \"fst=@".$pathDB.".fst\" fullinv/ansi=".$pathDB." -all now";
    exec($reverseCommand);
    //print $reverseCommand;

}

function display_filesize($filesize){

    if(is_numeric($filesize)){
    $decr = 1024; $step = 0;
    $prefix = array('Byte','KB','MB','GB','TB','PB');

    while(($filesize / $decr) > 0.9){
        $filesize = $filesize / $decr;
        $step++;
    }
    return round($filesize,2).' '.$prefix[$step];
    } else {

    return 'NaN';
    }

}

function checkExtension($extension){
    $BVS_CONF['allow_ext'] = array("txt","lst","iso","002");
    $result =  array_search($extension, $BVS_CONF['allow_ext']);
    if($result){
        return;
    }else{
         throw new Exception("Forbiden file extension ".$extension."!");
    }
}


function checkFilesize($filesize){

    $maxFilesize = 40000; //in bites, default 40Kb
    if($filesize < $maxFilesize){
        return;
    }else{
        //deixango o tamanho do arquivo mais legivel para o usuario
        $filesize = display_filesize($filesize);
        throw new Exception("File has more than 5KB, it have ".$filesize);
    }
}

function importFile(){

        $strInitialPosition = stripos($_SERVER["SERVER_SOFTWARE"],"Win32");
        $serverOS = substr($_SERVER["SERVER_SOFTWARE"], $strInitialPosition, "5");
        if($serverOS == "Win32"){
            //Variaveis para Windows
            $pathMX = BVS_DIR."\\cgi-bin\\mx";
            $uploaddir = BVS_DIR."\\temp\\secs-web\\importedFiles\\";
        }else{
            //Variaveis para Linux
            $pathMX = BVS_DIR."/cgi-bin/mx";
            $uploaddir = BVS_DIR."/temp/secs-web/importedFiles/";
        }

    $uploadfile = $uploaddir . $_FILES['importFile']['name'];
    $extension = end(explode(".", $_FILES['importFile']['name']));
    $filesize = $_FILES['importFile']['size'];

    try{
        checkExtension($extension);
        checkFilesize($filesize);
    }
    catch(Exception $error)
    {
        print $error->getMessage();
        die;
    }

    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploaddir . $_FILES['importFile']['name'])) {
        
        $importedFile = file($uploadfile);
        for($i=0; $i<count($importedFile); $i++){

            $dataModel = new facicOperations();
            $temporaryArray = explode('|', $importedFile[$i]);
            $array_content = array(
                        "database" => "FACIC",
                        "centerCode" => $temporaryArray[0],
                        "titleCode" => $temporaryArray[1],
                        "codeNameMask" => $temporaryArray[2],
                        "year" => $temporaryArray[3],
                        "volume" => $temporaryArray[4],
                        "issue" => $temporaryArray[5],
                        "number" => $temporaryArray[6],
                        "creationDate" => date('Ymd'),
                        "changeDate" => date('Ymd'),
                        "documentalistCreation" => $_SESSION["logged"],
                        "documentalistChange" => $_SESSION["logged"]
                    );
            
            print "Registro #".$i." incluido com sucesso<br/>";
            $dataModel->createRecord($array_content);
            $dataModel->saveRecord("New");
        }
 
    } else {
        //user_error($BVS_LANG["errorImport"],E_USER_ERROR);
        print "error: ";
        print_r($_FILES);
    }

}

function  displayTitle($dataModel, $editRequest, $format){

    global $BVS_LANG, $BVS_CONF,$configurator;

    $title = $dataModel->getRecordByMFN($editRequest);
    /* Head Information */
    $content = "";
    if($title[30][0]){ $content .= '[ '.$title[30][0].' ] '; }
    if($title[100][0]){ $content .= strtoupper($title[100][0]); }
    if($title[110][0]){ $content .= ": ".strtoupper($title[110][0]); }
    if($title[120][0]){ $content .= ". ".$title[120][0]; }
    if($title[130][0]){ $content .= ", ".$title[130][0]; }
    if($title[140][0]){ $content .= " / ".$title[140][0]; }
    if($title[230][0]){ $content .= " = ".$title[230][0]; }
    if($title[301][0]){ $content .= ".-- Vol.".$title[302][0].','; }
    if($title[303][0]){ $content .= " no.".$title[303][0]; }
    if($title[302][0]){ $content .= " ( ".$title[301][0].")"; }
    if($title[304][0] || $title[305][0] || $title[306][0]){ 
        $content .= '- Vol.'. $title[305][0];
        if($title[305][0] && $title[306][0]){
            $content .= ', ';
        }
        $content .= ' no.'.$title[306][0] ;
        $content .= ' ('.$title[304][0].') ' ;
    }else{
        $content .= '- .';
    }
    if($title[490][0]){ $content .= "-- ".$title[490][0]; }
    if($title[480][0]){ $content .= " : ".$title[480][0].". "; }
    $content .= " <br/><br/>";

    switch ($format) {
        case "short":
            
            if($title[400][0]){ $content .= $BVS_LANG['lblissn'].": ".$title[400][0]."<br/>"; }
            if($title[150][0]){ $content .= $BVS_LANG['lblabbreviatedTitle'].": ".$title[150][0]."<br/>"; }
            break;

        case "long":
            if($title[200][0]){ $content .= $BVS_LANG['lblexpandedFormsOfTitle'].": ".$title[200][0]."<br/>"; }
            if($title[240][0]){ $content .= $BVS_LANG['lblotherTitle'].": ".$title[240][0]."<br/>"; }
            if($title[610][0]){ $content .= $BVS_LANG['lbltitleContinuationOf'].": ".$title[610][0]."<br/>"; }
            if($title[620][0]){ $content .= $BVS_LANG['lbltitlePartialContinuationOf'].": ".$title[620][0]."<br/>"; }
            if($title[650][0]){ $content .= $BVS_LANG['lbltitleAbsorbed'].": ".$title[650][0]."<br/>"; }
            if($title[660][0]){ $content .= $BVS_LANG['lbltitleAbsorbedInPart'].": ".$title[660][0]."<br/>"; }
            if($title[670][0]){ $content .= $BVS_LANG['lbltitleFormedByTheSplittingOf'].": ".$title[670][0]."<br/>"; }
            if($title[680][0]){ $content .= $BVS_LANG['lbltitleMergeOfWith'].": ".$title[680][0]."<br/>"; }
            if($title[710][0]){ $content .= $BVS_LANG['lbltitleContinuedBy'].": ".$title[710][0]."<br/>"; }
            if($title[720][0]){ $content .= $BVS_LANG['lbltitleContinuedInPartBy'].": ".$title[720][0]."<br/>"; }
            if($title[750][0]){ $content .= $BVS_LANG['lbltitleAbsorbedBy'].": ".$title[750][0]."<br/>"; }
            if($title[760][0]){ $content .= $BVS_LANG['lbltitleAbsorbedInPartBy'].": ".$title[760][0]."<br/>"; }
            if($title[770][0]){ $content .= $BVS_LANG['lbltitleSplitInto'].": ".$title[770][0]."<br/>"; }
            if($title[780][0]){ $content .= $BVS_LANG['lbltitleMergedWith'].": ".$title[780][0]."<br/>"; }
            if($title[790][0]){ $content .= $BVS_LANG['lbltitleToForm'].": ".$title[790][0]."<br/>"; }
            if($title[510][0]){ $content .= $BVS_LANG['lbltitleHasOtherLanguageEditions'].": ".$title[510][0]."<br/>"; }
            if($title[520][0]){ $content .= $BVS_LANG['lbltitleAnotherLanguageEdition'].": ".$title[520][0]."<br/>"; }
            if($title[530][0]){ $content .= $BVS_LANG['lbltitleHasSubseries'].": ".$title[530][0]."<br/>"; }
            if($title[540][0]){ $content .= $BVS_LANG['lbltitleIsSubseriesOf'].": ".$title[540][0]."<br/>"; }
            if($title[550][0]){ $content .= $BVS_LANG['lbltitleHasSupplementInsert'].": ".$title[550][0]."<br/>"; }
            if($title[560][0]){ $content .= $BVS_LANG['lbltitleIsSupplementInsertOf'].": ".$title[560][0]."<br/>"; }
            if($title[400][0]){ $content .= $BVS_LANG['lblissn'].": ".$title[400][0]."<br/>"; }
            if($title[150][0]){ $content .= $BVS_LANG['lblabbreviatedTitle'].": ".$title[150][0]."<br/>"; }
            break;

        case "full":
            $content = '';
            $content .= "MFN = ".$editRequest."<br/>";
            if($title[1][0]){ $content .= $BVS_LANG['lblDatabase']." [001] = ".$title[1][0]."<br/>"; }
            if($title[5][0]){ $content .= $BVS_LANG['lblliteratureType']." [005] = ".$title[5][0]."<br/>"; }
            if($title[6][0]){ $content .= $BVS_LANG['lbltreatmentLevel']." [006] = ".$title[6][0]."<br/>"; }
            if($title[10][0]){ $content .= $BVS_LANG['lblCenterCod']." [010] = ".$title[10][0]."<br/>"; }
            if($title[20][0]){ $content .= $BVS_LANG['lblnationalCode']." [020] = ".$title[20][0]."<br/>"; }
            if($title[37][0]){ $content .= $BVS_LANG['lblsecsIdentification']." [037] = ".$title[37][0]."<br/>"; }
            if($title[40][0]){ $content .= $BVS_LANG['lblrelatedSystems']." [040] = ".$title[40][0]."<br/>"; }
            if($title[50][0]){ $content .= $BVS_LANG['lblpublicationStatus']." [050] = ".$title[50][0]."<br/>"; }
            if($title[100][0]){ $content .= $BVS_LANG['lblpublicationTitle']." [100] = ".$title[100][0]."<br/>"; }
            if($title[120][0]){ $content .= $BVS_LANG['lblsubtitle']." [120] = ".$title[120][0]."<br/>"; }
            if($title[130][0]){ $content .= $BVS_LANG['lbltitleOfSectionPart']." [130] = ".$title[130][0]."<br/>"; }
            if($title[140][0]){ $content .= $BVS_LANG['lblnameOfIssuingBody']." [140] = ".$title[140][0]."<br/>"; }
            if($title[149][0]){ $content .= $BVS_LANG['lblkeyTitle']." [149] = ".$title[149][0]."<br/>"; }
            if($title[150][0]){ $content .= $BVS_LANG['lblabbreviatedTitle']." [150] = ".$title[150][0]."<br/>"; }
            if($title[180][0]){ $content .= $BVS_LANG['lblabbreviatedTitleMedline']." [180] = ".$title[180][0]."<br/>"; }
            if($title[230][0]){ $content .= $BVS_LANG['lblparallelTitle']." [230] = ".$title[230][0]."<br/>"; }
            if($title[240][0]){ $content .= $BVS_LANG['lblotherTitle']." [240] = ".$title[240][0]."<br/>"; }
            if($title[301][0]){ $content .= $BVS_LANG['lblinitialDate']." [301] = ".$title[301][0]."<br/>"; }
            if($title[302][0]){ $content .= $BVS_LANG['lblinitialVolume']." [302] = ".$title[302][0]."<br/>"; }
            if($title[303][0]){ $content .= $BVS_LANG['lblinitialNumber']." [303] = ".$title[303][0]."<br/>"; }
            if($title[304][0]){ $content .= $BVS_LANG['lblfinalDate']." [304] = ".$title[304][0]."<br/>"; }
            if($title[305][0]){ $content .= $BVS_LANG['lblfinalVolume']." [305] = ".$title[305][0]."<br/>"; }
            if($title[306][0]){ $content .= $BVS_LANG['lblfinalNumber']." [306] = ".$title[306][0]."<br/>"; }
            if($title[310][0]){ $content .= $BVS_LANG['lblcountry']." [310] = ".$title[310][0]."<br/>"; }
            if($title[320][0]){ $content .= $BVS_LANG['lblstate']." [320] = ".$title[320][0]."<br/>"; }
            if($title[330][0]){ $content .= $BVS_LANG['lblpublicationLevel']." [330] = ".$title[330][0]."<br/>"; }
            if($title[340][0]){ $content .= $BVS_LANG['lblalphabetTitle']." [340] = ".$title[340][0]."<br/>"; }
            if($title[350][0]){ $content .= $BVS_LANG['lbllanguageText']." [350] = ".$title[350][0]."<br/>"; }
            if($title[360][0]){ $content .= $BVS_LANG['lbllanguageAbstract']." [360] = ".$title[360][0]."<br/>"; }
            if($title[380][0]){ $content .= $BVS_LANG['lblFrequency']." [380] = ".$title[380][0]."<br/>"; }
            if($title[400][0]){ $content .= $BVS_LANG['lblissn']." [400] = ".$title[400][0]."<br/>"; }
            if($title[410][0]){ $content .= $BVS_LANG['lblcoden']." [410] = ".$title[410][0]."<br/>"; }
            if($title[420][0]){ $content .= $BVS_LANG['lblmedlineCode']." [420] = ".$title[420][0]."<br/>"; }
            if($title[421][0]){ $content .= $BVS_LANG['lblclassificationCdu']." [421] = ".$title[421][0]."<br/>"; }
            if($title[422][0]){ $content .= $BVS_LANG['lblclassificationDewey']." [422] = ".$title[422][0]."<br/>"; }
            if($title[430][0]){ $content .= $BVS_LANG['lblclassification']." [430] = ".$title[430][0]."<br/>"; }
            if($title[435][0]){ $content .= $BVS_LANG['lblthematicaArea']." [435] = ".$title[435][0]."<br/>"; }
            if($title[436][0]){ $content .= $BVS_LANG['lblspecialtyVHL']." [436] = ".$title[436][0]."<br/>"; }
            if($title[440][0]){ $content .= $BVS_LANG['lbldescriptors']." [440] = ".$title[440][0]."<br/>"; }
            if($title[441][0]){ $content .= $BVS_LANG['lblotherDescriptors']." [441] = ".$title[441][0]."<br/>"; }
            if($title[445][0]){ $content .= $BVS_LANG['lbluserVHL']." [445] = ".$title[445][0]."<br/>"; }
            if($title[450][0]){ $content .= $BVS_LANG['lblindexingCoverage']." [450] = ".$title[450][0]."<br/>"; }
            if($title[470][0]){ $content .= $BVS_LANG['lblmethodAcquisition']." [470] = ".$title[470][0]."<br/>"; }
            if($title[480][0]){ $content .= $BVS_LANG['lblpublisher']." [480] = ".$title[480][0]."<br/>"; }
            if($title[490][0]){ $content .= $BVS_LANG['lblplace']." [490] = ".$title[490][0]."<br/>"; }
            if($title[510][0]){ $content .= $BVS_LANG['lbltitleHasOtherLanguageEditions']." [510] = ".$title[510][0]."<br/>"; }
            if($title[520][0]){ $content .= $BVS_LANG['lbltitleAnotherLanguageEdition']." [520] = ".$title[520][0]."<br/>"; }
            if($title[530][0]){ $content .= $BVS_LANG['lbltitleHasSubseries']." [530] = ".$title[530][0]."<br/>"; }
            if($title[540][0]){ $content .= $BVS_LANG['lbltitleIsSubseriesOf']." [540] = ".$title[540][0]."<br/>"; }
            if($title[550][0]){ $content .= $BVS_LANG['lbltitleHasSupplementInsert']." [550] = ".$title[550][0]."<br/>"; }
            if($title[560][0]){ $content .= $BVS_LANG['lbltitleIsSupplementInsertOf']." [560] = ".$title[560][0]."<br/>"; }
            if($title[610][0]){ $content .= $BVS_LANG['lbltitleContinuationOf']." [610] = ".$title[610][0]."<br/>"; }
            if($title[620][0]){ $content .= $BVS_LANG['lbltitlePartialContinuationOf']." [620] = ".$title[620][0]."<br/>"; }
            if($title[650][0]){ $content .= $BVS_LANG['lbltitleAbsorbed']." [650] = ".$title[650][0]."<br/>"; }
            if($title[660][0]){ $content .= $BVS_LANG['lbltitleAbsorbedInPart']." [660] = ".$title[660][0]."<br/>"; }
            if($title[670][0]){ $content .= $BVS_LANG['lbltitleFormedByTheSplittingOf']."  [670] = ".$title[670][0]."<br/>"; }
            if($title[680][0]){ $content .= $BVS_LANG['lbltitleMergeOfWith']."[680] = ".$title[680][0]."<br/>"; }
            if($title[710][0]){ $content .= $BVS_LANG['lbltitleContinuedBy']." [710] = ".$title[710][0]."<br/>"; }
            if($title[720][0]){ $content .= $BVS_LANG['lbltitleContinuedInPartBy']." [720] = ".$title[720][0]."<br/>"; }
            if($title[750][0]){ $content .= $BVS_LANG['lbltitleAbsorbedBy']." [750] = ".$title[750][0]."<br/>"; }
            if($title[760][0]){ $content .= $BVS_LANG['lbltitleAbsorbedInPartBy']." [760] = ".$title[760][0]."<br/>"; }
            if($title[770][0]){ $content .= $BVS_LANG['lbltitleSplitInto']." [770] = ".$title[770][0]."<br/>"; }
            if($title[780][0]){ $content .= $BVS_LANG['lbltitleMergedWith']." [780] = ".$title[780][0]."<br/>"; }
            if($title[790][0]){ $content .= $BVS_LANG['lbltitleToForm']." [790] = ".$title[790][0]."<br/>"; }
            if($title[860][0]){ $content .= $BVS_LANG['lblurlInformation']." [860] = ".$title[860][0]."<br/>"; }
            if($title[900][0]){ $content .= $BVS_LANG['lblnotes']." [900] = ".$title[900][0]."<br/>"; }
            if($title[910][0]){ $content .= $BVS_LANG['lblnotesBVS']." [910] = ".$title[910][0]."<br/>"; }
            if($title[920][0]){ $content .= $BVS_LANG['lblwhoindex']." [920] = ".$title[920][0]."<br/>"; }
            if($title[930][0]){ $content .= $BVS_LANG['lblcodepublisher']." [930] = ".$title[930][0]."<br/>"; }
            if($title[999][0]){ $content .= $BVS_LANG['lblurlPortal']." [999] = ".$title[999][0]."<br/>"; }
            break;

        case "catalog":
            $allHoldings = getAllHoldings();
            $titleID = array_search($title[30][0], $allHoldings[0]);

            if($title[550][0]){ $content .= $BVS_LANG['lbltitleHasSupplementInsert'].": ".$title[550][0]."<br/>"; }
            if($title[400][0]){ $content .= $BVS_LANG['lblissn'].": ".$title[400][0]."<br/>"; }
            if($title[150][0]){ $content .= $BVS_LANG['lblabbreviatedTitle'].": ".$title[150][0]."<br/><br/>"; }

            if($titleID && $allHoldings[2][$titleID]){ $content .= $BVS_LANG['lblColection']. ': ' .$allHoldings[2][$titleID]."<br/><br/>"; }
           
            break;
        case "titleplus":
            if($title[301][0]){ $content .= $title[301][0]."<br/>"; }
            if($title[302][0]){ $content .= $title[302][0]."<br/>"; }
            if($title[303][0]){ $content .= $title[303][0]."<br/>"; }
            break;
    }

    if($content == " <br/><br/>"){
        $content = "empty";
    }
    
    print $content;

}

function  displayTitlePlus($dataModel,$editRequest){

    global $BVS_LANG;
    
    if(is_numeric($_REQUEST["title"])){
        
        //faz busca na titlePlus pelo titulo
        $titleFound = $dataModel->searchByTitle($_REQUEST["title"]);
        
        
        if ($titleFound){
                //se encontrar adiciona o mfn do registro para edicao na titleplus
                $editRequest = $titleFound->registro->mfn;
                $titlePlus = $dataModel->getRecordByMFN($editRequest);
        }

    }else{
        $titlePlus = $dataModel->getRecordByMFN($editRequest);
    }
    
     

    $content = "";
    if($titlePlus[10][0]){ $content .= $BVS_LANG['lblLibrary']." = ".$titlePlus[10][0]."<br/>"; }
    if($titlePlus[30][0]){ $content .= $BVS_LANG['lblrecordIdentification']." = ".$titlePlus[30][0]."<br/>"; }
    if($titlePlus[100][0]){ $content .= $BVS_LANG['lblpublicationTitle']." = ".$titlePlus[100][0]."<br/>"; }
    if($titlePlus[901][0]){ $content .= $BVS_LANG['lblAcquisitionMethod']." = ".$titlePlus[901][0]."<br/>"; }
    if($titlePlus[902][0]){  $content .= $BVS_LANG['lblAcquisitionControl']." = ".$titlePlus[902][0]."<br/>"; }
    if($titlePlus[906][0]){ $content .= $BVS_LANG['lblExpirationSubs']." = ".$titlePlus[906][0]."<br/>"; }
    if($titlePlus[946][0]){ $content .= $BVS_LANG['lblAcquisitionPriority']." = ".$titlePlus[946][0]."<br/>"; }
    if($titlePlus[911][0]){ $content .= $BVS_LANG['lblAdmNotes']." = ".$titlePlus[911][0]."<br/>"; }
    if($titlePlus[905][0]){ $content .= $BVS_LANG['lblProvider']." = ".$titlePlus[905][0]."<br/>"; }
    if($titlePlus[904][0]){ $content .= $BVS_LANG['lblProviderNotes']." = ".$titlePlus[904][0]."<br/>"; }
    if($titlePlus[903][0]){ $content .= $BVS_LANG['lblReceivedExchange']." = ".$titlePlus[903][0]."<br/>"; }
    if($titlePlus[912][0]){ $content .= $BVS_LANG['lblDonorNotes']." = ".$titlePlus[912][0]."<br/>"; }
    if($titlePlus[940][0]){ $content .= $BVS_LANG['lblCreatDate']." = ".$titlePlus[940][0]."<br/>"; }
    if($titlePlus[941][0]){ $content .= $BVS_LANG['lblModifDate']." = ".$titlePlus[941][0]."<br/>"; }
    if($titlePlus[950][0]){ $content .= $BVS_LANG['lblDataEntryCreat']." = ".$titlePlus[950][0]."<br/>"; }
    if($titlePlus[951][0]){ $content .= $BVS_LANG['lblDataEntryMod']." = ".$titlePlus[951][0]."<br/>"; }

    if($content == ""){
        $content = "empty";
    }
    print $content;

}



function  displayFacic($dataModel){

    if(is_numeric($_REQUEST["title"])){

        //faz busca na titlePlus pelo titulo
        $titleFound = $dataModel->searchByTitle($_REQUEST["title"]);

        if ($titleFound){
                //se encontrar adiciona o mfn do registro para edicao na titleplus
                $editRequest = $titleFound->registro->mfn;
                $title = $dataModel->getRecordByMFN($editRequest);
        }

    }else{
        $title = $dataModel->getRecordByMFN($editRequest);
    }

    $content = "";
    if($title[301][0]){ $content .= $title[301][0]; }

    if($content == ""){
        $content = "empty";
    }
    print $content;

}


/**
*@param string $param Receive a comand to starts or finalize the timer. This will mensure the load time of each page/query
*@param string $starttime Receive the value of start time if already called before with $param="start"
*/
function timer($param,$starttime)
{
    switch($param)
    {
        case"start":
            $mtime = microtime();
            $mtime = explode(" ",$mtime);
            $mtime = $mtime[1] + $mtime[0];
            $starttime = $mtime;
         $returnable = $starttime;
        break;
        case"finalize":
            $mtime = microtime();
            $mtime = explode(" ",$mtime);
            $mtime = $mtime[1] + $mtime[0];
            $endtime = $mtime;                      // Finaliza a variável de contagem do tempo de geração da página.
            $totaltime = ($endtime - $starttime);
            $returnable = round($totaltime,2);
        break;
    }

    return $returnable;
}
?>

