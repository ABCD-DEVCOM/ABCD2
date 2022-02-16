<?php
/*
202202216 fho4abcd backbutton,div-helper
*/
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include ("../config.php");
// ARCHIVOD DE MENSAJES
include("../lang/dbadmin.php");
include("../lang/statistics.php");

//foreach ($arrHttp as $var=>$value)   echo "$var=$value<br>";

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

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
        <?php echo $msgstr["stats_conf"]." - ".$msgstr["pre_tabs"].": ".$arrHttp["base"];?>
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
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tables.cfg";
$fp=fopen($file,"w");
if (!isset($arrHttp["ValorCapturado"])) $arrHttp["ValorCapturado"]="";
$vc=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($vc as $value){
	$r=fwrite($fp,$value."\n");
    echo $value."<br>";
}
$r=fclose($fp);
echo "<h4>". $arrHttp["base"]."/".$_SESSION["lang"]."/def/tables.cfg"." ".$msgstr["updated"]."</h4>" ;
?>
	</div>
</div>
<?php
include("../common/footer.php");
?>
