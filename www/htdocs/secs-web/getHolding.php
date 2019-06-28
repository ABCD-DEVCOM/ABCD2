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
//HLDGMODULE
    if (count($_REQUEST['YEAR'])>0 || $h == "" || !$h){
        $hldgModule = new hldgModule($_SESSION['centerCode'],
        BVS_ROOT_DIR."/"."hldgChronOrder",
          $configurator->getPath2Facic(),
          $configurator->getPath2Holdings(),
          $configurator->getPath2Title(),
          HLDGMODULE_TAG,
          BVS_DIR."/cgi-bin/",
          BVS_TEMP_DIR);

//echo 'hldgModule='.$hldgModule."<BR>";
//echo "ccode=".$_SESSION['centerCode']."<BR>";
/*
echo BVS_ROOT_DIR ."<BR>";
echo HLDGMODULE."<BR>";
echo $configurator->getPath2Facic()."<BR>";
echo $configurator->getPath2Holdings()."<BR>";
echo $configurator->getPath2Title()."<BR>";
echo HLDGMODULE_TAG."<BR>";
echo BVS_DIR."/cgi-bin/"."<BR>";
echo BVS_TEMP_DIR."<BR>";
echo HLDGMODLE_DEBUG."<BR>";
var_dump($_REQUEST);  echo "<BR>";
//die;
*/
            if (count($_REQUEST['YEAR'])>0){
            echo "YEAR=".$_REQUEST['YEAR']. "<BR>";
                    $hldgModule->setTempIssues($_REQUEST['YEAR'], $_REQUEST['VOLU'], $_REQUEST['FASC'], $_REQUEST['TYPE'], $_REQUEST['STAT'], $_REQUEST['SEQN'],$_REQUEST['MASK']);

            }
            $h = $hldgModule->execute($_REQUEST['title'], HLDGMODULE_DEBUG);

    }

    if($h == ""){
        $h = "no holdings info available for library <i>" . $_SESSION['centerCode'] . "</i>";
    }
    
    echo $h;
?>
