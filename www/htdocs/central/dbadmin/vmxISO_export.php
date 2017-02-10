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
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path;

//if(!isset($_SESSION["base"]))
//{
//session_register("base");
//$_SESSION["base"]=$base;
//}

include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
echo "<div style='float:right;'> <a href=\"menu_mantenimiento.php?base=".$_POST['basef']."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Export ISO: " . $base."
			</div>
			<div class=\"actions\">";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_vmxISO_export.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_vmxISO_export.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: vmxISO_export.php</font>";
?>
</div>
<div class="middle form">
<form action="" method="post" enctype="multipart/form-data">
<?php echo "<input type='hidden' name='basef' value='$base'>" ?>
<label>Enter a name</label> <br>
<input type='text' name='isoname'>
<br><br><label>MARC format</label>
  <select name="mf">
  <option>yes</option>
  <option>no</option>
  </select>
<br><br>
  <input type="submit" value="Start"/>
  </form>


<?php

$base=$_POST['basef'];
$bd=$db_path.$base;
$OK=$_POST['ok'];


  
	$mf=$_POST['mf'];
$isoname=$_POST['isoname'];
if($isoname!='')
{
if($mf=="no")
	 $strINV=$cisis_path."mx ".$db_path."/".$base."/data/".$base." iso=".$db_path."/wrk/".$isoname." -all now";
else 
$strINV=$cisis_path."mx ".$db_path.$base."/data/".$base." iso=".$db_path."wrk/".$isoname." outisotag1=3000 -all now";
	 exec($strINV, $output,$t);
	 $straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";
}
echo "<br>MX query: ".$strINV;
echo "<br>Process output: ".$straux; 
if($t==0)
{
echo "<br>Process OK!<br>File saved in ".$db_pat."wrk/".$isoname;

}
else
echo "<br>Process NOT executed!";
if($base=="")
{
echo"<br>NO database selected";
}
}
//echo "<br>"."<a href='menu_mantenimiento.php?base=&encabezado=s'>Maintenance Menu</a>"."<br>";
?>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>";

?>
