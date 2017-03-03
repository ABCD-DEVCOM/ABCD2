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

// LECTURA DE LA LISTA DE VARIABLES YA DEFINIDAS (STATS.CFG)
$total=-1;
$error="";
$cfg=array();
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/stat.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
if (!file_exists($file)){	$error="S";}else{	$fp=file($file);
	//$ix=-1;
	$fields="";
	foreach ($fp as $value) {		$value=trim($value);
		if ($value!=""){			$t=explode('|',$value);
			$fields.=trim($t[0])."||";
			//$ix++;
			//$cfg[$ix]=$value;
		}
	}
}
echo "<script>fields='$fields'</script>\n";
?>
<script  src="../dataentry/js/lr_trim.js"></script>
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

function DrawElement(ixEl,Title,ixRow,ixCol){
	nuevo="<table width=800 bgcolor=#cccccc border=0>"
	nuevo+="<td rowspan=3 bgcolor=white valign=top><a href=javascript:DeleteElement("+ixEl+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php echo $msgstr["delete"]?>\"></a></td>\n";
	nuevo+="<td width=300 bgcolor=white><?php echo $msgstr["title"]?></td>"
	nuevo+="<td bgcolor=white><input type=text name=tit size=120 value='"+Title+"'></td>"
    nuevo+="<tr><td bgcolor=white><?php echo $msgstr["rows"]?></td><td bgcolor=white><select name=rows><option></option>"
    f=fields.split('||')
    ix0=0
    for (var opt in f){    	ix0++
    	selected=""
    	if (ix0==ixRow) selected=" selected"
    	nuevo+="<option value=\""+f[opt]+"\""+selected+">"+f[opt]+"</option>\n"    }
    nuevo+="</select></td>"
    nuevo+="<tr><td bgcolor=white><?php echo $msgstr["cols"]?></td><td bgcolor=white><select name=cols><option></option>"
    ix0=0
    for (var opt in f){
    	ix0++
    	selected=""
    	if (ix0==ixCol) selected=" selected"
    	nuevo+="<option value=\""+f[opt]+"\""+selected+">"+f[opt]+"</option>\n"
    }
    nuevo+="</select></td></table><br>"
    return nuevo
}

function DeleteElement(ix){
	seccion=returnObjById( "tabs" )
	html_sec=""
	Ctrl=eval("document.stats.tit")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.stats.tit[ix].value=""
		document.stats.rows[ix].selectedIndex =0
		document.stats.cols[ix].selectedIndex =0
	}else{
		ixE=-1
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_tit=document.stats.tit[i].value
				Ctrl_rows=document.stats.rows[i].selectedIndex
				Ctrl_cols=document.stats.cols[i].selectedIndex
				ixE++
				html=DrawElement(ixE,Ctrl_tit,Ctrl_rows,Ctrl_cols)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec
	}

}



function AddElement(){
	seccion=returnObjById( "tabs" )
	html=""
	Ctrl=eval("document.stats.rows")
	if (Ctrl){
		if (Ctrl.length){
			ixLength=Ctrl.length
			last=ixLength-1
	        if (!ixLength) ixLength=1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	ixRow=document.stats.rows[ia].selectedIndex
			    	ixCol=document.stats.cols[ia].selectedIndex
			    	Title=document.stats.tit[ia].value
			    	xhtm=DrawElement(ia,Title,ixRow,ixCol)
			    	html+=xhtm
			    }
		    }
		 }
	 }else{
		ia=0
	 }
	nuevo=DrawElement(ia,"","","")
	seccion.innerHTML = html+nuevo
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA

function Guardar(){	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.tit.length
	if (total==0){
		row=""
		col=""
		titulo=Trim(document.stats.tit.value)
		ix=document.stats.rows.selectedIndex
		if (ix>0) row=Trim(document.stats.rows.options[ix].value)
		ix=document.stats.cols.selectedIndex
		if (ix>0) col=Trim(document.stats.cols.options[ix].value)		if (titulo!="" && row=="" && col==""){			alert("<?php echo $msgstr["sel_rc"]?>")   //SELECCIONAR VARIABLE PARA LAS FILAS O LAS COLUMNAS
			return;		}
		if (titulo=="" && (row!="" || col!="")){
			alert("<?php echo $msgstr["sel_tit"]?>")   //INDICAR EL TITULO DEL CUADRO
			return;
		}
		ValorCapturado=titulo+"|"+row+"|"+col
	}else{		for (i=0;i<total;i++){
			row=""
			col=""			titulo=Trim(document.stats.tit[i].value)
			ix=document.stats.rows[i].selectedIndex
			if (ix>0) row=Trim(document.stats.rows[i].options[ix].value)
			ix=document.stats.cols[i].selectedIndex
			if (ix>0) col=Trim(document.stats.cols[i].options[ix].value)
			if (titulo!="" && row=="" && col==""){
				alert("<?php echo $msgstr["sel_rc"]?>")   //SELECCIONAR VARIABLE PARA LAS FILAS O LAS COLUMNAS
				return;
			}
			if (titulo=="" && (row!="" || col!="")){
				alert("<?php echo $msgstr["sel_tit"]?>")   //INDICAR EL TITULO DEL CUADRO
				return;
			}
			if (titulo!="") ValorCapturado+=titulo+"|"+row+"|"+col+"\n"
		}	}
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
	<div class=\"breadcrumb\">".$msgstr["stats_conf"]." - ".$msgstr["tab_list"].": ".$arrHttp["base"]."</div>
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
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/stats/stats_config_tabs.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/stats/stats_config_tabs.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: tables_cfg.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<?php
// SI FALTA EL ARCHIVO STATS.CFG SE DETIENE LA EJECUCIÓN
if ($error=="S"){	echo "<h4>".$msgstr["mis_statscfg"]." (<a href=index.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["stats"]." - ".$msgstr["var_list"]. "</a>)</h4>";
	die;}
//LECTURA DE LOS CUADROS Y TABLA YA DEFINIDOS
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tabs.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
$total=-1;
echo  "<div id=tabs>\n";
if (file_exists($file)){
	$fp=file($file);
}
$fp[]="||";
$fp[]='||';
foreach ($fp as $value) {
	$value=trim($value);
	if ($value!=""){		$total++;
		$t=explode('|',$value);
		echo "<table  width=800 bgcolor=#cccccc border=0>";
		echo "<td rowspan=3 bgcolor=white valign=top><a href=javascript:DeleteElement(".$total.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a></td>\n";
		echo "<td width=300 bgcolor=white>".$msgstr["title"]."</td>";
		echo "<td bgcolor=white><input type=text name=tit size=120 value=\"".$t[0]."\"></td>";
   		echo "<tr><td bgcolor=white>".$msgstr["rows"]."</td><td bgcolor=white><select name=rows><option></option>";
   		$f=explode('||',$fields);
   		foreach ($f as $opt) {   			$selected="";
   			if ($opt==$t[1]) $selected=" selected";
   			echo "<option value=\"$opt\" $selected>$opt</option>\n";   		}
   		echo "</select></td>";
   		echo "<tr><td bgcolor=white>".$msgstr["cols"]."</td><td bgcolor=white><select name=cols><option></option>";
   		$f=explode('||',$fields);
   		foreach ($f as $opt) {
   			$selected="";
   			if ($opt==$t[2]) $selected=" selected";
   			echo "<option value=\"$opt\" $selected>$opt</option>\n";
   		}
           echo "</table><br>";
           echo "<script>MarcarSeleccion(document.stats.rows,$total,'".$t[1]."')
           MarcarSeleccion(document.stats.cols,$total,'".$t[2]."')
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
<form name=enviar method=post action=tables_cfg_update.php>
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