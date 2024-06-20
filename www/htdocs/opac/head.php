<?php
include realpath(__DIR__ . '/../central/config_opac.php');

include $Web_Dir.'functions.php';

session_start(); 

//include ("get_ip_address.php");


header('Content-Type: text/html; charset=".$meta_encoding."');
header("Cache-Control: no cache");

//session_cache_limiter("private_no_expire");

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
$ActualDir=getcwd();
$meta_encoding=$meta_encoding;
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
 <!-- Meta Tags para SEO -->
  <title><?php echo $TituloPagina; ?></title>
  <meta name="description" content="<?php echo $Site_Description;?>">
  <meta name="keywords" content="<?php echo $Site_Keywords;?>" />
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $meta_encoding ?>" />
  <meta name="author" content="<?php echo $TituloEncabezado;?>">
  <meta name="language" content="<?php echo $lang; ?>">

  <!-- Meta Tags para Redes Sociais (Facebook, Twitter, LinkedIn) -->
  <meta property="og:title" content="<?php echo $TituloPagina; ?>">
  <meta property="og:description" content="<?php echo $Site_Description;?>">
  <meta property="og:image" content="<?php echo $link_logo;?>">
  <meta property="og:url" content="<?php echo $OpacHttp;?>">
  <meta name="twitter:title" content="<?php echo $TituloPagina; ?>">
  <meta name="twitter:description" content="<?php echo $Site_Description;?>">
  <meta name="twitter:image" content="<?php echo $link_logo;?>">
  <meta name="twitter:card" content="<?php echo $link_logo;?>">
  <meta name="linkedin:title" content="<?php echo $TituloPagina; ?>">
  <meta name="linkedin:description" content="<?php echo $Site_Description;?>">
  <meta name="linkedin:image" content="<?php echo $link_logo;?>">

  <!-- Meta Tags para Resultados de Pesquisa (Google, Bing) -->
  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow">
  

  

	<meta name="viewport" content="width=device-width, initial-scale=1">
	

	 <!-- Link para o Ícone da Página -->
	<?php if (isset($shortIcon) and $shortIcon != "") { ?>
		<link rel="icon" type="image/x-icon" href="<?php echo $shortIcon;?>">
	<?php } ?>

		<!--FontAwesome-->
	<link href="/assets/css/all.min.css" rel="stylesheet">

	<link href="<?php echo $OpacHttp;?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $OpacHttp;?>assets/css/styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
	
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/script_b.js?<?php echo time(); ?>"></script>
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/highlight.js?<?php echo time(); ?>"></script>
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/lr_trim.js"></script>
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/selectbox.js"></script>
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/jquery-3.6.4.min.js?<?php echo time(); ?>"></script>
	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/get_cookies.js?<?php echo time(); ?>"></script>

	<?php echo $googleAnalyticsCode;?>
	
	<?php echo $CustomStyle;?>

	<script>
		msgstr = Array()
		msgstr["no_rsel"] = "<?php echo $msgstr["front_no_rsel"] ?>"
		msgstr["sel_term"] = "<?php echo $msgstr["front_sel_term"] ?>"
		msgstr["miss_se"] = "<?php echo $msgstr["front_miss_se"] ?>"
		msgstr["rsel_no"] = "<?php echo $msgstr["front_rsel_no"] ?>"
		msgstr["reserv_no"] = "<?php echo $msgstr["front_reserv_no"] ?>"
		actualScript = "<?php echo $actualScript ?>"
	</script>
	
</head>

<body>
	
	<?php include("views/topbar.php");?>

	<div class="container<?php echo $container;?>">

	<?php if ($sidebar=="SL") { ?>
	<div id="searchBox" class="card bg-white p-4 mb-4 custom-searchbox">
		<?php if ($search_form!="detailed") include("components/search_free.php");  ?>
		<?php if ($search_form=="detailed") include("components/search_detailed.php"); ?>
	</div>
	<?php } ?>
	
	<main>
			<?php if ($sidebar!="N")  { ?>
				<div class="d-flex flex-row col-md-12">
				<?php include("views/sidebar.php"); ?>
			<?php } else { ?>

				<div class="row">

			<?php } ?>

				<div id="page" class="container">
					<div class="col-md-12" id="content" <?php if (isset($desde) and $desde = "ecta"); ?>>
						<?php if ($sidebar!="SL") { ?>
						<div id="searchBox" class="card bg-white p-4 mb-4">
							<?php if ($search_form!="detailed") include("components/search_free.php");  ?>
							<?php if ($search_form=="detailed") include("components/search_detailed.php"); ?>
						</div>
						<?php } ?>
						<?php $_REQUEST["base"] = $actualbase; ?>