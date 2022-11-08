<?php
/*
20220202 fho4abcd buttons+div-helper
*/
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
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
//THIS VARIABLE IS FOR TESTING THE VALIDATION PFT
var pos_val=0


function Enviar(){
	ValorCapturado=document.recval.format.value
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
<?php
if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
}else{
	$encabezado="";
}
if (isset($arrHttp["wks"])){
	$arrHttp["wks"]=urldecode($arrHttp["wks"]);
	$w=explode('|',$arrHttp["wks"]);
}else{
	$w[0]=$arrHttp["base"].".fdt";
	$w[3]="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr[$arrHttp['format']].": ".$arrHttp["base"]." (".$w[0]." ".$w[3].")";?>
	</div>
	<div class="actions">
        <?php
            $backtocancelscript="menu_modificardb.php?Opcion=update";
            include "../common/inc_cancel.php";
            include "../common/inc_home.php";
        ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="recval.html";
include "../common/inc_div-helper.php";
?>
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
			$pft[]=$value;
		}
	}
}else{
	$pft[]="";
}
?>

<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1 style='margin-left:auto;margin-right:auto;'>
<tr><td nowrap><?php echo $msgstr[$arrHttp["format"]];?></td></tr>
<tr><td bgcolor=white>
    <textarea cols=80 rows=5 name=format><?php
        if (isset($pft)){
            foreach ($pft as $value){
                echo $value;
                echo "\n";
            }
        }
        ?>
    </textarea>
</td></tr>
</table>
<table style='margin-left:auto;margin-right:auto;'>
<tr><td>
<?php echo $msgstr["testmfn"];?> &nbsp;
<input type=text size=5 name=Mfn>
<a class='bt bt-gray' href=javascript:Test()> <i class='fas fa-vial'></i> <?php echo $msgstr["test"]?></a>
</td>
<td> &nbsp; &nbsp; &nbsp; &nbsp; </td>
<td>
<a class='bt bt-green' href=javascript:Enviar()><i class='far fa-save'></i> <?php echo $msgstr["save"]?></a>  (recdel_val.pft)
</td>
</tr>
</table>
<input type=hidden name=fn value=recdel_val.pft>
<input type=hidden name=ValorCapturado>
</form>

<form name=test  method=post action=recval_test.php target=RecvalTest>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Mfn>
<input type=hidden name=ValorCapturado>
</form>
</div></div>
<?php include("../common/footer.php");?>

