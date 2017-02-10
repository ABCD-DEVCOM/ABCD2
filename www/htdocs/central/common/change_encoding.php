<?php
include("../config.php");
$encoding=$_GET['encoding'];
//READING abcd.def to find unicode
$fp=file($db_path."abcd.def");
$texto="";
foreach($fp as $line)
{
	$pos = strpos($line, "UNICODE");
	if ($pos === false)
	 {
		 $texto.=$line;echo $line."</br>";
	 }
		
}
fclose($fp);
if($texto!="")
{
if(isset($encoding)&& $encoding!="")
{
if($encoding=="ansi")
	$unicode='UNICODE=0';
else $unicode='UNICODE=1';
$texto.=$unicode;
$fp=fopen($db_path."abcd.def","w");
fwrite($fp,$texto);
}
}
?>