<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab";
$fp=fopen($archivo,"a");
$res=fwrite($fp,trim($arrHttp["Descripcion"])."|".trim($arrHttp["Expresion"])."\n\n");
fclose($fp);
echo "<html><body>
<title>".$msgstr["savesearch"]."</title>
<font face=verdana size=2><font color=darkred><h4>".$msgstr["saved"]."</h4>

<a href=javascript:self.close()>".$msgstr["cerrar"]."</a>

</body></html>";

?>