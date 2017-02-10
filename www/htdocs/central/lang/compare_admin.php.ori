<?php
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) and !isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");

$lang=$_SESSION["lang"];
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
include("../common/header.php");
$table=$_GET["table"];
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["compare_trans"].": ".$table."</h5>"?>
			</div>

			<div class="actions">
 				<a href="../dbadmin/menu_traducir.php?encabezado=s" class="defaultButton backButton">
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>

			</div>
			<div class="spacer">&#160;</div>
</div>
<?php
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";
echo "<font size=1> &nbsp; &nbsp; Script: compare_admin.php</font><br>";
//error_reporting (0);


echo "<strong>$table</strong>";
if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/00/$table";
else
	$a=$db_path."lang/00/$table";
$file=file($a);
foreach ($file as $value){
	if (trim($value)!=""){		$x=explode('=',$value);
		$msgstr_x[$x[0]]["00"]=trim($x[1]);
		$cod_msg[$x[0]][]=$msgstr_x[$x[0]]["00"];
	}}
//var_dump($cod_msg)  ;  die;
if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/en/$table";
else
	$a=$db_path."lang/en/$table";
if (file_exists($a)){
	$file=file($a);
	foreach ($file as $value){
		if (trim($value)!=""){
			$x=explode('=',$value);
			$msgstr_x[$x[0]]["en"]=trim($x[1]);
		}
	}
}

if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/es/$table";
else
	$a=$db_path."lang/es/$table";
if (file_exists($a)){
	$file=file($a);
	foreach ($file as $value){
		if (trim($value)!=""){
			$x=explode('=',$value);
			$msgstr_x[$x[0]]["es"]=trim($x[1]);
		}
	}
}
if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/fr/$table";
else
	$a=$db_path."lang/fr/$table";
if (file_exists($a)){
	$file=file($a);
	foreach ($file as $value){		if (trim($value)!=""){
			$x=explode('=',$value);
			$msgstr_x[$x[0]]["fr"]=trim($x[1]);
		}
	}
}
if (isset($msg_path) and $msg_path!="")
   	$a=$msg_path."lang/pt/$table";
else
	$a=$db_path."lang/pt/$table";
if (file_exists($a)){
	$file=file($a);
	foreach ($file as $value){		if (trim($value)!=""){
			$x=explode('=',$value);
			$msgstr_x[$x[0]]["pt"]=trim($x[1]);
		}
	}
}

$languaje=array();
$language["00"]="00";
$language["en"]="Inglés";
$language["es"]="Español";
$language["fr"]="Francés";
$language["pt"]="Portugués";
//var_dump($language) ;die;
echo "<table bgcolor=#eeeeee>";
echo "<th>Código</th><th>00</th><th>Inglés</th><th>Español</th><th>Francés</th><th>Portugués</th>";
foreach ($cod_msg as $key=>$cod){
	echo "<tr><td bgcolor=white valign=top><font face=arial size=2>$key</td>";
	reset($language);
	foreach ($language as $key_lang=>$val_lang){
		echo "<td bgcolor=white valign=top><font face=arial size=2>";
		if (isset($msgstr_x[$key][$key_lang]))
			echo $msgstr_x[$key][$key_lang];
		else
			echo "&nbsp;";
		echo "</td>";
	}}
echo "<tr><th>Código</th><th>00</th><th>Inglés</th><th>Español</th><th>Francés</th><th>Portugués</th>";
echo "</table>";
?>
