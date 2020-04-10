<?php
/* Smarty version 3.1.31, created on 2017-02-08 17:12:38
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\index.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b6da65c9466_36441317',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21d246a081958812d43ff0fd63852997d68d970a' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\index.tpl.php',
      1 => 1485871996,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl.php' => 1,
    'file:heading.tpl.php' => 1,
    'file:navigation.tpl.php' => 1,
    'file:messages.tpl.php' => 1,
    'file:search.tpl.php' => 1,
    'file:pagination.tpl.php' => 1,
    'file:footer.tpl.php' => 1,
  ),
),false)) {
function content_589b6da65c9466_36441317 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'];?>
" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'];?>
">
    <?php $_smarty_tpl->_subTemplateRender("file:header.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <body>
        <?php $_smarty_tpl->_subTemplateRender("file:heading.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php $_smarty_tpl->_subTemplateRender("file:navigation.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <div id="middle" class="middle <?php if ($_smarty_tpl->tpl_vars['sMessage']->value) {?>message <?php if ($_smarty_tpl->tpl_vars['sMessage']->value['success']) {?>mSuccess<?php } elseif ($_smarty_tpl->tpl_vars['sMessage']->value['warning']) {?>mAlert<?php } else { ?>mError<?php }
} else {
echo $_smarty_tpl->tpl_vars['smartyTemplate']->value;
}?>">
        <?php if ($_smarty_tpl->tpl_vars['sMessage']->value) {?>
            <?php $_smarty_tpl->_subTemplateRender("file:messages.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php } else { ?>
            <?php if ($_smarty_tpl->tpl_vars['formRequest']->value) {?>
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['formRequest']->value).".form.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php } elseif ($_smarty_tpl->tpl_vars['listRequest']->value == 'homepage' || $_smarty_tpl->tpl_vars['listRequest']->value == 'login' || $_smarty_tpl->tpl_vars['listRequestReport']->value == "report") {?>
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['listRequest']->value).".tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php } else { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:search.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['listRequest']->value).".list.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                <?php $_smarty_tpl->_subTemplateRender("file:pagination.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php }?>
        <?php }?>
        </div>
        <?php $_smarty_tpl->_subTemplateRender("file:footer.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </body>
</html>
<?php }
}
