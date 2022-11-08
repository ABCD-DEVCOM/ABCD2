<?php
/*
20211215 fho4abcd Backbutton by & helper by included file
*/
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      copies_linkdb.php
 * @desc:      Reads if a database is linked or not to the copies database
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
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//READ BASES.DAT TO READ IF THE DATABASE IS LINKED WITH COPIES DATABASE
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
$base=$arrHttp["base"];
$fp=file($db_path."bases.dat");
$copies_link="";
foreach ($fp as $value){
	$value=trim($value);
	$v=explode('|',$value);
	if ($v[0]==$base && (isset($v[2]))){
		if ($v[2]=="Y") $copies_link=" checked";
		break;
	}
}


include("../common/header.php");
echo "<body>\n";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=../dataentry/js/lr_trim.js></script>"
?>
<script>
function Enviar(){
	control=Trim(document.forma1.control_n.value)
	if (control=="" || control=="0"){
		if (confirm("The control number of the database will be restored to 0 \n\n Is that correct? ")){
			if (confirm("are you sure?")){
			}else{
				return
			}
		}else{
			return
		}
	}
	control=Trim(document.forma1.inv_n.value)
	if (control=="" || control=="0"){
		if (confirm("The inventory number of the copies database will be restored to 0 \n\n Is that correct? ")){
			if (confirm("are you sure?")){
			}else{
				return
			}
		}else{
			return
		}
	}
	document.forma1.submit()
}


</script>
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["linkcopies"].": $base"?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
echo "<div class=\"middle form\">
	<div class=\"formContent\">";
echo "<form name=forma1 action=resetautoinc_update.php method=post>
 <input type=hidden name=base value=$base>
 <input type=hidden name=Opcion value=copies>\n";
if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=s>\n";
echo "<h3>".$msgstr["database"]." ".$base."<p>";
echo "<br><input type=checkbox name=copies value=on $copies_link>".$msgstr["incopies"].".<br>".$msgstr["copiesreq"]."</h3>";
echo "<input type=submit name=mark value=".$msgstr["update"].">";

echo "<form></div></div>";
include("../common/footer.php");

?>