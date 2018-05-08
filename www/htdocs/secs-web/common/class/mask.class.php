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

class mask
{
	var $registro;
	var $totalRecords = 0;

	function mask()
	{
		global $configurator;
		global $isisBroker;

		$this->registro = new Record();

	}

    function __construct() {
    self:: mask();
    }

       function returnRecordByKEY_ByKeyrange($key)
	{
		global $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<from>{$key}</from>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<posting>All</posting>\n";
		$xmlparameters .= "<postings>All</postings>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->keyrange_mfnrange($xmlparameters);
//var_dump($rawxml);
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

			$x = 0;
			for ($key=0; $key<count($tempField); $key++) {

				//demais ocorrencias do campo repetitivo
				if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
					$arrTemp = $tempRecord[$tempField[$key]->tag];
					if (!is_array($tempRecord[$tempField[$key]->tag])){
						unset($tempRecord[$tempField[$key]->tag]);
						$tempRecord += array( $tempField[$key]->tag =>  array ( $x => $arrTemp, $x+1 => $tempField[$key]->contenido ) );
					}else{
						array_push($tempRecord[$tempField[$key]->tag], $tempField[$key]->contenido);
					}

				//Primeira ocorencia do campo repetitivo
				}else{
					$tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
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


		//print_r($this->createRecord($recordList[0]));
		//print_r ( $recordList[0][900] );
		//die;

		return $recordList[0];

	}

	function returnRecordByKEY($key)
	{
		global $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<search>{$key}</search>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->search($xmlparameters);
		
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
			
			$x = 0;
			for ($key=0; $key<count($tempField); $key++) {
				
				//demais ocorrencias do campo repetitivo
				if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
					$arrTemp = $tempRecord[$tempField[$key]->tag];
					if (!is_array($tempRecord[$tempField[$key]->tag])){ 
						unset($tempRecord[$tempField[$key]->tag]);
						$tempRecord += array( $tempField[$key]->tag =>  array ( $x => $arrTemp, $x+1 => $tempField[$key]->contenido ) );
					}else{
						array_push($tempRecord[$tempField[$key]->tag], $tempField[$key]->contenido);
					}
					
				//Primeira ocorencia do campo repetitivo
				}else{
					$tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
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
		//print_r($this->createRecord($recordList[0]));
		//print_r ( $recordList[0][900] );
		//die;
		return $recordList[0];
	}

	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<from>{$mfn}</from>\n";
		$xmlparameters .= "<to>{$mfn}</to>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->listar($xmlparameters);
		//print_r ($rawxml);
		//die();
		
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
                        //print_r($tempField[9]->subcampos);
			$tempRecord = array();
			
			$x = 0;
			for ($key=0; $key<count($tempField); $key++) {
				
				//demais ocorrencias do campo repetitivo
				if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
					$arrTemp = $tempRecord[$tempField[$key]->tag];
                                        $subField = $tempField[$key]->subcampos[0];

					if (!is_array($tempRecord[$tempField[$key]->tag])){ 
						unset($tempRecord[$tempField[$key]->tag]);
						$tempRecord += array( $tempField[$key]->tag =>  array ( $x => $arrTemp, $x+1 => $tempField[$key]->contenido."^".$subField->letra.$subField->content ) );
                                        }else{
						array_push($tempRecord[$tempField[$key]->tag], $tempField[$key]->contenido."^".$subField->letra.$subField->content);
					}
				//Primeira ocorencia do campo repetitivo
				}else{
                                        if($tempField[$key]->tag == "900"){
                                            $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido."^ien");
                                        }else{
                                            $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
                                        }
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
		
		
		//print_r($this->createRecord($recordList[0]));
		//print_r ( $recordList[0][900] );
		//die;
		
		return $recordList[0];

	}

	function setRecordByMFN2($mfn)
	{
		global $configurator, $isisBroker, $LIBRARY_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
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
        }
	function getRecordByMFN($mfn) {
		return $this->setRecordByMFN($mfn);
	}

	function createRecord($fieldsList)
	{
		//print_r($fieldsList);
		$_fields_tags = $GLOBALS['MASK_NAME_TAG'];
		/** Verifica se os dados estao formatados como array
		 *  extraimos os dados do array, se houver ocorrencias de arrays nos campos, teremos subcampos
		 */		
		if(is_array($fieldsList))
		{
			foreach($fieldsList as $key=>$val)
			{
				if($val != "") {
					//Se o campo corrente for um array, extraimos seus dados
					if(is_array($fieldsList[$key]))
					{
						foreach($fieldsList[$key] as $keyf=>$valf)
						{
							
							$this->defineField($_fields_tags[$key],$valf == '' ? ' ': $valf);
						}
					}else {
						$this->defineField($_fields_tags[$key],$val);
					}
				}
			}
		}		
		return $this->registro;
	}

	function getAllNameMask()
	{
		return $this->setAllNameMask();
	}

	function setAllNameMask(){
		$recordList = $this->setAllRecords();
		//$recordList = $this->setRecords();
		reset($recordList);
		$collectionMask = array();
		 foreach($recordList as $key=>$val) {
			$collectionMask += array($recordList[$key]["mfn"] => $recordList[$key]["801"]);
		}

		//print_r($collectionMask);
		//die;
		return $collectionMask;
	}

	function getAllMfnMask()
	{
		return $this->setAllMfnMask();
	}

	function setAllMfnMask(){
		$recordList = $this->setAllRecords();
		//$recordList = $this->setRecords();
		reset($recordList);
		$collectionMask = array();
		foreach($recordList as $key=>$val) {
			$collectionMask += array($recordList[$key]["mfn"] => $recordList[$key]["mfn"]);
		}

		//print_r($collectionMask);
		//die;
		return $collectionMask;
	}

	
	function setRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		//Used when has search
		if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
			$xmlparameters .= "<search>TIT={$_REQUEST["title"]}</search>\n";
		}elseif(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
			if(isset($_GET['indexes']) && $_GET['indexes'] != "")  {
				$xmlparameters .= "<search>{$_GET["indexes"]}={$_REQUEST["searchExpr"]}</search>\n";
			}else {
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

		$this->setTotalRecords($recordList[0][1002]);
		return $recordList;
	}
	
	function setAllRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<search>$</search>\n";
		$xmlparameters .= "<from>1</from>\n";
		$xmlparameters .= "<to>99999</to>\n";
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
		global $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters =  "<parameters>\n";
		$xmlparameters .= "<database>". $configurator->getPath2Mask(). "</database>\n";
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
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Mask()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";
		
			//print $xmlparameters;
			//print_r ( utf8_decode($this->registro->asXML()) );
			//die;
		
		if (is_null($isisBroker->getError()))
		{
			if ($mfn == 'New' ){
				$isisBroker->writeNewRecord($xmlparameters, $this->registro);
				user_notice($BVS_LANG["sucessSaveRecord"]);
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
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Mask()."</fst>\n";
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
		$field = new Field();
		if($content == "") {
			$content == "vazio";
		}
		$content = utf8_encode($content);
		$field->setTag($tag);
		$field->setContent($content);
		$this->registro->addField($field,false);
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

	function getMaskSample($maskId, &$mId){
		$m = $this->returnRecordByKEY_ByKeyrange(trim($maskId));
        
        $maskInfo['numSeq'] = $m[841][1];
        $maskInfo['volSeq'] = $m[841][0];
		$maskInfo['vol'] = $m[860];
		$maskInfo['num'] = $m[880];

                if (count($maskInfo['num']) != count($maskInfo['vol'])){
                    while (count($maskInfo['num']) < count($maskInfo['vol'])){
                        $maskInfo['num'][] = " ";
                    }
                    while (count($maskInfo['num']) > count($maskInfo['vol'])){
                        $maskInfo['vol'][] = " ";
                    }
                }

                $maskInfo['id'] = $m[801];
		$mId = $m[801];
		return $maskInfo;
	}
}

function sortMaskByAlphabet(){

    $pathMX = BVS_DIR."/cgi-bin/ansi/mx.exe";
    $pathMSRT = BVS_DIR."/cgi-bin/ansi/msrt.exe";
    $pathDB = BVS_DIR."/bases/secs-web/mask";

    $executeCommand = $pathMSRT." ".$pathDB." 10 v801";
    exec($executeCommand);

    $invertCommand = $pathMX." ".$pathDB." fst=@ fullinv/ansi=".$pathDB." -all now";
    exec($invertCommand);

}

?>