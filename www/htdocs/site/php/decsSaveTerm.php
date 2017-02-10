<?php
    $DirNameLocal=dirname(__FILE__).'/';
    include_once($DirNameLocal . "./include.php");
    include_once($DirNameLocal . "./common.php");

    session_start();

    if( isset($_GET["method"]) && $_GET["method"] != "clean") {
        $expression = $_SESSION["expression"];
        $initialExpression = $expression;
        if(isset($_GET["searchBox"])) {
            if(count($_GET["searchBox"]) == 1) {
                $expression .= ($initialExpression != "" ? " " . $_GET["conector"] . " " : "[MH]") . "\"" . $_GET["searchBox"][0] . "\"";
            } else {
                if (strpos($_GET["searchBox"][0],"/") == false)
                    $expression .= ($initialExpression != "" ? " " . $_GET["conector"] . " " : "[MH]") . "\"" . $_GET["searchBox"][0] . "\"";
                else {
                    $expression .= ($initialExpression != "" ? " " . $_GET["conector"] . " " : "[MH]");
                    $expression .= ($initialExpression != "" ? "(" : "");
                    for($i=0;$i<count($_GET["searchBox"]);$i++) {
                        $expression .= "\"" . $_GET["searchBox"][$i] . "\"";
                        $expression .= ($i < count($_GET["searchBox"])-1 ? ($initialExpression != "" ? " OR " : " " . $_GET["conector"] . " ") : "");
                    }
                    $expression .= ($initialExpression != "" ? ")" : "");
                }
            }
        }
        $_SESSION["expression"] = $expression;
    } else {
        $_SESSION["expression"] = "";
    }
    header("Location: ./decsws.php?lang=".$_GET["lang"]."&tree_id=".$_GET["tree_id"]);
?>