<?php
/*
20220316 fho4abcd Created
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
$base=$arrHttp["base"];
$backtoscript="../dbadmin/menu_modificardb.php";
include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>

<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["barcode_config"]. ": " . $base?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
    <?php include "../common/inc_home.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
NOT IMPLEMENTED YET
</div>
</div>
<?php
include("../common/footer.php");
?>
