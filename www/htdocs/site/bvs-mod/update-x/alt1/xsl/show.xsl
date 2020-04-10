<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/show.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/alt1/xsl/update-x.xsl"/>

	<xsl:template match="*[/UPDATE-X/data/*/write/Isis_Status/occ != '0']" mode="UPDATE_X-show-formShow">
		<xsl:apply-templates select="." mode="UPDATE_X-edit-lockError"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X_lockError-message">
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="'UPDATE-X could not save'"/>
		</xsl:call-template>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-button-listDocuments">
		<input type="button" name="UPDATE_X_buttonListDocuments" onclick="javascript: document.formList.submit();">
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X list documents'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
	</xsl:template>	
	
	<xsl:template match="*" mode="UPDATE_X-startShow">
		<table width="100%" cellpadding="0">
			<tr>
				<td>
					<table width="100%" class="ROOT">
						<tr>
							<td>
								<xsl:apply-templates select="/UPDATE-X/data/*/record/field[@tag = '1']/occ/*" mode="UPDATE_X-show"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</xsl:template>
</xsl:stylesheet>
