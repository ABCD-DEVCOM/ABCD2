<?php

session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../../common/error_page.php") ;
}

include("../../config_opac.php");
//echo $_SESSION["db_path"];
//foreach ($_REQUEST AS $var=>$value) echo "$var=>$value<br>"; die;
if (!isset($_REQUEST["db_path"])) $_REQUEST["db_path"]=$db_path;
if (isset($_REQUEST["db_path"]) and $_REQUEST["db_path"]!="" )
	$_SESSION["db_path"]=$_REQUEST["db_path"];
IF (!isset($_SESSION["db_path"])){
	$_SESSION["db_path"]=$_REQUEST["db_path"];
}
$db_path=$_SESSION["db_path"];


?>
<script>
actualScript="<?php echo $actualScript?>"
</script>



<?php

include("../../common/header.php");

?>

	<script src= ../../../opac/assets/js/script_b.js?<?php echo time(); ?>></script>

	<script src= ../../../opac/assets/js/lr_trim.js></script>
	<style>
		td{
			font-size:12px;
			padding:5px;
		}
	</style>
<script>
function EnviarForma(Proceso){
	document.opciones_menu.action=Proceso
	document.opciones_menu.submit()
}

function SeleccionarBase(Base){
	document.forma1.action="procesos_base.php"
	document.forma1.base.value=Base
	document.forma1.submit()
}

function SeleccionarProceso(Proceso,Base,Conf){
	document.opciones_menu.action=Proceso
	document.opciones_menu.base.value=Base
	document.opciones_menu.o_conf.value=Conf
	document.opciones_menu.submit()
}

function ShowHide(myDIV) {
  var x = document.getElementById(myDIV);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>
</head>



<body  <?php if (isset($onload)) echo $onload?>>

<?php
include("../../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		OPAC Config 
	</div>
	<div class="actions">
	<?php 
		$backtoscript="../conf_abcd.php";
		include "../../common/inc_back.php";
	?>

	</div>
	<div class="spacer">&#160;</div>
</div>

<?php if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced")
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	  if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="")
			echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";


?>