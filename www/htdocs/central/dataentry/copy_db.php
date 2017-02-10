<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

$db=$arrHttp["base"];
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or  isset($_SESSION["permiso"]["CENTRAL_ALL"])
    or isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
}else{
	echo $msgstr["invalidright"];
	die;

}

include("../common/header.php");
?>
<script language="javascript1.2" src="js/lr_trim.js"></script>
<script>
function Explorar(){
	msgwin=window.open("dirs_explorer.php?desde=dbcp&Opcion=explorar&base=<?php echo $arrHttp["base"]?>&tag=document.forma1.dbfolder","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
    msgwin.focus()
}
function EnviarForma(){
	if (Trim(document.upload.storein.value)==""){		alert("Debe especificar la carpeta")
		return	}
	if (Trim(document.upload.copyname.value)==""){		alert("Debe especificar el nombre de la base de datos")
		return	}
   	document.upload.submit()
}
</script>
</head>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["db_cp"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/copy_db.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo " &nbsp; &nbsp; <a href='http://isisabcd.pbworks.com/w/page/Copiar-base-de-datos' target=_blank>".$msgstr["online_help"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: copy_db.php</font>";

	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<p>
<?php echo $msgstr["db_cp"].": ".$arrHttp["base"]?>
<form name=upload method=post action=copy_db_ex.php onsubmit="EnviarForma();return false;">
<table><tr><td>
<?php echo $msgstr["cp_folder"];?></td><td>
<input type=text name=storein size=30 onclick=javascript:blur()> <a href=javascript:Explorar()><?php echo $msgstr["explore"]?></a><br>
<tr><td><?php echo $msgstr["cp_name"];?></td><td><input type=text name=copyname></td>
</table>
<input type=checkbox name=reorganize> <?php echo $msgstr["cp_reorganize"];?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<p><input type=submit value=<?php echo $msgstr["procesar"]?>>
</form>
</div>
</div>
</center>
<?php
include("../common/footer.php");
?>

</body>
</html>