<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

$lang=$_SESSION["lang"];


function CrearFdt($Fdt_w){
global $arrHttp,$msgstr;
$fdt=array();
$ix=0;
$salida="";
$fdt=explode("\n",$Fdt_w);
foreach ($fdt as $value){
	if (trim($value)=="***") $ix=1;
	if ($ix>1){
		if (trim($value)!=""){
			$nc=trim(substr($value,0,30));
			$subc=trim(substr($value,30,20));
			$value=trim(substr($value,50));
			$t=explode(' ',$value);
			$tag=trim($t[0]);
			$rep=trim($t[3]);
			$repetible="";
			if ($rep=="1")  $repetible="yes";
			$salida.="F|$tag|$nc|0|$rep|$subc||||||||\n";
		}
	}else{
	    if ($ix==1) $ix=2;
	}

}
return $salida;
}

function MostrarFdt($Fdt_w){
global $arrHttp,$msgstr;
	echo "<p><dd>".$msgstr["subir"]." ".$arrHttp["base"].".fdt"."</span>";
	echo "<p><dd><table bgcolor=#cccccc>
	<td width=50 bgcolor=white>Tag</td><td nowrap width=200 bgcolor=white>Description</td><td width=50 nowrap bgcolor=white>Subfields</td><td width=10 bgcolor=white>Repetible</td>";
	$fdt=explode("\n",$Fdt_w);
	foreach ($fdt as $value){
		if (trim($value)!=""){
			$f=explode('|',$value);
			$repetible="";
			if (isset($f[4]) and $f[4]=="1")  $repetible="yes";
			echo "<tr><td  bgcolor=white nowrap>".$f[1]."</td><td  bgcolor=white nowrap>".$f[2]."</td><td  bgcolor=white nowrap>";
			if (isset($f[5])) echo $f[5];
			echo "</td><td  bgcolor=white nowrap>".$repetible."</td>";
		}
	}
	echo "</table>";
	echo "<h3><dd>" .$arrHttp["base"].".fdt Converted</h3>";
}




//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

include("../common/header.php");
if (isset($arrHttp["encabezado"]))
	include("../common/institutional_info.php");
echo "<script  src=\"../dataentry/js/lr_trim.js\"></script>\n";
echo "<script languaje=javascript>
function EnviarForma(){
	if (Trim(document.winisis.userfile.value)==''){
		alert('".$msgstr["missing"]." ".$msgstr["fst"]."')
		return
	}
	ext=document.winisis.userfile.value
	e=ext.split(\".\")
	if (e.length==1 || e[1].toUpperCase()!=\"FST\"){
		alert('".$msgstr["missing"]." ".$msgstr["fst"]."')
		return
	}
	document.winisis.submit()
}
</script>";
echo "
	<div class=\"sectionInfo\">

			<div class=\"breadcrumb\"><h5>".
				$msgstr["winisisdb"].": " . $arrHttp["base"]."</h5>
			</div>

			<div class=\"actions\">
	";
if (isset($arrHttp["encabezado"]))
		$encabezado="&encabezado=s";
	else
		$encabezado="";
echo "<a href=winisis.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"]).$encabezado." class=\"defaultButton backButton\">";
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/winisis_upload_fdt.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/winisis_upload_fdt.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: winisis_upload_fdt.php</font></div>";

echo "
<div class=\"middle form\">
			<div class=\"formContent\">";
$files = $_FILES;
if ($files["userfile"]['size']) {
      // clean up file name
	$name=$files["userfile"]['name'];
   	$name = ereg_replace("[^a-z0-9._]", "",
    str_replace(" ", "_",
       	str_replace("%20", "_", strtolower($name)
					)
      			)
        );
	$fp=file($files["userfile"]['tmp_name']);
	$Fdt="";
 	foreach($fp as $linea) $Fdt.=$linea;
  	$Fdt_conv=CrearFdt($Fdt);
   	$_SESSION["FDT"]=$Fdt_conv;
    MostrarFdt($_SESSION["FDT"]);
}else{	if (isset($_SESSION["FDT"])) MostrarFdt($_SESSION["FDT"]);}
$_SESSION["DESC"]=$arrHttp["desc"];
unset ($_SESSION["FST"]);
unset ($_SESSION["PFT"]);


echo "
<form action=winisis_upload_fst.php method=POST enctype=multipart/form-data name=winisis onsubmit='javascript:EnviarForma();return false'>
<input type=hidden name=Opcion value=FDT>
<input type=hidden name=base value=".$arrHttp["base"].">
<input type=hidden name=desc value=\"".$arrHttp["desc"]."\"> ";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
echo "<dd><table bgcolor=#eeeeee>
<tr>
<tr><td class=title>".$msgstr["subir"]." ".$arrHttp["base"]. ".fst</td>

<tr><td><input name=userfile type=file size=50></td><td></td>
<tr><td>  <input type=submit value='".$msgstr["subir"]."'></td>
</table></dd>
<p>
</form>";
echo "<dd><a href=menu_creardb.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["cancel"]."</a> &nbsp; &nbsp;
	<a href=winisis.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"]);
	if (isset($arrHttp["encabezado"]))echo "&encabezado=s";
	echo ">".$msgstr["back"]."</a> &nbsp; &nbsp; &nbsp; &nbsp;
	</dd>";
	echo "</div></div>\n";
	include("../common/footer.php");
?>
