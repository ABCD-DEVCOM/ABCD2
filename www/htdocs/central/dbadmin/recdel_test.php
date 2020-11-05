<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$vc=explode("\n",$arrHttp["ValorCapturado"]);
$Pft=array();
$ix=-1;
$formato="";
foreach ($vc as $var=>$value) {	$value=trim($value);	if (substr($value,0,1)=="@"){		$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($value,1));
		if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($value,1));
		$formato="@".$pft_file;
		break;
	}
	$formato.= $value  ;
}
$formato=urlencode(trim($formato));
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
?>
<html>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
<?php echo "<a href=\"javascript:self.close()\" class=\"defaultButton cancelButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["close"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="middle form">
	<div class="formContent">
<?php

echo "<h5>&nbsp; &nbsp; Script: dbadmin/recval_test.php</h5>";
$recval_pft="";
$recval_pft=implode("",$contenido);
if (!strpos($recval_pft,'execution error')===false){
    echo $recval_pft;
   	die;
}

echo  $recval_pft;

echo "</div></div></body>
</html>";
?>