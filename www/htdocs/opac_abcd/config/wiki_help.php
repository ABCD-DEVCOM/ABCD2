<?php
if (isset($_SESSION["showhelp"]) and $_SESSION["showhelp"]=="Y"){
	$showhelp="block";
}else
    $showhelp="none";
if (!isset($wiki_trad)) $wiki_trad=$wiki_help;
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
echo " <a href=javascript:ShowHide('myDiv')><img src=../images_config/helper_bg.png><font size=2>".$msgstr["show_hide"]." ".$msgstr["help"]."</a>
    &nbsp;/  <a href=\"http://translate.google.com/translate?sl=es&tl=en&u=".$wiki_trad."\" target=_blank>".$msgstr["translate"]."</a></font></h3><p>";
echo "  <div id=\"myDiv\" style=\"display:$showhide_help;margin:auto;width:100%;xheight:150px;position:relative;border:1px solid black;\">
	  <iframe style=\"width:100%; height:350px; border:0\" src=\"$protocol$wiki_help\"></iframe>
	</div></h3>";
?>