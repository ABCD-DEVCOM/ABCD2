<?php
/**
 * 2023-01-04 rogercgui Uncommented line 19 "$filename=strtolower.."Reason: files with the uppercase extension are not working on updated Linux servers.
 * 
 * **/

session_start();
include("../viewer/get_post.php");
include("../../central/config.php");

if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")) {
    $def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
    $img_path = trim($def["ROOT"]);
} else {
    $img_path = $db_path.$arrHttp["base"]."/";
}

$filename = $arrHttp["image"];
$f_ext = pathinfo($filename, PATHINFO_EXTENSION);
$img_file = $img_path . $filename;

if (!file_exists($img_file)) {
    die("Imagem não encontrada: $img_file");
}

// Definir tipo MIME e criar a imagem
switch ($f_ext) {
    case "jpg":
    case "jpeg":
        $img = imagecreatefromjpeg($img_file);
        $content_type = "image/jpeg";
        break;
    case "png":
        $img = imagecreatefrompng($img_file);
        $content_type = "image/png";
        break;
    case "gif":
        $img = imagecreatefromgif($img_file);
        $content_type = "image/gif";
        break;
    default:
        die("Tipo de imagem não suportado.");
}

// Redimensionar se necessário
$max_dim = 800;
$width = imagesx($img);
$height = imagesy($img);
$scale = min($max_dim / $width, $max_dim / $height, 1);

$new_width = intval($width * $scale);
$new_height = intval($height * $scale);
$resized = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($resized, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// Adicionar marca d'água
$text = $_SERVER['HTTP_HOST']." - ".date('Ymd hh:mm');
$font_size = 20;
$angle = 0;
$font_file = "../assets/webfonts/alexandria.ttf"; // Caminho real para uma fonte TTF
$text_color = imagecolorallocatealpha($resized, 255, 255, 255, 75); // Branco com transparência

if (file_exists($font_file)) {
    imagettftext($resized, $font_size, $angle, 8, 25, $text_color, $font_file, $text);
}

// Exibir imagem com cabeçalhos apropriados
header("Content-type: $content_type");
switch ($f_ext) {
    case "jpg":
    case "jpeg":
        imagejpeg($resized);
        break;
    case "png":
        imagepng($resized);
        break;
    case "gif":
        imagegif($resized);
        break;
}
imagedestroy($resized);
?>