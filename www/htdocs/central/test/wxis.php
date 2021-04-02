<?php
/* modifications
20210402 fho4abcd Added test with context
*/
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
	//die;
}
//echo "Result: <b>Ok !!!</b><p>";

if ($wxisUrl!=""){
	echo "<hr>";
	echo "<font color=blue>Testing the execution of  <b>$wxisUrl</b> via http(s), NO context</font><br>";
	echo "$wxisUrl?IsisScript=$xWxis".'hello.xis';
	$result =file_get_contents($wxisUrl."?IsisScript=$xWxis".'hello.xis');
	echo $result;

	echo "<hr>";
	echo "<font color=blue>Testing the execution of  <b>$wxisUrl</b> via http(s), WITH context</font><br>";
	echo "$wxisUrl?IsisScript=$xWxis".'hello.xis';
    $postdata="IsisScript=$xWxis".'hello.xis'; // $ postdata required by inc_setup-stream-contxt
    include "../common/inc_setup-stream-context.php";
	$result =file_get_contents($wxisUrl,false,$context);
	echo $result;

	//-----------------------------------------------------
	echo "<p><hr>";
	echo "<font color=blue>Testing the acces to the operator's database (acces) using http(s)</font><p>";
	$IsisScript=$xWxis."login.xis";
	$query = "&base=acces&cipar=$db_path"."par/acces.par"."&login=abcd&password=adm";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
   		echo "$linea";
	}
}

if ($Wxis!=""){
	echo "<hr>";
	echo "<font color=blue>Testing the execution of  <b>$Wxis</b></font><br>";
	echo "Command used: "."\"".$Wxis." what\" <p>";
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='."");
	exec("\"".$Wxis."\" what" ,$contenido,$ret);
	if ($ret==1){		echo "<font color=red>The program $Wxis could not be executed";
		die;	}
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
	$script=$xWxis."login.xis";
	$query = "base=acces&cipar=$db_path"."par/acces.par&login=abcd&password=adm&path_db=$db_path";
	echo "query=$query<br>";
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='."?xx=".$query);
	exec("\"".$Wxis."\" IsisScript=$script ",$contenido,$ret);
	//include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
   		echo "$linea<br>";
	}
}

?>
