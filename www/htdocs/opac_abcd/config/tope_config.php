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
	document.forma1.action=Proceso
	document.forma1.submit()
}

function SeleccionarBase(Base){	document.forma1.action="procesos_base.php"	document.forma1.base.value=Base
	document.forma1.submit()}

function SeleccionarProceso(Proceso,Base){	document.forma1.action=Proceso
	document.forma1.base.value=Base
	document.forma1.submit()}

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
<form name=form_lang method=post>
<?php if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced")
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	  if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="")
			echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
?>
<div id="menu-wrapper">
	<div id=menu>
		<UL>
			<?php
			if (isset($_SESSION["lang_init"]))
				$l_init=$_SESSION["lang_init"];
			else
				$l_init=$_REQUEST["lang"];
			echo "<li><a href=\"index.php?lang=".$l_init."\">LogOut</a></li>";?>
		</ul>
	</div>
	<div id=right>
		<div id="language"><?php echo $msgstr["lang"];?>

			<select name=lang onchange=document.form_lang.submit() id=lang >
				<?php
					$archivo=$db_path."opac_conf/$lang/lang.tab";
					if (file_exists($archivo)){						$fp=file($archivo);
						foreach ($fp as $value){
							if (trim($value)!=""){
								$a=explode("=",$value);
								echo "<option value=".$a[0];
								if ($lang==$a[0]) echo " selected";
								echo ">".trim($a[1])."</option>";
							}
						}
						unset($fp);
					}else{						echo "<option value=$lang selected>$lang</option>";					}

				?>
			</select>

		</div>
		<div id="back">
			<a href="<?php if (isset($url_back)) echo $url_back; else echo 'menu.php?';?>lang=<?php echo $_REQUEST["lang"];
			 if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced") echo '&conf_level='.$_REQUEST["conf_level"]
			 ?>"><img src=../images_config/defaultButton_back.png alt=<?php echo $msgstr["back"];?> title=<?php echo $msgstr["back"];?>></a>
		</div>
	</div>
	<!-- end #menu -->
</div>
</form>