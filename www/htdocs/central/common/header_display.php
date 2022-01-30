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
		<link rel="stylesheet" rev="stylesheet" href="../../assets/css/<?php echo $css_name?>template.css?<?php echo time(); ?>" type="text/css" media="screen"/>
		<!--FontAwesome-->
		
		<link href="../../assets/css/all.min.css" rel="stylesheet"> 
	
<?php
include ("css_settings.php");
?>

</head>