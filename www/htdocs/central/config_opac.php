<?php
/*
20211224 fho4abcd Read default message file from central, with central processing, lineends
20220831 rogercgui Included the variable $opac_path to allow changing the Opac root directory
*/
//session_start();
error_reporting(E_ALL);
//CHANGE THIS ////
include ("config.php");   //CAMINO DE ACCESO HACIA EL CONFIG.PHP DE ABCD

if (isset($_SESSION["db_path"])){
	$db_path=$_SESSION["db_path"];   //si hay multiples carpetas de bases de datos
} elseif (isset($_REQUEST["db_path"]))  {
	$db_path=$_REQUEST["db_path"];
}

$opac_path="opac_v2";

$actualScript=basename($_SERVER['PHP_SELF']);
$CentralPath=$ABCD_scripts_path.$app_path."/";
$CentralHttp=$server_url;
$Web_Dir=$ABCD_scripts_path."opac/";
$NovedadesDir="";

$lang_config=$lang; // save the configured language to preset it later

if (isset($_REQUEST["lang"])){
	$lang=$_REQUEST["lang"];
}else{
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

include ($CentralPath."/lang/opac.php");
include ($CentralPath."/lang/admin.php");

$galeria="Y";
$styles="";
$facetas="Y";
$logo="assets/img/logoabcd.png";
$link_logo="/".$opac_path;
$TituloPagina="ABCD - OPAC";
$TituloEncabezado=" OPAC ABCD";
$footer='&copy; 2023 - Consulta bases de dados';

$multiplesBases="Y";   //no se presenta acceso para cada una de las bases de datos
$afinarBusqueda="Y";   //permite afinar la expresion de búsqueda
$IndicePorColeccion="N";  //Se mantienen indices separados para los términos de las colecciones
if (file_exists($db_path."/opac_conf/opac.def")){
	$fp=file($db_path."/opac_conf/opac.def");
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('=',$value);
			switch ($v[0]){
				case "logo":
					$logo=$v[1];
					break;
				case "link_logo":
					$link_logo=$v[1];
					break;
				case "TituloPagina":
					$TituloPagina=$v[1];
					break;
				case "TituloEncabezado":
					$TituloEncabezado=$v[1];
				case "footer":
					$footer=$v[1];
					break;
				case "charset":
					if (trim($v[1])!="")
						$charset=$v[1];
					break;
				case "styles":
					if (trim($v[1])!="")
						$styles=$v[1];
					break;
/*
				case "Web_Dir":
					if (trim($v[1])!="")
						$Web_Dir=$v[1];
					break;
*/
				case "ONLINESTATMENT":
					if (trim($v[1])!="")
						$ONLINESTATMENT=$v[1];
					break;
				case "WEBRESERVATION":
					if (trim($v[1])!="")
						$WEBRESERVATION=$v[1];
					break;
				case "WEBRENOVATION":
					if (trim($v[1])!="")
						$WEBRENOVATION=$v[1];
					break;
				case "SHOWHELP":
					if (trim($v[1])!="")
						$showhide=$v[1];
					break;
				case "OpacHttp":
					if (trim($v[1])!=""){
						$OpacHttp=$v[1];
						if (substr($OpacHttp,strlen($OpacHttp)-1,1)!="/")
							$OpacHttp.="/";
					}
					break;
				case "shortIcon":
				    $shortIcon=trim($v[1]);
					break;
			}
		}
	}
	unset($fp);
}

$db_path=trim(urldecode($db_path));
$ix=explode('/',$db_path);
$xxp="";
for ($i=1;$i<count($ix);$i++) {
	$xxp.=$ix[$i];
	if ($i!=count($ix)-1) $xxp.='/';
}


?>