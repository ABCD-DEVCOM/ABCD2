<?php
/* Modifications
20210903 fho4abcd Created
20211215 fho4abcd Backbutton by included file
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

// Define default array for Dublin Core metadata elements + ABCD elements and their initial map
// Map defined here to ensure availability
$metadataMap=array();
array_push($metadataMap,array("term"=>"title", "label"=>$msgstr['dd_term_title'], "field"=>"v1"));
array_push($metadataMap,array("term"=>"creator", "label"=>$msgstr['dd_term_creator'], "field"=>"v2"));
array_push($metadataMap,array("term"=>"subject", "label"=>$msgstr['dd_term_subject'], "field"=>"v3"));
array_push($metadataMap,array("term"=>"description", "label"=>$msgstr['dd_term_description'], "field"=>"v4"));
array_push($metadataMap,array("term"=>"publisher", "label"=>$msgstr['dd_term_publisher'], "field"=>"v5"));
array_push($metadataMap,array("term"=>"contributor", "label"=>$msgstr['dd_term_contributor'], "field"=>"v6"));
array_push($metadataMap,array("term"=>"date", "label"=>$msgstr['dd_term_date'], "field"=>"v7"));
array_push($metadataMap,array("term"=>"type", "label"=>$msgstr['dd_term_type'], "field"=>"v8"));
array_push($metadataMap,array("term"=>"format", "label"=>$msgstr['dd_term_format'], "field"=>"v9"));
array_push($metadataMap,array("term"=>"identifier", "label"=>$msgstr['dd_term_identifier'], "field"=>"v10"));
array_push($metadataMap,array("term"=>"source", "label"=>$msgstr['dd_term_source'], "field"=>"v11"));
array_push($metadataMap,array("term"=>"language", "label"=>$msgstr['dd_term_language'], "field"=>"v12"));
array_push($metadataMap,array("term"=>"relation", "label"=>$msgstr['dd_term_relation'], "field"=>"v13"));
array_push($metadataMap,array("term"=>"coverage", "label"=>$msgstr['dd_term_coverage'], "field"=>"v14"));
array_push($metadataMap,array("term"=>"rights", "label"=>$msgstr['dd_term_rights'], "field"=>"v15"));
$metadataMapCntDC=count($metadataMap);
array_push($metadataMap,array("term"=>"htmlSrcURL", "label"=>$msgstr['dd_term_htmlSrcURL'], "field"=>"v95"));
array_push($metadataMap,array("term"=>"htmlSrcFLD", "label"=>$msgstr['dd_term_htmlSrcFLD'], "field"=>"v96"));
array_push($metadataMap,array("term"=>"sections", "label"=>$msgstr['dd_term_section'], "field"=>"v97"));
array_push($metadataMap,array("term"=>"url", "label"=>$msgstr['dd_term_url'], "field"=>"v98"));
array_push($metadataMap,array("term"=>"doctext", "label"=>$msgstr['dd_term_doctext'], "field"=>"v99"));
array_push($metadataMap,array("term"=>"id", "label"=>$msgstr['dd_term_id'], "field"=>"v111"));
array_push($metadataMap,array("term"=>"dateadded", "label"=>$msgstr['dd_term_dateadded'], "field"=>"v112"));
array_push($metadataMap,array("term"=>"htmlfilesize", "label"=>$msgstr['dd_term_htmlfilesize'], "field"=>"v997"));
$metadataMapCnt=count($metadataMap);
$metadataMapCntABCD=$metadataMapCnt-$metadataMapCntDC;

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
    $retval= read_dd_cfg("config", $metadataConfigFull, $metadataMapCnt,$actualField );
    if ($retval!=0) {
        echo "<p>".$msgstr["dd_map_intern"]."</p><br>";
        $showallbuttons=false;
        for ($i=0; $i<$metadataMapCnt;$i++) {
            array_push($actualField,array("field"=>$metadataMap[$i]["field"]));
        }
    }
}
else if ($mapoption=="Save") {
    echo "<p>".$msgstr["dd_map_write"]." ".$metadataConfigFull."</p><br>";
    $fp=fopen($metadataConfigFull,"w");
    for ($i=0; $i<$metadataMapCnt;$i++) {
        $term=$metadataMap[$i]["term"];
        if (isset($arrHttp[$term])) {
            $field=$arrHttp[$term];
        }else{
            $field=$metadataMap[$i]["field"];
        }
        fwrite($fp,$term."|".$field."\n");
        array_push($actualField,array("field"=>$field));
    }
    fclose($fp);
}
else if ($mapoption=="Default") {
    echo "<p>".$msgstr["dd_map_intern"]."</p><br>";
    $showallbuttons=false;
    if (file_exists($metadataConfigFull) ) {
        unlink($metadataConfigFull);
    }
    for ($i=0; $i<$metadataMapCnt;$i++) {
        array_push($actualField,array("field"=>$metadataMap[$i]["field"]));
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
    for ($i=0;$i<$metadataMapCntDC;$i++) {
        echo "<td align=right>".$metadataMap[$i]["label"]."</td>";
        echo "<td><input type=text name=".$metadataMap[$i]["term"]." value='".$actualField[$i]["field"]."' size=4></td>\n";
        if ( $i%5==4) echo "</tr><tr>";
    }
    ?>
    <tr><td colspan=10 style="color:green" align=center><?php echo $msgstr["dd_imp_meta_docs"];?></td></tr>
    <tr>
    <?php
    for ($i=0;$i<$metadataMapCntABCD;$i++) {
        $j=$i+$metadataMapCntDC;
        echo "<td align=right>".$metadataMap[$j]["label"]."</td>";
        echo "<td><input type=text name=".$metadataMap[$j]["term"]." value='".$actualField[$j]["field"]."' size=4></td>\n";
        if ( $j%5==4) echo "</tr><tr>";
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

