<?PHP


function errorHandler ($errno, $errmsg, $filename, $linenum, $vars)
{
    global $errorMessage;

    $errorMessage =  htmlentities($errmsg,ENT_QUOTES);
}

function createNewFolder ( $currentDirectory, $newFolder )
{
    global $errorMessage;

    $folderName = $currentDirectory . "/" . $newFolder;

    if ( file_exists($folderName) )
    {
        return "<message folder=\"" . $newFolder . "\" error=\"can not create folder\" why=\"folder already exists\"/>";
    }
    if ( !@mkdir($folderName,0750) )
    {
        return "<message folder=\"" . $newFolder . "\" error=\"can not create folder\" why=\"" . $errorMessage . "\"/>";
    }

    return "<message folder=\"" . $newFolder . "\" success=\"folder created\"/>";
}

function uploadFile ( $upLoaded, $directory )
{
    global $errorMessage, $cfg;

    $from = $upLoaded["tmp_name"];
    $fileName = $upLoaded["name"];
    $to = $directory . "/" . $fileName;

    if (!eregi("\." . $cfg['allowed_extensions'] . "$", $fileName))
    {
        return "<message file=\"" . $fileName . "\" error=\"can not upload file\" why=\"not allowed extenstion\"/>";
    }

    if ( !is_uploaded_file($from) )
    {
        return "<message file=\"" . $fileName . "\" error=\"can not upload file\" why=\"malicious try\"/>";
    }
    if ( !move_uploaded_file($from,$to) )
    {
        return "<message file=\"" . $fileName . "\" error=\"can not upload file\" why=\"unable to move file\"/>";
    }
    return "<message file=\"" . $fileName . "\" success=\"file uploaded\"/>";
}

function getDirectoryList ( $directory )
{
    $directoryList = array();
    $file = "";

    if ( !is_dir($directory) ) {
        die("404 - page not found");
    }
    if ( !chdir($directory) ) {
        die("unable to view directory");
    }

    $handle = opendir(".");
    while ( $file = readdir($handle) )
    {
        if ( is_dir($file) )
        {
            if ( $file != "." /* && $file != ".." */ )
            {
                $directoryList[] = $file;
            }
        }
    }
    closedir($handle);

    return $directoryList;
}

function getFileList ( $directory )
{
    $fileList = array();

    chdir($directory);

    $handle = opendir(".");
    while ( $file = readdir($handle) )
    {
        if ( is_file($file) )
        {
            $fileList[] = $file;
        }
    }
    closedir($handle);

    return $fileList;
}

function getChangedDate ( $fileName )
{
    $lastChanged = filectime($fileName);
    $changedDate = date("Y-m-d H:i:s", $lastChanged);

    return $changedDate;
}

function getFileSize ( $fileName )
{
    $sizeInBytes = filesize($fileName);

   return $sizeInBytes . "";
}

function getFilePermissions ( $fileName )
{
    $permission = sprintf ("%o", (fileperms($fileName)) & 0777);

    return $permission;
}

function getPreviousDir ( $directory )
{
    $splited = split("/",$directory);
    $splited = array_slice($splited,0,-1);

    return join("/",$splited);
}

function genAttributeList ( $list )
{
    $attrList = "";
    reset($list);
    while ( list($key, $value) = each($list) )
    {
        $attrList .= " " . $key . "=\"" . $value . "\"";
    }

    return $attrList;
}

function setDirectoryListXML ( $currentDirectory, $navigationList, $directoryList, $fileList, $message )
{
    global $cfg;

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n";

    $xml .= "<directoryList " . genAttributeList($navigationList) . " previous=\"" . getPreviousDir($navigationList["relative"]) . "\">\n";
    $xml .= $message;

    foreach ( $directoryList as $name )
    {
        $fullName = $currentDirectory . "/" . $name;
        $changedDate = getChangedDate($fullName);
        $fSize = getFileSize($fullName);

       $xml .= "<directory name=\"" . htmlspecialchars($name) . "\" type=\"dir\" size=\"" . $fSize . "\" changedDate=\"" . $changedDate . "\"/>\n";
    }
    foreach ( $fileList as $name )
    {
        $fullName = $currentDirectory . "/" . $name;
        $pathSplited = pathinfo($fullName);
        $changedDate = getChangedDate($fullName);
        $fSize = getFileSize($fullName);

       $xml .= "<file name=\"" . htmlspecialchars($name) . "\" type=\"" . $pathSplited["extension"] . "\" size=\"" . $fSize . "\" changedDate=\"" . $changedDate . "\"/>\n";
    }
    $xml .= "<cgi><lang>" . $cfg["lang"] . "</lang></cgi>";
    $xml .= "</directoryList>\n";

    return $xml;
}

function removeFile ( $currentDirectory, $deleteFile )
{
    global $errorMessage;

    $fileName = $currentDirectory . "/" . $deleteFile;
    if ( is_dir($fileName) )
    {
        if ( !@rmdir($fileName) )
        {
            return "<message folder=\"" . $deleteFile . "\" error=\"can not delete folder\" why=\"" . $errorMessage . "\"/>";
        }
        return "<message folder=\"" . $deleteFile . "\" success=\"folder deleted\"/>";
    }
    else
    {
        if ( !@unlink($fileName) )
        {
            return "<message file=\"" . $deleteFile . "\" error=\"can not delete file\" why=\"" . $errorMessage . "\"/>";
        }
        return "<message file=\"" . $deleteFile . "\" success=\"file deleted\"/>";
    }
}

function renameFile ( $currentDirectory, $renameFrom, $renameTo )
{
    global $errorMessage;

    $from = $currentDirectory . "/" . $renameFrom;
    $to = $currentDirectory . "/" . $renameTo;
    if ( !@rename($from,$to) )
    {
        return "<message file=\"" . $renameFrom . "\" error=\"can not rename it\" why=\"" . $errorMessage . "\"/>";
    }
    return "<message file=\"" . $renameFrom . "\" success=\"renamed to " . $renameTo . "\"/>";

}


function setFnowXML ( $xml )
{
    header("Content-type: text/xml\n\n");
    print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n" . $xml);
}

?>
