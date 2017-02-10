<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {popup} function plugin
 *
 * Type:     function<br>
 * Name:     breadcrumb<br>
 * Purpose:  create the breadcrumb/navigation site
 * @author:  Bruno Neofiti <bruno.neofiti@bireme.org>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_breadcrumb($params, &$smarty)
{
    global $BVS_LANG;
    $totalRecords = $params['total'];
    print "<a href=\"http://{$_SERVER['HTTP_HOST']}{$BVS_LANG['index']}/index.php\" >{$BVS_LANG['home']}</a>\n\t";

    if (isset($_SESSION["identified"])){
        switch ($_GET['m']) {
            case "titleplus":
                print " / <a href=\"?m=titleplus\">{$BVS_LANG['titlePlus']}</a>\n\t";
                $facicTitle = facicTitle($_GET["title"]);
                if($facicTitle){
                    print " / $facicTitle\n\t";
                }
                break;
            case "facic":
                if ($_GET["listRequest"]){ $url = $_GET["listRequest"]; }else{ $url = "title"; }
                print " / <a href=\"?m=$url\">{$BVS_LANG['title']}</a>\n\t";
                $facicTitle = facicTitle($_GET["title"]);
                //print " / <a href=\"?$key=$value&amp;title={$_GET['title']}&amp;initialDate={$_GET['initialDate']}&amp;initialVolume={$_GET['initialVolume']}&amp;initialNumber={$_GET['initialNumber']}\">$facicTitle</a>\n\t";
                print " / ".$facicTitle;
                break;
            default:
                if($_GET['m']){
                    print " / ";
                }
                print " <a href=\"?m=".$_GET['m']."\">{$BVS_LANG[$_GET['m']]}</a>\n\t";
        }

        if ($totalRecords){
            print "<sup>($totalRecords {$BVS_LANG['registers']})</sup>";
        }

        if ($_GET['edit']){
            print " / <h3>{$BVS_LANG['btEditRecord']} {$BVS_LANG[$_GET['m']]}</h3>\n\t";
        }
        
        if($_GET['action']) {
            if($_GET["action"] == "delete" && isset($_GET['id'])) {
                print " / <h3>{$BVS_LANG["actionDeleteRegister"]}</h3>\n\t";
            }elseif($_GET["action"] == "new"  && $_GET['m'] != 'titleplus') {
                print " / <h3>{$BVS_LANG['btNewRecord']} ";
                if($_GET['m'] != 'facic') {
                    print "{$BVS_LANG[$_GET['m']]}";
                }
                print "</h3>\n\t";
            }
        }

    }else{
            print " / <h3>{$BVS_LANG["login"]}</h3>\n\t";
    }

}

?>
