<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema">

	<xsl:output method="xml" indent="yes"/>

	<xsl:template match="/">
		<xsl:apply-templates select="/UPDATE-X/vars" mode="UPDATE_X-write-comment"/>
		<xsl:apply-templates select="/UPDATE-X/data/*"/>
	</xsl:template>
	
	<xsl:template match="/UPDATE-X/vars" mode="UPDATE_X-write-comment">
		<xsl:comment>
			<xsl:value-of select="' '"/>
			<xsl:apply-templates select="UPDATE_X" mode="UPDATE_X-write-comment"/>
			<xsl:apply-templates select="UPDATE_X_VERSION" mode="UPDATE_X-write-comment"/>
			<xsl:apply-templates select="UPDATE_X_saveDate" mode="UPDATE_X-write-comment"/>
			<xsl:apply-templates select="user" mode="UPDATE_X-write-comment"/>
			<xsl:value-of select="' '"/>
		</xsl:comment>
	</xsl:template>
	
	<xsl:template match="UPDATE_X" mode="UPDATE_X-write-comment">
		<xsl:value-of select="concat('updated with ',.)"/>
	</xsl:template>
	
	<xsl:template match="UPDATE_X_VERSION" mode="UPDATE_X-write-comment">
		<xsl:value-of select="concat(' ',.)"/>
	</xsl:template>
	
	<xsl:template match="UPDATE_X_saveDate" mode="UPDATE_X-write-comment">
		<xsl:value-of select="concat(' on ',.)"/>
	</xsl:template>
	
	<xsl:template match="user" mode="UPDATE_X-write-comment">
		<xsl:value-of select="concat(' by ',.)"/>
	</xsl:template>
	
	<xsl:template match="* | @*">
		<xsl:copy>
			<xsl:apply-templates select="* | @* | text()"/>
		</xsl:copy>
	</xsl:template>

</xsl:stylesheet>