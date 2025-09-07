<?php

require("../php/include.php");
require("php/functions.php");

$language = 'en';
$texts = __DIR__ . "/defaultXml/" . $language . "/texts.xml";

if(file_exists($localPath['xml'].'texts.xml')){
    $texts = $localPath['xml'].'texts.xml';
} else if(file_exists(SITE_PATH."admin/defaultXml/".$lang."/texts.xml")) {
    $texts = SITE_PATH."admin/defaultXml/".$lang."/texts.xml";
}

$label = loadLabels($texts);
$langs = loadLangs(DATABASE_PATH.'xml/');
		$error_from_request = $_REQUEST['error'] ?? '';
		$error = preg_replace('/[^A-Z_]/', '', $error_from_request);
    
echo'<?xml version="1.0" encoding="utf-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo trans("ADMINISTRATION");?></title>
        <style type="text/css">
            ul.lang li.<?php echo $lang;?> {
                display: none;
            }
        </style>
        <link rel="stylesheet" href="../css/admin/adm.css"/>
    </head>
    <body>
	
	<div class="barLang">
		<ul class="lang">
            <?php foreach($langs as $l):?>
            <li class="<?php echo $l;?>">
                <a href="?lang=<?php echo $l;?>"><?php echo trans(strtoupper($l));?></a>
            </li>
            <?php endforeach;?>
        </ul>
	</div>
	<div class="login">
        <h1><?php echo trans("ADMINISTRATION");?></h1>
	    <form action="auth_user.php" method="POST">
	        <?php if(isset($checked['portal'])):?>
	            <input type="hidden" name="portal" value="<?php echo $checked['portal'];?>"/>
	        <?php endif;?>

	        <input type="hidden" name="lang" value="<?php echo $lang;?>"/>

	        <ul>
	            <li>
	                <label for="username"><?php echo trans("USER");?></label><br/>
	                <input type="text" id="username" name="username" maxlength="30"/>
	            </li>
	            <li>
	                <label for="password"><?php echo trans("PASSWORD");?></label><br/>
	                <input type="password" id="password" name="password" maxlength="30"/>
	            </li>
	            <li>
	                <input id="submit" type="submit" value="Log In" />
	            </li>
	        </ul>

	        <?php if (isset($label[$error])):?>
	            <div class="error">
	                <?php echo trans($error);?>
	            </div>
	        <?php endif ?>
	    </form>
	</div><!--/login-->
    <div class="copyright">
        <?php echo trans("ABCD-SITE").' '.VERSION;?> &copy;
        <a href="http://www.bireme.br/" target="_blank">BIREME/OPS/OMS</a>
    </div>
</body>
</html>

