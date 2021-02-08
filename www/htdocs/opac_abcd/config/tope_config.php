<?php
include("../php/config_opac.php");
//echo $_SESSION["db_path"];
//foreach ($_REQUEST AS $var=>$value) echo "$var=>$value<br>"; die;
if (!isset($_REQUEST["db_path"])) $_REQUEST["db_path"]=$db_path;
if (isset($_REQUEST["db_path"]) and $_REQUEST["db_path"]!="" )
	$_SESSION["db_path"]=$_REQUEST["db_path"];
IF (!isset($_SESSION["db_path"])){
	$_SESSION["db_path"]=$_REQUEST["db_path"];
}
$db_path=$_SESSION["db_path"];
$lang=$_REQUEST["lang"];
header('Content-Type: text/html; charset=<?php echo $charset?>');


//foreach ($_REQUEST AS $var=>$value)  echo "$var=$value<br>";
?>
<script>
actualScript="<?php echo $actualScript?>"
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
	<title><?php echo $TituloPagina." ".$msgstr["opac_configure"]?> </title>
	<link href="../styles/<?php if ($styles !="") echo $styles."/";?>styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
	<script src=../js/script_b.js?<?php echo time(); ?>></script>

	<script src=../js/lr_trim.js></script>
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

function SeleccionarBase(Base){	document.forma1.action="procesos_base.php"	document.forma1.base.value=Base
	document.forma1.submit()}

function SeleccionarProceso(Proceso,Base){	document.opciones_menu.action=Proceso
	document.opciones_menu.base.value=Base
	document.opciones_menu.submit()}

function ShowHide(myDIV) {  var x = document.getElementById(myDIV);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>
</head>
<body  <?php if (isset($onload)) echo $onload?>>
<a name=inicio>
<div id=centrado>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<a href="<?php echo $link_logo?>"><img src=<?php echo $logo?>></a>
		</div>
	</div>
	 <div class=areaTitulo><span class=tituloBase><?php echo $msgstr["opac_configure"];?><br>
	 <?php
	 echo $charset."<br>";
	 echo $msgstr["db_space"].": ".$_SESSION["db_path"];?>
	 </span></div>
</div>
</div>
<?php if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced")
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	  if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="")
			echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
include("menu_bar.php");
?>
