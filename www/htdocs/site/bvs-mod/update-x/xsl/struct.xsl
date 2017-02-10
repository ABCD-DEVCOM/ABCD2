<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:variable name="UPDATE-X-struct" select="document(concat('file://',$UPDATE-X-ini/XML/struct))"/>

	<xsl:template match="*" mode="UPDATE_X-script-edit-struct">
		<script language="JavaScript">
			var UPDATE_X_tree = {
				item: new Array (
					{
						list: new Array (
							<xsl:apply-templates select="." mode="UPDATE_X-startStruct"/>
							null
						)
					},
					null
				)
			};
		</script>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-startStruct">
		<xsl:apply-templates select="$UPDATE-X-struct" mode="UPDATE_X-struct">
			<xsl:with-param name="content" select="data"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-struct">
		<xsl:param name="content"/>

		<xsl:variable name="name" select="@name"/>
		<xsl:variable name="this-content" select="$content/*[name() = $name]"/>

		{
			name: "<xsl:apply-templates select="." mode="UPDATE_X-struct-name"/>",
			path: "<xsl:apply-templates select="." mode="UPDATE_X-struct-path"/>",
			type: "<xsl:apply-templates select="." mode="UPDATE_X-struct-type"/>",
			repeat: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat"><xsl:with-param name="content" select="$this-content"/></xsl:apply-templates>,
			value: <xsl:apply-templates select="." mode="UPDATE_X-struct-value"><xsl:with-param name="content" select="$this-content"/></xsl:apply-templates>,
			child: <xsl:apply-templates select="." mode="UPDATE_X-struct-child"><xsl:with-param name="content" select="$this-content"/></xsl:apply-templates>
		}, // <xsl:apply-templates select="." mode="UPDATE_X-struct-name"/>
	</xsl:template>

	<xsl:template match="edit" mode="UPDATE_X-struct">
		<xsl:param name="content"/>
		
		<xsl:variable name="name" select="@name"/>
		<xsl:variable name="this-content">
			<xsl:choose>
				<xsl:when test="contains($name,'@')">
					<xsl:value-of select="$content/@*[name() = substring-after($name,'@')]"/>
				</xsl:when>
				<xsl:when test="$name = 'text()'">
					<xsl:value-of select="$content/text()"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="$content/*[name() = $name]"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>

		{
			name: "<xsl:apply-templates select="." mode="UPDATE_X-struct-name"/>",
			path: "<xsl:apply-templates select="." mode="UPDATE_X-struct-path"/>",
			type: "<xsl:apply-templates select="." mode="UPDATE_X-struct-type"/>",
			repeat: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat"><xsl:with-param name="content" select="$this-content"/></xsl:apply-templates>,
			value: <xsl:apply-templates select="." mode="UPDATE_X-struct-value"><xsl:with-param name="content" select="$this-content"/></xsl:apply-templates>,
			child: null
		}, // <xsl:apply-templates select="." mode="UPDATE_X-struct-name"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-name">
		<xsl:value-of select="@name"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-path">
		<xsl:call-template name="UPDATE_X-edit-full-path"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-type">
		<xsl:value-of select="name()"/>
	</xsl:template>

	<xsl:template match="element | edit" mode="UPDATE_X-struct-repeat">
		null
	</xsl:template>

	<xsl:template match="element[@repeat]" mode="UPDATE_X-struct-repeat">
		<xsl:param name="content"/>
	
		{
			type: "<xsl:value-of select="@repeat"/>",
			current: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat-current"><xsl:with-param name="content" select="$content"/></xsl:apply-templates>,
			add: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat-add-child"/>
		}
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-repeat-current">
		<xsl:param name="content"/>

		<xsl:choose>
			<xsl:when test="$content">
				<xsl:choose>
					<xsl:when test="$content != '' or $content/@* != ''">0</xsl:when>
					<xsl:otherwise>-1</xsl:otherwise>
				</xsl:choose>
			</xsl:when>
			<xsl:otherwise>-1</xsl:otherwise>
		</xsl:choose>

	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-repeat-add">
		{
			name: "<xsl:apply-templates select="." mode="UPDATE_X-struct-name"/>",
			path: "<xsl:apply-templates select="." mode="UPDATE_X-struct-path"/>",
			type: "<xsl:apply-templates select="." mode="UPDATE_X-struct-type"/>",
			repeat: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat"/>,
			child: <xsl:apply-templates select="." mode="UPDATE_X-struct-repeat-add-child"/>
		},
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-repeat-add-child">
		null
	</xsl:template>

	<xsl:template match="*[element | edit]" mode="UPDATE_X-struct-repeat-add-child">
		new Array ( <xsl:apply-templates select="*" mode="UPDATE_X-struct-repeat-add"/> null )
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-struct-value">
		null
	</xsl:template>

	<xsl:template match="element[@repeat = 'select']" mode="UPDATE_X-struct-value">
		<xsl:param name="content"/>
	
		"" <xsl:apply-templates select="$content" mode="UPDATE_X-struct-value-select"/>
	</xsl:template>

	<xsl:template match="edit" mode="UPDATE_X-struct-value">
		<xsl:param name="content"/>
	
		<xsl:call-template name="UPDATE_X-struct-js-value">
			<xsl:with-param name="value" select="$content"/>
			<xsl:with-param name="result" select="''"/>
		</xsl:call-template>
	</xsl:template>

	<xsl:template match="edit[textarea]" mode="UPDATE_X-struct-value">
		<xsl:param name="content"/>

		<xsl:choose>
			<xsl:when test="$content != ''">null</xsl:when> <!-- must be stored in the formTextarea -->
			<xsl:otherwise>""</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-struct-value-select">
		+ "<xsl:element name="{name()}" xml:space="default"><xsl:value-of select="."/></xsl:element>"
	</xsl:template>

	<xsl:template name="UPDATE_X-struct-js-value">
		<xsl:param name="value"/>
		<xsl:param name="result"/>

		<xsl:variable name="before-quote" select="substring-before($value,'&quot;')"/>
		<xsl:variable name="after-quote" select="substring-after($value,'&quot;')"/>
		<xsl:variable name="quote" select="'\&quot;'"/>

		<xsl:choose>
			<xsl:when test="contains($value,'&quot;')">
				<xsl:call-template name="UPDATE_X-struct-js-value">
					<xsl:with-param name="value" select="$after-quote"/>
					<xsl:with-param name="result" select="concat($result,$before-quote,$quote)"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				"<xsl:value-of select="normalize-space(concat($result,$value))"/>"
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="*" mode="UPDATE_X-struct-child">
		null
	</xsl:template>

	<xsl:template match="*[element | edit]" mode="UPDATE_X-struct-child">
		<xsl:param name="content"/>

		{
			item: new Array (
				{
					list: new Array (
						<xsl:apply-templates mode="UPDATE_X-struct">
							<xsl:with-param name="content" select="$content[1]"/>
						</xsl:apply-templates>
						null
					)
				},
				null
			)
		}
	</xsl:template>

	<xsl:template match="element[@repeat = 'list']" mode="UPDATE_X-struct-child">
		<xsl:param name="content"/>

		<xsl:variable name="this" select="."/>

		{
			item: new Array (
				<xsl:for-each select="$content">
				{
					list: new Array (
						<xsl:apply-templates select="$this/*" mode="UPDATE_X-struct">
							<xsl:with-param name="content" select="."/>
						</xsl:apply-templates>
						null
					)
				},
				</xsl:for-each>
				null
			)
		}
	</xsl:template>

</xsl:stylesheet>
