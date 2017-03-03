<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ('../config.php');
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;
$archivo=$arrHttp["archivo"];
$t=explode("\n",$arrHttp["ValorCapturado"]);
$fp=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$archivo,"w");
if (!$fp){	echo $arrHttp["base"]."/def/".$_SESSION["lang"]."/".$archivo." cannot be opened for writing";
	die;}

foreach ($t as $value){
	$val=trim(str_replace('|','',$value));
	if ($val=="00") $val="";
	if ($val!="") fwrite($fp,stripslashes($value)."\n");
	//echo "$value<br>";}
// IF THE FDT IS A FORMAT UPDATE THE FILE FORMATOS.DAT
if (isset($arrHttp["fmt_name"])){	if (file_exists(($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks"))){
		$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks");
	}else{
		if (file_exists(($db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks")))
			$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks");
	}
	$fex="N";
	if ($fp){
		foreach ($fp as $linea){
			$linea=trim($linea);
			if ($linea!=""){
				$l=explode('|',$linea);
				if (trim($l[0])==trim($arrHttp["fmt_name"]))
					$fex="S";
				$salida[]=$linea;
			}
		}
	}
	//IF IS A NEW FORMAT
	if ($fex=="N"){
		$fp=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks","w");
		if (!$fp){
			echo "the file could not be updated";
			die;
		}
		foreach ($salida as $arch) $res=fwrite($fp,$arch."\n");
		$res=fwrite($fp,$arrHttp["fmt_name"].'|'.$arrHttp["fmt_desc"]);
		fclose($fp); #close the file
	}
}
include("../common/header.php");
?>
<body>
<?php
$encabezado="";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
}
echo "
	<div class=\"sectionInfo\">

			<div class=\"breadcrumb\"><h5>".
				$msgstr["fdt"]." " .$msgstr["database"]. ": " . $arrHttp["base"]."</h5>
			</div>

			<div class=\"actions\">
	";
if (isset($arrHttp["encabezado"]))
		$encabezado="&encabezado=s";
else
	$encabezado="";
if (isset($arrHttp["Fixed_field"])) {	echo "<a href=fixed_marc.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">";}else{
	if (!isset($arrHttp["ventana"]))
		echo "<a href=menu_modificardb.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">";
	else
		echo "<a href=\"javascript:self.close()\" class=\"defaultButton backButton\">";
}
echo "
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
	</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
echo"
	<div class=\"middle form\">
		<div class=\"formContent\">";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: fdt_update.php";
echo "<br><br>
	 <p><h2>".$msgstr["fdtupdated"]."</h2>";
echo "
</div>
</div>";
include ("../common/footer.php");
?>
</body>
</html>
