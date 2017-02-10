<?php
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include("../config.php");
$t=explode('/',$arrHttp["help"]);
$a=$msg_path."documentacion/".$arrHttp["help"];
unset($fp);
$texto="";
if (file_exists($a)){
	$fp = file($a);
}else{
	if (isset($t[2]))
		$a=$msg_path."documentacion/en/".$t[2];
	else
		$a=$msg_path."documentacion/en/".$t[1];
	if (file_exists($a)) $fp=file($a);

}
if (isset($fp))
	foreach ($fp as $value) {
		echo "$value\n";	}
?>