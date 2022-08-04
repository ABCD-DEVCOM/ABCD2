<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$indice_alfa="n";
include("../common/opac-head.php");

// Para presentar el diccionario de terminos consolidado
include($_SERVER['DOCUMENT_ROOT'] . "/opac/components/dibujarformabusqueda_st.php");

//foreach ($_REQUEST as $key =>$value) echo "$key =>".urldecode($value)."<br>";
if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado")
	if (isset($_REQUEST["base"])) unset($_REQUEST["base"]);

if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){
	$base="";
	 echo "<h2>".$msgstr["todos_c"]."</h2>";
}else{
	 echo "<h2>".$bd_list[$_REQUEST["base"]]["titulo"]."</h2>";

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