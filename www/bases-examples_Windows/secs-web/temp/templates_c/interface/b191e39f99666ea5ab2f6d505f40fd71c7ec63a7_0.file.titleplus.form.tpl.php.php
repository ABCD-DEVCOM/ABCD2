<?php
/* Smarty version 3.1.31, created on 2017-02-10 07:30:11
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\titleplus.form.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589d882398e925_58831929',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b191e39f99666ea5ab2f6d505f40fd71c7ec63a7' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\titleplus.form.tpl.php',
      1 => 1486042285,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589d882398e925_58831929 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\modifier.date_format.php';
if ($_SESSION['role'] != "Documentalista") {?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataRecord']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->_assignInScope(("titplus").($_smarty_tpl->tpl_vars['k']->value), $_smarty_tpl->tpl_vars['v']->value);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<div class="yui-skin-sam">

    <div id="helpDialog" >
        <div class="hd"><div id="helpTitle"></div></div>
        <div class="bd">
            <div id="helpBody"></div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
<?php $_smarty_tpl->_assignInScope('i', 0);
?>
var lblAcquisitionHistory = new Array();
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSubFieldsv913'], 'z');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['z']->value) {
?>
    lblAcquisitionHistory[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
] = new Array('<?php echo $_smarty_tpl->tpl_vars['z']->value;?>
');
    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_LOADING'];?>
</div></div>";
YAHOO.widget.DataTable.MSG_ERROR = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_ERROR'];?>
";
labelHelp = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblHelp'];?>
";
help913subfieldD = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionHistoryD'];?>
";
help913subfieldV = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionHistoryV'];?>
";
help913subfieldA = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionHistoryA'];?>
";
help913subfieldF = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionHistoryF'];?>
";
//alert(help913subfieldF);

YAHOO.namespace("example.container");
function init() {

        YAHOO.example.container.helpDialog = new YAHOO.widget.Dialog("helpDialog",
        { width : "50em",
            fixedcenter : true,
            visible : false,
            constraintoviewport : true
        });

        YAHOO.example.container.helpDialog.render();

        YAHOO.example.container.isbdDialog = new YAHOO.widget.Dialog("isbdDialog",
        { width : "50em",
            fixedcenter : false,
            visible : false,
            constraintoviewport : true
        });

        YAHOO.example.container.isbdDialog.render();
    }
    YAHOO.util.Event.onDOMReady(init);



    function successHandler(o){
        var t = o.responseText;

        if (t == "1"){
            alert(unescape(IDErrorMesage));
            var oForm = document.getElementById('formData');
            oForm.elements['field[recordIdentification]'].value = "";
        }

    }

    function failureHandler(o){
        alert("Async Request Failure");
    }

<?php echo '</script'; ?>
>
<form action="<?php echo $_SERVER['PHP_SELF'];?>
?m=<?php echo $_GET['m'];?>
&amp;title=<?php echo $_smarty_tpl->tpl_vars['titleCode']->value;?>
&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >	
    <?php if ($_GET['edit']) {?>
    <input type="hidden" name="mfn" value="<?php echo $_GET['edit'];?>
"/>
    <?php }?>
    <input type="hidden" name="gravar" id="gravar" value="false"/>
    <input type="hidden" name="record" id="record" value="false"/>
    <input type="hidden" name="field[titleCode]" value="<?php if ($_smarty_tpl->tpl_vars['titplus30']->value[0]) {
echo $_smarty_tpl->tpl_vars['titplus30']->value[0];
} else {
echo $_smarty_tpl->tpl_vars['titleCode']->value;
}?>"/>
    <input type="hidden" name="field[centerCode]" value="<?php echo $_SESSION['library'];?>
"/>
    <input type="hidden" name="field[titleName]" value="<?php echo $_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['pubTitle'];?>
"/>

    <input type="hidden" name="field[initialDate]" value="<?php echo $_GET['initialDate'];?>
"/>
    <input type="hidden" name="field[initialVolume]" value="<?php echo $_GET['initialVolume'];?>
"/>
    <input type="hidden" name="field[initialNumber]" value="<?php echo $_GET['initialNumber'];?>
"/>

    <div class="formHead">
        <?php if ($_SESSION['library']) {?>
        <div><?php echo $_SESSION['library'];?>
</div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['titplus30']->value || $_smarty_tpl->tpl_vars['titleCode']->value) {?>
        <div>ID=<?php if ($_smarty_tpl->tpl_vars['titleCode']->value) {
echo $_smarty_tpl->tpl_vars['titleCode']->value;
} else {
echo $_smarty_tpl->tpl_vars['titplus30']->value;
}?></div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['pubTitle']) {?>
        <div><?php echo $_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['pubTitle'];?>
.--</div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['ISSN']) {?>
        <div>ISSN: <?php echo $_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['ISSN'];?>
</div>
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['abrTitle']) {?>
        <div><?php echo $_smarty_tpl->tpl_vars['OBJECTS_TITLE']->value['abrTitle'];?>
</div>
        <?php }?>

        <div class="spacer">&#160;</div>
    </div>

    <div class="formContent">
        <div id="formRow08" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionMethod'];?>
</label>
            <div class="frDataFields">
              
                <select name="field[acquisitionMethod]" id="acquisitionMethod" class="textEntry superTextEntry" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionMethod'];?>
">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionMethod'],'selected'=>$_smarty_tpl->tpl_vars['titplus901']->value[0]),$_smarty_tpl);?>

                </select>
                <span id="formRow08_help">
                    <a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow08_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [901] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionMethod'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionMethod'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow01" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionControl'];?>
</label>
            <div class="frDataFields">
                <select name="field[acquisitionControl]" id="acquisitionControl" class="textEntry superTextEntry" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionControl'];?>
">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionControl'],'selected'=>$_smarty_tpl->tpl_vars['titplus902']->value[0]),$_smarty_tpl);?>

                </select>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow01_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [902] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionControl'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionControl'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow10" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblExpirationSubs'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="field[expirationSubs]" id="expirationSubs" value="<?php echo $_smarty_tpl->tpl_vars['titplus906']->value[0];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblExpirationSubs'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                <div class="yui-skin-sam"><div id="datefields" style="display: none;"></div></div>
                <a id="#calend" href="#" onclick="calendarButton('expirationSubs'); showHideDiv('datefields');" >
                    <img src="public/images/common/calbtn.gif" title="calend" alt="calend" />
                </a>
                <span id="formRow10_help">
                    <a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow10_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [906] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblExpirationSubs'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperExpirationSubs'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow16" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionPriority'];?>
</label>
            <div class="frDataFields">
              
                <select name="field[acquisitionPriority]" id="acquisitionPriority" class="textEntry superTextEntry" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionPriority'];?>
">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAcquisitionPriority'],'selected'=>$_smarty_tpl->tpl_vars['titplus946']->value[0]),$_smarty_tpl);?>

                </select>
                <span id="formRow16_help">
                    <a href="javascript:showHideDiv('formRow16_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow16_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow16_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [946] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionPriority'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperacquisitionPriority'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow15" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAdmNotes'];?>
</label>
            <div class="frDataFields">
                <textarea name="field[admNotes]" cols="80" rows="3" id="admNotes" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAdmNotes'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow15').className = 'formRow';" ><?php echo $_smarty_tpl->tpl_vars['titplus911']->value[0];?>
</textarea>
                <span id="formRow15_help">
                    <a href="javascript:showHideDiv('formRow15_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow15_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow15_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [911] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAdmNotes'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAdmNotes'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
    </div>

    <div class="formHead">
        <div id="formRow913" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionHistory'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="field[acquisitionHistory]" value="<?php echo $_smarty_tpl->tpl_vars['titplus913']->value[0];?>
" id="acquisitionHistory" title="valor" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow913').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow913').className = 'formRow';" />
                <span id="formRow913_help">
                    <a href="javascript:showHideDiv('formRow913_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow913_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow913_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [913] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblAcquisitionHistory'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperAcquisitionHistory'];?>
</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('acquisitionHistory','superTextEntry2','<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" title="spacer" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
"/>
                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
                <a href="javascript:insertSubField913(this, 'acquisitionHistory', '^x', '<?php echo $_SESSION['lang'];?>
', lblAcquisitionHistory);"
                   class="singleButton addSubField">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
                <!-->começo da parte de inserir linha<-->
                <?php
$__section_iten_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['titplus450']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_0_total = $__section_iten_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_0_total != 0) {
for ($__section_iten_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_0_iteration <= $__section_iten_0_total; $__section_iten_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsacquisitionHistory<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[acquisitionHistory][]" id="acquisitionHistory<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" value="<?php echo $_smarty_tpl->tpl_vars['titplus913']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsacquisitionHistory<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" title="spacer" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }} else {
 ?>
                <?php if ($_smarty_tpl->tpl_vars['titplus913']->value) {?>
                <div id="frDataFieldsacquisitionHistory" class="frDataFields">
                    <input type="text" name="field[acquisitionHistory][]" id="acquisitionHistory" value="<?php echo $_smarty_tpl->tpl_vars['titplus913']->value[0];?>
" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsacquisitionHistory');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" title="spacer" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
"/>
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }?>
                <?php
}
if ($__section_iten_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_0_saved;
}
?>
                <!-->fim da parte de inserir linha<-->
            </div>
            <div id="frDataFieldsacquisitionHistory" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>
        <div id="formRow09" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProvider'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="field[provider]" id="provider" value="<?php echo $_smarty_tpl->tpl_vars['titplus905']->value[0];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProvider'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow09').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow09').className = 'formRow';" />
                <span id="formRow09_help">
                    <a href="javascript:showHideDiv('formRow09_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow09_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow09_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [905] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProvider'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperProvider'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow02" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProviderNotes'];?>
</label>
            <div class="frDataFields">
                <textarea name="field[providerNotes]" cols="80" rows="3" id="providerNotes" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProviderNotes'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';"><?php echo $_smarty_tpl->tpl_vars['titplus904']->value[0];?>
</textarea>
                <span id="formRow02_help">
                    <a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow02_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [904] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblProviderNotes'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperProviderNotes'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblReceivedExchange'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="field[receivedExchange]" id="receivedExchange" value="<?php echo $_smarty_tpl->tpl_vars['titplus903']->value[0];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblReceivedExchange'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                <span id="formRow03_help">
                    <a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow03_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [903] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblReceivedExchange'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperReceivedExchange'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow17" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblDonorNotes'];?>
</label>
            <div class="frDataFields">
                <textarea name="field[donorNotes]" cols="80" rows="3" id="donorNotes" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblDonorNotes'];?>
" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow17').className = 'formRow';" ><?php echo $_smarty_tpl->tpl_vars['titplus912']->value[0];?>
</textarea>
                <span id="formRow17_help">
                    <a href="javascript:showHideDiv('formRow17_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" /></a>
                </span>
                <div class="helpBG" id="formRow17_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow17_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" /></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [912] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblDonorNotes'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperDonorNotes'];?>
</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

    </div>

    <div class="formContent">

        <div id="formRow11" class="formRow">
            <label for="locationRoom"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="locationRoom" id="locationRoom" value="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
" class="textEntry superTextEntry" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow11_help">
                    <a href="javascript:showHideDiv('formRow11_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <div class="helpBG" id="formRow11_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow11_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [907] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperLocationRoom'];?>
</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('locationRoom', 'superTextEntry2', '<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php
$__section_iten_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['titplus907']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_1_total = $__section_iten_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_1_total != 0) {
for ($__section_iten_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_1_iteration <= $__section_iten_1_total; $__section_iten_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
            <div id="frDataFieldslocationRoom<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                <input type="text" name="field[locationRoom][]" id="locationRoom" value="<?php echo $_smarty_tpl->tpl_vars['titplus907']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow11').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldslocationRoom<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }} else {
 ?>
            <?php if ($_smarty_tpl->tpl_vars['titplus907']->value) {?>
            <div id="frDataFieldslocationRoomp" class="frDataFields">
                <input type="text" name="field[locationRoom][]" id="locationRoom" value="<?php echo $_smarty_tpl->tpl_vars['titplus907']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblLocationRoom'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow11').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldslocationRoomp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }?>
            <?php
}
if ($__section_iten_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_1_saved;
}
?>
            <div id="frDataFieldslocationRoom" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>


        <div id="formRow12" class="formRow">
            <label for="estMap"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="estMap" id="estMap" value="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
" class="textEntry superTextEntry" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow12').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow12_help">
                    <a href="javascript:showHideDiv('formRow12_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <div class="helpBG" id="formRow12_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow12_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [908] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperEstMap'];?>
</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('estMap', 'superTextEntry2', '<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php
$__section_iten_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['titplus908']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_2_total = $__section_iten_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_2_total != 0) {
for ($__section_iten_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_2_iteration <= $__section_iten_2_total; $__section_iten_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
            <div id="frDataFieldsEstMap<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                <input type="text" name="field[estMap][]" id="estMap" value="<?php echo $_smarty_tpl->tpl_vars['titplus908']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow12').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsEstMap<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }} else {
 ?>
            <?php if ($_smarty_tpl->tpl_vars['titplus908']->value) {?>
            <div id="frDataFieldsestMapp" class="frDataFields">
                <input type="text" name="field[estMap][]" id="estMap" value="<?php echo $_smarty_tpl->tpl_vars['titplus908']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblEstMap'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow12').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsestMapp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }?>
            <?php
}
if ($__section_iten_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_2_saved;
}
?>
            <div id="frDataFieldsestMap" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow13" class="formRow">
            <label for="ownClassif"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="ownClassif" id="ownClassif" value="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
" class="textEntry superTextEntry" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow13_help">
                    <a href="javascript:showHideDiv('formRow13_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <div class="helpBG" id="formRow13_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow13_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [909] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperOwnClassif'];?>
</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('ownClassif', 'superTextEntry2', '<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php
$__section_iten_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['titplus909']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_3_total = $__section_iten_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_3_total != 0) {
for ($__section_iten_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_3_iteration <= $__section_iten_3_total; $__section_iten_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
            <div id="frDataFieldsOwnClassif<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                <input type="text" name="field[ownClassif][]" id="ownClassif" value="<?php echo $_smarty_tpl->tpl_vars['titplus909']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow13').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnClassif<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }} else {
 ?>
            <?php if ($_smarty_tpl->tpl_vars['titplus909']->value) {?>
            <div id="frDataFieldsownClassifp" class="frDataFields">
                <input type="text" name="field[ownClassif][]" id="ownClassif" value="<?php echo $_smarty_tpl->tpl_vars['titplus909']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnClassif'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow13').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnClassifp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }?>
            <?php
}
if ($__section_iten_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_3_saved;
}
?>
            <div id="frDataFieldsownClassif" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow14" class="formRow">
            <label for="ownDesc"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
</label>
            <div class="frDataFields">
                <input type="text" name="ownDesc" id="ownDesc" value="" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
" class="textEntry superTextEntry" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow14').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow14_help">
                    <a href="javascript:showHideDiv('formRow14_helpA')"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                </span>
                <div class="helpBG" id="formRow14_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow14_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
"><img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"></a></span>
                        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [910] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
</h2>
                        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperOwnDesc'];?>
</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('ownDesc', 'superTextEntry2', '<?php echo $_SESSION['lang'];?>
');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                    <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php
$__section_iten_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['titplus910']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_4_total = $__section_iten_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_4_total != 0) {
for ($__section_iten_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_4_iteration <= $__section_iten_4_total; $__section_iten_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
            <div id="frDataFieldsOwnDesc<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                <input type="text" name="field[ownDesc][]" id="ownDesc" value="<?php echo $_smarty_tpl->tpl_vars['titplus910']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow14').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnDesc<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }} else {
 ?>
            <?php if ($_smarty_tpl->tpl_vars['titplus910']->value) {?>
            <div id="frDataFieldsownDescp" class="frDataFields">
                <input type="text" name="field[ownDesc][]" id="ownDesc" value="<?php echo $_smarty_tpl->tpl_vars['titplus910']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblOwnDesc'];?>
" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow14').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnDescp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            <?php }?>
            <?php
}
if ($__section_iten_4_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_4_saved;
}
?>
            <div id="frDataFieldsownDesc" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>
    </div>

    <div class="formHead">
        <div id="formRow03" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblCreatDate'];?>
</label>
            <div class="frDataFields">
                <?php if ($_smarty_tpl->tpl_vars['titplus940']->value[0]) {
echo $_smarty_tpl->tpl_vars['titplus940']->value[0];
} else {
echo smarty_modifier_date_format(time(),"%Y%m%d");
}?>
                <input type="hidden" name="field[creatDate]" value='<?php if ($_smarty_tpl->tpl_vars['titplus940']->value[0]) {
echo $_smarty_tpl->tpl_vars['titplus940']->value[0];
} else {
echo smarty_modifier_date_format(time(),"%Y%m%d");
}?>' class="textEntry superTextEntry"/>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblModifDate'];?>
</label>
            <div class="frDataFields">
                <?php echo smarty_modifier_date_format(time(),"%Y%m%d");?>

                <input type="hidden" name="field[modifDate]" value='<?php echo smarty_modifier_date_format(time(),"%Y%m%d");?>
' class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblDataEntryCreat'];?>
</label>
            <div class="frDataFields">
                <?php if ($_smarty_tpl->tpl_vars['titplus950']->value[0]) {
echo $_smarty_tpl->tpl_vars['titplus950']->value[0];
} else {
echo $_SESSION['logged'];
}?>
                <input type="hidden" name="field[dataEntryCreat]" value='<?php if ($_smarty_tpl->tpl_vars['titplus950']->value[0]) {
echo $_smarty_tpl->tpl_vars['titplus950']->value[0];
} else {
echo $_SESSION['logged'];
}?>' class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblDataEntryMod'];?>
</label>
            <div class="frDataFields">
                <?php echo $_SESSION['logged'];?>

                <input type="hidden" name="field[dataEntryMod]" value="<?php echo $_SESSION['logged'];?>
" class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

    </div>
</form>

<div class="formFoot">
    <div class="helper">
		<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpGeneralTitlePlus'];?>

    </div>
    <div class="spacer">&#160;</div>
</div>
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
