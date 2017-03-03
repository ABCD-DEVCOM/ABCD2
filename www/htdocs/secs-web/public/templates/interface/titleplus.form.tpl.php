{if $smarty.session.role neq "Documentalista"}
{**geramos as variaveis com os valores de campos associados**}
{foreach key=k item=v from=$dataRecord}
{assign var="titplus"|cat:$k value=$v}
{/foreach}

<div class="yui-skin-sam">

    <div id="helpDialog" >
        <div class="hd"><div id="helpTitle"></div></div>
        <div class="bd">
            <div id="helpBody"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
{assign var="i" value=0}
var lblAcquisitionHistory = new Array();
{foreach from=$BVS_LANG.lblSubFieldsv913 item=z}
    lblAcquisitionHistory[{$i}] = new Array('{$z}');
    {assign var="i" value=$i+1}
{/foreach}

YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
YAHOO.widget.DataTable.MSG_ERROR = "{$BVS_LANG.MSG_ERROR}";
labelHelp = "{$BVS_LANG.lblHelp}";
help913subfieldD = "{$BVS_LANG.helperAcquisitionHistoryD}";
help913subfieldV = "{$BVS_LANG.helperAcquisitionHistoryV}";
help913subfieldA = "{$BVS_LANG.helperAcquisitionHistoryA}";
help913subfieldF = "{$BVS_LANG.helperAcquisitionHistoryF}";
//alert(help913subfieldF);
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
{/literal}
</script>
<form action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&amp;title={$titleCode}&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >	
    {if $smarty.get.edit}
    <input type="hidden" name="mfn" value="{$smarty.get.edit}"/>
    {/if}
    <input type="hidden" name="gravar" id="gravar" value="false"/>
    <input type="hidden" name="record" id="record" value="false"/>
    <input type="hidden" name="field[titleCode]" value="{if $titplus30[0]}{$titplus30[0]}{else}{$titleCode}{/if}"/>
    <input type="hidden" name="field[centerCode]" value="{$smarty.session.library}"/>
    <input type="hidden" name="field[titleName]" value="{$OBJECTS_TITLE.pubTitle}"/>

    <input type="hidden" name="field[initialDate]" value="{$smarty.get.initialDate}"/>
    <input type="hidden" name="field[initialVolume]" value="{$smarty.get.initialVolume}"/>
    <input type="hidden" name="field[initialNumber]" value="{$smarty.get.initialNumber}"/>

    <div class="formHead">
        {if $smarty.session.library}
        <div>{$smarty.session.library}</div>
        {/if}
        {if $titplus30 or $titleCode}
        <div>ID={if $titleCode}{$titleCode}{else}{$titplus30}{/if}</div>
        {/if}
        {if $OBJECTS_TITLE.pubTitle}
        <div>{$OBJECTS_TITLE.pubTitle}.--</div>
        {/if}
        {if $OBJECTS_TITLE.ISSN}
        <div>ISSN: {$OBJECTS_TITLE.ISSN}</div>
        {/if}
        {*if $OBJECTS_TITLE.issnOnline}
        <div>{$OBJECTS_TITLE.issnOnline}</div>
        {/if*}
        {if $OBJECTS_TITLE.abrTitle}
        <div>{$OBJECTS_TITLE.abrTitle}</div>
        {/if}

        <div class="spacer">&#160;</div>
    </div>

    <div class="formContent">
        <div id="formRow08" class="formRow">
            <label>{$BVS_LANG.lblAcquisitionMethod}</label>
            <div class="frDataFields">
              
                <select name="field[acquisitionMethod]" id="acquisitionMethod" class="textEntry superTextEntry" title="* {$BVS_LANG.lblAcquisitionMethod}">
                    {html_options options=$BVS_LANG.optAcquisitionMethod selected=$titplus901[0]}
                </select>
                <span id="formRow08_help">
                    <a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow08_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [901] {$BVS_LANG.lblAcquisitionMethod}</h2>
                        <div class="help_message">{$BVS_LANG.helperAcquisitionMethod}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow01" class="formRow">
            <label>{$BVS_LANG.lblAcquisitionControl}</label>
            <div class="frDataFields">
                <select name="field[acquisitionControl]" id="acquisitionControl" class="textEntry superTextEntry" title="* {$BVS_LANG.lblAcquisitionControl}">
                    {html_options options=$BVS_LANG.optAcquisitionControl selected=$titplus902[0]}
                </select>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow01_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [902] {$BVS_LANG.lblAcquisitionControl}</h2>
                        <div class="help_message">{$BVS_LANG.helperAcquisitionControl}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow10" class="formRow">
            <label>{$BVS_LANG.lblExpirationSubs}</label>
            <div class="frDataFields">
                <input type="text" name="field[expirationSubs]" id="expirationSubs" value="{$titplus906[0]}" title="{$BVS_LANG.lblExpirationSubs}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow10').className = 'formRow';" />
                <div class="yui-skin-sam"><div id="datefields" style="display: none;"></div></div>
                <a id="#calend" href="#" onclick="calendarButton('expirationSubs'); showHideDiv('datefields');" >
                    <img src="public/images/common/calbtn.gif" title="calend" alt="calend" />
                </a>
                <span id="formRow10_help">
                    <a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow10_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [906] {$BVS_LANG.lblExpirationSubs}</h2>
                        <div class="help_message">{$BVS_LANG.helperExpirationSubs}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow16" class="formRow">
            <label>{$BVS_LANG.lblAcquisitionPriority}</label>
            <div class="frDataFields">
              
                <select name="field[acquisitionPriority]" id="acquisitionPriority" class="textEntry superTextEntry" title="* {$BVS_LANG.lblAcquisitionPriority}">
                    {html_options options=$BVS_LANG.optAcquisitionPriority selected=$titplus946[0]}
                </select>
                <span id="formRow16_help">
                    <a href="javascript:showHideDiv('formRow16_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow16_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow16_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [946] {$BVS_LANG.lblAcquisitionPriority}</h2>
                        <div class="help_message">{$BVS_LANG.helperacquisitionPriority}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow15" class="formRow">
            <label>{$BVS_LANG.lblAdmNotes}</label>
            <div class="frDataFields">
                <textarea name="field[admNotes]" cols="80" rows="3" id="admNotes" title="{$BVS_LANG.lblAdmNotes}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow15').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow15').className = 'formRow';" >{$titplus911[0]}</textarea>
                <span id="formRow15_help">
                    <a href="javascript:showHideDiv('formRow15_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow15_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow15_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [911] {$BVS_LANG.lblAdmNotes}</h2>
                        <div class="help_message">{$BVS_LANG.helperAdmNotes}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
    </div>

    <div class="formHead">
        <div id="formRow913" class="formRow">
            <label>{$BVS_LANG.lblAcquisitionHistory}</label>
            <div class="frDataFields">
                <input type="text" name="field[acquisitionHistory]" value="{$titplus913[0]}" id="acquisitionHistory" title="valor" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow913').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow913').className = 'formRow';" />
                <span id="formRow913_help">
                    <a href="javascript:showHideDiv('formRow913_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow913_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow913_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [913] {$BVS_LANG.lblAcquisitionHistory}</h2>
                        <div class="help_message">{$BVS_LANG.helperAcquisitionHistory}</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('acquisitionHistory','superTextEntry2','{$smarty.session.lang}');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnInsertLine}"/>
                    {$BVS_LANG.btInsertRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
                <a href="javascript:insertSubField913(this, 'acquisitionHistory', '^x', '{$smarty.session.lang}', lblAcquisitionHistory);"
                   class="singleButton addSubField">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                    {$BVS_LANG.btSubField}
                    <span class="sb_rb">&#160;</span>
                </a>
                <!-->começo da parte de inserir linha<-->
                {section name=iten loop=$titplus450}
                <div id="frDataFieldsacquisitionHistory{$smarty.section.iten.index}" class="frDataFields">
                    <input type="text" name="field[acquisitionHistory][]" id="acquisitionHistory{$smarty.section.iten.index}" value="{$titplus913[iten]}" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow54').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsacquisitionHistory{$smarty.section.iten.index}');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnDeleteLine}" />
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {sectionelse}
                {if $titplus913}
                <div id="frDataFieldsacquisitionHistory" class="frDataFields">
                    <input type="text" name="field[acquisitionHistory][]" id="acquisitionHistory" value="{$titplus913[0]}" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow54').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow59').className = 'formRow';" />
                    <a href="javascript:removeRow('frDataFieldsacquisitionHistory');" class="singleButton eraseButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" title="spacer" alt="{$BVS_LANG.btnDeleteLine}"/>
                        {$BVS_LANG.btDeleteRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </div>
                {/if}
                {/section}
                <!-->fim da parte de inserir linha<-->
            </div>
            <div id="frDataFieldsacquisitionHistory" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>
        <div id="formRow09" class="formRow">
            <label>{$BVS_LANG.lblProvider}</label>
            <div class="frDataFields">
                <input type="text" name="field[provider]" id="provider" value="{$titplus905[0]}" title="{$BVS_LANG.lblProvider}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow09').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow09').className = 'formRow';" />
                <span id="formRow09_help">
                    <a href="javascript:showHideDiv('formRow09_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow09_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow09_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [905] {$BVS_LANG.lblProvider}</h2>
                        <div class="help_message">{$BVS_LANG.helperProvider}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow02" class="formRow">
            <label>{$BVS_LANG.lblProviderNotes}</label>
            <div class="frDataFields">
                <textarea name="field[providerNotes]" cols="80" rows="3" id="providerNotes" title="{$BVS_LANG.lblProviderNotes}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';">{$titplus904[0]}</textarea>
                <span id="formRow02_help">
                    <a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow02_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [904] {$BVS_LANG.lblProviderNotes}</h2>
                        <div class="help_message">{$BVS_LANG.helperProviderNotes}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label>{$BVS_LANG.lblReceivedExchange}</label>
            <div class="frDataFields">
                <input type="text" name="field[receivedExchange]" id="receivedExchange" value="{$titplus903[0]}" title="{$BVS_LANG.lblReceivedExchange}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry superTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                <span id="formRow03_help">
                    <a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow03_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [903] {$BVS_LANG.lblReceivedExchange}</h2>
                        <div class="help_message">{$BVS_LANG.helperReceivedExchange}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow17" class="formRow">
            <label>{$BVS_LANG.lblDonorNotes}</label>
            <div class="frDataFields">
                <textarea name="field[donorNotes]" cols="80" rows="3" id="donorNotes" title="{$BVS_LANG.lblDonorNotes}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow17').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow17').className = 'formRow';" >{$titplus912[0]}</textarea>
                <span id="formRow17_help">
                    <a href="javascript:showHideDiv('formRow17_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
                </span>
                <div class="helpBG" id="formRow17_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow17_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
                        <h2>{$BVS_LANG.help} - [912] {$BVS_LANG.lblDonorNotes}</h2>
                        <div class="help_message">{$BVS_LANG.helperDonorNotes}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

    </div>

    <div class="formContent">

        <div id="formRow11" class="formRow">
            <label for="locationRoom">{$BVS_LANG.lblLocationRoom}</label>
            <div class="frDataFields">
                <input type="text" name="locationRoom" id="locationRoom" value="" title="{$BVS_LANG.lblLocationRoom}" class="textEntry superTextEntry" title="{$BVS_LANG.lblLocationRoom}" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow11_help">
                    <a href="javascript:showHideDiv('formRow11_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <div class="helpBG" id="formRow11_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow11_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                        <h2>{$BVS_LANG.help} - [907] {$BVS_LANG.lblLocationRoom}</h2>
                        <div class="help_message">{$BVS_LANG.helperLocationRoom}</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('locationRoom', 'superTextEntry2', '{$smarty.session.lang}');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />{$BVS_LANG.btInsertRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {section name=iten loop=$titplus907}
            <div id="frDataFieldslocationRoom{$smarty.section.iten.index}" class="frDataFields">
                <input type="text" name="field[locationRoom][]" id="locationRoom" value="{$titplus907[iten]}" title="{$BVS_LANG.lblLocationRoom}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow11').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldslocationRoom{$smarty.section.iten.index}');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {sectionelse}
            {if $titplus907}
            <div id="frDataFieldslocationRoomp" class="frDataFields">
                <input type="text" name="field[locationRoom][]" id="locationRoom" value="{$titplus907}" title="{$BVS_LANG.lblLocationRoom}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow11').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldslocationRoomp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {/if}
            {/section}
            <div id="frDataFieldslocationRoom" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>


        <div id="formRow12" class="formRow">
            <label for="estMap">{$BVS_LANG.lblEstMap}</label>
            <div class="frDataFields">
                <input type="text" name="estMap" id="estMap" value="" title="{$BVS_LANG.lblEstMap}" class="textEntry superTextEntry" title="{$BVS_LANG.lblEstMap}" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow12').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow12_help">
                    <a href="javascript:showHideDiv('formRow12_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <div class="helpBG" id="formRow12_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow12_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                        <h2>{$BVS_LANG.help} - [908] {$BVS_LANG.lblEstMap}</h2>
                        <div class="help_message">{$BVS_LANG.helperEstMap}</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('estMap', 'superTextEntry2', '{$smarty.session.lang}');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                    {$BVS_LANG.btInsertRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {section name=iten loop=$titplus908}
            <div id="frDataFieldsEstMap{$smarty.section.iten.index}" class="frDataFields">
                <input type="text" name="field[estMap][]" id="estMap" value="{$titplus908[iten]}" title="{$BVS_LANG.lblEstMap}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow12').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsEstMap{$smarty.section.iten.index}');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {sectionelse}
            {if $titplus908}
            <div id="frDataFieldsestMapp" class="frDataFields">
                <input type="text" name="field[estMap][]" id="estMap" value="{$titplus908}" title="{$BVS_LANG.lblEstMap}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow12').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow12').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsestMapp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {/if}
            {/section}
            <div id="frDataFieldsestMap" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow13" class="formRow">
            <label for="ownClassif">{$BVS_LANG.lblOwnClassif}</label>
            <div class="frDataFields">
                <input type="text" name="ownClassif" id="ownClassif" value="" title="{$BVS_LANG.lblOwnClassif}" class="textEntry superTextEntry" title="{$BVS_LANG.lblOwnClassif}" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow13').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow13_help">
                    <a href="javascript:showHideDiv('formRow13_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <div class="helpBG" id="formRow13_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow13_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                        <h2>{$BVS_LANG.help} - [909] {$BVS_LANG.lblOwnClassif}</h2>
                        <div class="help_message">{$BVS_LANG.helperOwnClassif}</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('ownClassif', 'superTextEntry2', '{$smarty.session.lang}');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                    {$BVS_LANG.btInsertRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {section name=iten loop=$titplus909}
            <div id="frDataFieldsOwnClassif{$smarty.section.iten.index}" class="frDataFields">
                <input type="text" name="field[ownClassif][]" id="ownClassif" value="{$titplus909[iten]}" title="{$BVS_LANG.lblOwnClassif}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow13').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnClassif{$smarty.section.iten.index}');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {sectionelse}
            {if $titplus909}
            <div id="frDataFieldsownClassifp" class="frDataFields">
                <input type="text" name="field[ownClassif][]" id="ownClassif" value="{$titplus909}" title="{$BVS_LANG.lblOwnClassif}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow13').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow13').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnClassifp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {/if}
            {/section}
            <div id="frDataFieldsownClassif" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow14" class="formRow">
            <label for="ownDesc">{$BVS_LANG.lblOwnDesc}</label>
            <div class="frDataFields">
                <input type="text" name="ownDesc" id="ownDesc" value="" title="{$BVS_LANG.lblOwnDesc}" class="textEntry superTextEntry" title="{$BVS_LANG.lblOwnDesc}" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow14').className = 'formRow';" />
                <div id="categoryError" style="display: none;" class="inlineError">erro descricao.</div>
                <span id="formRow14_help">
                    <a href="javascript:showHideDiv('formRow14_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <div class="helpBG" id="formRow14_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow14_helpA');" title="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                        <h2>{$BVS_LANG.help} - [910] {$BVS_LANG.lblOwnDesc}</h2>
                        <div class="help_message">{$BVS_LANG.helperOwnDesc}</div>
                    </div>
                </div>
                <a href="javascript:InsertLineOriginal('ownDesc', 'superTextEntry2', '{$smarty.session.lang}');" class="singleButton okButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnInsertLine}" title="spacer" />
                    {$BVS_LANG.btInsertRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {section name=iten loop=$titplus910}
            <div id="frDataFieldsOwnDesc{$smarty.section.iten.index}" class="frDataFields">
                <input type="text" name="field[ownDesc][]" id="ownDesc" value="{$titplus910[iten]}" title="{$BVS_LANG.lblOwnDesc}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow14').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnDesc{$smarty.section.iten.index}');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {sectionelse}
            {if $titplus910}
            <div id="frDataFieldsownDescp" class="frDataFields">
                <input type="text" name="field[ownDesc][]" id="ownDesc" value="{$titplus910}" title="{$BVS_LANG.lblOwnDesc}" class="textEntry superTextEntry2" onfocus="this.className = 'textEntry superTextEntry2 textEntryFocus';document.getElementById('formRow14').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry2';document.getElementById('formRow14').className = 'formRow';" />
                <a href="javascript:removeRow('frDataFieldsOwnDescp');" class="singleButton eraseButton">
                    <span class="sb_lb">&#160;</span>
                    <img src="public/images/common/spacer.gif" alt="{$BVS_LANG.btnDeleteLine}" title="spacer" />{$BVS_LANG.btDeleteRecord}
                    <span class="sb_rb">&#160;</span>
                </a>
            </div>
            {/if}
            {/section}
            <div id="frDataFieldsownDesc" style="display:block!important">&#160;</div>
            <div class="spacer">&#160;</div>
        </div>
    </div>

    <div class="formHead">
        <div id="formRow03" class="formRow">
            <label>{$BVS_LANG.lblCreatDate}</label>
            <div class="frDataFields">
                {if $titplus940[0]}{$titplus940[0]}{else}{$smarty.now|date_format:"%Y%m%d"}{/if}
                <input type="hidden" name="field[creatDate]" value='{if $titplus940[0]}{$titplus940[0]}{else}{$smarty.now|date_format:"%Y%m%d"}{/if}' class="textEntry superTextEntry"/>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label>{$BVS_LANG.lblModifDate}</label>
            <div class="frDataFields">
                {$smarty.now|date_format:"%Y%m%d"}
                <input type="hidden" name="field[modifDate]" value='{$smarty.now|date_format:"%Y%m%d"}' class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label>{$BVS_LANG.lblDataEntryCreat}</label>
            <div class="frDataFields">
                {if $titplus950[0]}{$titplus950[0]}{else}{$smarty.session.logged}{/if}
                <input type="hidden" name="field[dataEntryCreat]" value='{if $titplus950[0]}{$titplus950[0]}{else}{$smarty.session.logged}{/if}' class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow03" class="formRow">
            <label>{$BVS_LANG.lblDataEntryMod}</label>
            <div class="frDataFields">
                {$smarty.session.logged}
                <input type="hidden" name="field[dataEntryMod]" value="{$smarty.session.logged}" class="textEntry superTextEntry" />
            </div>
            <div class="spacer">&#160;</div>
        </div>

    </div>
</form>

<div class="formFoot">
    <div class="helper">
		{$BVS_LANG.helpGeneralTitlePlus}
    </div>
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