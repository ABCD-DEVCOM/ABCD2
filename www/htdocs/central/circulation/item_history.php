<?php
session_start();
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");



?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function checkSubmit(e) {
   if(e && e.keyCode == 13) {
   		EnviarForma()
   }
}
function EnviarForma(){
	if (Trim(document.inventorysearch.inventory.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]." / ".$msgstr["usercode"]?>")
		return
	}
    document.inventorysearch.target="receiver"
    document.inventorysearch.submit()
}



</script>
<?php
$encabezado="";
echo "<body onLoad=javascript:document.inventorysearch.inventory.focus()>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["co_history"];
		?>
	</div>
	<div class="actions">

	</div>
	<?php include("submenu_prestamo.php");?>
</div>

<?php
$ayuda="item_history.html";
include "../common/inc_div-helper.php";
?> 	

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">

<form name=inventorysearch action=item_history_ex.php method=post onsubmit="javascript:return false">
<input type=hidden name=Opcion value=prestar>
		<h4><?php echo $msgstr["inventory"]?></h4>
		<input type="text" name="inventory" id="inventory" value="" class="w-10" onKeyPress="return checkSubmit(event,1)" />

		<button type="submit" name="reservar" title="<?php echo $msgstr["loan"]?>" class=" bt-green w-10" onclick="javascript:EnviarForma()"/> <?php echo $msgstr["search"]?> <i class="fas fa-arrow-right"></i></button>

	</form>

	</div>
	<div class="formContent col-9 m-2">
		<iframe class="iframe w-10" height="600px" name="receiver" id="receiver" frameborder="0"></iframe>
	</div>
	</div>
</div>



<?php include("../common/footer.php"); ?>