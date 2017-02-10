<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:variable name="UPDATE-X-vars" select="/UPDATE-X/vars"/>
	<xsl:variable name="UPDATE-X-ini" select="/UPDATE-X/ini"/>
	<xsl:variable name="lang" select="/UPDATE-X/vars/lang"/>
	<xsl:variable name="UPDATE-X-ini-PATH-image">
		<xsl:choose>
			<xsl:when test="$UPDATE-X-ini/PATH/image">
				<xsl:value-of select="$UPDATE-X-ini/PATH/image"/>
			</xsl:when>
			<xsl:otherwise><xsl:value-of select="'../image'"/></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	 
	<xsl:variable name="UPDATE-X-texts-file" select="concat('file://',$UPDATE-X-ini/XML/text)"/>
	<xsl:variable name="UPDATE-X-texts" select="document($UPDATE-X-texts-file)/texts/language[@id = $lang]"/>

	<xsl:template name="UPDATE_X-show-full-path">
		<xsl:apply-templates select="ancestor::*" mode="UPDATE_X-show-path"/>
		<xsl:apply-templates select="." mode="UPDATE_X-show-path"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show-path">
		<xsl:value-of select="concat('/',name())"/>
	</xsl:template>

	<xsl:template match="@*" mode="UPDATE_X-show-path">
		<xsl:value-of select="concat('/@',name())"/>
	</xsl:template>
	
	<xsl:template match="/UPDATE-X | /UPDATE-X/data" mode="UPDATE_X-show-path"/>

	<xsl:template match="*" mode="HTML-title">
		<title><xsl:value-of select="concat($UPDATE-X-ini/PROJECT/title,' [',$UPDATE-X-vars/UPDATE_X,' ',$UPDATE-X-vars/UPDATE_X_VERSION,']')"/></title>
	</xsl:template>

	<xsl:template match="*" mode="HTML-style">
		<xsl:apply-templates select="$UPDATE-X-ini/CSS/*" mode="UPDATE_X-style"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-style">
		<link rel="stylesheet" href="{.}" type="text/css"></link>
	</xsl:template>
	
	<xsl:template match="UPDATE_X" mode="UPDATE_X-vars">
		<span class="UPDATE_X-edit-version"><xsl:value-of select="concat(.,' ',../UPDATE_X_VERSION)"/></span>
	</xsl:template>

	<xsl:template match="UPDATE_X_VERSION | UPDATE_X_saveDate" mode="UPDATE_X-vars"/>

	<xsl:template match="*" mode="UPDATE_X-vars">
		<span class="UPDATE_X-edit-vars"><xsl:value-of select="concat(name(),'=',.)"/></span>
	</xsl:template>

	<xsl:template match="PROJECT" mode="UPDATE_X-project">
		<span class="UPDATE_X-project">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X project'"/>
			</xsl:call-template>
			<xsl:value-of select="name"/>
		</span>
	</xsl:template>

	<xsl:template name="UPDATE_X-texts">
		<xsl:param name="find"/>
		
		<xsl:variable name="found" select="$UPDATE-X-texts/text[find = $find]/replace"/>
		
		<xsl:choose>
			<xsl:when test="$found != ''">
				<xsl:copy-of select="$found/text() | $found/*"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="concat('[',$find,']')"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-alt1-form">
		<form name="formNew" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_SHOW/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
			<input type="hidden" name="selectedId" value="New"/>
		</form>
		<form name="formDelete" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_DELETE/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
			<input type="hidden" name="selectedId" value="{data/*/record[1]/@mfn}"/>
		</form>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-form-action">
		<xsl:attribute name="action"><xsl:value-of select="."/></xsl:attribute>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-form-hidden">
		<input type="hidden" name="{name()}" value="{.}"/>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-buttons">
		<table width="100%">
			<tr>
				<td width="80%" align="left">
					<xsl:apply-templates select="." mode="UPDATE_X-form-submit"/>
				</td>
				<td width="20%" align="right">
					<xsl:apply-templates select="$UPDATE-X-ini/EXIT/href" mode="UPDATE_X-exit"/>
				</td>
			</tr>
		</table>
	</xsl:template>	

	<xsl:template match="*" mode="UPDATE_X-button-editDocument">
		<input type="button" name="UPDATE_X_buttonEditXML" onclick="javascript: document.formShow.submit();">
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X edit'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
	</xsl:template>	
			
	<xsl:template match="*" mode="UPDATE_X-exit">
		<a href="{.}">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X exit'"/>
			</xsl:call-template>
		</a>
	</xsl:template>
	
</xsl:stylesheet>
