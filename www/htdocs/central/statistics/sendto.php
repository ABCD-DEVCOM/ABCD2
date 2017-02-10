<?php
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
			echo "<html>
			<font face=arial size=2>";
	}
    echo $arrHttp["html"];
    echo "</html>";

	die;
?>