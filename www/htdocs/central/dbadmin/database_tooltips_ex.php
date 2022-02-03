<?php
/*
20220203 fho4abcd back button+div-helper*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");
include("../common/header.php");
$base=$arrHttp["base"];

?>
<body>
<script language=javascript>
function AbrirVentana(Html){
	msgwin=window.open("../documentacion/ayuda.php?help=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}
function Edit(Html){
	msgwin=window.open("../documentacion/edit.php?archivo=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["database_tooltips"].": ".$base?>
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
<?php
$ayuda="trad_ayudas.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form name=update action=database_tooltips_ex.php method=post>
<?php
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/help.tab";
$fp=fopen($archivo,"w");
foreach ($arrHttp as $key=>$value){
	$value=trim($value);
	if ($value!=""){
		if (substr($key,0,3)=="tag"){
			$key=substr($key,3);
			$value=str_replace("\n","",$value);
			$value=str_replace("\r","",$value);
			fwrite($fp,$key."=".$value."\n");
		}
	}
}
fclose($fp);
echo "<h2>".$base."/def/".$_SESSION["lang"]."/help.tab: ".$msgstr["updated"]."</h2>";
echo "</div></div>";
include("../common/footer.php");
?>
