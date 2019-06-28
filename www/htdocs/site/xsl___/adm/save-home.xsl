<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="xsl/home.xsl"/>

    <xsl:template match="*" mode="tab-click">
        <a href="{concat('/html/',$lang,'/',@href,'.html')}" class="tab_unsel_text"><xsl:apply-templates select="@img"/><xsl:apply-templates select="text()"/></a>
    </xsl:template>

</xsl:stylesheet>

