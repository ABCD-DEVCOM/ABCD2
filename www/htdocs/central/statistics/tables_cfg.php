<?php
/*
20220215 fho4abcd back backbutton+div-helper+sanitize html
20220220 fho4abcd resolved small error
*/
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include ("../config.php");
// ARCHIVOD DE MENSAJES
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// LECTURA DE LA LISTA DE VARIABLES YA DEFINIDAS (STATS.CFG)
$total=-1;
$error="";
$fields="";
$cfg=array();
$file=$db_path.$arrHttp["base"]."/def/".$lang."/stat.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
if (!file_exists($file)){
	$error="S";
}else{
	$fp=file($file);
	//$ix=-1;
	foreach ($fp as $value) {
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			$fields.=trim($t[0]);
			if (isset($t[2]) and $t[2]=="LMP") $fields.='%'."LMP";
			$fields.="||";
			//$ix++;
			//$cfg[$ix]=$value;
		}
	}
}
?>
<body>
<script>fields='<?php echo $fields?>'</script>

<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language=javascript>

//LLEVA LA CUENTA DE TABLAS AGREGADAS A LA LISTA
total=0


//MARCA EL SELECT DE LAS FILAS Y COLUMNAS DE LAS TABLAS YA DEFINIDAS
function IndexSelected(Ctrl,Var){
	ix=Ctrl.length
	for (i=0;i<ix;i++){
		v=Trim(Ctrl.options[i].text)
		if (v==Var) {
			Ctrl.options[i].selected=true
			i=999
		}

	}
}

function MarcarSeleccion(Ctrl,nvars,Var){
	if (nvars==0){
		IndexSelected(Ctrl,Var)
	}else{
		IndexSelected(Ctrl[nvars],Var)
	}
}

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
    for (var opt in f){
    	ix0++
    	selected=""
    	if (ix0==ixRow) selected=" selected"
    	nuevo+="<option value=\""+f[opt]+"\""+selected+">"+f[opt]+"</option>\n"
    }
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
	Ctrl=document.stats.tit
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
		ixRow=document.stats.rows.selectedIndex
		ixCol=document.stats.cols.selectedIndex
		Title=document.stats.tit.value
		xhtm=DrawElement(ia,Title,ixRow,ixCol)
		html+=xhtm
	 }
	nuevo=DrawElement(ia,"","","")
	seccion.innerHTML = html+nuevo
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA

function Guardar(){
	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.tit.length
	if (total==0){
		row=""
		col=""
		titulo=Trim(document.stats.tit.value)
		ix=document.stats.rows.selectedIndex
		if (ix>0) row=Trim(document.stats.rows.options[ix].value)
		ix=document.stats.cols.selectedIndex
		if (ix>0) col=Trim(document.stats.cols.options[ix].value)
		if (titulo!="" && row=="" && col==""){
			alert("<?php echo $msgstr["sel_rc"]?>")   //SELECCIONAR VARIABLE PARA LAS FILAS O LAS COLUMNAS
			return;
		}
		if (titulo=="" && (row!="" || col!="")){
			alert("<?php echo $msgstr["sel_tit"]?>")   //INDICAR EL TITULO DEL CUADRO
			return;
		}
		ValorCapturado=titulo+"|"+row+"|"+col
	}else{
		for (i=0;i<total;i++){
			row=""
			col=""
			titulo=Trim(document.stats.tit[i].value)
			ix=document.stats.rows[i].selectedIndex
            rr_len=0
            cc_len=0
			if (ix>0) {
				row=Trim(document.stats.rows[i].options[ix].value)
				rr=row.split('%');
				row=rr[0]
				rr_len=rr.length;
			}
			ix=document.stats.cols[i].selectedIndex
			if (ix>0){
				col=Trim(document.stats.cols[i].options[ix].value)
				cc=col.split('%');
				col=cc[0]
				cc_len=cc.length;
			}
			if (titulo!="" && row=="" && col==""){
				alert("<?php echo $msgstr["sel_rc"]?>")   //SELECCIONAR VARIABLE PARA LAS FILAS O LAS COLUMNAS
				return;
			}
			if (titulo=="" && (row!="" || col!="")){
				alert("<?php echo $msgstr["sel_tit"]?>")   //INDICAR EL TITULO DEL CUADRO
				return;
			}
			if (col!="" && rr_len>1 || cc_len>1){
				alert("Los mas prestados solo puede aparecer como fila")
				return
			}
			if (titulo!="") ValorCapturado+=titulo+"|"+row+"|"+col+"\n"
		}
	}
	document.enviar.base.value=base
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()
}

</script>
<?php
// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["stats_conf"]." - ".$msgstr["tab_list"].": ".$arrHttp["base"];?>
    </div>
	<div class="actions">
        <?php
        if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics")
            $backtoscript="tables_generate.php";
        else
            $backtoscript="../dbadmin/menu_modificardb.php";//old status where variables were defined in that script
        include "../common/inc_back.php";
        $savescript="javascript:Guardar()";
        include "../common/inc_save.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="stats_config_tabs.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
// SI FALTA EL ARCHIVO STATS.CFG SE DETIENE LA EJECUCIÓN
if ($error=="S"){
    $urlforvardef="../statistics/config_vars.php?base=".$arrHttp["base"]."&Opcion=Update&from=statistics".$encabezado;
	echo "<h4>".$msgstr["mis_statscfg"]." (<a href='".$urlforvardef."'>".$msgstr["stats"]." - ".$msgstr["var_list"]. "</a>)</h4>";
	die;
}
//LECTURA DE LOS CUADROS Y TABLA YA DEFINIDOS
$file=$db_path.$arrHttp["base"]."/def/".$lang."/tabs.cfg";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
$total=-1;
echo "<form name=stats method=post>";
echo  "<div id=tabs>\n";
if (file_exists($file)){
	$fp=file($file);
}else{
	$fp=array();
}
$cuenta=count($fp);
if (count($fp)<3){
 	$fp[]="||||||";
 	$fp[]="||||||";
}
foreach ($fp as $value) {
	$value=trim($value);
	if ($value!=""){
		$total++;
		$t=explode('|',$value);
        ?>
		<table  width=800 bgcolor=#cccccc border=0 name=tbst>
        <tr>
            <td rowspan=4 bgcolor=white valign=top>
                <a href=javascript:DeleteElement(<?php echo $total;?>)>
                    <img src=../dataentry/img/toolbarDelete.png alt="<?php echo $msgstr["delete"];?>" title="<?php echo $msgstr["delete"];?>"></a>
            </td>
            <td width=300 bgcolor=white><?php echo $msgstr["title"];?></td>
            <td bgcolor=white><input type=text name=tit size=120 value="<?php echo $t[0];?>"></td>
        </tr>
   		<tr>
            <td bgcolor=white><?php echo $msgstr["rows"];?></td>
            <td bgcolor=white>
                <select name=rows>
                <option></option>
                <?php
                $f=explode('||',$fields);
                foreach ($f as $opt_x) {
                    $opt=explode('%',$opt_x);
                    $selected="";
                    if ($opt[0]==$t[1]) $selected=" selected";
                    echo "<option value=\"$opt_x\" $selected>".$opt[0]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor=white><?php echo $msgstr["cols"];?></td>
            <td bgcolor=white>
                <select name=cols>
                <option></option>
                <?php
                $f=explode('||',$fields);
                foreach ($f as $opt_x) {
                    $selected="";
                    $opt=explode('%',$opt_x);
                    $selected="";
                    if ($opt[0]==$t[2]) $selected=" selected";
                    echo "<option value=\"$opt_x\" $selected>".$opt[0]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        </table><br>
        <script>
            MarcarSeleccion(document.stats.rows,$total,'<?php echo $t[1];?>')
            MarcarSeleccion(document.stats.cols,$total,'<?php echo $t[2];?>')
        </script>
        <?php
	}
}
echo "<script>total=$total</script>\n";
?>
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
<script>
	if (total==-1) AddElement()
</script>
<?php
include("../common/footer.php");
?>
