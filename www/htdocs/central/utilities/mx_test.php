<?php
include("../config.php");
echo "<hr>";
echo "Testing if the  file <b>$mx_path</b> exists<br>";
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
