<?php
// ==================================================================================================
// ENVIA LA SALIDA
// ==================================================================================================
//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
include ("../lang/acquisitions.php");

//VALORES QUE VIENEN DE LA PÁGINA
include("../common/get_post.php");
//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
switch ($arrHttp["Opcion"]){
	case "D":
    	$filename=$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "W":
		$filename=$arrHttp["base"].".xls";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	default:
		echo "<html>
		<font face=arial size=2>";
}
$titulo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tit"] ;
if (!file_exists($titulo))
	$titulo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["tit"] ;
if (file_exists($titulo)){
	$fp=file($titulo);
	$tit_tab=implode("",$fp);
}else{	$tit_tab=$arrHttp["missing"]. " ".$arrHttp["tit"];}
$Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["index"] ;
if (!file_exists($Formato))
	$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["index"] ;
$Formato="@$Formato,/";
$Expresion=$arrHttp["Expresion"];
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){	$value=trim($value);
	if ($value!="")	{
		$ix=$ix+1;
		$s=explode('|',$value);
		$key=$s[0].$ix;
		$recom[$key]=$value;
	}



}

ksort($recom);
echo "<table class=listTable cellspacing=0 border=1>";
echo "<th>&nbsp;</th>";
	$t=explode('|',$tit_tab);
	foreach ($t as $v)  echo "<th>".$v."</th>";

	foreach ($recom as $value){
		echo "\n<tr>";
		$r=explode('|',$value);
		$ix1="";
		foreach ($r as $cell){
			if ($ix1=="")
				$ix1=1;
			else
				if ($ix1==1){
					echo "<td>&nbsp;</td>";
					$ix1=2;
				}else
	 				echo "<td>$cell</td>";
		}

	}
echo "</table>";
echo "</body></html>"
?>