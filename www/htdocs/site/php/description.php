<?php
    $DirNameLocal=dirname(__FILE__).'/';
    include_once($DirNameLocal."./include.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php include($DirNameLocal . "./head.php"); ?>
    </head>
    <body id="popUp">
        <?php

        $xml = "xml/" . $checked['lang'] . "/bvs.xml";
        $xsl = "xsl/public/components/page_description.xsl";

        $VARS["component"] = $checked["component"];
        $VARS["id"] = $checked["id"];

        require($DirNameLocal . 'xmlRoot.php');

        ?>
    </body>
</html>
