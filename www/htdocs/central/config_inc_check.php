<?php
/*
** Check that the central config file is present.
** If missing give hints that the file can be created from a template
** Git has only the template, so avoid erroneous overwrites during installation
** Text is only in English: supposed only to be read by application installers
** Included before inclusion of config.php in some key files (no need to include everywhere)
*/
$def_config_file="central/config.php";
$def_config_file_full=$_SERVER["DOCUMENT_ROOT"]."/".$def_config_file;
$def_config_file_template=$def_config_file.".template";
if (!is_readable($def_config_file_full) || filesize($def_config_file_full)<=0) {
    ?>
    <!DOCTYPE html><html><body>
    <h3><font color=red>
    <b>FATAL</b>: Configuration file: <b><?php echo $def_config_file?></b> does not exist, is empty or unreadable
    </font></h3>
    File location: <?php echo $def_config_file_full?><br><br>
    Steps to resolve this:<ol>
    <li>Copy <b><?php echo $def_config_file_template?></b> to <b><?php echo $def_config_file?></b></li>
    <li>Edit <b><?php echo $def_config_file?></b> to reflect your local situation and save it</li>
    <li>Check permissions and ownership: the webserver must be able to read the file!</li>
    <li>Reload page</li></ol>
    </body></html>
    <?php
    die;
}
?>
