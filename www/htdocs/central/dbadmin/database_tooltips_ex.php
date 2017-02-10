<?php
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
?>
<script languaje=javascript>
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
echo " <body>
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">"."<h5>".
				$msgstr["tradyudas"]."</h5>
			</div>
			<div class=\"actions\">

	";

echo "<a href=\"menu_modificardb.php?encabezado=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

 ?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/trad_ayudas.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/trad_ayudas.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/database_tooltips.php";
?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">


<body>
<form name=update action=database_tooltips_ex.php method=post>
<?php
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/help.tab";
$fp=fopen($archivo,"w");
foreach ($arrHttp as $key=>$value){	$value=trim($value);
	if ($value!=""){
		if (substr($key,0,3)=="tag"){
			$key=substr($key,3);			$value=str_replace("\n","",$value);
			$value=str_replace("\r","",$value);
			fwrite($fp,$key."=".$value."\n");		}	}}
fclose($fp);
echo "<h2>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/help.tab: ".$msgstr["updated"]."</h2>";
echo "</div></div>";
include("../common/footer.php");
?>
