<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.3" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>

    <xsl:variable name="lang" select="/root/http-info/cgi/lang" />
    <xsl:variable name="path-xml" select="concat(/root/define/DATABASE_PATH,'xml/',$lang)"/>
    <xsl:variable name="texts" select="document(concat($path-xml,'/metasearch.xml'))/metasearch" />

    <xsl:template match="/">
        <!--
        <textarea cols="120" rows="20">
            <xsl:copy-of select="."/>
        </textarea>
        -->
        <xsl:apply-templates select="/root/google"/>
    </xsl:template>

    <xsl:template match="google">
        <div class="searchResult">
            <div id="search">
                <h3>
                    <span><xsl:apply-templates select="$texts/text[@id = 'search_title']" /></span>
                </h3>
                   <div id="breadCrumb">
                  <a href="../index.php?lang=pt">home</a> &gt;
                  <xsl:value-of select="$texts/text[@id = 'search_title']" />
                </div>

                <form action="../google/search.php" method="post" name="google">
                    <input type="hidden" name="lang" value="{$lang}"/>

                    <div class="searchItens">
                        <xsl:value-of select="$texts/text[@id = 'search_entryWords']" /><br />
                        <input type="text" name="expression" class="expression" />
                        <input type="submit" value="{$texts/text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                    </div>
                  </form>
                <h4>
                    <span><xsl:value-of select="$texts/text[@id = 'search_results']" /></span>
                </h4>
                <xsl:apply-templates select="result-group"/>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="result-group">
        <ul>
            <xsl:apply-templates select="source"/>
        </ul>
    </xsl:template>

    <xsl:template match="source">
        <li>
            <a href="{@browseUrl}" target="metaResult" onclick="openResultWin(this.href, this.target)"><xsl:value-of select="@label"/></a> (<xsl:value-of select="@total"/>)
        </li>
    </xsl:template>


</xsl:stylesheet>