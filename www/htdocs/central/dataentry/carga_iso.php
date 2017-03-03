<?
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;

include("../common/header.php");

?>
<script src=js/lr_trim.js></script>
<body onunload=win.close()>
<script language=javascript>
<!--
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
win.focus()
// -->

function Ver(iso){
	url= "carga_iso_ex.php?iso_file="+iso+"&accion=ver&base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["base"].".par&tipo=".$arrHttp["tipo"]?>"
	self.location=url
}

function Seleccionar(iso){
	borrarBd=false
	if (document.explora.borrar.checked){
		if (confirm("<?php echo $msgstr["mnt_ibd"]?> ??")==true){
			borrarBd=true
		}else{
			return
		}
	}
	fullinvBd=false
	if (document.explora.fullinv.checked){
		fullinvBd=true
	}
	if (document.explora.toansi.checked){
		toansi=true
	}else{		toansi=false	}
	if (document.explora.tolinux.checked){
		tolinux=true
	}else{
		tolinux=false
	}
	if (document.explora.usemx.checked){
		usemx=true
	}else{
		usemx=false
	}
	url= "carga_iso_ex.php?base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["base"].".par&tipo=".$arrHttp["tipo"]?>&cnv="+iso+"&accion=importar"
	url+="&borrar="+borrarBd
	if (fullinvBd==true) url+="&fullinv="+fullinvBd
	if (toansi==true) url+="&toansi="+toansi
	if (tolinux==true) url+="&tolinux="+tolinux
	if (usemx==true) url+="&usemx="+usemx
	if (confirm("<?php echo $msgstr["conf_import"]?> ??")==true) {		NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
		self.location=url	}
}

function Eliminar(Archivo){
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+Archivo)==true){
		url="carga_iso_ex.php?base=<?php echo $arrHttp["base"]."&tipo=".$arrHttp["tipo"]?>&cnv="+Archivo+"&Opcion=cnv&accion=eliminar"
		self.location=url
	}
}
</script>

<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_import"]." ".$msgstr["cnv_iso"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["edhlp"]."</a>";
		echo "<font color=white>&nbsp; &nbsp; Script: dataentry/carga_iso.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<form name=explora>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=tipo value=<?php echo $arrHttp["tipo"]?>>
<input type=hidden name=tablacnv value="">
<?
$Dir=$db_path."wrk";
$the_array = Array();

$handle = opendir($Dir);


	while (false !== ($file = readdir($handle))) {
	   if ($file != "." && $file != "..") {
	   		if(is_file($Dir."/".$file))
	            $the_array[]=$file;
	        else
	            $dirs[]=$Dir."/".$file;
	   }
	}
	closedir($handle);
	if (count($the_array)>=0){
		sort ($the_array);
		reset ($the_array);
		$Url="";
		echo "<dd><h5><input type=checkbox name=borrar>".$msgstr["deldb"]."";
		echo "<br><input type=checkbox name=tolinux>".$msgstr["tolinux"];
		echo "<br><input type=checkbox name=toansi>".$msgstr["toansi"];
		echo "<br><input type=checkbox name=usemx>".$msgstr["importiso_mx"];
		echo "<br><input type=checkbox name=fullinv>".$msgstr["mnt_gli"]."</h5>";
		echo "<dd><h5>".$msgstr["seleccionar"]." ".$msgstr["cnv_iso"]." </h5>";
		echo "<dd><table border=0  cellspacing=1 cellpadding=4 bgcolor=#cccccc>
		     <tr><td>".$msgstr["seleccionar"]."</td><td>".$msgstr["eliminar"]."</td><td>".$msgstr["ver"]."</td>
		     <td>".$msgstr["archivo"]."</td>
			 <tr>
		   			<td bgcolor=white width=10></td>
		   			<td bgcolor=white></td>
		   			<td bgcolor=white></td>
		   			<td bgcolor=white></td>";
		while (list ($key, $val) = each ($the_array)) {

		   echo "<tr>

		   			<td bgcolor=white align=center><a href=javascript:Seleccionar('$val')><img src=img/aceptar.gif alt=\"".$msgstr["selformat"]."\" title=\"".$msgstr["selformat"]. "\" border=0></a></td>
		   			<td bgcolor=white align=center><a href=javascript:Eliminar('$val')><img src=img/delete.gif border=0 alt=\"".$msgstr["eliminar"]."\" title=\"".$msgstr["eliminar"]."\"></a></td>
		   			<td bgcolor=white align=center><a href=javascript:Ver('$val')><img src=img/search.gif border=0 alt=\"".$msgstr["ver"]."\" title=\"".$msgstr["ver"]."\"></a></td>

					<td bgcolor=white><strong>$val</strong></td>";
		}
		echo "</table>";

	}

echo "</form>";

echo "

<form action=upload.php method=POST enctype=multipart/form-data>
<input type=hidden name=base value=".$arrHttp["base"].">
<input type=hidden name=tipo value=". $arrHttp["tipo"].">
<input type=hidden name=dir value=wrk>
<dd><table bgcolor=#eeeeee>
<tr>
<tr><td class=menusec1>".$msgstr["subir"]." ".$msgstr["cnv_iso"]. "</td><td class=menusec1></td>

<tr><td><input name=userfile[] type=file size=50>  <input type=submit value='".$msgstr["subir"]."'></td>
<td nowrap><input type=hidden name=path value=wrk>
</table>
<p>
</form>";
echo "</div></div>";
include("../common/footer.php");
?>