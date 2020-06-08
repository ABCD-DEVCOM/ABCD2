<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="callsData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="calls">
        <div class="calls">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$callsData/@href != ''">
                    <a href="{$callsData/@href}"><xsl:value-of select="$callsData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <!-- caramez 08-03-06
                        OLD
                        <a href="../php/level.php?lang={$lang}&amp;component={$id}"><xsl:value-of select="$callsData/text()" /></a>
                    -->
                    <xsl:value-of select="$callsData/text()" />
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="calls/item">
        <li>
            <span><xsl:apply-templates select="text()" /></span>
        </li>
    </xsl:template>

    <xsl:template match="calls/item[@img]">
        <li>
            <img src="{@img}" alt="" />
            <span><xsl:apply-templates select="text()" /></span>
        </li>
    </xsl:template>

    <xsl:template match="calls/item[@href != '']">
        <li>
            <a href="{@href}" target="_blank"><span><xsl:apply-templates select="text()" /></span></a>
        </li>
    </xsl:template>

    <xsl:template match="calls/item[@img and @href != '']">
        <li>
            <a href="{@href}" target="_blank">
                <img src="{@img}" alt="" />
            </a>
            <xsl:if test="text() != ''">
                <a href="{@href}" target="_blank">
                    <xsl:apply-templates select="text()"/>
                </a>
            </xsl:if>
        </li>
    </xsl:template>

</xsl:stylesheet>
