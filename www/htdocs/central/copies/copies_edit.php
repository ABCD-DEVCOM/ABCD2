<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/acquisitions.php");
//     foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

//se lee la FDT de la base de datos para determinar el campo donde se almacena el número de control
$tag_ctl="";
$error="";
LeerFst($arrHttp["base"]);

if ($error==""){
	$Formato="v".$tag_ctl;
//    echo $Formato;
//Se lee el registro bibliográfico para capturar el número del objeto

	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=$Formato&Opcion=rango";
//	echo $query;
	$IsisScript=$xWxis."imprime.xis";
	include("../common/wxis_llamar.php");
//	foreach ($contenido as $value) echo "**$value<br>";
	$valortag[1]=implode("",$contenido);
	if ($valortag[1]=="")     //CHECK IF THE RECORD HAS CONTROL NUMBER
		$err_copies="Y";
	else
		$err_copies="N";
//echo $err_copies;
}else{	$err_copies="Y";}
if ($err_copies=="Y"){
    include("../common/header.php");
	if (isset($arrHttp["encabezado"]) and $arrHttp["encabezado"]=="s"){
		include("../common/institutional_info.php");
	}
	echo "<body>\n";
?>
	<div class="sectionInfo">
		<div class="breadcrumb">
			<?php echo $msgstr["m_editdelcopies"]?>
		</div>
		<div class="actions">
		<a href='javascript:top.toolbarEnabled="";top.Menu("same")' class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" /><?php echo $msgstr["back"]?></a>

		</div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/copies_add.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp; &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/acquisitions/copies_add.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: copies/copies_edit.php";
?>
</font>
	</div
	<div class="middle form">
		<div class="formContent">
<?php echo "
		<dd><h4>".$msgstr["err_cannotaddcopies"]."</h4>";
?>
	</div>
</div>
<?php include("../common/footer.php"); ?>
</body>
</html>
<?php
	die;}else{ 	$Expresion="CN_".$arrHttp["base"]."_".$valortag[1];
    header("Location:copies_edit_browse.php?Expresion=$Expresion&base=copies");}
?>


<?php
// ==================================================================================

function LeerFst($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr,$error;
// GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
	$archivo=$db_path.$base."/data/".$base.".fst";
	if (!file_exists($archivo)){
		echo "missing file ".$base."/data/".$base.".fst";
		die;
	}
	$fp=file($archivo);
	$tag_ctl="";
	$pref_ctl="CN_";
	foreach ($fp as $linea){
		$linea=trim($linea);
		$ix=strpos($linea,"\"CN_\"");
		if ($ix===false){
			$ix=strpos($linea,'|CN_|');
		}
		if ($ix===false){
		}else{
			$ix=strpos($linea," ");
			$tag_ctl=trim(substr($linea,0,$ix));
			break;
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl==""){
	echo "****nose encontro";
		$error="missingctl";
	}
}


function LeerFdt($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$lang_db;
// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeración automática y el prefijo con el cual se indiza el número de control

	$archivo=$db_path.$base."/def/".$_SESSION["lang"]."/".$base.".fdt";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$archivo=$db_path.$base."/def/".$lang_db."/".$base.".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$archivo;
		    die;
		 }
	}
	$tag_ctl="";
	$pref_ctl="";
	foreach ($fp as $linea){
		$l=explode('|',$linea);
		if ($l[0]=="AI" || $l[7]=="AI"){  //PARA ASUMIR EL CAMBIO EN LA FDT
			$tag_ctl=$l[1];
			$pref_ctl=$l[12];
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl=="" or $pref_ctl==""){
		echo "<h2>".$msgstr["missingctl"]."</h2>";
		die;
	}
}

?>