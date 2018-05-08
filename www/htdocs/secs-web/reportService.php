<?php
/**
 * @file:	reportService.php
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

//header('Content-type: application/json');
// Define defaults
$results = -1; // default get all
$startIndex = 0; // default start at 0
$sort = null; // default don't sort
$dir = 'asc'; // default sort dir is asc
$sort_dir = SORT_ASC;


//Number of records to get
if(strlen($_REQUEST['results']) > 0) {
    $results = $_REQUEST['results'];
}

//Start record
if(strlen($_REQUEST['startIndex']) > 0) {
    $startIndex = $_REQUEST['startIndex'];
}

//Sort
if(strlen($_REQUEST['sort']) > 0) {
    $sort = $_REQUEST['sort'];
}

//Sort dir
if((strlen($_REQUEST['dir']) > 0) && ($_REQUEST['dir'] == 'desc')) {
    $dir = 'desc';
    $sort_dir = SORT_DESC;
}
else {
    $dir = 'asc';
    $sort_dir = SORT_ASC;
}

$strInitialPosition = stripos($_SERVER["SERVER_SOFTWARE"],"Win32");
$serverOS = substr($_SERVER["SERVER_SOFTWARE"], $strInitialPosition, "5");

if($serverOS == "Win32"){
    //Variaveis para Windows
    $pathMX = BVS_DIR."\\cgi-bin\\ansi\\mx.exe";
    $pathMXTB = BVS_DIR."\\cgi-bin\\ansi\\mxtb.exe";
}else{
    //Variaveis para Linux
    $pathMX = BVS_DIR."/cgi-bin/ansi/mx";
    $pathMXTB = BVS_DIR."/cgi-bin/ansi/mxtb"; 
}



//Dependendo da Base selecionada invocamos a funcao que ira formatar os dados
//para serem enviados ao dataset
if(isset($_REQUEST["format"]) && !preg_match("=/=",$_REQUEST["format"])){

         //Recover the registers in the database
        switch ($_REQUEST['format']) {
                case 'titCurrColect':
                        $arrayRecords = makeRecords('title');
                        $formatedRecords = titCurrColect($arrayRecords);
                        $countFacic = $pathMXTB." ".$configurator->getPath2Facic()." create=".$configurator->getPath2TempFacic()." \"100:v30\"";
                        exec($countFacic);
                        $invertCommand = $pathMX." ".$configurator->getPath2TempFacic()." \"fst=1 0 v1\" fullinv/ansi=".$configurator->getPath2TempFacic()." -all now";
                        exec($invertCommand);
                        $atualDirectory = getcwd();
                        chdir(BVS_DIR."/bases/secs-web/".$LIBDIR);
                        $joinHldgTitle = $pathMX." ".$configurator->getPath2TempFacic()." \"join=holdings,970='TIT='v1\" \"proc='d32001'\" -all now copy=".$configurator->getPath2TempFacic();
                        exec($joinHldgTitle);
                        chdir($atualDirectory);
                        $arrayRecordsFacic = makeRecords('temp_facic');
                        printFormat('titCurrColect', $formatedRecords, $arrayRecordsFacic, $arrayRecordsHolding);
                        break;
                case 'titWCurrColect':
                        $arrayRecords = makeRecords('title');
                        $formatedRecords = titWCurrColect($arrayRecords);
                        printFormat('titWCurrColect', $formatedRecords, $arrayRecordsHolding);
                        break;
                case 'titFinishColect':
                        $arrayRecords = makeRecords('title');
                        $formatedRecords = titFinishColect($arrayRecords);
                        $arrayRecordsHolding = makeRecords('holding');
                        $countFacic = $pathMXTB." ".$configurator->getPath2Facic()." create=".$configurator->getPath2TempFacic()." \"100:v30\"";
                        exec($countFacic);
                        $invertCommand = $pathMX." ".$configurator->getPath2TempFacic()." \"fst=@".$configurator->getPath2Facic().".fst\" fullinv/ansi=".$configurator->getPath2TempFacic()." -all now";
                        exec($invertCommand);
                        $arrayRecordsHolding = makeRecords('temp_facic'); //Recover the registers in the database
                        printFormat('titFinishColect', $formatedRecords, $arrayRecordsHolding);
                        break;
                case 'titWithoutColect':
                        $arrayRecords = makeRecords('title');
                        $formatedRecords = titWithoutColect($arrayRecords);
                        printFormat('titWithoutColect', $formatedRecords, $arrayRecordsHolding);
                        break;
                case 'numTitRegLib':
                        $arrayRecords = makeRecords('titleplus');
                        print $BVS_LANG['lblNumTitRegLib'].": ".$arrayRecords[0][1002];
                        break;
                case 'totIssRegLib':
                        $arrayRecords = makeRecords('facic'); //Recover the registers in the database
                        print $BVS_LANG['lblTotIssRegLib'].": ".$arrayRecords[0][1002];
                        break;
        }
}



/**
 *
 */
function printFormat($format, $formatedRecords,  $arrayRecordsFacic, $arrayRecordsHolding){

global $BVS_LANG;

if ($arrayRecords[0][1002]) {
        $totalRecordsReturned = $arrayRecords[0][1002];
}else {
        $totalRecordsReturned = 0;
}

    $content = "";
    switch ($format) {
            case 'titCurrColect':
                $allDataTitle = returnData($formatedRecords, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                $allDataFacic = returnData($arrayRecordsFacic, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                foreach($allDataFacic[records] as $keyFacic => $valueFacic){
                    foreach($allDataTitle[records] as $key => $value){
                        if($valueFacic[1] == $value[30]){
                            if($value[30])  { $content .= "<div class='reportLeft'>[".$value[30]."] "; }
                            if($value[100]) { $content .= $value[100]." "; }
                            if($value[110]) { $content .= $value[110]." "; }
                            if($value[120]) { $content .= $value[120]." "; }
                            if($value[400]) { $content .= "(".$value[400].") </div>"; }
                            $content .= "<div class='reportRight'>".$BVS_LANG['lblColection'].": ".$valueFacic[970]." ".$BVS_LANG['lblTotalOf']." ".$valueFacic[999]." ".$BVS_LANG['lblFacic']."</div>";
                        }
                    }
                }
                break;
            case 'titWCurrColect':
                $allDataTitle = returnData($formatedRecords, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                foreach($allDataTitle[records] as $key => $value){
                    if($value[30])  { $content .= "[".$value[30]."] "; }
                    if($value[100]) { $content .= $value[100]." "; }
                    if($value[110]) { $content .= $value[110]." "; }
                    if($value[120]) { $content .= $value[120]." "; }
                    if($value[400]) { $content .= "(".$value[400].") "; }
                    $content .= "<br/>";
                }
                break;
            case 'titFinishColect':
                $allDataTitle = returnData($formatedRecords, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                $allDataFacic = returnData($arrayRecordsFacic, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                foreach($allDataFacic[records] as $keyFacic => $valueFacic){
                    foreach($allDataTitle[records] as $key => $value){
                        if($valueFacic[1] == $value[30]){
                            if($value[30])  { $content .= "<div class='reportLeft'>[".$value[30]."] "; }
                            if($value[100]) { $content .= $value[100]." "; }
                            if($value[110]) { $content .= $value[110]." "; }
                            if($value[120]) { $content .= $value[120]." "; }
                            if($value[400]) { $content .= "(".$value[400].") </div>"; }
                            $content .= "<div class='reportRight'>".$BVS_LANG['lblColection'].": ".$valueFacic[970]." ".$BVS_LANG['lblTotalOf']." ".$valueFacic[999]." ".$BVS_LANG['lblFacic']."</div>";
                        }
                    }
                }
                break;
            case 'titWithoutColect':
                $allDataTitle = returnData($formatedRecords, $totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
                foreach($allDataTitle[records] as $key => $value){
                    if($value[30])  { $content .= "[".$value[30]."] "; }
                    if($value[100]) { $content .= $value[100]." "; }
                    if($value[110]) { $content .= $value[110]." "; }
                    if($value[120]) { $content .= $value[120]." "; }
                    if($value[400]) { $content .= "(".$value[400].") "; }
                    ;
                    $content .= "<br/>";
                }
                break;
        }
        if(empty ($content)){
            print $BVS_LANG["lblReportEmpty"];
        }
    print $content;
}

/**
 * Function witch returns the data in JSON format to YUI
 */
function returnData($allRecords,$totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir) {

	// Need to sort records
	if(!is_null($sort)) {

		// Obtain a list of columns
		foreach ($allRecords as $key => $row) {
			$sortByCol[$key] = $row[$sort];
		}

		// Valid sort value
		if(count($sortByCol) > 0) {
			// Sort the original data
			// Add $allRecords as the last parameter, to sort by the common key
			array_multisort($sortByCol, $sort_dir, $allRecords);
		}
	}

	// Invalid start value
	if(is_null($startIndex) || !is_numeric($startIndex) || ($startIndex < 0)) {
		$startIndex = 0; // Default is zero
	}
	// Valid start value
	else {
		$startIndex += 0; // Convert to number
	}

	// Invalid results value
	if(is_null($results) || !is_numeric($results) ||
	($results < 1) || ($results >= $totalRecordsReturned)) {
		$results = $totalRecorsReturned; // Default is all
	}
	// Valid results value
	else {
		$results += 0; // Convert to number
	}

	// Iterate through records and return from start index
	$data = array();
	$lastIndex = $startIndex+$results;
	if($lastIndex > $totalRecordsReturned) {
		$lastIndex = $totalRecordsReturned;
	}

	// Create return value
	$returnValue = array(
	'recordsReturned'=>count($allRecords),
	'totalRecords'=>$totalRecordsReturned,
	'startIndex'=>$startIndex,
	'sort'=>$sort,
	'dir'=>$dir,
	'records'=>$allRecords
	);

        return $returnValue;
}

/**
 * Funcao que monta o XML que e enviado ao Wxis-Modules
 * @return XML
 */
function makeRecords($database)
{
	global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

	$xmlparameters = "<parameters>\n";
	if(isset($database) && !preg_match("=/=",$database)){
		switch ($database) {
			case 'facic':
				$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
				break;
			case 'title':
				$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
				break;
			case 'titleplus':
				$xmlparameters .= "<database>".$configurator->getPath2Titleplus()."</database>\n";
				break;
			case 'holding':
				$xmlparameters .= "<database>".$configurator->getPath2Holdings()."</database>\n";
				break;
			case 'temp_facic':
				$xmlparameters .= "<database>".$configurator->getPath2TempFacic()."</database>\n";
				break;

		}
	}
	//Used when has search
	if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {

            $xmlparameters .= "<search>TIT={$_REQUEST["title"]}</search>\n";

	}elseif(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {

            if(isset($_REQUEST['indexes']) && $_REQUEST['indexes'] != "")  {
                $xmlparameters .= "<search>{$_REQUEST["indexes"]}={$_REQUEST["searchExpr"]}</search>\n";
            }else{
                $xmlparameters .= "<search>{$_REQUEST["searchExpr"]}</search>\n";
            }

	}else {
            $xmlparameters .= "<search>$</search>\n";
	}

	if(isset($_REQUEST['startIndex']) && $_REQUEST['startIndex'] > 0) {
            $xmlparameters .= "<from>{$_REQUEST['startIndex']}</from>\n";
	}else{
            $xmlparameters .= "<from>1</from>\n";
	}
	$xmlparameters .= "<to>99999</to>\n";
	if(isset($_REQUEST["results"]) && $_REQUEST["results"] != "") {
		$xmlparameters .= "<count>{$_REQUEST['results']}</count>\n";
	}else{
		$xmlparameters .= "<count>1</count>\n";
	}
	if(isset($_REQUEST['fieldsort']) && $_REQUEST['fieldsort'] != "") {
		$xmlparameters .= "<fieldsort>{$_REQUEST['fieldsort']}</fieldsort>\n";
	}
	$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
	$xmlparameters .= "<xml_header>yes</xml_header>\n";
        $xmlparameters .= "<reverse>On</reverse>\n";
	$xmlparameters .= "</parameters>\n";

        if(isset($_REQUEST['title']) && $_REQUEST['title'] != "") {
            $rawxml = $isisBroker->IsisSearchSort($xmlparameters);
	}else{
            $rawxml = $isisBroker->search($xmlparameters);
	}
	$posicion1 = strpos($rawxml,"<record");
	$posicion2 = strpos($rawxml,"</record>");

	$recordList = null;
	$i=0;
	while ($posicion1>0)
	{
            $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
            $record = new Record();
            $record->unserializeFromString($elemento);
            $tempField = $record->campos;
            $tempRecord = array();

            if ($_REQUEST['debug'] == 'yes') {
                echo "tempField \n";
                var_dump($tempField);
            }

            foreach($tempField as $key=>$val) {
                if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                        $varTemp = $tempRecord[$tempField[$key]->tag];
                        if (is_array($varTemp)){
                                if (is_array($val->contenido)){
                                    $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
                                }else{
                                    array_push($tempRecord[$tempField[$key]->tag], $val->contenido);
                                }
                        }else{
                                $tempRecord[$tempField[$key]->tag] = array($varTemp, $val->contenido);
                        }
                }else{
                    $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
                }
            }
            $tempRecord += array("mfn" => $record->getMfn());
            ksort($tempRecord);

            if ($_REQUEST['debug'] == 'yes') {
                echo "tempRecord \n";
                var_dump($tempRecord);
            }

            $recordList[] = $tempRecord;
            $tempRecord = null;
            $rawxml = substr($rawxml,$posicion2+1);
            $posicion1 = strpos($rawxml,"<record");
            $posicion2 = strpos($rawxml,"</record>");

	}
	return $recordList;
}

/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function titCurrColect($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        foreach($dataCollection as $key=>$val) {
            if($dataCollection[$key]["50"] == "C"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }
        }
    }
    return $data;
}


/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function titCurrColectHolding($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        foreach($dataCollection as $key=>$val) {
            if($dataCollection[$key]["50"] == "C"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }
        }
    }
    return $data;
}

/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function titWCurrColect($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
       foreach($dataCollection as $key=>$val) {
            if($dataCollection[$key]["50"] == "C"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }
        }
    }
    return $data;
}

/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function titFinishColect($dataCollection){
    
    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        foreach($dataCollection as $key=>$val) {
            if($dataCollection[$key]["50"] == "D"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }
        }
        }
    return $data;
}

/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function titWithoutColect($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        foreach($dataCollection as $key=>$val) {
            if($dataCollection[$key]["50"] == "D"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }
        }
    }
    return $data;
}

/**
 * Funcao que busca os dados na base de dados TITLE
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLE
 * @param array dataCollection
 * @return array with DB data
 */
function totIssRegLib($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        foreach($dataCollection as $key=>$val) {
            /*if($dataCollection[$key]["50"] == "D"){
                    $data[] = array(
                        "MFN" => $dataCollection[$key]["mfn"],
                        "100" => $dataCollection[$key]["100"],
                        "110" => $dataCollection[$key]["110"],
                        "120" => $dataCollection[$key]["120"],
                        "130" => $dataCollection[$key]["130"],
                        "400" => $dataCollection[$key]["400"],
                        "30" => $dataCollection[$key]["30"]
                      );
            }*/
        }
    }
    return $data;
}

function arrayToFacic($dataCollection)
{
    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();

        if ($_GET['debug'] == 'yes') {
            var_dump($dataCollection);
        }

        foreach($dataCollection as $key=>$val) {
                $INV = implode('; ',$dataCollection[$key]["917"]);

                $data[] = array(
                "MFN" => $dataCollection[$key]["mfn"],
                "SEQN" => $dataCollection[$key]["920"],
                "teste" => $dataCollection[$key]["920"],
                "previous" => $dataCollection[$key-1]["920"],
                "YEAR" => $dataCollection[$key]["911"],
                "VOLU" => $dataCollection[$key]["912"],
                "FASC" => $dataCollection[$key]["913"],
                "TYPE" => $dataCollection[$key]["916"] == NULL || $dataCollection[$key]["916"] == 'null' ? '': $dataCollection[$key]["916"],
                "INVENTORY" => $INV ? $INV : '',
                "STAT" => $dataCollection[$key]["914"],
                "QTD" => $dataCollection[$key]["915"],
                "FORMERSTAT" => $dataCollection[$key]["914"],
                "FORMERQTD" => $dataCollection[$key]["915"],
                "MASK" => $dataCollection[$key]["910"],
                "NOTE" => makeShorterText($dataCollection[$key]["900"],30)
                );

        }
    }
    return $data;
}

?>

