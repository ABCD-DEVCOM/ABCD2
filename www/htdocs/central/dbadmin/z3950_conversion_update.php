<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conversion_update.php
 * @desc:      Creates in the def folder a conversion table from z39.50
 * @author:    Guilda Ascencio
 * @since:     20091203
20220108 fho4abcd backButton+ div helper+improve html
20230704 fho4abcd cnvfile (file with table of actual filenames) by parameter
20230705 fho4abcd Moved write of data to this file. Added ignore data type
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$Type=$arrHttp["Type"];
$backtoscript="../dbadmin/z3950_conf.php";

$lang=$_SESSION["lang"];
//====================== Functions =================
// Function to dispatch te writing of table data
function dispatchType(){
    global $msgstr,$Type;
    if ( $Type=="ignore") {
        writeIgnore();
    } else if ( $Type=="convert") {
        writeConvert();
    } else {
        echo "<br><font=red>"."Unknown Type. Program error."."</font>";
        die;
    }    
}
function writeIgnore() {
    global $msgstr, $arrHttp, $numerr,$tabfilefull;
    $locerr=0;
    if ( !isset($arrHttp["ignfields"])) {
        $locerr++;
    } else {
        $ignfields=explode('|',$arrHttp["ignfields"]);
        for ($i=0;$i<count($ignfields);$i++) {
            $ignfield=trim($ignfields[$i]);
            if ($ignfield=="" ) {
                $locerr++;
            } else if (!is_numeric($ignfield) || intval($ignfield)==0){
                $locerr++;
            }
        }
    }
    if ($locerr!=0) {
        echo "<font color=red>".$msgstr["z3950_invfieldnumbers"]."</font><br>";
        $numerr++;
    }
    if ($numerr==0) {
        $fptabfile=fopen($tabfilefull,"w");
        if (!$fptabfile){
            echo "<font color=red>".$tabfilefull.": ".$msgstr["nopudoseractualizado"]."</font>";
            $numerr++;
        }
    }
    if ($numerr==0){
        for ($i=0;$i<count($ignfields);$i++) {
            fwrite($fptabfile,trim($ignfields[$i])."\n");
        }
        fclose($fptabfile);
    }
}
function writeConvert() {
    global $msgstr, $arrHttp,$numerr,$tabfilefull;
    $locerr=0;
    $pft=array();
    foreach ($arrHttp as $var=>$value) {
        $value=trim($value);
        if (substr($var,0,3)=="tag") {
            $ix=substr($var,3);
            if (isset($arrHttp["formato".$ix])) {
                if (trim($arrHttp["formato".$ix])!="") $pft[$value]=stripslashes($arrHttp["formato".$ix]);
            }
        }
    }
    if ($numerr==0) {
        $fptabfile=fopen($tabfilefull,"w");
        if (!$fptabfile){
            echo "<font color=red>".$tabfilefull.": ".$msgstr["nopudoseractualizado"]."</font>";
            $numerr++;
        }
    }
    if ($numerr==0){
        foreach ($pft as $tag=>$value){
            fwrite($fptabfile,$tag.":".$value."\n");
        }
        fclose($fptabfile);
    }
}
//----------------------- End functions --------------------------------------------------

include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
$Opcion=$arrHttp["Opcion"];
$description=$arrHttp["descr"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php
    if ($Type=="ignore"){
        echo $msgstr["z3950"].": ".$msgstr["z3950_ign"]." (".$arrHttp["base"].")";
    } else {
        echo $msgstr["z3950"].": ".$msgstr["z3950_tab"]." (".$arrHttp["base"].")";
    }
    ?>
	</div>

	<div class="actions">
    <?php
	include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="z3950_conf.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<div style="text-align:center">
<?php
$numerr=0;
// Construct the filename of the table with table files. Must be writable
$filesTableFile=$arrHttp["base"].$arrHttp["filesTableFile"];
$filesTableFilefull=$db_path.$filesTableFile;
$fp=fopen($filesTableFilefull,"a+");
if (!$fp){
	echo $filesTableFilefull.": ".$msgstr["nopudoseractualizado"];
	die;
}
fclose($fp);
// Now we are sure that the filenames table file exists and is writable
// Content may be empty
// Read the filenames table file
$fp=file($filesTableFilefull);
$filnamarry=Array();
foreach ($fp as $value){
    $t=explode('|',trim($value));
    if (trim($t[0])!="" && count($t)>1 && trim($t[1])!="" ) {
        $filnamarry[trim($t[0])]=trim($t[1]);
    }
}
// Construct the filename of the table with data
$tabfilename=$arrHttp["Table"];
$tabfilebase=$arrHttp["base"]."/def/".$tabfilename;
$tabfilefull=$db_path.$tabfilebase;
/*
* For a new file: the file should not exist + file & description must be unique
*/
if ( $Opcion=="new") {
    if ( file_exists($tabfilefull) ) {
        echo "<font color=red> ".$tabfilefull.": ".$msgstr["fileexists"]."</font><br>";
        $numerr++;
    }
    foreach($filnamarry as $key => $value) {
        if ($key==$tabfilename) {
            echo "<font color=red>&apos;".$key."&apos;: ".$msgstr["exists"]."</font><br>";
            $numerr++;
        }
        if ($value==$description) {
            echo "<font color=red>&apos;".$value."&apos;: ".$msgstr["exists"]."</font><br>";
            $numerr++;
        }
    }
    if ($numerr==0) dispatchType();
    if ($numerr==0) {
        echo "<h4>".$tabfilebase.": ".$msgstr["created"]."</h4>";
        
        // write the extra line to the filenames table file
        $filnamarry[$tabfilename]=$description;
        natsort($filnamarry);
        $fp=fopen($filesTableFilefull,"w");
        foreach($filnamarry as $key => $value) {
            fwrite($fp, $key."|".$value.PHP_EOL);
        }
        echo "<h4>".$filesTableFile.": ".$msgstr["updated"]."</h4>";
    }
} else {
    /*
    * For a modified file: file must exist+ file/description exist in table OR file exists and description is unique
    */
    $add="Y";
    foreach($filnamarry as $key => $value) {
        if ($key==$tabfilename && $value==$description) {
            $add="N";
        } else if ($key==$tabfilename && $value!=$description) {
            $add="M";
        } else if ($value==$description) {
            echo "<font color=red>&apos;".$value."&apos;: ".$msgstr["exists"]."</font><br>";
            $numerr++;
        }
    }
    if ( $numerr==0) dispatchType();
    if ( $numerr==0) {
        ?>
        <h4><?php echo $tabfilebase.": ".$msgstr["updated"];?></h4>
        <?php
    }
    if ( $numerr==0 && ($add=="Y" || $add=="M")) {
        $out=fopen($db_path.$filesTableFile,"w");
        foreach ($fp as $value){
            $t=explode('|',$value);
            if (count($t)<2 || (count($t)==2 && $t[0]!=$arrHttp["Table"])) $res=fwrite($out,$value);
        }
        $res=fwrite($out,$arrHttp["Table"].'|'.$arrHttp["descr"]."\n");
        fclose($out);
        echo "<h4>".$filesTableFile.": ".$msgstr["updated"]."</h4>";
    }
} ?>
</div></div>
<?php
include("../common/footer.php");
?>