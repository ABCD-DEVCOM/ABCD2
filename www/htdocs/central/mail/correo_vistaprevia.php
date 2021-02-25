<?php
session_start();

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
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
function VistaPreviaInvitacion(){
    msgwin=window.open("","VistaPrevia","width=850, height=600, resizable, scrollbars, menubar")
    document.VistaPrevia.target="VistaPrevia"
    document.VistaPrevia.action="invitacion_vistaprevia.php"

    document.VistaPrevia.submit()
    msgwin.focus()
}

function GenerarCorreos(){	ixn=document.forma1.chk_p.length
    result="N"
    Seleccion=""
    for (i=0;i<ixn-1;i++){
    	if(document.forma1.chk_p[i].checked){
    		Seleccion=Seleccion+"|"+document.forma1.chk_p[i].value
    		result="S"
    	}
    }
    if (result=="N"){
    	alert("Debe seleccionar los contactos")
    	return
    }
    msgwin=window.open("","CorreosInvitacion","width=800, height=600, resizable, scrollbars, menubar,statusbar")
    document.VistaPrevia.target="CorreosInvitacion"
    document.VistaPrevia.contactos.value=Seleccion
    document.VistaPrevia.action="correos.php";
   	document.VistaPrevia.count.value=document.forma1.count.value
   	document.VistaPrevia.desde.value=document.forma1.desde.value
    msgwin.focus()
    document.VistaPrevia.submit()
}

selContactos=0

function CambiarStatus(Ctrl){
	if (Ctrl.checked){
		selContactos++;
	}else{
		selContactos=selContactos-1
	}
	document.forma1.chkall.checked=false
	document.forma1.contactos.value="  (Seleccionados: "+selContactos+")"
}

function MarcarTodos(){

	if (document.forma1.chkall.checked)
		bool=1
	else
		bool=0
	for(i=0; i<document.forma1.elements.length; i++){
		Ctrl=document.forma1.elements[i].name
		if (Ctrl.substr(0,4)=="chk_"){
			if (bool==1){
				if(document.forma1.elements[i].checked==false){
					document.forma1.elements[i].checked=true
					selContactos++
				}
			}else{
			   	document.forma1.elements[i].checked=false
			   	selContactos=0
			}
		}
	}
	document.forma1.contactos.value="  (Seleccionados: "+selContactos+")"
}
</script>
<body>

<?php
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Distribución
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"index.php\" class=\"defaultButton backButton\">";
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
echo "<font color=white>&nbsp; &nbsp; Script: gestion_usuarios/correo_vistaprevia.php";
?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<?php

echo "<form name=forma1>";
echo "<table width=100% border=0 bgcolor=#eeeeee cellpadding=5>";
echo "<tr><td valign=top width=1%><input type=checkbox name=chkall onclick=javascript:MarcarTodos(0)>
	</td>
     <td valign=top><table width=100% cellpadding=0 cellspacing=0>
     					<td>Seleccionar todo <font size=1><input type=text size=30 name=contactos style='border: 0px none; background:#eeeeee' onfocus=blur()></td>
          				<td>&nbsp;  &nbsp; Desde: <input type=text name=desde size=5> &nbsp; Enviar en lotes de <input type=text name=count size=5></td>
          				<td align=right><a href=javascript:VistaPreviaInvitacion()>Ver invitación</a> &nbsp; &nbsp;  <a href=javascript:GenerarCorreos()>Generar correos</a></td></table>";
$IsisScript=$xWxis."buscar.xis";
$Expresion=$_REQUEST["Expresion"];
if (isset($_REQUEST["base"]))
	$base=$_REQUEST["base"];
else
	$base="caras_temp";
$query = "&base=$base&cipar=$db_path"."par/$base.par&Expresion=".$Expresion."&Formato=$db_path"."caras/pfts/es/lista_participantes&prologo=NNN&epilogo=NNN&Opcion=buscar&count=9999";
include("../common/wxis_llamar.php");
$cuenta=0;
foreach ($contenido as $value){
	$value=trim($value);
	$v=explode('$$$$',$value);
	$cuenta=$cuenta+1;
	echo "<tr><td bgcolor=white valign=top width=3% nowrap>$cuenta. <input type=checkbox name=chk_p value=".$v[0].'$$$'.$v[4].'$$$'.$v[5]." onclick=CambiarStatus(this)></td>\n";
	echo "<td bgcolor=white valign=top width=90%>".$v[1]."</td></tr>\n";

}
echo "</table>";
?>
<input type=hidden name=chk_p>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
<form name=VistaPrevia action=invitacion_vistaprevia.php method=post>
<input type=hidden name=base value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]; else echo "caras_temp";?>>
<input type=hidden name=contactos>
<input type=hidden name=desde value=''>
<input type=hidden name=count value=''>
<input type=hidden name=Opcion value=Invitacion>
</form>
