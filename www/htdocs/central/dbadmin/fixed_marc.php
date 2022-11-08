<?php
/* Modifications
20220202 fho4abcd back button, div-helper
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");


if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CENTRAL_MODIFYDEF"])  and !isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDEF"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])){
	echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
	die;
}
include("../common/header.php");
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";

?>
<body>
<link rel="STYLESHEET" type="text/css" href="../styles/basic.css">
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<?php if (isset($arrHttp["encabezado"])){
    	include("../common/institutional_info.php");
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["typeofrecords"].": ". $arrHttp["base"]?>
    </div>
    <div class="actions">
        <?php
        $backtoscript="menu_modificardb.php";
        include "../common/inc_back.php";
        include "../common/inc_home.php";
        ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="typeofrecs_marc.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
//READ THE TYPE OF RECORDS USING THE PICKLIST ASSOCIATED TO THE FIELD 3006 OF THE LEADER
unset($ldr_06);
if (file_exists($db_path.$arrHttp["base"]."/def/".$lang."/ldr_06.tab"))
	$ldr_06=file($db_path.$arrHttp["base"]."/def/".$lang."/ldr_06.tab");
else
    if (file_exists($db_path.$arrHttp["base"]."/def/".$lang_db."/ldr_06.tab"))
		$ldr_06=file($db_path.$arrHttp["base"]."/def/".$lang_db."/ldr_06.tab");

if (!$ldr_06){
	echo "missing file ".$ldr_06;
	die;
}
echo "<div style=position:relative;margin-left:100px>";
echo "<strong>File: ldr_06.fdt (<a href=picklist_edit.php?base=".$arrHttp["base"]."&picklist=ldr_06.tab&desde=fixed_marc$encabezado>".$msgstr["edit"]."</a>)</strong><p>" ;
foreach ($ldr_06 as $value){
	$value=trim($value);
	if ($value!=""){
		$t=explode('|',$value);
		echo $t[0]." - ".$t[1].": <a href=\"fdt.php?base=". $arrHttp["base"]."$encabezado&Fixed_field=y&fdt_name=".$t[2]."\">".$t[2]."</a><br>";
	}
}
echo "</div></div>";
include("../common/footer.php");?>
