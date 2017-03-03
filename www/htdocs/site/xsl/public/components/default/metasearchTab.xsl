<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="metasearch">
        <div id="search" style="display: block;">
            <h3>
                <span class="searchConcepts" id="selected"><a href="#" onClick="MM_showhideLayers('searchConcepts','','none');MM_showhideLayers('search','','block');"><xsl:apply-templates select="text[@id = 'search_freeSearch']" /></a></span>
                <span class="searchConcepts"><a href="#" onClick="MM_showhideLayers('searchConcepts','','block');MM_showhideLayers('search','','none');"><xsl:apply-templates select="text[@id = 'conceptSearch_title']" /></a></span>
            </h3>
            <form name="searchForm" action="../metaiah/search.php" method="POST">
                <input type="hidden" name="lang" value="{$lang}" />
                <input type="hidden" name="group" value="&lt;?= $_REQUEST['id'] ?&gt;" />
                <xsl:apply-templates select="text[@id = 'search_entryWords']" /><br />
                <div class="searchItens">
                    <input type="text" name="expression" class="expression" />
                    <input type="submit" value="{text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                    <!--
                    <input type="radio" name="connector" value="AND" checked="checked" /> <xsl:apply-templates select="text[@id =     'search_allWords']" />
                    <input type="radio" name="connector" value="OR" /> <xsl:apply-templates select="text[@id = 'search_anyWord']" />
                    -->
                 </div>
                <div class="searchFeatures">
                    <ul>
                        <li class="advancedSearch"><a href="../metaiah/search.php?lang={$lang}&amp;form=advanced"><xsl:apply-templates select="text[@id = 'search_advancedSearch']" /></a></li>
                        <li class="how2Search"><a href="../auxiliary/{$lang}/help_search.php" onClick="popUp(this.href,'medium');return false;"><xsl:apply-templates select="text[@id = 'search_howToSearch']" /></a></li>
                    </ul>
                </div>
            </form>
        </div>
        <div id="searchConcepts" style="display: none;">
            <h3>
                <span class="searchConcepts"><a href="#" onClick="MM_showhideLayers('searchConcepts','','none');MM_showhideLayers('search','','block');"><xsl:apply-templates select="text[@id = 'search_freeSearch']" /></a></span>
                <span class="searchConcepts" id="selected"><a href="#" onClick="MM_showhideLayers('searchConcepts','','block');MM_showhideLayers('search','','none');"><xsl:apply-templates select="text[@id = 'conceptSearch_title']" /></a></span>
            </h3>

            <form action="http://collexis.bvsalud.org/regional/index.php" method="post" name="formMain">
                <input type="hidden" name="task" value="search"/>
                <input type="hidden" name="lang" value="{$lang}"/>
                <input type="hidden" name="thesaurus" value="decs2005_{$lang}"/>
                <input type="hidden" name="collection" value="BVS Overall"/>

                <xsl:apply-templates select="text[@id = 'conceptSearch_entryWords']" />:
                <br />
                <div class="searchItens">
                    <textarea name="expression" rows="2" class="expression"></textarea>
                    <input type="submit" class="submit" align="bottom" value="{text[@id = 'search_submit']}" />
                </div>
              </form>
        </div>
    </xsl:template>

    <xsl:template match="metasearch//text">
        <xsl:apply-templates />
    </xsl:template>
</xsl:stylesheet>