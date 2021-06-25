<?php
/* Modifications
20210608 fho4abcd Created
20210625 fho4abcd better output
*/
include("../config.php");
echo "<hr>";
if (isset($_GET['cnvexe'])) {
    $cnvexe = $_GET['cnvexe'];
}else {
    echo "<font color=red>Variable 'cnvexe' not in the URL.</font>";
    die;
}
echo "Testing if the file <b>$cnvexe</b> exists<br>";
if  (!file_exists($cnvexe)){
	echo "<font color=red>missing $cnvexe</font>";
	die;
}else{
	echo "<strong>OK!!</strong>";
}
echo "<p><font color=blue>Testing the execution of  <b>$cnvexe</b></font><br>";
$strINV=$cnvexe." -h 2>&1";
echo "<strong>Command line: $strINV</STRONG>";
echo "<div style='font-family:courier;font-size:12px'>";
echo "<pre>";
exec($strINV, $output,$t);
$straux="";
for($i=0;$i<count($output);$i++)
{
echo $output[$i]."<br>";
}
echo "</pre></div>";

?>
