<img src="public/images/common/spacer.gif" alt="" title="" />
<div class="mContent">
{if $sMessage.success}
    <h4>{$BVS_LANG.mSuccess}</h4>
{else}	
    <h4>{$BVS_LANG.mFail}</h4>
{/if}

{if $sMessage.success}
    <p>{$sMessage.message}</p>
    <div id="loading">&nbsp;</div>
{else}
    {if $sMessage.warning}
        <p><strong>{$sMessage.message}</strong></p>
        <div>
            <span>{$BVS_LANG.doYouComfirmThisAction}</span>
            <ul>
                <li><a href="?m={$smarty.get.m}{if $smarty.get.title}&title={$smarty.get.title}{/if}&delete={$smarty.get.id}"><strong>{$BVS_LANG.confirmAction}</strong></a></li>
                <li><a href="?m={$smarty.get.m}{if $smarty.get.title}&title={$smarty.get.title}{/if}"><strong>{$BVS_LANG.btCancelAction}</strong></a></li>
            </ul>
        </div>
    {else}
        <p><strong>{$BVS_LANG.msg_op_fail}</strong></p>
        <div>
            <code>Error #{$sMessage.NErro}: {$sMessage.message}</code>
        </div>
        <span><a href="http://{$smarty.server.HTTP_HOST}{$BVS_CONF.install_dir}{if $smarty.get.m}?m={$smarty.get.m}{/if}"><strong>{$BVS_LANG.btBackAction}</strong></a></span>
    {/if}
{/if}

</div>
<div class="spacer">&#160;</div>
