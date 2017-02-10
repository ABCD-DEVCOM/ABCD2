<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<xsl:output method="html" indent="yes"/>
	
	<xsl:variable name="relative" select="/directoryList/@relative"/>
	<xsl:variable name="viewPath" select="/directoryList/@viewPath"/>
	<xsl:variable name="previous" select="/directoryList/@previous"/>
	<xsl:variable name="base" select="/directoryList/@base"/>
	<xsl:variable name="pathData" select="/directoryList/@pathData"/>
	<xsl:variable name="column" select="/directoryList/@column"/>
	<xsl:variable name="order" select="/directoryList/@order"/>
	<xsl:variable name="lang" select="/directoryList/cgi/lang/text()"/>
    <xsl:variable name="texts-file" select="concat(/directoryList/@Fnow,'/xml/texts.xml')"/>
	<xsl:variable name="texts" select="document($texts-file)/texts/language[@id = $lang]/labels"/>	
	
	<xsl:variable name="kiloByte" select="1024"/>
	<xsl:variable name="megaByte" select="1024 * $kiloByte"/>
	<xsl:variable name="gigaByte" select="1024 * $megaByte"/>
	
	<xsl:template match="/">
		<xsl:apply-templates select="." mode="html"/>
	</xsl:template>

	<xsl:template match="*" mode="html">
		<html>
			<xsl:apply-templates select="." mode="head"/>
			<xsl:apply-templates select="." mode="body"/>
		</html>
	</xsl:template>

	<xsl:template match="*" mode="head">
		<head>
			<xsl:apply-templates select="." mode="meta"/>
			<xsl:apply-templates select="." mode="title"/>
			<xsl:apply-templates select="." mode="style"/>
			<xsl:apply-templates select="." mode="script"/>
		</head>
	</xsl:template>

	<xsl:template match="*" mode="title">
		<title>Fnow 0.5 <xsl:value-of select="$relative"/></title>
	</xsl:template>

	<xsl:template match="*" mode="script">
		<script language="JavaScript" src="js/list.js"/>
	</xsl:template>

	<xsl:template match="*" mode="style">
		<link rel="stylesheet" href="css/list.css" type="text/css"/>
	</xsl:template>
	
	<xsl:template match="*" mode="body">
		<body leftmargin="50" onload="javascript:this.focus()">
			<xsl:apply-templates select="." mode="body-onLoad"/>
			<xsl:apply-templates select="." mode="body-onUnload"/>
			<xsl:apply-templates select="." mode="form"/>
		</body>
	</xsl:template>

	<xsl:template match="*" mode="body-onLoad"/>
	<xsl:template match="*" mode="body-onUnload"/>
	
	<xsl:template match="*" mode="debug-textarea">
		<textarea name="debug_{name()}" rows="12" cols="70"><xsl:copy-of select="."/></textarea>
	</xsl:template>
	
	<xsl:template match="*" mode="meta">
		<meta http-equiv="Content-Language" content="pt-BR"/>	
		<meta http-equiv="Expires" content="-1"/>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
		<meta name="author" content="BIREME (http://www.bireme.br/)"/>		
	</xsl:template>

	<xsl:template match="*" mode="form">
		<form name="formDirectoryList" action="index.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="task" value="list"/>
			<input type="hidden" name="relative" value="{$relative}"/>
			<input type="hidden" name="column" value="{$column}"/>
			<input type="hidden" name="order" value="{$order}"/>
			<input type="hidden" name="newFolder" value=""/>
			<input type="hidden" name="deleteFile" value=""/>
			<input type="hidden" name="renameFrom" value=""/>
			<input type="hidden" name="renameTo" value=""/>
			<input type="hidden" name="fileSave" value=""/>
			<input type="hidden" name="content" value=""/>
			<input type="hidden" name="lang" value="{$lang}"/>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">
						<table cellpadding="0" cellspacing="0">
			
							<tr>
								<xsl:apply-templates select="." mode="identification"/>
							</tr>
			
							<tr>
								<td>
									<xsl:apply-templates select="." mode="directoryList"/>
									<br/>
								</td>
							</tr>
							<tr>
								<td>
									<xsl:apply-templates select="." mode="inputList"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<br/>
						<xsl:apply-templates select="message" mode="message"/>
					</td>
				</tr>
			</table>
		</form>
<!-- 
		<xsl:apply-templates select="." mode="debug-textarea"/>
 -->
	</xsl:template>
	
	<xsl:template match="*" mode="identification">
		<td align="center" class="identification">
			<xsl:value-of select="$texts/text[find = 'title']/replace"/>
		</td>
	</xsl:template>
	
	<xsl:template match="*" mode="directoryList">
		<xsl:variable name="data-type">
			<xsl:choose>
				<xsl:when test="$column = 'size'"><xsl:value-of select="$texts/text[find = 'number']/replace"/></xsl:when>
				<xsl:otherwise><xsl:value-of select="$texts/text[find = 'text']/replace"/></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
	
		<table class="directoryList" cellpadding="2" cellspacing="0">
			
			<tr>
				<td colspan="5" class="current">/local/<xsl:value-of select="$relative"/></td>
			</tr>
			<tr>
				<td class="caption" onmouseover="javascript: this.style.backgroundColor = '#CCCCCC'" onmouseout="javascript: this.style.backgroundColor = '#EEEEEE'">
					<xsl:if test="$relative != ''">
						<a href="">
							<xsl:attribute name="onClick">javascript: return directoryList('');</xsl:attribute>
							<img src="image/root.gif" border="0" alt="go to root directory"/>
						</a>
					</xsl:if>&#160;
				</td>
				<xsl:apply-templates select="directory[1]/@*" mode="caption"/>
				<td class="caption" width="1">&#160;</td>
				<td class="caption" onmouseover="javascript: this.style.backgroundColor = '#CCCCCC'" onmouseout="javascript: this.style.backgroundColor = '#EEEEEE'">
					<a href="" onclick="javascript: return createNewFolder();">
						<img src="image/newFolder.gif" border="0" alt="create new folder"/>
					</a>
				</td>
				<td class="caption" width="1">&#160;</td>
				<td></td>
			</tr>
			<xsl:apply-templates select="directory">
				<xsl:sort select="@*[name() = $column]" data-type="{$data-type}" order="{$order}"/>
			</xsl:apply-templates>
			<xsl:apply-templates select="file">
				<xsl:sort select="@*[name() = $column]" data-type="{$data-type}" order="{$order}"/>
			</xsl:apply-templates>
		</table>
	</xsl:template>

	<xsl:template match="@*" mode="caption">
		<td class="caption" width="1">&#160;</td>
		<td valign="middle" onclick="javascript: return columnList('{name()}','{$column}','{$order}');" onmouseover="javascript: this.style.backgroundColor = '#CCCCCC'" onmouseout="javascript: this.style.backgroundColor = '#EEEEEE'">
			<xsl:apply-templates select="." mode="caption-class"/>
			<xsl:apply-templates select="." mode="caption-align"/>
			<xsl:apply-templates select="." mode="label"/>
			<xsl:if test="name() = $column">
				&#160;<img src="image/{$order}.gif" border="0" alt="{$order}"/>
			</xsl:if>
		</td>
	</xsl:template>
	
	<xsl:template match="@*" mode="caption-class">
		<xsl:attribute name="class">caption</xsl:attribute>
	</xsl:template>

	<xsl:template match="@*[name() = /directoryList/@column]" mode="caption-class">
		<xsl:attribute name="class">column</xsl:attribute>
	</xsl:template>

	<xsl:template match="@name" mode="caption-align">
		<xsl:attribute name="align">left</xsl:attribute>
	</xsl:template>

	<xsl:template match="@changedDate" mode="caption-align">
		<xsl:attribute name="align">center</xsl:attribute>
	</xsl:template>

	<xsl:template match="@*" mode="caption-align">
		<xsl:attribute name="align">right</xsl:attribute>
	</xsl:template>

	<xsl:template match="@*" mode="label">		
		<xsl:variable name="current-name" select="name()"/>
		<xsl:value-of select="$texts/text[find = $current-name]/replace"/>

	</xsl:template>
	
	<xsl:template match="@changedDate" mode="label">
		<xsl:value-of select="$texts/text[find = 'modified']/replace"/>
	</xsl:template>

	<xsl:template match="directory | file">
		<xsl:if test="not(@name = '..' and $relative = '')">
			<tr onmouseover="javascript: this.style.backgroundColor = 'Yellow'" onmouseout="javascript: this.style.backgroundColor = 'White'">
				<xsl:apply-templates select="." mode="type"/>
				<xsl:apply-templates select="@*" mode="column"/>
				<xsl:apply-templates select="." mode="action"/>
			</tr>
		</xsl:if>
	</xsl:template>

	<xsl:template match="directory" mode="type">
		<td class="line">
			<a href="">
				<xsl:apply-templates select="@name" mode="onClick"/>
				<img border="0" alt="go to folder {@name}">
					<xsl:apply-templates select="." mode="button-image"/>
				</img>
			</a>
		</td>
	</xsl:template>

	<xsl:template match="directory" mode="button-image">
		<xsl:attribute name="src">image/folder.gif</xsl:attribute>
	</xsl:template>

	<xsl:template match="directory[@name = '..']" mode="button-image">
		<xsl:attribute name="src">image/up.gif</xsl:attribute>
	</xsl:template>

	<xsl:template match="file" mode="type">
		<td class="line">
			<a href="">
				<xsl:apply-templates select="@name" mode="onClick"/>
				<img src="image/file.gif" border="0" alt="show {@name}"/>
			</a>
		</td>
	</xsl:template>

	<xsl:template match="directory/@name" mode="onClick">
		<xsl:variable name="clickDirectory">
			<xsl:choose>
				<xsl:when test="$relative != ''">
					<xsl:value-of select="concat($relative, '/', .)"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="."/>
				</xsl:otherwise>
			</xsl:choose>		
		</xsl:variable>	
	
		<xsl:attribute name="onClick">javascript: return directoryList('<xsl:value-of select="$clickDirectory"/>');</xsl:attribute>
	</xsl:template>

	<xsl:template match="directory/@name[. = '..']" mode="onClick">
		<xsl:variable name="clickDirectory" select="$previous"/>

		<xsl:attribute name="onClick">javascript: return directoryList('<xsl:value-of select="$clickDirectory"/>');</xsl:attribute>
	</xsl:template>

	<xsl:template match="file/@name" mode="onClick">
		<xsl:variable name="clickFile" select="concat($pathData, $base, $relative, '/', . )"/>

		<xsl:attribute name="href"><xsl:value-of select="$clickFile"/></xsl:attribute>
		<xsl:attribute name="onClick">return showLink('<xsl:value-of select="$clickFile"/>');</xsl:attribute>
	</xsl:template>

	<xsl:template match="@*" mode="column">
		<td class="separator" width="1">&#160;</td>
		<xsl:apply-templates select="."/>
	</xsl:template>

	<xsl:template match="@*">
		<td class="line" nowrap="">
			<xsl:apply-templates select="." mode="align"/>
			<xsl:value-of select="."/>
		</td>
	</xsl:template>

	<xsl:template match="@name">
		<td class="line">
			<xsl:apply-templates select="." mode="align"/>
			<a href="">
				<xsl:apply-templates select="." mode="a-title"/>
				<xsl:apply-templates select="." mode="onClick"/>
				<xsl:value-of select="."/>
			</a>
		</td>
	</xsl:template>

	<xsl:template match="@size">
		<xsl:variable name="sizeInBytes" select="number(.)"/>
	
		<td class="line">
			<xsl:apply-templates select="." mode="align"/>
			<xsl:choose>
				<xsl:when test="$sizeInBytes &gt;= $gigaByte">
					<xsl:value-of select="concat(string(round($sizeInBytes div $gigaByte * 100) div 100),'G')"/>
				</xsl:when>
				<xsl:when test="$sizeInBytes &gt;= $megaByte">
					<xsl:value-of select="concat(string(round($sizeInBytes div $megaByte * 100) div 100),'M')"/>
				</xsl:when>
				<xsl:when test="$sizeInBytes &gt;= $kiloByte">
					<xsl:value-of select="concat(string(round($sizeInBytes div $kiloByte * 100) div 100),'k')"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="."/>
				</xsl:otherwise>
			</xsl:choose>
		</td>
	</xsl:template>

	<xsl:template match="directory/@name" mode="a-title">
		<xsl:attribute name="title">go to folder <xsl:value-of select="."/></xsl:attribute>
	</xsl:template>

	<xsl:template match="file/@name" mode="a-title">
		<xsl:attribute name="title">show <xsl:value-of select="."/></xsl:attribute>
	</xsl:template>

	<xsl:template match="@*" mode="align">
		<xsl:attribute name="align">right</xsl:attribute>
	</xsl:template>

	<xsl:template match="@name" mode="align">
		<xsl:attribute name="align">left</xsl:attribute>
	</xsl:template>

	<xsl:template match="directory | file" mode="action">
		<td class="separator" width="1">&#160;</td>
		<td class="line">
			<xsl:if test="@name != '..'">
				<a href="" onclick="javascript: return removeFile('{name()}','{@name}');"><img src="image/delete.gif" border="0" alt="delete {@name}"/></a>
			</xsl:if>
		</td>
		<td class="separator" width="1">&#160;</td>
		<td class="line">
			<xsl:if test="@name != '..'">
				<a href="" onclick="javascript: return renameFile('{@name}');"><img src="image/rename.gif" border="0" alt="rename {@name}"/></a>
			</xsl:if>
		</td>
		
	</xsl:template>

			
	<xsl:template match="*" mode="inputList">
		<table cellpadding="2" cellspacing="0">
			<tr onmouseover="javascript: this.style.backgroundColor = 'Yellow'" onmouseout="javascript: this.style.backgroundColor = 'White'">
				<td>
					<xsl:value-of select="$texts/text[find = 'new']/replace"/><br/>
					<script language="JavaScript">
						var backupColor;
					</script>
					<input class="inputText" type="file" name="uploadFile" size="40"/>
					<input class="inputButton" type="submit" name="submitUpload" value="{$texts/text[find = 'upload']/replace}" title="upload selected file to the current folder" onmouseover="javascript: backupColor = this.style.backgroundColor; this.style.backgroundColor = 'Yellow'" onmouseout="javascript: this.style.backgroundColor = backupColor;"/>
				</td>
			</tr>
		</table>
	</xsl:template>

	<xsl:template match="*" mode="message">
		<table cellpadding="2" cellspacing="0">
			<xsl:apply-templates select="@error | @success" mode="class"/>
			<xsl:choose>
				<xsl:when test="1 = 0">
				</xsl:when>
				<xsl:otherwise>
					<xsl:apply-templates select="@*" mode="otherwise-error"/>
				</xsl:otherwise>
			</xsl:choose>
		</table>
	</xsl:template>

	<xsl:template match="@*" mode="class">
		<xsl:attribute name="class"><xsl:value-of select="name()"/></xsl:attribute>
	</xsl:template>

	<xsl:template match="@*" mode="otherwise-error">
		<tr>
			<td align="right"><xsl:value-of select="name()"/>: </td>
			<td><b><xsl:value-of select="."/></b></td>
		</tr>
	</xsl:template>

</xsl:stylesheet>
