<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="warningData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="warning">
        <div id="warnings">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$warningData/@href != ''">
                    <a href="{$warningData/@href}"><xsl:value-of select="$warningData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <!-- caramez 09-03-06
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}"><xsl:value-of select="$warningData/text()" /></a>
                    -->
                    <xsl:value-of select="$warningData/text()" />
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item"/>
            </ul>
        </div>
    </xsl:template>


    <xsl:template match="warning/item">
        <li><xsl:apply-templates select="description" /></li>
    </xsl:template>

    <xsl:template match="warning//description">
        <xsl:choose>
            <xsl:when test="count(child::*) &gt; 0">
                 <xsl:copy-of select="* | @* | text()" />
            </xsl:when>
            <xsl:otherwise>
                  <xsl:value-of select="." disable-output-escaping="yes"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>