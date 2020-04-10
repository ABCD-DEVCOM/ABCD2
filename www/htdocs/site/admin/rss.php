<?php
require_once("../php/include.php");
require_once("../php/common.php");
require_once("auth_check.php");

auth_check_login();

function stripFromText($haystack, $bfstarttext, $endsection) {
    $startpostext = $bfstarttext;
    $startposlen = strlen($startpostext);
    $startpos = strpos($haystack, $startpostext);
    $endpostext = $endsection;
    $endposlen = strlen($endpostext);
    $endpos = strpos($haystack, $endpostext, $startpos);

    return substr($haystack, $startpos + $startposlen, $endpos - ($startpos + $startposlen));
}

$back = $_SERVER["HTTP_REFERER"];
$id = $_REQUEST["id"];
$page = $_REQUEST["page"];
$type = $_REQUEST['type'];

$xmlSave = "xml/" . $checked['lang'] . "/" . $id . ".xml";
$xml = $def['DATABASE_PATH'] . "xml/" . $checked['lang'] . "/" . $id . ".xml";

if ($id == "" || $lang == "") {
  die("error: missing parameter id or lang");
}

if ( file_exists($xml) ){
    $xml = getDoc($xml);

    $buffer = '';
    if(preg_match('/<url>(.*?)<\/url>/', $xml, $matches)){
        $buffer = $matches[1];
    }
}else{
    $buffer = "";
}

switch ($type){
    case 'ticker':
        $xsl = "xsl/adm/save-ticker.xsl";
        break;
    case 'highlight':
        $xsl = "xsl/adm/save-rss-highlight.xsl";
        break;
    case 'rss':
        $xsl = "xsl/adm/save-rss.xsl";
}

$messageArray = array (
"es" =>
    array (
        "title" => "Administración: Biblioteca Virtual en Salud",
        "available" => "Disponible",
        "unavailable" => "Indisponible",
        "exit" => "Salir",
        "save" => "Graba",
        "url"  => "Enlace del archivo RSS ",
    ),
"pt" =>
    array (
        "title" => "Administração: Biblioteca Virtual em Saúde",
        "available" => "Disponível",
        "unavailable" => "Indisponível",
        "exit" => "Sai",
        "save" => "Grava",
        "url"  => "Link para o arquivo RSS ",
    ),
"en" =>
    array (
        "title" => "Administration: Virtual Health Library",
        "available" => "Available",
        "unavailable" => "Unavailable",
        "exit" => "Exit",
        "save" => "Save",
        "url"  => " Link to RSS file",
    ),
);
$message = $messageArray[$lang];

include('templates/rss.php');
?>
