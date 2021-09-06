<?php
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");


$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["dbnpar"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["cancel"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/editpar.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/editpar.html target=_blank>".$msgstr["edhlp"]."</a>";
echo " Script: editpar.php";
?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">
<?php
$par="";
$fp=file($db_path."par/".$arrHttp["base"].".par");
foreach ($fp as $value) $par.=trim($value)."\n";
?>
<form name="db" action="editpar_update.php" method="post">
	<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">
	<?php 
		if (isset($arrHttp["encabezado"]))  
			echo "<input type=hidden name=encabezado value=s>\n";
	?>	

	<center><label><?php echo $arrHttp["base"];?>.par</label>
		<br>
	<textarea cols="100" rows="20" name="par" class="par"><?php echo $par;?></textarea><br>
	<input type="submit" value="<?php echo $msgstr["update"];?>">
</form>
</div>
</div>
</center>
<?php
include("../common/footer.php");
?>