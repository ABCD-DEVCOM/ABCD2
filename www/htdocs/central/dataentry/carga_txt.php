<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");

include("../common/header.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";


?>
<script src=js/lr_trim.js></script>
<script languaje=javascript>

base=top.base

function LeerTxt(){
	url="carga_txt_ver.php?base=<?php echo $arrHttp["base"]."&cnv=".$arrHttp["cnv"]?>"
	msgwin=window.open(url,"","menu=no,scrollbars=yes,status=yes,width=640,height=380,resizable")
	msgwin.focus()
}

function TablaDeConversion(tb){
	ix=tb.selectedIndex
	key=tb.options[ix].value
	if (key==''){
		alert ("<?php echo $msgstr["cnv_ftab"]?>")
		return false
	}
	document.FCKfrm.sr.value=tab[key][1]
	for (i=0;i<document.FCKfrm.inicio.length;i++){
		document.FCKfrm.inicio[i].value=""
	}
	for (i=2;i<tab[key].length;i++){
		if (tab[key][i]){
			a=tab[key][i].split('|')
			document.FCKfrm.inicio[i-2].value=a[0]
			document.FCKfrm.fin[i-2].value=a[1]
			document.FCKfrm.tag[i-2].value=a[2]
		}
	}
	if (nota[key]!="") alert(nota[key])

}

function ValidarRotulos(){
	a=Trim(document.FCKfrm.bdd.value)
	if (a==""){
		alert("<?php echo $msgstr["cnv_paste"]?>")
		return
	}
	msgwin=window.open("","Validacion","")
	document.RotulosFrm.Texto.value=a
	document.RotulosFrm.submit()
	msgwin.focus()
}
function Actualizar(){
	a=Trim(document.FCKfrm.bdd.value)
	if (a==""){
		alert("<?php echo $msgstr["cnv_paste"]?>")
		return
	}
	msgwin=window.open("","Actualizacion","resizable, scrollbars");
	document.FCKfrm.target="Actualizacion"
	document.FCKfrm.submit()
	msgwin.focus()
}



		</script>
	</head>
	<body>

<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_".$arrHttp["accion"]]." ".$msgstr["cnv_".$arrHttp["tipo"]]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/carga_txt.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>


		<form action="carga_txt_ex.php" method="post"  name=FCKfrm onSubmit="Enviar();return false" target=_blank>

		<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
		<input type=hidden name=cnv value="<?php echo $arrHttp["cnv"]?>">
		<input type=hidden name=cipar value="<?php echo $arrHttp["base"]?>.par">
		<br><font face=verdana color=#ff0000 size=2><center>
		<table width=750 align=center cellspacing=0 cellpadding=0>
			<font color=darkred><?php echo $msgstr["cnv_paste"]?>
			<a href=javascript:LeerTxt()><font size=1><img src=img/preview.gif border=0><?php echo $msgstr["cnv_ver"]?></a><font color=black><br>
				<textarea rows=20 cols=150 name=bdd></textarea>

		</td></tr>
		</table>
		<a href=javascript:Actualizar()><?php echo $msgstr["procesar"]?></a>  &nbsp; &nbsp;
		<a href=javascript:ValidarRotulos()><?php echo $msgstr["cnv_validar"]?></a>   &nbsp; &nbsp;
		<a href=javascript:history.back()><?php echo $msgstr["regresar"]?></a>
		</p>
		</form>

		<form name=RotulosFrm action=valida_rotulos.php target=Validacion method=post>
		<input type=hidden name=Texto>
		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
		<input type=hidden name=cnv value=<?php echo $arrHttp["cnv"]?>>
		</form>
	</body>
</html>
<script>
window.scrollTo(0,0)
</script>
