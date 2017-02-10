<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="iso-8859-1" omit-xml-declaration="yes"/>

    <xsl:param name="source" select="/root/http-info/VARS/source" />
    <xsl:param name="id" select="/root/http-info/cgi/id" />

    <xsl:param name="texts" select="/root/bvs/texts" />
    <xsl:param name="bvsRoot" select="/root/bvs" />
    <xsl:param name="lang" select="/root/http-info//lang" />

    <xsl:include href="../texts.xsl"/>

    <xsl:template match="/">
        <div id="contact">
            <xsl:apply-templates select="$bvsRoot/contact" mode="display" />
        </div>
    </xsl:template>

    <xsl:template match="contact" mode="display">
        <xsl:apply-templates select="item[1]" />
    </xsl:template>

    <xsl:template match="contact/item">
        <h3><span><xsl:apply-templates select="$texts/text[@id = 'contact']" /></span></h3>
        <div id="breadCrumb">
            <a href="/?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a> &gt;
            <xsl:apply-templates select="$texts/text[@id = 'contact']" />
        </div>
        <div class="content">
            <xsl:apply-templates select="$texts/text[@id = 'contact: response']" />
        </div>
    </xsl:template>

    <xsl:template match="*[@available = 'no']" />
    <xsl:template match="*[@available = 'no']" mode="display" />

</xsl:stylesheet>