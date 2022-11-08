<?php
/*
20220108 fho4abcd backButton+ div helper+improve html
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");

include("../lang/soporte.php");
include("../common/header.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$backtoscript="../dbadmin/z3950_conf.php";

include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["z3950"].". ".$msgstr["z3950_diacritics"] ?>
	</div>
	<div class="actions">
    <?php
    include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"?>
<div class="middle form">
<div class="formContent">
<?php
$m2afile="cnv/marc-8_to_ansi.tab";
$fp=fopen($db_path.$m2afile,"w");
$accents=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($accents as $val){
	$val=trim($val);
	if($val!=""){
		$a=explode('|',$val);
		fwrite($fp,$a[0]." ".$a[1]."\n");
	}
}
fclose($fp);
echo "<h4>".$m2afile." : ".$msgstr["updated"]."</h4>";
?>
</div>
</div>
<?php include("../common/footer.php")?>


