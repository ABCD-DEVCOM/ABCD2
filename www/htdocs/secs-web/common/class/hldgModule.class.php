<?php
	class hldgModule {

		var $my_path = '';
		var $my_facicDB = '';
		var $my_hldgDB = '';
		var $my_titleDB = '';
		var $my_tag = '';
		var $my_mxPath = '';
		var $my_tempPath = '';
		var $my_tempIssues = array();
		var $sep = '_';
		var $displayRule = 'chron|type';
        var $my_ccode = '';

		function __construct($ccode, $modPath, $facicDB, $hldgDB, $titleDB, $tag, $mxPath, $tempPath, $displayRule='type')
		{
			if (strpos($modPath,'Chron')>0) $displayRule = 'chron';

			$this->my_path = $modPath;
			$this->my_facicDB = $facicDB;
			$this->my_hldgDB = $hldgDB;
			$this->my_titleDB = $titleDB;
			$this->my_tag = $tag;
			$this->my_mxPath = $mxPath;
			$this->my_tempPath = $tempPath;
			$this->displayRule = $displayRule;
            $this->my_ccode = $ccode;
		}
		
		function getSep() {
			$temp = $this->my_path .  $this->my_facicDB .  $this->my_hldgDB .  $this->my_titleDB .  $this->my_tag .  $this->my_mxPath .  $this->my_tempPath;
			if (strpos($temp , chr(92) )>0){
			} else {
				$this->sep = '|';
			}
		}
		
		function execute($titleId, $debug) {
            //centerCode
			if ($this->my_path &&  $titleId &&  $this->my_facicDB &&  $this->my_hldgDB &&  $this->my_titleDB &&  $this->my_ccode &&  $this->my_mxPath &&  $this->my_tempPath &&  $debug){
				$call = $this->my_path.'/win/generateForJournal.bat '.$titleId.' '.$this->my_facicDB.' '.$this->my_hldgDB.' '.$this->my_titleDB.' '.$this->my_ccode.' '.$this->my_mxPath.' '.$this->my_path. ' '.$this->my_tempPath.' '.$debug;
				if (strpos($call , chr(92) )>0){
					$call = str_replace( chr(47), chr(92), $call);
				} else {
					$call = str_replace('/win/', '/lin/', $call);
				}

				$file = $this->my_tempPath.'/'.$titleId.'.temp.txt';
				if ($this->my_tempIssues){
					if (strpos($file,chr(92))>0){
						$file = str_replace(chr(47),chr(92),$file);
					}
					$fp = fopen($file, "w");
					fwrite($fp, $this->my_tempIssues);
					fclose($fp);
				}
				exec($call);
				//$r = $call;
				if (file_exists($file.'.result')){
					$fp = fopen($file.'.result', "r");
					$r = fread($fp, filesize($file.'.result'));
					$r = str_replace(','.chr(39).'a'.$this->my_tag.'{','',$r);
					$r = str_replace('{a'.$this->my_tag.'{','<p/>',$r);
					$r = str_replace('{'.chr(39).',','',$r);
					fclose($fp);
					$this->my_tempIssues = array();
				}
				return $r;
			}	
		}

		function setTempIssues($aYEAR,$aVOLU,$aFASC,$aTYPE,$aSTAT,$aSEQN,$aMASK){
			$this->getSep();
			if (count($aYEAR)>0){
				foreach ($aYEAR as $k=>$v){
					$s = $aSEQN[$k];

					$s = str_repeat("0",30-strlen($s)).$s;
					if ($this->displayRule == 'type'){
						if ($aTYPE[$k]){
							$s = 'S'.$s;
						} else {
							$s = 'R'.$s;
						}
					}
					$content .= $s.$this->sep.$v.$this->sep;
					if ($aVOLU[$k]!='null'){
						$content .= $aVOLU[$k];
					}
					$content .= $this->sep;
					if ($aFASC[$k]!='null'){
						$content .= $aFASC[$k];
					}
					$content .= $this->sep;
					if ($aSTAT[$k]!='null'){
						$content .= $aSTAT[$k];
					}
					$content .= $this->sep;
					if ($aTYPE[$k]!='null'){
						$content .= $aTYPE[$k];
					}
					$content .= $this->sep;
					if ($aMASK[$k]!='null'){
						$content .= $aMASK[$k];
					}
					if ($this->displayRule == 'chron'){
						$content .= $this->sep;
						if ($aTYPE[$k]){
							$content .= 'S';
						} else {
							$content .= 'R';
						}
					}
					$content .= "\n";
				}
				$this->my_tempIssues = $content;
			}
		}
	}


class holding
{
	var $registro;
	var $totalRecords = 0;

	function __construct()
	{
		global $configurator;
		global $isisBroker;
		$this->registro = new Record();
	}
	function searchByTitle($title)
	{
		global $configurator, $isisBroker;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Holdings()."</database>\n";
		$xmlparameters .= "<from>1</from>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<search>I=".$title."</search>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->search($xmlparameters);
                //print_r($rawxml);
		$posicion1 = strpos($rawxml,"<record");
		$posicion2 = strpos($rawxml,"</record>");

		if ($posicion1>0)
		{
                    $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
                    $miregistro = new miuser($elemento,$configurator);
                    return $miregistro;
		}
		else
		{
		  return null;
		}


	}

	function createRecord($fieldsList)
	{
		//print_r($fieldsList);
		$_fields_tags = $GLOBALS['FACIC_NAME_TAG'];
		/** Verifica se os dados estao formatados como array
		 *  extraimos os dados do array, se houver ocorrencias de arrays nos campos, teremos subcampos
		 */
		if(is_array($fieldsList))
		{
			while (list($key, $val) = each($fieldsList))
			{
				if($val != "") {
					//Se o campo corrente for um array, extraimos seus dados
					if(is_array($fieldsList[$key]))
					{
						while (list($keyf, $valf) = each($fieldsList[$key]))
						{
							$this->defineField($_fields_tags[$key],$valf);
						}
					}else {
						$this->defineField($_fields_tags[$key],$val);
					}
				}
			}
		}
		//print_r($this->registro);
		return $this->registro;
	}
	function setRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $HOLDINGS_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Holding()."</database>\n";
		if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
			$xmlparameters .= "<search>TIT={$_REQUEST["title"]}</search>\n";
		}elseif(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
			$xmlparameters .= "<search>{$_GET["indexes"]}{$_REQUEST["searchExpr"]}</search>\n";
		}else {
			user_error("Para esta pesquisa, informe um termo!",E_USER_ERROR);
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
		}else {
			$xmlparameters .= "<fieldsort>920</fieldsort>\n";
		}

		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		if(isset($_REQUEST['title']) && $_REQUEST['title'] != "") {
			$rawxml = $isisBroker->IsisSearchSort($xmlparameters);
		}else{
			user_error("Selecione um título para ver seus Fasciculos",E_USER_ERROR);
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
			while (list($key,$val) = each($tempField)) {
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
		$this->setTotalRecords($recordList[0][1002]);
		return $recordList;
	}
	function getRecords(){

		return  $this->setRecords();
	}

	function setAllHoldings(){

            global $BVS_CONF, $configurator, $isisBroker, $HOLDING_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Holdings()."</database>\n";
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

                    while (list($key,$val) = each($tempField)) {
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

	function getAllHoldings()
	{
		return $this->setAllHoldings();
	}

}

/**
 * A funcao getAllIssues() retorna dois arrays
 * o primeiro esta em $titleName
 * o segundo esta em $titleCode
 * @return array.
 */
function getAllHoldings(){

    //colocando todas as bibliotecas disponiveis na base na variavel collectionIssue
    $dataModel = new holding();
    $allHoldingData = $dataModel->getAllHoldings();
    $field30Hlds = array($allHoldingData[0][30]);
    $field37Hlds = array($allHoldingData[0][37]);
    $field970Hlds = array($allHoldingData[0][970]);
    for ($i=1; $i<count($allHoldingData); $i++) {
        array_push($field30Hlds, $allHoldingData[$i][30]);
        array_push($field37Hlds, $allHoldingData[$i][37]);
        array_push($field970Hlds, $allHoldingData[$i][970]);
    }
    return array($field30Hlds, $field37Hlds, $field970Hlds);
}

function getField37(){

    //colocando todas as bibliotecas disponiveis na base na variavel collectionIssue
    $dataModel = new holding();
    $allHoldingData = $dataModel->getAllHoldings();
    $field30Hlds = array($allHoldingData[0][30]);
    $field37Hlds = array($allHoldingData[0][37]);
    $field970Hlds = array($allHoldingData[0][970]);
    for ($i=1; $i<count($allHoldingData); $i++) {
        array_push($field30Hlds, $allHoldingData[$i][30]);
        array_push($field37Hlds, $allHoldingData[$i][37]);
        array_push($field970Hlds, $allHoldingData[$i][970]);
    }
    return array($field30Hlds, $field37Hlds, $field970Hlds);
}

?>