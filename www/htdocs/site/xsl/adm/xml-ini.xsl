<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" indent="no" encoding="iso-8859-1"/>

<xsl:param name="xml-path" />
<xsl:param name="lang" />

<xsl:variable name="line"><xsl:text>
</xsl:text></xsl:variable>

<xsl:variable name="bvs-title">
    <xsl:choose>
        <xsl:when test="/bvs">
            <xsl:value-of select="/bvs/identification/item/text()"/>
        </xsl:when>
        <xsl:when test="//item[item]">
            <xsl:value-of select="document(concat($xml-path,$lang,'/bvs.xml'))/bvs/identification/item"/>
        </xsl:when>
    </xsl:choose>
</xsl:variable>

<xsl:template match="/">
     <xsl:choose>
         <xsl:when test="/bvs/collectionList">
            <xsl:value-of select="concat('title=&#34;',$bvs-title,'&#34;')"/>
            <xsl:value-of select="$line"/>
            <xsl:apply-templates select="/bvs/collectionList/item[@available = 'yes']"/>
        </xsl:when>
        <xsl:when test="//item[not(@href) and (item or portal)]">
            <xsl:apply-templates select="//item"/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:text>;subpages not present in this component</xsl:text>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>


<xsl:template match="item" mode="ancestor">
    <xsl:value-of select="concat(' : ',normalize-space(text()))"/>
</xsl:template>

<xsl:template match="item[not(@href)]">
    <xsl:variable name="title">
        <xsl:value-of select="normalize-space(text())"/>
        <xsl:apply-templates select="ancestor::item" mode="ancestor"/>
        <xsl:value-of select="concat(' : ',normalize-space($bvs-title))"/>
    </xsl:variable>
    <xsl:value-of select="concat(@id,'=&quot;',$title,'&quot;')"/>
    <xsl:value-of select="$line"/>
</xsl:template>

<xsl:template match="item[@href]"/>

<xsl:template match="collectionList/item">
    <xsl:value-of select="$line"/>
    <xsl:value-of select="concat('[col',position(),']')"/>
    <xsl:value-of select="$line"/>
    <xsl:apply-templates select="item[@available = 'yes']"/>
</xsl:template>

<xsl:template match="collectionList/item/item">
    <xsl:value-of select="concat('pos',position(),'_',@type)"/>=<xsl:value-of select="@id"/>
    <xsl:value-of select="$line"/>
</xsl:template>


</xsl:stylesheet>
