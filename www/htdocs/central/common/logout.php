<?php
/*
20240514 fho4abcd Added alternative return script. When the standard index.php is forbidden
*/
session_start();
include("../config.php");
if (file_exists($db_path."logtrans/data/logtrans.mst") and $_SESSION["MODULO"]=="loan"){
	include("../circulation/grabar_log.php");
	$datos_trans["operador"]=$_SESSION["login"];
	GrabarLog("Q",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path);

}
if (isset($_SESSION["HOME"]))
	$retorno=$_SESSION["HOME"];
else {
    if (file_exists("../../index.php")){
        $retorno="../../index.php";
    } else {
        $retorno="../../index_abcd.php";
    }
}
$_SESSION=array();
unset($_SESSION);
session_unset();
session_destroy();
?>
<script>
	top.window.location.href="<?php echo $retorno?>";
</script>