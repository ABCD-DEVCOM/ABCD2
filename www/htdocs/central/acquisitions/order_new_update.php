<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
include("../lang/admin.php");
include("../lang/acquisitions.php");
$ValorCapturado="";
foreach ($_GET as $var => $value) {	VariablesDeAmbiente($var,$value);
}
if (count($arrHttp)==0){
	foreach ($_POST as $var => $value) {
		VariablesDeAmbiente($var,$value);
	}
}
foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=explode("_",$var);
		if (isset($variables[$tag[0]])){
			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}
}
$cn="";
$arrHttp["Opcion"]="actualizar";
$cipar=$arrHttp["cipar"];
$base=$arrHttp["base"];
$xtl="";
$xnr="";

include("../dataentry/plantilladeingreso.php");
include("../dataentry/actualizarregistro.php");
require_once ('../dataentry/leerregistroisis.php');

$order=$valortag[1];
//VERIFY IS THE ORDER NUMBER ALREADY EXISTS IN THE DATABASE
$Prefijo='ON_'.$order;
$IsisScript= $xWxis."ifp.xis";
$query = "&base=purchaseorder&cipar=$db_path"."par/purchaseorder.par&Opcion=diccionario&prefijo=$Prefijo&campo=1";
$contenido=array();
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){
	if (trim($linea)!=""){
		$pre=trim(substr($linea,0,strlen($Prefijo)));
		if ($pre==$Prefijo){
			$l=explode('|',$linea);
			break;
		}
	}
}
$err="";
if (!isset($l[1]))
	ActualizarRegistro();
else
	$err=$msgstr["duporder"];

	include("../common/header.php");
	echo "<body>\n";
	include("../common/institutional_info.php");
?>
	<div class="sectionInfo">
		<div class="breadcrumb">
			<?php echo $msgstr["purchase"].": ".$msgstr["new"]?>
		</div>
		<div class="actions">
			<?php if ($err==""){			?>
			<a href=../common/inicio.php?reinicio=s&encabezado=s&base=<?php echo $arrHttp["base"]?> class="defaultButton backButton">
				<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
				<span><strong><?php echo $msgstr["back"]?></strong></span>
			</a>			<?php }?>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions_new_update.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/order_new_update.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: order_new_update.php</font>\n";
	?>
	</div>
	<div class="middle form">
		<div class="formContent">
<?php
	if ($err==""){		$arrHttp["Formato"]="purchaseorder";
		$regSal=LeerRegistroFormateado($arrHttp["Formato"]);
		echo $regSal;	}else{
		echo "<h4>$err</h4>" ;
		echo "<p><a href=javascript:document.forma2.submit()>".$msgstr["back"]."</a>";
	}
echo "<form name=forma2 method=post action=order_new.php>\n";
echo "<input type=hidden name=wks value=".$arrHttp["wks"].">";
echo "<input type=hidden name=base value=".$arrHttp["base"].">";
echo "<input type=hidden name=mov value=".$arrHttp["mov"].">";
echo "<input type=hidden name=cipar value=".$arrHttp["cipar"].">";
foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		echo "<input type=hidden name=$var value=\"$value\">\n";
   	}
}
echo "</form>";
//------------------------------------------------------
function VariablesDeAmbiente($var,$value){
global $arrHttp;
		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].=$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}


?>
