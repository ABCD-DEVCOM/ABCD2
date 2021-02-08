<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
?>
<html>
<title>PickList</title>
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
		window.opener.top.frames[2].Asignar()
	}else{		window.opener.valor=name
		window.opener.prefix=prefix
		window.opener.list=list
		window.opener.extract=extract
		window.opener.Asignar()	}
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
	document.cambiarbase.submit()
}
</script>
<font size=1 face=arial>
<form name=pl>
<?php echo $msgstr["selcapture"]?>
<p>

<table border=0>
<tr>
<td><font size=1 face=arial>
<?php echo $msgstr["database"]?></td>
<td><font size=1 face=arial><Select name=base onchange=javascript:CambiarBase()><option value=>--
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
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/picklist_db.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/picklist_db.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: picklist_db.php";
?>
</td>
<tr><td align=right><font size=1 face=arial><?php echo $msgstr["prefix"]?>: </td><td><input type=text name=prefix size=10 value="<?php if (isset($arrHttp["prefix"])) echo $arrHttp["prefix"]?>"></td>
<tr><td align=right><font size=1 face=arial><?php echo $msgstr["listas"]?>: </td><td><input type=text name=list size=80 value="<?php if (isset($arrHttp["list"])) echo stripslashes($arrHttp["list"])?>"></td>
<tr><td><font size=1 face=arial><?php echo $msgstr["extractas"]?>: </td><td><input type=text name=extract size=80 value="<?php if (isset($arrHttp["extract"])) echo stripslashes($arrHttp["extract"])?>"></td>
</table>

<center><a href=javascript:PickList_update()><?php echo $msgstr["updfdt"]?></a></center>
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
</body></html>