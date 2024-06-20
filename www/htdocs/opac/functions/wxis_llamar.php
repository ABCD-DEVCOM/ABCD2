<?php
/*
20220128 fho4abcd Removed MULTIPLE_DB_FORMATS
*/
/*
function WxisLLamar() {
    global $ABCD_scripts_path;  //para asegurar que la variable está cuando se llama desde una función
    include($ABCD_scripts_path."central/common/wxis_llamar.php");
}*/

function wxisLlamar($base, $query, $IsisScript) {
	global $db_path, $Wxis, $xWxis, $ABCD_scripts_path;
	include($ABCD_scripts_path."central/common/wxis_llamar.php");
	return $contenido;
}

?>