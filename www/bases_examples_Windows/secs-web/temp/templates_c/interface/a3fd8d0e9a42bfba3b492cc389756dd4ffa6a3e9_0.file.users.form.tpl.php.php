<?php
/* Smarty version 3.1.31, created on 2017-02-10 07:30:55
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\users.form.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589d884fa3f2e1_85872134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3fd8d0e9a42bfba3b492cc389756dd4ffa6a3e9' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\users.form.tpl.php',
      1 => 1485991520,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589d884fa3f2e1_85872134 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataRecord']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
        <?php $_smarty_tpl->_assignInScope(("use").($_smarty_tpl->tpl_vars['k']->value), $_smarty_tpl->tpl_vars['v']->value);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<?php if ($_SESSION['logged'] == $_smarty_tpl->tpl_vars['use1']->value[0] || $_SESSION['role'] == "Administrator") {?>
<div class="yui-skin-sam">

<div id="collectionDialog" >
      <div class="hd"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleApp'];?>
</div>
        <div class="bd">
        <div id="collectionDisplayed"></div>
      </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">

YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_LOADING'];?>
</div></div>";
YAHOO.widget.DataTable.MSG_ERROR = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_ERROR'];?>
";


YAHOO.namespace("example.container");

function init() {
	var handleOK = function() {
		window.location.reload();
	};
        
	YAHOO.example.container.collectionDialog = new YAHOO.widget.Dialog("collectionDialog",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleOK } ]
							});

	YAHOO.example.container.collectionDialog.render();
}
YAHOO.util.Event.onDOMReady(init);

<?php echo '</script'; ?>
>

<div id="listRecords" class="listTable"></div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>
?m=<?php echo $_GET['m'];?>
&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >	

<div class="formHead">
	<?php if ($_GET['edit']) {?>
	<input type="hidden" name="mfn" value="<?php echo $_GET['edit'];?>
"/>
	<?php }?>
	<input type="hidden" name="gravar" id="gravar" value="false"/>
        <input type="hidden"  name="myRole" id="myRole" value="<?php echo $_SESSION['role'];?>
"/>

	<div id="formRow01" class="formRow" <?php if ($_SESSION['role'] != "Administrator") {?>style="display: none;"<?php }?>>
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsername'];?>
</label>
		<div class="frDataFields">
			<input  type="text" name="field[username]" id="username" value="<?php echo $_smarty_tpl->tpl_vars['use1']->value[0];?>
"  title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsername'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow01').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow01').className = 'formRow';"  />
			<div class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperUserName'];?>
</div>
			<div id="usernameError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow01_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [1] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsername'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpUser'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	
	<div id="formRow02" class="formRow" >
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblPassword'];?>
</label>
		<div class="frDataFields">
			<input type="password" name="field[passwd]" id="passwd" value="" title="*  <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblPassword'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';"  />
			<div class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperUserName'];?>
</div>
			<div id="passwdError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<div id="difPasswdError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['difPass'];?>
</div>
			<span id="formRow02_help">
				<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow02_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [3] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblPassword'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpPassword'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow03" class="formRow">
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcPassword'];?>
</label>
		<div class="frDataFields">
			<input type="password" name="cpasswd" id="cpasswd" value="" title="*  <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcPassword'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow03').className = 'formRow'; " />
			<div class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperUserName'];?>
</div>
			<div id="cpasswdError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow03_help">
				<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow03_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [3] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcPassword'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpcPassword'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

<?php if ($_GET['edit'] != 1) {?>
<div id="formRow14" class="formRow" <?php if ($_SESSION['role'] != "Administrator") {?>style="display: none;"<?php }?>>
        <label for="role"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
</label>
            <div class="frDataFields">
                <div class="frDFRow">
                    <div id="roleLib">
                        <!-- Role -->
                        <div class="frDFColumn">
                            <label class="inline"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
</label><br/>
                            <select name="role" id="role" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
" class="textEntry">
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optRole']),$_smarty_tpl);?>

                            </select>
                            <a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help"/></a>
                        </div>
                        <!-- /Role -->
                        <!-- Library -->
                        <div class="frDFColumn">
                            <label class="inline"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
</label><br/>
                            <select name="library" id="library" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
" class="textEntry">
                                <option value="" label="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
</option>
                                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['codesLibrary']->value,'output'=>$_smarty_tpl->tpl_vars['collectionLibrary']->value),$_smarty_tpl);?>

                            </select>
                            <a href="javascript:showHideDiv('formRow05_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help"/></a>
                        </div>
                        <!-- /Library -->
                        <!-- Help -->
                        <div class="helpBG" id="formRow04_helpA" style="display: none;">
                            <div class="helpArea">
                                <span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>
                                <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [4] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
</h2>
                                <div class="help_message">
                                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpRole'];?>

                                </div>
                            </div>
                        </div>
                        <div class="helpBG" id="formRow05_helpA" style="display: none;">
                            <div class="helpArea">
                                <span class="exit"><a href="javascript:showHideDiv('formRow05_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>
                                <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [5] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
</h2>
                                <div class="help_message">
                                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpLibrary'];?>

                                </div>
                            </div>
                        </div>
                        <!-- /Help -->
                        <div class="spacer">&#160;</div>
                        <a href="javascript:InsertLineSelect('role', 'library', '<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                            <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" title="spacer" />
                            <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
$__section_iten_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['use4']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_0_total = $__section_iten_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_0_total != 0) {
for ($__section_iten_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_0_iteration <= $__section_iten_0_total; $__section_iten_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
            <div class="frDataFields">
                <div class="frDFRow">
                    <div id="roleLib">
                        <div id="frDataFieldsRole<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDFColumn">
                            <input type="text" name="field[role][]" id="role" value="<?php echo $_smarty_tpl->tpl_vars['use4']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" readonly="readonly" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
" class="textEntry">
                        </div>
                        <div id="frDataFieldsLibrary<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDFColumn">
                            <input type="text" name="field[library][]" id="library" value="<?php echo $_smarty_tpl->tpl_vars['use5']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" readonly="readonly" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
" class="textEntry" >
                            <input type="hidden" name="field[libraryDir][]" id="libraryDir" value="<?php echo $_smarty_tpl->tpl_vars['use6']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" readonly="readonly">
                            <a href="javascript:removeRow('frDataFieldsRole<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
'); removeRow('frDataFieldsLibrary<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                                <span class="sb_lb">&#160;</span>
                                <img src="public/images/common/spacer.gif" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                                <span class="sb_rb">&#160;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }} else {
 ?>
                <?php if ($_smarty_tpl->tpl_vars['use4']->value) {?>
                <div class="frDataFields">
                    <div class="frDFRow">
                        <div id="roleLib">
                            <div id="frDataFieldsrolep" class="frDFColumn">
                                <select name="field[role][]" id="role" readonly="readonly" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
" class="textEntry">
                                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optRole'],'selected'=>$_smarty_tpl->tpl_vars['use4']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)]),$_smarty_tpl);?>

                                </select>
                            </div>
                            <div id="frDataFieldslibraryp" class="frDFColumn">
                                <select name="field[library][]" id="library" readonly="readonly" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
" class="textEntry">
                                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optRole'],'selected'=>$_smarty_tpl->tpl_vars['use5']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)]),$_smarty_tpl);?>

                                </select>
                                <a href="javascript:removeRow('frDataFieldsLibraryp'); removeRow('frDataFieldsRolep');" class="singleButton eraseButton">
                                    <span class="sb_lb">&#160;</span>
                                    <img src="public/images/common/spacer.gif" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                                    <span class="sb_rb">&#160;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            <?php
}
if ($__section_iten_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_0_saved;
}
?>
            <div id="frDataFieldsrole" style="display:block!important">&#160;</div>
        <div class="spacer">&#160;</div>
    </div>
   <div class="spacer">&#160;</div>
<?php }?>


</div>
<div class="formContent">
	<div id="formRow06" class="formRow">
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblFullname'];?>
</label>
		<div class="frDataFields">
			<input type="text" name="field[fullname]" id="fullname" value="<?php echo $_smarty_tpl->tpl_vars['use8']->value[0];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow06').className = 'formRow';" />
			<div id="fullnameError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow06_help">
				<a href="javascript:showHideDiv('formRow06_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow06_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow06_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [8] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblFullname'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpFullname'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow07" class="formRow" <?php if ($_SESSION['role'] != "Administrator") {?>style="display: none;"<?php }?>>
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsersAcr'];?>
</label>
		<div class="frDataFields">
			<input type="text" name="field[userAcr]" id="userAcr" value="<?php echo $_smarty_tpl->tpl_vars['use2']->value[0];?>
" title="*  <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsersAcr'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow07').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow07').className = 'formRow';" />
			<div class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperUserName'];?>
</div>
			<div id="userAcrError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow07_help">
				<a href="javascript:showHideDiv('formRow07_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow07_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow07_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [2] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUsersAcr'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpUsersAcr'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>


	<div id="formRow04" class="formRow" >
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEmail'];?>
</label>
		<div class="frDataFields">
			<input name="field[email]" id="email" value="<?php echo $_smarty_tpl->tpl_vars['use11']->value[0];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow04').className = 'formRow';" />
			<div id="emailError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow04_help">
				<a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow04_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [11] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEmail'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpEmail'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

   
	<div id="formRow08" class="formRow" <?php if ($_SESSION['role'] != "Administrator") {?>style="display: none;"<?php }?>>
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblInstitution'];?>
</label>
		<div class="frDataFields">
			<input type="text" name="field[institution]" id="institution" value="<?php echo $_smarty_tpl->tpl_vars['use9']->value[0];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow08').className = 'formRow';" />
			<div class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperUserName'];?>
</div>
			<div id="institutionError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
			<span id="formRow08_help">
				<a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow08_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [9] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblInstitution'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpInstitution'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow10" class="formRow" <?php if ($_SESSION['role'] != "Administrator") {?>style="display: none;"<?php }?>>
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblNotes'];?>
</label>
		<div class="frDataFields">
			<textarea name="field[notes]" id="notes" class="textEntry singleTextEntry" rows="4" cols="50" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" ><?php echo $_smarty_tpl->tpl_vars['use10']->value[0];?>
</textarea>
			<span id="formRow10_help">
				<a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow10_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [10] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblNotes'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpNotes'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

        <?php if ($_SESSION['role'] != "Administrator" || $_GET['edit'] == 1) {?>
    	<div id="formRow01" class="formRow" >
		<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lang'];?>
</label>
		<div class="frDataFields">
                    <?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "pt") {?><a href="#" onclick="changeLanguage('pt','3','<?php echo $_SESSION['mfn'];?>
');" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['portuguese'];?>
</a> |<?php }?>
            <?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "en") {?><a href="#" onclick="changeLanguage('en','3','<?php echo $_SESSION['mfn'];?>
');" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['english'];?>
</a> | <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "es") {?><a href="#" onclick="changeLanguage('es','3','<?php echo $_SESSION['mfn'];?>
');" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['espanish'];?>
</a> | <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['BVS_LANG']->value['metaLanguage'] != "fr") {?><a href="#" onclick="changeLanguage('fr','3','<?php echo $_SESSION['mfn'];?>
');" target="_self"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['french'];?>
</a><?php }?>
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow01_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
				<h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lang'];?>
</h2>
				<div class="help_message">
					<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpLang'];?>

				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
        <?php }?>
	
</div>
</form>
<?php } else { ?>
    <div id="middle" class="middle message mAlert">
        <img src="public/images/common/spacer.gif" alt="" title="" />
        <div class="mContent">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['mFail'];?>
</h4>
            <p><strong><?php echo $_smarty_tpl->tpl_vars['sMessage']->value['message'];?>
</strong></p>
            <p><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['msg_op_fail'];?>
</strong></p>
            <div>
                <code><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['error404'];?>
</code>
            </div>
            <span><a href="index.php"><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btBackAction'];?>
</strong></a></span>
        </div>
        <div class="spacer">&#160;</div>
    </div>
<?php }
}
}
