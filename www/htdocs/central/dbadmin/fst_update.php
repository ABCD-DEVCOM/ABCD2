<?php
/*
20220121 fho4abcd Buttons+div-helper + clean html_entity_decode
*/
// This script does nothing but display a message. The real work is done in fst.php
// There is code for option=new: never used
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";
$arrHttp["ValorCapturado"]= htmlspecialchars_decode ($arrHttp["ValorCapturado"]);
$arrHttp["ValorCapturado"]= stripslashes ($arrHttp["ValorCapturado"]);
if ($arrHttp["Opcion"]=="new"){
	$_SESSION["FST"]=$arrHttp["ValorCapturado"];
	header("Location:pft.php?Opcion=new&base=".$arrHttp["base"].$encabezado);
	die;
}
$t=explode("\n",$arrHttp["ValorCapturado"]);
$fp=fopen($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst","w");

foreach ($t as $value){
	fwrite($fp,stripslashes($value)."\n");
	//echo "$value<br>";
}

include("../common/header.php");
echo "<body>";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["fst"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php if ($arrHttp["Opcion"]=="new"){
        $backtocancelscript="../common/inicio.php?reinicio=s";
        include "../common/inc_cancel.php";
    }else{
        $backtoscript="menu_modificardb.php";
        include "../common/inc_back.php";
    }
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<h4>
    <?php echo $msgstr["fstupdated"]?>
</h4>
</div></div>
<?php include("../common/footer.php");?>
