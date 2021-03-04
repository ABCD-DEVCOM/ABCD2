<?php
/* Modifications
2021-03-04 fho4abcd Get mx_path from url (required if more database sets are present)
*/
include("../config.php");
echo "<hr>";
if (isset($_GET['mx_path'])) {
    $mx_path = $_GET['mx_path'];
}else {
    echo "<font color=red>Variable 'mx_path' not in the URL. Using default for this test</font><br><br>";
}
echo "Testing if the file <b>$mx_path</b> exists<br>";
if  (!file_exists($mx_path)){
	echo "<font color=red>missing $mx_path</font>";
	die;
}else{	echo "<strong>OK!!</strong>";}
echo "<p><font color=blue>Testing the execution of  <b>$mx_path</b></font><br>";
$strINV=$mx_path." what ";
echo "<strong>Command line: $strINV<P></STRONG>";
exec($strINV, $output,$t);
$straux="";
for($i=0;$i<count($output);$i++)
{
echo $output[$i]."<br>";
}

?>
