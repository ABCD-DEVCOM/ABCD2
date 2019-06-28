{if $smarty.session.role eq "Administrator"}
<form action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post">	
	<div class="formHead">
		{if $smarty.get.edit and $smarty.get.basedMask neq 'true'}
		<input type="hidden" name="mfn" value="{$smarty.get.edit}"/>
		{/if}
		<input type="hidden" id="gravar" name="gravar" value="false"/>
		<input type="hidden" name="field[database]" value="MASK"/>
		<input type="hidden" name="field[typeLiterature]" value="K"/>
		<input type="hidden" name="field[levelTreatment]" value="ks"/>
		<input type="hidden" name="field[codeCenter]" value="main"/>
		<input type="hidden" name="field[creationDate]" value="{$smarty.now|date_format:"%Y%m%d"}"/>
		{if $edit}
		<input type="hidden" name="field[ChangeDate]" value="{$smarty.now|date_format:"%Y%m%d"}"/>
		{/if}
		<input type="hidden" name="field[documentalistCreation]" value="DT"/>
		
		{if !$smarty.get.edit}
		<div id="formRow01" class="formRow">
			<label for="id">{$BVS_LANG.lblCopyMaskTo}</label>
			<div class="frDataFields">
				<select name="basedMask" id="basedMask" class="textEntry">
					<option value="{$mfnMask}" >{$BVS_LANG.lblNone}</option>
					{html_options options=$collectionMask}
				</select>
				<div id="basedMaskError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
				<span id="formRow01_help">
					<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
				</span>
				<a href="javascript: basedMask();  " class="singleButton okButton">
					<span class="sb_lb">&#160;</span>
					<img src="public/images/common/spacer.gif" alt="spacer" title="" />
					{$BVS_LANG.btInsertRecord}
					<span class="sb_rb">&#160;</span>
				</a>
				<div class="helpBG" id="formRow01_helpA" style="display: none;">
					<div class="helpArea">
						<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
						<h2>{$BVS_LANG.help} - {$BVS_LANG.field}</h2>
						<div class="help_message">
							{$BVS_LANG.helpBasedMask}
						</div>
					</div>
				</div>
			
			</div>
			<div class="spacer">&#160;</div>
		</div>
		{/if}
		
		<div id="formRow02" class="formRow">
			<label for="id">{$BVS_LANG.lblMaskName}</label>
			<div class="frDataFields">
				<input type="text" name="field[nameMask]" id="nameMask" {if $smarty.get.basedMask neq 'true'} value="{$dataRecord.801}" title="* {$BVS_LANG.lblMaskName}" {/if} {if $smarty.get.usedMask} disabled="true" {/if} class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';" />
				<div id="nameMaskError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
				<span id="formRow02_help">
					<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
				</span>
				<div class="helpBG" id="formRow02_helpA" style="display: none;">
					<div class="helpArea">
						<span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
						<h2>{$BVS_LANG.help} - [801] {$BVS_LANG.lblMaskName}</h2>
						<div class="help_message">
							{$BVS_LANG.helpMaskName}
						</div>
					</div>
				</div>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		
		<!--div id="formRow03" class="formRow">
			<label for="note">{$BVS_LANG.lblNotes}</label>
			<div class="frDataFields">
				<textarea name="field[notes]" id="note" class="textEntry singleTextEntry" rows="4" cols="50" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" >{if $smarty.get.basedMask neq 'true'}{$dataRecord.900}{/if}</textarea>
				<div id="noteError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
				<span id="formRow03_help">
					<a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
				</span>
			</div>
				<div class="helpBG" id="formRow03_helpA" style="display: none;">
					<div class="helpArea">
						<span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
						<h2>{$BVS_LANG.help} - [900] {$BVS_LANG.lblNotes}</h2>
						<div class="help_message">
							{$BVS_LANG.helpNotesMask}
						</div>
					</div>
				</div>
			<div class="spacer">&#160;</div>
		</div-->

		<div id="formRow03" class="formRow">
			<label for="notes">{$BVS_LANG.lblNotes}</label>
                                <div class="frDataFields">
                                    <input type="text" name="field[notes]" id="notes" value="" title="{$BVS_LANG.lblNotes}" class="textEntry singleTextEntry" title="Teste" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                                    <div id="categoryError" style="display: none;" class="inlineError">Defina um nome para a m�dia.</div>
                                    <span id="formRow03_help">
                                        <a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                                    </span>
                                    <div class="helpBG" id="formRow03_helpA" style="display: none;">
                                        <div class="helpArea">
                                            <span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                                            <h2>{$BVS_LANG.help} [140] {$BVS_LANG.lblNotes}</h2>
                                            <div class="help_message">{$BVS_LANG.helpNotesMask}</div>
                                        </div>
                                    </div>
                                    <a href="javascript:InsertLineOriginal('notes', 'singleTextEntry', '{$smarty.session.lang}');" class="singleButton okButton">
                                        <span class="sb_lb">&#160;</span>
                                        <img src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btInsertRecord}
                                        <span class="sb_rb">&#160;</span>
                                    </a>
                                </div>
				{section name=iten loop=$dataRecord.900}
                                    <div id="frDataFieldsnotes{$smarty.section.iten.index}" class="frDataFields">
                                        <input type="text" name="field[notes][]" id="notes" value="{$dataRecord.900[iten]}" title="{$BVS_LANG.lblNotes}" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                                        <a href="javascript:removeRow('frDataFieldsnotes{$smarty.section.iten.index}');" class="singleButton eraseButton">
                                            <span class="sb_lb">&#160;</span>
                                            <img src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                                            <span class="sb_rb">&#160;</span>
                                        </a>
                                    </div>
				{sectionelse}
                                    {if $dataRecord.900}
                                        <div id="frDataFieldsnotesp" class="frDataFields">
                                            <input type="text" name="field[notes][]" id="notes" value="{$dataRecord.900}" title="{$BVS_LANG.lblNotes}" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
                                            <a href="javascript:removeRow('frDataFieldsnotesp');" class="singleButton eraseButton">
                                                <span class="sb_lb">&#160;</span>
                                                <img src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                                                <span class="sb_rb">&#160;</span>
                                            </a>
                                        </div>
                                    {/if}
				{/section}
				<div id="frDataFieldsnotes" style="display:block!important">&#160;</div>
			<div class="spacer">&#160;</div>
		</div>
	</div>


	{if !$smarty.get.usedMask}
<script type="text/javascript">
lineCounter = {$dataRecord.860|@count};
</script>
	<div class="formContent">
		<div id="formRow04" class="formRow">
			<label>{$BVS_LANG.lblFrequency}</label>
			<div class="frDataFields">
				
				<div class="frDFRow">
					<div class="frDFColumn">
						<label for="volumes" class="inline">{$BVS_LANG.lblVolume}</label><br/>
						<select name="field[volumeType][]" id="volumes" class="textEntry">
							{html_options options=$BVS_LANG.optInfiniteFinite selected=$dataRecord.841[0]}
						</select>
						<div id="frequencyError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
						<span id="formRow04_help">
							<a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
						</span>
					</div>
					<div class="frDFColumn">
						<label for="nums" class="inline">{$BVS_LANG.lblNumber}</label><br/>
						<select name="field[volumeType][]" id="nums" class="textEntry">
							{html_options options=$BVS_LANG.optInfiniteFinite selected=$dataRecord.841[1]}
						</select>
						<div id="frequencyError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
						<span id="formRow05_help">
							<a href="javascript:showHideDiv('formRow05_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
						</span>
					</div>
					<div class="helpBG" id="formRow04_helpA" style="display: none;">
						<div class="helpArea">
							<span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
							<h2>{$BVS_LANG.help} - [860] {$BVS_LANG.lblVolume}</h2>
							<div class="help_message">
								{$BVS_LANG.helpVolume}
							</div>
						</div>
					</div>
					<div class="helpBG" id="formRow05_helpA" style="display: none;">
						<div class="helpArea">
							<span class="exit"><a href="javascript:showHideDiv('formRow05_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
							<h2>{$BVS_LANG.help} - [880] {$BVS_LANG.lblNumber}</h2>
							<div class="help_message">
								{$BVS_LANG.helpNumber}
							</div>
						</div>
					</div>

					<div class="frDFColumn">&#160;</div>
					<div class="spacer">&#160;</div>
				</div>

				<div id="template" class="frDFRow">
					<div class="frDFColumn">
						<input type="text" name="sequenceVolumesValue" value="" id="volumesIns" class="textEntry miniTextEntry" />
					</div>
					<div class="frDFColumn">
						<input type="text" name="numbersSequenceValue" value="" id="numsIns" class="textEntry miniTextEntry" />
						<a href="javascript:insertFieldMaskRepeat('frDFRowIns','{$BVS_LANG.btInsertRecord}','{$BVS_LANG.btDeleteRecord}');" class="singleButton okButton">
							<span class="sb_lb">&#160;</span>
							<img src="public/images/common/spacer.gif" alt="spacer" title="" />
							{$BVS_LANG.btInsertRecord}
							<span class="sb_rb">&#160;</span>
						</a>
					</div>
					<div class="spacer">&#160;</div>
				</div>

			{counter assign=contador start=0 skip=1}
			{foreach name=myvar2 item=myData from=$dataRecord.860}
			  {foreach name=myvar key=key item=item from=$myData}

				<div  class="frDFRow" id="frDFRow{$contador}">
					<div class="frDFColumn">
							<input type="text" name="field[sequenceVolumes][]" value="{$item}" id="volumesIns{$contador}" class="textEntry miniTextEntry" />
					</div>
					<div class="frDFColumn">
						<input type="text" name="field[numbersSequence][]"  value="{$dataRecord.880[$contador]}" id="numsIns{$contador}" class="textEntry miniTextEntry" />
							<a href="javascript:removeRow('frDFRow{$contador}');" class="singleButton eraseButton">
								<span class="sb_lb">&#160;</span>
								<img src="public/images/common/spacer.gif" alt="spacer" title="" />
								 {$BVS_LANG.btDeleteRecord}
								<span class="sb_rb">&#160;</span>
							</a>
					</div>
					<div class="spacer">&#160;</div>
				</div>
			  {/foreach}
			{counter}
			{/foreach}						

				<div id="frDFRowIns"></div>
			</div>
			
			<div class="spacer">&#160;</div>
		</div>	
	</div>
	{/if}	

</form>
{/if}