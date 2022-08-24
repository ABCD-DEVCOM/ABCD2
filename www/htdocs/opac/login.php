<?php
session_start();

include("../central/config.php");
include("../$app_path/common/get_post.php");
foreach ($arrHttp as $var=>$value) 

if (isset($_SESSION["lang"])){
	$arrHttp["lang"]=$_SESSION["lang"];
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
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $meta_encoding;?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta http-equiv="Content-Language" content="<?php echo $lang;?>" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />

		<title>ABCD</title>

		<!-- Favicons -->
		
		<link rel="mask-icon" href="../../assets/images/favicons/favicon.svg">
    	<link rel="icon" type="image/svg+xml" href="../../assets/images/favicons/favicon.svg" color="#fff">

    	<link rel="icon" type="image/png" sizes="32x32" href="../../assets/images/favicons/favicon-32x32.png">
    	<link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicons/favicon-16x16.png">

    	<link rel="apple-touch-icon" sizes="60x60" href="../../assets/images/favicons/favicon-60x60.png">
    	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/images/favicons/favicon-76x76.png">
    	<link rel="apple-touch-icon" sizes="120x120" href="../../assets/images/favicons/favicon-120x120.png">
    	<link rel="apple-touch-icon" sizes="152x152" href="../../assets/images/favicons/favicon-152x152.png">
    	<link rel="apple-touch-icon" sizes="180x180" href="../../assets/images/favicons/favicon-180x180.png">


		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css" media="screen"/>

		<!--FontAwesome-->
		<link href="/assets/css/all.min.css" rel="stylesheet"> 

<script src=../<?php echo $app_path?>/dataentry/js/lr_trim.js></script>
<script language=javascript>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Enviar()
			return true;
	}

function UsuarioNoAutorizado(){
	alert("<?php echo $msgstr["menu_noau"];?>")
}
function Enviar(id){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	if (login=="" || password=="")
	{
		alert("<?php echo $msgstr["datosidentificacion"];?>")
		return
	}
	else
	{
	DoLogIn(login,password,id);		
	}
}

<!--//Ajax funtion to declare an XMLHttpRequest object
function getXMLHTTPRequest() {
try {
req = new XMLHttpRequest();
} catch(err1) {
  try {
  req = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (err2) {
    try {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (err3) {
      req = false;
    }
  }
}
return req;
}
// -->//XMLHttpRequest object instance
 var http = getXMLHTTPRequest();
 
 function DoLogIn(user,pass,service) {

 if (http.readyState == 4 || http.readyState == 0) {
        mydbaccess="<?php echo $db_path ?>";
  var myurl = 'dologin.php';//define la url
  myRand = parseInt(Math.random()*999999999999999);// es para que la info no vaya a la cache sino al servidor  
  var modurl = myurl+"?user="+user+"&pass="+pass+"&path="+mydbaccess+"&rand="+myRand;//crea la nueva url

	http.open("GET", modurl);//define tipo de convercion
  http.onreadystatechange = function(){ResponseDoLogin(service, user);}//es lo que queremos q se ejecute
  http.send(null);//se ejecuta la funcion
  }
  else
    setTimeout('DoLogIn('+user+','+pass+','+service+')', 1000);
 
 }
 function ResponseDoLogin(service,user) {

if (http.readyState == 4)
	  if(http.status == 200)
	{
	  if (http.responseText=="ok") {
	  	document.cookie = "user="+user;
	  		<?php 	
	  		$converter_path=$cisis_path."mx";
	  		$user=$_COOKIE["user"];
	  		?>	   
				console.log('Connected!'+user);
				close(); 		   
		  } else  {
		  	console.log('Error!');	
		  	alert(" Wrong user login-data, please try again");
		   	document.getElementById("user").focus();
		  }
        }
}
</script>
<?php
include ("../$app_path/common/css_settings.php");
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
	<div class="sectionInfo">
		<div class="breadcrumb"></div>
		<div class="actions"></div>
		<div class="spacer">&#160;</div>
	</div>

<section>
<form name="administra" onsubmit="javascript:return false" method="post" >
<input type="hidden" name=Opcion value="admin">
<input type="hidden" name=cipar value="users.par">
<input type="hidden" name="window_id">
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
			if (isset($arrHttp["login"]) and $arrHttp["login"]=="P"){
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
		</div>
		<div class="formRow">
				<a href="javascript:Enviar('<?php echo $_GET["id"];?>')" class="bt bt-blue">
					<?php echo $msgstr["entrar"]?> 
				</a>
		</div>	
	</div>

	</div>
</div>
</form>
</section>
	</body>
</html>