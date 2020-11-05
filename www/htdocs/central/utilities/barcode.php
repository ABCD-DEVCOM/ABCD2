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
include("../config.php");
include("../common/header.php");
$base=$arrHttp["base"];

echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}


echo "<div style='float:right;'> <a href=\"..\dbadmin\menu_mantenimiento.php?base=".$base."\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";


//$OS=strtoupper(PHP_OS);
$converter_path=$mx_path;
//if (strpos($OS,"WIN")=== false)
//{
//$converter_path=str_replace('mx.exe','',$converter_path);
//$converter_path.=$cisis_ver."mx";
//}
//else
//$converter_path=$mx_path.$cisis_ver."mx.exe";
$t="";$barcode="";
$retag_path=$converter_path;
$base=$arrHttp["base"];
$bd=$db_path.$base;
if (isset($_GET['barcode'])) $barcode=$_GET['barcode'];
if (isset($_GET['bf'])) $bf=$_GET['bf'];
$strINV=$retag_path." ".$bd."/data/".$base." \"".$barcode."\"";
if($barcode!="")
{
exec($strINV, $output,$t);
$straux="";
$strstr="";
for($i=0;$i<count($output);$i++)
{
$straux[$i]=$output[$i]."<br>";
$strstr.=$output[$i];
}
}
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Barcode: " . $base."
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
			function MFN ($str)
{
$mfnf=split("mfn= ",$str);
$aux= trim($mfnf[1]);
$i=0;
$mfn="";
while($aux[$i]!=' ')
{
$mfn.=$aux[$i];
$i++;
}
return $mfn;
}

if($t==0 and $barcode!=""){
echo ("<h3>Results for barcode '$barcode' in database $base</h3><br>");
echo "<li>Found in $base?";
if(strpos($strstr,"Hits=0")==false and $t==0) echo " yes";
else echo " no";
echo " </li>";
if(strpos($strstr,"Hits=0")==false and $t==0)
{
$mfnf=split("mfn= ",$strstr);
$aux= trim($mfnf[1]);
$i=0;
$mfn="";
while($aux[$i]!=' ')
{
$mfn.=$aux[$i];
$i++;
}
echo "<li>Mfn= ".$mfn."</li>";
$cn=$straux[4];
$cnOK="";
$str=$strstr;
for($i=0;$i<strlen($str)-3;$i++)
{

if($str[$i]=='1' and $str[$i+1]==' ' and $str[$i+2]==' ' and $str[$i+3]=='®')
{
$i=$i+4;
while($str[$i]!='¯')
{
$prevcn.=$str[$i];
$i++;
}
break;
}


}
$CN=$prevcn;
echo "<li><font color='red'>Control number:".$CN."</font></li>";
}

}

 if (isset($straux)) if(strpos($straux[3],"="))
{
/*
echo "<form name='f2' method='get' action='cn.php'>";
echo "<h3>Enter the red control number to search it in database marc</h3><br>";
echo "Enter control number <input type='text' name='cn'> <input type='submit' value='search'>";
echo "</form>";
$auxsplit=split("<br>",$cnOK);
$cnOK=$auxsplit[0];
echo "<script>document.f2.cn.value='$cnOK'</script>";
*/
$bd2=$_GET['bd2'];
$cnf=$_GET['cnf'];
$bd=$db_path.$bd2;
$auxsplit=split("<br>",$cnOK);
$cnOK=$auxsplit[0];
$cng=$cnOK;
$CN=CN($strstr);
$strINV2=$retag_path." ".$bd."/data/".$bd2." \"".$CN."\""." "."\"pft=v$cnf\"" ;
exec($strINV2, $output2,$t);
$strout="";
for($i=0;$i<count($output2);$i++)
{
$strout.= $output2[$i]."<br>";

}
if(strpos($strout,"Hits=0")==false and $t==0)
{
echo "<h3>The control number  $CN is present in the $bd2 database</h3><br>";

}
else
echo "<h3><font color='red'>The control number $CN is NOT present in the $bd2 database in the field '$cnf'</font></h3>";
}
else
if($t!=0)
echo ("<h2>Output: <br>process NOT EXECUTED</h2><br>");
if($base=="")
{
echo"NO database selected";
}

function CN ($str)//to get control number from mx output
{
$cnf=$_GET['cnf'];
for($i=0;$i<strlen($str)-3;$i++)
{

if($str[$i]=='$cnf' and $str[$i+1]==' ' and $str[$i+2]==' ' and $str[$i+3]=='®')
{
$i=$i+4;
while($str[$i]!='¯')
{
$prevcn.=$str[$i];
$i++;
}
break;
}


}

return $prevcn;
}





?>


			</ul>

		</td>
</table></form>


