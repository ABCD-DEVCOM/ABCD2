<?php
/* Smarty version 3.1.31, created on 2017-02-10 07:21:20
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\search.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589d86109b4156_69532884',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d2031effb01ea9c6f52b86ac47d913e07056c3f' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\search.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589d86109b4156_69532884 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
?>
<div class="searchBox">

    <?php if ($_GET['m'] != "facic") {?>
		
		<?php if ($_GET['m'] == 'mask') {?>
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="<?php if ($_GET['m']) {
echo $_GET['m'];
}?>"/>
                <label for="searchExpr"><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleSearch'];?>
</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="<?php if ($_smarty_tpl->tpl_vars['searcExpr']->value) {
echo $_smarty_tpl->tpl_vars['searcExpr']->value;
} else { ?>$<?php }?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesMask']),$_smarty_tpl);?>

                </select>
                <input type="button" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSearch'];?>
" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <span class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperSearch'];?>
</span>
            </form>
        
		<?php } elseif ($_GET['m'] == 'title') {?>
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="<?php if ($_GET['m']) {
echo $_GET['m'];
}?>"/>
                <label for="searchExpr"><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleSearch'];?>
</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="<?php if ($_smarty_tpl->tpl_vars['searcExpr']->value) {
echo $_smarty_tpl->tpl_vars['searcExpr']->value;
} else { ?>$<?php }?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesTitle']),$_smarty_tpl);?>

                </select>
                <input type="button" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSearch'];?>
" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <span class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperSearch'];?>
</span>
            </form>

		<?php } elseif ($_GET['m'] == 'users') {?>
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="<?php if ($_GET['m']) {
echo $_GET['m'];
}?>"/>
                <label for="searchExpr"><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleSearch'];?>
</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="<?php if ($_smarty_tpl->tpl_vars['searcExpr']->value) {
echo $_smarty_tpl->tpl_vars['searcExpr']->value;
} else { ?>$<?php }?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesUsers']),$_smarty_tpl);?>

                </select>
                <input type="button" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSearch'];?>
" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <span class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperSearch'];?>
</span>
            </form>

		<?php } elseif ($_GET['m'] == 'titleplus') {?>
             <form action="?" class="form" id="searchTitlePlusForm" method="get">
                <input type="hidden" name="m" value="<?php if ($_GET['m']) {
echo $_GET['m'];
}?>"/>
                <label><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleSearch'];?>
</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="<?php if ($_smarty_tpl->tpl_vars['searcExpr']->value) {
echo $_smarty_tpl->tpl_vars['searcExpr']->value;
} else { ?>$<?php }?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

                <select id="AcquisitionMethod" style="display:none;" class="textEntry">
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optValAcq'],'output'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionMethod']),$_smarty_tpl);?>

                </select>
                <select id="AcquisitionControl" style="display:none;" class="textEntry">
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optValAcq'],'output'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionControl']),$_smarty_tpl);?>

                </select>
                <select id="AcquisitionPriority" style="display:none;" class="textEntry">
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optValAcq2'],'output'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionPriority']),$_smarty_tpl);?>

                </select>
                <select name="indexes" id="indexes" class="textEntry" onchange="checkSelection('2');">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesTitlePlus']),$_smarty_tpl);?>

                </select>
                <input type="button" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSearch'];?>
" class="submit" onclick="changeVal('searchExpr'); doit('searchTitlePlusForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <span class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperSearch'];?>
</span>
            </form>


		<?php } elseif ($_GET['m'] == 'library') {?>
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="<?php if ($_GET['m']) {
echo $_GET['m'];
}?>"/>
                <label for="searchExpr"><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titleSearch'];?>
</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="<?php if ($_smarty_tpl->tpl_vars['searcExpr']->value) {
echo $_smarty_tpl->tpl_vars['searcExpr']->value;
} else { ?>$<?php }?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesLibrary']),$_smarty_tpl);?>

                </select>
                <input type="button" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSearch'];?>
" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <span class="helper"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperSearch'];?>
</span>
            </form>
		<?php }?>
        
    <?php }?>

</div><?php }
}
