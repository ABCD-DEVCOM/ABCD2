<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/style1/xsl/update-x.xsl"/>

	<xsl:template match="*" mode="HTML-form">
		<xsl:apply-templates select="." mode="STYLE1_top"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formEdit"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formCancel"/>
		<xsl:apply-templates select="." mode="UPDATE_X-edit-formTextarea"/>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-form-submit">
		<xsl:variable name="save">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X save'"/>
			</xsl:call-template>
		</xsl:variable>
		<xsl:variable name="cancel">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X cancel'"/>
			</xsl:call-template>
		</xsl:variable>

		<a class="UPDATE_X-submit" href="{$save}" title="{$save}" onclick="javascript: UPDATE_X_sendXML(document.formEdit); return false;"><img src="{$UPDATE-X-ini-PATH-image}/save.gif" alt="{$save}" border="0"/><xsl:value-of select="$save"/></a>
		&#160;&#160;&#160;&#160;
		<a class="UPDATE_X-submit" href="{$cancel}" title="{$cancel}">
			<xsl:apply-templates select="." mode="UPDATE_X-edit-buttonCancel-onclick"/>
			<img src="{$UPDATE-X-ini-PATH-image}/cancel.gif" alt="{$cancel}" border="0"/>
			<xsl:value-of select="$cancel"/>
		</a>
	</xsl:template>
	
	<xsl:template match="/" mode="UPDATE_X-input">
		<table width="100%" cellpadding="0">
			<tr>
				<td>
					<table width="100%" class="ROOT">
						<xsl:apply-templates mode="UPDATE_X-input"/>
					</table>
				</td>
			</tr>
		</table>
	</xsl:template>
	
	<xsl:template match="element" mode="UPDATE_X-input">
		<tr>
			<td colspan="2">
				<table>
					<tr>
						<td colspan="2" valign="top" class="STYLE1_elementLabel">
							<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>
						</td>
					</tr>
					<xsl:apply-templates mode="UPDATE_X-input"/>
				</table>
			</td>
		</tr>
	</xsl:template>
	
	<xsl:template match="element[@repeat = 'list']" mode="UPDATE_X-input">
		<tr>
			<td colspan="2" class="GROUP_BOX">
				<table>
					<tr>
						<td align="right" valign="top" class="STYLE1_elementLabel">
							<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>:
						</td>
						<td valign="top">
							<xsl:apply-templates select="." mode="UPDATE_X-input-repeat"/>
						</td>
					</tr>
					<xsl:apply-templates mode="UPDATE_X-input"/>
				</table>
			</td>
		</tr>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-input-label">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>

		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="$name"/>
		</xsl:call-template>
	</xsl:template>

	<xsl:template match="input[(@type = 'radio' or @type = 'checkbox') and @value]" mode="UPDATE_X-input-text">
		<xsl:param name="name"/>

		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="concat($name,'.',@value)"/>
		</xsl:call-template>
	</xsl:template>

	<xsl:template match="option" mode="UPDATE_X-input-select-option">
		<xsl:param name="name"/>

		<option value="{@value}">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="concat($name,'.',@value)"/>
			</xsl:call-template>
		</option>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list">
		<xsl:param name="name"/>

		<table>
			<tr>
				<td valign="top">
					<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-select">
						<xsl:with-param name="name" select="$name"/>
					</xsl:apply-templates>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-functions">
						<xsl:with-param name="name" select="$name"/>
					</xsl:apply-templates>
				</td>
			</tr>
		</table>
	</xsl:template>

	<xsl:template match="element/element[not(@repeat)]" mode="UPDATE_X-input">
		<xsl:apply-templates mode="UPDATE_X-input"/>
	</xsl:template>

	<xsl:template match="element[@repeat = 'select']" mode="UPDATE_X-input">
		<tr>
			<td valign="top" class="STYLE1_editLabel">
				<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>:
			</td>
			<td>
				<xsl:apply-templates select="." mode="UPDATE_X-input-repeat"/>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="edit[not(input/@type = 'hidden')]" mode="UPDATE_X-input">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>
		
		<tr>
			<td valign="top" class="STYLE1_editLabel">
				<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>:
			</td>
			<td>
				<xsl:apply-templates select="." mode="UPDATE_X-input-type">
					<xsl:with-param name="name" select="$name"/>
				</xsl:apply-templates>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-repeat-label" priority="1"/>

	<xsl:template match="edit" mode="UPDATE_X-input-repeat"/>

</xsl:stylesheet>
