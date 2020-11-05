<?php
include("config_opac.php");
$path="../";
include("leer_bases.php");
include("tope.php");
include("presentar_registros.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_REQUEST["indice_base"])){	include ("submenu_bases.php");}else{
?>
<div id="menu">
		<a href="../index.php"><div class=inicio>Inicio</div></a>
	</div>
	<!-- end #menu -->
	<div id="page">

<?php
}
function PrepararBusqueda(){
	$_REQUEST["Expresion"]=str_replace("\\","",urldecode($_REQUEST["Expresion"]));
	$expresion=explode(" ~~~ ",$_REQUEST["Expresion"]);
	$campos=explode(" ~~~ ",$_REQUEST["Campos"]);
	if (isset($_REQUEST["Operadores"])){
		$operadores=explode(" ~~~ ",$_REQUEST["Operadores"]);
	}else{
		$operadores[0]="+";
	}

	$truncar="";
// se analiza cada sub-expresion para preparar la fórmula de búsqueda
// los Id para cualificar las búsquedas se determinan haciendo la equivalencia entre la tabla de campos
// de la base de datos y la tabla de campos general (camposbusqueda.tab, en ambos casos)
	for ($i=0;$i<count($expresion);$i++){
		$expresion[$i]=trim($expresion[$i]);
		if ($expresion[$i]!=""){
			$formula=str_replace("  "," ",$expresion[$i]);
			$subex=Array();
			$id="";
			if (trim($campos[$i])!="" and trim($campos[$i])!="---") {
				$id=trim($campos[$i]);
			}
			$xor="¬or¬";
			$xand="¬and¬";
//			echo $formula;
			$formula=str_replace (" or ", $xor, $formula);
			$formula=str_replace (" and ", $xand, $formula);
			$f=explode("¬or¬",$formula);
			$formula="";
			foreach ($f as $value){				$value=trim($value);
				if ($value!=""){					if (substr($value,0,1)=="\"")
						$value=substr($value,0,1).$id.substr($value,1);
					else						$value=$id.$value;
					if ($formula=="")
						$formula=$value;
					else
						$formula=$formula."¬or¬".$value;				}			}
			/*$f=explode("¬and¬",$formula);
			$formula="";
			foreach ($f as $value){
				$value=trim($value);
				if ($value!=""){
					if (substr($value,0,1)=="\"")
						$value=substr($value,0,1).$id.substr($value,1);
					else
						$value=$id.$value;
					if ($formula=="")
						$formula=$value;
					else
						$formula=$formula."¬and¬".$value;
				}
			}*/
			$nse=-1;
			while (is_integer(strpos($formula,"**\""))){
				$nse++;
				$pos1=strpos($formula,"\"");
				$pos2=strpos($formula,"\"",$pos1+1);
				$a=$campos[$i].substr($formula,$pos1+1,$pos2-$pos1-1);
				if (strpos($a,"(")!=0) $a="\"".$a."\"";
				$subex[$nse]=$a;
				if ($pos1==0){
					$formula="²".$nse."·".substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1-1)."²".$nse."·".substr($formula,$pos2+1);
				}
			}
			//$formula=str_replace (" ", " and ", $formula);
			while (is_integer(strpos($formula,"²"))){
				$pos1=strpos($formula,"²");
				$pos2=strpos($formula,"·");
				$ix=substr($formula,$pos1+1,$pos2-$pos1-1);
				if ($pos1==0){
					$formula=$subex[$ix].substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1)." ".$subex[$ix].substr($formula,$pos2+1);
				}
			}

			$formula=str_replace ("¬", " ", $formula);
			$formula=str_replace("\\'","'",$formula);
		    $expresion[$i]=trim($formula);
		}
	}
	$formulabusqueda="";
	for ($i=0;$i<count($expresion);$i++){
		if (trim($expresion[$i])!=""){			//echo $expresion[$i].$operadores[$i]."<br>";			if ($formulabusqueda!=""){
				$formulabusqueda=$formulabusqueda.$OPER." (".$expresion[$i].")";
				$OPER=$operadores[$i];
			}else{
			    $formulabusqueda="(".$expresion[$i].") ";
			    $OPER=$operadores[$i];
			}
		}
	}
	//echo "<p>$formulabusqueda<p>";
	return $formulabusqueda;
}

//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_REQUEST["desde"]) or trim($_REQUEST["desde"])=="" ) $_REQUEST["desde"]=1;
if (!isset($_REQUEST["count"]) or trim($_REQUEST["count"])=="")  $_REQUEST["count"]=25;
$desde=$_REQUEST["desde"];
$count=$_REQUEST["count"];
$Expresion="";
$base=$_REQUEST["base"];
switch ($_REQUEST["Opcion"]){	case "palabras":
		if (!isset($_REQUEST["Incluir"])) $_REQUEST["Incluir"]="and";
		if (!isset($_REQUEST["Expresion"]) or $_REQUEST["Expresion"]=="" ){
			 $Expresion='$';
		}else{
			$pal=explode(" ",$_REQUEST["Expresion"]);
			foreach ($pal as $w){				if (trim($w)!=""){
					if ($Expresion=="")
						$Expresion=$_REQUEST["prefijo"].$w;
					else
						$Expresion.=" ".$_REQUEST["Incluir"]." ".$_REQUEST["prefijo"].$w;
				}			}
		}
		break;
	case "detalle":
		if (!isset($_REQUEST["Expresion"]) or $_REQUEST["Expresion"]=="" ){			 $Expresion='$';
		}else{
			$Expresion=$_REQUEST["Expresion"];        }
		break;
	case "prepararbusqueda";
		$Expresion=PrepararBusqueda();
		break;
	case "avanzada":
		$Expresion=trim($_REQUEST["Expresion"]);
		break;
	case "fecha":
		if (!isset($_REQUEST["Expresion"]))
			$Expresion=$_REQUEST["prefijo"].'$';
		else
			$Expresion=$_REQUEST["Expresion"];
		$query = "&base=$base&cipar=$db_path"."par/$base.par&prefijo=".$_REQUEST["prefijo"]."&to=".$_REQUEST["prefijo"]."ZZZ&Opcion=diccionario";

		$resultado=wxisLlamar($base,$query,"ifp.xis");
		$inicio=strlen($_REQUEST["prefijo"]);
		foreach ($resultado as $year){			$year=substr($year,$inicio);
			$ix=strpos($year,'|');
			$arr_year[]=$year;		}

		rsort($arr_year);
		echo "<h3>Presentación por Año de publicación<p>Seleccione un año: <select name=fecha style=height:25px onchange=Buscar(this)>\n";
		echo "<option value=''></option>\n";
		foreach ($arr_year as $value){
			$c=explode('|',$value);
			echo "<option value=\"".$_REQUEST["prefijo"].$c[0]."\">".$c[0]."  (".$c[1].")</option>\n";
        }
		echo "</select></h3>";
		break;}
$Formato="opac.pft";
PresentarRegistros($base,$db_path,$Expresion,$Formato,$count,$desde,1);


if ($total==0){
		echo "<strong>".$_REQUEST["Expresion"]. " No pudo ser localizada en la base de datos</strong>.<p>";
		echo "<br>Use <img src=../images/diccionario.gif> para revisar el diccionario de términos recuperables.";
}

if (basename($_SERVER["SCRIPT_FILENAME"])=="index.php")
	$dir="php/";
else
	$dir="";

if (isset($proximo)){
	if ($proximo<$total){
		echo "<div style='float:left;xwidth:400px;display:inline;'><a href=javascript:history.back()><img src=../images/retroceder.gif alt=Regresar title=Regresar></a></div>" ;
		echo "<div  style='float:right;xwidth:400px;display:inline;'><a href=javascript:document.buscar.submit()><img src=../images/avanzar.gif alt=Continuar title=Continuar></a></div>" ;
		echo "<p><br>";
	}
}
if (isset($_REQUEST["integrada"])and trim($_REQUEST["integrada"])!=""){

	echo "<div id=page style=\"text-align:center;\">\n";
	echo "<h4>Resumen</h4>";
	echo "<div style=\"align:center; margin: 0 auto;   width:50%; border:2px solid #C4D1C0; vertical-align:top;text-align:left;padding:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius:10px;\">";

	echo "<table  width=100% >";
	$integ=explode('||',$_REQUEST["integrada"]);
	foreach ($integ as $value){
		if (trim($value)!=""){
			$v=explode('$$',$value);
			echo "<tr height=30px width=300px><td>".$bd[$v[0]]["titulo"]."</td><td align=right>".$v[1]."</td>";
			echo "<td width=80px align=right><a href=javascript:BuscarBase('".$v[0]."')><img src=../images/lupa.gif></a></td>";
			echo "</tr>\n";
		}
	}
	echo "</table>";
	echo "</div><p>";
}


//echo "<div align=right><a href=javascript:history.back()><img src=../images/retroceder.gif alt=Regresar title=Regresar></a></div>" ;

?>


<?php
include("footer.php");

if (!isset($_REQUEST["resaltar"]) or $_REQUEST["resaltar"]=="S") {    $Expresion=str_replace('"',"",$Expresion);
	echo "\n<SCRIPT LANGUAGE=\"JavaScript\">
	highlightSearchTerms(\"$Expresion\");

	</SCRIPT>\n";
}
?>
<script>

 window.scrollTo(0, 0);
</script>