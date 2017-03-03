<?php
//
// Crea en la base de datos copias los ítems procedentes de una orden de compra
// INSERT IN COPIES DATABASE THE ITEMS RECEIVED FROM A PURCHASE ORDER
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
		<?php echo $msgstr["purchase"].": ".$msgstr["createcopies"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/copies_create.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/copies_create.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: copies_create.php</font>\n";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php

// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeración automática
$archivo=$db_path.$arrHttp["database"]."/def/".$_SESSION["lang"]."/".$arrHttp["database"].".fdt";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	$archivo=$db_path.$arrHttp["database"]."/def/".$lang_db."/".$arrHttp["database"].".fdt";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		echo "missing file ".$arrHttp["database"]."/".$arrHttp["database"].".fdt";
	    die;
	 }
}
$tag_ctl="";
foreach ($fp as $linea){
	$l=explode('|',$linea);
	if ($l[0]=="AI"){
		$tag_ctl=$l[1];
		$pref_ctl="CN_";
	}
}
//ERROR IF THE CONTROL NUMBER IS NOT DEFINED IN THE FDT
if ($tag_ctl=="" or $pref_ctl==""){
	echo "<h2>".$msgstr["missingctl"]."</h2>";
	die;
}

//GET AND DISPLEY THE OBJECT FROM THE BIBLIOGRAPHIC DATABASE
$Formato=$db_path.$arrHttp["database"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["database"].".pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["database"]."/pfts/".$lang_db."/".$arrHttp["database"].".pft" ;
$Formato="@$Formato,/";
$Expresion="$pref_ctl".$arrHttp["objectid"];
$query = "&base=".$arrHttp["database"]."&cipar=$db_path"."par/".$arrHttp["database"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$cont_database=implode('',$contenido);
if (trim($cont_database)=="") {
	echo "<h4>".$arrHttp["objectid"].": ".$msgstr["objnoex"]."</h4>";
	die;
}
echo $cont_database;
//DISPLAY THE DATA OF THE PURCHASE ORDER AND ITEM TO BE CREATED
echo "<h3>".$msgstr["order"].": ".$arrHttp["order"];
echo "<br>".$msgstr["copies_no"].": ".$arrHttp["copies_req"];
echo "<br>".$msgstr["price"].": ".$arrHttp["price"];
echo "<br>".$msgstr["copiesrec"].": ".$arrHttp["received"];
if (isset($arrHttp["suggestion"])) echo "<br>".$msgstr["suggestions"].": ".$arrHttp["suggestion"];
if (isset($arrHttp["bidding"])) echo "<br>".$msgstr["bidding"].": ".$arrHttp["bidding"];
echo "<br>".$msgstr["database"].": ".$arrHttp["database"];
echo "<br>".$msgstr["date_receival"].": ".$arrHttp["date"];
echo "</h3>";

// Se verifica si esa orden de compra-recomendación-cotización ya ha sido actrualizada
//$res=BuscarCopias($arrHttp["database"],$arrHttp["order"],$arrHttp["suggestion"],$arrHttp["bidding"]);
$res=0;
if ($res==0){   // si no existen las copias, se crean
//READ THE TABLE WITH THE STATUS OF THE COPIES TO ASSIGN THE STATUS 0
	$ix=strpos($arrHttp["provider"],"^");
	if ($ix>0) $arrHttp["provider"]=substr($arrHttp["provider"],0,$ix);
	$status=$db_path."copies/def/".$_SESSION["lang"]."/status_copy.tab";
	if (!file_exists($status)) $status=$db_path."copies/def/".$lang_db."/status_copy.tab";
	$fp=file($status);
	$ix=0;
	$st="^a0";
	foreach ($fp as $stats){		$stats=trim($stats);
		if ($stats!=""){			if ($ix==0) {
				$stats=explode('|',$stats);				$st='^a'.$stats[0].'^b'.$stats[1];
				break;			}		}
    }
	$Mfn="";
	for ($ix=1;$ix<=$arrHttp["received"];$ix++ ){
		echo "<hr>";		$cn=ProximoNumero("copies");
		echo "<p>".$msgstr["createcopies"].": $ix";
		echo "<br>".$msgstr["inventory"].": $cn";
		$ValorCapturado="<1 0>" .$arrHttp["objectid"]."</1>"; 												//CONTROL NUMBER
		$ValorCapturado.="<10 0>" .$arrHttp["database"]."</10>";											//DATABASE
		$ValorCapturado.="<30 0>" .$cn."</30>";                												//INVENTORY NUMBER
//		$ValorCapturado.="\n0035"  																			//MAIN LIBRARY
//		$ValorCapturado.="\n0040"                           												//BRANCH LIBRARY
		if (isset($arrHttp["tome"]))        $ValorCapturado.="<50 0>" .$arrHttp["tome"]."</50>";      		//TOME
		if (isset($arrHttp["volume"]))      $ValorCapturado.="<60 0>" .$arrHttp["volume"]."</60>";			//VOLUME/PART
//		$ValorCapturado.="\n0063"                             	//COPY NUMBER
		if (isset($arrHttp["acqtype"]))     $ValorCapturado.="<68 0>" .$arrHttp["acqtype"]."</68>";			//ACQUISITION TYPE
		if (isset($arrHttp["provider"]))    $ValorCapturado.="<70 0>" .$arrHttp["provider"]."</70>";		//PROVIDER
		if (isset($arrHttp["date"]))        $ValorCapturado.="<80 0>" .$arrHttp["date"]."</80>";      		//DATE OF ARRIVAL
		if (isset($arrHttp["isodate"]))     $ValorCapturado.="<85 0>" .$arrHttp["isodate"]."</85>";   		//ISO DATE OF ARRIVAL
		if (isset($arrHttp["price"]))       $ValorCapturado.="<90 0>" .$arrHttp["price"]."</90>";     		//PRICE
		if (isset($arrHttp["order"]))       $ValorCapturado.="<100 0>" .$arrHttp["order"]."</100>";       	//ORDEN NUMBER
		if (isset($arrHttp["suggestion"]))  $ValorCapturado.="<110 0>" .$arrHttp["suggestion"]."</110>";  	//SUGGESTION NUMBER
		if (isset($arrHttp["bidding"]))     $ValorCapturado.="<120 0>" .$arrHttp["bidding"]."</120>";     	//BIDDING NUMBER
		$ValorCapturado.="<200 0>".$st."</200>";                    	                                 	//STATUS: PRECATALOGUING
		if (isset($arrHttp["institucion"])) $ValorCapturado.="<70 0>" .$arrHttp["institucion"]."</70>"; 	//INSTITUTION (EXCHANGE OR DONATION)
		if (isset($arrHttp["condiciones"])) $ValorCapturado.="<300 0>" .$arrHttp["condiciones"]."</300>"; 	//CONDITIONS (EXCHANGE OR DONATION)
		if (isset($arrHttp["canjeadopor"])) $ValorCapturado.="<400 0>" .$arrHttp["canjeadopor"]."</400>";	//INSTITUTION (EXCHANGE OR DONATION)
		$ValorCapturado=urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar.xis";
		$query = "&base=copies&cipar=$db_path"."par/copies.par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea){
			if (substr($linea,0,4)=="MFN:") {
				echo " &nbsp; Mfn: <a href=../dataentry/show.php?base=copies&Mfn=".trim(substr($linea,4))." target=_blank>".trim(substr($linea,4))."</a>";
	    		$Mfn.=trim(substr($linea,4))."|";
			}else{
				if (trim($linea!="")) echo $linea."\n";
			}
		}
	}
	echo "<hr>";
}else{
// ya se cargó esa orden de compra - recomendacion-cotización en la base de datos
	$Expresion='ORDER_'.$arrHttp["order"].'_'.$arrHttp["suggestion"].'_'.$arrHttp["bidding"];
	echo "<h3>".$msgstr["orderloaded"]." ($res) &nbsp; <a href=../dataentry/show.php?base=copies&Expresion=$Expresion target=_blank>".$msgstr["search"]."</a></h3>";}
echo "<p><a href=receive_order_ex.php?searchExpr=".$arrHttp["order"]."&base=purchaseorder&date=".$arrHttp["date"]."&isodate=".$arrHttp["isodate"];
echo ">purchase order</a>";

echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";

//UPDATE PURCHASE ORDER WITH THE COPIES RECEIVED
PurchaseOrderUpdate();


//=================================================================

function ProximoNumero($base){
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

function BuscarCopias($database,$order,$suggestion,$bidding){
global $xWxis,$db_path,$wxisUrl,$Wxis;	$Prefijo='ORDER_'.$order.'_'.$suggestion.'_'.$bidding;
	$IsisScript= $xWxis."ifp.xis";
	$query = "&base=copies&cipar=$db_path"."par/copies.par&Opcion=diccionario&prefijo=$Prefijo&campo=1";
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
	return 0;}


function PurchaseOrderUpdate(){
global $arrHttp,$xWxis,$Wxis,$wxisUrl,$db_path;
	$Db="purchaseorder";
	$Expresion="ON_".$arrHttp["order"] ;
	$formato="(v50/)";
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=$Db&cipar=$db_path"."par/$Db.par&Expresion=".$Expresion."&count=1&from=1&Pft=$formato";
	include("../common/wxis_llamar.php");
	$order=array();
	$ix=0;
    foreach ($contenido as $value){
    	$value=trim($value);
    	if ($value!=""){
    		if (substr($value,0,1)!="[")   $order[]=$value;
    	}
    }
    $ValorCapturado="";
    $Eliminar="";
    foreach ($order as $value){    	$ix=$ix+1;
    	if (trim($value)!=""){
	    	if ($ix==$arrHttp["occ"]){
	    		$ix1=strpos($value,"^f");
	    		if ($ix1===false){
	    			$value.="^f".$arrHttp["received"];
	    		}else{    				$p=explode('^',$value);
    				$value="";
    				foreach ($p as $sc){    					$delim=substr($sc,0,1);
    					$subc=substr($sc,1);
    					if ($delim=="f"){    						$subc=(int)$subc + (int)$arrHttp["received"];    					}
    					$value.='^'.$delim.$subc;    				}
	    		}
	    	}
	    	if ($ValorCapturado==""){
	    		$Eliminar="d50";
	   		}
    		$ValorCapturado.="<50 0>".$value."</50>";
	   }
    }
    $ValorCapturado=$Eliminar.$ValorCapturado;
    $arrHttp["Mfn"]=$arrHttp["Mfn_order"];
    $IsisScript=$xWxis."actualizar.xis";
  	$query = "&base=".$Db ."&cipar=$db_path"."par/".$Db.".par&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
}

?>
