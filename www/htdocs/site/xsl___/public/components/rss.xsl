<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="default/rss.xsl"/>
    <xsl:template match="rss">
        <xsl:variable name="component" select="@id"/>
        <xsl:variable name="rssData" select="$bvsRoot/collectionList//item[@id = $component]" />

        <div class="RSS" id="c_{$component}">
            <h3><span>
                <xsl:choose>
                  <xsl:when test="$rssData/@href and $rssData/@href != ''">
                    <a href="{$rssData/@href}"><xsl:apply-templates select="$rssData" mode="component"/></a>
                  </xsl:when>
                  <xsl:otherwise>
                    <xsl:value-of select="$rssData/text()" />
                  </xsl:otherwise>
                </xsl:choose></span>
            </h3>
            <xsl:text disable-output-escaping = "yes" >&lt;?</xsl:text>
                $url = "<xsl:value-of select="url" disable-output-escaping="yes"/>";
                include("./php/show_rss.php");
            <xsl:text disable-output-escaping = "yes" >?&gt;</xsl:text>
        </div>
    </xsl:template>

    <xsl:template match="item[@img]" mode="component">
        <img src="{@img}" alt="{text()}" />
    </xsl:template>

    <xsl:template match="item" mode="component">
        <span>
            <xsl:value-of select="."/>
        </span>
    </xsl:template>


</xsl:stylesheet>
