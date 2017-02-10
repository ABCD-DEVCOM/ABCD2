<?php
if ( $def['GOOGLE_ANALYTICS_ID'] != '')
{
?>

        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try{
                var pageTracker = _gat._getTracker("<?php echo $def['GOOGLE_ANALYTICS_ID'];?>");
                pageTracker._trackPageview();
            } catch(err) {
                if(window.console !== undefined
                        && typeof window.console.warn === "function") {
                    console.warn(err);
                }
            }
        </script>
<?php } ?>