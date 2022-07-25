<?php
/**
 * Displays a field to select the display format.
 */

function SelectFormato($base,$db_path,$msgstr){
	$PFT="";
	$Formato="";
	$archivo=$base."_formatos.dat";
	if (file_exists($db_path.$base."/opac/".$_REQUEST["lang"]."/".$archivo)){
		$fp=file($db_path.$base."/opac/".$_REQUEST["lang"]."/".$archivo);
	}else{
		echo "<h4><font color=red>".$msgstr["no_format"]."</h4>";
		die;
	}


	$select_formato=$msgstr["select_formato"]." <select name=cambio_Pft id=cambio_Pft onchange=CambiarFormato()>";

	$primero="";
	$encontrado="";
	foreach ($fp as $linea){
		if (trim($linea!="")){
			$f=explode('|',$linea);
			$f[0]=trim($f[0]);
			if (substr($f[0],strlen($f[0])-4)==".pft") $f[0]=substr($f[0],0,strlen($f[0])-4);
			$linea=$f[0].'|'.$f[1];
			if ($PFT==""){
				$PFT=trim($linea);
			} else {
				$PFT.='$$$'.trim($linea);
			}
			if (!isset($_REQUEST["Formato"]) and $primero==""){
				$primero=$f[0];
			}
			if (isset($_REQUEST["Formato"]) and $_REQUEST["Formato"]==$f[0]){
				$xselected=" selected";
				$encontrado="Y";
			}else {
				$xselected="";
				$select_formato.= "<option value=".$f[0]." $xselected>".$f[1]."</option>\n";
			}
		}
	}

	$select_formato.="</select>";
	if ($encontrado!="Y")
		$_REQUEST["Formato"]=$primero;
	$Formato=$_REQUEST["Formato"];
	return array($select_formato,$Formato);
}