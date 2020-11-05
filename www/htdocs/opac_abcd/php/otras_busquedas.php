<?php
include("config.php");
include("leer_bases.php");
include("tope.php");
//foreach ($_REQUEST as $key=>$value) echo "$key=$value<br>";
if (isset($_REQUEST["base"])){
	 echo "<span class=tituloBase>".$bd_list[$_REQUEST["base"]]["titulo"]."</span>";
	 echo "<br>".$bd_list[$_REQUEST["base"]]["descripcion"]."<br>";
	 $base=$_REQUEST["base"];
}else{	$base="";}
unset($_bd_list);
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_REQUEST["desde"])) $_REQUEST["desde"]=1;
if (!isset($_REQUEST["count"])) $_REQUEST["count"]=25;
$desde=$_REQUEST["desde"];
$count=$_REQUEST["count"];
$Expresion="";
?>

<p>
<h4><strong>Búsqueda libre</strong></h4>
    	<form method="post" action="buscar_integrada.php" name=diccio>
			<br><strong>Alcance</strong></br>
			<font class=titulo2>Incluir en los resultados las referencias que contengan<br>
			<input type=radio value=and name=alcance id=and checked>Todos los términos de búsqueda (and)<br>
			<input type=radio value=or name=alcance id=or>Alguno(s) de los términos de búsqueda (or)</font>
			<br><strong>Términos de búsqueda</strong></br>
	        <input type=hidden name=prefijo value=TW_>
	  		<input type=hidden name=Opcion value=libre>
	  		<input type=hidden name=base value=<?php if (isset($_REQUEST["base"]))echo $_REQUEST["base"]?>>
	      	<input type="text" id="search-text" name="Sub_Expresion" value="" />
	      	<input type="submit" id="search-submit" value="Buscar" /><p><br>
			<input type="button" id="search-submit" value="Consultar diccionario" onclick="javascript:DiccionarioLibre('1')"/>
		</form>
		<p><br><br><br>
		<hr>Seleccione del menú el tipo de búsqueda que desea realizar:
		<p><ul class=submenu>
			<LI>Búsqueda libre: Permite localizar información a partir de términos generales en cualquiera de los campos de la base de datos<br><br></li>
			<li>Búsqueda avanzada: Permite realizar búsquedas más precisas, a través de la construcción de sub-expresiones dentro de los diferentes campos de la base de datos<br><br></li>
			<li>Índices de
<?php
$fp=file($path."data/$base.ix");
foreach ($fp as $value){
	$val=trim($value);
	if ($val!=""){
		$v=explode('|',$val);
		echo "<strong>".$v[0]."</strong>, \n";
	}
}
?>
para presentar el índice solicitado y a partir del mismo proceder a la recuperación de los registros</li>
		</ul>
<br><br>
<?php
include("footer.php");


?>
