<?php
ini_set('session.gc_maxlifetime',44400);
session_start();
set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
$arrHttp["cipar"]=$arrHttp["base"].".par";
include ("../config.php");

function BuscarClavesLargas($Termino){
global $arrHttp,$Formato,$xWxis,$Wxis,$wxisUrl,$db_path;
	$contenido="";	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=autoridades"."&tagfst=".substr($arrHttp["tagfst"],3)."&prefijo=".strtoupper($arrHttp["pref"]).$Termino."&to=".strtoupper($arrHttp["pref"]).$Termino."&pref=".strtoupper($arrHttp["pref"])."&postings=ALL&formato_e=".urlencode($Formato);
	$IsisScript=$xWxis."ifp.xis";
	include("../common/wxis_llamar.php");
	$cont = array_unique ($contenido);
	foreach ($cont as $linea ){		$f=explode('$$$',$linea);
		if (isset($f[2])) $f[1]=$f[2];
		if (!isset($f[1])) $f[1]=$f[0];
		if (substr($f[0],0,1)=="^") $f[0]=substr($f[0],2);
		echo '<li>'.$f[0]."</li>";
	}}

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

$arrHttp["lang"]=$_SESSION["lang"];
include("../lang/admin.php");

//foreach ($arrHttp as $var => $value )	echo "$var = $value<br>";
//die;
$primeravez="";
$arrHttp["pref"]=$arrHttp["prefijo"];
if (!isset($arrHttp["subc"])) $arrHttp["subc"]="";

if (!isset($arrHttp["tagfst"])) $arrHttp["tagfst"]="";
if (!isset($arrHttp["delimitador"])) $arrHttp["delimitador"]="";
if (!isset($arrHttp["separa"])) $arrHttp["separa"]="";
if (!isset($arrHttp["postings"])) $arrHttp["postings"]="ALL";
$arrHttp["Formato"]=stripslashes($arrHttp["Formato"]);
if (substr($arrHttp["Formato"],0,1)=="@" and $arrHttp["baseactiva"]==$arrHttp["base"]){
	$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($arrHttp["Formato"],1);
	if (!file_exists($Formato))
		$Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".substr($arrHttp["Formato"],1);
	$Formato="@".$Formato;
}else
	$Formato=$arrHttp["Formato"];
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=autoridades"."&tagfst=".substr($arrHttp["tagfst"],3)."&prefijo=".strtoupper($arrHttp["prefijo"])."&pref=".strtoupper($arrHttp["pref"])."&postings=".$arrHttp["postings"]."&formato_e=".urlencode($Formato)."&to=".strtoupper($arrHttp["prefijo"])."ZZZZZZ";
$IsisScript=$xWxis."ifp.xis";
include("../common/wxis_llamar.php");
$contenido = array_unique ($contenido);
include("../common/header_display.php") ;
echo "<font face=arial><strong>".$msgstr["termsdict"].": ";
	if (!isset($tesau[$arrHttp["base"]]["name"])){
		if ($arrHttp["baseactiva"]!=$arrHttp["base"]) echo $arrHttp["base"];
	}else{
		echo $tesau[$arrHttp["base"]]["name"];
	}
	echo  " - ".$msgstr["bd"].": ".$arrHttp["baseactiva"];
	echo "</strong><p>";?>

<?php
	$i=0;
	echo "<ul>";
	foreach ($contenido as $linea){
		$f=explode('$$$',$linea);
		if (isset($f[2])) $f[1]=$f[2];
		if (!isset($f[1])) $f[1]=$f[0];
		if (substr($f[0],0,1)=="^") $f[0]=substr($f[0],2);
		if (strlen($f[0])>58){			BuscarClavesLargas($f[0]);
		}else{
			echo '<li>'.$f[0]."</li>";
	   }
	   $i++;
	   if ($i>50){	   	   $i=0;
	   	   flush_page();
	   }
	}
	echo "</ul>";
	echo "<p>" ;
echo "<a href=javascript:print()><img src=img/barPrint.png border=0 alt='".$msgstr["print_dict"]."' title='".$msgstr["print_dict"]."' border=0></a>";

function flush_page (){
    echo(str_repeat(' ',256));
    // check that buffer is actually set before flushing
    if (ob_get_length()){
        @ob_flush();
        @flush();
        @ob_end_flush();
    }
    @ob_start();
}
?>


</body></html>


