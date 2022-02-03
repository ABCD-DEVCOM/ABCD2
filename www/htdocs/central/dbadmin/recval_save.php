<?php
/*
20220202 fho4abcd back-button+div-helper+ move code that may send errors into formContent
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
$lang=$_SESSION["lang"];

include("../common/header.php");
echo "<body>";
if (isset($arrHttp["encabezado"])){
    	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["recval"].": ".$arrHttp["base"]?>
    </div>
	<div class="actions">
        <?php
            switch ($arrHttp["fn"]){
                case "recdel_val.pft":
                    $backtoscript="menu_modificardb.php";
                    break;
                default:
                    $backtoscript="typeofrecs.php";
                    break;
            }
            include "../common/inc_back.php";
            include "../common/inc_home.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";  //die;
if (isset($arrHttp["ValorCapturado"]))  {
	$pft=explode("\n",$arrHttp["ValorCapturado"]);
}else{
	$pft=array();
}

$fp=fopen($db_path.$arrHttp["base"]."/def/".$lang."/".$arrHttp["fn"],"w");
if (!$fp){
	echo $arrHttp["base"]."/def/".$lang."/".$arrHttp["fn"].": ";
	echo $msgstr["nopudoseractualizado"];
	die;
}
foreach ($pft as $value){

	switch ($arrHttp["fn"]){
		case "recdel_val.pft":
			fwrite($fp,urldecode($value)."\n");
			break;
		default:
			$tag=substr($value,0,4);
			$value=trim(substr($value,4));
			fwrite($fp,ltrim($tag, "0").":".urldecode($value)."\n###\n");
			break;
	}

}
fclose($fp);
echo "<center><h4>".$arrHttp["base"]."/def/".$lang."/".$arrHttp["fn"].": ".$msgstr["updated"];
echo "</h4></center></div></div>";
include("../common/footer.php");
?>