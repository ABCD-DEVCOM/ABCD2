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

// LECTURA DE LA LISTA DE PROCESOS YA DEFINIDAS (PROC.CFG)
$total=-1;
$error_1="";
$error_2="";
$fields="";
$cfg=array();
$tabs="";
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tabs.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
if (!file_exists($file)){	$error_1="S";}else{	$fp=file($file);
	//$ix=-1;
	$fields="";
	foreach ($fp as $value) {		$value=trim($value);
		if ($value!=""){			$t=explode('|',$value);
			$tabs.=trim($t[0])."||";
		}
	}
}
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tables.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tables.cfg";
if (!file_exists($file)){
    $error_2="";
}else{
	$fp=file($file);
	$fields="";
	foreach ($fp as $value) {
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			$tabs.=trim($t[0]).'{{PFT||';
		}
	}
}
echo "<script>fields='$tabs'</script>\n";
?>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script languaje=javascript>

//LLEVA LA CUENTA DE TABLAS AGREGADAS A LA LISTA
total=0


//MARCA EL SELECT DE LAS FILAS Y COLUMNAS DE LAS TABLAS YA DEFINIDAS
function IndexSelected(Ctrl,Var){	ix=Ctrl.length
	for (i=0;i<ix;i++){
		v=Trim(Ctrl.options[i].text)
		if (v==Var) {			Ctrl.options[i].selected=true
			i=999		}
	}}

function MarcarSeleccion(Ctrl,nvars,Var){
	if (nvars==0){		IndexSelected(Ctrl,Var)
	}else{
		IndexSelected(Ctrl[nvars],Var)
	}}

//PARA AGREGAR NUEVOS PROCESOS A LA LISTA
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

function DrawElement(ixEl,Title,ixRow){
	nuevo="<table width=800 bgcolor=#cccccc border=0>"
	nuevo+="<td rowspan=3 bgcolor=white valign=top><a href=javascript:DeleteElement("+ixEl+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php echo $msgstr["delete"]?>\"></a></td>\n";
	nuevo+="<td width=300 bgcolor=white><?php echo $msgstr["title"]?></td>"
	nuevo+="<td bgcolor=white><input type=text name=tit id=tit size=120 value='"+Title+"'></td>"
    nuevo+="<tr><td bgcolor=white valign=top><?php echo $msgstr["tab_list"]?></td><td bgcolor=white>"
    nuevo+="<?php echo "<strong>".$msgstr["sel_multiple"]."</strong><br>";?>"
    nuevo+="<select name=rows valign=top multiple size="+size_sel+">"
    f=fields.split('||')
    ix0=-1
    for (var opt in f){
	    	ix0++
	    	selected=""
	    	optsel="|"+ix0+"|"
	    	if (ixRow.indexOf(optsel)>-1) selected=" selected"
	    	oo=f[opt].split('{{')
	    	nuevo+="<option value=\""+f[opt]+"\""+selected+">"+oo[0]+"</option>\n"
    }
    nuevo+="</select></td></table><br>"
    return nuevo
}

function DeleteElement(ix){
	seccion=returnObjById( "tabs" )
	html_sec=""
	Ctrl=eval("document.stats.tit")
	ixLength=Ctrl.length
	if (ixLength==undefined ){		document.stats.tit.value=""
		document.stats.rows.selectedIndex =-1	}else{
		ixE=-1
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_tit=document.stats.tit[i].value
				ixRowTot=document.stats.rows[i].options.length
				ixRow="|";
				for (ixrt=0;ixrt<ixRowTot;ixrt++){
					if (document.stats.rows[i].options[ixrt].selected)
			    		ixRow+=ixrt +"|"
				}
				ixE++
				html=DrawElement(ixE,Ctrl_tit,ixRow)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec
	}
}



function AddElement(){
	seccion=returnObjById( "tabs" )
	Ctrl=eval("document.stats.tit")
	ixLength=Ctrl.length
	html=""
	if (ixLength==undefined){		ia=0
		Title=document.stats.tit.value
		ixRowTot=document.stats.rows.options.length
		ixRow="|";
		for (ixrt=0;ixrt<ixRowTot;ixrt++) {
			if (document.stats.rows.options[ixrt].selected)
				ixRow+=ixrt+"|"
		}
		ixRow+="|"
		xhtm=DrawElement(ia,Title,ixRow)
		html+=xhtm
		ia=ia+1
	 }else{
		ixLength=Ctrl.length
		html=""
	    for (ia=0;ia<ixLength;ia++){
			ixRowTot=document.stats.rows[ia].options.length
			ixRow="|";
			for (ixrt=0;ixrt<ixRowTot;ixrt++){
				if (document.stats.rows[ia].options[ixrt].selected)
	    			ixRow+=ixrt +"|"
			}
	    	Title=document.stats.tit[ia].value
	    	xhtm=DrawElement(ia,Title,ixRow)
	    	html+=xhtm
	    }
 	}
 	xhtm=DrawElement(ia,"","")
	seccion.innerHTML = html+xhtm
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA

function Guardar(){	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.tit.length
	if (total==undefined){
		titulo=Trim(document.stats.tit.value)
		ixRowTot=document.stats.rows.options.length
		row="";
		for (ixrt=0;ixrt<ixRowTot;ixrt++) {
			if (document.stats.rows.options[ixrt].selected)
				row+=document.stats.rows.options[ixrt].value +"|"
		}		if (Trim(titulo)!="" && row=="" ){			alert("<?php echo $msgstr["tab_req"]?>")   //SELECCIONAR LAS TABLAS
			return;		}
		if (Trim(titulo)=="" && row!="" ){
			alert("<?php echo $msgstr["tit_req"]?>")   //INDICAR EL TITULO DEL CUADRO
			return;
		}
		ValorCapturado=titulo+"||"+row
	}else{		for (i=0;i<total;i++){
			row=""
			col=""			titulo=Trim(document.stats.tit[i].value)
			ixRowTot=document.stats.rows[i].options.length
			row="";
			for (ixrt=0;ixrt<ixRowTot;ixrt++) {
				if (document.stats.rows[i].options[ixrt].selected)
					row+=document.stats.rows[i].options[ixrt].value +"|"
			}
			if (titulo!="" && row==""){
				alert("<?php echo $msgstr["tab_req"]?>")   //SELECCIONAR VARIABLE PARA LAS FILAS O LAS COLUMNAS
				return;
			}
			if (titulo=="" && row!=""){
				alert("<?php echo $msgstr["tit_req"]?>")   //INDICAR EL TITULO DEL CUADRO
				return;
			}
			if (titulo!="") ValorCapturado+=titulo+"||"+row+"\n"
		}	}
	document.enviar.base.value=base
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()}</script>
<body>
<?php
if ($error_1=="S" and $error_2=="S")
	$error="S";
else
	$error="";
// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "<form name=stats method=post>";
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["stats_conf"]." - ".$msgstr["exist_proc"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">";
if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics"){
	$script="tables_generate.php";
}else{
	$script="../dbadmin/menu_modificardb.php";
}
	echo "<a href=\"$script?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" />
	<span><strong>".$msgstr["back"]."</strong></span></a>";
if ($error==""){	echo "
	<a href=\"javascript:Guardar()\" class=\"defaultButton saveButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["save"]."</strong></span></a>";
}
?>
</div><div class="spacer">&#160;</div></div>
<div class="helper">
<a href=http://abcdwiki.net/wiki/es/index.php?title=Estad%C3%ADsticas target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<font color=white>&nbsp; &nbsp; Script: proc_cfg.php
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<?php
// SI FALTA EL ARCHIVO TABS.CFG SE DETIENE LA EJECUCIÓN
if ($error=="S"){	echo "<h4>".$msgstr["mis_tabscfg"]."</h4> (<a href=tables_generate.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["stats"]." - ".$msgstr["tab_list"]. "</a>)";
	die;}
//LECTURA DE LOS CUADROS Y TABLA YA DEFINIDOS
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/proc.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/proc.cfg";
$total=-1;
echo  "<div id=tabs>\n";
if (file_exists($file)){
	$fp=file($file);
}else{	$fp=array('||');}
$f=explode('||',$tabs);
$size=count($f);
echo "\n<script>size_sel=$size</script>\n";
//$fp=explode('||',$tabs);
foreach ($fp as $value) {
	$value=trim($value);
	if ($value!=""){		$total++;
		$tt=explode('||',$value);
		echo "<table  width=800 bgcolor=#cccccc border=0 name=tbst>";
		echo "<td rowspan=3 bgcolor=white valign=top><a href=javascript:DeleteElement(".$total.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a></td>\n";
		echo "<td width=300 bgcolor=white>".$msgstr["title"]."</td>";
		echo "<td bgcolor=white><input type=text name=tit id=tit size=120 value=\"".$tt[0]."\"></td>";
   		echo "<tr><td bgcolor=white valign=top>".$msgstr["tab_list"]."</td><td bgcolor=white>";
   		echo "<strong>".$msgstr["sel_multiple"]."</strong><br>";
   		echo "<select name=rows  size=$size multiple>";
        $proc_tab=explode("|",$tt[1]);
   		foreach ($f as $opt) {
   			if (trim($opt)!=""){                $OO=explode('{{',$opt);	   			$selected="";
	   			foreach ($proc_tab as $opcion){	   				if ($opt==$opcion) {	   					$selected=" selected";
	   					break;
	   				}
	   			}
	   			echo "<option value=\"$opt\" $selected>".$OO[0]."</option>\n";
	   		}   		}

   		echo "</select></td>";

           echo "</table><br>";
           echo "<script>MarcarSeleccion(document.stats.rows,$total,'".$t[1]."')
          </script>\n";
	}
}


echo "<script>total=$total</script>\n";
?>
		<strong></strong>


        </div>
        <a href='javascript:AddElement()'><?php echo $msgstr["add"]?></a>
	</div>
</div>
</form>
<form name=enviar method=post action=proc_cfg_update.php>
<input type=hidden name=base>
<input type=hidden name=ValorCapturado>
<?php
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>\n";
if (isset($arrHttp["from"])) echo "<input type=hidden name=from value=".$arrHttp["from"].">\n";
?>
</form>
<?php
include("../common/footer.php");
?>
</body>
</html>
<script>
	if (total==-1) AgregarTabla()
</script>