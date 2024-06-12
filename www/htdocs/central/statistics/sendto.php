<?php
/*
20240612 fho4abcd Default (open in new window) with correct html and stylesheet
*/
// ==================================================================================================
// GENERA LOS CUADROS ESTADÍSTICOS
// ==================================================================================================
//
session_start();
include("../common/get_post.php");
include ("../config.php");
include ("../lang/statistics.php");

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
			?><!DOCTYPE html>
			<html>
			<head profile="http://www.w3.org/2005/10/profile">
			<link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css" media="screen"/>
			</head>
			<div style="padding-left:10px">
			<?php
			echo $arrHttp["html"];
			?>
			</div></html>
			<?php
			die;
	}
    echo $arrHttp["html"];
    echo "</html>";

	die;

?>