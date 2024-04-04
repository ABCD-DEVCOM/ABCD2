<?php
/*
20220107 fho4abcd created
20240403 fho4abcd Added variables
Function  : Show the close button in the breadcrumb in div class actions
Usage     : <?php include "../common/inc_close.php" ?>
** Variables
**  $smallbutton	: true/false. Default false. Shows smaller button
**	$inframe		: true/false. Default false. Closes parent window
*/
$js_close_action="self";
if (isset($smallbutton) && isset($inframe)) $js_close_action="parent";
if (isset($smallbutton) && $smallbutton==true) {?>
<a href="javascript:<?php echo $js_close_action?>.close()" class="button_browse" title='<?php echo $msgstr["cerrar"]?>'>
    <i class="far fa-window-close  bt-red"></i>&nbsp;<?php echo $msgstr["cerrar"]?></a>
<?php } else {?>
<a href="javascript:<?php echo $js_close_action?>.close()" class="bt bt-red" title='<?php echo $msgstr["cerrar"]?>'>
    <i class="far fa-window-close"></i>&nbsp;<?php echo $msgstr["cerrar"]?></a>
<?php }?>