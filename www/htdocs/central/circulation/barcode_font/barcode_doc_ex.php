<?php
session_start();
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../config.php");

function LeerRegistro($base,$cipar,$from,$to,$Opcion,$Formato) {
global $xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db;

 	if (file_exists($db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato.".pft")){
 		$Formato=$db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path.$base."/pfts/".$lang_db."/" .$Formato;
    }

 	$IsisScript=$xWxis."leer_mfnrange.xis";
 	$query = "&base=$base&cipar=$db_path"."par/".$cipar. "&from=" . $from."&to=$to&Formato=$Formato";
	include("../common/wxis_llamar.php");
	return $contenido;
}

$base=$arrHttp["base"];
$parms=array();
if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab")){
	$fp=file($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab");
	foreach ($fp as $linea){
		$linea=trim($linea);
		$l=explode('=',$linea);
		$parms[$l[0]]=$l[1];
	}

}else{
	echo "<h1>Falta la tabla $base/def/".$_SESSION["lang"]."/barcode_label.tab</h1>";
	die;
}
$Formato=$parms["formato"];
$ix=stripos($Formato,".pft");
if ($ix!==false)
	$Formato=substr($Formato,0,$ix);
$desde=$arrHttp["desde"];
$hasta=$arrHttp["hasta"];

$filename="barcode_".$arrHttp["base"].".doc";
header('Content-Type: application/msword; charset=windows-1252');
header("Content-Disposition: attachment; filename=\"$filename\"");
Header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
echo "<style>
td{
	width:".$parms["width"]."cm;height:".$parms["height"]."cm;
}
</style>\n";
echo "<table  border=0 cellpadding=0 cellspacing=0>";
$cols=$parms["cols"];
$ixcol=$cols+2;
$ixrow=0;
$base=$arrHttp["base"];
$cipar=$base.".par";
$contenido=LeerRegistro($base,$cipar,$desde,$hasta,"leer",$Formato);
foreach ($contenido as $value){
	if (trim($value)!=""){
		if ($ixcol>=$cols){
			$ixcol=0;
			$ixrow=$ixrow+1;
			echo "<tr>\n";
		}
		echo "<td class=td align=center>";
		$bar=explode('|',$value);
		foreach ($bar as $b) echo $b."<br>";
		echo "</td>";
		$ixcol=$ixcol+1;
		if ($ixcol>=$cols){
			echo "</tr>\n";
		}
	}
}
?>
</table>
</body>

</html>