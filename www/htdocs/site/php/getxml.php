<?php
/**
 * Allow remote access to xml files of bvs-site
 *
 *
 * PHP version 5
 *
 * Edit this file in ISO-8859-1 - Test String αινσϊ
 */
include("include.php");

//include.php verifica parametros obrigatorios lang e id 

if ( isset($localPath["xml"]) ) {

    
    if ( isset($_GET['component']) ) {
        // use checked component (created on include.php file)
        $xml_name = $checked['component'] . ".xml";
        
    }else{
        if ( isset($_GET['name']) && ereg("^[a-zA-Z\_\-]+$", $_GET['name']) ){            
            $xml_name = $_GET['name'] . ".xml";    
        }else{        
            die("no content");
        }    
    }

    $xml_file = $localPath["xml"] . $xml_name;    
    
    header("Pragma: no-cache");
    header("Expires:  -1");
    header("Content-Type: text/xml; charset=\"ISO-8859-1\"");
    
    readfile($xml_file);

}else{
    header("HTTP/1.0 404 Not Found");
    
}        

?>
