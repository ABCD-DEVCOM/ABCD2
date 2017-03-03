<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="tree.xsl"/>

    <xsl:template match="*" mode="script">
        <script type="text/javascript">
            var HTMLAreaElement = null;
            var HTMLAreaModifyButtonLabel = "";
            var HTMLAreaCancelButtonLabel = "";

            function HTMLAreaBox ( selelectedElement, labelModify, labelCancel, language )
            {
                HTMLAreaElement = selelectedElement;
                HTMLAreaModifyButtonLabel = labelModify;
                HTMLAreaCancelButtonLabel = labelCancel;
                HTMLDefaultLanguage = language;

                window.open("../admin/editor/editor.php?lang=<xsl:value-of select='$lang'/>","HTMLArea",
                    "toolbar=no,location=no,directories=no,status=no,menubar=no," +
                    "scrollbars=no,resizable=yes,top=100,left=200,width=815,height=590");

                return;
            }
        </script>
    </xsl:template>

    <xsl:template match="*" mode="form">
        <form name="formPage" action="{$xml2html}?portal={$portal}" method="post" class="{name()}-{@id}">
            <xsl:apply-templates select="bar"/>
            <xsl:apply-templates select="menu|change"/>
        </form>
    </xsl:template>

    <xsl:template match="flag">
        <xsl:variable name="find-flag" select="@name"/>
        <xsl:variable name="flag-found" select="$cgi/buffer/*[name() = $find-flag]"/>

        <xsl:apply-templates select="." mode="flag-show">
            <xsl:with-param name="curr-value" select="$flag-found"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="change">
        <div class="{name()}">
            <ul>
                <xsl:apply-templates/>
            </ul>
        </div>
    </xsl:template>

    <xsl:template match="item[@edit]">
        <li>
            <label for="{@name}"><xsl:apply-templates select="text()"/></label>
            <xsl:apply-templates select="." mode="edit"/>
        </li>
    </xsl:template>

    <xsl:template match="item[@edit = 'hidden']">
        <xsl:variable name="find-name" select="@name"/>
        <input type="hidden" name="{@name}" value="{@value}{$cgi/buffer/*[name() = $find-name]}"/>
    </xsl:template>

    <xsl:template match="item[@edit = 'readonly']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>
        <input type="hidden" name="{@name}" value="{@value}{$cgi/buffer/*[name() = $find-name]}"/>
        <strong><xsl:value-of select="concat(@value,$cgi/buffer/*[name() = $find-name])"/></strong>
    </xsl:template>


    <xsl:template match="item[@edit = 'text']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>
        <input type="{@edit}" id="{@name}" name="{@name}" value="{$cgi/buffer/*[name() = $find-name]}"/><br/>
    </xsl:template>


    <xsl:template match="item[@edit = 'password']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>
        <input type="password" id="{@name}" name="{@name}"/><br/>
    </xsl:template>

    <xsl:template match="item[@edit = 'textarea']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>

        <textarea cols="70" rows="5" name="{@name}"><xsl:apply-templates select="$cgi/buffer/*[name() = $find-name]" mode="copy"/><xsl:value-of select="' '"/></textarea><br/>
    </xsl:template>

    <xsl:template match="item[@edit = 'htmlarea']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>
        <a href="" onclick="javascript: HTMLAreaBox(document.formPage.{@name},'{@label-modify}','{@label-cancel}','{/root/adm/@language}'); return false;" target="HTMLArea"><xsl:value-of select="@label-edit"/></a>
        <textarea cols="70" rows="10" id="{@name}" name="{@name}"><xsl:apply-templates select="$cgi/buffer/*[name() = $find-name]" mode="copy"/><xsl:value-of select="' '"/></textarea>
    </xsl:template>

    <xsl:template match="item[@edit = 'select']" mode="edit">
        <xsl:variable name="find-name" select="@name"/>

        <select name="{@name}" size="1">
            <xsl:apply-templates select="option" mode="option"/>
        </select><br/>
    </xsl:template>

    <xsl:template match="*" mode="option">
        <xsl:variable name="find-name" select="parent::node()/@name"/>

        <xsl:element name="option">
            <xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
            <xsl:if test="@value = $cgi/buffer/*[name() = $find-name]">
                <xsl:attribute name="selected"></xsl:attribute>
            </xsl:if>
            <xsl:apply-templates/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="@*" mode="copy-of">
        <xsl:attribute name="{name()}"><xsl:value-of select="."/></xsl:attribute>
    </xsl:template>

    <xsl:template match="item[@edit = 'group']">
        <li>
            <xsl:apply-templates select="text()"/>
            <ul>
                <xsl:apply-templates select="item"/>
            </ul>
        </li>
    </xsl:template>

    <xsl:template match="item[@edit = 'group-id']">

        <xsl:for-each select="$doc-xml//item[@type = 'collection']">
            <xsl:apply-templates select="document(concat($base-path,@file))/collection//item[meta-search/@base-search-url]" mode="info-source">
                <xsl:with-param name="colid" select="@id"/>
            </xsl:apply-templates>
        </xsl:for-each>

    </xsl:template>

    <xsl:template match="item" mode="info-source">
        <xsl:param name="colid"/>
        <xsl:variable name="source-id" select="concat('info-source-id_',$colid,'-',@id)"/>

        <li>
            <label for="{$source-id}"><xsl:apply-templates select="text()"/></label>
            <input type="text" name="{$source-id}" value="{$cgi/buffer/*[name() = $source-id]}"/><br/>
        </li>
    </xsl:template>

</xsl:stylesheet>

