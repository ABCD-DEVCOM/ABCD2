<?php


?>

  <script>

		function EnviarReserva(){
			hayerror=0
			document.enviarreserva.items_por_reservar.value=items_por_reservar;
			if (Trim(document.enviarreserva.usuario.value)==''  ){
      			alert("<?php echo $msgstr["front_missing"]. " ".$msgstr["front_user_id"]?>")
      			hayerror=1
			}

			if (hayerror==1){
				return false
			}else{
				document.enviarreserva.submit()
  			}
		}
	</script>

<div class="py-3 my-3">
	<h3><?php echo $msgstr["reserve"]?></h3>
</div>

<form name=enviarreserva action=opac_statment_ex.php method=post onSubmit='EnviarReserva();return false' target=_top>
	<input type="hidden" name="mostrar_reserva" value="Y">
	<input type="hidden" name="items_por_reservar">

<?php

foreach ($_REQUEST as $key=>$value){
	if ($key!="items_por_reservar")
		echo "<input type=hidden name=$key value=\"$value\">\n";
}
?>

<div class="row g-3 py-2">

	<div class="col-auto">
		<label><?php echo $msgstr["front_user_id"]?>: </label>
	</div>

	<div class="col-auto">
		<input class="form-control" type="text" name="usuario" size="30">
	</div>

	<div class="col-auto">
		<input class="btn btn-success" type="submit" value="<?php echo $msgstr["front_send"]?> ">
	</div>
</div>

<?php
if ($accion=="reserve_one"){
	echo "&nbsp; &nbsp; <input type=button value=\" ".$msgstr["front_back"]." \" onclick=document.regresar.submit()>";
}
?>

</form>

<?php
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/disclaimer.txt")){
	    $fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/disclaimer.txt");
	    foreach ($fp as $value) echo "$value<br>";
	}

	foreach ($_REQUEST as $var=>$value){
		$_SESSION["$var"]=$value;
	}

?>
