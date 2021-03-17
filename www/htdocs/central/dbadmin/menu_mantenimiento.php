<?php
/* Modifications
20210314 fho4abcd Replaced helper code fragment by included file
20210314 fho4abcd html move body and remove win.close + sanitize html
20210314 fho4abcd Replaced dbinfo code by included file
*/
session_start();

$Permiso=$_SESSION["permiso"];
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include ("../common/get_post.php");

if (!isset($arrHttp["base"])) $arrHttp["base"]="";

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=explode('|',$arrHttp["base"]);
		$arrHttp["base"]=$ix[0];
}
$db=$arrHttp["base"];
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"])
    ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}


//SEE IF THE DATABASE IS LINKED TO COPIES
$copies="N";
$fp=file($db_path."bases.dat");
foreach ($fp as $value){
	$value=trim($value);
	$x=explode("|",$value);
	if ($x[0]==$arrHttp["base"]){
		if (isset($x[2]) and $x[2]=="Y"){			$copies="Y";
		}
		break;
	}
}
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>
<body >
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>

<?php

	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";

	echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent" style="min-height:300px;">

<?php
// Display menu bar
include("menu_bar.php");

// Get info about the current database from the database
include ("../common/inc_get-dbinfo.php");
// Display info about current database
echo "<br><br><div align=center><b>".$msgstr["bd"].": ".$arrHttp["base"]."</b>";

if ( !isset($def_db["UNICODE"]) or $def_db["UNICODE"] == "ansi" || $def_db["UNICODE"] == '0' ) {
	$charset_db="ISO-8859-1";
}else{
	$charset_db="UTF-8";
}
echo "<br><strong>$charset_db</strong>" ;
echo "<br><font color=darkred><b>". $msgstr["maxmfn"].": ".$arrHttp["MAXMFN"]."</b></font>";

if (isset($arrHttp["BD"]) and $arrHttp["BD"]=="N")
	echo "<p>".$msgstr["database"]." ".$msgstr["ne"];

if (isset($arrHttp["IF"]) and $arrHttp["IF"]=="N")
	echo "<p>".$msgstr["if"]." ".$msgstr["ne"];

if (isset($arrHttp["EXCLUSIVEWRITELOCK"]) and $arrHttp["EXCLUSIVEWRITELOCK"]!=0) {
	echo "<p>".$msgstr["database"]." ".$msgstr["exwritelock"]."=".$arrHttp["EXCLUSIVEWRITELOCK"].". ".$msgstr["contactdbadm"]."
	<script>top.lock_db='Y'</script>
	";

}

if ($wxisUrl!=""){
	echo "<p>CISIS version: $wxisUrl</p>";
}else{
	$ix=strpos($Wxis,"cgi-bin");
	$wxs=substr($Wxis,$ix);
    echo "<p>CISIS version: ".$wxs."</p>";
}
?>
</div>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
