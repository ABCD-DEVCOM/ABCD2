<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="text"/>

    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="lang" select="$cgi/lang"/>

    <xsl:variable name="graphic"><xsl:if test="$cgi/graphic = 'yes'">graphic=yes&amp;</xsl:if></xsl:variable>


    <xsl:template match="/">
        <xsl:value-of select="concat($graphic,'lang=',$lang,'&amp;xml=',$cgi/xml,'&amp;xsl=generated.xsl&amp;xslSave=xsl/adm/save-home.xsl&amp;xmlSave=html/',$lang,'/home.html','&#010;')"/>
        <xsl:apply-templates select="root/bvs/collectionList/item"/>
    </xsl:template>

    <xsl:template match="collectionList/item">
        <xsl:value-of select="concat($graphic,'lang=',$lang,'&amp;xml=',$cgi/xml,'&amp;xsl=generated.xsl&amp;tab=',@href,'&amp;xslSave=xsl/adm/save-home.xsl&amp;xmlSave=html/',$lang,'/',@href,'.html','&#010;')"/>
    </xsl:template>

</xsl:stylesheet>

