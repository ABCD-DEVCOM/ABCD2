<?php
/* Modifications
2021-03-08 fho4abcd Replaced helper code fragment by included file
2021-03-08 fho4abcd Improved html & code. Hovering symbols works now
*/
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


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================



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


?>
<body>
<script language="JavaScript" type="text/javascript" src="js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src="js/selectbox.js"></script>
<script language=javascript>

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
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=850,height=400")
	msgwin.focus()
}

</script>
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
<?php $ayuda="exportiso.html"; include "../common/inc_div-helper.php" ?>

<div class="middle form">
<div class="formContent">

<form name=forma1 method=post action=exporta_txt_ex.php onsubmit="Javascript:return false" >
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
<input type=hidden name=cnv value=<?php if (isset($arrHttp["cnv"]))echo $arrHttp["cnv"]?>>
<input type=hidden name=tipo value=<?php echo $arrHttp["tipo"]?>>
<input type=hidden name=Accion>

<div align=center><br>
<table cellpadding=5 border=0 background=img/fondo0.jpg >
	<tr>
		<td colspan=2 align=center  bgcolor=#cccccc><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td align=center colspan=2><?php echo $msgstr["r_mfnr"]?><br></td>
	<tr>
		<td width=50% align=right>
            <?php echo $msgstr["r_desde"]?>:&nbsp;<input type=text name=Mfn size=10 >&nbsp; &nbsp;
        </td>
		<td width=50%>
            <?php echo $msgstr["r_hasta"]?>:&nbsp;<input type=text name=to size=10 >
		    <script>document.write(" (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script> <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a>
        </td>
		<?php
			if (isset($arrHttp["seleccionados"])){				echo "<tr>
				<td colspan=2><strong>".$msgstr["selected_records"]."</strong>: &nbsp;";
				$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
				$sel=str_replace("_","",$sel);
				echo "<input type=text name=seleccionados size=80 value=$sel>\n";
				echo "</td></tr>";
			}else{ // next line required to suppress javascript errors				echo "<tr><td colspan=2><input type=hidden name=seleccionados>\n</td></tr>";			}
		?>
	<tr>
		<td colspan=2><hr></td>

	<tr>
		<td align=center colspan=2><?php echo $msgstr["r_busqueda"]?></td>
    </tr>
	<tr>
    <td colspan=2>
    <table>
        <tr><td>
                <a href=javascript:Buscar()><img src=img/barSearch.png height=24 border=0 title="<?php echo $msgstr["m_indice"]?>"></a>&nbsp;&nbsp;</td>
            <td>
                <textarea rows=3 cols=90 name=Expresion ><?php if ($Expresion!="") echo $Expresion?></textarea></td>
            <td>
			    &nbsp;&nbsp;<a href=javascript:BorrarExpresion()><?php echo $msgstr["borrar"]?></a></td>
        </tr>
    </table>
    </td>
    </tr>
    <tr>
		<td colspan=2><hr></td>
	</tr>
</table>

<div>
<?php
if ($arrHttp["tipo"]!="iso"){ // The preview symbol
?>
<a href="javascript:EnviarForma('P')" title=<?php echo $msgstr["vistap"]?>><img src=img/preview.gif border=0 style="vertical-align:middle"></a> &nbsp;&nbsp;&nbsp;&nbsp;
<?php }
echo $msgstr["cnv_".$arrHttp["tipo"]]?> 
<input type=text name=archivo size=25 title="Filename with extension" >&nbsp;&nbsp;
<a href="javascript:EnviarForma('S')" title=<?php echo $msgstr["cnv_export"]?> ><img src=img/barSave.png border=0 style="vertical-align:middle"></a>
</div><br>
</div>
<?php include("../common/footer.php");
?>



