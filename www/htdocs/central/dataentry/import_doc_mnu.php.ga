<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      fmt.php
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
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$lang=$_SESSION["lang"];
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
require_once("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
require_once("../config.php");
require_once ("../lang/admin.php");
require_once ("../lang/importdoc.php");

if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
	$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
	if (isset($def["ROOT"])){
		$dr_path=trim($def["ROOT"]);
		$ix=strrpos($dr_path,"/");
        $dr_path_rel=substr($dr_path,0,$ix-1);
        $ix=strrpos($dr_path_rel,"/");
        $dr_path_rel="<i>[dr_path.def]</i>".substr($dr_path,$ix);
	}else{
		$dr_path=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"]."/";
		$dr_path_rel="<i>[DOCUMENT_ROOT]</i>/bases/".$arrHttp["base"]."/";
	}
}

include("../common/header.php");
?>
<body>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/import_doc.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/import_doc.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: import_doc_mnu.php" ?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<?php
echo "<form name=upload action=import_doc.php method=POST enctype=multipart/form-data>\n";
echo $msgstr["storein"].": ";
echo $dr_path_rel;
echo " <input type=text name=storein size=40 value=\"\" onfocus=blur()>\n";
echo " <a href=dirs_explorer.php?Opcion=explorar&base=".$arrHttp["base"]." target=_blank>".$msgstr["explorar"]."</a>";
echo "<P>";
echo "<input type=checkbox name=nomultiple value=true checked> ".$msgstr["nomultiple"]."<br>";
echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
echo "<input type=hidden name=fURL value='".$arrHttp["fURL"]."'>\n";
echo "<input type=hidden name=Tag value=".$arrHttp["Tag"].">\n";
echo "<input type=hidden name=Tipo value=".$arrHttp["Tipo"].">\n";
echo "<input type=hidden name=Mfn value=".$arrHttp["Mfn"].">\n";
echo "<table width=100%>\n";
echo "<tr><td class=menusec1>". $msgstr["archivo"]."</td>\n";
echo "<tr><td><input name=userfile[] type=file size=50></td></td>\n";
echo "</table>\n";
echo "  <input type=submit value='".$msgstr["uploadfile"]."'>\n";
echo "</form>\n";
?>
</div></div>
<?php
include("../common/footer.php");

?>
</body>
</Html>