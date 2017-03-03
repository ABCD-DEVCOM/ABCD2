<?
session_start();

include("central/config.php");
include("central/common/get_post.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

if (isset($arrHttp["lang"]))
{
    $lang=$arrHttp["lang"];
}
else if (isset($lang))
{
    $arrHttp["lang"]=$lang;
}
else
{
    $arrHttp["lang"]="en";
}


if (!isset($_SESSION["lang"])) $_SESSION["lang"]=$lang;

include ("central/lang/admin.php");
include ("central/lang/mysite.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>

		<title>ABCD-MySite plug in</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta http-equiv="Content-Language" content="pt-br" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="central/css/templatemysite.css" type="text/css" media="screen"/>
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="php/css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="php/css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<script src="central/dataentry/js/lr_trim.js"></script>
<script languaje=javascript>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Enviar()
			return true;
	}

function UsuarioNoAutorizado(){
	alert("<?php echo $msgstr["menu_noau"]?>")
}

function CambiarClave(){
	document.cambiarPass.login.value=Trim(document.administra.login.value)
	document.cambiarPass.password.value=Trim(document.administra.password.value)
	document.cambiarPass.submit()
}

function Enviar(){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	//sas=document.administra.startas.selectedIndex
	if (login=="" || password==""){
		alert("<?php echo $msgstr["datosidentificacion"]?>")
		return
	}else{
		document.administra.submit()
	}
}

</script>
	</head>
	<body class="mysite">
		<div class="headingmysite">
			<div class="institutionalInfo">
				<h1><?php echo $institution_name?></h1>
				<h2>ABCD</h2>
			</div>
			<div class="userInfo">

			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="sectionInfo">
			<div class="breadcrumb">

			</div>
			<div class="actions">

			</div>
			<div class="spacer">&#160;</div>
		</div>
<form name=administra onsubmit="javascript:return false" method=post action="central/iniciomysite.php">
<input type=hidden name=Opcion value=admin>
<input type=hidden name=cipar value=acces.par>
<input type=hidden name=lang value="<?php echo $arrHttp["lang"];?>">
<input type=hidden name=id value="<?php echo $_GET['id'];?>">
<input type=hidden name=cdb value="<?php echo $_GET['cdb'];?>">
		<div class="middle login">
			<div class="loginForm">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent">
<?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
			<div class=\"helper alert\">".$msgstr["menu_noau"]."
			</div>
		";
}
if ($_GET["login"]=="P"){
		echo "
			<div class=\"helper alert\">".$msgstr["pswchanged"]."
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

					<div class="spacer">&#160;</div>
				</div>
					<div class="formRow">
					<!--	<input type="checkbox" name="setCookie" id="setCookie" value="" />
						<label for="setCookie" class="inline">Lembrar a senha neste computador</label> -->
					</div>
					<div class="submitRow">
						<div class="frLeftColumn">
						<!--	<a href="#">esqueceu a senha?</a>-->
						</div>
						<div class="frRightColumn">
							<a href="javascript:Enviar()" class="defaultButton goButton">
								<img src="central/images/icon/defaultButton_next.png" alt="" title="" />
								<span><strong><?php echo $msgstr["entrar"]?></strong></span>
							</a>
						</div>
						<div class="spacer">&#160;</div>
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
<form name=cambiarPass action="<?php echo $app_path?>/mysite_change_password.php" method=post>
<input type=hidden name=login>
<input type=hidden name=password>
<input type=hidden name=Opcion value=chgpsw>
</form>
<?php include ("central/common/footermysite.php");?>
	</body>
</html>



