<?php
session_start();
unset($_SESSION);
session_destroy();
$fp=file("../php/config_opac.php");

$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Tutorial_de_configuraci%C3%B3n#Entrada_al_m.C3.B3dulo_de_configuraci.C3.B3n";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Tutorial_de_configuraci%C3%B3n#Entrada_al_m.C3.B3dulo_de_configuraci.C3.B3n";
$msg_err="";
$msg_err="";
$primera_vez="";
$config_php="";
foreach ($fp as $value){
	if ($config_php!="") break;
	$value=trim($value);
	if ($value!=""){
		if (substr($value,0,7)=="include" and $config_php==""){
			if ($config_php==""){
				$ix=strpos($value,'"');
				$config_php=substr($value,$ix+1);
				$ix=strpos($config_php,'"');
				$config_php=substr($config_php,0,$ix);
				if (!file_exists($config_php)){
					$dir= $_SERVER['PHP_SELF'];
					$ix=strpos($dir,'/config/index.php');
					$dir=substr($dir,0,$ix);
					header('Content-Type: text/html; charset="utf-8">');
					echo "<Html>";
					echo "<body>";
					echo "<font color=red face=arial size=4>Error. Script not found <strong>config_php</strong> in <strong>ABCD central folder</strong>.<br><br>";
					echo "Please check the <strong>include</strong> path in <strong><font color=black>$dir/php/config_opac.php</font></strong> ";
					echo "(Actual include path: $config_php)<br><br>The <strong>include</strong> Must contain the full path to ABCD config.php script";
					echo "<br><br><strong>See tutorial, item 5</strong>";
					echo "<div id=\"help_01\" style=\"display:block;margin:auto;width:100%;xheight:150px; position:relative;border:1px solid black;\">
					    <iframe style=\"width:100%; height:350px; border:0\" src=http://wiki.abcdonline.info/OPAC-ABCD_Tutorial_de_configuraci%C3%B3n>

						</iframe>
					</div>";
					echo "</body></html>";
					die;
				}
			}
		}

	}
}
include("../php/config_opac.php");

$_SESSION["lang"]=$lang;
$_REQUEST["lang"]=$lang;
$_REQUEST["modo"]="";
include ("$CentralPath/lang/admin.php");
include ("$CentralPath/lang/lang.php");
include ("$CentralPath/lang/opac.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<title>ABCD</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<META http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
		<meta http-equiv="Content-Language" content="pt-br" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href=../styles/styles.css type="text/css" media="screen"/>
		<!--[if IE]>
			<link rel="stylesheet" rev="stylesheet" href="<?php echo $CentralHttp?>/central/css/bugfixes_ie.css" type="text/css" media="screen"/>
		<![endif]-->
		<!--[if IE 6]>
			<link rel="stylesheet" rev="stylesheet" href="<?php echo $CentralHttp?>/central/css/bugfixes_ie6.css" type="text/css" media="screen"/>
		<![endif]-->
<script src=../js/lr_trim.js></script>
<script languaje=javascript>
function ShowHide(myDiv) {
  	var x = document.getElementById(myDiv);
  	if (x.style.display === "none") {
    	x.style.display = "inline-block";
  	} else {
    	x.style.display = "none";
  	}
}

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Enviar_login()
			return true;
	}

function UsuarioNoAutorizado(){
	alert("<?php echo $msgstr["menu_noau"]?>")
}

function Enviar_login(){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	if (login=="" || password==""){
		alert("<?php echo $msgstr["datosidentificacion"]?>")
		return
	}else{		dbp=document.getElementById("db_path")
		if (dbp)
			document.administra.db_path_desc.value=dbp.options[dbp.selectedIndex].text
		ix=document.administra.lang.selectedIndex
		document.administra.lang_init.value=document.administra.lang.options[ix].value
		document.administra.submit()
	}
}

</script>
</head>
<body style="background:white">
	<div >
		<div>
			<h1><img src=../images/circulos.png></a>
			<?php echo $msgstr["opac_configure"]?></h1>
		</div>

	</div>
<div id=page>
<DIV style="float: left; border:1px solid; width:400px;padding:10px;display:block;margin-bottom:10px;">
<?php
	if (isset($_REQUEST["invaliduser"])) echo "<center><strong><font color=red>Invalid user</font></strong></center><br>";
?>
<form name=administra onsubmit="javascript:return false" method=post action=menu.php>
<input type=hidden name=Opcion value=admin>
<input type=hidden name=cipar value=acces.par>

	<table align=center>
		<tr><td colspan=2 align=left>

		<tr>
			<td><?php echo $msgstr["userid"]?></td>
			<td><input autocomplete="off" type="text" name="login" id="user"></td>
		</tr>
		<tr>
			<td><?php echo $msgstr["password"]?></td>
			<td><input autocomplete="off" type="password" name="password" id="pwd" value="" ></td>
		</tr>
		<tr>
			<td><?php echo $msgstr["lang"]?></td>
			<td>
<?php
 	$a=$db_path."/lang/$lang/lang.tab";
 	if (!file_exists($a)){ 		$a=$db_path."/opac_conf/en/lang.tab"; 	}
 	if (file_exists($a)){ 		echo '<select name=lang >';
		$fp=file($a);
		$selected="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$l=explode('=',$value);
				if ($l[0]!="lang"){
					if ($l[0]==$_SESSION["lang"]) $selected=" selected";
					echo "<option value=$l[0] $selected>".$l[1]."</option>";
					$selected="";
				}
			}
		}
	}else{
		echo $msgstr["flang"].$a;
		die;
	}
?>
			</select>
		</td>
	</tr>


<?php
	if (file_exists("../php/opac_dbpath.dat")){
		echo "<tr><td>";
		$fp=file("../php/opac_dbpath.dat");
		echo $msgstr["database_dir"].": </td><td><select name=db_path id=db_path>\n";
		foreach ($fp as $value){
			if (trim($value)!=""){
				$v=explode('|',$value);
				$v[0]=trim($v[0]);
				echo "<Option value=".trim($v[0]).">".$v[1]."\n";
			}

		}
		echo "</select></td></tr>";
	}
?>
	<tr>
		<td colspan=2>
			<input type=hidden name=db_path_desc>
			<input type=hidden name=lang_init>
			<input type=submit value="<?php echo $msgstr["send"];?>" onclick=javascript:Enviar_login()>
		</td>
	</tr>
</table>
<?php if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">";?>
</form>
</div>

<div style="position:relative;width:100%;height:400px;float:left">
<?php include ("wiki_help.php")?>

</div>


	</body>
</html>



