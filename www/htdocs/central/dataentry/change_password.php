<?php
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>
		<title>ABCD</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Language" content="pt-br" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="../css/<?php echo $css_name?>template.css" type="text/css" media="screen"/>
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="../css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<script src=../dataentry/js/lr_trim.js></script>
<script language=Javascript src=../dataentry/js/password_check.js></script>
<script languaje=javascript>

<?php

if (isset($SECURE_PASSWORD_LEVEL))
	echo "secure_password_level='$SECURE_PASSWORD_LEVEL'\n";
if (isset($SECURE_PASSWORD_LENGTH))
	echo "secure_password_length='$SECURE_PASSWORD_LENGTH'\n";
?>


// Function to check letters and numbers
function alphanumeric(inputtxt) {
  var letters = /^[0-9a-zA-Z]+$/;
  if (letters.test(inputtxt)) {
    return true;
  } else {

    return false;
  }
}

function Enviar(){	res=VerificarPassword("pwd")
	if (!res && secure_password_level!="" && secure_password_length!=""){		alert('<?php echo $msgstr["pass_error"]." ".$msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
		if ($SECURE_PASSWORD_LENGTH>0) echo ". ". $msgstr["pass_format_1"]. " ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"];?>')
		return	}	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	new_password=Trim(document.administra.new_password.value)
	confirm_password=Trim(document.administra.confirm_password.value)

	if (login=="" || password=="" || new_password=="" || confirm_password==""){
		alert("<?php echo $msgstr["datosidentificacion"]?>")
		return
	}else{		if (new_password != confirm_password){			alert("<?php echo $msgstr["passconfirm"]?>")
			return		}
		txt=login+password+new_password+confirm_password
		if (alphanumeric(txt)){			document.administra.submit()		}else{			alert("<?php echo $msgstr["valchars"]?>")		}
	}}
</script>
</head>
<body>
	<div class="heading">
		<div class="institutionalInfo">
			<h1><img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../images/logoabcd.jpg";
					  ?>>
			<?php echo $institution_name?></h1>
		</div>
		<div class="userInfo"></div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="sectionInfo">
		<div class="breadcrumb"></div>
		<div class="actions"></div>
		<div class="spacer">&#160;</div>
	</div>
<form name=administra action=../common/inicio.php method=post onsubmit="Javascript:Enviar();return false">
<input type=hidden name=Opcion value=chgpsw>
<input type=hidden name=lang value="<?php echo $arrHttp["lang"]?>">
<input type=hidden name=db_path value="<?php if (isset($arrHttp["db_path"])) echo $arrHttp["db_path"]?>">
	<div class="middle login">
		<div class="loginForm">
			<div class="boxTop">
				<div class="btLeft">&#160;</div>
				<div class="btRight">&#160;</div>
			</div>
			<div class="boxContent">
				<div class="formRow">
					<label for="user"><?php echo $msgstr["userid"]?></label>
					<input type="text" name="login" id="user" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry';" />
				</div>
				<div class="formRow">
					<label for="pwd"><?php echo $msgstr["actualpass"]?></label>
					<input type="password" name="password" id="actualpwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';" onblur="this.className = 'textEntry superTextEntry';" />
					<a href=javascript:DisplayPassword('actualpwd')><?php echo $msgstr["ver"]?></a>
				</div>
				<div class="formRow">
					<label for="pwd"><?php echo $msgstr["newpass"]?></label>
					<input type="password" name="new_password" id="pwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus'";
				 	onblur="this.className = 'textEntry superTextEntry';<?php if (isset($SECURE_PASSWORD_LEVEL)  or isset($SECURE_PASSWORD_LENGTH)) echo "pwd_Validation('pwd')";?> " />
                    <a href=javascript:DisplayPassword('pwd')><?php echo $msgstr["ver"]?></a>
				<?php
					if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="") or (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="")) {						echo "<br><FONT COLOR=DARKRED>";						if ($SECURE_PASSWORD_LENGTH>0)
							echo $msgstr["pass_format_1"]." ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"]."<br>";
						if ($SECURE_PASSWORD_LEVEL>1)
							echo "<FONT COLOR=DARKRED>".$msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
						echo "</font>". ' &nbsp;<span id="spnPwd" class="pwd_Strength" ></span> &nbsp;';					}

				?>
				</div>
				<div class="formRow">
					<label for="pwd"><?php echo $msgstr["confirmpass"]?></label>
					<input type="password" name="confirm_password" id="confirmpwd" value="" class="textEntry superTextEntry" onfocus="this.className = 'textEntry superTextEntry textEntryFocus';<?php if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="")  or (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="") ) echo "VerificarPassword('pwd')";?>"
					   onblur="this.className = 'textEntry superTextEntry';" />
					<a href=javascript:DisplayPassword('confirmpwd')><?php echo $msgstr["ver"]?></a>
				</div>
				<div class="submitRow">
					<a href="javascript:Enviar()" class="defaultButton goButton">
					<img src="../images/icon/defaultButton_next.png" alt="" title="" />
					<span><?php echo $msgstr["chgpass"]?></span>
					</a>
				</div>
				<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
				<div class="bbLeft">&#160;</div>
				<div class="bbRight">&#160;</div>
			</div>
		</div>
	</div>
</form>

<?php include ("../common/footer.php");?>
	</body>
</html>



