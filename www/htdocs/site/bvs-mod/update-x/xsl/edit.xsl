<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/html.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/update-x.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/struct.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/input.xsl"/>

	<xsl:template match="*" mode="HTML-script">
		<xsl:apply-templates select="." mode="UPDATE_X-script-edit-struct"/>
		<xsl:apply-templates select="." mode="UPDATE_X-script-edit-input"/>
	</xsl:template>
	
	<xsl:template match="*" mode="HTML-body-onLoad">
		<xsl:attribute name="onLoad">javascript: UPDATE_X_spreadTree(UPDATE_X_tree);</xsl:attribute>
	</xsl:template>

	<xsl:template match="*" mode="HTML-form">
		<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-vars"/>
		<xsl:apply-templates select="$UPDATE-X-ini/PROJECT" mode="UPDATE_X-project"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formEdit"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formCancel"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formTextarea"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-formEdit">
		<form name="formEdit" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_EDIT/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
			<input type="hidden" name="xml" value=""/>
			<xsl:apply-templates select="." mode="UPDATE_X-buttons"/>
			<xsl:apply-templates select="$UPDATE-X-ini/JS/debug" mode="UPDATE_X-edit-formEdit-debug"/>
			<xsl:apply-templates select="$UPDATE-X-struct" mode="UPDATE_X-input"/>
		</form>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-form-submit">
		<input type="button" name="UPDATE_X_buttonSendXML" onclick="javascript: UPDATE_X_sendXML(this.form);">
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X save'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
		<input type="button" name="UPDATE_X_buttonCancel">
			<xsl:apply-templates select="." mode="UPDATE_X-edit-buttonCancel-onclick"/>
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X cancel'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-buttonCancel-onclick">
		<xsl:attribute name="onclick">javascript: document.formCancel.submit(); return false;</xsl:attribute>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-formEdit-debug">
		<input name="debugStruct" type="button" value="struct" onclick="javascript: UPDATE_X_debugStruct();"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-formCancel">
		<form name="formCancel" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_CANCEL/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
		</form>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-formTextarea">
		<form name="formTextarea" method="post" class="UPDATE_X-edit-formTextarea">
			<xsl:apply-templates select="." mode="UPDATE_X-input-textarea"/>
		</form>
	</xsl:template>

	<xsl:template name="UPDATE_X-edit-full-path">
		<xsl:apply-templates select="ancestor::*" mode="UPDATE_X-edit-path"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-path"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-path">
		<xsl:value-of select="concat('/',@name)"/>
	</xsl:template>

	<xsl:template match="@*" mode="UPDATE_X-edit-path">
		<xsl:value-of select="concat('/@',@name)"/>
	</xsl:template>

</xsl:stylesheet>
