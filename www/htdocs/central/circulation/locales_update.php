<?php
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

include("../common/header.php");
include("../common/institutional_info.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".$msgstr["local"]."
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
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/locales.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/locales.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: locales.php </font>";
echo "</div>
		<div class=\"middle form\">
			<div class=\"formContent\"> ";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
echo "<xmp>";
$salida="; 0=domingo, 1=lunes, ...";
$salida="currency=\"".$arrHttp["currency"]."\"\n";
$salida.="fine=".$arrHttp["fine"]."\n";
//  Se graba el horario 0=domingo, 1=lunes, ...
$salida.= "[1]\n";
if (isset($arrHttp["mon"])){	$salida.= "from=".$arrHttp["mon_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["smon_from"]."\n";
	$salida.= "to=".$arrHttp["mon_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["smon_to"]."\n";}
$salida.= "[2]\n";
if (isset($arrHttp["tue"])){
	$salida.= "from=".$arrHttp["tue_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["stue_from"]."\n";
	$salida.= "to=".$arrHttp["tue_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["stue_to"]."\n";
}
$salida.= "[3]\n";
if (isset($arrHttp["wed"])){
	$salida.= "from=".$arrHttp["wed_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["swed_from"]."\n";
	$salida.= "to=".$arrHttp["wed_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["swed_to"]."\n";
}
$salida.= "[4]\n";
if (isset($arrHttp["thu"])){
	$salida.= "from=".$arrHttp["thu_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["sthu_from"]."\n";
	$salida.= "to=".$arrHttp["thu_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["sthu_to"]."\n";
}
$salida.= "[5]\n";
if (isset($arrHttp["fri"])){
	$salida.= "from=".$arrHttp["fri_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["sfri_from"]."\n";
	$salida.= "to=".$arrHttp["fri_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["sfri_to"]."\n";
}
$salida.= "[6]\n";
if (isset($arrHttp["sat"])){
	$salida.= "from=".$arrHttp["sat_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["ssat_from"]."\n";
	$salida.= "to=".$arrHttp["sat_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["ssat_to"]."\n";
}
$salida.= "[0]\n";
if (isset($arrHttp["sun"])){

	$salida.= "from=".$arrHttp["sun_from"]."\n";
	$salida.= "f_ampm=".$arrHttp["ssun_from"]."\n";
	$salida.= "to=".$arrHttp["sun_to"]."\n";
	$salida.= "t_ampm=".$arrHttp["ssun_to"]."\n";
}

echo "$salida</xmp>";
$fp=fopen($db_path."circulation/def/".$_SESSION["lang"]."/locales.tab","w");
$r=fwrite($fp,$salida) ;
fclose($fp);

echo"</form></div></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>