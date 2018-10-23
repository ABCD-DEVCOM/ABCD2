<?php
//echo 'dologin !<p>';
include("../central/config.php");
$response="";
$converter_path=$cisis_path."mx";
$user=$_GET["user"];
$pass=$_GET["pass"];
$db_path1=$_GET["path"];
$pft="if (v600='" . $user . "' and v610='" . $pass . "') then v600 fi/";
$mx=$converter_path." ".$db_path1."users/data/users ". $user. ' pft="' . $pft . '" now';
//echo $mx . '<p>';
//die;
exec($mx,$outmx,$banderamx);
$textoutmx="";
//for ($i = 0; $i < count($outmx); $i++) {
//$textoutmx.=$outmx[$i];
//}
$textoutmx=$outmx[count($outmx)-1];
//echo "textoutmx=".$textoutmx;
//die;
if ($textoutmx==$user) $response="DISPLAY"; else $response=$textoutmx;
echo $response;
?>
