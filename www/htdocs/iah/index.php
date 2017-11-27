<?php
$base = ($_REQUEST['base'] != '' ?  $_REQUEST['base'] : 'marc');
$lang = ($_REQUEST['lang'] != '' ?  $_REQUEST['lang'] : 'en');
$form = $_REQUEST['form'];

//define database path according to OS
if (stripos($_SERVER["SERVER_SOFTWARE"],"Win") > 0)    {
 $db_path="/ABCD/www/bases/" ;
 $ext_exec=".exe";
 }
else {
 $db_path="/var/opt/ABCD/bases/";
 $ext_exec="";
 }
//unicode defined in abcd.def
$dbpath=$db_path."abcd.def";
$def2= parse_ini_file($dbpath);
if (isset($def2["UNICODE"]))  {
 $unicode=trim($def2["UNICODE"]);
 if (intval($unicode)!=0) $unicode="utf8"; else $unicode="ansi";}
else
 $unicode="ansi";

//cisis_ver and unicode defined in dr_path.def
$drpath= $db_path.$base."/dr_path.def";
 $def= parse_ini_file($drpath);
if (isset($def["CISIS_VERSION"]))
 $cisis_version=trim($def["CISIS_VERSION"]);
else
 $cisis_version="";
if (isset($def["UNICODE"]))  {
 $unicode=trim($def["UNICODE"]);
 if (intval($unicode)!=0) $unicode="utf8"; else $unicode="ansi";}
//echo "cisisver=".$cisis_version."<BR>";
//die;
if ($cisis_version!="")
$cisis_ver=$unicode."/".$cisis_version."/";
else $cisis_ver=$unicode."/";


//Path to the wwwisis executable (include the name of the program, in Windows add .exe)
$Wxis=$cisis_ver."wxis" . $ext_exec;
$hdr = "Location: /cgi-bin/". $Wxis . "/iah/scripts/?IsisScript=iah.xis&lang=" . $lang . "&base=" . strtoupper($base);
header($hdr);
?>
