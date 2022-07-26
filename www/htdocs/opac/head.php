<?php
session_start();

if (isset($_COOKIE['user'])) {
	$_SESSION['username']=$_COOKIE['user'];
}
unset($_SESSION['login']);

include($_SERVER['DOCUMENT_ROOT'] . "/central/config_opac.php");
include($_SERVER['DOCUMENT_ROOT']."/opac/inc/leer_bases.php");
$modo = "";

if (isset($_REQUEST["base"])){
	$actualbase = $_REQUEST["base"];
 } else {
	$actualbase = "";
}

function wxisLlamar($base, $query, $IsisScript) {
	global $db_path, $Wxis, $xWxis;
	include($_SERVER['DOCUMENT_ROOT']."/opac/wxis_llamar.php");
	return $contenido;
}
//include $_SERVER['DOCUMENT_ROOT']."/opac/functions.php";
include ("inc/get_ip_address.php");
header('Content-Type: text/html; charset=".$charset."');
$meta_encoding = $charset;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $TituloPagina ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset ?>" />
	<?php if (isset($shortIcon) and $shortIcon != "") {
		echo "<link rel=\"shortcut icon\" href=\"<?php echo $ShorcutIcon;?>\" type=\"image/x-icon\">\n";
	} else {
	?>
		<!-- Favicons -->
		<link rel="mask-icon" href="/assets/images/favicons/favicon.svg">
    	<link rel="icon" type="image/svg+xml" href="/assets/images/favicons/favicon.svg" color="#fff">

    	<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicons/favicon-32x32.png">
    	<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicons/favicon-16x16.png">

    	<link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicons/favicon-60x60.png">
    	<link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicons/favicon-76x76.png">
    	<link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicons/favicon-120x120.png">
    	<link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicons/favicon-152x152.png">
    	<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/favicon-180x180.png">

	<?php
	}
	?>


	<link href="/assets/css/colors.css" rel="stylesheet">
	<link href="/assets/css/buttons.css" rel="stylesheet">
	<link href="/assets/css/normalize.css" rel="stylesheet">

	<link href="/opac/assets/css/styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
	<script src=/opac/assets/js/script_b.js?<?php echo time(); ?>></script>
	<script src=/opac/assets/js/highlight.js?<?php echo time(); ?>></script>
	<script src=/opac/assets/js/lr_trim.js></script>
	<script src=/opac/assets/js/selectbox.js></script>

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

	<header id="header-wrapper">
		<div id="header">
			<div id="logo">
				<a name="inicio" href="<?php echo $link_logo ?>?lang=<?php echo $_REQUEST['lang'] ?>"><img src="/opac/<?php echo $logo ?>"></a>
			</div>

		</div>
		<div class="areaTitulo">
			<div class=tituloBase>
				<?php 
				if (isset($_SESSION['nombre'])){ 
					echo utf8_encode($_SESSION['nombre']);
				} else {
					echo '<a href="/mysite?mode=opac">Sign</a>';
				}?>
			</div>
			<div>
				<?php echo $charset;
				if (file_exists("opac_dbpath.dat"))
					echo "<a href=../index.php>Cambiar carpeta bases</a>";
				?>
			</div>
		</div>
	</header>
	<?php
	if (!file_exists($db_path . "opac_conf/$lang/lang.tab")) {
		echo $msgstr["missing"] . " " . $db_path . "opac_conf/$lang/lang.tab";
		die;
	}

		
// Layout
// NAVBARTOP
		include_once 'components/topbar.php';


// SIDEBAR
if ((!isset($_REQUEST["existencias"]) or $_REQUEST["existencias"] == "") and !isset($sidebar)) include("components/sidebar.php");

if (isset($_REQUEST["modo"])) {
	unset($_REQUEST["base"]);
	$modo = "integrado";
}

?>
		<div id="page">
			<div id="content" <?php if (isset($desde) and $desde = "ecta") ?>>
				<?php
				//Display search form when not on a user's screen
				if (!isset($indice_alfa)) {
				// Exibe form de busca
				
				$_REQUEST["base"] = $actualbase;
				include("components/search_free.php");
			} else {
				//include 'components/avanzada.php';
			}
				?>
			</div>

	--- /opac/head.php --- 