<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");

include("../lang/soporte.php");
include("../common/header.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["z3950"].". ".$msgstr["z3950_diacritics"] ?>
	</div>

	<div class="actions">
<?php
	if ($encabezado!="") echo "<a href=z3950_conf.php?&base=$db$encabezado class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/z3950_conf.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/z3950_conf.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: z3950_diacritics_update.php </font>";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php
$fp=fopen($db_path."cnv/marc-8_to_ansi.tab","w");
$accents=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($accents as $val){
	$val=trim($val);
	if($val!=""){		$a=explode('|',$val);
		fwrite($fp,$a[0]." ".$a[1]."\n");	}}
fclose($fp);
echo "<h4>marc-8_to_ansi.tab : ".$msgstr["updated"]."</h4>";
?>
</div>
</div>
<?php include("../common/footer.php")?>
</body>
</html>

