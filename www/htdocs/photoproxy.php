<?php
include_once("central/config.php");
function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}


//echo $img_path."users/".$_REQUEST["imgid"];die;
header('Content-Type: image/jpeg');
if ((strpos($_REQUEST["imgid"],".jpg") > 0) && (file_exists($img_path.$_REQUEST["imgid"])))
{
  $img = LoadJpeg($img_path.$_REQUEST["imgid"]);
  imagejpeg($img);
  imagedestroy($img);
}
else
{
  $img = LoadJpeg($img_path."/users/noimage.jpg");
  imagejpeg($img);
  imagedestroy($img);
}

?>