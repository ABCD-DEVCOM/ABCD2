<?php
// ==================================================================================================
// GENERA LOS CUADROS ESTADÍSTICOS
// ==================================================================================================
//

session_start();
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/statistics.php");

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";

//SE EXTRAE EL NOMBRE DE LA BASE DE DATOS
if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";

// SE LEE EL MÁXIMO MFN DE LA BASE DE DATOS
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
include("../common/wxis_llamar.php");
$ix=-1;
foreach($contenido as $linea) {
	$ix++;
	if ($ix>1) {
		if (trim($linea)!=""){
	   		$a=explode(":",$linea);
	   		$tag[$a[0]]=$a[1];
	  	}
	}
}


//HEADER DEL LA PÁGINA HTML Y ARCHIVOS DE ESTIVO
include("../common/header.php");
?>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<style type=text/css>

td{	font-size:12px;
	font-family:Arial;}

div#useextable{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#createtable{<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#generate{
	display: none;
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

div#configure{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script languaje=javascript>

TipoFormato=""
C_Tag=Array()



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

	switch (whichLayer){		case "createtable":
<?php		echo '
			EsconderVentana("useextable")
			break
			';

?>
		case "useextable":
			EsconderVentana("createtable")
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

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function EnviarForma(){
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
    			alert("<?php echo $msgstr["inv_mfn"]?>")
	    		return
    		}
    	}
    	for (i = 0; i < a.length; i++){
    		strChar = a.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["inv_mfn"]?>")
	    		return
    		}
    	}
    	de=Number(de)
    	a=Number(a)
    	if (de<=0 || a<=0 || de>a ||a><?php echo $tag["MAXMFN"]?>){
	    	alert("<?php echo $msgstr["inv_mfn"]?>")
	    	return
		}
	}
    if (Trim(document.forma1.Expresion.value)=="" && (Trim(document.forma1.Mfn.value)=="" )){
		alert("<?php echo $msgstr["selreg"]?>")
		return
	}
	if (Trim(document.forma1.Expresion.value)!="" && (Trim(document.forma1.Mfn.value)!="" )){
		alert("<?php echo $msgstr["selreg"]?>")
		return
	}
	if (document.forma1.tables.selectedIndex>0 ){		if (document.forma1.rows.selectedIndex>0 || document.forma1.cols.selectedIndex>0){			alert("<?php echo $msgstr["seltab"]?>")
			return		}
	}
	if (document.forma1.tables.selectedIndex || document.forma1.rows.selectedIndex>0 || document.forma1.cols.selectedIndex>0){
	  	document.forma1.submit()
	  	return
	}
	document.forma1.submit();
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
  	Url="../dataentry/buscar.php?Opcion=formab&Target=s&Tabla=Expresion&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}

function Configure(Option){
	if (document.configure.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "stats_var":
			document.configure.action="config_vars.php"
			break
		case "stats_tab":
			document.configure.action="tables_cfg.php"
			break
	}
	document.configure.submit()
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
<?php echo $msgstr["stats"].": ".$arrHttp["base"]?>
	</div>

	<div class="actions">
<?php
if (isset($arrHttp["encabezado"]))
	echo "<a href=\"../common/inicio.php?reinicio=S&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
<span><strong>".$msgstr["back"]."</strong></span></a>
	";
?>

</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/stats/stats_tables_generate.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/stats/stats_tables_generate.html target=_blank>".$msgstr["edhlp"]."</a>";
?>
<font color=white>&nbsp; &nbsp; Script: tables_generate.php</font>
</div>
<form name=forma1 method=post action=tables_generate_ex.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Opcion>

<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
?>
<div class="middle form">
	<div class="formContent">

<?php
//USAR UNA TABLA YA EXISTENTE
	echo "<table width=600 border=0  class=listTable>
			<tr>
			<td align=left   valign=center bgcolor=#ffffff>
    		&nbsp; <A HREF=\"javascript:toggleLayer('useextable')\"> <u><strong>". $msgstr["exist_tb"]."</strong></u></a>
    		<div id=useextable>
    		<br>".$msgstr["tab_list"].": <select name=tables  style=\"width:300\">
    		<option value=''>";
    unset($fp);
	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tabs.cfg";
	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
	if (!file_exists($file)){
		$error="S";
	}else{
		$fp=file($file);
		$fields="";
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
			}
		}
	}
?>
			</select>
			<p>
		</div>
	</td>
</table>
<br>

<!-- CONSTRUIR UNA TABLA SELECCIONANDO FILAS Y COLUMNAS  -->
<table border=0 width=600 class=listTable>
	<tr>
		<td valign=top width=600 align=left bgcolor=#ffffff>
		&nbsp; <A HREF="javascript:toggleLayer('createtable')"><u><strong><?php echo $msgstr["create_tb"]?></strong></u></a>
    	<div id=createtable>
    	<table width=600>
    		<td>
    		<P><strong><?php echo $msgstr["rows"]?></strong><br>
			<table width=300 border=0 >
				<td align=right width=250>
				<Select name=rows style="width:250px">
				<option value=""></option>

 <?php
 	unset($fp);
	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/stat.cfg";
	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
	if (!file_exists($file)){
		$error="S";
	}else{
		$fp=file($file);
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
			}
		}
	}
?>
				</select></td>
			</table>
			</td>
			<td bgcolor=#ffffff>
			<P><strong><?php echo $msgstr["cols"]?></strong><br>
			<table width=300 border=0 >
				<td align=right width=250>
				<Select name=cols style="width:250px">
				<option value=""></option>

 <?php
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				echo "<option value=\"".$value."\">".trim($t[0])."</option>";
			}
		}
?>
				</select>
				</td>
			</table>
		</td>
	</table>
 </div>
</td>
</table>
<p>

<!-- SELECCION DE LOS REGISTROS  -->
<table width=600 class=listTable>
	<tr>
		<td bgcolor=white>
			&nbsp; <A HREF="javascript:toggleLayer('generate')"><u><strong><?php echo $msgstr["gen_output"]?></strong></u></a>
    		<div id=generate><p>
    		<table>
    <tr>
		<td  align=center colspan=2 bgcolor=#eeeeee><strong><?php echo $msgstr["bymfn"]?></strong></td>
	<tr>
		<td width=50% align=right><?php echo $msgstr["from"]?>: <input type=text name=Mfn size=10 value=1>&nbsp; &nbsp; </td>
		<td width=50%><?php echo $msgstr["to"]?>: <input type=text name=to size=10 value=<?php echo $tag["MAXMFN"]?>>
		 <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["clear"]?></a> (
		<?php echo $msgstr["maxmfn"].": ".$tag["MAXMFN"]?>)</td>
	<tr>
		<td  align=center colspan=2 bgcolor=#eeeeee><strong><?php echo $msgstr["bysearch"]?></strong></td>
	<tr>

		<td colspan=2 >
			<table>
				<td><a href=javascript:Buscar()><img src=../dataentry/img/toolbarSearch.png height=24 align=middle border=0 alt=""></a></td>
				<td><textarea rows=2 cols=100 name=Expresion><?php if (isset($Expresion )) echo $Expresion?></textarea>

					<a href=javascript:BorrarExpresion() class=boton><?php echo $msgstr["clear"]?></a></td>
				<td colspan=2 width=100% align=center>
			<input type=submit value="<?php echo $msgstr["send"]?>" onclick=EnviarForma()>
		</td>
			</table>
		</td>
	<tr>

</table>
</div>
</td>
<?php
if (isset($_SESSION["permiso"]["CENTRAL_STATCONF"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){?>
<tr>
	<td align=left   valign=center bgcolor=#ffffff><p>
    	&nbsp; <A HREF="javascript:toggleLayer('configure')"> <u><strong><?php echo $msgstr["stats_conf"]?></strong></u></a>
    	<div id=configure>
    	<ul>
    		<li><a href=javascript:Configure("stats_var")><?php echo $msgstr["var_list"]?></a></li>
            <li><a href=javascript:Configure("stats_tab")><?php echo $msgstr["tab_list"]?></a></li>
    	</ul>
    	</div>
    </td>
<?php } ?>
</table>

</div>
</div>
</center>
</form>
<form name=configure onSubmit="return false">
	<input type=hidden name=Opcion value=update>
	<input type=hidden name=from value="statistics">
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>
</form>
<?php
include("../common/footer.php");
?>
</body>
</html>
