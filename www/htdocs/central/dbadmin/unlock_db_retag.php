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
include("../common/institutional_info.php");
	$encabezado="&encabezado=s";

echo "<div style='float:right;'> <a href=\"menu_mantenimiento.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";


$OS=strtoupper(PHP_OS);
$converter_path=$mx_path;
$ix=strrpos($mx_path,"/");
$converter_path=substr($mx_path,0,$ix+1);
if (strpos($OS,"WIN")=== false){
	$converter_path.="retag";
}else
	$converter_path.="retag.exe";
$retag_path=$converter_path;
$base=$arrHttp["base"];
$bd=$db_path.$base;
$strINV=$retag_path." ".$bd."/data/".$base." unlock";
exec($strINV, $output,$t);
$straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";
}

echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Unlock DB: " . $base."
			</div>
			<div class=\"actions\">";
if (isset($arrHttp["encabezado"])){
echo "<a href=\"menu_mantenimiento.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";

?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_unlock_db_retag.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_unlock_db_retag.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: unlock_db_retag.php</font>";
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
			<li>
          <?php
		  echo "<h3>Query: $strINV"."</h3><br>";
		  ?>
            </li>
           <br>
            <li>
			<?php

			if($t==0)
echo ("<h3>process Output: ".$straux."<br>process Finished OK</h3><br>");
else
echo ("<h2>Output: <br>process NOT EXECUTED</h2><br>");
if($base=="")
{
echo"NO database selected";
}
?></li>


			</ul>

		</td>
</table></form>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>";
?>

