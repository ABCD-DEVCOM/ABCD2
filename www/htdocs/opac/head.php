<?php
include realpath(__DIR__ . '/../central/config_opac.php');
include $Web_Dir . 'functions.php';

// Definição de cabeçalhos de segurança
$nonce = base64_encode(random_bytes(16));
header("X-XSS-Protection: 1; mode=block");
header("Content-Type: text/html; charset=$meta_encoding");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

//header("Content-Security-Policy: script-src 'self' 'nonce-$nonce'; object-src 'none'; form-action 'self'; base-uri 'self'; upgrade-insecure-requests;");

header("Cache-Control: no-cache, no-store, must-revalidate"); // ou header("Cache-Control: no-store");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Data no passado para invalidar o cache
header("Pragma: no-cache"); // Para HTTP/1.0

//include ("get_ip_address.php");
//session_cache_limiter("private_no_expire");

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
$ActualDir = getcwd();

session_start();

//foreach ($_REQUEST as $var => $value) echo "$var=>$value<br>";
?>

<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?php echo htmlspecialchars($TituloPagina, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($Site_Description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($Site_Keywords, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta charset="<?php echo $meta_encoding; ?>">
    <meta name="author" content="<?php echo htmlspecialchars($TituloEncabezado, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="language" content="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Meta Tags para Redes Sociais -->
    <?php foreach (["og", "twitter", "linkedin"] as $prefix) : ?>
        <meta property="<?php echo $prefix; ?>:title" content="<?php echo htmlspecialchars($TituloPagina, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="<?php echo $prefix; ?>:description" content="<?php echo htmlspecialchars($Site_Description, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="<?php echo $prefix; ?>:image" content="<?php echo htmlspecialchars($link_logo, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endforeach; ?>

    <!-- Ícone da Página -->
    <?php if (!empty($shortIcon)) : ?>
        <link rel="icon" href="<?php echo htmlspecialchars($shortIcon, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <!-- Estilos -->
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $OpacHttp; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $OpacHttp; ?>assets/css/styles.css?<?php echo time(); ?>">

    <!-- Scripts -->
    <?php foreach (["script_b.js", "highlight.js", "lr_trim.js", "selectbox.js", "jquery-3.6.4.min.js", "get_cookies.js"] as $script) : ?>
        <script nonce="<?php echo $nonce; ?>" src="<?php echo $OpacHttp; ?>assets/js/<?php echo $script; ?>?<?php echo time(); ?>"></script>
    <?php endforeach; ?>

    <?php echo $googleAnalyticsCode; ?>
    <?php echo $CustomStyle; ?>

</head>

<body>
    <?php include "views/topbar.php"; ?>
    <div class="container<?php echo $container; ?>">

        <?php
        if (isset($_REQUEST['page'])) {
            $page= $_REQUEST['page'];
        }else{
            $page = "";
        }


        if ($sidebar == "SL") :

            if ($page != "startsearch") {
        ?>
        
            <div id="searchBox" class="card bg-white custom-searchbox p-4 mb-4 rounded-0">
                <?php
                // Define qual formulário deverá ser exibido para o pesquisador
                switch ($search_form) {
                    case 'free':
                        include("components/search_free.php");
                        break;
                    case 'detailed':
                    case 'detalle':
                    case 'avanzada':
                        include("components/search_detailed.php");
                        break;
                    case 'directa':
                        include("components/search_directa.php");
                        break;
                    default:
                        include("components/search_free.php") ;
                        break;
                }
            } ?>
            </div>
        <?php endif; ?>

        <main>
            <?php

            if ((isset($_REQUEST['page'])) && (($_REQUEST['page'] == "startsearch"))) : ?>
                <div class="d-flex flex-row col-md-12">
                    <?php include "views/sidebar.php"; ?>
                <?php else : ?>
                    <div class="row">
                    <?php endif; ?>
                    <div id="page" class="container">
                        <div class="col-md-12 p-4" id="content" <?php if (isset($desde) and $desde = "ecta"); ?>>
                            <?php if ($sidebar != "SL") : ?>
                                <div id="searchBox" class="card bg-white p-4 mb-4 rounded-0">

                                    <?php //if ($search_form!="detailed") include("components/search_free.php");  
                                    ?>
                                    <?php //if (($search_form=="detailed") || ($search_form!="directa")) include("components/search_detailed.php"); 
                                    ?>
                                    <?php
                                    // Define qual formulário deverá ser exibido para o pesquisador
                                    switch ($search_form) {
                                        case 'free':
                                            include("components/search_free.php");
                                            break;
                                        case 'detailed':
                                        case 'detalle':
                                        case 'avanzada':
                                            include("components/search_detailed.php");
                                            break;
                                        default:
                                            include("components/search_free.php");
                                            break;
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php $_REQUEST["base"] = $actualbase; ?>