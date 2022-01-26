<?php
/*
20220125 fho4abcd buttons+div-helper + update to php7: ereg_replace->preg_replace
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");


include("../lang/dbadmin.php");
include("../lang/soporte.php");

$lang=$_SESSION["lang"];


function CrearPft($Pft_w){
global $arrHttp,$msgstr;
	$ix=0;
	echo "<p><dd><span class=title>".$msgstr["subir"]." ".$arrHttp["base"].".pft"."</span>";
	$salida="";
	echo "<dd><table bgcolor=#FFFFFF>
		<td>";
	echo "<xmp>$Pft_w</xmp>";
	echo "</dd></table>";
	echo "<dd>" .$arrHttp["base"].".pft Uploaded!!";
	return $Pft_w;
}

include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
} else {
    $encabezado="";
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["winisisdb"].": " . $arrHttp["base"]?>
    </div>
	<div class="actions">
    <?php
    $backtoscript="winisis_upload_fst.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"]).$encabezado;
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="winisis_upload_pft.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
    <div class="formContent">"
<?php
$files = $_FILES;
if ($files['userfile']['size']) {
      // clean up file name
      	$name=$files['userfile']["size"];
        $name=str_replace(" ", "_", str_replace("%20", "_", strtolower($name)));
		$name=preg_replace("[^a-z0-9._]", "",$name);
      	$fp=file($files['userfile']['tmp_name']);
       	$Pft="";
        foreach($fp as $linea) $Pft.=$linea;
        $Pft_conv=CrearPft($Pft);
}

$_SESSION["PFT"]=$Pft_conv;
echo "<P><dd><a href=menu_creardb.php?base=".$arrHttp["base"].">".$msgstr["cancel"]."</a> &nbsp; &nbsp;
	<a href=winisis_upload_fst.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"])."$encabezado>".$msgstr["back"]."</a> &nbsp; &nbsp; &nbsp; &nbsp;
	<a href=crearbd_new_create.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["createdb"]."</a> &nbsp; &nbsp; &nbsp; &nbsp;
	";
echo "</div></div>\n";
include("../common/footer.php");
?>
