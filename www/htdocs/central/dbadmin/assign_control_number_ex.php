<?php
/*
20220203 fho4abcd backbutton+div-helper
20220713 fho4abcd Use $actparfolder as location for .par files
*/
//ASSIGN CONTROL NUMBERS TO A DATABASE
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
set_time_limit(0);
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/acquisitions.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;
if (!isset($arrHttp["base"]) or $arrHttp["base"]==""){
	$arrHttp["base"]=$arrHttp["activa"];
}
$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["assigncn"].": ".$arrHttp["base"];?>
    </div>
	<div class="actions">
    <?php
    $ayuda="control_number.html";
    $backtoscript="assign_control_number.php";
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php

//GET THE MAX MFN
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$arrHttp["base"] . "&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&Opcion=status";
include("../common/wxis_llamar.php");
$ix=-1;
foreach($contenido as $linea) {
	$ix=$ix+1;
	if ($ix>0) {
		if (trim($linea)!=""){
	   		$a=explode(":",$linea);
	   		$tag[$a[0]]=$a[1];
	  	}
	}
}
LeerFdt($arrHttp["base"]);
$db_addto=$arrHttp["base"];
echo "<center><h3>".$msgstr["assigncn"]."</h3></center>";

//se lee la FDT de la base de datos para determinar el campo donde se almacena el número de control

$Formato=$tag_ctl;
if ($tag_ctl==""){
	echo "<h4>".$msgstr["missingctl"]."</h4>";
}else{
	echo "Tag for the control number: $tag_ctl<br>";
	?>
    <table>
	<tr><th>Mfn</th><th><?php echo $msgstr["cn"]?></th></tr>
    <?php
	for ($Mfn=$arrHttp["Mfn"];$Mfn<=$arrHttp["to"];$Mfn++){
		$control=ProximoNumero($arrHttp["base"]);
		$tag_ctl=trim($tag_ctl);
		$ValorCapturado="d".$tag_ctl."<".$tag_ctl." 0>".$control."</".$tag_ctl.">";
		$ValorCapturado=urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar.xis";
		$query = "&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&login=".$_SESSION["login"]."&Mfn=$Mfn&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
		include("../common/wxis_llamar.php");
		echo "<tr><td>$Mfn</td><td>$control</td>" ;
		//echo "<td>";
		//foreach ($contenido as $value) {
		//	if (trim($value)!="")
		//		echo "---$value<br>";
		//}
		//echo "</td>";
        echo "</tr>";
		flush();
    	ob_flush();
	}
    ?>
    </table>

	<form name="forma1" action="assign_control_number.php" method="post">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
		<input type="hidden" name="from" value="<?php echo $Mfn?>">
		<input type="hidden" name="to" value="<?php echo $Mfn+$arrHttp["to"]-$arrHttp["Mfn"]?>">
		<input type="hidden" name="encabezado" value="s">
    
		<?php if (($Mfn)<=$tag["MAXMFN"]){ ?>
			<input type="submit" class="bt-blue" name="go" value="<?php echo $msgstr["continuar"]?>">
    	<?php } ?>
	</form>
	<?php
}
?>
</div>
</div>

<?php
include "../common/footer.php";

// =================== Functions ==============================
function LeerFdt($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$msgstr;
// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeración automática y el prefijo con el cual se indiza el número de control

	$archivo=$db_path.$base."/def/".$_SESSION["lang"]."/".$base.".fdt";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$archivo=$db_path.$base."/def/".$lang_db."/".$base.".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$base."/".$base.".fdt";
		    die;
		 }
	}
	$tag_ctl="";
	$pref_ctl="";
	foreach ($fp as $linea){
		$l=explode('|',$linea);
		if ($l[0]=="AI" or $l[7]=="AI"){
			$tag_ctl=$l[1];
			if (trim($l[12])=="") $l[12]="NC_";  //if the prefix in not defined NC_ is assumed
			$pref_ctl=$l[12];
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
}


function ProximoNumero($base){
global $db_path,$max_cn_length;
	$archivo=$db_path.$base."/data/control_number.cn";
	if (!file_exists($archivo)){
		$fp=fopen($archivo,"w");
		$res=fwrite($fp,"");
		fclose($fp);
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
	    if (isset($max_cn_length)) $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
	    return $cn;
	}
}