<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet
     xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:include href="xsl/public/metacollexis/common.xsl"/>

    <xsl:variable name="show-preview" select="$metaiah-tree/cgi/show-preview"/>
    <xsl:variable name="query-string">
        <xsl:apply-templates select="$metaiah-tree/cgi/child::*[not(name()='show-preview')]"/>
    </xsl:variable>

    <xsl:template match="/metaiah/cgi/child::*">

        <xsl:if test="position() &gt; 1">&amp;</xsl:if>
        <xsl:value-of select="concat(name(),'=',translate(text(),' ','+'))"/>

    </xsl:template>

    <xsl:template name="metaiah-core">
        <!--textarea cols="120" rows="20">
            <xsl:copy-of select="."/>
        </textarea-->
        <xsl:call-template name="result-info"/>
    </xsl:template>

    <xsl:template name="breadCrumb">
        <div id="breadCrumb">
            <a href="../index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a> &gt;
            <xsl:choose>
                <xsl:when test="//metaiah/cgi/form = 'advanced'">
                    <a href="javascript:history.back(-1)">
                        <xsl:apply-templates select="$searchTexts/text[@id = 'search_advancedSearch']" />
                    </a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="$searchTexts/text[@id = 'conceptSearch_title']" />
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>

    <xsl:template name="result-info">
        <h4>
            <span>
                <xsl:apply-templates select="$searchTexts/text[@id = 'search_results']" />
                "<xsl:value-of select="$metaiah-tree/control/@expression-label | $metaiah-tree/cgi/expression"/>"&#160;
                <!--
                <xsl:choose>
                    <xsl:when test="$metaiah-tree/cgi/connector='or'"><i>(<xsl:apply-templates select="$searchTexts/text[@id = 'search_anyWords']" />)</i></xsl:when>
                    <xsl:when test="$metaiah-tree/cgi/connector='and'"><i>(<xsl:apply-templates select="$searchTexts/text[@id = 'search_allWords']" />)</i></xsl:when>
                </xsl:choose>
                -->
            </span>
        </h4>
        <!--div id="breadCrumb">
            <a href="../index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a> &gt;
            <xsl:choose>
                <xsl:when test="/metaiah/cgi/form = 'advanced'">
                    <a href="javascript:history.back(-1)">
                        <xsl:apply-templates select="$searchTexts/text[@id = 'search_advancedSearch']" />
                    </a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="$searchTexts/text[@id = 'search_freeSearch']" />
                </xsl:otherwise>
            </xsl:choose>
        </div-->
        <ul>
            <xsl:apply-templates select="$metaiah-tree//result-group[child::*]" mode="info"/>
        </ul>
    </xsl:template>

    <xsl:template match="result-group" mode="info">

        <xsl:variable name="currentLabel" select="@label"/>
        <xsl:variable name="countOriginalItens" select="count($metaiah-tree//group[@label =$currentLabel]/item)"/>
        <xsl:variable name="totalHits" select="sum(source/collexis/search/statistics/count)" />

        <xsl:variable name="browse-overall" select="concat($metaiah-tree/sourceList/group[@label = $currentLabel]/@base-browse-url,'&amp;expression=',$metaiah-tree/cgi/expression)"/>

        <li>
            <xsl:choose>
                <xsl:when test="$countOriginalItens = 1 and $totalHits &gt; 0">
                        <a href="#" onclick="javascript:postHref('{translate(source/@browse-url,'|','&amp;')}')" class="result_set_grp">
                            <xsl:value-of select="@label"/>
                        </a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="#" onclick="javascript:postHref('{$browse-overall}')" class="result_set_grp">
                        <xsl:value-of select="@label"/>
                    </a>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:choose>
                <xsl:when test="$totalHits &gt;= 15000">
                    (15000&#160;<xsl:value-of select="$searchTexts/text[@id = 'search_results']" />)
                </xsl:when>
                <xsl:otherwise>
                    (<xsl:value-of select="$totalHits"/>&#160;<xsl:value-of select="$searchTexts/text[@id = 'search_results']" />)
                </xsl:otherwise>
            </xsl:choose>


            <xsl:if test="$totalHits &gt; 0">
                <ul>
                    <xsl:apply-templates select="source" mode="info"/>
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="source" mode="info">

        <xsl:variable name="sourceHits" select=".//collexis/search/statistics/count"/>

        <li>
            <a href="#" onclick="javascript:postHref('{translate(@browse-url,'|','&amp;')}')" >
                <xsl:value-of select="@label"/>
            </a>
            <xsl:choose>
                <xsl:when test="connection-error">
                    (<xsl:apply-templates select="connection-error"/>)
                </xsl:when>
                <xsl:otherwise>
                    (<xsl:value-of select="$sourceHits"/>&#160;<xsl:apply-templates select="$searchTexts/text[@id = 'search_results']" />)
                </xsl:otherwise>
            </xsl:choose>
        </li>
    </xsl:template>

    <xsl:template match="source/connection-error">
        <xsl:choose>
            <xsl:when test="@status = 'RESOURCE NOT FOUND'"><i>fonte não disponível</i></xsl:when>
            <xsl:when test="@status = 'SERVER UNAVAILABLE'"><i>servidor não disponível</i></xsl:when>
            <xsl:when test="@status = 'SERVER TIMEOUT' or @status = 'REQUEST TIMEOUT'"><i>serviço sobrecarregado</i></xsl:when>
            <xsl:otherwise><i>falha de comunição</i></xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template name="show-itens">
        <xsl:apply-templates select="iah/document"/>
        <xsl:apply-templates select="iyp/browse"/>
        <xsl:apply-templates select="swish/browse"/>
    </xsl:template>

    <xsl:template match="iah/document">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="Citation"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="iyp/browse">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="title | abstract"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="swish/browse">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="Title | content"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="iyp/browse/title">
            <a href="{../href/occ}"><xsl:value-of select="."/></a>
    </xsl:template>

    <xsl:template match="iyp/browse/abstract/occ">
            <i><xsl:value-of select="."/></i><br/>
    </xsl:template>

    <xsl:template match="Title">
            <b><xsl:value-of select="."/></b>
    </xsl:template>

    <xsl:template match="Title[@href]">
            <a href="{@href}"><b><xsl:value-of select="."/></b></a>
    </xsl:template>

    <xsl:template match="content">
            <i><xsl:value-of select="."/></i>
    </xsl:template>

    <xsl:template match="Serial">
            <i><xsl:value-of select="."/></i>
    </xsl:template>

    <xsl:template match="iah/document">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="Citation"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="iyp/browse">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="title | abstract"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="swish/browse">
        <xsl:call-template name="show-item">
            <xsl:with-param name="what" select="Title | content"/>
        </xsl:call-template>
    </xsl:template>

    <xsl:template match="iyp/browse/title">
            <a href="{../href/occ}"><xsl:value-of select="."/></a>
    </xsl:template>

    <xsl:template match="iyp/browse/abstract/occ">
            <i><xsl:value-of select="."/></i><br/>
    </xsl:template>

    <xsl:template match="Title">
            <b><xsl:value-of select="."/></b>
    </xsl:template>

    <xsl:template match="Title[@href]">
            <a href="{@href}"><xsl:value-of select="."/></a>
    </xsl:template>

    <xsl:template match="content">
            <i><xsl:value-of select="."/></i>
    </xsl:template>

    <xsl:template match="Serial">
            <i><xsl:value-of select="."/></i>
    </xsl:template>

    <xsl:template name="show-item">
        <xsl:param name="what"/>
        <xsl:apply-templates select="$what"/>

    </xsl:template>


</xsl:stylesheet>
