<?php
/* Modifications
2021-01-04 fho4abcd Removed login encryption
2021-01-04 fh04abcd Corrected "languaje" --> language
2021-02-07 fho4abcd Configured Logo url now used without prefix and strip. Works now according to wiki
2021-02-27 fho4abcd png favicon works better in bookmarks.
2021-08-10 fho4abcd Do not crash if first language file (from the browser) is missing. Visible message if no file found
2022-01-19 rogercgui Include css_settings.php
2022-01-19 fho4abcd Configured language is preset in the language selection
20220122 rogercgui Default logo is displayed if institution image is absent
20230127 fho4abcd Removed unused function, login fail can be caused by expiration: improve message content
                  Removed inline fixed size (clashed often with footer position). Removed unused div sectioninfo
20230223 fho4abcd Check for existence of config.php
*/
session_start();
$_SESSION=array();
unset($_SESSION["db_path"]);
include("central/config_inc_check.php");
include("central/config.php");
include("$app_path/common/get_post.php");
$new_window=time();
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$lang_config=$lang; // save the configured language to preset it later
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if (isset($_SESSION["lang"])){
	$arrHttp["lang"]=$_SESSION["lang"];
	$lang=$lang;
}else{
	$arrHttp["lang"]=$lang;
	$_SESSION["lang"]=$lang;
}

include ("$app_path/lang/admin.php");
include ("$app_path/lang/lang.php");	
?>
<!DOCTYPE html>

<html lang="<?php echo $lang;?>" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang;?>">

<head profile="http://www.w3.org/2005/10/profile">
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $meta_encoding;?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta http-equiv="Content-Language" content="<?php echo $lang;?>" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />

		<!-- Favicons -->
		
		<link rel="mask-icon" href="/assets/images/favicons/favicon.svg">
    	<link rel="icon" type="image/svg+xml" href="/assets/images/favicons/favicon.svg" color="#fff">

    	<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicons/favicon-32x32.png">
    	<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicons/favicon-16x16.png">

    	<link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicons/favicon-60x60.png">
    	<link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicons/favicon-76x76.png">
    	<link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicons/favicon-120x120.png">
    	<link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicons/favicon-152x152.png">
    	<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/favicon-180x180.png">

		<title>ABCD</title>
		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css" media="screen"/>

		<!--FontAwesome-->
		<link href="/assets/css/all.min.css" rel="stylesheet"> 
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="<?php echo $app_path?>/css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="<?php echo $app_path?>/css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<script src=/<?php echo $app_path?>/dataentry/js/lr_trim.js></script>

<script language=javascript>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Enviar()
			return true;
	}


function CambiarClave(){
	document.cambiarPass.login.value=Trim(document.administra.login.value)
	document.cambiarPass.password.value=Trim(document.administra.password.value)
	ix=document.administra.lang.selectedIndex
	document.cambiarPass.lang.value=document.administra.lang.options[ix].value
	ix=document.administra.db_path.value
	document.cambiarPass.db_path.value=document.administra.db_path.value
	document.cambiarPass.submit()
}
function Enviar(){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	if (login=="" || password==""){
		alert("<?php echo $msgstr["datosidentificacion"]?>")
		return
	}else{
		if (document.administra.newindow.checked){
			new_window=new Date()
			document.administra.target=new_window;
			ancho=screen.availWidth-15
			alto=(screen.availHeight||screen.height) -50
			msgwin=window.open("",new_window,"menubar=no, toolbar=no, location=no, scrollbars=yes, status=yes, resizable=yes, top=0, left=0, width="+ancho+", height="+alto)
			msgwin.focus()
		} else{
			document.administra.target=""
		}
		document.administra.submit()
	}
}

</script>
<?php
include ("$app_path/common/css_settings.php");
?>
</head>
<body>
	<header class="heading">
		<div class="institutionalInfo">
			<?php

			if (isset($def['LOGO_DEFAULT'])) {
				echo "<img src='/assets/images/logoabcd.png?".time()."' title='$institution_name'>";
			} elseif ((isset($def["LOGO"])) && (!empty($def["LOGO"]))) {
				echo "<img src='".$folder_logo.$def["LOGO"]."?".time()."' title='";
				if (isset($institution_name)) echo $institution_name;
				echo "'>";
			} else {
				echo "<img src='/assets/images/logoabcd.png?".time()."' title='ABCD'>";
			}

			?>
		</div>
		<div class="userInfo" style="margin-left: 80%;"><?php echo $meta_encoding?></div>

		<div class="spacer">&#160;</div>
	</header>
<form name="administra" onsubmit="javascript:return false" method="post" action="/<?php echo $app_path?>/common/inicio.php">
<input type="hidden" name="Opcion" value="admin">
<input type="hidden" name="cipar" value="acces.par">
	<div class="middle login">
		<div class="loginForm">

		<div class="boxContent">
<?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
			<div class=\"helper alert\">".$msgstr["menu_ex_noau"]."
			</div>
		";
}
if (isset($arrHttp["login"]) and $arrHttp["login"]=="P"){
		echo "
			<div class=\"helper success\">".$msgstr["pswchanged"]."
			</div>
		";
}
?>
		<div class="formRow">
			<label for="user"><?php echo $msgstr["userid"]?></label>
<?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
			<input type=\"text\" name=\"login\" id=\"user\" value=\"\" class=\"textEntry superTextEntry inputAlert\" onfocus=\"this.className = 'textEntry superTextEntry inputAlert textEntryFocus';\" onblur=\"this.className = 'textEntry superTextEntry inputAlert';\" />\n";
}else{
		echo "
			<input type=\"text\" name=\"login\" id=\"user\" value=\"\" class=\"textEntry superTextEntry\" onfocus=\"this.className = 'textEntry superTextEntry textEntryFocus';\" onblur=\"this.className = 'textEntry superTextEntry';\" />\n";
}

?>
		</div>

		<div class="formRow">
			<label for="pwd"><?php echo $msgstr["password"]?></label>
			<input type="password" name="password" id="pwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry';" />
		   <?php if (isset($change_password) and $change_password=="Y") echo "<br><a href=javascript:CambiarClave()>". $msgstr["chgpass"]."</a>\n";?>
		</div>
		<div id="formRow3" class="formRow formRowFocus">
        <?php
        // Check if the language from the browser is present
        $a=$msg_path."lang/$lang/lang.tab";
        if (!file_exists($a)){
            // switch to configured language if browser language is not present
            echo "<div>".$msgstr["flang"].": ".$a."<br>";
            echo $msgstr["using_config"]." '".$lang_config."'<br>&nbsp;</div>";
            $lang=$lang_config;
        }
        // Check if the language file is present
        $a=$msg_path."lang/$lang/lang.tab";
        if (!file_exists($a)){
            echo "<div style='color:red'>".$msgstr["fatal"].": ".$msgstr["flang"].": ".$a."</div>";
            die;
        }
        ?>
			<label ><?php echo $msgstr["lang"]?></label> 
			<select name=lang class="textEntry singleTextEntry" onchange="this.submit()">
                <option value=''></option>
                <?php
                $fp=file($a);
                $selected="";
                foreach ($fp as $value){
                    $value=trim($value);
                    if ($value!=""){
                        $l=explode('=',$value);
                        if ($l[0]!="lang"){
                            if ($l[0]==$lang) $selected=" selected";
                            echo "<option value=$l[0] $selected>".$msgstr[$l[0]]."</option>\n";
                            $selected="";
                        }
                    }
                }
                ?>
			</select>
		</div>
		<div class="formRow"><br>
<?php
if (file_exists("dbpath.dat")){
	global $db_path;
	$fp=file("dbpath.dat");
	echo $msgstr["database_dir"].': <select class="textEntry singleTextEntry" name=db_path>\n';
	foreach ($fp as $value){
		if (trim($value)!=""){
			$v=explode('|',$value);
			$v[0]=trim($v[0]);
			echo "<option value=".trim($v[0]).">".$v[1]."\n";
		}

	}
	echo "</select>";
} else {
	echo '<input type="hidden" name="db_path" value="'.$db_path.'">';
}
?>
			<input type="checkbox" name="newindow" value=
<?php
if (isset($open_new_window) and $open_new_window=="Y")
	echo "Y checked";
else
	echo "N";
?> />
			<label for="setCookie" class="inline"><?php echo $msgstr["openwindow"]?></label>
		</div>
		<div class="formRow">
				<a href="javascript:Enviar()" class="bt bt-blue">
					<?php echo $msgstr["entrar"]?> 
				</a>
		</div>
	</div>

</div>
</div>
</form>
<form name="cambiarPass" action="<?php echo $app_path?>/dataentry/change_password.php" method="post">
	<input type="hidden" name="login">
	<input type="hidden" name="password">
	<input type="hidden" name="lang">
	<input type="hidden" name="db_path">
	<input type="hidden" name="Opcion" value="chgpsw">
</form>

<?php include ("$app_path/common/footer.php");?>

