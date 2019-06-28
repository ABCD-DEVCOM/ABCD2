<?php
/* Smarty version 3.1.31, created on 2017-02-10 07:21:13
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\homepage.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589d8609ea8820_83669534',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5e7d76ee3e9695c78adfbe79d11e9ee9bfb16ed' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\homepage.tpl.php',
      1 => 1462971526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589d8609ea8820_83669534 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
echo '<script'; ?>
 type="text/javascript">
<?php $_smarty_tpl->_assignInScope('i', 0);
?>
    var optControlAccess = new Array();
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['optControlAccess'], 'y', false, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value => $_smarty_tpl->tpl_vars['y']->value) {
?>
    optControlAccess[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
] = new Array('<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['y']->value;?>
');
    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<?php echo '</script'; ?>
>

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>

        <div class="boxContent titleSection">
            <div class="sectionIcon">&#160;</div>
            <div class="sectionTitle">
                <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblManagerOf'];?>
<strong>
                    <?php if ($_SESSION['role'] == "Administrator") {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitleFacic'];
}?>
                    <?php if ($_SESSION['role'] == "EditorOnly" || $_SESSION['role'] == "AdministratorOnly" || $_SESSION['role'] == "Editor") {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitle'];
}?>
                    <?php if ($_SESSION['role'] == "Operator") {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitlePlusFacic'];
}?>
                </strong></h4>
                <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTotalOf'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['totalTitleRecords']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitleRegister'];?>
</span>
            </div>
            <div class="sectionButtons">
                <div class="searchTitles">
                    <form id="searchTitlesForm" action="<?php echo $_SERVER['PHP_SELF'];?>
?m=title" method="post">
                        <div class="stInput">
                            <label for="searchExpr"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTypeTitle'];?>
</label>
                            <input type="text" name="searchExpr" id="searchExpr" value="" class="textEntry" />
                            <select name="indexes" class="textEntry">
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesTitle']),$_smarty_tpl);?>

                            </select>
				<span id="formRow01_help">
                                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
				</span>
                        </div>
                        <a href="javascript:void(0);" class="defaultButton searchButton" onclick="doit('searchTitlesForm');">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['install_dir'];?>
/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                            <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSearch'];?>
 </strong></span>
                        </a>
                    </form>
                </div>
                <a href="?m=title" class="defaultButton multiLine listButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblList'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitle'];?>
</span>
                </a>
                <?php if ($_SESSION['role'] == "Administrator") {?>
                <a href="?m=title&amp;action=new" class="defaultButton multiLine newButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblNew'];?>
</strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitle'];?>
</span>
                </a>
                <?php }?>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div class="boxBottom">
            <div class="bbLeft">&#160;</div>
            <div class="bbRight">&#160;</div>
        </div>
	</div>
	
	<?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Editor" || $_SESSION['role'] == "EditorOnly") {?>
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>
        <div class="boxContent titlePlusSection">
            <div class="sectionIcon">&#160;</div>
            <div class="sectionTitle">
                <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblManagerOf'];?>
<strong><?php if ($_SESSION['role'] == "Editor") {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitlePlusFacic'];
} else {
echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitlePlusFacic'];
}?></strong></h4>
                <span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTotalOf'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['totalTitlePlusRecords']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitleRegister'];?>
</span>
            </div>
            <div class="sectionButtons">
                 <div class="searchTitles">
                        <div class="stInput">
                            <label for="searchExpr"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTypeTitle'];?>
</label>
                            <input type="text" id="freeText" name="freeText" style="display:block;" class="textEntry" />
                            <select id="AcquisitionMethod" style="display:none;" class="textEntry superTextEntry">
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionMethod']),$_smarty_tpl);?>

                            </select>
                            <select id="AcquisitionControl" style="display:none;" class="textEntry superTextEntry">
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionControl']),$_smarty_tpl);?>

                            </select>
                            <select id="AcquisitionPriority" style="display:none;" class="textEntry superTextEntry">
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionPriority']),$_smarty_tpl);?>

                            </select>
                            <form id="searchTitlePlusForm" action="<?php echo $_SERVER['PHP_SELF'];?>
?" method="get">
                                <input type="hidden" name="m" id="m" value="titleplus" class="textEntry" />
                                <input type="hidden" name="searchExpr" id="searchExpr" value="" class="textEntry" />
                                <select name="indexes" id="indexes" class="textEntry" onchange="checkSelection();">
                                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexesTitlePlus']),$_smarty_tpl);?>

                                </select>
				<span id="formRow02_help">
                                    <a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
				</span>

                            </form>
                        </div>
                        <a href="javascript:void(0);" class="defaultButton searchButton" onclick="changeVal('freeText'); doit('searchTitlePlusForm');">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['BVS_CONF']->value['install_dir'];?>
/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                            <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSearch'];?>
</strong></span>
                        </a>
                     
                </div>
                <a href="?m=titleplus" class="defaultButton multiLine listButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblList'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titlePlus'];?>
 </span>
                </a>
                <!--a href="?m=title&amp;titleplus=new" class="defaultButton multiLine newButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblNew2'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['titlePlus'];?>
 </span>
                </a-->
            </div>
            <div class="spacer">&#160;</div>
            </div>
            
            <div class="boxBottom">
                <div class="bbLeft">&#160;</div>
                <div class="bbRight">&#160;</div>
            </div>
    </div>
	<?php }?>

	<?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "AdministratorOnly") {?>
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>

	<div class="boxContent maskSection">
		<div class="sectionIcon">
			&#160;
		</div>
		<div class="sectionTitle">
			<h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblManagerOf'];?>
 <strong>  <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblMasks'];?>
 </strong></h4>
			<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTotalOf'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['totalMaskRecords']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblMasks2'];?>
  </span>
		</div>
		<div class="sectionButtons">
			<a href="?m=mask" class="defaultButton listButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblList'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblMasks'];?>
</span>
			</a>
			<a href="?m=mask&amp;action=new" class="defaultButton multiLine newButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblNew2'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblMask'];?>
</span>
			</a>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
	</div>
	<?php }?>
	
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	
	<div class="boxContent toolSection">
		<div class="sectionIcon">&#160;</div>
		<div class="sectionTitle">
			<h4>&#160;<strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblUtility'];?>
</strong></h4>
		</div>
		
			<div class="sectionButtons">
			<?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "AdministratorOnly") {?>
			<a href="?m=users" class="defaultButton multiLine userButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAdmUsers'];?>
</span>
			</a>
			<a href="?m=library" class="defaultButton multiLine libraryButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAdmLibrary'];?>
</span>
			</a>
            <!--a href="javascript: EmDesenvolvimento('<?php echo $_SESSION['lang'];?>
');" class="defaultButton multiLine importButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span><strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblImport'];?>
</strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTitle2'];?>
</span>
			</a-->
			<?php }?>
			<a href="?m=report" class="defaultButton multiLine reportButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblServReport'];?>
</span>
			</a>
			<a href="?m=maintenance" class="defaultButton multiLine databaseMaintenceButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblServMaintance'];?>
</span>
			</a>
		</div>
		
		<div class="spacer">&#160;</div>
	</div>

	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
	</div>

	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	<div class="boxContent helpSection">
		<div class="sectionIcon">
			&#160;
		</div>
		<div class="sectionTitle">
			<h4>&#160;<strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblHelp'];?>
</strong></h4>
		</div>
		<div class="sectionButtons">
			<a href="javascript: showMessage('<?php echo $_SESSION['lang'];?>
');" class="defaultButton multiLine pdfButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblRead'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblManual'];?>
</strong></span>
			</a>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
            
        <div class="helpBG" id="formRow01_helpA" style="display: none;">
            <div class="helpArea">
                    <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                    <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['field'];?>
 <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSearchTitle'];?>
</h2>
                    <div class="help_message">
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpSearchTitle'];?>

                    </div>
            </div>
        </div>
        <div class="helpBG" id="formRow02_helpA" style="display: none;">
            <div class="helpArea">
                    <span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                    <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['field'];?>
 <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSearchTitlePlus'];?>
</h2>
                    <div class="help_message">
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpSearchTitlePlus'];?>

                    </div>
            </div>
        </div>
</div><?php }
}
