<?php
/* Smarty version 3.1.31, created on 2017-02-08 12:57:49
  from "/opt/ABCD/www/htdocs/secs-web/public/templates/interface/navigation.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589b31ed985c82_95663169',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8938676f75099191df064ee74d9aee2d2fe52211' => 
    array (
      0 => '/opt/ABCD/www/htdocs/secs-web/public/templates/interface/navigation.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589b31ed985c82_95663169 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_breadcrumb')) require_once '/opt/ABCD/www/htdocs/secs-web/common/plugins/smarty/libs/plugins/function.breadcrumb.php';
if (!is_callable('smarty_function_html_options')) require_once '/opt/ABCD/www/htdocs/secs-web/common/plugins/smarty/libs/plugins/function.html_options.php';
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo smarty_function_breadcrumb(array('total'=>$_smarty_tpl->tpl_vars['totalRecords']->value),$_smarty_tpl);?>

    </div>
	
	<?php if ($_SESSION['identified']) {?>
		<div id="actionsButtons" class="actions">
		<?php if (!isset($_smarty_tpl->tpl_vars['sMessage']->value)) {?>	
			<?php if ($_GET['edit'] || $_GET['action']) {?>
				<?php if ($_GET['m'] == 'title') {?>
				<div id="BackNext" style="display:none">
                                    <a href="javascript: desligabloco2();" class="defaultButton multiLine nextButton">
                                        <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                        <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btNext'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep'];?>
</span>
                                    </a>
				</div>
				<?php }?>
				<a href="javascript: submitForm('<?php echo $_GET['m'];?>
', '<?php echo $_SESSION['lang'];?>
');"  class="defaultButton saveButton" >
					<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSaveRecord'];?>
" />
					<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSaveRecord'];?>
</strong></span>
				</a>

				<a href="javascript:cancelAction('?m=<?php echo $_smarty_tpl->tpl_vars['listRequest']->value;
if ($_smarty_tpl->tpl_vars['titleCode']->value) {?>&amp;title=<?php echo $_smarty_tpl->tpl_vars['titleCode']->value;
}
if ($_GET['searchExpr']) {?>&amp;searchExpr=<?php echo $_GET['searchExpr'];
}?>')" id="cancelButton" class="defaultButton cancelButton">
					<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" />
					<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
</strong></span>
				</a>
			<?php } else { ?>
				<?php if ($_GET['m']) {?>
					<?php if ($_smarty_tpl->tpl_vars['listRequestReport']->value != "report" && $_GET['m'] != "facic" && $_GET['m'] != "titleplus") {?>
						<!--a href="?m=<?php echo $_smarty_tpl->tpl_vars['listRequest']->value;
if ($_smarty_tpl->tpl_vars['titleCode']->value) {?>&amp;title=<?php echo $_smarty_tpl->tpl_vars['titleCode']->value;
}?>&amp;action=new" class="defaultButton multiLine newButton" <?php if ($_smarty_tpl->tpl_vars['titleCode']->value) {?> OnClick="javascript: desligabloco1();" <?php }?>-->
                                            <?php if ($_GET['m'] == "title") {?>
                                                <?php if ($_SESSION['role'] == "Administrator") {?>
                                                    <a href="?m=<?php echo $_smarty_tpl->tpl_vars['listRequest']->value;
if ($_smarty_tpl->tpl_vars['titleCode']->value) {?>&amp;title=<?php echo $_smarty_tpl->tpl_vars['titleCode']->value;
}?>&amp;action=new" id="show" class="defaultButton multiLine newButton">
                                                        <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                        <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>
 <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value[$_smarty_tpl->tpl_vars['listRequest']->value];?>
</span>
                                                    </a>
                                                <?php }?>

                                                <a href="javascript: fullExportMenu('menuRegisters'); " id="show" class="defaultButton multiLine exportTitleButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblExportTitle'];?>
</span>
                                                </a>
                                                
                                                <a href="javascript: fullExportMenu('menuCatalog'); " id="show" class="defaultButton multiLine exportCatalogButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblExportCatalog'];?>
</span>
                                                </a>

                                            <?php } else { ?>
                                                <a href="?m=<?php echo $_smarty_tpl->tpl_vars['listRequest']->value;
if ($_smarty_tpl->tpl_vars['titleCode']->value) {?>&amp;title=<?php echo $_smarty_tpl->tpl_vars['titleCode']->value;
}?>&amp;action=new" id="show" class="defaultButton multiLine newButton ">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>
 <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value[$_smarty_tpl->tpl_vars['listRequest']->value];?>
</span>
                                                </a>

                                            <?php }?>
					<?php } elseif ($_GET['m'] == "facic") {?>
						
						<a id="saveFacic" href="#"  class="defaultButton saveButton" >
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSaveRecord'];?>
" />
                                                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSaveRecord'];?>
</strong></span>
						</a>
						
						<a id="displayCollection" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblViewHldg'];?>
</span>
						</a>
						<a id="addRow" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>
</span>
						</a>
						
						<a id="addRows" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblInsertRange'];?>
</span>
						</a>

                                                <a href="javascript:cancelAction('?m=<?php if ($_GET['listRequest']) {
echo $_GET['listRequest'];
} else { ?>title<?php }
if ($_GET['searchExpr']) {?>&amp;searchExpr=<?php echo $_GET['searchExpr'];
}?>')" id="cancelButton" class="defaultButton cancelButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" />
                                                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
</strong></span>
                                                </a>

                                        <?php }?>
				<?php }?>
			<?php }?>
		<?php }?>
                
            <?php if ($_GET['action'] == "signin" || $_GET['m'] != '') {?>
            <?php if ($_GET['action'] != "delete") {?>
                <?php if ($_GET['m'] && $_GET['action']) {?>
                    <?php if ($_GET['m'] != "titleplus") {?>
                        <a href="?m=<?php echo $_GET['m'];?>
" class="defaultButton multiLine backButton">
                   <?php } else { ?>
                        <a href="?m=title" class="defaultButton multiLine backButton">
                   <?php }?>
                <?php } else { ?>
                    <?php if ($_GET['edit'] && $_GET['m'] != "preferences") {?>
                       <a href="?m=<?php echo $_GET['m'];
if ($_GET['searchExpr']) {?>&amp;searchExpr=<?php echo $_GET['searchExpr'];
}?>"  class="defaultButton multiLine backButton">
                    <?php } else { ?>
                        <?php if ($_GET['m'] != "facic") {?>
                            <a href="index.php" class="defaultButton multiLine backButton">
                        <?php } else { ?>
                           <a href="?m=<?php if ($_GET['listRequest']) {
echo $_GET['listRequest'];
} else { ?>title<?php }?>" class="defaultButton multiLine backButton">
                        <?php }?>
                    <?php }?>
                <?php }?>
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSaveRecord'];?>
" />
                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btBackAction'];?>
</strong></span>
                </a>
            <?php }?>
            <?php }?>


             <?php if ($_GET['m'] == '' && $_SESSION['optLibrary'][1] != '') {?>
             <div>
                <select name="role" id="role" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRole'];?>
" style="display:none;">
                     <?php if ($_SESSION['role'] == "Administrator") {?>
                        <option value="<?php echo $_SESSION['role'];?>
" selected="selected"><?php echo $_SESSION['role'];?>
</option>
                     <?php } else { ?>
                        <option value="" label="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
</option>
                        <?php echo smarty_function_html_options(array('values'=>$_SESSION['optRole'],'output'=>$_SESSION['optRole']),$_smarty_tpl);?>

                     <?php }?>
                </select>
                <select name="library" id="library" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLibrary'];?>
" class="textEntry" onchange="changeLib('<?php echo $_SESSION['lang'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['msgLibChange'];?>
');">
                    <option value="" label="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['optSelValue'];?>
</option>
                    <?php echo smarty_function_html_options(array('values'=>$_SESSION['optLibraryDir'],'output'=>$_SESSION['optLibrary']),$_smarty_tpl);?>

                </select>
            </div>
            <?php }?>


		</div>
    <?php }?>
	
	<div class="spacer">&#160;</div>

</div>
<?php }
}
