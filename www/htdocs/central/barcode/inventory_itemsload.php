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

/** PHPExcel_IOFactory */
require_once ('../Classes/PHPExcel/IOFactory.php');

include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
include ("configure.php");

function SeleccionarFuente(){
global $arrHttp,$db_path;
?>
	<form action="" method="post" enctype="multipart/form-data">
<?php

		$base=$arrHttp["base"];
		echo "<br> <label for=\"archivo\">Seleccione el archivo a cargar:</label>
			<input type=\"file\" name=\"archivo\" id=\"archivo\" />
			<br><br>";
		echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
		echo "<input type=\"submit\" value=\"Subir archivo\"/>
              <input type=hidden name=Opcion value=subir>
			</form>";
}

function SubirFuente(){
global $db_path,$arrHttp,$ext_allowed;
	if( !isset($_FILES['archivo']) ){
  		echo '<h4><br>No se ha seleccionado el archivo a subir<br/></h4>';
	}else{
		$nombre = $_FILES['archivo']['name'];
		$nombre_tmp = $_FILES['archivo']['tmp_name'];
		$tipo = $_FILES['archivo']['type'];

		$extension= pathinfo($nombre, PATHINFO_EXTENSION);

		$tamano = $_FILES['archivo']['size'];
		$limite = 5000 * 1024;
    	if( $_FILES['archivo']['error'] > 0 ){
      		echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
    	}else{
			echo "<h3>Información de la transferencia del archivo</h3>";
      		echo 'Nombre: ' . $nombre . '<br/>';
      		echo 'Tipo: ' . $tipo . '<br/>';
      		echo 'Tamaño: ' . ($tamano / 1024) . ' Kb<br/>';
      		$encontrado="N";
      		for ($i=0;$i<count($ext_allowed);$i++){      			if (strtoupper($ext_allowed[$i])==strtoupper($extension)){
      				$encontrado="S";
      				break;
      			}      		}
      		if ($encontrado=="N"){
				echo "<h1>invalid extension $extension</h1>";
				die;
			}
      		echo 'Subido a: ' . $nombre_tmp;
			move_uploaded_file($nombre_tmp,$db_path."wrk/" . $nombre);
			echo "<br/>Guardado en: " . $db_path."wrk/" . $nombre;
			echo "<br><br><form name=form1 method=post>
			<input type=hidden name=base value=".$arrHttp["base"].">
			<input type=hidden name=Opcion value=cargar>
			<input type=hidden name=fuente value=\"".$nombre."\">
			<input type=submit name=cargar value=\"Cargar en base de datos\">
			</form>
			";
      	}
    }
}

function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}

function CrearInventario($inven){
global $db_path;	$ValorCapturado="<50 0>$inven</50><60 0>".date("Ymd")."</60>";
	$IsisScript="crear_registro.xis";
	$query = "&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&login=".$_SESSION["login"]."&Mfn=New&ValorCapturado=".$ValorCapturado."&Pft=f(mfn,1,0)/";	$contenido=WxisLLamar($IsisScript,"abcd_inventory",$query);
	$contenido=implode("\n",$contenido);
	return $contenido;
}


function CargarItems($base){
global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
$fuente="";
	$Pft="v30,'|',v50,'|',v70,'|',f(mfn,1,0),/";
	$fuente=$db_path."wrk/".$arrHttp["fuente"];
	$objPHPExcel = PHPExcel_IOFactory::load($fuente);
	//$objReader->setReadDataOnly(true);
	$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$Fecha=date("Ymd");
	echo "<table><td align=center>".$msgstr["inventory_database"]."</td><td align=center>".$msgstr["inventory"]."</td><td align=center>".$msgstr["inventory_loan"]."</td><td align=center>Mfn<br>(abcd_inventory)</td><td></td>\n";
	$inven=array();
	foreach ($objWorksheet->getRowIterator() as $row) {
		$rowIndex = $row->getRowIndex ();
		$cellIterator = $row->getCellIterator();
	  	$cellIterator->setIterateOnlyExistingCells(false);
	  	$ValorCapturado="";
	  	unset($campo);
	  	$ix=-1;
	  	$campos=array();
	  	foreach ($cellIterator as $key=>$cell) {
	  		$cell=$cell->getValue();
	  		$cell=utf8_decode($cell);
	  		if (!isset($inven[$cell])) $inven[$cell]="";
	  		$query="&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&Pft=$Pft&Expresion=NI_$cell";
	  		$IsisScript="cipres_usuario.xis";
	  		$contenido=WxisLLamar($IsisScript,"abcd_inventory",$query);
	  		$value=implode("\n",$contenido);
			if (trim($value)!=""){
				unset($inven[$cell]);				$item=explode('|',$value);
				$inv=$item[0];
				$inv_fisico=$item[1];
				$inv_prestamo=$item[2];
				$Mfn=$item[3];
				if ($inv_fisico=="") {					$ValorCapturado="<50 0>$inv</50><60>$Fecha</60>";
					$IsisScript="actualizar_registro.xis";
					$Formato="";
					$query = "&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
				   	$resultado=WxisLLamar($IsisScript,"abcd_inventory",$query);
					$resultado=implode("\n",$resultado);
					echo "<tr><td width=100 align=center>$inv</td><td width=100 align=center>$cell</td><td width=100 align=center>$inv_prestamo</td><td width=100 align=center>$Mfn</td><td></td></tr>\n";				}else{					$res=$msgstr["inventory_loaded"];
					echo "<tr><td width=100 align=center>$inv</td><td width=100 align=center>$inv_fisico</td><td width=100 align=center>$inv_prestamo</td><td width=100 align=center>$Mfn</td><td>$res</td></tr>\n";
				}
			}
			flush();
   		 	ob_flush();
		}
	}
	foreach ($inven as $key=>$value){		if (trim($value)==""){			$res=CrearInventario($key);			echo "<tr><td align=center>$key</td><td></td><td></td><td>$res</td><td>".$msgstr["inventory_not_found"]."</td></tr>";
		}	}
	echo "</table>";
	echo "\n<script>alert('".$msgstr["end_process"]."')</script>\n";
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
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["inventory_dbinit"].": ".$arrHttp["base"]?>
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
echo "<font color=white>&nbsp; &nbsp; Script: barcode/inventory_itemsload.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<?php
if ( $arrHttp["Opcion"]=="subir"){
	if( !isset($_FILES['archivo'])){
		SeleccionarFuente();

	}else{
		SubirFuente();

	}
}else{
	if ($arrHttp["Opcion"]=="cargar" ){
		CargarItems($arrHttp["base"]);
		die;
	}
}
?>

	</div>
</div>
<?php
Include("../common/footer.php");
?>
</Body>
</Html>
