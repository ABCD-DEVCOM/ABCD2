<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/html.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/update-x.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/alt1/xsl/update-x.xsl"/>

	<xsl:variable name="UPDATE-X-column" select="document(concat('file://',$UPDATE-X-ini/XML/column))"/>

	<xsl:variable name="column" select="$UPDATE-X-vars/column"/>
	<xsl:variable name="order" select="$UPDATE-X-vars/order"/>

	<xsl:template match="*" mode="HTML-script">
		<script language="JavaScript" src="{$UPDATE-X-ini/PATH/update-x}/update-x/js/string.js"></script>
		<xsl:apply-templates select="." mode="HTML-script-documents"/>
	</xsl:template>

	<xsl:template match="*" mode="HTML-script-documents"/>

	<xsl:template match="*[data/*/record]" mode="HTML-script-documents">
		<script language="JavaScript">
			function UPDATE_X_selectedId ( )
			{
				var selectedValue = "";
			
				if ( document.formShow.selectedId.value == '' )
				{
					document.formDocuments.selectedId[0].checked = true;
					selectedValue = document.formDocuments.selectedId[0].value;
					document.formShow.selectedId.value = selectedValue;
					document.formDelete.selectedId.value = selectedValue;
					document.formList.selectedId.value = selectedValue;
				}
						
				return;
			}
		</script>
	</xsl:template>

	<xsl:template match="*[data/*/record]" mode="HTML-body-onLoad">
		<xsl:attribute name="onLoad">javascript: UPDATE_X_selectedId();</xsl:attribute>
	</xsl:template>

	<xsl:template match="*" mode="HTML-form">
		<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-vars"/>
		<xsl:apply-templates select="$UPDATE-X-ini/PROJECT" mode="UPDATE_X-project"/>
		<xsl:apply-templates select="." mode="UPDATE_X-documents-formDocuments"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-documents-formDocuments">
		<form name="formDocuments" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_DOCUMENTS/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*[name() != 'selectedId']" mode="UPDATE_X-form-hidden"/>
			<xsl:apply-templates select="." mode="UPDATE_X-buttons"/>
			<xsl:apply-templates select="." mode="UPDATE_X-documents-list"/>
		</form>
		<form name="formShow" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_SHOW/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*[name() != 'selectedId']" mode="UPDATE_X-form-hidden"/>
			<xsl:apply-templates select="$UPDATE-X-vars/selectedId" mode="UPDATE_X-form-hidden-selectedId"/>
		</form>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formNew"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formDelete"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formList"/>
	</xsl:template>
	
	<xsl:template match="*[/UPDATE-X/data/*/delete/Isis_Status/occ != '0']" mode="UPDATE_X-documents-formDocuments">
		<xsl:apply-templates select="." mode="UPDATE_X-edit-lockError"/>
	</xsl:template>
	
	<xsl:template match="xml | UPDATE_X_saveDate" mode="UPDATE_X-form-hidden"/>

	<xsl:template match="*" mode="UPDATE_X-form-submit">
		<xsl:apply-templates select="." mode="UPDATE_X-button-newDocument"/>
		<xsl:if test="data/*/record[1]">
			<xsl:apply-templates select="." mode="UPDATE_X-button-deleteDocument"/>
			<xsl:apply-templates select="." mode="UPDATE_X-button-editDocument"/>
		</xsl:if>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-documents-list">
		<xsl:variable name="column-id">
			<column path="UPDATE-X id" sort=""/>
		</xsl:variable>
		
		<table border="1" width="100%" cellspacing="0">
			<tr>
				<td width="1%"></td>
				<td width="6%" align="center">
					<xsl:apply-templates select="$column-id/column" mode="UPDATE_X-column-header-bgcolor"/>
					<xsl:apply-templates select="$column-id/column" mode="UPDATE_X-column-link"/>
				</td>
				<xsl:apply-templates select="$UPDATE-X-column/document-line/column" mode="UPDATE_X-column-header"/>
			</tr>
			<xsl:apply-templates select="." mode="UPDATE_X-documents-list-sort"/>
		</table>
	</xsl:template>

	<xsl:template match="column" mode="UPDATE_X-column-header">
		<td>
			<xsl:apply-templates select="." mode="UPDATE_X-column-header-bgcolor"/>
			<xsl:apply-templates select="." mode="UPDATE_X-column-link"/>
		</td>
	</xsl:template>

	<xsl:template match="column" mode="UPDATE_X-column-header-bgcolor">
		<xsl:if test="$column = @sort">
			<xsl:attribute name="bgcolor">Silver</xsl:attribute>
		</xsl:if>
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

		<a href="{@sort}" onclick="javascript: document.formList.column.value = '{@sort}'; document.formList.order.value = '{$link-order}'; document.formList.submit(); return false;">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="@path"/>
			</xsl:call-template>
		</a>
		<xsl:if test="$column = @sort">
			&#160;<img src="{$UPDATE-X-ini-PATH-image}/{$order}.gif" alt="{$order}" border="0"/>			
		</xsl:if>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-documents-list-sort">
		<xsl:choose>
			<xsl:when test="$UPDATE-X-vars/column = ''">
				<xsl:apply-templates select="/UPDATE-X/data/*[search]/record" mode="UPDATE_X-documents-line">
					<xsl:sort select="@mfn" data-type="number" order="{$order}"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates select="/UPDATE-X/data/*[search]/record" mode="UPDATE_X-documents-line">
					<xsl:sort select="field/occ//*[name() = $column] | field/occ//@*[name() = $column]" order="{$order}"/>
				</xsl:apply-templates>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="record" mode="UPDATE_X-documents-line">
		<xsl:variable name="pos" select="position()"/>
	
		<tr>
			<xsl:apply-templates select="." mode="UPDATE_X-documents-line-class">
				<xsl:with-param name="pos" select="$pos"/>				
			</xsl:apply-templates>
			<td align="center" class="DOCUMENTS_column">
				<input type="radio" name="selectedId" value="{@mfn}" onchange="javascript: document.formShow.selectedId.value = this.value; document.formDelete.selectedId.value = this.value; document.formList.selectedId.value = this.value;">
					<xsl:apply-templates select="." mode="UPDATE_X-documents-selectedId">
						<xsl:with-param name="pos" select="$pos"/>
					</xsl:apply-templates>
				</input>
			</td>
			<td align="center" class="DOCUMENTS_column">
				<xsl:apply-templates select="@mfn" mode="UPDATE_X-documents-id">
					<xsl:with-param name="pos" select="$pos"/>
				</xsl:apply-templates>
			</td>
			<xsl:apply-templates select="$UPDATE-X-column/document-line/column" mode="UPDATE_X-column-content">
				<xsl:with-param name="pos" select="$pos"/>
				<xsl:with-param name="content" select="field[@tag = '1']/occ/*"/>
			</xsl:apply-templates>
		</tr>
	</xsl:template>

	<xsl:template match="record" mode="UPDATE_X-documents-line-class"/>

	<xsl:template match="record" mode="UPDATE_X-documents-selectedId">
		<xsl:param name="pos"/>

		<xsl:if test="@mfn = $UPDATE-X-vars/selectedId or (($UPDATE-X-vars/selectedId = '' or /UPDATE-X/data/*/delete/Isis_Status/occ = '0') and $pos = 1)">
			<xsl:attribute name="checked"></xsl:attribute>
		</xsl:if>
	</xsl:template>

	<xsl:template match="@mfn" mode="UPDATE_X-documents-id">
		<xsl:param name="pos"/>
	
		<xsl:variable name="index" select="$pos - 1"/>
	
		<a href="{@mfn}" onclick="javascript: document.formDocuments.selectedId[{$index}].checked = true; document.formDocuments.submit(); return false;"><xsl:value-of select="."/></a>
	</xsl:template>

	<xsl:template match="column" mode="UPDATE_X-column-content">
		<xsl:param name="pos"/>
		<xsl:param name="content"/>

		<xsl:variable name="index" select="$pos - 1"/>
		<xsl:variable name="path" select="@path"/>
		<xsl:variable name="this-content">
			<xsl:apply-templates select="$content" mode="UPDATE_X-find-content">
				<xsl:with-param name="find" select="$path"/>
			</xsl:apply-templates>
		</xsl:variable>
	
		<td class="DOCUMENTS_column">
			<xsl:choose>
				<xsl:when test="position() = 1">
					<a href="{@mfn}" onclick="javascript: document.formDocuments.selectedId[{$index}].checked = true; document.formDocuments.submit(); return false;">
						<xsl:copy-of select="$this-content"/>
					</a>
				</xsl:when>
				<xsl:otherwise>
					<xsl:copy-of select="$this-content"/>&#160;
				</xsl:otherwise>
			</xsl:choose>
		</td>
	</xsl:template>

	<xsl:template match="@* | *" mode="UPDATE_X-find-content">
		<xsl:param name="find"/>
		
		<xsl:variable name="path">
			<xsl:call-template name="UPDATE_X-show-full-path"/>
		</xsl:variable>
		
		<xsl:choose>
			<xsl:when test="$find = $path">
				<xsl:apply-templates select="." mode="UPDATE_X-column-show-content"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates select="@* | *" mode="UPDATE_X-find-content">
					<xsl:with-param name="find" select="$find"/>
				</xsl:apply-templates>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
