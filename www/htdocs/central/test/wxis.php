<?php
include("../config.php");
echo "<xmp>";
echo "Path to databases: $db_path--\n";
echo "Path to wxis: $Wxis--\n";
echo "Path to IsisScripts: $xWxis--";
echo "</xmp>";

echo "<hr>";
echo "Testing if the  file <b>$Wxis</b> exists<br>";
if  (!file_exists($Wxis)){
	echo "missing $Wxis";
	die;
}
echo "Result: <b>Ok !!!</b><p>";

echo "<hr>";
echo "<font color=blue>Testing the execution of  <b>$wxisUrl</b> via Http</font><br>";
if ($fp = fopen($wxisUrl.'?what', 'r')) {
   $content = '';
   // keep reading until there's nothing left
   while ($line = fread($fp, 1024)) {
      $content .= $line;
   }
   echo $content;
   // do something with the content here
   // ...
} else {
   // an error occured when trying to open the specified url
}



echo "<hr>";
echo "<font color=blue>Testing the execution of  <b>$Wxis</b></font><br>";
echo "Command used: "."\"".$Wxis." what\" <p>";
exec("\"".$Wxis."\" what" ,$contenido,$ret);
if ($ret==1){	echo "<font color=red>The program $Wxis could not be executed";
	die;}
foreach ($contenido as $value) echo "$value<br>";
echo "Result: <b>Ok !!!</b><p>";
echo "<hr>";
$script=$xWxis."hello.xis";
echo "<font color=blue>Testing the execution of  <b>$Wxis</b> with the script <b>$script</b>: </font><br>";
echo "Command line: ". "\"".$Wxis."\" IsisScript=$script";
if (!file_exists($script)){
	echo "missing $script";
	die;
}
echo "<p>";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."");
exec("\"".$Wxis."\" IsisScript=$script ",$contenido,$ret);
if ($ret!=0) {
	echo "no se puede ejecutar el wxis. Código de error: $ret<br>";
	die;
}
foreach ($contenido as $value) echo "$value<br>";

//-----------------------------------------------------
echo "<p><hr>";
echo "<font color=blue>Testing the acces to the operator's database (acces) using exec</font><p>";

$IsisScript=$xWxis."login.xis";
$query = "?xx=&base=acces&cipar=$db_path"."par/acces.par"."&login=abcd&password=adm";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='.$query);
$contenido="";
include("../common/wxis_llamar.php");
$ic=-1;
$tag= "";
foreach ($contenido as $linea){
   echo "$linea";
}


echo "<p><hr>";
echo "<font color=blue>Testing the acces to the operator's database (acces) using Http</font><p>";

$IsisScript=$xWxis."login.xis";
$query = "&base=acces&cipar=$db_path"."par/acces.par"."&login=abcd&password=adm";
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){
   echo "$linea";
}

?>
