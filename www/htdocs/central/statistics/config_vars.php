<?php
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
// ARCHIVOD DE MENSAJES
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILOinclude("../common/header.php");

// LECTURA DE LA FDT DE LA BASE DE DATOS Y CREAR LISTA DE CAMPOS
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($file);
$ixFdt=-1;
echo "<script>\n";
$fields="";
foreach ($fp as $value){
	$t=explode('|',$value);
	if ($t[0]!="H" and $t[0]!="S" and $t[0]!="L")
		$fields.=$t[1]."$$$".$t[2]."||";
}
echo "fields=\"$fields\"\n";
echo "</script>\n";
?>
<script  src="../dataentry/js/lr_trim.js"></script>
<script languaje=javascript>
//LEE LA FDT O LA FST
function Ayuda(hlp){
	switch (hlp){		case 0:
			msgwin=window.open("../dbadmin/fdt_leer.php?base=<?php echo $arrHttp["base"]?>","FDT","")
			break
		case 1:
		   	msgwin=window.open("../dbadmin/fst_leer.php?base=<?php echo $arrHttp["base"]?>","FST","")
			break	}
	msgwin.focus()
}

//LLEVA LA CUENTA DE VARIABLES AGREGADAS A LA LISTA
ix=-1
total=0

//PARA AGREGAR NUEVAS VARIABLES A LA LISTA
function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function DrawElement(ixE,seltext,nombre,pft){
	xhtml="<tr><td bgcolor=white width=300 valign=top><select name=sel_text style='width:150px' onchange=Cambiar("+ixE+")>\n<option></option>"
	option=fields.split('||')
	for (var opt in option){
		o=option[opt].split('$$$')		xhtml+="<option value=\""+o[0]+"\">"+o[1]+"</option>\n";	}
	xhtml+="</select><input type=text name=\"nombre\" value=\""+nombre+"\" size=20></td><td bgcolor=white width=400><textarea name=pft style='width:400px;height:30px'>"+pft+"</textarea></td><td bgcolor=white valign=top><input type=text name=prefix size=5></a>";
	xhtml+="&nbsp;<a href=javascript:DeleteElement("+ixE+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php echo $msgstr["delete"]?>\"></a></td></tr>"
    return xhtml
}

function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table width=800 class=listTable border=0>"
	Ctrl=eval("document.stats.sel_text")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.stats.sel_text[ix].selectedIndex=0
		document.stats.nombre[ix].value=""
		document.stats.pft[ix].value=""
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_seltext=document.stats.sel_text[i].selectedIndex
				Ctrl_nombre=document.stats.nombre[i].value
				Ctrl_pft=document.stats.pft[i].value
				ixE++
				html=DrawElement(ixE,Ctrl_seltext,Ctrl_nombre,Ctrl_pft)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec+"</table>"
	}

}



function AddElement(){
	seccion=returnObjById( "rows" )
	html="<table width=800 class=listTable border=0>"
	Ctrl=eval("document.stats.nombre")
	if (Ctrl){
		if (Ctrl.length){
			ixLength=Ctrl.length
			last=ixLength-1
	        if (!ixLength) ixLength=1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	ixSel=document.stats.sel_text[ia].selectedIndex
			    	seltext=""
			    	nombre=""
			    	pft=""
			    	if (ixSel>0) seltext=document.stats.sel_text[ia].options[ixSel].value
			    	nombre=document.stats.nombre[ia].value
			    	pft=document.stats.pft[ia].value
			    	xhtm=DrawElement(ia,seltext,nombre,pft)
			    	html+=xhtm
			    }
		    }
		 }	 }else{		ia=0	 }
	nuevo=DrawElement(ia,"","","")
	seccion.innerHTML = html+nuevo+"</table>"
}

// PASA AL CAMPO DE TEXTO EL NOMBRE DE LA VARIABLE SELECCIONADA
function Cambiar(ix){
		sel=document.stats.sel_text[ix].selectedIndex
		if (sel==0){
			document.stats.nombre[ix].value=""
			document.stats.pft[ix].value=""
		}else{
			document.stats.nombre[ix].value=document.stats.sel_text[ix].options[sel].text
			document.stats.pft[ix].value="v"+document.stats.sel_text[ix].options[sel].value
		}
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA
function Guardar(){	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.nombre.length	if (total==0){
		pft=Trim(document.stats.pft.value)
		nombre=Trim(document.stats.nombre.value)		if (nombre=="" && pft!=""){			alert("<?php echo $msgstr["mustselectfield"]?>")
			return;		}
		if (nombre!="" && pft==""){
			alert("<?php echo $msgstr["misspft"]?>")
			return;
		}
		if (pft!=""){
			pft=pft.replace(new RegExp('\\n','g'),' ')
			pft=pft.replace(new RegExp('\\r','g'),'')
			ValorCapturado=nombre+"|"+pft
		}
	}else{		for (i=0;i<total;i++){			pft=Trim(document.stats.pft[i].value)
			nombre=Trim(document.stats.nombre[i].value)
			if (nombre=="" && pft!=""){
				xi=i+1
				alert("<?php echo $msgstr["mustselectfield"]?>"+" ("+xi+")")
				return;
			}
			if (nombre!="" && pft==""){
				alert("<?php echo $msgstr["misspft"]?>")
				return;
			}
			if (pft!=""){
				pft=pft.replace(new RegExp('\\n','g'),' ')
				pft=pft.replace(new RegExp('\\r','g'),'')
				ValorCapturado+=nombre+"|"+pft+"\n"
			}		}	}

	document.enviar.base.value=base
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()}</script>
<body>
<?php
// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "<form name=stats method=post>";
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["stats_conf"]." - ".$msgstr["var_list"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">";
if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics")
	$script="tables_generate.php";
else
	$script="../dbadmin/menu_modificardb.php";
	echo "<a href=\"$script?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" />
	<span><strong>".$msgstr["back"]."</strong></span></a>
	<a href=\"javascript:Guardar()\" class=\"defaultButton saveButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["save"]."</strong></span></a>";
?>
</div><div class="spacer">&#160;</div></div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/stats/stats_config_vars.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/stats/stats_config_vars.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: config_vars.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
		<table width=800  class=listTable bgcolor=#bbbbbb>
			<td width=280 valign=top><strong><?php echo $msgstr["var"]?></strong><a href=javascript:Ayuda(0)><img src=../dataentry/img/helper_bg.png></a></td>
			<td width=450><strong><?php echo $msgstr["pft_ext"]?></td>
			<td valign=top><strong><?php echo $msgstr["prefix"]?></strong> <a href=javascript:Ayuda(1)><img src=../dataentry/img/helper_bg.png></a></td>
		</table>
        <div id=rows>
 <?php
 	$total=-1;
 	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/stat.cfg";
 	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
 	echo "<table width=800 class=listTable>";
 	$ix=-1;
 	if (file_exists($file)){ 		$fp=file($file); 		foreach ($fp as $value) { 			if (trim($value)!=""){
 				$ix++;
 				$total=$ix; 				$var=explode('|',$value); 				echo "<tr><td bgcolor=white width=300 valign=top><select name=sel_text style='width:150px' onchange=Cambiar(".$ix.")><option</option>\n";
 				$f=explode('||',$fields);
	    		foreach ($f as $opt) {
					$o=explode('$$$',$opt);
	    			echo "<option value=\"".$o[0]."\" >".$o[1]."</option>\n";
	    		}
 				echo "</select><input type=text name=\"nombre\" value=\"".$var[0]."\" size=20></td><td bgcolor=white width=400><textarea name=pft style='width:400px;height:30px'>".$var[1]."</textarea></td><td bgcolor=white valign=top><input type=text name=prefix size=5></a>";
 				echo "&nbsp;<a href=javascript:DeleteElement(".$ix.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a></td></tr>\n";
 			} 		}

 	}

 	if ($ix<1){
 		$ix++;
 		$total++;
 		for ($ix=$ix;$ix<2;$ix++){
		 	echo "<tr><td bgcolor=white width=300 valign=top><select name=sel_text style='width:150px' onchange=Cambiar(".$ix.")><option></option>\n";
		 	$f=explode('||',$fields);
			foreach ($f as $opt) {
				$o=explode('$$$',$opt);
				echo "<option value=\"".$o[0]."\" >".$o[1]."</option>\n";
			}
		 	echo "</select><input type=text name=\"nombre\" value=\"\" size=20></td><td bgcolor=white width=400><textarea name=pft style='width:400px;height:30px'></textarea></td><td bgcolor=white valign=top><input type=text name=prefix size=5></a>";
		 	echo "&nbsp;<a href=javascript:DeleteElement(".$ix.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a></td></tr>\n";
	   	}
	}
    echo "</table>";
 ?>
        </div>

		<a href="javascript:AddElement('rows')"><?php echo $msgstr["add"]?></a>
	</div>
</div>
</form>
<form name=enviar method=post action=config_vars_update.php>
<input type=hidden name=base>
<input type=hidden name=ValorCapturado>
<?php
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>\n";
if (isset($arrHttp["from"])) echo "<input type=hidden name=from value=".$arrHttp["from"].">\n";
?>
</form>
<?php
include("../common/footer.php");
echo "<script>total=$total</script>\n";
?>
</body>
</html>
