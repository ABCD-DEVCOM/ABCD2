<?php
include( $_SERVER['DOCUMENT_ROOT']."/central/config_opac.php");
$modo="";
if (isset($_REQUEST["base"]))
	$actualbase=$_REQUEST["base"];
else
	$actualbase="";
if (isset($_REQUEST["xmodo"]) and $_REQUEST["xmodo"]!="") {
	unset($_REQUEST["base"]);
	$modo="integrado";
}

function wxisLlamar($base,$query,$IsisScript){
global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}
//include ("get_ip_address.php");
header('Content-Type: text/html; charset=".$charset."');
$meta_encoding=$charset;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
	<?php if (isset($shortIcon)and $shortIcon!=""){
		echo "<link rel=\"shortcut icon\" href=\"<?php echo $ShorcutIcon?>\" type=\"image/x-icon\">\n";
	}
	?>
	<title><?php echo $TituloPagina?></title>

	<link href="/assets/css/colors.css" rel="stylesheet"> 
	<link href="/assets/css/buttons.css" rel="stylesheet"> 
	<link href="/assets/css/normalize.css" rel="stylesheet"> 

	<link href="assets/css/styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />
	<script src=/opac/assets/js/script_b.js?<?php echo time(); ?>></script>
	<script src=/opac/assets/js/highlight.js?<?php echo time(); ?>></script>
	<script src=/opac/assets/js/lr_trim.js></script>
	<script src=/opac/assets/js/selectbox.js></script>

	<!--FontAwesome-->
	<link href="/assets/css/all.min.css" rel="stylesheet"> 

<script>
	document.cookie = 'ORBITA; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'
	document.cookie =  'ORBITA=;';

/* Marcado y presentación de registros*/
function getCookie(cname) {
    var name = cname+"=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function Seleccionar(Ctrl){
	cookie=getCookie('ORBITA')
	if (Ctrl.checked){
		if (cookie!=""){
		    c=cookie+"|"
			if (c.indexOf(Ctrl.name+"|")==-1)
				cookie=cookie+"|"+Ctrl.name
		}else{
			cookie=Ctrl.name
		}
	}else{
		sel=Ctrl.name+"|"
		c=cookie+"|"
		n=c.indexOf(sel)
		if (n!=-1){
			cookie=cookie.substr(0,n)+ cookie.substr(n+sel.length)
		}

	}
	document.cookie="ORBITA="+cookie
	Ctrl=document.getElementById("cookie_div")
	Ctrl.style.display="inline-block"
}

function delCookie(){
  	document.cookie =  'ORBITA=;';

}
var user = getCookie("ORBITA");
  if (user != "") {
    alert("Welcome again " + user);
  } else {

    }

</script>


<script>
msgstr=Array()
msgstr["no_rsel"]="<?php echo $msgstr["no_rsel"]?>"
msgstr["sel_term"]="<?php echo $msgstr["sel_term"]?>"
msgstr["miss_se"]="<?php echo $msgstr["miss_se"]?>"
msgstr["rsel_no"]="<?php echo $msgstr["rsel_no"]?>"
msgstr["reserv_no"]="<?php echo $msgstr["reserv_no"]?>"
actualScript="<?php echo $actualScript?>"

</script>
</head>
<body <?php if (isset($onload)) echo $onload?>>
<header id="header-wrapper" >
	<div id="header">
		<div id="logo">
			<a name="inicio" href="<?php echo $link_logo?>?lang=<?php echo $_REQUEST['lang']?>"><img src="<?php echo $logo?>"></a>
		</div>

	</div>
	 <div class="areaTitulo">
	 	<div class=tituloBase>
	 		<?php 
	 		echo $TituloEncabezado;
	 		if (isset($_REQUEST["db_path"])) 
	 			echo "  ".$_REQUEST["db_path"];
	 		?>
	 			
	 	</div>
	 	<div>
	 	 <?php echo $charset;
	 		if (file_exists("opac_dbpath.dat")) 
	 			echo "<a href=../index.php>Cambiar carpeta bases</a>";
	 	 ?>
	 	 </div>
	 </div>
</header>
<?php
if (!file_exists($db_path."opac_conf/$lang/lang.tab")){
	echo $msgstr["missing"]." ".$db_path."opac_conf/$lang/lang.tab";
	die;
}
if (!isset($mostrar_menu) or (isset($mostrar_menu) and $mostrar_menu=="S")){
?>
	<div id="menu-wrapper">
	<div id="menu">
		<ul>
			<li><a href="javascript:openNav()">&#9776;<?php echo $msgstr["menu"];?></a></li>
			<li><a href="javascript:document.inicio_menu.submit()"><?php echo $msgstr["inicio"]?></a></li>
			<?php
				if (file_exists($db_path."opac_conf/".$lang."/menu.info")){
					$fp=file($db_path."opac_conf/".$lang."/menu.info");
					foreach ($fp as $value){
						$value=trim($value);
						if ($value!=""){
							$x=explode('|',$value);
							echo "<li><a href=\"".$x[1]."\"";
							if (isset($x[2])and $x[2]=="Y") echo " target=_blank";
							echo ">".$x[0]."</a></li>";
						}
					}
				}

			?>
		</ul>
	</div>
	<div id="right">
		<div id="language">

			<select name="lang" onchange="ChangeLanguage()" id="lang">
				<?php
					$fp=file($db_path."opac_conf/$lang/lang.tab");
					foreach ($fp as $value){
						if (trim($value)!=""){
							$a=explode("=",$value);
							echo "<option value=".$a[0];
							if ($lang==$a[0]) echo " selected";
							echo ">".trim($a[1])."</option>";
						}
					}
				?>
			</select>
		</div>
	<!-- end #menu -->
	</div>
 <?php
 }
 	if ((!isset($_REQUEST["existencias"]) or $_REQUEST["existencias"]=="") and !isset($sidebar) )include("sidebar.php");
 ?>
	<div id="page">
		<div id="content" <?php if (isset($desde) and $desde="ecta") 
		echo "style='float:left;border: #cccccc 1px solid;border-radius:15px'"; ?>>

<?php
	if (!isset($indice_alfa)) include("submenu_bases.php");
	$_REQUEST["base"]=$actualbase;
?>
