<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>

    <xsl:variable name="lang" select="/node()/@lang | /node()/@language" />
    <xsl:variable name="texts" select="/root/metasearch" />

    <xsl:template match="/">
        <xsl:apply-templates select="/root/metasearch"/>
    </xsl:template>

    <xsl:template match="metasearch">
        <div id="search">
            <h3>
                <span><xsl:value-of select="text[@id = 'decs_mesh']"/></span>
            </h3>
            <div id="breadCrumb">
                  <a href="../index.php?lang=pt">home</a> &gt;
                    <xsl:value-of select="text[@id = 'decs_mesh']"/>
            </div>

            <script type="text/javascript" src="../js/decs.js"><xsl:comment>decs.js</xsl:comment></script>

            <form action="#" method="post" name="decsSearchForm" onsubmit="return(executeSearchDecs());">
                <input type="hidden" name="lang" value="{$lang}"/>

                <div class="searchItens">
                    <xsl:value-of select="text[@id = 'search_entryWords']" /><br />
                    <input type="text" name="expression" class="expression" />
                    <input type="submit" value="{text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                </div>
              </form>
        </div>

        <!-- div AJAX search result -->
           <div id="searchResult" style="display: none;">
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