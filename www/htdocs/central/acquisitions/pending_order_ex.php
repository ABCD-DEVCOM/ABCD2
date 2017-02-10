<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");

include("../common/get_post.php");
$arrHttp["base"]="purchaseorder";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;
include ('../dataentry/leerregistroisis.php');

include("../common/header.php");
?>
<style>
#headerDiv, #contentDiv {
float: left;
width: 510px;
}
#titleText {
float: left;
font-size: 1.2em;
font-weight: bold;
margin: 5px 10px;
}
headerDiv {
background-color: #ffffff;
color: #000000;
}
contentDiv {
background-color: #FFE694;
}
myContent {
margin: 5px 10px;
}
headerDiv a {
float: left;
margin: 10px 10px 5px 5px;
}
headerDiv a:hover {
color: #;
}
</style>
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript src=../dataentry/js/popcalendar.js></script>
<script>
function toggle(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    	ele.style.display = "none";
		text.innerHTML = "<?php echo $msgstr["createorder"]?>";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "<?php echo $msgstr["hide"]?>";
	}
}

function EnviarForma(){	alert('not developed yet')
	return false
}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["claim"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/pending_order_ex.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/pending_order_ex.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: pending_order_ex.php</font>\n";
?>
	</div>




<div class="middle form">
			<div class="formContent">
<?php

$locales=explode('/',$config_date_format);
switch ($locales[0]){	case "DD":
		$date1="d";
		break;
	case "MM":
		$date1="m";
		break;
}switch ($locales[1]){
	case "DD":
		$date2="d";
		break;
	case "MM":
		$date2="m";
		break;
}
date_default_timezone_set('UTC');
$formato_fecha="$date1-$date2-Y";
$fecha=date($formato_fecha);
//
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/purchaseorder.pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/purchaseorder.pft" ;
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=@$Formato&Opcion=rango";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
foreach ($contenido as $value) echo "$value\n";

?>
<form method=post name=forma1 action=order_update.php onSubmit="javascript:return false">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=order value="<?php echo $purchase?>">
<dd><dd><?php echo $msgstr["date"]?>: <input type=text name=tag450_1 value="<?php echo $fecha?>" size=10> &nbsp;
<input type=submit value=<?php echo $msgstr["submit"]?> onclick=EnviarForma()>  </dd></dd>

</form>
<?php
	echo "<form name=close action=close_order.php>\n";
	echo "<center>&nbsp;<input type=submit value=\"Close order\"></center>\n";
	echo "<input type=hidden name=order value=".$purchase.">\n";
	echo "<input type=hidden name=Mfn_order value=".$arrHttp["Mfn"].">\n";


?>
