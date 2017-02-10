<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="institution">
        <div id="institutionList">
            <ul>
                <xsl:apply-templates select="item[@available='yes']" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="institution//item">
        <li>
            <xsl:apply-templates select="text()" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="institution//item[@img]">
        <li>
            <img src="{@img}" alt="{text()}" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="institution//item[@href != '']">
        <li>
            <a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a>
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="institution//item[@href != '' and @img]">
        <li>
            <a href="{@href}" target="_blank"><img src="{@img}" alt="{text()}" /></a>
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

</xsl:stylesheet>