<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include("../lang/soporte.php");
include ("../lang/dbadmin.php");





function LeerArchivos($Dir,$Ext){
// se leen los archivos con la extensión .pft
$the_array = Array();
$handle = opendir($Dir);
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file))
		   if (substr($file,strlen($file)-4,4)==".".$Ext) $the_array[]=$file;
   }
}
closedir($handle);
return $the_array;
}

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//



//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else {
	$encabezado="";
}

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
?>


<script>
Maxmfn=<?php echo $tag["MAXMFN"];?>;
</script>

<?php
//GET LAST CONTROL NUMBER
$archivo=$db_path.$arrHttp["base"]."/data/control_number.cn";
if (!file_exists($archivo)){
	$fp=fopen($archivo,"w");
	$res=fwrite($fp,"");
	fclose($fp);
}else{
	$fp=file($archivo);
	$last_cn=implode("",$fp);
}

include("../common/header.php");
?>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/selectbox.js"></script>

<script language="javascript">

function BorrarRango(){
	document.cnFrm.Mfn.value=''
	document.cnFrm.to.value=''
}

function EnviarFormaCN(vp){
	de=Trim(document.cnFrm.Mfn.value);
  	a=Trim(document.cnFrm.to.value);
  	Maxmfn=<?php echo $tag["MAXMFN"];?>;
  	if (de!="" || a!="") {
  		Se=""
		var strValidChars = "0123456789";
		blnResult=true
   	//  test strString consists of valid characters listed above
   		for (i = 0; i < de.length; i++){
    		strChar = de.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	for (i = 0; i < a.length; i++){
    		strChar = a.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	de=Number(de)
    	a=Number(a)
    	if (de<=0 || a<=0 || de>a ||a>Maxmfn){
	    	alert("<?php echo $msgstr["numfr"]?>")
	    	return
		}
	}
  	document.cnFrm.submit()
}

</script>

<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["assigncn"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php
	$ayuda="control_number.html";
	if (isset($arrHttp["encabezado"])){
		if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
            isset($_SESSION["permiso"]["CENTRAL_MODIFYDEF"]) or
            isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDEF"]) or
            isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])){
            $backtoscript="../dbadmin/menu_mantenimiento.php";
		}else{
            $backtoscript="../common/inicio.php";
		}
        include "../common/inc_back.php";	}
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>

<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
<div class="formContent">

	<h3><?php echo $msgstr["assigncn"];?></h3>

    <form name="cnFrm" method="post" action="assign_control_number_ex.php" onsubmit="Javascript:return false">
    <input type="hidden" name="encabezado" value="s">
    <input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
    <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]?>.par">

	<p><?php echo $msgstr["r_recsel"]?>

	<b><?php echo $msgstr["r_mfnr"]?>:</b></p>
	
	<label><?php echo $msgstr["r_desde"];?></label>
		<input type="text" name="Mfn" size="10" value="<?php if (isset($arrHttp["from"])) echo $arrHttp["from"]; else echo "1";?>"> 
	
<?php
	if (isset($arrHttp["to"])) { 
		$count=$arrHttp["to"]-$arrHttp["from"]-1; 
		$count= $arrHttp["to"]+$count-1; 
		$to=$count;
	if ($count>$tag["MAXMFN"]) {
		$to=$tag["MAXMFN"]; 
	} else {
		$to=$count;
		}
	} else {
		$to="";
	}
?>

	<label><?php echo $msgstr["r_hasta"];?></label>
		<input type="text" name="to" size="10" value="<?php echo $to;?>">
		
	<small><?php echo $msgstr["maxmfn"].": ".$tag["MAXMFN"];?></small>

	<div class="py-5">
		<a href="javascript:BorrarRango()" class="bt bt-default">
			<i class="fa fa-times"></i> <?php echo $msgstr["borrar"]?>
		</a>

        <button type="submit" class="bt-blue" onClick="javascript:EnviarFormaCN()" name=enviar>
			<i class="fa fa-step-forward"></i> <?php echo $msgstr["send"]?>
		</button> 
		
        <p><?php echo $msgstr["lastcn"].": ".$last_cn."&nbsp; <a href=Javascript:Reset()>".$msgstr["resetcn"];?></a></p>

	</div>
</form>
</div>
</div>

<form name="reset_nc" method="post" action="reset_control_number.php">
	<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
	<input type="hidden" name="encabezado" value="s">
</form>

<script>
function Reset(){
	document.reset_nc.submit()
}
</script>


<?php include("../common/footer.php"); ?>
