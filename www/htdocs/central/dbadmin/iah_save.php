<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/iah_conf.php");
include("../lang/dbadmin.php");

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");

unset($fp);

?>
</head>
<body>
<A NAME=INICIO>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["iah-conf"].": ".$arrHttp["base"].".def"?>
	</div>
	<div class="actions">
<?php
if (isset($arrHttp["encabezado"]))
	echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/iah_edit_db.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "\<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/iah_edit_db.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp;<font color=white>&nbsp; &nbsp; Script: iah_save.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">


<?php
$arrHttp["ValorCapturado"]= stripslashes($arrHttp["ValorCapturado"]);
echo "<xmp>".$arrHttp["ValorCapturado"]."</xmp>";
$file=$db_path."par/".strtoupper($arrHttp["base"]).".def";
$fp=fopen($file,"w");
if (!$fp){	echo "Cannot open the file $file for writing";
	die;}
$res=fwrite($fp,$arrHttp["ValorCapturado"]);

fclose($fp);
echo "<h2>".$msgstr["saved"];
?>
</form>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>