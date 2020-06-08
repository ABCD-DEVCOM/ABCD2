<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" />

    <xsl:param name="expression" select="/root/http-info/VARS/expression" />
    <xsl:param name="source" select="/root/http-info/VARS/source" />
    <xsl:param name="tree_id" select="/root/http-info/cgi/tree_id" />
    <xsl:param name="lang" select="/root/http-info/VARS/lang" />
    <xsl:param name="script" select="/root/http-info/server/PHP_SELF" />
    <xsl:param name="decsWs" select="/root/decsws_response" />
    <xsl:param name="base-path" select="/root/define/DATABASE_PATH" />

    <xsl:param name="texts" select="document(concat($base-path,'xml/',$lang,'/decsws.xml'))/texts" />

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="script"/>

        <div id="breadCrumb">
            <a href="../php/index.php?lang={$lang}"><xsl:apply-templates select="$texts/text[@id = 'home']" /></a>
            &gt;
            <a href="{concat($script,'?lang=',$lang)}"><xsl:value-of select="$texts/text[@id = 'all_categories']" /></a>
            <xsl:apply-templates select="$decsWs/tree/ancestors/term_list[@lang = $lang]/term" mode="breadcrumb"/>
        </div>

        <xsl:choose>
            <xsl:when test="$decsWs/record_list">
                <div id="{$source}">
                    <h3><span><a href="../php/decsws.php?lang={$lang}"><xsl:value-of select="$texts/text[@id = 'title']" /></a></span></h3>
                    <div id="boxContent">
                        <xsl:call-template name="autocomplete"/>
                        <h4><xsl:apply-templates select="$decsWs/tree/self/term_list[@lang = $lang]/term" mode="sectionTitle"/></h4>

                        <xsl:if test="$decsWs/record_list/record/allowable_qualifier_list/allowable_qualifier">
                            <strong><xsl:value-of select="$texts/text[@id = 'allowable_qualifier_list']"/></strong>
                            <div style="border: solid 1px #b6cdcd; height: 100px; width: 230px; overflow: auto; background:#ffffff; padding: 0px;">
                                <ul>
                                    <xsl:apply-templates select="$decsWs/record_list/record[@lang = $lang]/allowable_qualifier_list" />
                                </ul>
                            </div>
                        </xsl:if>
                        <strong><xsl:value-of select="$texts/text[@id = 'hierarchy']"/></strong>
                        <xsl:apply-templates select="$decsWs/tree/ancestors"/>
                    </div>
                </div>

                <div id="{$source}">
                    <h3><span><xsl:value-of select="$texts/text[@id = 'selection']"/></span></h3>
                    <form name="send2search" action="http://bases.bvs.br/public/scripts/php/metasearch.php" onsubmit="ajaxUpdateQuery(); return false;" method="POST">
                        <input type="hidden" name="lang" value="{$lang}"/>
                        <input type="hidden" name="form" value="advanced"/>
                        <input type="hidden" name="expression" value="" id="expression"/>

                        <xsl:apply-templates select="." mode="basket"/>
                    </form>
                </div>

                <div id="{$source}">
                    <h3><xsl:value-of select="$decsWs/tree/self/term_list[@lang = $lang]/term"/></h3>
                    <div class="content">
                        <xsl:apply-templates select="$decsWs/record_list"/>
                    </div>
                </div>
            </xsl:when>
            <xsl:otherwise>
                <div id="{$source}">
                    <h3><span><a href="../php/decsws.php?lang={$lang}"><xsl:value-of select="$texts/text[@id = 'title']" /></a></span></h3>

                    <xsl:call-template name="autocomplete"/>

                    <ul>
                        <xsl:apply-templates select="$decsWs/tree/term_list[@lang = $lang] | $decsWs/tree/self/term_list[@lang = $lang]"/>
                    </ul>
                </div>
                <div id="{$source}">
                    <h3><span>Sua seleção</span></h3>
                    <form name="send2search" action="./decsBasketSearch.php">
                        <input type="hidden" name="lang" value="{$lang}"/>
                        <xsl:apply-templates select="." mode="basket"/>
                    </form>
                </div>

            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="term_list">
        <xsl:apply-templates select="term" />
    </xsl:template>

    <xsl:template match="term_list/term">
        <li>
            <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
                <xsl:apply-templates select="." mode="formatTerm"/>
            </a>
        </li>
    </xsl:template>

    <xsl:template match="*" mode="formatTerm">
        <xsl:choose>
            <xsl:when test="@leaf = 'false'">
                <xsl:text>+</xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>&#160;</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
        <xsl:value-of select="."/>
    </xsl:template>

    <xsl:template match="self | following_sibling | descendants | preceding_sibling">
        <ul>
            <xsl:apply-templates select="term_list[@lang = $lang]" />
        </ul>
    </xsl:template>

    <xsl:template match="ancestors">
        <ul>
            <xsl:apply-templates select="term_list[@lang = $lang]/term[1]" />
        </ul>
    </xsl:template>

    <xsl:template match="ancestors//term">
        <li>
            <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
                <xsl:apply-templates select="." mode="formatTerm"/>
            </a>

            <xsl:choose>
                <xsl:when test="count(following-sibling::term[1]) = 0">
                    <xsl:apply-templates select="$decsWs/tree/preceding_sibling"/>
                    <xsl:apply-templates select="$decsWs/tree/self"/>
                    <xsl:apply-templates select="$decsWs/tree/following_sibling"/>
                </xsl:when>
                <xsl:otherwise>
                    <ul>
                        <xsl:apply-templates select="following-sibling::term[1]" />
                    </ul>
                </xsl:otherwise>
            </xsl:choose>
        </li>
    </xsl:template>

    <xsl:template match="self//term">
        <li>
            <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
                <xsl:apply-templates select="." mode="formatTerm"/>
            </a>
            <xsl:apply-templates select="$decsWs/tree/descendants"/>
        </li>
    </xsl:template>

    <xsl:template match="ancestors//term" mode="breadcrumb">
        &gt;
        <a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
            <xsl:apply-templates/>
        </a>
    </xsl:template>

    <xsl:template match="self//term" mode="sectionTitle">
        <div id="slidingProduct{@tree_id}" class="sliding_product">
            <a href="#" onclick="addToBasket('{@tree_id}','{.}');return false;"><xsl:value-of select="."/></a>
        </div>
    </xsl:template>

    <xsl:template match="record_list">
        <div id="details">
            <table width="100%">
                <xsl:apply-templates select="record[@lang = $lang]" />
                <xsl:apply-templates select="record[@lang != $lang]/descriptor" />
            </table>
        </div>
    </xsl:template>

    <xsl:template match="record_list/record/descriptor">
        <xsl:variable name="recordLanguage" select="../@lang" />
        <tr>
            <td class="label">
                <xsl:value-of select="$texts/text[@id = 'descriptor']" />&#160;<xsl:value-of select="$texts/text[@id = $recordLanguage]" />:
            </td>
            <td class="area"><xsl:apply-templates /></td>
        </tr>
    </xsl:template>

    <xsl:template match="record_list/record">
        <xsl:if test="definition/occ">
            <tr>
                <td colspan="2"><strong><xsl:apply-templates select="definition" /></strong></td>
            </tr>
        </xsl:if>
        <!--
        <xsl:if test="indexing_annotation != ''">
            <tr>
                <td class="label"><xsl:value-of select="$texts/text[@id = 'indexing_annotation']" />:</td>
                <td class="area"><xsl:apply-templates select="indexing_annotation" /></td>
            </tr>
        </xsl:if>
        -->
        <xsl:if test="count(tree_id_list) &gt; 0">
            <tr>
                <td class="label"><xsl:value-of select="$texts/text[@id = 'tree_id_list']" />:</td>
                <td class="area"><xsl:apply-templates select="tree_id_list/tree_id" /></td>
            </tr>
        </xsl:if>

    </xsl:template>

    <xsl:template match="tree_id">
        <a href="{concat($script,'?tree_id=',text(),'&amp;lang=',$lang)}"><xsl:apply-templates select="text()"/></a><br />
    </xsl:template>

    <xsl:template match="allowable_qualifier_list">
        <xsl:variable name="descriptor" select="../descriptor"/>
        <xsl:variable name="translated_qualifier_list">
            <xsl:element name="allowable_qualifier_list">
                <xsl:apply-templates select="allowable_qualifier" mode="translate"/>
            </xsl:element>
        </xsl:variable>
        <xsl:for-each select="$translated_qualifier_list/allowable_qualifier_list/allowable_qualifier">
            <xsl:sort select="."/>
            <xsl:variable name="compoundId" select="concat($tree_id,'/',@qualifier_id)"/>
            <li>
                <span class="sliding_product" id="slidingProduct{$compoundId}">
                    <a href="#" onclick="addToBasket('{$compoundId}','{concat($descriptor,'/',.)}');return false;">
                        <xsl:value-of select="."/>
                    </a>
                </span>
            </li>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="allowable_qualifier" mode="translate">
        <xsl:variable name="qualifierTextId" select="concat('subheading.',.)"/>

        <allowable_qualifier qualifier_id="{.}">
            <xsl:value-of select="$texts/text[@id = $qualifierTextId]/text()"/>
        </allowable_qualifier>
    </xsl:template>

    <xsl:template match="*" mode="al">
        <xsl:variable name="qualifierId" select="concat('subheading.',.)"/>
        <xsl:variable name="qualifierName" select="$texts/text[@id = $qualifierId]/text()"/>
        <xsl:variable name="compoundId" select="concat($tree_id,'/',.)"/>

        <li>
            <span class="sliding_product" id="slidingProduct{$compoundId}">
                <a href="#" onclick="addToBasket('{$compoundId}','{concat(../../descriptor,'/',$qualifierName)}');return false;">
                    <xsl:value-of select="$qualifierName"/>
                </a>
            </span>
        </li>
    </xsl:template>

    <xsl:template match="definition/occ">
        <xsl:value-of select="@n" disable-output-escaping="yes"/><br />
    </xsl:template>

    <xsl:template name="autocomplete">
            <!-- AUTOCOMPLETE CODE -->
            <form action="../php/decsws.php" method="get" name="decswsForm">
                  <input type="hidden" name="lang" value="{$lang}"/>
                  <input type="hidden" name="tree_id" value=""/>
             </form>
             <div id="decsAutocomplete">
                <input id="terminput" size="20" class="textinput"/>
                <div id="container"></div>
             </div>
             <script>
                var serviceUrl = "../php/decsAutoCompleteProxy.php";
                var serviceSchema = ["item","term","id"];
                var decsDataSource = new YAHOO.widget.DS_XHR(serviceUrl, serviceSchema);
                decsDataSource.responseType = decsDataSource.TYPE_XML;

                var decsAutoComp = new YAHOO.widget.AutoComplete('terminput','container', decsDataSource);
                decsAutoComp.forceSelection = true;
                decsAutoComp.allowBrowserAutocomplete = false;
                decsAutoComp.minQueryLength = 2;
                decsAutoComp.maxResultsDisplayed = 40;

                decsAutoComp.itemSelectEvent.subscribe(onItemSelect);

                function onItemSelect(sType, aArgs) {
                    var oItem = aArgs[1];
                    var tree_id = oItem._oResultData[1];
                    document.decswsForm.tree_id.value = tree_id;
                    document.decswsForm.submit();
                }
            </script>
            <!-- /AUTOCOMPLETE CODE -->
    </xsl:template>

    <xsl:template match="*" mode="basket">
        <xsl:variable name="terms" select="/root/http-info/session/terms"/>

        <div id="shopping_cart">
            <table id="shopping_cart_items" width="85%">
                <xsl:apply-templates select="$terms"/>
            </table>
        </div>

        <div id="searchButton" style="display: none">
            <xsl:choose>
                <xsl:when test="count($terms) &gt;= 1">
                    <xsl:attribute name="style">display: block;</xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:attribute name="style">display: none;</xsl:attribute>
                </xsl:otherwise>
            </xsl:choose>
            <input type="submit" value="{$texts/text[@id = 'search']}" name="search" class="submit"/>&#160;
            <xsl:value-of select="$texts/text[@id = 'documents_with']"/>&#160;
            <select name="connector">
                <option value="AND"><xsl:value-of select="$texts/text[@id = 'and_terms']"/></option>
                <option value="OR"><xsl:value-of select="$texts/text[@id = 'or_terms']"/></option>
            </select>
        </div>
    </xsl:template>

    <xsl:template match="session/terms">
        <xsl:variable name="id" select="substring-before(.,'|||')"/>
        <xsl:variable name="name" select="substring-after(.,'|||')"/>

        <tr id="shoping_cart_items_product{$id}">
            <td>
                <xsl:value-of select="$name"/>
            </td>
            <td>
                <a href="#" onclick="removeProductFromBasket('{$id}')">
                    <img src="../image/common/remove.gif"/>
                </a>
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

</xsl:stylesheet>