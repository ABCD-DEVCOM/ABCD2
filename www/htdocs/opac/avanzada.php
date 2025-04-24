<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// Para presentar el diccionario de terminos consolidado

include("../central/config_opac.php");
$indice_alfa="n";
$mostrar_libre="N";
include("head.php");



//foreach ($_REQUEST as $key =>$value) echo "$key =>".urldecode($value)."<br>";
if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado")
	if (isset($_REQUEST["base"])) unset($_REQUEST["base"]);

if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){
	$base="";
	 echo "<span class=tituloBase>".$msgstr["front_todos_c"]."</span>";
}else{
	 echo "<span class=tituloBase>".$bd_list[$_REQUEST["base"]]["titulo"]."</span>";

	$base=$_REQUEST["base"];
}

if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!="")  {

		$_REQUEST["coleccion"]=urldecode($_REQUEST["coleccion"]);
		$col=explode('|',$_REQUEST["coleccion"]);
        echo " (<strong><i>".$col[1]."<i></strong>)";

}
?>

</p>


<?php include("views/footer.php"); ?>