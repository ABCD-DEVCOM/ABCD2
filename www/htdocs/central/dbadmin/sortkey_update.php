<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
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
<?php echo $msgstr["sortkey"].$arrHttp["base"] ?>
	</div>

	<div class="actions">
<?php
	if ($encabezado!="") echo "<a href=javascript:self.close() class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/sortkey.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/sortkey.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script:sortkey_update.php </font>";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php
$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab","w");
$accents=explode("\n",$arrHttp["ValorCapturado"]);
echo "\n<script>
sort=new Array()
window.opener.document.forma1.sort.length=0
";
$ix=0;
foreach ($accents as $val){
	$val=trim($val);
	$ix=$ix+1;
	if($val!=""){		$a=explode('|',$val);
		echo "window.opener.document.forma1.sort.options[$ix]= new Option('".$a[0]."','".$a[1]."')\n";
		fwrite($fp,$a[0]."|".$a[1]."\n");	}}
fclose($fp);
echo "</script>\n";
echo "sort.tab ".$msgstr["updated"]."<p>";
?>
</div>
</div>
<?php include("../common/footer.php")?>
</body>
</html>

