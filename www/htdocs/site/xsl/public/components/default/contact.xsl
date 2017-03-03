<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="contact">
        <xsl:if test="item[@available = 'yes']">
            <div id="contact">
                <span><a href="../php/contact.php?lang={$lang}{$portal_param}"><xsl:apply-templates select="$texts/text[@id = 'contact']" /></a></span>
            </div>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>
