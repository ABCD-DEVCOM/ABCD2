<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");



include("../common/get_post.php");
if (!isset($arrHttp["cipar"])) $arrHttp["cipar"] =$arrHttp["base"].".par";
if (!isset($arrHttp["count"])) $arrHttp["count"] ="";
if (!isset($arrHttp["desde"])) $arrHttp["desde"] ="";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
$arrHttp["encabezado"]="S";
include("../common/header.php");
include("../dataentry/formulariodebusqueda.php");
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["search"]?>
	</div>
	<div class="actions">
		<a href=suggestions.php?encabezado=s&base=<?php echo $arrHttp["base"]?> class="defaultButton backButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/suggestions.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: suggestions_search.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
	<?php
	$a= $db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
	$fp=file_exists($a);
	if (!$fp){
		$a= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
		$fp=file_exists($a);
		if (!$fp){
			echo "<br><br><h4><center>".$msgstr["faltacamposbusqueda"]."</h4>";
			die;
		}
	}
	$fp = fopen ($a, "r");
	$fp = file($a);
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			$camposbusqueda[]= $linea;
			$t=explode('|',$linea);
			$tag=$t[1];
			$matriz_c[$tag]=$linea;
		}
	}
	DibujarFormaBusqueda();
	?>
	</div>
</div>
<?php include("../common/footer.php");
echo "</body></html>" ;


?>