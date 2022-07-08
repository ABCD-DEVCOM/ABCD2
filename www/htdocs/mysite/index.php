<?php
session_start();
$_SESSION=array();
unset($_SESSION["db_path"]);
include("../central/config.php");
include("../$app_path/common/get_post.php");
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

include ("../$app_path/lang/admin.php");
include ("../$app_path/lang/lang.php");
?>
<!DOCTYPE html>

<html lang="<?php echo $lang;?>" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang;?>">

<head>

    <title>ABCD-MySite plug in</title>
    <meta http-equiv="Expires" content="-1" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $meta_encoding;?>">
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

    <!-- Stylesheets -->
    <link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css"
        media="screen" />

    <!--FontAwesome-->
    <link href="/assets/css/all.min.css" rel="stylesheet">


    <style type="text/css">
    html,
    body {
        height: 100vh;
        margin: 0;
    }

    .middle {
        height: 80vh;
    }
    </style>


    <script src=../<?php echo $app_path?>/dataentry/js/lr_trim.js></script>
    <script languaje=javascript>
    document.onkeypress =
        function(evt) {
            var c = document.layers ? evt.which :
                document.all ? event.keyCode :
                evt.keyCode;
            if (c == 13) Enviar()
            return true;
        }

    function UsuarioNoAutorizado() {
        alert("<?php echo $msgstr["menu_noau"]?>")
    }

    function Enviar() {
        login = Trim(document.administra.login.value)
        password = Trim(document.administra.password.value)
        //sas=document.administra.startas.selectedIndex
        if (login == "" || password == "") {
            alert("<?php echo $msgstr["datosidentificacion"]?>")
            return
        } else {
            document.administra.submit()
        }
    }
    </script>
    <?php
include ("../$app_path/common/css_settings.php");
?>	
</head>

<body class="mysite">
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
    <div class="sectionInfo">
        <div class="breadcrumb"></div>
        <div class="actions"></div>
        <div class="spacer">&#160;</div>
    </div>

    <form name="administra" onsubmit="javascript:return false" method="post" action="common/iniciomysite.php">
        <input type="hidden" name="Opcion" value="admin">
        <input type="hidden" name="cipar" value="acces.par">
        <input type="hidden" name="lang" value="<?php echo $arrHttp["lang"];?>">
        <input type="hidden" name="id" value="<?php if (!empty($_GET['id'])) echo $_GET['id'];?>">
        <input type="hidden" name="cdb" value="<?php echo $_GET['cdb'];?>">

        <div class="middle login">
            <div class="loginForm">

                <div class="boxContent">
                    <?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
					<div class=\"helper alert\">".$msgstr["menu_noau"]."
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
                        <input type="password" name="password" id="pwd" value="" class="textEntry superTextEntry"
                            onfocus="this.className = 'textEntry superTextEntry textEntryFocus';"
                            onblur="this.className = 'textEntry superTextEntry';" />
                    </div>
                    <div id="formRow3" class="formRow formRowFocus">


                    </div>
                    <div class="formRow">
                        <input type="checkbox" name="setCookie" id="setCookie" value="" />
                        <label for="setCookie" class="inline">Lembrar a senha neste computador</label>
                    </div>
                    <div class="submitRow">
                        <div class="frLeftColumn">
                            <a href="#">esqueceu a senha?</a>
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
    <?php include ("central/common/footermysite.php");?>
</body>

</html>