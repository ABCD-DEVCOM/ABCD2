<?php

function DibujarFormaBusqueda($Diccio){
global $db_path,$msgstr,$Web_Dir;
	$mensaje="";
	if (!isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){
		$mensaje=$msgstr["front_metasearch"];
		$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/avanzada.tab";
	}else{
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){

				$c=explode('|',$_REQUEST["coleccion"]);
				
				if (file_exists($db_path.$_REQUEST["base"]."/opac/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab")) {
					$archivo=$db_path.$_REQUEST["base"]."/opac/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab";
				} else { 
					$archivo=$db_path.$_REQUEST["base"]."/opac/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_col.tab";
				}
			
			}else{
			
				$archivo=$db_path.$_REQUEST["base"]."/opac/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada.tab";
			
			}
		
		}else{
			$mensaje=$msgstr["front_metasearch"];
			$archivo=$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/avanzada.tab";
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

	$Tope=7;  //significa que se van a colocar 7 cajas de texto con la expresi�n de b�squeda
	$Tope=$ix;
?>

</script>

<p><?php echo $msgstr["front_mensajeb"]; ?></p>

<div id="registro">

<form method="GET" name="forma1" action="avanzada.php" onSubmit="Javascript:return false">
	<?php
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($_REQUEST["lang"]))     echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
	if (isset($_REQUEST["modo"]))     echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
	if (isset($_REQUEST["base"]))     echo "<input type=hidden name=base value=".$_REQUEST['base'].">\n";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">";
	if (isset($_REQUEST["indice_base"]))     echo "<input type=hidden name=base value=".$_REQUEST['indice_base'].">\n";
	if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
?>

	<input type="hidden" name="page" value="startsearch">
	<input type="hidden" name="Opcion" value="avanzada">
	<input type="hidden" name="resaltar" value=S>
	<input type="hidden" name="Campos" value="">
	<input type="hidden" name="Operadores" value="">
	<input type="hidden" name="Expresion" value="">
	<input type="hidden" name="llamado_desde" value="avanzada.php">



	



	<div class="row">
		<div class="col-4"><?php echo $msgstr["front_campo"]; ?></div>
		<div class="col-6"><?php echo $msgstr["front_expr_b"]; ?></div>
	</div>

<?php
	$Diccio=0;
	for ($jx=0;$jx<=$Tope;$jx++){
   		if (isset($EX[$jx])) $EX[$jx]=Trim($EX[$jx]);
   		if (isset($OP[$jx])) $OP[$jx]=Trim($OP[$jx]);
   		if (isset($CA[$jx])) $CA[$jx]=Trim($CA[$jx]);
?>		
	<div class="row">
		<div class="col-10 col-sm-3 px-1 my-2">
			<select name="camp" class="form-select">

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
		</div>
		
		<div class="col-2 col-sm-1 px-1 my-2">
            <a class="btn btn-secondary" href="javascript:Diccionario(<?php echo $jx;?>)">
                <i class="fas fa-book" alt="<?php echo $msgstr["front_indice"];?>" title="<?php echo $msgstr["front_indice"];?>"></i>
            </a>
   		</div>

		<div class="col-12 col-sm-6 px-1 my-2">
			<?php echo'<input class="form-control" type="text" size="80" name="Sub_Expresiones"';
			echo "value='";
			if (isset($_REQUEST["Seleccionados"])){
					if ($_REQUEST["Diccio"]==$jx){
						if ($_REQUEST["Seleccionados"]!='""') echo $_REQUEST["Seleccionados"];
					} else {
						if (isset($EX[$jx])){
							if ($EX[$jx]!='""') echo $EX[$jx];
						}
					}
				}else{
					if (isset($EX[$jx])){
						if ($EX[$jx]!='""')echo $EX[$jx];
					}
				}
				echo "' >";
		?>
		</div>

		<?php if ($jx<$Tope){ ?>	
       	<div class="col-12 col-sm-2 px-1 my-2">
			<select name="oper" id="oper_<?php echo $jx;?>" size="1" class="form-select">
                <option value="and" <?php if (!isset($OP[$jx]) or $OP[$jx]=="and" or $OP[$jx]=="") echo " selected";?> >AND</option>
                <option value="or" <?php if (isset($OP[$jx]) and $OP[$jx]=="or") echo " selected";?> >OR</option>
            </select>
        <?php } else { ?>
                <input type="hidden" name="oper" id="oper_<?php echo $jx;?>">
        <?php } ?>
        </div>
    </div><!--./row-->

<?php } ?>
<div class="row g-3 py-2">
    <div class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
        <input class="btn btn-secondary" type="button" id="search-submit" value="<?php echo $msgstr["front_back"]?>" onclick="javascript:history.back()">
    </div>
    <div class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
	    <input class="btn btn-secondary" type="button" onclick="javascript:LimpiarBusqueda()" value="<?php echo $msgstr["front_limpiar"];?>">
    </div>
    <div class="col-md-4 col-xs-12 d-grid gap-2 d-xs-block">
		<input class="btn btn-success" type="button" onclick="javascript:PrepararExpresion()" value="<?php echo $msgstr["front_search"];?>">
    </div>
</div>
</form>

</div>

<div style='overflow: hidden;text-align:left; float:right;display:block;' id='mensajes'></div>
	
<form name="diccio" method="GET" action="diccionario_integrado.php">
<?php
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($_REQUEST["lang"]))     echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
	if (isset($_REQUEST["base"])) echo "<input type=hidden name=base value=".$_REQUEST['base'].">";
	if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=".$_REQUEST['modo'].">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=".$_REQUEST['indice_base'].">";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST['coleccion']."\">";
?>
		<input type="hidden" name="page" value="startsearch">
	<input type="hidden" name="Sub_Expresion">
	<input type="hidden" name="Campos">
	<input type="hidden" name="Operadores">
	<input type="hidden" name="Opcion" value="avanzada">
	<input type="hidden" name="prefijo" value="">
	<input type="hidden" name="campo" value="">
	<input type="hidden" name="id" value="">
	<input type="hidden" name="Diccio" value="">
	<input type="hidden" name="llamado_desde" value="avanzada.php">

	</form>

<?php } ?>
