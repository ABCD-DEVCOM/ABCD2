<?php
	require("auth_check.php");
	require("../php/include.php");
	
	auth_check_login();

	$cgiList[] = "xml=xml/" . $lang . "/adm.xml";
	$cgiList[] = "xsl=xsl/adm/menu.xsl";
	$cgiList[] = "lang=" . $checked['lang'];
	$cgiText = join("&",$cgiList);

	$href = $def['DIRECTORY'] . "php/xmlRoot.php?" . $cgiText;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo isset($lang) ? $lang : 'en'; ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo isset($lang) ? $lang : 'en'; ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php echo isset($lang) ? $lang : 'en'; ?>">
<!--<![endif]-->
<!-- Head BEGIN -->
<head>
	<meta charset="utf-8">
	<title>ABCD-Site Admin</title>
</head>
<!-- frames -->
<frameset rows="100%,*">
    <frame name="frameAdm"    src="<?php echo $href?>" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
    <frame name="frameHidden" src="<?php echo $def['DIRECTORY']?>admin/frameHidden.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
</frameset>
</body>
</html>

