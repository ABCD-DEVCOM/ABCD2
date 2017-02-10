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

include("../common/header.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//SE LEE LA ORDEN DE COMPRA PARA PODERLE GRABAR EL NÚMERO DE CONTROL ASIGNADO
$purchase_order=ReadPurchaseOrder();
//foreach ($purchase_order as $key=>$value) echo "$key=$value<br>";

echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["create"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/object_create.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/object_create.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: object_create.php</font>\n";

?>
	</div>




<div class="middle form">
			<div class="formContent">
<?php

$pref_ctl="CN_";
//GET THE CONTROL NUMBER FOR THE NEW OBJECT
$CN=NextControlNumber($arrHttp["database"]);
//VERIFY IF THE CONTROL NUMBER IS ASSIGNED TO ANOTHER RECORD
$tag_ctl="";
LeerFst($arrHttp["database"]);

//FIND IF THE CONTROL NUMBER ALREADY EXISTS IN THE DATABASE
$Formato=$db_path.$arrHttp["database"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["database"].".pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["database"]."/pfts/".$lang_db."/".$arrHttp["database"].".pft" ;
$Formato="@$Formato,/";
$Expresion="CN_".$CN;
$query = "&base=".$arrHttp["database"]."&cipar=$db_path"."par/".$arrHttp["database"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$cont_database=implode('',$contenido);
if (trim($cont_database)!="") {	echo "<h3>".$msgstr["objectexist"]."</h4>";
	echo $cont_database;
	echo "</div></div>";
	include("../common/footer.php");
	echo "</body></html>";
	die;
}

//CREATE THE STRING FOR THE NEW RECORD
$ValorCapturado="";
foreach ($arrHttp as $var=>$value){	if (substr($var,0,3)=="tag"){		$tag=trim(substr($var,3));
		$ValorCapturado.="<".$tag." 0>".trim($value)."</".$tag.">";
	}}
//ADD THE CONTROL NUMBER TO THE UPDATE STRING
$ValorCapturado.="<".$tag_ctl." 0>".$CN."</".$tag_ctl.">";
// ADD THE RECORD TO THE BIBLIOGRAPHIC DATABASE
$ValorCapturado=urlencode($ValorCapturado);
$IsisScript=$xWxis."actualizar.xis";
$query = "&base=".$arrHttp["database"] ."&cipar=$db_path"."par/".$arrHttp["database"].".par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){
	if (substr($linea,0,4)=="MFN:") {
    	$arrHttp["Mfn"]=trim(substr($linea,4));
	}else{
		if (trim($linea!="")) echo $linea."\n";
	}
}
echo "<h4>".$msgstr["database"].": ".$arrHttp["database"]." - " . $msgstr["objectcreated"]." Mfn: ";
echo "<a href=../dataentry/show.php?base=".$arrHttp["database"]."&Mfn=".$arrHttp["Mfn"]." target=_blank>".$arrHttp["Mfn"]."</a>";
echo " ".$msgstr["cn"]." = ".$CN;
echo "</h4><p>";

//OJO AQUI HAY QUE AGREGAR EL NÚMERO DE CONTROL A LA BASE DE DATOS DE ORDENES DE COMPRA
$purchase_order[$arrHttp["occ"]].="^i".$CN;
$ValorCapturado="";
foreach ($purchase_order as $order_c){
	if (trim($order_c)!="")
		$ValorCapturado.="<50 0>".$order_c."</50>";}
$ValorCapturado=urlencode($ValorCapturado);
$IsisScript=$xWxis."actualizar.xis";
$query = "&base=purchaseorder&cipar=$db_path"."par/purchaseorder.par&login=".$_SESSION["login"]."&Mfn=".$arrHttp["Mfn_order"]."&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
include("../common/wxis_llamar.php");



//SHOW THE BUTTON FOR ADDING THE COPIES TO THE COPIES DATABASE
AddCopies();

echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";

function ReadPurchaseOrder(){	global $arrHttp,$msgstr,$db_path,$Wxis,$wxisUrl,$xWxis;
	$IsisScript=$xWxis."leer_mfnrange.xis";
	$query = "&base=purchaseorder&cipar=$db_path"."par/purchaseorder.par&from=".$arrHttp["Mfn_order"]."&to=".$arrHttp["Mfn_order"]."&Opcion=leer&Pft=(v50/)";
	include("../common/wxis_llamar.php");
	$ix=0;
	foreach($contenido as $value) {		$ix=$ix+1;
		$purchase_order[$ix]=trim($value);	}
	return $purchase_order;
}


function AddCopies(){	global $arrHttp,$msgstr,$CN;
	echo "<form name=forma1 action=copies_create.php method=post>\n";
	foreach ($arrHttp as $var=>$value){
		if (substr($var,0,3)!="tag"){
			echo "<input type=hidden name=$var value=\"$value\">\n";
		}
	}
	echo "<input type=hidden name=objectid value=$CN>\n";
	echo "<input type=submit value=\"".$msgstr["createcopies"]."\">\n";
	echo "</form>";
}

function NextControlNumber($base){
global $db_path;
	$archivo=$db_path.$base."/data/control_number.cn";
	if (!file_exists($archivo)){
		echo "<h2>Missign file $base/data/control_number.cn</h2>";
		return 0;
	}
	$perms=fileperms($archivo);
	if (is_writable($archivo)){
	//se protege el archivo con el número secuencial
		chmod($archivo,0555);
	// se lee el último número asignado y se le agrega 1
		$fp=file($archivo);
		$cn=implode("",$fp);
		$cn=$cn+1;
	// se remueve el archivo .bak y se renombre el archivo .cn a .bak
		if (file_exists($db_path.$base."/data/control_number.bak"))
			unlink($db_path.$base."/data/control_number.bak");
		$res=rename($archivo,$db_path.$base."/data/control_number.bak");
		chmod($db_path.$base."/data/control_number.bak",0666);
		$fp=fopen($archivo,"w");
	    fwrite($fp,$cn);
	    fclose($fp);
	    chmod($archivo,0666);
	    return $cn;
	}
}

function LeerFst($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr,$error;
// GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
	$archivo=$db_path.$base."/data/".$base.".fst";
	if (!file_exists($archivo)){
		echo "missing file ".$base."/data/".$base.".fst";
		die;
	}
	$fp=file($archivo);
	$tag_ctl="";
	$pref_ctl="CN_";
	foreach ($fp as $linea){
		$linea=trim($linea);
		$ix=strpos($linea,"\"CN_\"");
		if ($ix===false){
			$ix=strpos($linea,'|CN_|');
		}
		if ($ix===false){
		}else{
			$ix=strpos($linea," ");
			$tag_ctl=trim(substr($linea,0,$ix));
			break;
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl==""){
		$error="missingctl";
	}
}


?>