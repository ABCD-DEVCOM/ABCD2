<?php
/*
20220215 fho4abcd backbutton,div-helper,improve html, remove obsolete code
20220926 fho4abcd translations
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

?>
<body>
<script language="JavaScript" type="text/javascript"  src="../dataentry/js/lr_trim.js"></script>
<script language=javascript>

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

function DrawElement(ixE,nombre,pft,date){
//alert(date)
	if (date)
		xselected=" checked"
	else
		xselected=""
	xhtml="<tr><td bgcolor=white width=220 valign=top>"
	xhtml+="<a href=javascript:DeleteElement("+ixE+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php echo $msgstr["delete"]?>\"></a>&nbsp; &nbsp;";
	xhtml+="<input type=text name=\"nombre\" value=\""+nombre+"\" size=25></td><td bgcolor=white width=500><textarea name=pft style='width:500px;height:30px'>"+pft+"</textarea></td><td bgcolor=white valign=top><input type=hidden name=prefix size=5></a>";
	xhtml+="<input type=checkbox name=date "+xselected+"><?php echo $msgstr["date_field"]?></td></tr>"
    return xhtml
}

function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table width=800 class=listTable border=0>"
	Ctrl=eval("document.stats.nombre")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.stats.nombre[ix].value=""
		document.stats.pft[ix].value=""
		document.stats.date[ix].checked=false
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_nombre=document.stats.nombre[i].value
				Ctrl_pft=document.stats.pft[i].value
				Ctrl_date=document.stats.date[i].checked
				ixE++
				html=DrawElement(ixE,Ctrl_nombre,Ctrl_pft,Ctrl_date)
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
			    	seltext=""
			    	nombre=""
			    	pft=""
			    	nombre=document.stats.nombre[ia].value
			    	pft=document.stats.pft[ia].value
			    	date=document.stats.date[ia].checked
			    	xhtm=DrawElement(ia,nombre,pft,date)
			    	html+=xhtm
			    }
		    }
		 }
	 }else{
		ia=0
	 }
	nuevo=DrawElement(ia,"","","","")
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
function Guardar(){
	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.nombre.length
	if (total==0){
		pft=Trim(document.stats.pft.value)
		nombre=Trim(document.stats.nombre.value)
		date=document.stats.date.checked
		if (nombre=="" && pft!=""){
			alert("<?php echo $msgstr["mustselectfield"]?>")
			return;
		}
		if (nombre!="" && pft==""){
			alert("<?php echo $msgstr["misspft"]?>")
			return;
		}
		if (pft!=""){
			pft=pft.replace(new RegExp('\\n','g'),' ')
			pft=pft.replace(new RegExp('\\r','g'),'')
			ValorCapturado=Trim(nombre)+"|"+Trim(pft)+"|"+date
		}
	}else{
		for (i=0;i<total;i++){
			pft=Trim(document.stats.pft[i].value)
			nombre=Trim(document.stats.nombre[i].value)
			date=document.stats.date[i].checked
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
				ValorCapturado+=Trim(nombre)+"|"+Trim(pft)+"|"+date+"\n"
			}
		}
	}
	Ctrl=returnObjById( "lmp" )
	if (Ctrl){
		pft=Trim(document.stats.lmp.value)
		pft=pft.replace(new RegExp('\\n','g'),' ')
		pft=pft.replace(new RegExp('\\r','g'),'')
    	if (Trim(pft)!=""){
        	document.enviar.excluir.value=document.stats.excluir.value
    		document.enviar.lmp.value=pft
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
        <?php echo $msgstr["stats"]." - ".$msgstr["stat_cfg_vars"].": ".$arrHttp["base"];?>
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
$ayuda="stats_config_vars.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
    <form name=stats method=post>
		<table width=800  class=listTable bgcolor=#bbbbbb>
            <tr>
			<td width=220 valign=top><strong><?php echo $msgstr["var"]?></strong></td>
			<td width=450><strong><?php echo $msgstr["pft_ext"]?></strong></td>
            </tr>
		</table>
        <div id=rows>
    <?php
 	$total=-1;
 	$file=$db_path.$arrHttp["base"]."/def/".$lang."/stat.cfg";
 	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
    ?>
 	<table width=800 class=listTable>
    <?php
 	$ix=-1;
 	$lmp="";
 	$excluir="";
 	if (file_exists($file)){
 		$fp=file($file);
 	}else{
 		$fp=array();
 	}
 	$cuenta=count($fp);
 	if ($cuenta<3){
 		$fp[]="||||||";
 		$fp[]="||||||";
 	}
 	$lineas=0;
 		foreach ($fp as $value) {
 			$value=trim($value);
 			if ($value!=""){
 				$var=explode('|',$value);
 				if (isset($var[2]) and $var[2]=="LMP"){
 					$lmp=$var[1];
 					$excluir=$var[3];

 				}else{
 					$xselected="";
 					if (isset($var[2])){
 						if ($var[2]=="true")
 							$xselected=" checked";
 					}
 					$ix++;
 					$total=$ix;
                    ?>
	 				<tr>
                        <td bgcolor=white width=220 valign=top nowrap>
                            <a href=javascript:DeleteElement("<?php echo $ix;?>")>
                                <img src="../dataentry/img/toolbarDelete.png"
                                     alt="<?php echo $msgstr["delete"];?>"
                                     title="<?php echo $msgstr["delete"];?>"></a>&nbsp; &nbsp;
                            <input type=text name="nombre" value="<?php echo $var[0];?>" size=25>
                        </td>
                        <td bgcolor=white width=500>
                            <textarea name=pft style='width:500px;height:30px'><?php echo $var[1]?></textarea>
                        </td>
                        <td bgcolor=white valign=top>
                            <input type=checkbox name=date <?php echo $xselected;?>><?php echo $msgstr["date_field"];?>
                            <input type=hidden name=prefix size=5>
                        </td>
                    </tr>
                    <?php
 				}
 			}
 		}
        ?>
        </table>
        </div>

		<a href="javascript:AddElement('rows')"><?php echo $msgstr["add"]?></a>
        <?php
        if ($arrHttp["base"]=="trans"){
        ?>
		<p>
        <table width=800  class=listTable>
        <tr><td bgcolor=white width=120 valign=top><?php echo $msgstr["mostborrowed"];?></td>
            <td  bgcolor=white width=500><textarea name=lmp id=lmp style='width:500px;height:30px'><?php echo $lmp?></textarea></td>
            <td><?php echo $msgstr["excludetotallt"];?> <input type=text name=excluir size=4 value="<?php echo $excluir?>"></td>
        </tr>
		</table>
        <?php }?>
    </form>
	<iframe id="cframe" src="../dbadmin/fdt_leer.php?Opcion=<?php echo $arrHttp["Opcion"]?>&base=<?php echo $arrHttp["base"]?>" width=100% height=400 scrolling=yes name=fdt></iframe>
</div>
<form name=enviar method=post action=config_vars_update.php>
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
?>
