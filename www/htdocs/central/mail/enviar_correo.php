<?php
session_start();

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["login"])){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Buscar(){

	base='<?php
	if (isset($arrHttp["base"]))
		echo $arrHttp["base"];

	?>'
	cipar=base+".par"
	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=900,height=600")
	msgwin.focus()
}
function BorrarExpresion(){
	document.forma1.Expresion.value=''
}
function EnviarForma(){
    if (Trim(window.document.forma1.Expresion.value)==""){    	alert("Debe construir una expresión de búsqueda para seleccionar los participantes")
    	return    }
    document.forma1.submit()
}
</script>
<body >

<?php
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\"><font size=3>Enviar Correo</font>
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"index.php?base=".$_REQUEST["base"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>Regresar</strong></span></a>";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<!--a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/distribucion.html target=_blank>".$msgstr["edhlp"]."</a-->";
echo "<font color=white>&nbsp; &nbsp; Script: mail/enviar_correo.php";
?>
</font>
</div>
<div class="middle">
	<div class="formContent" >

<h3>Seleccionar destinatarios: <p><a href=javascript:Buscar()>Buscar</a><br>
<form name=forma1 method=post action=correo_vistaprevia.php>
<input type=hidden name=base value=
<?php
	if (isset($arrHttp["base"]))		echo $arrHttp["base"];
?>
>
<textarea rows=2 cols=150 name=Expresion></textarea>
<a href=javascript:BorrarExpresion() class=boton><?php echo $msgstr["borrar"]?></a> &nbsp;</h3>
<a href=javascript:EnviarForma()>Generar correos</a>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
