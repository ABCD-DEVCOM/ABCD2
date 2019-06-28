<?xml version="1.0" encoding="iso-8859-1"?>
    <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" />

    <xsl:param name="cgi" select="/root/http-info/cgi" />
    <xsl:variable name="metaiah-tree" select="/root/metaiah"/>
    <xsl:variable name="path-data" select="/root/metaiah/environment/path-data"/>
    <xsl:variable name="path-xml" select="concat(/root/define/DATABASE_PATH,'xml/',$lang)"/>
    <xsl:variable name="path-image" select="concat($path-data,'pt/images/')"/>
    <xsl:variable name="action" select="/root/metaiah/environment/script"/>

    <xsl:param name="lang" select="$cgi/lang" />
    <xsl:param name="metaIAH" select="/root/metaiah/environment/script" />

    <xsl:variable name="bvsRoot" select="document(concat($path-xml,'/bvs.xml'))/bvs" />
    <xsl:variable name="texts" select="$bvsRoot/texts" />

    <xsl:param name="searchTexts" select="document(concat($path-xml,'/metasearch.xml'))/metasearch" />

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="BVS-middle" />
        <!-- generate a empty FORM to submit information by POST method -->
        <xsl:call-template name="formHref"/>
    </xsl:template>

    <xsl:template match="*" mode="BVS-middle">
        <div class="searchResult">
            <div id="search">
                <h3><span><xsl:apply-templates select="$searchTexts/text[@id = 'search_title']" /></span></h3>
                <xsl:call-template name="breadCrumb"/>
                <form name="searchForm" action="{$metaIAH}" method="POST" onsubmit="metaSearch()">
                    <input type="hidden" name="lang" value="{$lang}" />
                    <xsl:apply-templates select="." mode="BVS-middle-search" />
                    <xsl:apply-templates select="." mode="BVS-middle-search-result" />
                </form>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="*" mode="BVS-middle-search-result">
        <div id="result">
            <xsl:call-template name="metaiah-core"/>
        </div>
    </xsl:template>

    <xsl:template match="*" mode="BVS-middle-search">
        <div id="search">
            <div class="searchItens">
                <xsl:apply-templates select="$searchTexts/text[@id = 'search_entryWords']" /><br />
                <input type="text" name="expression" class="expression" value="{$metaiah-tree/control/@expression-label | $metaiah-tree/cgi/expression}" />
                <input type="submit" value="{$searchTexts/text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                <!--
                <input type="radio" name="engine" value="metaiah"  id="engine_metaiah" /> <label for="engine_metaiah"><xsl:apply-templates select="$searchTexts/text[@id ='search_freeSearch']" /></label>
                <input type="radio" name="engine" value="metacollexis" id="engine_metacollexis" checked="checked"/> <label for="engine_metacollexis"><xsl:apply-templates select="$searchTexts/text[@id = 'conceptSearch_title']" /></label>

                <input type="radio" name="connector" value="AND" checked="checked" id="connector_AND"  /> <label for="connector_AND"><xsl:apply-templates select="$searchTexts/text[@id = 'search_allWords']" /></label>
                <input type="radio" name="connector" value="OR" id="connector_OR"/> <label for="connector_OR"><xsl:apply-templates select="$searchTexts/text[@id = 'search_anyWord']" /></label>
                -->
            </div>
            <!--div class="searchFeatures">
                <ul>
                    <li class="advancedSearch"><a href="metaiah.php?lang={$lang}&amp;form=advanced"><xsl:apply-templates select="$searchTexts/text[@id = 'search_advancedSearch']" /></a></li>
                    <li class="how2Search"><a href="../auxiliary/{$lang}/help_search.php" onClick="popUp(this.href,'medium');return false;"><xsl:apply-templates select="$searchTexts/text[@id = 'search_howToSearch']" /></a></li>
                </ul>
            </div-->
        </div>
    </xsl:template>

    <xsl:template name="formHref">
        <form name="formHref" method="post" target="">
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
            <input type="hidden" name="" value=""/>
        </form>
    </xsl:template>


</xsl:stylesheet>
