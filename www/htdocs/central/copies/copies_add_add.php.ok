<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;
include("../common/header.php");
echo "<body>\n";

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $arrHttp["base"].": ".$msgstr["createcopies"]?>
	</div>
	<div class="actions">
    	<a href="javascript:top.Menu('same')" class="defaultButton backButton">
				<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
				<span><strong><?php echo $msgstr["back"]?></strong></span>
			</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/copies_create.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/copies_create.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: copies_add_add.php</font>\n";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<?php
$arrHttp["Opcion"]="ver";
$arrHttp["database"]=$arrHttp["tag10"];
$arrHttp["objectid"]=$arrHttp["tag1"];
// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeración automática

LeerFst($arrHttp["database"]);

// Se lee la base de datos catalográfica para determinar si el objeto ha sido ingresado
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
	echo "\n<script>top.toolbarEnabled=\"\"</script>\n";
	die;
}

if (isset($arrHttp["copies"])) echo "<br>".$msgstr["copies_no"].": ".$arrHttp["copies"];

$Mfn="";
if (isset($arrHttp["tag30"])){	$inven=explode("\n",$arrHttp["tag30"]);
	unset($arrHttp["tag30"]);
	foreach ($inven as $cn) {		if (trim($cn)!="")
			CrearCopia(trim($cn),$max_inventory_length);	}}else{
	for ($ix=1;$ix<=$arrHttp["copies"];$ix++ ){
		echo "<hr>";		$cn=ProximoNumero("copies");   // GENERATE THE INVENTORY NUMBER
		CrearCopia($cn,$max_inventory_length);
	}
}
echo "<p>".$cont_database;

echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";
echo "\n<script>top.toolbarEnabled=\"\"</script>\n";

//=================================================================

function CrearCopia($cn,$max_inventory_length){
global $msgstr,$arrHttp,$xWxis,$Wxis,$wxisUrl,$db_path;
	$Mfn="" ;
	$cn=str_pad($cn, $max_inventory_length, '0', STR_PAD_LEFT);
	echo "<br>".$msgstr["createcopies"].": ";
	echo $msgstr["inventory"].": $cn";
	// Se verifica si ese número de inventario no existe
	$res=BuscarCopias($cn);
	if ($res>0){
		echo "<font color=red> &nbsp;".$msgstr["invdup"]."</font>";
	}else{
		$ValorCapturado="";
		foreach ($arrHttp as $var=>$value){
			if (substr($var,0,3)=="tag"){
				$tag=trim(substr($var,3));
				$ValorCapturado.="<".$tag." 0>".$value."</".$tag.">";
			}
		}
		$ValorCapturado.="<30 0>".$cn."</30>";
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

}

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

function BuscarCopias($inventario){
global $xWxis,$db_path,$wxisUrl,$Wxis;
	if ($inventario!=""){		$Prefijo="IN_".$inventario;	}else{		$Prefijo='ORDER_'.$order.'_'.$suggestion.'_'.$bidding;
	}
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
