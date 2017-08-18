<?php

    $pathFile = $_REQUEST["pathFile"];
    $newFile = $_REQUEST["newFile"];
    $fileName = basename($pathFile);

    header("Content-type: bireme/application");
    header("Content-Disposition: attachment; filename=".$newFile);
    readfile($pathFile);

?>
