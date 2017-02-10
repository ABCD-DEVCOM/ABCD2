<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/UPDATE-X/data/* | /UPDATE-X/data/*/record | /UPDATE-X/data/*/record/field | /UPDATE-X/data/*/record/field/occ" mode="UPDATE_X-show-path"/>

	<xsl:template match="*" mode="UPDATE_X-show-formList">
		<form name="formList" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_LIST/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
		</form>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show-formNew">
		<form name="formNew" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_SHOW/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*[name() != 'selectedId']" mode="UPDATE_X-form-hidden"/>
			<input type="hidden" name="selectedId" value="New"/>
		</form>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-show-formDelete">
		<form name="formDelete" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_DELETE/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*[name() != 'selectedId']" mode="UPDATE_X-form-hidden"/>
			<xsl:apply-templates select="$UPDATE-X-vars/selectedId" mode="UPDATE_X-form-hidden-selectedId"/>
		</form>
	</xsl:template>

	<xsl:template match="selectedId" mode="UPDATE_X-form-hidden-selectedId">
		<xsl:choose>
			<xsl:when test="/UPDATE-X/data/*/delete/Isis_Status/occ = '0'">
				<input type="hidden" name="selectedId" value=""/>
			</xsl:when>
			<xsl:when test="/UPDATE-X/data/*[delete]/delete/Isis_Status/occ != '0'">
				<input type="hidden" name="selectedId" value="{/UPDATE-X/data/*[delete]/record[1]/@mfn}"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates select="." mode="UPDATE_X-form-hidden"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-button-newDocument">
		<input type="button" name="UPDATE_X_buttonNewDocument" onclick="javascript: document.formNew.submit();">
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X new document'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
	</xsl:template>	

	<xsl:template match="*" mode="UPDATE_X-button-deleteDocument">
		<xsl:apply-templates select="." mode="UPDATE_X-button-deleteDocument-script"/>
		<input type="button" name="UPDATE_X_buttonDeleteDocument" onclick="javascript: return UPDATE_X_deleteDocument(document.formDelete);">
			<xsl:attribute name="value">
				<xsl:call-template name="UPDATE_X-texts">
					<xsl:with-param name="find" select="'UPDATE-X delete document'"/>
				</xsl:call-template>
			</xsl:attribute>
		</input>
	</xsl:template>	

	<xsl:template match="*" mode="UPDATE_X-button-deleteDocument-script">
		<xsl:variable name="confirmDelete">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="'UPDATE-X delete confirm'"/>
			</xsl:call-template>
		</xsl:variable>

		<script language="JavaScript">
			function UPDATE_X_deleteDocument ( formDelete )
			{
				var msg = '<xsl:value-of select="$confirmDelete"/>';
				if ( confirm(STRING_replace(msg,"[UPDATE-X id]",formDelete.selectedId.value)) )
				{
					formDelete.submit();
					return true;
				}
				
				return false;
			}
		</script>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-edit-lockError">
		<form name="formDocuments" method="post">
			<xsl:apply-templates select="$UPDATE-X-ini/FORM_DOCUMENTS/action" mode="UPDATE_X-form-action"/>
			<xsl:apply-templates select="$UPDATE-X-vars/*" mode="UPDATE_X-form-hidden"/>
			
			<dl type="disc">
				<dd class="UPDATE_X_lockError">
					<xsl:apply-templates select="$UPDATE-X-vars/selectedId" mode="UPDATE_X-inform-selectedId"/>
				</dd>
				<dd>
					<br/>
				</dd>
				<dd class="UPDATE_X_lockError">
					<xsl:apply-templates select="." mode="UPDATE_X_lockError-message"/>
				</dd>
				<dd>&#160;</dd>
				<dd class="UPDATE_X_lockError-continue">
					<input type="submit" name="UPDATE_X_buttonContinue" value="continue">
						<xsl:attribute name="value">
							<xsl:call-template name="UPDATE_X-texts">
								<xsl:with-param name="find" select="'UPDATE-X continue'"/>
							</xsl:call-template>
						</xsl:attribute>
					</input>
				</dd>
				<dd>&#160;</dd>
				<dd class="UPDATE_X_lockError-code">
					<xsl:apply-templates select="/UPDATE-X/data/*/*/Isis_Status/occ" mode="UPDATE_X_lockError-code"/>
				</dd>
			</dl>
		</form>		
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X_lockError-message">
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="'UPDATE-X locked document'"/>
		</xsl:call-template>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X_lockError-code">
		<xsl:call-template name="UPDATE_X-texts">
			<xsl:with-param name="find" select="'UPDATE-X locked error code'"/>
		</xsl:call-template>
		<b><xsl:value-of select="."/></b>
	</xsl:template>

</xsl:stylesheet>
