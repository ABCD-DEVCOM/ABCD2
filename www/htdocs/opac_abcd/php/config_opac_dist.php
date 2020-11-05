<?php
session_start();
error_reporting(E_ALL);
//CHANGE THIS ////
include ("/abcd2.2/www/htdocs/central/config.php");   //CAMINO DE ACCESO HACIA EL CONFIG.PHP DE ABCD

//LOS SIGUIENTES PARÁMETROS ESTÁN DEFINIDOS EN EL CONFIG.PHP DE LA VERSIÓN 2.2. SE INCLUYEN AQUÍ PARA
//COMPATIBILIDAD CON LA VERSION 1.6
if (!isset($ABCD_scripts_path))
	$ABCD_scripts_path="/abcd2.2/www/htdocs/";   //path donde están instalados los scripts de abcd
if (!isset($server_url)){
	$server_url="http://localhost:9091";       //El url qaue se usa para acceder a ABCD
	$OpacHttp=$server_url;
}
//

if (!isset($_REQUEST["lang"]))
	$_REQUEST["lang"]=$lang;
else
	$lang=$_REQUEST["lang"];

if (isset($_SESSION["db_path"]))
	$db_path=$_SESSION["db_path"];   //si hay multiples carpetas de bases de datos
else
	if (isset($_REQUEST["db_path"])) $db_path=$_REQUEST["db_path"];
if (isset($_REQUEST["lang"])){	 $_SESSION["lang"]= $_REQUEST["lang"];
	 $lang=$_REQUEST["lang"];
}$actualScript=basename($_SERVER['PHP_SELF']);
$CentralPath=$ABCD_scripts_path.$app_path."/";
$CentralHttp=$server_url;
$NovedadesDir="";

$showhide="Y";
$galeria="NO";
$styles="";
$logo="../images/circulos.png";
$link_logo="http://opac.abcdonline.info";
$TituloPagina="ABCD - OPAC";
$TituloEncabezado=" OPAC de ABCD";
$footer='&nbsp; &copy; 2019, - Consulta bases de datos </p>';
$multiplesBases="S";   //no se presenta acceso para cada una de las bases de datos
$afinarBusqueda="S";   //permite afinar la expresion de búsqueda
$IndicePorColeccion="N";  //Se mantienen indices separados para los términos de las colecciones
if (file_exists($db_path."/opac_conf/opac_abcd.def")){
	$fp=file($db_path."/opac_conf/opac_abcd.def");
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
				case "Web_Dir":
					if (trim($v[1])!="")
						$Web_Dir=$v[1];
					break;
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
			}
		}
	}
	unset($fp);
}
if ($showhide=="Y")
	$showhide_help="block";
else
	$showhide_help="none";
include("read_lang.php");
$db_path=trim(urldecode($db_path));
$ix=explode('/',$db_path);
$xxp="";
for ($i=1;$i<count($ix);$i++) {	$xxp.=$ix[$i];
	if ($i!=count($ix)-1) $xxp.='/';
}

if (!isset($diagnostico)){
	if (!is_dir($db_path."opac_conf")) {
		echo "<h3>".$msgstr["missing_folder"]." <font color=red>opac_conf</font> in $xxp</h4>";
		echo "<a href=//wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuración#Estructura_de_carpetas_y_archivos_de_configuraci.C3.B3n>".$msgstr["help"]."</a>";
        die;
	}
	if (!is_dir($db_path."opac_conf/$lang")) {		echo "<h3>".$msgstr["missing_folder"]."  $xxp opac_conf <font color=red>$lang</font><h3>";
		echo "<a href=//wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci&oacute;n#Estructura_de_carpetas_y_archivos_de_configuraci.C3.B3n>".$msgstr["help"]."</a>";
		die;
	}
}
?>