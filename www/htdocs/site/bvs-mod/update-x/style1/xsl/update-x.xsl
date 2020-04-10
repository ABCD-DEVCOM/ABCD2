<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="*" mode="STYLE1_top">
		<table width="100%">
			<tr class="PROJECT_LINE">
				<td class="PROJECT_LINE_update_x" nowrap="" width="5%">
					<xsl:apply-templates select="$UPDATE-X-vars/UPDATE_X" mode="PROJECT_LINE_update_x"/>
				</td>
				<td class="PROJECT_LINE_project_name" nowrap="" width="5%">
					<xsl:apply-templates select="$UPDATE-X-ini/PROJECT" mode="PROJECT_LINE_project_name"/>
				</td>
				<td class="PROJECT_LINE_user" nowrap="" width="5%">
					<xsl:apply-templates select="$UPDATE-X-vars/user" mode="PROJECT_LINE_user"/>
				</td>
				<td class="PROJECT_LINE_filler">
					<xsl:apply-templates select="." mode="PROJECT_LINE_filler"/>
				</td>
			</tr>
		</table>
	</xsl:template>

	<xsl:template match="UPDATE_X" mode="PROJECT_LINE_update_x">
		<xsl:value-of select="concat(.,' ',../UPDATE_X_VERSION)"/>
	</xsl:template>

	<xsl:template match="PROJECT" mode="PROJECT_LINE_project_name">
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="'UPDATE-X project'"/>
		</xsl:call-template>
		<span class="PROJECT_LINE_info"><xsl:value-of select="name"/></span>
	</xsl:template>
	
	<xsl:template match="user" mode="PROJECT_LINE_user">
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="'UPDATE-X user'"/>
		</xsl:call-template>
		<span class="PROJECT_LINE_info"><xsl:value-of select="."/></span>
	</xsl:template>

	<xsl:template match="*" mode="PROJECT_LINE_filler">
		&#160;
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-buttons">
		<table width="100%">
			<tr>
				<td width="10%" nowrap="">
					<xsl:apply-templates select="$UPDATE-X-vars/selectedId" mode="UPDATE_X-inform-selectedId"/>
				</td>
				<td height="40" width="80%" align="center">
					<xsl:apply-templates select="." mode="UPDATE_X-form-submit"/>
				</td>
				<td width="10%" align="right">
					<xsl:apply-templates select="$UPDATE-X-ini/EXIT/href" mode="UPDATE_X-exit"/>
				</td>
			</tr>
		</table>
	</xsl:template>	
	
	<xsl:template match="selectedId" mode="UPDATE_X-inform-selectedId">
		<br/>
		<span class="UPDATE_X-inform-selectedId">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X id'"/>
			</xsl:call-template>:
			<b><xsl:value-of select="."/></b>
		</span>
	</xsl:template>	
	
	<xsl:template match="selectedId[. = 'New']" mode="UPDATE_X-inform-selectedId"/>

	<xsl:template match="*" mode="UPDATE_X-exit">
		<xsl:variable name="exit">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X exit'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{.}" title="{$exit}"><img src="{$UPDATE-X-ini-PATH-image}/exit.gif" alt="{$exit}" border="0"/><xsl:value-of select="$exit"/></a>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-button-listDocuments">
		<xsl:variable name="list">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X list documents'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{$list}" title="{$list}" onclick="javascript: document.formList.submit(); return false;"><img src="{$UPDATE-X-ini-PATH-image}/list.gif" alt="{$list}" border="0"/><xsl:value-of select="$list"/></a>
		&#160;&#160;&#160;&#160;
	</xsl:template>	

	<xsl:template match="*" mode="UPDATE_X-button-newDocument">
		<xsl:variable name="new">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X new document'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{$new}" title="{$new}" onclick="javascript: document.formNew.submit(); return false;"><img src="{$UPDATE-X-ini-PATH-image}/new.gif" alt="{$new}" border="0"/><xsl:value-of select="$new"/></a>
		&#160;&#160;&#160;&#160;
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-button-deleteDocument">
		<xsl:variable name="delete">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X delete document'"/>
			</xsl:call-template>
		</xsl:variable>

		<xsl:apply-templates select="." mode="UPDATE_X-button-deleteDocument-script"/>
		<a class="UPDATE_X-submit" href="{$delete}" title="{$delete}" onclick="javascript: UPDATE_X_deleteDocument(document.formDelete); return false;"><img src="{$UPDATE-X-ini-PATH-image}/remove.gif" alt="{$delete}" border="0"/><xsl:value-of select="$delete"/></a>
		&#160;&#160;&#160;&#160;
	</xsl:template>	

	<xsl:template match="*" mode="UPDATE_X-button-editDocument">
		<xsl:variable name="edit">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X edit'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{$edit}" title="{$edit}" onclick="javascript: document.formShow.submit(); return false;"><img src="{$UPDATE-X-ini-PATH-image}/edit.gif" alt="{$edit}" border="0"/><xsl:value-of select="$edit"/></a>
	</xsl:template>	

	<xsl:template match="* | @*" mode="UPDATE_X-show-label">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-show-full-path"/>
		</xsl:variable>

		<span>
			<xsl:apply-templates select="." mode="STYLE1-show-label-class"/>
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="$name"/>
			</xsl:call-template>
		</span>
	</xsl:template>
	
	<xsl:template match="*" mode="STYLE1-show-label-class">
		<xsl:attribute name="class">STYLE1_elementLabel</xsl:attribute>
	</xsl:template>
	
	<xsl:template match="@* | *[not(*)]" mode="STYLE1-show-label-class">
		<xsl:attribute name="class">STYLE1_editLabel</xsl:attribute>
	</xsl:template>

</xsl:stylesheet>
