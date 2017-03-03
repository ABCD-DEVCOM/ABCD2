<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="bvs">
        <xsl:apply-templates select="." mode="BVS-bar" />
        <xsl:apply-templates select="." mode="BVS-top" />
    </xsl:template>

    <!-- inicio definições da barra superior -->
    <xsl:template match="*" mode="BVS-bar">
        <div class="bar">
            <xsl:apply-templates select="." mode="BVS-bar-otherVersions" />
            <xsl:apply-templates select="." mode="BVS-bar-buttons" />
        </div>
    </xsl:template>

    <xsl:template match="*" mode="BVS-bar-buttons">
        <!--div id="contact"-->
            <xsl:apply-templates select="contact" />
        <!--/div-->
    </xsl:template>

    <xsl:template match="*" mode="BVS-bar-otherVersions">
        <!--div id="otherVersions"-->
            <xsl:apply-templates select="other-versions" />
        <!--/div-->
    </xsl:template>

    <!-- definições do top -->
    <xsl:template match="*" mode="BVS-top">
        <div class="top">
            <xsl:apply-templates select="." mode="BVS-top-parent" />
            <xsl:apply-templates select="." mode="BVS-top-identification" />
            <xsl:apply-templates select="." mode="BVS-top-institutionList" />
        </div>
    </xsl:template>

    <xsl:template match="*" mode="BVS-top-parent">
        <div id="parent">
            <xsl:apply-templates select="parent" />
        </div>
    </xsl:template>

    <xsl:template match="parent">
        <xsl:apply-templates select="item" />
    </xsl:template>

    <xsl:template match="parent/item">
        <xsl:apply-templates select="text()" />
    </xsl:template>

    <xsl:template match="parent/item[@img]">
        <img src="{@img}" alt="{text()}" />
    </xsl:template>

    <xsl:template match="parent/item[@href != '']">
        <a href="{@href}"><xsl:apply-templates select="text()" /></a>
    </xsl:template>

    <xsl:template match="parent/item[@href != '' and @img]">
        <a href="{@href}"><img src="{@img}" alt="{text()}" /></a>
    </xsl:template>

    <xsl:template match="parent/item[substring-after(@img,'.') = 'png']">
        <img src="{@img}" alt="{text()}" onLoad="fixPNG(this);"/>
    </xsl:template>

    <xsl:template match="parent/item[substring-after(@img,'.') = 'png' and @href != '']">
        <a href="{@href}"><img src="{@img}" alt="{text()}" onLoad="fixPNG(this);"/></a>
    </xsl:template>

    <xsl:template match="*" mode="BVS-top-identification">
        <div id="identification">
            <xsl:apply-templates select="identification" />
        </div>
    </xsl:template>

    <xsl:template match="identification">
        <xsl:apply-templates select="item" />
    </xsl:template>

    <xsl:template match="identification/item">
        <h1><span><xsl:apply-templates select="text()"/></span></h1>
    </xsl:template>

    <xsl:template match="identification/item[@img]">
        <h1><span><img src="{@img}" alt="{text()}" /></span></h1>
    </xsl:template>

    <xsl:template match="identification/item[substring-after(@img,'.') = 'png']">
        <h1><span><img src="{@img}" alt="{text()}" onLoad="fixPNG(this);"/></span></h1>
    </xsl:template>

    <xsl:template match="*" mode="BVS-top-institutionList">
        <!--div id="institutionList"-->
            <xsl:apply-templates select="institution" />
        <!--/div-->
    </xsl:template>

    <xsl:template match="texts"/>

    <xsl:template match="*[@available = 'no']" />

</xsl:stylesheet>

