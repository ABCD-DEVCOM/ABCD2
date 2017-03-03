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
		<div>
			<h3><span><xsl:value-of select="$texts/text[@id = 'explode_title']/text()"/></span></h3>

			<div style="padding: 7px">
				<strong><xsl:value-of select="$decsWs/tree/self/term_list/term"/></strong>
			</div>

			<form action="../php/decsBasketEx.php" method="post">
				<input type="hidden" name="term" value="{$tree_id}"/>

				<div style="margin: 0px; padding: 3px">
					<input type="checkbox" name="explode" value="*explode*">
						<xsl:if test="contains($sessionTerm,'*explode*')">
							<xsl:attribute name="checked">1</xsl:attribute>
						</xsl:if>
					</input>
					<xsl:value-of select="$texts/text[@id = 'explode']/text()"/>
				</div>

				<div style="float: right; margin: 5px;">
					<input type="submit" value="{$texts/text[@id = 'apply']/text()}" class="submit"/>
				</div>
			</form>
		</div>
	</xsl:template>

</xsl:stylesheet>