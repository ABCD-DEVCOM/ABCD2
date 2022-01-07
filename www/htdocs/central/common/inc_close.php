<?php
/*
20220107 fho4abcd created
Function  : Show the close button in the breadcrumb in div class actions
Usage     : <?php include "../common/inc_close.php" ?>
** Variables none
*/
?>
<a href="javascript:self.close()" class="bt bt-red" title='<?php echo $msgstr["cerrar"]?>'>
    <i class="far fa-window-close"></i>&nbsp;<?php echo $msgstr["cerrar"]?></a>
<?php