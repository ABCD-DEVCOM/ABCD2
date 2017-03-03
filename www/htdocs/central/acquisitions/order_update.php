<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/acquisitions.php");
include("../common/get_post.php");
$ValorCapturado="";
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;
foreach ($arrHttp as $var=>$value){	$k=explode('_',$var);
	if (count($k)>2) $linea[$k[1]][$k[2]][$k[0]]=$value;
}
$ValorCapturado="0001".$arrHttp["order_no"]."\n";
$ValorCapturado.="0002".$arrHttp["order_date"]."\n";
$ValorCapturado.="0005".$arrHttp["provider"]."\n";
$ix=0;
foreach ($linea as $i=>$value){
	foreach ($value as $j=>$val){
		$campo="";
		foreach  ($val as $l=>$linea){
			$l=trim($l);
			$subc="";			switch ($l){				case "object":
					$subc="^a";      		//OBJECT
					break;
				case "cant":         		//QUANTITY
					$subc="^b";
					break;
				case "precio":       		//PRICE
					$subc="^c";
					break;
				case "suggestionno":  		//SUGGESTION
					$subc="^d";
					break;
				case "biddingno":    		//BIDDING
					$subc="^e";
					break;

				case "dbn":             	//`DATABASE
					$subc="^h";
					break;
				case "objtype":         	// NEW OBJECT OR COPIES
					$subc="^g";
					break;
				case "acqtype":         	// TYPE OF ACQUISITION (PURCHASE, EXCHANGE, DONATION)
					if ($ix==0){						$ix=1;
						$ValorCapturado.="0010".$linea."\n";
					}
					break;
				case "controln":       		// CONTROL NUMBER
					$subc="^i";
					break;
				case "controln":       		// ITEMS RECEIVED
					$subc="^j";
					break;
				case "tome":            	// TOME
					$subc="^l";
					break;             		// VOLUME
				case "volume":
					$subc="^m";
					break;
			}
			if ($subc!="") $campo.=$subc.$linea;
		}
		$ValorCapturado.=  "0050".$campo."\n";
	}
}
//echo "<xmp>$ValorCapturado</xmp>";
//die;
include("../common/header.php");
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["ordercreated"]?>
	</div>
	<div class="actions">
		<?php    ///OJO ARREGLAR
		$index=" ";
	//	include("order_menu.php");?>

	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/order_update.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/order_update.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: order_update.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<?
$key="ON_".trim($arrHttp["order_no"]);
//if (isset($arrHttp["suggestion"])) $key.='RNBN_'.$arrHttp["suggestion"];
//if (isset($arrHttp["bidding"])) $key.='_'.$arrHttp["bidding"];
$npost=SearchOrder($key);
if ($npost==0){
	$arrHttp["Opcion"]="actualizar";
	$cipar="purchaseorder.par";
	$base="purchaseorder";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."acquisitions/order_create.xis";
	$pft=$db_path."purchaseorder/pfts/".$_SESSION["lang"]."/purchaseorder.pft";
	if (!file_exists($pft)) $pft=$db_path."purchaseorder/pfts/".$lang_db."/purchaseorder.pft";
	$query = "&base=".$base ."&cipar=$db_path"."par/".$cipar."&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado."&order_no=".$arrHttp["order_no"]."&order_date=".$arrHttp["order_date"]."&Mfnsuggestion=".$Mfnsuggestion;
	$query.="&Formato_o=@$pft";
	$pft=$db_path."suggestions/pfts/".$_SESSION["lang"]."/suggestions.pft";
	if (!file_exists($pft)) $pft=$db_path."suggestions/pfts/".$lang_db."/suggestions.pft";
	$query.="&Formato_s=@$pft";

	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		if (substr($linea,0,4)=="MFN:") {
		    $arrHttp["Mfn"]=trim(substr($linea,4));
		}else{
			if (trim($linea!="")) echo $linea."\n";
		}
	}
}else{	echo "<h4>".$arrHttp["order_no"].": ".$msgstr["orderexist"]."</h4>";
	echo "<br><br><br><br><br>";}
echo "<a href=javascript:self.close()>".$msgstr["close"]."</a>";
echo "</div></div>";
include("../common/footer.php");
die;
//------------------------------------------------------

function SearchOrder($order){//SEE IS THE ORDER ALREADY EXISTS
global $xWxis,$db_path,$wxisUrl,$Wxis;
	$Prefijo=$order;
	$IsisScript= $xWxis."ifp.xis";
	$query = "&base=purchaseorder&cipar=$db_path"."par/purchaseorder.par&Opcion=diccionario&prefijo=$Prefijo&campo=1";
	$contenido=array();
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		if (trim($linea)!=""){
			$pre=trim(substr($linea,0,strlen($Prefijo)));
			if ($pre==$Prefijo){
				$l=explode('|',$linea);
				return $l[1];
				break;
			}
		}
	}
	return 0;
}
?>
