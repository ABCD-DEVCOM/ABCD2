<html>

<head>
  <title>Tesaurus</title>
</head>

<body>
<font face=arial height=10px>
<?php

function Agregar($base,$termino,$key,$Mfn){
global $db_path,$xWxis,$msgstr;
	$Formato="(v$key/)";
	$query="&base=".$base."&cipar=$db_path"."par/".$base.".par&from=$Mfn&to=$Mfn&Pft=$Formato";
	$query.="&Pft=".urlencode($Formato)."&Opcion=rango";
	$contenido="";
	$IsisScript=$xWxis."imprime.xis";
	$resultado=WxisLLamar($IsisScript,$query);
	$Agregar="S";
	foreach ($resultado as $value) {		$value=trim($value);
		if (trim($value)!=""){			if (strtoupper($termino)==strtoupper($value)) $Agregar="N";		}
	}	if ($Agregar=="S" ){		$ValorCapturado="a".$key."×".$termino."×\n";
		$query="&base=".$base."&cipar=$db_path"."par/".$base.".par&Mfn=$Mfn&count=1";
		$query.="&login=".$_SESSION["login"]."&ValorCapturado=".urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar_cg.xis";
		$contenido=WxisLLamar($IsisScript,$query);
		echo "Agregado: $termino<br>";
		foreach ($contenido as $value){			echo "$value<br>";		}	}else{		echo $msgstr["tes_relexists"]."<br>";	}}

function Eliminar($base,$termino,$key,$Mfn){
global $db_path,$xWxis,$msgstr;
	$Formato="(v$key/)";
	$query="&base=".$base."&cipar=$db_path"."par/".$base.".par&from=$Mfn&to=$Mfn&Pft=$Formato";
	$query.="&Pft=".urlencode($Formato)."&Opcion=rango";
	$contenido="";
	$IsisScript=$xWxis."imprime.xis";
	$resultado=WxisLLamar($IsisScript,$query);
	$Eliminar="N";
	$ValorCapturado="";
	foreach ($resultado as $value) {
		$value=trim($value);
		if (trim($value)!=""){
			if (strtoupper($termino)==strtoupper($value)) {				$Eliminar="S";			}else{				$ValorCapturado.="a".$key."×".$value."×\n";			}
		}
	}
	if ($Eliminar=="S" ){
		$ValorCapturado="d".$key."\n".$ValorCapturado;
		$query="&base=".$base."&cipar=$db_path"."par/".$base.".par&Mfn=$Mfn&count=1";
		$query.="&login=".$_SESSION["login"]."&ValorCapturado=".urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar_cg.xis";
		$contenido=WxisLLamar($IsisScript,$query);
		echo "Eliminado: $termino<br>";
		foreach ($contenido as $value){
			echo "$value<br>";
		}
	}else{
		echo $msgstr["tes_relnexists"]."<br>";
	}
}
session_start();
include("../config.php");
include("../common/get_post.php");
include("../lang/admin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../common/llamar_wxis_inc.php");
include("leer_relaciones.php");
echo "<h2>";
if ($arrHttp["Opcion"]=="update")
	echo $msgstr["tes_updaterels"];
else
	$msgstr["tes_chkinvrel"];
echo "</h2>";
$actual_rel=explode('$$$',$arrHttp["rel_text"]) ;
$anterior_rel=explode('$*$',$arrHttp["ant_text"]);
foreach ($actual_rel as $value){	$vter=explode('_',$value);
	if (trim($value)!="") {		$term=explode('$*',$vter[1]);
		foreach ($term as $t)
			$arr_actual[$vter[0]][$t]="";
	}}
foreach ($anterior_rel as $value){	if (trim($value)!=""){
		$vter=explode('_',$value);
		$tt=explode('$$',$vter[1]);
		foreach ($tt as $vv)
			$arr_anterior[$vter[0]][$vv]="";
    }
}
//echo "<xmp>";var_dump($arr_actual);var_dump($arr_anterior);echo "</xmp>";
$terminoenproceso=$arrHttp["termino"];
//echo "<p>";
$primeravez="S";

$relacion=array();
//SE VEN LAS RELACIONES QUE HA QUE ELIMINAR
foreach ($arr_anterior as $key=>$value){
	foreach ($value as $term=>$val){		if (!isset($arr_actual[$key][$term])){
			if (trim($term)!=""){
				$relacion[$key][$term]="E";
			}
		}
	}
}

//SE ANALIZAN LAS RELACIONES NUEVAS
foreach ($arr_actual as $key=>$value){	foreach ($value as $term=>$val){
		if (!isset($arr_anterior[$key][$term])){			if (trim($term)!=""){				$relacion[$key][$term]="A";
			}		}	}}
//echo "<xmp>";var_dump($rels);echo "</xmp>";
//echo "<xmp>";var_dump($relacion);echo "</xmp>";
echo "<h2><font color=darkblue>$terminoenproceso</font></h2>";
if (count($relacion)==0) echo "<h3>".$msgstr["tes_noupdate"]."</h2>";
foreach ($relacion as $key => $value){	foreach ($value as $term=>$accion){		$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=ubicar";
		$query.="&Expresion=".$term_prefix.$term."&to=".$term_prefix.$term ;
		$IsisScript=$xWxis."buscar.xis";
		$cont_rels=WxisLLamar($IsisScript,$query);
		echo $msgstr["tes_rel"]." ". $rels[$key]["name"] . " (".$rels[$key]["tag"].")<font color=darkblue><strong> ".$term. "</strong></font><br>".$msgstr["tes_action"].": ";
		echo "<strong> ";
		if ($accion=="A") echo $msgstr["tes_add"];
		if ($accion=="E") echo $msgstr["tes_delete"];
		echo "</strong> ";
		echo $rels[$key]["rel_name"] . " (".$rels[$key]["rel_tag"] .")  ";
		foreach ($cont_rels as $value){			if (trim($value)!=""){				if (trim($value)=="NO EXISTE"){
					echo "<font color=red>".$msgstr["tes_missterm"]."</font>";
				}else{					echo " Mfn: $value <br>";
					if ($arrHttp["Opcion"]=="update"){						switch($accion){							case "A":
									Agregar($arrHttp["base"],$terminoenproceso,$rels[$key]["rel_tag"],$value);
									break;
							case "E":
									Eliminar($arrHttp["base"],$terminoenproceso,$rels[$key]["rel_tag"],$value);
									break;						}					}
				}			}		}
		echo "<p>";	}}


die;


?>

</body>

</html>