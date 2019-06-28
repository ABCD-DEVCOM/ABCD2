<?php
/* Smarty version 3.1.31, created on 2017-02-08 12:57:49
  from "/opt/ABCD/www/htdocs/secs-web/public/templates/interface/footer.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b31ed995525_71395042',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9560a7da3b471085b1792e8991a429899c46b477' => 
    array (
      0 => '/opt/ABCD/www/htdocs/secs-web/public/templates/interface/footer.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589b31ed995525_71395042 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_redirect_page')) require_once '/opt/ABCD/www/htdocs/secs-web/common/plugins/smarty/libs/plugins/function.redirect_page.php';
?>
<div class="footer">
	<div class="systemInfo">
		<strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleApp'];?>
 v<?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['version'];?>
</strong>
		<span>&copy; <?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['copyright'];?>
 - <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['institutionName'];?>
</span>
		<a href="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['institutionURL'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['institutionURL'];?>
</a>
	</div>
	<!--div class="distributorLogo">
		<a href="<?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['authorURI'];?>
" target="_blank"><span><?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['metaAuthor'];?>
</span></a>
	</div-->
	<div class="spacer">&#160;</div>
</div>
<?php if ($_smarty_tpl->tpl_vars['sMessage']->value['success']) {?>
	<?php echo smarty_function_redirect_page(array('time'=>3,'get'=>$_GET),$_smarty_tpl);?>

<?php }
}
}
