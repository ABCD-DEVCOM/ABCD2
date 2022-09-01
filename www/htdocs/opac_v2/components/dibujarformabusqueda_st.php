
<div class="container-fluid">
    <div class="row">
<?php include 'nav_forms.php' ?>

        <div class="bg-light col-md col-lg">

<?php

function DibujarFormaBusqueda($Diccio){
global $db_path,$msgstr,$lang;
	$mensaje="";
	$_REQUEST["modo"]="integrado";
	if (!isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){
		$mensaje=$msgstr["metasearch"];
		$archivo=$db_path."opac_conf/".$lang."/avanzada.tab";
	}else{
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){

				$c=explode('|',$_REQUEST["coleccion"]);
				
				if (file_exists($db_path.$_REQUEST["base"]."/".$opac_path."/".$lang."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab")) {
					$archivo=$db_path.$_REQUEST["base"]."/".$opac_path."/".$lang."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab";
				} else { 
					$archivo=$db_path.$_REQUEST["base"]."/".$opac_path."/".$lang."/".$_REQUEST["base"]."_avanzada_col.tab";
				}
			
			}else{
			
				$archivo=$db_path.$_REQUEST["base"]."/".$opac_path."/".$lang."/".$_REQUEST["base"]."_avanzada.tab";
			
			}
		
		}else{
			$mensaje=$msgstr["metasearch"];
			$archivo=$archivo=$db_path."opac_conf/".$lang."/avanzada.tab";
		}
	}

	if (!file_exists($archivo)){
		echo "<br><br><font color=red><h4>";
		if ($mensaje!="")
			echo $mensaje."<br>";
		echo "No existe $archivo</font></h4>";
		$fp=array();
		$camposbusqueda=array();
	}else{
		$fp=file($archivo);
	}
    $EX=array();
	$CA=array();
	$OP=array();
	$campos_tab="";
	foreach ($fp as $linea){
		if (trim($linea)!=""){
			$l=explode('|',$linea);
	    	if ($campos_tab=""){
	    		$campos_tab=$l[1];
	    	}else{
	    		$campos_tab.=' ~~~'.$l[1];
	    	}
			$camposbusqueda[]= rtrim($linea);
		}
	}
   	$expb="";
   	$camb="";
   	if (isset($_REQUEST["prefijo"]) and isset( $_REQUEST["Campos"]) and $_REQUEST["prefijo"] == $_REQUEST["Campos"]) unset($_REQUEST["Campos"]);
   	if (isset($_REQUEST["prefijoindice"]) and !isset($_REQUEST["prefijo"]) ) {
   		$_REQUEST["prefijo"]=$_REQUEST["prefijoindice"];
   		unset($_REQUEST["Campos"]);
   	}
	if (!isset($_REQUEST["Campos"]) and isset($_REQUEST["Sub_Expresion"])){
        foreach ($camposbusqueda as $linea){
        	$x=explode('|',$linea);
        	if ($x[1]==$_REQUEST["prefijo"]){
        		if (substr(urldecode($_REQUEST["Sub_Expresion"]),0,1)=='"')
        			$expb=$expb.$_REQUEST["Sub_Expresion"]." ~~~";
        		else
        			$expb=$expb.'"'.$_REQUEST["Sub_Expresion"]."\" ~~~";
        		$camb=$camb.$_REQUEST["prefijo"]." ~~~";
        	}else{
        		if ($expb==""){
        			$expb="~~~";
        			$camb=$x[1]." ~~~";
        		}else{
        			$expb=$expb." ~~~";
        			$camb=$camb.$x[1]." ~~~";
        		}

        	}
        }
        $_REQUEST["Sub_Expresion"]=$expb;
        $_REQUEST["Campos"]=$camb;
	}
	if (isset($_REQUEST["Sub_Expresion"]) and $_REQUEST["Sub_Expresion"]!=""){
		if (isset($_REQUEST["prefijoindice"]))
			$_REQUEST["Sub_Expresion"]=str_replace($_REQUEST["prefijoindice"],"",$_REQUEST["Sub_Expresion"]);
		$EX=explode('~~~',urldecode($_REQUEST["Sub_Expresion"]));
		$CA=explode('~~~',$_REQUEST["Campos"]);
		if (isset($_REQUEST["Operadores"])){
			$OP=explode('~~~',$_REQUEST["Operadores"]);
		}
	}
	echo "<script>\n";
	echo "var dt= new Array()\n";
	$ix=-1;
	foreach ($camposbusqueda as $linea){
		if (trim($linea)!=""){
			$ix=$ix+1;
			echo "dt[".$ix."]=\"".rtrim($linea)."\"\n";
		}
	}

	$Tope=7;  //significa que se van a colocar 7 cajas de texto con la expresión de búsqueda
	$Tope=$ix;
?>

	</script>
	


	
	<div id="registro" >
	
	<p><?php echo $msgstr["mensajeb"]; ?></p>

	<form method="post" class="row g-3" name="forma1" action="search_advanced.php" onSubmit="Javascript:return false">
	
	<?php
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($lang))     echo "<input type=hidden name=lang value=".$lang.">\n";
	if (isset($_REQUEST["modo"]))     echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
	if (isset($_REQUEST["base"]))     echo "<input type=hidden name=base value=".$_REQUEST['base'].">\n";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">";
	if (isset($_REQUEST["indice_base"]))     echo "<input type=hidden name=base value=".$_REQUEST['indice_base'].">\n";
	if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
	?>
	<input type="hidden" name="Opcion" value="avanzada">
	<input type="hidden" name="resaltar" value="S">
	<input type="hidden" name="Campos" value="">
	<input type="hidden" name="Operadores" value="">
	<input type="hidden" name="Expresion" value="">
	<input type="hidden" name="llamado_desde" value="search_advanced.php">

  <div class="col-md-4">
    <label for="inputCity" class="form-label"><?php echo $msgstr["campo"];?></label>
  </div>
  <div class="col-md-6">
    <label for="inputState" class="form-label"><?php echo $msgstr["expr_b"];?></label>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">#</label>
  </div>
	

	<?php	
	$Diccio=0;
	for ($jx=0;$jx<=$Tope;$jx++){
   		if (isset($EX[$jx])) $EX[$jx]=Trim($EX[$jx]);
   		if (isset($OP[$jx])) $OP[$jx]=Trim($OP[$jx]);
   		if (isset($CA[$jx])) $CA[$jx]=Trim($CA[$jx]);
	?>	
		
		<div class="col-md-4">
			<div class="input-group">
				<select name="camp" class="form-select form-select-sm">
		
			<?php	
			$asel="";

		for ($i=0;$i<count($camposbusqueda);$i++){
			$asel="";
			$c=explode('|',$camposbusqueda[$i]);

			if ($i==$jx) $asel=" selected";
		    echo "<option value=\"".$c[1]."\" $asel>".$c[0]."</option>\n";
		}
		?>

				</select>
		
		
		<a class="btn btn-primary btn-sm" href="javascript:Diccionario(<?php echo $jx;?>)">
			<i class="fas fa-book" alt="<?php echo $msgstr["indice"];?>" title="<?php echo $msgstr["indice"];?>"></i>
		</a>
			</div>
   		</div>

		<?php		
		
		if (isset($_REQUEST["Seleccionados"])){
			if ($_REQUEST["Diccio"]==$jx){
			     if ($_REQUEST["Seleccionados"]!='""') {$Sub_Expr=$_REQUEST["Seleccionados"];}
			}else{
                if (isset($EX[$jx])){
					if ($EX[$jx]!='""') {$Sub_Expr=$EX[$jx];}
				}
			}
		}else{
			if (isset($EX[$jx])){
				if ($EX[$jx]!='""') {$Sub_Expr=$EX[$jx];}
			}
		}
		
		?>

		<div class="col-md-6">
			<input class="form-control form-control-sm" type="text" name="Sub_Expresiones" value='<?php echo $Sub_Expr;?>'>
		</div>

		<?php
		if ($jx<$Tope){
			?>
       		<div class="col-md-2">
				<select class="form-select form-select-sm" name="oper" id="oper_<?php echo $jx;?>" >
       		<?php
				echo "<option value=and ";
       		if (!isset($OP[$jx]) or $OP[$jx]=="and" or $OP[$jx]=="")
       			echo " selected";
       		echo ">AND";
       		echo "<option value=or ";
       		if (isset($OP[$jx]) and $OP[$jx]=="or")
       			echo " selected";
       		echo ">OR";
       		echo "</select></div>";
 		}else {
       		echo "<div class=\"col-md-2\"><input type=hidden name=oper id=oper_$jx></div>";
    	}


	}
	?>
		</div>

		<div class="col-md-12 my-2">
	    	<input class="btn btn-success" type="button" onclick="javascript:PrepararExpresion()" value="<?php echo $msgstr["search"];?>">
			<input class="btn btn-light" type="button" onclick="javascript:LimpiarBusqueda()" value="<?php echo $msgstr["limpiar"];?>">
   
	
		    <div style='overflow: hidden;text-align:left; float:right;display:block;' id='mensajes'></div>
		</div>		


	</form>


	<form name="diccio" method="post" action="/".$opac_path."/components/diccionario_integrado.php">
<?php
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($lang))     echo "<input type=hidden name=lang value=".$lang.">\n";
	if (isset($_REQUEST["base"])) echo "<input type=hidden name=base value=".$_REQUEST['base'].">";
	if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=".$_REQUEST['modo'].">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=".$_REQUEST['indice_base'].">";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST['coleccion']."\">";
	echo "<input type=hidden name=Sub_Expresion>";
	echo "<input type=hidden name=Campos>";
	echo "<input type=hidden name=Operadores>";
	echo "<input type=hidden name=Opcion value=avanzada>";
	echo "<input type=hidden name=prefijo value=\"\">";
	echo "<input type=hidden name=campo value=\"\">";
	echo "<input type=hidden name=id value=\"\">";
	echo "<input type=hidden name=Diccio value=\"\">";
	echo "<input type=hidden name=llamado_desde value='search_advanced.php'>\n";

	echo "</form>";


}



?>
