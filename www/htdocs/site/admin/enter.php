<?php
require('auth_check.php');
require('../php/include.php');
require('../php/common.php');

auth_check_login();

header("Location: " . DIRECTORY . "admin/admFrames.php?lang=" . $checked['lang'] );

?>

