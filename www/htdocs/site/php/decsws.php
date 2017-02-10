<?php
session_start();
$DirNameLocal=dirname(__FILE__).'/';
include_once($DirNameLocal . "./include.php");
include_once($DirNameLocal . "./common.php");

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 'default');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php include($DirNameLocal . "./head.php"); ?>
    </head>
    <body>

        <?php if ($page == 'default'){
               echo '<div class="container">';
               echo '   <div class="level2">';
               include($localPath['html'] . "/bvs.html");
         } ?>
                
                <div class="middle">
                    <?php

                    $tree_id = $_REQUEST["tree_id"];
                    $VARS["expression"] = $_SESSION["expression"];
                    $VARS["source"] = "decs";
                    $VARS["lang"] = $checked["lang"];

                    // create a xml element with session terms splited by chuncks (separator |||)
                    $session_term_list = $_SESSION['terms'];
                    if ( count($session_term_list) > 0) {
                        $token_xml = "<session-token-list>";
                        foreach ($session_term_list as $term){
                            $token_xml .= "<token-list>";
                            $token_list = preg_split("/(\|\|\|)/", $term );
                            foreach ($token_list as $token){
                                $token_xml .= "<token>" . $token . "</token>";
                            }
                            $token_xml .= "</token-list>";
                        }
                        $token_xml .= "</session-token-list>";
                    }

                    $xml = getDeCSTreeVmx($tree_id);
                    $xml .= $token_xml;

                    if ($page == 'info'){
                        $xsl = "xsl/public/components/page_decs_info.xsl";
                    }elseif ($page == 'qualifier'){
                        $xsl = "xsl/public/components/page_decs_qualifier.xsl";
                    }elseif ($page == 'explode'){
                        $xsl = "xsl/public/components/page_decs_explode.xsl";
                    }else{
                        $xsl = "xsl/public/components/page_decs.xsl";
                    }

                    require($DirNameLocal . "./xmlRoot.php");

                    ?>
                </div> <!-- /middle -->
                
                <?php if ($page == 'default'){ 
                    echo '    <div class="bottom">';
                    include($localPath['html'] . "/responsable.html");
                    echo '    </div>';
                    echo '   </div> <!-- /level2 -->';
                    echo '</div> <!-- /container -->';
                
                    include($DirNameLocal. "./foot.php");  
                 } ?>
    </body>
</html>
