<?php
/*
20220202 fho4abcd back button, div-helper
*/
/*
** Note that setting a value via the dataentry screen closes the pop-up window without any positive feedback
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	$encabezado="&encabezado=s";
	include("../common/institutional_info.php");
}else{
	$encabezado="";
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["picklist"]. ": " . $arrHttp["base"]." - ".$arrHttp["picklist"]?>
    </div>
    <div class="actions">
        <?php
            if (isset($arrHttp["desde"]) and $arrHttp["desde"]!="dataentry"){
                $backtoscript="fixed_marc.php";
                include "../common/inc_back.php";
            }else{
                if (!isset($arrHttp["desde"])){
                    $backtoscript="picklist.php?base=". $arrHttp["base"]."&row=".$arrHttp["row"]."&picklist=".$arrHttp["picklist"];
                    include "../common/inc_back.php";
                }
            }
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="picklist_tab.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
if (strpos($arrHttp["picklist"],"%path_database%")===false){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"];
}else{
	$archivo=str_replace("%path_database%",$db_path,$arrHttp["picklist"]);
}
$fp=false;
$fp=fopen($archivo,"w");
if (!$fp){
//	echo $archivo.": ".$msgstr["nopudoseractualizado"];
//	die;
}
fwrite($fp,$arrHttp["ValorCapturado"]);
fclose($fp);
$Opciones="";
$VC=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($VC as $value){
	$value=trim($value);
	if ($Opciones=="")
		$Opciones=$value;
	else
		$Opciones.='$$$$'.$value;
}
echo "<h3>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"]." ".$msgstr["updated"]."</h3>";
if (!isset($arrHttp["desde"]) or $arrHttp["desde"]!="dataentry"){
?>

<script>
	row=<?php if (isset($arrHttp["row"])) echo $arrHttp["row"]."\n"?>
	name="<?php echo $arrHttp["picklist"]?>"
	window.opener.valor=name
	window.opener.Asignar()
	self.close()
</script>

<?php
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
echo "</div></div>";
include("../common/footer.php");?>