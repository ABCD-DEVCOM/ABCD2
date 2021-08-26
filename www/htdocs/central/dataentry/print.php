<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include ("../lang/admin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>"; //die;
$data="";
if (isset($arrHttp["Expresion"])){
	$arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
	if (strpos('"',$arrHttp["Expresion"])==0) {
    	$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
	}
	$Expresion=urlencode($arrHttp["Expresion"]);
}
if (isset($arrHttp["pft"])) $arrHttp["pft"]=stripslashes($arrHttp["pft"]);


if (isset($arrHttp["pft"]) and trim($arrHttp["pft"])!=""){
	$Formato=urlencode($arrHttp["pft"]);
}else{
	if (isset($arrHttp["fgen"]) and $arrHttp["fgen"]!="") {
		$pft_name=explode('|',trim($arrHttp["fgen"]));
		$arrHttp["fgen"]=$pft_name[0];
		if (isset($pft_name[1]))
			$arrHttp["tipof"]=trim($pft_name[1]);
		else
			$arrHttp["tipof"]="";
		if (strpos($arrHttp["fgen"],'.pft')===false) $arrHttp["fgen"].=".pft";
	    $Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["fgen"];
	    if (!file_exists($Formato)){
	    	$Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["fgen"];
	    }
	    if (file_exists($Formato)) $Formato="@".$Formato;
// READ THE HEADINGS, IF ANY
	    if ($arrHttp["tipof"]!=""){
	    	$head=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/tbtit.tab";
	    	if (!file_exists($head)){
	    		$head=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/tbtit.tab";
	    	}
	    	if (file_exists($head)){
	    		$fp=file($head);
	    		$arrHttp["headings"]="";
	    		foreach ($fp as $value) {
	    			$arrHttp["headings"].=trim($value)."\r";
	    		}
	    	}
	    }
	}
}

if (isset($arrHttp["Expresion"])) {
    $Opcion="buscar";
}else{
	$Opcion="rango";
}
if (isset($arrHttp["seleccionados"]))
	$Opcion="seleccionados";

if (isset($arrHttp["guardarformato"])){
   	$fp=fopen($db_path.$arrHttp["base"]."/".$arrHttp["Dir"]."/".$arrHttp["nombre"],"w",0);
   	fputs($fp, $arrHttp["pft"]); #write all of $data to our opened file
 		fclose($fp); #close the file
 		$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/listados.gen","a",0);

   	fputs($fp, "\n".$arrHttp["nombre"]." ".$arrHttp["descripcion"]); #write all of $data to our opened file
 		fclose($fp); #close the file

}

$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"];
if (isset($Expresion)) $query.="&Expresion=".$Expresion;
$query.="&Opcion=$Opcion&Word=S&Formato=".$Formato;
if (isset($arrHttp["seleccionados"])){
	$seleccion="";
	$mfn_sel=explode(',',$arrHttp["seleccionados"]);
	foreach ($mfn_sel as $sel){
		if ($seleccion==""){
			$seleccion="'$sel'";
		}else{
			$seleccion.="/,'$sel'";
		}
	}
	$query.="&Mfn=$seleccion";
}else
	if (isset($arrHttm["Mfn"]) and isset($arrHttp["to"]))
		$query.="&from=".$arrHttp["Mfn"]."&to=".$arrHttp["to"];
if (!isset($arrHttp["sortkey"])){
	$IsisScript=$xWxis."imprime.xis";

}else{
	$query.='&sortkey='.urlencode($arrHttp["sortkey"]).",";
	$IsisScript=$xWxis."sort.xis";
}
include("../common/wxis_llamar.php");
//foreach ($contenido as $value) echo "$value<br>";
?>
<style type="text/css">
	html	{
	font-family: Arial, Helvetica, sans-serif;
	background-color: #FFFFFF; 
	margin: 0px;  /* this affects the margin on the html before sending to printer */
	}

	body	{
	margin: 10mm 15mm 10mm 10mm; /* margin you want for the content */
	padding: 0.5mm;
	}

	.print {
	border-collapse: collapse;
	width: 100%;
	}

	.print td, .print th {
	border: 1px solid #ddd;
	padding: 8px;
	}

	.print tr:nth-child(even){background-color: #f2f2f2;}

	.print tr:hover {background-color: #ddd;}

	.print th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #708bb1;
	color: #000;
	}

	@page {
	size:  auto;   /* auto is the initial value */
	margin: 0mm;  /* this affects the margin in the printer settings */
	}


</style>


<script type="text/javascript">
	window.onload = function() { window.print(); }
</script>



<?php
$ficha=$contenido;
if (isset($arrHttp["tipof"])){
	switch ($arrHttp["tipof"]){              //TYPE OF FORMAT
		case "T":  //TABLE
			break;
		case "P":  //PARRAGRAPH
			break;
		case "CT": //COLUMNS (TABLE)
			$data='<table class="print"><tr>';
			if (isset($arrHttp["headings"])){
				$h=explode("|",$arrHttp["headings"]);
				foreach ($h as $value){
					$data.="<th>$value</th>";
				}
				$data.="</tr>";
			}
			break;
		case "CD":
			if (isset($arrHttp["headings"])){
				$h=explode("\r",$arrHttp["headings"]);
				foreach ($h as $value){
					if (trim($value)!=""){
						if ($data==""){
							$data=$value;
						}else{
							$data.="|$value";
						}
	               }
				}
				$data.="\n";
			}
			break;
	}
}


foreach ($ficha as $linea){
	if (substr($linea,0,6)=='$$REF:'){
	 			$ref=substr($linea,6);

	 			$f=explode(",",$ref);
	 			$bd_ref=trim($f[0]);
	 			$pft_ref=trim($f[1]);
	 			$expr_ref=trim($f[2]);
	 			if (file_exists($db_path.$bd_ref."/pfts/".$_SESSION["lang"]."/" .$pft_ref.".pft")){
 					$pft_ref=$db_path.$bd_ref."/pfts/".$_SESSION["lang"]."/" .$pft_ref;
 				}else{
 					$pft_ref=$db_path.$bd_ref."/pfts/".$lang_db."/" .$pft_ref;
        		}
	 			$IsisScript=$xWxis."imprime.xis";
 				$query = "&cipar=$db_path"."par/".$bd_ref. ".par&count=9999&Expresion=".$expr_ref."&Opcion=buscar&base=" .$bd_ref."&Formato=@$pft_ref.pft";
				include("../common/wxis_llamar.php");
				$ixcuenta=0;
				
				foreach($contenido as $linea_alt){
										
					if (trim($linea_alt)!=""){
						$ll=explode('|^',$linea_alt);

						if (isset($ll[1])){
							$ixcuenta=$ixcuenta+1;
							$SS[trim($ll[1])."-$ixcuenta"]=$ll[0];

						}else{

							$data.= "$linea_alt\n";

						}

					}
				}

				if (isset($SS) and count($SS)>0){
					ksort($SS);
					
					foreach ($SS as $linea_alt)

					     $data.= "$linea\n";

				}
	}else{
		$data.= $linea."\n" ;
	}

}



switch ($arrHttp["vp"]){
	case "WP":
    	$filename=$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		#echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		#echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		#echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "TB":
		$filename=$arrHttp["base"].".xls";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		#echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		#echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		#echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "TXT":
		$filename=$arrHttp["base"].".txt";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		break;
	default:
		include("../common/header_display.php");
}
if (isset($institution_name)) echo $institution_name;
echo "<h5>ABCD - ".$_REQUEST['print_content']."</h5>";
   echo $data;


if (isset($arrHttp["tipof"])){
	switch ($arrHttp["tipof"]){              //TYPE OF FORMAT
		case "T":  //TABLE
			echo "</body></html>";
			break;
		case "P":  //PARRAGRAPH
			echo "</body></html>";
			break;
		case "CT": //COLUMNS (TABLE)
			echo "</table></body></html>";
echo "<small>".date('c')."</small>";
			break;
		case "CD":
			break;
	}
}
die;

?>
