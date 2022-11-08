<?php
/*
20220221 fho4abcd backbutton,div-helper
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "<pre>$var=$value</pre>"; die;
include ("../config.php");
include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/reports.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function AbrirVentana(Url){
	msgwin=window.open(Url,"","width=400, height=400, resizable, scrollbars, menu=no, toolbar=no")
	msgwin.focus();
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["configure"]." " .$msgstr["barcode"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
        <?php
            $backtoscript="../barcode/bcl_config_labels.php";
            include "../common/inc_back.php";
        ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="barcode.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$lang."/".$arrHttp["tipo"].".conf","w");
foreach ($arrHttp as $key=>$conf){
	if (substr($key,0,4)=="tag_"){
		$key=substr($key,4);
		echo "$key=$conf<br>";
		fwrite($fp,"$key=$conf"."\n");
	}
}
fclose($fp);
?>
</div>
</div>
<?php
include("../common/footer.php");
?>