<?php
/*
20220309 fho4abcd created
*/
set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;

include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/soporte.php");
include ("../lang/reports.php");

include ("../common/header.php");
echo "<body>";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
echo "<h3 style='text-align:center'>".$msgstr["barcode_font_check"]."</h3>";
$font_family=$arrHttp["fontfamily"];
$font_family=urldecode($font_family);
$text="12345-abCD";
$pft=$arrHttp["pft"];
$pft=urldecode($pft);
?>
<div style='color:blue'>
    <?php echo $msgstr["barcode_sample_1"]." <b>".$text."</b> ".$msgstr["barcode_sample_2"]." <b>".$font_family;?></b></div>
<hr>
<span style="font-family:'<?php echo $font_family?>'"><?php echo $text?></span>
<hr>
<div style='color:blue'><?php echo $msgstr["barcode_sample_3"]?>
    <b><?php echo $font_family;?></b>
    <?php echo $msgstr["barcode_sample_4"]?>
</div>
<br>
<br>
<div style='color:blue'><?php echo $msgstr["barcode_pft_1"];?></div>
<div style='color:blue'><?php echo $msgstr["barcode_pft_2"];?></div>
<hr>
<span><?php echo $pft;?></span>
<hr>
<div style='color:blue;text-align:left'><?php echo $msgstr["barcode_pft_3"]?></div>
</div></div>
<?php
include ("../common/footer.php");
?>
</body></html>
<?php
