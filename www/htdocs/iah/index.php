<?php
$base = ($_REQUEST['base'] != '' ?  $_REQUEST['base'] : 'RDA');
$lang = ($_REQUEST['lang'] != '' ?  $_REQUEST['lang'] : 'en');
$form = $_REQUEST['form'];


if (stripos($_SERVER["SERVER_SOFTWARE"],"Win") > 0) {
    //Windows path variables
$db_path="/ABCD/www/bases/";                   //path where the bases are to be located
}else{
    //Linux path variables
$db_path="/var/opt/ABCD/bases/";
}

//buscando cisis_ver en dr_path.def de la BD
$drpathtext=$fp=file($db_path.$base."/dr_path.def");
foreach($fp as $line)
{
	$pos = strpos($line, "CISIS_VERSION");
	if ($pos !== false)
	 {
		$str_line=explode("=",$line);
		$CISIS_VERSION=$str_line[1];
	 }
}
if($CISIS_VERSION!="")
{
	$CISIS_VERSION=trim($CISIS_VERSION);
	}
//READING abcd.def to find unicode-setting
//$fp=file($db_path."par/".strtoupper($base).".def");
$fp=file($db_path."abcd.def");
$unicode="ansi";
foreach($fp as $line)
{
	$pos = strpos($line, "UNICODE");
	if ($pos !== false)
	 {
		$str_line=explode("=",$line);
		$use_unicode=$str_line[1];
		if($use_unicode!=0)
{
	$unicode="utf8";
}
else $unicode="ansi";
}
}
//echo "ENCODING=$unicode<BR>";
if($CISIS_VERSION!="")
$cisis_ver=$unicode."/".$CISIS_VERSION."/";
else $cisis_ver=$unicode."/";
//end
//Path to the wwwisis executable (include the name of the program, in Windows add .exe)
$Wxis="$cisis_ver"."wxis";

$hdr = "Location: /cgi-bin/". $Wxis . "/iah/scripts/?IsisScript=iah.xis&lang=" . $lang . "&base=" . strtoupper($base);
header($hdr);
?>
