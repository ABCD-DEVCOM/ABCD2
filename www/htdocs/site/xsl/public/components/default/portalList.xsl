<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="portalListData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="portal">
        <div class="portal" id="c_{$id}">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$portalListData/@href != ''">
                    <a href="{$portalListData/@href}"><xsl:value-of select="$portalListData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$portalListData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="portal//item">
        <li>
            <xsl:apply-templates select="text()" />
        </li>
    </xsl:template>

    <xsl:template match="portal//item[@img]">
        <li><img src="{@img}" alt="{text()}" /></li>
    </xsl:template>

    <xsl:template match="portal//item[@href != '']">
        <li><a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a></li>
    </xsl:template>

    <xsl:template match="portal//item[@href != '' and @img]">
        <li><a href="{@href}" target="_blank"><img src="{@img}" alt="{text()}" /></a></li>
    </xsl:template>


    <xsl:template match="portal//item[item]">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a>
            <xsl:if test="ancestor::item"> +  </xsl:if>
            <ul>
                <xsl:comment>item</xsl:comment>
                <xsl:apply-templates select="item" />
            </ul>
        </li>
    </xsl:template>

    <!--xsl:template match="portal//item[item and @href != '']">
        <li>
            <a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </li>
    </xsl:template-->

    <xsl:template match="portal//item[item and @img]">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}"><img src="{@img}" alt="{text()}" /></a>
            <xsl:if test="ancestor::item"> + </xsl:if>
            <ul>
                <xsl:comment>item</xsl:comment>
                <xsl:apply-templates select="item" />
            </ul>
        </li>
    </xsl:template>

    <!--xsl:template match="portal//item[item and @img and @href != '']">
        <li>
            <a href="{@href}" target="_blank"><img src="{@img}" alt="{text()}" /></a>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </li>
    </xsl:template-->

    <xsl:template match="portal/item/item/item" />

</xsl:stylesheet>