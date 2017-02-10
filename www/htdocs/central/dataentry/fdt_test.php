<?php
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

	$ix=$ix+1;
	$fdt[$t[1]]=$value;
	$vars[$ix]=$value;
	//echo "$value<br>";
}
$fmt_test="S";
$fondocelda="white";

include("../common/header.php");
echo "<script>
base='".$arrHttp["base"]."'
</script>
";
//include("../common/institutional_info.php");
//include ("scripts_dataentry.php");
echo "


<div class=\"helper\">
<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/fdt_test.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/fdt_test.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: fdt_test.php";
echo "</font>
	</div>

<div class=\"middle form\">
			<div class=\"formContent\">";
include("../dataentry/dibujarhojaentrada.php");
echo "</div>";
include("../dataentry/ingresoadministrador.php");




?>