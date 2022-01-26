<?php
/*
20220125 fho4abcd buttons+div-helper
*/
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
unset($_SESSION["FDT"]);
unset($_SESSION["PFT"]);
unset($_SESSION["FST"]);
include("../common/get_post.php");
include ("../config.php");


include ("../lang/dbadmin.php");
include ("../lang/soporte.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript"  src="../dataentry/js/lr_trim.js"></script>
<?php
echo "<script language=javascript>
function EnviarForma(){
	if (Trim(document.winisis.userfile.value)==''){
		alert('".$msgstr["missing"]." ".$msgstr["fdt"]."')
		return
	}
	ext=document.winisis.userfile.value
	e=ext.split(\".\")
	if (e.length==1 || e[1].toUpperCase()!=\"FDT\"){
		alert('".$msgstr["missing"]." ".$msgstr["fdt"]."')
		return
	}
	document.winisis.submit()
}
</script>";
if (isset($arrHttp["encabezado"]))
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["winisisdb"].": " . $arrHttp["nombre"];?>
    </div>
    <div class="actions">
    <?php
    if (isset($arrHttp["encabezado"]))
            $encabezado="?encabezado=s";
        else
            $encabezado="";
    $backtoscript="menu_creardb.php";
    include "../common/inc_back.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="crearbd_winisis_create.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
    <div class="formContent">
    <br><br>

<form name=winisis action=winisis_upload_fdt.php method=POST enctype='multipart/form-data' onsubmit='javascript:EnviarForma();return false'>
<input type=hidden name=Opcion value=FDT>
<input type=hidden name=base value="<?php echo $arrHttp["nombre"]?>">
<input type=hidden name=desc value="<?php echo$arrHttp["desc"]?>">
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
?>
<dd><table bgcolor=#eeeeee>
<tr>
<tr><td class=title><?php echo $msgstr["subir"]." ".$arrHttp["nombre"].".fdt"?></td>

<tr><td><input name=userfile type=file size=50></td><td></td>
<tr><td>  <input type=submit value='<?php echo $msgstr["subir"]?>'></td>
</table>
<p>
</div>
</div>
<?php
include("../common/footer.php");
