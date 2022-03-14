<?php


?>

  <script>

		function EnviarReserva(){
			hayerror=0
			document.enviarreserva.items_por_reservar.value=items_por_reservar;
			if (Trim(document.enviarreserva.usuario.value)==''  ){
      			alert("<?php echo $msgstr["missing"]. " ".$msgstr["user_id"]?>")
      			hayerror=1
			}

			if (hayerror==1){
				return false
			}else{
				document.enviarreserva.submit()
  			}
		}
	</script>


<p align=center>
<strong><?php echo $msgstr["reserve"]?></strong></p>
<form name=enviarreserva action=opac_statment_ex.php method=post onSubmit='EnviarReserva();return false' target=_top>
<?php

foreach ($_REQUEST as $key=>$value){	if ($key!="items_por_reservar")
		echo "<input type=hidden name=$key value=\"$value\">\n";
}
?>
<input type=hidden name=mostrar_reserva value=Y>
<input type=hidden name=items_por_reservar>
<table align=center>
<tr><td><font size=2><?php echo $msgstr["user_id"]?>: </td><td><input type=text name=usuario size=30></td>
<tr><td colspan=2 align=center><br><input type=submit value=" <?php echo $msgstr["send"]?> ">
<?php
if ($accion=="reserve_one"){	echo "&nbsp; &nbsp; <input type=button value=\" ".$msgstr["back"]." \" onclick=document.regresar.submit()>";}
?>
</td></table>
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
