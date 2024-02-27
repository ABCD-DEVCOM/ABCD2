<form name="correo" action="controllers/control_mail.php" method="post" onSubmit='EnviarCorreo();return false'>
<?php
foreach ($_REQUEST as $var=>$value){
	echo "<input type='hidden' name='$var' value='$value'>\n";
}
?>

	<div class="g-3 py-2">
		<label><?php echo $msgstr["front_name"]?></label>
		<input class="form-control" type="text" name="nombre" size="55">
	</div>

	<div class="g-3 py-2">
		<label><?php echo $msgstr["front_to_mail"]?></label>
		<input class="form-control" type="email" name="email" size="55">
	</div>

	<div class="g-3 py-2">	
		<label><?php echo $msgstr["front_comments"]?></label>
		<textarea  class="form-control" rows="3" cols="60" name="comentario"></textarea>
	</div>

	<div class="g-3 py-2">
		<div class="col-auto">
			<input class="btn btn-success" type="submit" value="<?php echo $msgstr["front_send"]?> ">
		</div>

		<?php if ($accion=="mail_one"){ ?>
		<div class="col-auto">
			<input class="btn btn-light" type="button" value="<?php echo $msgstr["front_back"];?>" onclick="document.regresar.submit()">
		</div>
		<?php } ?>
	</div>
</form>