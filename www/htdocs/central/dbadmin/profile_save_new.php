<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      profile_save.php
 * @desc:      Save the profile data
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
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/header.php");
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/profile.php");
foreach ($arrHttp as $var => $value) echo "$var = $value<br>"; die;
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>

<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["PROFILES"]?>
	</div>

	<div class="actions">
<?php echo "<a href=\"profile_edit.php?base="."$encabezado\" class=\"defaultButton backButton\">";?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["BACK"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/profiles.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/profiles.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/profile_save.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<?php
$file=fopen($db_path."par/profiles/".$arrHttp["profilename"],"w");
foreach ($arrHttp as $key=> $value){
	if ($key!="encabezado"){		//echo "$key=$value<br>";
		fwrite($file,$key."=".$value."\n");
	}}
$profiles=array();
$fp=file($db_path."par/profiles/profiles.lst");
foreach ($fp as $val){
	$val=trim($val);
	if ($val!=""){		$p=explode('|',$val);
		$profiles[$p[0]]=$p[1];	}}
$profiles[$arrHttp["profilename"]]=$arrHttp["profiledesc"];
$fp=fopen($db_path."par/profiles/profiles.lst","w");
foreach ($profiles as $key=>$value){
	fwrite($fp,$key.'|'.$value."\n");}
fclose($fp);
echo "<h4>".$arrHttp["profilename"]." - " .$arrHttp["profiledesc"]." ".$msgstr['SAVED']."</h4>";
echo "</div>
</div>
</center>";
include("../common/footer.php");
echo "</body></html>\n";

?>