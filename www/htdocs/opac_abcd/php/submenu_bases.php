<?php
if (!isset($titulo_pagina)){	//if (isset($_REQUEST["indice_base"]) and $_REQUEST["indice_base"]=="") unset($_REQUEST["integrada"]);
	if (isset($_REQUEST["modo"])and  $_REQUEST["modo"]=="integrado"){
		echo "<span class=tituloBase>".$msgstr["todos_c"]."</STRONG>";
		echo "<input type=hidden name=modo value=integrado>\n";
	}else{		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			echo "<span class=tituloBase>".$bd_list[$_REQUEST["base"]]["titulo"];
			$yaidentificado="S";
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!="") {				$_REQUEST["coleccion"]=urldecode($_REQUEST["coleccion"]);
				$cc=explode('|',$_REQUEST["coleccion"]);
				echo "<br><i>".$cc[1]."</i>";
			}
		}
	}
	echo "</span>";
}
if (!isset($mostrar_libre) or $mostrar_libre!="N"){

	echo "<div id=searchBox>
		<form method=\"post\" action=\"buscar_integrada.php\" name=libre>
		<div id=\"search\" >\n";
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($_REQUEST["lang"]))     echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
    if (isset($_REQUEST["Formato"]))echo "<input type=hidden name=indice_base value=".$_REQUEST["Formato"].">\n";
    if (isset($_REQUEST["indice_base"]))echo "<input type=hidden name=indice_base value=".$_REQUEST["indice_base"].">\n";
	if (isset($_REQUEST["base"]))echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
	if (isset($_REQUEST["modo"]))echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
	?>
			<input type="text" name="Sub_Expresion" id="search-text" value="" placeholder="<?php echo $msgstr["search"]?>  ..."/>
			<input type="submit"  value="<?php echo $msgstr["search"]?>"><br>
			<?php
	if (!isset($BusquedaAvanzada) or isset($BusquedaAvanzada) and $BusquedaAvanzada=="S"){
?>
			<input type="button" value="<?php echo $msgstr["buscar_a"]?>"  onclick="javascript:document.libre.action='avanzada.php';document.libre.submit();"/>


    		<?php
	}

	if (!isset($_REQUEST["submenu"]) or $_REQUEST["submenu"]!="N"){		$archivo="";
		if (isset($_REQUEST["modo"])){			IF ($_REQUEST["modo"]=="integrado"){				$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/indice.ix";			}else{				$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"].".ix";			}		}
		if (file_exists($archivo)){
			echo "&nbsp; &nbsp; <input type=button value=\"".$msgstr["indice_alfa"]."\" onclick=\"showhide('sub_menu')\">";
		}
	}
?>
	</div>
	<div id="more">
		<table>
			<td valign=top>
           		<input type=button height=50 value="<?php echo $msgstr["diccionario"]?>" onclick="javascript:DiccionarioLibre(0)">
       		</td>
       		<td>
       			<font class=titulo2><?php echo $msgstr["resultados_inc"]?><br></font>
	        	<input type=radio value=and name=alcance id=and><font class=titulo2><?php echo $msgstr["todas_p"]?><br>
	        	<input type=radio value=or name=alcance id=or  checked><?php echo $msgstr["algunas_p"]?></font>
   	    	</td>
   		</table>
   	</div>
<?php
}
if (!isset($_REQUEST["submenu"]) or $_REQUEST["submenu"]!="N") {
?>

<div style="clear:both;"></div>
    <div id="sub_menu" style="display: none;" name=sub_menu>
		<ul>
<?php

$php_path="";
if ($multiplesBases=="S" and isset($_REQUEST["base"])){
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
}else{	if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
		$col=explode("|",$_REQUEST["coleccion"]);
		$archivo=$_REQUEST["base"].'_'.$col[0].".ix";
	}else{
		$archivo=$_REQUEST["base"].".ix";
	}
	$base=$_REQUEST["base"];
}
if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$archivo")){
	$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$archivo");
	foreach ($fp as $value){
		$val=trim($value);
		if ($val!=""){
			$v=explode('|',$val);
			if (isset($v[3]) and trim($v[3])!="")
				$columnas=$v[3];
			else
				$columnas=1;

			echo "<li><a href='Javascript:ActivarIndice(\"".str_replace("'","´",$v[0])."\",$columnas,\"inicio\",90,1,\"".$v[1]."\",\""."$base\")'>".$v[0]."</a></li>\n";
		}
	}
}
if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){	$archivo="libre.tab";
}else{
	$archivo=$_REQUEST["base"]."_libre.tab";
}
//echo $archivo;
if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$archivo")){	$prefijo="TW_";
}else{	$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$archivo");
	foreach ($fp as $linea){		$linea=trim($linea);
		if ($linea!=""){			$x=explode('|',$linea);
			$prefijo=$x[2];
			break;		}	}}?>

		</ul>
	</div>
    	<input type=hidden name=Opcion value=libre>
   		<input type=hidden name=prefijo value=<?php echo $prefijo;?>
   		<input type=hidden name=resaltar value="S">
   		<?php if (isset($_REQUEST["coleccion"])) {
   			echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
   		}
   		?>
   	</form>
   	<div style="clear:both;"></div>

<?php
}
if ($actualScript=="index.php") {	unset($_REQUEST["base"]);
}


echo "</div>";
?>

