<?php
/*
2021-03-02 fho4abcd Created
Function  : Displays information in the 'helper' paragraph (html div class="helper")
Usage     : <?php include "../common/inc_div-helper.php" ?>
Inherited : Super globals $_SESSION and $_SERVER and variables
  $ayuda    : The name of the ABCD help file
              Example: $ayuda=$ayuda="circulation/homepage.html";
              If not set the name of the including file is used with extension .html          
  $wiki_help: The Spanish title#subtitle of the entry in the abcdwiki.net
              UTF8 in title escaped with % , in subtitle with .
              Example: $wiki_help="";
                       $wiki_help="B%C3%BAsquedas";
                       $wiki_help="B%C3%BAsquedas#B.C3.BAsqueda_Libre";
              If not set the link is not shown
    $n_wiki_help: Link to the wiki on Github https://abcd-community.github.io/wiki/
*/
$including_file = pathinfo(debug_backtrace()[0]['file'])['basename'];
$server_script = $_SERVER['PHP_SELF'];

if (isset($ayuda)) {
    $help_file = $ayuda;
} else {
    $help_file = strstr($including_file,".php",true).".html";
}
// If the including name is already in the server script: no need to display
if (strstr($server_script,$including_file,true)!=false) unset($including_file);
?>
<div class="helper">
	<a href="../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/$help_file"?>" target=_blank><?php echo $msgstr["help"]?></a>
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) {?>
    &nbsp;&nbsp;<a href="../documentacion/edit.php?archivo=<?php echo $_SESSION["lang"]."/$help_file"?>" target=_blank><?php echo $msgstr["edhlp"]?></a>
<?php } ?>
<?php if (isset($wiki_help)) {?>
    &nbsp;&nbsp;<a href="http://abcdwiki.net/<?php echo $wiki_help?>" target=_blank>abcdwiki</a>
<?php }?>
<?php if (isset($n_wiki_help)) {?>
    &nbsp;&nbsp;<a href="https://abcd-community.github.io/wiki/<?php echo $n_wiki_help?>" target=_blank>wiki</a>
<?php }?>
	&nbsp;&nbsp;Script: <?php echo $server_script; if (isset($including_file)) echo "&#8594;".$including_file; ?> 
</div>
