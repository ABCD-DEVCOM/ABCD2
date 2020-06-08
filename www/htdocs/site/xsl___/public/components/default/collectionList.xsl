<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="collectionData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="collection" id="c_{$id}">
        <div class="collection">
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
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
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
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="collection/item/item">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
        </li>
    </xsl:template>

    <xsl:template match="collection/item/item[@href != '']">
        <li>
            <a href="{@href}" target="_blank">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
        </li>
    </xsl:template>

    <xsl:template match="collection/item//@img">
        <img src="{.}" alt="" />
    </xsl:template>

    <xsl:template match="collection/item/item//item" />

</xsl:stylesheet>
