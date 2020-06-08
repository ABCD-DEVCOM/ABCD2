<?php
    $DirNameLocal=dirname(__FILE__).'/';
    include_once($DirNameLocal."./include.php");

    $site = parse_ini_file($localPath['ini'] . "bvs.ini", true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>
            <?php echo  $site['title']?>
        </title>
        <? include($DirNameLocal."./head.php"); ?>
    </head>
    <body>
        <div class="container">
            <?
            include($localPath['html'] . "/bvs.html");
            flush();
            ?>

            <div class="middle">
                <div class="firstColumn">
                    <?
                     foreach ($site["col1"] as $id=>$file){
                         $html = $localPath['html'] . $file . ".html";
                         include($html);
                     }
                     flush();
                    ?>
                </div>

                <div class="secondColumn">
                    <? include($localPath['html'] . "/metasearch.html"); ?>
                    <div class="centerLeftColumn">
                        <?
                         foreach ($site["col2"] as $id=>$file){
                            $html = $localPath['html'] . $file . ".html";
                             include($html);
                         }
                         flush();
                        ?>
                    </div>
                </div>
                <div class="thirdColumn">
                    <?
                     foreach ($site["col3"] as $id=>$file){
                         $html = $localPath['html'] . $file . ".html";
                         include($html);
                     }
                     flush();
                    ?>
                </div>
                <div class="spacer"> </div>
            </div>
            <div class="bottom">
                <? include($localPath['html'] . "/responsable.html"); ?>
            </div>
        </div>
        <div class="copyright">
            ABCD Site <?php echo  VERSION ?> &copy; <a href="http://www.abcdwiki.net/" target="_blank">ABCD Wiki</a>
            <a href="http://validator.w3.org/check?uri=http://<?php echo $def["SERVERNAME"].$def["DIRECTORY"].$_SERVER["PHP_SELF"]?>" target="w3c"><img src="../image/common/valid-xhtml10.png" alt="Valid XHTML 1.0 Transitional" border="0"/></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://<?php echo $def["SERVERNAME"].$def["DIRECTORY"].$_SERVER["PHP_SELF"]?>" target="w3c"><img src="../image/common/valid-css.png" alt="Valid CSS" border="0"/></a>
        </div>
        <? include($DirNameLocal. "./foot.php");  ?>
    </body>
</html>