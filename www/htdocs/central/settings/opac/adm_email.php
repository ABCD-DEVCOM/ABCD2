<?php
include ("conf_opac_top.php");

if ($_SESSION["profile"]=="adm"){ 

$wiki_help="OPAC-ABCD_configuraci%C3%B3n#Par.C3.A1metros_globales";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="general";
</script>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
		<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

	<?php
	if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar") {
		$fp=fopen($db_path."/opac_conf/correo.ini","w");
	?>

    <div class="alert success" onload="setTimeout(function () { window.location.reload(); }, 10)" >
		<?php echo $msgstr["updated"];?>
		<pre>opac_conf/correo.ini </pre>
	</div>

	<pre>
		<?php
			foreach ($_REQUEST as $var=>$value){
				$value=trim($value);
				if ($value!=""){
					$var=trim($var);
					if (substr($var,0,5)=="conf_"){
						if (substr($var,5)=="OpacHttp"){
							if (substr($value,strlen($value)-1,1)!="/"){
								$value.="/";
							}
						}
						echo substr($var,5)."=".$value."\n";
						fwrite($fp,substr($var,5)."=".$value."\n");
					}
				}
			}
		?>
	</pre>
	
	<?php fclose($fp); 	?>

	<a class="bt bt-green" href="javascript:EnviarForma('adm_email.php')">Voltar</a>

	<?php	exit(); } ?>

	<?php 
	if (file_exists($db_path."opac_conf/correo.ini")){
		$fp=file($db_path."opac_conf/correo.ini");
		foreach ($fp as $value){
			if (trim($value)!=""){
				$a=explode('=',$value);
				switch ($a[0]){
					case "HOST":
						$mail_host=trim($a[1]);
						break;
					case "PORT":
						$mail_port=trim($a[1]);
						break;
					case "USERNAME":
						$mail_user=trim($a[1]);
						break;
					case "PASSWORD":
						$mail_password=trim($a[1]);
						break;
					case "FROM":
						$mail_from=trim($a[1]);
						break;
					case "FROMNAME":
						$mail_fromname=trim($a[1]);
						break;
					case "SUBJECT":
						$mail_subject=trim($a[1]);
						break;
					case "TEST":
						$mail_test=trim($a[1]);
						break;
					case "PHPMAILER":
						$mail_send=trim($a[1]);
						break;
				}
			}
		}
	}
?>


<h3><?php echo $msgstr["parametros"]." (correo.ini)";?></h3>

<form name="parametros" method="post">
<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">
<?php
if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}

if (!isset($OpacHttp)){
	$OpacHttp=$_SERVER["HTTP_ORIGIN"].str_replace("config/parametros.php","",$_SERVER['REQUEST_URI']);
}
if (!isset($shortIcon))$shortIcon="";

?>

    <table class="table striped">
    	<tr>
    		<td><?php echo $msgstr["mail_host"]?></td>
    		<td valign="top"><input type="text" name="conf_HOST" size=100 value="<?php if(isset($mail_host)) echo $mail_host;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_port"]?></td>
    		<td valign="top"><input type=text name="conf_PORT" size="100" value="<?php if(isset($mail_port)) echo $mail_port;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_username"]?></td>
    		<td valign="top"><input type=text name="conf_USERNAME" size="100" value="<?php if(isset($mail_user)) echo $mail_user;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_password"]?></td>
    		<td valign="top"><input type=text name="conf_PASSWORD" size="100" value="<?php if(isset($mail_password)) echo $mail_password;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_from"]?></td>
    		<td valign="top"><input type=text name="conf_FROM" size="100" value="<?php if(isset($mail_from)) echo $mail_from;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_fromname"]?></td>
    		<td valign=top><input type=text name="conf_FROMNAME" size="100" value="<?php if(isset($mail_fromname)) echo $mail_fromname;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_subject"]?></td>
    		<td valign=top><input type=text name="conf_SUBJECT" size="100" value="<?php if(isset($mail_subject)) echo $mail_subject;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_test"]?></td>
    		<td valign=top><input type=text name="conf_TEST" size="100" value="<?php if(isset($mail_test)) echo $mail_test;?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["mail_send"]?></td>
    		<td valign=top>
                <label >
                    <input type="radio" name="conf_PHPMAILER" value="phpmailer" <?php if (isset($mail_send) and $mail_send=="phpmailer") echo " checked"?>> PHPMailer
                </label><br>
                <label >
                    <input type="radio" name="conf_PHPMAILER" value="PHPMail" <?php if (isset($mail_send) and $mail_send=="PHPMail") echo " checked"?>> PHP Mail
                </label>
            </td>
    	</tr>
    </table>
    
<input type="hidden" name="Opcion" value="Guardar">
<input type="submit" class="bt-green mt-5" value="<?php echo $msgstr["save"];?>">
</form>
</div>
</div>



<?php 
} else {
    echo $msgstr["menu_noau"];
}

include ("../../common/footer.php"); ?>