<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="responsable">
        <div id="footNotes">
            <xsl:apply-templates select="item/description"/>
        </div>
    </xsl:template>

    <!--xsl:template match="responsable//description | responsable//description//*">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text()"/>
        </xsl:copy>
    </xsl:template-->

    <xsl:template match="responsable//description">
        <xsl:choose>
            <xsl:when test="count(child::*) &gt; 0">
                 <xsl:copy-of select="* | @* | text()" />
            </xsl:when>
            <xsl:otherwise>
                  <xsl:value-of select="." disable-output-escaping="yes"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>


</xsl:stylesheet>