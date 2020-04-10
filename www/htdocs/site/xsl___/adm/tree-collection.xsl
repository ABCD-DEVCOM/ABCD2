<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="tree.xsl"/>

    <xsl:variable name="find-element" select="/root/adm/page[@id = $page]/edit/tree-edit/@element"/>

    <xsl:variable name="doc-file">
            <xsl:choose>
                <xsl:when test="$id != ''">
                    <xsl:value-of select="$doc-xml/bvs/*[name() = $find-element]//item[@id = $id]/@file"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="$doc-xml/bvs/*[name() = $find-element]//item[@type = $page]/@file"/>
                </xsl:otherwise>
            </xsl:choose>
    </xsl:variable>
    <xsl:variable name="doc-edit" select="concat($base-path,$doc-file)"/>


    <xsl:template match="*" mode="form-save">
        <input type="hidden" name="xmlSave" value="{$doc-file}"/>
        <input type="hidden" name="xslSave" value="{$xsl-path}save.xsl"/>
    </xsl:template>

    <xsl:template match="tree-edit">
        <xsl:variable name="select" select="document($doc-edit)/*[name() = $page]"/>

        <xsl:apply-templates select="$select" mode="next-id"/>

        <xsl:apply-templates select="." mode="select">
            <xsl:with-param name="select" select="$select"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="flag">
        <xsl:variable name="find-element" select="@element"/>
        <xsl:variable name="find-flag" select="@name"/>
        <xsl:variable name="flag-found" select="document($doc-edit)/*[name() = $find-element]/@*[name() = $find-flag]"/>

        <xsl:apply-templates select="." mode="flag-show">
            <xsl:with-param name="curr-value" select="$flag-found"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="collection | topic | community" mode="next-id">
        <xsl:apply-templates select="//item[@id &gt; 0]" mode="sorted-id">
            <xsl:sort select="@id" data-type="number" order="descending"/>
        </xsl:apply-templates>
        <xsl:if test="not(//item[@id != ''])">
            <script type="text/javascript">
                <xsl:comment>
                    var nextId =  1;
                </xsl:comment>
            </script>
        </xsl:if>
    </xsl:template>

    <xsl:template match="item" mode="sorted-id">
        <xsl:if test="position() = 1">
            <script type="text/javascript">
                <xsl:comment>
                    var nextId = <xsl:value-of select="@id"/> + 1;
                </xsl:comment>
            </script>
        </xsl:if>
    </xsl:template>

    <!-- collection -->
    <xsl:template match="collection//item" mode="array">
        "<xsl:element name="available"><xsl:apply-templates select="@available" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="id"><xsl:apply-templates select="@id" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="name"><xsl:apply-templates select="text()" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="img"><xsl:apply-templates select="@img" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="href"><xsl:apply-templates select="@href" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="description"><xsl:apply-templates select="description" mode="copy-js"/><xsl:value-of select="' '"/></xsl:element>" +
        "<xsl:element name="portal"><xsl:apply-templates select="portal" mode="copy-js"/><xsl:value-of select="' '"/></xsl:element>" +
        "<xsl:element name="base-search-url"><xsl:apply-templates select="meta-search/@base-search-url" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="search-parameters"><xsl:apply-templates select="meta-search/@search-parameters" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="base-browse-url"><xsl:apply-templates select="meta-search/@base-browse-url" mode="escape_quotes_js"/></xsl:element>",
        <xsl:apply-templates select="item" mode="array"/>
    </xsl:template>
    <!-- /collection -->

    <!-- community -->
    <xsl:template match="community//item" mode="array">
        "<xsl:element name="available"><xsl:apply-templates select="@available" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="id"><xsl:apply-templates select="@id" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="name"><xsl:apply-templates select="text()" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="img"><xsl:apply-templates select="@img" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="href"><xsl:apply-templates select="@href" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="portal"><xsl:apply-templates select="portal" mode="copy-js"/><xsl:value-of select="' '"/></xsl:element>" +
        "<xsl:element name="description"><xsl:apply-templates select="description" mode="copy-js"/><xsl:value-of select="' '"/></xsl:element>",
        <xsl:apply-templates select="item" mode="array"/>
    </xsl:template>
    <!-- /community -->


    <!-- topic -->
    <xsl:template match="topic//item" mode="array">
        "<xsl:element name="available"><xsl:apply-templates select="@available" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="id"><xsl:apply-templates select="@id" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="name"><xsl:apply-templates select="text()" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="description"><xsl:apply-templates select="description" mode="copy-js"/><xsl:value-of select="' '"/></xsl:element>" +
        "<xsl:apply-templates select="meta-search/info-source" mode="array"/>",
        <xsl:apply-templates select="item" mode="array"/>
    </xsl:template>

    <xsl:template match="info-source" mode="array">
        <xsl:element name="info-source-id_{@id}"><xsl:apply-templates select="@search-parameters" mode="escape_quotes_js"/></xsl:element>
    </xsl:template>

    <!-- /topic -->

    <!-- decs -->
    <xsl:template match="decs//item" mode="array">
        "<xsl:element name="category"><xsl:apply-templates select="@category" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="name"><xsl:apply-templates select="text()" mode="escape_quotes_js"/></xsl:element>",
    </xsl:template>
    <!-- /decs -->

    <!-- meta tags -->
    <xsl:template match="metainfo//item" mode="array">
        "<xsl:element name="available"><xsl:apply-templates select="@available" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="id"><xsl:apply-templates select="@id" mode="escape_quotes_js"/></xsl:element>" +
        "<xsl:element name="tag_content"><xsl:apply-templates select="." mode="copy-js"/></xsl:element>",
    </xsl:template>

    <xsl:template match="metainfo//item" mode="option">
        <option value="0"><xsl:value-of select="@id"/></option>
    </xsl:template>
    <!-- /meta tags -->

</xsl:stylesheet>
