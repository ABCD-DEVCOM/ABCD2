<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="aboutData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="about">
        <div class="about" id="c_{$id}">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$aboutData/@href != ''">
                    <a href="{$aboutData/@href}"><xsl:value-of select="$aboutData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$aboutData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>

            <xsl:if test="item[@available = 'yes']">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </div>
    </xsl:template>

    <xsl:template match="about/item">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a>
        </li>
    </xsl:template>

    <xsl:template match="about/item[@img]">
        <li>
            <a href="../php/level.php?lang={$lang}&amp;component={$id}&amp;item={@id}{$portal_param}"><img src="{@img}" alt="{text()}" /></a>
        </li>
    </xsl:template>

    <xsl:template match="about/item[@href != '']">
        <li>
            <a href="{@href}"><xsl:apply-templates select="text()" /></a>
        </li>
    </xsl:template>

    <xsl:template match="about/item[@href != '' and @img]">
        <li>
            <a href="{@href}"><img src="{@img}" alt="{text()}" /></a>
        </li>
    </xsl:template>

</xsl:stylesheet>