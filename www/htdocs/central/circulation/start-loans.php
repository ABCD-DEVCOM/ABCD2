<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org
 * @file:      start-loans.php
 * @desc:      Ask for the inventory number and the user code for processing a loan
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   2.2
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>"; //die;
include("../common/header.php");
include("../common/institutional_info.php");
include("../circulation/scripts_circulation.php");

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}
	}
    return $pft;
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["loan"]." ";
		  if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") echo " - ".$msgstr["users"].": ".$arrHttp["usuario"];
		?>
	</div>
	<div class="actions">
	</div>
	<?php include("submenu_prestamo.php");?>
</div>

<?php 
	$ayuda="circulation/loan.html";
	include "../common/inc_div-helper.php";
?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
		<?php include("inc_form_loan.php");?>
	</div>
	<div class="formContent col-9 m-2">
			<h4><?php echo $msgstr['instructions'];?></h4>
			<li><?php echo $msgstr['instr1'];?></li>
			<li><?php echo $msgstr['instr2'];?></li>
			<li><?php echo $msgstr['instr3'];?></li>
	</div>
	</div>
</div>
<?php include("../common/footer.php");
