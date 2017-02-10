<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Want a more effective customization? See this files:
        * bases/site/xml/$lang/adm.xml
        * htdocs/admin/edit-ticker.php
        * htdocs/php/show-ticker.php
        * htdocs/xsl/admin/menu.xsl
        * htdocs/xsl/admin/save-ticker.xsl    -->
    <xsl:include href="default/ticker.xsl"/>

    <xsl:template match="ticker">
        <xsl:variable name="component" select="@id"/>
        <xsl:variable name="rssData" select="$bvsRoot/collectionList//item[@id = $component]" />

        <link rel="stylesheet" href="/css/public/skins/classic/common/carousel.css" type="text/css"/>

        <script type="text/javascript" src="/js/jsSlider/unobtrusivelib.js">//</script>
        <script type="text/javascript" src="/js/jsSlider/prettify.js">//</script>
        <script type="text/javascript" src="/js/jsSlider/jquery.carousel.pack.js">//</script>
        <script type="text/javascript">
        $(function(){
            $.unobtrusivelib();
            prettyPrint();
            $("<xsl:value-of select="concat('#ticker',$component)"/> div.pagination").carousel(
                {
                    pagination: true,
                    effect: "fade",
                    autoSlide: true,
                    loop: true,
                    autoSlideInterval: 5000
                }
            );
        });
        </script>
        <div class="ticker" id="ticker{$component}">
            <h3>
                <span>
                    <xsl:choose>
                        <xsl:when test="$rssData/@href and $rssData/@href != ''">
                            <a href="{$rssData/@href}"><xsl:apply-templates select="$rssData" mode="component"/></a>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="$rssData/text()" />
                        </xsl:otherwise>
                    </xsl:choose>
                </span>
            </h3>
            <div class="carousel pagination">
                <xsl:text disable-output-escaping = "yes">&lt;?</xsl:text>
                $url = "<xsl:value-of select="url" disable-output-escaping="yes"/>";
                include("./php/show-ticker.php");
                <xsl:text disable-output-escaping = "yes">?&gt;</xsl:text>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>
