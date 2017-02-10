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
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include ('../dataentry/leerregistroisis.php');

include("../common/header.php");
include("javascript.php");
?>
<script>
function Validar(){	res=""
	if (document.forma1.tag2[1].checked || document.forma1.tag2[2].checked) res="Y"
	if (res==""){
		alert ("<?php echo $msgstr["err2_1"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag230.value)=="" ){
		alert ("<?php echo $msgstr["err230"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag231.value)==""){
		alert ("<?php echo $msgstr["err231"]?>")
		return "N"
	}
	if (document.forma1.tag2[1].checked && Trim(document.forma1.tag240.value)==""){
		alert ("<?php echo $msgstr["err240"]?>")
		return "N"
	}
	if (document.forma1.tag2[2].checked && Trim(document.forma1.tag250.value)==""){
		alert ("<?php echo $msgstr["err250"]?>")
		return "N"
	}
	return "Y";
}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$see_all="";
if (isset($arrHttp["see_all"])) $see_all="&see_all=Y"
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["approve"]."/".$msgstr["reject"]?>
	</div>
	<div class="actions">
		<a href=suggestions_status.php?encabezado=s&base=<?php echo $arrHttp["base"]."&sort=".$arrHttp["sort"].$see_all?> class="defaultButton cancelButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["cancel"]?></strong></span>
		</a>
		<a href=javascript:EnviarForma() class="defaultButton saveButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["update"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions_status.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/suggestions_status_new.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: suggestions_status_ex.php</font>\n";
?>
	</div>




<div class="middle form">
			<div class="formContent">

<form method=post name=forma1 action=suggestions_status_update.php onSubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"].".par"?>>
<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=valor value="">
<?php
if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";
$fmt_test="S";
$arrHttp["wks"]="status.fmt";
if (!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$arrHttp["base"].".par";
include("../dataentry/plantilladeingreso.php");
ConstruyeWorksheetFmt();
//Se lee el registro que va a ser editado
$arrHttp["lock"] ="S";
$maxmfn=$arrHttp["Mfn"];
$res=LeerRegistro($arrHttp["base"],$arrHttp["base"].".par",$arrHttp["Mfn"],$maxmfn,$arrHttp["Opcion"],$_SESSION["login"],"","");
echo "<a href=../dataentry/show.php?Mfn=".$arrHttp["Mfn"]."&base=".$arrHttp["base"]." target=_blank><img src=../images/zoom.png></a> &nbsp;<strong>".$valortag[18]."</strong><br>";
echo "<br>";
if ($res=="LOCKREJECTED") {
	echo "<script>
	alert('".$arrHttp["Mfn"].": ".$msgstr["reclocked"]."')
	</script>";
	die;
}
echo "<b>Mfn: ".$arrHttp["Mfn"]."</b><br>";
include("../dataentry/dibujarhojaentrada.php");
PrepararFormato();
?>
</form>
	</div>
</div>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>