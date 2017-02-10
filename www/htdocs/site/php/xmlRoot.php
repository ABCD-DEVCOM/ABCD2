<?php

$xmlRootPath = dirname(__FILE__).'/';

require_once($xmlRootPath . '../admin/auth_check.php');
require_once($xmlRootPath . '../php/include.php');
require_once($xmlRootPath . "./xmlRoot_functions.php");

$xml = ( $xml != "" ? $xml : $_REQUEST['xml'] );
$xsl = ( $xsl != "" ? $xsl : $_REQUEST['xsl'] );
$lang = ( $lang != "" ? $lang : $_REQUEST['lang'] );
$page = ( $page != "" ? $page : $_REQUEST['page'] );

$xslSave = $_REQUEST['xslSave'];
$xmlSave = $_REQUEST['xmlSave'];

check_parameters();
$check_login = false;
if (preg_match("/(adm.xml)|(users.xml)/i",$checked['xml'])  ){
    $checked['xml'] = file_get_contents(DEFAULT_DATA_PATH . $checked['xml']);
    $check_login = true;
} else if ( preg_match("/adm/i",$checked['xsl']) || isset($xmlSave) ){
    $check_login = true;
}

if ( $check_login ){
    auth_check_login();
}

$xmlContent = BVSDocXml("root",$checked['xml']);

if ( isset($_REQUEST['debug']) ){
    debug($_REQUEST['debug']);
}

$xsl_params = array();
if ( isset($checked['portal']) ){
    $xsl_params['portal'] = $checked['portal'];
}

if ( isset($xslSave) )
{
    $xslSave = "../" . $checked['xslSave'];

    try {
        $sucessWriteXml = xmlWrite($xmlContent,$xslSave,$checked['xmlSave'],$xsl_params);
        if ( $sucessWriteXml != '' && $checked['page'] != 'users' ){

            // generate html
            $xsl_params['lang'] = $lang;
            htmlWrite($sucessWriteXml,$xsl_params);

            // generate ini
            iniWrite($sucessWriteXml,$xsl_params);

            if ($checked['page'] == 'collection' || $checked['page'] == 'topic'){
                // generate metaiah define xml
                defineMetaIAHWrite();
            }
        }
    } catch (Exception $php_errormsg) {
        $php_errormsg = htmlentities($php_errormsg);
        $php_errormsg = str_replace("\n", '<br/>', $php_errormsg);
        include('../admin/templates/error.php');
        return;
    }


    if ( isset($xmlT) ){
        if ( $xmlT == "saved" ){
            $xmlContent = BVSDocXml("root",$checked['xmlSave']);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF'] . '?xml=' . $xml . '&xsl=' . $xsl
                        .'&lang='.$lang
                        .(isset($checked['portal'])?'&portal='.$checked['portal']:''));

    return;
}

$xslTransform = SITE_PATH . $checked['xsl'];


if ( $debug == "XSL" ) { die($xslContent); }

if ( isset($checked['xsl']) ){
    print(processTransformation($xmlContent,$xslTransform,$xsl_params) );
} else {
    print($xmlContent);
}

?>

