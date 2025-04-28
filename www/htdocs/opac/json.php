<?php
session_start();
ini_set('error_reporting', E_ALL);
include realpath(__DIR__ . '/../central/config.php');

$prefixo = "TW_";
$letra = $_GET["letra"] ?? '';

$ocurrencias = [];
$novo_contenido = [];

function buscarIndiceBase($base, $letra, $db_path, $xWxis, $ABCD_scripts_path, $prefixo)
{

    $IsisScript = $xWxis . "opac/json.xis";
    $arrHttp["base"] = $base;
    $arrHttp["cipar"] = $base . ".par";
    $arrHttp["Opcion"] = "buscar";

    $query_param = "&base=" . $arrHttp["base"];
    $query_param .= "&count=5000";
    $query_param .= "&cipar=" . $db_path . "par/" . $arrHttp["cipar"];
    $query_param .= "&prefijo=" . $prefixo;
    $query_param .= "&letra=" . $letra;
    $query_param .= "&Opcion=diccionario";

    $query= $query_param;

    $contenido = [];

    // Run WXIS for this base
    include($ABCD_scripts_path . "central/common/wxis_llamar.php");

    if (!empty($contenido)) {
        return $contenido;
    }
    return [];
}

function utf8ize($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = utf8ize($value);
        }
    } elseif (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8, ISO-8859-1, ISO-8859-15, Windows-1252');
    }
    return $data;
}

// --- CHECK IF IT HAS A BASE OR SEARCH IN ALL ---
if (!empty($_GET['base'])) {
    $bases = [$_GET['base']]; // Just a base
} else {
    // Search all bases defined in bases.dat
    $bases_dat_path = $db_path . "opac_conf/" . $lang . "/bases.dat";
    if (file_exists($bases_dat_path)) {
        $bases = [];
        $bases_dat = file($bases_dat_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($bases_dat as $linha) {
            $partes = explode('|', $linha);
            $sigla = trim($partes[0]);
            if (!empty($sigla)) {
                $bases[] = $sigla;
            }
        }
    } else {
        $bases = []; // No base available
    }
}

// Now run through all the bases
foreach ($bases as $base) {
    $contenido = buscarIndiceBase($base, $letra, $db_path, $xWxis, $ABCD_scripts_path, $prefixo);

    foreach ($contenido as $linha) {
        $termos = explode('<br>', $linha);
        foreach ($termos as $termo) {
            $termo_limpo = trim($termo);
            if (!empty($termo_limpo)) {
                $novo_contenido[] = $termo_limpo;
            }
        }
    }
}

// Occurrence counts
foreach ($novo_contenido as $value) {
    $value_tratado = trim(strip_tags($value)); // Remove tags HTML
    $value_tratado = preg_replace('/\s+/', ' ', $value_tratado); // Normaliza espaços

    if (!empty($value_tratado)) {
        if (isset($ocurrencias[$value_tratado])) {
            $ocurrencias[$value_tratado]++;
        } else {
            $ocurrencias[$value_tratado] = 1;
        }
    }
}

// Format the terms
$termos_formatados = [];

foreach ($ocurrencias as $termo => $quantidade) {
    $termo_sem_prefixo = preg_replace('/^TW_/', '', $termo); // Remove "TW_"
    $termo_formatado = ucfirst(strtolower($termo_sem_prefixo)); // Normaliza capitalização

    if (!empty($termo_formatado)) {
        $termos_formatados[] = $termo_formatado;
    }
}

// Remove duplicates and correct encoding
$termos_formatados = array_unique($termos_formatados);
$termos_formatados = utf8ize($termos_formatados);

echo json_encode(array_values($termos_formatados), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
