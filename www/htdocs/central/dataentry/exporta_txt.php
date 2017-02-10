<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];


include ("../lang/admin.php");
include ("../lang/soporte.php");



function LeerArchivos($Dir,$Ext){
// se leen los archivos con la extensión .pft
$the_array = Array();
$handle = opendir($Dir);
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file))
		   if (substr($file,strlen($file)-4,4)==".".$Ext) $the_array[]=$file;
   }
}
closedir($handle);
return $the_array;
}

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//



//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";


include("../common/header.php");

if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

$arrHttp["login"]=$_SESSION["login"];
$arrHttp["password"]=$_SESSION["password"];

$base =$arrHttp["base"];
$cipar =$arrHttp["cipar"];
$login=$arrHttp["login"];
$password=$arrHttp["password"];


if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";


?>
<script language="javascript1.2" src="js/lr_trim.js"></script>
<script language=Javascript src=js/selectbox.js></script>
<style type=text/css>
div#editformat{
	margin: 0px 0px 0px 0px;
	width:700px;
	xdisplay: none;
	border: "3px coral solid";
}
</style>
<script languaje=javascript>

function check( x )  {
    x = x.replace(/\*/g, "")      // delete *
   	x = x.replace(/\[/g, "")      // delete [
   	x = x.replace(/\]/g, "")      // delete ]
   	x = x.replace(/\</g, "")      // delete <
   	x = x.replace(/\>/g, "")      // delete >
   	x = x.replace(/\=/g, "")      // delete =
   	x = x.replace(/\+/g, "")      // delete +
   	x = x.replace(/\'/g, "")      // delete '
   	x = x.replace(/\"/g, "")      // delete "
   	x = x.replace(/\\/g, "")      // delete \
   	x = x.replace(/\//g, "")      // delete /
   	x = x.replace(/\,/g, "")      // delete ,
//   	x = x.replace(/\./g, "")      // delete .
   	x = x.replace(/\:/g, "")      // delete :
   	x = x.replace(/\;/g, "")      // delete ;
   	x = x.replace(/ /g, "_")         // delete spaces
	return x
}

function AbrirVentana(Archivo){
	xDir="<?php echo $xSlphp?>"
	msgwin=window.open(xDir+"ayudas/<?php echo $lang?>/"+Archivo,"Ayuda","")
	msgwin.focus()
}


function EnviarForma(vp){


	de=Trim(document.forma1.Mfn.value)
  	a=Trim(document.forma1.to.value)
  	Opcion=""
  	if (de!="" || a!="") Opcion="rango"
  	if (Opcion=="rango"){
  		Se=""
		var strValidChars = "0123456789";
		blnResult=true
   	//  test strString consists of valid characters listed above
   		for (i = 0; i < de.length; i++){
    		strChar = de.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	for (i = 0; i < a.length; i++){
    		strChar = a.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	de=Number(de)
    	a=Number(a)
    	if (de<=0 || a<=0 || de>a ||a>top.maxmfn){
	    	alert("<?php echo $msgstr["numfr"]?>")
	    	return
		}
	}
	Letra=""

	if (Trim(document.forma1.Expresion.value)=="" && (Trim(document.forma1.Mfn.value)=="" && Trim(document.forma1.seleccionados.value=="") ) && Letra==""){
		alert("<?php echo $msgstr["exp_selreg"]?>")
		return
	}
	cuenta=0;
	if (Trim(document.forma1.Expresion.value)!="") cuenta++
	if (Trim(document.forma1.Mfn.value)!="" ) cuenta++
	if (Trim(document.forma1.seleccionados.value)!="" ) cuenta++
	if (Letra!="") cuenta++
	if (cuenta>1){
		alert("<?php echo $msgstr["r_1opcion"]?>")
		return
	}
	if (vp=="P") {
		msgwin=window.open("","VistaPrevia","")
		msgwin.focus()
		document.forma1.target="VistaPrevia"
	}else{
		document.forma1.target=""
	}
	if (vp=="S"){
		archivo=Trim(document.forma1.archivo.value)
		archivo=check(archivo)
		if (archivo==""){
			alert("<?php echo $msgstr["exp_archivo"]?>")
			return
		}
		document.forma1.archivo.value=archivo
	}
	document.forma1.Accion.value=vp
	document.forma1.submit()
}

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function BorrarRango(){
	document.forma1.Mfn.value=''
	document.forma1.to.value=''
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
	ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1) ix=0
	Formato=top.menu.document.forma1.formato.options[ix].value
	FormatoActual="&Formato="+Formato

  	Url="buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar+FormatoActual
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}

</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_export"]." ".$msgstr["cnv_".$arrHttp["tipo"]]?>
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
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/exportiso.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/exportiso.html target=_blank>".$msgstr["edhlp"]."</a>
		<font color=white>&nbsp; &nbsp; Script: dataentry/exporta_txt.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<form name=forma1 method=post action=exporta_txt_ex.php onsubmit="Javascript:return false" >
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
<input type=hidden name=Dir value=<?php echo $arrHttp["Dir"]?>>
<input type=hidden name=cnv value=<?php echo $arrHttp["cnv"]?>>
<input type=hidden name=tipo value=<?php echo $arrHttp["tipo"]?>>
<input type=hidden name=letrasel>
<input type=hidden name=tagsel>
<input type=hidden name=Accion>

<center><br>
<table cellpading=5 cellspacing=5 border=0 background=img/fondo0.jpg width=800>
	<tr>
		<td colspan=2 align=center height=1 bgcolor=#cccccc><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td  align=center colspan=2><?php echo $msgstr["r_mfnr"]?><br></td>
	<tr>
		<td width=50% align=right><?php echo $msgstr["r_desde"]?>: <input type=text name=Mfn size=10 >&nbsp; &nbsp; </td>
		<td width=50%><?php echo $msgstr["r_hasta"]?>:<input type=text name=to size=10 >
		<script>document.write(" (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script> <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a></td>
		<?php
			if (isset($arrHttp["seleccionados"])){				echo "<tr>
				 	 <td  colspan=2><strong>".$msgstr["selected_records"]."</strong>: &nbsp; &nbsp; &nbsp;";
				$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
				$sel=str_replace("_","",$sel);
				echo "<input type=text name=seleccionados size=100 value=$sel>\n";
				echo "</td></tr>";
			}else{				echo "<input type=hidden name=seleccionados>\n";			}
		?>
	<tr>
		<td colspan=2><hr></td>

	<tr>
		<td align=center colspan=2><?php echo $msgstr["r_busqueda"]?><br></td>
	<tr>

		<td colspan=2 class=subtitlebody>
			<table>
				<td><a href=javascript:Buscar()><img src=img/barSearch.png height=24 align=middle border=0 alt="<?php echo $msgstr["m_indice"]?>"></a></td>
				<td><textarea rows=4 cols=90 name=Expresion ><?php if ($Expresion!="") echo $Expresion?></textarea>
				<a href=javascript:BorrarExpresion()><?php echo $msgstr["borrar"]?></a></td>
			</table>
		</td>
</table>
<?
	if ($arrHttp["tipo"]!="iso"){
		echo "
		<a href=javascript:EnviarForma('P')><img src=img/preview.gif border=0 alt=\"".$msgstr["vistap"]."\"></a> &nbsp;";
	}
	echo $msgstr["cnv_".$arrHttp["tipo"]]." &nbsp;<input type=text name=archivo size=25> &nbsp;<a href=javascript:EnviarForma('S')><img src=img/barSave.png border=0 alt=\"".$msgstr["cnv_export"]."\"></a>";
echo "</center></div></div>";
include("../common/footer.php");
?>



