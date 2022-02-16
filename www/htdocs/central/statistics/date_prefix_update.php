<?php
/*
20220216 fho4abcd delete file if prefix is empty
*/
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include("../config.php");
// ARCHIVOD DE MENSAJES
include("../lang/admin.php");
include("../lang/statistics.php");

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");
?>
<body>
<?php
// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["stats_conf"]." - ".$msgstr["date_pref"].": ".$arrHttp["base"];?>
    </div>
	<div class="actions">
        <?php
        if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics")
            $backtoscript="tables_generate.php";
        else
            $backtoscript="../dbadmin/menu_modificardb.php";//old status where variables were defined in that script
        include "../common/inc_back.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
$file="date_prefix.cfg";
$filename=$db_path.$arrHttp["base"]."/def/".$lang."/".$file;
if ($_REQUEST["date_prefix"]!=""){	$fp=fopen($filename,"w");
	fwrite($fp,trim($_REQUEST["date_prefix"]));
	fclose($fp);
	echo $msgstr["date_pref"]." (".$file.") ".$msgstr["updated"]." &rarr;". $_REQUEST["date_prefix"]."&larr;<p>";} else {
    if (file_exists($filename)) {
        unlink($filename);
        echo $msgstr["date_pref"]." (".$file.") ".$msgstr["eliminados"]."<p>";
    }
}
echo "<h4>".$msgstr["conf_prefixdate_ok"]."</h4>";
?>
	</div>
</div>
<?php
include("../common/footer.php");
?>
