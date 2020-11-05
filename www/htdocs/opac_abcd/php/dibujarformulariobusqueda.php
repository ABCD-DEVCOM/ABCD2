 <script>
function addRowTable(tableID,subC,accion,valdef) {
		va_def=new Array()
            tag=tableID
            tableID="id_"+tag
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            initRow=0
            nfilas=rowCount
            var colCount = table.rows[initRow].cells.length;
            for(var i=0; i<colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.vAlign = 'top';
                newcell.setAttribute("bgColor","#FFFFFF");
                if (i==1) {                	newcell.innerHTML ="<input type=\"button\" onclick=\"Diccionario("+nfilas+");\" class=\"button-diccionario\">"                }else{
               	 	newcell.innerHTML = table.rows[initRow].cells[i].innerHTML;
                }

        	}

        	subC="abc"
        	names=Array()
        	names[0]="camp"
        	names[1]="Sub_Expresiones"
        	names[2]="oper"
            if (subC.length>0){	            for (i=0;i<subC.length;i++){
	            	sc=""
	                if (subC!="")
	                	sc="_"+subC.substr(i,1)
	                	lsc=subC.substr(i,1)
	            	newName="tag"+tag+"_"+nfilas+sc
	            	Ctrl=eval("document.forma1."+names[i])
	            	Ctrl=Ctrl[nfilas]
                    if (accion=="add"){
		            	switch (Ctrl.type){
		            		case "text":
		            			if (lsc in va_def)
		            				Ctrl.value=va_def[lsc]
		          				else
		            				Ctrl.value=""
		            			break;
		            		case "textarea":
		            			if (lsc in va_def)
		            				Ctrl.value=va_def[lsc]
		          				else
		            				Ctrl.value=""
		            			mlt=tag+"_0"+sc
		            			text_counter=eval("document.forma1.rem"+tag+"_"+nfilas+sc)
		            			if (text_counter){
	                               text_counter.value=max_l[mlt]
		            			}
		            			break;
		            		case "checkbox":
		              			Ctrl.checked = false;
		                 		break;
		                 	 case "select-one":
		                   		Ctrl.selectedIndex = 0;
		                     	break;
		                     case "radio":
		                        Ctrl.checked = false;
		                 		break;

		            	}
		       		}else{
		       			prev_val=nfilas-1
		       			oldName="tag"+tag+"_"+prev_val+sc
	            		Ctrl_new=eval("document.forma1."+newName)
	            		Ctrl_old=eval("document.forma1."+oldName)
	            		switch (Ctrl.type){
		            		case "text":
		            			Ctrl_new.value=""
		            			break;
		            		case "textarea":
		            			Ctrl_new.value=""
		            			//mlt=tag+"_0"+sc
		            			//text_counter=eval("document.forma1.rem"+tag+"_"+nfilas+sc)
		            			//if (text_counter){
	                            //   text_counter.value=max_l[mlt]
		            			//}
		            			break;
		            		case "checkbox":
		              			Ctrl_new.checked = ""
		                 		break;
		                 	 case "select-one":
		                   		Ctrl_new.selectedIndex =1
		                     	break;
		                     case "radio":
		                        Ctrl_new.checked = ""
		                 		break;
		            	}


		       		}
	            }
			}else{

			}


        }

        function deleteRowTable(row){
            var parent = row.parentNode;
  			var tagName = "table";

  			while (parent) { //Loop through until you find the desired parent tag name
				if (parent.tagName && parent .tagName.toLowerCase() == tagName) {
      				tableID=(parent .id);
      				break;
    			}else{
          			parent = parent .parentNode;
      			}
			}
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
	if (rowCount>1){
    	var i=row.parentNode.parentNode.rowIndex;
    	document.getElementById(tableID).deleteRow(i);
    }else{    	Ctrl=eval("document.forma1.Sub_Expresiones")    	Ctrl.value=""    }
}

function IniciarBusqueda(){	PrepararExpresion('buscar')
}


</script>

<?php

function DibujarFormaBusqueda($Diccio){
global $multiplesBases,$EX,$CA,$OP,$criterios,$db_path;
	$ix=-1;
	if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){		$archivo=$db_path."opac_conf/data/avanzada.tab";	}else{
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
			if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){				$c=explode('|',$_REQUEST["coleccion"]);
				if (file_exists($db_path."opac_conf/".$_REQUEST["base"]."_avanzada_".$c[0].".tab"))
					$archivo=$db_path."opac_conf/".$_REQUEST["base"]."_avanzada_".$c[0].".tab";
				else
					$archivo=$db_path."opac_conf/".$_REQUEST["base"]."_avanzada_col.tab";
			}else{
				$archivo=$db_path."opac_conf/".$_REQUEST["base"]."_avanzada.tab";
			}
		}else{			$archivo=$db_path."opac_conf/avanzada.tab";		}
	}
	$fp = file($archivo);
	echo "<script>\n";
	echo "var dt= new Array()\n";

	$Tope=1;  //significa que se van a colocar 7 cajas de texto con la expresión de búsqueda

	foreach ($fp as $linea){		$linea=trim($linea);
		if ($linea!=""){			$cc=explode('|',$linea);
			if (!isset($cc[3]) or isset($cc[3]) and $cc[3]!="N"){
				$camposbusqueda[]= $linea;
				$ix=$ix+1;
				echo "dt[".$ix."]=\"".$linea."\"\n";
			}
		}
	}

	if (isset($_REQUEST["Campos"])){
		$c=count($CA);
		for ($i=0;$i<$c;$i++){			if (trim($CA[$i])=="" and $i>0){				unset($CA[$i]);
				unset($EX[$i]);
				unset($OP[$i]);			}		}
	}
	$Tope=count($CA);
	if ($Tope==0) $Tope=1;
	echo "</script>\n";
	echo '';
	echo "<form method=post name=forma1 action=buscar_integrada.php onSubmit=\"Javascript:return false\">\n";
	if (isset($_REQUEST["modo"]))        echo "<input type=hidden name=modo value=".$_REQUEST['modo'].">\n";
	if (isset($_REQUEST["base"]))        echo "<input type=hidden name=base value=".$_REQUEST['base'].">\n";
	if (isset($_REQUEST["lista_bases"])) echo "<input type=hidden name=lista_bases value=".$_REQUEST['lista_bases'].">\n";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=".$_REQUEST['indice_base'].">\n";
	echo "<input type=hidden name=Opcion value=avanzada>\n";
	echo "<input type=hidden name=resaltar value=S>\n";
	echo "<input type=hidden name=Campos value=\"\">\n";
	echo "<input type=hidden name=Operadores value=\"\">\n";
	echo "<input type=hidden name=Expresion value=\"\">\n";
    if (isset($_REQUEST["modo"]))
		echo "<input type=hidden name=modo value=".$_REQUEST['modo'].">\n";
	if (isset($_REQUEST["Pft"]))
		echo "<input type=hidden name=Pft value=\"".$_REQUEST["Pft"]."\">\n";
    echo "<div  style='float: left;  width: 440px; overflow: hidden; margin-top:5px;'>\n";
	echo "<table border=0 valign=center cellpadding=0 cellspacing=3 id=id_900 >";
    if ($Tope==1){    	if (count($EX)==0) $EX[]="";    }
	for ($jx=0;$jx<$Tope;$jx++){

		$Diccio=$Diccio+1;
   		if (isset($EX[$Diccio])) $EX[$Diccio]=Trim($EX[$Diccio]);
   		if (isset($OP[$Diccio])) $OP[$Diccio]=Trim($OP[$Diccio]);
   		if (isset($CA[$Diccio])) $CA[$Diccio]=Trim($CA[$Diccio]);
   		if (!isset($EX[$jx])) continue;
   		if (($EX["$jx"]=="" or $EX[$jx]=='""') and count($EX)>1) continue;

		echo "<tr>
				<td  valign=center width=160>";
		echo "		<SELECT name=camp  id=tag900_0_o class=select-criterio>";
		$asel="";
		for ($i=0;$i<count($camposbusqueda);$i++){
			$asel="";
			$c=explode('|',$camposbusqueda[$i]);
            if (trim($c[0])!=""){
				if (isset($CA[$jx]) and $CA[$jx]==$c[2] and $CA[$jx]!=""  )
					$asel=" selected";
				else
					if ($i==$jx and !isset($CA[$jx]))
						$asel=" selected";

			    echo "<OPTION value=".$c[2].$asel.">".$c[0]."\n";
			}
		}
		echo "		</SELECT></td>\n";
		echo "<td width=20><input type=\"button\" onclick=\"Diccionario($jx);\" class=\"button-diccionario\">";
   		echo "	</td>";

		echo "	<td width=50>";
		echo "<input type=text style='font-size:10px' size=30 name=Sub_Expresiones id=tag900_0_n value=\"";
		if (!isset($_REQUEST["Diccio"])) $_REQUEST["Diccio"]=0;
		if (isset($_REQUEST["Seleccionados"])){
			if ($_REQUEST["Diccio"]==$jx){
			     echo str_replace('"','&quot;',$_REQUEST["Seleccionados"]);
			}else{
                if (isset($EX[$jx]) and $EX[$jx]!='""'){
					echo str_replace('"','&quot;',$EX[$jx]);
				}

			}
		}else{
			if (isset($EX[$jx])  and $EX[$jx]!='""'){
				 echo str_replace('"','&quot;',$EX[$jx]);
			}
		}

		echo "\"></td>\n";
        if ($jx<$Tope){
       		echo "<td><select name=oper size=1 style='font-size:10px' i=tag900_0_p>";
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
       		echo "<td></td>";
    	}
        echo "<td><input type=\"button\" onclick=\"deleteRowTable(this);\" class=\"button-del\"></td>\n";
        echo "</tr>";
	}
	echo "
		</table>\n";
	echo "<input type=button value=\"Agregar\" onclick=addRowTable('900','onp','add','') style=\"width:80px; font-size:10px\">&nbsp; &nbsp;\n";
	echo "<input type=button value=\"Buscar\" onclick=IniciarBusqueda() style=\"width:80px; font-size:10px\"><br>";
	echo "</div>";
	echo "<div style='overflow: hidden;text-align:left;' id='mensajes'> \n";
	echo "<font size=1>Click sobre <input type=button value=\"Agregar\" onclick=addRowTable('900','onp','add','') style=\"width:70px; font-size:10px\">&nbsp; para sumar un nuevo criterio de búsqueda. Seleccione un campo y de clic sobre <img src=../images/diccionario.gif height=10> para consultar el índice. ";
	echo "Puede indicar el operador que combinará los diferentes criterios (y/o).</font>";
	echo "</div>";
	echo "</form>";
	echo "<form name=diccio method=post action=../php/diccionario_integrado.php>";
	if (isset($_REQUEST["base"])) echo "<input type=hidden name=base value=".$_REQUEST['base'].">";
	if (isset($_REQUEST["cipar"])) echo "<input type=hidden name=cipar value=".$_REQUEST['cipar'].">";
	if (isset($_REQUEST["lista_bases"])) echo "<input type=hidden name=lista_bases value=".$_REQUEST['lista_bases'].">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_basea value=".$_REQUEST['indice_base'].">";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST['coleccion']."\">";
	if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=".$_REQUEST['modo'].">";
	if (isset($_REQUEST["integrada"])) echo "<input type=hidden name=integrada value=".$_REQUEST['integrada'].">";
	echo "<input type=hidden name=Sub_Expresion>";
	echo "<input type=hidden name=Campos>";
	echo "<input type=hidden name=Operadores>";
	echo "<input type=hidden name=Opcion value=avanzada>";
	echo "<input type=hidden name=prefijo value=\"\">";
	echo "<input type=hidden name=campo value=\"\">";
	echo "<input type=hidden name=id value=\"\">";
	echo "<input type=hidden name=Diccio value=\"\">";
	echo "<input type=hidden name=llamado_desde value='buscar_integrada.php'>\n";
	if (isset($criterios)) echo "<input type=hidden name=criterios value=$criterios>\n";
    if (isset($_REQUEST["Pft"]))
		echo "<input type=hidden name=Pft value=\"".$_REQUEST["Pft"]."\">\n";
	echo "</form>";


}

?>

