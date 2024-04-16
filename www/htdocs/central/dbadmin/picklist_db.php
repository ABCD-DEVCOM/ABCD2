<?php
/* Modifications
2024-04-16 fho4abcd New look+make it working
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

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
include("../common/header.php");
?>
<body>
<script>
function PickList_update(){
	prefix=document.pl.prefix.value
	list=document.pl.list.value
	extract=document.pl.extract.value	row="<?php echo $arrHttp["row"]?>"
	ix=self.document.pl.base.selectedIndex
	name=self.document.pl.base.options[ix].value
	if (name==""){		alert("<?php echo $msgstr["seldb"]?>")
		return	}
	nf=window.opener.frames.length
	if (nf>0){
		window.opener.top.frames[2].valor=name
		window.opener.top.frames[2].prefix=prefix
		window.opener.top.frames[2].list=list
		window.opener.top.frames[2].extract=extract
		window.opener.top.frames[2].AsignarDbPicklistValues()
	}else{		window.opener.valor=name
		window.opener.prefix=prefix
		window.opener.list=list
		window.opener.extract=extract
		window.opener.AsignarDbPicklistValues()	}
	self.close()
}

function CambiarBase(){	ix=document.pl.base.selectedIndex
	name=self.document.pl.base.options[ix].value
	if (name==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	document.cambiarbase.dbsel.value=name
	document.cambiarbase.base.value=name
	document.cambiarbase.submit()}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["picklist_db"]?>
	</div>
	<div class="actions">
		<?php include "../common/inc_close.php"?>
		&nbsp;
		<a class="bt bt-green" href=javascript:PickList_update()><?php echo $msgstr["updfdt"]?></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
	<div class="formContent">
		<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['selcapture']?></span>
<form name=pl>

<table border=0>
<tr>
<td><?php echo $msgstr["database"]?></td>
<td><Select name=base onchange=javascript:CambiarBase()><option value="">
<?php
$fp=file($db_path."bases.dat");
foreach ($fp as $base){
	$base=trim($base);
	if ($base!="") {
		$d=explode('|',$base);
		$dbname=$d[0];
		if (isset($arrHttp["dbsel"])) if ($dbname==$arrHttp["dbsel"]) $dbname.=" selected";
		echo "<option value=".$dbname.">".$d[1]."\n";
	}
}
?>
</Select>
</td>
<tr><td align=right><?php echo $msgstr["prefix"]?>: </td>
	<td><input type=text name=prefix size=10 value="<?php if (isset($arrHttp["prefix"])) echo $arrHttp["prefix"]?>"></td>
<tr><td align=right><?php echo $msgstr["listas"]?>: </td>
	<td><input type=text name=list size=80 value="<?php if (isset($arrHttp["list"])) echo stripslashes($arrHttp["list"])?>"></td>
<tr><td><?php echo $msgstr["extractas"]?>: </td>
	<td><input type=text name=extract size=80 value="<?php if (isset($arrHttp["extract"])) echo stripslashes($arrHttp["extract"])?>"></td>
</table>
</form>
<div id="dwindow" style="position:relative;background-color:#ffffff;cursor:hand;left:0px;top:0px;height:250" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
<div id="dwindowcontent" style="height:100%;">
<iframe id="cframe" src="fst_leer.php?base=<?php echo $arrHttp["base"]?>" width=100% height=100% scrolling=yes name=fst></iframe>
</div>
</div>
<form name=cambiarbase action=picklist_db.php>
<input type=hidden name=dbsel>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=row value=<?php echo $arrHttp["row"]?>>
</form>
</div></div>
<?php include ("../common/footer.php");?>
