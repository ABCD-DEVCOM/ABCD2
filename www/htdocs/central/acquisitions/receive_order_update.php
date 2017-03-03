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
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;

include ('../dataentry/leerregistroisis.php');

include("../common/header.php");
?>
<script>
function Call_Z3950(){	msgwin=window.open("../dataentry/z3950.php?desde=acquisitions","","width=700, height=600, resizable, scrollbars")
	magwin.focus()}
</script>
<?
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["receiving"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/receive_order_update.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/receive_order_update.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: receive_order_update.php</font>\n";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php

$arrHttp["postings"]=0;
//IF IS NOT A NEW OBJECT, SEARCH IT IN THE DATABASE AND DISPLAY THE RECORD
if (isset($arrHttp["objectid"]) and trim($arrHttp["objectid"])!=""){
	$Formato=$db_path.$arrHttp["database"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["database"].".pft" ;
	if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["database"]."/pfts/".$lang_db."/".$arrHttp["database"].".pft" ;
	$Formato="@$Formato,/";
	$Expresion="CN_".$arrHttp["objectid"];
	$query = "&base=".$arrHttp["database"]."&cipar=$db_path"."par/".$arrHttp["database"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
	$IsisScript=$xWxis."imprime.xis";
	include("../common/wxis_llamar.php");
//	foreach ($contenido as $value) echo "==$value<br>";
	$cont_database=implode('',$contenido);
	if (trim($cont_database)!="") $arrHttp["postings"]=1;
}


// IF IS A NEW OBJETCT RECOLECT DATA FOR CREATING A RECORD IN THE BIBLIOGRAPHIC DATABASE
if ($arrHttp["typeofobj"]=="N"){   // si el objeto es nuevo y el número de objeto no existe en la base de datos
    echo "<h4>".$msgstr["newobject"].". ".$msgstr["database"].": ".$arrHttp["database"]."<BR>";
	echo $msgstr["precatal"]."</h4>";
	echo "<form name=catalog method=post action=object_create.php onsubmit='return false'>\n";
//IF THE PURCHASE ORDER WAS GENERATED FROM A SUGGESTIONS, GET THE SUGGESTION FOR RECOLECTING THE PRE-CATALOGATION
	$valortag=array();
	if (isset($arrHttp["suggestion"])){
		$res=EjecutarBusqueda("CN_".$arrHttp["suggestion"],"suggestions");     // se localiza la recomendación para sacar los datos de pre-catalogacion
		if ($res==0){
			echo "<h4>".$msgstr["suggestions"].": ".$arrHttp["suggestion"]." ".$msgstr["notfound"]."</h4>";
			die;
		}
	}else{
//IF THERE IS NO SUGGESTION GET THE DATA FROM THE PURCHASEORDER DATABASE        $res=EjecutarBusqueda("ON_".$arrHttp["order"],"purchaseorder");     // se localiza la recomendación para sacar los datos de pre-catalogacion
		if ($res==0){
			echo "<h4>".$msgstr["purchaseorder"].": ".$arrHttp["suggestion"]." ".$msgstr["notfound"]."</h4>";
			die;
		}	}
	foreach  ($valortag as $tag=>$value){
		echo "<input type=hidden name=tag$tag value=\"$value\">\n";
		echo "$tag=$value<br>";
	}
	foreach ($arrHttp as $var=>$value){		echo "<input type=hidden name=$var value=\"$value\">\n";	}
   	echo "<p><input type=submit value=' &nbsp; &nbsp; &nbsp; ".$msgstr["create"]." &nbsp; &nbsp; &nbsp; ' onclick=document.catalog.submit()> &nbsp; &nbsp; &nbsp;
   	   <!-- <input type=submit value=' &nbsp; &nbsp; &nbsp; Z39.50 &nbsp; &nbsp; &nbsp; ' onclick=javascript:Call_Z3950()>-->
   		</form>" ;
}

//NEW COPIES TO AN EXISTENT OBJECTS. SHOW THE RECORD
if ($arrHttp["typeofobj"]=="C"){	if ($arrHttp["postings"]==0){
		echo "<h4>".$arrHttp["objectid"].": ".$msgstr["objectexist"];
		echo "</h4>";
	}else{
		echo $cont_database;
//		echo " &nbsp; <a href=show.php?base=".$arrHttp["database"]."&Expresion=CN_".$arrHttp["objectid"]." target=_blank>"."<img src=../images/zoom.png></a>";

		echo "\n<form name=copies method=post action=copies_create.php>\n";
		foreach ($arrHttp as $var=>$value){
			echo "<input type=hidden name=$var value=\"$value\">\n";
		}
 		echo "<input type=submit value=' &nbsp; &nbsp; &nbsp; ".$msgstr["createcopies"]." &nbsp; &nbsp; &nbsp; '>
    	</form>" ;
    }

}


echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";

// --------------------------------------------------------------------------------


function EjecutarBusqueda($Expresion,$Db){
global $arrHttp,$db_path,$xWxis,$Wxis,$valortag,$tl,$nr,$Mfn,$wxisUrl,$lang_db,$msgstr;
    $formato=$db_path.$arrHttp["database"]."/pfts/".$_SESSION["lang"]."/acquisitions.pft";
    if (!file_exists($formato)) $formato=$db_path.$arrHttp["database"]."/pfts/".$lang_db."/acquisitions.pft";
    if (!file_exists($formato)){
    	echo $msgstr["missacqpft"]." ".$arrHttp["database"];
    	die;
    }
	$Expresion=urlencode(trim($Expresion));
//	$Expresion=str_replace("\'","'",$Expresion);
	$contenido="";
	$registro="";
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=$Db&cipar=$db_path"."par/$Db.par&Expresion=".$Expresion."&count=1&from=1&Formato=$formato";
	include("../common/wxis_llamar.php");

	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!="") {
			if (substr($linea,0,6)=="[MFN:]"){
				$arrHttp["Mfn"]=trim(substr($linea,6));
			}else{
				if (substr($linea,0,8)=="[TOTAL:]"){
					$total=trim(substr($linea,8));
					if($total==0){
						echo "Total: 0";
						return $total;
						die;
					}
				}else{
					$registro.=$linea."\n";
				}
			}
		}
	}
	$contenido=explode("\n",$registro);
	$valortag=array();
	foreach($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			$pos=strpos($linea, ":");
   			if (is_integer($pos)) {
   				$tag=trim(substr($linea,0,$pos));
   				$end=strlen($linea)-$pos+1;
   				$linea=rtrim(substr($linea, $pos+1,strlen($linea)));
 				if (!isset($valortag[$tag])){
 					$valortag[$tag]=$linea;
 				}else {
 					$valortag[$tag]=$valortag[$tag]."\n".$linea;
 				}
			}
		}
	}
	return $total;
}

function ProximoNumero($base){
global $db_path;	$archivo=$db_path.$base."/data/control_number.cn";
	if (!file_exists($archivo)){		echo "<h2>Missing file $base/data/control_number.cn</h2>";
		return 0;	}
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
	    return $cn;	}
}


?>
