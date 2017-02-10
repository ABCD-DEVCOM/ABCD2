<form id="facicForm" class="form">

    <input type="hidden" id="formFacic_recordId" value="" />
    <div class="formHead">
	{if $dataRecord}
            <h4>{$BVS_LANG.btEdFasc}{$editRequest}</h4>
	{else}
            <h4>{$BVS_LANG.btAddFasc}{$editRequest}</h4>
	{/if}

	<div id="formRowShortcut" class="formRow">
            <div class="fieldBlock">
                {if $OBJECTS_TITLE.pubTitle}
                    <label><strong>{$BVS_LANG.lblpublicationTitle}</strong></label>
                    <div class="frDataFields">{$OBJECTS_TITLE.pubTitle}</div>
                {/if}
                {if $OBJECTS_TITLE.ISSN}
                    <label><strong>{$BVS_LANG.lblissn}</strong></label>
                    <div class="frDataFields">{$OBJECTS_TITLE.ISSN}</div>
                {/if}
                {if $OBJECTS_TITLE.issnOnline}
                    <label><strong>{$BVS_LANG.lblissnOnline}</strong></label>
                    <div class="frDataFields">{$OBJECTS_TITLE.issnOnline}</div>
                {/if}
                {if $OBJECTS_TITLE.abrTitle}
                    <label><strong>{$BVS_LANG.lblabbreviatedTitle}</strong></label>
                    <div class="frDataFields">{$OBJECTS_TITLE.abrTitle}</div>
                {/if}
                <div class="spacer">&#160;</div>
            </div>
	</div>

        <div id="formRow01" class="formRow">

            <div class="fieldBlock">
                <label><strong>{$BVS_LANG.lblYear}&nbsp;</strong></label>
                <input type="text" name="field[year]" id="formFacic_year" value="{if $dataRecord.911}{$dataRecord.911}{elseif $newDataRecord.year}{$newDataRecord.year}{else}{$smarty.get.yearFacic}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <div class="helpBG" id="formRow01_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [911] {$BVS_LANG.lblYear}</h2>
                        <div class="help_message">{$BVS_LANG.helpFacicYear}</div>
                    </div>
                </div>
                <div class="frDataFields">
                    <label><strong>{$BVS_LANG.lblVol}&nbsp;</strong></label>
                    <input type="text" name="field[volume]" id="formFacic_volume" value="{if $dataRecord.912}{$dataRecord.912}{else}{$newDataRecord.volume}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                    <span id="formRow02_help">
                            <a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                    </span>
                    <div class="helpBG" id="formRow02_helpA" style="display: none;">
                        <div class="helpArea">
                            <span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                            <h2>{$BVS_LANG.help} - [912] {$BVS_LANG.lblVol}</h2>
                            <div class="help_message">{$BVS_LANG.helpFacicVol}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fieldBlock">
                <label><strong>{$BVS_LANG.facic}</strong></label>
                <div class="frDataFields">
                        <input type="text" name="field[issue]" id="formFacic_issue" value="{if $dataRecord.913}{$dataRecord.913}{else}{$newDataRecord.number}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                        <span id="formRow03_help">
                            <a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                        </span>
                        <div class="helpBG" id="formRow03_helpA" style="display: none;">
                            <div class="helpArea">
                                <span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                                <h2>{$BVS_LANG.help} - [913] {$BVS_LANG.facic}</h2>
                                <div class="help_message">
                                        {$BVS_LANG.helpFacicName}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="spacer">&#160;</div>
            </div>
		
            <div class="fieldBlock">
                <label><strong>{$BVS_LANG.mask}</strong></label>
                <div class="frDataFields">
                    <select  id="formFacic_mask" name="field[codeNameMask]" class="smallTextEntry">
                        {if $dataRecord.910}
                            {html_options values=$collectionMask output=$collectionMask selected=$dataRecord.910}
                        {else}
                            {html_options values=$collectionMask output=$collectionMask selected=$newDataRecord.codeNameMask}
                        {/if}
                    </select>
                    <span id="formRow04_help">
                        <a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                    </span>
                    <div class="helpBG" id="formRow04_helpA" style="display: none;">
                        <div class="helpArea">
                            <span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                            <h2>{$BVS_LANG.help} - [910] {$BVS_LANG.mask}</h2>
                            <div class="help_message">{$BVS_LANG.helpFacicMask}</div>
                        </div>
                    </div>
                </div>
                <div class="spacer">&#160;</div>
            </div>
		
            <div class="fieldBlock" >
                <label><strong>{$BVS_LANG.lblPubType}</strong></label>
                <div class="frDataFields">
                    <select name="field[literatureType]" id="formFacic_pubType" class="smallTextEntry">
                    {if $dataRecord.916}
                        {html_options options=$BVS_LANG.optPubType selected=$dataRecord.916}
                    {else}
                        {html_options options=$BVS_LANG.optPubType selected=$newDataRecord.publicationType}
                    {/if}
                    </select>
                    <span id="formRow05_help">
                        <a href="javascript:showHideDiv('formRow05_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                    </span>
                    <div class="helpBG" id="formRow05_helpA" style="display: none;">
                        <div class="helpArea">
                            <span class="exit"><a href="javascript:showHideDiv('formRow05_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                            <h2>{$BVS_LANG.help} - [916] {$BVS_LANG.lblPubType}</h2>
                            <div class="help_message">{$BVS_LANG.helpFacicPubType}</div>
                        </div>
                    </div>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div class="fieldBlock">
                <label><strong>{$BVS_LANG.lblPubSt}</strong></label>
                <div class="frDataFields">
                    <select name="field[status]" id="formFacic_status" class="smallTextEntry" onblur="selectNumOfCopys('status');">
                    {if $dataRecord.914}
                        {html_options options=$BVS_LANG.optPubSt selected=$dataRecord.914}
                    {else}
                        {html_options options=$BVS_LANG.optPubSt selected=$newDataRecord.status}
                    {/if}
                    </select>
                    <span id="formRow06_help">
                        <a href="javascript:showHideDiv('formRow06_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                    </span>
                    <div class="helpBG" id="formRow06_helpA" style="display: none;">
                        <div class="helpArea">
                            <span class="exit"><a href="javascript:showHideDiv('formRow06_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                            <h2>{$BVS_LANG.help} - [914] {$BVS_LANG.lblPubEst}</h2>
                            <div class="help_message">{$BVS_LANG.helpPubEst}</div>
                        </div>
                    </div>
                </div>
                <div class="spacer">&#160;</div>
            </div>

            <div class="fieldBlock">
                <label><strong>{$BVS_LANG.lblQtd}</strong></label>
                <div class="frDataFields">
                    <input type="text" name="field[quantity]" id="formFacic_quantity" value="{if $dataRecord.915}{$dataRecord.915}{else}{$newDataRecord.quantity}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                    <span id="formRow07_help">
                        <a href="javascript:showHideDiv('formRow07_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                    </span>
                    <div class="helpBG" id="formRow07_helpA" style="display: none;">
                        <div class="helpArea">
                            <span class="exit"><a href="javascript:showHideDiv('formRow07_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                            <h2>{$BVS_LANG.help} - [915] {$BVS_LANG.lblQtd}</h2>
                            <div class="help_message">{$BVS_LANG.helpQtd}</div>
                        </div>
                    </div>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
		
        <div id="formRow08" class="formRow">
            <label><strong>{$BVS_LANG.lblTextualDesignation|truncate:46:"..."}</strong></label>
            <div class="frDataFields">
                <input type="text" name="field[textualDesignation]" id="formFacic_textualDesignation" value="{if $dataRecord.925}{$dataRecord.925}{else}{$newDataRecord.textualDesignation}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                <span id="formRow08_help">
                    <a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>

                <div class="helpBG" id="formRow08_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [925] {$BVS_LANG.lblTextualDesignation}</h2>
                        <div class="help_message">{$BVS_LANG.helptextualDesignation}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow09" class="formRow">
            <label><strong>{$BVS_LANG.lblStandardizedDate}</strong></label>
            <div class="frDataFields">
                <input type="text" name="field[standardizedDate]" id="formFacic_standardizedDate" value="{if $dataRecord.926}{$dataRecord.926}{else}{$newDataRecord.standardizedDate}{/if}" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                <span id="formRow09_help">
                    <a href="javascript:showHideDiv('formRow09_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <div class="helpBG" id="formRow09_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow09_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [926] {$BVS_LANG.lblStandardizedDate}</h2>
                        <div class="help_message">{$BVS_LANG.helpstandardizedDate}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
		
        <!-- NAO DEIXAR ESPACO NEM QUEBRA DE LINHA ENTRE ESTE DOIS DIV A SEGUIR
            div id=template e div id=frDFRow_counter -->
        <div id="template">
            <div id="frDFRow_counter" class="formRow">
                <div class="frDataFields">
                    <input type="text" name="template_field[inventoryNumber][]" value="" id="template_formFacic_inventoryNumber_counter" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                    <span id="template_remove_counter">
                        <a href="javascript:removeFieldInventory('frDFRow_counter');" class="singleButton eraseButton">
                            <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" alt="spacer" title="" />{$BVS_LANG.btDeleteRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </span>
                    <span id="template_insert_counter">
                        <a href="javascript:insertFieldInventoryRepeat('frDFRowIns', '_NewCounter'); " class="singleButton okButton">
                            <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" alt="spacer" title="" />{$BVS_LANG.btInsertRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </span>
                </div>
                <div class="spacer">&#160;</div>
            </div>
        </div>
		
        <div id="formRow10" class="formRow">
            <label><strong>{$BVS_LANG.lblInventoryNumber}</strong></label>
            <div class="frDataFields">
                <input type="text" name="field[inventoryNumber][]" id="formFacic_inventoryNumber_0" value="" class="smallTextEntry" onfocus="this.className = 'textEntry smallTextEntry textEntryFocus';" onblur="this.className = 'smallTextEntry';" />
                <span id="formRow10_help">
                    <a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <span id="insert_0">
                    <a href="javascript:insertFieldInventoryRepeat('frDFRowIns', 1); "  class="singleButton okButton">
                        <span class="sb_lb">&#160;</span>
                        <img src="public/images/common/spacer.gif" alt="spacer" title="" />{$BVS_LANG.btInsertRecord}
                        <span class="sb_rb">&#160;</span>
                    </a>
                </span>
                <div class="helpBG" id="formRow10_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [917] {$BVS_LANG.lblInventoryNumber}</h2>
                        <div class="help_message">{$BVS_LANG.helpInventoryNumber}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="frDFRowIns"></div>
        <div id="formRow11" class="formRow">
            <label><strong>{$BVS_LANG.lblEAddress}</strong></label>
            <div class="frDataFields">
                <input type="text" name="field[eAddress]" id="formFacic_eAddress" value="{if $dataRecord.918}{$dataRecord.918}{else}{$newDataRecord.quantity}{/if}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow11').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow11').className = 'formRow';" />
                <span id="formRow11_help">
                        <a href="javascript:showHideDiv('formRow11_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <div class="helpBG" id="formRow11_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow11_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [918] {$BVS_LANG.lblEAddress}</h2>
                        <div class="help_message">{$BVS_LANG.helpEAddress}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div id="formRow12" class="formRow">
            <label><strong>{$BVS_LANG.lblNote}</strong></label>
            <div class="frDataFields">
                <textarea name="field[notes]" id="formFacic_notes" rows="4" cols="50" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow08').className = 'formRow';">{if $dataRecord.900}{$dataRecord.900}{else}{$newDataRecord.notes}{/if}</textarea>
                <span id="formRow12_help">
                    <a href="javascript:showHideDiv('formRow12_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <div class="helpBG" id="formRow12_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('formRow12_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - [900] {$BVS_LANG.lblNote}</h2>
                        <div class="help_message">{$BVS_LANG.helpFacicNote}</div>
                    </div>
                </div>
            </div>
            <div class="spacer">&#160;</div>
        </div>
        
</div>
</form>