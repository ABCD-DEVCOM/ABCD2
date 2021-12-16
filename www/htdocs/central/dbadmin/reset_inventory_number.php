<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. Improve html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}else{
	if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CENTRAL_RESETLIN"])){
		header("Location: ../common/error_page.php") ;
	}
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$inv_val="";
$file=$db_path."copies/data/control_number.cn";
if (file_exists($file)){
	$fp=file($file);
	$inv_val=implode("",$fp);
}

include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script>
function Enviar(){
	control=Trim(document.forma1.control_n.value)
	if (control=="" || control=="0"){
		if (confirm("The inventory number of the copies database will be restored to 0 \n\n Is that correct? ")){
			if (confirm("are you sure?")){
			}else{
				return
			}
		}else{
			return
		}
	}
	document.forma1.submit()
}

</script>
<?php
echo "<>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}


?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["resetinv"]?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="resetautoinc.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
    <form name=forma1 action=resetautoinc_update.php method=post onsubmit="javascript:return false">
    <input type=hidden name=Opcion value=inventory>
    <?php
    if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=s>\n";
    ?>
    <table>
    <tr><td><?php echo $msgstr["lastinv"]?></td>
        <td><input type=textbox name=control_n value="<?php echo $inv_val?>"></td>   
    </table>
    <p>
    <input type=submit name=send class=bt-blue value="<?php echo $msgstr["update"]?>" onclick=Enviar() >
    </form>
</div></div>
<?php
include("../common/footer.php");
?>