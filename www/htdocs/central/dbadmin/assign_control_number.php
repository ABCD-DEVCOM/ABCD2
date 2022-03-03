<?php
/* Modifications
20210613 fho4abcd remove password, lineends
20211215 fho4abcd Backbutton by & helper by included file
20220203 fho4abcd Cleanup code&html+translation+make it work after reinvoke
20220303 rogercgui Corrected the absence of the variable in the function "EnviarFormaCN"
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
//
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (strpos($arrHttp["base"],"|")===false){

} else{

		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";
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
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/selectbox.js"></script>

<script language=javascript>

function BorrarRango(){
	document.cnFrm.Mfn.value=''
	document.cnFrm.to.value=''
}

function EnviarFormaCN(vp){
	de=Trim(document.cnFrm.Mfn.value)
  	a=Trim(document.cnFrm.to.value)
  	Maxmfn=<?php echo $tag["MAXMFN"];?>
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
<?php
echo "<center><h3>".$msgstr["assigncn"]."</h3></center>";
?>
    <form name=cnFrm method=post action=assign_control_number_ex.php onsubmit="Javascript:return false">
    <input type=hidden name=encabezado value=s>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
	<table width=100% cellpadding=5>
	<tr>
		<td colspan=2 align=center height=1 bgcolor=#eeeeee><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td  align=center colspan=2><strong><?php echo $msgstr["r_mfnr"]?></strong>: &nbsp; &nbsp; &nbsp;
		<?php echo $msgstr["r_desde"].": <input type=text name=Mfn size=10 value=";
		if (isset($arrHttp["from"]))
			echo $arrHttp["from"];
		else
			echo "1";
		echo ">&nbsp; &nbsp; &nbsp; &nbsp;";
		echo $msgstr["r_hasta"].": <input type=text name=to size=10 value='";
		if (isset($arrHttp["to"])){
			$count=$arrHttp["to"]-$arrHttp["from"]-1;
			$count= $arrHttp["to"]+$count-1;
			if ($count>$tag["MAXMFN"])
				echo $tag["MAXMFN"];
			else
				echo $count;
		}
		echo "'>";
		echo "&nbsp;".$msgstr["maxmfn"].": ".$tag["MAXMFN"]
		?>
		&nbsp; &nbsp; &nbsp; <a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a>
	</td>
	<tr>
		<td colspan=2 align=center>
        <input type=submit name=enviar value="<?php echo $msgstr["send"]?>" onClick="javascript:EnviarFormaCN()">
        <br><br>
        <?php
		echo $msgstr["lastcn"].": ".$last_cn."&nbsp; <a href=Javascript:Reset()>".$msgstr["resetcn"]."</a>";
        ?>
        </td>
    </tr>
</table>
</form>
</div>
</div>
<form name=reset_nc method=post action=reset_control_number.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=encabezado value=s>
</form>
<script>function Reset(){
	document.reset_nc.submit()
}
</script>
<?php
include("../common/footer.php");

//================= functions =============
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
?>
