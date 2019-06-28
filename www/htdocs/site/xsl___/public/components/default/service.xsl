<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="service">
        <xsl:variable name="component" select="@id"/>
        <xsl:variable name="collectionData" select="$bvsRoot/collectionList//item[@id = $component]" />

        <div class="webServices">
            <h3><span><xsl:value-of select="$collectionData/text()" /></span></h3>
            <xsl:text disable-output-escaping = "yes" >&lt;?</xsl:text>
                $url = "<xsl:value-of select="url" disable-output-escaping="yes"/>";
                include("../php/show_php.php");
            <xsl:text disable-output-escaping = "yes" >?&gt;</xsl:text>
        </div>

    </xsl:template>

</xsl:stylesheet>
