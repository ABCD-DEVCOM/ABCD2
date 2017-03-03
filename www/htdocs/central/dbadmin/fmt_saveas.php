<?
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../common/header.php");
?>
<script>
function Enviar(){
	document.wks.submit()}
function Regresar(){	document.wks.Opcion.value="saveas";
	document.wks.submit()}
</script>
<?php

echo "<body>\n";
include("../common/institutional_info.php");

?>
<div class="sectionInfo">
	<div class="breadcrumb">

	</div>

	<div class="actions">
<?php
    $encabezado="&encabezado=S";
	echo "<a href=\"fmt.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "<font color=white>&nbsp; &nbsp; Script: fmt_update.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><h2>
<form name=wks method=post action=fmt_saveas.php onsubmit="javascript:Enviar();return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Opcion value="save">
<input type=hidden name=fmt_name value=<?php echo $arrHttp["fmt_name"]?>>
<input type=hidden name=fmt_desc value="<?php echo $arrHttp["fmt_desc"]?>">
<?php
if (isset($arrHttp["name"])){	echo "<input type=hidden name=name value='". $arrHttp["name"]."'>\n";}
if (isset($arrHttp["desc"])){
	echo "<input type=hidden name=desc value='". $arrHttp["desc"]."'>\n";
}
switch ($arrHttp["Opcion"]){	case "saveas":
		echo "<p>".$msgstr["name"].": <input type=text name=name size=8 maxlength=12 value='";
		if (isset($arrHttp["name"])) echo $arrHttp["name"];
		echo "'> ".$msgstr["description"].": <input type=text size=50 maxlength=50 name=desc value='";
		if (isset($arrHttp["desc"])) echo $arrHttp["desc"];
		echo "'> &nbsp;
		<input type=submit value='".$msgstr["save"]."'>";
		break;
	case "save":
		GuardarWks();
		die;}
?>
</form>
</center>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>

<?php

function  GuardarWks(){
global $arrHttp,$msgstr,$db_path;
	$err="N";	if (!isset($arrHttp["name"]) or trim($arrHttp["name"])==""){		echo $msgstr["missing"].": ".$msgstr["name"];
		$err="S";	}
	if (!isset($arrHttp["desc"]) or trim($arrHttp["desc"])==""){
		echo "<br>".$msgstr["missing"].": ".$msgstr["description"];
		$err="S";
	}
	if(!preg_match('/^[a-z0-9-_]+$/',$arrHttp["name"])) {
		echo "<br>".$msgstr["invalidfilename"];
   		$err="S";
	}
	if ($err=="N"){
		if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["name"].".fmt")){			echo $msgstr["fileexists"];
			$err="S";		}
	}
	if ($err=="S"){		echo "<p><a href=javascript:Regresar()>".$msgstr["back"]."</a>";
		return;	}

	copy($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["fmt_name"].".fmt",$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["name"].".fmt");
	$filename=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks";
	$new_wks="\n".$arrHttp["name"]."|".$arrHttp["desc"];
	$res=file_put_contents ($filename , $new_wks ,FILE_APPEND);
	echo "<p>".$arrHttp["name"]."  ".$msgstr["saved"];

}
?>


