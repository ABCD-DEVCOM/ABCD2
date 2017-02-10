<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";die;
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
		$Expresion=urlencode(trim($Expresion));
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
	//			echo $query;
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
						window.opener.top.Expresion=\"".$Expresion."\"
						window.opener.top.mfn=1
						window.opener.top.Menu(\"ejecutarbusqueda\");
						self.close()
					</script>
				";
			}else{				echo "<script>
						top.browseby=\"search\"
						top.Expresion=\"".$Expresion."\"
						top.Expre_b=\"".urldecode($Expresion)."\"
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
//		if ($arrHttp["Formato"]=="") $arrHttp["Formato"]=$arrHttp["base"].".pft";
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
		$expresion[$i]=trim(stripslashes($expresion[$i]));
		$pref="";
		if ($expresion[$i]!=""){
            if (trim($prefijos[$i])!=""){
				$cb=$matriz_c[$prefijos[$i]];
				$cb=explode('|',$cb);
				$pref=trim($cb[2]);
				$pref1='"'.$pref;
				if (substr(strtoupper($expresion[$i]),0,strlen($pref1))==strtoupper($pref1) or substr(strtoupper($expresion[$i]),0,strlen($pref))==strtoupper($pref)){				}else{
					$expresion[$i]=$pref.$expresion[$i];				}
			}
			$formula=str_replace("  "," ",$expresion[$i]);
			$subex=Array();
			if (trim($campos[$i])!="" and trim($campos[$i])!="---"){
				$id="/(".trim($campos[$i]).")";
			}else{
				$id="";
			}
			if ($pref!=""){
				$xor="¬or¬$pref";
				$xand="¬and¬$pref";
            }else{            	$xor="¬or¬";
				$xand="¬and¬";            }
			$formula=stripslashes($formula);
			while (is_integer(strpos($formula,'"'))){
				$nse=$nse+1;
				$pos1=strpos($formula,'"');
				$xpos=$pos1+1;
				$pos2=strpos($formula,'"',$xpos);
				$subex[$nse]=trim(substr($formula,$xpos,$pos2-$xpos));
				if ($pos1==0){
					$formula="{".$nse."}".substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1-1)."{".$nse."}".substr($formula,$pos2+1);
				}
			}
			$formula=str_replace (" {", "{", $formula);
			$formula=str_replace (" or ", $xor, $formula);
			$formula=str_replace ("+", $xor, $formula);
			$formula=str_replace (" and ", $xand, $formula);
			$formula=str_replace ("*", $xand, $formula);
			$formula=str_replace ('\"', '"', $formula);
		//	if (substr($formula,0,strlen($pref))!=$pref)
		//		$formula=$pref.$formula;
			while (is_integer(strpos($formula,"{"))){
				$pos1=strpos($formula,"{");
				$pos2=strpos($formula,"}");
				$ix=substr($formula,$pos1+1,$pos2-$pos1-1);
				if ($pos1==0){
					$formula=$subex[$ix].substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1)." ".$subex[$ix]." ".substr($formula,$pos2+1);
				}
			}

			$formula=str_replace ("¬", " ", $formula);
//			if (substr($formula,0,strlen($pref))!=$pref) $formula=$pref.$formula;
			$expresion[$i]=trim($formula);
		}
	}
	$formulabusqueda="";
	for ($i=0;$i<count($expresion);$i++){
		if (trim($expresion[$i])!=""){
			$formulabusqueda=$formulabusqueda." (".$expresion[$i].") ";
			$resto="";
			for ($j=$i+1;$j<count($expresion);$j++){
				$resto=$resto.trim($expresion[$j]);
			}
			if (trim($resto)!="") $formulabusqueda=$formulabusqueda." ".$operadores[$i];
		}
	}
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
//if ($arrHttp["Opcion"]!="cGlobal" and $arrHttp["Opcion"]!="reportes" and $arrHttp["Opcion"]!="stats")
include("../common/header.php");
//echo $arrHttp["Opcion"];
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
	case "solobusqueda":
	    $Expresion=PrepararBusqueda();
	    if ($arrHttp["Tabla"]=="imprimir" or $arrHttp["Tabla"]=="cGlobal"){	    	 $Ctrl='window.opener.document.forma1.Expresion.value="'.$Expresion.'"';	    }else{	    	 $Ctrl='window.opener.document.forma1.'.$arrHttp["Tabla"].'.value="'.$Expresion.'"';	    }
		echo "<script>
				$Ctrl
				self.close()
				</script>
			";
		die;
		break;
}
?>