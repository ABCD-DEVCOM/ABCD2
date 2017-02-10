<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$file_cn=$db_path.$arrHttp["base"]."/data/control_number.cn";
if (file_exists($file_cn)){	$fp=file($file_cn);
	$cn_val=implode("",$fp);}
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>"
?>
<?php
echo "<body>\n";
include("../common/institutional_info.php");


?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["resetctl"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/copies_configuration.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/copies_configuration.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: resetautoinc.php</font>\n";
echo "
	</div>
<div class=\"middle form\">
	<div class=\"formContent\">";
	$file_cn=$db_path.$arrHttp["base"]."/data/control_number.cn";
	$fp=fopen($file_cn,"w");
	fwrite($fp,$arrHttp["control_n"]);
	fclose($fp);
	unset($fp);
	echo "<dd><h4>".$msgstr["lastsugupd"]."</h4>";
echo "</div></div></body></html>";
?>