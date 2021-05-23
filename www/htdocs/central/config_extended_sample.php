<?php
//SE LEEN PARÁMETROS ADICIONALES DE abcd.def
if (isset($def["MULTIPLE_DB_FORMATS"]) and $def["MULTIPLE_DB_FORMATS"]=="Y"){  //PARA PROCESAR BASES DE DATOS CON DIFERENTES VERSIONES EN LA MISMA CARPETA BASES
   if (isset($_SESSION))
   		$_SESSION["MULTIPLE_DB_FORMATS"]="Y";
   else
   		$MULTIPLE_DB_FORMATS="Y";
}
if (!isset($dirtree)) $dirtree=0;
if (isset($def["DIRTREE"]))
 	$dirtree=$def["DIRTREE"];
if ($dirtree==1) $dirtree="Y";
//SETTING FOR HEICHT OF THE FRAMES OF THE CATALOGUING WINDOWS
if (isset($def["FRAME_1H"])) $FRAME_1H=$def["FRAME_1H"];
if (isset($def["FRAME_2H"])) $FRAME_2H=$def["FRAME_2H"];
//direccion donde se localiza el archivo de perfiles genéricos
if (isset($def["PROFILES_PATH"]))
	$profiles_path=$def["PROFILES_PATH"];
//archivos de estilo
if (isset($def["CSS_NAME"])){
	$css_name=$def["CSS_NAME"];
}
//Pedir lapso del préstamo
if (isset($def["ASK_LPN"])){
	$ASK_LPN=$def["ASK_LPN"];
}else{
	$ASK_LPN="";
}
//Política de préstamos
if (isset($def["LOAN_POLICY"])){
	$LOAN_POLICY=$def["LOAN_POLICY"];
}else{
	$LOAN_POLICY="";
}
//se incluyen los feriados en el cálculo de suspensiones y multas: Y=/N
if (isset($def["CALENDAR"])) {
	$CALENDAR_S=$def["CALENDAR"];
}else{
	$CALENDAR_S="N";
}

//Validacion de password segura
if (isset($def["SECURE_PASSWORD_LEVEL"])){
	$SECURE_PASSWORD_LEVEL=$def["SECURE_PASSWORD_LEVEL"];
}else{
	$SECURE_PASSWORD_LEVEL="0";
}
if (isset($def["SECURE_PASSWORD_LENGTH"])){
	$SECURE_PASSWORD_LENGTH=$def["SECURE_PASSWORD_LENGTH"];
}else{
	$SECURE_PASSWORD_LENGTH="5";
}
//Acumular suspensiones
$AC_SUSP="Y";
if (isset($def["AC_SUSP"])){
	$AC_SUSP=strtoupper($def["AC_SUSP"]);
}
//Logo
if (isset($def["LOGO"])) $logo=$def["LOGO"];
//Activar reservas
$reserve_active="Y";
if (isset($def["RESERVATION"])) $reserve_active=strtoupper($def["RESERVATION"]);
IF (isset($def["OPACHTTP"])){
	$OpacHttp=trim($def["OPACHTTP"]);
	if (substr($OpacHttp,strlen($OpacHttp)-1,1)!="/")
		$OpacHttp.="/";
}

//se lee el archivo dr_path.def para ver las configuraciones locales de la base de datos
if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
//echo "base-specific parameters read<BR>";
	$selected_base= $_REQUEST["base"];
	$check=explode('|',$selected_base);
	$db_name=$check[0];
	unset($def_db);
	if (file_exists($db_path.$db_name."/dr_path.def")){
		$def_db = parse_ini_file($db_path.$db_name."/dr_path.def");
		//SE MODIFICAN LOS PARÁMETROS EXISTENTES EN EL abcd.def
		if (isset($def_db["UNICODE"]))
			 $def["UNICODE"]=$def_db["UNICODE"];
		else
			 $def["UNICODE"]=$unicode;
		if (isset($def_db["CISIS_VERSION"]))
			 $def["CISIS_VERSION"]=$def_db["CISIS_VERSION"];
		else
			 $def["CISIS_VERSION"]=$cisis_ver;
       	//SE REDEFINEN LOS SIGUIENTES PARÁMETROS DEL CONFIG.PHP
		if (isset($def_db["inventory_numeric"]))      	$inventory_numeric=$def_db["inventory_numeric"];
		if (isset($def_db["max_inventory_length"]))   	$max_inventory_length=$def_db["max_inventory_length"];
		if (isset($def_db["max_cn_length"]))   			$max_cn_length=$def_db["max_cn_length"];
		if (isset($def_db["dirtree"]))                  $dirtree=1;
		if (isset($_SESSION)){
			unset($_SESSION["BARCODE"]);
			unset($_SESSION["BARCODE_SIMPLE"]);
			if (isset($def_db["barcode"]))                  $_SESSION["BARCODE"]="Y";
			if (isset($def_db["barcode_simple"]))			$_SESSION["BARCODE_SIMPLE"]="Y";
		}

		if (isset($def_db["barcode1reg"]))              $barcode1reg=$def_db["barcode1reg"];
  		if (isset($def_db["tesaurus"]))                 $tesaurus=$def_db["tesaurus"];
    	if (isset($def_db["prefix_search_tesaurus"]))   $prefix_search_tesaurus=$def_db["prefix_search_tesaurus"];
 		if (isset($def_db["leader"]))                   $LEADER_TAG=$def_db["leader"];
	}else{		$def["UNICODE"]=$unicode;
		$def["CISIS_VERSION"]=$cisis_ver;	}

}
//No se muestra la base de datos de operadores en la lista de bases de datos disponibles
$show_acces="N";
//Este arreglo es para modificar los nombres de los archivos y eliminarles los diacríticos
$fix_file_name = array(     'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y',' '=>'_' );
//NO EXTRA BLANK LINE MUST APPEAR AFTER THE CLOSING TAG
?>