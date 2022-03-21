<?php
/*
20220316 fho4abcd Created
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
$base=$arrHttp["base"];
$backtoscript="../dbadmin/menu_modificardb.php";
include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["barcode_config"]. ": " . $base?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
    <?php include "../common/inc_home.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) and
    !isset($_SESSION["permiso"][$base."_CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$base."_CENTRAL_BARCODE"])){
        echo "<div style='color:red'>".$msgstr["invalidright"]."</div>";
        die;
}
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
    echo "<a href='../barcode/bcl_config_label_table.php?base=".$base."'>".$msgstr["barcode_table"]."</a>";
    echo "</div>";
	echo "</div></div>";
	include("../common/footer.php");
	die;
}
echo "<h3 style='text-align:center'>".$msgstr['barcode_conf']."</h3>";
echo "<div style='color:blue;text-align:center'>".$msgstr["bcl_info_labelcfgloc"]." &rarr; ".$pftfileprefix."</div><br>";
// Show a list of labels & links to configure the barcode
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
        ?>
    <tr><td valign="middle"><?php echo $desc." (".$name.")";?></td>
        <td style='padding:10px'><i class="fa fa-cog"></i>
            <a href="barcode_conf.php?base=<?php echo $base;?>&tipo=<?php echo $name;?>&desc=<?php echo urlencode($desc)?>">
                <?php echo $msgstr["barcode_config"];?></a><br>
            <i class="fa fa-barcode"></i>
            <a href="barcode_font.php?base=<?php echo $base;?>&tipo=<?php echo $name;?>&desc=<?php echo urlencode($desc)?>">
               <?php echo $msgstr["barcode_font"];?></a>
        </td>
    </tr>
    <?php } ?>
</table>
<div style='text-align:center'>
    <?php echo $msgstr["bcl_continuewith"]?>: 
    <a href='../settings/editar_abcd_def.php?base=<?php echo $base?>&Opcion=dr_path'><?php echo$msgstr["dr_path.def"]?></a>
</div>

</div>
</div>
<?php
include("../common/footer.php");
?>
