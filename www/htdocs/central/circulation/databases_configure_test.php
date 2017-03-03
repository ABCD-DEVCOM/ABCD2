<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      databases_configure_test.php
 * @desc:      Tests the configuration of an bibliographic database
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

include("../lang/dbadmin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

function LeerRegistro($Pft,$base){global $arrHttp,$Wxis,$xWxis,$wxisUrl,$db_path;
	if (isset($arrHttp["Mfn"])){
		echo urldecode($Pft)."<p>";		$IsisScript=$xWxis."leer_mfnrange.xis";
		$query = "&base=$base&cipar=$db_path"."par/$base".".par&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Pft=$Pft";
		include("../common/wxis_llamar.php");
		foreach ($contenido as $value) echo "$value<br>";

	}}

include("../common/header.php");
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["sourcedb"].". ".$msgstr["loan"].". ".$msgstr["configure"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"javascript:self.close()\" class=\"defaultButton cancelButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
echo "		<div class=\"middle form\">
			<div class=\"formContent\">\n";

$object_db=$arrHttp["base"];
$presta_db="presta";

if (isset($arrHttp["totalej"])){
	echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_nejem"]."</font></H5>";
	$Pft=stripslashes($arrHttp["totalej"]);
	$Pft=urlencode($Pft);
	LeerRegistro($Pft,$object_db);
	echo "</td></table>";
}

if (isset($arrHttp["pft_ninv"])){
	echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_ninv"]."</font></H5>";
	$Pft=stripslashes($arrHttp["num_i"]);
	$Pft=urlencode($Pft);
	LeerRegistro($Pft,$object_db);
	echo "</td></table>";
}

if (isset($arrHttp["pft_nclas"])){
	echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_nclas"]."</font></H5>";
	$Pft=stripslashes($arrHttp["num_c"]);
	$Pft=urlencode($Pft);
	LeerRegistro($Pft,$object_db);
	echo "</td></table>";
}

if (isset($arrHttp["tm"])){
	echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_typeofr"]."</font></H5>";
	$Pft="";
	if (isset($arrHttp["num_i"]))
		$Pft=$arrHttp["num_i"].'\'$$$\'';
	$Pft.=$arrHttp["tm"];
	$Pft=urlencode("(".$Pft."/)");
	LeerRegistro($Pft,$object_db);
	echo "</td></table>";
}

echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_obj"]."</font></H5>";
$Pft=stripslashes($arrHttp["bibref"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);
echo "</td></table>";

echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_store"]."</font></H5>";
$Pft=stripslashes($arrHttp["bibstore"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);
echo "</td></table>";

echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_loandisp"]."</font></H5>";
$Pft=stripslashes($arrHttp["loandisp"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,"trans");
echo "</td></table>";

if (isset($arrHttp["pft_typeofr"])){
	echo "<table border=1 width=90%><td><h5><font color=darkred>". $msgstr["pft_typeofr"]."</font></H5>";
	$Pft=stripslashes($arrHttp["tm"]);
	$Pft=urlencode($Pft);
	LeerRegistro($Pft,$object_db);
	echo "</td></table>";
}

?>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>