<?php
// Main server configuration
$server_url="http://127.0.0.1:9090";    // URL with port (if not 80)
$postMethod=1;                          // if set to '1' (or true) ABCD will use POST-method; use with caution
$dirtree=1;                             // SE THIS PARAMETER TO SHOW THE ICON THAT ALLOWS THE BASES FOLDER EXPLORATION
$MD5=0;                                 // USE THIS PARAMETER TO ENABLE/DISABLE THE MD5 PASSWORD ENCRIPTYON (0=OFF 1=ON)
$EmpWeb=0;                              // use EmpWeb or not
$use_ldap=0;                            // use LDAP or not

//************************************* Set operation system depending variables
if (stripos($_SERVER["SERVER_SOFTWARE"],"Win") > 0) {  //Windows path variables
$ABCD_path="/ABCD/";                    // base path to ABCD-installation
$db_path="/ABCD/www/bases/";            // path where the databases are to be located
$exe_ext=".exe";                        // extension for executables
}else{                                  // Linux path variables
$ABCD_path="/opt/ABCD/";
$db_path="/var/opt/ABCD/bases/";
$exe_ext="";
}

// Other local settings to be configured
$open_new_window="N";                   // Open the Central module in a new window for avoiding the use of the browse buttons
$context_menu="Y";                      // allow opening right-click menu
$config_date_format="DD/MM/YY";         // USED FOR ALL THE DATE FUNCTIONS. DD=DAYS, MM=MONTH, AA=YEAR. USE / AS SEPARATOR
$app_path="central";                    // Folder with the administration modulo
$inventory_numeric ="N";                // This variable erases the left zeroes in the inventory number
$max_inventory_length=1;                // Add Zeroes to the left for reaching the max length of the inventory number
$max_cn_length=1;                       // Add Zeroes to the left for reaching the max length of the control number
$log="Y";                               // switch on logging of the actions, a subfolder 'log' needs to exist in database-directory
$lang="en";                             // default language
$lang_db="en";                          // Default langue for the databases definition
$ext_allowed=array("jpg","gif","png","pdf","doc","docx","xls","xlsx","odt");    //extension allowed for uploading files (used in dataentry/)
$change_password="Y";                   //allow change password

// *** NO CHANGES NEEDED BELOW HERE
// Construction of executable path and URL
$cisis_ver="";                             // initialisation of $cisis_ver as empty = default standard CISIS-version
$wxis_exec="wxis".$exe_ext;                // name and extension of wxis executable
$mx_exec="mx".$exe_ext;                    // name and extension of mx executable
$msg_path=$db_path;                        // path to the folder where the uploaded images are to be stored (the database name will be added to this path)
$img_path=$ABCD_path."www/htdocs/bases/";  // path to the mx program (include the name of the program) and cisis-utilities (no name of program)
$cgibin_path=$ABCD_path."www/cgi-bin/";    // path to the basic directory for CISIS-utilities
$xWxis=$ABCD_path."www/htdocs/$app_path/dataentry/wxis/";    // path to the wxis scripts .xis for Central

if (isset($_SESSION["BASES_DIR"]))
	$db_path=$_SESSION["BASES_DIR"];
else {
$unicode="";
$institution_name="";
if (isset($arrHttp["base"]))    {
if (!file_exists($db_path."abcd.def")){
	echo "Missing abcd.def in the database folder"; die;
}
//}
$def = parse_ini_file($db_path."abcd.def",true);      // read variables from abcd.def
//}
$institution_name=$def["LEGEND2"];        // Institution name defined by abcd.def 'LEGEND2'
$unicode="ansi";                          // Unicode setting read from abcd.def, with default = ANSI
//if (isset($def["UNICODE"]))  {            // If unicode is defined in abcd.def
if (intval($def["UNICODE"])>0)
$unicode=$def["UNICODE"];                 // set unicode to value in abcd.def
else $unicode='';

if (isset($arrHttp["base"]) and isset($def[$arrHttp["base"]]))
//if (isset($def[strtoupper($arrHttp["base"])]))   // if database named in abcd.def
 $cisis_ver=$def[$arrHttp["base"]] ; // use the CISIS-version defined for that database
} // end (isset($arrHttp["base"]))
}
if (file_exists(realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."config_extended.php")){
	include (realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."config_extended.php");  //Include config_extended.php that reads extra configuration parameters
}
//echo "unicode after extended_php : " . intval($unicode);
//if (intval($unicode)!==0) {                 // if unicode not specified as OFF
 if (strtoupper($unicode)!="ANSI"  OR intval($unicode)>0) {      // if unicode not yet specified as ANSI
  $unicode="utf8";
  //echo " unicode set to utf8";
  }                     // then set unicode to UTF8
 else {$unicode="ansi";
 //echo "unicode set to ansi";
 }
//echo "unicode config2=$unicode<BR>";
$cisis_path=$cgibin_path.$unicode."/".$cisis_ver;   // path to directory with correct CISIS-executables
$mx_path=$cisis_path.$mx_exec;                      // path to mx-executable
$Wxis=$cisis_path.$wxis_exec;             // path to the wwwisis executable (include the name of the program, with extension if present)
if ($postMethod)
$wxisUrl=$server_url."/cgi-bin/".$unicode."/".$cisis_ver.$wxis_exec;  // POST method used
else $wxisUrl="";                                                     // GET method used
//echo "cisis_path=$cisis_path<BR>";
//echo "cisis_ver=$cisis_ver<BR>";
//echo "mx=$mx_path<BR>";
//echo "unicode=$unicode<BR>";
//echo "cgibin_path=$cgibin_path<BR>";
//echo "bases_path=$db_path<BR>";
//echo "msg_path=$msg_path<BR>";
//echo "wxisUrl=$wxisUrl<BR>";
//print "wxis=$Wxis<BR>";    // sleep(1);


$FCKConfigurationsPath="/".$app_path."/dataentry/fckconfig.js";  // path to CKeditor configuration
$FCKEditorPath="/site/bvs-mod/FCKeditor/";                       // path to CKEditor
if ($use_ldap) {                                                 //LDAP parameters if used
$ldap_host = "ldap://zflexldap.com";
$ldap_dn = "cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com";
$ldap_search_context = "ou=guests,dc=zflexsoftware,dc=com";
$ldap_port = "389";
$ldap_pass = "zflexpass";
}
if ($EmpWeb) {                                                   //EmpWeb parameters if used
$empwebservicequerylocation = "http://localhost:8086/ewengine/services/EmpwebQueryService";
$empwebservicetranslocation = "http://localhost:8086/ewengine/services/EmpwebTransactionService";
$empwebserviceobjectsdb = "objetos";
$empwebserviceusersdb = "*";
}
$adm_login="eds";                                                // emergency username for administrator
$adm_password="eeddss";                                          // emergency password for administrator
?>
