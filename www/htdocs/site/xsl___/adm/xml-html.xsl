<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes" omit-xml-declaration="yes" encoding="iso-8859-1"/>

    <xsl:param name="xml-path" />
    <xsl:param name="portal" select="''" />
    <xsl:param name="lang" select="/node()/@lang | /node()/@language" />
    
    <xsl:variable name="id" select="/node()/@id" />
    <xsl:variable name="metaIAH" select="'../metaiah/search.php'" />
    <xsl:variable name="bvsRoot" select="document(concat($xml-path,$lang,'/bvs.xml'))/bvs" />
    <xsl:variable name="texts" select="$bvsRoot/texts" />
    <xsl:variable name="define" select="/root/define"/>

    <xsl:variable name="portal_param">
        <xsl:choose>
            <xsl:when test="$portal != ''">
                <xsl:value-of select="concat('&amp;portal=',$portal)" />
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$portal" />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:include href="../public/components/about.xsl" />
    <xsl:include href="../public/components/bvs.xsl" />
    <xsl:include href="../public/components/calls.xsl" />
    <xsl:include href="../public/components/collectionList.xsl" />
    <xsl:include href="../public/components/communityList.xsl" />
    <xsl:include href="../public/components/contact.xsl" />
    <xsl:include href="../public/components/decs.xsl" />
    <xsl:include href="../public/components/institutionList.xsl" />
    <xsl:include href="../public/components/metainfo.xsl" />
    <xsl:include href="../public/components/metasearch.xsl" />
    <xsl:include href="../public/components/otherversions.xsl" />
    <xsl:include href="../public/components/portalList.xsl" />
    <xsl:include href="../public/components/responsable.xsl" />
    <xsl:include href="../public/components/rss-highlight.xsl" />
    <xsl:include href="../public/components/rss.xsl" />
    <xsl:include href="../public/components/service.xsl" />
    <xsl:include href="../public/components/texts.xsl" />
    <xsl:include href="../public/components/ticker.xsl" />
    <xsl:include href="../public/components/topicList.xsl" />
    <xsl:include href="../public/components/warnings.xsl" />

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="div"/>
    </xsl:template>

    <xsl:template match="*" mode="div">
        <xsl:apply-templates select="." />
    </xsl:template>

    <xsl:template match="*[@available = 'no']">
        <xsl:comment>component <xsl:value-of select="name()"/> disable</xsl:comment>
    </xsl:template>

    <xsl:template match="//item[@available = 'no']">
        <xsl:comment>item <xsl:value-of select="@id"/> disable</xsl:comment>
    </xsl:template>

    <xsl:template match="xhtml">
        <xsl:variable name="collectionData" select="$bvsRoot/collectionList//item[@id = $id]" />

        <div class="generic" id="box_{$id}">
            <h3>
                <span>
                  <xsl:choose>
                    <xsl:when test="$collectionData/@href != ''">
                        <a href="{$collectionData/@href}"><xsl:value-of select="$collectionData/text()" /></a>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="$collectionData/text()" />
                    </xsl:otherwise>
                  </xsl:choose>
                </span>
            </h3>
            <div>
                <xsl:choose>
                    <xsl:when test="count(child::*) &gt; 0">
                         <xsl:apply-templates />
                    </xsl:when>
                    <xsl:when test="string-length(text()) = 0">
                        <xsl:value-of select="' '"/>
                    </xsl:when>
                    <xsl:otherwise>
                          <xsl:value-of select="." disable-output-escaping="yes"/>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
    </xsl:template>

    <!-- Previne fechamento incorreto de tags para o componente XHTML -->
    <xsl:template match="xhtml/content//*">
        <xsl:element name="{name()}">
            <xsl:for-each select="@*">
                <xsl:attribute name="{name()}"><xsl:value-of select="."/></xsl:attribute>
            </xsl:for-each>
            <xsl:choose>
                <xsl:when test="count(child::*) &gt; 0">
                     <xsl:apply-templates />
                </xsl:when>
                <xsl:when test="string-length(text()) = 0">
                    <xsl:value-of select="' '"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:template>

</xsl:stylesheet>
