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
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

	<link href="assets/css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>	

	<link href="/opac/assets/css/dashboard.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
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
<?php 
if (!file_exists($db_path . "opac_conf/$lang/lang.tab")) {
	echo $msgstr["missing"] . " " . $db_path . "opac_conf/$lang/lang.tab";
	die;
}
?>
<header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow text-bg-light">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">
    <img class="bi me-2" height="32" role="img" src="/opac/<?php echo $logo ?>" title="ABCD">
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <?php include_once 'components/topbar.php'; ?>

</header>


<?php

if (isset($_REQUEST["modo"])) {
	unset($_REQUEST["base"]);
	$modo = "integrado";
}


//Display search form when not on a user's screen
if (!isset($indice_alfa)) {
// Exibe form de busca

$_REQUEST["base"] = $actualbase;
include("components/search_free.php");
} else {
//include 'components/avanzada.php';
}



