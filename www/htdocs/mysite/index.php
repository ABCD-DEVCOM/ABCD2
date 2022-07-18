<?php

include "../central/config.php";
include "../$app_path/common/get_post.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
} 

// unset($_SESSION["db_path"]);

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

<html lang="<?php echo $lang;?>" lang="<?php echo $lang;?>">

<head>

    <title>ABCD | MySite</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Expires" content="-1" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $meta_encoding;?>">
    <meta name="robots" content="all" />
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

    <!--Bootstrap-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    
<meta name="theme-color" content="#712cf9">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

     
    </style>


    <link href="assets/css/signin.css?<?php echo time();?>" rel="stylesheet" />

    <!--FontAwesome-->
    <link href="/assets/css/all.min.css" rel="stylesheet">


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
        if (login == "" || password == "") {
            alert("<?php echo $msgstr["datosidentificacion"]?>")
            return
        } else {
            document.administra.submit()
        }
    }
    </script>

</head>

  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
    <form name="administra" onsubmit="javascript:return false" method="post" action="common/index.php">
        <input type="hidden" name="Opcion" value="admin">
        <input type="hidden" name="cipar" value="acces.par">
        <input type="hidden" name="lang" value="<?php echo $lang;?>">
        <input type="hidden" name="id" value="<?php if (!empty($_GET['id'])) echo $_GET['id'];?>">
        <input type="hidden" name="cdb" value="<?php if (!empty($_GET['cdb'])) echo $_GET['cdb'];?>">
    <?php
    if (isset($def['LOGO_DEFAULT'])) {
        echo "<img class='mb-4'  src='/assets/images/logoabcd.png?".time()."' title='$institution_name'>";
    } elseif ((isset($def["LOGO"])) && (!empty($def["LOGO"]))) {
        echo "<img class='mb-4'  src='".$folder_logo.$def["LOGO"]."?".time()."' title='";
        if (isset($institution_name)) echo $institution_name;
        echo "'>";
    } else {
        echo "<img class='mb-4'  src='assets/img/png/logo_abcd_152x182px.png?".time()."' title='ABCD'>";
    }
    ?>


    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="text" class="form-control" placeholder="name@example.com" name="login" id="user"  autocomplete="username">
      <label for="floatingInput"><?php echo $msgstr["userid"]?></label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" placeholder="Password" name="password" id="pwd" autocomplete="current-password">
      <label for="floatingPassword"><?php echo $msgstr["password"]?></label>
    
    </div>

    <?php
    if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
	    echo '<div class="alert alert-warning" role="alert">'.$msgstr["menu_noau"].'</div>';
    }

    if (isset($arrHttp["login"]) and $arrHttp["login"]=="P"){
        echo '<div class="alert alert-warning" role="alert">'.$msgstr["pswchanged"].'</div>';
    }
    ?>    
      <?php if (isset($change_password) and $change_password=="Y") echo "<br><a href=javascript:CambiarClave()>". $msgstr["chgpass"]."</a>\n";?>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me" name="setCookie" id="setCookie"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" onclick="Enviar()"><?php echo $msgstr["entrar"];?></button>
    <p class="mt-5 mb-3 text-muted">&copy; 2022 | <?php echo $meta_encoding?></p>

<?php
if (file_exists("dbpath.dat")){
	global $db_path;
	$fp=file("dbpath.dat");
	echo $msgstr["database_dir"].': <select name=db_path>\n';
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
  </form>
  
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

</main>


</body>

</html>