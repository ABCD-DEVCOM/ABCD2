<?php
/*
20250204 fho4abcd Created
Function  : Set language variables in the case that no database is set, or not desired.
            This is the case for several administrative scripts like translate .php
Usage     : <?php include "../common/inc_nodb_lang.php" ?>
** Variable:none
** Notes  : Table $curlangcode should be replaced by reading a file (candidate bases/lang.tab)
**        : $guesstatus and $selcharset are used in scripts that display a choice to change code
*/
// Get the current language code (preset by config.php)
$lang=$_SESSION["lang"];
// unset a possible database:encoding may be different from langauage file
if (isset($_REQUEST["base"])) $_REQUEST["base"]="";
$baseSelect = "";// used in inicio.php
// Try to guess from the language code and the actual code as existed at the time this script was written
// The future is UTF-8, but we have currently some ISO langauges
$curlangcode["de"]="ISO-8859-1";//German
$curlangcode["en"]="ISO-8859-1";//English
$curlangcode["es"]="ISO-8859-1";//Spanish
$curlangcode["fr"]="ISO-8859-1";//French
$curlangcode["it"]="ISO-8859-1";//Italian
$curlangcode["nl"]="ISO-8859-1";//Dutch (Nederlands)
$curlangcode["nn"]="ISO-8859-1";//Norwegian
$curlangcode["pt"]="ISO-8859-1";//Portuguese
$curlangcode["sv"]="ISO-8859-1";//Swedish
$curlangcode["am"]="UTF-8";//Amharic
$curlangcode["ar"]="UTF-8";//Arabic
$curlangcode["he"]="UTF-8";//Hebrew
$curlangcode["el"]="UTF-8";//Greek
$curlangcode["ma"]="UTF-8";//Marathi. Code should be "mr"
$curlangcode["ru"]="UTF-8";//Russian
$curlangcode["si"]="UTF-8";//Sinhalese
// Take the code if present in the array
if ( isset($curlangcode[$lang]) ) {
    $guessstatus="lang"; // in 00: string "Language"
    $selcharset=$curlangcode[$lang];
} else {
    $guessstatus="basesdef"; // in 00: "Bases default"
    $selcharset=$charset;
}
// And a manual selected code overrules all guesses.
if (isset($arrHttp["selcharset"])){
    $guessstatus="manual"; // in 00: string "Manually set"
    $selcharset=$arrHttp["selcharset"];
}
// Set the variables in such a way that the current language will be displayed correct
$charset=$selcharset;
$meta_encoding=$charset;
$_SESSION["meta_encoding"]=$charset;
if ( $charset=="UTF-8") {
    $unicode=1;
} else {
    $unicode=0;
}
// Send characterset to the server. Note that the browser gets it via the html header.
// This overrules the default header in config.
header('Content-type: text/html; charset='.$charset);
?>