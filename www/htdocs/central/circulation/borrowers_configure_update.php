<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure_update.php
 * @desc:      Saves the configuration of the borrowers (users) database
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
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");

include("../lang/dbadmin.php");

include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

function GuardarPft($Pft,$base){
global $msgstr,$db_path;

	$fp=fopen($base,"w");
	if (!$fp){		echo "$base ".$msgstr["notsaved"]."<hr>";
		die;	}
	fwrite($fp,$Pft);
	echo "<xmp>".$Pft."</xmp><p>$base <strong>". $msgstr["saved"]." </strong><hr>";

}

include("../common/header.php");
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["sourcedb"].". ".$msgstr["bconf"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"middle form\">
			<div class=\"formContent\">\n";

$object_db=$arrHttp["base"];


echo "<h5><font color=darkred>". $msgstr["uskey"]."</font></H5>";
$Pft=$arrHttp["uskey"];
$Pft.="\n".$arrHttp["usname"];
$Pft.="\n".$arrHttp["uspft"];
GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_uskey.tab");

echo "<h5><font color=darkred>". $msgstr["pft_uskey"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_uskey"]);
GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_uskey.pft");

echo "<h5><font color=darkred>". $msgstr["pft_ustype"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_ustype"]);
GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_ustype.pft");

echo "<h5><font color=darkred>". $msgstr["pft_usvig"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_usvig"]);
GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_usvig.pft");

echo "<h5><font color=darkred>". $msgstr["pft_usdisp"]."</font></H5>";
$Pft=stripslashes($arrHttp["pft_usdisp"]);
GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_usdisp.pft");

?>
</div></div>
</body>
</html>