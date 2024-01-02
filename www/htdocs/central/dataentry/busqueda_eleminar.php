<?php
/*
20231231 fho4abcd Created
Function:	Delete an entry in the list of search expressions (<base></pfts/<lang>/search_expr.tab)
			The entry is identified by the "Descripcion"
Note:		The option in the dropdown list is removed by the caller
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
$archivo_db=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab";
$archivo=$db_path.$archivo_db;
$descripcion=$arrHttp["Descripcion"];
?>
<html><body>
<title><?php echo $msgstr["savesearch"] ?></title>
<div>
<?php
if (!file_exists($archivo)){ echo "<div style='color:red'>System error:".$archivo." does not exist"; die;}
$fp=file($archivo);
foreach ($fp as $value){
	// format= <description>|<search_expression>
	// may contain empty lines
	$value=trim($value);
	if ($value!=""){
		$pp=explode('|',$value);
		if ($pp[0]!=$descripcion) $expressiontab[]=$pp[0]."|".$pp[1];
	}
}
$fp=fopen($archivo,"w");
foreach($expressiontab as $value){
	fwrite($fp,$value.PHP_EOL);
}
fclose($fp);
?>
<font size=1>Script: <?php echo $_SERVER['PHP_SELF'];?></font><br><br>
<font color=darkred><?php echo $msgstr["archivo"].": ".$archivo_db ?>
<h4><?php echo $msgstr["saved"]?></h4></font>

<a href=javascript:self.close()><?php echo $msgstr["cerrar"]?></a>

</div></body></html>