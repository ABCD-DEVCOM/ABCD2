<?php
/*
** 20240509 fho4abcd Created

** Function  : Functions to Read/write the file with freesearch parameters
** Usage     : <?php include "freesearch_sav_inc.php" ?>
*/
function Freesearch_table_file($option,&$name_arr){
	global $msgstr,$db_path,$arrHttp,$lang_db;
	$archivo_name="freesearch_save.tab";
	$archivo_exists=true;
	$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$archivo_name;
	if (!file_exists($archivo)){
		$archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$archivo_name;
		if (!file_exists($archivo)){
			$archivo_exists=false;
		}
	}
	if ($option=="Read") {
		$name_arr=array();
		if (!$archivo_exists) return;
		$fp=fopen($archivo,"r");
		if($fp){
			while( ($value=fgets($fp))!== false){
				$value=trim($value);
				if ($value !="") {
					$savarr=explode('|',$value);
					if (sizeof($savarr)>=2) {
						if ($savarr[0]!="" && $savarr[1]!="") {
							$name_arr[$savarr[0]]=$savarr[0]."|".$savarr[1];
						}
					}
				}
			}
			fclose($fp);
		}
		if (sizeof($name_arr)>0) ksort($name_arr);
		return;
	} elseif ($option=="Write") {
		$fp=fopen($archivo,"w");
		if($fp){
			foreach($name_arr as $value){
				fwrite($fp,$value."\n");
			}
			fclose($fp);
			echo "<h1>".$archivo_name."&nbsp;:&nbsp;".$msgstr["saved"]."</h1>";
		}
	}
}
