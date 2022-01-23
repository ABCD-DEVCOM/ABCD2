<?php
/* Modified
20210521 fho4abcd Replaced helper code fragment by included file
20210521 fho4abcd Rewritten: correct filenames and error checks
20220123 fho4abcd buttons
*/

session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) and !isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
$lang=$_SESSION["lang"];
$table=$arrHttp["table"];
$backtoscript="../dbadmin/menu_traducir.php"; // The default return script
include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["traducir"].": ".$table;?>
    </div>
    <div class="actions">
        <?php include "../common/inc_back.php"?>
        <?php include "../common/inc_home.php"?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
/*
** The new content of the file is derived from the form
** Only inputs with names starting with "msg_" contains messages
** The suffix of such a name is the key for the translation (part before the "="
** The value is the translated messages
*/
$mensajes="";

foreach ($arrHttp as $var=>$value) {
	if (substr($var,0,4)=="msg_"){
		$var=substr($var,4);
		$mensajes.=$var."=".$value."\n";
	}
}

if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/".$lang."/".$table;
else
	$a=$db_path."lang/".$lang."/".$table;
$fp=@fopen($a,"w");
if ($fp===false ) {
    $contents_error= error_get_last();
    echo "<p style='color:red'>".$msgstr["notok"]." : ".$contents_error["message"]."</p>";
    die;
}
// strip backslashes before quotes, so quotes remain and write result
$res=@fwrite($fp,stripslashes($mensajes)."\n");
if ($res===false ) {
    $contents_error= error_get_last();
    "<p style='color:red'>".$msgstr["notok"]." : ".$contents_error["message"]."</p>";
}
fclose($fp);
if ($res!==false) {
    echo "<h3 align=center>".$msgstr["actualizados"]." ".$lang."/".$table.". ".$res." ".$msgstr["characters"]."</h3> ";
}
echo "</div></div>";
include("../common/footer.php");
?>
