<?php
/*
20220203 fho4abcd back button, div-helper
20220628 fho4abcd Remove import/export with excel
*/
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
$base=$arrHttp["base"];


$archivo=$db_path.$base."/def/".$lang."/help.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('=',$value,2);
			$tooltip[$v[0]]=$v[1];
		}

	}
}
$archivo=$db_path.$base."/def/".$lang."/".$base.".fdt";
if (file_exists($archivo)){
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('|',$value);
			if ($v[0]!="S"){
				switch ($v[0]){
					case "H":
					case "L":
						if (isset($v[18])){
							if (trim($v[17])!="")
								$fdt[$v[17]]=$v[2];
						}
						break;
					default:
						$fdt[$v[1]]=$v[2];
						break;
				}
			}
		}

	}
}


include("../common/header.php");
?>
<body>
<script language=javascript>
function Guardar(){
	document.update.submit();
}
function AbrirVentana(Html){
	msgwin=window.open("../documentacion/ayuda.php?help=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}
function Edit(Html){
	msgwin=window.open("../documentacion/edit.php?archivo=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}

function VerificarUpload(){
	if(document.getElementById("archivo").value == "") {
		alert("Debe suministrar el archivo a convertir")
		return false
	}
	document.upload.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["database_tooltips"].": ".$base?>
    </div>
    <div class="actions">
        <?php 
        if (!isset($arrHttp["Opcion"]) or isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]!="Importar"){
            $savescript="javascript:Guardar()";
            include "../common/inc_save.php";
        }
        $backtoscript="menu_modificardb.php";
        include "../common/inc_back.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">

<?php
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="Importar"){
	if (!isset($_FILES["archivo"])){
	ECHO "<h2>".$msgstr["import_ods"]."</H2>";
    ?>
    <form action="" method="post" enctype="multipart/form-data" name=upload_form onsubmit="javascript:VerificarUpload();return false">
     <br> <label for="archivo"><?php echo $msgstr["selfile"]?>:</label>
      <input type="file" name="archivo" id="archivo" />
      <br><br>
     <?php

      echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
      ?>
      <input type="submit" value="<?php echo $msgstr["send"]?>"/>
      <input type="hidden" name=Opcion value=importado>
      </form>
    <?php
        die;
    }
}
?>
<a href=database_tooltips.php?Opcion=Importar&base=<?php echo $base?>><?php echo $msgstr["import_ods"]?></a><br>

<form name="update" action="database_tooltips_ex.php" method="post">
	<input type=hidden name=base value=<?php echo $base?>>
    <?php
    foreach ($fdt as $key=>$value){
        ?>
        <div class="tooltip-data" ><span><b><?php echo $key." | ".$value?></b></span>
        <textarea rows=1 class=tooltip name=tag<?php echo $key?>><?php if (isset($tooltip[$key])) echo $tooltip[$key];?></textarea>
        <?php if (isset($tooltip[$key])) echo $tooltip[$key]?>
        </div>
    <?php } ?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
