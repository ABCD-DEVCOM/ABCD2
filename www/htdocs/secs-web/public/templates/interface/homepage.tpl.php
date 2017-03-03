<script type="text/javascript">
{assign var="i" value=0}
    var optControlAccess = new Array();
    {foreach from=$BVS_LANG.optControlAccess key=t item=y}
    optControlAccess[{$i}] = new Array('{$t}','{$y}');
    {assign var="i" value=$i+1}
    {/foreach}

</script>

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>

        <div class="boxContent titleSection">
            <div class="sectionIcon">&#160;</div>
            <div class="sectionTitle">
                <h4>{$BVS_LANG.lblManagerOf}<strong>
                    {if $smarty.session.role eq "Administrator"}{$BVS_LANG.lblTitleFacic}{/if}
                    {if $smarty.session.role eq "EditorOnly" || $smarty.session.role eq "AdministratorOnly" || $smarty.session.role eq "Editor"}{$BVS_LANG.lblTitle}{/if}
                    {if $smarty.session.role eq "Operator"}{$BVS_LANG.lblTitlePlusFacic}{/if}
                </strong></h4>
                <span>{$BVS_LANG.lblTotalOf} <strong>{$totalTitleRecords}</strong> {$BVS_LANG.lblTitleRegister}</span>
            </div>
            <div class="sectionButtons">
                <div class="searchTitles">
                    <form id="searchTitlesForm" action="{$smarty.server.PHP_SELF}?m=title" method="post">
                        <div class="stInput">
                            <label for="searchExpr">{$BVS_LANG.lblTypeTitle}</label>
                            <input type="text" name="searchExpr" id="searchExpr" value="" class="textEntry" />
                            <select name="indexes" class="textEntry">
                                {html_options options=$BVS_LANG.optIndexesTitle}
                            </select>
				<span id="formRow01_help">
                                    <a href="javascript:showHideDiv('formRow01_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
				</span>
                        </div>
                        <a href="javascript:void(0);" class="defaultButton searchButton" onclick="doit('searchTitlesForm');">
                            <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                            <span><strong>{$BVS_LANG.lblSearch} </strong></span>
                        </a>
                    </form>
                </div>
                <a href="?m=title" class="defaultButton multiLine listButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblList}</strong> {$BVS_LANG.lblTitle}</span>
                </a>
                {if $smarty.session.role eq "Administrator"}
                <a href="?m=title&amp;action=new" class="defaultButton multiLine newButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblNew}</strong>{$BVS_LANG.lblTitle}</span>
                </a>
                {/if}
            </div>
            <div class="spacer">&#160;</div>
        </div>

        <div class="boxBottom">
            <div class="bbLeft">&#160;</div>
            <div class="bbRight">&#160;</div>
        </div>
	</div>
	
	{if $smarty.session.role eq "Administrator" || $smarty.session.role eq "Editor" || $smarty.session.role eq "EditorOnly"}
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>
        <div class="boxContent titlePlusSection">
            <div class="sectionIcon">&#160;</div>
            <div class="sectionTitle">
                <h4>{$BVS_LANG.lblManagerOf}<strong>{if $smarty.session.role eq "Editor"}{$BVS_LANG.lblTitlePlusFacic}{else}{$BVS_LANG.lblTitlePlusFacic}{/if}</strong></h4>
                <span>{$BVS_LANG.lblTotalOf} <strong>{$totalTitlePlusRecords}</strong> {$BVS_LANG.lblTitleRegister}</span>
            </div>
            <div class="sectionButtons">
                 <div class="searchTitles">
                        <div class="stInput">
                            <label for="searchExpr">{$BVS_LANG.lblTypeTitle}</label>
                            <input type="text" id="freeText" name="freeText" style="display:block;" class="textEntry" />
                            <select id="AcquisitionMethod" style="display:none;" class="textEntry superTextEntry">
                                {html_options options=$BVS_LANG.optAcquisitionMethod}
                            </select>
                            <select id="AcquisitionControl" style="display:none;" class="textEntry superTextEntry">
                                {html_options options=$BVS_LANG.optAcquisitionControl}
                            </select>
                            <select id="AcquisitionPriority" style="display:none;" class="textEntry superTextEntry">
                                {html_options options=$BVS_LANG.optAcquisitionPriority}
                            </select>
                            <form id="searchTitlePlusForm" action="{$smarty.server.PHP_SELF}?" method="get">
                                <input type="hidden" name="m" id="m" value="titleplus" class="textEntry" />
                                <input type="hidden" name="searchExpr" id="searchExpr" value="" class="textEntry" />
                                <select name="indexes" id="indexes" class="textEntry" onchange="checkSelection();">
                                    {html_options options=$BVS_LANG.optIndexesTitlePlus}
                                </select>
				<span id="formRow02_help">
                                    <a href="javascript:showHideDiv('formRow02_helpA')"><img src="public/images/common/icon/helper_bg.png" title="{$BVS_LANG.help}" alt="{$BVS_LANG.help}"/></a>
				</span>

                            </form>
                        </div>
                        <a href="javascript:void(0);" class="defaultButton searchButton" onclick="changeVal('freeText'); doit('searchTitlePlusForm');">
                            <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                            <span><strong>{$BVS_LANG.lblSearch}</strong></span>
                        </a>
                     
                </div>
                <a href="?m=titleplus" class="defaultButton multiLine listButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblList}</strong> {$BVS_LANG.titlePlus} </span>
                </a>
                <!--a href="?m=title&amp;titleplus=new" class="defaultButton multiLine newButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblNew2}</strong> {$BVS_LANG.titlePlus} </span>
                </a-->
            </div>
            <div class="spacer">&#160;</div>
            </div>
            
            <div class="boxBottom">
                <div class="bbLeft">&#160;</div>
                <div class="bbRight">&#160;</div>
            </div>
    </div>
	{/if}

	{if $smarty.session.role eq "Administrator" || $smarty.session.role eq "AdministratorOnly"}
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>

	<div class="boxContent maskSection">
		<div class="sectionIcon">
			&#160;
		</div>
		<div class="sectionTitle">
			<h4>{$BVS_LANG.lblManagerOf} <strong>  {$BVS_LANG.lblMasks} </strong></h4>
			<span>{$BVS_LANG.lblTotalOf} <strong>{$totalMaskRecords}</strong> {$BVS_LANG.lblMasks2}  </span>
		</div>
		<div class="sectionButtons">
			<a href="?m=mask" class="defaultButton listButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><strong>{$BVS_LANG.lblList}</strong> {$BVS_LANG.lblMasks}</span>
			</a>
			<a href="?m=mask&amp;action=new" class="defaultButton multiLine newButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span><strong>{$BVS_LANG.lblNew2}</strong> {$BVS_LANG.lblMask}</span>
			</a>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
	</div>
	{/if}
	
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	
	<div class="boxContent toolSection">
		<div class="sectionIcon">&#160;</div>
		<div class="sectionTitle">
			<h4>&#160;<strong>{$BVS_LANG.lblUtility}</strong></h4>
		</div>
		
			<div class="sectionButtons">
			{if $smarty.session.role eq "Administrator" || $smarty.session.role eq "AdministratorOnly"}
			<a href="?m=users" class="defaultButton multiLine userButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span>{$BVS_LANG.lblAdmUsers}</span>
			</a>
			<a href="?m=library" class="defaultButton multiLine libraryButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span>{$BVS_LANG.lblAdmLibrary}</span>
			</a>
            <!--a href="javascript: EmDesenvolvimento('{$smarty.session.lang}');" class="defaultButton multiLine importButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span><strong>{$BVS_LANG.lblImport}</strong>{$BVS_LANG.lblTitle2}</span>
			</a-->
			{/if}
			<a href="?m=report" class="defaultButton multiLine reportButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span>{$BVS_LANG.lblServReport}</span>
			</a>
			<a href="?m=maintenance" class="defaultButton multiLine databaseMaintenceButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="Em desenvolvimento" title="Em desenvolvimento" />
				<span>{$BVS_LANG.lblServMaintance}</span>
			</a>
		</div>
		
		<div class="spacer">&#160;</div>
	</div>

	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
	</div>

	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>
	<div class="boxContent helpSection">
		<div class="sectionIcon">
			&#160;
		</div>
		<div class="sectionTitle">
			<h4>&#160;<strong>{$BVS_LANG.lblHelp}</strong></h4>
		</div>
		<div class="sectionButtons">
			<a href="javascript: showMessage('{$smarty.session.lang}');" class="defaultButton multiLine pdfButton">
				<img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
				<span>{$BVS_LANG.lblRead} <strong>{$BVS_LANG.lblManual}</strong></span>
			</a>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="boxBottom">
		<div class="bbLeft">&#160;</div>
		<div class="bbRight">&#160;</div>
	</div>
            
        <div class="helpBG" id="formRow01_helpA" style="display: none;">
            <div class="helpArea">
                    <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                    <h2>{$BVS_LANG.help} - {$BVS_LANG.field} {$BVS_LANG.lblSearchTitle}</h2>
                    <div class="help_message">
                        {$BVS_LANG.helpSearchTitle}
                    </div>
            </div>
        </div>
        <div class="helpBG" id="formRow02_helpA" style="display: none;">
            <div class="helpArea">
                    <span class="exit"><a href="javascript:showHideDiv('formRow02_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
                    <h2>{$BVS_LANG.help} - {$BVS_LANG.field} {$BVS_LANG.lblSearchTitlePlus}</h2>
                    <div class="help_message">
                        {$BVS_LANG.helpSearchTitlePlus}
                    </div>
            </div>
        </div>
</div>