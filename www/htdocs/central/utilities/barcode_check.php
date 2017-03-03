<?php 
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
//include("../config.php");
include("../common/header.php");
$base=$arrHttp["base"];
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "<div style='float:right;'> <a href=\"menu_mx_based.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";
$OS=strtoupper(PHP_OS);
//$mx_path="/opt/ABCD/www/cgi-bin/";
$cisis=""; 
$converter_path=$cisis_path;
if (strpos($OS,"WIN")=== false)
{ 
$converter_path=str_replace('mx.exe','',$converter_path);
$converter_path.=$cisis_ver."mx";
}
else
$converter_path=$cisis_path.$cisis_ver."mx";
$retag_path=$converter_path;	
$base=$arrHttp["base"];
$bd=$db_path.$base;
$barcode=$_GET['barcode'];
$bf=$_GET['bf'];
$PFT="MFN(0),/if 'MARCmarc': v10 then v1 fi"; 
$strINV=$retag_path." ".$bd."/data/".$base." \"".$barcode."\"" .  " \"pft=" . $PFT." \"" ;
//echo "strINV=".$strINV. '<p>';
if($barcode!="")
{
exec($strINV, $output,$t);
$CN=substr($output[4], 0, strlen($output[4])-2);
$MFN=$output[3];
echo "CN=".$CN . '<p>';
}
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Barcode_check: " . $base."
			</div>
			<div class=\"actions\">";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
				
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_barcode.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_barcode.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode.php</font>";
?>
</div>
<div class="middle form">
	<div class="formContent">
<form name=maintenance>
<table cellspacing=5 width=400 align=center>
	<tr>
		<td>
		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
             <br>
			<ul>
			
          <?php 
		  echo "This tool only works from the Loanobjects database !<p>";
		  echo "<form name='f1' action='' method='get'>
		  Enter barcode <input type='text' name='barcode'><br><br>
		  Enter secondary database <input type='text' name='bd2' value='marc'> <br><br>
		  Control Number Field <input type='text' name='cnf' value='1'>
		  <input type='submit' value='search'>
		  		  </form>
		  "; 
		  ?>
           
           <br>
            
			<?php 
			
			if($MFN!="" and $barcode!=""){
echo ("<h3>Results for barcode '$barcode' in database $base</h3><br>");
echo "<li>Found in $base : ";
if ($MFN!=0) 
{echo "<b><font color=green>YES</font></b> ";
echo "<li>Mfn= ".$MFN."</li>";
}
else echo "<b><font color=red>NO</font></b> ";
echo " </li>";
}
 $bd2=$_GET['bd2'];
$cnf=$_GET['cnf'];
$bd=$db_path.$bd2;
if ($CN!=0)
{
if ($CN!="") 
{
$strINV2=$retag_path." ".$bd."/data/".$bd2." \" CN_".$CN."\""."  lw=999 "."\"pft=v$cnf/,v245^a,v245^b\"" ;
echo "<p> strINV2=".$strINV2;
exec($strINV2, $output2,$t);
$title = $output2[count($output2)-1];
if ($title!="") 
{
echo "<h3>The control number  $CN is present in database $bd2 as MFN $MFN. <br>Title : <font color=`green`> $title.</font></h3><br>";
}
else 
echo "<h3><font color='red'>The control number $CN is <B>NOT</B> present in the $bd2 database in the field '$cnf'</font></h3>";
}
}
else 
if($t!=0)
echo ("<h2>Output: <br>process NOT EXECUTED</h2><br>");
else 
if ($MFN!="->") echo "<b>CN $CN <font color=red>NOT FOUND IN DATABASE $bd2</font></b>";
if($base=="")
{
echo"NO database selected";
}
?>
			</ul>
		</td>
</table></form>
