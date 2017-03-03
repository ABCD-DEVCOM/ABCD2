<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="menu.xsl"/>

    <xsl:template match="/">
        <xsl:apply-templates select="root/adm/page[@id = 'menu-standard']" mode="html"/>
    </xsl:template>

    <xsl:template match="attach[not(@adm)]" mode="tree"/>

</xsl:stylesheet>

