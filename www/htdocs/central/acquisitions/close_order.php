<?php
//
//Cierra una orden de compra bien sea porque se procesaron los ítems adquiridos o si la misma ha sido anulada
// CLOSE A PURCHASE ORDER IF IS COMPLETED O ANNULED
//

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");

include("../common/header.php");
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["closeorder"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/receive_order_ex.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/receive_order_ex.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: close_order.php</font>\n";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php
//UPDATE PURCHASE ORDER FOR CLOSING THE ORDER
PurchaseOrderClose();
echo "<h4>".$msgstr["order"].": ";
if (isset($arrHttp["order"])) echo $arrHttp["order"]." ";
echo  $msgstr["orderclosed"]."</h4>";

echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";




//=================================================================


function PurchaseOrderClose(){
global $arrHttp,$xWxis,$Wxis,$wxisUrl,$db_path;
	$Db="purchaseorder";
    $arrHttp["Mfn"]=$arrHttp["Mfn_order"];
    $ValorCapturado="d0500<500 0>Y</500>";
    $IsisScript=$xWxis."actualizar.xis";
  	$query = "&base=".$Db ."&cipar=$db_path"."par/".$Db.".par&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
}

?>
