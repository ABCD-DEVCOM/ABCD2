<?php
require_once("../php/common.php");
require_once("../php/include.php");

require_once("auth_check.php");

auth_check_login();

$xml = simplexml_load_file( DEFAULT_DATA_PATH . 'xml/subportals.xml');
$items = count($xml->item);

$subportals = array();
for ($i = 0; $i < $items; $i++){
    $subportals[ (String) $xml->item[$i]['id'] ] = utf8_decode( (String) $xml->item[$i] );
}
unset( $xml, $i);

$xml_path = $def['DEFAULT_DATA_PATH'].'xml/subportals.xml';
$des = preg_replace('/[^\/]+\/$/', '', $def['DEFAULT_DATA_PATH']);

$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
$xml .= "\n<subportal>";
$xml .= "%s";
$xml .= "\n</subportal>";
$newXml = '';


if( $_REQUEST['action'] === 'add' && isset($_REQUEST['addname']) ){
    $add_name = preg_replace(
        '/[^À-ÖØ-öø-ÿ\w\-_\(\)\[\] ]+/',
        ' ', $_REQUEST['addname']
    );
    $dir_name = normalize_xml_id( $add_name );
    recurse_copy($def['DEFAULT_DATA_PATH'], $des.$dir_name);
    $subportals[$dir_name] = $add_name;
    unset($add_name,$dir_name);
} else if( $_REQUEST['action'] === 'del'){
    $del_name = $_REQUEST['subportal'];
    
    if( file_exists($des.$del_name) ){
        for( $i = 0; file_exists($des.'=DEL='.$i.'='.$del_name); $i++ );
        rename($des.$del_name, $des.'=DEL='.$i.'='.$del_name);
        unset( $subportals[$del_name] );
    }
    unset($del_name);
} else if( $_REQUEST['action'] === 'ren'){
    $new_name = preg_replace(
        '/[^À-ÖØ-öø-ÿ\w\-_\(\)\[\] ]+/',
        ' ',
        $_REQUEST['rename']
    );
    $dir_name = normalize_xml_id( $new_name );
    $old_dir_name = $_REQUEST['subportal'];

    if( file_exists($des.$old_dir_name) ){
        rename($des.$old_dir_name, $des . $dir_name);
        unset( $subportals[$old_dir_name] );
        $subportals[$dir_name] = $new_name;
    }
    unset($new_name,$old_dir_name,$dir_name);
}

$dh  = opendir($des);
while (false !== ($directory = readdir($dh))) {
    if(!preg_match('/^(\.|=DEL=|site)/', $directory) ){
        if( isset($subportals[$directory]) ){
            $name = $subportals[$directory];
            $newXml .= "\n    <item id=\"$directory\">$name</item>";
        }
    }
}

$newXml = sprintf($xml,$newXml);

$handler = fopen($xml_path,'w');
fwrite($handler, $newXml);
fclose($handler);



header('Location: edit_subportal.php');
?>