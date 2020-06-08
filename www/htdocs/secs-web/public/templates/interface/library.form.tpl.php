{if $smarty.session.role eq "Administrator"}
{**geramos as variaveis com os valores de campos associados**}
{foreach key=k item=v from=$dataRecord}
      {assign var="libra"|cat:$k value=$v}
{/foreach}
<form action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >	

<div class="formHead">
	{if $smarty.get.edit}
   	<input type="hidden" name="mfn" value="{if $smarty.get.edit}{$smarty.get.edit}{else}New{/if}"/>
	{/if}
	<input type="hidden" name="gravar" id="gravar" value="false"/>

	<div id="formRow01" class="formRow">
		<label>{$BVS_LANG.lblLibFullname}</label>
		<div class="frDataFields">
        
			<input  type="text" name="field[fullname]" id="fullname" value="{$libra2[0]}" title="* {$BVS_LANG.lblLibFullname}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow01').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow01').className = 'formRow';"  />
			<div class="helper">{$BVS_LANG.helperFullname}</div>
			<div id="fullnameError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow01_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [2] {$BVS_LANG.lblLibFullname}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibFullname}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
    
	<div id="formRow02" class="formRow">
		<label>{$BVS_LANG.lblLibCode}</label>
		<div class="frDataFields">
			<input  type="text" name="field[code]" id="code" value="{$libra1[0]}" {if $smarty.get.edit}readonly="readonly"{/if} title="{$BVS_LANG.lblLibCode}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow01').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow01').className = 'formRow';"  />
			<div class="helper">{$BVS_LANG.helperLibCode}</div>
			<div id="codeError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
            <div id="spaceNotAllowedError" style="display: none;" class="inlineError">{$BVS_LANG.spaceNotAllowedError}</div>
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow02_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [1] {$BVS_LANG.lblLibCode}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibCode}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow05" class="formRow">
		<label>{$BVS_LANG.lblInstitution}</label>
		<div class="frDataFields">
			<input type="text" name="field[institution]" id="institution" value="{$libra9[0]}" title="{$BVS_LANG.lblInstitution}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow06').className = 'formRow';" />
			<div class="helper">{$BVS_LANG.helperLibCode}</div>
            <div id="institutionError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow05_help">
				<a href="javascript:showHideDiv('formRow05_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow05_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow05_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [9] {$BVS_LANG.lblInstitution}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibInstitution}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
    
	<div id="formRow08" class="formRow" >
		<label>{$BVS_LANG.lblAddress}</label>
		<div class="frDataFields">
			<input type="text" name="field[address]" id="address" value="{$libra3[0]}" title="*  {$BVS_LANG.lblAddress}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';"  />
			<div class="helper">{$BVS_LANG.helperAddress}</div>
			<div id="addressError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow08_help">
				<a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow08_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [3] {$BVS_LANG.lblAddress}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibAddress}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow07" class="formRow">
		<label>{$BVS_LANG.lblCity}</label>
		<div class="frDataFields">
			<input type="text" name="field[city]" id="city" value="{$libra4[0]}" title="*  {$BVS_LANG.lblCity}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow07').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow07').className = 'formRow';" />
			<div class="helper">{$BVS_LANG.helperCity}</div>
			<div id="cityError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow07_help">
				<a href="javascript:showHideDiv('formRow07_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow07_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow07_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [4] {$BVS_LANG.lblCity}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibCity}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow03" class="formRow">
		<label>{$BVS_LANG.lblCountry}</label>
		<div class="frDataFields">
			<input type="text" name="field[country]" id="country" value="{$libra5[0]}" title="*  {$BVS_LANG.lblCountry}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow03').className = 'formRow'; " />
			<div class="helper">{$BVS_LANG.helperCountry}</div>
			<div id="countryError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow03_help">
				<a href="javascript:showHideDiv('formRow03_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow03_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [5] {$BVS_LANG.lblCountry}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibCountry}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow04" class="formRow">
		<label>{$BVS_LANG.lblPhone}</label>
		<div class="frDataFields">
			<input type="text" name="field[phone]" id="phone"
                               value="{$libra6[0]}" title="{$BVS_LANG.lblPhone}"
                               class="textEntry superTextEntry"
                               onfocus="this.className = 'textEntry superTextEntry textEntryFocus';
                               document.getElementById('formRow03').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry superTextEntry';
                               document.getElementById('formRow03').className = 'formRow';"
                               onkeyup="validatePhone(this);"/>
			<div class="helper">{$BVS_LANG.helperPhone}</div>
			<div id="phoneError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow04_help">
				<a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow04_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [6] {$BVS_LANG.lblPhone}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibPhone}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

 	<div id="formRow10" class="formRow">
		<label>{$BVS_LANG.lblContact}</label>
		<div class="frDataFields">
			<input type="text" name="field[contact]" id="contact" value="{$libra7[0]}" title="*  {$BVS_LANG.lblContact}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow03').className = 'formRow'; " />
			<div class="helper">{$BVS_LANG.helperContact}</div>
			<div id="contactError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow10_help">
				<a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow10_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [7] {$BVS_LANG.lblContact}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibContact}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>


	
	<div id="formRow06" class="formRow">
		<label>{$BVS_LANG.lblNote}</label>
		<div class="frDataFields">
            <textarea name="field[note]" id="note" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow06').className = 'formRow';" >
			{$libra10[0]}</textarea>
			<div id="noteError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow06_help">
				<a href="javascript:showHideDiv('formRow06_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow06_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow06_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [10] {$BVS_LANG.lblNote}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibNote}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow11" class="formRow">
		<label>{$BVS_LANG.lblEmail}</label>
		<div class="frDataFields">
			<input name="field[email]" id="email" value="{$libra11[0]}" 
                               class="textEntry superTextEntry"
                               onfocus="this.className = 'textEntry superTextEntry textEntryFocus';
                               document.getElementById('formRow04').className = 'formRow formRowFocus';"
                               onblur="this.className = 'textEntry superTextEntry';
                               document.getElementById('formRow04').className = 'formRow';" />
			<div id="emailError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow04_help">
				<a href="javascript:showHideDiv('formRow11_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow11_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow11_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [11] {$BVS_LANG.lblEmail}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLibEmail}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

</div>
</form>
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