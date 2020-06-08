<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet
     xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:include href="common.xsl"/>

    <xsl:variable name="searchType" select="/root/http-info/cgi/search_type"/>
    <xsl:variable name="show-preview" select="$metaiah-tree/cgi/show-preview"/>
    <xsl:variable name="query-string">
        <xsl:apply-templates select="$metaiah-tree/cgi/child::*[not(name()='show-preview')]"/>
    </xsl:variable>

    <xsl:variable name="connection-error" select="$metaiah-tree//source/@error"/>

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
                <xsl:when test="$searchType = 'decs'">
                    <a href="../php/decsws.php?lang={$lang}">DeCS/MeSH</a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="$searchTexts/text[@id = 'search_title']" />
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>

    <xsl:template name="result-info">
        <h4>
            <span>
                <xsl:apply-templates select="$searchTexts/text[@id = 'search_results']" /><xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
                <xsl:if test="$searchType != 'decs'">
                        <xsl:value-of select="$metaiah-tree/control/@expression-label | $metaiah-tree/cgi/expression"/>
                </xsl:if>
            </span>
        </h4>

        <div align="right">
               <xsl:if test="$connection-error != ''">
                <strong>!</strong>&#160;<xsl:value-of select="$searchTexts/text[@id = 'connection-error']"/>
            </xsl:if>
        </div>
        <ul>
            <xsl:apply-templates select="$metaiah-tree//result-group[child::*]" mode="info"/>
        </ul>
    </xsl:template>

    <xsl:template match="result-group" mode="info">

        <xsl:variable name="currentLabel" select="@label"/>
        <xsl:variable name="countOriginalItens">
            <xsl:choose>
                <xsl:when test="@sources">
                    <xsl:value-of select="@sources"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="count($metaiah-tree//group[@label =$currentLabel]/item)"/>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <xsl:variable name="totalHits">
            <xsl:choose>
                <xsl:when test="@total">
                    <xsl:value-of select="@total"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="sum(source//iah/prolog/total-hits) +
                                          sum(source//iah/search/Isis_Total/occ) +
                                          sum(source//lis/Isis_Total/occ) +
                                          sum(source//iyp/prolog/Isis_Total/occ) +
                                          sum(source//root/swish-result/index//hits) +
                                          sum(source//fapesp/result/total) +
                                          sum(source//wxis-modules[@IsisScript='search.xis']/search/Isis_Total/occ) +
                                          sum(source//titles/navigation/@total) +
                                          sum(source//myfaq/total) +
                                          sum(source//htdig/total) +
                                          sum(source/collexis/search/statistics/count) +
                                          sum(source//xisis/result/@total) +
                                          sum(source//Result/total) +
                                          sum(source//dir-module//control/total)"/>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <li>
            <xsl:choose>
                <xsl:when test="$countOriginalItens = 1 and $totalHits &gt; 0">
                    <a href="#">
                        <xsl:choose>
                            <xsl:when test="contains(source/@browse-url, 'GET')">
                                <xsl:attribute name="onclick">javascript:this.href = '<xsl:value-of select="translate(source/@browse-url,'|','&amp;')"/>'</xsl:attribute>
                                <xsl:attribute name="target">metaresult</xsl:attribute>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:attribute name="onclick">javascript:postHref('<xsl:value-of select="translate(source/@browse-url,'|','&amp;')"/>','metaresult')</xsl:attribute>
                            </xsl:otherwise>
                        </xsl:choose>
                        <xsl:value-of select="@label"/>
                        (<xsl:value-of select="$totalHits"/><xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text><xsl:value-of select="$searchTexts/text[@id = 'search_results']" />)
                    </a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="@label"/>
                    (<xsl:value-of select="$totalHits"/><xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text><xsl:value-of select="$searchTexts/text[@id = 'search_results']" />)
                    <xsl:if test="$totalHits &gt; 0">
                        <ul>
                            <xsl:apply-templates select="source" mode="info"/>
                        </ul>
                    </xsl:if>
                </xsl:otherwise>
            </xsl:choose>

        </li>
    </xsl:template>

    <xsl:template match="source" mode="info">

        <xsl:variable name="sourceHits">
            <xsl:choose>
                <xsl:when test="@total">
                    <xsl:value-of select="@total"/>
                </xsl:when>
                <xsl:when test=".//swish-result">
                    <xsl:value-of select="sum(root/swish-result/index/hits)"/>
                </xsl:when>
                <xsl:when test=".//cochrane">
                    <xsl:value-of select="sum(.//cochrane//db/wxis-modules[@IsisScript='search.xis']/search/Isis_Total/occ)"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select=".//iah/prolog/total-hits |
                                          .//iah/search/Isis_Total/occ |
                                          .//lis/Isis_Total/occ |
                                          .//iyp/prolog/Isis_Total/occ |
                                          .//fapesp/result/total |
                                          .//wxis-modules[@IsisScript='search.xis']/search/Isis_Total/occ |
                                          .//titles/navigation/@total |
                                          .//myfaq/total |
                                          .//htdig/total |
                                          .//collexis/search/statistics/count |
                                          .//xisis/result/@total |
                                          .//Result/total |
                                          .//dir-module//control/total" />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <li>

            <xsl:choose>
                <xsl:when test="$sourceHits &gt; 0">
                    <a href="#">
                        <xsl:choose>
                            <xsl:when test="contains(@browse-url, 'GET')">
                                <xsl:attribute name="onclick">javascript:this.href = '<xsl:value-of select="translate(@browse-url,'|','&amp;')"/>'</xsl:attribute>
                                <xsl:attribute name="target">metaresult</xsl:attribute>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:attribute name="onclick">javascript:postHref('<xsl:value-of select="translate(@browse-url,'|','&amp;')"/>','metaresult')</xsl:attribute>
                            </xsl:otherwise>
                        </xsl:choose>
                        <xsl:value-of select="@label"/>
                        (<xsl:value-of select="$sourceHits"/>)
                    </a>
                </xsl:when>
                <xsl:when test="@error or error">
                    <xsl:value-of select="@label"/>
                    <span title="{error/@type}"> (<strong>!</strong>) </span>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="@label"/>
                    (<xsl:value-of select="$sourceHits"/>)
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
