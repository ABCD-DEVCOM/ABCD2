<?php
include realpath(__DIR__ . '/../central/config_opac.php');

$modo = "";
if (isset($_REQUEST["base"]))
	$actualbase = $_REQUEST["base"];
else
	$actualbase = "";
if (isset($_REQUEST["xmodo"]) and $_REQUEST["xmodo"] != "") {
	unset($_REQUEST["base"]);
	$modo = "integrado";
}

function wxisLlamar($base, $query, $IsisScript) {
	global $db_path, $Wxis, $xWxis;
	include("wxis_llamar.php");
	return $contenido;
}



//include ("get_ip_address.php");
//header('Content-Type: text/html; charset=".$charset."');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

$meta_encoding = $charset;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

session_start(); 
?>
<?php ?>
<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset ?>" />
	<?php if (isset($shortIcon) and $shortIcon != "") {
	?>
		<link rel="icon" type="image/x-icon" href="<?php echo $shortIcon;?>">
	<?php
	}
	?>
	<title><?php echo $TituloPagina ?></title>
	<link href="<?php echo $OpacHttp;?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $OpacHttp;?>assets/css/styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
	<script src="<?php echo $OpacHttp;?>assets/js/script_b.js?<?php echo time(); ?>"></script>
	<script src="<?php echo $OpacHttp;?>assets/js/highlight.js?<?php echo time(); ?>"></script>
	<script src="<?php echo $OpacHttp;?>assets/js/lr_trim.js"></script>
	<script src="<?php echo $OpacHttp;?>assets/js/selectbox.js"></script>

	<!--FontAwesome-->
	<link href="/assets/css/all.min.css" rel="stylesheet">

	<script>
		document.cookie = 'ORBITA; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'
		document.cookie = 'ORBITA=;';

		/* Marcado y presentación de registros*/
		function getCookie(cname) {
			var name = cname + "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}

		function Seleccionar(Ctrl) {
			cookie = getCookie('ORBITA')
			if (Ctrl.checked) {
				if (cookie != "") {
					c = cookie + "|"
					if (c.indexOf(Ctrl.name + "|") == -1)
						cookie = cookie + "|" + Ctrl.name
				} else {
					cookie = Ctrl.name
				}
			} else {
				sel = Ctrl.name + "|"
				c = cookie + "|"
				n = c.indexOf(sel)
				if (n != -1) {
					cookie = cookie.substr(0, n) + cookie.substr(n + sel.length)
				}

			}
			document.cookie = "ORBITA=" + cookie
			Ctrl = document.getElementById("cookie_div")
			Ctrl.style.display = "inline-block"
		}

		function delCookie() {
			document.cookie = 'ORBITA=;';

		}
		var user = getCookie("ORBITA");
		if (user != "") {
			alert("Welcome again " + user);
		} else {

		}
	</script>


	<script>
		msgstr = Array()
		msgstr["no_rsel"] = "<?php echo $msgstr["no_rsel"] ?>"
		msgstr["sel_term"] = "<?php echo $msgstr["sel_term"] ?>"
		msgstr["miss_se"] = "<?php echo $msgstr["miss_se"] ?>"
		msgstr["rsel_no"] = "<?php echo $msgstr["rsel_no"] ?>"
		msgstr["reserv_no"] = "<?php echo $msgstr["reserv_no"] ?>"
		actualScript = "<?php echo $actualScript ?>"
	</script>
</head>

<body>




<!--<header  id="header"  class="d-flex flex-wrap justify-content-center p-3 mb-4 border-bottom">-->
<header class="navbar navbar-primary sticky-top p-1 mb-3 d-flex shadow bg-white">
  <div class="container">
    <a id="logo" name="inicio" href="<?php echo $link_logo ?>?lang=<?php echo $lang; ?>" class="navbar-brand p-0 me-0 me-lg-2">
	<?php if (isset($logo)) { ?>
    	<img class="p-2" style="max-height:70px;" src="<?php echo $logo ?>" title="<?php echo $TituloEncabezado;?>">
    <?php } else { ?>	
		<span class="fs-4"><?php echo $TituloEncabezado;?></span>
	<?php } ?>	
    </a>

	<?php
		include_once 'components/topbar.php';
		if (isset($_REQUEST["db_path"])) echo "  " . $_REQUEST["db_path"];
		if (file_exists("opac_dbpath.dat")) echo "<a href=../index.php>Cambiar carpeta bases</a>";
	?>

	<?php
	if (!file_exists($db_path . "opac_conf/$lang/lang.tab")) {
		echo $msgstr["missing"] . " " . $db_path . "opac_conf/$lang/lang.tab";
		die;
	}
	?>
  </div>
</header>

<div class="container">
<main>

<div class="row">

	<div class="col-md-3">
		<?php if ((!isset($_REQUEST["existencias"]) or $_REQUEST["existencias"] == "") and !isset($sidebar)) include("components/sidebar.php"); ?>
	</div>

	<div id="page" class="col-md-9">
		<div id="content" <?php if (isset($desde) and $desde = "ecta"); ?>>

			<?php
				if (!isset($indice_alfa)) 
				include("components/search_free.php");
				$_REQUEST["base"] = $actualbase;
				?>
		