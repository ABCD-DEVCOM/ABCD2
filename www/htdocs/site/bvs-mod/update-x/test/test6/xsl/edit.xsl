<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/xsl/edit.xsl"/>
	<xsl:include href="file:///home/repository/linux/htdocs/bvs-mod/update-x/style1/xsl/edit.xsl"/>

	<xsl:template match="element[@name = 'language']" mode="UPDATE_X-input-repeat-list-add"/>
	<xsl:template match="element[@name = 'language']" mode="UPDATE_X-input-repeat-list-delete"/>
	<xsl:template match="element[@name = 'language']" mode="UPDATE_X-input-repeat-list-move"/>

</xsl:stylesheet>
