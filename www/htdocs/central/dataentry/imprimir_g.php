<?php
/*
20220117 fho4abcd Improve html+divhelper+ typo in the range processing
20220713 fho4abcd Use $actparfolder as location for .par files
20240102 fho4abcd Documentation+improved algorithms+better output for preview+print option
20240102 fho4abcd Removed obsolete pragma, pre-check/post-check and unnecessary cache control
20240116 fho4abcd Added warning for pft content > 31.000 characters for 16-60 databases
*/
/*
** This module is located in central/dataentry as it is referenced from several sources
** Exports database content controlled by a pft.
** - The pft content is given by the caller or from a stored pft.
** - Record selection is controlled by parameters from the caller
** - Export target is controlled by a parameter from the caller
** Parameters:
	&base		database indicator (<basename>[|<user>]) (required)
	&cipar		Name of database parameter file
** Parameters for exports based on supplied (~temporary) pft specification
	&pft		PFT content to be used.
				- An empty or omitted value requires that &fgen is set
	&headings	Headings for columns syntax format (CT/CD)
	&tipof		Output syntax acronym (T/P/..../CD)
	&separ		Separator to be used by syntax format CD
** Parameters for exports based on stored pft
	&fgen		Indication of the pft to be used. Accepted string values
				- <pftname>[|<syntax acronym>[|<separator acronym>]]
				- <pftname>|<description>|<syntax acronym>(tipof)|<separator acronym>
				- <pftname>          : Filename of the pft. No fullpath, no extension
				- <syntax acronym>   : The intended output format (PL/CD/...)
				- <separator acronym>: Acronym of separator in column formats (VBAR/...)
** Parameters for export target
	&vp			Acronym for export target
				- WP:	Export to a word file (.doc)
				- TB:	Export to an Excel file (.xls)
				- TXT:	Export to a text file (.txt)
				- default: Show in browser
** All other parameters for selection of records
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../dbadmin/inc_pft_files.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>"; 
$data="";
$headings="";
$pft_name="";
$pft_descri="";
$tipoacro="";
$separ="|";// was hard coded in previous versions
$vp="";
if (isset($arrHttp["vp"])) $vp=$arrHttp["vp"];
$Opcion="rango";
if (isset($arrHttp["Expresion"]))		$Opcion="buscar";
if (isset($arrHttp["seleccionados"])) 	$Opcion="seleccionados";

if (isset($arrHttp["Expresion"])){
	$arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
	if (strpos('"',$arrHttp["Expresion"])==0) {
    	$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
	}
	$Expresion=urlencode($arrHttp["Expresion"]);
}
if (isset($arrHttp["pft"])) $arrHttp["pft"]=stripslashes($arrHttp["pft"]);
if (isset($arrHttp["pft"]) and trim($arrHttp["pft"])!=""){
	// This the case that a pft is supplied.
	// Check the length for non-bigisis databases
	if ($cisis_ver!="bigisis") {
		$pftlength=strlen($arrHttp["pft"]);
		$pfttoolarge="31000";
		if ( intval($pftlength) > intval($pfttoolarge)) {
			echo "<div style='color:red'><b>".$msgstr["warning"]."</b><br>";
			echo $msgstr["pftcontentsize"].number_format($pftlength,0,',','.')." ".$msgstr["pftbytes"]."<br>";
			echo $msgstr["pftverylarge"]."<br>";
			echo $msgstr["pftrecommend"]." ".number_format($pfttoolarge,0,',','.')." ".$msgstr["pftbytes"]."<br><br></div>";
		}
	}
	$Formato=urlencode($arrHttp["pft"]);
	if (isset($arrHttp["headings"])) 	$headings=$arrHttp["headings"];
	if (isset($arrHttp["tipof"]))		$tipoacro=$arrHttp["tipof"];
	if (isset($arrHttp["separ"]))		$separ=$arrHttp["separ"];
}elseif (isset($arrHttp["fgen"]) and $arrHttp["fgen"]!="") {
	// This the case that a reference to an existing pft file is supplied 
	$separacro="";
	$fgenar=explode('|',$arrHttp["fgen"]);
	if ($fgenar[0]!="") 							$pft_name=Trim($fgenar[0]);
	if (isset($fgenar[1])&& Trim($fgenar[1]!=""))	$pft_descri=Trim($fgenar[1]);
	if (isset($fgenar[2])&& Trim($fgenar[2]!=""))	$tipoacro=Trim($fgenar[2]);
	if (isset($fgenar[3])&& Trim($fgenar[3]!=""))	$separacro=Trim($fgenar[3]);
	if ($separacro=="COMMA")  $separ=",";// must match with selection in pft.php
	if ($separacro=="SEMICO") $separ=";";// idem
	if ($separacro=="VBAR")   $separ="|";// idem
	// The pft is not read here, but in wxis
	$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$pft_name.".pft";
	if (!file_exists($Formato)){
		$Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$pft_name.".pft";
	}
	if (file_exists($Formato)) $Formato="@".$Formato;
	// READ THE HEADINGS, IF ANY
	if (ReadPFT_H($pft_name[0], $headings)!=0) die;
} else {
	echo "<div color=red>Coding error: No pft and no pft content</div>";
	die;
}
// Add leading text to the generated output (if necessary)
if (isset($tipoacro)){
	switch ($tipoacro){              //TYPE OF FORMAT
		case "CT": //COLUMNS (TABLE)
			$data="<table border=1 style='border-collapse: collapse;'>";
			if ($headings!=""){
				$data.="<tr style='vertical-align:top'>";
				$h=explode("\r",$headings);
				foreach ($h as $value){
					$data.="<th>$value</th>";
				}
				$data.="</tr>";
			}
			break;
		case "CD":
			if ($vp=="P") $data.="<pre>";
			if ($headings!=""){
				$h=explode("\r",$headings);
				$i=0;
				foreach ($h as $value){
					$value=trim($value);
					if ($i==0){
						$data=$value;
					}else{
						$data.=$separ.$value;
					}
					$i++;
				}
				$data.="\n";
			}
			break;
	}
} // end if (isset tipof

// Setup the query string for execution of the report
$query = "&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["cipar"];
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
}else {
	if (isset($arrHttp["Mfn"]) and isset($arrHttp["to"]))
		$query.="&from=".$arrHttp["Mfn"]."&to=".$arrHttp["to"];
} // end if (isset seleccionades

if (!isset($arrHttp["sortkey"])){
	$IsisScript=$xWxis."imprime.xis";
}else{
	$query.='&sortkey='.urlencode($arrHttp["sortkey"]).",";
	$IsisScript=$xWxis."sort.xis";
}
// Execute the query (== get the report data)
include("../common/wxis_llamar.php");
//foreach ($contenido as $value) echo "$value<br>";
$ficha=$contenido;


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
 				$query = "&cipar=$db_path".$actparfolder.$bd_ref. ".par&count=9999&Expresion=".$expr_ref."&Opcion=buscar&base=" .$bd_ref."&Formato=@$pft_ref.pft";
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
} // end foreach
// Modify \n into <br> in case of a preview
if ($tipoacro=="CD"&& $vp=="P"){
	$data=str_replace("\n","<br>",$data);
	$data=str_replace(PHP_EOL,"<br>",$data);
}
switch ($vp){
	case "WP":
    	$filename=$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		break;
	case "TB":
		$filename=$arrHttp["base"].".xls";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		break;
	case "TXT":
		$filename=$arrHttp["base"].".txt";
		header('Content-Type: text/plain');
		header("Content-Disposition: attachment; filename=\"$filename\"");
 		break;
	case "P":
		include("../common/header_display.php");
        ?>
        <body>
        <?php
        include "../common/inc_div-helper.php";
        ?>
        <div class="formContent">
        <?php
		break;
	case "PRINT":
		include("../common/header_display.php");
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
        <body>
        <?php
        ?>
        <div class="formContent">
        <?php
		if (isset($institution_name)) echo $institution_name;
		echo "<h5>ABCD - ".$pft_descri."</h5>";
		break;
	default:
		include("../common/header_display.php");
        ?>
        <body>
        <div class="formContent">
        <?php
} // end switch vp

echo $data;

if (isset($tipoacro)){
	switch ($tipoacro){              //TYPE OF FORMAT
		case "T":  //TABLE
			echo "</body></html>";
			break;
		case "P":  //PARAGRAPH
			echo "</body></html>";
			break;
		case "CT": //COLUMNS (TABLE)
			echo "</table></body></html>";
			break;
		case "CD":
			break;
	}
}
die;
?>
