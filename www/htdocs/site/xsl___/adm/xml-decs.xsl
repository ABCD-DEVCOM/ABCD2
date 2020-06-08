<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" omit-xml-declaration="yes" encoding="iso-8859-1"/>

    <xsl:template match="/">
        <xsl:apply-templates select="//decsws_response/tree/term_list[@lang = 'pt']//term"/>
    </xsl:template>

    <xsl:template match="term">
        <item category="{@tree_id}">
            <xsl:value-of select="text()"/>
        </item>
    </xsl:template>

    <xsl:template match="@* | comment()">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

    <xsl:template match="*">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>


</xsl:stylesheet>
