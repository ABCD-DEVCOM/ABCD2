<?php
/*
20211214 fho4abcd Created
Function  : Show the backbutton in the breadcrumb in div class actions
Usage     : <?php include "../common/inc_back.php" ?>
** Variables
**  $arrHttp["base"]: The current database. If not set the Home page is shown
**  $backtoscript   : The return script.  If not set the Home page is shown
*/

$inc_backtourl="";
if (isset($backtoscript) AND $backtoscript!="" ) {
    $inc_backtourl=$backtoscript;
} else {
    $inc_backtourl="/central/common/inicio.php";
}
if (isset($arrHttp["base"]) AND $arrHttp["base"]!="")  {
    $inc_backtourl.="?base=".$arrHttp["base"];
}
?>
<a href="<?php echo $inc_backtourl?>" class="button_browse " title='<?php echo $msgstr["regresar"]?>'>
    <i class="fas fa-arrow-circle-left"></i>&nbsp;<?php echo $msgstr["regresar"]?></a>
<?php
unset($inc_backtourl);
