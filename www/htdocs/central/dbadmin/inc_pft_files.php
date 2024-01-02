<?php
/* Modifications
20231223 fho4abcd Created
*/
/*
** Functions for manipulation of pft files
*/
clearstatcache();
/*--------------------------------------------------------------
** Function  : To read pft file.
** Parameters: - $pft_name : Name of the pft (no extension)
**             - &pft_content	 Defaults to ""
** Returns   : number of errors (0 or 1)
** A missing .pft file is an error. An empty file is OK
** Globals   :
**	$db_path : I	path where the databases are located
**	$base	 : I	 
**	$msgstr  : I	array with translation
*/
function ReadPFT($pft_name, &$pft_content) {
    global $msgstr, $db_path, $base;
	$NOT_OK="<b><font color=red>&rarr; ".$msgstr["notok"]." : </font></b>";
    $retval=0;
	$pft_content="";
	$pft_namef=$pft_name.".pft";
	$pft_fullnamef=$db_path.$base."/pfts/".$_SESSION["lang"]."/".$pft_namef;
    if (!file_exists($pft_fullnamef)) {
            $retval=1;
            $resval=$NOT_OK.$msgstr["misfile"]." '".$pft_namef."'";
            echo $resval."<br>";
    } else {
		$fpPFT = file($pft_fullnamef);
		foreach ($fpPFT as $linea){
			$pft_content.=str_replace('&','&amp;',$linea);
		}
	}
    return $retval;
}
/*---------------------end------------------------------------*/
/*--------------------------------------------------------------
** Function  : To read pft header file.
** Parameters: - $pft_name : Name of the pft (no extension)
**			   - $pft_h_content. Defaults to ""
** Returns   : number of errors (0 or 1)
** A missing h.pft file is OK. An empty file is also OK
** Globals   :
**	$db_path : I	path where the databases are located
**	$base	 : I	 
**	$msgstr  : I	array with translation
*/
function ReadPFT_H($pft_name, &$pft_h_content) {
    global $msgstr, $db_path, $base;
    $retval=0;
	$pft_h_content="";
	$pft_nameh=$pft_name."_h.txt";
	$pft_fullnameh=$db_path.$base."/pfts/".$_SESSION["lang"]."/".$pft_nameh;
     if (!file_exists($pft_fullnameh)) {
    } else {
		$fpPFT = file($pft_fullnameh);
		foreach ($fpPFT as $linea){
			$pft_h_content.=str_replace('&','&amp;',$linea);
		}
		// Remove trailing newline
		$pft_h_content=trim($pft_h_content);
	}
    return $retval;
}
/*---------------------end------------------------------------*/
