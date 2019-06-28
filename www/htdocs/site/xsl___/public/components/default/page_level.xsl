<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" omit-xml-declaration="yes" encoding="iso-8859-1"/>
    <xsl:include href="../texts.xsl"/>

    <xsl:param name="base-path" select="/root/define/DATABASE_PATH"/>

    <xsl:param name="component" select="/root/http-info/VARS/component" />
    <xsl:param name="item" select="/root/http-info/cgi/item" />

    <xsl:param name="texts" select="/root/bvs/texts" />
    <xsl:param name="bvsRoot" select="/root/bvs" />
    <xsl:param name="metaIAH" select="'../metaiah/search.php'" />
    <xsl:param name="lang" select="/root/http-info//lang" />
    
    <xsl:param name="portal" select="''" />
    <xsl:variable name="portal_param">
        <xsl:choose>
            <xsl:when test="$portal != ''">
                <xsl:value-of select="concat('&amp;portal=',$portal)" />
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$portal" />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="/">
        <!--textarea cols="120" rows="20">
            <xsl:copy-of select="."/>
        </textarea-->
        <xsl:apply-templates select="$bvsRoot/collectionList//item[@id = $component]" />
    </xsl:template>

    <xsl:template match="collectionList//item">
        <xsl:param name="informationSourceName" select="text()" />
        <xsl:variable name="file" select="concat($base-path,@file)"/>

        <div id="{name(document($file)/node())}">
        <xsl:choose>
            <xsl:when test="$item != ''">
                <xsl:apply-templates select="document($file)//item[@id = $item]" mode="head">
                    <xsl:with-param name="informationSourceName" select="$informationSourceName" />
                </xsl:apply-templates>
            </xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates select="document($file)/node()" mode="head">
                    <xsl:with-param name="informationSourceName" select="$informationSourceName" />
                </xsl:apply-templates>
            </xsl:otherwise>
        </xsl:choose>
        </div>
    </xsl:template>

    <xsl:template match="*" mode="head">
        <xsl:param name="informationSourceName" />

        <h3><span><xsl:apply-templates select="$informationSourceName" /></span></h3>
        <div id="breadCrumb">
            <a href="../index.php?lang={$lang}{$portal_param}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a>
            &gt; <xsl:apply-templates select="$informationSourceName" />
        </div>
        <div class="content">
            <xsl:if test="string-length(.//@base-search-url) &gt; 0">
                <xsl:apply-templates select="." mode="metasearch"/>
            </xsl:if>

            <h4><span><xsl:apply-templates select="$informationSourceName" /></span></h4>
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </div>
    </xsl:template>


    <xsl:template match="//item" mode="head">
        <xsl:param name="informationSourceName" />

        <h3><span><xsl:apply-templates select="$informationSourceName" /></span></h3>
        <div id="breadCrumb">
            <a href="../index.php?lang={$lang}{$portal_param}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a>
            <xsl:if test="ancestor::item">
                &gt;
                <xsl:apply-templates select="ancestor::item" mode="breadCrumb" />
            </xsl:if>
            &gt; <xsl:apply-templates select="text()" />
        </div>
        <div class="content">
            <xsl:if test="string-length(.//@base-search-url) &gt; 0">
                <xsl:apply-templates select="." mode="metasearch"/>
            </xsl:if>

            <h4><span><xsl:apply-templates select="text()" /></span></h4>
            <xsl:apply-templates select="portal" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </div>
    </xsl:template>


    <xsl:template match="item" mode="breadCrumb">
        <a href="../php/level.php?lang={$lang}&amp;component={$component}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a>
        <xsl:if test="position() != last()"> &gt; </xsl:if>
    </xsl:template>

    <xsl:template match="item[@img]" mode="breadCrumb">
        <a href="../php/level.php?lang={$lang}&amp;component={$component}&amp;item={@id}{$portal_param}"><img src="{@img}" alt="text()" /></a>
        <xsl:if test="position() != last()"> &gt; </xsl:if>
    </xsl:template>

    <xsl:template match="collection//item | community//item | about//item | portal//item">
        <li>
            <h5><a href="../php/level.php?lang={$lang}&amp;component={$component}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a></h5>
            <xsl:apply-templates select="description" />
        </li>
    </xsl:template>

    <!-- caramez 09-03-06 -->
    <xsl:template match="warning//item">
        <li>
            <h5><xsl:apply-templates select="text()" /></h5>
            <xsl:apply-templates select="description" />
        </li>
    </xsl:template>

    <xsl:template match="topic//item">
        <li>
            <h5><xsl:apply-templates select="text()" /></h5>
            <xsl:apply-templates select="description" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="topic//item[meta-search/info-source]">
        <li>
            <h5><a href="{$metaIAH}?lang={$lang}&amp;topic={concat($component,'-',@id)}"><xsl:apply-templates select="text()"/></a></h5>
            <xsl:apply-templates select="description" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="collection//item[@href != ''] | community//item[@href != ''] | about//item[@href != ''] | portal//item[@href != '']">
        <li>
            <h5><a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a></h5>
            <xsl:apply-templates select="description" />
        </li>
    </xsl:template>

    <xsl:template match="collection//portal | community//portal | about//portal | portal//portal">
        <div class="portal">
            <xsl:choose>
                <xsl:when test="count(child::*) &gt; 0">
                    <xsl:copy-of select="* | @* | text()" />
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="." disable-output-escaping="yes"/>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>

    <xsl:template match="collection//description | community//description | about//description | portal//description | warning//description | topic//description">
        <div class="description">
            <xsl:choose>
                <xsl:when test="count(child::*) &gt; 0">
                    <xsl:copy-of select="* | @* | text()" />
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="." disable-output-escaping="yes"/>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>
    <!-- end -->

    <xsl:template match="portal//item">
        <li>
            <xsl:choose>
                <xsl:when test="name(ancestor::node()) = 'item'">
                    <a href="../php/level.php?lang={$lang}&amp;component={$component}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <h5><a href="../php/level.php?lang={$lang}&amp;component={$component}&amp;item={@id}{$portal_param}"><xsl:apply-templates select="text()" /></a></h5>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:apply-templates select="description" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="portal//item[@href != '']">
        <li>
            <xsl:choose>
                <xsl:when test="ancestor::item">
                    <a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a>
                </xsl:when>
                <xsl:otherwise>
                    <h5><a href="{@href}" target="_blank"><xsl:apply-templates select="text()" /></a></h5>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:apply-templates select="description" />
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" />
                </ul>
            </xsl:if>
        </li>
    </xsl:template>

    <xsl:template match="*" mode="metasearch">
        <xsl:variable name="texts" select="document(concat($base-path,'xml/',$lang,'/metasearch.xml'))/metasearch"/>

        <div id="search">
            <form name="searchForm" action="../metaiah/search.php" method="POST">
                <input type="hidden" name="portal" value="{$portal}" />
                <input type="hidden" name="lang" value="{$lang}" />
                <input type="hidden" name="form" value="advanced" />
                <input type="hidden" name="selected_sources[{normalize-space(text())}]" value="true"/>
                <xsl:for-each select=".//item">
                    <input type="hidden" name="selected_sources[{normalize-space(text())}]" value="true"/>
                </xsl:for-each>

                <div class="searchItens">
                    <xsl:apply-templates select="$texts/text[@id = 'search_entryWords']" /><br />
                    <input type="text" name="expression" class="expression" id="expression"/>
                    <input type="submit" value="{$texts/text[@id = 'search_submit']}" name="submit" class="submit" /><br />
                 </div>
            </form>
        </div>
    </xsl:template>

    <xsl:template match="*[@available = 'no']" />

</xsl:stylesheet>