<?php
/* Smarty version 3.1.31, created on 2017-02-08 12:57:49
  from "/opt/ABCD/www/htdocs/secs-web/public/templates/interface/heading.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b31ed9576a7_08547670',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '07be07508d16a3f42befccf8d1785e1da5a14628' => 
    array (
      0 => '/opt/ABCD/www/htdocs/secs-web/public/templates/interface/heading.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589b31ed9576a7_08547670 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/opt/ABCD/www/htdocs/secs-web/common/plugins/smarty/libs/plugins/modifier.truncate.php';
?>
<div class="heading">
	<div class="institutionalInfo">
		<h1 class="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['institutionURL'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['appLogo'];?>
" target="_blank"><span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['appLogo'];?>
</span></a></h1>
		<h1><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['bannerTitle'];?>
</h1>
		<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleApp'];?>
</h2>
	</div>	
	<div class="userInfo">
		<?php if ($_SESSION['identified']) {?>
			<span><?php if ($_SESSION['fullName']) {?> <?php echo $_SESSION['fullName'];?>
 <?php } else { ?> <?php echo $_SESSION['logged'];?>
 <?php }?> |</span>
            <?php if ($_GET['m'] == '' && $_SESSION['optLibrary'][1] != '') {?>
                <?php echo smarty_modifier_truncate($_SESSION['library'],28,"...");?>
 |
            <?php } else { ?>
                <?php echo smarty_modifier_truncate($_SESSION['library'],72,"...");?>
 |
            <?php }?>

            <a href="?m=users&amp;edit=<?php echo $_SESSION['mfn'];?>
"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['myPreferences'];?>
</a> |
	  		<a href="?action=signoff&amp;lang=<?php echo $_SESSION['lang'];?>
" class="button_logout"><span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['logOff'];?>
</span></a>
		<?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "pt") {?><a href="?lang=pt" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['portuguese'];?>
</a> | <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "en") {?><a href="?lang=en" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['english'];?>
</a> | <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "es") {?><a href="?lang=es" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['espanish'];?>
</a> | <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "fr") {?><a href="?lang=fr" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['french'];?>
</a> | <?php }?>
        <?php }?>

	</div>
	<div class="spacer">&#160;</div>
</div><?php }
}
