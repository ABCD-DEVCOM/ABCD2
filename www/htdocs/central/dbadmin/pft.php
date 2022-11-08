<?php
/* Modifications
2021-03-03 fho4abcd Replaced helper code fragment by included file
2021-06-14 fho4abcd remove password+lineends
2022-01-20 fho4abcd new look buttons+Remove some nested tables+cleanup html+repair bugs
2022-01-25 fho4abcd more new look buttons, shift Generate output to the bottom, improve generate output layout
2022-01-26 fho4abcd Open preview in larger window and after all checks passed.
2022-01-29 fho4abcd Improve setting of encabezado+create language folder if it does not exist
20220227 fho4abcd Always show backbutton. Other back if institutional info not shown
20220918 fho4abcd Explode base before config.php (to get correct value for $actparfolder)
20221102 fho4abcd Cancel button acts now the same as the back button
*/

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$x=explode('|',$arrHttp["base"]);
$arrHttp["base"]=$x[0];

include ("../config.php");
if (isset($_SESSION["UNICODE"])) {
	IF ($_SESSION["UNICODE"]==1)
		$meta_encoding="UTF-8";
	else
		$meta_encoding="ISO-8859-1";
}
include ("../lang/admin.php");
include ("../lang/dbadmin.php");


function LeerArchivos($Dir,$Ext){
// se leen los archivos con la extensión .pft
$the_array = Array();
if (!file_exists($Dir)) mkdir($Dir);
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
if (strpos($arrHttp["base"],"|")===false){

}else{
	$ix=explode('|',$arrHttp["base"]);
	$arrHttp["base"]=$ix[0];
}
if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="s";
else
	$encabezado="";

$arrHttp["login"]=$_SESSION["login"];

$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";
$login=$arrHttp["login"];

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}
include("../common/header.php");
?>
<body>
<?php

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
if ($arrHttp["Opcion"]!="new"){
	$pft=LeerArchivos($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/","pft");
	echo "\n<script>Dir='pfts/".$_SESSION["lang"]."/'</script>\n";
	$arrHttp["Dir"]="pfts/".$_SESSION["lang"];

	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
	if (file_exists($archivo)){
		$fpTm=file($archivo);
	}else{
		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		if (file_exists($archivo)){
			$fpTm=file($archivo);
		}else{
			echo $msgstr["fatal"].". ".$msgstr["misfile"].": ".$db_path.$arrHttp["base"]."/".$arrHttp["base"].".fdt";
			die;
		}
	}
}else{
	$arrHttp["Dir"]="";
	$fpTm=explode("\n",$_SESSION["FDT"]);
}
foreach ($fpTm as $linea){
	if (trim($linea)!="") {
		$t=explode('|',$linea);
		if ($t[0]!="S")
   		$Fdt[]=rtrim($linea);
	}
}

?>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language="Javascript" src=../dataentry/js/selectbox.js></script>
<style type=text/css>


div#useexformat{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#createformat{
<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#pftedit{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#testformat{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#saveformat{
	<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script language=javascript>

TipoFormato=""
C_Tag=Array()

//IF THE TYPE OF OUTPUT IS NOT IN COLUMN, HEADINGS ARE NOT ALLOWED
function CheckType(){
	if (document.forma1.tipof[0].checked || document.forma1.tipof[1].checked){
		alert("<?php echo $msgstr["r_noheading"]?>")
		document.forma1.pft.focus()
	}
}

function CopiarExpresion(){
	Expr=document.forma1.Expr.options[document.forma1.Expr.selectedIndex].value
	document.forma1.Expresion.value=Expr
}

function CopySortKey(){
	Sort=document.forma1.sort.options[document.forma1.sort.selectedIndex].value
	document.forma1.sortkey.value=Sort
}

function CreateSortKey(){
	msgwin=window.open("","sortkey","resizable,scrollbars, width=700,height=600")
	document.sortkey.submit()
	msgwin.focus()
}

function AbrirVentana(Archivo){
	xDir=""
	msgwin=window.open(xDir+"ayudas/"+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function EsconderVentana( whichLayer ){
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
	vis.display = 'none';
	vis.display =  'none';
}


function toggleLayer( whichLayer ){
	var elem, vis;

	switch (whichLayer){
		case "createformat":
<?php if ($arrHttp["Opcion"]!="new"){
		echo '
			document.forma1.fgen.selectedIndex=-1
			EsconderVentana("useexformat")
			break
			';
}
?>
		case "useexformat":
			EsconderVentana("createformat")
			break

	}
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

function SubCampos(Tag,delim,ed){
	xtag="(if p(v"+Tag+") then "
	for (ic=0;ic<delim.length;ic++){
		if(delim.substr(ic,1)=="-")
			delimiter="*"
 		else
 			delimiter=delim.substr(ic,1)
 		edicion=ed.substr(ic,1)
 		if (ic==0)
 			edicion=""
 		else
 			if (edicion!="") edicion=" "+edicion
		//if (ic!=delim.length-1)
			if (edicion!="")
				xtag+=',|'+edicion+'|v'+Tag+'^'+delimiter+','
	        else
			    xtag+="| |v"+Tag+'^'+delimiter+","
       	//else
       	//	xtag+="v"+Tag+'^'+delimiter+','

	}
	xtag+=" if iocc<>nocc(v"+Tag+") then '<br>' fi"
	xtag+=" fi/)"
	return xtag
}

function GenerarFormato(Tipo){
    if (document.forma1.list21.options.length==0){
    	alert("<?php echo $msgstr["selfieldsfmt"]?>")
    	return
    }
    <?php if ($arrHttp["Opcion"]!="new")
		echo "document.forma1.fgen.selectedIndex=-1
		";
	?>

	formato=""
	head=""    //COLUMNS HEADING
    switch (Tipo){
    	case "T":             //TABLE
    		formato="'<table border=0 width=90%>'\n"
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
				if (xTag=="" || xTipoE=="L"){
					campo="'<tr><td colspan=2 valign=top><font face=arial size=2><b>"+t[2]+"</b></td>'/\n"
		    	}else {
		    		if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|<br>|"
					}
			    	campo="if p(v"+xTag+ ") then '<tr><td width=20% valign=top><font face=arial size=2><b>"+t[2]+"</b></td><td valign=top><font face=arial size=2>'"+tag+",'</td>' fi/\n"
				}
				formato+=campo
			}
			formato+="'</table><p>'";
    		break
    	case "PL":
    	case "P":
	    	for (i=0;i<document.forma1.list21.options.length;i++){
		    	campo=document.forma1.list21.options[i].value
		    	t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
				if (xTag=="" || xTipoE=="L"){
					campo="'<br><b>"+t[2]+"</b></td>'/\n"
		    	}else {
		    		if (Tipo=='PL')
		    			label_f=  "<font face=arial size=2><b>"+t[2]+"</b>: "
		 			else
		 				label_f=""
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|; |"
					}

		    		campo="if p(v"+xTag+ ") then '<br>"+label_f+"<font face=arial size=2>'"+tag+", fi/\n"
				}
				formato+=campo
			}
			formato+="'<P>'/\n"
    		break
    	case "CT":
    		formato+="\n'<tr>',"
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
		  		if (xTag!=""){
		  			res=""
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|; |"
					}
			    	campo="'<td valign=top><font face=arial size=2>'"+tag+" if a(v"+xTag+") then '&nbsp;' fi,'</td>'/\n"
			    	formato+=campo
			    	head+=t[2]+"\n"
				}
			}
    		break;
    	case "CD":
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
		  		if (xTag!=""){
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag
					}
			    	campo=tag+",'|',\n"
			    	formato+=campo
			    	head+=t[2]+"\n"
				}

			}
			formato+="/"
    		break;
    }

	document.forma1.pft.value=formato
	document.forma1.headings.value=head

}

function LeerArchivo(Opcion){

  	if (Opcion!="agregar"){
		ix=document.forma1.fgen.selectedIndex
		if (ix==-1 || ix==0){
    		alert("<?php echo $msgstr["r_self"]?>")
    		return
		}
		fmt=document.forma1.fgen.options[ix].value

		desc=document.forma1.fgen.options[ix].text
		forsel=document.forma1.fgen.options[ix].value
  	}else{
  		forsel="*"  //para indicar que es un formato nuevo
  	}
  	xfmt=fmt+'|'
  	fm=xfmt.split('|')
  	document.forma1.nombre.value=fm[0]
  	document.forma1.descripcion.value=desc
	msgwin=window.open("leertxt.php?base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["base"]?>.par&pft=s&archivo="+forsel,"editar","menu=no,status=yes, resizable, scrollbars,width=790")
	msgwin.focus()
}

function SubirFormato(){
	document.forma1.pft.value=""
	BorrarFormato("todos")
	theHeight=150
	theWidth=400
	var theTop=(screen.height/2)-(theHeight/2);
	var theLeft=(screen.width/2)-(theWidth/2);
	var features= 'height='+theHeight+',width='+theWidth+',top='+theTop+',left='+theLeft+",scrollbars=yes,resizable";
	msgupload=window.open("","upload",features)
	msgupload.document.writeln("<html><Title><?php echo $msgstr["pft"]?></title>")
	msgupload.document.writeln("<style>")
	msgupload.document.writeln("td{font-family:arial;font-size:10px}</style>")
	msgupload.document.writeln("<form action=upload_pft.php method=POST enctype=multipart/form-data>")
	msgupload.document.writeln("<input type=hidden name=Opcion value=PFT>")
	msgupload.document.writeln("<dd><table bgcolor=#eeeeee>")
	msgupload.document.writeln("<tr>")
	msgupload.document.writeln("<tr><td class=title><?php echo $msgstr["subir"]." ".$msgstr["pft"]?></td>")
	msgupload.document.writeln("<tr><td><input name=userfile[] type=file size=20></td><td></td>")
	msgupload.document.writeln("<tr><td><input type=submit value='<?php echo $msgstr["subir"]?>'></td>")
	msgupload.document.writeln("</table>")
	msgupload.document.writeln("<p>")
	msgupload.document.writeln("</form>")
	msgupload.focus()
	msgupload.document.close()
}
function BorrarFormato(area){
	if (area=="todos"){
		document.forma1.headings.value=""
		document.forma1.pft.value=""
    }else{
    	Ctrl=eval ("document.forma1."+area)
    	Ctrl.value=""
    }

	moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false)
	for (i=0;i<document.forma1.tipof.length;i++){
		document.forma1.tipof[i].checked=false
	}
}

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function BorrarSeleccionados(){
	document.forma1.seleccionados.value=''
}

function EnviarForma(vp){
	if (vp=="P") {
		document.forma1.vp.value="S"
		document.forma1.target="VistaPrevia"
	}else{
		document.forma1.vp.value=vp
		document.forma1.target=""
	}
	de=Trim(document.forma1.Mfn.value)
  	a=Trim(document.forma1.to.value)
  	if (de!="" || a!="") {
	  	document.forma1.Opcion.value="rango"
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

	if (Trim(document.forma1.pft.value)=="" && document.forma1.fgen.selectedIndex<1 && Trim(document.forma1.pft.value)==""  ){
	  	alert("<?php echo $msgstr["r_selgen"]?>")
	  	return
	}
	if (Trim(document.forma1.Expresion.value)=="" && Trim(document.forma1.Mfn.value)=="" && Trim(document.forma1.seleccionados.value)==""){
		alert("<?php echo $msgstr["r_selreg"]?>")
		return
	}
	if (vp=="P") {
		msgwin=window.open("","VistaPrevia","width=600,top=0,left=0,resizable, status, scrollbars")
    }

  	document.forma1.submit()
  	msgwin.focus()
}

function GuardarFormato(){
	document.forma1.fgen.selectedindex=-1
	if (Trim(document.forma1.pft.value)==""){
	  	alert("<?php echo $msgstr["r_selgen"]?>")
	  	return
	}
	if (Trim(document.forma1.nombre.value)==""){
		alert("<?php echo $msgstr["r_fnomb"]?>")
		return
	}
	if (Trim(document.forma1.descripcion.value)==""){
		alert("<?php echo $msgstr["pftnodescri"]?>")
		return
	}
	fn=document.forma1.nombre.value
	bool=  /^[a-z][\w]+$/i.test(fn)
 	if (bool){

   	}else {
      	alert("The name must start with a letter and contains only letters and numbers and the sign _. No extention is required  ");
      	return
   	}
   	tipoformato=""
   	for (i=0;i<document.forma1.tipof.length;i++){
   		if (document.forma1.tipof[i].checked)
   			tipoformato=document.forma1.tipof[i].value
   	}
	document.guardar.pft.value=document.forma1.pft.value
	document.guardar.headings.value=document.forma1.headings.value
	document.guardar.tipof.value=tipoformato
	document.guardar.nombre.value=document.forma1.nombre.value
	document.guardar.descripcion.value=document.forma1.descripcion.value
	document.guardar.base.value=document.forma1.base.value
	document.guardar.submit()

}

function Buscar(){
	base='<?php echo $arrHttp["base"]?>'
	cipar=base+".par"
	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=1000,height=500")
	msgwin.focus()
}

function EliminarFormato(){
	if (document.forma1.fgen.selectedIndex==0 || document.forma1.fgen.selectedIndex==-1){
		alert("<?php echo $msgstr["selpftdel"]?>")
		return
	}
	ix=document.forma1.fgen.selectedIndex
	if (confirm("delete "+document.forma1.fgen.options[ix].text+"?")){
		file=document.forma1.fgen.options[ix].value +'|'
		f=file.split('|')
    	document.frmdelete.pft.value=f[0]
    	document.frmdelete.submit()
    }
}

function ValidarFormato(){
	if (Trim(document.forma1.pft.value)==""){
		alert("<?php echo $msgstr["genformat"]?>")
		return
	}
	document.forma1.action="crearbd_new_create.php"
	document.forma1.submit()
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
<?php
if ($encabezado!=""){
	include("../common/institutional_info.php");
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["pft"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php
if ($arrHttp["Opcion"]=="new"){
	$ayuda="pft_create.html";
    $backtoscript="fst.php?Opcion=new";
    $backtocancelscript="../dbadmin/menu_creardb.php";
    include "../common/inc_back.php";
    include "../common/inc_cancel.php";
}else{
	$ayuda="pft.html";
	if (isset($arrHttp["encabezado"])){
		if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDB"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDB"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])){
			if (isset($arrHttp["retorno"])) $backtoscript=$arrHttp["retorno"];
			else                            $backtoscript="menu_modificardb.php";
            include "../common/inc_back.php";
            include("../common/inc_home.php");

		}else{
            include("../common/inc_home.php");
		}
	} else {
        $backtoscript="../dataentry/inicio_main.php";
        include "../common/inc_back.php";
    }// end if encabezado
    $backtocancelscript=$backtoscript;
}
?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
if ( $arrHttp["Opcion"]!="new" ) {
    include ("../common/inc_get-dbinfo.php");// sets $arrHttp["MAXMFN"]
} else {
    $arrHttp["MAXMFN"]="";
}
?>
<div class="middle form">
<div class="formContent">
<form name=forma1 method=post action=../dataentry/imprimir_g.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Dir value='<?php echo $arrHttp["Dir"]?>'>
<input type=hidden name=Modulo value='<?php if (isset($arrHttp["Modulo"])) echo $arrHttp["Modulo"]?>'>
<input type=hidden name=tagsel>
<input type=hidden name=Opcion>
<input type=hidden name=vp>
<?php
if ($encabezado!="") echo "<input type=hidden name=encabezado value=s>\n";

/*
** here was an unused piece of code using file /pfts/<lang>/listados.dat
** This file is not created by any code and no such file is found in any example database
** The <select> tag was modified to <xselect (already in the first commit). Implies that it was not used
** The code is now removed completely
*/

// The top message: Generate output
?>
<table class=listTable>
    <tr>
	<td style="text-align:center">
		<?php echo "<strong>".$msgstr["r_fgent"]."</strong>";?>
        &nbsp; &nbsp;
        <a href="https://abcd-community.org/cisis-formatting-language/" target="_blank">
        <font size=1><i class="far fa-life-ring"></i> <?php echo $msgstr["cisis"]?></font>
        </a>
   </td>
   </tr>
</table>
<?php
if ($arrHttp["Opcion"]!="new"){
    //==== USE AN EXISTING FORMAT ==================================
    ?>
	<table class=listTable>
        <tr>
        <td>
    		<A HREF="javascript:toggleLayer('useexformat')"> <u><strong><?php echo $msgstr["useexformat"]?></strong></u></a>
    		<div id=useexformat> &nbsp;
                <br><?php echo $msgstr["r_formatos"]?>: 
                <select name=fgen onclick='javascript:BorrarFormato("todos")'>
                <option value=''>
                <?php
                unset($fp);
                $archivo=$db_path.$base."/pfts/".$_SESSION["lang"]."/formatos.dat";
                if (!file_exists($archivo)) $archivo=$db_path.$base."/pfts/".$lang_db."/formatos.dat";
                if (file_exists($archivo)) $fp = file($archivo);
                if (isset($fp)){
                    foreach ($fp as $value){
                        $value=trim($value);
                        if ($value!=""){
                            $pp=explode('|',$value);
                            if (!isset($pp[2])) $pp[2]="";
                            if (!isset($pp[3])) $pp[3]="";
                            if (isset($_SESSION["permiso"]["CENTRAL_ALL"])
                                or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])
                                or isset($_SESSION["permiso"][$arrHttp["base"]."_pft_ALL"])
                                or isset($_SESSION["permiso"][$arrHttp["base"]."_pft_".$pp[0]])){
                                echo "<option value=\"".$pp[0]."|".$pp[2]."|".$pp[3]."\">".$pp[1]." (".$pp[0].")</option>\n";
                            }
                        }
                    }

                }
                ?>
                </select>
                <?php
                if (isset($_SESSION["permiso"]["CENTRAL_ALL"])
                    or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])
                    or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EDPFT"])
                    or isset($_SESSION["permiso"]["_CENTRAL_EDPFT"])) {
                    ?> &nbsp;
                    <button class="bt-green" type="button"
                        title="<?php echo $msgstr["edit"]?>:&nbsp;<?php echo $arrHttp["base"]."/".$arrHttp["Dir"]."/..."?>"
                        onclick='javascript:LeerArchivo("")'>
                        <i class="far fa-edit"></i> <?php echo $msgstr["edit"]?></button>
                    <button class="bt-red" type="button"
                        title="<?php echo $msgstr["delete"]?>:&nbsp;<?php echo $arrHttp["base"]."/".$arrHttp["Dir"]."/..."?>"
                        onclick='javascript:EliminarFormato()'>
                        <i class="fas fa-trash"></i> <?php echo $msgstr["delete"]?></button>
                    <?php
                }
                ?>
            </div>
        </td></tr>
    </table>
<?php
}else{
    echo "<div id=useexformat></div>";
}
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])
    or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])
    or isset($_SESSION["permiso"]["CENTRAL_EDPFT"])
    or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EDPFT"])
    or isset($_SESSION["permiso"]["CENTRAL_MODIFYDB"])
    or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDB"])){
    // ==== CREATE A FORMAT==== also for "new" items ===========  ?>
    <!-- CREATE A FORMAT -->
    <table class=listTable>
        <tr>
        <td>
            <a HREF="javascript:toggleLayer('createformat')"><u><strong><?php echo $msgstr["r_creaf"]?></strong></u></a>
            <div id=createformat><br>
                <?php echo $msgstr["r_incluirc"]?><br>
            &nbsp; &nbsp; &nbsp;
            <table style="display:inline-table">
                <tr>
                <td style="border-bottom:none">
                    <select name=list11 style="width:250px" multiple size=10 onDblClick="moveSelectedOptions(this.form['list11'],this.form['list21'],false)">
                    <?php
                        $t=array();
                        foreach ($Fdt as $linea){
                            $t=explode('|',$linea);
                            echo "<option value='".$linea."'>".$t[2]." (".$t[1].")\n";
                        }
                    ?>
					</select>
				</td>
				<td style="border-bottom:none">
					<a class="button_browse show" href="#" onClick="moveSelectedOptions(document.forms[0]['list11'],document.forms[0]['list21'],false);return false;">
                        <i class="fas fa-angle-right"></i>
                        </a>
                        <br><br>
                    <a class="button_browse show" href="#" onClick="moveAllOptions(document.forms[0]['list11'],document.forms[0]['list21'],false); return false;">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                    <br><br>
                    <a class="button_browse show" href="#" onClick="moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;"><i class="fas fa-angle-double-left"></i>
                    </a>
                    <br><br>
                    <a class="button_browse show" href="#" onClick="moveSelectedOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;">
                        <i class="fas fa-angle-left"></i>
                    </a>
				</td>
				<td width=250 style="border-bottom:none">
					<select NAME="list21" MULTIPLE SIZE=10 style="width:250px" onDblClick="moveSelectedOptions(this.form['list21'],this.form['list11'],false)">

					</select>
				</td>
				<td style="border-bottom:none">
                    <button class="button_browse show" type="button" value="<?php echo $msgstr["up"]?>" title="<?php echo $msgstr['up']?>" onClick="moveOptionUp(this.form['list21'])"><i class="fas fa-caret-up"></i></button>
                    <br><br>
                    <button class="button_browse show" type="button" value="<?php echo $msgstr["down"]?>" title="<?php echo $msgstr["down"]?>" onClick="moveOptionDown(this.form['list21'])"><i class="fas fa-caret-down"></i></button>
				</td>
                </tr>
			</table>
           <div>
                <?php echo $msgstr["pftoutsyntax"]?> &nbsp;&nbsp;
                <input type=radio name=tipof value=T  onclick="GenerarFormato('T')" ><?php echo $msgstr["r_tabla"]?> &nbsp;
                <input type=radio name=tipof value=P  onclick="GenerarFormato('P')" ><?php echo $msgstr["r_parrafo"]?> &nbsp;
                <input type=radio name=tipof value=PL onclick="GenerarFormato('PL')"><?php echo $msgstr["r_parrafowith"]?> &nbsp;
                <input type=radio name=tipof value=CT onclick="GenerarFormato('CT')"><?php echo $msgstr["r_colstab"]?> &nbsp;
                <input type=radio name=tipof value=CD onclick="GenerarFormato('CD')"><?php echo $msgstr["r_colsdelim"]?> &nbsp; 
            </div>
            &nbsp; &nbsp; &nbsp;
            <table style="display:inline-table">
                <tr>
                <td style="border-bottom:none">
                    <?php echo $msgstr["pftgenoutput"]?><br>
                    <textarea name=pft cols=80 rows=10 style="font-family:courier new;"></textarea>
                </td>
                <td style="border-bottom:none">
                    <?php echo $msgstr["r_heading"]?><br>
                    <textarea name=headings cols=30 rows=10 style="font-family:courier new;" onfocus=CheckType()></textarea>
                </td>
                </tr>
                <tr><td style="border-bottom:none" colspan=2>
                    <div style="text-align:center">
                        <button class="bt-gray" type="button"
                            title="<?php echo $msgstr["borrar"]?>" onclick='javascript:BorrarFormato("pft")'>
                            <i class="fa fa-times"></i> <?php echo $msgstr["borrar"]?></button>
                    </div>
                </td></tr>
            </table>
		</div>
		</td>
        </tr>
    </table>
<?php
}else{
	echo "<div id=createformat></div>";
}
// =========== Save format =========== Not for new databases
if ($arrHttp["Opcion"]!="new" and
    (   isset($_SESSION["permiso"]["CENTRAL_ALL"])
        or isset($_SESSION["permiso"]["CENTRAL_EDPFT"])
        or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])
        or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EDPFT"]))){
    ?>
    <table class=listTable>
        <tr>
        <td>
            <a HREF="javascript:toggleLayer('saveformat')"><u><strong><?php echo $msgstr["r_guardar"]?></strong></u></a>
            <div id=saveformat><br> &nbsp;
                <span title="<?php echo $msgstr["pftnameenter"]?>"><?php echo $msgstr["name"]?></span>
                <input type=text name=nombre size=20 maxlength=30 value='' title="<?php echo $msgstr["pftnameenter"]?>"> &nbsp; &nbsp;

                <?php echo $msgstr["description"]?>
                <input type=text size=50 maxlength=50 name=descripcion value=''> &nbsp; 

                <button class="bt-green" type="button"
                    title="<?php echo $msgstr["saveinfolder"]?>:&nbsp;<?php echo $arrHttp["base"]."/". $arrHttp["Dir"]?>/"
                    onclick="javascript:GuardarFormato()">
                    <i class="far fa-save"></i> </button>
            </div>
        </td>
        </tr>
    </table>
    <?php
}
 //=============GENERATE OUTPUT============= 
if ($arrHttp["Opcion"]!="new"){?>
    <!-- GENERATE OUTPUT -->
    <table >
	<tr>
    <td>
        <a HREF="javascript:toggleLayer('testformat')"><u><strong><?php echo $msgstr["generateoutput"]?></strong></u></a>
        <div id=testformat><p>
            <table>
                <tr> <!-- row 1 record selection by MFN range -->
                <td><?php echo $msgstr["r_recsel"]?><br>
                    <b><?php echo $msgstr["r_mfnr"]?></b>
                </td>
                <td>
                    <?php echo $msgstr["r_desde"]?>: <input type=text name=Mfn size=10>&nbsp; &nbsp; &nbsp; &nbsp;
                    <?php echo $msgstr["r_hasta"]?>: <input type=text name=to size=10>
                    &nbsp;<?php echo $msgstr["maxmfn"]?>:&nbsp;<?php echo $arrHttp["MAXMFN"] ?>
                    &nbsp; &nbsp; 
                    <button class="bt-gray" type="button"
                        title="<?php echo $msgstr["borrar"]?>" onclick='javascript:BorrarRango()'>
                        <i class="fa fa-times"></i> <?php echo $msgstr["borrar"]?></button>
                </td>
                </tr>
                <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
                <?php // check if there are preselected records
                if (isset($arrHttp["seleccionados"])){
                ?>
                <tr>  <!-- row 2 selected record numbers -->
                <td><?php echo $msgstr["r_recsel"]?><br>
                    <b><?php echo $msgstr["selected_records"]?></b>
                    <?php
                    $sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
                    $sel=str_replace("_","",$sel);
                    ?>
                </td>
                <td>
                    <input type=text name=seleccionados size=100 value=<?php echo $sel?>>
                &nbsp;
                    <button class="bt-gray" type="button"
                        title="<?php echo $msgstr["borrar"]?>" onclick='javascript:BorrarSeleccionados()'>
                        <i class="fa fa-times"></i> <?php echo $msgstr["borrar"]?></button>
                </td>
                </tr>
                <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
                <?php } ?>
                <tr> <!-- row 3 record selection by Search -->
                <td><?php echo $msgstr["r_recsel"]?><br>
                    <b><?php echo $msgstr["r_busqueda"]?></b>
                </td>
                <td>
                <table>
                    <tr><td colspan=2>
                        <?php // proces a possible search expression table
                        unset($fp);
                        if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab"))
                            $fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
                        else
                            if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab"))
                                $fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab");
                        if (isset($fp)){
                            ?>
                            <?php echo $msgstr["copysearch"]?> :&nbsp;
                            <select name=Expr  onChange=CopiarExpresion()>
                                <option value=''>
                                <?php
                                foreach ($fp as $value){
                                    $value=trim($value);
                                    if ($value!=""){
                                        $pp=explode('|',$value);
                                        ?>
                                        <option value='<?php echo $pp[1]?>'><?php echo $pp[0]?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> &nbsp; &nbsp;
                            <?php
                        }
                        ?>
                        <button class="bt-green" type="button"
                            title="<?php echo $msgstr["pftcreatesrcexpr"]?>"
                            onclick='javascript:Buscar()'>
                            <i class="far fa-plus-square"></i> <?php echo $msgstr["pftcreatesrcexpr"]?></button>
                        </td>
                    </tr>
                    <tr><td>
                        <textarea rows=2 cols=100 name=Expresion><?php if ($Expresion!="") echo $Expresion?></textarea>
                    </td>
                    <td> &nbsp;
                        <button class="bt-gray" type="button"
                            title="<?php echo $msgstr["borrar"]?>" onclick='javascript:BorrarExpresion()'>
                            <i class="fa fa-times"></i> <?php echo $msgstr["borrar"]?></button>
                    </td>
                    </tr>
                    <?php
                    if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
                        isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])  or
                        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or
                        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_SAVEXPR"])){
                        ?>
                        <tr><td>
                            <button class="bt-green" type="button"
                                title="<?php echo $msgstr["savesearch"]?>"
                                onclick="javascript:GuardarBusqueda()">
                                <i class="far fa-save"></i> <?php echo $msgstr["savesearch"]?></button>
                            <?php echo $msgstr["r_desc"].": " ?>
                            <input type=text name=Descripcion size=40>
                        </td>
                        <?php
                    }
                    ?>
                </table>
                </td>
                </tr>
                <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
                <tr>  <!-- row 4 sort key -->
                <td><b><?php echo $msgstr["sortkey"]?></b></td>
                <td><?php echo $msgstr["sortkeycopy"]?> :&nbsp;
                    <select name=sort  onChange=CopySortKey()>
                        <option value=''>
                        <?php
                        unset($fp);
                        if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab"))
                            $fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab");
                        else
                            if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab"))
                                $fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab");
                        if (isset($fp)){
                            foreach ($fp as $value){
                                if (trim($value)!=""){
                                    $pp=explode('|',$value);
                                    ?>
                                    <option value="<?php echo trim($pp[1])?>"><?php echo $pp[0]?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select> &nbsp; &nbsp;
                    <?php 
                    if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
                        isset($_SESSION["permiso"]["CENTRAL_EDSORT"]) or
                        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or
                        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EDSORT"])){
                        ?>
                        <button class="bt-green" type="button"
                            title="<?php echo $msgstr["sortkeycreate"]?>"
                            onclick='javascript:CreateSortKey()'>
                            <i class="far fa-plus-square"></i> <?php echo $msgstr["sortkeycreate"]?></button>
                    <?php  }
                    ?>
                    <br>
                    <input type=text name=sortkey size=70>
                </td>
                </tr>
                <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
                <tr>  <!-- row 5 send to -->
                <td style="border-bottom:none">
                    <strong><?php echo $msgstr["sendto"]?></strong>:
                </td>
                <td>
                    <button class="bt-blue" type="button"
                        title="<?php echo $msgstr["vistap"]?>"
                        onclick="javascript:EnviarForma('P')">
                        <i class="far fa-eye"></i> <?php echo $msgstr["vistap"]?></button> &nbsp;
                    <button class="bt-blue" type="button"
                        title="<?php echo $msgstr["word"]?>"
                        onclick="javascript:EnviarForma('WP')">
                        <i class="far fa-file-word"></i> <?php echo $msgstr["word"]?></button> &nbsp;
                    <button class="bt-blue" type="button"
                        title="<?php echo $msgstr["wsproc"]?>"
                        onclick="javascript:EnviarForma('TB')">
                        <i class="far fa-file-excel"></i> <?php echo $msgstr["wsproc"]?></button> &nbsp;
                    <button class="bt-blue" type="button"
                        title="<?php echo $msgstr["pftplain"]?>"
                        onclick="javascript:EnviarForma('TXT')">
                        <i class="far fa-file-alt"></i> <?php echo $msgstr["pftplain"]?></button>
                </td>
            </table>
        </div>
    </td></tr>
    </table>

<?php
/*  End of the tables with collapsing content. */
if (!isset($arrHttp["Modulo"]))
	if ($encabezado=="s")
		echo "&nbsp; &nbsp;<a href=".$backtocancelscript."?Opcion=".$arrHttp["Opcion"]."&base=".$arrHttp["base"].">".$msgstr["cancel"]. "</a><p>";
}else{
    ?>
    <button class="bt-green" type="button"
        title="<?php echo $msgstr["createdb"]?>"
        onclick="javascript:ValidarFormato()">
        <i class="far fa-save"></i> <?php echo $msgstr["createdb"]?> </button>
    <?php
}
?>
    <input type=hidden name=sel_oper>
</form>
<form name=guardar method=post action=pft_update.php>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=pft>
    <input type=hidden name=nombre>
    <input type=hidden name=descripcion>
    <input type=hidden name=tipof>
    <input type=hidden name=headings>
    <input type=hidden name=pftname>
    <input type=hidden name=Modulo value='<?php if (isset($arrHttp["Modulo"])) echo $arrHttp["Modulo"]?>'>
    <input type=hidden name=sel_oper>
    <?php if ($encabezado=="s") echo "<input type=hidden name=encabezado value=s>"; ?>
</form>
<form name=frmdelete action=pft_delete.php method=post>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=pft>
    <?php if ($encabezado=="s") echo "<input type=hidden name=encabezado value=s>"; ?>
</form>
<form name=savesearch action=../dataentry/busqueda_guardar.php method=post target=savesearch>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=Expresion value="">
	<input type=hidden name=Descripcion value="">
</form>
<form name=sortkey method=post action=sortkey_edit.php target=sortkey>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=encabezado value=s>
</form>
</div>
</div>
<?php

if (isset($arrHttp["pft"])and $arrHttp["pft"]!="") {
?> <script>
		xpft='<?php echo $arrHttp["pft"]?>'
		xDesc='<?php echo $arrHttp["desc"]?>'
		document.forma.nombre.value=xpft
		document.forma1.descripcion.value=""
		msgwin=window.open("leertxt.php?base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["cipar"]?>&archivo="+xpft,"editar","menu=no, resizable, scrollbars,width=790")
		msgwin.focus()
	</script>
<?php
}
if ($arrHttp["Opcion"]=="new")
	echo "\n<script>toggleLayer('createformat')\n</script>\n";

include("../common/footer.php");
