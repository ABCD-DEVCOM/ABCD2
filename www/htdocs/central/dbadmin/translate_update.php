<?
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) and !isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/dbadmin.php");

include("../lang/admin.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
$encabezado="";
if (isset($arrHttp["encabezado"])) $encabezado="&encabezado=s";
include("../common/header.php");
$rotulo="";
switch ($arrHttp["componente"]){
	case "soporte.php":
		$rotulo=$msgstr["maintenance"];
		break;
	case "dbadmin.php":
		$rotulo=$msgstr["dbadmin"];
		break;
	case "admin.php":
		$rotulo=$msgstr["catalogacion"];
		break;
}
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["traducir"].": ".$rotulo."</h5>"?>
			</div>

			<div class="actions">
 				<a href="menu_traducir.php?encabezado=s" class="defaultButton backButton">
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php }
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";
echo "<font size=1> &nbsp; &nbsp; Script: translate_update.php</font><br>";
//error_reporting (0);
$componente=$arrHttp["componente"];
$lang=$_SESSION["lang"];

$componente=$arrHttp["componente"];
echo "<h2>$lang/$componente</h2><p>";
$mensajes="";

foreach ($arrHttp as $var=>$value) {	if (substr($var,0,4)=="msg_"){
		$var=substr($var,4);
		$mensajes.=$var."=".$value."\n";
	}
}
//echo "<xmp>$mensajes</xmp>";
if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/".$_SESSION["lang"]."/$componente";
else
	$a=$db_path."lang/".$_SESSION["lang"]."/$componente";

$fp=fopen($a,"w");
if (!$fp) {	echo "no pudo ser actualizado";
	die;}
$res=fwrite($fp,stripslashes($mensajes)."\n");
fclose($fp);
echo "<h3>".$msgstr["actualizados"]."</h3> ";
echo "<p></div></div>";
include("../common/footer.php");
echo "
</body>
</html>";
?>
