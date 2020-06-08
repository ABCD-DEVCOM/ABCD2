{if $smarty.session.role eq "Administrator"}
{assign var="i" value=0}
<script type="text/javascript">
    {assign var="i" value=0}
    var optAgregators = new Array();
    {foreach from=$BVS_LANG.optAgregators key=x item=z}
    optAgregators[{$i}] = new Array('{$x}','{$z}');
    {assign var="i" value=$i+1}
    {/foreach}

    {assign var="i" value=0}
    var optAccessType = new Array();
    {foreach from=$BVS_LANG.optAccessType key=t item=y}
    optAccessType[{$i}] = new Array('{$t}','{$y}');
    {assign var="i" value=$i+1}
    {/foreach}

    {assign var="i" value=0}
    var optControlAccess = new Array();
    {foreach from=$BVS_LANG.optControlAccess key=t item=y}
    optControlAccess[{$i}] = new Array('{$t}','{$y}');
    {assign var="i" value=$i+1}
    {/foreach}

    {assign var="i" value=0}
    var optIndexingCoverage = new Array();
    {foreach from=$BVS_LANG.optIndexingCoverage key=x item=z}
    optIndexingCoverage[{$i}] = new Array('{$x}','{$z}');
    {assign var="i" value=$i+1}
    {/foreach}

    {assign var="i" value=0}
    var lblIndexingCoverage = new Array();
    {foreach from=$BVS_LANG.lblSubFieldsv450 item=z}
    lblIndexingCoverage[{$i}] = new Array('{$z}');
    {assign var="i" value=$i+1}
    {/foreach}
</script>
{**geramos as variaveis com os valores de campos associados**}
{foreach key=k item=v from=$dataRecord}
{assign var="title"|cat:$k value=$v}
{/foreach}
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
<script type="text/javascript">

    YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
    YAHOO.widget.DataTable.MSG_ERROR = "{$BVS_LANG.MSG_ERROR}";
    labelHelp = "{$BVS_LANG.lblHelp}";
    helpISBD = "{$BVS_LANG.helpISBD}";
    help999subfieldA = "{$BVS_LANG.helpField999SubfieldA}"
    help999subfieldB = "{$BVS_LANG.helpField999SubfieldB}"
    help999subfieldC = "{$BVS_LANG.helpField999SubfieldC}"
    help999subfieldD = "{$BVS_LANG.helpField999SubfieldD}"
    help999subfieldE = "{$BVS_LANG.helpField999SubfieldsEF}"
    help999subfieldG = "{$BVS_LANG.helpField999SubfieldG}"

    help450subfieldA = "{$BVS_LANG.helperindexingCoverageA}"
    help450subfieldB = "{$BVS_LANG.helperindexingCoverageB}"
    help450subfieldC = "{$BVS_LANG.helperindexingCoverageC}"
    help450subfieldD = "{$BVS_LANG.helperindexingCoverageD}"
    help450subfieldE = "{$BVS_LANG.helperindexingCoverageE}"
    help450subfieldF = "{$BVS_LANG.helperindexingCoverageF}"
    IDErrorMesage = "{$BVS_LANG.IDErrorMesage}"

    {literal}
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
    {/literal}
</script>

<div class="formFoot">
    <div class="pagination">
        <a href="javascript: desligabloco1();" id="bloco1" class="singleButton selectedBlock" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep1} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco2();" id="bloco2" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep2} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco3();" id="bloco3" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep3} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco4();" id="bloco4" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep4} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco5();" id="bloco5" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep5} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco6();" id="bloco6" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep6} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco7();" id="bloco7" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep7}  <span class="sb_rb">&#160;</span>
        </a>
    </div>
    <div class="spacer">&#160;</div>
    <div class="spacer">&#160;</div>
</div>
<form id="formData" class="form" action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&edit=validation" enctype="multipart/form-data" name="formData" method="POST">
    <!--
    <form id="formData" class="form" action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&edit=save" enctype="multipart/form-data" name="formData" method="POST">
    -->
		{if $smarty.get.edit}
    <input type="hidden" name="mfn" value="{$smarty.get.edit}"/>
		{/if}
<!--                <input type="hidden" name="previousStep" id="previousStep" value="<span>{$BVS_LANG.btStep} <strong>{$BVS_LANG.btPrevious}</strong></span>"/>
    <input type="hidden" name="nextStep" id="nextStep" value="<span>{$BVS_LANG.btNext} <strong>{$BVS_LANG.btStep}</strong></span>"/>
    -->		<input type="hidden" name="gravar" id="gravar" value="false"/>
    <input type="hidden" name="field[dataBase]" value="TITLE"/>
    <input type="hidden" name="field[literatureType]" value="S"/>
    <input type="hidden" name="field[treatmentLevel]" value="s"/>
    <input type="hidden" name="field[centerCode]" value="main"/>
    <input type="hidden" name="field[creationDate]" value="{$smarty.now|date_format:"%Y%m%d"}"/>
		{if $edit}
           <input type="hidden" name="field[changeDate]" value="{$smarty.now|date_format:"%Y%m%d"}"/>
           <input type="hidden" name="field[changeDocumentalist]" value="BIREME"/>
		{/if}
    <input type="hidden" name="field[creationDocumentalist]" value="BIREME"/>

    <div  id="bloco_1" style="width:100%; position:relative; display: block">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep1} - {$title100[0]} - {$title30[0]}</h4>
            <div id="formRow01" class="formRow">
                <label>{$BVS_LANG.lblrecordIdentification}</label>
                <div class="frDataFields">
                    <label style="font-weight: bold; font-size: 12pt">{$title30[0]} &#160; </label>
                    <input type="hidden" name="field[recordIdentification]" id="recordIdentification" value="{$title30[0]}"/> 
                    <div id="recordIdentificationError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow01_help">
                        <a href="javascript:showHelp('30', '{$BVS_LANG.lblrecordIdentification}', '{$BVS_LANG.helperrecordIdentification}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow02" class="formRow">
                <label>{$BVS_LANG.lblpublicationTitle}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[publicationTitle]"
                           id="publicationTitle"
                           value="{$title100[0]}"
                           title="* {$BVS_LANG.lblpublicationTitle}"
                           class="textEntry singleTextEntry inputAlert"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry inputAlert';document.getElementById('formRow02').className = 'formRow';" />
                    <div id="publicationTitleError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow02_help">
                        <a href="javascript:showHelp('100', '{$BVS_LANG.lblpublicationTitle}', '{$BVS_LANG.helperpublicationTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>

	<div class="formContent">
		<div id="formRow03" class="formRow">
			<label>{$BVS_LANG.lblnameOfIssuingBody}</label>
                                <div class="frDataFields">
                                    <input type="text"
                                           name="field[nameOfIssuingBody][]"
                                           id="nameOfIssuingBody" value=""
                                           title="{$BVS_LANG.lblnameOfIssuingBody}"
                                           class="textEntry singleTextEntry"
                                           title="Teste"
                                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                                    <div id="categoryError" style="display: none;" class="inlineError">Defina um nome para a mï¿½dia.</div>
                                    <span id="formRow03_help">
                                        <a href="javascript:showHelp('140','{$BVS_LANG.lblnameOfIssuingBody}','{$BVS_LANG.helpernameOfIssuingBody}');">
                                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                                    </span>
                                    <a href="javascript:InsertLineOriginal('nameOfIssuingBody', 'singleTextEntry', '{$smarty.session.lang}');" 
                                       class="singleButton okButton"
                                       id="nameOfIssuingBody">
                                        <span class="sb_lb">&#160;</span>
                                        <img alt="" src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btInsertRecord}
                                        <span class="sb_rb">&#160;</span>
                                    </a>
                                </div>
				{section name=iten loop=$title140}
                <div id="frDataFieldsnameOfIssuingBody{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text"
                           name="field[nameOfIssuingBody][]"
                           id="nameOfIssuingBody"
                           value="{$title140[iten]}"
                           title="{$BVS_LANG.lblnameOfIssuingBody}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsnameOfIssuingBody{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
                {if $title140}
                <div id="frDataFieldsnameOfIssuingBodyp" class="frDataFields">
                    <input type="text" 
                           name="field[nameOfIssuingBody][]" id="nameOfIssuingBody"
                           value="{$title140}"
                           title="{$BVS_LANG.lblnameOfIssuingBody}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsnameOfIssuingBodyp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {/if}
				{/section}
                <div id="frDataFieldsnameOfIssuingBody" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow66" class="formRow">
                <label>{$BVS_LANG.lblkeyTitle}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[keyTitle]"
                           id="keyTitle"
                           value="{$title149[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow66').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow66').className = 'formRow';" />
                    <span id="formRow66_help">
                        <a href="javascript:showHelp('149', '{$BVS_LANG.lblkeyTitle}', '{$BVS_LANG.helperkeyTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow04" class="formRow">
                <label>{$BVS_LANG.lblabbreviatedTitle}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[abbreviatedTitle]"
                           id="abbreviatedTitle"
                           value="{$title150[0]}"
                           title="* {$BVS_LANG.lblabbreviatedTitle}"
                           class="textEntry singleTextEntry inputAlert"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry inputAlert';document.getElementById('formRow04').className = 'formRow';" />
                    <div id="abbreviatedTitleError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow04_help">
                        <a href="javascript:showHelp('150','{$BVS_LANG.lblabbreviatedTitle}','{$BVS_LANG.helperabbreviatedTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow69" class="formRow">
                <label>{$BVS_LANG.lblabbreviatedTitleMedline}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[abbreviatedTitleMedline][]"
                           id="abbreviatedTitleMedline"
                           title="{$BVS_LANG.lblabbreviatedTitleMedline}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <span id="formRow69_help">
                        <a href="javascript:showHelp('180','{$BVS_LANG.lblabbreviatedTitleMedline}','{$BVS_LANG.helperabbreviatedTitleMedline}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('abbreviatedTitleMedline', 'textEntry singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="abbreviatedTitleMedline">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'abbreviatedTitleMedline', 'textEntry singleTextEntry', '180', '{$smarty.session.lang}', ['{$BVS_LANG.lblField180subfield}', '{$BVS_LANG.lblField180subfiela}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    {section name=iten loop=$title180}
                    <div id="frDataFieldsabbreviatedTitleMedline{$smarty.section.iten.index}">
                        <input type="text"
                               name="field[abbreviatedTitleMedline][]"
                               id="abbreviatedTitleMedline"
                               value="{$title180[iten]}"
                               title="{$BVS_LANG.lblabbreviatedTitleMedline}"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsabbreviatedTitleMedline{$smarty.section.iten.index}');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
				{sectionelse}
					{if $title180[0]}
                    <div id="frDataFieldsabbreviatedTitleMedlinep" class="frDataFields">
                        <input type="text"
                               name="field[abbreviatedTitleMedline][]"
                               id="abbreviatedTitleMedline"
                               value="{$title180[0]}"
                               title="{$BVS_LANG.lblabbreviatedTitleMedline}"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsabbreviatedTitleMedlinep');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
					{/if}
				{/section}
                    <div id="frDataFieldsabbreviatedTitleMedline" style="display:block!important">&#160;</div>
                    <div class="spacer">&#160;</div>
                </div>
                <div class="spacer">&#160;</div>
            </div>

        </div>
    </div>
    <div  id="bloco_2" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep2}  - {$title100[0]} - {$title30[0]}</h4>
            <div id="formRow05" class="formRow">
                <label>{$BVS_LANG.lblsubtitle} </label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[subtitle]"
                           id="subtitle"
                           value="{$title110[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow05').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow05').className = 'formRow';" />
                    <span id="formRow05_help">
                        <a href="javascript:showHelp('110','{$BVS_LANG.lblsubtitle}','{$BVS_LANG.helpersubtitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow06" class="formRow">
                <label>{$BVS_LANG.lblsectionPart}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[sectionPart]"
                           id="sectionPart"
                           value="{$title120[0]}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow06').className = 'formRow';" />
                    <span id="formRow06_help">
                        <a href="javascript:showHelp('120','{$BVS_LANG.lblsectionPart}','{$BVS_LANG.helpersectionPart}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow07" class="formRow">
                <label>{$BVS_LANG.lbltitleOfSectionPart}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[titleOfSectionPart]"
                           id="titleOfSectionPart"
                           value="{$title130[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow07').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow07').className = 'formRow';" />
                    <span id="formRow07_help" >
                        <a href="javascript:showHelp('130','{$BVS_LANG.lbltitleOfSectionPart}','{$BVS_LANG.helpertitleOfSectionPart}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow08" class="formRow">
                <label>{$BVS_LANG.lblparallelTitle}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <span id="formRow08_help" >
                        <a href="javascript:showHelp('230','{$BVS_LANG.lblparallelTitle}','{$BVS_LANG.helperparallelTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('parallelTitle', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="parallelTitle">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				{section name=iten loop=$title230}
                <div id="frDataFieldsparallelTitle{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           value="{$title230[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsparallelTitle{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title230}		
                <div id="frDataFieldsparallelTitlep" class="frDataFields">
                    <input type="text" 
                           name="field[parallelTitle][]"
                           id="parallelTitle"
                           value="{$title230[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsparallelTitlep');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsparallelTitle" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow10" class="formRow">
                <label>{$BVS_LANG.lblotherTitle}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value=""
                           title="{$BVS_LANG.lblotherTitle}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <span id="formRow10_help">
                        <a href="javascript:showHelp('240','{$BVS_LANG.lblotherTitle}','{$BVS_LANG.helperotherTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('otherTitle', 'textEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="otherTitle">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title240}
                <div id="frDataFieldsotherTitle{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value="{$title240[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherTitle{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}"  src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title240}		
                <div id="frDataFieldsotherTitlep" class="frDataFields">
                    <input type="text" 
                           name="field[otherTitle][]"
                           id="otherTitle"
                           value="{$title240[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherTitlep');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsotherTitle" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow11" class="formRow">
                <label>{$BVS_LANG.lbltitleHasOtherLanguageEditions}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           title="{$BVS_LANG.lbltitleHasOtherLanguageEditions}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <span id="formRow11_help" >
                        <a href="javascript:showHelp('510','{$BVS_LANG.lbltitleHasOtherLanguageEditions}','{$BVS_LANG.helpertitleHasOtherLanguageEditions}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasOtherLanguageEditions', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleHasOtherLanguageEditions">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'titleHasOtherLanguageEditions', 'singleTextEntry', '510', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleHasOtherLanguageEditions}', '{$BVS_LANG.lblissn}']);" class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title510}
                <div id="frDataFieldstitleHasOtherLanguageEditions{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           value="{$title510[iten]}"
                           title="{$BVS_LANG.lbltitleHasOtherLanguageEditions}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasOtherLanguageEditions{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title510[0]}		
                <div id="frDataFieldstitleHasOtherLanguageEditionsp" class="frDataFields">
                    <input type="text"
                           name="field[titleHasOtherLanguageEditions][]"
                           id="titleHasOtherLanguageEditions"
                           value="{$title510[0]}"
                           title="{$BVS_LANG.lbltitleHasOtherLanguageEditions}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasOtherLanguageEditionsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleHasOtherLanguageEditions" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow12" class="formRow">
                <label>{$BVS_LANG.lbltitleAnotherLanguageEdition}</label>
                <div id="frDataFieldstitleAnotherLanguageEdition" class="frDataFields">
                    <input type="text"
                           name="field[titleAnotherLanguageEdition]"
                           id="titleAnotherLanguageEdition"
                           title="{$BVS_LANG.lbltitleAnotherLanguageEdition}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow12').className = 'formRow';" />
                    <span id="formRow12_help">
                        <a href="javascript:showHelp('520','{$BVS_LANG.lbltitleAnotherLanguageEdition}','{$BVS_LANG.helpertitleAnotherLanguageEdition}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this,'titleAnotherLanguageEdition','singleTextEntry','520','{$smarty.session.lang}', ['{$BVS_LANG.lbltitleAnotherLanguageEdition}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow13" class="formRow">
                <label>{$BVS_LANG.lbltitleHasSubseries}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           title="{$BVS_LANG.lbltitleHasSubseries}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />

                    <span id="formRow13_help" >
                        <a href="javascript:showHelp('530','{$BVS_LANG.lbltitleHasSubseries}','{$BVS_LANG.helpertitleHasSubseries}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasSubseries', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleHasSubseries">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleHasSubseries', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleHasSubseries}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>


                </div>
				{section name=iten loop=$title530}
                <div id="frDataFieldstitleHasSubseries{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           value="{$title530[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSubseries{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title530}		
                <div id="frDataFieldstitleHasSubseriesp" class="frDataFields">
                    <input type="text"
                           name="field[titleHasSubseries][]"
                           id="titleHasSubseries"
                           value="{$title530[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSubseriesp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleHasSubseries" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow14" class="formRow">
                <label>{$BVS_LANG.lbltitleIsSubseriesOf}</label>
                <div id="frDataFieldstitleIsSubseriesOf" class="frDataFields">
                    <input type="text"
                           name="field[titleIsSubseriesOf]"
                           id="titleIsSubseriesOf"
                           value="{$title540[0]}"
                           title="{$BVS_LANG.lbltitleIsSubseriesOf}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow14').className = 'formRow';" />
                    <span id="formRow14_help" >
                        <a href="javascript:showHelp('540','{$BVS_LANG.lbltitleIsSubseriesOf}','{$BVS_LANG.helpertitleIsSubseriesOf}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this, 'titleIsSubseriesOf', 'singleTextEntry', '^x', '{$smarty.session.lang}',  ['{$BVS_LANG.lbltitleIsSubseriesOf}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow15" class="formRow">
                <label>{$BVS_LANG.lbltitleHasSupplementInsert}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           title="{$BVS_LANG.lbltitleHasSupplementInsert}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <span id="formRow15_help" >
                        <a href="javascript:showHelp('550','{$BVS_LANG.lbltitleHasSupplementInsert}','{$BVS_LANG.helpertitleHasSupplementInsert}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleHasSupplementInsert', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleHasSupplementInsert">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'titleHasSupplementInsert', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleHasSupplementInsert}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				{section name=iten loop=$title550}
                <div id="frDataFieldstitleHasSupplementInsert{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           value="{$title550[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSupplementInsert{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title550}		
                <div id="frDataFieldstitleHasSupplementInsertp" class="frDataFields">
                    <input type="text" 
                           name="field[titleHasSupplementInsert][]"
                           id="titleHasSupplementInsert"
                           value="{$title550[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow15').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleHasSupplementInsertp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
				{**
				{foreach from=$dataRecord.550 item=curr_id name=campo}
					id: {$dataRecord.550}<br>
				{/foreach}

				{foreach name=outer item=contact from=$dataRecord.550}
					{foreach key=key item=item from=$dataRecord.550.subcampo}
						{$key}: {$item}<br>
					{/foreach}
				{/foreach}				
				**}

                <div id="frDataFieldstitleHasSupplementInsert" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow16" class="formRow">
                <label>{$BVS_LANG.lbltitleIsSupplementInsertOf}</label>
                <div id="frDataFieldstitleIsSupplementInsertOf" class="frDataFields">
                    <input type="text"
                           name="field[titleIsSupplementInsertOf]"
                           id="titleIsSupplementInsertOf"
                           value="{$title560[0]}"
                           title="{$BVS_LANG.lbltitleIsSupplementInsertOf}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow16').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow16').className = 'formRow';" />
                    <span id="formRow16_help" >
                        <a href="javascript:showHelp('560','{$BVS_LANG.lbltitleIsSupplementInsertOf}','{$BVS_LANG.helpertitleIsSupplementInsertOf}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:subFieldWizard(this, 'titleIsSupplementInsertOf', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleIsSupplementInsertOf}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_3" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep3} - {$title100[0]} - {$title30[0]}</h4>
            <div id="formRow17" class="formRow">
                <label>{$BVS_LANG.lbltitleContinuationOf}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           title="{$BVS_LANG.lbltitleContinuationOf}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <span id="formRow17_help" >
                        <a href="javascript:showHelp('610','{$BVS_LANG.lbltitleContinuationOf}','{$BVS_LANG.helpertitleContinuationOf}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuationOf', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleContinuationOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleContinuationOf', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleContinuationOf}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				{section name=iten loop=$title610}
                <div id="frDataFieldstitleContinuationOf{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           value="{$title610[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuationOf{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title610}		
                <div id="frDataFieldstitleContinuationOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuationOf][]"
                           id="titleContinuationOf"
                           value="{$title610[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow17').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuationOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleContinuationOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow18" class="formRow">
                <label>{$BVS_LANG.lbltitlePartialContinuationOf}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <span id="formRow18_help" >
                        <a href="javascript:showHelp('620','{$BVS_LANG.lbltitlePartialContinuationOf}','{$BVS_LANG.helpertitlePartialContinuationOf}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titlePartialContinuationOf', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titlePartialContinuationOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titlePartialContinuationOf', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitlePartialContinuationOf}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>

                </div>
				{section name=iten loop=$title620}
                <div id="frDataFieldstitlePartialContinuationOf{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           value="{$title620[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitlePartialContinuationOf{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title620}		
                <div id="frDataFieldstitlePartialContinuationOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titlePartialContinuationOf][]"
                           id="titlePartialContinuationOf"
                           value="{$title620[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow18').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow18').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitlePartialContinuationOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitlePartialContinuationOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow19" class="formRow">
                <label>{$BVS_LANG.lbltitleAbsorbed}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           title="{$BVS_LANG.lbltitleAbsorbed}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <span id="formRow19_help" >
                        <a href="javascript:showHelp('650','{$BVS_LANG.lbltitleAbsorbed}','{$BVS_LANG.helpertitleAbsorbed}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbed', 'singleTextEntry');" 
                       class="singleButton okButton"
                       id="titleAbsorbed">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleAbsorbed', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleAbsorbed}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title650}
                <div id="frDataFieldstitleAbsorbed{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           value="{$title650[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbed{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title650}		
                <div id="frDataFieldstitleAbsorbedp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbed][]"
                           id="titleAbsorbed"
                           value="{$title650[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow19').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow19').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleAbsorbed" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow20" class="formRow">
                <label>{$BVS_LANG.lbltitleAbsorbedInPart}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartInPart][]"
                           id="titleAbsorbedInPart"
                           title="{$BVS_LANG.lbltitleAbsorbedInPart}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <span id="formRow20_help">
                        <a href="javascript:showHelp('660','{$BVS_LANG.lbltitleAbsorbedInPart}','{$BVS_LANG.helpertitleAbsorbedInPart}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedInPart', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleAbsorbedInPart">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleAbsorbedInPart', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleAbsorbedInPart}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title660}
                <div id="frDataFieldstitleAbsorbedInPart{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedInPart][]"
                           id="titleAbsorbedInPart"
                           value="{$title660[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPart{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}

                                {if $title660}
                <div id="frDataFieldstitleAbsorbedInPartp" class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPart][]"
                           id="titleAbsorbedInPart"
                           value="{$title660[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow20').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow20').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleAbsorbedInPart" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow21" class="formRow">
                <label>{$BVS_LANG.lbltitleFormedByTheSplittingOf}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           title="{$BVS_LANG.lbltitleFormedByTheSplittingOf}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <span id="formRow21_help" >
                        <a href="javascript:showHelp('670','{$BVS_LANG.lbltitleFormedByTheSplittingOf}','{$BVS_LANG.helpertitleFormedByTheSplittingOf}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleFormedByTheSplittingOf', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleFormedByTheSplittingOf">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'titleFormedByTheSplittingOf', 'singleTextEntry', '^x', '{$smarty.session.lang}', ['{$BVS_LANG.lbltitleFormedByTheSplittingOf}', '{$BVS_LANG.lblissn}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title670}
                <div id="frDataFieldstitleFormedByTheSplittingOf{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           value="{$title670[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleFormedByTheSplittingOf{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title670}		
                <div id="frDataFieldstitleFormedByTheSplittingOfp" class="frDataFields">
                    <input type="text" 
                           name="field[titleFormedByTheSplittingOf][]"
                           id="titleFormedByTheSplittingOf"
                           value="{$title670}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow21').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow21').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleFormedByTheSplittingOfp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleFormedByTheSplittingOf" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow22" class="formRow">
                <label>{$BVS_LANG.lbltitleMergeOfWith}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           title="{$BVS_LANG.lbltitleMergeOfWith}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <span id="formRow22_help" >
                        <a href="javascript:showHelp('680','{$BVS_LANG.lbltitleMergeOfWith}','{$BVS_LANG.helpertitleMergeOfWith}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleMergeOfWith', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleMergeOfWith">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title680}
                <div id="frDataFieldstitleMergeOfWith{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           value="{$title680[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergeOfWith{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title680}		
                <div id="frDataFieldstitleMergeOfWithp" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergeOfWith][]"
                           id="titleMergeOfWith"
                           value="{$title680}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow22').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow22').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergeOfWithp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleMergeOfWith" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow23" class="formRow">
                <label>{$BVS_LANG.lbltitleContinuedBy}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           title="{$BVS_LANG.lbltitleContinuedBy}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <span id="formRow23_help" >
                        <a href="javascript:showHelp('710','{$BVS_LANG.lbltitleContinuedBy}','{$BVS_LANG.helpertitleContinuedBy}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuedBy', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleContinuedBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>



				{section name=iten loop=$title710}
                <div id="frDataFieldstitleContinuedBy{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           value="{$title710[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedBy{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title710}		
                <div id="frDataFieldstitleContinuedByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedBy][]"
                           id="titleContinuedBy"
                           value="{$title710}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow23').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow23').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleContinuedBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow24" class="formRow">
                <label>{$BVS_LANG.lbltitleContinuedInPartBy}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           title="{$BVS_LANG.lbltitleContinuedInPartBy}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <span id="formRow24_help">
                        <a href="javascript:showHelp('720','{$BVS_LANG.lbltitleContinuedInPartBy}','{$BVS_LANG.helpertitleContinuedInPartBy}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleContinuedInPartBy', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleContinuedInPartBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title720}
                <div id="frDataFieldstitleContinuedInPartBy{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           value="{$title720[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPart{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title720}		
                <div id="frDataFieldstitleContinuedInPartByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleContinuedInPartBy][]"
                           id="titleContinuedInPartBy"
                           value="{$title720}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow24').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow24').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleContinuedInPartByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleContinuedInPartBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow25" class="formRow">
                <label>{$BVS_LANG.lbltitleAbsorbedBy}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           title="{$BVS_LANG.lbltitleAbsorbedBy}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <span id="formRow25_help" >
                        <a href="javascript:showHelp('750','{$BVS_LANG.lbltitleAbsorbedBy}','{$BVS_LANG.helpertitleAbsorbedBy}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedBy', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleAbsorbedBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title750}
                <div id="frDataFieldstitleAbsorbedBy{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           value="{$title750[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedBy{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title750}		
                <div id="frDataFieldstitleAbsorbedByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedBy][]"
                           id="titleAbsorbedBy"
                           value="{$title750}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow25').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow25').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleAbsorbedBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow26" class="formRow">
                <label">{$BVS_LANG.lbltitleAbsorbedInPartBy}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           title="{$BVS_LANG.lbltitleAbsorbedInPartBy}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <span id="formRow26_help">
                        <a href="javascript:showHelp('760','{$BVS_LANG.lbltitleAbsorbedInPartBy}','{$BVS_LANG.helpertitleAbsorbedInPartBy}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleAbsorbedInPartBy', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleAbsorbedInPartBy">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title760}
                <div id="frDataFieldstitleAbsorbedInPartBy{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text"
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           value="{$title760[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartBy{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title760}		
                <div id="frDataFieldstitleAbsorbedInPartByp" class="frDataFields">
                    <input type="text" 
                           name="field[titleAbsorbedInPartBy][]"
                           id="titleAbsorbedInPartBy"
                           value="{$title760[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow26').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow26').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleAbsorbedInPartByp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleAbsorbedInPartBy" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow27" class="formRow">
                <label>{$BVS_LANG.lbltitleSplitInto}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           title="{$BVS_LANG.lbltitleSplitInto}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <span id="formRow27_help">
                        <a href="javascript:showHelp('770','{$BVS_LANG.lbltitleSplitInto}','{$BVS_LANG.helpertitleSplitInto}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleSplitInto', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleSplitInto">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title770}
                <div id="frDataFieldstitleSplitInto{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           value="{$title770[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleSplitInto{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title770}		
                <div id="frDataFieldstitleSplitIntop" class="frDataFields">
                    <input type="text" 
                           name="field[titleSplitInto][]"
                           id="titleSplitInto"
                           value="{$title770}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow27').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow27').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleSplitIntop');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleSplitInto" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow28" class="formRow">
                <label>{$BVS_LANG.lbltitleMergedWith}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           title="{$BVS_LANG.lbltitleMergedWith}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <span id="formRow28_help" >
                        <a href="javascript:showHelp('780','{$BVS_LANG.lbltitleMergedWith}','{$BVS_LANG.helpertitleMergedWith}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleMergedWith', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleMergedWith">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title780}
                <div id="frDataFieldstitleMergedWith{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           value="{$title780[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergedWith{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title780}		
                <div id="frDataFieldstitleMergedWithp" class="frDataFields">
                    <input type="text" 
                           name="field[titleMergedWith][]"
                           id="titleMergedWith"
                           value="{$title780[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow28').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow28').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleMergedWithp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleMergedWith" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow29" class="formRow">
                <label>{$BVS_LANG.lbltitleToForm}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[titleToForm][]"
                           id="titleToForm"
                           title="{$BVS_LANG.lbltitleToForm}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <span id="formRow29_help" >
                        <a href="javascript:showHelp('790','{$BVS_LANG.lbltitleToForm}','{$BVS_LANG.helpertitleToForm}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('titleToForm', 'singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="titleToForm">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title790}
                <div id="frDataFieldstitleToForm{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text"
                           name="field[titleToForm][]"
                           id="titleToForm"
                           value="{$title790[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleToForm{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title790}		
                <div id="frDataFieldstitleToFormp" class="frDataFields">
                    <input type="text" 
                           name="field[titleToForm][]"
                           id="titleToForm"
                           value="{$title790}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow29').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow29').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldstitleToFormp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldstitleToForm" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_4" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep4}  - {$title100[0]} - {$title30[0]}</h4>
            <div id="formRow30" class="formRow">
                <label>{$BVS_LANG.lblpublisher}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[publisher]"
                           id="publisher"
                           value="{$title480[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow30').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow30').className = 'formRow';" />
                    <span id="formRow30_help">
                        <a href="javascript:showHelp('480','{$BVS_LANG.lblpublisher}','{$BVS_LANG.helperpublisher}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow31" class="formRow">
                <label>{$BVS_LANG.lblplace}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[place]"
                           id="place"
                           value="{$title490[0]}"
                           title="* {$BVS_LANG.lblplace}"
                           class="textEntry inputAlert"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow31').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow31').className = 'formRow';" />
                    <div id="placeError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow31_help" >
                        <a href="javascript:showHelp('490','{$BVS_LANG.lblplace}','{$BVS_LANG.helperplace}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow32" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblcountry}</label>
                <div class="frDataFields">
                    <select name="field[country]" id="country" class="textEntry inputAlert" title="* {$BVS_LANG.lblcountry}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 280px 0px no-repeat !important;">
                        {html_options options=$BVS_LANG.optCountry selected=$title310}
                    </select>
                    <div id="countryError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow32_help" >
                        <a href="javascript:showHelp('310','{$BVS_LANG.lblcountry}','{$BVS_LANG.helpercountry}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow33" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblstate}</label>
                <div class="frDataFields">
                    <select name="field[state]" id="state" title="{$BVS_LANG.lblstate}" class="textEntry">
					{html_options options=$BVS_LANG.optState selected=$title320}
                    </select>
                    <span id="formRow33_help">
                        <a href="javascript:showHelp('320','{$BVS_LANG.lblstate}','{$BVS_LANG.helperstate}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow34" class="formRow">
                <label>{$BVS_LANG.lblissn}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[issn][]"
                           id="issn"
                           value=""
                           title="{$BVS_LANG.lblissn}"
                           class="textEntry inputAlert"
                           onkeyup="validateISSN(this);"
                           onfocus="this.className = 'textEntry textEntryFocus';
                                    document.getElementById('formRow34').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';
                                   document.getElementById('formRow34').className = 'formRow';" />
                    <span id="formRow34_help">
                        <a href="javascript:showHelp('400','{$BVS_LANG.lblissn}','{$BVS_LANG.helperissn}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('issn', 'singleText', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       onclick="document.getElementById('issn').title = '{$BVS_LANG.lblissn}'"
                       id="issn">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:subFieldWizard(this, 'issn', 'singleText', '400', '{$smarty.session.lang}',
                        ['{$BVS_LANG.lblissn}', '{$BVS_LANG.lblField400subfieldA}'], 'validateISSN(this)');"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertSubField}" src="public/images/common/spacer.gif" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    {section name=iten loop=$title400}
                    <div id="frDataFieldsissn{$smarty.section.iten.index}">
                        <input disabled="disabled"
                               type="text"
                               name="field[issn][]"
                               id="issn"
                               value="{$title400[iten]}"
                               title="{$BVS_LANG.lblissn}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsissn{$smarty.section.iten.index}');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
				{sectionelse}
					{if $title400[0]}
                    <div id="frDataFieldsissnp" class="frDataFields">
                        <input disabled="disabled"
                               type="text"
                               name="field[issn][]"
                               id="issn"
                               value="{$title400}"
                               title="{$BVS_LANG.lblissn}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow69').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow69').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsissnp');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
					{/if}
				{/section}

                </div>
                <div id="frDataFieldsissn" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow35" class="formRow">
                <label>{$BVS_LANG.lblcoden}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[coden]"
                           id="coden"
                           value="{$title410}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow35').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow35').className = 'formRow';" />
                    <span id="formRow35_help" >
                        <a href="javascript:showHelp('410','{$BVS_LANG.lblcoden}','{$BVS_LANG.helpercoden}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow36" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblpublicationStatus}</label>
                <div class="frDataFields">
                    <select name="field[publicationStatus]" 
                            id="publicationStatus"
                            class="textEntry inputAlert"
                            title="* {$BVS_LANG.lblpublicationStatus}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 90px 0px no-repeat !important;">
        		{html_options options=$BVS_LANG.optPublicationStatus selected=$title50}
                    </select>
                    <div id="publicationStatusError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow36_help" >
                        <a href="javascript:showHelp('50','{$BVS_LANG.lblpublicationStatus}','{$BVS_LANG.helperpublicationStatus}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>

        <div class="formContent">
            <div class="field49">
                <div id="formRow37" class="formRow">
                    <label>{$BVS_LANG.lblinitialDate}</label>
                    <div class="frDataFields">
                        <input type="text"
                               name="field[initialDate]"
                               id="initialDate"
                               value="{$title301[0]}"
                               title="* {$BVS_LANG.lblinitialDate}"
                               class="textEntry inputAlert"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow37').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow37').className = 'formRow';" />
                        <div id="initialDateError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                        <span id="formRow37_help" >
                            <a href="javascript:showHelp('301','{$BVS_LANG.lblinitialDate}','{$BVS_LANG.helperinitialDate}');"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow38" class="formRow">
                    <label>{$BVS_LANG.lblinitialVolume}</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[initialVolume]"
                               id="initialVolume"
                               value="{$title302[0]}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow38').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow38').className = 'formRow';" />
                        <span id="formRow38_help" >
                            <a href="javascript:showHelp('302','{$BVS_LANG.lblinitialVolume}','{$BVS_LANG.helperinitialVolume}');">
                                <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow39" class="formRow">
                    <label>{$BVS_LANG.lblinitialNumber}</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[initialNumber]"
                               id="initialNumber"
                               value="{$title303[0]}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow39').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow39').className = 'formRow';" />
                        <span id="formRow39_help" >
                            <a href="javascript:showHelp('303','{$BVS_LANG.lblinitialNumber}','{$BVS_LANG.helperinitialNumber}');">
                                <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
            </div>
            <div class="field49">
                <div id="formRow40" class="formRow">
                    <label>{$BVS_LANG.lblfinalDate}</label>
                    <div class="frDataFields">
                        <input type="text"
                               name="field[finalDate]"
                               id="finalDate"
                               value="{$title304[0]}"
                               title="{$BVS_LANG.lblfinalDate}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow40').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow40').className = 'formRow';" />
                        <span id="formRow40_help" >
                            <a href="javascript:showHelp('304','{$BVS_LANG.lblfinalDate}','{$BVS_LANG.helperfinalDate}');">
                                <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow41" class="formRow">
                    <label>{$BVS_LANG.lblfinalVolume}</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[finalVolume]"
                               id="finalVolume"
                               value="{$title305[0]}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow41').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow41').className = 'formRow';" />
                        <span id="formRow41_help">

                            <a href="javascript:showHelp('305','{$BVS_LANG.lblfinalVolume}','{$BVS_LANG.helperfinalVolume}');">
                                <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
                <div id="formRow42" class="formRow">
                    <label>{$BVS_LANG.lblfinalNumber}</label>
                    <div class="frDataFields">
                        <input type="text" 
                               name="field[finalNumber]"
                               id="finalNumber"
                               value="{$title306[0]}"
                               class="textEntry"
                               onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow42').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry';document.getElementById('formRow42').className = 'formRow';" />
                        <span id="formRow42_help" >
                            <a href="javascript:showHelp('306','{$BVS_LANG.lblfinalNumber}','{$BVS_LANG.helperfinalNumber}');">

                                <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                        </span>
                    </div>
                    <div class="spacer">&#160;</div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
        <div class="formHead">

            <div id="formRow43" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblFrequency}</label>
                <div class="frDataFields">
                    <select name="field[frequency]" id="frequency" class="textEntry inputAlert" title="* {$BVS_LANG.lblFrequency}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 110px 0px no-repeat !important;">
					{html_options options=$BVS_LANG.optFrequency selected=$title380}
                    </select>
                    <div id="frequencyError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow43_help" >

                        <a href="javascript:showHelp('380','{$BVS_LANG.lblFrequency}','{$BVS_LANG.helperfrequency}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow44" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblpublicationLevel}</label>
                <div class="frDataFields">
                    <select name="field[publicationLevel]" 
                            id="publicationLevel"
                            class="textEntry inputAlert"
                            title="* {$BVS_LANG.lblpublicationLevel}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 70px 0px no-repeat !important;">
					{html_options options=$BVS_LANG.optPublicationLevel selected=$title330}
                    </select>
                    <div id="publicationLevelError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow44_help" >
                        <a href="javascript:showHelp('330','{$BVS_LANG.lblpublicationLevel}','{$BVS_LANG.helperpublicationLevel}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow45" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblalphabetTitle}</label>
                <div class="frDataFields">
                    <select name="field[alphabetTitle]"
                            id="alphabetTitle"
                            class="textEntry inputAlert"
                            size="*"
                            title="* {$BVS_LANG.lblalphabetTitle}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 80px 0px no-repeat !important;">
					{html_options options=$BVS_LANG.optAlphabetTitle selected=$title340}
                    </select>
                    <div id="alphabetTitleError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow45_help" >
                        <a href="javascript:showHelp('340','{$BVS_LANG.lblalphabetTitle}','{$BVS_LANG.helperalphabetTitle}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow46" class="formRow formRowFocus">
                <label>{$BVS_LANG.lbllanguageText}</label>
                <div class="frDataFields">
                    <select name="field[languageText][]"
                            id="languageText"
                            class="textEntry inputAlert"
                            multiple size="*"
                            title="* {$BVS_LANG.lbllanguageText}"
                            style="background: url('public/images/common/icon/singleButton_alert.gif') 130px 0px no-repeat !important;">
					{html_options options=$BVS_LANG.optLanguage selected=$title350}
                    </select>
                    <div id="languageTextError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow46_help" >
                        <a href="javascript:showHelp('350','{$BVS_LANG.lbllanguageText}','{$BVS_LANG.helperlanguageText}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow47" class="formRow formRowFocus">
                <label>{$BVS_LANG.lbllanguageAbstract}</label>
                <div class="frDataFields">
                    <select name="field[languageAbstract][]" id="languageAbstract" class="textEntry inputAlert" multiple size="*">
					{html_options options=$BVS_LANG.optLanguage selected=$title360}
                    </select>
                    <span id="formRow47_help" >
                        <a href="javascript:showHelp('360','{$BVS_LANG.lbllanguageAbstract}','{$BVS_LANG.helperlanguageAbstract}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_5" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep5}  - {$title100[0]} - {$title30[0]}</h4>
            <div id="formRow48" class="formRow">
                <label>{$BVS_LANG.lblrelatedSystems}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           title="{$BVS_LANG.lblrelatedSystems}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <span id="formRow48_help" >
                        <a href="javascript:showHelp('40','{$BVS_LANG.lblrelatedSystems}','{$BVS_LANG.helperrelatedSystems}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('relatedSystems', 'textEntry singleTextEntry', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="relatedSystems">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title40}
                <div id="frDataFieldsrelatedSystems{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" 
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           value="{$title40[iten]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsrelatedSystems{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{sectionelse}
					{if $title40}		
                <div id="frDataFieldsrelatedSystemsp" class="frDataFields">
                    <input type="text" 
                           name="field[relatedSystems][]"
                           id="relatedSystems"
                           value="{$title40[0]}"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow48').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow48').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsrelatedSystemsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnDeleteLine}" src="public/images/common/spacer.gif" title="spacer" />
								{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsrelatedSystems" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow49" class="formRow">
                <label>{$BVS_LANG.lblnationalCode}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[nationalCode]"
                           id="nationalCode"
                           value="{$title20[0]}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow49').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow49').className = 'formRow';" />
                    <span id="formRow49_help">
                        <a href="javascript:showHelp('20','{$BVS_LANG.lblnationalCode}','{$BVS_LANG.helpernationalCode}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow50" class="formRow">
                <label>{$BVS_LANG.lblsecsIdentification}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[secsIdentification]"
                           id="secsIdentification"
                           value="{$title37[0]}"
                           class="textEntry"
                           onkeyup="validateNumeric(this);"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow50').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow50').className = 'formRow';" />
                    <span id="formRow50_help" >
                        <a href="javascript:showHelp('37','{$BVS_LANG.lblsecsIdentification}','{$BVS_LANG.helpersecsIdentification}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
        <div id="formRow52" class="formRow">
                <label>{$BVS_LANG.lblclassification}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classification]"
                           id="classification"
                           value="{$title430[0]}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow52').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow52').className = 'formRow';" />
                    <span id="formRow52_help" >
                        <a href="javascript:showHelp('430','{$BVS_LANG.lblclassification}','{$BVS_LANG.helperclassification}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow67" class="formRow">
                <label>{$BVS_LANG.lblclassificationCdu}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classificationCdu]"
                           id="classificationCdu"
                           value="{$title421[0]}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow67').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow67').className = 'formRow';" />
                    <span id="formRow67_help" >
                        <a href="javascript:showHelp('421','{$BVS_LANG.lblclassificationCdu}','{$BVS_LANG.helperclassificationCdu}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow68" class="formRow">
                <label>{$BVS_LANG.lblclassificationDewey}</label>
                <div class="frDataFields">
                    <input type="text" 
                           name="field[classificationDewey]"
                           id="classificationDewey"
                           value="{$title422[0]}"
                           class="textEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow68').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow68').className = 'formRow';" />
                    <span id="formRow68_help" >
                        <a href="javascript:showHelp('422','{$BVS_LANG.lblclassificationDewey}','{$BVS_LANG.helperclassificationDewey}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow72" class="formRow">
                <label>{$BVS_LANG.lblthematicaArea}</label>
                <div class="frDataFields">
                    <input type="text"
                           name="field[thematicaArea][]"
                           id="thematicaArea"
                           class="textEntry"
                           title="{$BVS_LANG.lblthematicaArea}"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <span id="formRow72_help" >
                        <a href="javascript:showHelp('435','{$BVS_LANG.lblthematicaArea}','{$BVS_LANG.helperthematicaArea}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                    </span>
                    <a href="javascript:InsertLineOriginal('thematicaArea', '', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="thematicaArea">
                        <span class="sb_lb">&#160;</span>
                        <img alt="{$BVS_LANG.btnInsertLine}" src="public/images/common/spacer.gif" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{section name=iten loop=$title435}
                <div id="frDataFieldsthematicaArea{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[thematicaArea][]"
                           id="thematicaArea" value="{$title435[iten]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsthematicaArea{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
			{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{sectionelse}
		{if $title435}		
                <div id="frDataFieldsthematicaAreap" class="frDataFields">
                    <input type="text" name="field[thematicaArea][]"
                           id="thematicaArea" value="{$title435[0]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow72').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow72').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsthematicaAreap');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{/if}
		{/section}
                <div id="frDataFieldsthematicaArea" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow53" class="formRow">
                <label>{$BVS_LANG.lbldescriptors}</label>
                <div class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="" class="textEntry inputAlert" title="* {$BVS_LANG.lbldescriptors}"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry inputAlert';document.getElementById('formRow53').className = 'formRow';" />
                    <span id="formRow53_help" >
                        <a href="javascript:showHelp('440','{$BVS_LANG.lbldescriptors}','{$BVS_LANG.helperdescriptors}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('descriptors', '', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       onclick="document.getElementById('descriptors').title = '{$BVS_LANG.lbldescriptors}'"
                       id="descriptors">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
			{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title440}
                <div id="frDataFieldsdescriptors{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="{$title440[iten]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow53').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsdescriptors{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
			{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{sectionelse}
		{if $title440}		
                <div id="frDataFieldsdescriptorsp" class="frDataFields">
                    <input type="text" name="field[descriptors][]"
                           id="descriptors" value="{$title440}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow53').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow53').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsdescriptorsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsdescriptors" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow70" class="formRow">
                <label>{$BVS_LANG.lblotherDescriptors}</label>
                <div class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" class="textEntry" title="{$BVS_LANG.lblotherDescriptors}"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <span id="formRow70_help" >
                        <a href="javascript:showHelp('441','{$BVS_LANG.lblotherDescriptors}','{$BVS_LANG.helperotherDescriptors}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('otherDescriptors', '', '{$smarty.session.lang}');" 
                       class="singleButton okButton"
                       id="otherDescriptors">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
							{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
				{section name=iten loop=$title441}
                <div id="frDataFieldsotherDescriptors{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" value="{$title441[iten]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherDescriptors{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{sectionelse}
		{if $title441}		
                <div id="frDataFieldsotherDescriptorsp" class="frDataFields">
                    <input type="text" name="field[otherDescriptors][]"
                           id="otherDescriptors" value="{$title441[0]}" class="textEntry" 
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsotherDescriptorsp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
			{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{/if}
		{/section}
                <div id="frDataFieldsotherDescriptors" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <!--Inicio campo v450<-->
            <div id="formRow54" class="formRow formRowFocus">
                <label>{$BVS_LANG.lblindexingCoverage}</label>
                <div class="frDataFields">
                    <input type="text" name="field[indexingCoverage][]"
                           id="indexingCoverage" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" 
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                    
                    <span id="formRow54_help">
                        <a href="javascript:showHelp('450','{$BVS_LANG.lblindexingCoverage}','{$BVS_LANG.helperindexingCoverage}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('indexingCoverage','textEntry singleTextEntry','{$smarty.session.lang}')" 
                       class="singleButton okButton"
                       id="indexingCoverage">
                        <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnInsertLine}"/>
                            {$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <a href="javascript:insertSubField450(this, 'indexingCoverage', 'singleTextEntry', '^x', '{$smarty.session.lang}', optIndexingCoverage, lblIndexingCoverage);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    <!--começo da parte de inserir linha<-->
                    {section name=iten loop=$title450}
                    <div id="frDataFieldsindexingCoverage{$smarty.section.iten.index}" class="frDataFields">
                        <input type="text" name="field[indexingCoverage][]" 
                               id="indexingCoverage{$smarty.section.iten.index}" value="{$title450[iten]}"
                               class="textEntry singleTextEntry"
                               onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                        <a href="javascript:removeRow('frDataFieldsindexingCoverage{$smarty.section.iten.index}');" class="singleButton eraseButton">
                                <span class="sb_lb">&#160;</span>
                                <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnDeleteLine}"/>
                                {$BVS_LANG.btDeleteRecord}
                                <span class="sb_rb">&#160;</span>
                        </a>
                </div>
                {sectionelse}
                    {if $title450}
                        <div id="frDataFieldsindexingCoverage" class="frDataFields">
                            <input type="text" name="field[indexingCoverage][]" 
                                   id="indexingCoverage" value="{$title450[0]}"
                                   class="textEntry singleTextEntry"
                                   onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';"
                                   onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                            <a href="javascript:removeRow('frDataFieldsindexingCoverage');" class="singleButton eraseButton">
                                    <span class="sb_lb">&#160;</span>
                                    <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnDeleteLine}"/>
                                    {$BVS_LANG.btDeleteRecord}
                                    <span class="sb_rb">&#160;</span>
                            </a>
                        </div>
                    {/if}
                {/section}
                    <!--fim da parte de inserir linha<-->
                </div>
                <div id="frDataFieldsindexingCoverage" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
            <!--Fim do campo v450<-->

        </div>
        <div class="formHead">
            <div id="formRow57" class="formRow">
                <label>{$BVS_LANG.lblnotes}</label>
                <div class="frDataFields">
                    <textarea name="field[notes]" id="notes" 
                              rows="4" cols="50" class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow57').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow57').className = 'formRow';">{$title900[0]}
                    </textarea>
                    <span id="formRow57_help" >
                        <a href="javascript:showHelp('900','{$BVS_LANG.lblnotes}','{$BVS_LANG.helpernotes}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>
    <div  id="bloco_6" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep6}  - {$title100[0]} - {$title30[0]}</h4>
        </div>

        <div class="formContent">
            <div id="formRow83" class="formRow">
                <label>{$BVS_LANG.lblurlPortal}</label>
                <div class="frDataFields">
                    <input type="text" name="field[urlPortal][]"
                           id="urlPortal" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <span id="formRow83_help" >
                        <a href="javascript:showHelp('999','{$BVS_LANG.lblurlPortal}','{$BVS_LANG.helperurlPortal}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    {* addSubFieldElement *}
                    <a href="javascript:InsertLineOriginal('urlPortal','textEntry singleTextEntry','{$smarty.session.lang}')" 
                       class="singleButton okButton"
                       id="urlPortal">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                        {$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                    
                    <a href="javascript:InsertLineSubField(this, 'urlPortal', 'singleTextEntry', '^x', '{$smarty.session.lang}', optAgregators, optAccessType, optControlAccess);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {section name=iten loop=$title999}
                <div id="frDataFieldsurlPortal{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[urlPortal][]" id="urlPortal{$smarty.section.iten.index}"
                           value="{$title999[iten]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlPortal{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {sectionelse}
                {if $title999}
                <div id="frDataFieldsurlPortalp" class="frDataFields">
                    <input type="text" name="field[urlPortal][]" id="urlPortal"
                           value="{$title999[0]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow59').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlPortalp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {/if}
                {/section}
                <div id="frDataFieldsurlPortal" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow74" class="formRow">
                <label>{$BVS_LANG.lblBanPeriod}</label>
                <div class="frDataFields">
                    <textarea name="field[banPeriod]" id="banPeriods" rows="4" 
                              cols="50" class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow57').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow57').className = 'formRow';">{$title861[0]}
                    </textarea>
                    <span id="formRow74_help" >
                        <a href="javascript:showHelp('861','{$BVS_LANG.lblBanPeriod}','{$BVS_LANG.helperBanPeriod}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>


            <div id="formRow73" class="formRow">
                <label>{$BVS_LANG.lblurlInformation}</label>
                <div class="frDataFields">
                    <input type="text" name="field[urlInformation][]"
                           id="urlInformation" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <span id="formRow73_help" >
                        <a href="javascript:showHelp('860','{$BVS_LANG.lblurlInformation}','{$BVS_LANG.helperurlInformation}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>

                    <a href="javascript:InsertLineOriginal('urlInformation', 'singleTextEntry', '{$smarty.session.lang}');"
                       class="singleButton okButton"
                       id="urlInformation">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
			{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{section name=iten loop=$title860}
                <div id="frDataFieldsurlInformation{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[urlInformation][]" id="urlInformation"
                           value="{$title860[iten]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlInformation{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {sectionelse}
		{if $title860}
                <div id="frDataFieldsurlInformationp" class="frDataFields">
                    <input type="text" name="field[urlInformation][]" id="urlInformation"
                           value="{$title860[0]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow73').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow73').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsurlInformationp');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
			{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsurlInformation" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>


    <div  id="bloco_7" style="width:100%; position:absolute; display: none">
        <div class="formHead">
            <h4>{$BVS_LANG.lblStep7}  - {$title100[0]} - {$title30[0]}</h4>

            <div id="formRow82" class="formRow">
                <label>{$BVS_LANG.lblspecialtyVHL}</label>
                <div class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL"
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow70').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow70').className = 'formRow';" />
                    <span id="formRow82_help" >
                        <a href="javascript:showHelp('436','{$BVS_LANG.lblspecialtyVHL}','{$BVS_LANG.helperspecialtyVHL}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    {* addSubFieldElement *}
                    <a href="javascript:InsertLineOriginal('specialtyVHL','textEntry singleTextEntry','{$smarty.session.lang}')"
                       class="singleButton okButton" id="specialtyVHL">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                        {$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>

                    <a href="javascript:subFieldWizard(this, 'specialtyVHL', 'singleTextEntry', '436', '{$smarty.session.lang}', ['{$BVS_LANG.lblTematicVHL}', '{$BVS_LANG.lblTerminology}']);"
                       class="singleButton addSubField">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                        {$BVS_LANG.btSubField}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {section name=iten loop=$title436}
                <div id="frDataFieldsSpecialtyVHL{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL{$smarty.section.iten.index}"
                           value="{$title436[iten]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow83').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow83').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsSpecialtyVHL{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {sectionelse}
                {if $title436}
                <div id="frDataFieldsSpecialtyVHL" class="frDataFields">
                    <input type="text" name="field[specialtyVHL][]" id="specialtyVHL"
                           value="{$title436[0]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow59').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsSpecialtyVHL');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {/if}
                {/section}
                <div id="frDataFieldsspecialtyVHL" style="display:block!important">&#160;</div>
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow74" class="formRow">
                <label>{$BVS_LANG.lbluserVHL}</label>
                <div class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL" value=""
                           class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <span id="formRow74_help" >
                        <a href="javascript:showHelp('445','{$BVS_LANG.lbluserVHL}','{$BVS_LANG.helperuserVHL}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                    <a href="javascript:InsertLineOriginal('userVHL', 'singleTextEntry', '{$smarty.session.lang}');"
                       class="singleButton okButton"
                       id="userVHL">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
			{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
		{section name=iten loop=$title445}
                <div id="frDataFieldsuserVHL{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL"
                           value="{$title445[iten]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsuserVHL{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
							{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {sectionelse}
		{if $title445}
                <div id="frDataFieldsuserVHL" class="frDataFields">
                    <input type="text" name="field[userVHL][]" id="userVHL"
                           value="{$title445[0]}" class="textEntry singleTextEntry"
                           onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow74').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow74').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsuserVHL');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />
			{$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
					{/if}
				{/section}
                <div id="frDataFieldsuserVHL" style="display:block!important">&#160;</div>
                
                <div class="spacer">&#160;</div>
            </div>

            <div id="formRow80" class="formRow">
                <label>{$BVS_LANG.lblnotesBVS}</label>
                <div class="frDataFields">
                    <textarea name="field[notesBVS]" id="notesBVS" rows="4" cols="50" 
                              class="textEntry singleTextEntry"
                              onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow80').className = 'formRow formRowFocus';"
                              onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow80').className = 'formRow';">{$title910[0]}
                    </textarea>
                    <span id="formRow80_help" >
                        <a href="javascript:showHelp('910','{$BVS_LANG.lblnotesBVS}','{$BVS_LANG.helpernotesBVS}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
        <div class="formContent">
            <div id="formRow78" class="formRow">
                <label>{$BVS_LANG.lblwhoindex}</label>
                <div class="frDataFields">
                    <input type="text" name="field[whoindex]" id="whoindex"
                           value="{$title920[0]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow78').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow78').className = 'formRow';" />
                    <div id="whoindexError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow78_help">
                        <a href="javascript:showHelp('920','{$BVS_LANG.lblwhoindex}','{$BVS_LANG.helperwhoindex}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow79" class="formRow">
                <label>{$BVS_LANG.lblcodepublisher}</label>
                <div class="frDataFields">
                    <input type="text" name="field[codepublisher]" id="codepublisher"
                           value="{$title930[0]}" class="textEntry"
                           onfocus="this.className = 'textEntry textEntryFocus';document.getElementById('formRow79').className = 'formRow formRowFocus';"
                           onblur="this.className = 'textEntry';document.getElementById('formRow79').className = 'formRow';" />
                    <div id="codepublisherError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
                    <span id="formRow79_help">
                        <a href="javascript:showHelp('930','{$BVS_LANG.lblcodepublisher}','{$BVS_LANG.helpercodepublisher}');">
                            <img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            <div id="formRow80" class="formRow">
                <label>{$BVS_LANG.lblCreatDate}</label>
                <div class="frDataFields">
                    <label>{$title940[0]}</label>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
    </div>

</form>

<div class="helpBG" id="formRow999a_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999a_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 a] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldA}</div>
    </div>
</div>
<div class="helpBG" id="formRow999b_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999b_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 b] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldB}</div>
    </div>
</div>
<div class="helpBG" id="formRow999c_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999c_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 c] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldC}</div>
    </div>
</div>
<div class="helpBG" id="formRow999d_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999d_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 d] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldD}</div>
    </div>
</div>
<div class="helpBG" id="formRow999e_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999e_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 e,f] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldsEF}</div>
    </div>
</div>
<div class="helpBG" id="formRow999g_helpA" style="display: none;">
    <div class="helpArea">
        <span class="exit">
            <a href="javascript:showHideDiv('formRow999g_helpA');" title="{$BVS_LANG.close}">
                <img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"/>
            </a>
        </span>
        <h2>{$BVS_LANG.help} - [999 g] {$BVS_LANG.lblurlPortal}</h2>
        <div class="help_message">{$BVS_LANG.helpField999SubfieldG}</div>
    </div>
</div>
<div class="formFoot">
    <div class="helper">
		{$BVS_LANG.helperMaskForm}
    </div>
    <div class="pagination">
        <a href="javascript: desligabloco1();" id="bloco1a" class="singleButton selectedBlock" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep1} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco2();" id="bloco2a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep2} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco3();" id="bloco3a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep3} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco4();" id="bloco4a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep4} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco5();" id="bloco5a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep5} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco6();" id="bloco6a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep6} <span class="sb_rb">&#160;</span>
        </a>
        <a href="javascript: desligabloco7();" id="bloco7a" class="singleButton singleButtonSelected" >
            <span class="sb_lb">&#160;</span> {$BVS_LANG.btStep7}  <span class="sb_rb">&#160;</span>
        </a>
    </div>
    <div class="spacer">&#160;</div>
    <div class="spacer">&#160;</div>
</div>
{else}
<div id="middle" class="middle message mAlert">
    <img src="public/images/common/spacer.gif" alt="" title="" />
    <div class="mContent">
        <h4>{$BVS_LANG.mFail}</h4>
        <p><strong>{$sMessage.message}</strong></p>
        <p><strong>{$BVS_LANG.msg_op_fail}</strong></p>
        <div>
            <code>{$BVS_LANG.error404}</code>
        </div>
        <span><a href="index.php"><strong>{$BVS_LANG.btBackAction}</strong></a></span>
    </div>
    <div class="spacer">&#160;</div>
</div>
{/if}
<script>
window.onload=changeDesc();
function changeDesc()
{
	var desc=document.getElementById("descriptors");
	desc.title="rmv "+desc.title;
	var languageText=document.getElementById("languageText");
	languageText.title="rmv "+languageText.title;
}
</script>
