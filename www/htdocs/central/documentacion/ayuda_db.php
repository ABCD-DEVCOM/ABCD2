<?php
/*
20220925 fho4abcd cleanup+ new style button
*/
session_start();
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
unset($fp);
$archivo=$db_path.$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$arrHttp["campo"];
if (!file_exists($archivo)){	$archivo=$db_path.$arrHttp["base"]."/ayudas/".$lang_db."/".$arrHttp["campo"];
}
if (!file_exists($archivo)){
    include("../common/header.php");
	echo "<h4>".$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$arrHttp["campo"]." &rarr; ".$msgstr["notfound"]."</h4>";    ?>
    <div>
    <a class="bt bt-red" href="javascript:window.close();"><i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["cerrar"]?></a>
    </div>
    <?php
	die;}
$fp=file($archivo);
foreach ($fp as $value) {
    $value=str_replace('/php',$app_path.'/',$value);
    echo "$value\n";
}?>
</body>
</html>