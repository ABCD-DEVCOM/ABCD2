<?php
/* Modifications
20210322 fho4abcd Created
*/
/*
** Execute function get_dblongname
*/

/*--------------------------------------------------------------
** Function  : Get info about the current database from the database
** Returns   : $arrHttp["dblongname"]
** Globals   :
**   $arrHttp: I/O I: the current database
**   $db_path: I   path where the databases are located
*/
function get_dblongname () {
    global $arrHttp, $db_path;
    if ( !isset($arrHttp["base"]) or $arrHttp["base"]=="undefined" or $arrHttp["base"]==""){
        ?>
        <H3><font color=red>This script: <br><?php echo __FILE__;?><br>
        included by <b><?php echo pathinfo(debug_backtrace()[0]['file'])['basename'];?></b><br>
        requires the name of the database via $arrHttp["base"]<br>
        This is a coding error</font></H3>
        <?php
        die;
    }
    $arrHttp["dblongname"]="long name not found"; // default value in case of errors
    $fullbasesdotdat=$db_path."bases.dat";
    if (!file_exists($fullbasesdotdat)){
        echo "<h3><font color=red>".$fullbasesdotdat.": Does not exist</font></h3>";
    } else {
        $fp=file($fullbasesdotdat);
        foreach ($fp as $value){
            if (trim($value)!=""){
                $baseslinearr=explode('|',$value);
                if ($baseslinearr[0]==$arrHttp["base"]) {
                    if (isset($baseslinearr[1]) and trim($baseslinearr[1])!="" ) {
                        $arrHttp["dblongname"]= $baseslinearr[1];
                    }
                    break;
                }
            }
        }
    }
return;
}
get_dblongname();
