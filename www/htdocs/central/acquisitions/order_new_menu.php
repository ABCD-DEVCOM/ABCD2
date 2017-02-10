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
$arrHttp["Mfn"]="New";
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=split("_",$var);
		if (isset($variables[$tag[0]])){
			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}

}

include("../common/header.php");
include("javascript.php");
?>

<?php                                                                                                                                      $encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["new"]?>
	</div>
	<div class="actions">
		<a href=../common/inicio.php?reinicio=s&encabezado=s&modulo=acquisitions&base=<?php echo $arrHttp["base"]?> class="defaultButton cancelButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["cancel"]?></strong></span>
		</a>
    </div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions_new.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/suggestions_new.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: order_new.php</font>\n";
?>
</div>
<div class="middle form">
	<div class="formContent">
    <ul>

<?php
	$file=$db_path."copies/def/".$_SESSION["lang"]."/acquiredby.tab";
	if (!file_exists($file))
		$file=$db_path."copies/def/".$lang_db."/acquiredby.tab";
	$fp=file($file);
	foreach ($fp as $var){
		$var=trim($var);
		$v=explode('|',$var);
		$var=urlencode($var);		echo "<li><a href=order_new.php?base=purchaseorder&cipar=purchaseorder.par&mov=$var&Opcion=nuevo&wks=".$v[0].">".$v[1]."</a>";	}

?>
	</ul>
	</div>
</div>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>