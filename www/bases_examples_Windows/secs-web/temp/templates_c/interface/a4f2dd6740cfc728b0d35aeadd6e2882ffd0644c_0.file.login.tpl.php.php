<?php
/* Smarty version 3.1.31, created on 2017-02-08 17:12:38
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\login.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b6da6ee6b46_91395898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a4f2dd6740cfc728b0d35aeadd6e2882ffd0644c' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\login.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589b6da6ee6b46_91395898 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
?>
<div class="loginForm">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	<div class="boxContent">
	<form action="?action=signin&amp;lang=<?php if ($_GET['lang'] == '') {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['LANGCODE'];
} else {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'];
}?>" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post">
		<input type="hidden" name="field[action]" id="action" value="do" />
		<div class="formRow">
			<label for="user"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsername'];?>
</label>
			<input type="text" name="field[username]" id="user" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry';" />
		</div>
		<div class="formRow">
			<label for="pwd"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblPassword'];?>
</label>
			<input type="password" name="field[password]" id="pwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry'; document.getElementById('selLibrary').focus();" />
		</div>
 		<div class="formRow">
			<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['library'];?>
</label>
            <select name="field[selLibrary]" id="selLibrary" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry'; document.getElementById('btLogin').focus();">
                <option value="" label="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
</option>
                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['codesLibrary']->value,'selected'=>$_smarty_tpl->tpl_vars['collectionLibrary']->value[$_smarty_tpl->tpl_vars['defaultLib']->value],'output'=>$_smarty_tpl->tpl_vars['collectionLibrary']->value),$_smarty_tpl);?>

            </select>
		</div>
		<div class="submitRow">
			<!--
			<div class="frLeftColumn">
				<div style="white-space: nowrap;">
					<input type="checkbox" name="setCookie" id="setCookie" value="yes" />
					<label for="setCookie" class="inline"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblKeepMeSigned'];?>
</label>
				</div>
				<a href="#"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblForgetMyPassword'];?>
?</a>
			</div>
			-->
			<div class="frRightColumn">
				<a href="javascript:doit('formData');" class="defaultButton goButton" id="btLogin">
					<img src="public/images/common/spacer.gif" alt="" title="" />
					<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLogIn'];?>
</strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="spacer">&#160;</div>
	</form>
	</div>
	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
</div><?php }
}
