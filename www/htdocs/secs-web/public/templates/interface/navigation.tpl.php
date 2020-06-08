<div class="sectionInfo">
    <div class="breadcrumb">
        {breadcrumb total=$totalRecords}
    </div>
	
	{if $smarty.session.identified}
		<div id="actionsButtons" class="actions">
		{if !isset($sMessage)}	
			{if $smarty.get.edit || $smarty.get.action}
				{if $smarty.get.m eq 'title'}
				<div id="BackNext" style="display:none">
                                    <a href="javascript: desligabloco2();" class="defaultButton multiLine nextButton">
                                        <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                        <span><strong>{$BVS_LANG.btNext}</strong> {$BVS_LANG.btStep}</span>
                                    </a>
				</div>
				{/if}
				<a href="javascript: submitForm('{$smarty.get.m}', '{$smarty.session.lang}');"  class="defaultButton saveButton" >
					<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="{$BVS_LANG.btSaveRecord}" />
					<span><strong>{$BVS_LANG.btSaveRecord}</strong></span>
				</a>

				<a href="javascript:cancelAction('?m={$listRequest}{if $titleCode}&amp;title={$titleCode}{/if}{if $smarty.get.searchExpr}&amp;searchExpr={$smarty.get.searchExpr}{/if}')" id="cancelButton" class="defaultButton cancelButton">
					<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="{$BVS_LANG.btCancelAction}" />
					<span><strong>{$BVS_LANG.btCancelAction}</strong></span>
				</a>
			{else}
				{if $smarty.get.m}
					{if $listRequestReport neq "report" && $smarty.get.m neq "facic" && $smarty.get.m neq "titleplus"}
						<!--a href="?m={$listRequest}{if $titleCode}&amp;title={$titleCode}{/if}&amp;action=new" class="defaultButton multiLine newButton" {if $titleCode} OnClick="javascript: desligabloco1();" {/if}-->
                                            {if $smarty.get.m eq "title"}
                                                {if $smarty.session.role eq "Administrator"}
                                                    <a href="?m={$listRequest}{if $titleCode}&amp;title={$titleCode}{/if}&amp;action=new" id="show" class="defaultButton multiLine newButton">
                                                        <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                        <span>{$BVS_LANG.btInsertRecord} {$BVS_LANG.$listRequest}</span>
                                                    </a>
                                                {/if}

                                                <a href="javascript: fullExportMenu('menuRegisters'); " id="show" class="defaultButton multiLine exportTitleButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.lblExportTitle}</span>
                                                </a>
                                                
                                                <a href="javascript: fullExportMenu('menuCatalog'); " id="show" class="defaultButton multiLine exportCatalogButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.lblExportCatalog}</span>
                                                </a>

                                            {else}
                                                <a href="?m={$listRequest}{if $titleCode}&amp;title={$titleCode}{/if}&amp;action=new" id="show" class="defaultButton multiLine newButton ">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.btInsertRecord} {$BVS_LANG.$listRequest}</span>
                                                </a>

                                            {/if}
					{elseif $smarty.get.m eq "facic"}
						
						<a id="saveFacic" href="#"  class="defaultButton saveButton" >
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="{$BVS_LANG.btSaveRecord}" />
                                                    <span><strong>{$BVS_LANG.btSaveRecord}</strong></span>
						</a>
						
						<a id="displayCollection" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.lblViewHldg}</span>
						</a>
						<a id="addRow" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.btInsertRecord}</span>
						</a>
						
						<a id="addRows" href="#" class="defaultButton multiLine newButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                                                    <span>{$BVS_LANG.lblInsertRange}</span>
						</a>

                                                <a href="javascript:cancelAction('?m={if $smarty.get.listRequest}{$smarty.get.listRequest}{else}title{/if}{if $smarty.get.searchExpr}&amp;searchExpr={$smarty.get.searchExpr}{/if}')" id="cancelButton" class="defaultButton cancelButton">
                                                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="{$BVS_LANG.btCancelAction}" />
                                                    <span><strong>{$BVS_LANG.btCancelAction}</strong></span>
                                                </a>

                                        {/if}
				{/if}
			{/if}
		{/if}
                {*if $smarty.get.m eq "titleplus"}
                        <a href="javascript: fullExportMenu('menuRegisters'); " id="show" class="defaultButton multiLine newButton">
                            <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                            <span>{$BVS_LANG.lblExportTitle}</span>
                        </a>

                        <a href="javascript: fullExportMenu('menuCatalog'); " id="show" class="defaultButton multiLine newButton">
                            <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />
                            <span>{$BVS_LANG.lblExportCatalog}</span>
                        </a>
                {/if*}
            {if $smarty.get.action eq "signin" || $smarty.get.m neq ""}
            {if $smarty.get.action neq "delete"}
                {if $smarty.get.m && $smarty.get.action }
                    {if $smarty.get.m neq "titleplus"}
                        <a href="?m={$smarty.get.m}" class="defaultButton multiLine backButton">
                   {else}
                        <a href="?m=title" class="defaultButton multiLine backButton">
                   {/if}
                {else}
                    {if $smarty.get.edit && $smarty.get.m neq "preferences"}
                       <a href="?m={$smarty.get.m}{if $smarty.get.searchExpr}&amp;searchExpr={$smarty.get.searchExpr}{/if}"  class="defaultButton multiLine backButton">
                    {else}
                        {if $smarty.get.m neq "facic"}
                            <a href="index.php" class="defaultButton multiLine backButton">
                        {else}
                           <a href="?m={if $smarty.get.listRequest}{$smarty.get.listRequest}{else}title{/if}" class="defaultButton multiLine backButton">
                        {/if}
                    {/if}
                {/if}
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="{$BVS_LANG.btSaveRecord}" />
                    <span><strong>{$BVS_LANG.btBackAction}</strong></span>
                </a>
            {/if}
            {/if}


             {if  $smarty.get.m eq "" && $smarty.session.optLibrary[1] neq ""}
             <div>
                <select name="role" id="role" title="{$BVS_LANG.lblRole}" style="display:none;">
                     {if $smarty.session.role eq "Administrator"}
                        <option value="{$smarty.session.role}" selected="selected">{$smarty.session.role}</option>
                     {else}
                        <option value="" label="{$BVS_LANG.optSelValue}" selected="selected">{$BVS_LANG.optSelValue}</option>
                        {html_options values=$smarty.session.optRole output=$smarty.session.optRole}
                     {/if}
                </select>
                <select name="library" id="library" title="{$BVS_LANG.lblLibrary}" class="textEntry" onchange="changeLib('{$smarty.session.lang}', '{$BVS_LANG.msgLibChange}');">
                    <option value="" label="{$BVS_LANG.optSelValue}">{$BVS_LANG.optSelValue}</option>
                    {html_options values=$smarty.session.optLibraryDir output=$smarty.session.optLibrary}
                </select>
            </div>
            {/if}


		</div>
    {/if}
	
	<div class="spacer">&#160;</div>

</div>
