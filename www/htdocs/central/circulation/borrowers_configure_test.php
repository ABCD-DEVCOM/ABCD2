<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure_test.php
 * @desc:      Test the pfts for the borrowers (users) database
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
		$query = "&base=$base&cipar=$db_path"."par/$base".".par&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Pft=$Pft";
		$contenido="";
		$IsisScript=$xWxis."leer_mfnrange.xis";
		include("../common/wxis_llamar.php");
		foreach ($contenido as $value) echo "$value<br>";

	}}

include("../common/header.php");
echo "		<div class=\"middle form\">
			<div class=\"formContent\">\n";

$object_db=$arrHttp["base"];

echo "<h5><font color=darkred>". $msgstr["pft_uskey"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_uskey"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);

echo "<h5><font color=darkred>". $msgstr["pft_ustype"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_ustype"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);

echo "<h5><font color=darkred>". $msgstr["pft_usvig"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_usvig"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);

echo "<h5><font color=darkred>". $msgstr["pft_usdisp"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_usdisp"]);
$Pft=urlencode($Pft);
LeerRegistro($Pft,$object_db);

?>
</div></div>
<?php include("../common/footer.php")?>;
</body>
</html>