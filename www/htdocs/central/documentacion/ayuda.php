<?php
/* Modifications
2021-03-03 fho4abcd Display ansi helpfiles with extended characterset correct
2021-03-03 fho4abcd Display error if not found
*/
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
if (isset($fp)) {
    $content = file_get_contents($a);
    $homepage= mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
} else {
    $homepage= "<p>Help file &#8594; ".$arrHttp["help"]." &#8592; Does not exist.<br></p>";
    $homepage= $homepage."<p>We cannot find a suitable replacement too. So sorry</p>";
}
?>
<!DOCTYPE html>
<html><body>
<?php
echo $homepage;
?>
