<?php
/*
20220320 fho4abcd Created
20220630 fho4abcd Improved back button
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include ("../lang/reports.php");
$base=$arrHttp["base"];
include("../common/header.php");
$ayuda="barcode.html";
?>
<body>
<script>
function Top_bcl_config_label_table(){
    top.location.href = "../barcode/bcl_config_label_table.php?base=<?php echo $base?>"
}
</script>
<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["bcl_show_print"]?>
    </div>
    <div class="actions">
    <?php
    $backtoscript="../dataentry/inicio_main.php";
    include "../common/inc_back.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
include "inc_barcode_constants.php";
$error=0;
if (file_exists($labeltablefull)) {
    $labeltablearr=file($labeltablefull);
} else {
    $error++;
	echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["misfile"]." &rarr; ".$labeltable."</div>";
}
if ( $error==0 &&  count($labeltablearr)==0) {
    $error++;
	echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["bcl_fileempty"]." &rarr; ".$labeltable."</div>";
}
if ( $error!=0) {
    echo "<br><div>".$msgstr["bcl_continuewith"].": ";
    echo "<a href='javascript:Top_bcl_config_label_table()'>".$msgstr["barcode_table"]."</a>";
    echo "</div>";
	echo "</div></div>";
	include("../common/footer.php");
	die;
}
echo "<h3 style='text-align:center'>".$msgstr['bcl_select']."</h3>";
// Show a list of label names
?>
<table border=0 align=center>
    <?php
    foreach ($labeltablearr as $value) {
        $value=trim($value);
        if ($value=="") continue;
        $namedesc=explode("|",$value);
        $name=trim($namedesc[0]);
        if ($name=="") continue;
        $desc=$name;
        if (isset($namedesc[1]) && trim($namedesc[1]!="")) $desc=trim($namedesc[1]);
        $url="bcl_labelshow_ex.php?base=".$base."&tipo=".$name."&desc=".urlencode($desc);
        ?>
    <tr><td ><i class="fa fa-barcode"></i>
            <a href="<?php echo $url?>">
                <?php echo $desc ?></a><br>
         </td>
    </tr>
    <?php } ?>
</table>
</div>
</div>
<?php
include("../common/footer.php");
?>
