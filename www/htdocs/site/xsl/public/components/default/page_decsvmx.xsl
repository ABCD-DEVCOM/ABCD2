<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes" omit-xml-declaration="yes" encoding="iso-8859-1" />

    <xsl:param name="expression" select="/root/http-info/VARS/expression" />
    <xsl:param name="source" select="/root/http-info/VARS/source" />
    <xsl:param name="tree_id" select="/root/http-info/cgi/tree_id" />
    <xsl:param name="lang" select="/root/http-info/VARS/lang" />
    <xsl:param name="autocompleteTerm" select="/root/http-info/cgi/autocomplete_term" />
    <xsl:param name="script" select="/root/http-info/server/PHP_SELF" />
    <xsl:param name="decsWs" select="/root//decsws_response" />
    <xsl:param name="base-path" select="/root/define/DATABASE_PATH" />
    <xsl:variable name="terms" select="/root/http-info/session/terms"/>

    <xsl:param name="texts" select="document(concat($base-path,'xml/',$lang,'/decsws.xml'))/texts" />

    <!-- cria variavel que contem o ID do pai do termo selecionado pelo usuario -->
    <xsl:variable name="termId" select="$decsWs/@tree_id"/>
    <xsl:variable name="termParent">
        <xsl:choose>
            <xsl:when test="contains($termId, '.')">
                <xsl:value-of select="substring($termId,1,string-length($termId)-4)"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="translate($termId, '0123456789', '')"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="script"/>

        <!-- debug area 
        <textarea cols="80" rows="10">
            <xsl:copy-of select="."/>
        </textarea>
        -->
        <div id="breadCrumb">
            <a href="../php/index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a>
            &gt;
            <a href="{concat($script,'?lang=',$lang)}"><xsl:value-of select="$texts/text[@id = 'all_categories']" /></a>
            <xsl:apply-templates select="$decsWs/tree/ancestors" mode="breadcrumb"/>
        </div>

        <div id="decs" style="width: 100%;">
            <h3><span><xsl:value-of select="$texts/text[@id = 'search_terms']"/></span></h3>
            <xsl:call-template name="autocomplete"/>
        </div>

        <div id="{$source}">
            <h3><span><xsl:value-of select="$texts/text[@id = 'hierarchy']"/></span></h3>
            <div id="boxContent">
                <xsl:if test="$autocompleteTerm != '' or $decsWs/tree/self/term_list/term">
                    <div id="title">
                        <xsl:choose>
                            <xsl:when test="$autocompleteTerm">
                                <xsl:apply-templates select="$autocompleteTerm" mode="title"/>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:apply-templates select="$decsWs/tree/self/term_list/term" mode="title"/>
                            </xsl:otherwise>
                        </xsl:choose>
                    </div>
                </xsl:if>

                <!-- hierarchy level -->
                <div>
                    <xsl:apply-templates select="." mode="hierarchy"/>
                </div>
                <xsl:if test="$decsWs/record_list/record/definition/occ/@n = '' or not($decsWs/record_list)">
                    <ul>
                        <xsl:apply-templates select="$decsWs/tree/term_list[@lang = $lang]"/>
                    </ul>
                </xsl:if>
            </div>
        </div>

        <div id="{$source}">
            <h3><span><xsl:value-of select="$texts/text[@id = 'selection']"/></span></h3>
            <div class="selectionArea">
                <form name="send2search" action="./decsBasketSearch.php">
                    <input type="hidden" name="lang" value="{$lang}"/>
                    <xsl:apply-templates select="." mode="basket"/>
                </form>
            </div>
        </div>

    </xsl:template>

    <xsl:template match="*" mode="title">
        <xsl:variable name="tmp" select="translate($tree_id, '0123456789', '9999999999')"/>
        <!-- cria variavel com as opcoes que o termo possue: X (delete) Q (pode conter qualificadores) Ex (pode utilizar explode) -->
        <xsl:variable name="options">
            <xsl:text>X</xsl:text>
            <xsl:if test="contains($tmp,'9')">
                    <xsl:text>Q</xsl:text>
            </xsl:if>
            <xsl:if test="not(@leaf) or @leaf = 'false'">
                <xsl:text>Ex</xsl:text>
            </xsl:if>
        </xsl:variable>

        <span title="{$tree_id}">
            <xsl:value-of select="."/>
        </span>
        <span class="actions" id="slidingProduct{$tree_id}">
            <!-- quando é categoria não mostrar botão de detalhes -->
            <xsl:if test="contains($options,'Q')">
                <a href="#" onclick="showTermInfo('{$tree_id}');return false;"><img src="../image/common/decs/info.gif" title="{$texts/text[@id = 'info']}" alt="{$texts/text[@id = 'info']}"/></a>
            </xsl:if>
            <a href="#" onclick="addToBasket('{$tree_id}','{.}','{$options}');return false;"><img src="../image/common/decs/select.gif" title="{$texts/text[@id = 'select']}" alt="{$texts/text[@id = 'select']}"/></a>
        </span>
    </xsl:template>


    <xsl:template match="*" mode="hierarchy">
        <!-- nao apresenta hierarquia para qualificadores -->
        <xsl:if test="not( starts-with($tree_id, 'Q') )">
            <xsl:choose>
                <xsl:when test="$decsWs//tree/ancestors/term_list/term">
                    <xsl:apply-templates select="$decsWs//tree/ancestors"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="$decsWs//tree/self"/>
                    <ul>
                        <xsl:apply-templates select="$decsWs//tree/descendants"/>
                    </ul>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:if>
    </xsl:template>


    <xsl:template match="term_list">
        <xsl:apply-templates select="term" />
    </xsl:template>

    <xsl:template match="term_list/term">
        <xsl:if test="text()">
            <li>
                <xsl:apply-templates select="." mode="format"/>
            </li>
        </xsl:if>
    </xsl:template>

    <xsl:template match="*" mode="format">
        <!--
        <xsl:choose>
            <xsl:when test="not(@leaf) or @leaf = 'false'">
                +
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>&#160;&#160;&#160;</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
        -->
        <xsl:variable name="tmp" select="translate(@tree_id, '0123456789', '9999999999')"/>
        <!-- cria variavel com as opcoes que o termo possue: X (delete) Q (pode conter qualificadores) Ex (pode utilizar explode) -->
        <xsl:variable name="options">
            <xsl:text>X</xsl:text>
            <xsl:if test="contains($tmp,'9')">
                    <xsl:text>Q</xsl:text>
            </xsl:if>
            <xsl:if test="not(@leaf) or @leaf = 'false'">
                <xsl:text>Ex</xsl:text>
            </xsl:if>
        </xsl:variable>

        <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}" title="{@tree_id}">
            <xsl:value-of select="."/>
        </a>
        <xsl:if test="not(@leaf) or @leaf = 'false'">
            <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}" title="{@tree_id}">+</a>
        </xsl:if>

        <span class="actions" id="slidingProduct{@tree_id}">
            <!-- quando é categoria não mostrar botão de detalhes -->
            <xsl:if test="contains($options,'Q')">
                <a href="#" onclick="showTermInfo('{@tree_id}');return false;"><img src="../image/common/decs/info.gif" title="{$texts/text[@id = 'info']}" alt="{$texts/text[@id = 'info']}"/></a>
            </xsl:if>
            <a href="#" onclick="addToBasket('{@tree_id}','{.}','{$options}');return false;"><img src="../image/common/decs/select.gif" title="{$texts/text[@id = 'select']}" alt="{$texts/text[@id = 'select']}"/></a>
        </span>
    </xsl:template>


    <xsl:template match="self | following_sibling | descendants | preceding_sibling">
        <ul>
            <xsl:apply-templates select="term_list" />
        </ul>
    </xsl:template>

    <xsl:template match="ancestors">
        <ol>
            <xsl:for-each select="term_list/term">
                <xsl:variable name="tmp" select="translate(@tree_id, '0123456789', '9999999999')"/>
                <!-- aplica somente para as primeiras categorias (não contem número no ID) -->
                <xsl:if test="not( contains($tmp, '9') )">
                    <div id="{@tree_id}">
                        <xsl:apply-templates select=".">
                            <xsl:with-param name="pos" select="position()"/>
                        </xsl:apply-templates>
                    </div>
                </xsl:if>

            </xsl:for-each>
        </ol>
    </xsl:template>

    <xsl:template match="ancestors//term">
        <xsl:param name="pos" select="position()"/>
        <xsl:variable name="nextId" select="following-sibling::term[1]/@tree_id"/>
        <xsl:variable name="currentId" select="@tree_id"/>

        <li>
            <xsl:if test="text() != ''">
                <xsl:apply-templates select="." mode="format"/>
            </xsl:if>
            <ul>
                <xsl:apply-templates select="following-sibling::term[1][string-length(@tree_id) &gt; string-length($currentId) and contains(@tree_id,$currentId) ]">
                    <xsl:with-param name="pos" select="$pos"/>
                </xsl:apply-templates>
            </ul>
            <!-- and string-length(@tree_id) &gt; string-length($nextId) -->

            <xsl:choose>
                <!-- caso seja a categoria do termo selecionado -->
                <xsl:when test="@tree_id = $termParent" >
                    <xsl:apply-templates select="$decsWs/tree/preceding_sibling"/>
                    <ul>
                        <xsl:apply-templates select="$decsWs/tree/self"/>
                        <ul>
                            <xsl:apply-templates select="$decsWs/tree/descendants"/>
                        </ul>
                    </ul>
                    <xsl:apply-templates select="$decsWs/tree/following_sibling"/>
                </xsl:when>
                <!-- caso seja o ultimo nivel da categoria mostra o termo -->
                <xsl:when test="not( contains($nextId, $currentId) )">
                    <xsl:apply-templates select="$decsWs/tree/self"/>
                </xsl:when>
            </xsl:choose>
        </li>
    </xsl:template>

    <xsl:template match="self//term">
        <li><strong><xsl:apply-templates select="." mode="format"/></strong></li>
    </xsl:template>


    <xsl:template match="ancestors" mode="breadcrumb">

        <xsl:apply-templates select="term_list/term[@tree_id = $termParent]" mode="breadcrumb"/>

    </xsl:template>

    <xsl:template match="ancestors//term" mode="breadcrumb">
        <xsl:variable name="currentId" select="@tree_id"/>

        <xsl:apply-templates select="preceding-sibling::term[1][string-length(@tree_id) &lt; string-length($currentId) ]" mode="breadcrumb"/>
        &gt;
        <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
            <xsl:value-of select="."/>
        </a>
    </xsl:template>

    <xsl:template match="self//term" mode="sectionTitle">
        <div id="slidingProduct{@tree_id}" class="sliding_product">
            <a href="#" onclick="addToBasket('{@tree_id}','{.}');return false;"><xsl:value-of select="."/></a>
        </div>
    </xsl:template>

    <xsl:template name="autocomplete">
            <!-- AUTOCOMPLETE CODE -->
            <form action="../php/decsws.php" method="get" name="decswsForm">
                  <input type="hidden" name="lang" value="{$lang}"/>
                  <input type="hidden" name="tree_id" value=""/>
                <input type="hidden" name="autocomplete_term" value=""/>
             </form>
              <div id="decsAutocomplete">
                <input id="terminput" class="textinput"/>
                <span id="loading">
                    <xsl:comment>loading indicator</xsl:comment>
                </span>
                <div id="container">
                    <xsl:comment>container div</xsl:comment>
                </div>
            </div>

            <script type="text/javascript" src="../js/decs.js"><xsl:comment>decs</xsl:comment></script>
            <script>
                DeCSAutoCompleteConfigure();
            </script>
            <!-- /AUTOCOMPLETE CODE -->
    </xsl:template>

    <xsl:template match="*" mode="basket">

        <div id="shopping_cart">
            <table id="shopping_cart_items" width="98%" cellspacing="0" cellpadding="3">

                <tr id="shoping_cart_items_product0" class="oddLine">
                    <xsl:if test="count($terms) &gt;= 1">
                        <xsl:attribute name="style">display: none;</xsl:attribute>
                    </xsl:if>
                    <td colspan="4"><xsl:value-of select="$texts/text[@id = 'emptylist']"/></td>
                </tr>
                <xsl:apply-templates select="/root/session-token-list/token-list"/>
            </table>
        </div>

        <div id="searchButtonEnabled">
            <xsl:if test="count($terms) = 0">
                <xsl:attribute name="style">display: none;</xsl:attribute>
            </xsl:if>
            <input type="radio" name="connector" value="AND" checked="checked"/><xsl:value-of select="$texts/text[@id = 'and_terms']"/>
            <input type="radio" name="connector" value="OR" /><xsl:value-of select="$texts/text[@id = 'or_terms']"/>

            <input type="submit" value="{$texts/text[@id = 'search']}" name="search" class="submit"/>&#160;
        </div>

        <div id="searchButtonDisabled">
            <xsl:if test="count($terms) &gt;= 1">
                <xsl:attribute name="style">display: none;</xsl:attribute>
            </xsl:if>
            <input type="radio" name="connector" value="AND" disabled="true" /><xsl:value-of select="$texts/text[@id = 'and_terms']"/>
            <input type="radio" name="connector" value="OR" disabled="true" /><xsl:value-of select="$texts/text[@id = 'or_terms']"/>

            <input type="submit" value="{$texts/text[@id = 'search']}" name="search" class="submit" disabled="true"/>&#160;
        </div>
    </xsl:template>

    <xsl:template match="token-list">

        <xsl:variable name="id" select="token[1]"/>
		<xsl:variable name="name" select="token[2]"/>
		<xsl:variable name="options" select="token[3]"/>
		<xsl:variable name="qualifier" select="token[4]"/>

        <xsl:variable name="even_odd">
            <xsl:choose>
                <xsl:when test="position() mod 2">
                    <xsl:text>evenLine</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>oddLine</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <tr id="shoping_cart_items_product{$id}" class="{$even_odd}">
            <td width="20">
                <a href="#" onclick="removeProductFromBasket('{$id}')"><span title="{$texts/text[@id = 'action.X']}">X</span></a>
            </td>
            <td width="20">
                <xsl:if test="contains($options,'Q')">
                    <a href="#" onclick="selectTermQualifier('{$id}')"><span title="{$texts/text[@id = 'action.Q']}">Q</span></a>
                </xsl:if>
            </td>
            <td width="20">
                <xsl:if test="contains($options,'Ex')">
                    <a href="#" onclick="selectTermExplode('{$id}')"><span title="{$texts/text[@id = 'action.Ex']}">Ex</span></a>
                </xsl:if>
            </td>
            <td>
                <xsl:value-of select="$name"/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="*" mode="script">
        <!-- yui library: autocomplete function  -->
        <script type="text/javascript" src="../js/yui/yahoo.js"></script>
        <script type="text/javascript" src="../js/yui/dom.js"></script>
        <script type="text/javascript" src="../js/yui/event.js"></script>
        <script type="text/javascript" src="../js/yui/connection.js"></script>
        <script type="text/javascript" src="../js/yui/autocomplete.js"></script>

        <!-- selection basket -->
        <script type="text/javascript" src="../js/ajax.js"></script>
        <script type="text/javascript" src="../js/basket.js"></script>

    </xsl:template>

    <xsl:template name="split">
        <xsl:param name="string"/>
        <xsl:choose>
            <xsl:when test="contains($string, '|||')">
                <token><xsl:value-of select="substring-before($string,'|||')"/></token>
            </xsl:when>
            <xsl:otherwise>
                <token><xsl:value-of select="$string"/></token>
            </xsl:otherwise>
        </xsl:choose>
        <xsl:if test="contains($string,'|||')">
            <xsl:call-template name="split">
                <xsl:with-param name="string" select="substring-after($string,'|||')"/>
            </xsl:call-template>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>