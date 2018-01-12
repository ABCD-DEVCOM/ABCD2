<?php
include ("../config.php");
include ("../common/get_post.php");
$dbn=$arrHttp["base"];
$file_name=$arrHttp["base"].".tab";
//echo "config=$file_name<BR>";

if (!$file_name){
	echo "Missing configuration file $file_name";
	die;
}
$fp=file($file_name);
foreach ($fp as $value){
	$value=trim($value);
	if (trim($value)!=""){
		if (substr($value,0,1)==";") continue;
		$ix=strpos($value,":");
		if ($ix===false){
			echo "error in configuration file $file_name";
			die;
		}
		$key=substr($value,0,$ix);
		$value=trim(substr($value,$ix+1));
		//echo "$key=$value<br>";

		$config[$key]=$value;
	}
}
?>
