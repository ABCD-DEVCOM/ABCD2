<?php
session_start();
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
$salida=$arrHttp["FCK"];
$salida=stripslashes($salida);
if (isset($msg_path) and trim($msg_path)!="")
	$archivo=$msg_path."documentacion/".$arrHttp["archivo"];
else
	$archivo=$db_path."documentacion/".$arrHttp["archivo"];
$fp = fopen($archivo, "w", 0); #open for writing
  fputs($fp, $salida); #write all of $data to our opened file
  fclose($fp); #close the file

echo "<html><body>

	<a href=edit.php?archivo=" . $arrHttp["archivo"].">Editar</a><br>";
	echo $salida;

?>
<p>
<input type="submit" value="<?php echo $msgstr["close"]?>" onclick=javascript:self.close()>