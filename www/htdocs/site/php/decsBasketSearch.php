<?php
session_start();
include("include.php");

$connector  = $_REQUEST["connector"];
$termList = $_SESSION["terms"];
$lang = $_REQUEST["lang"];
$expression = "";

if ($def['IAHX_SEARCH_URL'] != ''){     // use lucene query language and send request to iAHx

    foreach ($termList as $id=>$term){
        $termPeaces = split("\|\|\|",$term);

        $termName = trim($termPeaces[1]);
        $options = $termPeacesm[2];
        $qualifierList = $termPeaces[3];
        $explode = ($termPeaces[4] == "*explode*" ? true : false) ;

        $expression .= ($expression == "" ? "mh:" : " " . $connector . " " );

        if ($explode == true){
            $expression .= "(" . $id . "$";
            if ($qualifierList != ''){
                $expression .= " AND " . qualiferExp($qualifierList);
            }
            $expression .= ")";
        }else{
            if ($qualifierList != ''){
                $expression .= qualiferExp($qualifierList, $termName);
            }else{
                $expression .= "\"" . $termName . "\"";
            }
        }
    }

    header("Location: " .$def['IAHX_SEARCH_URL'] ."?lang=" . $lang . "&q=" . $expression);
    
    
}else{      // use isis query language and send request to metaIAH

    foreach ($termList as $id=>$term){
        $termPeaces = split("\|\|\|",$term);

        $termName = trim($termPeaces[1]);
        $options = $termPeacesm[2];
        $qualifierList = $termPeaces[3];
        $explode = ($termPeaces[4] == "*explode*" ? true : false) ;

        $expression .= ($expression == "" ? "" : " " . $connector . " " );

        if ($explode == true){
            $expression .= "(EX " . $id . "$";
            if ($qualifierList != ''){
                $expression .= " AND " . qualiferExp($qualifierList);
            }
            $expression .= ")";
        }else{
            if ($qualifierList != ''){
                $expression .= qualiferExp($qualifierList, $termName);
            }else{
                $expression .= "\"" . $termName . "\"";
            }
        }
    }

    header("Location: " .$def['DIRECTORY'] ."metaiah/search.php?lang=" . $lang . "&expression=" . $expression . "&connector=" . $connector . "&search_type=decs");
    

}


//================================================================================================================================
function qualiferExp($qualifierList, $termName = ""){

    $qualifierListArray = split(",",$qualifierList);
    $qlfExp .= "(";
    $totalQlf = count($qualifierListArray);
    for ($i = 0; $i < $totalQlf; $i++){
        $qualifier = $qualifierListArray[$i];

        if ($termName != ""){
            $qlfExp .= "\"" . $termName . "/" . $qualifier . "\"";
        }else{
            $qlfExp .= "/" . $qualifier;
        }

        if ($i+1 < $totalQlf){
            $qlfExp .= " OR ";
        }
    }
    $qlfExp .= ")";

    return $qlfExp;
}

?>



