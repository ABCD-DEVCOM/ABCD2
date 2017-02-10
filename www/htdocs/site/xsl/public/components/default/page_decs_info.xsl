<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" indent="yes" omit-xml-declaration="yes" encoding="iso-8859-1" />

	<xsl:param name="expression" select="/root/http-info/VARS/expression" />
	<xsl:param name="source" select="/root/http-info/VARS/source" />
	<xsl:param name="tree_id" select="/root/http-info/cgi/tree_id" />
	<xsl:param name="lang" select="/root/http-info/VARS/lang" />
	<xsl:param name="script" select="/root/http-info/server/PHP_SELF" />
	<xsl:param name="decsWs" select="/root/decsvmx/decsws_response" />
	<xsl:param name="base-path" select="/root/define/DATABASE_PATH" />

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
		<script type="text/javascript" src="../js/decs.js"><!--decs.js--></script>
		
        <div id="logo">
            <img src="../image/{$lang}/logoDeCS.gif"/>
        </div>
        <span>
            <a href="#" onclick="window.close()"><xsl:value-of select="$texts/text[@id = 'close']"/></a>
        </span>

		<div>
			<h3><xsl:value-of select="$decsWs/tree/self/term_list/term"/></h3>
			<div id="boxContentScroll">
				<xsl:apply-templates select="$decsWs/record_list"/>
			</div>
		</div>
        <span>
            <a href="#" onclick="window.close()"><xsl:value-of select="$texts/text[@id = 'close']"/></a>
		</span>
		
	</xsl:template>

	<xsl:template match="term_list">
		<xsl:apply-templates select="term" />
	</xsl:template>

	<xsl:template match="term_list/term">
		<li>
			<xsl:apply-templates select="." mode="format"/>
		</li>
	</xsl:template>

	<xsl:template match="self | following_sibling | descendants | preceding_sibling">
		<ul>
			<xsl:apply-templates select="term_list" />
		</ul>
	</xsl:template>


	<xsl:template match="ancestors">
			<xsl:for-each select="term_list/term">
				<xsl:variable name="tmp" select="translate(@tree_id, '0123456789', '9999999999')"/>
				<!-- aplica somente para as primeiras categorias (não contem número no ID) -->
				<xsl:if test="not( contains($tmp, '9') )">
					<ul style="margin:0px">
						<xsl:apply-templates select=".">
							<xsl:with-param name="pos" select="position()"/>
						</xsl:apply-templates>
					</ul>
				</xsl:if>
			</xsl:for-each>

	</xsl:template>

	<xsl:template match="ancestors//term">
		<xsl:param name="pos" select="position()"/>
		<xsl:variable name="nextId" select="../term[$pos+1]/@tree_id"/>
		<xsl:variable name="currentId" select="@tree_id"/>

		<li><a href="#" onclick="expandRetract(this,'{concat(@tree_id,'-',$pos)}');return false" tite="{concat(.,' (',@tree_id,')')}"><xsl:value-of select="."/></a></li>
		<ul id="{concat(@tree_id,'-',$pos)}" style="display:none">
			<xsl:apply-templates select="following-sibling::term[1][string-length(@tree_id) &gt; string-length($currentId) ]">
				<xsl:with-param name="pos" select="$pos"/>
			</xsl:apply-templates>
		</ul>
	</xsl:template>

	<xsl:template match="self//term">
		<li>
			<a href="{concat($script,'?tree_id=',@tree_id,'&amp;lang=',$lang)}">
				<strong><xsl:apply-templates select="." mode="formatTerm"/></strong>
			</a>
			<xsl:apply-templates select="$decsWs/tree/descendants"/>
		</li>
	</xsl:template>

	<xsl:template match="record_list">
		<div id="details">
			<table width="355" cellpadding="4" cellspacing="1">
				<xsl:apply-templates select="record" />
			</table>
		</div>
	</xsl:template>

	<xsl:template match="record_list/record">
		<xsl:variable name="tmp" select="translate($tree_id, '0123456789', '9999999999')"/>
		<!-- caso seja uma categoria principal somente mostra o código da categoria -->
		<xsl:if test="contains($tmp, '9')">
			<xsl:apply-templates select="descriptor_list/descriptor"/>
			<xsl:apply-templates select="definition[occ/@n != '']"/>
			<xsl:apply-templates select="synonym_list[synonym]"/>
			<xsl:apply-templates select="indexing_annotation" />
			<xsl:apply-templates select="tree_id_list" />
			<xsl:apply-templates select="allowable_qualifier_list[allowable_qualifier]" />
			<xsl:apply-templates select="unique_identifier_nlm[text()]" />
		</xsl:if>

	</xsl:template>

	<xsl:template match="record//descriptor">
		<xsl:variable name="lang" select="@lang"/>
		<tr class="evenLine">
			<td class="label"><xsl:copy-of select="$texts/text[@id = concat('descriptor_',$lang)]"/></td>
			<td class="area">
				<xsl:value-of select="."/>
			</td>
		</tr>
	</xsl:template>


	<xsl:template match="record/definition">
		<tr class="evenLine">
			<td class="label"><xsl:value-of select="$texts/text[@id = 'definition']"/></td>
			<td class="area">
				<xsl:value-of select="occ/@n" disable-output-escaping="yes"/>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="record/synonym_list[synonym]">
		<tr class="oddLine">
			<td class="label"><xsl:value-of select="$texts/text[@id = 'synonym_list']"/></td>
			<td class="area">
				<xsl:for-each select="synonym">
					<xsl:value-of select="."/><br/>
				</xsl:for-each>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="record/indexing_annotation">
		<tr class="evenLine">
			<td class="label"><xsl:value-of select="$texts/text[@id = 'indexing_annotation']" /></td>
			<td class="area"><xsl:value-of select="." /></td>
		</tr>
	</xsl:template>

	<xsl:template match="record/tree_id_list[tree_id]">
		<tr class="oddLine">
			<td class="label"><xsl:value-of select="$texts/text[@id = 'tree_id_list']" /></td>
			<td class="area"><xsl:apply-templates select="tree_id" /></td>
		</tr>
	</xsl:template>

	<xsl:template match="tree_id">
		<span title="{.}"><xsl:apply-templates select="text()"/></span><br/>
	</xsl:template>

	<xsl:template match="allowable_qualifier_list">
		<xsl:variable name="descriptor" select="../descriptor"/>
		<xsl:variable name="translated_qualifier_list">
			<xsl:element name="allowable_qualifier_list">
				<xsl:apply-templates select="allowable_qualifier" mode="translate"/>
			</xsl:element>
		</xsl:variable>
		<tr class="evenLine">
			<td class="label" valign="top"><xsl:value-of select="$texts/text[@id = 'allowable_qualifier_list']" /></td>
			<td valign="top">
			<table>
			<xsl:for-each select="allowable_qualifier">
				<xsl:sort select="."/>

                <xsl:variable name="qualifier_id" select="text()"/>
				<tr>
					<td><a href="#" onclick="showDeCSQualifier('{$qualifier_id}')"><xsl:value-of select="$texts/text[@id = concat('subheading.',$qualifier_id)]/text()"/></a></td>
				</tr>
			</xsl:for-each>
			</table>
			</td>
		</tr>

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

	<xsl:template match="record/unique_identifier_nlm">
		<tr class="oddLine">
			<td class="label"><xsl:value-of select="$texts/text[@id = 'unique_identifier_nlm']" /></td>
			<td class="area" valign="top"><xsl:value-of select="." /></td>
		</tr>
	</xsl:template>


</xsl:stylesheet>
