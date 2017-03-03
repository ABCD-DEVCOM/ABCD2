<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/style1/xsl/update-x.xsl"/>

	<xsl:template match="*" mode="HTML-form">
		<xsl:apply-templates select="." mode="STYLE1_top"/>
		<xsl:apply-templates select="." mode="UPDATE_X-documents-formDocuments"/>
	</xsl:template>

	<xsl:template match="selectedId" mode="UPDATE_X-inform-selectedId">
		<br/>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-documents-list">
		<xsl:variable name="column-id">
			<column path="UPDATE-X id" sort=""/>
		</xsl:variable>
		
		<table width="100%">
			<tr>
				<td>
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="1%" class="DOCUMENTS_listHeader">&#160;</td>
							<td width="6%" align="center" class="DOCUMENTS_listHeader">
								<xsl:attribute name="onmouseover">javascript: UPDATE_X_buttonSendXML_backupColor = this.style.backgroundColor; this.style.backgroundColor = 'LightSlateGray'</xsl:attribute>
								<xsl:attribute name="onmouseout">javascript: this.style.backgroundColor = UPDATE_X_buttonSendXML_backupColor;</xsl:attribute>
								<xsl:apply-templates select="$column-id/column" mode="UPDATE_X-column-header-bgcolor"/>
								<xsl:apply-templates select="$column-id/column" mode="UPDATE_X-column-link"/>
							</td>
							<xsl:apply-templates select="$UPDATE-X-column/document-line/column" mode="UPDATE_X-column-header"/>
						</tr>
						<xsl:apply-templates select="." mode="UPDATE_X-documents-list-sort"/>
					</table>
				</td>
			</tr>
		</table>
	</xsl:template>
	
	<xsl:template match="column" mode="UPDATE_X-column-header">
		<td class="DOCUMENTS_listHeader">
			<xsl:attribute name="onmouseover">javascript: UPDATE_X_buttonSendXML_backupColor = this.style.backgroundColor; this.style.backgroundColor = 'LightSlateGray'</xsl:attribute>
			<xsl:attribute name="onmouseout">javascript: this.style.backgroundColor = UPDATE_X_buttonSendXML_backupColor;</xsl:attribute>
			<xsl:apply-templates select="." mode="UPDATE_X-column-header-bgcolor"/>
			<xsl:apply-templates select="." mode="UPDATE_X-column-link"/>
		</td>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-column-link">
		<xsl:variable name="link-order">
			<xsl:choose>
				<xsl:when test="$column = @sort">
					<xsl:choose>
						<xsl:when test="$order = 'ascending'"><xsl:value-of select="'descending'"/></xsl:when>
						<xsl:otherwise><xsl:value-of select="'ascending'"/></xsl:otherwise>
					</xsl:choose>
				</xsl:when>
				<xsl:otherwise><xsl:value-of select="'ascending'"/></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>

		<xsl:attribute name="onclick">javascript: document.formList.column.value = '<xsl:value-of select="@sort"/>'; document.formList.order.value = '<xsl:value-of select="$link-order"/>'; document.formList.submit(); return false;</xsl:attribute>
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="@path"/>
		</xsl:call-template>
		<xsl:if test="$column = @sort">
			&#160;<img src="{$UPDATE-X-ini-PATH-image}/{$order}.gif" alt="{$order}" border="0"/>			
		</xsl:if>
	</xsl:template>

	<xsl:template match="record" mode="UPDATE_X-documents-line-class">
		<xsl:param name="pos"/>

		<xsl:attribute name="class">
			<xsl:choose>
				<xsl:when test="$pos mod 2 = 1">
					<xsl:value-of select="'DOCUMENTS_line1'"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="'DOCUMENTS_line2'"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:attribute>
		<xsl:attribute name="onmouseover">javascript: UPDATE_X_buttonSendXML_backupColor = this.style.backgroundColor; this.style.backgroundColor = '#D6D6A7'</xsl:attribute>
		<xsl:attribute name="onmouseout">javascript: this.style.backgroundColor = UPDATE_X_buttonSendXML_backupColor;</xsl:attribute>
	</xsl:template>

</xsl:stylesheet>
