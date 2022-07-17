<?php
/*
20220717 fho4abcd Use $actparfolder as location for .par & def files
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/iah_conf.php");
include("../lang/dbadmin.php");

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");

unset($fp);

?>
</head>
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
<?php echo $msgstr["iah-conf"].": ".$arrHttp["base"].".def"?>
	</div>
	<div class="actions">
<?php
if (isset($arrHttp["encabezado"]))
	$backtoscript= "menu_modificardb.php?base=".$arrHttp["base"].$encabezado;
	include "../common/inc_back.php";
?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php

$ayuda="iah_edit_db.html";
include "../common/inc_div-helper.php";

?>
<div class="middle form">
	<div class="formContent">


	<?php
	$arrHttp["ValorCapturado"]= stripslashes($arrHttp["ValorCapturado"]);
	echo "<pre>".$arrHttp["ValorCapturado"]."</pre>";
	$file=$db_path.$actparfolder.strtoupper($arrHttp["base"]).".def";
	$fp=fopen($file,"w");
	if (!$fp){
		echo "Cannot open the file $file for writing";
		die;
	}
	$res=fwrite($fp,$arrHttp["ValorCapturado"]);

	fclose($fp);
	echo "<h2>".$msgstr["saved"];
	?>
	</div>

</div>
<?php include("../common/footer.php");?>