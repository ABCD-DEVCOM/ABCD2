<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$arrHttp=array();

global $arrHttp;
include("../common/get_post.php");
include("../config.php");


include("../lang/dbadmin.php");

//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
include("../common/header.php");

echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo $msgstr["dbnpar"]." " .$msgstr["database"].": ".$arrHttp["base"]?>
			</div>

			<div class="actions">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php }
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";


echo "<font face=arial>";
echo "<xmp>".$arrHttp["par"]."</xmp>";
$fp=fopen($db_path."par/".$arrHttp["base"].".par","w");
fwrite($fp,$arrHttp["par"]);
fclose($fp);

echo "<p><h4>".$arrHttp["base"].".par ".$msgstr["updated"]."</H4>";
if (!isset($arrHttp["encabezado"]))echo "<a href=menu_modificardb.php?base=".$arrHttp["base"].">Menu</a><p>";
echo "
</div>
</div>
";
include("../common/footer.php");
echo "</body></html>\n";