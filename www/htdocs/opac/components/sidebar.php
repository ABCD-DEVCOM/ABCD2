<aside id="sidebar" class="d-md-block flex-column flex-shrink-0 p-3 sidebar collapse">
	<?php
//col-md-3 col-lg-2 d-md-block bg-light sidebar collapse
	//include_once ('components/facets.php');
	//include_once ('alfabetico.php');

	if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"])=="" ){

	//include_once ('components/indexes.php');

	include_once ('components/online_statment.php');

	include_once ('components/more_links.php');
		
	}
	?>
</aside>


<form name="bi" action="buscar_integrada.php" method="post">
	<input type="hidden" name="base">
	<input type="hidden" name="cipar">
	<input type="hidden" name="Opcion">
	<input type="hidden" name="coleccion">
	<input type="hidden" name="Expresion">
	<input type="hidden" name="titulo_c">
	<input type="hidden" name="resaltar">
	<input type="hidden" name="submenu">
	<input type="hidden" name="Pft">
	<input type="hidden" name="mostrar_exp">
	<input type="hidden" name="home">
	<?php
	echo "<input type=hidden name=modo value=\"";
	if (isset($_REQUEST["modo"])) echo $_REQUEST["modo"];
	echo "\">\n";
	if (isset($_REQUEST["integrada"]))
		echo "<input type=hidden name=integrada value=\"".str_replace('"','&quot;',$_REQUEST["integrada"])."\">\n";
	if (isset($_REQUEST["db_path"]))
		echo "<input type=hidden name=db_path value=\"".str_replace('"','&quot;',$_REQUEST["db_path"])."\">\n";
	if (isset($lang))
		echo "<input type=hidden name=lang value=\"".str_replace('"','&quot;',$lang)."\">\n";
	?>
</form>


<script>

function BuscarIntegrada(base,modo,Opcion,Expresion,Coleccion,titulo_c,resaltar,submenu,Pft,mostrar_exp){
	if (mostrar_exp!="") document.bi.action="inicio_base.php"
	document.bi.base.value=base
	document.bi.Opcion.value=Opcion
	document.bi.modo.value=modo
	document.bi.home.value=mostrar_exp

	if (Opcion=="libre"){
		document.bi.coleccion.value=Coleccion
		document.bi.Expresion.value=Expresion
	}

	if (Opcion=="directa"){
		document.bi.Expresion.value=Expresion
		document.bi.titulo_c.value=titulo_c
		document.bi.resaltar.value=resaltar
		document.bi.submenu.value=submenu
		document.bi.Pft.value=Pft
		document.bi.mostrar_exp.value=mostrar_exp
	}
	document.bi.submit()
}
</script>