<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");


?>
<xlink rel="STYLESHEET" type="text/css" href="../css/styles.css">
<style>
	td{
		font-family:arial;
		font-size:12px;
	}
</style>
<script>
function AbrirVentana(){	msgwin=window.open("","Fdt","width=400,height=400,resizable,scrollbars=yes")
	msgwin.focus()}
</script>
<body bgcolor=white>
<?php echo "<font face=arial size=1>&nbsp; &nbsp;Script: fst_leer.php<p><font face=arial size=2>";
?>
 <b><?php echo $msgstr["fst"]?> &nbsp; (<a href=fdt_leer.php?base=<?php echo $arrHttp["base"]?> target=Fdt onclick=AbrirVentana()><?php echo $msgstr["displayfdt"]?><font color=black></a>)
 &nbsp; (<a href=adform_leer.php?base=<?php echo $arrHttp["base"]?> target=Fdt onclick=AbrirVentana()><?php echo $msgstr["advsearch"]?><font color=black></a>)

 <br>
		<table bgcolor=#EEEEEE>
			<td>ID</td><td><?php echo $msgstr["itech"]?></td><td><?php echo $msgstr["extrpft"]?></td>
<?php
$fst=$db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst";
if (file_exists($fst)){
	$fp=file($fst);
	foreach ($fp as $value){
		if (trim($value)!=""){
			$ix=strpos($value," ");
			$id=trim(substr($value,0,$ix));
			$value=trim(substr($value,$ix));
			$ix=strpos($value," ");
			$ti=trim(substr($value,0,$ix));
			$format=stripslashes(trim(substr($value,$ix+1)));
			echo "<tr><td bgcolor=white valign=top>$id</td><td bgcolor=white valign=top>$ti</td><td bgcolor=white><font face=\"courier new\">$format</td>";
		}
	}
}else{	echo "<tr><td bgcolor=white valign=top>&nbsp</td><td bgcolor=white valign=top>&nbsp</td><td bgcolor=white>&nbsp;</td>";
}
?>
</table>

<p>
</body>
</html>