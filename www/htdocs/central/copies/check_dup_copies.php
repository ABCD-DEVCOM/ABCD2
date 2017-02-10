<?php 
include("../config.php");
$response="";
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path."mx";
$in=$_GET["invnum"];
$mx=$converter_path." ".$db_path."copies/data/copies IN_".$in." now";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=$outmx[$i]."~";
}
$splitbymfn=explode("mfn=",$textoutmx);
for ($i = 1; $i < count($splitbymfn); $i++) {//Now going one by one mfn
$splitbymarc=explode("~",$splitbymfn[$i]);
$response.=str_replace(" ",'',$splitbymarc[0])."~";
}//Now going one by one mfn
if ($response=="") $response="~";
echo $response;
?>