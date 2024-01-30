<?php
/* Modifications
20240123 fho4abcd Created
*/
/*
** Functions for manipulation of date & calendar info
*/
/*--------------------------------------------------------------
** Function  : Generate a date specification from PHP like and historical habits
** Parameters: - $config_date : Date specification in ABCD terms
**               As specified in config variable $config_date_format
** Returns   : The string acceptable by Calendar.setup
**			   See calendar.js:Date.prototype.print for accepted indicators
**			   These partially equal to the PHP format characters
*/
function ConvertDateSpec($config_date) {
	// tackle formats like historical "DD/MM/YY" 
	$config_date=str_replace("YY","Y",$config_date);
	$config_date=str_replace("MM","m",$config_date);
	$config_date=str_replace("DD","d",$config_date);
	// No hassle with % signs. So sorry
	$config_date=str_replace("%","",$config_date);
	$cal_ifFormat="";
	for ($i=0; $i<strlen($config_date); $i++){
		$char = $config_date[$i];
		if (ctype_alpha($char)) {
			// assume that all characters have a meaning
			// Note that calendar and PHP have different ideas
			// Currently no action (Ymd are OK,lazy programmer)
			$cal_ifFormat.="%".$char;
		}
		else {
			// The separators and blank
			$cal_ifFormat.=$char;
		}
	}
    return $cal_ifFormat;
}
/*---------------------end------------------------------------*/
