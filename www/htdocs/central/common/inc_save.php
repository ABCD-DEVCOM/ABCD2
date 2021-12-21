<?php
/*
20211220 rogercgui Copied from inc_back.php
Function  : Show the save button in the breadcrumb in div class actions
Usage     : <?php include "../common/inc_save.php" ?>
** Variable
**  $savescript   : The save script.
*/

$inc_save="";
if (isset($savescript) AND $savescript!="" ) {
    $inc_save=$savescript;
} else {
    $inc_save="/central/common/inicio.php";
}
?>

<a href="<?php echo $inc_save;?>" class="button_browse " title='<?php echo $msgstr["regresar"]?>'>
    <i class="far fa-save"></i>&nbsp;<?php echo $msgstr["actualizar"]?></a>
<?php
unset($inc_save);
