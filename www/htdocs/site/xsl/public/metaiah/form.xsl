<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:include href="common.xsl"/>

    <xsl:template name="metaiah-core">
        <xsl:choose>
            <xsl:when test="//metaiah/cgi/form = 'advanced'">
                <xsl:apply-templates select="$metaiah-tree//sourceList" mode="advanced"/>
            </xsl:when>
            <xsl:otherwise>
                <blockquote>
                    <xsl:apply-templates select="$texts/text[@id =     'search_error']" />
                </blockquote>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template name="breadCrumb">
        <xsl:choose>
            <xsl:when test="//metaiah/cgi/form = 'advanced'">
                <div id="breadCrumb">
                    <a href="../php/index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a> &gt; <xsl:apply-templates select="$searchTexts/text[@id = 'search_advancedSearch']" />
                </div>
            </xsl:when>
            <xsl:otherwise>
                <div id="breadCrumb">
                    <a href="../php/index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a> &gt; <xsl:apply-templates select="$searchTexts/text[@id = 'search_advancedSearch']" />
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="metaiah//sourceList" mode="advanced">
        <input type="hidden" name="form" value="advanced"/>
        <ul>
            <xsl:apply-templates select="group"/>
        </ul>
    </xsl:template>

    <xsl:template match="metaiah//group">
        <xsl:variable name="group" select="position()"/>

        <li>
            <input type="checkbox" value="true" checked="1" name="selected_sources[{@label}]" id="{$group}" onclick="javascript: checkUncheck('{$group}-', this.checked);"/>
            <xsl:value-of select="@label"/>

                <ul>
                    <xsl:apply-templates select="item">
                        <xsl:with-param name="group" select="$group"/>
                    </xsl:apply-templates>
                </ul>

        </li>

    </xsl:template>

    <xsl:template match="metaiah//item">
        <xsl:param name="group"/>
        <xsl:variable name="source" select="@source"/>

        <li>
            <input type="checkbox" value="true" checked="1" name="selected_sources[{@label}]" id="{concat($group,'-',position())}"/>
            <a href="{@href}">
                <xsl:value-of select="@label"/>
            </a>
        </li>
    </xsl:template>


</xsl:stylesheet>
