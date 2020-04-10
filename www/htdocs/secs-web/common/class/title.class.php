<?php
/**
 * @desc        Classe de controle de base de dados
 * @package     [secsWeb] SeCS
 * @version     1.0
 * @author      Domingos Teruel <domingosteruel@terra.com.br>
 * @since       28 de janeiro 2008
 * @copyright   (c)BIREME - PFI - 2008
 * @public  
*/  

class title
{
	var $registro;
	var $totalRecords = 0;

	function title()
	{
		global $configurator;
		global $isisBroker;
		$this->registro = new Record();
	}

        function __construct() {
         self:: title();
        }

	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $TITLE_TAG_NAME, $smarty;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
		$xmlparameters .= "<from>{$mfn}</from>\n";
		$xmlparameters .= "<to>{$mfn}</to>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->listar($xmlparameters);		
		$record = xmlIsisToArrayField($rawxml);		
		
		for($i=0;$i<count($record);$i++) {
            $key = key($record[$i]);
            $_record[$key][] = utf8_decode($record[$i][$key][0]);
        }
        
        return $_record;

	}
	function getRecordByMFN($mfn) {
		return $this->setRecordByMFN($mfn);
	}

        function searchRecordByIndex($indexes, $searchExpr) {

                global $configurator, $isisBroker;
                $xmlparameters = '<parameters>\n';
                $xmlparameters .= '<database>'.$configurator->getPath2Title().'</database>\n';
                $xmlparameters .= '<search>'.$indexes.'='.$searchExpr.'</search>\n';
                $xmlparameters .= '<from>1</from>\n';
                $xmlparameters .= '<to>99999</to>\n';
                $xmlparameters .= '<count>1</count>\n';
                $xmlparameters .= '<gizmo>GIZMO_XML</gizmo>\n';
                $xmlparameters .= '<xml_header>yes</xml_header>\n';
                $xmlparameters .= '<reverse>Off</reverse>\n';
                $xmlparameters .= '</parameters>\n';
                
                $result = $isisBroker->search($xmlparameters);

                return $result;
        }
	function createRecord($fieldsList) {
            $_fields_tags = $GLOBALS['TITLE_NAME_TAG'];
            /** Verifica se os dados estao formatados como array
             *  extraimos os dados do array, se houver ocorrencias de arrays nos campos, teremos subcampos
             */
            if(is_array($fieldsList)) {
                foreach($fieldsList as $key=>$val) {
                    if($val != "") {
                        //Se o campo corrente for um array, extraimos seus dados
                        if(is_array($fieldsList[$key])) {
                            foreach($fieldsList[$key] as $keyf=>$valf) {
                                switch ($key) {
                                    case 'alphabetTitle':
                                        $this->defineField($_fields_tags['alphabetTitle'],$valf);
                                        break;
                                    case 'languageText':
                                        $this->defineField($_fields_tags['languageText'],$valf);
                                        break;
                                    case 'languageAbstract':
                                        $this->defineField($_fields_tags['languageAbstract'],$valf);
                                        break;
                                    case 'indexingCoverage':
                                        $this->defineField($_fields_tags['indexingCoverage'],$valf);
                                        break;
                                    case 'subcampo':
                                        $this->defineSubField($_fields_tags[$key],$valf);
                                        break;
                                }
                                $this->defineField($_fields_tags[$key],$valf);
                            }
                        }else {
                            $this->defineField($_fields_tags[$key],$val);
                        }
                    }
                }
            }

            return $this->registro;

        }

	function setAllNameTitle(){
		$recordList = $this->setRecords();
		reset($recordList);
		$collectionMask = array();
		foreach($recordList as $key=>$val) {
			$collectionTitle += array($recordList[$key]["mfn"] => $recordList[$key]["801"]);
		}
		return $collectionTitle;
	}
	function getAllNameTitle()
	{
		return $this->setAllNameTitle();
	}
	function setRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $TITLE_TAG_NAME;
                

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
		if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
			$xmlparameters .= "<search>TIT={$_REQUEST["title"]}</search>\n";
		//Used when has search
		}elseif(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
			if(isset($_GET['indexes']) && $_GET['indexes'] != "")  {
				$xmlparameters .= "<search>{$_GET["indexes"]}={$_REQUEST["searchExpr"]}</search>\n";
			}else {
				//search all the field
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
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->search($xmlparameters);
		//die($rawxml);
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

			foreach($tempField as $key=>$val) {
				if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
					$varTemp = $tempRecord[$tempField[$key]->tag];
					$tempRecord[$tempField[$key]->tag] = array_merge($varTemp,utf8_decode($tempField[$key]->contenido));
				}else {
					$tempRecord += array($tempField[$key]->tag => utf8_decode($tempField[$key]->contenido));
				}
			}
			$tempRecord += array("mfn" => $record->getMfn());

			ksort($tempRecord);

			$recordList[] = $tempRecord;
			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<record");
			$posicion2 = strpos($rawxml,"</record>");

		}

		//Setamos o total de registro retornados
		$this->setTotalRecords($recordList[0][1002]);

		return $recordList;
	}
	function getRecords()
	{
		return  $this->setRecords();
	}
	function setTotalRecords($total)
	{
		$this->totalRecords = $total;
	}
	function getTotalRecords()
	{
		return $this->totalRecords;
	}
	function setIndex(){
		global $configurator, $isisBroker, $TITLE_TAG_NAME;

		$xmlparameters =  "<parameters>\n";
		$xmlparameters .= "<database>". $configurator->getPath2Title(). "</database>\n";
		$xmlparameters .= "<from>A</from>\n";
		$xmlparameters .= "<to>ZZZZZZ</to>\n";
		$xmlparameters .= "<posting>All</posting>\n";
		$xmlparameters .= "<count>20</count>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>";
		$rawxml = $isisBroker->index($xmlparameters);

		$posicion1 = strpos($rawxml,"<term");
		$posicion2 = strpos($rawxml,"</term>");

		$recordList = null;
		$i=0;
		while ($posicion1>0)
		{
			$elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);

			$record = new Record();
			$record->unserializeFromString($elemento);
			$tempField = $record->campos;

			$tempRecord = array();

			foreach($tempField as $key=>$val) {
				if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
					$varTemp = $tempRecord[$tempField[$key]->tag];
					$tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
				}else {
					$tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
				}
			}
			$tempRecord += array("mfn" => $record->getMfn());

			ksort($tempRecord);

			$recordList[] = $tempRecord;
			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<term");
			$posicion2 = strpos($rawxml,"</term>");

		}

		return $recordList;

	}
	function getIndex(){
		return $this->setIndex();
	}

	function saveRecord ($mfn)
	{
		global $configurator, $isisBroker, $BVS_LANG;
		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Title()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";
			/*print $xmlparameters;
			print_r ($this->registro->asXML());
			//print_r($this->registro);
			die;*/
		if (is_null($isisBroker->getError()))
		{
			if ($mfn == 'New' ){
                                $id = $isisBroker->nextID($configurator->getPath2Title());
                                if ($id == CREATE_LOCK_ERROR){
                                    $sec = 1;
                                    while($sec < 10){
                                        sleep($sec);
                                        $id = $isisBroker->nextID($configurator->getPath2Title());
                                        if ($id != CREATE_LOCK_ERROR){
                                            break;
                                        }else{
                                            $sec *= 2;
                                        }
                                    }
                                }
                                if($id > 0){
                                    $this->defineField("30", $id);
                                    $isisBroker->writeNewRecord($xmlparameters, $this->registro);
                                    user_notice($BVS_LANG["sucessSaveRecord"]);
                                }else{
                                    switch ($id){
                                        case CREATE_LOCK_ERROR:
                                            user_error($BVS_LANG["lockError"]);
                                            break;
                                        case PERMISSION_ERROR:
                                            user_error($BVS_LANG["permissionError"]);
                                            break;
                                        case FILE_READ_ERROR:
                                            user_error($BVS_LANG["permissionError"]);
                                            break;
                                    }
                                    
                                }
			}else{
				$isisBroker->updateRecord($xmlparameters, $this->registro);
				user_notice($BVS_LANG["sucessSaveRecord"]);
			}
		}
		else
		{
			user_error($isisBroker->getError(),E_ERROR);
		}
	}

	function deleteRecord ($mfn)
	{
		global $configurator, $isisBroker, $BVS_LANG;
		
		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Title().".fst</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

		//print $xmlparameters;
		//die;

		if (is_null($isisBroker->getError()))
		{
			$isisBroker->deleteRecord($xmlparameters);
			user_notice($BVS_LANG["sucessDeleteRecord"]);
		}
		else
		{
			user_error($isisBroker->getError(),E_ERROR);
		}
	}
	function defineField($tag,$content)
	{
            if(isset ($content) && $content != ""){
		$field = new Field();
		$content = utf8_encode($content);
		$field->setTag($tag);
		$field->setContent($content);
		$this->registro->addField($field,false);
            }
	}
	function defineSubfield($letter,$content)
	{
		if($content == "") {
			$content == "vazio";
		}
		$content = utf8_encode($content);
		$subfield = new Subfield();
		$subfield->setLetra($letter);
		$subfield->setContent($content);
		return $subfield;
	}
	function getTitleId()
	{
		$id = $this->registro->select_fields("1");
		return $id[0]->getContent();
	}


	function setAllTitles(){

            global $BVS_CONF, $configurator, $isisBroker, $TITLE_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Title()."</database>\n";
            $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
            $xmlparameters .= "<xml_header>yes</xml_header>\n";
            $xmlparameters .= "<reverse>Off</reverse>\n";
            $xmlparameters .= "</parameters>\n";

            $rawxml = $isisBroker->listar($xmlparameters);
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

                    foreach($tempField as $key=>$val) {
                            if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                                    $varTemp = $tempRecord[$tempField[$key]->tag];
                                    $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
                            }else {
                                    $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
                            }
                    }
                    $tempRecord += array("mfn" => $record->getMfn());
                    ksort($tempRecord);
                    $recordList[] = $tempRecord;
                    $tempRecord = null;
                    $rawxml = substr($rawxml,$posicion2+1);
                    $posicion1 = strpos($rawxml,"<record");
                    $posicion2 = strpos($rawxml,"</record>");
            }
            return $recordList;
	}

	function getAllTitles()
	{
		return $this->setAllTitles();
	}

}


/**
 * A funcao getAllIssues() retorna dois arrays
 * o primeiro esta em $titleName
 * o segundo esta em $titleCode
 * @return array.
 */
function getAllTitles($field){

    //colocando todas as bibliotecas disponiveis na base na variavel collectionIssue
    $dataModel = new title();
    $allData = $dataModel->getAllTitles();
    $field20 = array($allData[0][20]);
    $field100 = array($allData[0][100]);
    $field400 = array($allData[0][400]);

    for ($i=1; $i<count($allData); $i++) {
        array_push($field20, $allData[$i][20]);
        array_push($field100, $allData[$i][100]);
        array_push($field400, $allData[$i][400]);
    }

    return array($field20, $field100, $field400);
}

function getField37Title(){

    //colocando todas as bibliotecas disponiveis na base na variavel collectionIssue
    $dataModel = new title();
    $allData = $dataModel->getAllTitles();
    $field37 = array();

    for ($i=0; $i<count($allData); $i++) {
        if($allData[$i][37]){
            array_push($field37, $allData[$i][37]);
        }
    }

    return array($field37);
}

function sortTitleByField37(){

    $pathMX = BVS_DIR."/cgi-bin/ansi/mx.exe";
    $pathMSRT = BVS_DIR."/cgi-bin/ansi/msrt.exe";
    $pathDB = BVS_DIR."/bases/secs-web/title";
    $goTempDirectory = BVS_TEMP_DIR;
    //."/htdocs/secs-web/temp/";

    $executeCommand = $pathMSRT." ".$pathDB." 10 f(val(v37),8,0)";
    exec($executeCommand);

    $invertCommand = $pathMX." ".$pathDB." fst=@ fullinv/ansi=".$pathDB." -all now";
    exec($invertCommand);

}

?>