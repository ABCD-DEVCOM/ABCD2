<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{$BVS_LANG.metaLanguage}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$BVS_LANG.metaLanguage}">
    {include file="header.tpl.php"}
    <body>
        {include file="heading.tpl.php"}
        {include file="navigation.tpl.php"}
        <div id="middle" class="middle {if $sMessage}message {if $sMessage.success}mSuccess{elseif $sMessage.warning}mAlert{else}mError{/if}{else}{$smartyTemplate}{/if}">
        {if $sMessage}
            {include file="messages.tpl.php"}
        {else}
            {if $formRequest}
                {include file="$formRequest.form.tpl.php"}
            {elseif $listRequest eq 'homepage' || $listRequest eq 'login'  || $listRequestReport eq "report"}
                {include file="$listRequest.tpl.php"}
            {else}
                {include file="search.tpl.php"}
                {include file="$listRequest.list.tpl.php"}
                {include file="pagination.tpl.php"}
            {/if}
        {/if}
        </div>
        {include file="footer.tpl.php"}
    </body>
</html>
