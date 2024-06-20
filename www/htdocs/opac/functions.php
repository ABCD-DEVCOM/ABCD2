<?php
/**
 * 20230507 rogercgui Creation of this script to automatically read functions inserted 
 *                    into the Opac system. To create a new function, create a PHP script 
 *                    with a function and save it in the /inc/ directory.
 */


foreach (glob($Web_Dir."classes/*.php") as $filename) {
    include $filename;
}

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    require_once $Web_Dir. '/classes/' . $className . '.php';
});

foreach (glob($Web_Dir."includes/*.php") as $filename) {
    include $filename;
}

foreach (glob($Web_Dir."functions/*.php") as $filename) {
    include $filename;
}

/*
foreach (glob($Web_Dir."controllers/*.php") as $filename) {
    include $filename;
}
*/

/*
foreach (glob($Web_Dir."app/models/*.php") as $filename) {
    include $filename;
}

foreach (glob($Web_Dir."app/routes/*.php") as $filename) {
    include $filename;
}

foreach (glob("views/*.php") as $filename) {
    include $filename;
}

foreach (glob("controllers/*.php") as $filename) {
    include $filename;
}*/