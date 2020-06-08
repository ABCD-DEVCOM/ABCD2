<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="collectionData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="collection">
        <div class="collection" id="c_{$id}">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$collectionData/@href != ''">
                    <a href="{$collectionData/@href}"><xsl:value-of select="$collectionData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$collectionData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="collection/item">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
            <xsl:if test="item">
                <!--ul>
                    <li><xsl:apply-templates select="item" /></li>
                </ul-->
                <span><xsl:apply-templates select="item" /></span>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="collection/item[@href != '']">
        <li>
            <a href="{@href}" target="_blank">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
            <xsl:if test="item">
                <!--ul>
                    <li><xsl:apply-templates select="item" /></li>
                </ul-->
                <span><xsl:apply-templates select="item" /></span>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="collection/item/item">
        <xsl:if test="position() > 1">, </xsl:if>
        <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}">
            <xsl:apply-templates select="@img"/>
            <xsl:apply-templates select="text()"/>
        </a>
    </xsl:template>

    <xsl:template match="collection/item/item[@href != '']">
        <xsl:variable name="text"><xsl:apply-templates select="text()"/></xsl:variable>

        <xsl:if test="position() > 1">, </xsl:if>
        <a href="{@href}" target="_blank">
            <xsl:apply-templates select="@img"/>
            <xsl:value-of select="normalize-space($text)"/>
        </a>
    </xsl:template>

    <xsl:template match="collection//item/text()">
        <xsl:choose>
            <xsl:when test="contains(.,' - ')">
                <span title="{normalize-space(substring-after(.,' - '))}"><xsl:value-of select="substring-before(.,' - ')"/></span>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="." />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="collection/item//@img">
        <img src="{.}" alt="" />
    </xsl:template>

    <xsl:template match="collection/item/item//item" />


</xsl:stylesheet>
