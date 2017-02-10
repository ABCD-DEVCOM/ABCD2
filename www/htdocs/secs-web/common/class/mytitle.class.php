<?php


class mytitle
{

	//var $configurator;
	//var $brokerIsis;
	var $registro;
	var $totalRecords = 0;
	
	function __construct()
	{
		global $configurator;
		global $isisBroker;
		$this->registro = new Record();
	}

	function mytitle()
	{
		return $this->__construct();
	}
	
	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $MYTITLE_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n";
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
					$tempRecord[$tempField[$key]->tag] = array_merge($varTemp, $tempField[$key]->contenido);
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
		//print_r($this->createRecord($recordList[0]));
		return $recordList[0];

	}

	function getRecordByMFN($mfn) {
		return $this->setRecordByMFN($mfn);
	}

	function setRecords()
	{
		
		global $BVS_CONF, $configurator, $isisBroker, $MYTITLE_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n";
		if(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
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
	
	function createRecord($fieldsList)
	{
		//print_r($fieldsList);
		$_fields_tags = $GLOBALS['MYTITLE_NAME_TAG'];
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
		return $this->registro;
	}
	
	function saveRecord ($mfn)
	{
		global $configurator, $isisBroker, $BVS_LANG;
		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2myTitle()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";
		
		//print $xmlparameters;
		//print_r ($this->registro->asXML());
		//print_r ($this->registro->campos);
		
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
			mytitle_error($isisBroker->getError(),E_ERROR);
		}
	}

	function deleteRecord ($mfn)
	{
		global $configurator, $isisBroker, $BVS_LANG;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2myTitle()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

		//print $xmlparameters;
		//die;

		if (is_null($isisBroker->getError()))
		{
			$isisBroker->deleteRecord($xmlparameters);
			//mytitle_notice($BVS_LANG["sucessDeleteRecord"]);
		}
		else
		{
			mytitle_error($isisBroker->getError(),E_ERROR);
		}
	}

	function define_field($tag,$content)
	{
		$field = new Field();
		$field->setTag($tag);
		$field->setContent($content);
		$this->registro->addField($field);
	}
	
	function getmytitleId()
	{
		$id = $this->registro->getMfn();
		return $id;
	}
	
	function getCenterCode()
	{
		$name = $this->registro->select_fields("5");
		return $name[0]->getContent();
	}

}


class mytitles
{
	var $configurator;
	var $usuarios;
	var $brokerIsis;
	var $isisBroker;
	var $registro;
	
	
	
	function __construct()
	{
		global $configurator;
		global $isisBroker;
		$this->registro = new Record();
		
	}
	
	function get_all()
	{
		global $configurator, $isisBroker;
		
		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n";
		$xmlparameters .= "<from>1</from>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";
		
		$rawxml = $this->brokerIsis->listar($xmlparameters);
		//print "Elemento:".$rawxml;
		//die  ();
			
		$posicion1 = strpos($rawxml,"<record");
		$posicion2 = strpos($rawxml,"</record>");
		
		while ($posicion1>0)
		{
				$elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
				
		
				$miregistro = new miuser($elemento,$configurator);
				array_push($this->usuarios, $miregistro);			
				
				$rawxml = substr($rawxml,$posicion2+1);

				$posicion1 = strpos($rawxml,"<record");
				$posicion2 = strpos($rawxml,"</record>");
		}		
			
		
	}
	
	function searchByLogin($login)
	{
		global $configurator, $isisBroker;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2myTitle()."</database>\n"; 
		$xmlparameters .= "<from>1</from>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<search>".$login."/(1)</search>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";
		
		$rawxml = $isisBroker->search($xmlparameters);
		//die("aqui".$rawxml);

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
		
	function print_formatted()
	{
		$buffer="";
		foreach ($this->usuarios as $mit)
		{
			$buffer.=$mit->return_formatted().",\n";			
		}	
		return $buffer;
	}
		
	function mytitles()
	{
		return $this->__construct();
	}
		
	function numberOfUsuarios()
	{
		return sizeof($this->usuarios);
	}
	
	function getUserAt($i)
	{
		return $this->usuarios[$i];
	}
	
	function getUserName()
	{
		$name = $this->registro->select_fields("2");
		return $name[0]->getContent();
	}
	
	function getPassword()
	{
		$name = $registro->select_fields("3");
		return $name[0]->getContent();
	}
	
	function getUserId()
	{
		$id = $this->registro->select_fields("4");
		return $id[0]->getContent();
	}

	function getLogin()
	{
		$name = $this->registro->select_fields("4");
		return $name[0]->getContent();
	}

	function getRole()
	{
		$name = $this->registro->select_fields("6");
		return $name[0]->getContent();
	}
}
   
?>