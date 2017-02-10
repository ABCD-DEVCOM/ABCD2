<?php
session_start();
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/soporte.php");
include("../lang/admin.php");
include("../lang/lang.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (!isset($_SESSION["permiso"])) {	echo "session expired";
	die;}
unset($fp);
$archivo=$db_path.$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$arrHttp["campo"];

if (file_exists($archivo)){	$fp=file($archivo);
}else{	$archivo=$db_path.$arrHttp["base"]."/ayudas/".$lang_db."/".$arrHttp["campo"];

	if (file_exists($archivo)){		$fp=file($archivo);
	}
}

if (!file_exists($archivo)){
	echo "<h4>".$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$arrHttp["campo"] ."</h4>";	echo $msgstr["notfound"];
	die;}
if (isset($fp)){	foreach ($fp as $value) {
		$value=str_replace('/php',$app_path.'/',$value);
		echo "$value\n";
	}}
?>
</body>
</html>