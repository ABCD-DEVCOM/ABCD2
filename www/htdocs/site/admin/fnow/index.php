<?
require_once("include_config_system.php");

session_start();
if ($_SESSION['auth_id'] != "BVS@BIREME") {
    header("Location: ../index.php?lang=pt&timeout=session");
    die();
}

//apply security checks on request variables
$lang = $_REQUEST['lang'];
$task = ($_POST['task'] ? $_POST['task'] : "list");
$relativeDirectory = $_POST['relative'];
$deleteFile = $_POST['deleteFile'];
$newFolder  = $_POST['newFolder'];
$renameFrom =  $_POST['renameFrom'];
$renameTo =  $_POST['renameTo'];

if ( $lang != '' and  !preg_match("~^(pt|es|en)$~",$lang) ){
    die("invalid language");
}
if ( $relativeDirectory != '' and preg_match("~\.[/\/]~",$relativeDirectory) ) {
    die("404 - page not found");
}
if ( $task == "removeFile" and preg_match("~[\/\\]~",$deleteFile) ) {
    die("404 - page not found");
}
if ( $task == "newFolder" and !preg_match("~[A-Za-z_]" .strlen($newFolder) . "}~",$newFolder) ){
    die("invalid folder name");
}
if ( $task == "renameFile" ){
    if ( preg_match("~[\/\\]~",$renameFrom) or preg_match("~[\/\\]~",$renameTo) ){
        die("invalid name");
    }
}

$baseDirectory = pHOME . $cfg["base_directory"];

//die("dir: " .$baseDirectory);

$currentDirectory = $baseDirectory;
if ($relativeDirectory != '')
    $currentDirectory .= "/" . $relativeDirectory . "/";


$column  = ($_POST['column'] ? $_POST['column'] : "name");
$order   = ($_POST['order'] ? $_POST['order'] : "ascending");
$message = "";
$errorMessage = "";

if ( $task == "createFolder" )
{
    $message .= createNewFolder($currentDirectory, $newFolder);
}
if ( isset($_POST['submitUpload']) )
{
    $message .= uploadFile($_FILES["uploadFile"],$currentDirectory);
}
if ( $task == "removeFile" )
{
    $message .= removeFile($currentDirectory, $deleteFile);
}
if ( $task == "renameFile" )
{
    $message .= renameFile($currentDirectory, $renameFrom, $renameTo);
}


$directoryList = getDirectoryList($currentDirectory);

$fileList = getFileList($currentDirectory);

$navigationList["Fnow"] = $def['SITE_PATH'] . '/admin/fnow';
$navigationList["base"] = $cfg['base_directory'];
$navigationList["relative"] = $relativeDirectory;
$navigationList["column"] = $column;
$navigationList["order"] = $order;
$navigationList["pathData"] = $def['DIRECTORY'];

$directoryListXML = setDirectoryListXML($currentDirectory, $navigationList,$directoryList,$fileList,$message);

$result = processTransformation($directoryListXML, pFNOW . "/xsl/directoryList.xsl");
print $result;
?>
