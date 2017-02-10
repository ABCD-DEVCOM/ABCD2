<?php
//
// Presenta una sugerencia presentada desde el script bidding.php anterior para la inserción de los datos de las cotizaciones
// DISPLAYS FOR EDITING THE SUGGESTIONS SELECTED FROM THE LIST SHOWN IN BIDDING.PHP IN ORDER TO UPDATE THE BIDDING DATA
// DATAENTRY FORMAT USED: BIDDING.FMT
//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include ('../dataentry/leerregistroisis.php');

include("../common/header.php");
include("javascript.php");
?>
<script>

function Validar(){	j=document.forma1.elements.length-1
	occ=""
	a=""
	r=""
	b=""
	c=""
	for (i=0;i<=j;i++){
		campo=document.forma1.elements[i]
		nombre=campo.name
		//Se verifica si la información de la cotización de cada proveedor está completa
		if (nombre.substr(3,3)=="300"){			t=nombre.split("_")
			if (occ=="" ) occ=t[1]
			if (occ!=t[1]){
				if (a+r+b+c!=""){					if (a=="")   {						alert(occ+"-"+"<?php echo $msgstr["err300a"]?>")
						return "N"
					}
					if (r=="")   {
						alert(occ+"-"+"<?php echo $msgstr["err300r"]?>")
						return "N"
					}
					if (b=="")   {
						alert(occ+"-"+"<?php echo $msgstr["err300b"]?>")
						return "N"
					}
					if (c=="")   {
						alert(occ+"-"+"<?php echo $msgstr["err300c"]?>")
						return "N"
					}				}
				occ=t[1]
				a=Trim(campo.value)
				b=""
				c=""			}else{
				switch (t[2]){					case "a":
						a=Trim(campo.value)
						break
					case "r":
						r=Trim(campo.value)
						break
					case "b":
						b=Trim(campo.value)
						break
					case "c":
						c=Trim(campo.value)
						break				}			}
		}else{			if (a+b+c!=""){
					if (a=="")   {
						alert(t[1]+"-"+"<?php echo $msgstr["err300a"]?>")
						return "N"
					}
					if (b=="")   {
						alert(t[1]+"-"+"<?php echo $msgstr["err300b"]?>")
						return "N"
					}
					if (c=="")   {
						alert(t[1]+"-"+"<?php echo $msgstr["err300c"]?>")
						return "N"
					}
			}		}
	}
	if (Trim(document.forma1.tag330.value)==""){		alert("<?php echo $msgstr["err330"]?>")
		return "N"	}
	if (Trim(document.forma1.tag331.value)==""){
		alert("<?php echo $msgstr["err331"]?>")
		return "N"
	}
	return "Y"}

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
		<?php echo $msgstr["suggestions"].": ".$msgstr["bidding"]?>
	</div>
	<div class="actions">
		<a href=bidding.php?encabezado=s&base=<?php echo $arrHttp["base"]."&sort=".$arrHttp["sort"].$see_all?> class="defaultButton cancelButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["cancel"]?></strong></span>
		</a>
		<a href=javascript:EnviarForma() class="defaultButton saveButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["actualizar"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/bidding_ex.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/bidding_ex.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: bidding_ex.php</font>\n";
?>
	</div>




<div class="middle form">
			<div class="formContent">

<form method=post name=forma1 action=bidding_update.php onSubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"].".par"?>>
<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=tag2 value="3">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=valor value="">
<?php
if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";
$fmt_test="S";
$arrHttp["wks"]="bidding.fmt";
if (!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$arrHttp["base"].".par";
include("../dataentry/plantilladeingreso.php");
ConstruyeWorksheetFmt();
//Se lee el registro que va a ser editado
$arrHttp["lock"] ="S";
$maxmfn=$arrHttp["Mfn"];
$res=LeerRegistro($arrHttp["base"],$arrHttp["base"].".par",$arrHttp["Mfn"],$maxmfn,$arrHttp["Opcion"],$_SESSION["login"],"","");
echo "<a href=../dataentry/show.php?Mfn=".$arrHttp["Mfn"]."&base=".$arrHttp["base"]." target=_blank><img src=../images/zoom.png></a> &nbsp;<strong>".$valortag[18]."<br>Copias aprobadas:".$valortag[240]."</strong><br>";
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
