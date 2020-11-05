<?php
$path="../";
include("config.php");
include("leer_bases.php");
include("tope.php");
include("navegarpaginas.php");

include ("slide_show.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>$value<br>";
if (!isset($_REQUEST["desde"]) or trim($_REQUEST["desde"])=="" ) $_REQUEST["desde"]=1;
if (!isset($_REQUEST["count"]) or trim($_REQUEST["count"])=="")  $_REQUEST["count"]=25;
$desde=$_REQUEST["desde"];
$count=$_REQUEST["count"];

$Expresion="";
$_REQUEST["Expresion"]=urldecode($_REQUEST["Expresion"]);
$Expresion=$_REQUEST["Expresion"];
if ($Expresion=='') $Expresion='$';
if (isset($_REQUEST["integrada"])){	$_REQUEST["integrada"]=urldecode($_REQUEST["integrada"]);	$int=explode('||',$_REQUEST["integrada"]);
	$ix_b=-1;
	foreach ($int as $val){		$x=explode('$$',$val);
		$total_base[$x[0]]=$x[1];
		foreach ($seq_bases as $key => $value)
		if ($x[0]==$value)
			$total_base_seq[$x[0]]=$key;
			$Expresion_base_seq[$x[0]]=$x[2];	}
}$Formato="slide_show.pft";
$ix=0;
$contador=0;
$base=$_REQUEST["base"];
$query = "&base=$base&cipar=$db_path"."par/$base.par&Expresion=".urlencode($Expresion)."&Formato=$Formato&count=$count&from=$desde";
$resultado=wxisLlamar($base,$query,$xWxis."buscar.xis");
$salida="";

foreach ($resultado as $value){	$value=trim($value);
	if (substr($value,0,8)!='[TOTAL:]'){		$salida.=$value;
	}else{		$contador=substr($value,8);	}
}
echo "<div align=right style='margin-top:10px'>&nbsp; &nbsp; ";
echo "<span class=tituloBase>";
echo"". $bd_list[$base]["titulo"]."</span>. ";
echo "Resultado: ".$contador." registros ";
$hasta=$desde+$count-1;
if ($hasta>$contador) $hasta=$contador;
if ($contador>1){
	echo "<br>Mostrando del $desde al ".$hasta;
}
echo "<br><input type=button id=\"search-submit\" value=\" Ver galeria imágenes \" onclick=\"javascript:Presentacion('".$_REQUEST["base"]."','".urlencode($_REQUEST["Expresion"])."','".$_REQUEST["pagina"]."','galeria')\">";
echo "&nbsp; &nbsp; <input type=button id=\"search-submit\" value=\" Ver ficha descriptiva \" onclick=\"javascript:Presentacion('".$_REQUEST["base"]."','".urlencode($_REQUEST["Expresion"])."','".$_REQUEST["pagina"]."','ficha')\"><br>";
echo "<p></div>";

$s=explode('###',$salida);
foreach ($s as $linea){	$l=explode('$$$',$linea);
	if (trim($l[0])!=""){		$image[]=$l[0];
		$dummy=str_replace("\n","",$l[1]);
		$dummy=str_replace("\"","",$dummy);
		$titulo[]=str_replace("'"," ",$dummy);
		$dummy=str_replace("\n","",$l[2]);
		$dummy=str_replace("\"","",$dummy);
		$ficha[]=str_replace("'"," ",$dummy);	}
}
SlideShow($image,$titulo,$ficha);
$desde=$desde+$count;
if ($desde>=$contador) $desde=1;
echo "<hr>";
echo "<table width=100%><td width=100% align=center>";
if (isset($_REQUEST["lista_bases"]) and $_REQUEST["lista_bases"]!="" ){
	echo "<h4>Mostrando: ".$bd_list[$base]["titulo"]." (".$total_base[$base]." registros)</h4>";
      	$totalRegistros=$total_base[$base];
}else{	echo "<h4>Mostrando: ".$bd_list[$base]["titulo"]." (".$contador." registros)</h4>";
	$totalRegistros=$contador;
}
echo "<form name=continuar action=slide_integrada.php method=post>\n";
echo "<input type=hidden name=Expresion value=\"".urlencode($Expresion)."\">\n";
NavegarPaginas($totalRegistros,$count,$desde);

echo "</td>";

echo "</table></form>\n";
if (isset($total_base) and count($total_base)>1){	$fin=end($total_base);
	reset($total_base);
	$key_end=key($total_base);
	echo "<br><br><center>Resumen de resultados<div style=\"margin-top:0px; width:70%; margin-bottom:2px;margin-right:2px;margin-left:2px; border:2px solid #C4D1C0; vertical-align:top;text-align:left;padding:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius:10px;\">";
	echo "<table align=center width=100% >";
	$ix=-1;
	$total_general=0;
	foreach ($total_base as $base=>$total){		$ix=$ix+1;
		$total_general=$total_general+$total;
		echo "<tr height=30px width=300px><td>".$bd_list[$base]["titulo"]."</td><td align=right>".$total."</td>";
		echo "<td width=80px align=right><a href=\"javascript:ProximaBase(".$total_base_seq[$base].",'".urlencode($Expresion_base_seq[$base])."')\"><img src=../images/lupa.gif></a></td>";
		echo "</tr>\n";
	}
	echo "<tr><td align=right><strong>Total ...</td>";
	echo "<td align=right>$total_general</td></tr>";
	echo "</table>";
	echo "</div>";
}
include("footer.php");

?>
