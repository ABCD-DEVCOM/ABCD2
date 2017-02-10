<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
//

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
$parm=explode('|',$arrHttp["list"]);

if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}


include("../common/header.php");
?>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script language=Javascript src=../dataentry/js/selectbox.js></script>
<style type=text/css>

td{	font-size:12px;
	font-family:Arial;}

div#useexformat{

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}


div#testformat{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#savesearch{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script languaje=javascript>

function CopiarExpresion(){
	Expr=document.forma1.Expr.options[document.forma1.Expr.selectedIndex].value
	document.forma1.Expresion.value=Expr

}

function CopySortKey(){
	Sort=document.forma1.sort.options[document.forma1.sort.selectedIndex].value
	document.forma1.sortkey.value=Sort
}

function CreateSortKey(){
	msgwin=window.open("","sortkey","resizable,scrollbars, width=600,height=600")	document.sortkey.submit()
	msgwin.focus()}

function AbrirVentana(Archivo){
	xDir=""
	msgwin=window.open(xDir+"ayudas/"+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function EsconderVentana( whichLayer ){var elem, vis;

	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
	vis.display = 'none';
	vis.display =  'none';
}


function toggleLayer( whichLayer ){
	var elem, vis;

	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
		vis.display = ( elem.offsetWidth != 0 && elem.offsetHeight != 0 ) ? 'block':'none';
	vis.display = ( vis.display == '' || vis.display == 'block' ) ? 'none':'block';
}



function BorrarRango(){
	document.forma1.Mfn.value=''
	document.forma1.to.value=''
}


function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function EnviarForma(vp){
	if (vp=="P") {
		document.forma1.vp.value="S"
		document.forma1.target="VistaPrevia"
		msgwin=window.open("","VistaPrevia","resizable, status, scrollbars,width=700,height=600")
	}else{
		document.forma1.vp.value=vp
		document.forma1.target=""
	}
	de=Trim(document.forma1.Mfn.value)
  	a=Trim(document.forma1.to.value)
  	if (de!="" || a!="") {
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
    	if (de<=0 || a<=0 || de>a ){
	    	alert("<?php echo $msgstr["numfr"]?>")
	    	return
		}
		document.forma1.Opcion.value="rango"
	}

	if (Trim(document.forma1.Expresion.value)=="" && (Trim(document.forma1.Mfn.value)=="" )){
		alert("<?php echo $msgstr["r_selreg"]?>")
		return
	}
  	document.forma1.submit()
  	msgwin.focus()
}

function Buscar(){
	base='<?php echo $arrHttp["base"]?>'
	cipar=base+".par"
	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}


function GuardarBusqueda(){
	document.savesearch.Expresion.value=Trim(document.forma1.Expresion.value)
	if (document.savesearch.Expresion.value==""){
		alert("<?php echo $msgstr["faltaexpr"]?>")
		return
	}
	Descripcion=document.forma1.Descripcion.value
	if (Trim(Descripcion)==""){
		alert("<?php echo $msgstr["errsave"]?>")
		return
	}
	document.savesearch.Descripcion.value=Descripcion
	var winl = (screen.width-300)/2;
	var wint = (screen.height-200)/2;
	msgwin=window.open("","savesearch","menu=no,status=yes,width=300, height=200,left="+winl+",top="+wint)
	msgwin.focus()
	document.savesearch.submit()
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $parm[1]?>
	</div>

	<div class="actions">
<?php
	$ayuda="pft.html";
	if (isset($arrHttp["encabezado"])){			echo "<a href=\"reports_menu.php?$encabezado\" class=\"defaultButton backButton\">
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>".$msgstr["back"]."</strong></span></a>
			";
	}
?>

</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reports.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reports_menu_recsel.php";
?>
</font>
	</div>
<form name=forma1 method=post action=../dataentry/imprimir_g.php onsubmit="Javascript:return false" target=VistaPrevia>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Dir value=pfts/es>
<input type=hidden name=vp>
<input type=hidden name=Opcion>
<?php $tit=explode("|",$arrHttp["list"]);
echo "<input type=hidden name=fgen value=\"".trim($tit[0]);
if (isset($tit[2])) echo "|".trim($tit[2]);
echo "\">\n";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
?>
<center>
<div class="middle form">
			<div class="formContent">
<!-- GENERATE OUTPUT -->
<table background=../img/fondo0.jpg width=600 cellpadding=5 class=listTable>
	<tr>
		<td>
			&nbsp;<strong><?php echo $msgstr["generateoutput"]?></strong>
    		<div id=testformat><p>
    		<table>
		<td colspan=2 align=center height=1 bgcolor=#eeeeee><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td  align=center colspan=2><strong><?php echo $msgstr["r_mfnr"]?></strong>: &nbsp; &nbsp; &nbsp;
		<?php echo $msgstr["r_desde"]?>: <input type=text name=Mfn size=10>&nbsp; &nbsp; &nbsp; &nbsp;<?php echo $msgstr["r_hasta"]?>:<input type=text name=to size=10>
		 &nbsp; &nbsp; &nbsp; <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a>
		<script> if (top.window.frames.length>0)
			document.writeln(" &nbsp; &nbsp; &nbsp; (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script></td>
	<tr>
		<td  align=center colspan=2><strong><?php echo $msgstr["r_busqueda"]?></strong>: &nbsp;
<?php
unset($fp);
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab"))
	$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
else
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab"))
		$fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab");
if ($fp){
	echo "&nbsp; &nbsp; &nbsp; &nbsp;".$msgstr["copysearch"].":";
	echo "<select name=Expr  onChange=CopiarExpresion()>
    		<option value=''>
    ";
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$pp=explode('|',$value);
			echo "<option value=\"".$pp[1]."\">".$pp[0]."</option>\n";
		}
	}

}
?>
			</select>&nbsp; &nbsp;
			<a href=javascript:Buscar()><?php echo $msgstr["new"]?></a>
			<br>
			<textarea rows=2 cols=100 name=Expresion><?php if ($Expresion!="") echo $Expresion?></textarea>
			<a href=javascript:BorrarExpresion() class=boton><?php echo $msgstr["borrar"]?></a>
<?php
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])){	echo "&nbsp; <A HREF=\"javascript:toggleLayer('savesearch')\"> <u><strong>". $msgstr["savesearch"]."</strong></u></a>";
	echo "<div id=savesearch>".$msgstr["r_desc"].": <input type=text name=Descripcion size=40>
     	&nbsp &nbsp <input type=button value=\"". $msgstr["savesearch"]."\" onclick=GuardarBusqueda()>
		</div>\n";}
?>
		</td>
	<tr>
		<td colspan=2><strong><?php echo $msgstr["sortkey"]?></strong>: &nbsp;
		<input type=text name=sortkey size=70> &nbsp; &nbsp; &nbsp; <?php echo $msgstr["sortkeycopy"]?>
		&nbsp; &nbsp;
    		<select name=sort  onChange=CopySortKey()>
    		<option value=''>
<?php
unset($fp);
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab"))
	$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab");
else
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab"))
		$fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab");
if ($fp){
	foreach ($fp as $value){
		if (trim($value)!=""){
			$pp=explode('|',$value);
			echo "<option value=\"".trim($pp[1])."\">".$pp[0]."</option>\n";
		}
	}

}

echo "			</select>";
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_EDSORT"])){
 echo "&nbsp; &nbsp;<a href=javascript:CreateSortKey()>".$msgstr["sortkeycreate"]."</a>";
 }
?>
		</td>

	<tr>
		<td colspan=2 width=100%>
			<strong><?php echo $msgstr["sendto"]?></strong>:
			<a href=javascript:EnviarForma('WP')><?php echo $msgstr["word"]?></a>
			&nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			<a href=javascript:EnviarForma('TB')><?php echo $msgstr["wsproc"]?></a>
			&nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			<a href=javascript:EnviarForma('P')><?php echo $msgstr["vistap"]?></a>

		</td>
</table>
</div>
</td>
</table>
<!--a href=menu_modificardb.php?base=<?php echo $arrHttp["base"]?>><?php echo $msgstr["cancel"]?></a>-->
</form>
<form name=savesearch action=../dataentry/busqueda_guardar.php method=post target=savesearch>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=Expresion value="">
	<input type=hidden name=Descripcion value="">
</form>	<p>
<form name=sortkey method=post action=../dataentry/sortkey_edit.php target=sortkey>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=encabezado value=s>
</form>
</center>
</div>
</div>
</center>
<?php
include("../common/footer.php");
?>
</body>
</html>
