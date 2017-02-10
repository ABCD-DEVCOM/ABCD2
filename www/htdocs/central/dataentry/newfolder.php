<?php
session_start();

set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

switch ($arrHttp["desde"]){	case "dbcp":
		$folder=$db_path;
		break;
	default:
		if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
			$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
			$folder=trim($def["ROOT"]);
		}else{
			$folder=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"];
		}}
$root=$folder;
$activeFolder="";

if (isset($arrHttp["path"])){
	if ($arrHttp["path"]!="..")
		$folder=$folder."/". $arrHttp["path"];
}
if (isset($arrHttp["source"])) $folder.="/".$arrHttp["source"];

$folder.="/".$arrHttp["folder"];
$folder=str_replace('//','/',$folder);
$folder=str_replace('//','/',$folder);
$activeFolder=str_replace($root,"",$folder);
if (!file_exists($folder))
	mkdir($folder);
echo "<script>
history.back()
</script>
";

?>