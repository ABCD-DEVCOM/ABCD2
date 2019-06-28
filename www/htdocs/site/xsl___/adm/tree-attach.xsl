<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="tree.xsl"/>

    <xsl:variable name="find-element" select="/root/adm/page[@id = $page]/edit/tree-edit/@element"/>
    <xsl:variable name="doc-edit" select="document($doc-name)/bvs/*[name() = $find-element]/attach[@href = $page]/@file"/>

    <xsl:template match="*" mode="form-save">
        <input type="hidden" name="xmlSave" value="{$doc-edit}"/>
        <input type="hidden" name="xslSave" value="{$xsl-path}save.xsl"/>
<!--
<input type="hidden" name="debug" value="xml"/>
-->
    </xsl:template>

    <xsl:template match="flag">
        <xsl:variable name="find-flag" select="@name"/>
        <xsl:variable name="flag-found" select="document($doc-edit)/*[name() = $page]/@*[name() = $find-flag]"/>

        <xsl:apply-templates select="." mode="flag-show">
            <xsl:with-param name="flag-found" select="$flag-found"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="tree-edit">
        <xsl:apply-templates select="$doc-xml/bvs/*[name() = $find-element]" mode="next-id"/>
        <xsl:apply-templates select="." mode="select">
            <xsl:with-param name="select" select="document($doc-edit)/*[name() = $page]"/>
        </xsl:apply-templates>
    </xsl:template>

</xsl:stylesheet>

