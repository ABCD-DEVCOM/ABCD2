<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:include href="tree.xsl"/>

    <xsl:variable name="find-element" select="/root/adm/page[@id = 'generic-xhtml']/edit/tree-edit/@element"/>
    <xsl:variable name="doc-edit" select="document($doc-name)/bvs/*[name() = $find-element]//item[@href = $page]/@file"/>

    <xsl:template match="/">
        <xsl:apply-templates select="root/adm/page[@id = 'generic-xhtml']" mode="html"/>
    </xsl:template>

    <xsl:template match="*" mode="script">
        <script type="text/javascript" src="{$location}js/menu.js"></script>

        <script type="text/javascript">
          _editor_url = "/bvs-mod/HTMLArea/";
          _editor_lang = "en";
        </script>

        <!-- load the main HTMLArea file -->
        <script type="text/javascript" src="/bvs-mod/HTMLArea/htmlarea.js"> /* comentario */ </script>

        <script type="text/javascript">
          HTMLArea.loadPlugin("ContextMenu");
          HTMLArea.loadPlugin("TableOperations");

          var editor = new HTMLArea("editor");
          function initDocument() {
            editor.registerPlugin(ContextMenu);
            editor.registerPlugin(TableOperations);
            editor.generate();
          }
        </script>
    </xsl:template>

    <xsl:template match="*" mode="form-save">
        <input type="hidden" name="xmlSave" value="{$doc-edit}"/>
        <input type="hidden" name="xslSave" value="{$xsl-path}save-xhtml.xsl"/>
    </xsl:template>

    <xsl:template match="*" mode="body">
        <body onload="javascript:initDocument();">
            <xsl:apply-templates select="." mode="form"/>
        </body>
    </xsl:template>

    <xsl:template match="tree-edit">
        <table width="100%" class="tree-edit">
            <tr valign="top">
                <td>
                   <textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">&#160;</textarea>
                  </td>
            </tr>
        </table>
    </xsl:template>



</xsl:stylesheet>

