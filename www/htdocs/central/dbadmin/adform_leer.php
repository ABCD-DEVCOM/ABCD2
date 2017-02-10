<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
?>
<html>
<link rel="STYLESHEET" type="text/css" href="../css/styles.css">
<style>
	td{		font-family:arial;
		font-size:10px;	}
</style>
<?php echo "<font size=1 face=arial color=white>Script: fdt_leer.php</font><br>"?>
 <b><font face=arial size=1 color=white><?php echo $msgstr["advsearch"].". ".$msgstr["database"]?>: <?php echo $arrHttp["base"]?>
 <font color=black>
		<table bgcolor=#EEEEEE width=100%>
			<td><?php echo $msgstr["prefix"]?></td><td><?php echo $msgstr["description"]?></td>
<?php
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
if (file_exists($archivo)){	$fp=file($archivo);
}else{
	$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/camposbusqueda.tab";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		echo "missing file ".$arrHttp["base"]."/camposbusqueda.tab";
    	die;
  	}
}
foreach ($fp as $value){
	$t=explode('|',$value);
	echo "<tr><td bgcolor=white>$t[2]</td><td bgcolor=white>".$t[0]."</td>";
}
?>
</table>
