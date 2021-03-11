<?php
/* Modifications
20210311 fho4abcd Replaced helper code fragment by included file
20210311 fho4abcd html move body + sanitize html & javascript
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include("../lang/soporte.php");

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

$arrHttp["login"]=$_SESSION["login"];
$arrHttp["password"]=$_SESSION["password"];

$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";
//GET THE MAX MFN
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
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
include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>

<script language=javascript>

function BorrarRango(){
	document.forma1.Mfn.value=''
	document.forma1.to.value=''
}

function EnviarForma(vp){
	de=Trim(document.forma1.Mfn.value)
  	a=Trim(document.forma1.to.value)
  	if (de=="" && a=="") {
        alert ( "Please enter values");
        return
    }
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
    	if (de<=0 || a<=0 || de>a ||a><?php echo $tag["MAXMFN"] ?>){
	    	alert("<?php echo $msgstr["numfr"]?>")
	    	return
		}
	}

  	document.forma1.submit()
}

</script>
<?php
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php
if ($arrHttp["Opcion"]=="listar")
	echo $msgstr["mnt_rlb"];
else
	echo $msgstr["mnt_dr"];
echo ": ".$arrHttp["base"]?>
	</div>

	<div class="actions">
<?php
	$ayuda="";
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDEF"])  or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDEF"])){
		echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\" class=\"defaultButton cancelButton\">
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["cancelar"]."</strong></span></a>
		";
	}else{		echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["cancel"]."</strong></span></a>
		";	}
?>

</div>

<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"; ?>
<div align=center>
<div class="middle form">
	<div class="formContent">
<form name=forma1 method=post action=administrar_ex.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
?>
	<table width=600 cellpadding=5>
	<tr>
		<td colspan=2 align=center height=1 bgcolor=#eeeeee><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td  align=center colspan=2><strong><?php echo $msgstr["r_mfnr"]?></strong>: &nbsp; &nbsp; &nbsp;
		<?php echo $msgstr["r_desde"].": <input type=text name=Mfn size=10 value=";
		if (isset($arrHttp["to"]))
			echo $arrHttp["to"]+1;
		else
			echo "1";
		echo ">&nbsp; &nbsp; &nbsp; &nbsp;";
		echo $msgstr["r_hasta"].": <input type=text name=to size=10 value=\"";
		if (isset($arrHttp["to"])){
			$count=$arrHttp["to"]-$arrHttp["from"]+1;
			if (isset($arrHttp["to"]))
				$count= $arrHttp["to"]+$count;
			if ($count>$tag["MAXMFN"])
				echo $tag["MAXMFN"];
			else
				echo $count;
		}
		echo "\">";
		echo "&nbsp;".$msgstr["maxmfn"].": ".$tag["MAXMFN"];
		?>
		&nbsp; &nbsp; &nbsp; <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a>
	</td>
	<tr>
		<td colspan=2 align=center><input type=submit name=enviar value="<?php echo $msgstr["cg_execute"]?>" onClick=javascript:EnviarForma()></td>
</table>
</form>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>
</body>
</html>
