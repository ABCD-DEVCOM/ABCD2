<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="no" omit-xml-declaration="yes"/>


    <xsl:param name="decsTexts" select="document(concat($xml-path,$lang,'/decsws.xml'))/texts" />
    <xsl:param name="decsData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="decs">
        <div id="decs">
            <xsl:apply-templates select="." mode="script"/>
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$decsData/@href != ''">
                    <a href="{$decsData/@href}"><xsl:value-of select="$decsData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$decsData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <div class="label"><xsl:value-of select="$decsTexts/text[@id = 'search_terms']"/></div>

            <form action="../php/decsws.php" method="get" name="decswsForm">
                  <input type="hidden" name="lang" value="{$lang}"/>
                  <input type="hidden" name="tree_id" value=""/>
                <input type="hidden" name="autocomplete_term" value=""/>
             </form>
             <div id="decsAutocomplete">
                <input id="terminput" class="textinput"/>
                <span id="loading">
                    <xsl:comment>loading indicator</xsl:comment>
                </span>
                <div id="container">
                    <xsl:comment>container div</xsl:comment>
                </div>
            </div>

            <script type="text/javascript" src="../js/decs.js"><xsl:comment>decs</xsl:comment></script>
            <script>
                DeCSAutoCompleteConfigure();
            </script>

            <span class="label"><xsl:value-of select="$decsTexts/text[@id = 'category']"/></span>
            <!--
            <a href="#" onclick="showhideLayers('decsCategoryList','showHideDecsCategory','../image/{$lang}/retract.gif','../image/{$lang}/expand.gif')"><img id="showHideDecsCategory" src="../image/{$lang}/expand.gif" border="0" align="middle"/></a>
            -->
              <div id="decsCategoryList">
                <ul>
                    <xsl:apply-templates select="item">
                        <xsl:sort/>
                    </xsl:apply-templates>
                </ul>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="item">
        <li>
            <a href="../php/decsws.php?lang={$lang}&amp;tree_id={@category}"><xsl:value-of select="text()"/></a>
        </li>
    </xsl:template>

    <xsl:template match="*" mode="script">
        <script type="text/javascript" src="../js/yui/yahoo.js"><xsl:comment>yui library </xsl:comment></script>
        <script type="text/javascript" src="../js/yui/dom.js"><xsl:comment>yui library </xsl:comment></script>
        <script type="text/javascript" src="../js/yui/event.js"><xsl:comment>yui library </xsl:comment></script>
        <script type="text/javascript" src="../js/yui/connection.js"><xsl:comment>yui library </xsl:comment></script>
        <script type="text/javascript" src="../js/yui/autocomplete.js"><xsl:comment>yui library </xsl:comment></script>
    </xsl:template>

</xsl:stylesheet>