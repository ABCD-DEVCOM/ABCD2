<?php
session_start();

//session_name('orbitacn');

var_dump($_SESSION);

$mostrar_menu="N";
include("../central/config_opac.php");
include("inc/leer_bases.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>".urldecode($value)."<br>";
unset($_REQUEST["usuario"]);
$desde=1;
$count="";
$accion="";
if (isset($_REQUEST["sendto"]) and $_REQUEST["sendto"]!="") $_REQUEST["cookie"]=$_REQUEST["sendto"];
$list=explode("|",$_REQUEST["cookie"]);
$ll=explode("_",$list[0]);
if (isset($_REQUEST["Accion"])) $accion=trim($_REQUEST["Accion"]);
if (isset($_REQUEST["db_path"]))
	$ptdb='&db_path='.$_REQUEST["db_path"];
else
	$ptdb="";
header('Content-Type: text/html; charset=".$charset."');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
<!--<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />-->
	<title><?php echo $TituloPagina?></title>
	<link href="assets/styles/styles.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="screen" />

	<link href="/assets/css/colors.css" rel="stylesheet"> 
	<link href="/assets/css/buttons.css" rel="stylesheet"> 
	<link href="/assets/css/normalize.css" rel="stylesheet"> 

	<!--FontAwesome-->
	<link href="/assets/css/all.min.css" rel="stylesheet"> 

	<script src=assets/js/script_b.js?<?php echo time(); ?>></script>
	<script src=assets/js/highlight.js?<?php echo time(); ?>></script>
	<script src=assets/js/lr_trim.js></script>
	<script src=assets/js/selectbox.js></script>
	<script>
	function SendToWord(){
		document.regresar.action="sendtoword.php"
		document.regresar.target=""
		document.regresar.submit()
		document.regresar.action="buscar_integrada.php"
	}
	function SendToXML(seleccion){
		cookie=document.regresar.cookie.value
		document.regresar.cookie.value=seleccion
		document.regresar.action="sendtoxml.php"
		document.regresar.target="_blank"
		document.regresar.submit()
		document.regresar.action="buscar_integrada.php"
		document.regresar.target=""
		document.regresar.cookie=cookie
	}
	function SendToISO(){
		document.regresar.action="sendtoiso.php"
		document.regresar.submit()
		document.regresar.action="buscar_integrada.php"
		document.regresar.target=""
	}
	function SendToPrint(){
		document.regresar.target=""
		CerrarCorreo()
		var x = document.getElementById("toolBar");
		x.style.display = "none";
		self.print()

	 	var afterPrint = function() {

      		 var x = document.getElementById("toolBar");
			x.style.display = "block";
    	};

 		window.onafterprint = afterPrint;
	}
  	function ShowHide(myDiv) {
  		if (myDiv=="myMail"){
  			document.getElementById("myReserve").style.display="none"
  		}else{
  			document.getElementById("myMail").style.display="none"
  			if (Total_No>=contador){
  				alert("<?php echo $msgstr["nothing_to_reserve"]?>")
  				return
  			}
  		}
  		var x = document.getElementById(myDiv);
  		if (x.style.display === "none") {
    		x.style.display = "block";
  		} else {
    		x.style.display = "none";
  		}
	}

	</script>
<body>
	<header id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><a href="<?php echo $link_logo?>"><img src=<?php echo $logo?>></a></h1>
			</div>
		</div>
	</header>

<div id="wrapper">
	<div id="page" style='float:left;width:90%'>
		<div id="content" style='float:left;width:90%'>
		<br>


	<?php
	$list=explode('|',$_REQUEST["cookie"]);
	foreach ($list as $value){
		$value=trim($value);
		if ($value!="")	{
			$x=explode('_',$value);
			$sel_db[$x[1]]=$x[1];
		}
	}

	if ($accion!="mail_one" and $accion!="print_one" and $accion!="reserve_one"){
	?>
		<div id=toolBar style="margin:auto;text-align:center;width:400px;border:1px solid;padding:5px">
			<a class="bt" href="javascript:SendToPrint()"><i class="fas fa-print"></i></a>&nbsp; &nbsp;
			<a class="bt" href="javascript:SendToWord()"><i class="far fa-file-word"></i></a>&nbsp; &nbsp;
			<?php if (count($sel_db)==1){?>

			<?php }?>
			<a class="bt" href="javascript:SendToISO()">ISO</a>&nbsp; &nbsp;
			<a class="bt" href="javascript:ShowHide('myMail')"><i class="far fa-envelope"></i></a>&nbsp; &nbsp;
			<?php if (isset($WEBRESERVATION) and $WEBRESERVATION=="Y") { ?>
				<a class="bt" href="javascript:ShowHide('myReserve')"><i class="fas fa-book"></i></a>&nbsp; &nbsp;
			<?php
			}
			?>
			<a class="bt bt-blue" href="javascript:document.regresar.submit()"><i class="fas fa-arrow-alt-circle-left"></i></a>
		</div>
	<br>
	<?php } ?>
	<div id="myMail" style="display:<?php if ($accion=="mail_one") echo "block"; else echo "none";?>;margin:auto;width:600px;xheight:150px; position:relative;border:1px solid black;">
		<?php include("correo_iframe.php");?>
	</div>
	<div id="myReserve" style="display:<?php if ($accion=="reserve_one") echo "block"; else echo "none";?>;margin:auto;width:600px;xheight:150px; position:relative;border:1px solid black;">
			<?php include("reserve_iframe.php")?>;
	</div>

<?php
echo "<strong><font size=3 color=darkred>".$msgstr["records_selected"]."</font></strong><br><br>";
function wxisLlamar($base,$query,$IsisScript){
global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}
?>

<div class="results">

	<?php include ("presentar_seleccion_inc.php"); ?>

</div>
<?php
If (isset($accion) and $accion=="print"){
?>
<script>
	self.print()
</script>


<?php
	foreach ($_REQUEST as $var=>$value){
		$_SESSION["$var"]=$value;
	}
}
?>

</div>
<?php
//}
?>
			</div>
		</div>
	</body>
</html>

<script>
Total_No=<?php echo $Total_No?>;
contador=<?php echo $contador?>;
</script>