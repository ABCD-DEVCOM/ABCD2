<?php

global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");


include("../lang/admin.php");
include("../lang/soporte.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

echo "<form name=db action=editpar_update.php method=post>";
echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
echo "Path to the database: <input type=text name=path size=100>
<input type=submit value=execute>
</form>";


?>