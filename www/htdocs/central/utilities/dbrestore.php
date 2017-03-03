<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      copy_db_ex.php
 * @desc:      Search form for z3950 record importing
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;

include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

include("../common/header.php");
include("../common/institutional_info.php");

function Confirmar(){
global $msgstr,$arrHttp;
	echo "<input type=hidden name=confirmar>";
	echo "<h4>".$msgstr["db_restore"]."</h4>";
	echo "<h4>".$arrHttp["copyname"]." => ".$arrHttp["base"]."<h4>";
	echo "<input type=button name=continuar value=\"".$msgstr["continuar"]."\" onclick=Confirmar()>";
	echo "&nbsp; &nbsp;<input type=button name=cancelar value=\"".$msgstr["cancelar"]."\" onclick=Regresar()>";
	echo "</body></html>";
    die;
}

Function Explorar(){
global $msgstr;	echo "<form name=upload method=post onsubmit=\"EnviarFormaUpload();return false;\">";
	foreach ($_REQUEST as $var=>$value){
		echo "<input type=hidden name=$var value=\"$value\">\n";
	}
	echo "
	<table><tr><td valign=top>
	";
	echo $msgstr["mx_folder"];
	echo "</td><td>
<input type=text name=storein size=30 onclick=javascript:blur()> <a href=javascript:Explorar()>";
	echo $msgstr["explore"];
	echo "</a><br>";
	echo "<p><input type=submit value=".$msgstr["procesar"].">\n
	<td></tr></table>\n
	</form>";
    die;}

function ShowDatabases($storein,$db_path){global $msgstr;	$Dir=$db_path.$storein;
	$handle = opendir($Dir);
	$ix=0;
	echo "<table bgcolor=#cccccc border=0 cellpadding=8>";
	while (false !== ($file = readdir($handle))) {	   	if ($file != "." && $file != "..") {	   		$f=$file;	   		$file=$Dir."/".$file;
	   		if(is_file($file) and pathinfo ( $file , PATHINFO_EXTENSION)=="mst" ){	   			$ix=$ix+1;
	   			$ixpos=strpos($f,".");
	   			if ($ixpos>0){
	   				$fmst=substr($f,0,$ixpos);
		            $dateFormat = "D d M Y g:i A";
					$ctime = filectime($file);
        	        echo "<tr><td bgcolor=white><input type=radio name=db_sel value='".$fmst."'> $f</td>";
            	    echo "<td bgcolor=white>".date($dateFormat, $ctime) . "</td>";
                	echo "<td bgcolor=white>".number_format(filesize($file))."</td></tr>";
                }
	   		}
		}
	}
	echo "</table>";
	echo "<input type=hidden name=db_sel>\n";
	echo "<input type=hidden name=copyname>\n";
	if ($ix==0){		echo "<h4>".$msgstr["mx_nodb"]."</h4>";
		die;	}
	closedir($handle);
	echo "<p><input type=submit value=".$msgstr["procesar"].">\n";
	echo "</form></body></html>";
	die;
}

?>

<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function Explorar(){	msgwin=window.open("../dataentry/dirs_explorer.php?desde=dbcp&Opcion=explorar&base=<?php echo $db_path?>&mx=s&tag=document.forma1.dbfolder","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
    msgwin.focus()
}


function Limpiar(){
	fld=Trim(document.upload.storein.value)
	if (fld.substr(0,1)=="/"){
		fld=fld.substring(1)
		document.upload.storein.value=fld
	}
}

function Confirmar(){
	document.continuar.confirmar.value="OK";
	document.getElementById('loading').style.display='block';
	document.continuar.submit()
}

function EnviarForma(){
	selected_db=""
	for (i=0;i<document.continuar.db_sel.length-1;i++){
		if(document.continuar.db_sel[i].checked){
			document.continuar.copyname.value=document.continuar.db_sel[i].value
			selected_db="OK"
		}
	}
	if (selected_db=="OK")
		document.continuar.submit()
	else
		alert("<?php echo $msgstr["mx_select"]?>")
}

function Regresar(){
	document.continuar.action="../dbadmin/menu_mantenimiento.php";
	document.continuar.submit()
}

function FullInv(){	document.getElementById('loading').style.display='block';
	document.continuar.action="vmx_fullinv.php";
	document.continuar.submit()}

</script>
<body>


<div id="loading">
  <img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading..." />
</div>
<div class="sectionInfo">
	<div class="breadcrumb">
	<?php echo $msgstr["db_restore"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php if (isset($arrHttp["base"]))echo "<a href=\"../dbadmin/menu_mantenimiento.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: utilities/dbrestore.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";

if (!isset($mx_path)){
	echo $msgstr["mis_mx_path"];
    die;
}

if (file_exists($db_path.$arrHttp["base"]."/protect_status.def")){
	$fp=file($db_path.$arrHttp["base"]."/protect_status.def");
	foreach ($fp as $value){
		$value=trim($value);
		if ($value=="PROTECTED"){
			echo "<h4>".$msgstr["protect_active"]."</h4>";
			die;
		}
	}
}

if (!isset($arrHttp["storein"])){	Explorar();

}else{
	echo "<form name=continuar method=post onsubmit=\"EnviarForma();return false;\">";

	foreach ($_REQUEST as $var=>$value){		if (trim($value)!="")
			echo "<input type=hidden name=$var value=\"$value\">\n";
	}
	if (isset($arrHttp["storein"]) and !isset($arrHttp["copyname"])){		ShowDatabases($arrHttp["storein"],$db_path);
        echo "</form></body></html>";
		die;	}

}

if (!isset($arrHttp["confirmar"]) or $arrHttp["confirmar"]!="OK"){	Confirmar();}

$err="";
$from=$db_path.$arrHttp["storein"]."/".$arrHttp["copyname"];
$to=$db_path.$arrHttp["base"]."/data/".$arrHttp["base"];
$res=copy($from.".mst",$to.".mst");
if ($res==1){
	echo $from.".mst => ".$to.".mst <strong>".$msgstr["copied"]."</strong><br>";
	$res=copy($from.".xrf",$to.".xrf");
	if ($res==1){
		echo $from.".xrf => ".$to.".xrf  <strong>".$msgstr["copied"]."</strong><P>";
	}else
		$err="Y";
}else{
	$err="Y";
}
if ($err==""){	echo "<h4>".$msgstr["copied"]."</h4>";
	echo "<input type=hidden name=encabezado value=Y>\n";
	echo "<a href=javascript:FullInv()>".$msgstr["mnt_gli"]."</a>";}else{	echo "<h4>".$msgstr["not_copied"]."</h4>";}
?>
</form>
</div>
</div>
</center>
<?php

include("../common/footer.php");
?>

</body>
</html>
