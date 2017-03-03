<?php
global $arrHttp;
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");


//set_time_limit(120);

// se incluye la rutina que convierte los rótulos a tags isis
include ("rotulos2tags.php");

function GuardarArchivo($contenido){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$msgstr;
	switch ($arrHttp["tipo"]){		case "txt":
		default:
			$file=$db_path."wrk/".$arrHttp["archivo"];
			if ($arrHttp["tipo"]!="iso" or ($arrHttp["tipo"]=="iso" and isset($arrHttp["seleccionados"]))){
				$fp = fopen($file,"w");
				if (!$fp){
					echo "<center><br><br><h4><b><font color=red>$file</font></b> ".$msgstr["revisarpermisos"]."</h4></center>";
					die;
				}
				fwrite($fp,$contenido);
				fclose($fp);
			}
			echo "<center><br><br><h4>$file &nbsp;".$msgstr["okactualizado"];
			echo " &nbsp;<a href=javascript:Download()>Bajar</a>"."</h4></center>";
	}

}

function SubCampos($campo,$subc,$delim){
	$subc=rtrim($subc);
	$ixpos=0;
	for ($i=0;$i<strlen($subc);$i++){
		$sc=substr($subc,$i,1);
		$ed=substr($delim,$i,1);
		if ($i==0){
			if ($ed==" ")
				$campo='^'.$sc.$campo;
			else
				$campo=str_replace($ed,'^'.$sc,$campo);
				$campo=str_replace('^'.$sc." ",'^'.$sc,$campo);
		}else{
			$campo=str_replace($ed,'^'.$sc,$campo);
			$campo=str_replace('^'.$sc." ",'^'.$sc,$campo);
		}
	}
	return $campo;
}

//Se lee la tabla con la estructura de conversión de rótulos a tags isis
function LeerTablaCnv(){
Global $separador,$arrHttp,$db_path;
	$fp=file($db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"]);
	$ix=-1;
	$Pft="";
	foreach($fp as $value){
		if (substr($value,0,2)<>'//'){
			if ($ix==-1){
				$separador=trim($value);
				$ix=0;
			}else{
				$ix=$ix+1;
				$t=explode('|',$value);
				$t[1]=trim($t[1]);
				$t[0]=trim($t[0]);
//				$Pft.="if p(v".$t[1].") then '".$t[0]."' (v".$t[1]."/)/fi, \n";
				$rotulo[$t[1]][0]=$t[0];
				$rotulo[$t[1]][1]=$t[1];
				$rotulo[$t[1]][2]=$t[2];
				if (isset($t[3])) $rotulo[$t[1]][3]=$t[3];
				if (isset($t[4])) $rotulo[$t[1]][4]=$t[4];
				if (isset($t[5])) $rotulo[$t[1]][5]=$t[5];
				if (trim($t[5])==""){
				    if ($separador=="[TABS]"){
						$Pft.="if p(v".$t[1].") then (v".$t[1]."+|; |) fi,'|'";
					}else{						$Pft.="if p(v".$t[1].") then '".$t[0]."' (v".$t[1]."/)/fi,\n";					}
				}else{					if ($separador=="[TABS]"){
						$Pft.=$t[5]."'|'";
					}else{						$Pft.="'".$t[0]."' ".$t[5]."/";					}
				}
			}
		}
	}
	if ($separador=="[TABS]"){		$Pft.="/";	}else{
		$Pft.="'$separador'/#";
	}
//	echo $Pft;
	return $Pft;
}

function Exportar($Pft){
global $Wxis,$xWxis,$db_path,$arrHttp,$msgstr,$separador,$wxisUrl;
    $query = "&base=" . $arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["cipar"]."&Formato=".urlencode($Pft);
    if (isset($arrHttp["Mfn"]) and trim($arrHttp["Mfn"])!="") {
    	$query.="&Opcion=rango&Mfn=" . $arrHttp["Mfn"]."&to=".$arrHttp["to"];
    }else{
		if (isset($arrHttp["Expresion"]) and trim($arrHttp["Expresion"])!=""){			$query.="&Opcion=buscar&Expresion=";
		 	$query.= urlencode($arrHttp["Expresion"]);
		}else{
			$query.="&Opcion=seleccionados&Seleccionados=";
			$query.="&Mfn=".str_replace(",","&Mfn=",$arrHttp["seleccionados"]);
       }
    }
    if (isset($arrHttp["archivo"]) and $arrHttp["tipo"]=="iso") $query.="&archivo=".urlencode($db_path."wrk/".$arrHttp["archivo"]);
 	$contenido="";
 	$IsisScript=$xWxis."export_txt.xis";
 	include("../common/wxis_llamar.php");
 	if ($arrHttp["Accion"]=="P"){
 		foreach ($contenido as $value) echo "$value<br>";
 		die;
 	}
 	if ($arrHttp["Accion"]=="W" or $arrHttp["Accion"]=="S" ){        //and $arrHttp["tipo"]=="txt"
 		$salida="";
 		if ($arrHttp["Accion"]=="S"){
 			$nl=PHP_EOL;
 		}else{
 			$nl="<br>";
        }
 		foreach ($contenido as $value)  $salida.=$value.PHP_EOL;
 		if (trim($value)==$separador) $salida.=$nl.$nl;
 		return $salida;

 	}

}
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------


//foreach ($arrHttp as $var=>$value) echo "**$var=$value<br>";
if(!isset($arrHttp["tipo"])) $arrHttp["tipo"]="txt";
include("../common/header.php");
?>
<script>
function Download(){	document.download.submit()}


</script>
<?php
echo "
<body>
<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["cnv_export"]." ".$msgstr["cnv_".$arrHttp["tipo"]]."
	</div>
	<div class=\"actions\">";
if ($arrHttp["Accion"]!="P"){	echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>".$msgstr["regresar"]."</strong></span></a>";}
?>

	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/exportiso.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/exportiso.html target=_blank>".$msgstr["edhlp"]."</a>
		<font color=white>&nbsp; &nbsp; Script: dataentry/exporta_txt_ex.php</font>";

?>
	</div>

<div class="middle form">
			<div class="formContent">
<?php
if (isset($arrHttp["cnv"]) and trim($arrHttp["cnv"]) !="")
  	$Pft=LeerTablaCnv();
else
	$Pft="";

$data=Exportar($Pft);
if ($arrHttp["Accion"]=="S") {
	GuardarArchivo($data);
}
echo "</div></div>";
echo "<form name=download action=../utilities/download.php>
<input type=hidden name=archivo value=\"".$arrHttp["archivo"]."\">
</form>\n";
include("../common/footer.php");
?>
