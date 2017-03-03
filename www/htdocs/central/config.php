<?php

// Open the Central module in a new window for avoiding the use of the browse buttons
$open_new_window="N";
$context_menu="Y";

//USED FOR ALL THE DATE FUNCTIONS. DD=DAYS, MM=MONTH, AA=YEAR. USE / AS SEPARATOR
$config_date_format="DD/MM/YY";

//Folder with the administration modulo
$app_path="central";

//This variable erases the left zeroes in the inventory number
$inventory_numeric ="N";
//Add Zeroes to the left for reaching the max length of the inventory number
$max_inventory_length=1;
//Add Zeroes to the left for reaching the max length of the control number
$max_cn_length=1;

//Colocar Y en esta variable si se quiere llevar un log de todas las transacciones realizadas sobre la base de datos.
//Para que funcione en la carpeta de la base de datos debe existir una subcarpeta llamada log
$log="Y";
$cisis_ver="";


//************************************* Set operation system depending variables
if (stripos($_SERVER["SERVER_SOFTWARE"],"Win") > 0) {
    //Windows path variables
$db_path="/ABCD/www/bases/";                   //path where the lang file and help page are to be located
$msg_path="/ABCD/www/bases/";                  //Path to the folder where the uploaded images are to be stored (the database name will be added to this path)
$img_path="/ABCD/www/htdocs/bases/";           //path to the mx program (include the name of the program) and cisis-utilities (no name of program)
$cgibin_path="/ABCD/www/cgi-bin/";                     //path to the basic directory for CISIS-utilities
$xWxis="/ABCD/www/htdocs/$app_path/dataentry/wxis/";  //Path to the wxis scripts .xis for Central
//$cisis_path="/ABCD/www/cgi-bin/";
$wxis_exec="wxis.exe";                                //name of the wxis executable
$mx_exec="mx.exe";
}else{
    //Linux path variables
$db_path="/var/opt/ABCD/bases/";
$msg_path="/var/opt/ABCD/bases/";
$img_path="/opt/ABCD/www/htdocs/bases/";
$cgibin_path="/opt/ABCD/www/cgi-bin/";
$xWxis="/opt/ABCD/www/htdocs/$app_path/dataentry/wxis/";
//$cisis_path="/opt/ABCD/www/cgi-bin/";
$wxis_exec="wxis";
$mx_exec="mx";
}

if (isset($_SESSION["DATABASE_DIR"])) {
	$db_path=$_SESSION["DATABASE_DIR"];
}
if (!file_exists($db_path."abcd.def")){
	echo "Missing abcd.def in the database folder"; die;
}
$def = parse_ini_file($db_path."abcd.def",true);

//Name of the institution
$institution_name=$def["LEGEND2"];
//Unicode setting
//echo "unicode1 in config.php is $unicode<BR>";
$unicode="ansi";
if (isset($def["UNICODE"]))  {
$unicode=$def["UNICODE"];
//echo "unicode config1=$unicode<BR>";
if ($unicode!="0") $unicode="utf8"; else $unicode="ansi";
//echo "unicode config2=$unicode<BR>";
}

//***
//Include config_extended.php that reads configuration parameters that applies to the selected database, before creating final wxis-variables
if (file_exists(realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."config_extended.php")){
	include (realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."config_extended.php");
}
//***


$cisis_path=$cgibin_path.$unicode."/".$cisis_ver;
//$mx_path=$cgibin_path.$unicode.$cisis_ver.$mx_exec;
$mx_path=$cisis_path.$mx_exec;
//echo "cisis=$cisis_path<BR>";
//echo "mx=$mx_path<BR>";


//*************************************


//Path to the wwwisis executable (include the name of the program, with extension if present)
$Wxis=$cisis_path.$wxis_exec;
//Url for the execution of wxis, when using GGI in place of exec, include extension if present
//$wxisUrl="http://127.0.0.1:9090/cgi-bin/".$unicode."/".$cisis_ver.$wxis_exec;
$wxisUrl="";   //SI NO SE VA A UTILIZAR EL METODO POST PARA VER LOS REGISTROS


//default language
$lang="en";

//Default langue for the databases definition
$lang_db="en";

//extension allowed for uploading files (used in dataentry/)
$ext_allowed=array("jpg","gif","png","pdf","doc","docx","xls","xlsx","odt");

//allow change password
$change_password="Y";

//Ruta hacia el archivo con la configuración del FCKeditor
$FCKConfigurationsPath="/".$app_path."/dataentry/fckconfig.js";

//Ruta hacia el FCKEditor
$FCKEditorPath="/site/bvs-mod/FCKeditor/";

//USE THIS LOGIN AND PASSWORD IN CASE OF CORRUPTION OF THE OPERATORS DATABASE OR IF YOU DELETED, BY ERROR, THE SYSTEM ADMINISTRATOR
$adm_login="eds";
$adm_password="eeddss";

//LDAP parameters if used
$use_ldap=false;
$ldap_host = "ldap://zflexldap.com";
$ldap_dn = "cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com";
$ldap_search_context = "ou=guests,dc=zflexsoftware,dc=com";
$ldap_port = "389";
$ldap_pass = "zflexpass";


//USE THIS PARAMETER TO SHOW THE ICON THAT ALLOWS THE BASES FOLDER EXPLORATION.
// this parameter can be read from the abcd.def
//DIRTREE=0 dont show
//DIRTREE=1 show
$dirtree=0;
//USE THIS PARAMETER TO ENABLE/DISABLE THE MD5 PASSWORD ENCRIPTYON (0=OFF 1=ON)
$MD5=0;

//variables related to the EmpWeb module
$EmpWeb="N";
//$empwebservicequerylocation = "http://localhost:8086/ewengine/services/EmpwebQueryService";
//$empwebservicetranslocation = "http://localhost:8086/ewengine/services/EmpwebTransactionService";
//$empwebserviceobjectsdb = "objetos";
//$empwebserviceusersdb = "*";




?>