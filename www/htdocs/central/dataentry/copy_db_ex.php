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
?>
</head>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["db_cp"].": ".$arrHttp["base"]?>
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
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/copy_db_ex.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
$err="";
$from=$db_path.$arrHttp["base"]."/data/".$arrHttp["base"];
$to=$arrHttp["storein"];
$copyname=$arrHttp["copyname"];
if (substr($to,0,1)=="/") $to=substr($to,1);
if (substr($to,strlen($to)-1,1)=="/") $to=substr($to,0,strlen($to)-1);
$copyname=str_replace('/',"",$copyname);
$to=$db_path.$to."/".$arrHttp["copyname"];
$OS=PHP_OS;
if (strtoupper(substr($OS,0,3))== "WIN"){
	$target="pc";
	$extension="bat";
}else{
	$target="linux";
	$extension="sh";
}
echo "<H4>" . $from ." => $to</H4>";
if (isset($arrHttp["reorganize"])){
	if (!isset($mx_path)){
		echo $msgstr["mis_mx_path"];
	    die;
	}
	$mx_path=trim($mx_path);

	$res=exec($mx_path." $from create=$to -all now tell=1 ",$contenido,$resultado);
	$fp=fopen($to.".$extension","w");
	fwrite($fp,$mx_path." $from create=$to -all now tell=1");
	fclose($fp);
	echo "<font color=red>CISIS: <B>".$mx_path." $from create=$to -all now tell=1</B></font><br>";
	echo $to.".$extension ".$msgstr["created"]."<p>";
	if ($resultado==0){		echo $from.".mst ".$msgstr["reorganized"]."<br>";	}else{		$err="Y";	}}else{	$res=copy($from.".mst",$to.".mst");
	if ($res==1)
		echo $from.".mst ",$to.".mst".$msgstr["copied"]."<br>";
	else
		$err="Y";
	$res=copy($from.".xrf",$to.".xrf");
	if ($res==1)
		echo $from.".xrf ",$to.".xrf ".$msgstr["copied"]."<br>";
	else
		$err="Y";}

$res=copy($from.".cnt",$to.".cnt");
if ($res==1)
	echo $from.".cnt ",$to.".cnt ".$msgstr["copied"]."<br>";
else
	$err="Y";
$res=copy($from.".n01",$to.".n01");
if ($res==1)
	echo $from.".n01 ",$to.".n01 ".$msgstr["copied"]."<br>";
else
	$err="Y";
$res=copy($from.".n02",$to.".n02");
if ($res==1)
	echo $from.".n02 ",$to.".n02 ".$msgstr["copied"]."<br>";
else
	$err="Y";
$res=copy($from.".l01",$to.".l01");
if ($res==1)
	echo $from.".l01 ",$to.".l01 ".$msgstr["copied"]."<br>";
else
	$err="Y";
$res=copy($from.".l02",$to.".l02");
if ($res==1)
	echo $from.".l02 ",$to.".l02 ".$msgstr["copied"]."<br>";
else
	$err="Y";
$res=copy($from.".ifp",$to.".ifp");
if ($res==1)
	echo $from.".ifp ",$to.".ifp ". $msgstr["copied"]."<br>";
else
	$err="Y";
if ($err=="Y") echo $msgstr["ok"];


if (isset($contenido)) foreach ($contenido as $value) echo "$value<br>" ;
?>
</div>
</div>
</center>
<?php

include("../common/footer.php");
?>

</body>
</html>