<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../common/get_post.php");
include ("../config.php");


include ("../lang/dbadmin.php");
include ("../lang/admin.php");
$lang=$_SESSION["lang"];


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
//THIS VARIABLE IS FOR TESTING THE VALIDATION PFT
var pos_val=0


function Enviar(){	ValorCapturado=document.recval.format.value
	document.recval.ValorCapturado.value=ValorCapturado
	document.recval.target=""
	document.recval.action="recval_save.php"
	document.recval.submit()

}


function Test(Tag){
	Formato=document.recval.format.value
	if (Trim(document.recval.Mfn.value)==""){
		alert("<?php echo $msgstr["mismfn"]?>")
		return
	}
	msgwin=window.open("","RecvalTest","width=740, height=400, status,scrollbars")
	msgwin.document.close()
	document.test.Mfn.value=document.recval.Mfn.value
	document.test.target="RecvalTest"
	document.test.ValorCapturado.value=Formato
	document.test.action="recdel_test.php"
	document.test.submit()
	msgwin.focus()

}


</script>
</head>
<body>
<?php
if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
}else{	$encabezado="";}
if (isset($arrHttp["wks"])){
	$arrHttp["wks"]=urldecode($arrHttp["wks"]);
	$w=explode('|',$arrHttp["wks"]);
}else{	$w[0]=$arrHttp["base"].".fdt";
	$w[3]="";}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".
	$msgstr[$arrHttp['format']].": ".$arrHttp["base"]." (".$w[0]." ".$w[3].")
	</div>
	<div class=\"actions\">\n";
echo "<a href=\"menu_modificardb.php?Opcion=update&type=&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["cancel"]."</strong></span>
	</a>
	</div>
	<div class=\"spacer\">&#160;</div>
	</div>";

?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/recval.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/recval.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: recdel_val.php";
?>
</font>
</div>
 <div class="middle form">
	<div class="formContent">


<form name=recval  method=post onsubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
if (isset($arrHttp["encabezado"]))
   echo "<input type=hidden name=encabezado value=s>";
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/recdel_val.pft";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/recdel_val.pft";
if (file_exists($archivo)){
	$fp=file($archivo);
	foreach ($fp as $value){
		if (trim($value)!=""){
			$pft[]=$value;		}
	}
}else{	$pft[]="";}
echo "<center>";
echo "<div id=rows>\n";
echo "<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1>";
echo "<tr><td nowrap>".$msgstr[$arrHttp["format"]]."</td></tr>";
$ix=-1;
echo "<tr><td bgcolor=white><textarea cols=80 rows=5 name=format>";
if (isset($pft)){
	foreach ($pft as $value){		echo $value;
		echo "\n";
	}

}
echo "</textarea></td></tr>";

echo "</table></div>";


echo "<tr><td bgcolor=white>";
echo $msgstr["testmfn"];
echo "&nbsp; <input type=text size=5 name=Mfn> <a href=javascript:Test()>".$msgstr["test"]."</a>  &nbsp; &nbsp;";
echo "</td><td colspan=3  bgcolor=white><img src=../dataentry/img/toolbarSave.png> &nbsp;";

echo "<a href=javascript:Enviar()>".$msgstr["save"]."&nbsp;</a> (recdel_val.pft)  &nbsp; &nbsp ";
echo "<input type=hidden name=fn value=recdel_val.pft>";



echo "</td></table>";
echo "<input type=hidden name=ValorCapturado>";
echo "</form>"
?>
<form name=test  method=post action=recval_test.php target=RecvalTest>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Mfn>
<input type=hidden name=ValorCapturado>
</form>
</div></div>
<?php include("../common/footer.php");?>
</body></html>
