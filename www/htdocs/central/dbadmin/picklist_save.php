<?php
/*
20220202 fho4abcd back button, div-helper
20240422 fho4abcd return title
20250824 fho4abcd Add messages for footer+ add close button+ correct action on empty table
20250824 fho4abcd Always feedback + Close window after delay
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
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
$tag="";
if (isset($arrHttp["tag"]))$tag=$arrHttp["tag"];
$subfield="";
if (isset($arrHttp["subfield"]))$subfield=$arrHttp["subfield"];
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
					$backtoscript="picklist.php?base=". $arrHttp["base"];
					$backtoscript=$backtoscript."&row=".$arrHttp["row"];
					$backtoscript=$backtoscript."&picklist=".$arrHttp["picklist"];
					$backtoscript=$backtoscript."&title=".$arrHttp["title"];
					$backtoscript=$backtoscript."&tag=".$tag;
					$backtoscript=$backtoscript."&subfield=".$subfield;
					include "../common/inc_back.php";
				}
			}
			include "../common/inc_close.php";
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
if (!isset($arrHttp["ValorCapturado"]) || $arrHttp["ValorCapturado"]=="" ) {
	echo "<h3 style=color:red>".$msgstr["nopicklistvalues"]."</h3>";
} else {
	$fp=false;
	$fp=fopen($archivo,"w");
	if (!$fp){
		echo $archivo.": ".$msgstr["nopudoseractualizado"];
		die;
	}
	fwrite($fp,$arrHttp["ValorCapturado"]);
	fclose($fp);
	echo "<h3>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"]." ".$msgstr["updated"]."</h3>";
}
/*
Delete this pop-up window after 4 seconds. Just in case the close button is not hit
*/
?>
<script>setTimeout("window.close()",4000)</script>
<?php
echo "</div></div>";
include("../common/footer.php");?>