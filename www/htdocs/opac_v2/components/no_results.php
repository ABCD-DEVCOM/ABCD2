<?php
/**
 * This script is triggered when the search returns no results.
 */


if ($Expresion!="" or isset($_REQUEST["facetas"]) and $_REQUEST["facetas"]!=""){
	if ((!isset($total_base) or count($total_base)==0) ){
		echo "<div style='border: 1px solid;width: 98%; margin:0 auto;text-align:center'>";
		echo "<p><br> <font color=red>".$msgstr["no_rf"]."</font>";

		if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
			echo " ". $msgstr["en"]." ";
			$cc=explode('|',$_REQUEST["coleccion"]);
			echo "<strong>".$cc[1]."</strong><br>";

		} else {
			if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="") echo " <strong>".$bd_list[$_REQUEST["base"]]["titulo"]."</strong>";
		}
		echo "<br>".$msgstr["p_refine"];
		echo "</div>\n";
	}
}