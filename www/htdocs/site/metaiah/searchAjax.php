<?php
    require("../php/include.php");
    require("common.inc.php");
    header("Content-type: text/xml");
    $expression = stripslashes($_REQUEST['expression']);
    $metaiahServerUrl = "http://" . $def['SERVER'] . "/metaiahServer/search?expression=" . $expression . "&bvs=" . $def['SERVERNAME'] . "&timeout=" . $def['TIMEOUT'] . "&lang=" . $lang;

    $ajax = postIt($metaiahServerUrl);
    die($ajax);
?>