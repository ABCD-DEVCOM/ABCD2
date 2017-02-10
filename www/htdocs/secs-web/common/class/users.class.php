<?php
/**
 * @desc        Classe de controle de base de dados
 * @package     [SeCS-Web] ABCD
 * @version     1.0
 * @author      Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
 * @since       julho de 2009
 * @copyright   (c)BIREME - PFI - 2009
 * @public
*/


/**
 * @desc        User class is used to define user object
 * @author      Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
 *
 */
class user
{
	
	var $registro;
	var $totalRecords = 0;
	
        /**
         *
         * @author  Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
         * @desc    Constructor
         */
        function __construct()
	{
		global $configurator;
		global $isisBroker;
		$this->registro = new Record();
	}

        /**
         * 
         * @desc    Search records in user database by MFN
         * @author  Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
         */
	function setRecordByMFN($mfn)
	{
		global $configurator, $isisBroker, $USERS_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
		$xmlparameters .= "<from>{$mfn}</from>\n";
		$xmlparameters .= "<to>{$mfn}</to>\n";
		$xmlparameters .= "<count>1</count>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<xml_header>yes</xml_header>\n";
		$xmlparameters .= "<reverse>Off</reverse>\n";
		$xmlparameters .= "</parameters>\n";

		$rawxml = $isisBroker->listar($xmlparameters);
		$record = xmlIsisToArrayField($rawxml);

		for($i=0;$i<count($record);$i++){
            $key = key($record[$i]);
            $_record[$key][] = utf8_decode($record[$i][$key][0]);
        }
        
        return $_record;

	}

	function getRecordByMFN($mfn) {
		return $this->setRecordByMFN($mfn);
	}

	function setRecords()
	{
		
		global $BVS_CONF, $configurator, $isisBroker, $USERS_TAG_NAME;

		$xmlparameters = "<parameters>\n";
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
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
		$_fields_tags = $GLOBALS['USERS_NAME_TAG'];
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
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Users()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

                //print_r($this->registro);
                //die();
		
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
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
		$xmlparameters .= "<mfn>$mfn</mfn>\n";
		$xmlparameters .= "<fst>".$configurator->getPath2Users()."</fst>\n";
		$xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
		$xmlparameters .= "<lockid>".string_generator()."</lockid>\n";
		$xmlparameters .= "<expire>".$configurator->getTimeOut()."</expire>\n";
		$xmlparameters .= "</parameters>\n";

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


	function define_field($tag,$content)
	{
		$field = new Field();
		$field->setTag($tag);
		$field->setContent($content);
		$this->registro->addField($field);
	}
	
	function getuserId()
	{
		$id = $this->registro->getMfn();
		return $id;
	}
	
	function getCenterCode()
	{
		$name = $this->registro->select_fields("6");
		return $name[0]->getContent();
	}


}


class miuser extends user 
{
	function __construct ($xml, $configurator)
	{
		$this->registro = new Record();
		$this->registro->unserializeFromString($xml);			
	}
	
	
	function getuserName()
	{
		$name = $this->registro->select_fields("1");
		return $name[0]->getContent();
	}
	
	function getLogin()
	{
		$name = $this->registro->select_fields("1");
		return $name[0]->getContent();
	}
	
	function getPassword()
	{
		$name = $this->registro->select_fields("3");
		return $name[0]->getContent();

	}
	
	function getRole()
	{
		$name = $this->registro->select_fields("4");
		return $name;
	}

	function getLib()
	{
		$name = $this->registro->select_fields("5");
		return $name;
	}

 	function getLibDir()
	{
		$name = $this->registro->select_fields("6");
		return $name;
	}

	function getLang()
	{
		$name = $this->registro->select_fields("12");
		return $name[0]->getContent();
	}

 	/*function getFormView()
	{
		$name = $this->registro->select_fields("13");
		return $name[0]->getContent();
	}*/

	/*function isAdministrator() 
	{
	  
	  if ($this->getRole()=='Administrador')
	  {
		return '1';	
	  }
	  else 
	  {
	  	return '0';
	  }	
	}*/
	
}


class users
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
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n";
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
		$xmlparameters .= "<database>".$configurator->getPath2Users()."</database>\n"; 
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