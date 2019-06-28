<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/style2/xsl/update-x.xsl"/>

	<xsl:template match="*" mode="UPDATE_X-form-submit">
		<xsl:variable name="edit">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X edit'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{$edit}" title="{$edit}" onclick="javascript: document.formShow.submit(); return false;"><img src="{$UPDATE-X-ini-PATH-image}/edit.gif" alt="{$edit}" border="0"/><xsl:value-of select="$edit"/></a>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-startShow">
		<table width="100%" cellpadding="0">
			<tr>
				<td>
					<table width="100%" class="ROOT">
						<tr>
							<td>
								<xsl:apply-templates select="/UPDATE-X/data/*" mode="UPDATE_X-show"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</xsl:template>
	
</xsl:stylesheet>
