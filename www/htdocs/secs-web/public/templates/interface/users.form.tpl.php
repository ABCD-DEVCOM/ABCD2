{**geramos as variaveis com os valores de campos associados**}
{foreach key=k item=v from=$dataRecord}
        {assign var="use"|cat:$k value=$v}
{/foreach}

{if $smarty.session.logged eq $use1[0] or $smarty.session.role eq "Administrator"}
<div class="yui-skin-sam">

<div id="collectionDialog" >
      <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
        <div id="collectionDisplayed"></div>
      </div>
    </div>
</div>
<script type="text/javascript">

YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
YAHOO.widget.DataTable.MSG_ERROR = "{$BVS_LANG.MSG_ERROR}";

{literal}
YAHOO.namespace("example.container");

function init() {
	var handleOK = function() {
		window.location.reload();
	};
        
	YAHOO.example.container.collectionDialog = new YAHOO.widget.Dialog("collectionDialog",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleOK } ]
							});

	YAHOO.example.container.collectionDialog.render();
}
YAHOO.util.Event.onDOMReady(init);
{/literal}
</script>

<div id="listRecords" class="listTable"></div>
<form action="{$smarty.server.PHP_SELF}?m={$smarty.get.m}&amp;edit=save" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post" >	

<div class="formHead">
	{if $smarty.get.edit}
	<input type="hidden" name="mfn" value="{$smarty.get.edit}"/>
	{/if}
	<input type="hidden" name="gravar" id="gravar" value="false"/>
        <input type="hidden"  name="myRole" id="myRole" value="{$smarty.session.role}"/>

	<div id="formRow01" class="formRow" {if $smarty.session.role neq "Administrator"}style="display: none;"{/if}>
		<label>{$BVS_LANG.lblUsername}</label>
		<div class="frDataFields">
			<input  type="text" name="field[username]" id="username" value="{$use1[0]}"  title="* {$BVS_LANG.lblUsername}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow01').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow01').className = 'formRow';"  />
			<div class="helper">{$BVS_LANG.helperUserName}</div>
			<div id="usernameError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow01_help">
				<a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow01_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [1] {$BVS_LANG.lblUsername}</h2>
				<div class="help_message">
					{$BVS_LANG.helpUser}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	
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

{if $smarty.get.edit neq 1}
<div id="formRow14" class="formRow" {if $smarty.session.role neq "Administrator"}style="display: none;"{/if}>
        <label for="role">{$BVS_LANG.lblRole}</label>
            <div class="frDataFields">
                <div class="frDFRow">
                    <div id="roleLib">
                        <!-- Role -->
                        <div class="frDFColumn">
                            <label class="inline">{$BVS_LANG.lblRole}</label><br/>
                            <select name="role" id="role" title="{$BVS_LANG.lblRole}" class="textEntry">
                                {html_options options=$BVS_LANG.optRole}
                            </select>
                            <a href="javascript:showHideDiv('formRow04_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help"/></a>
                        </div>
                        <!-- /Role -->
                        <!-- Library -->
                        <div class="frDFColumn">
                            <label class="inline">{$BVS_LANG.lblLibrary}</label><br/>
                            <select name="library" id="library" title="{$BVS_LANG.lblLibrary}" class="textEntry">
                                <option value="" label="{$BVS_LANG.optSelValue}" selected="selected">{$BVS_LANG.optSelValue}</option>
                                {html_options values=$codesLibrary output=$collectionLibrary}
                            </select>
                            <a href="javascript:showHideDiv('formRow05_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help"/></a>
                        </div>
                        <!-- /Library -->
                        <!-- Help -->
                        <div class="helpBG" id="formRow04_helpA" style="display: none;">
                            <div class="helpArea">
                                <span class="exit"><a href="javascript:showHideDiv('formRow04_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>
                                <h2>{$BVS_LANG.help} - [4] {$BVS_LANG.lblRole}</h2>
                                <div class="help_message">
                                    {$BVS_LANG.helpRole}
                                </div>
                            </div>
                        </div>
                        <div class="helpBG" id="formRow05_helpA" style="display: none;">
                            <div class="helpArea">
                                <span class="exit"><a href="javascript:showHideDiv('formRow05_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>
                                <h2>{$BVS_LANG.help} - [5] {$BVS_LANG.lblLibrary}</h2>
                                <div class="help_message">
                                    {$BVS_LANG.helpLibrary}
                                </div>
                            </div>
                        </div>
                        <!-- /Help -->
                        <div class="spacer">&#160;</div>
                        <a href="javascript:InsertLineSelect('role', 'library', '{$smarty.session.lang}');" class="singleButton okButton">
                            <span class="sb_lb">&#160;</span>
                            <img src="public/images/common/spacer.gif" title="spacer" />
                            {$BVS_LANG.btInsertRecord}
                            <span class="sb_rb">&#160;</span>
                        </a>
                    </div>
                </div>
            </div>
            {section name=iten loop=$use4}
            <div class="frDataFields">
                <div class="frDFRow">
                    <div id="roleLib">
                        <div id="frDataFieldsRole{$smarty.section.iten.index}" class="frDFColumn">
                            <input type="text" name="field[role][]" id="role" value="{$use4[iten]}" readonly="readonly" title="{$BVS_LANG.lblRole}" class="textEntry">
                        </div>
                        <div id="frDataFieldsLibrary{$smarty.section.iten.index}" class="frDFColumn">
                            <input type="text" name="field[library][]" id="library" value="{$use5[iten]}" readonly="readonly" title="{$BVS_LANG.lblLibrary}" class="textEntry" >
                            <input type="hidden" name="field[libraryDir][]" id="libraryDir" value="{$use6[iten]}" readonly="readonly">
                            <a href="javascript:removeRow('frDataFieldsRole{$smarty.section.iten.index}'); removeRow('frDataFieldsLibrary{$smarty.section.iten.index}');" class="singleButton eraseButton">
                                <span class="sb_lb">&#160;</span>
                                <img src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                                <span class="sb_rb">&#160;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {sectionelse}
                {if $use4}
                <div class="frDataFields">
                    <div class="frDFRow">
                        <div id="roleLib">
                            <div id="frDataFieldsrolep" class="frDFColumn">
                                <select name="field[role][]" id="role" readonly="readonly" title="{$BVS_LANG.lblRole}" class="textEntry">
                                    {html_options options=$BVS_LANG.optRole selected=$use4[iten]}
                                </select>
                            </div>
                            <div id="frDataFieldslibraryp" class="frDFColumn">
                                <select name="field[library][]" id="library" readonly="readonly" title="{$BVS_LANG.lblLibrary}" class="textEntry">
                                    {html_options options=$BVS_LANG.optRole selected=$use5[iten]}
                                </select>
                                <a href="javascript:removeRow('frDataFieldsLibraryp'); removeRow('frDataFieldsRolep');" class="singleButton eraseButton">
                                    <span class="sb_lb">&#160;</span>
                                    <img src="public/images/common/spacer.gif" title="spacer" />{$BVS_LANG.btDeleteRecord}
                                    <span class="sb_rb">&#160;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
            {/section}
            <div id="frDataFieldsrole" style="display:block!important">&#160;</div>
        <div class="spacer">&#160;</div>
    </div>
   <div class="spacer">&#160;</div>
{/if}


</div>
<div class="formContent">
	<div id="formRow06" class="formRow">
		<label>{$BVS_LANG.lblFullname}</label>
		<div class="frDataFields">
			<input type="text" name="field[fullname]" id="fullname" value="{$use8[0]}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow06').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow06').className = 'formRow';" />
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

	<div id="formRow07" class="formRow" {if $smarty.session.role neq "Administrator"}style="display: none;"{/if}>
		<label>{$BVS_LANG.lblUsersAcr}</label>
		<div class="frDataFields">
			<input type="text" name="field[userAcr]" id="userAcr" value="{$use2[0]}" title="*  {$BVS_LANG.lblUsersAcr}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow07').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow07').className = 'formRow';" />
			<div class="helper">{$BVS_LANG.helperUserName}</div>
			<div id="userAcrError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow07_help">
				<a href="javascript:showHideDiv('formRow07_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow07_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow07_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [2] {$BVS_LANG.lblUsersAcr}</h2>
				<div class="help_message">
					{$BVS_LANG.helpUsersAcr}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>


	<div id="formRow04" class="formRow" >
		<label>{$BVS_LANG.lblEmail}</label>
		<div class="frDataFields">
			<input name="field[email]" id="email" value="{$use11[0]}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow04').className = 'formRow';" />
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

   
	<div id="formRow08" class="formRow" {if $smarty.session.role neq "Administrator"}style="display: none;"{/if}>
		<label>{$BVS_LANG.lblInstitution}</label>
		<div class="frDataFields">
			<input type="text" name="field[institution]" id="institution" value="{$use9[0]}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';document.getElementById('formRow08').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry superTextEntry';document.getElementById('formRow08').className = 'formRow';" />
			<div class="helper">{$BVS_LANG.helperUserName}</div>
			<div id="institutionError" style="display: none;" class="inlineError">{$BVS_LANG.requiredField}</div>
			<span id="formRow08_help">
				<a href="javascript:showHideDiv('formRow08_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow08_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow08_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [9] {$BVS_LANG.lblInstitution}</h2>
				<div class="help_message">
					{$BVS_LANG.helpInstitution}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div id="formRow10" class="formRow" {if $smarty.session.role neq "Administrator"}style="display: none;"{/if}>
		<label>{$BVS_LANG.lblNotes}</label>
		<div class="frDataFields">
			<textarea name="field[notes]" id="notes" class="textEntry singleTextEntry" rows="4" cols="50" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow10').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow10').className = 'formRow';" >{$use10[0]}</textarea>
			<span id="formRow10_help">
				<a href="javascript:showHideDiv('formRow10_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}" /></a>
			</span>
		</div>
		<div class="helpBG" id="formRow10_helpA" style="display: none;">
			<div class="helpArea">
				<span class="exit"><a href="javascript:showHideDiv('formRow10_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" /></a></span>
				<h2>{$BVS_LANG.help} - [10] {$BVS_LANG.lblNotes}</h2>
				<div class="help_message">
					{$BVS_LANG.helpNotes}
				</div>
			</div>
		</div>
		<div class="spacer">&#160;</div>
	</div>

        {if $smarty.session.role neq "Administrator" or $smarty.get.edit eq 1}
    	<div id="formRow01" class="formRow" >
		<label>{$BVS_LANG.lang}</label>
		<div class="frDataFields">
                    {if $BVS_LANG.metaLanguage neq "pt"}<a href="#" onclick="changeLanguage('pt','3','{$smarty.session.mfn}');" target="_self">{$BVS_LANG.portuguese}</a> |{/if}
            {if $BVS_LANG.metaLanguage neq "en"}<a href="#" onclick="changeLanguage('en','3','{$smarty.session.mfn}');" target="_self">{$BVS_LANG.english}</a> | {/if}
            {if $BVS_LANG.metaLanguage neq "es"}<a href="#" onclick="changeLanguage('es','3','{$smarty.session.mfn}');" target="_self">{$BVS_LANG.espanish}</a> | {/if}
            {if $BVS_LANG.metaLanguage neq "fr"}<a href="#" onclick="changeLanguage('fr','3','{$smarty.session.mfn}');" target="_self">{$BVS_LANG.french}</a>{/if}
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
        {/if}
	
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