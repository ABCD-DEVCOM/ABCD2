<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");

include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/header.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";die;

if (strpos($arrHttp["picklist"],"%path_database%")===false){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"];
}else{
	$archivo=str_replace("%path_database%",$db_path,$arrHttp["picklist"]);
}
$fp=false;
$fp=file($archivo);
if (!$fp){	echo $archivo.": ".$msgstr["misfile"];
	die;}

$Opciones="";
foreach ($fp as $value){
	$value=trim($value);
	if ($Opciones=="")
		$Opciones=$value;
	else
		$Opciones.='$$$$'.$value;
}

if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="dataentry"){
?>

<script>
	window.opener.ValorTabla="<?php echo $Opciones?>"
	window.opener.SelectName='<?php echo $arrHttp["Ctrl"]?>'
	window.opener.AsignarTabla()
	self.close()
</script>
<?php
}
