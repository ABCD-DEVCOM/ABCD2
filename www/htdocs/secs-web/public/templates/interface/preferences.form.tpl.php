{**geramos as variaveis com os valores de campos associados**}
{foreach key=k item=v from=$dataRecord}
      	{assign var="pref"|cat:$k value=$v}
{/foreach}

{if $smarty.session.logged eq $pref1[0]}
<form action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >

<div class="formHead">
	{if $smarty.get.edit}
	<input type="hidden" name="mfn" value="{$smarty.get.edit}"/>
	{/if}
	<input type="hidden" name="gravar" id="gravar" value="false"/>


	<div id="formRow02" class="formRow" >
		<label>{$BVS_LANG.lblPassword}</label>
		<div class="frDataFields">
			<input type="password" name="field[passwd]" id="passwd" value="" title="*  {$BVS_LANG.lblPassword}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow02').className = 'formRow';"  />
			<div class="helper">{$BVS_LANG.helperUserName}</div>
			<div id="passwdError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<div id="difPasswdError" style="display: none;" class="inlineError">{$BVS_LANG.difPass}</div>
			<span id="formRow02_help">
				<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow02_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [3] {$BVS_LANG.lblPassword}</h2>
				<div class="help_message">
					{$BVS_LANG.helpPassword}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow03" class="formRow">
		<label>{$BVS_LANG.lblcPassword}</label>
		<div class="frDataFields">
			<input type="password" name="cpasswd" id="cpasswd" value="" title="*  {$BVS_LANG.lblcPassword}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow03').className = 'formRow'; " />
			<div class="helper">{$BVS_LANG.helperUserName}</div>
			<div id="cpasswdError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow03_help">
				<a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow03_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow03_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [3] {$BVS_LANG.lblcPassword}</h2>
				<div class="help_message">
					{$BVS_LANG.helpcPassword}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>


</div>
<div class="formContent">
	<div id="formRow06" class="formRow">
		<label>{$BVS_LANG.lblFullname}</label>
		<div class="frDataFields">
			<input type="text" name="field[fullname]" id="fullname" value="{$pref8[0]}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow06').className = 'formRow';" />
			<div id="fullnameError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow06_help">
				<a href="javascript:showHideDiv('formRow06_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow06_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow06_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [8] {$BVS_LANG.lblFullname}</h2>
				<div class="help_message">
					{$BVS_LANG.helpFullname}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow04" class="formRow">
		<label>{$BVS_LANG.lblEmail}</label>
		<div class="frDataFields">
			<input name="field[email]" id="email" value="{$pref11[0]}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow04').className = 'formRow';" />
			<div id="emailError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow04_help">
				<a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow04_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [11] {$BVS_LANG.lblEmail}</h2>
				<div class="help_message">
					{$BVS_LANG.helpEmail}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
    
	<div id="formRow01" class="formRow" >
		<label>{$BVS_LANG.lang}</label>
		<div class="frDataFields">
            {if $BVS_LANG.metaLanguage neq "pt"}<a href="?lang=pt&amp;m=preferences&amp;edit={$smarty.session.mfn} changeLanguage('pt','3');" target="_self">{$BVS_LANG.portuguese}</a> |{/if}
            {if $BVS_LANG.metaLanguage neq "en"}<a href="?lang=en&amp;m=preferences&amp;edit={$smarty.session.mfn} changeLanguage('en','3');" target="_self">{$BVS_LANG.english}</a> | {/if}
            {if $BVS_LANG.metaLanguage neq "es"}<a href="?lang=es&amp;m=preferences&amp;edit={$smarty.session.mfn} changeLanguage('es','3');" target="_self">{$BVS_LANG.espanish}</a> | {/if}
            {if $BVS_LANG.metaLanguage neq "fr"}<a href="?lang=fr&amp;m=preferences&amp;edit={$smarty.session.mfn} changeLanguage('fr','3');" target="_self">{$BVS_LANG.french}</a>{/if}
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow01_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - {$BVS_LANG.lang}</h2>
				<div class="help_message">
					{$BVS_LANG.helpLang}
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