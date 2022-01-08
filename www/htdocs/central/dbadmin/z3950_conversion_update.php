<?php
/*
20220108 fho4abcd backButton+ div helper+improve html
*/
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conversion_update.php
 * @desc:      Creates in the def folder a conversion table from z39.50
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
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$backtoscript="../dbadmin/z3950_conf.php";

$lang=$_SESSION["lang"];

include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["z3950"].": ".$msgstr["z3950_tab"]." (".$arrHttp["base"].")" ?>
	</div>

	<div class="actions">
    <?php
    $savescript="javascript:Enviar()";
	include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="z3950_conf.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<div style="text-align:center">
<?php
$tag=array();
$pft=array();
foreach ($arrHttp as $var=>$value) {
	$value=trim($value);
	if (substr($var,0,3)=="tag") {
		$ix=substr($var,3);
		if (isset($arrHttp["formato".$ix]))
			if (trim($arrHttp["formato".$ix])!="") $pft[$value]=stripslashes($arrHttp["formato".$ix]);

	}
}
$tabfile=$arrHttp["base"]."/def/".$arrHttp["namecnvtb"];
$file=$db_path.$tabfile;
$fp=fopen($file,"w");
if (!$fp){
	echo $tabfile.": ".$msgstr["nopudoseractualizado"];
	die;
}
foreach ($pft as $tag=>$value){
	fwrite($fp,$tag.":".$value."\n");
}
fclose($fp);
?>
<h4><?php echo $tabfile.": ".$msgstr["updated"];?></h4>
<?php
$add="Y";
$cnvfile=$arrHttp["base"]."/def/z3950.cnv";
$fp=array();
if (file_exists($db_path.$cnvfile)){
	$fp=file($db_path.$cnvfile);
	foreach ($fp as $value){
		$t=explode('|',$value);
		if ($t[0]==$arrHttp["namecnvtb"]){
			$add="N";
			break;
		}
	}
}

if ($add=="Y"){
	$out=fopen($db_path.$cnvfile,"w");
	foreach ($fp as $value){
		$res=fwrite($out,$value);
	}
	$res=fwrite($out,$arrHttp["namecnvtb"].'|'.$arrHttp["descr"]."\n");
	fclose($out);
?>
<h4><?php echo $cnvfile.": ".$msgstr["updated"]?></h4>
<?php } ?>
</div></div>
<?php
include("../common/footer.php");
?>