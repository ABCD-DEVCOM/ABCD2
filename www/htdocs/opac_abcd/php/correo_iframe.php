<?php

?>

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
<p>
<form name=correo action=correos.php method=post onSubmit='EnviarCorreo();return false'>
<?php
foreach ($_REQUEST as $var=>$value){	echo "<input type=hidden name=$var value=$value>\n";}
?>
<table>
<tr><td><font size=2><?php echo $msgstr["to_mail"]?></font></td><td><input type=text name=email size=55><font color=red size=1></td>
<tr><td valign=top><font size=2><?php echo $msgstr["comments"]?></font></td><td><textarea rows=3 cols=60 name=comentario></textarea></td>
<tr><td colspan=2 align=center><input type=submit value=" <?php echo $msgstr["send"]?> ">
<?php
if ($accion=="mail_one"){
	echo "&nbsp; &nbsp; <input type=button value=\" ".$msgstr["back"]." \" onclick=document.regresar.submit()>";
}
?>
</td></table>
</form>