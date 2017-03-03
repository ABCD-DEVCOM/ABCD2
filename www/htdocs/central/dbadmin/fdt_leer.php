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
 <b><font face=arial size=1 color=white><?php echo $msgstr["fdt"].". ".$msgstr["database"]?>: <?php echo $arrHttp["base"]?>
 <font color=black>
		<table bgcolor=#EEEEEE width=100%>
			<td>Tag</td><td><?php echo $msgstr["fn"]?></td><td><?php echo $msgstr["subfields"]?></td><td><?php echo $msgstr["rep"]?></td><td><?php echo $msgstr["prefix"]?></td>
<?php
if ($arrHttp["Opcion"]!="new"){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
	if (file_exists($archivo)){		$fp=file($archivo);
	}else{
		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$arrHttp["base"]."/".$arrHttp["base"].".fdt";
	    	die;
	  	}
	}
}else{	$fp=explode("\n",$_SESSION["FDT"]);}
foreach ($fp as $value){
	$t=explode('|',$value);
	echo "<tr><td bgcolor=white>$t[1]</td><td bgcolor=white>".$t[2]."</td><td bgcolor=white>".$t[5]."</td><td bgcolor=white>";
	if ($t[4]==1) echo "R";
	echo "</td><td bgcolor=white>".$t[12]."</td>";
}
?>
</table>
