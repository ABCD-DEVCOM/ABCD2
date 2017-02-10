<div class="loginForm">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	<div class="boxContent">
	<form action="?action=signin&amp;lang={if $smarty.get.lang eq ''}{$BVS_LANG.LANGCODE}{else}{$BVS_LANG.metaLanguage}{/if}" enctype="multipart/form-data" name="formData" id="formData" class="form"  method="post">
		<input type="hidden" name="field[action]" id="action" value="do" />
		<div class="formRow">
			<label for="user">{$BVS_LANG.lblUsername}</label>
			<input type="text" name="field[username]" id="user" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry';" />
		</div>
		<div class="formRow">
			<label for="pwd">{$BVS_LANG.lblPassword}</label>
			<input type="password" name="field[password]" id="pwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry'; document.getElementById('selLibrary').focus();" />
		</div>
 		<div class="formRow">
			<label>{$BVS_LANG.library}</label>
            <select name="field[selLibrary]" id="selLibrary" title="{$BVS_LANG.lblLibrary}" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry'; document.getElementById('btLogin').focus();">
                <option value="" label="{$BVS_LANG.optSelValue}">{$BVS_LANG.optSelValue}</option>
                {html_options values=$codesLibrary selected=$collectionLibrary.$defaultLib output=$collectionLibrary}
            </select>
		</div>
		<div class="submitRow">
			<!--
			<div class="frLeftColumn">
				<div style="white-space: nowrap;">
					<input type="checkbox" name="setCookie" id="setCookie" value="yes" />
					<label for="setCookie" class="inline">{$BVS_LANG.lblKeepMeSigned}</label>
				</div>
				<a href="#">{$BVS_LANG.lblForgetMyPassword}?</a>
			</div>
			-->
			<div class="frRightColumn">
				<a href="javascript:doit('formData');" class="defaultButton goButton" id="btLogin">
					<img src="public/images/common/spacer.gif" alt="" title="" />
					<span><strong>{$BVS_LANG.lblLogIn}</strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="spacer">&#160;</div>
	</form>
	</div>
	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
</div>