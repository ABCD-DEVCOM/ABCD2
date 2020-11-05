<?php

session_start();
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/statistics.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_REQUEST["base"]) or !isset($_REQUEST["date_prefix"])) die;

if ($_REQUEST["date_prefix"]!=""){	$fp=fopen($db_path."/".$_REQUEST["base"]."/def/".$_SESSION["lang"]."/date_prefix.cfg","w");
	fwrite($fp,trim($_REQUEST["date_prefix"]));
	fclose($fp);
	echo $msgstr["date_pref"]." ".$msgstr["updated"]." (". $_REQUEST["date_prefix"].")<p>";}
echo "<a href=javascript:self.close()>".$msgstr["close"]."</a>";

?>

