<?php
/* Modifications
2021-09-30 fho4abcd Created
** Test a list of jars given in the URL by tikajar0=..&tikajar1=..
*/
include("../config.php");
echo "<html><head><title>Test tika (s)</title></head><body>";
$count=0;
$tikajar="tika.jar";
while ( isset($_GET['tikajar'.$count]) ) {
    $tikajar = $_GET['tikajar'.$count];
    $count++;
    echo "<hr>Testing if the file <b>$tikajar</b> exists in cgi-bin";
    if  (!file_exists($cgibin_path.$tikajar)){
        echo "<br><span style='color:red'>missing $cgibin_path.$tikajar</span>";
        die;
    }else{        echo "&nbsp;&nbsp;<b>OK!!</b>";    }
    $tikacommand='java -jar '.$cgibin_path.$tikajar.' --version 2>&1';
    echo "<p style='color:blue'>Test with command:<b> $tikacommand</b></p>";
    $output="";
    exec($tikacommand, $output,$t);
    for($i=0;$i<count($output);$i++) {
        echo "<span style='color:green'>".$output[$i]."<br></span>";
    }
}
if ($count==0) echo "<span style='color:red'>Variable '&amp;tikajar&lt;number&gt;' not in the URL.</span>";
?>
