<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");
$arrHttp["sort"]=stripslashes($arrHttp["sort"]);
//foreach ($arrHttp as $var=>$value) echo "$var=>$value<br>"; die;


if (!isset($_SESSION["login"])){	echo $msgstr["sessionexpired"];
	die;}
include("../common/header.php");


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//

include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
	<?php echo $msgstr["new_report"]?>
	</div>
	<div class="actions">
		<a href="menu.php" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reports.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: output_circulation/print_add_ex.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<?php
$list=array();
$bd=$arrHttp["base"];
if (file_exists($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst")){	$fp=file($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst");
	$ix=0;
	foreach ($fp as $value){		$value=trim($value);
		$list[]=$value;	}}

$fp=fopen($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst","w");
$arrHttp["code"]=strtoupper($arrHttp["code"]);
if (isset($arrHttp["heading"])){	$h=explode("\n",$arrHttp["heading"]);
	$arrHttp["heading"]="";
	foreach ($h as $head){		if ($arrHttp["heading"]==""){			$arrHttp["heading"]=trim($head);		}else{			$arrHttp["heading"].='#'.trim($head);		}	}}else{	$arrHttp["heading"]="";}
if (!isset($arrHttp["expresion"])) $arrHttp["expresion"]="";
$salida=$arrHttp["code"]."|".$arrHttp["pft"]."|".$arrHttp["heading"]."|";
if (isset($arrHttp["sort"])) $salida.=$arrHttp["sort"];
$salida.="|".$arrHttp["expresion"]."|".$arrHttp["title"];

if (isset($arrHttp["ask"])){
	$askfor=$arrHttp["ask"];
	$af=explode('_',$askfor);	$salida.="|".$af[0];
	switch ($af[0]){		case "DATE":
		case "DATEQUAL":
		case "DATELESS":
			$arrHttp["tag"]=$af[1];
			break;
		case "USERTYPE":
			$arrHttp["tag"]=70;
			break;
		case "ITEMTYPE":
			$arrHttp["tag"]=80;
			break;	}
	$salida.='|'.$arrHttp["tag"];}else
	$salida.="||";
foreach ($list as $value){   	if (substr($value,0,2)=="//"){   		fwrite($fp,$value."\n");
   	}else{		$t=explode("|",$value);
		if (strtoupper($t[0])==$arrHttp["code"]){			fwrite($fp,$salida."\n");
			$salida="";		}else{			fwrite($fp,$value."\n");		}   	}}
if ($salida!=""){	fwrite($fp,$salida."\n");}
fclose($fp);
echo "<h3>".$arrHttp["base"].": outputs.lst ".$msgstr["actualizados"]."</h3>";
?>
<p>
<p>
</div>
</div>
<?php
include("../common/footer.php");
?>
</body>
</html>
