<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");

if (isset($arrHttp["Expresion"])) {	$arrHttp["Expresion"]=urldecode($arrHttp["Expresion"]);
	$arrHttp["Expresion"]=str_replace("''",'"',$arrHttp["Expresion"]);}
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>"; //if (isset($arrHttp["Expresion"]))die;
include("../config.php");

include ("leerregistroisispft.php");
include ("../lang/admin.php");
// Busqueda libre


function EjecutarBusqueda(){
global $arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl;
		$vienede=$arrHttp["Opcion"];

		if ($arrHttp["Opcion"]!="continuar" and $arrHttp["Opcion"]!="buscar_en_este"){
			$Expresion=PrepararBusqueda();
		}else{
		 	$Expresion=stripslashes($arrHttp["Expresion"]);
			$arrHttp["Opcion"]="busquedalibre";
		}
		echo $Expresion;
		//$Expresion=urlencode(trim($Expresion));
		if ($arrHttp["desde"]!="dataentry"){
			if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
			if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]=$arrHttp["from"];
			if (isset($arrHttp["from"]))$arrHttp["count"]=1;
			if (!isset($arrHttp["Formato"]))$arrHttp["Formato"]="ALL";
			$Formato=$arrHttp["Formato"];
			if ($Formato!="ALL" ){
				$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Formato;
			}
			$IsisScript=$xWxis."buscar.xis";
			$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Expresion=".$Expresion."&Opcion=".$arrHttp["Opcion"]."&count=".$arrHttp["count"]."&Mfn=".$arrHttp["Mfn"]."&Formato=$Formato";
 			echo $query;
 			include("../common/wxis_llamar.php");
			foreach ($contenido as $linea){
				if (trim($linea)!="") {
				    echo "$linea\n";
				}
			}
		}else{
			if ($vienede=="buscar_en_este" or $vienede=="toolbar"){
				echo "<script>
						window.opener.top.browseby=\"search\"
						window.opener.top.Expresion=".$Expresion."
						window.opener.top.mfn=1
						window.opener.top.Menu(\"ejecutarbusqueda\");
						self.close()
					</script>
				";
			}else{				echo "<script>
						top.browseby=\"search\"
						top.Expresion='".str_replace("'","¨",$Expresion)."'
						top.Expre_b='".str_replace("'","¨",$Expresion)."'
						top.mfn=1
						top.Menu(\"ejecutarbusqueda\");
					</script>
				";			}
		}

}


// con el login y el password suministrado, se ubica el registro que se va a actualizar
function UbicarRegistro(){
global $arrHttp,$OS,$xWxis,$wxisUrl,$Wxis;
		if ($arrHttp["Opcion"]=="ubicar"){
			$Expresion="!E".$arrHttp["login"]."*!X".$arrHttp["password"];
		}else{
			$Expresion=PrepararBusqueda();
		}
		$arrHttp["Opcion"]="buscar";

		$Expresion=urlencode(trim($Expresion));
		$IsisScript="buscar.xis";
		$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&login=".$arrHttp["login"]."&password=".$arrHttp["password"]."&Expresion=".$Expresion."&Opcion=".$arrHttp["Opcion"]."&Formato=$db_path".$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["Formato"]."&Path=".$arrHttp["Path"];
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea){
			echo "$linea\n";
		}
}

// Prepara la fórmula de búsqueda cuando viene de la búsqueda avanzada

function PrepararBusqueda(){
global $arrHttp,$matriz_c,$camposbusqueda;

	if (!isset($arrHttp["Campos"])) $arrHttp["Campos"]="";
	$expresion=explode(" ~~~ ",$arrHttp["Expresion"]);
	$campos=explode(" ~~~ ",$arrHttp["Campos"]);
	if (isset($arrHttp["Operadores"])){
		$operadores=explode(" ~~~ ",$arrHttp["Operadores"]);
	}
	if (isset($arrHttp["Prefijos"])){
		$prefijos=explode(" ~~~ ",$arrHttp["Prefijos"]);
	}
	// se analiza cada sub-expresion para preparar la fórmula de búsqueda
	$nse=-1;
	for ($i=0;$i<count($expresion);$i++){
		$formula_parcial="";
		if (trim($expresion[$i])!="" and trim($campos[$i])!="---"){
			$exp=explode('"',$expresion[$i]);
			foreach ($exp as $val_exp){				if (trim($val_exp)!=""){					if ($val_exp !=" and " and $val_exp !=" or "){						$val_exp='"'.trim($prefijos[$i]).$val_exp.'"';
						$formula_parcial.=$val_exp;					}else{						$formula_parcial.=$val_exp;					}
				}			}
			//$expresion[$i]=$formula_parcial;
			$expresion[$i]=trim($formula_parcial);
		}
	}
	//return $expresion[0];
	$formulabusqueda="";
	for ($i=0;$i<count($expresion);$i++){
		if (trim($expresion[$i])!=""){
			if ($i!=0)
				$formulabusqueda=$formulabusqueda." (".$expresion[$i].") ";
			else
				$formulabusqueda=$expresion[$i];
			$resto="";
			for ($j=$i+1;$j<count($expresion);$j++){
				$resto=$resto.trim($expresion[$j]);
			}
			if (trim($resto)!="") $formulabusqueda=$formulabusqueda." ".$operadores[$i];
		}
	}
	$formulabusqueda=str_replace("&ldquo;",'"',$formulabusqueda);
	return $formulabusqueda;


}

include("../dataentry/formulariodebusqueda.php");



// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------



if (isset($arrHttp['Tabla']) and $arrHttp["Opcion"]!="formab"){	$arrHttp["Opcion"]="solobusqueda";}

if (isset($arrHttp["prestamo"])) {
	    unset($arrHttp["Target"]);
	}

if (!isset($arrHttp["prologo"])) {
	    $arrHttp["prologo"]="p";
	}
if (!isset($arrHttp["desde"])) $arrHttp["desde"]="";
if (!isset($arrHttp['count'])) $arrHttp["count"]="10";
// Se carga la tabla con las opciones de búsqueda

	$a= $db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
	$fp=file_exists($a);
	if (!$fp){		$a= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
		$fp=file_exists($a);
		if (!$fp){			echo "<br><br><h4><center>".$msgstr["faltacamposbusqueda"]."</h4>";
			die;		}
	}
	$fp = fopen ($a, "r");
	$fp = file($a);
	foreach ($fp as $linea){		$linea=trim($linea);		if ($linea!=""){            $camposbusqueda[]= $linea;
			$t=explode('|',$linea);
			$pref=$t[2];

			$matriz_c[$pref]=$linea;
		}
	}
include("../common/header.php");
switch ($arrHttp["Opcion"]){

	case "busquedalibre":
		EjecutarBusqueda();
		break;
	case "continuar":
		EjecutarBusqueda();
		break;
	case "formab":
	    $arrHttp["Opcion"]="buscar";
		DibujarFormaBusqueda();
		break;
	case "buscar":
		EjecutarBusqueda();
		break;
	case "ubicar":
		$arrHttp["Formato"]="actual";
		UbicarRegistro();
		break;
	case "buscar_en_este":
		EjecutarBusqueda();
		break;
	case "actualizarportabla":
		$Expresion=PrepararBusqueda();
		header("Location: actualizarportabla.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&Expresion=".urlencode($Expresion));
		die;
		break;
	case "solobusqueda":
	    $Expresion=PrepararBusqueda();
	    if ($arrHttp["Tabla"]=="imprimir" or $arrHttp["Tabla"]=="cGlobal"){	    	 $Ctrl='window.opener.document.forma1.Expresion.value=\''.$Expresion.'\'';	    }else{	    	 $Ctrl='window.opener.document.forma1.'.$arrHttp["Tabla"].'.value=\''.$Expresion.'\'';	    }
		echo "<script>
				$Ctrl
				self.close()
				</script>
			";
		die;
		break;
}
?>