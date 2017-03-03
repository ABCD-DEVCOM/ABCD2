<?php
session_start();
include ("../config.php");
include ("../lang/statistics.php");

//VALORES QUE VIENEN DE LA PÁGINA
include("../common/get_post.php");
if (!isset($arrHttp["tipo"])) $arrHttp["tipo"]="column";
if (!isset($arrHttp["columnas"])) $arrHttp["columnas"]="";
#foreach ($arrHttp as $key => $value) echo "$key = $value <br>";

$arreglo=$_SESSION['matriz'];
#var_dump($_SESSION['matriz']);

$arreglo_original=$arreglo;


include("../common/header.php");
echo "<body topmargin=0 bgcolor=#FFFFFF>\n<script>
	function CambiarGrafico(tipo){

		document.Grafico_x.tipo.value=tipo
		document.Grafico_x.submit()
	}
</script>\n";



include ("chart_library/charts.php");

echo "<div class=\"middle form\">
	<div class=\"formContent\" id=results>";
echo "<center><p>";
echo "<h4>".$arrHttp["titulo"]."</h4>";

echo InsertChart("chart_library/charts.swf", "chart_library","grafico_data.php?tipo=".str_replace(" ","+",$arrHttp["tipo"]),"680" ,"290");
echo "\n<br><br></center>\n";

$mat=split('###',$arreglo_original);
$matriz_n=array();
$matriz_n[0][0]="";
$i=-1;
foreach ($mat as $linea){
	if(substr($linea,0,strlen($linea)-1)=='|') $linea=substr($linea,0,strlen($linea)-1);
    $filas=explode('|',$linea);
	$i++;
	$j=-1;
	foreach ($filas as $celda){
		$j++;
		$matriz_n[$i][$j]=$celda;

	}
}
$ncolumnas=$j;
$nfilas=$i;
$i=-1;
echo "<center><font size=1>".$msgstr["chartype"].":";
echo "<table bgcolor=#ff0000 border=0 cellpadding=0 cellspacing=1>
	<td bgcolor=#eeeeee>&nbsp;
		<a href=\"javascript:CambiarGrafico('bar')\"><img src=chart_library/bar.gif border=0 alt=Barras></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('stacked bar')\"><img src=chart_library/stackedbar.gif border=0 alt=\"Barras acumuladas\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('column')\"><img src=chart_library/column.gif border=0 alt=columnas></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('3d column')\"><img src=chart_library/3dcolumn.gif border=0 alt=\"columnas 3d\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('stacked column')\"><img src=chart_library/stackedcolumn.gif border=0 alt=\"columnas acumuladas\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('stacked 3d column')\"><img src=chart_library/stacked3dcolumn.gif border=0 alt=\"columnas 3d acumuladas\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('parallel 3d column')\"><img src=chart_library/parallel3dcolumn.gif border=0 alt=\"columnas 3d paralelas\"></a>&nbsp;
	</td>
";
if (isset($arrHttp["Pie"])) {
   	echo "
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('pie')\"><img src=chart_library/pie.gif border=0 alt=\"circulo\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('3d pie')\"><img src=chart_library/3dpie.gif border=0 alt=\"círculo 3d\"></a>&nbsp;
	</td>";
}else{
	echo "
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('line')\"><img src=chart_library/line.gif border=0 alt=\"línea\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('area')\"><img src=chart_library/area.gif border=0 alt=\"área\"></a>&nbsp;
	</td>
	<td bgcolor=#eeeeee>
		&nbsp;<a href=\"javascript:CambiarGrafico('stacked area')\"><img src=chart_library/stackedarea.gif border=0 alt=\"área acumulada\"></a>&nbsp;
	</td>";
}


echo "</table></font><center>";
$columnas=$arrHttp["columnas"];
echo "<p><table  bgcolor=#cccccc class=statTable border>";
for ($j=0;$j<=$ncolumnas;$j++){
		if (isset($matriz_n[0][$j])) echo "<td  bgcolor=#FFFFFF align=center>".$matriz_n[0][$j]."</td>";
}
if ($ncolumnas>1) echo "<td width=60 bgcolor=#FFFFFF align=center>".$msgstr["total"]."</td>";
$x=0;

$totalcolumna= Array();
$nc=$ncolumnas;
if ($ncolumnas==1) $ncolumnas=2;
for ($j=1;$j<=$ncolumnas;$j++) $totalcolumna[$j]=0;
for ($i=1;$i<=$nfilas;$i++){
	echo "<tr><td width=200 bgcolor=#FFFFFF align=left>".$matriz_n[$i][0]."</td>";
	$totalfila=0;
	for ($j=1;$j<$ncolumnas;$j++){
		echo "<td width=60 align=center  bgcolor=#FFFFFF>";
		if (isset($matriz_n[$i][$j])){
			if ($matriz_n[$i][$j]==0) {
			    $total="-";
			}else{
				$total=$matriz_n[$i][$j];
	//			echo "<xa class=texto href=\"javascript:VerDatos('".str_replace(" ","+",$links[$i][$j])."')\" >".$total."</a>";
				$totalfila=$totalfila+$total;
				$totalcolumna[$j]=$totalcolumna[$j]+$total;
				echo "$total";
				echo "</td>";
			}
		}else{			echo "-";
			echo "</td>";		}

	//	echo $links[$i][$j]."<br>";


	}
	if ($nc>1) {
	    echo "<td width=60 align=center bgcolor=#FFFFFF>".$totalfila."</td>";
	}


}
echo "<tr><td width=60 align=center bgcolor=#FFFFFF>".$msgstr["total"]."</td>";
$totalfila=0;
for ($j=1;$j<=$ncolumnas;$j++){
	if ($j<$ncolumnas){
		echo "<td width=60 align=center bgcolor=#FFFFFF>";
		echo $totalcolumna[$j]."</td>";
	}
	$totalfila=$totalfila+$totalcolumna[$j];
}
if ($nc>1) {
	echo "<td width=60 align=center bgcolor=#FFFFFF>";
	echo $totalfila."</td>";
}
echo "</table><br><br>";

echo "</form>
	<form name=Grafico_x action=cuadro_animado.php method=post>
	<input type=hidden name=menu_graficos value=S>
	<input type=hidden name=base value=".$arrHttp["base"].">
	<input type=hidden name=cipar value=".$arrHttp["cipar"].">
	<input type=hidden name=tipo value=\"\">
	<input type=hidden name=titulo value=\"".$arrHttp["titulo"]."\">
	";
	if (isset($arrHttp["Pie"])) echo "<input type=hidden name=Pie value=S>";


echo "</form>
<p><center><a href=javascript:self.close()>".$msgstr["close"]."</a>
</div>
</div>
</body></html>" ;

?>