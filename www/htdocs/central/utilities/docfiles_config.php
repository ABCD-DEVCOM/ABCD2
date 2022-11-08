<?php
/* Modifications
20210903 fho4abcd Created
20211215 fho4abcd Backbutton by included file
20220103 fho4abcd Remove unused fields, add extra fields, moved default map to included file, new names
20220104 fho4abcd Added exif
**
** The field-id's in this file have a default, but can be configured
** Effect is that this code can be used for databases with other field-id's
** Goal fo this code is to configure the docfiles fields (enforced at first time usage)
** Note that this module is not aware of the actual database fdt,fst,...
** The database administrator has to take care of matching both worlds.
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../lang/importdoc.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$backtoscript="../dataentry/incio_main.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$impdoc_cnfcnt=0;
if ( isset($arrHttp["backtoscript"]))  $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))       $inframe=$arrHttp["inframe"];
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;

include "inc_coll_defmap.php";
?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function MapDefault(){
    document.continuar.mapoption.value="Default";
    document.continuar.submit()
}
function MapSave(){
    document.continuar.mapoption.value="Save";
    document.continuar.submit()
}
function SetFieldsMap(){
    document.continuar.submit()
}
function Done(){
    document.continuar.action='<?php echo $backtoscript?>';
    document.continuar.submit()
}
</script>

<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php   echo $msgstr["mantenimiento"].": ".$msgstr["dd_config"];
?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
    <div align=center><h3><?php echo $msgstr["dd_documents"] ?></h3>

<?php
// Set collection related parameters and create folders if not present
include "../utilities/inc_coll_chk_init.php";
// Include configuration functions
include "inc_coll_read_cfg.php";
/* =======================================================================
/* ----- main code : Check metadata mapping -*/
echo "<h3>".$msgstr["dd_imp_step_check_map"]."</h3>";
$mapoption="";
if (isset($arrHttp["mapoption"])) $mapoption=$arrHttp["mapoption"];
$actualField=array();
$showallbuttons=true;
if ($mapoption=="" ) {
    $retval= read_dd_cfg("config", $tagConfigFull, $actualField );
    if ($retval!=0) {
        echo "<p>".$msgstr["dd_map_intern"]."</p><br>";
        $showallbuttons=false;
        $actualField=array();
        for ($i=0; $i<$defTagMapCnt;$i++) {
            array_push($actualField,array("field"=>$defTagMap[$i]["field"]));
        }
    }
}
else if ($mapoption=="Save") {
    echo "<p>".$msgstr["dd_map_write"]." ".$tagConfigFull."</p><br>";
    $fp=fopen($tagConfigFull,"w");
    for ($i=0; $i<$defTagMapCnt;$i++) {
        $term=$defTagMap[$i]["term"];
        if (isset($arrHttp[$term])) {
            $field=$arrHttp[$term];
        }else{
            $field="";
        }
        fwrite($fp,$term."|".$field."\n");
        array_push($actualField,array("field"=>$field));
    }
    fclose($fp);
}
else if ($mapoption=="Default") {
    echo "<p>".$msgstr["dd_map_intern"]."</p><br>";
    $showallbuttons=false;
    if (file_exists($tagConfigFull) ) {
        unlink($tagConfigFull);
    }
    for ($i=0; $i<$defTagMapCnt;$i++) {
        array_push($actualField,array("field"=>$defTagMap[$i]["field"]));
    }
}
?>
<form name=continuar  method=post >
    <input type=hidden name=mapoption>
    <?php
    foreach ($_REQUEST as $var=>$value){
        if ( $var!="upldoc_cnfcnt" && $var!="mapoption"){
            // some values may contain quotes or other "non-standard" values
            $value=htmlspecialchars($value);
            echo "<input type=hidden name=$var value=\"$value\">\n";
        }
    }
    ?>
    <table cellspacing=1 cellpadding=4>
    <tr><td colspan=8 style="color:green" align=center><?php echo $msgstr["dd_imp_meta_dublin"];?></td></tr>
    <tr>
    <?php
    for ($i=0;$i<$defTagMapCntDC;$i++) {
        echo "<td align=right>".$defTagMap[$i]["label"]."</td>";
        echo "<td><input type=text name=".$defTagMap[$i]["term"]." value='".$actualField[$i]["field"]."' size=4></td>\n";
        if ( $i%5==4) echo "</tr><tr>";
    }
    ?>
    <tr><td colspan=8 style="color:green" align=center><?php echo $msgstr["dd_imp_meta_exif"];?></td></tr>
    <tr>
    <?php
    for ($i=0;$i<$defTagMapCntEX;$i++) {
        $j=$i+$defTagMapCntDC;
        echo "<td align=right>".$defTagMap[$j]["label"]."</td>";
        echo "<td><input type=text name=".$defTagMap[$j]["term"]." value='".$actualField[$j]["field"]."' size=4></td>\n";
        if ( $i%5==4) echo "</tr><tr>";
    }
    ?>
    <tr><td colspan=10 style="color:green" align=center><?php echo $msgstr["dd_imp_meta_docs"];?></td></tr>
    <tr>
    <?php
    for ($i=0;$i<$defTagMapCntABCD;$i++) {
        $j=$i+$defTagMapCntEX+$defTagMapCntDC;
        echo "<td align=right>".$defTagMap[$j]["label"]."</td>";
        echo "<td><input type=text name=".$defTagMap[$j]["term"]." value='".$actualField[$j]["field"]."' size=4></td>\n";
        if ( $i%5==4) echo "</tr><tr>";
    }
    ?>
    <tr><td colspan=10 style="color:darkred" align=center><b><br><?php echo $msgstr["dd_map_fdt"];?></td></tr>
    </table>
    <br><br>
    <input type=button value='<?php echo $msgstr["dd_map_save"];?>' onclick=MapSave()>
    <?php if ($showallbuttons==true) { ?>
    <input type=button value='<?php echo $msgstr["dd_map_default"];?>' onclick=MapDefault()>
    &numsp;&numsp;&numsp;&numsp;&numsp;&numsp;
    <input type=button value='<?php echo $msgstr["dd_done"];?>' onclick=Done()>
    <?php } ?>
</form>
</div>
</div>
</div>
<?php
include "../common/footer.php";
?>

