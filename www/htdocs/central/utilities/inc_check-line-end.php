<?php
/* Modifications
20210426 fho4abcd Created
20210605 fho4abcd Extra check if there is no lineend. (was an error, now only a remark)
*/

/*--------------------------------------------------------------
** Function  : Checks the line ending of the given file
**             The line-ends must fit the current operating system
**             In case of wrong lineends the function will die with a message to correct it
**             Only the first line-end ic checked. It is assumed that the rest is the same.
** Usage     : include "inc_check-line-end.php";
**             if ( check_line_end($file) != 0 ) // error processing
** Parameters: - $filename : full path of file to check
** Returns   : 0 : no errors occured. linenends match
**             1 : error reading the file
**             2 : line-ends mismatch
** Messages  : Shows a message if lineends are correct and a failure message in case of errors
*/
// 
function check_line_end($filename) {
    global $msgstr;
    $retval=0;
    // Test for correct lineendings: mx will fail with wrong lineends
    $actlinend="";$strlinend="?";$oslinend="??";
    $handle = @fopen($filename, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            // process the line read.
            if ( strpos($line,"\r\n") !== false) { $strlinend="CRLF";$actlinend="\r\n";break;}
            if ( strpos($line,"\r")   !== false) { $strlinend="CR";$actlinend="\r";break;}
            if ( strpos($line,"\n")   !== false) { $strlinend="LF";$actlinend="\n";break;}
        }

        fclose($handle);
    } else {
        $contents_error= error_get_last();
        echo "<font color=red>".$msgstr["copenfile"]." <b>".$filename.":</b> ".$contents_error["message"]."</font><br><br>";
        return 1;
    }
    if (strcmp(PHP_EOL,"\r\n")==0) $oslinend="CRLF";
    if (strcmp(PHP_EOL,"\r")==0)   $oslinend="CR";
    if (strcmp(PHP_EOL,"\n")==0)   $oslinend="LF";
    if (strcmp(PHP_EOL,$actlinend)==0) {
        echo $msgstr["lineendsof"]." $filename: $strlinend &rarr; ".$msgstr["isok"];
        return 0;
    } else if ( strcmp($actlinend,"")==0) {
        echo "<font color=blue>".$msgstr["error"].": ".$msgstr["lineendsof"]." $filename: <b>$strlinend &rarr; Show MIGHT fail </b></font>";
        return 0;
    } else {
        echo "<font color=red>".$msgstr["fatal"].": ".$msgstr["lineendsof"]." $filename: <b>$strlinend</b> &rarr; Please correct to <b>$oslinend</b></font>";
        return 2;
    }
 return $retval;
}
