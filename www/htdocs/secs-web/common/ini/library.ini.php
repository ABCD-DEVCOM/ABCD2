<?php
/**
 * @desc        Library controller file
 * @package     [ABCD] SeCS-Web
 * @version     1.0
 * @author      Bruno Neofiti <bruno.neofiti@bireme.org>
 * @since       August 04, 2009
 * @copyright   (c)BIREME - PFI - 2009
 * @public
*/

/*
 * This files set $LIBDIR to the user see what library is in use
 */
    if (isset($_REQUEST["library"]) && isset($_REQUEST["role"]) && isset($_REQUEST["libName"]) &&  isset($_REQUEST["libSel"]))
    {
        if (in_array($_REQUEST["role"],$_SESSION["optRole"]))
        {
            $LIBDIR = $_REQUEST["library"];
            $_SESSION["libraryDir"] = $_REQUEST["library"];
            $_SESSION["librarySel"] = $_REQUEST["libSel"];
            $_SESSION["library"] = $_REQUEST["libName"];
            $_SESSION["role"] = $_REQUEST["role"];
        }

    }else{

        if (isset($_REQUEST["action"]) && $_REQUEST["action"] == "signin"){
            $LIBDIR = $_REQUEST["field"]["selLibrary"];
        }else{
            if(isset($_SESSION["libraryDir"])){
                $LIBDIR = $_SESSION["libraryDir"];
            }
        }        
    }

    //In case of everything goes wrong
    if(!isset($LIBDIR)){
        $LIBDIR = "main";
        $_SESSION["libraryDir"] = "main";
    }
    
$BVS_CONF['PATH2FACIC'] = BVS_DATABASE_DIR.$LIBDIR."/facic";
$BVS_CONF['PATH2TITLEPLUS'] = BVS_DATABASE_DIR.$LIBDIR."/titlePlus";
$BVS_CONF['PATH2HOLDINGS'] = BVS_DATABASE_DIR.$LIBDIR."/holdings";
$BVS_CONF['PATH2TEMPFACIC'] = BVS_DIR."/temp/secs-web/temp_facic";

?>
