<?php
session_start();
require_once "../../central/config.php";


if (isset($_SESSION["HOME"]))
	$retorno=$_SESSION["HOME"];
else
	$retorno="/mysite";
$_SESSION=array();
unset($_SESSION);
session_unset();
session_destroy();
?>
<script>
	top.window.location.href="<?php echo $retorno?>";
</script>