<?php
/*
20220127 fho4abcd div-helper, buttons
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"]) and !isset($_REQUEST["moodle"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

include("../lang/admin.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$arrHttp["ValorCapturado"]=stripslashes($arrHttp["ValorCapturado"]) ;
$base=$arrHttp["base"];
$arrHttp["cipar"]="$base.par";
$t=explode("\n",$arrHttp["ValorCapturado"]);
$ix=-1;
global $vars;
foreach ($t as $value){
    if (trim($value)!=""){
		$ix=$ix+1;
		//$fdt[$t[1]]=$value;
		$vars[$ix]=$value;
	}
	//echo "$value<br>";
}
$fmt_test="S";// required by included files
$fondocelda="white";

include("../common/header.php");
?>
<body>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["test"]." &rarr; "."FDT"." / "."FMT";?>
    </div>
    <div class="actions">
    <?php
    include "../common/inc_close.php";
    ?>
	</div>
    <div class="spacer">&#160;</div>
</div>
<?php
echo "<script>
base='".$arrHttp["base"]."'
</script>
";
//include("../common/institutional_info.php");
//include ("scripts_dataentry.php");
include "../common/inc_div-helper.php";
if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]=0; // required by included files
include("../dataentry/dibujarhojaentrada.php");
include("../dataentry/ingresoadministrador.php");
?>