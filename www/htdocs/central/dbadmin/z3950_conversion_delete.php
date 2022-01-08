<?php
/*
20220108 fho4abcd backButton+ div helper+improve html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$lang=$_SESSION["lang"];
$backtoscript="../dbadmin/z3950_conf.php";

include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["z3950"].": ".$msgstr["z3950_tab"]." (".$arrHttp["base"].")" ?>
	</div>

	<div class="actions">
    <?php
    $savescript="javascript:Enviar()";
	include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="z3950_conf.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<div style="text-align:center">
<?php
$tabfile=$arrHttp["base"]."/def/".$arrHttp["Table"];
$file=$db_path.$tabfile;

if (file_exists($file)){
	$res=unlink($file);
	if (!$res){
		echo $tabfile.": ".$msgstr["nodeleted"]."<br><br>";
	}
    else {
		echo $tabfile.": ".$msgstr["eliminados"]."<br><br>";
    }
}
$cnvfile=$arrHttp["base"]."/def/z3950.cnv";
$fp=file($db_path.$cnvfile);
foreach ($fp as $value) $sal[]=$value;

$out=fopen($db_path.$cnvfile,"w");
foreach ($sal as $value){
	$t=explode('|',$value);
	if (trim($t[0])!=trim($arrHttp["Table"]))
		$res=fwrite($out,$value);
}
fclose($out);
?>
<h4><?php echo $cnvfile.": ".$msgstr["updated"]?></h4>
</div></div></div>
<?php
include("../common/footer.php");
?>