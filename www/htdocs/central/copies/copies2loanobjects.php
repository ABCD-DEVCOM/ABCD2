<?php
session_start();
set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
$arrHttp["base"]="copies";

$IsisScript=$xWxis."imprime.xis";
$Formato="V1'|',v10'|^i',v30,'|^t'v50,'|^v'v60,'|',v63,'|',ref(['libros']l(['libros']'CN_'v1),v3)/";
$query ="&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=rango&from=1&to=99999&Formato=".urlencode($Formato);
//echo $query;
include("../common/wxis_llamar.php");
foreach ($contenido as $value){
	//echo "$value<br>";	$x=explode('|',$value);
	if (!isset($inven[$x[0]])){		$inven[$x[0]]=$value;	}else{		$inven[$x[0]].="\n".$value;	}
}
foreach ($inven as $key=>$value){	$value=trim($value);
	if ($value!=""){		$control=$key;
		$ValorCapturado="<1>".$control."</1><10>libros</10>";
		$obj=explode("\n",$value);
		foreach ($obj as $lobje) {			$lobje=trim($lobje);
			$a=explode('|',$lobje);
			$inven=$a[2];
			$signa=strtoupper($a[6]);
			$copia=strtoupper($a[5]);
			$ValorCapturado.="<959>".$inven."</959>";
			$tipo=strtoupper(substr($inven,2,1));
			if ($tipo=="T"){
				$tipo='^oT';
			}else{				if (substr($signa,0,3)=="^AR"){
					$tipo="^oR";
				}else{					$ix=strpos($copia,"RS");
					if (!$ix==false){						$tipo="^oRS";					}else{						$tipo="^oCG";					}				}			}
			$ValorCapturado.=$tipo;
			if ($a[3]!="^t")
			   $ValorCapturado.=$a[3];
			if ($a[4]!="^v")
			   $ValorCapturado.=$a[4];
			//$ValorCapturado.="\n";			}
		echo "<xmp>$ValorCapturado</xmp>";
		$IsisScript=$xWxis."actualizar.xis";
		$ValorCapturado=urlencode($ValorCapturado);
  		$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par&login=abcd&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea) echo "$linea<br>";
	}}
?>
