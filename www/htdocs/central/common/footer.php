<?php
/* Modifications
20210428 fho4abcd System info has latest release & date (not dynamic, so must be fixed every release)
20210610 fho4abcd update date. Remove wiki (done by URL1 and all pages
20210626 fho4abcd MOve logo from css to php +span to title.
20220316 fho4abcd remove duplicate target,empty lines, confusing spacing in html
20220322 fho4abcd date&release comment
20240519 fho4abcd Improve version info
20250316 fho4abcd Hover over responsible logo shows responsible text
*/
require_once (dirname(__FILE__)."/../config.php");
$def = parse_ini_file($db_path."/abcd.def");
include "css_settings.php";
//print_r($def);
?>

<footer class="footer">
    <div class="systemInfo">
        <span class="institutionName">
            <a href="<?php 
            if (isset($def["INSTITUTION_URL"])) {
                echo $def["INSTITUTION_URL"];
            } else {
                echo "//abcd-community.org";
            }?>" target="_blank">
            <?php 
                function randomName() {
                    $names = array(
                        'Automatisaci&oacute;n de Bibliot&eacute;cas y Centros de Documentaci&oacute;n',
                        'Automation des Biblioth&eacute;ques et Centres de Documentacion',
                        'Automatiza&ccedil;&atilde;o das Bibliotecas e dos Centros de Documenta&ccedil;&atilde;o',
                        'Automatisering van Bibliotheken en Centra voor Documentatie',
                        // and so on
                    );
                    return $names[rand ( 0 , count($names) -1)];
                }
            if (isset($def["INSTITUTION_NAME"])) {
                echo $def["INSTITUTION_NAME"]; 
            } else {
                echo "ABCD | ".randomName();
            }?>
        </a>
        </span>
        <?php 
        if ((isset($def["URL_ADDITIONAL_LINK"])) && (isset($def["ADDITIONAL_LINK_TITLE"]))) {
            $url1 = $def["URL_ADDITIONAL_LINK"];
            echo "<span><small><a href=".$def["URL_ADDITIONAL_LINK"]." target=_blank>".$def["ADDITIONAL_LINK_TITLE"]."</a></small></span>";
        } elseif (isset($def["URL_ADDITIONAL_LINK"])) {
            echo "<span><small><a href=".$def["URL_ADDITIONAL_LINK"]." target=_blank>".$def["URL_ADDITIONAL_LINK"]."</a></small></span>";
        } else {
            echo "<span><small><a href=\"https://github.com/ABCD-DEVCOM/ABCD2\" target=_blank>ONLY FOR TESTING - NOT FOR DISTRIBUTION</a></small></span>";
        }
        if(isset($def["URL2"])){
            $url2 = $def["URL2"];
        } else {
            $url2 = "URL2";
        }
        if(isset($def["TEXT2"])){
            $text2 = $def["TEXT2"];
        } else {
            $text2 = "TEXT2";
        }
		$versioninfo=$msgstr["version"].": v2.2.0-beta-1 + ... &rarr; 2025-03-21";
?>
        <span><small><a href="http://www.abcdwiki.net/" target="_blank">Wiki</a>  - <?php echo $versioninfo?> </small></span>
    </div>
        <div class="distributorLogo">
           <a  href="<?php 
            if (isset($def["RESPONSIBLE_URL"])) {
                    echo $def["RESPONSIBLE_URL"];
                } else {
                    echo "//abcd-community.org";   
                }
            ?>" target="_blank"> 
            <?php 
             if ((isset($def["RESPONSIBLE_NAME"])) && (!empty($def["RESPONSIBLE_NAME"]))) {
                $responsible = $def["RESPONSIBLE_NAME"];
            } else {
                $responsible = "ABCD Community";
            }
            if (isset($def['RESPONSIBLE_LOGO_DEFAULT'])) {
                echo "<img src='/assets/images/distributorLogo.png?".time()."' title='$responsible'>";
            } elseif ((isset($def["RESPONSIBLE_LOGO"])) && (!empty($def["RESPONSIBLE_LOGO"]))) {
                echo "<img src='".$folder_logo.$def["RESPONSIBLE_LOGO"]."?".time()."' title='".$responsible."'>";
            } else {
                echo "<img src='/assets/images/distributorLogo.png?".time()."' title='ABCD Community'>";
            }
   
            ?></a>
        </div>
    <div class="spacer">&#160;</div>
</footer>

</body>
</html>