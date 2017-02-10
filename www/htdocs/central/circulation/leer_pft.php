<?php

function LeerPft($pft_name,$dbname=""){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	if ($dbname=="")
		$dbname=$arrHttp["db"];
	$archivo=$db_path.$dbname."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["db"]."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;

}

?>
