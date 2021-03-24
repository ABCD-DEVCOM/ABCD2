<?php
/* Modifications
20210324 fho4abcd Created
*/
/*
** Functions for deletion of a file, folder, folder tree
*/
clearstatcache();
$OK=" &rarr; OK";
$NOT_OK=" &rarr; <b><font color=red>NOT OK</font></b>";
/*--------------------------------------------------------------
** Function  : To delete an existing file. No actions if file does not exist
** Parameters: - $filename : full path of file to delete
**             - $msglevel : message level
**               = -1 : show nothing
**               =  0 : show errors
**               =  1 : show errors + delete succes
** Returns   : number of errors (0 or 1)
** Globals   : - $msgstr : I  To show translated messages
*/
function DeleteFile($filename, $msglevel) {
    global $msgstr,$OK,$NOT_OK;
    $retval=0;
    if (file_exists($filename)) {
        $res=$OK;
        $msg=$msgstr["delete"]." ".$msgstr["file"]." ".$filename;
        $resval=@unlink($filename);
        if (!$resval) {
            $retval=1;
            $contents_error= error_get_last();
            $res=$NOT_OK." : ".$contents_error["message"];
        }
        if ( $msglevel>0 ) {
            echo $msg.$res."<br>";
        } else if ( $msglevel==0 and $retval > 0 ) {
            echo $msg.$res."<br>";
        }
    }
    return $retval;
}
/*--------------------------------------------------------------
** Function  : To delete a (empty) folder
**             Shows always success/failutre message
** Parameters: - $filename : full path of file to delete
** Returns   : number of errors (0 or 1)
** Globals   : - $msgstr : I  To show translated messages
*/
function DeleteFolder($filename) {
    global $msgstr,$OK,$NOT_OK;
    $retval=0;
    if (file_exists($filename)) {
        $resval=@rmdir($filename);
        $res=$OK;
        if (!$resval) {
            $retval=1;
            $contents_error= error_get_last();
            $res=$NOT_OK." : ".$contents_error["message"];
        }
        echo $msgstr["delete"]." folder ".$filename.$res."<br>";
    }
    return $retval;
}
/*--------------------------------------------------------------
** Function  : To delete a folder tree or non-empty folder
**             Shows always success/failure message for folders
**             Shows failure messages for files.
** Parameters: - $filename : full path of file to delete
** Returns   : number of errors (0 or more)
** Globals   : - $msgstr : I  To show translated messages
*/
function DeleteTree($dirname)  {
    global $db_path,$msgstr,$NOT_OK;
    $errors=0;
	$ix=strlen($db_path);
    if (!is_dir($dirname)) return 0;
    // Obtain a handle to read the directory contents
    $dir_handle = @opendir($dirname);
    if ($dir_handle===false) {
        $contents_error= error_get_last();
        $res=$NOT_OK." : ".$contents_error["message"];
        echo $msgstr["delete"]." folder ".$dirname.$res."<br>";
        return 1;
    }
    // First the folders (get into depth)
    while ($file = readdir($dir_handle)) {
        if ($file != "."  &&  $file != "..") {
            $subname=$dirname."/".$file;
            if (is_dir($subname)) {
            	$errors+=DeleteTree($subname);
            } else {
                $errors+=DeleteFile($subname,0);
            }
        }
    }
    closedir($dir_handle);
    $errors+=DeleteFolder($dirname);
    return $errors;
}
/*---------------------end------------------------------------*/
