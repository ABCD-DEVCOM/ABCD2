<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. Improve html
*/
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");


$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
$backtoscript="../dbadmin/menu_modificardb.php";
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
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
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

	<div style='text-align:center'><h3><?php echo $arrHttp["base"];?>.par</h3>
	<textarea cols="100" rows="20" name="par" class="par"><?php echo $par;?></textarea><br>
	<input class="bt-green" type="submit" value="<?php echo $msgstr["update"];?>">
    </div>
</form>
</div>
</div>
<?php
include("../common/footer.php");
?>