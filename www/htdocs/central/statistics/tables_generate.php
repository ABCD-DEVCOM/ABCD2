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
$x=explode('|',$arrHttp["base"]);
$arrHttp["base"]=$x[0];
$date_prefix="";
if (file_exists($db_path."/".$arrHttp["base"]."/def/".$_SESSION["lang"]."/date_prefix.cfg")){	$fp=file($db_path."/".$arrHttp["base"]."/def/".$_SESSION["lang"]."/date_prefix.cfg");
	foreach ($fp as $value){		if (trim($value)!=""){			$date_prefix=trim($value);
			break;		}	}}
unset($fp);
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
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<style type=text/css>

td{	font-size:12px;
	font-family:Arial;}

div#statsgen{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#useextproc{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

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
var strValidChars = "0123456789$";


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
function IsNumeric(data){   	//  test strString consists of valid characters listed above
   	for (i = 0; i < data.length; i++){
    	strChar = data.charAt(i);
    	if (strValidChars.indexOf(strChar) == -1){
    		return false

    	}
    }
    return true}
function Globales(){	var d = new Date();
	var n = d.getFullYear();
	year_from=Trim(document.globales.year_from.value)
	if (year_from==0 || year_from=="" || !IsNumeric(year_from) ) {
		alert("<?php echo $msgstr["inv_date"]?>")
		return
	}
	month_from=Trim(document.globales.month_from.value)
	if (month_from=="" ){

	} else{
		if (month_from<1 || month_from>12 || !IsNumeric(month_from) ) {
			alert("<?php echo $msgstr["inv_date"]?>")
			return
		}
	}
	document.globales.submit()}

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function EnviarForma(Desde){
	switch (Desde){
		case 1:
			var d = new Date();
			var n = d.getFullYear();
			year_from=Trim(document.forma1.year_from.value)
			//year_to=Trim(document.forma1.year_to.value)
			if (year_from==0 || year_from=="" || !IsNumeric(year_from) ) {				alert("<?php echo $msgstr["inv_date"]?>")
				return			}
			//if (year_to < year_from){			//	alert("<?php echo $msgstr["inv_date"]?>")
			//	return			//}
			month_from=Trim(document.forma1.month_from.value)
			//month_to=Trim(document.forma1.month_to.value)
			if (month_from=="" ){			} else{				if (month_from<1 || month_from>12 || !IsNumeric(month_from) ) {
					alert("<?php echo $msgstr["inv_date"]?>")
					return
				}			}
            document.forma1.Opcion.value="FECHAS"
			break
		case 2:
			de=Trim(document.forma1.Mfn.value)
  			a=Trim(document.forma1.to.value)
  			Se=""
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
			document.forma1.Opcion.value="MFN"
			break
		case 3:
			if (Trim(document.forma1.Expresion.value)==""){
				alert("<?php echo $msgstr["selreg"]?>")
				return
			}
			document.forma1.Opcion.value="BUSQUEDA"
			break
	}
    if (document.forma1.proc.selectedIndex<1 && document.forma1.tables.selectedIndex<1 && document.forma1.rows.selectedIndex<1 && document.forma1.cols.selectedIndex<1){
	  	alert("<?php echo $msgstr["seltab"]?>")
	  	return
	}
	i=0
	if (document.forma1.proc.selectedIndex>0 ){
		document.forma1.Accion.value="Procesos"		i=i+1
	}
	if (document.forma1.tables.selectedIndex>0 ){		document.forma1.Accion.value="Tablas"		i=i+1
	}
    if ( document.forma1.rows.selectedIndex>0 || document.forma1.cols.selectedIndex>0){
    	document.forma1.Accion.value="Variables"    	i=i+1    }
    if (i>1){    	alert("<?php echo $msgstr["seltab"]?>")
	  	return    }
	document.forma1.submit();
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
  	Url="../dataentry/buscar.php?Opcion=formab&Target=s&Tabla=Expresion&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}
function Probar(){	alert("entro")}

function Configure(Option){
	if (document.configure.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "stats_gen":
			document.configure.action="stats_gen_cfg.php"
			break
		case "stats_var":
			document.configure.action="config_vars.php"
			break
		case "stats_tab":
			document.configure.action="tables_cfg.php"
			break
		case "stats_proc":
			document.configure.action="proc_cfg.php"
			break
		case "stats_pft":
			document.configure.action="config_tables.php"
			break
		case "date_prefix":
			document.forma1.date_prefix.style="border: 1px solid red;"
			document.forma1.date_prefix.focus()
			document.forma1.date_prefix.onclick=null
			Ctrl=document.getElementById("label_dp")
			if (Ctrl.innerHTML=="<?php echo $msgstr['save']?>"){
				date_prefix=document.forma1.date_prefix.value
				date_prefix=Trim(date_prefix)
				if (date_prefix==""){					alert("<?php echo $msgstr['miss_dp']?>")
					return				}
				base="<?php echo $arrHttp["base"]?>"				msgwin=window.open("date_prefix_update.php?date_prefix="+date_prefix+"&base="+base,"dp","width=300,height=100")
				Ctrl.innerHTML="<?php echo $msgstr['change']?>"
				document.forma1.date_prefix.style="border: 0px solid white;"

				document.forma1.date_prefix.blur()
				document.forma1.date_prefix.onclick= function (){document.forma1.date_prefix.blur()}
				return			}
			Ctrl.innerHTML="<?php echo $msgstr['save']?>"
			return
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
<a href=http://abcdwiki.net/wiki/es/index.php?title=Estad%C3%ADsticas target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<font color=white>&nbsp; &nbsp; Script: tables_generate.php</font>
</div>



<div class="middle form">

	<div class="formContent">
  <?php
  if (file_exists($db_path."proc_gen.cfg")){ ?>
		<div id=statsgen>
			<strong><?php echo "<h2>".$msgstr["gen_output"]."</h2>"?></strong><hr>
			<form name=globales action=stats_gen_ex.php method=post onsubmit="Globales();return false">
			<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
		<?php
        if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
		echo "<strong>".$msgstr["stats_gen"]."</strong>: ";
		echo $msgstr["year"]?> <input type=text name=year_from size=5 value="">&nbsp; &nbsp;
		<?php echo $msgstr["month"]?> <input type=text name=month_from size=2 value="">&nbsp; &nbsp;
		<input type=submit value="<?php echo $msgstr["send"]?>"> <br>
		<?php
		$fp=file($db_path."proc_gen.cfg");
		foreach ($fp as $value) {			echo str_replace('$$',': ',$value."<br>");		}		unset($fp);
    ?>
		</form>
<?php }?>
		<form name=forma1 method=post action=tables_generate_ex.php onsubmit="Javascript:return false">
		<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";?>
		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
		<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
		<input type=hidden name=Opcion>
		<input type=hidden name=Accion>
<?php

//USAR UN PROCESO PRE-DEFINIDO

	echo "<table width=600 border=0  class=listTable>
			<tr>
			<td align=left   valign=center bgcolor=#ffffff><h2><i>".$arrHttp["base"]."</i></h2>
    		&nbsp; <A HREF=\"javascript:toggleLayer('useextproc')\"> <u><strong>". $msgstr["exist_proc"]."</strong></u></a>
    		<div id=useextproc><br>
    		"."<select name=proc  style=\"width:300px\">
    		<option value=''>";
    unset($fp);
	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/proc.cfg";
	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/proc.cfg";
	if (!file_exists($file)){
		$error="S";
	}else{
		$fp=file($file);
		$fields="";
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('||',$value);
				echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
			}
		}
	}
?>
			</select>

		</div>

	</td>
</table>
<p>
<?php
//USAR UNA TABLA YA EXISTENTE
	echo "<table width=600 border=0  class=listTable>
			<tr>
			<td align=left   valign=center bgcolor=#ffffff>
    		&nbsp; <A HREF=\"javascript:toggleLayer('useextable')\"> <u><strong>". $msgstr["exist_tb"]."</strong></u></a>
    		<div id=useextable>
    		<select name=tables  style=\"width:300\">
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
	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tables.cfg";
	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tables.cfg";
	if (!file_exists($file)){
		$error="S";
	}else{
		$fp=file($file);
		$fields="";
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				echo "<option value=\"".$value.'{{PFT'."\">".trim($t[0])."</option>";
			}
		}
	}
?>
			</select>
		</div>
	</td>
</table>
<p>
<!-- CONSTRUIR UNA TABLA SELECCIONANDO FILAS Y COLUMNAS  -->
<table border=0 width=600 class=listTable>
	<tr>
		<td valign=top width=600 align=left bgcolor=#ffffff>
		&nbsp; <A HREF="javascript:toggleLayer('createtable')"><u><strong><?php echo $msgstr["create_tb"]?></strong></u></a>
    	<div id=createtable>
    	<table width=600>
    		<td>
    			<strong><?php echo $msgstr["rows"]?></strong><br>
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
				</select>
			</td>
			<td bgcolor=#ffffff>
				<strong><?php echo $msgstr["cols"]?></strong><br>
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
 </div>
</td>
</table>
<p>
<!-- SELECCION DE LOS REGISTROS  -->
<table width=600 class=listTable>
	<tr>
		<td bgcolor=white>
			&nbsp; <A HREF="javascript:toggleLayer('generate')"><u><strong><?php echo $msgstr["r_recsel"]?></strong></u></a>
    		<div id=generate><p>
    		<table>
    <tr>
    	<td  align=center bgcolor=#eeeeee><strong><?php echo $msgstr["bydate"]?></strong></td><td>
    	<div id=date_prefix>
    	<strong>
    	<?php
			echo $msgstr["date_pref"].": $date_prefix";

		?>
		</strong>
		</div>
    	</td>
    </tr>
    <tr>
		<td></td><td width=30% align=right>
		<?php echo $msgstr["year"]?> <input type=text name=year_from size=5 value="">&nbsp; &nbsp;
		<?php echo $msgstr["month"]?> <input type=text name=month_from size=2 value="">&nbsp; &nbsp;


		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<input type=submit value="<?php echo $msgstr["send"]?>" onclick=EnviarForma(1)>
		&nbsp; &nbsp;

		</td>
    <tr>
		<td  align=center colspan=2 bgcolor=#eeeeee><strong><?php echo $msgstr["bymfn"]?></strong></td>
	<tr>
		<td width=30% align=right><strong><?php echo $msgstr["from"]?></strong>: <input type=text name=Mfn size=10 value="">&nbsp; &nbsp; </td>
		<td width=70%><strong><?php echo $msgstr["to"]?></strong>: <input type=text name=to size=10 value="">
		<?php echo $msgstr["maxmfn"].": ".$tag["MAXMFN"]?>
		&nbsp; &nbsp;
		<input type=submit value="<?php echo $msgstr["send"]?>" onclick=EnviarForma(2)>
		</td>
	<tr>
		<td  align=center colspan=2 bgcolor=#eeeeee><strong><?php echo $msgstr["bysearch"]?></strong></td>
	<tr>

		<td colspan=2 >
			<table>
				<td><a href=javascript:Buscar()><img src=../dataentry/img/toolbarSearch.png height=24 align=middle border=0 alt=""></a></td>
				<td><textarea rows=2 cols=100 name=Expresion><?php if (isset($Expresion )) echo $Expresion?></textarea>

					<a href=javascript:BorrarExpresion() class=boton><?php echo $msgstr["clear"]?></a></td>
				<td colspan=2 width=100% align=center>
                &nbsp; &nbsp;
		<input type=submit value="<?php echo $msgstr["send"]?>" onclick=EnviarForma(3)>
		</td>

		</tr>
			</table>
		</td>
	<tr>

</table>
</div>
</td>
<?php
if (isset($_SESSION["permiso"]["CENTRAL_STATCONF"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){?>
<tr>
	<td align=left   valign=center bgcolor=#ffffff><hr><p>
    	&nbsp; <A HREF="javascript:toggleLayer('configure')"> <font color=black><strong><?php echo "<h2>".$msgstr["stats_conf"]."</h2>"?></strong></font></a>
    	<div id=configure>
    	<ul>
    		<li><a href=javascript:Configure("stats_var")><?php echo $msgstr["var_list"]?></a></li>
            <li><a href=javascript:Configure("stats_pft")><?php echo $msgstr["def_pre_tabs"]?></a></li>
            <li><a href=javascript:Configure("stats_tab")><?php echo $msgstr["tab_list"]?></a></li>
            <li><a href=javascript:Configure("stats_proc")><?php echo $msgstr["exist_proc"]?></a></li>
            <li><a href=javascript:Configure("stats_gen")><?php echo $msgstr["stats_gen"]?></a><p></li>
            <li>
            <?php
			echo $msgstr["date_pref"].": <input type=text name=date_prefix size=5 style='border:0px white;' onclick=javascript:blur() value=$date_prefix> ";
			echo "<a href=javascript:Configure('date_prefix')><div id=label_dp style='display:inline;clear:both'>".$msgstr["change"]."</div></a>";
			?>
			</li>
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
