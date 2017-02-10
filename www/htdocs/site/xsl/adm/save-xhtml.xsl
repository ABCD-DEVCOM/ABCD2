<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" encoding="iso-8859-1"/>

    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="page" select="$cgi/page"/>
    <xsl:variable name="id" select="$cgi/id"/>
    <xsl:variable name="doc-name" select="$cgi/xmlSave"/>

    <xsl:template match="/">
        <xsl:element name="xhtml">
            <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
            <xsl:attribute name="lang"><xsl:value-of select="$cgi/lang"/></xsl:attribute>
            <xsl:attribute name="available"><xsl:value-of select="$cgi/available"/></xsl:attribute>
            <content>
                <xsl:apply-templates select="$cgi/buffer/node()"  />
            </content>
        </xsl:element>
    </xsl:template>

    <xsl:template match="*">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="@* | comment()">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

    <xsl:template name="write-starttag">
      <xsl:text>&lt;</xsl:text>
      <xsl:value-of select="local-name()"/>
      <xsl:for-each select="@*">
        <xsl:call-template name="write-attribute"/>
      </xsl:for-each>
      <xsl:text>></xsl:text>
    </xsl:template>


    <xsl:template name="write-endtag">
      <xsl:text>&lt;/</xsl:text>
      <xsl:value-of select="local-name()"/>
      <xsl:text>></xsl:text>
    </xsl:template>


    <xsl:template name="write-attribute">
      <xsl:text> </xsl:text>
      <xsl:value-of select="local-name()"/>
      <xsl:text>="</xsl:text>
      <xsl:value-of select="."/>
      <xsl:text>"</xsl:text>
    </xsl:template>


    <xsl:template match="*" mode="escape-xml">
      <xsl:call-template name="write-starttag"/>
      <xsl:apply-templates/>
      <xsl:call-template name="write-endtag"/>
    </xsl:template>

    <xsl:template match="script">
        <xsl:element name="{name()}">
            <xsl:for-each select="@*">
                <xsl:attribute name="{name()}"><xsl:value-of select="."/></xsl:attribute>
            </xsl:for-each>
            <xsl:choose>
                <xsl:when test="string-length(text()) = 0">
                    <xsl:value-of select="concat('/*',name(),'*/')"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:template>

    <xsl:template match="link | style">
        <!-- Anula todas as tag <link>, <style>  -->
    </xsl:template>
</xsl:stylesheet>
