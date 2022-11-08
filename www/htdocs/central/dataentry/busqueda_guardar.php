<?php
/*
20220926 fho4abcd Show filename, show script name, improve html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
//$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
$archivo_db=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab";
$archivo=$db_path.$archivo_db;
?>
<html><body>
<title><?php echo $msgstr["savesearch"] ?></title>
<?php
$fp=fopen($archivo,"a");
$res=fwrite($fp,trim($arrHttp["Descripcion"])."|".trim($arrHttp["Expresion"])."\n\n");
fclose($fp);
?>
<font size=1>Script: <?php echo $_SERVER['PHP_SELF'];?></font><br><br>
<font color=darkred><?php echo $msgstr["archivo"].": ".$archivo_db ?>
<h4><?php echo $msgstr["saved"]?></h4></font>

<a href=javascript:self.close()><?php echo $msgstr["cerrar"]?></a>

</body></html>