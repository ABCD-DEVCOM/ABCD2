<?php
include("config_opac.php");
include("leer_bases.php");
include("tope.php");
//echo "<div style=\"margin:0 auto;height:100%\">";
//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";
if (isset($_REQUEST["home"])){
	if (substr($_REQUEST["home"],0,6)=="[LINK]"){		echo "<iframe frameborder=\"0\" id=idf width=100% height=2000   src=".substr($_REQUEST["home"],6)."></iframe>";	}
	if (substr($_REQUEST["home"],0,6)=="[TEXT]"){		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".substr($_REQUEST["home"],6))){			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/".substr($_REQUEST["home"],6));
			foreach ($fp as $value){				echo "$value<br>";			}		}
    }
}
//echo "</div>";

include("footer.php");
?>

<script>
function setIframeHeight(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
		}
	}
};

window.onload = function () {
	setIframeHeight(document.getElementById('idf'));
};
</script>