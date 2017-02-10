<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="*" mode="UPDATE_X-script-edit-input">
		<xsl:apply-templates select="$UPDATE-X-ini/JS/edit" mode="UPDATE_X-input-js"/>
		<script language="JavaScript">
			var UPDATE_X_validateMessageList = new Array (
				"no error",
				<xsl:apply-templates select="$UPDATE-X-texts/text[starts-with(find,'VALIDATE:')]" mode="UPDATE_X-validateMessage"/>
				null
			);
		</script>
		<xsl:apply-templates select="$UPDATE-X-ini/JS/validate" mode="UPDATE_X-input-js"/>
		<xsl:if test="$UPDATE-X-ini/JS[not(validate)]">
			<script language="JavaScript" src="{$UPDATE-X-ini/PATH/update-x}/update-x/js/validate.js"></script>
		</xsl:if>
		<xsl:apply-templates select="$UPDATE-X-ini/JS/debug" mode="UPDATE_X-input-js"/>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-js">
		<script language="JavaScript" src="{.}"></script>
	</xsl:template>

	<xsl:template match="text" mode="UPDATE_X-validateMessage">
		"<xsl:value-of select="replace"/>",
	</xsl:template>
	
	<xsl:template match="element" mode="UPDATE_X-input">
		<ul type="disc">
			<li>
				<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>
				<xsl:apply-templates select="." mode="UPDATE_X-input-repeat"/>
			</li>
			<xsl:apply-templates mode="UPDATE_X-input"/>
		</ul>
	</xsl:template>

	<xsl:template match="edit" mode="UPDATE_X-input">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>

		<ul type="disc">
			<li>
				<xsl:apply-templates select="." mode="UPDATE_X-input-label"/>
				<br/>
				<xsl:apply-templates select="." mode="UPDATE_X-input-type">
					<xsl:with-param name="name" select="$name"/>
				</xsl:apply-templates>
			</li>
		</ul>
	</xsl:template>

	<xsl:template match="edit[input/@type = 'hidden']" mode="UPDATE_X-input">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>

		<xsl:apply-templates select="." mode="UPDATE_X-input-type">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="input | option | textarea | text()" mode="UPDATE_X-input"/>

	<xsl:template match="*" mode="UPDATE_X-input-label">
		<xsl:value-of select="concat(name(),' ',@name)"/>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat">
		<xsl:variable name="name">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>

		<xsl:if test="@repeat">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-label"/>
			<xsl:choose>
				<xsl:when test="@repeat = 'select'">
					<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-select">
						<xsl:with-param name="name" select="$name"/>
					</xsl:apply-templates>
				</xsl:when>
				<xsl:when test="@repeat = 'list'">
					<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list">
						<xsl:with-param name="name" select="$name"/>
					</xsl:apply-templates>
				</xsl:when>
				<xsl:otherwise>
					<xsl:apply-templates select="*" mode="UPDATE_X-input-repeat-unknown"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:if>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-repeat-label">
		repeat:<xsl:value-of select="@repeat"/>
	</xsl:template>

	<xsl:template match="element[@repeat = 'select']" mode="UPDATE_X-input-repeat-label">
		repeat:<xsl:value-of select="@repeat"/>
		<br/>
	</xsl:template>

	<xsl:template match="select" mode="UPDATE_X-input-repeat-select">
		<xsl:param name="name"/>

		<select name="{$name}" multiple="" onblur="javascript: UPDATE_X_setMultipleValue(this);">
			<xsl:copy-of select="@*"/>
			<xsl:apply-templates select="option" mode="UPDATE_X-input-select-option">
				<xsl:with-param name="name" select="$name"/>
			</xsl:apply-templates>
		</select>
	</xsl:template>

	<xsl:template match="option" mode="UPDATE_X-input-select-option">
		<xsl:param name="name"/>

		<xsl:copy-of select="."/>
	</xsl:template>

	<xsl:template match="input" mode="UPDATE_X-input-repeat-select">
		<xsl:param name="name"/>

		<input name="{$name}" onblur="javascript: UPDATE_X_setCheckboxValue(this);">
			<xsl:copy-of select="@*"/>
			<xsl:apply-templates select="." mode="UPDATE_X-input-text">
				<xsl:with-param name="name" select="$name"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="input" mode="UPDATE_X-input-text">
		<xsl:param name="name"/>

		<xsl:copy-of select="text() | *"/>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list">
		<xsl:param name="name"/>

		&#160;
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-select">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<br/>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-functions">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-select">
		<xsl:param name="name"/>

		<select class="UPDATE_X-input-repeat-list" name="{$name}" onchange="javascript: UPDATE_X_goto(this);"/>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-functions">
		<xsl:param name="name"/>

		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-goto">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-add">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-delete">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-move">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-goto">
		<xsl:param name="name"/>

		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-first">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-previous">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-next">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-last">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-first">
		<xsl:param name="name"/>

		<input name="first" type="Image" src="{$UPDATE-X-ini-PATH-image}/first.gif" onclick="javascript: UPDATE_X_first('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'first'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-previous">
		<xsl:param name="name"/>

		<input name="previous" type="Image" src="{$UPDATE-X-ini-PATH-image}/previous.gif" onclick="javascript: UPDATE_X_previous('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'previous'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-next">
		<xsl:param name="name"/>

		<input name="next" type="Image" src="{$UPDATE-X-ini-PATH-image}/next.gif" onclick="javascript: UPDATE_X_next('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'next'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-last">
		<xsl:param name="name"/>

		<input name="last" type="Image" src="{$UPDATE-X-ini-PATH-image}/last.gif" onclick="javascript: UPDATE_X_last('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'last'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-add">
		<xsl:param name="name"/>

		&#160;
		<input name="add" type="Image" src="{$UPDATE-X-ini-PATH-image}/add.gif" onclick="javascript: UPDATE_X_add('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'add'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-delete">
		<xsl:param name="name"/>

		<input name="delete" type="Image" src="{$UPDATE-X-ini-PATH-image}/delete.gif" onclick="javascript: UPDATE_X_delete('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'delete'"/>
			</xsl:apply-templates>
		</input>
		&#160;
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-move">
		<xsl:param name="name"/>

		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-top">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-up">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-down">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
		<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-botton">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-top">
		<xsl:param name="name"/>

		<input name="top" type="Image" src="{$UPDATE-X-ini-PATH-image}/top.gif" onclick="javascript: UPDATE_X_top('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'top'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-up">
		<xsl:param name="name"/>

		<input name="up" type="Image" src="{$UPDATE-X-ini-PATH-image}/up.gif" onclick="javascript: UPDATE_X_up('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'up'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-down">
		<xsl:param name="name"/>

		<input name="down" type="Image" src="{$UPDATE-X-ini-PATH-image}/down.gif" onclick="javascript: UPDATE_X_down('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'down'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="element" mode="UPDATE_X-input-repeat-list-botton">
		<xsl:param name="name"/>

		<input name="botton" type="Image" src="{$UPDATE-X-ini-PATH-image}/bottom.gif" onclick="javascript: UPDATE_X_botton('{$name}'); return false;">
			<xsl:apply-templates select="." mode="UPDATE_X-input-repeat-list-attributes">
				<xsl:with-param name="label" select="'botton'"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-repeat-list-attributes">
		<xsl:param name="label"/>
		
		<xsl:attribute name="alt">
			<xsl:call-template name="UPDATE_X-texts">
				<xsl:with-param name="find" select="concat('UPDATE-X ',$label)"/>
			</xsl:call-template>
		</xsl:attribute>
		<xsl:attribute name="onmouseover">javascript: UPDATE_X_buttonSendXML_backupColor = this.style.backgroundColor; this.style.backgroundColor = 'LightSlateGray'</xsl:attribute>
		<xsl:attribute name="onmouseout">javascript: this.style.backgroundColor = UPDATE_X_buttonSendXML_backupColor;</xsl:attribute>
	</xsl:template>
	
	<xsl:template match="element" mode="UPDATE_X-input-repeat-unknown">
		&#160;<span class="UPDATE_X-input-element-repeat-unknown">element repeat unknown</span>
	</xsl:template>

	<xsl:template match="edit" mode="UPDATE_X-input-type">
		<xsl:param name="name"/>
	
		<input name="{$name}" type="text" size="40" value="" onblur="javascript: UPDATE_X_setValue(this);"/>
	</xsl:template>

	<xsl:template match="edit[input or select or textarea]" mode="UPDATE_X-input-type">
		<xsl:param name="name"/>

		<xsl:apply-templates select="input | select | textarea" mode="UPDATE_X-input-type">
			<xsl:with-param name="name" select="$name"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="input" mode="UPDATE_X-input-type">
		<xsl:param name="name"/>

		<input name="{$name}" onblur="javascript: UPDATE_X_setValue(this);">
			<xsl:copy-of select="@*"/>
			<xsl:apply-templates select="." mode="UPDATE_X-input-text">
				<xsl:with-param name="name" select="$name"/>
			</xsl:apply-templates>
		</input>
	</xsl:template>

	<xsl:template match="select" mode="UPDATE_X-input-type">
		<xsl:param name="name"/>

		<select name="{$name}" onblur="javascript: UPDATE_X_setValue(this);">
			<xsl:copy-of select="@*"/>
			<xsl:apply-templates select="option" mode="UPDATE_X-input-select-option">
				<xsl:with-param name="name" select="$name"/>
			</xsl:apply-templates>
		</select>
	</xsl:template>

	<xsl:template match="textarea" mode="UPDATE_X-input-type">
		<xsl:param name="name"/>

		<textarea name="{$name}" onblur="javascript: UPDATE_X_setValue(this);"><xsl:copy-of select="@* | text() | *"/></textarea>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-textarea">
		<xsl:apply-templates select="$UPDATE-X-struct" mode="UPDATE_X-input-findTextarea">
			<xsl:with-param name="content" select="data"/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="*" mode="UPDATE_X-input-findTextarea">
		<xsl:param name="content"/>

		<xsl:variable name="this" select="."/>
		<xsl:variable name="name" select="$this/@name"/>

		<xsl:variable name="path">
			<xsl:call-template name="UPDATE_X-edit-full-path"/>
		</xsl:variable>

		<xsl:choose>
			<xsl:when test="$name = 'text()'">
				<xsl:apply-templates select="$content" mode="UPDATE_X-input-findTextarea-each">
					<xsl:with-param name="schema" select="$this"/>
					<xsl:with-param name="path" select="$path"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:otherwise>
				<xsl:for-each select="$content/*[name() = $name]">
					<xsl:apply-templates select="." mode="UPDATE_X-input-findTextarea-each">
						<xsl:with-param name="schema" select="$this"/>
						<xsl:with-param name="path" select="$path"/>
					</xsl:apply-templates>
				</xsl:for-each>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="* | text()" mode="UPDATE_X-input-findTextarea-each">
		<xsl:param name="schema"/>
		<xsl:param name="path"/>

		<xsl:if test="$schema[name() = 'edit']/textarea">
			<!--
			<textarea cols="1" rows="1" name="{$path}"><xsl:copy-of select="text() | *"/></textarea>
			-->
			<textarea cols="1" rows="1" name="{$path}"><xsl:apply-templates select="@* | text() | *" mode="UPDATE_X-input-copy-textarea"/></textarea>
		</xsl:if>
		<xsl:apply-templates select="$schema/*" mode="UPDATE_X-input-findTextarea">
			<xsl:with-param name="content" select="."/>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="*[* or text()]" mode="UPDATE_X-input-copy-textarea">
		<xsl:value-of select="concat('&lt;',name())"/><xsl:apply-templates select="@*" mode="UPDATE_X-input-copy-textarea"/><xsl:value-of select="'&gt;'"/><xsl:apply-templates select="text() | *" mode="UPDATE_X-input-copy-textarea"/><xsl:value-of select="concat('&lt;/',name(),'&gt;')"/>
	</xsl:template>	
	
	<xsl:template match="*[not(*) and not(text())]" mode="UPDATE_X-input-copy-textarea">
		<xsl:value-of select="concat('&lt;',name())"/><xsl:apply-templates select="@*" mode="UPDATE_X-input-copy-textarea"/><xsl:value-of select="'/&gt;'"/>
	</xsl:template>	
	
	<xsl:template match="@*" mode="UPDATE_X-input-copy-textarea">
		<xsl:value-of select="concat(' ',name(),'=&quot;',.,'&quot;')"/>
	</xsl:template>	

	<xsl:template match="text()" mode="UPDATE_X-input-copy-textarea">
		<xsl:copy-of select="."/>
	</xsl:template>	
	
</xsl:stylesheet>
