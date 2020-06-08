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
	<xsl:variable name="sessionTerm" select="/root/http-info/session/terms[starts-with(.,$tree_id)]/text() "/>

	<xsl:param name="texts" select="document(concat($base-path,'xml/',$lang,'/decsws.xml'))/texts" />


	<xsl:template match="/">
        <div id="{$source}" style="width: 262px;">
			<h3><span><xsl:value-of select="$texts/text[@id = 'qualifier_title']/text()"/></span></h3>

			<xsl:choose>
				<xsl:when test="$decsWs//record_list/record/allowable_qualifier_list/allowable_qualifier">
					<div style="padding-left: 7px;">
						<strong><xsl:value-of select="$decsWs/tree/self/term_list/term"/></strong>
					</div>
					<span style="margin-left: 7px;">
						<xsl:value-of select="$texts/text[@id = 'qualifier_restrict']/text()"/>
					</span>
					<form action="../php/decsBasketQlf.php" method="post">
						<input type="hidden" name="term" value="{$tree_id}"/>

						<div id="boxContentScroll">
							<xsl:apply-templates select="$decsWs//record_list/record/allowable_qualifier_list"/>
						</div>

                        <div>
							<input type="submit" value="{$texts/text[@id = 'apply']/text()}" class="submit"/>
						</div>

					</form>
				</xsl:when>
				<xsl:otherwise>
					<p>
						<xsl:value-of select="$texts/text[@id = 'qualifier_restrict_unavailable']/text()"/>.
					</p>
					<p align="right">
						<input type="button" value="{$texts/text[@id = 'close']/text()}" class="submit" onclick="javascript:window.close()"/>
					</p>
				</xsl:otherwise>
			</xsl:choose>

		</div>
	</xsl:template>

	<xsl:template match="term_list">
		<xsl:apply-templates select="term" />
	</xsl:template>

	<xsl:template match="term_list/term">
		<li>
			<xsl:apply-templates select="." mode="format"/>
		</li>
	</xsl:template>

	<xsl:template match="allowable_qualifier_list">        
		<xsl:variable name="descriptor" select="../descriptor"/>
        
		<xsl:variable name="translated_qualifier_list">
			<xsl:element name="allowable_qualifier_list">
				<xsl:apply-templates select="allowable_qualifier" mode="translate"/>
			</xsl:element>
		</xsl:variable>
		<ul class="termList">

		<xsl:for-each select="allowable_qualifier">
			<xsl:sort select="."/>

            <xsl:variable name="qualifier_id" select="text()"/>

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

			<xsl:variable name="checked">
				<xsl:choose>
					<xsl:when test="contains($sessionTerm, $qualifier_id)">
						<xsl:text>1</xsl:text>
					</xsl:when>
					<xsl:otherwise>
						<xsl:text>0</xsl:text>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>

			<li class="{$even_odd}">
				<input type="checkbox" name="ql[]" value="{$qualifier_id}">
					<xsl:if test="contains($sessionTerm,$qualifier_id)">
						<xsl:attribute name="checked">1</xsl:attribute>
					</xsl:if>
				</input>
                <xsl:value-of select="$texts/text[@id = concat('subheading.',$qualifier_id)]/text()"/>
			</li>

			</xsl:for-each>
		</ul>
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


</xsl:stylesheet>
