<?php
/* Modifications
20210312 fho4abcd Created
*/
/*
** Execute function get_dbinfo
*/

/*--------------------------------------------------------------
** Function  : Get info about the current database from the database
**             The info is requested by wxis_llamar.php (Opcion=status)
**             The info is returned in an array
** Globals   : This function uses wxis_llamar.php (with many globals)
**   $arrHttp: I/O specifies at least the current database
**   $xWxis  : I   path to the wxis scripts .xis for Central
**   $db_path: I   path where the databases are located
*/
// 
function get_dbinfo () {
    global $arrHttp, $xWxis, $db_path;
    if ( !isset($arrHttp["base"]) or $arrHttp["base"]=="undefined" or $arrHttp["base"]==""){
    ?>
    <H3><font color=red>This script: <br><?php echo __FILE__;?><br>
    included by <b><?php echo pathinfo(debug_backtrace()[0]['file'])['basename'];?></b><br>
    requires the name of the database via $arrHttp["base"]<br>
    This is a coding error</font></H3>
    <?php
         die;
    }
    $IsisScript=$xWxis."administrar.xis";
    $query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
    include("../common/wxis_llamar.php");
    if ( $err_wxis!="" ) die;

    $dbinfo_ix=-1;
    if (isset($contenido )) {
        foreach($contenido as $dbinfo_linea) {
            $dbinfo_ix=$dbinfo_ix+1;
            if ($dbinfo_ix>0) {
                if (trim($dbinfo_linea)!=""){
                    $dbinfo_a=explode(":",$dbinfo_linea);
                    if (isset($dbinfo_a[1])) $arrHttp[$dbinfo_a[0]]=$dbinfo_a[1];
                }
            }
        }
    }
    // Return at least one value
    if (!isset($arrHttp["MAXMFN"]))   $arrHttp["MAXMFN"]=0;
return;
}
get_dbinfo();
