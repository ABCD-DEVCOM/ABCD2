<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
$arrHttp["tipo"]="inventory";
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");



include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
include ("configure.php");
$bar_c=array();
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
    background-color: #FFFFFF;
    opacity: .5;
    display:none;
}

#popup {
    position: absolute;
    top:200px;
    width:100%;
    height:200px;
    background-color:#FFFFFF;
    z-index: 999;
    display:none;
}

</style>
<script>
	function Continuar(){		document.forma1.Opcion.value='OK'
		document.forma1.submit()	}
	function Comenzar(){
		var division = document.getElementById("overlay");
		division.style.display="block"
		var division = document.getElementById("popup");
		division.style.display="block"
	}
	function Finalizar(){		var division = document.getElementById("overlay");
		division.style.display="none"
		var division = document.getElementById("popup");
		division.style.display="none"
		alert("<?php echo $msgstr["end_process"]?>")	}
</script>
<?php

function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}

function LeerConfiguracion($base){
global $db_path;
	$bar_c=array();	$fp=file($db_path.$base."/pfts/".$_SESSION["lang"]."/inventory.conf");
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
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["inventory_type_record"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_inventory_type_record cols=100 rows=4>";
	if (isset($bar_c["inventory_type_record"])) echo $bar_c["inventory_type_record"];
	echo "</textarea></td></tr>\n";
	echo "<tr>";
	echo "<td bgcolor=white width=100>".$msgstr["inventory_item_info"]."</td>";
	echo "<td bgcolor=white><textarea name=tag_inventory_item_info cols=100>";
	if (isset($bar_c["inventory_item_info"])) echo $bar_c["inventory_item_info"];
	echo "</textarea></td></tr>\n";
	echo "</table>";
	echo "<input type=submit name=Actualizar value=Actualizar onclick=document.forma1.Opcion.value='actualizar'>\n";
}

function Ask_Confirmation(){global $arrHttp;
	echo "<div style='margin: 20px 40px 10px 200px; width:400px '>";
	echo "Este proceso carga el inventario desde la base de datos ".$arrHttp["base"]." y los pasa a la base de datos de inventario (abcd_inventory)\n";
	echo "<p>Lee todos los registros de la base de datos ".$arrHttp["base"]." y por cada ocurrencia del campo repetible de inventario crea un registro en la base de datos de inventario (abcd_inventory)\n";;
	echo "<p>Puede tardar varios minutos dependiendo del número de registros de la base de datos ".$arrHttp["base"]." y del número de items del inventario.";
	echo "<p>";
	echo "<a href=inventory_dbload.php?base=".$arrHttp["base"]."&Opcion=configurar>Configurar la captura de informacion de la base catalográfica</a><p>";
	echo "<input type=submit value=continuar onclick=Continuar()>";
	echo "</div>";
}

function GenerarInventario($base){
global $db_path,$mx_path;

	echo "Leyendo la base de datos $base para extraer los datos requeridos para el inventario<p>";
	echo date("d-m-Y h:i:s")."<p>";
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
    	$Pft="(".$bar_c["inventory_number_format"]."'##'".$bar_c["inventory_item_info"]."'$$$')";
    $Pft.="'|'";
    if (isset($bar_c["classification_number_format"]))
    	$Pft.=$bar_c["classification_number_format"];
    $Pft.="'|'";
    if (isset($bar_c["inventory_title_format"]))
    	$Pft.=$bar_c["inventory_title_format"];
    $Pft.="'|'";
    if (isset($bar_c["inventory_title_format"]))
    	$Pft.=$bar_c["inventory_type_record"];
    $Pft.="/";
	$IsisScript="leer_mfnrange.xis";
	$Fecha=date("Ymd");
	$cuenta=1000;
	$from=1;
	$to=-1;
	$fp=fopen($db_path."wrk/".$base.".txt","w");
	echo "\n<script>Comenzar()</script>\n";
	flush();
    ob_flush();
	while ($from<=$MaxMfn){		$to=$from+1000-1;
		if ($to>$MaxMfn) $to=$MaxMfn;
		echo "Leyendo registro desde $from hasta $to<br>";
		flush();
    	ob_flush();
		$query="&base=$base&cipar=$db_path"."par/$base.par&Pft=".$Pft."&from=$from&to=$to";
		$contenido=WxisLlamar($IsisScript,$base,$query);
		foreach ($contenido as $value){
			$value=trim($value);
			if ($value!=""){
				$ValorCapturado="";				$a=explode('|',$value);
				if (trim($a[0])!=""){
					$VC="";
					if (trim($a[1])!="") $VC.=$a[1];
					$VC.="|";
					if (trim($a[2])!="") $VC.=$a[2];
					$VC.="|";
					if (trim($a[3])!="") $VC.=$a[3];
					$VC.="|";
					$VC.=$Fecha;
					$VC.="|";
					if (trim($a[0])!=""){						$b=explode('$$$',$a[0]);
						foreach ($b as $item){							$item=trim($item);							if ($item!=""){
								$it=explode('##',$item);
								if (trim($it[0])!=""){									$ValorCapturado=$VC.$it[0];
									$ValorCapturado.='|';
									if (isset($it[1])) $ValorCapturado.=$it[1];
									$ValorCapturado.="\r\n";
									fwrite($fp,$ValorCapturado);
								}
							}						}					}
				}			}
		}
		$from=$to+1;
	}
	fclose($fp);

	echo "<p>".date("d-m-Y h:i:s");
    echo "<h4>Fin de la lectura dela base de datos catalográfica. Comienzo de la creación de abcd_inventory</h4>\n";
    $fp = fopen($db_path."wrk/".$base.".prc", "w");
	if (!$fp){
   		echo "Unable to write the file ".$db_path."/wrk/$base.prc";
   		exit;
 	}
	$savestring="'d*',
	'<10>'v1'</10>',
	'<15>'v2'</15>',
	'<1>'v3'</1>',
	'<40>'v4'</40>',
	'<30>'v5'</30>',
	'<120>'v6'</120>',
	";
	fwrite($fp,$savestring);
	fclose($fp);
	$mx=$mx_path." seq=".$db_path."wrk/biblo.txt proc=@".$db_path."wrk/$base.prc append=".$db_path."abcd_inventory/data/abcd_inventory now -all";
	echo $mx;
	exec($mx,$outmx,$banderamx);
	echo "<p>";
	foreach ($outmx as $value) echo "$value<br>";
	echo "<br>".$banderamx;
	echo "<p>".date("d-m-Y h:i:s")."<p>";

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
<div id="popup"><center><img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading..." /></center></div>
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
echo "<font color=white>&nbsp; &nbsp; Script: barcode/inventory_dbload.php";
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
			echo "\<script>Finalizar()</script>\n";
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
