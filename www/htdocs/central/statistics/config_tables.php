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
?>
<script language="JavaScript" type="text/javascript"  src="../dataentry/js/lr_trim.js"></script>
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

function DrawElement(ixE,nombre,filas,columnas,pft,date_in){
	xhtml="<tr  height=50><td bgcolor=white valign=top><a href=javascript:DeleteElement("+ixE+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php echo $msgstr["delete"]?>\"></a></td>"
	xhtml+="<td bgcolor=white width=250 valign=top>"
	xhtml+="<input type=text name=\"tag_nombre\" value=\""+nombre+"\" size=35></td>"
	xhtml+="<td width=100 valign=top><input type=text name=\"tag_filas\" value=\""+filas+"\" size=18></td>"
	xhtml+="<td width=100 valign=top><input type=text name=\"tag_columnas\" value=\""+columnas+"\" size=18></td>"
	xhtml+="<td bgcolor=white width=300  valign=top><textarea name=tag_pft style='width:300px;height:30px'>"+pft+"</textarea></td>";
	xhtml+="<td bgcolor=white nowrap valign=top>";
	selected1=""
	selected2=""
	selected3=""
	switch (date_in){		case "no_date":
			selected1=" checked"
			break
		case "rows":
			selected2=" checked"
			break
		case "cols":
			selected3=" checked"
			break	}
	xhtml+="<input type=radio name=date_in_"+ixE+" value=no_date"+selected1+"><?php echo $msgstr["no_date"]?><br>"
    xhtml+="<input type=radio name=date_in_"+ixE+" value=rows"+selected2+"><?php echo $msgstr["rows"]?> <input type=radio name=date_in_"+ixE+" value=cols"+selected3+"><?php echo $msgstr["cols"]?>"
	xhtml+="</td></tr>"
    return xhtml
}

function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table width=910 cellpadding=0 border=0>"
	Ctrl=eval("document.stats.tag_nombre")
	ixLength=Ctrl.length
	if (ixLength==undefined){		document.stats.tag_nombre.value=""
		document.stats.tag_pft.value=""
		document.stats.tag_filas.value=""
		document.stats.tag_columnas.value=""	}else{
		if (ixLength<3){
			document.stats.tag_nombre[ix].value=""
			document.stats.tag_pft[ix].value=""
			document.stats.tag_filas[ix].value=""
			document.stats.tag_columnas[ix].value=""
		}else{
			ixE=-1
			tags=new Array()
			cont=new Array()
			for (i=0;i<ixLength;i++){
				if (i!=ix){
					Ctrl_nombre=document.stats.tag_nombre[i].value
					Ctrl_pft=document.stats.tag_pft[i].value
					Ctrl_filas=document.stats.tag_filas[i].value
					Ctrl_columnas=document.stats.tag_columnas[i].value

					ixE++
					html=DrawElement(ixE,Ctrl_nombre,Ctrl_filas,Ctrl_columnas,Ctrl_pft)
	    			html_sec+=html
				}
			}
			seccion.innerHTML = html_sec+"</table>"
		}
	}

}



function AddElement(){
	ia=0
	seccion=document.getElementById( "rows" )
	html="<table width=910 cellpadding=0 border=0>"
	Ctrl=eval(document.stats.tag_nombre)
	if (Ctrl.length!=undefined){
		if (Ctrl.length){
			ixLength=Ctrl.length
			last=ixLength-1
	        if (!ixLength) ixLength=1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	seltext=""
			    	nombre=""
			    	pft=""
			    	nombre=document.stats.tag_nombre[ia].value
			    	filas=document.stats.tag_filas[ia].value
			    	columnas=document.stats.tag_columnas[ia].value
			    	pft=document.stats.tag_pft[ia].value
			    	Ctrl=document.getElementsByName("date_in_"+ia)
				    date_in=GetDateIn(Ctrl)
			    	xhtm=DrawElement(ia,nombre,filas,columnas,pft,date_in)
			    	html+=xhtm
			    }
		    }
		 }	 }else{
	 	seltext=""
    	nombre=""
    	pft=""
    	nombre=document.stats.tag_nombre.value
    	filas=document.stats.tag_filas.value
    	columnas=document.stats.tag_columnas.value
    	pft=document.stats.tag_pft.value
    	Ctrl=document.getElementsByName("date_in_0")
		date_in=GetDateIn(Ctrl)
    	xhtm=DrawElement(0,nombre,filas,columnas,pft,date_in)
    	html+=xhtm		ia=1	 }
	nuevo=DrawElement(ia,"","","","","","")
	seccion.innerHTML = html+nuevo+"</table>"
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA

function GetDateIn(Ctrl){
	tope=Ctrl.length
	for (xxi=0; xxi<tope;xxi++){
		if (Ctrl[xxi].checked){
			return Ctrl[xxi].value
		}
	}
	return ""
}
function Guardar(){	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.tag_nombre.length
	if (total==0 || total==undefined){
		pft=Trim(document.stats.tag_pft.value)
		nombre=Trim(document.stats.tag_nombre.value)
		filas=Trim(document.stats.tag_filas.value)
		columnas=Trim(document.stats.tag_columnas.value)		if (nombre==""){			alert("<?php echo $msgstr["sel_tit"]?>")
			return;		}
		if (pft==""){
			alert("<?php echo $msgstr["misspft"]?>")
			return;
		}
		if (filas=="" && columnas==""){			alert ("<?php echo $msgstr["sel_rc"]?>")
			return		}
		if (pft!=""){
			pft=pft.replace(new RegExp('\\n','g'),' ')
			pft=pft.replace(new RegExp('\\r','g'),'')
			ValorCapturado=nombre+'|'+filas+'|'+columnas+"|"+pft
			Ctrl=document.getElementsByName("date_in_0")
			date_in=GetDateIn(Ctrl)
			ValorCapturado+='|'+date_in +"\n"
		}
	}else{		for (i=0;i<total;i++){			pft=Trim(document.stats.tag_pft[i].value)
			nombre=Trim(document.stats.tag_nombre[i].value)
			filas=Trim(document.stats.tag_filas[i].value)
			columnas=Trim(document.stats.tag_columnas[i].value)
			if (pft!=""  || nombre!="" || filas!="" || columnas!=""){
				if (nombre==""){
					xi=i+1
					alert("<?php echo $msgstr["sel_tit"]?>"+" ("+xi+")")
					return;
				}
				if (pft==""){
					alert("<?php echo $msgstr["misspft"]?>")
					return;
				}
				if (filas=="" && columnas==""){
					alert ("<?php echo $msgstr["sel_rc"]?>")
					return
				}
				if (pft!=""){
					pft=pft.replace(new RegExp('\\n','g'),' ')
					pft=pft.replace(new RegExp('\\r','g'),'')
					ValorCapturado+=nombre+'|'+filas+'|'+columnas+"|"+pft
				}
				Ctrl=document.getElementsByName("date_in_"+i)
				date_in=GetDateIn(Ctrl)
				ValorCapturado+='|'+date_in +"\n"

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
	<div class=\"breadcrumb\">".$msgstr["stats_conf"]." - ".$msgstr["pre_tabs"].": ".$arrHttp["base"]."</div>
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
<a href=http://abcdwiki.net/wiki/es/index.php?title=Estad%C3%ADsticas target=_blank><?php echo $msgstr["help"]?></a>&nbsp; &nbsp;
<font color=white>&nbsp; &nbsp; Script: config_tables.php
</font>
	</div>
<div class="middle form">
	<div class="formContent">
		<table width=950  bgcolor=#bbbbbb border=0 cellpadding=0 >
			<tr>
			<td colspan=6 bgcolor=white><?php echo $msgstr["pre_tabs_pft"];?></td>
			</tr>
			<tr>
			<td width=20>&nbsp;</td>
			<td width=255 valign=top><strong><?php echo $msgstr["title"]?></strong></td>
			<td width=140 valign=top><strong><?php echo $msgstr["rows"]?></strong></td>
			<td width=140 valign=top><strong><?php echo $msgstr["cols"]?></strong></td>
			<td width=300><strong><?php echo $msgstr["pft_ext"]?></td>
			<td nowrap valign=right ><?php echo $msgstr["date_in"]?></td>
            </tr>
		</table>
        <div id=rows>
 <?php
 	$total=-1;
 	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tables.cfg";
 	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tables.cfg";
 	echo "<table width=910  border=0 cellpadding=0 rowspacing=10>";
 	$ix=-1;
 	$lmp="";
 	$excluir="";
 	if (file_exists($file)){ 		$fp=file($file);
 	}else{
 		$fp=array();
 	}
 	$cuenta=count($fp);
 	if (count($fp)<3){
 		$fp[]="||||||";
 		$fp[]="||||||";
    } 		foreach ($fp as $value) { 			$value=trim($value); 			if (trim($value)!=""){
 				$var=explode('|',$value);
 				$ix++;
 				$total=$ix;
 				$sel1="";
 				$sel2="";
 				$sel3="";
 				switch ($var[4]){ 					case "no_date":
 						$sel1=" checked";
 						break;
 					case "rows":
 						$sel2=" checked";
 						break;
 					case "cols":
 						$sel3="checked";
 						break; 				}
 				echo "<tr height=50><td valign=top><a href=javascript:DeleteElement(".$ix.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a></td>\n";	 			echo "<td bgcolor=white width=250  valign=top>";
 				echo "<input type=text name=\"tag_nombre\" value=\"".$var[0]."\" size=35 id=tag_nombre></td>\n";
 				echo "<td width=100 valign=top><input type=text name=\"tag_filas\" value=\"".$var[1]."\" size=18 id=tag_filas></td>\n";
 				echo "<td width=100 valign=top><input type=text name=\"tag_columnas\" value=\"".$var[2]."\" size=18 id=tag_columnas></td>\n";
 				echo "<td bgcolor=white width=300 valign=top>";
 				echo "<textarea name=tag_pft style='width:300px;height:30px' id=tag_pft>".$var[3]."</textarea></td>";
 				echo "<td bgcolor=white nowrap valign=top>";
 				echo "<input type=radio name=date_in_$ix value='no_date' $sel1>".$msgstr["no_date"]. "<br>";
     			echo "<input type=radio name=date_in_$ix value='rows' $sel2>".$msgstr["rows"]. " <input type=radio name=date_in_$ix value='cols' $sel3>".$msgstr["cols"];
               echo "</td></tr>";
 			}
 	}


    echo "</table>";
 ?>
        </div>

		<a href="javascript:AddElement('rows')"><?php echo $msgstr["add"]?></a>

	</div>
</div>
</form>
<form name=enviar method=post action=config_tables_update.php>
<input type=hidden name=base>
<input type=hidden name=ValorCapturado>
<input type=hidden name=lmp>
<input type=hidden name=excluir>
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
