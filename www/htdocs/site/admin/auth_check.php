<?php
function auth_check_login()
{
    ob_start();
    session_start();
    if ( $_SESSION["auth_id"] != "BVS@BIREME"  ) {
        ob_end_clean();
        header("Location: /site/admin/index.php?error=TIMEOUT");
        exit;
    }
    ob_end_clean();
}
?>