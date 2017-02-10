<?php
session_start();
include("../config.php");

if (isset($_SESSION["HOME"]))
	$retorno=$_SESSION["HOME"];
else
	$retorno="../../indexmysite.php";
$_SESSION=array();
unset($_SESSION);
session_unset();
session_destroy();
?>
<script>
	top.window.location.href="<?php echo $retorno?>";
</script>