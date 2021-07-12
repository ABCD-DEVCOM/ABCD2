<?php
/* Modifications
2021-07-11 fh04abcd Rewrite: Improve html&layout, div-helper
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

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$sep='|';
$db=explode($sep,$arrHttp["base"]);
$db=$db[0];
if(!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$db.".par";
$ciparamp="&amp;cipar=".$arrHttp["cipar"];
include("../common/header.php");
?>
<body>
<script>
function Edit(){
	if  (document.forma1.cnv.selectedIndex<1){
		alert('<?php echo $msgstr["selcnvtb"]?>')
		return	}
	document.enviar.action="z3950_conversion.php";
	document.enviar.Table.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].value
	document.enviar.descr.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].text
	document.enviar.Opcion.value="edit"
	document.enviar.submit()}
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
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["z3950"]." (".$db.")" ?>
	</div>

	<div class="actions">
<?php
	 echo "<a href='../common/inicio.php?reinicio=s&base=$db' class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>

<div class="middle form">
	<div class="formContent">
	<form name=forma1>
	<table >
    <tr><td>
        <li><a href='../dataentry/browse.php?base=servers&return=../dbadmin/z3950_conf.php|base=<?php echo $db.$encabezado?>'><?php echo $msgstr["z3950_servers"]?></a><br><br></li>
    </td></tr>
    <tr><td>
        <li><?php echo $msgstr["z3950_cnv"]?>
    </td><td>
        <a href='z3950_conversion.php?base=<?php echo $db.$encabezado?>'><?php echo $msgstr["new"]?></a>
        <?php
        if (file_exists($db_path.$db."/def/z3950.cnv")){            echo  "&nbsp; | <a href=javascript:Edit()>".$msgstr["edit"]."</a> &nbsp; | <a href=javascript:Delete()>".$msgstr["delete"]."</a> &nbsp; ";
            $fp=file($db_path.$db."/def/z3950.cnv");
            echo "<select name=cnv>
            <option value=''>\n";
            foreach ($fp as $var=>$value){
                $o=explode('|',$value);                echo "<option value='".$o[0]."'>".$o[1]."\n";            }
            echo "</select><br><br>";        }
        ?>
        <a href='z3950_diacritics_edit.php?base=<?php echo $db.$encabezado?>'><?php echo $msgstr["z3950_diacritics"]?></a><br><br>
    </td></tr>
    <tr><td>
        <li><a href='../dataentry/z3950.php?base=<?php echo $db.$encabezado.$ciparamp?>&test=Y&Opcion=test&backtoscript=../dbadmin/z3950_conf.php' target=_blank><?php echo $msgstr["test"]?></a></li>
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
<?php if ($encabezado!="")
echo "<input type=hidden name=encabezado value=s>\n";
?>
<form>
<?php include("../common/footer.php")?>
</body>
</html>