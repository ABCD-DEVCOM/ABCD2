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

function Ask_Confirmation(){
global $arrHttp,$msgstr;
	echo "<div style='margin: 20px 40px 10px 200px; width:400px '>";
	echo $msgstr["inventory_transload_help"];
	echo "<p>";
	echo "<input type=submit value=continuar onclick=Continuar()>";
	echo "</div>";
}


function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}

function CrearInventario($inven,$inf){
global $db_path;
	$i=explode('|',$inf);	$ValorCapturado="<70 0>$inven</70><80 0>".date("Ymd")."</80>"."<90 0>".$i[0]."</90>"."<110 0>".$i[1]."</110>"."<100 0>".$i[2]."</100>";
	$IsisScript="crear_registro.xis";
	$query = "&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&login=".$_SESSION["login"]."&Mfn=New&ValorCapturado=".$ValorCapturado."&Pft=f(mfn,1,0)/";	$contenido=WxisLLamar($IsisScript,"abcd_inventory",$query);
	$contenido=implode("\n",$contenido);
	return $contenido;
}


function CargarItems($base){
global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
$fuente="";
	$Pft="v10,'|',v30,'|',v40,'|',V10/";
	echo "<table><td align=center>".$msgstr["inventory_database"]."</td><td align=center>".$msgstr["inventory"]."</td><td align=center>".$msgstr["inventory_loan"]."</td><td align=center>Mfn<br>(abcd_inventory)</td><td></td>\n";
	$inven=array();
	$inf_pres=array();
	$query="&base=trans&cipar=$db_path"."par/trans.par&Pft=$Pft&Expresion=TR_P_$";
	$IsisScript="cipres_usuario.xis";
	$contenido=WxisLLamar($IsisScript,"abcd_inventory",$query);
	$Fecha=date("Ymd");
	$Pft="v30,'|',v50,'|'v70,'|',f(mfn,1,0)/";
	foreach ($contenido as $value){
		$ValorCapturado="";
	  	$value=trim($value);
	  	if ($value!=""){
	  		$i=explode('|',$value);
	  		$inv_pr=$i[0];
	  		$fecha_prestamo=$i[1];
	  		$fecha_devolucion=$i[2];
	  		$usuario=$i[3];
	  		if (!isset($inven[$inv_pr])) {
	  			$inven[$inv_pr]="";	  			$inf_pres[$inv_pr]=$usuario.'|'.$fecha_prestamo.'|'.$fecha_devolucion;	  		}
	  		$query="&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&Pft=$Pft&Expresion=NI_$inv_pr";
	  		$IsisScript="cipres_usuario.xis";
	  		$en_inventario=WxisLLamar($IsisScript,"abcd_inventory",$query);
	  		$v_inv=implode("\n",$en_inventario);
			if (trim($v_inv)!=""){
				$item=explode('|',$v_inv);
				$inv=$item[0];
				$inv_fisico=$item[1];
				$inv_prestamo=$item[2];
				$Mfn=$item[3];
				unset($inven[$inv_pr]);
				if ($inv_prestamo==""){					$ValorCapturado="<70 0>$inv_pr</70><80>$Fecha</80><90>$usuario</90><100>$fecha_devolucion</100><110>$fecha_prestamo</110>";
					$IsisScript="actualizar_registro.xis";
					$Formato="";
					$query = "&base=abcd_inventory&cipar=$db_path"."par/abcd_inventory.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
					$resultado=WxisLLamar($IsisScript,"abcd_inventory",$query);
					$resultado=implode("\n",$resultado);
    				echo "<tr><td width=100 align=center>$inv</td><td width=100 align=center>$inv_fisico</td><td width=100 align=center>$inv_pr</td><td width=100 align=center>$Mfn</td><td>$resultado</td></tr>\n";
				}else{
					$res=$msgstr["inventory_loaded"];
					echo "<tr><td width=100 align=center>$inv</td><td width=100 align=center>$inv_fisico</td><td width=100 align=center>$inv_prestamo</td><td width=100 align=center>$Mfn</td><td>$res</td></tr>\n";
				}
			}			flush();
   		 	ob_flush();
		}
	}
	foreach ($inven as $key=>$value){		if (trim($value)==""){
			$res=CrearInventario($key,$inf_pres[$key]);			echo "<tr><td align=center>$key</td><td></td><td></td><td>$res</td><td>".$msgstr["inventory_not_found"]."</td></tr>";
		}	}
	echo "</table>";
	echo "\n<script>alert('".$msgstr["end_process"]."')</script>\n";
}
?>
<script>
	function Continuar(){
		document.forma1.Opcion.value='OK'
		document.forma1.submit()
	}
</script>
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
echo "<font color=white>&nbsp; &nbsp; Script: barcode/inventory_transload.php";
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
if ( $arrHttp["Opcion"]=="inicio"){
	Ask_Confirmation();
}else{
	if ($arrHttp["Opcion"]=="OK" ){
		CargarItems($arrHttp["base"]);
		die;
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
