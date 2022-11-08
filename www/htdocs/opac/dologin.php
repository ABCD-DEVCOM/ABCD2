<?php
include("../central/config.php");
$response="";
$converter_path=$cisis_path."mx";
$user=$_GET["user"];
$pass=$_GET["pass"];
$db_path1=$_GET["path"];
$pft="if (v600='" . $user . "' and v610='" . $pass . "') then v600 fi/";
$mx=$converter_path." ".$db_path1."users/data/users ". $user. ' pft="' . $pft . '" now';
exec($mx,$outmx,$banderamx);
$textoutmx="";
$textoutmx=$outmx[count($outmx)-1];
if ($textoutmx==$user) 
	$response="ok";
 else 
 $response=$textoutmx;
	echo $response;
?>