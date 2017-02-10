<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="other-versions">
        <div id="otherVersions">
            <xsl:apply-templates select="item" />
        </div>
    </xsl:template>

    <xsl:template match="other-versions/item">
        <span class="{normalize-space(.)}"><xsl:value-of select="normalize-space(.)"/></span>
        <xsl:if test="position() != last()"> | </xsl:if>
    </xsl:template>

    <xsl:template match="other-versions/item[@href != '']">
        <span class="{normalize-space(.)}"><a href="{@href}"><xsl:value-of select="normalize-space(text())"/></a></span>
        <xsl:if test="position() != last()"> | </xsl:if>
    </xsl:template>

</xsl:stylesheet>
