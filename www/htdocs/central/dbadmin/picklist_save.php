<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/header.php");
if (isset($arrHttp["encabezado"])){	$encabezado="&encabezado=s";
	include("../common/institutional_info.php");}else{	$encabezado="";}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;


echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["picklist"]. ": " . $arrHttp["base"]." - ".$arrHttp["picklist"]."
			</div>
			<div class=\"actions\">

	";
if (isset($arrHttp["desde"]) and $arrHttp["desde"]!="dataentry"){	echo "<a href=\"fixed_marc.php?base=". $arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";}else{
	if (!isset($arrHttp["desde"]))
		echo "<a href=\"picklist.php?base=". $arrHttp["base"]."&row=".$arrHttp["row"]."&picklist=".$arrHttp["picklist"]."\" class=\"defaultButton backButton\">";
}
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>

<div class=\"helper\">
<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: picklist_save.php" ;

echo "</font>
	</div>
 <div class=\"middle form\">
			<div class=\"formContent\">";
if (strpos($arrHttp["picklist"],"%path_database%")===false){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"];
}else{
	$archivo=str_replace("%path_database%",$db_path,$arrHttp["picklist"]);
}
$fp=false;
$fp=fopen($archivo,"w");
if (!$fp){//	echo $archivo.": ".$msgstr["nopudoseractualizado"];
//	die;}
fwrite($fp,$arrHttp["ValorCapturado"]);
fclose($fp);
$Opciones="";
$VC=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($VC as $value){	$value=trim($value);	if ($Opciones=="")
		$Opciones=$value;
	else
		$Opciones.='$$$$'.$value;}
echo "<h3>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"]." ".$msgstr["updated"]."</h3>";
if (!isset($arrHttp["desde"]) or $arrHttp["desde"]!="dataentry"){?>

<script>
	row=<?php if (isset($arrHttp["row"])) echo $arrHttp["row"]."\n"?>
	name="<?php echo $arrHttp["picklist"]?>"
	window.opener.valor=name
	window.opener.Asignar()
	self.close()
</script>

<?php
}

if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="dataentry"){
?>

<script>
	window.opener.ValorTabla="<?php echo $Opciones?>"
	window.opener.SelectName='<?php echo $arrHttp["Ctrl"]?>'
	window.opener.AsignarTabla()
	self.close()
</script>
<?php
}

include("../common/footer.php");?>