<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="metainfo">
        <xsl:apply-templates select="item"/>
    </xsl:template>

    <xsl:template match="metainfo/item">
        <meta name="{@id}" content="{text()}" />
    </xsl:template>

</xsl:stylesheet>