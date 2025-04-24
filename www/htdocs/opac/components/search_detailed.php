<?php

$startpage="N";

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
 echo "</p>";
?>


 <h4><?php echo $msgstr["front_buscar_a"]; ?></h4>
	<?php
		$Diccio=-1;
		DibujarFormaBusqueda($Diccio);
	?>

<form name="back" method="post" action="buscar_integrada.php">
	<input type="hidden" name="page" value="startsearch">
<?php
	foreach ($_REQUEST as $var=>$value){
		echo "<input type=hidden name=$var value=";
		if (trim($value)!='""') echo urlencode($value);
		echo ">\n";
	}
?>
</form>
