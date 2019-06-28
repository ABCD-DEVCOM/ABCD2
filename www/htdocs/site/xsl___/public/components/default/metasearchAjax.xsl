<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!-- AJAX implementation -->

    <xsl:template match="metasearch">
        <div id="search" style="display: block;">
            <h3>
                <span>
                    <a href="../metaiah/search.php?lang={$lang}&amp;form=advanced"><xsl:value-of select="text[@id = 'search_title']" /></a>
                </span>
            </h3>
            <form name="searchForm" action="#" method="POST" onsubmit="executeSearchAjax();return false;">
                <input type="hidden" name="lang" value="{$lang}" />
                <input type="hidden" name="group" value="&lt;?= $_REQUEST['component'] ?&gt;" />
                <input type="hidden" name="engine" value="metaiah" />

                <div class="searchItens">
                    <xsl:value-of select="text[@id = 'search_entryWords']" /><br />
                    <input type="text" name="expression" class="expression" id="expression"/>
                    <input type="submit" value="{text[@id = 'search_submit']}" name="submit" class="submit" />
                 </div>

            </form>
        </div>
        <div id="searchResult" style="display: none;">
             <div class="portletTools">
                 <a href="#" onclick="javascript:executeSearchAjax();"><img class="portletRefresh" src="../image/common/refresh.png" border="0"/></a><a href="#" onclick="portletClose('searchResult');"><img class="portletClose" src="../image/common/close.png" border="0"/></a>
             </div>
             <h3><span><xsl:value-of select="text[@id = 'search_results']"/></span></h3>
             <div id="result">
             </div>
        </div>
    </xsl:template>

    <xsl:template match="metasearch//text">
        <xsl:apply-templates />
    </xsl:template>

<!-- /AJAX implementation -->
</xsl:stylesheet>