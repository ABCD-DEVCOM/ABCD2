<?php

function DibujarFormaBusqueda($Diccio){global $db_path,$msgstr;
	$mensaje="";
	if (!isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){
		$mensaje=$msgstr["metasearch"];
		$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/avanzada.tab";
	}else{
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
				$c=explode('|',$_REQUEST["coleccion"]);
				if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab"))
					$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_".$c[0].".tab";
				else
					$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada_col.tab";
			}else{
				$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_avanzada.tab";
			}
		}else{			$mensaje=$msgstr["metasearch"];
			$archivo=$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/avanzada.tab";
		}
	}
	if (!file_exists($archivo)){
		echo "<br><br><font color=red><h4>";		if ($mensaje!="")
			echo $mensaje."<br>";		echo "No existe $archivo</font></h4>";
		$fp=array();
		$camposbusqueda=array();
	}else{		$fp=file($archivo);	}
    $EX=array();
	$CA=array();
	$OP=array();
	$campos_tab="";
	foreach ($fp as $linea){
		if (trim($linea)!=""){			$l=explode('|',$linea);
	    	if ($campos_tab=""){
	    		$campos_tab=$l[2];
	    	}else{
	    		$campos_tab.=' ~~~'.$l[2];
	    	}			$camposbusqueda[]= rtrim($linea);
		}
	}
   	$expb="";
   	$camb="";
   	if (isset($_REQUEST["prefijo"]) and isset( $_REQUEST["Campos"]) and $_REQUEST["prefijo"] == $_REQUEST["Campos"]) unset($_REQUEST["Campos"]);
   	if (isset($_REQUEST["prefijoindice"]) and !isset($_REQUEST["prefijo"]) ) {   		$_REQUEST["prefijo"]=$_REQUEST["prefijoindice"];
   		unset($_REQUEST["Campos"]);   	}
	if (!isset($_REQUEST["Campos"]) and isset($_REQUEST["Sub_Expresion"])){
        foreach ($camposbusqueda as $linea){        	$x=explode('|',$linea);
        	if ($x[2]==$_REQUEST["prefijo"]){
        		if (substr(urldecode($_REQUEST["Sub_Expresion"]),0,1)=='"')        			$expb=$expb.$_REQUEST["Sub_Expresion"]." ~~~";
        		else
        			$expb=$expb.'"'.$_REQUEST["Sub_Expresion"]."\" ~~~";
        		$camb=$camb.$_REQUEST["prefijo"]." ~~~";        	}else{        		if ($expb==""){        			$expb="~~~";
        			$camb=$x[2]." ~~~";        		}else{        			$expb=$expb." ~~~";
        			$camb=$camb.$x[2]." ~~~";        		}
        	}
        }
        $_REQUEST["Sub_Expresion"]=$expb;
        $_REQUEST["Campos"]=$camb;	}
	if (isset($_REQUEST["Sub_Expresion"]) and $_REQUEST["Sub_Expresion"]!=""){		if (isset($_REQUEST["prefijoindice"]))			$_REQUEST["Sub_Expresion"]=str_replace($_REQUEST["prefijoindice"],"",$_REQUEST["Sub_Expresion"]);
		$EX=explode('~~~',urldecode($_REQUEST["Sub_Expresion"]));
		$CA=explode('~~~',$_REQUEST["Campos"]);
		if (isset($_REQUEST["Operadores"])){			$OP=explode('~~~',$_REQUEST["Operadores"]);
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
	echo "</script>\n";
	echo '<div id=registro STYLE="text-align:center;">';
	echo "<form method=post name=forma1 action=avanzada.php onSubmit=\"Javascript:return false\">\n";
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($_REQUEST["lang"]))     echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
	if (isset($_REQUEST["modo"]))     echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
	if (isset($_REQUEST["base"]))     echo "<input type=hidden name=base value=".$_REQUEST['base'].">\n";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">";
	if (isset($_REQUEST["indice_base"]))     echo "<input type=hidden name=base value=".$_REQUEST['indice_base'].">\n";
	if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
	echo "<input type=hidden name=Opcion value=avanzada>\n";
	echo "<input type=hidden name=resaltar value=S>\n";
	echo "<input type=hidden name=Campos value=\"\">\n";
	echo "<input type=hidden name=Operadores value=\"\">\n";
	echo "<input type=hidden name=Expresion value=\"\">\n";
	echo "<input type=hidden name=llamado_desde value=\"avanzada.php\">\n";
	echo "<table border=0 valign=center cellpadding=0 cellspacing=3 width=680>";
	echo "	<tr>";
	echo "		<td colspan=4 style='font-size:12px;' align=center>";
	echo $msgstr["mensajeb"];
//	echo "			Seleccione un campo de búsqueda e inserte términos de la información que desea localizar. ";
//	echo "			Puede ingresar información en más de un campo. Haga clic sobre <img src=../images/diccionario.gif> para presentar el índice de términos recuperables.";
	echo "		</td>
			</tr>";
	echo "	<tr>
				<td bgcolor=#222222 colspan=2><font face=verdana size=1 color=white><b>".$msgstr["campo"]."</b></td>";
	echo "		<td bgcolor=#222222 colspan=2><font face=verdana size=1 color=white><b>".$msgstr["expr_b"]."</b>
				</td>
			</tr>";
	$Diccio=0;
	for ($jx=0;$jx<=$Tope;$jx++){   		if (isset($EX[$jx])) $EX[$jx]=Trim($EX[$jx]);
   		if (isset($OP[$jx])) $OP[$jx]=Trim($OP[$jx]);
   		if (isset($CA[$jx])) $CA[$jx]=Trim($CA[$jx]);
		echo "<tr>
				<td  valign=center width=155>";
		echo "		<SELECT name=camp class=select-criterio>";
		$asel="";

		for ($i=0;$i<count($camposbusqueda);$i++){
			$asel="";
			$c=explode('|',$camposbusqueda[$i]);

			if ($i==$jx) $asel=" selected";
		    echo "<OPTION value=\"".$c[2]."\" $asel>".$c[0]."</option>\n";
		}
		echo "		</SELECT></TD>\n";
		//echo "<td width=20>xx<input type=\"button\" onclick=\"Diccionario($jx);\" class=\"button-diccionario\">";
		echo "<td>";
		echo "<a href=\"javascript:Diccionario($jx)\"><img src=../images/diccionario.gif alt=\"".$msgstr["indice"]."\" title=\"".$msgstr["indice"]."\"></a>";
   		echo "	</td>";


		echo "	<td NOWRAP width=100><input type=text style='font-size:10px' size=80 name=Sub_Expresiones value='";
		if (isset($_REQUEST["Seleccionados"])){
			if ($_REQUEST["Diccio"]==$jx){
			     if ($_REQUEST["Seleccionados"]!='""') echo $_REQUEST["Seleccionados"];
			}else{
                if (isset($EX[$jx])){
					if ($EX[$jx]!='""') echo $EX[$jx];
				}
			}
		}else{
			if (isset($EX[$jx])){
				if ($EX[$jx]!='""')echo $EX[$jx];
			}
		}

		echo "'></td>\n";
		if ($jx<$Tope){
       		echo "<td NOWRAP><select name=oper id=oper_$jx size=1 style='font-size:12px'>";
       		echo "<option value=and ";
       		if (!isset($OP[$jx]) or $OP[$jx]=="and" or $OP[$jx]=="")
       			echo " selected";
       		echo ">y";
       		echo "<option value=or ";
       		if (isset($OP[$jx]) and $OP[$jx]=="or")
       			echo " selected";
       		echo ">o";
       		echo "</select></td>";
 		}else {
       		echo "<td><input type=hidden name=oper id=oper_$jx></td>";
    	}


	}
	echo "<tr height=10>\n";
	echo "	<td colspan=5 align=center class=menu></td>\n";
	echo "<tr>\n";
	echo "<tr height=10>\n";
	echo "	<td colspan=5 align=center>";
	echo "		<br><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 width=560>";

	echo "<td align=center><input type=button onclick=javascript:PrepararExpresion() value='".$msgstr["search"]."'> &nbsp; &nbsp;
	      <input type=button onclick=javascript:LimpiarBusqueda() value='".$msgstr["limpiar"]."'>";
    echo "<div style='overflow: hidden;text-align:left; float:right;display:block;' id='mensajes'></div> </td>\n";
	echo "			</TABLE>
				</td>
			</tr>
		</table>\n";

	echo "</form>";
	echo "<form name=diccio method=post action=diccionario_integrado.php>";
	if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	if (isset($_REQUEST["lang"]))     echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
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
	echo "<input type=hidden name=llamado_desde value='avanzada.php'>\n";

	echo "</form>";


}



?>
