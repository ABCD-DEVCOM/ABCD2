<?php
/*
202202216 fho4abcd backbutton,div-helper
*/
// ==================================================================================================
// GENERA LOS CUADROS ESTADÍSTICOS
// ==================================================================================================
//
session_start();
include("../common/get_post.php");
include ("../config.php");
include ("../lang/statistics.php");
include ("../lang/admin.php");

//HEADER DEL LA PÁGINA HTML Y ARCHIVOS DE ESTIVO
include("../common/header.php");
//

//foreach ($_REQUEST as $var=>$value) echo "$var=>".urldecode($value)."<br>";
//die;
?>
<body>
<?php
include("tables_generate_inc.php");

if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}

if (isset($arrHttp["tables"]))  $arrHttp["tables"]=urldecode($arrHttp["tables"]);
if (isset($arrHttp["rows"]))  $arrHttp["rows"]=urldecode($arrHttp["rows"]);
if (isset($arrHttp["cols"]))  $arrHttp["cols"]=urldecode($arrHttp["cols"]);

// SELECCION DE LOS REGISTROS]

if (isset($arrHttp["Expresion"]))
	$Opcion="search";
else
	$Opcion="range";

//TOOLBAR O PÁGINA COMPLETA?
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";

//SE LEE LA LISTA DE VARIABLES
$tab_vars=LeerVariables($db_path,$arrHttp,$lang_db);

$Pie="";

$Formato=ConstruirFormato($arrHttp,$lang_db,$tab_vars,$db_path);
//echo $Formato."<p>";  //die;
?>
<script>
//PARA AGREGAR NUEVAS VARIABLES A LA LISTA
function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function SendTo(Opcion){

	switch(Opcion){
		default:
			if (Opcion=="P"){
				msgwin=window.open("","STATS","")
				msgwin.focus()
			}else{
				document.sendto.target=""
			}
			seccion=returnObjById( "results" )
			html=seccion.innerHTML
			document.sendto.html.value=html
			document.sendto.Opcion.value=Opcion
			document.sendto.submit()
			if (Opcion=="P") msgwin.focus()
	}
}
</script>

<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["stats"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
        <?php
        $backtoscript="tables_generate.php";
        include "../common/inc_back.php";
        include "../common/inc_home.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<form name=forma1 method=post onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>

<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
?>
<div class="middle form">
	<div class="formContent">

<dd><?php echo $msgstr["sendto"].": ";?>
<a href='javascript:SendTo("W")'><?php echo $msgstr["wks"];?></a> &nbsp; | &nbsp;
<a href='javascript:SendTo("D")'><?php echo $msgstr["doc"];?></a> &nbsp; | &nbsp;
<a href='javascript:SendTo("P")'><?php echo $msgstr["prn"];?></a> &nbsp; | &nbsp;
<div id=results>

<script>Pie="<?php echo $Pie;?>"</script>
<?php
$tab=array();
$total_r=0;
$total_c=0;
$contenido=SeleccionarRegistros($arrHttp,$db_path,$Formato,$xWxis);
//foreach ($contenido as $value)  echo "$value<br>"; die;
LeerRegistros($contenido);
//TABLAS
//echo "<pre>";print_r($tabs); echo "</pre>";
//echo "<pre>";print_r($tab); echo "</pre>";
ConstruirSalida($tab,$tabs,$tipo,$rows,$cols);

?>
</div></div>
<dd><?php echo $msgstr["sendto"].": ";?>
<a href='javascript:SendTo("W")'><?php echo $msgstr["wks"];?></a> &nbsp; | &nbsp;
<a href='javascript:SendTo("D")'><?php echo $msgstr["doc"];?></a> &nbsp; | &nbsp;
<a href='javascript:SendTo("P")'><?php echo $msgstr["prn"];?></a> &nbsp; | &nbsp;
<?php
//if (!isset($arrHttp["proc"]))echo "<a href=javascript:SendTo(\"AG\")>".$msgstr["ag"]."</a> &nbsp; | &nbsp; ";
//echo "<a href=javascript:SendTo(\"NAG\")>".$msgstr["nag"]."</a> &nbsp; | &nbsp; ";
?>
<p>
</div>
</form>

<!-- FORMA PARA ENVIAR LA SALIDA A UNA HOJA DE CALCULO O A UN DOCUMENTO-->
<form name=sendto action=sendto.php method=post target="STATS">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=html>
<input type=hidden name=Opcion>
<?php
if (isset($arrHttp["Expresion"]))
	echo "<input type=hidden name=Expresion value=\"".urlencode($arrHttp["Expresion"])."\">\n";
if (isset($arrHttp["tables"]))
	echo "<input type=hidden name=tables value=\"".urlencode($arrHttp["tables"])."\">\n";
if (isset($arrHttp["cols"]))
	echo "<input type=hidden name=cols value=\"".urlencode($arrHttp["cols"])."\">\n";
if (isset($arrHttp["rows"]))
	echo "<input type=hidden name=rows value=\"".urlencode($arrHttp["rows"])."\">\n";
if (isset($arrHttp["tables"]))
	echo "<input type=hidden name=tables value=\"".urlencode($arrHttp["tables"])."\">\n";
if (isset($arrHttp["Mfn"]))
	echo "<input type=hidden name=from value=\"".$arrHttp["Mfn"]."\">\n";
if (isset($arrHttp["to"]))
	echo "<input type=hidden name=tables value=\"".$arrHttp["Mfn"]."\">\n";
echo "</form>";
//PIE DE PAGINA
include("../common/footer.php");
?>
