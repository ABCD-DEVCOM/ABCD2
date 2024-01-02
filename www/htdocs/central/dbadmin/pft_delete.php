<?php
/*
20220129 fho4abcd div-helper+backbutton+improve logic+translation
20231228 fho4abcd Delete also possible _h.txt file. Cleanup code
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["pft"]." - ". $msgstr["delete"].": ".$arrHttp["pft"]." (".$arrHttp["base"].")"?>
	</div>
	<div class="actions">
    <?php
        $backtoscript="pft.php";
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
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["pft"]) && $arrHttp["pft"]!=""){
	$pft_name=$arrHttp["pft"];
	$pft_namef=$pft_name.".pft";
	$pft_nameh=$pft_name."_h.txt";
	$pft_namel="formatos.dat";
	$pft_basenamef=$base."/pfts/".$_SESSION["lang"]."/".$pft_namef;
	$pft_basenameh=$base."/pfts/".$_SESSION["lang"]."/".$pft_nameh;
	$pft_basenamel=$base."/pfts/".$_SESSION["lang"]."/".$pft_namel;
 	$pft_fullnamef=$db_path.$pft_basenamef;
	$pft_fullnameh=$db_path.$pft_basenameh;
	$pft_fullnamel=$db_path.$pft_basenamel;
	$res=true;
    if (file_exists($pft_fullnamef)) {
        $res=unlink($pft_fullnamef);
    }
	if ($res==false){
		echo "<h2 style='color:red'>".$msgstr["archivo"]." ".$pft_basenamef.": ".$msgstr["nodeleted"]."</h2>";
	}else{
		echo "<h2>".$msgstr["archivo"]." ".$pft_basenamef.": ".$msgstr["eliminados"]."</h2>";
	}
	// Delete the _h.txt file
	$res=true;
    if (file_exists($pft_fullnameh)) {
        $res=unlink($pft_fullnameh);
    }
	if ($res==false){
		echo "<h2 style='color:red'>".$msgstr["archivo"]." ".$pft_basenameh.": ".$msgstr["nodeleted"]."</h2>";
	}else{
		echo "<h2>".$msgstr["archivo"]." ".$pft_basenameh.": ".$msgstr["eliminados"]."</h2>";
	}
	// update formatos.dat
	$salida="";
	$fp=file($pft_fullnamel);
	foreach ($fp as $value){
		$value=trim($value);
		$v=explode('|',$value);
		if ($v[0]!=$pft_name) $salida.=$value."\n";
	}
	$fp=fopen($pft_fullnamel,"w");
	fwrite($fp,$salida);
	fclose($fp);
	echo "<h3>".$msgstr["archivo"]." ".$pft_basenamel.": ".$msgstr["updated"]."</h3>";
}
echo "</div></div>";
include "../common/footer.php";
?>