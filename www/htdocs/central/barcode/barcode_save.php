<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      barcode_menu.php
 * @desc:      Reservas con objetos asignados ya vencidos
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
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");

include("../common/header.php");
echo "<body>\n";


if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="javascript:document.regresar.submit()" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
</div>
<?php
}
?>
<div class="helper">
<!--a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/file_reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/file_reports.html target=_blank>".$msgstr["edhlp"]."</a-->";
echo "<font color=white>&nbsp; &nbsp; Script: barcode/barcode_save.php";
?>
</font>
</div>
<div class="middle homepage">
<?php
$base=$_SESSION["base_barcode"];
$fp=fopen($db_path.$base."/def/".$_SESSION["lang"]."/barcode_code.tab","w");
foreach ($_REQUEST as $var=>$value){	echo "$var=$value<br>";
	fwrite($fp,$var."=".$value."\n");
}
fclose($fp);
echo "<h4>barcode_code.tab Guardado!!";
?>

<p>
<form name=regresar method=post action=barcode_menu.php>
<input type=hidden name=base value=<?php echo $base?>>
<input type=submit value=Regresar>
</form>
</div>
</body>
</html>
