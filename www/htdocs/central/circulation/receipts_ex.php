<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/prestamo.php");

include("../common/header.php");
include("../common/institutional_info.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";//die;
$pft_val["pr_loan"]="r_loan.pft";
$pft_val["pr_return"]="r_return.pft";
$pft_val["pr_fine"]="r_fine.pft";
$pft_val["pr_statment"]="r_statment.pft";
$pft_val["pr_solvency"]="r_solvency.pft";
$ayuda="receipts.html";
$fp=fopen($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst","w");
$error=array();
$activated=array();
foreach ($arrHttp as $var=>$value){	if (substr($var,0,2)=="pr"){		$pft=$value;
		if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/$pft")){			$res=fwrite($fp,"$var\n");
			$activated[$var]=$value;
		}else{			$error[$var]=$value ;		}	}}
fclose($fp);
?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["receipts"]?>
	</div>
	<div class="actions">
		<a href="receipts.php?base=trans" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo  $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">

<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/receipts_ex.php";
?></font>
</div>
<div class="middle form">
	<div class="formContent">
	<form name=receipts action=receipts_ex.php method=post onsubmit="return false">

	<table cellpadding=10>
<?php

echo "<tr><td colspan=3><strong>".$msgstr["receipts"]."</td></tr>\n";
echo "<tr><td>".$msgstr["loan"]."</td><td>";
if (isset($activated["pr_loan"])){	echo  "<img src=\"../dataentry/img/recordvalidation_p.gif\">";}else{	if (isset($error["pr_loan"])) echo $msgstr["falta"]." ".$pft_val["pr_loan"];}
echo "</td>\n";
echo "<tr><td>".$msgstr["return"]."</td><td>";
if (isset($activated["pr_return"])){
	echo  "<img src=\"../dataentry/img/recordvalidation_p.gif\">";
}else{	if (isset($error["pr_return"])) echo $msgstr["falta"]." ".$pft_val["pr_return"];}
echo "</td>\n";
echo "<tr><td>".$msgstr["fine"]."</td><td>";
if (isset($activated["pr_fine"])){
	echo  "<img src=\"../dataentry/img/recordvalidation_p.gif\">";
}
else{
	if (isset($error["pr_fine"])) echo $msgstr["falta"]." ".$pft_val["pr_fine"];
}
echo "</td>\n";
echo "<tr><td>".$msgstr["statment"]."</td><td>";
if (isset($activated["pr_statment"])){
	echo  "<img src=\"../dataentry/img/recordvalidation_p.gif\">";
}else{
	if (isset($error["pr_statment"])) echo $msgstr["falta"]." ".$pft_val["pr_statment"];
}
echo "</td>\n";
echo "<tr><td>".$msgstr["solvency"]."</td><td>";
if (isset($activated["pr_solvency"])){
	echo  "<img src=\"../dataentry/img/recordvalidation_p.gif\">";
}else{
	if (isset($error["pr_solvency"])) echo $msgstr["falta"]." ".$pft_val["pr_solvency"];
}
echo "</td>";
?>
	</table>
    </form>
	</div>
</div>
</center>
<?php
include("../common/footer.php");
?>
</body>
</html>

