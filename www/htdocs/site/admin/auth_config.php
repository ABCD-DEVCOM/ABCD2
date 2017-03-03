<?php
////////////////////////////////////
// Configuration file for phpAuth //
////////////////////////////////////
require("../php/include.php");

$database_name = $def['DATABASE_PATH'] . "xml/users.xml"; // Make sure you include the .txt in your database name

$login_redirect  = "enter.php"; // page to directed to when logged in
$logout_redirect = "index.php"; // redirect to your own logout page.

?>