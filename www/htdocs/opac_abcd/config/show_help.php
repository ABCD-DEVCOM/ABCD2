<?php   if (!isset($div_height)) $div_height="200px";
		echo "<a href=javascript:ShowHide('myDiv')><img src=../images_config/helper_bg.png>". $msgstr["show_hide"]." ".$msgstr["help"]."</a>
    		&nbsp;/  <a href=http://translate.google.com/translate?sl=es&tl=en&u=".$wiki_help." target=_blank>".$msgstr["translate"]."</a></h3>
     		<div id=\"myDiv\" style=\"display:$showhide_help;margin:auto;width:100%;height:$div_height;position:relative;border:1px solid black;\">
	  		<iframe style=\"width:100%; height:100%; border:0\" src=\"http://$wiki_help\">

	  		</iframe>
			</div>
		";
?>