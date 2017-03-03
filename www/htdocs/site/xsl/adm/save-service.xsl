<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
        <xsl:output method="xml" indent="no" encoding="iso-8859-1"/>
        <xsl:variable name="cgi" select="/root/http-info/cgi"/>
        <xsl:variable name="page" select="$cgi/page"/>
        <xsl:variable name="id" select="$cgi/id"/>
        <xsl:variable name="doc-name" select="$cgi/xmlSave"/>

    <xsl:template match="/">
        <xsl:element name="service">
            <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
            <xsl:attribute name="lang"><xsl:value-of select="$cgi/lang"/></xsl:attribute>
            <xsl:attribute name="available"><xsl:value-of select="$cgi/available"/></xsl:attribute>
            <url>
                <xsl:value-of select="$cgi/buffer/text()" />
            </url>
        </xsl:element>
    </xsl:template>

</xsl:stylesheet>
