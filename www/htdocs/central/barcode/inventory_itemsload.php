<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");



include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
include ("configure.php");

function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}

function Ask_Confirmation(){
	echo "<div style='margin: 20px 40px 10px 200px; width:400px '>";
	echo "Este proceso borra todos los registros de la base de datos de inventario (abcd_inventory)\n";
	 echo "";
	 echo "<p>";
	 echo "<input type=submit value=continuar onclick=document.generar.ok.value='OK'>";
	 echo "</div>";
}

function InicializarBd($base){
global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
 	$query = "&base=$base&cipar=$db_path"."par/".$base.".par&Opcion=inicializar";
 	$IsisScript="administrar.xis";
 	$contenido=WxisLlamar($IsisScript,$base,$query);
 	$query = "&base=".$base . "&cipar=$db_path"."par/".$base.".par&Opcion=status";
    $contenido=WxisLlamar($IsisScript,$base,$query);
    $ix=-1;
    foreach($contenido as $linea) {
		$ix=$ix+1;
		if ($ix>0) {
			if (trim($linea)!=""){
		   		$a=explode(":",$linea);
		   		if (isset($a[1])) $tag[$a[0]]=$a[1];
		  	}
		}
	}
	$MaxMfn=$tag["MAXMFN"];
	echo "Base de datos de inventario (abcd_inventory)<p>";
	echo "Total registros: $MaxMfn<p>";
}
?>
<body>

<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
$ayuda="inventory.html";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["inventory_dbinit"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"menu.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp;<a href=\"http://abcdwiki.net/wiki/es/index.php?title=Inventory\" target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode/inventory_dbinit.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<form name=generar method=post>
<input type=hidden name=ok value=ok>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php if (!isset($_REQUEST["ok"]))
		Ask_Confirmation();
	 else
	    InicializarBd("abcd_inventory");
?>
</form>
	</div>
</div>
<?php
Include("../common/footer.php");
?>
</Body>
</Html>
