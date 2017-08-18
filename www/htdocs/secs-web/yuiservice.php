<?php
/**
 * @file:			yuiservice.php
 * @desc:           Retorn a JSON dataset to populate the DataTable elements of YUI
 * @author:			Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:			Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:			Domingos Teruel <domingos.teruel@bireme.org>
 * @since :			2008-02-14
 * @copyright:      (c) 2008 Domingos Teruel | BIREME|PFI
 ******************************************************************************/

require_once("./common/ini/config.ini.php");

/*
 * Error if user not logged into sistem
 */
if(!isset($_SESSION["identified"]) || $_SESSION["identified"]!=1 ) 
{  
    die($BVS_LANG["error404"]);
}

header('Content-type: application/json');
// Define defaults
$results = -1; // default get all
$startIndex = 0; // default start at 0
$sort = null; // default don't sort
$dir = 'asc'; // default sort dir is asc
$sort_dir = SORT_ASC;


//Number of records to get
if(strlen($_GET['results']) > 0) {
    $results = $_GET['results'];
}

//Start record
if(strlen($_GET['startIndex']) > 0) {
    $startIndex = $_GET['startIndex'];
}

//Sort
if(strlen($_GET['sort']) > 0) {
    $sort = $_GET['sort'];
}

//Sort dir
if((strlen($_GET['dir']) > 0) && ($_GET['dir'] == 'desc')) {
    $dir = 'desc';
    $sort_dir = SORT_DESC;
}
else {
    $dir = 'asc';
    $sort_dir = SORT_ASC;
}
if ($_GET["m"] == 'futureIssues'){
	if ($_REQUEST["maskId"]){
		$mask = new mask();
		$futureIssues = new futureIssues();


		$maskSample = $mask->getMaskSample($_REQUEST["maskId"], $maskId);
                if ($_GET['debug']){
                    echo "maskID\n";
                    var_dump($_REQUEST["maskId"]);
                    echo "maskSample\n";
                    var_dump($maskSample);
                    $futureIssues->_debug = 1;
                }
		$newIssues = $futureIssues->getFutureIssues($_REQUEST["initialDate"], $_REQUEST["lastDate"], $_REQUEST["lastVolume"], $_REQUEST["lastNumber"], $maskSample, $maskId, $_REQUEST["lastSeqN"], $_REQUEST["prevMask"]);

                if ($_GET['debug']){
                    echo "newIssues\n";
                    var_dump($newIssues);
                }

		$formatedRecords = futureIssuesToFacic($newIssues);
		$json = new Services_JSON();
		echo ($json->encode($formatedRecords)); // Instead of json_encode
	}
} else {
	//Recover the registers in the database
	$arrayRecords = makeRecords();
        /*
         * Depending on the select database we call a function that will format the data
         * to be send the datase
         */
	if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])){
		switch ($_GET['m']) {
			case 'facic':
				$formatedRecords = arrayToFacic($arrayRecords);
				break;
			case 'title':
				$formatedRecords = arrayToTitle($arrayRecords);
				break;
			case 'mask':
				$formatedRecords = arrayToMask($arrayRecords);
				break;
			case 'users':
				$formatedRecords = arrayToUsers($arrayRecords);
				break;
			case 'titleplus':
				$formatedRecords = arrayToTitlePlus($arrayRecords);
				break;
			case 'library':
				$formatedRecords = arrayToLibrary($arrayRecords);
				break;
			case 'report':
				$formatedRecords = arrayToReport($arrayRecords);
				break;
		}
	}
        
	if ($arrayRecords[0][1002]) {
		$totalRecordsReturned = $arrayRecords[0][1002];
	}else {
		$totalRecordsReturned = 0;
	}

	// Return the data
	returnData($formatedRecords,$totalRecordsReturned,$results, $startIndex, $sort, $dir, $sort_dir);
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

	// JSONify
	//print json_encode($returnValue);

	// Use Services_JSON
	//require_once('JSON.php');
	$json = new Services_JSON();
	echo ($json->encode($returnValue)); // Instead of json_encode
}

/**
 * Function that mount the XML, this XML is send to Wxis-Modules
 * @return XML
 */
function makeRecords()
{
	global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

	$xmlparameters = "<parameters>\n";
	if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])){
		switch ($_GET['m']) {
			case 'facic':
				$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
				break;
			case 'title':
				$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
				break;
			case 'mask':
				$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
				break;
			case 'users':
				$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
				break;
			case 'titleplus':
				$xmlparameters .= "<database>".$configurator->getPath2Titleplus()."</database>\n";
				break;
			case 'library':
				$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
				break;
			case 'report':
				$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
				break;
		}
	}
	//Used when has search
	if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {

            $xmlparameters .= "<search>TIT={$_REQUEST["title"]}</search>\n";

	}elseif(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {

            if(isset($_GET['indexes']) && $_GET['indexes'] != "")  {
                $xmlparameters .= "<search>{$_GET["indexes"]}={$_REQUEST["searchExpr"]}</search>\n";
            }else{
                $xmlparameters .= "<search>{$_REQUEST["searchExpr"]}</search>\n";
            }

	}else {
            $xmlparameters .= "<search>$</search>\n";
	}

	if(isset($_GET['startIndex']) && $_GET['startIndex'] > 0) {
            $xmlparameters .= "<from>{$_GET['startIndex']}</from>\n";
	}else{
            $xmlparameters .= "<from>1</from>\n";
	}
	$xmlparameters .= "<to>99999</to>\n";
	if(isset($_GET["results"]) && $_GET["results"] != "") {
		$xmlparameters .= "<count>{$_GET['results']}</count>\n";
	}else{
		$xmlparameters .= "<count>1</count>\n";
	}
	if(isset($_GET['fieldsort']) && $_GET['fieldsort'] != "") {
		$xmlparameters .= "<fieldsort>{$_GET['fieldsort']}</fieldsort>\n";
	}
	$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
	$xmlparameters .= "<xml_header>yes</xml_header>\n";
        if($_GET['m'] == "mask"){
            $xmlparameters .= "<reverse>Off</reverse>\n";
        }else{
            $xmlparameters .= "<reverse>On</reverse>\n";
        }
	
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

            if ($_GET['debug'] == 'yes') {
                echo "tempField \n";
                var_dump($tempField);
            }
                
            while (list($key,$val) = each($tempField)) {
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

            if ($_GET['debug'] == 'yes') {
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
 * Funtion tha search and order the data in FACIC database
 * to send to YUI, it shows a list with the data of FACIC database
 * @param array dataCollection
 * @return array with DB data
 */
function arrayToFacic($dataCollection)
{	
    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();

        if ($_GET['debug'] == 'yes') {
            var_dump($dataCollection);
        }

        while (list($key, $val) = each($dataCollection)) {
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
/**
 * Funcao que busca os dados na base de dados FACIC
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base FACIC
 * @param array dataCollection
 * @return array with DB data
 */
function futureIssuesToFacic($issues)
{	
	if(is_array($issues)) {
		reset($issues);
		//$i = count($issues);
		$data = array();
		while (list($key, $issue) = each($issues)) {
			$data[] = array(
			"MFN" => $issue->get_mfn(),
			"SEQN" => $issue->getData('sequentialNumber'),
			"teste" => $issue->getData('sequentialNumber'),
			"YEAR" => $issue->get_year(),
			"VOLU" => $issue->get_vol(),
			"FASC" => $issue->get_num(),
			"TYPE" => $issue->get_type(),
			"STAT" => $issue->get_status(),
			"QTD" => $issue->get_qtd(),
			"MASK" => $issue->get_mask(),
			"NOTE" => $issue->get_note(),
			"IDMFN" => $issue->get_mfn()
			);
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
function arrayToTitle($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        while (list($key, $val) = each($dataCollection)) {
            $data[] = array(
                "MFN" => $dataCollection[$key]["mfn"],
                "TITLE" => $dataCollection[$key]["100"],
                "SUBTITLE" => $dataCollection[$key]["110"],
                "SECTIONPART" => $dataCollection[$key]["120"],
                "OFSECTIONPART" => $dataCollection[$key]["130"],
                "PARALLELTITLE" => $dataCollection[$key]["230"],
                "OFISSUINGBODY" => $dataCollection[$key]["140"],
                "INITIALDATE" => $dataCollection[$key]["301"],
                "INITIALVOLUME" => $dataCollection[$key]["302"],
                "INITIALNUMBER" => $dataCollection[$key]["303"],
                "FINALDATE" => $dataCollection[$key]["304"],
                "FINALVOLUME" => $dataCollection[$key]["305"],
                "FINALNUMBER" => $dataCollection[$key]["306"],
                "PUBLISHER" => $dataCollection[$key]["480"],
                "CITY" => $dataCollection[$key]["490"],
                "FASC" => $dataCollection[$key]["30"]
              );
        }
    }
    return $data;
}

/**
 * Funcao que busca os dados na base de dados USERS
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base USERS
 * @param array dataCollection
 * @return array with DB data
 */
function arrayToUsers($dataCollection){

    if(is_array($dataCollection)) {
            reset($dataCollection);
            $data = array();
            while (list($key, $val) = each($dataCollection)) {
                $data[] = array(
                                "MFN" => $dataCollection[$key]["mfn"],
                                "user" => $dataCollection[$key]["1"],
                                "userAcronym" => $dataCollection[$key]["2"],
                                "role" => $dataCollection[$key]["4"],
                                "name" => $dataCollection[$key]["8"],
                                "email" => $dataCollection[$key]["11"],
                                "institution" => $dataCollection[$key]["9"],
                                "centerCode" => $dataCollection[$key]["5"],
                                "NOTE" =>  $dataCollection[$key]["10"]
                                );
        }
    }
    return $data;
    
}

/**
 * Funcao que busca os dados na base de dados MASK
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base MASK
 * @param array dataCollection
 * @return array with DB data
 */
function arrayToMask($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        while (list($key, $val) = each($dataCollection)) {

            switch ($_SESSION["lang"]) {
                case 'pt':
                        $noteMask = makeShorterText($dataCollection[$key]["900"][2],30);
                        break;
                case 'es':
                        $noteMask = makeShorterText($dataCollection[$key]["900"][3],30);
                        break;
                case 'en':
                        $noteMask = makeShorterText($dataCollection[$key]["900"][0],30);
                        break;
                case 'fr':
                        $noteMask = makeShorterText($dataCollection[$key]["900"][1],30);
                        break;
            }

            $data[] = array(
                            "MFN" => $dataCollection[$key]["mfn"],
                            "MASK" => $dataCollection[$key]["801"],
                            "NOTE" => $noteMask,
                            "usedMask" => $dataCollection[$key]["113"]
                              );
        }
    }
    return $data;
    
}


/**
 * Funcao que busca os dados na base de dados TITLEPLUS
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base TITLEPLUS
 * @param array dataCollection
 * @return array with DB data
 */
function arrayToTitlePlus($dataCollection) {

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        while (list($key, $val) = each($dataCollection)) {
            $cdAcqMet = $dataCollection[$key]["901"];
            $cdAcqCon = $dataCollection[$key]["902"];
            $data[] = array(
                    "MFN" => $dataCollection[$key]["mfn"],
                    "initialDate" => $dataCollection[$key]["301"],
                    "initialVolume" => $dataCollection[$key]["302"],
                    "initialNumber" => $dataCollection[$key]["303"],
                    "acquisitionControl" => translateCodes($cdAcqCon,
                            "optAcquisitionControl"),
                    "acquisitionMethod" => translateCodes($cdAcqMet,
                            "optAcquisitionMethod"),
                    "expirationSubs" => $dataCollection[$key]["906"],
                    "provider" => $dataCollection[$key]["905"],
                    "centerCode" => $dataCollection[$key]["10"],
                    "titleCode" => $dataCollection[$key]["30"],
                    "titleName" => $dataCollection[$key]["100"]
            );
        }
    }
    return $data;

}
/*
 * Funcao que retorna o significado do codigo gravado na
 * base de dados. Recebe o codigo gravado e a lista que
 * deve ser consultada.
 * @param String codigo
 * @param String lista
 * @return String text
 */
function translateCodes($codigo, $lista){
     global $BVS_LANG;
     
    $text = "";
    switch ($codigo){
        case '0':
            $text = $BVS_LANG[$lista][0];
            break;
        case '1':
            $text = $BVS_LANG[$lista][1];
            break;
        case '2':
            $text = $BVS_LANG[$lista][2];
            break;
        case '3':
            $text = $BVS_LANG[$lista][3];
            break;
        case '4':
            $text = $BVS_LANG[$lista][4];
            break;
        default : $text = "";
           
    }
    return $text;
}
/**
 * Funcao que busca os dados na base de dados LIBRARY
 * e ordena os dados para enviar ao YUI exibir uma lista
 *  com os dados da base LIBRARY
 * @param array dataCollection
 * @return array with DB data
 */
function arrayToLibrary($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        while (list($key, $val) = each($dataCollection)) {
                $data[] = array(
                                "MFN" => $dataCollection[$key]["mfn"],
                                "fullname" => $dataCollection[$key]["2"],
                                "address" => $dataCollection[$key]["3"],
                                "city" => $dataCollection[$key]["4"],
                                "country" => $dataCollection[$key]["5"],
                                "institution" => $dataCollection[$key]["9"],
                                "note" => $dataCollection[$key]["10"],
                                "email" =>  $dataCollection[$key]["11"]
                                  );
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
function arrayToReport($dataCollection){

    if(is_array($dataCollection)) {
        reset($dataCollection);
        $data = array();
        while (list($key, $val) = each($dataCollection)) {
            $data[] = array(
                "MFN" => $dataCollection[$key]["mfn"],
                "TITLE" => $dataCollection[$key]["100"],
                "SUBTITLE" => $dataCollection[$key]["110"],
                "SECTIONPART" => $dataCollection[$key]["120"],
                "OFSECTIONPART" => $dataCollection[$key]["130"],
                "PARALLELTITLE" => $dataCollection[$key]["230"],
                "OFISSUINGBODY" => $dataCollection[$key]["140"],
                "INITIALDATE" => $dataCollection[$key]["301"],
                "INITIALVOLUME" => $dataCollection[$key]["302"],
                "INITIALNUMBER" => $dataCollection[$key]["303"],
                "FINALDATE" => $dataCollection[$key]["304"],
                "FINALVOLUME" => $dataCollection[$key]["305"],
                "FINALNUMBER" => $dataCollection[$key]["306"],
                "PUBLISHER" => $dataCollection[$key]["480"],
                "CITY" => $dataCollection[$key]["490"],
                "FASC" => $dataCollection[$key]["30"]
              );
        }
    }
    return $data;
}
?>
