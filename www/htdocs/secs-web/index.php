<?php 

/**
 * @file:	index.php
 * @desc:	Main file, System Controller 
 * @author:	Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:	Domingos Teruel <domingos.teruel@bireme.org>
 * @since:      2008-01-11
 * @copyright:  (c) 2008 BIREME/PAHO/WHO - PFI
 ******************************************************************************/

/**
 * Main include file of the system, it contains all the parameters required for
 * the operation of this system..
 */
 //include("crud_mx.php");
require_once("./common/ini/config.ini.php");

//User not logged in System
if(!isset($_SESSION["identified"]) || $_SESSION["identified"]!=1 ) 
{
    list($libraryName, $libraryCode) = getAllLibraries();
    $smarty->assign("collectionLibrary",$libraryName);
    $smarty->assign("codesLibrary",$libraryCode);
  
    //User trying to log-in
    if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_GET["action"]) && !preg_match("=/=",$_GET["action"]) ) {
        if ($_REQUEST["field"]["action"]=="do")
        {
        $misession = new sessionManager();
        $checkUserPwd = $misession->checkLogin($_REQUEST["field"]["username"],$_REQUEST["field"]["password"],$_REQUEST["field"]["selLibrary"]);
        switch ($checkUserPwd) {
            case "OK":
                unset($_GET["action"]);
                $page = 'index';
                $smartyTemplate = "homepage";
                $listRequest = "homepage";
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "Error1":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorLogIn"],E_USER_ERROR);
                break;
            case "Error2":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorWrongLibrary"],E_USER_ERROR);
                break;
            case "Error3":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorSelectLibrary"],E_USER_ERROR);
                break;
        }
        }
    }
    }else{
        //User not logged in System, show login page
        $page = 'index';
        $smartyTemplate = "login";
        $listRequest = "login";
    }
}else{
//From here users logged in the system

//User doing logoff
if ($_GET['action'] == "signoff") {
	
    unset($_SESSION);
    session_destroy();
    $page = 'index';
    $smartyTemplate = "login";
    $listRequest = "login";
    list($libraryName, $libraryCode) = getAllLibraries();
    $smarty->assign("collectionLibrary",$libraryName);
    $smarty->assign("codesLibrary",$libraryCode);

}else{

    //Preventing passing variable by URL, if not logged
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $tentLogin = $_GET["action"];
        $tentAcesBase =  $_GET["m"];
        if (!preg_match("/^[a-z_.\/]*$/i", $tentAcesBase) && preg_match("/\\.\\./i", $tentAcesBase)) {
            user_error($BVS_LANG["error404"],E_USER_ERROR);
        }elseif(!preg_match("/^[a-z_.\/]*$/i", $tentLogin) && preg_match("/\\.\\./i", $tentLogin)){
            user_error($BVS_LANG["error404"],E_USER_ERROR);
        }
    }

    $listRequest = $_GET["m"]; 
    $page = "index";

    //Set witch dataModel to use
    if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])){
        switch ($_GET["m"]) {
            case "mask":
                if($_SESSION["role"] == "Administrator")
                    $dataModel = new mask();
                else
                    die($BVS_LANG["error404"]);
                break;
            case "title":
                $dataModel = new title();
                break;
            case "users":
                $dataModel = new user();
            break;
            case "facic":
                $dataModel = new facicOperations();
                break;
            case "titleplus":
                if($_SESSION["role"] == "Editor" || $_SESSION["role"] == "Administrator")
                    $dataModel = new titleplus();
                else
                    die($BVS_LANG["error404"]);
                break;
            case "library":
                $dataModel = new library();
                break;
            case "report":
                $dataModel = false;
                break;
            case "maintenance":
                $dataModel = false;
                break;
            case "export":
                $dataModel = false;
                break;
            default:
            die($BVS_LANG["error404"]);
        }
    }else{
        $dataModel = array();
    }

    //Setting total records value based in permission
    if($_GET["m"] == ""){
        switch ($_SESSION["role"]) {
            case "Administrator":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "AdministratorOnly":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                break;
            case "Editor":
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "Operator":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
        }
    }


    // CHECKING ACTION
    if (!isset($_GET["edit"]) && !isset($_GET["delete"]) && $_GET['hldg']=='execute'){
            $myAction = 'holdings';
    } elseif (isset($_GET["edit"]) && !preg_match("=/=",$_GET["edit"])) {
        if ($_GET['edit'] == 'validation'){
            //$myAction = 'validation';
            $formValidation = validation($_GET["m"]);
            //var_dump($formValidation);
            if($formValidation == false){
               foreach ($errorField as $key => $value) {
                        print_r ("erro no campo " .$errorField[$key]." <br>");
               }
            }else{
                $myAction = 'save';
            }
            //die(" fimm");
        } elseif ($_GET['edit'] == 'save' && $_REQUEST["gravar"]!="false") {
            $myAction = 'save';
        } else {
            if ($_GET["edit"]=="save"){
                $myAction = 'save?';
            } else {
                $myAction = 'edit?';
            }
        }

    } elseif (isset($_GET["delete"])){
        $myAction = 'delete';
    } elseif (isset($_GET["action"]) && !preg_match("=/=",$_GET["action"]) && $_GET["action"] != "signin") {
         switch ($_GET["action"]){
            case 'delete':
                $myAction = 'confirm_delete';
                break;
            case 'exist':
                $myAction = 'exist';
                break;
            default:
                $myAction = 'new';
                break;
            }
    } elseif (isset($_GET["export"]) && !preg_match("=/=",$_GET["export"])){
        $myAction = 'export';
    }elseif (isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])) {
        if (isset($_GET["delete"])){
            $myAction = 'delete';
        } else {
            $myAction = 'list';
        }

    } elseif (isset($_GET["delete"]) == "delete"){
        $myAction = 'delete';
    } else {
        $myAction = 'no_action';
    }

    switch ($myAction){
        case 'holdings':
            $hldgModule = new hldgModule($_SESSION['centerCode'], BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
            $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
            echo '<!-- [action]holdings[/action] -->'.'<!--'.$call.'-->';
            die();
            break;
        case 'exist':
            if ($dataModel->searchByTitle($_GET["title"])){
                echo 'EXIST';
            } else {
                echo 'DOES_NOT_EXIST';
            }
            die();
            break;
        case 'save':
            // part 1
            if(is_array($_REQUEST["field"])){
                $r = $dataModel->createRecord($_REQUEST["field"]);

                if(is_int((int)$_REQUEST["mfn"]) && $_REQUEST["mfn"] != 0) {
                    $dataModel->saveRecord($_REQUEST["mfn"]);  //Updating a register
                    $thisMfn = $_REQUEST["mfn"];
                }else{
                    $thisMfn = $dataModel->saveRecord("New"); //Saving new register
                }
                if($listRequest == "mask"){
                sortMaskByAlphabet();
                }
            }else{
                user_error($BVS_LANG["error404"],E_USER_ERROR);
            }
            // part 2
// esse condição parece não acontecer nunca.
// Verificar necessidade.
//            if($listRequest == "titleplus"){
//                $titleSearch = new titleplus();
//                $titleFound = $titleSearch->searchByTitle($_GET["title"]); //search titlePlus by title
//                if ($titleFound){
//                    echo "<h1>passei por aqui<h1/>";
//                    $editRequest = $titleFound->registro->mfn; //if search is ok, add mfn from search to edit in titleplus
//                    $_GET["edit"] = $editRequest;
//                }else{
//                    $_GET["edit"] = "";
//                    $_GET["action"] = "new";
//                }
//            }
            $smarty->assign("formRequest",$listRequest);

            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));

            if ($listRequest == "facic"){
                if ($_REQUEST["recid"]){
                    echo "<!-- [request]";
//                    var_dump($_REQUEST);
                    echo "[/request] -->";
                    echo "<!-- [recid]".$_REQUEST["recid"]."[/recid] -->";
                    echo "<!-- [mfn]".$thisMfn."[/mfn] -->";
                    echo '<!-- [action]save[/action] -->';
                }

                /*
                 * hldgModule can be executed in two situations:
                 * 1) After each update or delete action on a record of FACIC
                 * 2) After several update or delete actions on FACIC
                 *
                 * hldgModule is executed only when  $_REQUEST['hldg']=='execute'
                 */
                if ($_REQUEST["title"] && $_REQUEST['hldg']=='execute'){
                    $hldgModule = new hldgModule($_SESSION['centerCode'], BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
                    $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
                    echo '<!-- [action]holdings[/action] -->';
                }
            }
            break;

        case 'new':
            if($listRequest == "mask" ) {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
                $smarty->assign("mfnMask",$dataModel->getAllMfnMask());
            }
            $smarty->assign("formRequest",$listRequest);
            $smarty->assign("dataRecord",array());
            //echo "NEW "; die;
            break;

        case 'list':

            $smartyTemplate = "list";
            if(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
                $smarty->assign("searcExpr",$_REQUEST["searchExpr"]);
            }
            if($dataModel != false){
                //search in Database to show a List(YUI datatable)
                $smarty->assign("dataSource", $dataModel->getRecords());
                $smarty->assign("totalRecords", $dataModel->getTotalRecords());
            }
            exportTitle($_GET["export"]);

            //FACIC
            if ($listRequest == 'facic'){
                $mask = new mask();
                $collectionMask = $dataModel->getAllNameMask();
                $smarty->assign("collectionMask",$collectionMask);
                $futureIssues = new futureIssues();
                $yCurrent = $_REQUEST['initialDate'];
                if ( $dataModel->getTotalRecords() == 0){
                    if ($_REQUEST["maskId"]){
                        $maskId = $_REQUEST["maskId"];

                    }
                } else {
                    $last = $dataModel->lastFacicData();
                    $yCurrent = $last[911];
                    $test = array_search($last[910],$collectionMask);
                    if ( $collectionMask[$test] == $last[910]  ){
                        $maskId = $last[910];
                    } else {
                        $maskId = '';
                    }
                }
                $smarty->assign("currentMask",$maskId);

                $x='var initialVolume = "'.$_REQUEST["initialVolume"].'";'."\n";
                $x.='var initialNumber = "'.$_REQUEST["initialNumber"].'";'."\n";
                $x .= 'var collectionMask = new Array('.count($collectionMask).');' . "\n" ;
                for ($i=0;$i<count($collectionMask);$i++){
                    $x .= 'collectionMask['.$i.'] = "'.str_replace(chr(92),chr(92).chr(92),$collectionMask[$i]).'";'."\n" ;
                }
                for ($y=$yCurrent;$y < date("Y"); $y++){
                    $yearList[] = $y;
                }
                $smarty->assign("x",$x);
                $smarty->assign("yearList",$yearList);
            }
            break;

        case 'confirm_delete':
            if ($_POST["recid"]){
            echo "<!-- [recid]".$_POST["recid"]."[/recid] -->";

            } else {
            user_warning($BVS_LANG["confirmDelete"]);
            }
            break;

        case 'delete':
            $dataModel->deleteRecord($_GET["delete"]);
            if ($_GET["m"] == 'titleplus'){
                if ($_REQUEST["title"]){
                    $facicList = new facicOperations();
                    $facicList->multipleDelete($_REQUEST["title"]);
                }
            }
            if ($_GET["m"] == 'facic'){
                
                /*
                 * The implementation of this section is made when the user
                 * does "save" for the records marked as D in the list of FACIC
                 * getting unnecessary reload the list
                 */
                if ($_REQUEST["recid"]){
                   /*
                    * echo obligatory, used as a return of execution and
                    * used in facic.list.tpl.php
                    */
                    echo "<!-- [request]";
                    var_dump($_REQUEST);
                    echo "[/request] -->";
                    echo "<!-- [recid]".$_REQUEST["recid"]."[/recid] -->";
                    echo "<!-- [mfn]deleted[/mfn] -->";
                    echo '<!-- [action]delete[/action] -->';
                }
                if ($_REQUEST["title"] && $_REQUEST['hldg']=='execute'){
                    $hldgModule = new hldgModule($_SESSION['centerCode'],BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
                    $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
                    echo '<!-- [action]holdings[/action] -->';
                }
            } else {
                
                /*
                 * For other databases, the list of its records is reloaded
                 * after the implementation of delete
                 */
                $smartyTemplate = "list";
                //search in Database to show a List(YUI datatable)
                if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"]) && $_GET["m"]!=""){
                    if(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
                        $smarty->assign("searcExpr",$_REQUEST["searchExpr"]);
                    }
                    $smarty->assign("dataSource",$dataModel->getRecords());
                    $smarty->assign("totalRecords",$dataModel->getTotalRecords());
                }
            }
            break;
        case 'no_action':
            //Logged user - no action
            unset($_GET["action"]);
            $page = 'index';
            $smartyTemplate = "homepage";
            $listRequest = "homepage";
            break;
        case 'save?':
            // part 1 - Open a form to edit a record
            $smartyTemplate = "form";
            $editRequest = $_POST["mfn"];

            // part 2
/*
 * Para atualizar um registro TitlePlus já existente.
 */
            if($listRequest == "titleplus") {
                $titleSearch = new titleplus();
                $titleFound = $titleSearch->searchByTitle($_GET["title"]);
                if ($titleFound) {
                    $editRequest = $titleFound->registro->mfn;
                    if(is_array($_REQUEST["field"])) {
                        $dataModel->createRecord($_REQUEST["field"]);
                        if(is_int((int)$_REQUEST["mfn"]) && $_REQUEST["mfn"] != 0) {
                            $dataModel->saveRecord($_REQUEST["mfn"]);  //Updating a register
                        }
                    }
                }else {
/*
 * Para criar um novo registro TitlePlus apartir da planilha da Title.
 */
                    if(is_array($_REQUEST["field"])) {
                        $dataModel->createRecord($_REQUEST["field"]);
                        $dataModel->saveRecord("New");  //new register
                    }
                }
            }
            $smarty->assign("formRequest",$listRequest);

            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));
            break;
        case 'edit?':
            
            $smartyTemplate = "form";
            $editRequest = $_GET["edit"];

            if($listRequest == "titleplus"){
                $titleSearch = new titleplus();
                $titleFound = $titleSearch->searchByTitle($_GET["title"]);

                if ($titleFound){
                    $editRequest = $titleFound->registro->mfn;
                    $_GET["edit"] = $editRequest;
                }else{
                    $_GET["edit"] = "";
                    $_GET["action"] = "new";
                }
            }

            $smarty->assign("formRequest",$listRequest);
            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));
            break;

         case 'export':

            $openExportedFile = displayExport();
            if($openExportedFile == "no content"){
                //user_error($openExportedFile, E_USER_ERROR);
            }else{
                header("Location: ".$openExportedFile);
            }
            break;
    }


    // Add a Title in $titleCode - to use in Issues and TitlePlus
    if(isset($_GET["title"]) && !preg_match("=/=",$_GET["title"])) {
        $smarty->assign("titleCode",$_GET["title"]);
    }

    switch ($listRequest) {
    case "users":
        //After save own profile, user redirect to homepage
        if($_SESSION["role"] != "Administrator" && $smartyTemplate == "list"){
            $listRequest = "homepage";
            $smartyTemplate = "homepage";
            $_GET["m"] = "";
        }
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);

        break;
    case "titleplus":
        if($smartyTemplate == "form"){
        $TITLE_CONTENT = titPlusHeaderInfo($listRequest, $smartyTemplate, $_GET["title"]);
        $smarty->assign("OBJECTS_TITLE",$TITLE_CONTENT);
        }
        break;
    case "report":
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);
        $smarty->assign("listRequestReport","report");
        $smartyTemplate = "homepage";
        break;
    case "maintenance":
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);
        $smarty->assign("listRequestReport","report");
        $smartyTemplate = "homepage";
        break;
    }
		
}
}

// Register main Smarty Template variables, $smartyTemplate and $listRequest



$smarty->assign("smartyTemplate",$smartyTemplate);
$smarty->assign("listRequest",$listRequest);
$vars = array();
$smarty->assign("OBJECTS",$vars);
$smarty->assign("BVS_CONF",$BVS_CONF);
$smarty->assign("BVS_LANG",$BVS_LANG);
// Displays the template assembled
$smarty->assign("today",date("Ymd"));
$smarty->display($page.'.tpl.php');

?>