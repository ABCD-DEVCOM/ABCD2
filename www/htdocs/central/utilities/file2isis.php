<?php
session_start();
set_time_limit(0);
include ("../config.php");
$db_path="e:/bases_abcd/alvaro/";
$base="folleteria";
function LlamarWxis($base,$ValorCapturado,$IsisScript,$query){
global $arrHttp,$xWxis,$wxisUrl,$OS,$db_path,$Wxis;
	include("../common/wxis_llamar.php");
	return ($contenido);
}
if ($_REQUEST["tipo"]=="bn"){	$IsisScript=$xWxis."leer_mfnrange.xis";
	$query = "&base=".$base ."&cipar=$db_path"."par/".$base.".par&from=1&to=1651&Pft=f(mfn,1,0)'|'v12/";
	$contenido=LlamarWxis($base,"",$IsisScript,$query);
	foreach ($contenido as $value) {
		$value=trim($value);
		if ($value!=""){			$value=trim($value);			$v=explode('|',$value);
			$folleto[$v[1]]=$v[0];		}	}}
//print('<xmp>');
//print_r($folleto);
//print('</xmp>');
$file=file("e:/bases_abcd/alvaro/folleteria/LISTADO FOLLETERIA ANH 03-12-2011.txt");
foreach ($file as $value){
	$value=trim($value);
	$v=explode("|",$value);
	$tit[$v[0]]=trim($v[1]);
}
//print('<xmp>');
//print_r($tit);
//print('</xmp>');die;
switch ($_REQUEST["tipo"]){	case "cl":
		$dir="e:/bases_abcd/alvaro/folleteria/pdf/cl";
		break;
	case "bn":
		$dir="e:/bases_abcd/alvaro/folleteria/pdf/bn";
		break;
}
$total_ne=0;
if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            //echo "<font color=darkred>$entry</font><br>";
            $size=filesize($dir.'/'.$entry);
            $ix=strpos($entry,".pdf");
            if (!$ix===false){
	            $title=substr($entry,0,$ix);
	            if (isset($tit[$entry])) {
	            	$title=$tit[$entry];
	            }else{
	            	echo "<p>".$entry."  no se encontró en la lista de títulos<br>";
	            }
	            switch ($_REQUEST["tipo"]){	            	case "cl":
	            		echo "<font color=darkblue>$entry (".$size.")</font><br>";
		            	$ValorCapturado="<4 0>M</4><6 0>m</6><12 0>$title</12>";
						$ValorCapturado.="<800 0>^a".$entry."^b".$size."</800>";
						$ValorCapturado=urlencode($ValorCapturado);
						$IsisScript=$xWxis."actualizar_proc.xis";
	  					$query = "&base=".$base ."&cipar=$db_path"."par/".$base.".par&login=abcd&Mfn=New&ValorCapturado=".$ValorCapturado;
						$contenido=LlamarWxis($base,$ValorCapturado,$IsisScript,$query);
						foreach ($contenido as $value) echo trim($value)."<br>";
						break;
					case "bn":
						$ValorCapturado="d810<810 0>^a".$entry."^b".$size."</810>";
						if (isset($folleto[$title])){
							$Mfn=$folleto[$title];
							$IsisScript=$xWxis."actualizar_proc.xis";
	  						$query = "&base=".$base ."&cipar=$db_path"."par/".$base.".par&login=abcd&Mfn=$Mfn&ValorCapturado=".$ValorCapturado;
							$contenido=LlamarWxis($base,$ValorCapturado,$IsisScript,$query);
							foreach ($contenido as $value) echo trim($value)."<br>";
							//echo "$value<br>";
						}else{							echo "$entry<br>$title ** No se encontró<P>";
							$total_ne=$total_ne+1;						}						break;
				}
			}
        }
    }
    echo "<p>No encontrados: $total_ne";
    closedir($handle);
}
?>
