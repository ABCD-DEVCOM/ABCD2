<div class="footer">
	<div class="systemInfo">
		<strong>{$BVS_LANG.titleApp} v{$BVS_CONF.version}</strong>
		<span>&copy; {$BVS_CONF.copyright} - {$BVS_LANG.institutionName}</span>
		<a href="{$BVS_LANG.institutionURL}" target="_blank">{$BVS_LANG.institutionURL}</a>
	</div>
	<!--div class="distributorLogo">
		<a href="{$BVS_CONF.authorURI}" target="_blank"><span>{$BVS_CONF.metaAuthor}</span></a>
	</div-->
	<div class="spacer">&#160;</div>
</div>
{if $sMessage.success}
	{redirect_page time=3 get=$smarty.get}
{/if}