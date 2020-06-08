<?php
/**
 * @desc        Classe de controle de base de dados
 * @package     [secsWeb] SeCS
 * @version     1.0
 * @author      Bruno Neofiti <bruno.neofiti@bireme.org>
 * @since       julho de 2009
 * @copyright   (c)BIREME - PFI - 2008
 * @public
*/

class library
{
	var $registro;
	var $totalRecords = 0;

	function library()
	{
		//global $configurator, $isisBroker;
		$this->registro = new Record();

	}

    function __construct() {
    self:: library();
    }



	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $LIBRARY_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
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

	function createRecord($fieldsList)
	{
		$_fields_tags = $GLOBALS['LIBRARY_NAME_TAG'];
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

	function getAllMfnLibrary()
	{
		return $this->setAllMfnLibrary();
	}

	function setAllMfnLibrary(){

        $recordList = $this->setAllRecords();
		reset($recordList);
		$collectionLibrary = array();
		foreach($recordList as $key=>$val) {
			$collectionLibrary += array($recordList[$key]["mfn"] => $recordList[$key]["mfn"]);
		}

		return $collectionLibrary;
	}


	function setRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $LIBRARY_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
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
		global $BVS_CONF, $configurator, $isisBroker, $LIBRARY_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
		$xmlparameters .= "<search>$</search>\n";
		$xmlparameters .= "<from>1</from>\n";
		$xmlparameters .= "<to>99999</to>\n";
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

        global $configurator, $isisBroker, $LIBRARY_TAG_NAME;

		$xmlparameters =  "<parameters>\n";
		$xmlparameters .= "<database>". $configurator->getPath2Library()."</database>\n";
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
		$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Library()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

		for($i=0; $i<11; $i++){
			if(!is_null($this->registro->campos[$i]->tag)){
				if($this->registro->campos[$i]->tag == "1"){
					$checkCC = true;
					$centerTag = $i;
					$i=12;
				}
			}else{
				$i=12;
			}
		}

        //Cria um novo diretorio, para a nova biblioteca
        if($checkCC == true){

			$defaultFacic = $configurator->getPath2Facic(); //Diretorio da Facic
			$centerCode = utf8_decode($this->registro->campos[$centerTag]->contenido); //Pega conteudo do campo Cod. Centro
			$newCCDir = str_replace($_SESSION["libraryDir"], $centerCode, $defaultFacic);
			$newCCDir = str_replace("facic", "", $newCCDir);

            //cria um diretorio
            mkdir($newCCDir, 0777);
            chmod($newCCDir, 0777);
            //cria facic e titlePlus vazia no novo dir
            exec(BVS_DIR."/cgi-bin/mx tmp create=".$newCCDir."facic now count=0");
            exec(BVS_DIR."/cgi-bin/mx tmp create=".$newCCDir."titlePlus now count=0");

            //copia facic.fst para novo diretorio
            $tempFile = $newCCDir."facic.fst";
            $facicFile = BVS_DIR."/bases/secs-web/main/facic.fst";
            copy($facicFile, $tempFile);

            //copia titlePlus.fst para novo diretorio
            $tempFile = $newCCDir."titlePlus.fst";
            $titlePlusFile = BVS_DIR."/bases/secs-web/main/titlePlus.fst";
            copy($titlePlusFile, $tempFile);

            //invertendo as novas bases
            exec(BVS_DIR."/cgi-bin/mx ".$newCCDir."facic fst=@ fullinv/ansi=".$newCCDir."facic");
            exec(BVS_DIR."/cgi-bin/mx ".$newCCDir."titlePlus fst=@ fullinv/ansi=".$newCCDir."titlePlus");
		}

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
		$xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Library()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

		if (is_null($isisBroker->getError()) && $mfn != "1")
		{
			$isisBroker->deleteRecord($xmlparameters);
			user_notice($BVS_LANG["sucessDeleteRecord"]);

		}else{
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

	function setAllLibraries(){

            global $BVS_CONF, $configurator, $isisBroker, $LIBRARY_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
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

	function getAllLibraries()
	{
		return $this->setAllLibraries();
	}
	function setAllNameLibrary(){

            global $BVS_CONF, $configurator, $isisBroker, $LIBRARY_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
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
            $collectionLibrary = array();
            reset($recordList);
            foreach($recordList as $key=>$val) {
                    $collectionLibrary += array($recordList[$key]["2"] => $recordList[$key]["2"]);
            }
            sort($collectionLibrary);
            return $collectionLibrary;
	}

	function getAllNameLibrary()
	{
		return $this->setAllNameLibrary();
	}


	function setAllCodeLibrary(){

            global $BVS_CONF, $configurator, $isisBroker, $LIBRARY_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
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
            $collectionLibrary = array();
            reset($recordList);
            foreach($recordList as $key=>$val) {
                    $collectionLibrary += array($recordList[$key]["1"] => $recordList[$key]["1"]);
            }
            sort($collectionLibrary);
            return $collectionLibrary;
	}

	function getAllCodeLibrary()
	{
		return $this->setAllCodeLibrary();
	}

    function searchByParam($param, $field)
    {
        global $configurator, $isisBroker, $LIBRARY_TAG_NAME;
        

        $xmlparameters = "<parameters>\n";
        $xmlparameters .= "<database>".$configurator->getPath2Library()."</database>\n";
        $xmlparameters .= "<from>1</from>\n";
        $xmlparameters .= "<count>1</count>\n";
        $xmlparameters .= "<search>".$param."/(1)</search>\n";
        $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
        $xmlparameters .= "<xml_header>yes</xml_header>\n";
        $xmlparameters .= "<reverse>Off</reverse>\n";
        $xmlparameters .= "</parameters>\n";

        $rawxml = $isisBroker->search($xmlparameters);
        //print $rawxml;
        $posicion1 = strpos($rawxml,"<record");
        $posicion2 = strpos($rawxml,"</record>");

        if ($posicion1>0)
        {
            $elemento = substr($rawxml, $posicion1, $posicion2-$posicion1+9);
            $xmlElem = new SimpleXMLElement($elemento);
            foreach ($xmlElem->children() as $child){
                if($child->attributes() == $field){
                    $temporaryContent = $child;
                }
            }
            //manobra para retirar a dependencia do Nó XML
            $temporaryContent = " ".$temporaryContent;
            $content =  substr($temporaryContent,1, strlen($temporaryContent));

            return $content;

        }else{
          return null;
        }


    }

}

/**
 * A funcao getAllLibraries() retorna dois arrays
 * o primeiro esta em $libraryName
 * o segundo esta em $libraryCode
 * @return array. 
 */
function getAllLibraries(){
    
    //colocando todas as bibliotecas disponiveis na base na variavel collectionLibrary
    $dataModelLib = new library();
    $allLibraryData = $dataModelLib->getAllLibraries();
    $libraryName = array($allLibraryData[0][2]);
    $libraryCode = array($allLibraryData[0][1]);
    for ($i=1; $i<count($allLibraryData); $i++) {
        array_push($libraryName, $allLibraryData[$i][2]);
        array_push($libraryCode, $allLibraryData[$i][1]);
    }
    //retorna dois arrays
//    var_dump($libraryName); //die;
    return array($libraryName, $libraryCode);
}

?>