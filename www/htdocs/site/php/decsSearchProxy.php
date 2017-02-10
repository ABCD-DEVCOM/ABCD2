<?php
    require("../php/include.php");
    require("../php/common.php");
    header("Content-type: text/xml");

    $expression = trim($_REQUEST['expression']);
    $expression = replace_accents($expression);
    $expression = str_replace("$","*",$expression);

    $serviceUrl = "http://" . $def['SERVICES_SERVER'] . "/decsQuickTerm/search?query=" . $expression . "&lang=" . $checked["lang"];
    $serviceResponse = postIt($serviceUrl);

    echo($serviceResponse);
?>
