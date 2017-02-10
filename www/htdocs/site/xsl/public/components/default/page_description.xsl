<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" encoding="iso-8859-1" />    

    <xsl:param name="component" select="/root/http-info/VARS/component" />
    <xsl:param name="id" select="/root/http-info/VARS/id" />
    <xsl:param name="base-path" select="/root/define/DATABASE_PATH" />

    <xsl:param name="texts" select="/root/bvs/texts" />
    <xsl:param name="bvsRoot" select="/root/bvs" />
    <xsl:param name="lang" select="/root/http-info//lang" />

    <xsl:template match="/">
        <!--textarea cols="120" rows="20">
            <xsl:copy-of select="."/>
        </textarea-->
        <xsl:apply-templates select="$bvsRoot/collectionList//item[@id = $component]" />
    </xsl:template>

    <xsl:template match="collectionList//item">
        <xsl:variable name="file" select="concat($base-path,@file)"/>

        <xsl:apply-templates select="document($file)//item[@id = $id]" />
    </xsl:template>

    <xsl:template match="item">
        <h3><xsl:apply-templates select="text()" /></h3>
        <xsl:apply-templates select="description" />
        <div class="bottom">
            <span>
                <a href="javascript:window.print();"><xsl:apply-templates select="$texts/text[@id = 'default_print']" /></a> |
                <a href="javascript:window.close();"><xsl:apply-templates select="$texts/text[@id = 'default_close']" /></a>
            </span>
        </div>
    </xsl:template>

    <xsl:template match="description">
        <xsl:copy-of select="." />
    </xsl:template>


</xsl:stylesheet>
