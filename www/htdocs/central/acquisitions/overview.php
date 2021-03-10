<?php
/* Modifications
20210310 fho4abcd Replaced helper code fragment by included file
20210310 fho4abcd html code:body at begin+...
20210310 fho4abcd check existence $L1
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");

include("../common/get_post.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
echo "<body>\n";

// Se determina el total de registros según cada status del proceso
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&prefijo=STA_&Opcion=diccionario";
$IsisScript=$xWxis."ifp.xis";
include("../common/wxis_llamar.php");
$Total=array(0,0,0,0,0,0,0,0);

foreach ($contenido as $value)  {	$L=explode('|',$value);
	$ix=substr($L[0],4);
	if (isset($L[1]) ) $Total[$ix]=$L[1];
}

$encabezado="";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"]?>
	</div>
	<div class=actions>
		<?php include("suggestions_menu.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $ayuda="acquisitions/overview.html";include "../common/inc_div-helper.php" ?>

<div>
<div class="middle form">
	<div class="formContent">

	<center>
	<h3><?php echo $msgstr["overview"].": ".$msgstr["suggestions"]?></h3>
	<table class=statTable cellpadding=10 bgcolor=#cccccc>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_0" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["status_0"]?></td><td bgcolor=white> <?php if (isset( $Total[0])) echo $Total[0]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_1" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["approved"]?></td><td bgcolor=white> <?php if (isset($Total[1])) echo $Total[1]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_2" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["rejected"]?></td><td bgcolor=white> <?php if (isset($Total[2])) echo $Total[2]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_3" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["inbidding"]?></td><td bgcolor=white> <?php if (isset($Total[3])) echo $Total[3]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_4" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["prov_sel"]?></td><td bgcolor=white> <?php if (isset($Total[4])) echo $Total[4]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_5" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["purchase"]?></td><td bgcolor=white> <?php if (isset($Total[5])) echo $Total[5]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_6" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["itemsrec"]?></td><td bgcolor=white> <?php if (isset($Total[6])) echo $Total[6]?> </td>
		<tr>
			<td bgcolor=white align=left><a href="../dataentry/show.php?base=suggestions&Expresion=STA_7" target=_blank><img src=../images/icon/search.png align=absmiddle></a> <?php echo $msgstr["completed"]?></td><td bgcolor=white> <?php if (isset($Total[7])) echo $Total[7]?></td>
	</table>
	</center>

	</div>
</div>
<?php
include("../common/footer.php");
?>
</body></html>
