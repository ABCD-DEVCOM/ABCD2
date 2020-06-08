<?php

require("../php/include.php");

$lang = $_POST["lang"];

$filename = $def['DATABASE_PATH'] . "xml/users.xml";

$cgiList[] = "xml=xml/" . $lang . "/adm.xml";
$cgiList[] = "xsl=xsl/adm/menu.xsl";
$cgiList[] = "lang=" . $checked['lang'];
$cgiText = join("&",$cgiList);

$login_redirect = $def['DIRECTORY']
      . "php/xmlRoot.php?" . $cgiText
      . (isset($checked['portal'])?'&portal='.$checked['portal']:'');

$logout_redirect = "index.php";

$logged_in = false;

$xmlDoc = simplexml_load_file($filename);
$usersXml = $xmlDoc->xpath('//user');

foreach($usersXml as $user){
    $username = (String) $user['name'];     // The cast is needed to
    $password = (String) $user['password']; // prevent SimpleXML
    $level =    (String) $user['type'];     // serialization in session

    if ($_POST["username"] == trim($username)
        && md5($_POST["password"]) == trim($password)
    ){
        $logged_in = true;
        break;
    }
}

if ($logged_in === false) {
    header("Location: ./index.php?error=INVALID_USER");
} else {

    session_start();
    session_regenerate_id();
    $_SESSION['auth_id'] = "BVS@BIREME";
    $_SESSION['auth_username'] = $_POST["username"];
    $_SESSION['auth_level'] = $level;

    if (strlen($_POST['password']) < 6){
        $_SESSION['auth_pwd_change'] = 'true';
    }

    if ($_POST["auth_rm"] == 1) {
        setcookie("phpAuth_username",$_POST["phpAuth_usr"],time()+3600);
    }

    $login_redirect .= (isset($checked['portal'])?'?portal='.$checked['portal']:'');
    header('Location: '.$login_redirect.'');
}
?>
