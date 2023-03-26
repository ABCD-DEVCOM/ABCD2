  <script>
		function EnviarCorreo(){
			hayerror=0
			document.correo.comentario.value=escape(document.correo.comentario.value)
			if (Trim(document.correo.email.value)==''  || document.correo.email.value.indexOf('@')==-1){
      			alert('Correo inválido')
      			hayerror=1
			}

			if (hayerror==1){
				return false
			}else{
				document.correo.submit()
  			}
		}
	</script>


<form name="correo" action="correos.php" method="post" onSubmit='EnviarCorreo();return false'>
<?php
foreach ($_REQUEST as $var=>$value){
	echo "<input type='hidden' name='$var' value='$value'>\n";
}
?>
	<div class="row g-3 py-2">
		<label><?php echo $msgstr["to_mail"]?></label>
		<input class="form-control" type="text" name="email" size="55">
	</div>

	<div class="row g-3 py-2">	
		<label><?php echo $msgstr["comments"]?></label>
		<textarea  class="form-control" rows="3" cols="60" name="comentario"></textarea>
	</div>

	<div class="row g-3 py-2">
		<div class="col-auto">
			<input class="btn btn-success" type="submit" value="<?php echo $msgstr["send"]?> ">
		</div>

		<?php if ($accion=="mail_one"){ ?>
		<div class="col-auto">
			<input class="btn btn-light" type="button" value="<?php echo $msgstr["back"];?>" onclick="document.regresar.submit()">
		</div>
		<?php } ?>
	</div>
</form>