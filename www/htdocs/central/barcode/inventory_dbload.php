<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");



include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
include ("configure.php");
?>
<style>
#overlay {
    position: absolute;
    top:0px;
    left:0;
    bottom:0px;
    right:0;
    width:100%;
    height:100%;
    z-index:998;
    background-color: Black;
    opacity: .5;
    display:none;
}

#popup {
    position: absolute;
    top:200px;
    width:100%;
    height:200px;
    background-color:#8DA5C6;
    z-index: 999;
    display:none;
}

</style>
<script>
	function Continuar(){		var division = document.getElementById("overlay");
		division.style.display="block"
		var division = document.getElementById("popup");
		division.style.display="block"
		document.forma1.Opcion.value='OK'
		document.forma1.submit()	}
</script>
<?php

function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}

function LeerConfiguracion($base){
global $db_path;	$fp=file($db_path.$base."/pfts/".$_SESSION["lang"]."/inventory.conf");
	if ($fp){
		foreach ($fp as $conf){
			$conf=trim($conf);
			if ($conf!=""){
				$a=explode('=',$conf,2);
				$bar_c[$a[0]]=$a[1];
			}
		}
	}
	return($bar_c);}

function Configurar($base,$bar_c){
global $msgstr,$arrHttp;
	echo "<h4>".$msgstr["inventory_configure"]."</h4>";	echo "<dd><dd><table bgcolor=#cccccc cellpadding=10>";
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["classification_number_format"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_classification_number_format cols=100 rows=2>";
	if (isset($bar_c["classification_number_format"])) echo $bar_c["classification_number_format"];
	echo "</textarea></td></tr>\n";
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["inventory_number_format"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_inventory_number_format cols=100 rows=2>";
	if (isset($bar_c["inventory_number_format"])) echo $bar_c["inventory_number_format"];
	echo "</textarea></td></tr>\n";
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["inventory_title"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_inventory_title_format cols=100 rows=1>";
	if (isset($bar_c["inventory_title_format"])) echo $bar_c["inventory_title_format"];
	echo "</textarea></td></tr>\n";
	echo "</textarea></td></tr>\n";
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["inventory_control"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_inventory_control_format cols=100 rows=1>";
	if (isset($bar_c["inventory_control_format"])) echo $bar_c["inventory_control_format"];
	echo "</textarea></td></tr>\n";
	echo "</table>";
	echo "<input type=submit name=Actualizar value=Actualizar onclick=document.forma1.Opcion.value='actualizar'>\n";
}

function Ask_Confirmation(){global $arrHttp;
	echo "<div style='margin: 20px 40px 10px 200px; width:400px '>";
	echo "Este proceso carga el inventario desde la base de datos ".$arrHttp["base"]." y los pasa a la base de datos de inventario (abcd_inventory)\n";
	echo "";
	echo "<p>";
	echo "<a href=inventory_dbload.php?base=".$arrHttp["base"]."&Opcion=configurar>Configurar la captura de informacion de la base catalográfica</a><p>";
	echo "<input type=submit value=continuar onclick=Continuar()>";
	echo "</div>";
}

function GenerarInventario($base){
global $db_path,$mx_path;

	echo "Leyendo la base de datos bibliográfica para extraer los datos requeridos para el inventario<p>";
	echo date("Ymd h:i:s")."<p>";
	$IsisScript="administrar.xis";
	$query = "&base=".$base . "&cipar=$db_path"."par/".$base.".par&Opcion=status";
    $contenido=WxisLlamar($IsisScript,$base,$query);
    $ix=-1;
    foreach($contenido as $linea) {
		$ix=$ix+1;
		if ($ix>0) {
			if (trim($linea)!=""){
		   		$a=explode(":",$linea);
		   		if (isset($a[1])) $tag[$a[0]]=$a[1];
		  	}
		}
	}
	$MaxMfn=$tag["MAXMFN"];
	echo "Total registros a procesar: $MaxMfn<p>";
	flush();
    ob_flush();
    $bar_c=LeerConfiguracion($base);
    $Pft="";
    if (isset($bar_c["inventory_number_format"]))
    	$Pft="(".$bar_c["inventory_number_format"]."'$$$')";
    $Pft.="'|'";
    if (isset($bar_c["classification_number_format"]))
    	$Pft.=$bar_c["classification_number_format"];
    $Pft.="'|'";
    if (isset($bar_c["inventory_title_format"]))
    	$Pft.=$bar_c["inventory_title_format"];
    $Pft.="/";
	$IsisScript="leer_mfnrange.xis";
	$Fecha=date("Ymd");
	$query="&base=$base&cipar=$db_path"."par/$base.par&Pft=".$Pft."&from=1&to=$MaxMfn";
	$contenido=WxisLlamar($IsisScript,$base,$query);
	$fp=fopen($db_path."wrk/".$base.".txt","w");
	foreach ($contenido as $value){
		$value=trim($value);
		if ($value!=""){
			$ValorCapturado="";			$a=explode('|',$value);
			$VC="";
			if (trim($a[1])!="") $VC.=$a[1];
			$VC.="|";
			if (trim($a[2])!="") $VC.=$a[2];
			$VC.="|";
			$VC.=$Fecha."|";
			if (trim($a[0])!=""){				$b=explode('$$$',$a[0]);
				foreach ($b as $item){					$item=trim($item);					if ($item!=""){						$ValorCapturado=$VC.$item."\r\n" ;
						fwrite($fp,$ValorCapturado);
					}				}			}		}
	}
	fclose($fp);

	echo "<p>".date("Ymd h:i:s");
    echo "<h4>Fin de la lectura dela base de datos catalográfica. Comienzo de la creación de abcd_inventory</h4>\n";
    $fp = fopen($db_path."wrk/".$base.".prc", "w");
	if (!$fp){
   		echo "Unable to write the file ".$db_path."/wrk/$base.prc";
   		exit;
 	}
	$savestring="'d*',
	'<10>'v1'</10>',
	'<15>'v2'</15>',
	'<40>'v3'</40>',
	'<30>'v4'</30>',
	";
	fwrite($fp,$savestring);
	fclose($fp);
	$mx=$mx_path." seq=".$db_path."wrk/biblo.txt proc=@".$db_path."wrk/$base.prc append=".$db_path."abcd_inventory/data/abcd_inventory now -all";
	echo $mx;
	exec($mx,$outmx,$banderamx);
	echo $outmx."<br>".$banderamx;
	echo "<p>".date("Ymd h:i:s")."<p>";

}
?>
<body>

<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
$ayuda="inventory.html";
?>
<div id="overlay"></div>
<div id="popup"><center><h1>Procesando su requerimiento ...<br>Espere por favor</center></div>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["inventory_dbload"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"menu.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp;<a href=\"http://abcdwiki.net/wiki/es/index.php?title=Inventory\" target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode/inventory_dbinit.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<form name=forma1 method=post>
<input type=hidden name=ok value="">
<input type=hidden name=Opcion value="">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
if (!file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/inventory.conf") and $arrHttp["Opcion"]!="actualizar" ){	Configurar($arrHttp["base"],$bar_c);}else{
	switch ($arrHttp["Opcion"]){		case "actualizar":
			$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/inventory.conf","w");
			foreach ($arrHttp as $key=>$conf){
				if (substr($key,0,4)=="tag_"){
					$key=substr($key,4);
					fwrite($fp,"$key=$conf"."\n");
				}
			}
			fclose($fp);
			Ask_Confirmation();
			break;
		case "configurar":
			$bar_c=LeerConfiguracion($arrHttp["base"]);
			Configurar($arrHttp["base"],$bar_c);
			break;
		case "OK":
			GenerarInventario($arrHttp["base"]);
			break;
		case "inicio":
	        Ask_Confirmation();
	}
}

?>
</form>
	</div>
</div>
<?php
Include("../common/footer.php");
?>
</Body>
</Html>
