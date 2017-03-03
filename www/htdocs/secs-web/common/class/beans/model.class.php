<?php

class Record
{
	var $campos;
	var $mfn;

	function __construct()
	{
		$this->campos = array();
	}

	function addField($campo, $overcharge=false)
	{
		$prohibidos = array();

		if (!in_array($campo->getTag(),$prohibidos) || $overcharge)
		{
			array_push($this->campos,$campo);
		}
	}

	function unserializeFromString($rawxml)
	{
		 $xml_parser  =  xml_parser_create();
		 xml_parse_into_struct($xml_parser,$rawxml,$vector,$indice);
		 xml_parser_free($xml_parser);
		 $buffer="";

		 for ($i=0; $i<sizeof($vector); $i++)
		 {
		 	if ($vector[$i]["tag"]=="RECORD" && $vector[$i]["type"]=="open")
		 	{
		 		$this->setMfn($vector[$i][attributes]["MFN"]);
		 	}

		 	if ($vector[$i]["tag"]=="FIELD" && $vector[$i]["type"]=="complete")
		 	{
		 		$campo = new Field();
		 		if($vector[$i][attributes]["TAG"] != "") {
		 		   $campo->setTag($vector[$i][attributes]["TAG"]);
		 		   $campo->setContent($vector[$i]["value"]);
		 		   $this->addField($campo);
		 		}
		 		//echo "<field tag=\"". $vector[$i][attributes]["TAG"]."\"><occ>".$vector[$i]["value"]."</occ></field>\n";
		 	}

		 	if ($vector[$i]["tag"]=="FIELD" && $vector[$i]["type"]=="open")
		 	{
		 		$campo = new Field();
		 		if($vector[$i][attributes]["TAG"] != "") {
		 		   $campo->setTag($vector[$i][attributes]["TAG"]);
		 		   $campo->setContent(str_replace("\r","",str_replace("\n","",trim($vector[$i]["value"]))));
		 		}
		 		//$buffer="<field tag=\"". $vector[$i][attributes]["TAG"]."\"><occ>".;
		 	}

		 	if ($vector[$i]["tag"]=="SUBFIELD" && $vector[$i]["type"]=="complete")
		 	{
		 		$subcampo = new Subfield();
		 		$subcampo->setLetra($vector[$i][attributes]["ID"]);
		 		$subcampo->setContent($vector[$i]["value"]);
		 		$campo->addSubField($subcampo);
		 		//$buffer.="^".$vector[$i][attributes]["ID"].trim(trim($vector[$i]["value"],"\r"),"\n");
		 	}

		 	if ($vector[$i]["tag"]=="FIELD" && $vector[$i]["type"]=="close")
		 	{
		 		$this->addField($campo);
		 		//$buffer .= "</occ></field>\n";
		 		//echo $buffer;
		 	}
		 }
	}

	function getMfn()
	{
		return $this->mfn;
	}

	function setMfn($mimfn)
	{
		$this->mfn = $mimfn;
	}

	function get910()
	{
		return $this->mfn;
	}

	function set910($mimfn)
	{
		$this->mfn = $mimfn;
	}


	function asXML()
	{
		$buffer = "";
		for ($i=0; $i<sizeof($this->campos);$i++)
		{
			$buffer.=$this->campos[$i]->asXML()."\n";
		}
		return $buffer;
	}

	function numOfFields()
	{
		return sizeof($this->campos);
	}

	function update_field($tag,$contenido)
	{
		for ($i=0;$i<sizeof($this->campos);$i++)
		{
		   $campo = $this->campos[$i];
		   if ($campo->getTag() == $tag)
		   {
		   	$campo->setContent($contenido);
		   	break;
		   }
		}
	}

	function select_fields($tag)
	{
		$resultado = array();

		for ($i=0;$i<sizeof($this->campos);$i++)
		{
		   $campo = $this->campos[$i];
		   if ($campo->getTag() == $tag)
		   {
		   	array_push($resultado,$campo);

		   }
		}
		return $resultado;
	}


	function nocc($tag)
	{
		$resultado = array();

		for ($i=0;$i<sizeof($this->campos);$i++)
		{
		   $campo = $this->campos[$i];
		   if ($campo->getTag() == $tag)
		   {
		   	array_push($resultado,$campo);

		   }
		}
		return sizeof($resultado);
	}

	function delete_fields($mitag)
	{
		$i=0;
		while ($i<sizeof($this->campos))
		{
		   $campo = $this->campos[$i];
		   print $this->campos[$i]->getTag()."\n";
		   	$i++;
		}
	}
}

class Field
{
	var $subcampos;
	var $tag;
	var $contenido;
	
	function __construct()
	{
		$this->subcampos=array();
	}

	function setTag($tag)
	{
		$this->tag = $tag;
	}
	
	function getTag()
	{
		return $this->tag;
	}
	
	
	function setContent($contenido)
	{
		$this->contenido = $contenido;	
	}
	
	function getContent()
	{
		return $this->contenido;	
	}
	
	
	function addSubField($subcampo)
	{
		array_push($this->subcampos,$subcampo);
	}
	
	function asXML()
	{
	    
		$buffer = "<field tag=\"".$this->tag."\"><occ>";
		$buffer .= $this->contenido;
		for ($j=0;$j<sizeof($this->subcampos);$j++)
		{
			$buffer .= $this->subcampos[$j]->asIsis();
		}
		$buffer.="</occ></field>";
	    
		return $buffer;
	}
	
}

class Subfield
{
	var $letra;
	var $content;
	function __construct()
	{
	}

    function setContent($content)
	{
		$this->content = $content;
	}

	function setLetra($letra)
	{
		$this->letra = $letra;
	}

	function asIsis()
	{
		return "^".$this->letra.$this->content;
	}

}




?>