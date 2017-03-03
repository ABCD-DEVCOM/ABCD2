<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      disable_db.php
 * @desc:      Disable database on the loan system
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
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";  die;
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../lang/prestamo.php");
include("../common/header.php");

function ActualizarLoansDat(){
global $db_path,$arrHttp,$msgstr;
	if (isset($arrHttp["loan_option"])) {
		if ($arrHttp["loan_option"]=="copies"){
			if (file_exists($db_path."loans.dat")){
				unlink($db_path."loans.dat");
				echo "<h2>loans.dat: ".$msgstr["delete"]."</h4>";
			}
		}else{
			$loans_dat=array();
			if (file_exists($db_path."loans.dat")){
				$fp=file($db_path."loans.dat");
				foreach ($fp as $base){					$base=trim($base);
					if ($base!=""){
						$b=explode("|",$base);
						$loans_dat[$b[0]]=$b[1];
					}
				}
				if (isset($loans_dat[$arrHttp["base"]])){
					unset($loans_dat[$arrHttp["base"]]);
				}
				$fp=fopen ($db_path."loans.dat","w");
				foreach ($loans_dat as $var=>$value){
					if (trim($value)!=""){
						echo "$var|$value<br>";
						fwrite($fp,$var."|".$value."\n");
					}
				}
				fclose($fp);
				echo "<h2>loans.dat: ".$msgstr["updated"]."</h4>";
			}
		}
	}
}

function DeleteFiles($files){
global $db_path,$arrHttp,$msgstr;
	$path_to_file=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/";
	$short_path=$arrHttp["base"]."/loans/".$_SESSION["lang"]."/";
	foreach ($files as $value){
		if (file_exists($path_to_file.$value)){
			unlink($path_to_file.$value);
			echo $short_path.$value." ".$msgstr["deleted"]."<br>";
		}
	}
}

$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["sourcedb"].": ".$arrHttp["base"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/loans_databases.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/loans_databases.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/disable_db.php </font>";

echo " </div>
		<div class=\"middle form\">
			<div class=\"formContent\">";
if ($arrHttp["base"]!="loanobjects"){
	$files_to_delete=array();
	$files_to_delete[]="loans_conf.tab";
	$files_to_delete[]="loans_inventorynumber.pft";
	$files_to_delete[]="loans_cn.pft";
	$files_to_delete[]="loans_typeofobject.pft";
	$files_to_delete[]="loans_totalitems.pft";
	$files_to_delete[]="loans_display.pft";
	$files_to_delete[]="loans_store.pft";
	$files_to_delete[]="loans_show.pft";
	$files_to_delete[]="reserve_object.pft";
	DeleteFiles($files_to_delete);
}
ActualizarLoansDat();
echo "<h4>".$arrHttp["base"].": ".$msgstr["disabled"]."</h4>";
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>" ;
?>
