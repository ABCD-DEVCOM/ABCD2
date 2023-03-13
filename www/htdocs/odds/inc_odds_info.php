<?php
/*
** Load odds help information file
**
** 20221207 Created from lib/library.php-load_aditional_info
*/
function load_info() {
    global $lang, $db_path, $ABCD_scripts_path, $msgstr;
    $helpfile="odds_help_info.tab";
    $path_to_file=$db_path."lang/".$lang."/";
    $langfile=$path_to_file.$helpfile;
    $help_read=[];
    if ( !file_exists($langfile)) {
        $langfile=$ABCD_scripts_path."central/lang/00/".$helpfile;
    }
    if ( file_exists($langfile)) {
        $fopen = fopen($langfile, 'r');
        while (!feof($fopen)) {
            $line=fgets($fopen);
            $line=trim($line);
            $help_read[]=$line;
        }
    }
	
	if (count($help_read) < 1) {
		echo "<div style='color:red;font-weight: bolder'>".$msgstr["odds_nohelp"]." (".$helpfile.")</div><br>";
	}
	return $help_read;
}
?>