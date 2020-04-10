<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="communityData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="community">
        <div class="community" id="c_{$id}">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$communityData/@href != ''">
                    <a href="{$communityData/@href}"><xsl:value-of select="$communityData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$communityData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="community//item">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
        </li>
    </xsl:template>

    <xsl:template match="community//item[@href != '']">
        <li>
            <a href="{@href}" target="_blank">
                <xsl:apply-templates select="@img"/>
                <xsl:apply-templates select="text()"/>
            </a>
        </li>
    </xsl:template>

    <xsl:template match="community/item//@img">
        <img src="{.}" alt="" />
    </xsl:template>

    <xsl:template match="community/item/item//item" />


</xsl:stylesheet>
