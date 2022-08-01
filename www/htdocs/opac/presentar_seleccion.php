<?php
include("common/opac-head.php");

$mostrar_menu="N";
//include("inc/leer_bases.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>".urldecode($value)."<br>";
unset($_REQUEST["usuario"]);
$desde=1;
$count="";
$accion="";
if (isset($_REQUEST["sendto"]) and $_REQUEST["sendto"]!="") $_REQUEST["cookie"]=$_REQUEST["sendto"];
$list=explode("|",$_REQUEST["cookie"]);
$ll=explode("_",$list[0]);
if (isset($_REQUEST["Accion"])) $accion=trim($_REQUEST["Accion"]);
if (isset($_REQUEST["db_path"])){
	$ptdb='&db_path='.$_REQUEST["db_path"];
} else {
	$ptdb="";
}


?>

	<script>
	function SendToWord(){
		document.regresar.action="modules/export/sendtoword.php"
		document.regresar.target=""
		document.regresar.submit()
		document.regresar.action="buscar_integrada.php"
	}
	function SendToXML(seleccion){
		cookie=document.regresar.cookie.value
		document.regresar.cookie.value=seleccion
		document.regresar.action="modules/export/sendtoxml.php"
		document.regresar.target="_blank"
		document.regresar.submit()
		document.regresar.action="buscar_integrada.php"
		document.regresar.target=""
		document.regresar.cookie=cookie
	}
	function SendToISO(){
		document.regresar.action="modules/export/sendtoiso.php"
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
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-white sticky-top">
        <h2 class="h2"><?php echo "<strong>".$msgstr["records_selected"]."</strong>"; ?></h2>	


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
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
			<div class="btn-group me-2">
			<a class="btn btn-sm btn-outline-secondary" href="javascript:SendToPrint()"><i class="fas fa-print"></i></a>
			<a class="btn btn-sm btn-outline-secondary" href="javascript:SendToWord()"><i class="far fa-file-word"></i></a>
			<?php if (count($sel_db)==1){?>

			<?php }?>
			<a class="btn btn-sm btn-outline-secondary" href="javascript:SendToISO()">ISO</a>
			<a class="btn btn-sm btn-outline-secondary" href="javascript:ShowHide('myMail')"><i class="far fa-envelope"></i></a>
			<?php if (isset($WEBRESERVATION) and $WEBRESERVATION=="Y") { ?>
				<a class="btn btn-sm btn-outline-secondary" href="javascript:ShowHide('myReserve')"><i class="fas fa-book"></i></a>
			<?php
			}
			?>
			</div>
			<a class="btn btn-sm btn-outline-secondary" href="javascript:document.regresar.submit()"><i class="fas fa-arrow-alt-circle-left"></i></a>
		</div>
	</div>
	</div>
	
	<?php } ?>

	<div id="myMail" style="display:<?php if ($accion=="mail_one") echo "block"; else echo "none";?>;margin:auto;width:600px;xheight:150px; position:relative;border:1px solid black;">
		<?php include("modules/mail/correo_iframe.php");?>
	</div>

	<?php include("modules/reserve/reserve_iframe.php")?>
	


<?php include ("presentar_seleccion_inc.php"); ?>

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

<?php
if ($accion=="reserve_one"){
	echo "<input type=button value=\" ".$msgstr["back"]." \" onclick=document.regresar.submit()>";
}
?>

<script>
Total_No=<?php echo $Total_No;?>;
contador=<?php echo $contador;?>;
</script>