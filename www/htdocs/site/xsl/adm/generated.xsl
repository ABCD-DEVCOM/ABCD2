<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="xml" indent="yes"/>

    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="lang" select="$cgi/lang"/>
    <xsl:variable name="tab" select="$cgi/tab"/>

    <xsl:template match="/">
        <xsl:if test="not($tab)">
            <a href="/html/{$lang}/home.html" target="_blank"><xsl:value-of select="concat('/html/',$lang,'/home.html')"/></a>
        </xsl:if>
        <xsl:apply-templates select="root/bvs/collectionList/item[@href = $tab]"/>
    </xsl:template>

    <xsl:template match="collectionList/item">
        <a href="/html/{$lang}/{@href}.html" target="_blank"><xsl:value-of select="concat('/html/',$lang,'/',@href,'.html')"/></a>
    </xsl:template>

</xsl:stylesheet>

