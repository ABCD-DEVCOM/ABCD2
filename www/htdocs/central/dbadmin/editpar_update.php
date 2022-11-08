<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. Improve html, remove xmp tag
20220713 fho4abcd Use $actparfolder as location for .par files
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$arrHttp=array();

global $arrHttp;
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
include("../common/header.php");
$backtoscript="../dbadmin/menu_modificardb.php";
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["dbnpar"]." " .$msgstr["database"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<pre>
<?php
echo $arrHttp["par"];
echo "</pre>";
$fp=fopen($db_path.$actparfolder.$arrHttp["base"].".par","w");
fwrite($fp,$arrHttp["par"]);
fclose($fp);

echo "<h4>".$actparfolder.$arrHttp["base"].".par ".$msgstr["updated"]."</h4>";
echo "
</div>
</div>
";
include("../common/footer.php");
