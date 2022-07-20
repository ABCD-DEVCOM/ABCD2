<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$path="../";
include("../../central/config_opac.php");
include("../leer_bases.php");
$indice_alfa="n";
include("../head.php");

// Para presentar el diccionario de terminos consolidado
include("dibujarformabusqueda_st.php");

//foreach ($_REQUEST as $key =>$value) echo "$key =>".urldecode($value)."<br>";
if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado")
	if (isset($_REQUEST["base"])) unset($_REQUEST["base"]);

if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){
	$base="";
	 echo "<span class=tituloBase>".$msgstr["todos_c"]."</span>";
}else{
	 echo "<span class=tituloBase>".$bd_list[$_REQUEST["base"]]["titulo"]."</span>";

	$base=$_REQUEST["base"];
}

if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!="")  {

		$_REQUEST["coleccion"]=urldecode($_REQUEST["coleccion"]);
		$col=explode('|',$_REQUEST["coleccion"]);
        echo " (<strong><i>".$col[1]."<i></strong>)";

}
 echo "</p>";
?>

<?php
 echo $msgstr["buscar_a"];

 $Diccio=-1;
DibujarFormaBusqueda($Diccio);

?>


<input type="button" id="search-submit" value="<?php echo $msgstr["back"]?>" onclick="javascript:history.back()">

<form name="back" method="post" action="buscar_integrada.php">
<?php
foreach ($_REQUEST as $var=>$value){
	echo "<input type=hidden name=$var value=";
	if (trim($value)!='""') echo urlencode($value);
	echo ">\n";
}
echo "</form>";


?>