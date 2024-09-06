<?php
//session_name('ABCDcn');

//include("../../central/config_opac.php");

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

//include($Web_Dir."head.php");
//include($Web_Dir."includes/leer_bases.php");
?>

<div id="page">
	<div id="content" >
	<?php
	$list=explode('|',$_REQUEST["cookie"]);
	foreach ($list as $value){
		$value=trim($value);
		if ($value!="")	{
			$x=explode('_=',$value);
			$sel_db[$x[1]]=$x[1];
		}
	}
?>
	<div class="d-flex justify-content-between py-3 my-3">
		<?php echo "<h2>".$msgstr["front_records_selected"]."</h2> ".  $backButton->render();?>
	</div>

	<div id="myMail" class="card bg-white p-2 my-4" style="display:<?php if ($accion=="mail_one") echo "block"; else echo "none";?>;">
		<?php include($Web_Dir."components/mail_form.php");?>
	</div>
	<div id="myReserve" class="card bg-white p-2 my-4" style="display:<?php if ($accion=="reserve_one") echo "block"; else echo "none";?>;">
			<?php include($Web_Dir."reserve_iframe.php")?>
	</div>

<?php if ($accion!="mail_one" and $accion!="print_one" and $accion!="reserve_one") { ?>

		<?php 
			if (isset($opac_gdef['printButton'])) echo $printButton->render();
			echo $downloadButton->render();
			echo $WordButton->render();
			echo $emailButton->render();
		
			if (isset($WebReservation) and $WebReservation=="Y") {
				echo $reserveButton->render();
			 } 
 } ?>


		<?php echo ShowSelection(); ?>

<?php if (isset($accion) and ($accion=="print") or ($accion=="print_one")){ ?>
	<script>
		window.print()
	</script>

	<?php
		foreach ($_REQUEST as $var=>$value){
			$_SESSION[$var]=$value;
		}
	}
	?>
	</div>
</div>

<?php
//include($Web_Dir."views/footer.php");