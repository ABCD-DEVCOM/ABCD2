<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes"/>

	<xsl:template match="/">
		<xsl:apply-templates select="." mode="HTML-html"/>
	</xsl:template>

	<xsl:template match="*" mode="HTML-html">
		<html>
			<xsl:apply-templates select="." mode="HTML-head"/>
			<xsl:apply-templates select="." mode="HTML-body"/>
		</html>
	</xsl:template>

	<xsl:template match="*" mode="HTML-head">
		<head>
			<xsl:apply-templates select="." mode="HTML-title"/>
			<xsl:apply-templates select="." mode="HTML-style"/>
			<xsl:apply-templates select="." mode="HTML-script"/>
		</head>
	</xsl:template>

	<xsl:template match="*" mode="HTML-title"/>

	<xsl:template match="*" mode="HTML-style"/>
	
	<xsl:template match="*" mode="HTML-script"/>

	<xsl:template match="*" mode="HTML-body">
		<body>
			<xsl:apply-templates select="." mode="HTML-body-onLoad"/>
			<xsl:apply-templates select="." mode="HTML-body-onUnload"/>
			<xsl:apply-templates select="." mode="HTML-form"/>
		</body>
	</xsl:template>

	<xsl:template match="*" mode="HTML-body-onLoad"/>
	<xsl:template match="*" mode="HTML-body-onUnload"/>
	
	<xsl:template match="*" mode="HTML-debug-textarea">
		<textarea name="debug_{name()}" rows="12" cols="70"><xsl:copy-of select="."/></textarea>
	</xsl:template>

</xsl:stylesheet>
