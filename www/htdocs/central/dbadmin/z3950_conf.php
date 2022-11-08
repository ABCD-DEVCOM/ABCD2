<?php
/* Modifications
20210711 fho4abcd Rewrite: Improve html&layout, div-helper
20211216 fho4abcd Backbutton by included file
20220108 fho4abcd Improve layout&text
20220124 fho4abcd Ensure current database is present at exit
20220929 fho4abcd Improve layout, new style buttons, add error messages if yaz not loaded or servers db not present
*/

/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conf.php
 * @desc:      Configure Z39.50 client
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

include("../lang/dbadmin.php");
include("../lang/admin.php");

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$sep='|';
$db=explode($sep,$arrHttp["base"]);
$db=$db[0];
$arrHttp["base"]=$db;
if(!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$db.".par";
$ciparamp="&amp;cipar=".$arrHttp["cipar"];
include("../common/header.php");
?>
<body>
<script>
function Edit(){
	if  (document.forma1.cnv.selectedIndex<1){
		alert('<?php echo $msgstr["selcnvtb"]?>')
		return
	}
	document.enviar.action="z3950_conversion.php";
	document.enviar.Table.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].value
	document.enviar.descr.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].text
	document.enviar.Opcion.value="edit"
	document.enviar.submit()
}
function Delete(){
	if  (document.forma1.cnv.selectedIndex<1){
		alert('<?php echo $msgstr["selcnvtb"]?>')
		return
	}
	document.enviar.action="z3950_conversion_delete.php";
	document.enviar.Table.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].value
	document.enviar.Opcion.value="delete"
	document.enviar.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["z3950"]." (".$db.")" ?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<?php
$error=0;
$serversfolder=$db_path."servers";
if ( !file_exists($serversfolder)) {
    $error++;
    echo "<font color=red><b>".$msgstr["missing_serversdb"]." ".$msgstr["folderne"].": ".$serversfolder."</b></font><br>";
}
if (!extension_loaded('yaz') || !function_exists('yaz_connect')) {
    $error++;
    echo "<font color=red><b>".$msgstr["z3950_yaz_missing"]."</b></font><br>";
}

?>
<form name=forma1>
<table>
    <tr><td>
        <a class="bt bt-blue" href='../dataentry/browse.php?base=servers&return=../dbadmin/z3950_conf.php|base=<?php echo $db?>'><?php echo $msgstr["z3950_servers"]?></a><br><br>
    </td></tr>
    <tr><td>
        <h4><?php echo $msgstr["z3950_cnv"]?>
        </td><td>
        <table>
            <tr>
            <td>
                <a class="bt bt-green" href='z3950_conversion.php?base=<?php echo $db?>'>
                    <i class="far fa-plus-square"></i> &nbsp;<?php echo $msgstr["z3950_new_table"]?></a>
            </td>
            <tr><td>
            <?php
            if (file_exists($db_path.$db."/def/z3950.cnv")){
                $fp=file($db_path.$db."/def/z3950.cnv");
                ?>
                <select name=cnv>
                    <option value=''>
                    <?php
                    foreach ($fp as $var=>$value){
                        $o=explode('|',$value);
                        echo "<option value='".$o[0]."'>".$o[1]."\n";
                    }
                    ?>
                </select> &nbsp;
                <a class="bt bt-green" href=javascript:Edit()><i class="far fa-edit"></i> &nbsp;<?php echo $msgstr["edit"]?></a>
                <a class="bt bt-red" href=javascript:Delete()><i class="fas fa-trash"></i> &nbsp;<?php echo $msgstr["delete"]?></a>
                <?php
            }
            ?>
            </td></tr><tr>
            <td>
                <a class="bt bt-gray" href='z3950_diacritics_edit.php?base=<?php echo $db?>'><?php echo $msgstr["z3950_diacritics"]?></a>
            </td>
            </tr>
        </table>
        </td>
    </tr>
    <tr><td>
        <a class="bt bt-blue" href='../dataentry/z3950.php?base=<?php echo $db.$ciparamp?>&test=Y&Opcion=test&backtoscript=../dbadmin/z3950_conf.php' >
            <?php echo $msgstr["test"].": ". $msgstr["catz3950"];?></a>
    </td></tr>
</table>
</form>
</div>
</div>
<form name=enviar method=post>
<input type=hidden name=base value=<?php echo $db?>>
<input type=hidden name=Opcion>
<input type=hidden name=Table>
<input type=hidden name=descr>
<form>
<?php include("../common/footer.php")?>
