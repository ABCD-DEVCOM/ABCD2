<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$base=$arrHttp["base"];
$cn_val="";
$file_cn=$db_path.$base."/data/control_number.cn";
if (file_exists($file_cn)){
	$fp=file($file_cn);
	$cn_val=implode("",$fp);
}

include("../common/header.php");
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=../dataentry/js/lr_trim.js></script>"
?>
<script>
function Enviar(){
	control=Trim(document.forma1.control_n.value)
	if (control=="" || control=="0"){
		if (confirm("The control number of the database will be restored to 0 \n\n Is that correct? ")){
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
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["resetcn"].": $base"?>
	</div>
	<div class="actions">

 <?php 
$inc_backtourl="assign_control_number.php?base=".$base.$encabezado;
 include "../common/inc_back.php" ?>


 	</div>
	<div class="spacer">&#160;</div>
</div>

<?php 
$ayuda=$_SESSION["lang"]."/resetautoinc.html";
include "../common/inc_div-helper.php" 
?>


<div class="middle form">
	<div class="formContent">
 		<form name="forma1" action="resetautoinc_update.php" method="post" onsubmit="javascript:return false">
 <input type="hidden" name="base" value="<?php echo $base;?>">
 <input type="hidden" name="Opcion" value="control_n">

<?php 
if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=s>\n";
echo "<table>
	<td>".$msgstr["lastcn"]."</td><td><input type=text name=control_n value=$cn_val></td>";
echo "<tr><td colspan=2>&nbsp;</td>";
echo "</table>";
echo "<p><input type=submit name=send value=".$msgstr["update"]." onclick=Enviar()>";

echo "</form></div></div>";
include("../common/footer.php");
?>