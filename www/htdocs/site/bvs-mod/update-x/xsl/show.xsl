<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/html.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/update-x.xsl"/>

	<xsl:template match="*" mode="HTML-script">
		<script language="JavaScript" src="{$UPDATE-X-ini/PATH/update-x}/update-x/js/string.js"></script>
	</xsl:template>

	<xsl:template match="*" mode="HTML-form">
		<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-vars"/>
		<xsl:apply-templates select="$UPDATE-X-ini/PROJECT" mode="UPDATE_X-project"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formShow"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show-formShow">
		<form name="formShow" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_SHOW/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
			<xsl:apply-templates select="." mode="UPDATE_X-buttons"/>
			<xsl:apply-templates select="." mode="UPDATE_X-startShow"/>
		</form>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formList"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formNew"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-formDelete"/>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-show-formList"/>
	<xsl:template match="*" mode="UPDATE_X-show-formNew"/>
	<xsl:template match="*" mode="UPDATE_X-show-formDelete"/>

	<xsl:template match="xml | UPDATE_X_saveDate" mode="UPDATE_X-form-hidden"/>

	<xsl:template match="*" mode="UPDATE_X-form-submit">
		<xsl:apply-templates select="." mode="UPDATE_X-button-listDocuments"/>
		<xsl:apply-templates select="." mode="UPDATE_X-button-newDocument"/>
		<xsl:apply-templates select="." mode="UPDATE_X-button-deleteDocument"/>
		<xsl:apply-templates select="." mode="UPDATE_X-button-editDocument"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-button-listDocuments"/>
	<xsl:template match="*" mode="UPDATE_X-button-newDocument"/>
	<xsl:template match="*" mode="UPDATE_X-button-deleteDocument"/>

	<xsl:template match="*" mode="UPDATE_X-startShow">
		<xsl:apply-templates select="/UPDATE-X/data/*" mode="UPDATE_X-show"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show">
		<ul type="disc">
			<li>
				<xsl:apply-templates select="." mode="UPDATE_X-show-label"/>
			</li>
			<xsl:apply-templates select="@* | *" mode="UPDATE_X-show"/>
		</ul>
	</xsl:template>

	<xsl:template match="*[not(*)] | @*" mode="UPDATE_X-show">
		<ul type="disc">
			<li>
				<xsl:apply-templates select="." mode="UPDATE_X-show-label"/>
				<br/>
				<xsl:apply-templates select="@*" mode="UPDATE_X-show"/>
				<xsl:apply-templates select="." mode="UPDATE_X-show-content"/>
			</li>
		</ul>
	</xsl:template>

	<xsl:template match="@*" mode="UPDATE_X-show-label">
		<span class="UPDATE_X-show-label"><xsl:value-of select="concat('@',name())"/></span>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show-label">
		<span class="UPDATE_X-show-label"><xsl:value-of select="name()"/></span>
	</xsl:template>

	<xsl:template match="@* | *" mode="UPDATE_X-show-content">
		<span class="UPDATE_X-show-content"><xsl:value-of select="."/></span>
	</xsl:template>

</xsl:stylesheet>
