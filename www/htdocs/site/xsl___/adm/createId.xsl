<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="/">
        <xsl:apply-templates/>
    </xsl:template>
    <xsl:template match="@* | comment()">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>
    <xsl:template match="*">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="item">
        <xsl:copy>
            <xsl:variable name="newId"><xsl:value-of select="count(ancestor-or-self::item) + count(preceding::item)"/>                </xsl:variable>
            <xsl:attribute name="id"><xsl:value-of select="$newId"/></xsl:attribute>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="item[@id]">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

</xsl:stylesheet>
