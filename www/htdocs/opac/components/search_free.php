<?php
/*
20220307 rogercgui fixed index $prefijo=$x[1];
*/
?>


<?php
if (!isset($titulo_pagina)){
	//if (isset($_REQUEST["indice_base"]) and $_REQUEST["indice_base"]=="") unset($_REQUEST["integrada"]);
	if (isset($_REQUEST["modo"]) and  $_REQUEST["modo"]=="integrado"){
	?>	
		<h6 class="text-dark"><?php echo $msgstr["front_todos_c"];?></h6>
		<input type="hidden" name="modo" value="integrado">
	<?php
	}else{
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			echo "<h6 class=\"text-dark\">".$bd_list[$_REQUEST["base"]]["titulo"];
			$yaidentificado="S";
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!="") {
				$_REQUEST["coleccion"]=urldecode($_REQUEST["coleccion"]);
				$cc=explode('|',$_REQUEST["coleccion"]);
				echo " > <i>".$cc[1]."</i>";
			}
		}
	}
	echo "</h6>";
}


if (!isset($mostrar_libre) or $mostrar_libre!="N"){
?>
<div id="search">
<form method="get" action="buscar_integrada.php" name="libre">
	<input type="hidden" name="page" value="startsearch">
		<?php
		
		if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
		if (isset($lang)) echo "<input type=hidden name=lang value=".$lang.">\n";
		if (isset($_REQUEST["Formato"]))echo "<input type=hidden name=indice_base value=".$_REQUEST["Formato"].">\n";
		if (isset($_REQUEST["indice_base"]))echo "<input type=hidden name=indice_base value=".$_REQUEST["indice_base"].">\n";
		if (isset($_REQUEST["base"]))echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
		if (isset($_REQUEST["modo"]))echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
		if (isset($_REQUEST['Sub_Expresion'])) $_REQUEST['Sub_Expresion']=urldecode(str_replace('~','',$_REQUEST['Sub_Expresion']));
		?>
<div class="row g-3">
	<div class="col-md-6">
		<input class="form-control" type="text" name="Sub_Expresion" id="search-text" value="<?php if (isset($_REQUEST['Sub_Expresion'])) echo htmlentities($_REQUEST['Sub_Expresion']);?>" placeholder="<?php echo $msgstr["front_search"]?>  ..."/>
	</div>
	<div class="col-md-3">
		<?php include $Web_Dir.'views/dropdown_db.php'; ?>
	</div>
	<div class="col-md-3">
		<button type="submit"  class="btn btn-success btn-submit mb-3 w-100"><i class="fa fa-search"></i> <?php echo $msgstr["front_search"]?></button>
	</div>
</div>

<!-- // Buttons -->

<div class="row g-3">

	<div class="col-auto">
		<label class="text-secondary"><?php echo $msgstr["front_resultados_inc"]?> </label>

		<?php
			$alcance = $_REQUEST['alcance'] ?? 'or'; // Get alcance or default to 'or'
		?>

		<div class="form-check">
			<input type="radio" value="and" name="alcance" id="and" class="form-check-input" <?php if ($alcance === 'and') echo 'checked'; ?>>
			<label class="form-check-label text-secondary"><?php echo $msgstr["front_todas_p"]?> </label>
		</div>

		<div class="form-check">
			<input type="radio" value="or" name="alcance" id="or" class="form-check-input" <?php if ($alcance === 'or') echo 'checked'; ?>>
			<label class="form-check-label text-secondary"><?php echo $msgstr["front_algunas_p"]?></label>
		</div>
	</div><!--/more-->
</div>

<div class="row g-3 py-2">
	<?php if (!isset($BusquedaAvanzada) or isset($BusquedaAvanzada) and $BusquedaAvanzada=="S"){ ?>

		<div class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
  				<button type="button" class="btn btn-secondary" onclick="javascript:document.detailed.submit();"/><?php echo $msgstr["front_buscar_a"]?></button>
		</div>

	<?php  } ?>


	<?php 
	if (!isset($_REQUEST["submenu"]) or $_REQUEST["submenu"]!="N"){
		$archivo="";
		if (isset($_REQUEST["modo"])){
			if ($_REQUEST["modo"]=="integrado"){
				$archivo=$db_path."/opac_conf/".$lang."/indice.ix";
			}else{
				$archivo=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$_REQUEST["base"].".ix";
			}
		}
	?>
	
	<?php if (file_exists($archivo)){ ?>
		<div class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
			<button type="button" class="btn btn-secondary" onclick="showhide('sub_menu')"> <?php echo $msgstr["front_indice_alfa"];?></button>
		</div>
		
		<?php }  } ?>



		<div id="more" class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
   			<!--<input type=button class="btn btn-secondary" value="<?php echo $msgstr["front_diccionario"]?>" onclick="javascript:DiccionarioLibre(0)">-->
		</div>	
</div><!--/row-->
</div><!--/searc-->

<?php } ?>

<?php if (!isset($_REQUEST["submenu"]) or $_REQUEST["submenu"]!="N") { ?>

<div style="clear:both;"></div>
    <div id="sub_menu" style="display: none;" name=sub_menu>
		<ul>
			<?php
			$php_path="";
			if ($multiplesBases=="Y" and isset($_REQUEST["base"])){
				$base="base=".$_REQUEST["base"];
				$dbname=$_REQUEST["base"];
			}else{
				$base="";
				$dbname="";
			}

	if (isset($Home))
		echo "<li><a href=$Home>Home</a></li>\n";
	$multipleBases="S";

	if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){
		$archivo="indice.ix";
		$base="";
		$file_ix=$db_path."opac_conf/".$lang."/".$archivo;
	} else {
		if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
			$col=explode("|",$_REQUEST["coleccion"]);
			$archivo=$_REQUEST["base"].'_'.$col[0].".ix";
			$file_ix=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$archivo;
		}else{
			$archivo=$_REQUEST["base"].".ix";
			$file_ix=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$archivo;
		}

		$base=$_REQUEST["base"];
	}

	if (file_exists($file_ix)){
		$fp=file($file_ix);
		foreach ($fp as $value){
			$val=trim($value);
			if ($val!=""){
				$v=explode('|',$val);
				if (isset($v[2]) and trim($v[2])!="")
					$columnas=$v[2];
				else
					$columnas=1;

				echo "<li><a href='Javascript:ActivarIndice(\"".str_replace("'","�",$v[0])."\",$columnas,\"inicio\",90,1,\"".$v[1]."\",\""."$base\")'>".$v[0]."</a></li>\n";
			}
		}
	}
	if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){
		$archivo="libre.tab";
	} else {
		$archivo=$_REQUEST["base"]."_libre.tab";
	}
//echo $archivo;
if (!file_exists($db_path.$base."/opac/".$lang."/$archivo")){
	$prefijo="TW_";
}else{
	$fp=file($db_path.$base."/opac/".$lang."/$archivo");

	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			$x=explode('|',$linea);
			$prefijo=$x[1];
			break;
		}
	}
}

?>


		</ul>
	</div> <!--./#sub_menu-->
    	<input type="hidden" name="Opcion" value="libre">
   		<input type="hidden" name="prefijo" value="<?php echo $prefijo;?>" >
   		<input type="hidden" name="resaltar" value="S">
   		<?php if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";?>
   	</form>

	<form method="post" name="detailed">
		<input type="hidden" name="search_form" value="detailed">
		<input type="hidden" name="lang" value="<?php echo $lang;?>">
		<?php if (isset($_REQUEST["base"]))echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n"; ?>
		<?php if (isset($_REQUEST["modo"]))echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n"; ?>
	</form>

<?php } ?>

<?php
if ($actualScript=="index.php") {
	unset($_REQUEST["base"]);
}
?>

