<?php
/*
20220108 fho4abcd backButton+ div helper+improve html
*/

/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conversion.php
 * @desc:      Create/edit the conversion table for z3950 importing records
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
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$backtoscript="../dbadmin/z3950_conf.php";
$db=$arrHttp["base"];
include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
function Enviar(){
	if (Trim(document.cnv.namecnvtb.value)=="" || Trim(document.cnv.descr.value)==""){
		alert("<?php echo $msgstr["namecnvtamiss"]?>")
		return
	}
	document.cnv.target=""
	document.cnv.action="z3950_conversion_update.php"
	document.cnv.submit()

}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["z3950"].": ".$msgstr["z3950_tab"]." (".$arrHttp["base"].")" ?>
	</div>

	<div class="actions">
    <?php
    $savescript="javascript:Enviar()";
	include "../common/inc_save.php";
	include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="z3950_conf.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<form name=cnv  method=post onsubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=fn value=z3950.cnv>
<input type=hidden name=encabezado value=s>
<?php
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="edit" ){
	$archivo=$db_path.$arrHttp["base"]."/def/".$arrHttp["Table"];
	if (file_exists($archivo)){
		$fp=file($archivo);
		foreach ($fp as $value){
			if (trim($value)!=""){
				$ix=strpos($value,":");
				$t=substr($value,0,$ix);
				if (isset($pft[$t])){
					$pft[$t].="/".substr($value,$ix+1);
				}else{
					$pft[$t]=substr($value,$ix+1);
				}
        	}
		}
	}
}

$Dir=$db_path.$arrHttp["base"]."/def/";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
echo "<dd><table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1 class=td width=95%>";
echo "<tr><td>".$msgstr["ft_f"]."</td><td>".$msgstr["tag"]."</td><td>".$msgstr["ft_s"]."</td><td nowrap>".$msgstr["z3950_cnv"]."</td>";
$ix=-1;

foreach ($fp as $value){
	$t=explode('|',$value);
	if ($t[0]!='G'){
		$ix=$ix+1;
		$tag=$t[1];
		if ($tag!=""){
			echo "<tr><td bgcolor=white class=td>";
			echo $t[2];
			echo "</td>";
			echo "<td bgcolor=white class=td>".$tag."<input type=hidden name=tag$tag value=".$tag."></td>";
			echo "<td bgcolor=white class=td>";
			echo $t[5];
			echo "</td>";
			echo "<td bgcolor=white><textarea cols=100 rows=1 name=formato$tag>";
			if (isset($pft[$tag])) echo $pft[$tag];
			echo "</textarea></td>";
		}
	}
}


echo "</table><p><dd>";
echo $msgstr["namecnvtb"].":";
if (!isset($arrHttp["Table"])){
	echo  "<input type=text name=namecnvtb size=30> &nbsp &nbsp;";
	echo $msgstr["description"].": ";
	echo "<input type=text name=descr size=30>\n";
}else{
	echo "<input type=text name=namecnvtb size=30 value='".$arrHttp["Table"]."'> &nbsp; &nbsp;\n";
	echo $msgstr["description"].": ";
	echo "<input type=text name=descr size=30 value='".$arrHttp["descr"]."'>\n";
}
echo " &nbsp; ";
include "../common/inc_save.php";
?>
<a href='<?php echo $backtoscript."?base=".$arrHttp["base"]?>' class="bt bt-red" title='<?php echo $msgstr["cancel"]?>'>
    <i class="fas fa-backspace"></i>&nbsp;<?php echo $msgstr["cancel"]?></a>

</form>
</div>
</div>
<?php include("../common/footer.php")?>
