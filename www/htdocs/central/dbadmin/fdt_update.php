<?php
/*
20220128 fho4abcd improve back buttons + rewrite code to show more info+improve update of formatos.wks
20220202 fho4abcd improve back for fixed field
*/
session_start();
if (!isset($_SESSION["permiso"])){
    header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ('../config.php');
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
    $encabezado="&encabezado=s";
} else {
    $encabezado="";
}
if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
}
$isfdt=true;
if (isset($arrHttp["fmt_name"])) $isfdt=false;
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php
            if ($isfdt ) echo $msgstr["updfdt"];
            if (!$isfdt) echo $msgstr["fmtupdate"];
            echo "&rarr; ".$msgstr["database"].": ". $arrHttp["base"];
        ?>
    </div>
    <div class="actions">
        <?php    
        if (isset($arrHttp["Fixed_field"])) {
                $backtoscript ="fixed_marc.php?base=". $arrHttp["base"].$encabezado;
                include "../common/inc_back.php";
                include "../common/inc_home.php";
        } else {
            if (!isset($arrHttp["ventana"])) {
                $backtoscript = "menu_modificardb.php?base=". $arrHttp["base"].$encabezado;
                include "../common/inc_back.php";
                include "../common/inc_home.php";
            } else {
                include "../common/inc_close.php";
            }
        }
        ?>
</div>
<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";

// Write the content of ValorCapturado to the file
$archivo=$arrHttp["archivo"];
$archivobase=$arrHttp["base"]."/def/".$lang."/".$archivo;
$archivolang=$db_path.$arrHttp["base"]."/def/".$lang;
$archivofull=$db_path.$archivobase;
$t=explode("\n",$arrHttp["ValorCapturado"]);
if (!file_exists($archivolang)) mkdir ($archivolang);
$fp=@fopen($archivofull,"w");
if (!$fp){
    echo "<div style='color:red'>".$msgstr["cwritefile"].": ".$archivobase;
    include ("../common/footer.php");
    die;
}

foreach ($t as $value){
    $val=trim(str_replace('|','',$value));
    if ($val=="00") $val="";
    if ($val!="") fwrite($fp,stripslashes($value)."\n");
    //echo "$value<br>";
}
// The file is updated now: send a message
echo "<h2>".$msgstr["updated"]." : ".$archivobase."</h2>";

// IF THE FDT IS A FORMAT also UPDATE THE FILE formatos.wks
$formatos=$arrHttp["base"]."/def/".$lang."/formatos.wks";
$formatosfull=$db_path.$formatos;
$formatos2=$arrHttp["base"]."/def/".$lang_db."/formatos.wks";
$formatos2full=$db_path.$formatos2;
if (isset($arrHttp["fmt_name"])){
    if (file_exists(($formatosfull))){
        $fp=file($formatosfull);
        $updateformatos="default";
    }else{
        if (file_exists(($formatos2full))){
            $fp=file($formatos2full);
            $updateformatos="forced";
        }
    }
    $fex="N";
    // Read the content of the formatos file (of the current or default language)
    // If there is no formatos file for the current language the default language gives a good start
    if ($fp){
        foreach ($fp as $linea){
            $linea=trim($linea);
            if ($linea!=""){
                $l=explode('|',$linea);
                if (trim($l[0])==trim($arrHttp["fmt_name"]))
                    $fex="S";
                $salida[]=$linea;
            }
        }
    }
    //IF IS A NEW FORMAT: write to the current language
    if ($fex=="N" || $updateformatos=="forced"){
        $fp=@fopen($formatosfull,"w");
        if (!$fp){
            echo "<div style='color:red'>".$msgstr["cwritefile"].": ".$formatos;
            include ("../common/footer.php");
            die;
        }
        foreach ($salida as $arch) {
            // in case of forced update do not write duplicate
            if ($arch != $arrHttp["fmt_name"].'|'.$arrHttp["fmt_desc"]){
                $res=fwrite($fp,$arch."\n");
            }
        }
        $res=fwrite($fp,$arrHttp["fmt_name"].'|'.$arrHttp["fmt_desc"]);
        fclose($fp); #close the file
        echo "<h3>".$msgstr["updated"]." : ".$formatos."</h3>";
    }
}
?>
</div>
</div>
<?php include ("../common/footer.php"); ?>