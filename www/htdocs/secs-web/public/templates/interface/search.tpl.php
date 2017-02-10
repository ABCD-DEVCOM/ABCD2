<div class="searchBox">

    {if $smarty.get.m ne "facic"}
		
		{if $smarty.get.m eq 'mask'}
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="{if $smarty.get.m}{$smarty.get.m}{/if}"/>
                <label for="searchExpr"><strong>{$BVS_LANG.titleSearch}</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="{if $searcExpr}{$searcExpr}{else}${/if}" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    {html_options options=$BVS_LANG.optIndexesMask}
                </select>
                <input type="button" name="ok" value="{$BVS_LANG.btSearch}" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <span class="helper">{$BVS_LANG.helperSearch}</span>
            </form>
        
		{elseif $smarty.get.m eq 'title'}
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="{if $smarty.get.m}{$smarty.get.m}{/if}"/>
                <label for="searchExpr"><strong>{$BVS_LANG.titleSearch}</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="{if $searcExpr}{$searcExpr}{else}${/if}" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    {html_options options=$BVS_LANG.optIndexesTitle}
                </select>
                <input type="button" name="ok" value="{$BVS_LANG.btSearch}" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <span class="helper">{$BVS_LANG.helperSearch}</span>
            </form>

		{elseif $smarty.get.m eq 'users'}
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="{if $smarty.get.m}{$smarty.get.m}{/if}"/>
                <label for="searchExpr"><strong>{$BVS_LANG.titleSearch}</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="{if $searcExpr}{$searcExpr}{else}${/if}" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    {html_options options=$BVS_LANG.optIndexesUsers}
                </select>
                <input type="button" name="ok" value="{$BVS_LANG.btSearch}" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <span class="helper">{$BVS_LANG.helperSearch}</span>
            </form>

		{elseif $smarty.get.m eq 'titleplus'}
             <form action="?" class="form" id="searchTitlePlusForm" method="get">
                <input type="hidden" name="m" value="{if $smarty.get.m}{$smarty.get.m}{/if}"/>
                <label><strong>{$BVS_LANG.titleSearch}</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="{if $searcExpr}{$searcExpr}{else}${/if}" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

                <select id="AcquisitionMethod" style="display:none;" class="textEntry">
                    {html_options values=$BVS_LANG.optValAcq output=$BVS_LANG.optAcquisitionMethod}
                </select>
                <select id="AcquisitionControl" style="display:none;" class="textEntry">
                    {html_options values=$BVS_LANG.optValAcq output=$BVS_LANG.optAcquisitionControl}
                </select>
                <select id="AcquisitionPriority" style="display:none;" class="textEntry">
                    {html_options values=$BVS_LANG.optValAcq2 output=$BVS_LANG.optAcquisitionPriority}
                </select>
                <select name="indexes" id="indexes" class="textEntry" onchange="checkSelection('2');">
                    {html_options options=$BVS_LANG.optIndexesTitlePlus}
                </select>
                <input type="button" name="ok" value="{$BVS_LANG.btSearch}" class="submit" onclick="changeVal('searchExpr'); doit('searchTitlePlusForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <span class="helper">{$BVS_LANG.helperSearch}</span>
            </form>


		{elseif $smarty.get.m eq 'library'}
            <form action="?" class="form" id="searchForm" method="get">
                <input type="hidden" name="m" value="{if $smarty.get.m}{$smarty.get.m}{/if}"/>
                <label for="searchExpr"><strong>{$BVS_LANG.titleSearch}</strong></label>
                <input type="text" name="searchExpr" id="searchExpr" value="{if $searcExpr}{$searcExpr}{else}${/if}" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />
                <select name="indexes" class="textEntry">
                    {html_options options=$BVS_LANG.optIndexesLibrary}
                </select>
                <input type="button" name="ok" value="{$BVS_LANG.btSearch}" class="submit" onclick="doit('searchForm');"/>
                <span id="formRow01_help">
                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
                </span>
                <span class="helper">{$BVS_LANG.helperSearch}</span>
            </form>
		{/if}
        
    {/if}

</div>