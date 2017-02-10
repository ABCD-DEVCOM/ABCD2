<?php
    $DirName=dirname(__FILE__).'/';
    $version = split ("\.", phpversion());
    if ( $version[0] > 4 || ($version[0] == 4 && $version[1] >= 1) ) {
        include_once($DirName . "../../classes/php/session4.1.0.php");
    } else {
        include_once($DirName . "../../classes/php/session4.0.6.php");
    }
?>