<div id="mRefine" style="display:none;">
 <?php
include("dibujarformulariobusqueda.php");
$Sub_ex="";
if ($_REQUEST["Opcion"]=="libre" and !isset($_REQUEST["Seleccionados"])){
	if (isset($_REQUEST["prefijo"]) and trim($_REQUEST["Sub_Expresion"])!=""){
		if (!isset($_REQUEST["Campos"])){			$_REQUEST["Campos"]=$_REQUEST["prefijo"];
			$Sub_ex=$_REQUEST["Sub_Expresion"];
		}else{			$_REQUEST["Campos"].=' ~~~ '.$_REQUEST["prefijo"];
			$Sub_ex.=' ~~~ '.$_REQUEST["Sub_Expresion"];		}	}
}
$Diccio=-1;
DibujarFormaBusqueda($Diccio);
?>
</div>
