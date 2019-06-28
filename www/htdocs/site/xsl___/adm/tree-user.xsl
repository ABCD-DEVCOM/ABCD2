<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="tree.xsl"/>

    <xsl:variable name="find-element" select="/root/adm/page[@id = $page]/edit/tree-edit/@element"/>
    <!--xsl:variable name="doc-edit" select="/root/adm/page[@id = $page]/edit/tree-edit/@xml"/-->
    <xsl:variable name="xmlSave" select="/root/adm/page[@id = $page]/edit/tree-edit/@xml"/>
    <xsl:variable name="doc-edit" select="concat(/root/define/DEFAULT_DATA_PATH,$xmlSave)"/>

    <xsl:template match="*" mode="form-save">
        <input type="hidden" name="xmlSave" value="{$xmlSave}"/>
        <input type="hidden" name="xslSave" value="{$xsl-path}save.xsl"/>

<!--
<input type="hidden" name="debug" value="xmlSave"/>
-->
    </xsl:template>

    <!-- xsl:template match="user" mode="array">
        "<xsl:element name="name"><xsl:value-of select="@name"/></xsl:element>" +
        "<xsl:element name="type"><xsl:value-of select="@type"/></xsl:element>" +
        "<xsl:element name="password"><xsl:value-of select="@password"/></xsl:element>",
    </xsl:template -->

    <xsl:template match="user" mode="array">
        "<xsl:element name="name"><xsl:apply-templates select="@name" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="type"><xsl:apply-templates select="@type" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="password"><xsl:apply-templates select="@password" mode="escape_quotes_js"/></xsl:element>",
    </xsl:template>

    <xsl:template match="user" mode="option">
        <option value="0"><xsl:value-of select="@name"/></option>
    </xsl:template>

    <xsl:template match="tree-edit[@xml]">
        <xsl:variable name="find-element" select="@element"/>

        <xsl:apply-templates select="." mode="select">
            <xsl:with-param name="select" select="document($doc-edit)/*[name() = $find-element]"/>
        </xsl:apply-templates>
    </xsl:template>

</xsl:stylesheet>

