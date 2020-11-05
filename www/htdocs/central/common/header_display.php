<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html  xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
	<head>
		<title>ABCD</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
<?php
   // if (isset($_SESSION["meta_encoding"])) $meta_encoding=$_SESSION["meta_encoding"];
	if (isset($charset)){
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$charset\" />\n";
	}else{
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$meta_encoding\" />\n";
	}
	if (!isset($css_name))
		$css_name="";
	else
		$css_name.="/";
?>
		<meta http-equiv="X-Content-Type-Options" content="nosniff">
		<meta name="robots" CONTENT="NONE" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<!--link rel="stylesheet" rev="stylesheet" href="../css/<?php echo $css_name?>template.css" type="text/css" media="screen"/-->
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<?php
include ("css_settings.php");

?>
<?php if (isset($context_menu) and $context_menu=="N"){?>
<script>

 var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
 	var myevent = (isNS) ? e : event;
 	var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;

  </script>
<?php }?>
</head>