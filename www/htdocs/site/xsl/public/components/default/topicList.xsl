<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:param name="topicData" select="$bvsRoot/collectionList//item[@id = $id]" />

    <xsl:template match="topic">
        <div class="topic" id="c_{$id}">
            <h3>
             <span>
              <xsl:choose>
                <xsl:when test="$topicData/@href != ''">
                    <a href="{$topicData/@href}"><xsl:value-of select="$topicData/text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="../php/level.php?lang={$lang}&amp;component={$id}{$portal_param}"><xsl:value-of select="$topicData/text()" /></a>
                </xsl:otherwise>
              </xsl:choose>
             </span>
            </h3>
            <ul>
                <xsl:apply-templates select="item" />
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="topic/item | topic//item">
        <li>
            <xsl:choose>
                <xsl:when test="meta-search/info-source">
                    <a href="{$metaIAH}?lang={$lang}&amp;topic={concat($id,'-',@id)}{$portal_param}"><xsl:apply-templates select="text()"/></a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="text()"/>
                </xsl:otherwise>
            </xsl:choose>
        </li>
    </xsl:template>

    <xsl:template match="topic/item[item] | topic//item[item]">
        <li>
            <xsl:choose>
                <xsl:when test="meta-search/info-source">
                    <a href="{$metaIAH}?lang={$lang}&amp;topic={concat($id,'-',@id)}{$portal_param}"><xsl:apply-templates select="text()"/></a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="text()"/>
                </xsl:otherwise>
            </xsl:choose>
            <a href="#" class="expand-retract" onclick="javascript:showhideLayers('{concat('layer',@id)}','toggleImg{@id}','../image/common/retract.gif','../image/common/expand.gif');return false"><img id="toggleImg{@id}" src="../image/common/expand.gif" border="0" alt="{$texts/text[@id = 'topic.expand']}"/></a>
            <div id="{concat('layer',@id)}" style="display:none;">
                <ul>
                    <xsl:apply-templates select="item"/>
                </ul>
            </div>
        </li>
    </xsl:template>

    <xsl:template match="topic//item[normalize-space(description) != '']">
        <li>
            <input type="button" name="information" title="{$texts/text[@id = 'button_moreInformation']}" onclick="popUp('../php/description.php?lang={$lang}&amp;component={$id}&amp;id={@id}','medium');return false;" class="info"/>&#160;
            <xsl:choose>
                <xsl:when test="meta-search/info-source">
                    <a href="{$metaIAH}?lang={$lang}&amp;topic={concat($id,'-',@id)}{$portal_param}"><xsl:apply-templates select="text()"/></a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="text()"/>
                </xsl:otherwise>
            </xsl:choose>
        </li>
    </xsl:template>

    <xsl:template match="topic//item[item and normalize-space(description) != '']">
        <li>
            <input type="button" name="information" title="{$texts/text[@id = 'button_moreInformation']}" onclick="popUp('../php/description.php?lang={$lang}&amp;component={$id}&amp;id={@id}','medium');return false;" class="info" />&#160;
            <xsl:choose>
                <xsl:when test="meta-search/info-source">
                    <a href="{$metaIAH}?lang={$lang}&amp;topic={concat($id,'-',@id)}{$portal_param}"><xsl:apply-templates select="text()"/></a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="text()"/>
                </xsl:otherwise>
            </xsl:choose>

            <a href="#" class="expand-retract" onclick="javascript:showhideLayers('{concat('layer',@id)}','toggleImg{@id}','../image/common/retract.gif','../image/common/expand.gif');return false"><img id="toggleImg{@id}" src="../image/common/expand.gif" border="0" alt="expand"/></a>
            <div id="{concat('layer',@id)}" style="display:none;">
                <ul>
                    <xsl:apply-templates select="item"/>
                </ul>
            </div>
        </li>
    </xsl:template>

</xsl:stylesheet>
