<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="metasearch">
        <div id="search" style="display: block;">
            <h3>
                <span><xsl:value-of select="text[@id = 'search_title']" /></span>
            </h3>
            <form name="searchForm" action="#" method="post" onsubmit="return(executeSearch());">
                <input type="hidden" name="lang"   value="{$lang}" />
                <input type="hidden" name="group"  value="&lt;?= $_REQUEST['id'] ?&gt;" />
                <input type="hidden" name="view" value="&lt;?= $def['RESULT'] ?&gt;"/>

                <div class="searchItens">
                    <xsl:apply-templates select="text[@id = 'search_entryWords']" /><br />
                    <input type="text" name="expression" class="expression" />
                    <input type="submit" value="{text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                    <xsl:value-of select="text[@id = 'search_method']" />:
                    <input type="radio" name="engine" value="metaiah" checked="checked" id="engine_metaiah" /> <label for="engine_metaiah"><xsl:apply-templates select="text[@id ='search_freeSearch']" /></label>
                    <input type="radio" name="engine" value="metacollexis" id="engine_metacollexis" /> <label for="engine_metacollexis"><xsl:apply-templates select="text[@id = 'conceptSearch_title']" /></label>
                    <input type="radio" name="engine" value="google" id="engine_google" /> <label for="engine_google">google</label>
                 </div>
            </form>
        </div>

        <!-- div AJAX search result -->
           <div id="searchResult" style="display: none;">
                <div class="portletTools">
                 <a href="#" onclick="javascript:executeSearch();"><img class="portletRefresh" src="../image/common/refresh.png" border="0" alt="refresh"/></a><a href="#" onclick="portletClose('searchResult');"><img class="portletClose" src="../image/common/close.png" border="0" alt="close"/></a>
                </div>
                <h3>
                 <span><xsl:value-of select="text[@id = 'search_results']"/></span>
            </h3>
            <div id="result">
                <xsl:comment>result div</xsl:comment>
               </div>
        </div>

    </xsl:template>

    <xsl:template match="metasearch//text">
        <xsl:apply-templates />
    </xsl:template>
</xsl:stylesheet>