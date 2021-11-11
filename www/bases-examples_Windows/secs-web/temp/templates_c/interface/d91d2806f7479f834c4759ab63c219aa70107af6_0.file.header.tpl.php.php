<?php
/* Smarty version 3.1.31, created on 2017-02-08 17:12:38
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\header.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b6da679baf9_79204220',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd91d2806f7479f834c4759ab63c219aa70107af6' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\header.tpl.php',
      1 => 1485954120,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589b6da679baf9_79204220 (Smarty_Internal_Template $_smarty_tpl) {
?>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleApp'];
if ($_smarty_tpl->tpl_vars['listRequest']->value) {?> :: <?php if ($_GET['m']) {?> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['adminDataOf'];?>
 <?php }
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value[$_smarty_tpl->tpl_vars['listRequest']->value];
}?></title>

	<meta http-equiv="Expires" content="-1" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaCharset'];?>
" />
	<meta http-equiv="Content-Language" content="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'];?>
" />

	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaKeywords'];?>
" />
	<meta http-equiv="description" content="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaDescription'];?>
" />
	<!-- Stylesheets -->
	<!--Styles for yui -->
	<style type="text/css">
	
		/* custom styles for this example */
		#dt-pag-nav { margin-bottom:1em; } /* custom pagination UI */
		#yui-history-iframe {
  			position:absolute;
  			top:0; left:0;
  			width:1px; height:1px; /* avoid scrollbars */
  			visibility:hidden;
		}
	
	</style>
	<link rel="shortcut icon" href="favicon.ico"/>		
	<link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/fonts/fonts-min.css" />
	<link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/datatable/assets/skins/sam/datatable.css" />
    <link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/container/assets/skins/sam/container.css" />
    <link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/menu/assets/skins/sam/menu.css" />
    <link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/button/assets/skins/sam/button.css" />
    <link rel="stylesheet" type="text/css" href="common/plugins/yui/2.5.1/build/calendar/assets/skins/sam/calendar.css" />


	<!-- Stylesheets -->
        <link rel="stylesheet" rev="stylesheet" href="public/css/template.css" type="text/css" media="screen"/>
        <!--[if IE]>
            <link rel="stylesheet" rev="stylesheet" href="public/css/bugfixes_ie.css" type="text/css" media="screen"/>
        <![endif]-->
        <!--[if IE 6]>
            <link rel="stylesheet" rev="stylesheet" href="public/css/bugfixes_ie6.css" type="text/css" media="screen"/>
   <![endif]-->
	
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/yahoo-dom-event/yahoo-dom-event.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/datasource/datasource-beta-min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/connection/connection-min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/json/json-min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/history/history-min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/element/element-beta-min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/datatable/datatable-beta-min.js"><?php echo '</script'; ?>
>
	
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/utilities/utilities.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/container/container_core-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/container/container-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/menu/menu-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/button/button-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="common/plugins/yui/2.5.1/build/calendar/calendar-min.js"><?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="public/js/validation.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="public/js/functions.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="public/js/md5.js"><?php echo '</script'; ?>
>


</head>
<?php }
}
