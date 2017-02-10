<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="no"/>
    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="page" select="$cgi/page"/>
    <xsl:variable name="id" select="$cgi/id"/>
    <xsl:variable name="doc-name" select="$cgi/xmlSave"/>

    <xsl:template match="/">
        <xsl:apply-templates />
    </xsl:template>

    <!-- xsl:template match="*">
        <xsl:element name="{name()}">
            <xsl:for-each select="./@*">
                <xsl:attribute name="{name()}"><xsl:value-of select="."/></xsl:attribute>
            </xsl:for-each>
            <xsl:apply-templates/>
        </xsl:element>
    </xsl:template -->

    <xsl:template match="/">
        <xsl:element name="ticker">
            <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
            <xsl:attribute name="lang"><xsl:value-of select="$cgi/lang"/></xsl:attribute>
            <xsl:attribute name="available"><xsl:value-of select="$cgi/available"/></xsl:attribute>
            <xsl:for-each select="$cgi/buffer">
                <url>
                    <xsl:value-of select="text()" />
                </url>
            </xsl:for-each>
        </xsl:element>
    </xsl:template>

</xsl:stylesheet>
