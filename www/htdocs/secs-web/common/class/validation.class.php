<?php

/*
 * Function of form validation
 * @param page name of the form section
 */
function  validation($page){

    global $BVS_LANG, $errorField, $errorMsg, $checkfieldsError;
    switch ($page){
        case 'title':
            $valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
        case 'users':
            //$valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
        case "mask":
            //$valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
        case "facic":
            //$valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
        case "titleplus":
            //$valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
        case "library":
            //$valFormTitle = checkTitleForm();
            return $valFormTitle;
            break;
    }
}

/*
 * Function of Title form validation
 */
function checkTitleForm(){
    
    global $errorField, $errorMsg, $checkfieldsError;
    $checkfieldsError = true;
    $errorField = array();
    $errorMsg = array();

    valField50Title();
    valField310Title();
    //var_dump($checkfieldsError);
    return $checkfieldsError;

}

/*
 * Validation of field 50 in Title form
 */
function valField50Title(){

    global $BVS_LANG, $errorField, $errorMsg, $checkfieldsError;
    //print $_REQUEST["publicationStatus"];
	if ($_REQUEST["publicationStatus"] == "D" && $_REQUEST["finalDate"] == ""){
		$message = $BVS_LANG["msgErrorPublicationStatus"] . $BVS_LANG["lblfinalDate"] . $BVS_LANG["msgErrorShouldBeFilled"];
                array_push($errorField, "50");
                array_push($errorMsg, $message);
                $checkfieldsError = false;
	}
}

/*
 * Validation of field 310 in Title form
 */
function valField310Title(){

    global $BVS_LANG, $errorField, $errorMsg;

	if ($_REQUEST["country"] == "BR" && $_REQUEST["state"] == ""){
		$message = $BVS_LANG["msgErrorCountry"] . $BVS_LANG["lblstate"] . $BVS_LANG["msgErrorShouldBeFilled"];
                array_push($errorField, "310");
                array_push($errorMsg, $message);
                $checkfieldsError = false;
	}
}

?>
