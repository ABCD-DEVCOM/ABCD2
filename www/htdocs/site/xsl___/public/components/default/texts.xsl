<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="texts/text">
        <xsl:choose>
            <xsl:when test="@img != ''">
                <img src="{@img}" alt="{text()}" />
            </xsl:when>
            <xsl:otherwise>
                <xsl:copy-of select="* | text() " />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="texts/text/text()">
        <xsl:copy-of select="* | @* | . " />
    </xsl:template>


</xsl:stylesheet>