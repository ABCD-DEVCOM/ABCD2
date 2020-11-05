<html>

<head>
  <title></title>
</head>

<body>

<?php

session_start();
include("../config.php");
include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../common/llamar_wxis_inc.php");
include("leer_relaciones.php");
$actual_rel=explode('$$$',$arrHttp["rel_text"]) ;
$anterior_rel=explode('*$',$arrHttp["ant_text"]);
$terminoenproceso=$arrHttp["termino"]
$Formato="";
foreach ($rels as $value){
	$Formato.="("."|".$value["tag"]."_|"."v".$value["tag"]."/),";
}
$Formato="v$term_tag/".$Formato;
//echo "<xmp>";var_dump($rels);echo "</xmp>";
//echo $Formato;
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=rango&Formato=".$Formato;
$query.="&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis. "imprime.xis";
$contenido=WxisLLamar($IsisScript,$query);
echo "<p>";
$primeravez="S";
foreach($contenido as $value) {
	$value=trim($value);
	if ($value!=""){
		if ($primeravez=="S"){
			$termino= $value;
			$primeravez="N";
			echo "Procesando: ".$termino."<br>";
			continue;
		}
		$v=explode("_",$value);
		echo "<br>Relacion:<br>";
		echo $rels[$v[0]]["rel_tag"]." ".$rels[$v[0]]["rel_name"]."<br>";
		$Formato="(v".$rels[$v[0]]["rel_tag"]."/)";
		//echo $Formato."<br>";
		$Expresion=$prefix.$v[1];

		$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=buscar&Formato=".$Formato;
		$query.="&Expresion=$Expresion";
		echo $Expresion."<br>";
		$IsisScript=$xWxis. "imprime.xis";
		$cont_rels=WxisLLamar($IsisScript,$query);
		$agregar="S";
		foreach ($cont_rels as $rels_inversa){
			$rels_inversa=trim($rels_inversa);
			//echo "$rels_inversa<br>";
			if ($rels_inversa!="")
				if (strtoupper($termino)==strtoupper($rels_inversa)) $agregar="N";

		}
		if ($agregar=="S") echo "<font color=red>Agregar relación</font><br>";
	}

}

?>

</body>

</html>