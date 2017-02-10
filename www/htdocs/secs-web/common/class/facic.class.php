<?php
/**
 * @desc        Classe de controle de base de dados - FACIC
 * @package     [secsWeb] SeCS
 * @version     1.0
 * @author      Domingos Teruel <domingosteruel@terra.com.br>
 * @since       28 de janeiro 2008
 * @copyright   (c)BIREME - PFI - 2008
 * @public  
*/  

class facic
{
	var $registro;
	var $totalRecords = 0;

	function __construct()
	{
		global $configurator;
		global $isisBroker;	
		$this->registro = new Record();	
	}
	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $FACIC_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		$xmlparameters .= "<from>{$mfn}</from>\n";
		$xmlparameters .= "<to>{$mfn}</to>\n";
		$xmlparameters .= "<count>1</count>\n";
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
		//print_r($this->createRecord($recordList[0]));

		return $recordList[0];

	}
	function getRecordByMFN($mfn) {
		return $this->setRecordByMFN($mfn);
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
	function setAllNameMask(){
		global $BVS_CONF, $configurator, $isisBroker, $MASK_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
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
			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<record");
			$posicion2 = strpos($rawxml,"</record>");

		}
		$collectionMask = array();
		reset($recordList);
		while (list($key, $val) = each($recordList)) {
			$collectionMask += array($recordList[$key]["801"] => $recordList[$key]["801"]);
		}
		sort($collectionMask);
		return $collectionMask;
	}
	function getAllNameMask()
	{
		return $this->setAllNameMask();
	}
	function setRecodsByTitle($title='',$count=0){
		global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		//Used when has search

		if ($title == ''){
			$title = $_REQUEST["title"];
		}

		if(isset($title) && $title != "") {
			$xmlparameters .= "<search>TIT={$title}</search>\n";
		}
		if(isset($_GET['startIndex']) && $_GET['startIndex'] > 0) {
			$xmlparameters .= "<from>{$_GET['startIndex']}</from>\n";
		}else{
			$xmlparameters .= "<from>1</from>\n";
		}
		if ($count == 'all'){
		} else {
			if(isset($_GET["results"]) && $_GET["results"] != "") {
				$xmlparameters .= "<count>{$_GET['results']}</count>\n";
			}else{
				$xmlparameters .= "<count>1</count>\n";
			}
		}

		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		if(isset($title) && $title != "") {
			$rawxml = $isisBroker->search($xmlparameters);

		}else{
			user_error("Pesquisa Invalida, Sem Título para pesquisar");
		}

		$posicion1 = strpos($rawxml,"<record");
		$posicion2 = strpos($rawxml,"</record>");
var_dump($rawxml);
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

			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<record");
			$posicion2 = strpos($rawxml,"</record>");

		}
		
		return $recordList;
	}	
	function setRecords()
	{
		global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		//Used when has search
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
		
		//die($xmlparameters);
		
		if(isset($_REQUEST['title']) && $_REQUEST['title'] != "") {
			$rawxml = $isisBroker->IsisSearchSort($xmlparameters);
		}else{
			user_error("Selecione um título para ver seus Fasciculos",E_USER_ERROR);
			//$rawxml = $isisBroker->listar($xmlparameters);
		}
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
			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<record");
			$posicion2 = strpos($rawxml,"</record>");

		}
		
		//$tt = $this->searchRecord('TIT',$_REQUEST["title"]);
		
		$this->setTotalRecords($recordList[0][1002]);
		
		return $recordList;
	}
	function searchRecord($field,$value,$updMask)
	{
		global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		if($updMask){
			$xmlparameters .= "<database>".$configurator->getPath2Mask()."</database>\n";
		}else{
			$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		}
		//Used when has search
		$xmlparameters .= "<search>$field=$value</search>\n";

		if(isset($_GET['startIndex']) && $_GET['startIndex'] > 0) {
			$xmlparameters .= "<from>{$_GET['startIndex']}</from>\n";
		}else{
			$xmlparameters .= "<from>1</from>\n";
		}
		if(isset($_GET["results"]) && $_GET["results"] != "") {
			$xmlparameters .= "<count>{$_GET['results']}</count>\n";
		}else{
			$xmlparameters .= "<count>1</count>\n";
		}

		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>On</reverse>\n";
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
			//array_push($recordList,$tempRecord);

			$tempRecord = null;

			$rawxml = substr($rawxml,$posicion2+1);

			$posicion1 = strpos($rawxml,"<record");
			$posicion2 = strpos($rawxml,"</record>");

		}

		return $recordList;
	}
	function getRecords(){

		return  $this->setRecords();
	}
	function getRecordsByTitle() {
		return $this->setRecodsByTitle();
	}
	function setTotalRecords($total)
	{
		if ($total == '') $total = 0;
		$this->totalRecords = $total;
	}
	function getTotalRecords(){
		return $this->totalRecords;
	}
	function setIndex(){
		global $configurator, $isisBroker, $FACIC_TAG_NAME;

		$xmlparameters =  "<parameters>\n";
		$xmlparameters .= "<database>". $configurator->getPath2Facic(). "</database>\n";
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

	function saveRecord($mfn)
	{

		$mfnFacic = $mfn;
		global $configurator, $isisBroker,$smarty, $BVS_LANG;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		$xmlparameters .= "<mfn>$mfnFacic</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Facic()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";
		if ($mfn == 'New' ){
			$r = $isisBroker->writeNewRecord($xmlparameters, $this->registro);
			//user_notice($BVS_LANG["sucessSaveRecord"]);
		}else{
			if ($isisBroker->updateRecord($xmlparameters, $this->registro)){
				$r = $mfn;
			}
			//user_notice($BVS_LANG["sucessSaveRecord"]);
		}
		return $r;
	}

	function old_saveRecord ($mfn)
	{

		$mfnFacic = $mfn;
		global $configurator, $isisBroker,$smarty, $BVS_LANG;


		$busca = $this->registro->campos["9"]->contenido;

		$i=0;
		$found = false;
		while (!$found && $i<count($this->registro->campos)){
			$f = $this->registro->campos[$i];
			if ($f->tag == '910'){
				$busca = $f->contenido;
			}
			$i++;
		}

		$xmlparameters2 = "<parameters>\n";
		$xmlparameters2 .= "<database>".$configurator->getPath2Mask()."</database>\n";
		$xmlparameters2 .= "<search>".$busca."</search>\n";
		$xmlparameters2 .= "<from>1</from>\n";
		$xmlparameters2 .= "<count>1</count>\n";
		$xmlparameters2 .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters2 .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters2 .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters2 .= "</parameters>\n";
		$maskRawxml = $isisBroker->searchFacic($xmlparameters2);
		$strStart = stripos($maskRawxml," mfn=\"") + 6;
		$strEnd = stripos($maskRawxml,"\">",$strStart) ;
		$tamanho = $strEnd - $strStart;
		$meuMfn = substr($maskRawxml,$strStart,$tamanho);

        if(is_numeric($meuMfn)=="1"){

			$xmlparameters2 = str_replace("</parameters>\n","",$xmlparameters2);
			$xmlparameters2 .= "<mfn>".$meuMfn."</mfn>\n";
			$xmlparameters2 .= "<fst>".$configurator->getPath2Mask().".fst</fst>\n";
			$xmlparameters2 .= "</parameters>\n";
			
			$retira = strstr($maskRawxml,"<record mfn=") ;
			$retira = str_replace("<record mfn=","",$retira);
			$retira = str_replace("\"".$meuMfn."\">","",$retira);
			$retira = str_replace("</record>","",$retira);
			$retira = str_replace("</wxis-modules>","",$retira);
			$retira = str_replace("<field tag=\"1001\" name=\"Isis_Current\">1</field>","",$retira);
			$retira = str_replace("<field tag=\"1002\" name=\"Isis_Total\">1</field>","",$retira);
			$retira = str_replace("</field>","</occ></field>",$retira);
			$retira = str_replace("\">","\"><occ>",$retira);
			
			if(stripos($retira,"tag=\"113\"><occ>false") != ""){
				$retira = str_replace("<field tag=\"113\"><occ>false</occ></field>","<field tag=\"113\"><occ>true</occ></field>",$retira);
			}
			$grava = $isisBroker->updateRecordFacic($xmlparameters2,$retira);
		}
		
		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		$xmlparameters .= "<mfn>$mfnFacic</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Facic()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";
		if (is_null($isisBroker->getError()))
		{
			if ($mfn == 'New' ){
				$x = $isisBroker->writeNewRecord($xmlparameters, $this->registro);
				user_notice($BVS_LANG["sucessSaveRecord"]);
			}else{
				$isisBroker->updateRecord($xmlparameters, $this->registro);
				user_notice($BVS_LANG["sucessSaveRecord"]);
			}

		}else{
			/**
			echo $isisBroker->getError();
			die;
			*/
			user_error($isisBroker->getError(),E_ERROR);
		}
	}
	function deleteRecord ($mfn)
	{
		global $configurator, $isisBroker, $BVS_LANG;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Facic()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

		/**
		print $xmlparameters;
		die;
		**/

		if (is_null($isisBroker->getError()))
		{
			$isisBroker->deleteRecord($xmlparameters);
			user_notice($BVS_LANG["sucessDeleteRecord"]);
			
		}
		else
		{
			/**
			echo $isisBroker->getError();
			die;
			*/
			user_error($isisBroker->getError(),E_ERROR);
		}
	}
	function defineField($tag,$content)
	{
		$field = new Field();		
		//$content = utf8_encode($content);
		$field->setTag($tag);
		$field->setContent($content);
		$this->registro->addField($field,true);
	}
	function defineSubfield($letter,$content)
	{
		//$content = utf8_encode($content);
		$subfield = new Subfield();
		$subfield->setLetra($letter);
		$subfield->setContent($content);
		return $subfield;
	}

	function setAllIssues($searchExpr){

            global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;

            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
            /*if($searchExpr != "" || $searchExpr != "null"){
                $xmlparameters .= "<search>$searchExpr</search>\n";
                $xmlparameters .= "<from>1</from>\n";
                $xmlparameters .= "<to>99999</to>\n";
                $xmlparameters .= "<count>1</count>\n";
            }*/
            $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
            $xmlparameters .= "<xml_header>yes</xml_header>\n";
            $xmlparameters .= "<reverse>Off</reverse>\n";
            $xmlparameters .= "</parameters>\n";

            /*if($searchExpr != "" || $searchExpr != "null"){
                $rawxml = $isisBroker->searchFacic($xmlparameters);
            }else{
                $rawxml = $isisBroker->listar($xmlparameters);
            }*/
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

	function getAllIssues($searchExpr)
	{
		return $this->setAllIssues($searchExpr);
	}

    function multipleDelete($titleId){
        global $configurator, $isisBroker, $BVS_LANG;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Facic()."</database>\n";
        $xmlparameters .= "<search>TIT={$titleId}</search>\n";
        $xmlparameters .= "<fst>".$configurator->getPath2Facic()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "</parameters>\n";

		/**
		print $xmlparameters;
		die;
		**/
		if (is_null($isisBroker->getError()))
		{
			$isisBroker->multipleDelete($xmlparameters);
//var_dump($isisBroker);die();
			//user_notice($BVS_LANG["sucessDeleteRecord"]);
            $xmlparameters = "<parameters>\n";
            $xmlparameters .= "<database>".$configurator->getPath2Holdings()."</database>\n";
            $xmlparameters .= "<search>I={$titleId} or tit={$titleId}</search>\n";
            $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
            $xmlparameters .= "</parameters>\n";
            $isisBroker->multipleDelete($xmlparameters);
            //var_dump($isisBroker);die();
            return true;

		}
		else
		{
			/**
			echo $isisBroker->getError();
			die;
			*/
			return false;
		}
    }

}

/**
 * A funcao getAllIssues() retorna dois arrays
 * o primeiro esta em $titleName
 * o segundo esta em $titleCode
 * @return array.
 */
function getAllIssues($searchExpr){

    //colocando todas as bibliotecas disponiveis na base na variavel collectionIssue
    $dataModel = new facic();
    $allIssueData = $dataModel->getAllIssues($searchExpr);
    $field30 = array($allIssueData[0][30]);
    $field910 = array($allIssueData[0][910]);
    $field911 = array($allIssueData[0][911]);
    $field912 = array($allIssueData[0][912]);
    $field913 = array($allIssueData[0][913]);
    $field914 = array($allIssueData[0][914]);
    $field915 = array($allIssueData[0][915]);
    for ($i=1; $i<count($allIssueData); $i++) {
        array_push($field30, $allIssueData[$i][30]);
        array_push($field910, $allIssueData[$i][910]);
        array_push($field911, $allIssueData[$i][911]);
        array_push($field912, $allIssueData[$i][912]);
        array_push($field913, $allIssueData[$i][913]);
        array_push($field914, $allIssueData[$i][914]);
        array_push($field915, $allIssueData[$i][915]);
    }
    //retorna dois arrays
    //
    return array($field30, $field910, $field911, $field912, $field913, $field914, $field915);
}


?>