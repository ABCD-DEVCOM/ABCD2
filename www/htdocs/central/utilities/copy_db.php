<?php
/*
20211215 fho4abcd Backbutton & helper by included file
*/
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
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script

if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or  isset($_SESSION["permiso"]["CENTRAL_ALL"])
    or isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
}else{
	echo $msgstr["invalidright"];
	die;

}

include("../common/header.php");
include("../common/institutional_info.php");
?>
<script language="javascript" src="../dataentry/js/lr_trim.js"></script>
<script>

function Explorar(){
	msgwin=window.open("../dataentry/dirs_explorer.php?desde=dbcp&Opcion=explorar&base=<?php echo $arrHttp["base"]?>&tag=document.forma1.dbfolder","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
   	console.log("OK");

	msgwin.focus()
}
function EnviarForma(){
	if (Trim(document.upload.storein.value)==""){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["folder_name"]?>")
		return
	}
	if (Trim(document.upload.copyname.value)==""){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["cp_name"]?>")
		return
	}
	dbn=Trim(document.upload.copyname.value)
		
	var alphaExp = /^[a-zA-Z_0123456789-]+$/;
    if(dbn.match(alphaExp)){

    }else{
        alert("<?php echo $msgstr["invalidfilename"]?>");
        return
    }

    Limpiar()
   	document.upload.submit()
}

function Limpiar(){
	fld=Trim(document.upload.storein.value)
	if (fld.substr(0,1)=="/"){
		fld=fld.substring(1)
		document.upload.storein.value=fld
	}
}
</script>
</head>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["db_cp"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">

	<div class="formContent">

		<form name="upload" method="post" action="copy_db_ex.php" onsubmit="EnviarForma();return false;">

			<label><?php echo $msgstr["cp_folder"];?></label>
			<input type="text" name="storein" size="30" onclick="javascript:blur()"> 
			<a class="bt bt-blue" href="javascript:Explorar()"> <?php echo $msgstr["explore"];?></a>
			<br/>

			<label><?php echo $msgstr["cp_name"];?></label><input type="text" name="copyname">
			<br />
			<input type="checkbox" name="reorganize"> <label><?php echo $msgstr["cp_reorganize"];?></label>
			<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">

			<br />
			<input class="bt-green" type="submit" value="<?php echo $msgstr["procesar"]?>">

		</form>
	</div>
</div>

<?php include("../common/footer.php"); ?>