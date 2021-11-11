<?php
/* Modifications
20210903 fho4abcd Created
20211111 fho4abcd Allow empty and comment lines
*/
/*
** Contains functions explicitly for digital document functionality
** -- read_dd_cfg
** -- remove_v
*/
/*--------------------------------------------------------------
** Name      : read_dd_cfg
** Function  : Read the content of the collection configuration file
** Usage     : include "inc_coll_read_cfg.php";
**             $metadataMap=array();
**             if ( read_dd_cfg($option, $metadataConfigFull, &$metadataMapCnt, $metadataMap) != 0 ) // error processing
** Parameters: - $option  : "config"  : No printed error if cfg file does not exist
**                          "operate" : Print error if cfgfile does not exist
**             - $metadataConfigFull  : Full path to the configuration file
**             - $metadataMapCnt      : Number of found terms (=size of $metadataMap)
**             - $metadataMap         : Array of arrays with "term" and "field"
** Returns   : 0 : no errors occured.
**             1 : wrong option
**             2 : cfg file does not exist
**             3 : Errors while reading the cfg file
** Messages  : Shows a failure message in case of errors
*/
function read_dd_cfg($option, $metadataConfigFull, &$metadataMapCnt, &$metadataMap) {
    global $msgstr;
    $errprefix="<div style='color:red'>ERROR in ".__FILE__."&rarr; ";
    $retval=0;
    if ( $option!="config" and $option!="operate") {
        echo  $errprefix."Option $option is invalid";
        return(1);
    }
    $fp=@fopen($metadataConfigFull,"r");
    if ($fp===false && $option=="config") {
        // Configuration does not need an error
        return(2);
    } else if ($fp===false) {
        echo "<div style='color:red'>".$msgstr["dd_cfgfile"]." &rarr;".$metadataConfigFull."&larr; ".$msgstr["dd_notexist"]."<br>";
        echo $msgstr["dd_request_admin"].": ".$msgstr["dd_config"]."</div>";
        return(2);
    }
    // If the file is found: return the information
    echo "<p>".$msgstr["dd_map_read"]." ".$metadataConfigFull."</p><br>";
    $metadataMapCnt=0;
    while ( ($line=fgets($fp))!=false){
        $line=rtrim($line); // remove trailing white space(inc cr/lf)
        // Lines with // and lines with # are skipped
        // Lines that cannot caontain valid information are skipped
        if ( strlen($line)<4 ) continue;
        if ( stripos($line,'//') !== false ) continue;
        if ( stripos($line, '#') !== false ) continue;
        $linecontent=explode("|",$line);
        $term=$linecontent[0];
        $field="";
        if (isset($linecontent[1])) $field=$linecontent[1];
        $metadataMapCnt++;
        $metadataMap[]=array("term"=>$term, "field"=>$field);
    }
    return $retval;
}
/*--------------------------------------------------------------
** Name      : remove_v
** Function  : Remove a possible prefix "v" from the fieldname
** Usage     : include "inc_coll_read_cfg.php";
**             $vurl = remove_v($_POST["url"]);
** Parameters: - $field  : The content of the field
** Returns   : The field without prefix
*/
function remove_v($field) {
    $field=trim($field);
    if (isset($field[0])) {
        if (($field[0]=='v') or ($field[0]=='V')) {
            $field=str_replace( 'v','',strtolower($field));
        }
    }
    return $field;
}