<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");



include ("../lang/soporte.php");
include ("../lang/admin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

$base =$arrHttp["base"];
$cipar =$arrHttp["base"]."par";
include("leer_fdt.php");

$Fdt_unsorted=LeerFdt($base);
$Fdt=array();
foreach ($Fdt_unsorted as $value){	$f=explode('|',$value);
	$Fdt[$f[2]]=$value;}

ksort($Fdt);

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}
include("../common/header.php");
?>
<style>
.myLayersClass { position: absolute; visibility: hidden; xdisplay:none }
.Botones { position: relative; visibility: hidden; xdisplay:none }
</style>
<script language="javascript1.2" src="js/lr_trim.js"></script>
<script language=Javascript src=js/windowdhtml.js></script>
<script languaje=javascript>

function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
style2.display = style2.display? "":"block";
}
}



// quick browser tests
var ns4 = (document.layers) ? true : false;
var ie4 = (document.all && !document.getElementById) ? true : false;
var ie5 = (document.all && document.getElementById) ? true : false;
var ns6 = (!document.all && document.getElementById) ? true : false;


function MostrarLista(Tag){
  	if (document.forma1.global_C.selectedIndex==-1){
		alert("<?php echo $msgstr["cg_sel"]?>")
		return
	}
	ix=document.forma1.global_C.selectedIndex
	fst=document.forma1.global_C.options[ix].value
	t=fst.split("|")

	if (t[1]==""){
	  	alert("<?php echo $msgstr["cg_sinindice"]?>")
	  	return
	}
	Separa=""
	Separa="&delimitador="+Separa
	Prefijo=Separa+"&tagfst="+t[0]+"&prefijo="+t[1]
	ancho=200
	url_indice="capturaclaves.php?opcion=autoridades&base=<?php echo $arrHttp['base']?>&cipar=<?php echo $arrHttp['base']?>.par&Tag="+Tag+Prefijo
	loadwindow(url_indice,380,425)
	return
}

function ConfirmarCambio(){	msgwin=window.open("","cg","width=750,height=300,scrollbars,resizable")
	msgwin.focus()
	msgwin.document.close()
	msgwin.document.writeln("<html><title><?php echo $msgstr["mnt_globalc"] ?></title><body><?php echo $msgstr["mnt_globalc"] ?><p>")
	msgwin.document.writeln("<font face=arial size=2")
	msgwin.document.writeln("<strong><?php echo $msgstr["r_recsel"]?>:</strong><br>")
	if ((Trim(document.forma1.from.value)=="" || Trim(document.forma1.to.value)=="") && Trim(document.forma1.Expresion.value)==""){		msgwin.document.writeln("<strong><font color=red><?php echo $msgstr["cg_selrecords"]?>:</strong><br>")
		return	}
	if (Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!=""){
		msgwin.document.writeln("<i><?php echo $msgstr["cg_from"]?></i>: "+document.forma1.from.value+"<br>")
		msgwin.document.writeln("<i><?php echo $msgstr["cg_to"]?></i>: "+document.forma1.to.value+"<br>")
	}
	if (Trim(document.forma1.Expresion.value)!="")
		msgwin.document.writeln("<i><?php echo $msgstr["cg_search"]?></i>: "+document.forma1.Expresion.value+"<br>")
	if ((Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!="") && Trim(document.forma1.Expresion.value)!=""){
		msgwin.document.writeln("<strong><font color=red><?php echo $msgstr["cg_selrecords"]?>:</strong><br>")
		return
	}
    ix_csel=document.forma1.global_C.selectedIndex
	campo_sel=document.forma1.global_C.options[ix_csel].text
	if (ix_csel==0 && Trim(campo_sel)==""){		msgwin.document.writeln("<p><strong><font color=red><?php echo $msgstr["cg_sel"]?></strong>")
		die;	}
	if (ix_csel>0){
		msgwin.document.writeln("<strong><?php echo $msgstr["cg_selfield"]?></strong>: "+campo_sel+"<br>")
	}
	//if (Trim(document.forma1.listdel.value)!="")
	//	msgwin.document.writeln("<strong><?php echo $msgstr["cg_selfield"]?></strong>: "+document.forma1.listdel.value+"<br>")
	mov=""
	for (i=0;i<document.forma1.tipoc.length;i++){
	  	if(document.forma1.tipoc[i].checked) mov=document.forma1.tipoc[i].value
	}
	xtipo_mov=""
	switch (mov){
	  	case "agregar":
	  		xtipo_mov="<?php echo $msgstr["cg_add"]?>"
	  		break
	  	case "agregarocc":
	  		xtipo_mov="<?php echo $msgstr["cg_addocc"]?>"
	  		break
	  	case "modificar":
	  		xtipo_mov="<?php echo $msgstr["cg_modify"]?>"
	  		break
	  	case "modificarocc":
	  		xtipo_mov="<?php echo $msgstr["cg_modifyocc"]?>"
	  		break
	  	case "dividir":
	  		xtipo_mov="<?php echo $msgstr["cg_split"]?>"
	  		break
	 	case "mover":
	  		xtipo_mov="<?php echo $msgstr["cg_move"]?>"
	  		break
	  	case "eliminar":
	  		xtipo_mov="<?php echo $msgstr["cg_delete"]?>"
	  		break
	 	case "eliminarocc":
	 		xtipo_mov="<?php echo $msgstr["cg_deleteocc"]?>"
	 		break
	}
    if (xtipo_mov==""){    	msgwin.document.writeln("<strong><font color=red><?php echo $msgstr["cg_tipoc"]?> </strong>")
    	return    }else{    	msgwin.document.writeln("<strong><?php echo $msgstr["cg_tipoc"]?>:"+xtipo_mov+" </strong>")    }
	if (mov!="mover" && mov!="dividir"){
		msgwin.document.writeln("<i><?php echo $msgstr["cg_scope"]?></i>: ")
		if (document.forma1.tipoa[0].checked)
			msgwin.document.writeln("<?php echo $msgstr["cg_field"]?><br>")
		else
			msgwin.document.writeln("<?php echo $msgstr["cg_part"]?><br>")
		msgwin.document.writeln("<i><?php echo $msgstr["cg_valactual"]?></i>: "+document.forma1.actual.value+"<br>")
		msgwin.document.writeln("<i><?php echo $msgstr["cg_nuevoval"]?></i>: "+document.forma1.nuevo.value+"<br>")
	}

	if (mov=="mover" || mov=="dividir"){
		ix_csel=document.forma1.nuevotag.selectedIndex
		campo_sel=document.forma1.nuevotag.options[ix_csel].text
		msgwin.document.writeln("<i><?php echo $msgstr["cg_moveto"]?></i>: ")
		msgwin.document.writeln(campo_sel+"<br>")
	}
	if (mov =="dividir"){
		msgwin.document.writeln("<i><?php echo $msgstr["cg_delimiter"]?></i>: "+document.forma1.separar.value+"<br>")
		msgwin.document.writeln("<i><?php echo $msgstr["cg_found"]?></i>: ")
		if (document.forma1.posicion[0].checked)
			msgwin.document.writeln("<?php echo $msgstr["cg_before"]?>")
		else
		    msgwin.document.writeln("<?php echo $msgstr["cg_after"]?>")
	}
	msgwin.document.writeln("<p><a href='javascript:window.opener.document.forma1.submit();self.close()'>Continuar</a>")
	msgwin.document.writeln("&nbsp; &nbsp; &nbsp;<a href='javascript:self.close()'>Cancelar</a>")
	msgwin.document.writeln("</body></html>")
}

function EnviarForma(){
    res=ConfirmarCambio()
}
function EjecutarCambio(){	Se=""
	de=Trim(document.forma1.from.value)
	a=Trim(document.forma1.to.value)
    if (de!="" || a!=""){
		var strValidChars = "0123456789";
		blnResult=true
   	//  test strString consists of valid characters listed above
   		for (i = 0; i < de.length; i++){
    		strChar = de.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["cg_rangoinval"]?>")
	    		return false
    		}
    	}
    	for (i = 0; i < a.length; i++){
    		strChar = a.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["cg_rangoinval"]?>")
	    		return false
    		}
    	}
    	de=Number(de)
    	a=Number(a)
    	if (de<=0 || a<=0 || de>a ||a>top.maxmfn){
	    	alert("<?php echo $msgstr["cg_rangoinval"]?>")
	    	return false
		}
	}
	if (de=="" && a=="" && Trim(document.forma1.Expresion.value)=="" ){		alert("<?php echo $msgstr["cg_selrecords"]?>")
	    return false	}
	ix_csel=document.forma1.global_C.selectedIndex
	if (ix_csel==-1 ){
		alert("<?php echo $msgstr["cg_sel"]?>")
		return false
	}
	campo_sel=document.forma1.global_C.options[ix_csel].value
	cc_sel=campo_sel.split('|')
	if (cc_sel[3]=="AI"|| cc_sel[9]=="AI"){      //POR EL CAMBIO QUE SE HIZO EN EL FDT DEL TIPO DE CAMPO POR EL TIPO DE ENTRADA		if (!confirm("<?php echo $msgstr["cn_sel"]?>"))
			return	}
	x_d=Trim(document.forma1.actual.value)
	x_h=Trim(document.forma1.nuevo.value)
	mov=""
	for (i=0;i<document.forma1.tipoc.length;i++){
	  	if(document.forma1.tipoc[i].checked) mov=document.forma1.tipoc[i].value
	}
	if (mov==""){
	  	alert("<?php echo $msgstr["cg_tipoc"]?>")
	  	return false
	}
	switch (mov){
	  	case "agregar":
	  	case "agregarocc":
	  		if (x_h==""){
			    alert("<?php echo $msgstr["cg_selcontenido"]?>")
			    return false
			}
	  		break
	  	case "modificar":
	  	case "modificarocc":
	  		if (x_h=="" ){
			//    alert("<?php echo $msgstr["cg_modificar"]?>")
			//    return false
			}
	  		break
	  	case "dividir":
	  		if (Trim(document.forma1.separar.value)==""){
	  			alert("<?php echo $msgstr["cg_separador"]?>")
	  			return false
	  		}
	  		if (document.forma1.nuevo.selectedindex==-1){
				alert("<?php echo $msgstr["cg_colocar"]?>")
				return false
			}
			xpos=""
			for (i=0;i<document.forma1.posicion.length;i++){
	  			if(document.forma1.posicion[i].checked) xpos=document.forma1.posicion[i].value
			}
			if (xpos==""){
				alert("<?php echo $msgstr["cg_posicion"]?>")
				return false
			}
	  	case "eliminar":
	  		break
	 	case "eliminarocc":
	 		if (x_d==""){
	 			if (!confirm("<?php echo $msgstr["cg_delallocc"]?>")){
			   	 	return false
				}
			}


	}
	res=ConfirmarCambio()

	document.forma1.MaxMfn.value=top.maxmfn


}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
	ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1) ix=0
	Formato=top.menu.document.forma1.formato.options[ix].value
	FormatoActual="&Formato="+Formato
	Opcion="rango"
  	Url="buscar.php?Opcion=formab&prologo=prologoact&Tabla=Expresion&Target=s&base="+base+"&cipar="+cipar+FormatoActual
  	msgwin=window.open(Url,"CGLOBAL","menu=no, scrollbars=yes, resizable=yes")
  	msgwin.focus()
}

</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cg_titulo"].": ".$arrHttp["base"]?>
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
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/cglobal.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/cglobal.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/c_global.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<form name=forma1 method=post action=c_global_ex.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=MaxMfn>
<?php
echo "
	  <input type=hidden name=Opcion value=$Opcion>";
?>
<center>
<table cellpading=5 cellspacing=5 border=0 width=600>

	<tr>
	<td align=center bgcolor=#cccccc colspan=3><?php echo $msgstr["r_recsel"]?> <a href=../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#SEL target=_blank><img src=img/barHelp.png border=0 height=12></a></td>

	<tr>
		<td  align=left><?php echo $msgstr["cg_rango"]?> </td>
		<td align=left><?php echo $msgstr["cg_from"]?>:<input type=text name=from size=10></td>
		<td  align=left><?php echo $msgstr["cg_to"]?>: <input type=text name=to size=10>
		<script>document.writeln(" (<?php echo $msgstr["cg_maxmfn"]?>: "+top.maxmfn+")")</script></td>
	<TR><td colspan=3><hr></td>
	<tr>
		<td  align=left valign=top><a href=javascript:Buscar()><img src=img/barSearch.png height=24 align=middle border=0><?php echo $msgstr["cg_search"]?> </a></td>
        <TD colspan=2 align=left><?php echo $msgstr["expresion"]?><br>
		<textarea rows=1 cols=80 name=Expresion>
		<?php
	if (isset($arrHttp["Expresion"])){
	  	echo $Expresion;
	}
?></textarea>
		</td>

	<tr>
		<td valign=top align=right><br><?php echo $msgstr["cg_selfield"]?></td>
		<td align=left colspan=2><br>
			<Select name=global_C><option></option>
<?php foreach ($Fdt as $linea){
		$t=explode('|',$linea);
   		echo "<option value='".$t[1].'|'.$t[5].'|'.$t[6].'|'.$t[0]."'>".$t[2]." (".$t[1].")";
   		if ($t[5]!="") echo " (".$t[5].")";
   		echo "\n";
  	}
?>
					</select> <a href=../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#CAMPO target=_blank><img src=img/barHelp.png border=0 height=15></a>
					<br>
					</td>

	<tr><td colspan=4>&nbsp;</td>
	<tr>
		<td  colspan=4 align=center bgcolor=#cccccc>
                <?php echo $msgstr["cg_tipoc"]?>  <a href=../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#TIPO_CAMBIO target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
				<table>
					<td><input type=radio name=tipoc value="agregar"><?php echo $msgstr["cg_add"]?></td>
					<td><input type=radio name=tipoc value="modificar"><?php echo $msgstr["cg_modify"]?></td>
					<td><input type=radio name=tipoc value="eliminar"><?php echo $msgstr["cg_delete"]?></td>
		        <tr>
		        	<td><input type=radio name=tipoc value="agregarocc"><?php echo $msgstr["cg_addocc"]?></td>
					<td><input type=radio name=tipoc value="modificarocc"><?php echo $msgstr["cg_modifyocc"]?></td>
					<td><input type=radio name=tipoc value="eliminarocc"><?php echo $msgstr["cg_deleteocc"]?></td>
				</table>
		</td>
		<tr>
		<td colspan=4>
		<?php echo "<font color=darkred>".$msgstr["cg_modify"]." / " .$msgstr["cg_modifyocc"]."</font><br>".$msgstr["cg_scope"]?>:
						<input type=radio name=tipoa value="frase" checked><?php echo $msgstr["cg_field"]?>&nbsp; &nbsp; &nbsp;
						<input type=radio name=tipoa value="cadena"><?php echo $msgstr["cg_part"]?>&nbsp; &nbsp; &nbsp;
		</div>
					</td>

	<tr>

		<td  colspan=4 align=left width=100%>

			<table>

				<tr>
					<td   valign=top  bgcolor=#cccccc><?php echo $msgstr["cg_valactual"]?>  <a href=../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#VALOR target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
					<input type=text name=actual size=100>
					</td>
				<tr>
					<td ><?php echo $msgstr["cg_nuevoval"]?>:  <a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/cglobal.html#NUEVO_VALOR target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
					<input type=text name=nuevo size=100><!-- <a href=javascript:MostrarLista("nuevo")><img src=img/barSearch.png height=24 align=middle border=0></a>-->
					</td>
			</table>
		</td>
	<tr>
		<td  colspan=4 align=center bgcolor=#cccccc>
				<input type=radio name=tipoc value="dividir"><?php echo $msgstr["cg_split"]?>&nbsp;
				<input type=radio name=tipoc value="mover"><?php echo $msgstr["cg_move"]?>&nbsp;
				<a href=../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#DIVIDIR target=_blank><img src=img/barHelp.png border=0 height=12></a>&nbsp; &nbsp;
		</td>
	<tr>
		<td colspan=4 >
		<table border=0>
			<tr>
			<td align=left><?php echo $msgstr["cg_delimiter"]?></td><td align=left><input type=text name=separar value=""></td>
			<tr>
			<td align=left><?php echo $msgstr["cg_moveto"]?></td><td align=left><Select name=nuevotag>
			<option value=""><?php echo $msgstr["cg_splitdel"]?>
<?php foreach ($Fdt as $linea){
		$t=explode('|',$linea);
   		echo "<option value='".$t[1]."|".trim(substr($linea,46,2))."|".trim(substr($linea,59))."'>".$t[2]." (".$t[1].")\n";  	}
?>
</select></td><tr><td></td><td ><?php echo $msgstr["cg_found"]?><input type=radio name=posicion value=antes><?php echo $msgstr["cg_before"]?> <input type=radio name=posicion value=despues><?php echo $msgstr["cg_after"]?> </div>
			</td>
		</table>
		</td>
	<TR><td colspan=3 bgcolor=#cccccc>&nbsp;</td>
</table>
<p><input type=submit value=<?php echo $msgstr["cg_execute"]?> onClick=javascript:EnviarForma()>
&nbsp; &nbsp; &nbsp; <input type=reset value=<?php echo $msgstr["cg_borrar"]?>>&nbsp; &nbsp; &nbsp;
</div>
</div>
</center>
<script>
if (top.CG_actual.value!="") document.forma1.actual.value=top.CG_actual
if (top.CG_nuevo.value!="") document.forma1.nuevo.value=top.CG_nuevo

</script>
</form>
<?php
include("../common/footer.php");
?>

</body>
</html>

