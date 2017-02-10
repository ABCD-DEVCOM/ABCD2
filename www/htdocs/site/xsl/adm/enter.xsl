<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="text" omit-xml-declaration="yes"/>

    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="user" select="$cgi/user"/>
    <xsl:variable name="password" select="$cgi/password"/>

    <xsl:template match="/">
        <xsl:apply-templates select="root/users/user[@name = $user and @password = $password]"/>
        <xsl:if test="not(root/users/user[@name = $user and @password = $password])">
            <xsl:value-of select="'invalid-entry.xsl'"/>
        </xsl:if>
    </xsl:template>

    <xsl:template match="user[@type = 'adm']">
        <xsl:value-of select="'menu.xsl'"/>
    </xsl:template>

    <xsl:template match="user[@type = 'content']">
        <xsl:value-of select="'menu-standard.xsl'"/>
    </xsl:template>

    <xsl:template match="user[@available = 'no']">
        <xsl:value-of select="'invalid-entry.xsl'"/>
    </xsl:template>

</xsl:stylesheet>

