<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" encoding="iso-8859-1"/>

    <xsl:variable name="base-path" select="/root/define/DATABASE_PATH"/>
    <xsl:variable name="cgi" select="/root/http-info/cgi"/>
    <xsl:variable name="page" select="$cgi/page"/>
    <xsl:variable name="id" select="$cgi/id"/>
    <xsl:variable name="doc-name" select="concat($base-path,$cgi/xmlSave)"/>

    <xsl:template match="/">
        <xsl:apply-templates select="document($doc-name)/*"/>
    </xsl:template>

    <xsl:template match="@* | comment()">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>


    <xsl:template match="*[substring(name(),1,10) = 'attribute_']">
        <xsl:attribute name="{substring(name(),11)}"><xsl:value-of select="."/></xsl:attribute>
    </xsl:template>

    <xsl:template match="*">
        <xsl:choose>
            <xsl:when test="name() = $page">
                <xsl:element name="{name()}">
                    <xsl:attribute name="id"><xsl:value-of select="$cgi/id"/></xsl:attribute>
                    <xsl:attribute name="available"><xsl:value-of select="$cgi/available"/></xsl:attribute>
                    <xsl:apply-templates select="$cgi/buffer/*" mode="cgi"/>
                </xsl:element>
            </xsl:when>
            <xsl:otherwise>
                <xsl:copy>
                    <xsl:apply-templates select="* | @* | text() | comment()"/>
                </xsl:copy>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="item" mode="cgi">
        <xsl:choose>
            <xsl:when test="$cgi/page = 'about'">
                <xsl:element name="item">
                    <xsl:apply-templates select="id" mode="cgi"/>
                    <xsl:apply-templates select="available" mode="cgi"/>
                    <xsl:apply-templates select="href" mode="cgi"/>
                    <xsl:apply-templates select="img" mode="cgi"/>
                    <xsl:apply-templates select="name/text()"/>
                    <xsl:apply-templates select="description" mode="cgi"/>
                    <xsl:apply-templates select="portal" mode="cgi"/>
                    <xsl:apply-templates select="item" mode="cgi"/>
                </xsl:element>
            </xsl:when>
            <xsl:otherwise>
                <xsl:element name="item">
                    <xsl:apply-templates select="id" mode="cgi"/>
                    <xsl:apply-templates select="available" mode="cgi"/>
                    <xsl:apply-templates select="href" mode="cgi"/>
                    <xsl:apply-templates select="img" mode="cgi"/>
                    <xsl:apply-templates select="file" mode="cgi"/>
                    <xsl:apply-templates select="adm" mode="cgi"/>
                    <xsl:apply-templates select="name/text()"/>
                    <xsl:apply-templates select="description" mode="cgi"/>
                    <xsl:apply-templates select="portal" mode="cgi"/>
                    <xsl:apply-templates select="item" mode="cgi"/>
                </xsl:element>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="attach" mode="cgi">
        <xsl:element name="attach">
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="type" mode="cgi"/>
            <xsl:apply-templates select="file" mode="cgi"/>
            <xsl:apply-templates select="adm" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="text" mode="cgi">
        <xsl:element name="text">
            <xsl:apply-templates select="id" mode="attribute"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="img" mode="cgi"/>
            <xsl:apply-templates select="text_content" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="user" mode="cgi">
        <xsl:element name="user">
            <xsl:apply-templates select="name" mode="cgi"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="type" mode="cgi"/>
            <xsl:apply-templates select="password" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="id | name | available | href | img | type | file | adm | base-search-url | search-parameters | base-browse-url | password | category" mode="cgi">
        <xsl:if test="normalize-space(.) != ''">
            <xsl:attribute name="{name()}"><xsl:apply-templates select="text()"/></xsl:attribute>
        </xsl:if>
    </xsl:template>

    <xsl:template match="*" mode="attribute">
        <xsl:if test="normalize-space(.) != ''">
            <xsl:attribute name="{name()}"><xsl:apply-templates select="text()"/></xsl:attribute>
        </xsl:if>
    </xsl:template>

    <xsl:template match="item-component" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="id" mode="cgi"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="href" mode="cgi"/>
            <xsl:apply-templates select="type" mode="cgi"/>
            <xsl:apply-templates select="img" mode="cgi"/>
            <xsl:if test="type != ''">
                <xsl:attribute name="file"><xsl:value-of select="concat('xml/',$cgi/lang,'/',id,'.xml')"/></xsl:attribute>
            </xsl:if>
            <xsl:apply-templates select="name/text()"/>
            <xsl:apply-templates select="item-component" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="item-collection" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="id" mode="cgi"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="href" mode="cgi"/>
            <xsl:apply-templates select="img" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
            <xsl:apply-templates select="description" mode="cgi"/>
            <xsl:apply-templates select="portal" mode="cgi"/>
            <meta-search>
                <xsl:apply-templates select="base-search-url" mode="cgi"/>
                <xsl:apply-templates select="search-parameters" mode="cgi"/>
                <xsl:apply-templates select="base-browse-url" mode="cgi"/>
            </meta-search>
            <xsl:apply-templates select="item-collection" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="description | portal" mode="cgi">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text() | comment()"/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match="item-topic" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="id" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
            <xsl:apply-templates select="description" mode="cgi"/>
            <meta-search>
                <xsl:apply-templates select="*" mode="topic"/>
            </meta-search>
            <xsl:apply-templates select="item-topic" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="*" mode="topic">
        <xsl:variable name="id" select="substring-after(name(),'info-source-id_')"/>
        <xsl:if test="$id != '' and normalize-space(.) != ''">
            <xsl:element name="info-source">
                <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
                <xsl:attribute name="search-parameters"><xsl:value-of select="."/></xsl:attribute>
            </xsl:element>
        </xsl:if>
    </xsl:template>

    <xsl:template match="item-community" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="id" mode="cgi"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="href" mode="cgi"/>
            <xsl:apply-templates select="img" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
            <xsl:apply-templates select="description" mode="cgi"/>
            <xsl:apply-templates select="portal" mode="cgi"/>
            <xsl:apply-templates select="item-community" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="item-responsable" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="name"/>
            <xsl:apply-templates select="description" mode="cgi"/>
            <xsl:apply-templates select="item" mode="cgi"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="item-decs" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="category" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="item-metainfo" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="id" mode="attribute"/>
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="tag_content" mode="cgi"/>
        </xsl:element>
    </xsl:template>


    <xsl:template match="warning" mode="cgi">
        <xsl:element name="item">
            <xsl:apply-templates select="available" mode="cgi"/>
            <xsl:apply-templates select="name/text()"/>
            <xsl:apply-templates select="description" mode="cgi"/>
        </xsl:element>
    </xsl:template>


    <xsl:template match="warning_text | text_content" mode="cgi">
        <!--<xsl:if test="normalize-space(.) != '' or child::*">-->
        <xsl:apply-templates select="text() | *"/>
        <!--</xsl:if>-->
    </xsl:template>

    <xsl:template match="description//script | portal//script">
        <xsl:element name="{name()}">
            <xsl:for-each select="@*">
                <xsl:attribute name="{name()}"><xsl:value-of select="."/></xsl:attribute>
            </xsl:for-each>
            <xsl:choose>
                <xsl:when test="string-length(text()) = 0">
                    <xsl:value-of select="concat('/*',name(),'*/')"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:template>

    <xsl:template match="description//style | portal//style">
        <!-- Anula todas as tag <style> -->
    </xsl:template>

    <xsl:template match="description//link | portal//link">
        <!-- Anula todas as tag <link> -->
    </xsl:template>

    <xsl:template match="description//object | portal//object">
        <!-- Anula todas as tag <object> -->
    </xsl:template>

    <xsl:template match="description//text() | portal//text()">
        <xsl:value-of select="."/>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="normalize-space(.)"/>
    </xsl:template>

</xsl:stylesheet>
