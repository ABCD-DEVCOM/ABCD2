<?php

/* por ahora no se usa, se deshabilita apoderado  27/5/2014 */
/*
function show_emails($email,  $email_apoderado) {	
	if ($email == "" && $email_apoderado == "") {
		return "";
	} else if ($email != "" && $email_apoderado != "") {
		return $email.", ".$email_apoderado;
	} else if ($email != "" && $email_apoderado == "") {
		// TODO: TEST!!
		if (strpos($email, ", ") === FALSE) {
			return $email.", "."test@test.com";
		} else {
			return $email;
		}
	} else if ($email == "" && $email_apoderado != "") {
		return $email_apoderado;
	}
}
*/

function load_request_message($lang_param = '') {
	include("../../central/config.php");
	if ($lang_param != "") {
		$lang = $lang_param;
	}
	//$file_contents = trim(file_get_contents("../../../bases/lang/$lang/odds.tab"));
	$file_contents = trim(file_get_contents($db_path."lang/$lang/odds.tab"));	
	
	//REQUEST_MESSAGES 
	$labels_read = explode("\n", $file_contents);	
	$end = false;
	$request = "";
	for ($i = 0; $i<count($labels_read) && !$end; $i++) {
		$v = $labels_read[$i];
		if (trim($v) == 'REQUEST_MESSAGES') {
			$end = true;
			$second_end = false;
			for ($j = ($i+1); $j<count($labels_read) and !$second_end; $j++) {				
				$v = $labels_read[$j];				
				$a = explode("=", $v);				
				$value = trim($a[1]);
				$value = str_replace('\n', '<br>', $value);
				$value = str_replace('[center]', $institution_name, $value);
				$request[trim($a[0])] = $value;	
			}
		}
	}
	return $request;
}

function load_labels($lang_param = '', $id, $name, $email, $phone) {
	include("../../central/config.php");
	if ($lang_param != "") { 
		$lang = $lang_param;
	}		
	$labels = "";
	$file_contents = trim(file_get_contents($db_path."lang/$lang/odds.tab"));	
	//var_dump($db_path."lang/$lang/odds.tab");	
	//var_dump($file_contents);die();

	$labels_read = explode("\n", $file_contents);
	$end = false;
	for ($i = 0; $i<count($labels_read) && !$end; $i++) {
		$v = $labels_read[$i];
		if (trim($v) == 'HEADER_MESSAGES') {
			$end = true;
		} else {
			$a = explode("=", $v);			
			$value = trim($a[1]);			
			if (trim($a[0]) == 'welcome') {
				$value = str_replace("[year]", date("Y"), $value);				
				$value = str_replace("[day]", date("j"), $value);
				if ($lang == 'es') {
					$value = str_replace("[month]", _spanish_month(date('n')), $value);
				} else {
					$value = str_replace("[month]", date("F"), $value);
				}				
			}

			if ($id!="" && trim($a[0])=='id') {
				$value = str_replace("*", "", $value);
			} else {
				$value = str_replace("*", "<font color='red'> *</font>", $value);
			}
			if ($name!="" && trim($a[0])=='name') {
				$value = str_replace("*", "", $value);
			} else {
				$value = str_replace("*", "<font color='red'> *</font>", $value);
			}
			if ($email!="" && trim($a[0])=='email') {
				$value = str_replace("*", "", $value);
			} else {
				$value = str_replace("*", "<font color='red'> *</font>", $value);
			}
			if ($phone!="" && trim($a[0])=='phone') {
				$value = str_replace("*", "", $value);
			} else {
				$value = str_replace("*", "<font color='red'> *</font>", $value);
			}


			$labels[trim($a[0])] = $value;
		}
	}	
	return $labels;	
}


function load_aditional_info($lang_param = '') {
	include("../../central/config.php");
	if ($lang_param != "") {
		$lang = $lang_param;
	}	
	//Path al directorio de tabs 			
	//$file_contents = trim(file_get_contents("../../../bases/lang/$lang/odds_help_info.tab"));
	$file_contents = trim(file_get_contents($db_path."lang/$lang/odds_help_info.tab"));
	
	$help_readed = explode("\n", $file_contents,2);
	if (count($help_readed) < 2) {
		die("Fail to specify odds_help_info file (to help box)");
	} /*else {
		 $help_readed[1] = nl2br($help_readed[1]);

	}*/
	return $help_readed;
}

/* --------------------------------------------------------------------------------------------[]
Incluir el archivo de confirguracion, leer los archivos tabs y cargarlos en arrays para luego
dibujar los combos. 
Se buscan leer tabs para todos los combos, o sea, ... si algun archivo no se encuentra, 
se cargan arrays con valores por defecto
-------------------------------------------------------------------------------------------- */
function load_combos($lang_param = '') {
	include("../../central/config.php");
	if ($lang_param != "") {
		$lang = $lang_param;
	}	
	//Path al directorio de tabs 			
	$path_tab = $db_path."odds/def/".$lang."/";		

	// cuales tabs debemos leer?, o sea, cuales combos se deben llenar
	$combos["categoria"] = array();
	$combos["nivelbiblio"] = array();

	//leer el directorio y los archivos
	if (is_dir($path_tab)) { 		
		if ($dh = opendir($path_tab)) { 
			while (($file = readdir($dh)) !== false) {
				if (!is_dir($path_tab . $file) && $file!="." && $file!=".." ) {
					$a = explode(".", $file);
					if ($a[(count($a)-1)] == "tab"){
						// borrar ultima celda del array
						array_pop($a);				 
						// implode para reconstruir el nombre del archivo sin el tab
						$name_tab = trim(implode(".", $a));
						// ver si el archivo está en $combos, porque eso significa que el archivo se usa en el form
						if (isset($combos[$name_tab])) {
							// leer el archivo tab							
							$file_contents = file_get_contents($path_tab.$name_tab.".tab");	
							// separar las lineas con "\n"
							$lineas = explode("\n", $file_contents);												
							foreach ($lineas as $linea) {
								$key_value = explode("|", $linea);															
								$combos[$name_tab][trim($key_value[0])] =  trim($key_value[1]);
							}
						}
					}
				}
			} //fin while para loopear los archivos .tab
		}
	}
	// valores por defecto (si querdaron vacíos) - ¡deshabilitados por ahora!
	if (empty($combos["categoria"]) || empty($combos["nivelbiblio"])) {
		return false;
	}
	return $combos;
}

/* --------------------------------------------------------------------------------------------
Incluir el archivo de confirguracion, leer los archivos tabs y cargarlos en arrays para luego
function load_header_messages()
---------------------------------------------------------------------------------------------- */
function load_header_messages($lang_param = '') {	
	include("../../central/config.php");
	if ($lang_param != "") {
		$lang = $lang_param;
	}	
	$header_messages = array();
	$header_messages['institution_name'] = $institution_name;
	
	//$file_contents = trim(file_get_contents("../../../bases/lang/$lang/odds.tab"));
	$file_contents = trim(file_get_contents($db_path."lang/$lang/odds.tab"));	
	$labels_read = explode("\n", $file_contents);	
	$end = false;
	
	for ($i = 0; $i<count($labels_read) && !$end; $i++) {
		$v = $labels_read[$i];
		if (trim($v) == 'HEADER_MESSAGES') {
			$end = true;
			$second_end = false;
			for ($j = ($i+1); $j<count($labels_read) and !$second_end; $j++) {				
				$v = $labels_read[$j];
				if (trim($v) == "REQUEST_MESSAGES") {
					$second_end = true;
				}
				else {
					$a = explode("=", $v);				
					$value = trim($a[1]);					
					$header_messages[trim($a[0])] = $value;				
				}
			}
		}
	}	
	return $header_messages;
}

function _spanish_month($month) {
	$month = (int)$month;
	if ($month == 1) return "enero";
	if ($month == 2) return "febrero";
	if ($month == 3) return "marzo";
	if ($month == 4) return "abril";
	if ($month == 5) return "mayo";
	if ($month == 6) return "junio";
	if ($month == 7) return "julio";
	if ($month == 8) return "agosto";
	if ($month == 9) return "septiembre";	
	if ($month == 10) return "octubre";
	if ($month == 11) return "noviembre";
	if ($month == 12) return "diciembre";
}


// se determina el número siguiente del campo autoincremente
function get_cn($base, $db_path) {
	$cn="";
	$archivo=$db_path.$base."/data/control_number.cn";
	if (!file_exists($archivo)){
		$cn=false;
		return;
	}
	$perms=fileperms($archivo);
	if (is_writable($archivo)){
	//se protege el archivo con el número secuencial
		chmod($archivo,0555);
	// se lee el último número asignado y se le agrega 1
		$fp=file($archivo);
		$cn=implode("",$fp);
		$cn=$cn+1;
	// se remueve el archivo .bak y se renombre el archivo .cn a .bak
		if (file_exists($db_path.$base."/data/control_number.bak"))
			unlink($db_path.$base."/data/control_number.bak");
		$res=rename($archivo,$db_path.$base."/data/control_number.bak");
		chmod($db_path.$base."/data/control_number.bak",$perms);
		$fp=fopen($archivo,"w");
		fwrite($fp,$cn);
		fclose($fp);
		chmod($archivo,$perms);
		if (isset($max_cn_length)) $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
	 }else{
		$cn=false;
	 }
	 return $cn;
 }


function getOS() { 
	//echo strpos($_SERVER['SERVER_SOFTWARE'],'(unix)') !== false."<hr>";
	//echo $_SERVER['SERVER_SOFTWARE']."<hr>";
	//echo strpos( strtolower( $_SERVER['SERVER_SOFTWARE']), '(unix)') ."<hr>";
	if ( strpos(strtolower($_SERVER['SERVER_SOFTWARE']), strtolower('(unix)')) !== false) {	
		return "UNIX";
	} else {
		return "WIN";
	}
}

?>
