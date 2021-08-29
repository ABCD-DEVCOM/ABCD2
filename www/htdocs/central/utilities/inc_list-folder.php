<?php
/* Modifications
20210806 fho4abcd Created from function scanDirectories
*/

/*--------------------------------------------------------------
** Function  : List the content of a folder.
**             The folder is recursively scanned.
**             Filenames ., .., .htaccess, .htpasswd, Thumbs.db are skipped by default
** Usage     : include "inc_list-folder.php";
**             if ( list_folder($option, $rootDir, $skipNames, $fileList) != 0 ) // error processing
** Parameters: - $option   : "files"  : List files recursively
**                           "folders": List folders recursively
**             - $rootDir  : Full path of directory to list
**             - $skipNames: Array with additional names to skip
**             - $nameList : Array with found names
** Returns   : 0 : no errors occured.
**             1 : wrong option
**             2 : rootDir not set
**             3 : rootDir is not a folder
** Messages  : Shows a failure message in case of errors
*/
function list_folder($option, $rootDir, $skipNames=array(), &$nameList=array()) {
    global $msgstr;
    $retval=0;
    $errprefix="<div style='color:red'>ERROR in ".__FILE__."&rarr; ";
    // set fixed invisible filenames
    $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd", "Thumbs.db");
    if ( $option!="files" and $option!="folders") {
        echo  $errprefix."Option $option is invalid";
        return(1);
    }
    if ( !isset($rootDir)) {
        echo  $errprefix."Parameter rootDir not set";
        return(2);
    }
    if (!is_dir($rootDir)) {
        echo  $errprefix."$rootDir is not a folder";
        return(3);
    }
    // run through content of root directory
    $dirContent = scandir($rootDir);
    foreach($dirContent as $key => $content) {
        // filter all invisible files
        // filter all files with skipped Names
        $path = $rootDir.'/'.$content;
        if(!in_array($content, $invisibleFileNames) && !in_array($content, $skipNames)) {
             if( $option=="files" && is_file($path) && is_readable($path)) {
                // if option is "files" & content is a file & readable then
                // save file name with path
                $nameList[] = $path;
             } elseif(is_dir($path) && is_readable($path)) {
                if ( $option=="folders") {
                    // if option is  "folders" (& content is a directory & readable) then
                    // add path and name
                    $nameList[] = $path;
                }
                // recursive callback to open sub directory
                $retval= list_folder($option, $path, $skipNames,$nameList );
                if ($retval!=0) return $retval;
             }
        }
    }
    return $retval;
}
