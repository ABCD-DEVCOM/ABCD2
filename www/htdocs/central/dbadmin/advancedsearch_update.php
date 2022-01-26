<?php
/*
20220126 fho4abcd div-helper,backbutton, clean html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");;

$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["archivo"];
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>"; die;

$fp=fopen($archivo,"w");
fputs($fp,$arrHttp["txt"]);
fclose($fp);
include("../common/header.php");
echo "<body>" ;
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["advsearch"]." &rarr; " .$msgstr["database"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
        <?php
        $backtoscript="menu_modificardb.php";
        include "../common/inc_back.php";
        include "../common/inc_home.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php }?>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
    <div class="formContent">
    <br><br>
    <h4><?php echo $arrHttp["base"]. "/pfts/".$_SESSION["lang"]."/".$arrHttp["archivo"]." ".$msgstr["updated"]?></h4>
</div></div>
<?php include("../common/footer.php");?>

