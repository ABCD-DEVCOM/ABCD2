<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/edit.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/alt1/xsl/update-x.xsl"/>

	<xsl:template match="*" mode="UPDATE_X-startStruct">
		<xsl:apply-templates select="$UPDATE-X-struct" mode="UPDATE_X-struct">
			<xsl:with-param name="content" select="data/*/record/field[@tag = '1']/occ"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="*[/UPDATE-X/data/*/edit/Isis_Status/occ = '0']" mode="HTML-body-onUnload">
		<xsl:attribute name="onUnload">javascript: return UPDATE_X_editUnload(document.formEdit);</xsl:attribute>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-textarea">
		<xsl:apply-templates select="$UPDATE-X-struct" mode="UPDATE_X-input-findTextarea">
			<xsl:with-param name="content" select="data/*/record/field[@tag = '1']/occ"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="*[/UPDATE-X/data/*/edit/Isis_Status/occ != '0']" mode="HTML-body-onLoad"/>
	
	<xsl:template match="*[/UPDATE-X/data/*/edit/Isis_Status/occ != '0']" mode="UPDATE_X-edit-formEdit">
		<xsl:apply-templates select="." mode="UPDATE_X-edit-lockError"/>
	</xsl:template>

	<xsl:template match="*[/UPDATE-X/vars/selectedId = 'New']" mode="UPDATE_X-edit-buttonCancel-onclick">
		<xsl:attribute name="onclick">javascript: history.back(); return false;</xsl:attribute>
	</xsl:template>

</xsl:stylesheet>
