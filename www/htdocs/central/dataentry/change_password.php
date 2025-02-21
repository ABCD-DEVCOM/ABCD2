<?php
/* Modifications
2021-01-05 guilda Added message $msgstr["pass_format_0"]
2025-02-21 fho4abcd div layout->table layout. Standard back button, check valid chars (like scripts_dataentry.php),
2025-02-21 fho4abcd Only blur (=check pwd) for new pwd, original user/pwd readonly,
2025-02-21 fho4abcd Refuse emergency user, refuse ldap
*/
global $Permiso, $arrHttp;
$arrHttp=Array();
session_start();
include("../common/get_post.php");
if (isset($arrHttp["db_path"]))
	$_SESSION["DATABASE_DIR"]=$arrHttp["db_path"];
include("../config.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
if (isset($_SESSION["lang"])){
	$arrHttp["lang"]=$_SESSION["lang"];
}else{
	$arrHttp["lang"]=$lang;
	$_SESSION["lang"]=$lang;
}
include ("../lang/admin.php");
include ("../lang/lang.php");
	if (!isset($css_name))
		$css_name="";
	else
		$css_name.="/";
require_once("../config.php");
include ("../common/inc_login_scripts.php");
//
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
	<!-- Scripts-->
	<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
	<script language="JavaScript" type="text/javascript" src=../dataentry/js/password_check.js></script>
	<script language=javascript>
<?php
if (isset($SECURE_PASSWORD_LEVEL))
	echo "secure_password_level='$SECURE_PASSWORD_LEVEL'\n";
else
	echo "secure_password_level='0'\n";

if (isset($SECURE_PASSWORD_LENGTH))
	echo "secure_password_length='$SECURE_PASSWORD_LENGTH'\n";
else
	echo "secure_password_length='0'\n";
?>
// Change password requires a password (of course)
// The variable is required by dataentry/js/password_check.js (gets it normally via fdt)
mandatory_password=1

function Enviar(){
	<!-- Check of the new password (is in field with id="pwd") -->
	res=VerificarPassword("pwd")
	if (!res && secure_password_level!="" && secure_password_length!=""){
		alert('<?php echo $msgstr["pass_error"]." ".$msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
		if ($SECURE_PASSWORD_LENGTH>0) echo ". ". $msgstr["pass_format_1"]. " ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"];?>')
		return
	}
	new_password=Trim(document.administra.new_password.value)
	confirm_password=Trim(document.administra.confirm_password.value)
	<!-- check that New and Confirm are equal. Cover also an empty Confirm-->
	if (new_password != confirm_password){
		alert("<?php echo $msgstr["passconfirm"]?>")
		return
	}
	var allowedchars= /^[0-9a-zA-Z\.,!@#$%^&*?_~\\\-()]+$/;
	if (allowedchars.test(new_password)) {
		document.administra.submit()
	}else{
		alert("<?php echo $msgstr["validpwdchars"]?>")
	}
}
</script>
<?php
include ("../common/css_settings.php");
$login_value="";
if (isset($arrHttp["login"])) {$login_value=$arrHttp["login"];}
$pwd_value="";
if (isset($arrHttp["password"])) {$pwd_value=$arrHttp["password"];}
?>
</head>
<body>
<?php
// The pop-up message and redirection are in the <body> to prevent all kinds of browser errors
// Verify that we have a correct user for which the password might be modified
// If incorrect: returns to the caller
VerificarUsuario();
// Validation might be of the emergency login.
if (!isset($arrHttp["Mfn"])||$arrHttp["Mfn"]=="") {
	?>
	<script>
	alert("<?php echo $msgstr["emergnochgpwd"]?>")
	self.location.href="<?php echo $retorno."?login=N&user=".$arrHttp["login"];?>"
	</script>
	<?php	
}
// LDAP cannot be used with this script
if ( $use_ldap) {
	?>
	<script>
	alert("<?php echo $msgstr["nochgpwdldap"]?>")
	self.location.href="<?php echo $retorno."?login=N&user=".$arrHttp["login"];?>"
	</script>
	<?php	
}
// The normal execution starts with display of the page
?>
	<div class="heading">
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
		<div class="userInfo"></div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="sectionInfo">
		<div class="breadcrumb"></div>
		<div class="actions"></div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="middle login">
	<div class="loginForm">
	<div class="boxContent">
<form name=administra action=../common/inicio.php method=post onsubmit="Javascript:Enviar();return false">
<input type=hidden name=Opcion value=chgpsw>
<input type=hidden name=lang value="<?php echo $arrHttp["lang"]?>">
<input type=hidden name=db_path value="<?php if (isset($arrHttp["db_path"])) echo $arrHttp["db_path"]?>">
<table>
    <tr><td><label for="user"><?php echo $msgstr["userid"]?></label></td>
	<td><input autocomplete="off" type="text" name="login" readonly
		id="user" value="<?php echo $login_value ?>"
		class="textEntry superTextEntry"
		onfocus="this.className = 'textEntry superTextEntry textEntryFocus';"
		onblur="this.className = 'textEntry superTextEntry';" />
	</td>
    <tr><td><label for="pwd"><?php echo $msgstr["actualpass"]?></label></td>
	<td><input autocomplete="off" type="password" name="password" readonly
		id="actualpwd" value="<?php echo $pwd_value ?>"
		class="textEntry superTextEntry"
		onfocus="this.className = 'textEntry superTextEntry textEntryFocus';"
		onblur="this.className = 'textEntry superTextEntry';" />
	</td>
	<td><a class="bt-fdt" href="javascript:DisplayPassword('actualpwd')">
		<i class="far fa-eye"></i><?php echo $msgstr["ver"]?></a></td>
    <tr><td colspan=3><hr></td>
    <tr><td><label for="pwd"><?php echo $msgstr["newpass"]?></label></td>
	<td><input autocomplete="off" type="password" name="new_password" id="pwd" value=""
		class="textEntry superTextEntry"
		onfocus="this.className = 'textEntry superTextEntry textEntryFocus'"
		onblur="<?php if (isset($SECURE_PASSWORD_LEVEL) or isset($SECURE_PASSWORD_LENGTH)) echo "pwd_Validation('pwd')";?>" />
	</td>
	<td><a class="bt-fdt" href="javascript:DisplayPassword('pwd')">
		<i class="far fa-eye"></i><?php echo $msgstr["ver"]?></a></td>
    <tr><td colspan=3>
	<?php
		if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="") or (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="")) {
			echo "<FONT COLOR=DARKRED>";
			if ($SECURE_PASSWORD_LENGTH>0)
				echo $msgstr["pass_format_1"]." ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"]."<br>";
			if ($SECURE_PASSWORD_LEVEL>1)
				echo "<FONT COLOR=DARKRED>".$msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
				echo "</font>". ' &nbsp;<span id="spnPwd" class="pwd_Strength" ></span> &nbsp;';
		}

	?>
    <tr><td><label for="pwd"><?php echo $msgstr["confirmpass"]?></label></td>
	<td><input autocomplete="off" type="password" name="confirm_password" id="confirmpwd" value=""
		class="textEntry superTextEntry"
		onfocus="this.className = 'textEntry superTextEntry textEntryFocus'"
		onblur="this.className = 'textEntry superTextEntry';" />
	</td>
	<td><a class="bt-fdt" href="javascript:DisplayPassword('confirmpwd')">
		<i class="far fa-eye"></i><?php echo $msgstr["ver"]?></a></td>
    <tr><td>
		<?php
			$backtoscript="../../index.php?user=".$login_value;
			include "../common/inc_back.php";
		?>
	</td>
	<td>
		<a href="javascript:Enviar()" class="bt bt-blue"> <?php echo $msgstr["chgpass"]?> </a>
	</td>
</table>
</form>
</div>
</div>
</div>
<?php include ("../common/footer.php");?>