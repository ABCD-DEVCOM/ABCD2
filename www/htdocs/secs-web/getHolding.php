<?php
//ini_set('display_errors',1);
require_once("./common/ini/config.ini.php");

/*
 * Erro se o usuarios nao esta logados no sistema
 */
if(!isset($_SESSION["identified"]) || $_SESSION["identified"]!=1 )
{
	die($BVS_LANG["error404"]);
}	

    $dataModel = new facicOperations();
    if (count($_REQUEST['YEAR'])==0){
            $h = $dataModel->getRealHolding($_REQUEST['title']);
            if (strpos(' '.$h,'converting')>0){
                    $h = '';
            }
    }

    if (count($_REQUEST['YEAR'])>0 || $h == "" || !$h){
        $hldgModule = new hldgModule($_SESSION['centerCode'], BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);

            if (count($_REQUEST['YEAR'])>0){
                    $hldgModule->setTempIssues($_REQUEST['YEAR'], $_REQUEST['VOLU'], $_REQUEST['FASC'], $_REQUEST['TYPE'], $_REQUEST['STAT'], $_REQUEST['SEQN']);
            }
            $h = $hldgModule->execute($_REQUEST['title'], HLDGMODULE_DEBUG);

    }

    if($h == ""){
        $h = "empty";
    }
    
    echo $h;
?>
