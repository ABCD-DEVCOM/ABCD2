<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="metasearch">
        <div id="search" style="display: block;">
            <h3>
                <span><xsl:value-of select="text[@id = 'search_title']" /></span>
            </h3>
            <form name="searchForm" action="#" method="post" onsubmit="return(executeSearch());">
                <input type="hidden" name="lang"   value="{$lang}" />
                <input type="hidden" name="engine" value="metaiah"/>
                <input type="hidden" name="group"  value="&lt;?= $_REQUEST['id'] ?&gt;"/>
                <input type="hidden" name="view"   value="&lt;?= $def['RESULT'] ?&gt;"/>

                <div class="searchItens">
                    <xsl:apply-templates select="text[@id = 'search_entryWords']" /><br />
                    <input type="text" name="expression" class="expression" />
                    <input type="submit" value="{text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                 </div>
            </form>
            
            <div id="searchDecs">
                <a href="../php/decsws.php"><xsl:apply-templates select="text[@id = 'decs_mesh']"/></a>
            </div>

        </div>

        <!-- div AJAX search result -->
           <div id="searchResult" style="display: none;">
                <div class="portletTools">
                 <a href="#" onclick="javascript:executeSearch();"><img class="portletRefresh" src="../image/common/refresh.png" alt="refresh" border="0"/></a><a href="#" onclick="portletClose('searchResult');"><img class="portletClose" src="../image/common/close.png" alt="close" border="0"/></a>
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

    <xsl:template match="metasearch//text[@available = 'no']" />

</xsl:stylesheet>
