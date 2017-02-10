<?php
/* Smarty version 3.1.31, created on 2017-02-10 07:29:40
  from "C:\ABCD\www\htdocs\secs-web\public\templates\interface\title.form.tpl.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_589d88042c7e03_62762552',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '662cec3a3ee3987008db153fb19512157a8c5396' => 
    array (
      0 => 'C:\\ABCD\\www\\htdocs\\secs-web\\public\\templates\\interface\\title.form.tpl.php',
      1 => 1486003208,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589d88042c7e03_62762552 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_html_options')) require_once 'C:\\ABCD\\www\\htdocs\\secs-web\\common\\plugins\\smarty\\libs\\plugins\\function.html_options.php';
if ($_SESSION['role'] == "Administrator") {
$_smarty_tpl->_assignInScope('i', 0);
echo '<script'; ?>
 type="text/javascript">
    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    var optAgregators = new Array();
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['optAgregators'], 'z', false, 'x');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['x']->value => $_smarty_tpl->tpl_vars['z']->value) {
?>
    optAgregators[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
] = new Array('<?php echo $_smarty_tpl->tpl_vars['x']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['z']->value;?>
');
    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    var optAccessType = new Array();
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['optAccessType'], 'y', false, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value => $_smarty_tpl->tpl_vars['y']->value) {
?>
    optAccessType[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
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


    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    var optIndexingCoverage = new Array();
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['optIndexingCoverage'], 'z', false, 'x');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['x']->value => $_smarty_tpl->tpl_vars['z']->value) {
?>
    optIndexingCoverage[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
] = new Array('<?php echo $_smarty_tpl->tpl_vars['x']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['z']->value;?>
');
    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    var lblIndexingCoverage = new Array();
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblSubFieldsv450'], 'z');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['z']->value) {
?>
    lblIndexingCoverage[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
] = new Array('<?php echo $_smarty_tpl->tpl_vars['z']->value;?>
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

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataRecord']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->_assignInScope(("title").($_smarty_tpl->tpl_vars['k']->value), $_smarty_tpl->tpl_vars['v']->value);
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

    <div id="isbdDialog" >
        <div class="hd"><div id="isbdTitle"></div></div>
        <div class="bd">
            <div id="isbdBody"></div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">

    YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_LOADING'];?>
</div></div>";
    YAHOO.widget.DataTable.MSG_ERROR = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['MSG_ERROR'];?>
";
    labelHelp = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblHelp'];?>
";
    helpISBD = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpISBD'];?>
";
    help999subfieldA = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldA'];?>
"
    help999subfieldB = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldB'];?>
"
    help999subfieldC = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldC'];?>
"
    help999subfieldD = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldD'];?>
"
    help999subfieldE = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldsEF'];?>
"
    help999subfieldG = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldG'];?>
"

    help450subfieldA = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageA'];?>
"
    help450subfieldB = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageB'];?>
"
    help450subfieldC = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageC'];?>
"
    help450subfieldD = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageD'];?>
"
    help450subfieldE = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageE'];?>
"
    help450subfieldF = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverageF'];?>
"
    IDErrorMesage = "<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['IDErrorMesage'];?>
"

    
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

    function verifyID(){

        var oForm = document.getElementById('formData');
        var ID = oForm.elements['field[recordIdentification]'].value;
        //var entryPoint = 'common/plugins/asyncSearch.php';
        var entryPoint = './index.php'
        var queryString = encodeURI('?m=title&type=async&searchExpr=' + ID + '&indexes=I');
        var sUrl = entryPoint + queryString;

        var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, { success:successHandler, failure:failureHandler });
    }
    
<?php echo '</script'; ?>
>

<div class="formFoot">
    <div class="pagination">
        <a href="javascript: desligabloco1();" id="bloco1" class="singleButton selectedBlock" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep1'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco2();" id="bloco2" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep2'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco3();" id="bloco3" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep3'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco4();" id="bloco4" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep4'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco5();" id="bloco5" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep5'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco6();" id="bloco6" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep6'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco7();" id="bloco7" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep7'];?>
  <span class="sb_rb">&#160;</span>
        </a>
    </div>
    <div class="spacer">&#160;</div>
    <div class="spacer">&#160;</div>
</div>
<form id="formData" class="form" action="<?php echo $_SERVER['PHP_SELF'];?>
?m=<?php echo $_GET['m'];?>
&edit=validation" enctype="multipart/form-data" name="formData" method="POST">
    <!--
    <form id="formData" class="form" action="<?php echo $_SERVER['PHP_SELF'];?>
?m=<?php echo $_GET['m'];?>
&edit=save" enctype="multipart/form-data" name="formData" method="POST">
    -->
		<?php if ($_GET['edit']) {?>
    <input type="hidden" name="mfn" value="<?php echo $_GET['edit'];?>
"/>
		<?php }?>
<!--                <input type="hidden" name="previousStep" id="previousStep" value="<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btPrevious'];?>
</strong></span>"/>
    <input type="hidden" name="nextStep" id="nextStep" value="<span><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btNext'];?>
 <strong><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep'];?>
</strong></span>"/>
    -->		<input type="hidden" name="gravar" id="gravar" value="false"/>
    <input type="hidden" name="field[dataBase]" value="TITLE"/>
    <input type="hidden" name="field[literatureType]" value="S"/>
    <input type="hidden" name="field[treatmentLevel]" value="s"/>
    <input type="hidden" name="field[centerCode]" value="main"/>
    <input type="hidden" name="field[creationDate]" value="<?php echo smarty_modifier_date_format(time(),"%Y%m%d");?>
"/>
		<?php if ($_smarty_tpl->tpl_vars['edit']->value) {?>
           <input type="hidden" name="field[changeDate]" value="<?php echo smarty_modifier_date_format(time(),"%Y%m%d");?>
"/>
           <input type="hidden" name="field[changeDocumentalist]" value="BIREME"/>
		<?php }?>
    <input type="hidden" name="field[creationDocumentalist]" value="BIREME"/>

    <div  id="bloco_1" style="width:100%; position:relative; display: block">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep1'];?>
 - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
            <div id="formRow01" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblrecordIdentification'];?>
</label>
                <div class="frDataFields">
                    <label style="font-weight: bold; font-size: 12pt"><?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
 &#160; </label>
                    <input type="hidden" name="field[recordIdentification]" id="recordIdentification" value="<?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
"/> 
                    <div id="recordIdentificationError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow01_help">
                        <a href="javascript:showHelp('30', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblrecordIdentification'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperrecordIdentification'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow02" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationTitle'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[publicationTitle]"
                           id="publicationTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
"
                           title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationTitle'];?>
"
                           class="textEntry singleTextEntry inputAlert"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry inputAlert';document.getElementById('formRow02').className = 'formRow';" />
                    <div id="publicationTitleError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow02_help">
                        <a href="javascript:showHelp('100', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationTitle'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperpublicationTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>

	<div class="formContent">
		<div id="formRow03" class="formRow">
			<label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnameOfIssuingBody'];?>
</label>
                                <div class="frDataFields">
                                    <input type="text"
                                           name="field[nameOfIssuingBody][]"
                                           id="nameOfIssuingBody" value=""
                                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnameOfIssuingBody'];?>
"
                                           class="textEntry singleTextEntry"
                                           title="Teste"
                                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                                    <div id="categoryError" style="display: none;" class="inlineError">Defina um nome para a mï¿½dia.</div>
                                    <span id="formRow03_help">
                                        <a href="javascript:showHelp('140','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnameOfIssuingBody'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpernameOfIssuingBody'];?>
');">
                                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                                    </span>
                                    <a href="javascript:InsertLineOriginal('nameOfIssuingBody', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                                       class="singleButton okButton"
                                       id="nameOfIssuingBody">
                                        <span class="sb_lb">&#160;</span>
                                        <img alt="" src="public/images/common/spacer.gif" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                                        <span class="sb_rb">&#160;</span>
                                    </a>
                                </div>
				<?php
$__section_iten_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title140']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_0_total = $__section_iten_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_0_total != 0) {
for ($__section_iten_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_0_iteration <= $__section_iten_0_total; $__section_iten_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsnameOfIssuingBody<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text"
                           name="field[nameOfIssuingBody][]"
                           id="nameOfIssuingBody"
                           value="<?php echo $_smarty_tpl->tpl_vars['title140']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnameOfIssuingBody'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsnameOfIssuingBody<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
                <?php if ($_smarty_tpl->tpl_vars['title140']->value) {?>
                <div id="frDataFieldsnameOfIssuingBodyp" class="frDataFields">
                    <input type="text" 
                           name="field[nameOfIssuingBody][]" id="nameOfIssuingBody"
                           value="<?php echo $_smarty_tpl->tpl_vars['title140']->value;?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnameOfIssuingBody'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsnameOfIssuingBodyp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" /><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

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
                <div id="frDataFieldsnameOfIssuingBody" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow66" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblkeyTitle'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[keyTitle]"
                           id="keyTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title149']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow66').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow66').className = 'formRow';" />
                    <span id="formRow66_help">
                        <a href="javascript:showHelp('149', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblkeyTitle'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperkeyTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow04" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitle'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[abbreviatedTitle]"
                           id="abbreviatedTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title150']->value[0];?>
"
                           title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitle'];?>
"
                           class="textEntry singleTextEntry inputAlert"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry inputAlert';document.getElementById('formRow04').className = 'formRow';" />
                    <div id="abbreviatedTitleError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow04_help">
                        <a href="javascript:showHelp('150','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitle'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperabbreviatedTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow69" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitleMedline'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[abbreviatedTitleMedline][]"
                           id="abbreviatedTitleMedline"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitleMedline'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <span id="formRow69_help">
                        <a href="javascript:showHelp('180','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitleMedline'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperabbreviatedTitleMedline'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('abbreviatedTitleMedline', 'textEntry singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="abbreviatedTitleMedline">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'abbreviatedTitleMedline', 'textEntry singleTextEntry', '180', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblField180subfield'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblField180subfiela'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <?php
$__section_iten_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title180']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_1_total = $__section_iten_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_1_total != 0) {
for ($__section_iten_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_1_iteration <= $__section_iten_1_total; $__section_iten_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                    <div id="frDataFieldsabbreviatedTitleMedline<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
">
                        <input type="text"
                               name="field[abbreviatedTitleMedline][]"
                               id="abbreviatedTitleMedline"
                               value="<?php echo $_smarty_tpl->tpl_vars['title180']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                               title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitleMedline'];?>
"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsabbreviatedTitleMedline<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title180']->value[0]) {?>
                    <div id="frDataFieldsabbreviatedTitleMedlinep" class="frDataFields">
                        <input type="text"
                               name="field[abbreviatedTitleMedline][]"
                               id="abbreviatedTitleMedline"
                               value="<?php echo $_smarty_tpl->tpl_vars['title180']->value[0];?>
"
                               title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblabbreviatedTitleMedline'];?>
"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsabbreviatedTitleMedlinep');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

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
                    <div id="frDataFieldsabbreviatedTitleMedline" style="display:block!important">&#160;</div>
                    <div class="spacer">&#160;</div>
                </div>
                <div class="spacer">&#160;</div>
            </div>

        </div>
    </div>
    <div  id="bloco_2" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep2'];?>
  - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
            <div id="formRow05" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsubtitle'];?>
 </label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[subtitle]"
                           id="subtitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title110']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow05').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow05').className = 'formRow';" />
                    <span id="formRow05_help">
                        <a href="javascript:showHelp('110','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsubtitle'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpersubtitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow06" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsectionPart'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[sectionPart]"
                           id="sectionPart"
                           value="<?php echo $_smarty_tpl->tpl_vars['title120']->value[0];?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow06').className = 'formRow';" />
                    <span id="formRow06_help">
                        <a href="javascript:showHelp('120','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsectionPart'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpersectionPart'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow07" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleOfSectionPart'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[titleOfSectionPart]"
                           id="titleOfSectionPart"
                           value="<?php echo $_smarty_tpl->tpl_vars['title130']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow07').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow07').className = 'formRow';" />
                    <span id="formRow07_help" >
                        <a href="javascript:showHelp('130','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleOfSectionPart'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleOfSectionPart'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow08" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblparallelTitle'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <span id="formRow08_help" >
                        <a href="javascript:showHelp('230','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblparallelTitle'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperparallelTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('parallelTitle', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="parallelTitle">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				<?php
$__section_iten_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title230']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_2_total = $__section_iten_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_2_total != 0) {
for ($__section_iten_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_2_iteration <= $__section_iten_2_total; $__section_iten_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsparallelTitle<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title230']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsparallelTitle<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title230']->value) {?>		
                <div id="frDataFieldsparallelTitlep" class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title230']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsparallelTitlep');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

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
                <div id="frDataFieldsparallelTitle" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow10" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherTitle'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value=""
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherTitle'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <span id="formRow10_help">
                        <a href="javascript:showHelp('240','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherTitle'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperotherTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('otherTitle', 'textEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="otherTitle">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title240']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_3_total = $__section_iten_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_3_total != 0) {
for ($__section_iten_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_3_iteration <= $__section_iten_3_total; $__section_iten_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsotherTitle<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title240']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherTitle<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
"  src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title240']->value) {?>		
                <div id="frDataFieldsotherTitlep" class="frDataFields">
                    <input type="text" 
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value="<?php echo $_smarty_tpl->tpl_vars['title240']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherTitlep');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

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
                <div id="frDataFieldsotherTitle" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow11" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <span id="formRow11_help" >
                        <a href="javascript:showHelp('510','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleHasOtherLanguageEditions'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasOtherLanguageEditions', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleHasOtherLanguageEditions">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'titleHasOtherLanguageEditions', 'singleTextEntry', '510', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);" class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title510']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_4_total = $__section_iten_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_4_total != 0) {
for ($__section_iten_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_4_iteration <= $__section_iten_4_total; $__section_iten_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleHasOtherLanguageEditions<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           value="<?php echo $_smarty_tpl->tpl_vars['title510']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasOtherLanguageEditions<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title510']->value[0]) {?>		
                <div id="frDataFieldstitleHasOtherLanguageEditionsp" class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           value="<?php echo $_smarty_tpl->tpl_vars['title510']->value[0];?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasOtherLanguageEditions'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasOtherLanguageEditionsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

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
                <div id="frDataFieldstitleHasOtherLanguageEditions" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow12" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAnotherLanguageEdition'];?>
</label>
                <div id="frDataFieldstitleAnotherLanguageEdition" class="frDataFields">
                    <input type="text"
                           name="field[titleAnotherLanguageEdition]"
                           id="titleAnotherLanguageEdition"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAnotherLanguageEdition'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow12').className = 'formRow';" />
                    <span id="formRow12_help">
                        <a href="javascript:showHelp('520','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAnotherLanguageEdition'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleAnotherLanguageEdition'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this,'titleAnotherLanguageEdition','singleTextEntry','520','<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAnotherLanguageEdition'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow13" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSubseries'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSubseries'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />

                    <span id="formRow13_help" >
                        <a href="javascript:showHelp('530','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSubseries'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleHasSubseries'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasSubseries', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleHasSubseries">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleHasSubseries', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSubseries'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>


                </div>
				<?php
$__section_iten_5_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_5_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title530']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_5_total = $__section_iten_5_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_5_total != 0) {
for ($__section_iten_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_5_iteration <= $__section_iten_5_total; $__section_iten_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleHasSubseries<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           value="<?php echo $_smarty_tpl->tpl_vars['title530']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSubseries<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title530']->value) {?>		
                <div id="frDataFieldstitleHasSubseriesp" class="frDataFields">
                    <input type="text"
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           value="<?php echo $_smarty_tpl->tpl_vars['title530']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSubseriesp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_5_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_5_saved;
}
?>
                <div id="frDataFieldstitleHasSubseries" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow14" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSubseriesOf'];?>
</label>
                <div id="frDataFieldstitleIsSubseriesOf" class="frDataFields">
                    <input type="text"
                           name="field[titleIsSubseriesOf]"
                           id="titleIsSubseriesOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title540']->value[0];?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSubseriesOf'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow14').className = 'formRow';" />
                    <span id="formRow14_help" >
                        <a href="javascript:showHelp('540','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSubseriesOf'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleIsSubseriesOf'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this, 'titleIsSubseriesOf', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
',  ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSubseriesOf'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow15" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSupplementInsert'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSupplementInsert'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <span id="formRow15_help" >
                        <a href="javascript:showHelp('550','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSupplementInsert'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleHasSupplementInsert'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasSupplementInsert', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleHasSupplementInsert">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'titleHasSupplementInsert', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleHasSupplementInsert'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				<?php
$__section_iten_6_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_6_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title550']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_6_total = $__section_iten_6_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_6_total != 0) {
for ($__section_iten_6_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_6_iteration <= $__section_iten_6_total; $__section_iten_6_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleHasSupplementInsert<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           value="<?php echo $_smarty_tpl->tpl_vars['title550']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSupplementInsert<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title550']->value) {?>		
                <div id="frDataFieldstitleHasSupplementInsertp" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           value="<?php echo $_smarty_tpl->tpl_vars['title550']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSupplementInsertp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_6_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_6_saved;
}
?>
				

                <div id="frDataFieldstitleHasSupplementInsert" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow16" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSupplementInsertOf'];?>
</label>
                <div id="frDataFieldstitleIsSupplementInsertOf" class="frDataFields">
                    <input type="text"
                           name="field[titleIsSupplementInsertOf]"
                           id="titleIsSupplementInsertOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title560']->value[0];?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSupplementInsertOf'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow16').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow16').className = 'formRow';" />
                    <span id="formRow16_help" >
                        <a href="javascript:showHelp('560','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSupplementInsertOf'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleIsSupplementInsertOf'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this, 'titleIsSupplementInsertOf', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleIsSupplementInsertOf'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_3" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep3'];?>
 - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
            <div id="formRow17" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuationOf'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuationOf'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <span id="formRow17_help" >
                        <a href="javascript:showHelp('610','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuationOf'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleContinuationOf'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuationOf', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleContinuationOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleContinuationOf', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuationOf'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				<?php
$__section_iten_7_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_7_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title610']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_7_total = $__section_iten_7_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_7_total != 0) {
for ($__section_iten_7_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_7_iteration <= $__section_iten_7_total; $__section_iten_7_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleContinuationOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title610']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuationOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title610']->value) {?>		
                <div id="frDataFieldstitleContinuationOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title610']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuationOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_7_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_7_saved;
}
?>
                <div id="frDataFieldstitleContinuationOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow18" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitlePartialContinuationOf'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <span id="formRow18_help" >
                        <a href="javascript:showHelp('620','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitlePartialContinuationOf'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitlePartialContinuationOf'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titlePartialContinuationOf', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titlePartialContinuationOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titlePartialContinuationOf', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitlePartialContinuationOf'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				<?php
$__section_iten_8_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_8_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title620']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_8_total = $__section_iten_8_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_8_total != 0) {
for ($__section_iten_8_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_8_iteration <= $__section_iten_8_total; $__section_iten_8_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitlePartialContinuationOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title620']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitlePartialContinuationOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title620']->value) {?>		
                <div id="frDataFieldstitlePartialContinuationOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title620']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitlePartialContinuationOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_8_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_8_saved;
}
?>
                <div id="frDataFieldstitlePartialContinuationOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow19" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbed'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbed'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <span id="formRow19_help" >
                        <a href="javascript:showHelp('650','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbed'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleAbsorbed'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbed', 'singleTextEntry');" 
                       class="singleButton okButton"
                       id="titleAbsorbed">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleAbsorbed', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbed'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_9_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_9_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title650']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_9_total = $__section_iten_9_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_9_total != 0) {
for ($__section_iten_9_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_9_iteration <= $__section_iten_9_total; $__section_iten_9_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleAbsorbed<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           value="<?php echo $_smarty_tpl->tpl_vars['title650']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbed<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title650']->value) {?>		
                <div id="frDataFieldstitleAbsorbedp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           value="<?php echo $_smarty_tpl->tpl_vars['title650']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_9_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_9_saved;
}
?>
                <div id="frDataFieldstitleAbsorbed" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow20" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPart'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartInPart][]"
                           id="titleAbsorbedInPart"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPart'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <span id="formRow20_help">
                        <a href="javascript:showHelp('660','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPart'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleAbsorbedInPart'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedInPart', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleAbsorbedInPart">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleAbsorbedInPart', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPart'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_10_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_10_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title660']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_10_total = $__section_iten_10_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_10_total != 0) {
for ($__section_iten_10_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_10_iteration <= $__section_iten_10_total; $__section_iten_10_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleAbsorbedInPart<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedInPart][]"
                           id="titleAbsorbedInPart"
                           value="<?php echo $_smarty_tpl->tpl_vars['title660']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPart<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>

                                <?php if ($_smarty_tpl->tpl_vars['title660']->value) {?>
                <div id="frDataFieldstitleAbsorbedInPartp" class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPart][]"
                           id="titleAbsorbedInPart"
                           value="<?php echo $_smarty_tpl->tpl_vars['title660']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_10_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_10_saved;
}
?>
                <div id="frDataFieldstitleAbsorbedInPart" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow21" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleFormedByTheSplittingOf'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleFormedByTheSplittingOf'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <span id="formRow21_help" >
                        <a href="javascript:showHelp('670','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleFormedByTheSplittingOf'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleFormedByTheSplittingOf'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleFormedByTheSplittingOf', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleFormedByTheSplittingOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleFormedByTheSplittingOf', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleFormedByTheSplittingOf'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_11_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_11_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title670']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_11_total = $__section_iten_11_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_11_total != 0) {
for ($__section_iten_11_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_11_iteration <= $__section_iten_11_total; $__section_iten_11_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleFormedByTheSplittingOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title670']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleFormedByTheSplittingOf<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title670']->value) {?>		
                <div id="frDataFieldstitleFormedByTheSplittingOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           value="<?php echo $_smarty_tpl->tpl_vars['title670']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleFormedByTheSplittingOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_11_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_11_saved;
}
?>
                <div id="frDataFieldstitleFormedByTheSplittingOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow22" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergeOfWith'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergeOfWith'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <span id="formRow22_help" >
                        <a href="javascript:showHelp('680','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergeOfWith'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleMergeOfWith'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleMergeOfWith', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleMergeOfWith">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_12_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_12_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title680']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_12_total = $__section_iten_12_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_12_total != 0) {
for ($__section_iten_12_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_12_iteration <= $__section_iten_12_total; $__section_iten_12_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleMergeOfWith<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           value="<?php echo $_smarty_tpl->tpl_vars['title680']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergeOfWith<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title680']->value) {?>		
                <div id="frDataFieldstitleMergeOfWithp" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           value="<?php echo $_smarty_tpl->tpl_vars['title680']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergeOfWithp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_12_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_12_saved;
}
?>
                <div id="frDataFieldstitleMergeOfWith" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow23" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedBy'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedBy'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <span id="formRow23_help" >
                        <a href="javascript:showHelp('710','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedBy'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleContinuedBy'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuedBy', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleContinuedBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>



				<?php
$__section_iten_13_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_13_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title710']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_13_total = $__section_iten_13_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_13_total != 0) {
for ($__section_iten_13_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_13_iteration <= $__section_iten_13_total; $__section_iten_13_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleContinuedBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title710']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title710']->value) {?>		
                <div id="frDataFieldstitleContinuedByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title710']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_13_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_13_saved;
}
?>
                <div id="frDataFieldstitleContinuedBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow24" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedInPartBy'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedInPartBy'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <span id="formRow24_help">
                        <a href="javascript:showHelp('720','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleContinuedInPartBy'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleContinuedInPartBy'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuedInPartBy', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleContinuedInPartBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_14_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_14_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title720']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_14_total = $__section_iten_14_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_14_total != 0) {
for ($__section_iten_14_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_14_iteration <= $__section_iten_14_total; $__section_iten_14_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleContinuedInPartBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title720']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPart<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title720']->value) {?>		
                <div id="frDataFieldstitleContinuedInPartByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title720']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedInPartByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_14_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_14_saved;
}
?>
                <div id="frDataFieldstitleContinuedInPartBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow25" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedBy'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedBy'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <span id="formRow25_help" >
                        <a href="javascript:showHelp('750','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedBy'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleAbsorbedBy'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedBy', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleAbsorbedBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_15_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_15_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title750']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_15_total = $__section_iten_15_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_15_total != 0) {
for ($__section_iten_15_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_15_iteration <= $__section_iten_15_total; $__section_iten_15_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleAbsorbedBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title750']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title750']->value) {?>		
                <div id="frDataFieldstitleAbsorbedByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title750']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_15_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_15_saved;
}
?>
                <div id="frDataFieldstitleAbsorbedBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow26" class="formRow">
                <label"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPartBy'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPartBy'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <span id="formRow26_help">
                        <a href="javascript:showHelp('760','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleAbsorbedInPartBy'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleAbsorbedInPartBy'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedInPartBy', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleAbsorbedInPartBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_16_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_16_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title760']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_16_total = $__section_iten_16_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_16_total != 0) {
for ($__section_iten_16_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_16_iteration <= $__section_iten_16_total; $__section_iten_16_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleAbsorbedInPartBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title760']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartBy<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title760']->value) {?>		
                <div id="frDataFieldstitleAbsorbedInPartByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           value="<?php echo $_smarty_tpl->tpl_vars['title760']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_16_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_16_saved;
}
?>
                <div id="frDataFieldstitleAbsorbedInPartBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow27" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleSplitInto'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleSplitInto'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <span id="formRow27_help">
                        <a href="javascript:showHelp('770','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleSplitInto'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleSplitInto'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleSplitInto', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleSplitInto">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_17_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_17_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title770']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_17_total = $__section_iten_17_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_17_total != 0) {
for ($__section_iten_17_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_17_iteration <= $__section_iten_17_total; $__section_iten_17_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleSplitInto<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           value="<?php echo $_smarty_tpl->tpl_vars['title770']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleSplitInto<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title770']->value) {?>		
                <div id="frDataFieldstitleSplitIntop" class="frDataFields">
                    <input type="text" 
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           value="<?php echo $_smarty_tpl->tpl_vars['title770']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleSplitIntop');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_17_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_17_saved;
}
?>
                <div id="frDataFieldstitleSplitInto" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow28" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergedWith'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergedWith'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <span id="formRow28_help" >
                        <a href="javascript:showHelp('780','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleMergedWith'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleMergedWith'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleMergedWith', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleMergedWith">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_18_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_18_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title780']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_18_total = $__section_iten_18_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_18_total != 0) {
for ($__section_iten_18_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_18_iteration <= $__section_iten_18_total; $__section_iten_18_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleMergedWith<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           value="<?php echo $_smarty_tpl->tpl_vars['title780']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergedWith<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title780']->value) {?>		
                <div id="frDataFieldstitleMergedWithp" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           value="<?php echo $_smarty_tpl->tpl_vars['title780']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergedWithp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_18_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_18_saved;
}
?>
                <div id="frDataFieldstitleMergedWith" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow29" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleToForm'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleToForm][]"
                           id="titleToForm"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleToForm'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <span id="formRow29_help" >
                        <a href="javascript:showHelp('790','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbltitleToForm'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpertitleToForm'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleToForm', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="titleToForm">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_19_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_19_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title790']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_19_total = $__section_iten_19_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_19_total != 0) {
for ($__section_iten_19_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_19_iteration <= $__section_iten_19_total; $__section_iten_19_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldstitleToForm<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text"
                           name="field[titleToForm][]"
                           id="titleToForm"
                           value="<?php echo $_smarty_tpl->tpl_vars['title790']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleToForm<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title790']->value) {?>		
                <div id="frDataFieldstitleToFormp" class="frDataFields">
                    <input type="text" 
                           name="field[titleToForm][]"
                           id="titleToForm"
                           value="<?php echo $_smarty_tpl->tpl_vars['title790']->value;?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleToFormp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_19_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_19_saved;
}
?>
                <div id="frDataFieldstitleToForm" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_4" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep4'];?>
  - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
            <div id="formRow30" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublisher'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[publisher]"
                           id="publisher"
                           value="<?php echo $_smarty_tpl->tpl_vars['title480']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow30').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow30').className = 'formRow';" />
                    <span id="formRow30_help">
                        <a href="javascript:showHelp('480','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublisher'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperpublisher'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow31" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblplace'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[place]"
                           id="place"
                           value="<?php echo $_smarty_tpl->tpl_vars['title490']->value[0];?>
"
                           title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblplace'];?>
"
                           class="textEntry inputAlert"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow31').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow31').className = 'formRow';" />
                    <div id="placeError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow31_help" >
                        <a href="javascript:showHelp('490','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblplace'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperplace'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow32" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcountry'];?>
</label>
                <div class="frDataFields">
                    <select name="field[country]" id="country" class="textEntry inputAlert" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcountry'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 280px 0px no-repeat !important;">
                        <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optCountry'],'selected'=>$_smarty_tpl->tpl_vars['title310']->value),$_smarty_tpl);?>

                    </select>
                    <div id="countryError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow32_help" >
                        <a href="javascript:showHelp('310','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcountry'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpercountry'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow33" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblstate'];?>
</label>
                <div class="frDataFields">
                    <select name="field[state]" id="state" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblstate'];?>
" class="textEntry">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optState'],'selected'=>$_smarty_tpl->tpl_vars['title320']->value),$_smarty_tpl);?>

                    </select>
                    <span id="formRow33_help">
                        <a href="javascript:showHelp('320','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblstate'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperstate'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow34" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[issn][]"
                           id="issn"
                           value=""
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
"
                           class="textEntry inputAlert"
                           onkeyup="validateISSN(this);"
                           onfocus="this.className = 'textEntry textEntryFocus';
                                    document.getElementById('formRow34').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';
                                   document.getElementById('formRow34').className = 'formRow';" />
                    <span id="formRow34_help">
                        <a href="javascript:showHelp('400','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperissn'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('issn', 'singleText', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       onclick="document.getElementById('issn').title = '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
'"
                       id="issn">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'issn', 'singleText', '400', '<?php echo $_SESSION['lang'];?>
',
                        ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblField400subfieldA'];?>
'], 'validateISSN(this)');"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertSubField'];?>
" src="public/images/common/spacer.gif" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <?php
$__section_iten_20_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_20_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title400']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_20_total = $__section_iten_20_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_20_total != 0) {
for ($__section_iten_20_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_20_iteration <= $__section_iten_20_total; $__section_iten_20_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                    <div id="frDataFieldsissn<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
">
                        <input disabled="disabled"
                               type="text"
                               name="field[issn][]"
                               id="issn"
                               value="<?php echo $_smarty_tpl->tpl_vars['title400']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                               title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsissn<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title400']->value[0]) {?>
                    <div id="frDataFieldsissnp" class="frDataFields">
                        <input disabled="disabled"
                               type="text"
                               name="field[issn][]"
                               id="issn"
                               value="<?php echo $_smarty_tpl->tpl_vars['title400']->value;?>
"
                               title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblissn'];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsissnp');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
					<?php }?>
				<?php
}
if ($__section_iten_20_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_20_saved;
}
?>

                </div>
                <div id="frDataFieldsissn" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow35" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcoden'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[coden]"
                           id="coden"
                           value="<?php echo $_smarty_tpl->tpl_vars['title410']->value;?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow35').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow35').className = 'formRow';" />
                    <span id="formRow35_help" >
                        <a href="javascript:showHelp('410','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcoden'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpercoden'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow36" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationStatus'];?>
</label>
                <div class="frDataFields">
                    <select name="field[publicationStatus]" 
                            id="publicationStatus"
                            class="textEntry inputAlert"
                            title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationStatus'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 90px 0px no-repeat !important;">
        		<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optPublicationStatus'],'selected'=>$_smarty_tpl->tpl_vars['title50']->value),$_smarty_tpl);?>

                    </select>
                    <div id="publicationStatusError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow36_help" >
                        <a href="javascript:showHelp('50','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationStatus'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperpublicationStatus'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>

        <div class="formContent">
            <div class="field49">
                <div id="formRow37" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialDate'];?>
</label>
                    <div class="frDataFields">
                        <input type="text"
                               name="field[initialDate]"
                               id="initialDate"
                               value="<?php echo $_smarty_tpl->tpl_vars['title301']->value[0];?>
"
                               title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialDate'];?>
"
                               class="textEntry inputAlert"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow37').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow37').className = 'formRow';" />
                        <div id="initialDateError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                        <span id="formRow37_help" >
                            <a href="javascript:showHelp('301','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialDate'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperinitialDate'];?>
');"><img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow38" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialVolume'];?>
</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[initialVolume]"
                               id="initialVolume"
                               value="<?php echo $_smarty_tpl->tpl_vars['title302']->value[0];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow38').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow38').className = 'formRow';" />
                        <span id="formRow38_help" >
                            <a href="javascript:showHelp('302','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialVolume'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperinitialVolume'];?>
');">
                                <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow39" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialNumber'];?>
</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[initialNumber]"
                               id="initialNumber"
                               value="<?php echo $_smarty_tpl->tpl_vars['title303']->value[0];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow39').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow39').className = 'formRow';" />
                        <span id="formRow39_help" >
                            <a href="javascript:showHelp('303','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblinitialNumber'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperinitialNumber'];?>
');">
                                <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
            </div>
            <div class="field49">
                <div id="formRow40" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalDate'];?>
</label>
                    <div class="frDataFields">
                        <input type="text"
                               name="field[finalDate]"
                               id="finalDate"
                               value="<?php echo $_smarty_tpl->tpl_vars['title304']->value[0];?>
"
                               title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalDate'];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow40').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow40').className = 'formRow';" />
                        <span id="formRow40_help" >
                            <a href="javascript:showHelp('304','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalDate'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperfinalDate'];?>
');">
                                <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow41" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalVolume'];?>
</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[finalVolume]"
                               id="finalVolume"
                               value="<?php echo $_smarty_tpl->tpl_vars['title305']->value[0];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow41').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow41').className = 'formRow';" />
                        <span id="formRow41_help">

                            <a href="javascript:showHelp('305','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalVolume'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperfinalVolume'];?>
');">
                                <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow42" class="formRow">
                    <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalNumber'];?>
</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[finalNumber]"
                               id="finalNumber"
                               value="<?php echo $_smarty_tpl->tpl_vars['title306']->value[0];?>
"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow42').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow42').className = 'formRow';" />
                        <span id="formRow42_help" >
                            <a href="javascript:showHelp('306','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblfinalNumber'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperfinalNumber'];?>
');">

                                <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
        <div class="formHead">

            <div id="formRow43" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblFrequency'];?>
</label>
                <div class="frDataFields">
                    <select name="field[frequency]" id="frequency" class="textEntry inputAlert" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblFrequency'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 110px 0px no-repeat !important;">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optFrequency'],'selected'=>$_smarty_tpl->tpl_vars['title380']->value),$_smarty_tpl);?>

                    </select>
                    <div id="frequencyError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow43_help" >

                        <a href="javascript:showHelp('380','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblFrequency'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperfrequency'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow44" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationLevel'];?>
</label>
                <div class="frDataFields">
                    <select name="field[publicationLevel]" 
                            id="publicationLevel"
                            class="textEntry inputAlert"
                            title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationLevel'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 70px 0px no-repeat !important;">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optPublicationLevel'],'selected'=>$_smarty_tpl->tpl_vars['title330']->value),$_smarty_tpl);?>

                    </select>
                    <div id="publicationLevelError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow44_help" >
                        <a href="javascript:showHelp('330','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblpublicationLevel'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperpublicationLevel'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow45" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblalphabetTitle'];?>
</label>
                <div class="frDataFields">
                    <select name="field[alphabetTitle]"
                            id="alphabetTitle"
                            class="textEntry inputAlert"
                            size="*"
                            title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblalphabetTitle'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 80px 0px no-repeat !important;">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optAlphabetTitle'],'selected'=>$_smarty_tpl->tpl_vars['title340']->value),$_smarty_tpl);?>

                    </select>
                    <div id="alphabetTitleError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow45_help" >
                        <a href="javascript:showHelp('340','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblalphabetTitle'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperalphabetTitle'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow46" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbllanguageText'];?>
</label>
                <div class="frDataFields">
                    <select name="field[languageText][]"
                            id="languageText"
                            class="textEntry inputAlert"
                            multiple size="*"
                            title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbllanguageText'];?>
"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 130px 0px no-repeat !important;">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optLanguage'],'selected'=>$_smarty_tpl->tpl_vars['title350']->value),$_smarty_tpl);?>

                    </select>
                    <div id="languageTextError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow46_help" >
                        <a href="javascript:showHelp('350','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbllanguageText'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperlanguageText'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow47" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbllanguageAbstract'];?>
</label>
                <div class="frDataFields">
                    <select name="field[languageAbstract][]" id="languageAbstract" class="textEntry inputAlert" multiple size="*">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['BVS_LANG']->value['optLanguage'],'selected'=>$_smarty_tpl->tpl_vars['title360']->value),$_smarty_tpl);?>

                    </select>
                    <span id="formRow47_help" >
                        <a href="javascript:showHelp('360','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbllanguageAbstract'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperlanguageAbstract'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_5" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep5'];?>
  - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
            <div id="formRow48" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblrelatedSystems'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblrelatedSystems'];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <span id="formRow48_help" >
                        <a href="javascript:showHelp('40','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblrelatedSystems'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperrelatedSystems'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('relatedSystems', 'textEntry singleTextEntry', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="relatedSystems">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_21_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_21_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title40']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_21_total = $__section_iten_21_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_21_total != 0) {
for ($__section_iten_21_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_21_iteration <= $__section_iten_21_total; $__section_iten_21_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsrelatedSystems<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" 
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           value="<?php echo $_smarty_tpl->tpl_vars['title40']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsrelatedSystems<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php }} else {
 ?>
					<?php if ($_smarty_tpl->tpl_vars['title40']->value) {?>		
                <div id="frDataFieldsrelatedSystemsp" class="frDataFields">
                    <input type="text" 
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           value="<?php echo $_smarty_tpl->tpl_vars['title40']->value[0];?>
"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsrelatedSystemsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
								<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_21_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_21_saved;
}
?>
                <div id="frDataFieldsrelatedSystems" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow49" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnationalCode'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[nationalCode]"
                           id="nationalCode"
                           value="<?php echo $_smarty_tpl->tpl_vars['title20']->value[0];?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow49').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow49').className = 'formRow';" />
                    <span id="formRow49_help">
                        <a href="javascript:showHelp('20','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnationalCode'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpernationalCode'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow50" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsecsIdentification'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[secsIdentification]"
                           id="secsIdentification"
                           value="<?php echo $_smarty_tpl->tpl_vars['title37']->value[0];?>
"
                           class="textEntry"
                           onkeyup="validateNumeric(this);"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow50').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow50').className = 'formRow';" />
                    <span id="formRow50_help" >
                        <a href="javascript:showHelp('37','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblsecsIdentification'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpersecsIdentification'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
        <div id="formRow52" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassification'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classification]"
                           id="classification"
                           value="<?php echo $_smarty_tpl->tpl_vars['title430']->value[0];?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow52').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow52').className = 'formRow';" />
                    <span id="formRow52_help" >
                        <a href="javascript:showHelp('430','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassification'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperclassification'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow67" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassificationCdu'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classificationCdu]"
                           id="classificationCdu"
                           value="<?php echo $_smarty_tpl->tpl_vars['title421']->value[0];?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow67').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow67').className = 'formRow';" />
                    <span id="formRow67_help" >
                        <a href="javascript:showHelp('421','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassificationCdu'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperclassificationCdu'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow68" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassificationDewey'];?>
</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classificationDewey]"
                           id="classificationDewey"
                           value="<?php echo $_smarty_tpl->tpl_vars['title422']->value[0];?>
"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow68').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow68').className = 'formRow';" />
                    <span id="formRow68_help" >
                        <a href="javascript:showHelp('422','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblclassificationDewey'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperclassificationDewey'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow72" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblthematicaArea'];?>
</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[thematicaArea][]"
                           id="thematicaArea"
                           class="textEntry"
                           title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblthematicaArea'];?>
"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <span id="formRow72_help" >
                        <a href="javascript:showHelp('435','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblthematicaArea'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperthematicaArea'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('thematicaArea', '', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="thematicaArea">
                        <span class="sb_lb">&#160;</span>
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" src="public/images/common/spacer.gif" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php
$__section_iten_22_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_22_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title435']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_22_total = $__section_iten_22_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_22_total != 0) {
for ($__section_iten_22_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_22_iteration <= $__section_iten_22_total; $__section_iten_22_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsthematicaArea<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[thematicaArea][]"
                           id="thematicaArea" value="<?php echo $_smarty_tpl->tpl_vars['title435']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsthematicaArea<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php }} else {
 ?>
		<?php if ($_smarty_tpl->tpl_vars['title435']->value) {?>		
                <div id="frDataFieldsthematicaAreap" class="frDataFields">
                    <input type="text" name="field[thematicaArea][]"
                           id="thematicaArea" value="<?php echo $_smarty_tpl->tpl_vars['title435']->value[0];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsthematicaAreap');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php }?>
		<?php
}
if ($__section_iten_22_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_22_saved;
}
?>
                <div id="frDataFieldsthematicaArea" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow53" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbldescriptors'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="" class="textEntry inputAlert" title="* <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbldescriptors'];?>
"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow53').className = 'formRow';" />
                    <span id="formRow53_help" >
                        <a href="javascript:showHelp('440','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbldescriptors'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperdescriptors'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('descriptors', '', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       onclick="document.getElementById('descriptors').title = '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbldescriptors'];?>
'"
                       id="descriptors">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_23_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_23_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title440']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_23_total = $__section_iten_23_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_23_total != 0) {
for ($__section_iten_23_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_23_iteration <= $__section_iten_23_total; $__section_iten_23_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsdescriptors<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="<?php echo $_smarty_tpl->tpl_vars['title440']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow53').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsdescriptors<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php }} else {
 ?>
		<?php if ($_smarty_tpl->tpl_vars['title440']->value) {?>		
                <div id="frDataFieldsdescriptorsp" class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="<?php echo $_smarty_tpl->tpl_vars['title440']->value;?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow53').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsdescriptorsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_23_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_23_saved;
}
?>
                <div id="frDataFieldsdescriptors" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow70" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherDescriptors'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" class="textEntry" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherDescriptors'];?>
"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <span id="formRow70_help" >
                        <a href="javascript:showHelp('441','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblotherDescriptors'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperotherDescriptors'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('otherDescriptors', '', '<?php echo $_SESSION['lang'];?>
');" 
                       class="singleButton okButton"
                       id="otherDescriptors">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				<?php
$__section_iten_24_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_24_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title441']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_24_total = $__section_iten_24_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_24_total != 0) {
for ($__section_iten_24_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_24_iteration <= $__section_iten_24_total; $__section_iten_24_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsotherDescriptors<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" value="<?php echo $_smarty_tpl->tpl_vars['title441']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherDescriptors<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php }} else {
 ?>
		<?php if ($_smarty_tpl->tpl_vars['title441']->value) {?>		
                <div id="frDataFieldsotherDescriptorsp" class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" value="<?php echo $_smarty_tpl->tpl_vars['title441']->value[0];?>
" class="textEntry" 
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherDescriptorsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php }?>
		<?php
}
if ($__section_iten_24_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_24_saved;
}
?>
                <div id="frDataFieldsotherDescriptors" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <!-->Inicio campo v450<-->
            <div id="formRow54" class="formRow formRowFocus">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblindexingCoverage'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[indexingCoverage][]"
                           id="indexingCoverage" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" 
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                    
                    <span id="formRow54_help">
                        <a href="javascript:showHelp('450','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblindexingCoverage'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperindexingCoverage'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('indexingCoverage','textEntry singleTextEntry','<?php echo $_SESSION['lang'];?>
')" 
                       class="singleButton okButton"
                       id="indexingCoverage">
                        <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" title="spacer" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
"/>
                            <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:insertSubField450(this, 'indexingCoverage', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', optIndexingCoverage, lblIndexingCoverage);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    <!-->começo da parte de inserir linha<-->
                    <?php
$__section_iten_25_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_25_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title450']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_25_total = $__section_iten_25_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_25_total != 0) {
for ($__section_iten_25_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_25_iteration <= $__section_iten_25_total; $__section_iten_25_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                    <div id="frDataFieldsindexingCoverage<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                        <input type="text" name="field[indexingCoverage][]" 
                               id="indexingCoverage<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" value="<?php echo $_smarty_tpl->tpl_vars['title450']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsindexingCoverage<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                                <span class="sb_lb">&#160;</span>
                                <img src="public/images/common/spacer.gif" title="spacer" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
"/>
                                <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                                <span class="sb_rb">&#160;</span>
                        </a>
                </div>
                <?php }} else {
 ?>
                    <?php if ($_smarty_tpl->tpl_vars['title450']->value) {?>
                        <div id="frDataFieldsindexingCoverage" class="frDataFields">
                            <input type="text" name="field[indexingCoverage][]" 
                                   id="indexingCoverage" value="<?php echo $_smarty_tpl->tpl_vars['title450']->value[0];?>
"
                                   class="textEntry singleTextEntry"
                                   onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';"
                                   onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                            <a href="javascript:removeRow('frDataFieldsindexingCoverage');" class="singleButton eraseButton">
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
if ($__section_iten_25_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_25_saved;
}
?>
                    <!-->fim da parte de inserir linha<-->
                </div>
                <div id="frDataFieldsindexingCoverage" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <!-->Fim do campo v450<-->

        </div>
        <div class="formHead">
            <div id="formRow57" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnotes'];?>
</label>
                <div class="frDataFields">
                    <textarea name="field[notes]" id="notes" 
                              rows="4" cols="50" class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow57').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow57').className = 'formRow';"><?php echo $_smarty_tpl->tpl_vars['title900']->value[0];?>

                    </textarea>
                    <span id="formRow57_help" >
                        <a href="javascript:showHelp('900','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnotes'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpernotes'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_6" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep6'];?>
  - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>
        </div>

        <div class="formContent">
            <div id="formRow83" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[urlPortal][]"
                           id="urlPortal" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <span id="formRow83_help" >
                        <a href="javascript:showHelp('999','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperurlPortal'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    
                    <a href="javascript:InsertLineOriginal('urlPortal','textEntry singleTextEntry','<?php echo $_SESSION['lang'];?>
')" 
                       class="singleButton okButton"
                       id="urlPortal">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                    
                    <a href="javascript:InsertLineSubField(this, 'urlPortal', 'singleTextEntry', '^x', '<?php echo $_SESSION['lang'];?>
', optAgregators, optAccessType, optControlAccess);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php
$__section_iten_26_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_26_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title999']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_26_total = $__section_iten_26_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_26_total != 0) {
for ($__section_iten_26_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_26_iteration <= $__section_iten_26_total; $__section_iten_26_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsurlPortal<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[urlPortal][]" id="urlPortal<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
"
                           value="<?php echo $_smarty_tpl->tpl_vars['title999']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlPortal<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }} else {
 ?>
                <?php if ($_smarty_tpl->tpl_vars['title999']->value) {?>
                <div id="frDataFieldsurlPortalp" class="frDataFields">
                    <input type="text" name="field[urlPortal][]" id="urlPortal"
                           value="<?php echo $_smarty_tpl->tpl_vars['title999']->value[0];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow59').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlPortalp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }?>
                <?php
}
if ($__section_iten_26_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_26_saved;
}
?>
                <div id="frDataFieldsurlPortal" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow74" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblBanPeriod'];?>
</label>
                <div class="frDataFields">
                    <textarea name="field[banPeriod]" id="banPeriods" rows="4" 
                              cols="50" class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow57').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow57').className = 'formRow';"><?php echo $_smarty_tpl->tpl_vars['title861']->value[0];?>

                    </textarea>
                    <span id="formRow74_help" >
                        <a href="javascript:showHelp('861','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblBanPeriod'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperBanPeriod'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>


            <div id="formRow73" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlInformation'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[urlInformation][]"
                           id="urlInformation" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <span id="formRow73_help" >
                        <a href="javascript:showHelp('860','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlInformation'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperurlInformation'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>

                    <a href="javascript:InsertLineOriginal('urlInformation', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');"
                       class="singleButton okButton"
                       id="urlInformation">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php
$__section_iten_27_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_27_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title860']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_27_total = $__section_iten_27_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_27_total != 0) {
for ($__section_iten_27_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_27_iteration <= $__section_iten_27_total; $__section_iten_27_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsurlInformation<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[urlInformation][]" id="urlInformation"
                           value="<?php echo $_smarty_tpl->tpl_vars['title860']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlInformation<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }} else {
 ?>
		<?php if ($_smarty_tpl->tpl_vars['title860']->value) {?>
                <div id="frDataFieldsurlInformationp" class="frDataFields">
                    <input type="text" name="field[urlInformation][]" id="urlInformation"
                           value="<?php echo $_smarty_tpl->tpl_vars['title860']->value[0];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlInformationp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_27_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_27_saved;
}
?>
                <div id="frDataFieldsurlInformation" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>


    <div  id="bloco_7" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblStep7'];?>
  - <?php echo $_smarty_tpl->tpl_vars['title100']->value[0];?>
 - <?php echo $_smarty_tpl->tpl_vars['title30']->value[0];?>
</h4>

            <div id="formRow82" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblspecialtyVHL'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <span id="formRow82_help" >
                        <a href="javascript:showHelp('436','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblspecialtyVHL'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperspecialtyVHL'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    
                    <a href="javascript:InsertLineOriginal('specialtyVHL','textEntry singleTextEntry','<?php echo $_SESSION['lang'];?>
')"
                       class="singleButton okButton" id="specialtyVHL">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'specialtyVHL', 'singleTextEntry', '436', '<?php echo $_SESSION['lang'];?>
', ['<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTematicVHL'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblTerminology'];?>
']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btSubField'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php
$__section_iten_28_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_28_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title436']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_28_total = $__section_iten_28_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_28_total != 0) {
for ($__section_iten_28_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_28_iteration <= $__section_iten_28_total; $__section_iten_28_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsSpecialtyVHL<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
"
                           value="<?php echo $_smarty_tpl->tpl_vars['title436']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsSpecialtyVHL<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }} else {
 ?>
                <?php if ($_smarty_tpl->tpl_vars['title436']->value) {?>
                <div id="frDataFieldsSpecialtyVHL" class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL"
                           value="<?php echo $_smarty_tpl->tpl_vars['title436']->value[0];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow59').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsSpecialtyVHL');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
                        <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }?>
                <?php
}
if ($__section_iten_28_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_28_saved;
}
?>
                <div id="frDataFieldsspecialtyVHL" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow74" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbluserVHL'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL" value=""
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <span id="formRow74_help" >
                        <a href="javascript:showHelp('445','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lbluserVHL'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperuserVHL'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('userVHL', 'singleTextEntry', '<?php echo $_SESSION['lang'];?>
');"
                       class="singleButton okButton"
                       id="userVHL">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnInsertLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btInsertRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		<?php
$__section_iten_29_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_iten']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten'] : false;
$__section_iten_29_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['title445']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_iten_29_total = $__section_iten_29_loop;
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = new Smarty_Variable(array());
if ($__section_iten_29_total != 0) {
for ($__section_iten_29_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] = 0; $__section_iten_29_iteration <= $__section_iten_29_total; $__section_iten_29_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']++){
?>
                <div id="frDataFieldsuserVHL<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
" class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL"
                           value="<?php echo $_smarty_tpl->tpl_vars['title445']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null)];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsuserVHL<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_iten']->value['index'] : null);?>
');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
							<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <?php }} else {
 ?>
		<?php if ($_smarty_tpl->tpl_vars['title445']->value) {?>
                <div id="frDataFieldsuserVHL" class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL"
                           value="<?php echo $_smarty_tpl->tpl_vars['title445']->value[0];?>
" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsuserVHL');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btnDeleteLine'];?>
" title="spacer" />
			<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btDeleteRecord'];?>

                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					<?php }?>
				<?php
}
if ($__section_iten_29_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_iten'] = $__section_iten_29_saved;
}
?>
                <div id="frDataFieldsuserVHL" style="display:block!important">&#160;</div>
                
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow80" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnotesBVS'];?>
</label>
                <div class="frDataFields">
                    <textarea name="field[notesBVS]" id="notesBVS" rows="4" cols="50" 
                              class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow80').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow80').className = 'formRow';"><?php echo $_smarty_tpl->tpl_vars['title910']->value[0];?>

                    </textarea>
                    <span id="formRow80_help" >
                        <a href="javascript:showHelp('910','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblnotesBVS'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpernotesBVS'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow78" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblwhoindex'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[whoindex]" id="whoindex"
                           value="<?php echo $_smarty_tpl->tpl_vars['title920']->value[0];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow78').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow78').className = 'formRow';" />
                    <div id="whoindexError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow78_help">
                        <a href="javascript:showHelp('920','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblwhoindex'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperwhoindex'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow79" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcodepublisher'];?>
</label>
                <div class="frDataFields">
                    <input type="text" name="field[codepublisher]" id="codepublisher"
                           value="<?php echo $_smarty_tpl->tpl_vars['title930']->value[0];?>
" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow79').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow79').className = 'formRow';" />
                    <div id="codepublisherError" style="display: none;" class="inlineError"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['requiredField'];?>
</div>
                    <span id="formRow79_help">
                        <a href="javascript:showHelp('930','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblcodepublisher'];?>
','<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpercodepublisher'];?>
');">
                            <img src="public/images/common/icon/helper_bg.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow80" class="formRow">
                <label><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblCreatDate'];?>
</label>
                <div class="frDataFields">
                    <label><?php echo $_smarty_tpl->tpl_vars['title940']->value[0];?>
</label>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>

</form>

<div class="helpBG" id="formRow999a_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999a_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 a] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldA'];?>
</div>
    </div>
</div>
<div class="helpBG" id="formRow999b_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999b_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 b] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldB'];?>
</div>
    </div>
</div>
<div class="helpBG" id="formRow999c_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999c_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 c] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldC'];?>
</div>
    </div>
</div>
<div class="helpBG" id="formRow999d_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999d_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 d] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldD'];?>
</div>
    </div>
</div>
<div class="helpBG" id="formRow999e_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999e_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 e,f] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldsEF'];?>
</div>
    </div>
</div>
<div class="helpBG" id="formRow999g_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999g_helpA');" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['close'];?>
">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btCancelAction'];?>
"/>
            </a>
        </span>
        <h2><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['help'];?>
 - [999 g] <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['lblurlPortal'];?>
</h2>
        <div class="help_message"><?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helpField999SubfieldG'];?>
</div>
    </div>
</div>
<div class="formFoot">
    <div class="helper">
		<?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['helperMaskForm'];?>

    </div>
    <div class="pagination">
        <a href="javascript: desligabloco1();" id="bloco1a" class="singleButton selectedBlock" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep1'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco2();" id="bloco2a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep2'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco3();" id="bloco3a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep3'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco4();" id="bloco4a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep4'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco5();" id="bloco5a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep5'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco6();" id="bloco6a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep6'];?>
 <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco7();" id="bloco7a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> <?php echo $_smarty_tpl->tpl_vars['BVS_LANG']->value['btStep7'];?>
  <span class="sb_rb">&#160;</span>
        </a>
    </div>
    <div class="spacer">&#160;</div>
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
