<?php
/* Modifications
20210807 fho4abcd Created from several docbatchimport.php files
20210831 fho4abcd Improved URL fields
**
** The field-id's in this file have a default, but can be configured
** Effect is that this code can be used for databases with other field-id's
** Configuration is part of this code (enforced at first time usage)
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
if ( isset($arrHttp["impdoc_cnfcnt"])) $impdoc_cnfcnt=$arrHttp["impdoc_cnfcnt"];
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
function Eliminar(docfile,filename){
    /* docfile is the fullpath, filename is the user friendly name */
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+filename)==true){
	    document.continuar.deletedocfile.value=docfile
        document.continuar.submit()
	}
}
function Import(){
    document.continuar.impdoc_cnfcnt.value=3;
    document.continuar.submit()
}
function Invert(){
    document.continuar.action='../utilities/vmx_fullinv.php?&backtoscript=<?php echo $backtoscript?>'
    document.continuar.impdoc_cnfcnt.value=4;
    document.continuar.submit()
}
function MapDefault(){
    document.continuar.impdoc_cnfcnt.value=1;
    document.continuar.mapoption.value="Default";
    document.continuar.submit()
}
function MapSave(){
    document.continuar.impdoc_cnfcnt.value=1;
    document.continuar.mapoption.value="Save";
    document.continuar.submit()
}
function ShowDetails(){
    document.getElementById('importactiondiv').style.display='inherit'
}
function SetFieldsMap(){
    document.continuar.impdoc_cnfcnt.value=1;
    document.continuar.submit()
}
function SetImportOptions(){
    document.continuar.impdoc_cnfcnt.value=2;
    document.continuar.submit()
}
</script>

<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php   echo $msgstr["mantenimiento"].": ".$msgstr["dd_batchimport"];
?>
	</div>
	<div class="actions">
<?php
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:20%;left:25%;border:2px solid;"/>
    <div align=center><h3><?php echo $msgstr["dd_batchimport"] ?></h3>

<?php
// Set collection related parameters and create folders if not present
include "../utilities/inc_coll_chk_init.php";
// The file with adapted configuration
$metadataConfig="docfiles_metadataconfig.tab";
$metadataConfigFull=$fullcolpath."/".$metadataConfig;
// The function to list a folder and initial parameters
include "../utilities/inc_list-folder.php";
$fileList=array();
$skipNames=array($metadataConfig);

/* =======================================================================
/* ----- First screen: Give info and check existence of uploaded files -*/
if ($impdoc_cnfcnt<=0) {
    echo "<p>".$msgstr["dd_imp_init"]."</p>";
    echo "<h3>".$msgstr["dd_imp_step"]." ".($impdoc_cnfcnt+1).": ".$msgstr["dd_imp_step_check_files"]."</h3>";
    if ( isset($arrHttp["deletedocfile"]) && $arrHttp["deletedocfile"]!="")  {
        //delete the file
        unlink ($arrHttp["deletedocfile"]);
        $path=substr($arrHttp["deletedocfile"],strlen($coluplfull)+1);
        echo "<div>".$msgstr["archivo"]." ".$path." ".$msgstr["deleted"]."</div>";
    }

    // List all files in the upload folder
    $retval = list_folder("files", $coluplfull, $skipNames, $fileList);
    if ($retval!=0) die;
    $numfiles=count($fileList);
    if ($numfiles==0) {
        echo "<p style='color:red'>".$msgstr["dd_imp_nofiles"].$colupl."<p>";
    } else {
        $delimg="img src='../dataentry/img/barDelete.png' alt='" .$msgstr["eliminar"]."' title='".$msgstr["eliminar"]."'";
        echo "<p style='color:blue'>".$numfiles." ".$msgstr["dd_imp_numfiles"].$colupl."</p>";
        // build a table with filename, section and delete option
        sort($fileList);
        ?>
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=4>
        <tr>
            <th><?php echo $msgstr["archivo"]?> </th>
            <th><?php echo $msgstr["dd_section"]?> </th>
            <th><?php echo $msgstr["eliminar"]?> </th>
        </tr>
        <?php
        for ( $i=0;$i<$numfiles;$i++) {
            split_path($fileList[$i], $filename, $sectionname);
        ?> 
        <tr>
            <td bgcolor=white><?php echo $filename?></td>
            <td bgcolor=white><?php echo $sectionname?></td>
            <td bgcolor=white><a href="javascript:Eliminar('<?php echo $fileList[$i]?>','<?php echo $filename?>')"> <<?php echo $delimg?>> </a></td>
        </tr>
        <?php
        }
        echo "</table>";
        // Create a form
        ?>
        <form name=continuar  method=post >
            <input type=hidden name=impdoc_cnfcnt>
            <input type=hidden name=deletedocfile>
            <?php
            foreach ($_REQUEST as $var=>$value){
                if ( $var!= "deletedocfile" && $var!="impdoc_cnfcnt" && $var!="upldoc_cnfcnt"){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
            <br>
            <?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
            <input type=button value='<?php echo $msgstr["dd_imp_setfields"];?>' onclick=SetFieldsMap()>
        </form>
    <?php
    }
}
/* =======================================================================
/* ----- Second screen: Check metadata mapping -*/
else if ($impdoc_cnfcnt==1) {
    echo "<h3>".$msgstr["dd_imp_step"]." ".($impdoc_cnfcnt+1).": ".$msgstr["dd_imp_step_check_map"]."</h3>";
    $mapoption="";
    if (isset($arrHttp["mapoption"])) $mapoption=$arrHttp["mapoption"];
    $actualField=array();
    $showallbuttons=true;
    if ($mapoption=="" ) {
        $fp=@fopen($metadataConfigFull,"r");
        if ($fp===false) {
            echo "<p>".$msgstr["dd_map_intern"]."</p><br>";
            $showallbuttons=false;
            for ($i=0; $i<$metadataMapCnt;$i++) {
                array_push($actualField,array("field"=>$metadataMap[$i]["field"]));
            }
        }else {
            echo "<p>".$msgstr["dd_map_read"]." ".$metadataConfigFull."</p><br>";
            for ($i=0; $i<$metadataMapCnt;$i++) {
                $line=fgets($fp);
                if ($line!==false) {
                    $line=rtrim($line); // remove trailing white space(inc cr/lf)
                    $linecontent=explode("|",$line);
                    if(isset($linecontent[1])) {
                        array_push($actualField,array("field"=>$linecontent[1]));
                    }
                    else {
                        array_push($actualField,array("field"=>""));
                    }
                }
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
        <tr><td colspan=10 style="color:darkred" align=center><?php echo $msgstr["dd_map_fdt"];?></td></tr>
        </table>
        <br><br>
        <input type=button value='<?php echo $msgstr["dd_map_save"];?>' onclick=MapSave()>
        <?php if ($showallbuttons==true) { ?>
        <input type=button value='<?php echo $msgstr["dd_map_default"];?>' onclick=MapDefault()>
        &numsp;&numsp;&numsp;&numsp;&numsp;&numsp;
        <?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
        <input type=button value='<?php echo $msgstr["dd_imp_options"];?>' onclick=SetImportOptions()>
        <?php } ?>
    </form>
    <?php   
}
/* =======================================================================
/* ----- Third screen: Set import options -*/
else if ($impdoc_cnfcnt==2) {
    echo "<h3>".$msgstr["dd_imp_step"]." ".($impdoc_cnfcnt+1).": ".$msgstr["dd_imp_step_options"]."</h3>";
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
        <div style="color:green"><?php echo $msgstr["dd_optionmsg"];?></div>
        <table cellspacing=1 cellpadding=4>
        <tr>
            <td><?php echo $msgstr["dd_granularity"];?></td>
            <td><input type=text name=granularity size=2 value=" "</td>
        </tr><tr>
            <td><?php echo $msgstr["dd_addtimestamp"];?></td>
            <td><input type=checkbox id=addtimestamp name="addtimestamp" value=1 checked></td>
        </tr><tr>
            <td><?php echo $msgstr["dd_textformat"];?></td>
            <td><select name=textmode id=textmode>
                    <option value="m"><?php echo $msgstr["dd_tmode_meta"];?></option>
                    <option value="t"><?php echo $msgstr["dd_tmode_text"];?></option>
                    <option value="h" selected><?php echo $msgstr["dd_tmode_html"];?></option>
                    <option value="x"><?php echo $msgstr["dd_tmode_xhtml"];?></option>
                </select>
            </td>            
        </table>
        <br>
        <?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
        <input type=button value='<?php echo $msgstr["dd_imp_exec"];?>' onclick=Import()>
    </form>
    <?php   
}
/* =======================================================================
/* ----- Fourth screen: Actual import -*/
else if ($impdoc_cnfcnt==3) {
    echo "<h3>".$msgstr["dd_imp_step"]." ".($impdoc_cnfcnt+1).": ".$msgstr["dd_imp_step_exec"]."</h3>";
    $retval=0;
    $addtimestamp=$arrHttp["addtimestamp"];
    $textmode=$arrHttp["textmode"];
    $starttime = microtime(true);
    // List all files in the upload folder
    // The content is checked in the initial screen
    $retval = list_folder("files", $coluplfull, $skipNames, $fileList);
    if ($retval==0) {
        $numfiles=count($fileList);
        $numfilesOK=0;
        /*
        ** Before the import:
        ** Show number of files to do
        ** Open a div for all imports + show busy indicator
        */
        ?>
        <div id=importactiondiv align=left>
        <div style=color:blue><?php echo $msgstr["dd_imp_toimport"]." ".$numfiles;?></div><br>
        <script language=javascript>
            document.getElementById('preloader').style.visibility='visible'
        </script>
        <?php
        /*
        ** Loop over the files to import 
        ** Stop looping in case of errors
        */
        for ($i=0; $i<$numfiles && $retval==0; $i++) {
            ?>
            <hr>
            <ul><li><?php echo $msgstr["dd_imp_actfile"]." #".($i+1)." &rarr; ".$fileList[$i]?></li>
            <?php
            ob_flush();flush();
            // Import file
            $retval=import_action($fileList[$i],$addtimestamp, $textmode, $arrHttp["base"]);
            ob_flush();flush();
            if ($retval==0) $numfilesOK++;
            ?>
            </ul>
            <?php
        }
        /*
        ** After import: remove import output (only if no errors) and loader icon (always)
        ** Note that this text is still present in the page source
        */
        $endtime    = microtime(true);
        $timediff   = $endtime - $starttime;
        $numfilesNOK= $numfiles - $numfilesOK;
        ?>
        <hr>
        </div>
        <script language=javascript>
            <?php if ($retval==0) {?>
            document.getElementById('importactiondiv').style.display='none'
            <?php } ?>
            document.getElementById('preloader').style.visibility='hidden'
        </script>
        <br>
        <table style=color:blue  cellspacing=1 cellpadding=4>
        <tr><td><?php echo $msgstr["dd_imp_importok"]?></td>
            <td><?php echo $numfilesOK?></td>
            <td></td>
        </tr>
        <tr><td><?php echo $msgstr["dd_imp_importrem"]?></td>
            <td><?php echo $numfilesNOK?></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo $msgstr["dd_imp_proctime"];?></td>
            <td><?php echo secondsToTime($timediff)?></td>
            <td><input type=button value='<?php echo $msgstr["dd_imp_details"];?>' onclick=ShowDetails()></td>
        </tr>
        <form name=continuar  method=post >
        <?php
        foreach ($_REQUEST as $var=>$value){
            if ( $var!="upldoc_cnfcnt" && $var!="mapoption"){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
        ?>
        <tr>
            <td></td>
            <td><?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;</td>
            <td><input type=button value='<?php echo $msgstr["dd_imp_invert"];?>' onclick=Invert()></td>
        </tr>
        </form>
        </table>

        <?php
    }
}
?>
</div>
</div>
</div>
<?php
include "../common/footer.php";
?>
</body>
</html>
<?php
// ======================================================
// This the end of main script. Only functions follow now
// =========================== Functions ================
// ====== import_action =============================
function import_action($full_imp_path, $addtimestamp, $textmode, $basename) {
/*
** Imports the given file in ABCDImportRepo/... into the collection
** The metadata of this file is stored in an ABCD record.
** Normally a new record
**
** In: $full_imp_path = Full filename in <collection>/ABCDImportRepo/...
** In: $addtimestamp  = Indicator to add a timestamp to the filename (0/1)
** In: $textmode      = 
** In: $basename      = short name of the database (e.g. dubcore)
** Other variables via 'Global'.
** Return : 0=OK, 1=NOT-OK
*/
global $cgibin_path, $db_path, $fullcolpath, $msgstr, $mx_path, $metadataMapCntDC, $metadataMap;
    $retval=1;
    $time_sep="__";
    clearstatcache(true);
    /*
    ** Check if a section is required
    ** Create section (may be multiple subfolders) if not present in collection
    ** Check if the section destination folder is a writeable folder
    */
    $orgfilename="";
    $sectionname="";
    $destpath=$fullcolpath."/";
    split_path( $full_imp_path, $orgfilename, $sectionname);
    if ( $sectionname!="" ) {
        ?>
        <li><?php echo $msgstr["dd_chk_section"]." &rarr; ".$sectionname;?></li>
        <?php
        $destpath.=$sectionname."/";
        if (!file_exists($destpath)) {
            if (!mkdir ($destpath,0777,true)){
                echo '<div style="color:red">Failed to create section folder(s).... (e.g. &rarr;'.$destpath.'&larr;)>';
                return(1);
            }
        }
        if (!is_dir($destpath) || !is_writable($destpath) ){
             echo '<div style="color:red">Section is not a writeable folder (e.g. &rarr;'.$destpath.'&larr;)>';
             return(1);
       }
    }
    /*
    ** Actions with the filename:
    ** - Split in name and extension (more extensions will be created)
    ** - Construct default for dc:source
    ** - If checked: add timestamp to avoid accidental overwrite
    ** - replace space,%20 by underscore
    ** - Construct the name of the tika generated target html file
    ** - Construct the name of the mx proc input file
    ** - Construct the name of the final htmlfile (no sections in /ABCDSourceRepo)
    */
    $path_parts  = pathinfo($orgfilename);
    $docname     = $path_parts['filename'];
    $docext      = $path_parts['extension'];
    $def_c_source= $docname.".".$docext;
    if ($addtimestamp==1) {
        // Add timestamp. Don't care that it is in seconds
        $docname.=$time_sep.time();
    }
    $htmlfile    = $db_path."wrk/".$docname.'.html';
    $procfile    = $db_path."wrk/".$docname.'.proc';
    $htmlSrcPath = $fullcolpath."/ABCDSourceRepo/".$docname.".html";
    $htmlURLtail = substr($htmlSrcPath, strlen($db_path));
    $htmlURLPath = "/docs/".$htmlURLtail;
    /*
    ** Move the uploaded file to the collection
    */
    $docpath=$destpath.$docname.".".$docext;
    echo "<li>Moving $orgfilename to $docpath</li>";
    rename($full_imp_path, $docpath);
    /*
    ** Construct & execute the tika command to detect the metadata
    */
    $tikacommand='java -jar '.$cgibin_path.'tika-app-2.0.0.jar -r -'.$textmode.' '.$docpath.' 2>&1 >'.$htmlfile;
    echo "<li>".$msgstr['procesar'].": ".$tikacommand."</li>";
    ob_flush();flush();
    exec( $tikacommand, $output, $status);
    if ($status!=0) {
        echo "<div style='color:red'><b>".$msgstr["fatal"]."<br>";
        for ($i=0; $i<count($output);$i++) {
            echo $output[$i]."<br>";
        }
        echo "</b></div>";
        if (file_exists($htmlfile) ) unlink($htmlfile);
        rename($docpath, $full_imp_path);
        return(1);
    } else {
        echo ("<li style='color:green;font-weight:bold'>&rArr; ".$msgstr["dd_metadata_detect_ok"]."</li>");
        ob_flush();flush();
    }
    /*
    ** Read metadata from the tika generated html file
    ** Lines like 
    ** <meta name="dc:format" content="application/pdf; version=1.5"/>
    ** Actual files may contain hundreds of such lines.
    ** PHP function get_meta_tags handles this efficiently
    ** A missing file is considered a fatal error
    ** This file can be empty OR very large
    */
    echo "<li>".$msgstr["dd_detect_meta"]." ".$htmlfile."</li>";
    ob_flush();flush();
    $metatab=array();
    $metatab=get_meta_tags($htmlfile);
    if ($metatab===false) {
        echo "<div style='color:red'>".$msgstr["dd_error_get_meta"]." (".$htmlfile.")</div>";
        unlink($htmlfile);
        rename($docpath, $full_imp_path);
        return(1);
    }
    /*
    ** Get metadata value/content from dc attributes
    ** Ensure that each dc element has a value
    */
    if (array_key_exists("dc:title",$metatab))      {$c_title=$metatab["dc:title"];}             else {$c_title="";}
    if (array_key_exists("dc:creator",$metatab))    {$c_creator=$metatab["dc:creator"];}         else {$c_creator="";}
    if (array_key_exists("dc:subject",$metatab))    {$c_subject=$metatab["dc:subject"];}         else {$c_subject="";}
    if (array_key_exists("dc:description",$metatab)){$c_description=$metatab["dc:description"];} else {$c_description="";}
    if (array_key_exists("dc:publisher",$metatab))  {$c_publisher=$metatab["dc:publisher"];}     else {$c_publisher="";}
    if (array_key_exists("dc:contributor",$metatab)){$c_contributor=$metatab["dc:contributor"];} else {$c_contributor="";}
    if (array_key_exists("dc:date",$metatab))       {$c_date=$metatab["dc:date"];}               else {$c_date="";}
    if (array_key_exists("dc:type",$metatab))       {$c_type=$metatab["dc:type"];}               else {$c_type="";}
    if (array_key_exists("dc:format",$metatab))     {$c_format=$metatab["dc:format"];}           else {$c_format="";}
    if (array_key_exists("dc:identifier",$metatab)) {$c_identifier=$metatab["dc:identifier"];}   else {$c_identifier="";}
    if (array_key_exists("dc:source",$metatab))     {$c_source=$metatab["dc:source"];}           else {$c_source="";}
    if (array_key_exists("dc:language",$metatab))   {$c_language=$metatab["dc:language"];}       else {$c_language="";}
    if (array_key_exists("dc:relation",$metatab))   {$c_relation=$metatab["dc:relation"];}       else {$c_relation="";}
    if (array_key_exists("dc:coverage",$metatab))   {$c_coverage=$metatab["dc:coverage"];}       else {$c_coverage="";}
    if (array_key_exists("dc:rights",$metatab))     {$c_rights=$metatab["dc:rights"];}           else {$c_rights="";}
    /*
    ** If dc term did not reveal a value try dcterms (the successor definition)
    */
    if ($c_title==""      && array_key_exists("dcterms:title",$metatab))      {$c_title=$metatab["dcterms:title"];}
    if ($c_creator==""    && array_key_exists("dcterms:creator",$metatab))    {$c_creator=$metatab["dcterms:creator"];}
    if ($c_subject==""    && array_key_exists("dcterms:subject",$metatab))    {$c_subject=$metatab["dcterms:subject"];}
    if ($c_description==""&& array_key_exists("dcterms:description",$metatab)){$c_description=$metatab["dcterms:description"];}
    if ($c_publisher==""  && array_key_exists("dcterms:publisher",$metatab))  {$c_publisher=$metatab["dcterms:publisher"];}
    if ($c_contributor==""&& array_key_exists("dcterms:contributor",$metatab)){$c_contributor=$metatab["dcterms:contributor"];}
    if ($c_date==""       && array_key_exists("dcterms:date",$metatab))       {$c_date=$metatab["dcterms:date"];}
    if ($c_type==""       && array_key_exists("dcterms:type",$metatab))       {$c_type=$metatab["dcterms:type"];}
    if ($c_format==""     && array_key_exists("dcterms:format",$metatab))     {$c_format=$metatab["dcterms:format"];}
    if ($c_identifier=="" && array_key_exists("dcterms:identifier",$metatab)) {$c_identifier=$metatab["dcterms:identifier"];}
    if ($c_source==""     && array_key_exists("dcterms:source",$metatab))     {$c_source=$metatab["dcterms:source"];}
    if ($c_language==""   && array_key_exists("dcterms:language",$metatab))   {$c_language=$metatab["dcterms:language"];}
    if ($c_relation==""   && array_key_exists("dcterms:relation",$metatab))   {$c_relation=$metatab["dcterms:relation"];}
    if ($c_coverage==""   && array_key_exists("dcterms:coverage",$metatab))   {$c_coverage=$metatab["dcterms:coverage"];}
    if ($c_rights==""     && array_key_exists("dcterms:rights",$metatab))     {$c_rights=$metatab["dcterms:rights"];}
    /*
    ** Fill dc: values if not given by standard processing of tika output
    */
    if ($c_date=="" && array_key_exists("dcterms:created",$metatab)) {$c_date=$metatab["dcterms:created"];}
    if ($c_type=="")   $c_type   = $docext;
    if ($c_source=="") $c_source = $def_c_source;
    /*
    ** Construct other metadata content:
    ** - c_htmlSrcURL  :
    ** - c_htmlSrcFLD  :
    ** - c_sections    : by the section name
    ** - c_url         : by /docs/<collection>/<sectionname>/<docname>.<doc_ext>
    ** - c_id          : by next_cn_number
    ** - c_dateadded   : by current data&time
    ** - c_htmlfilesize:
    ** - c_doctext     : filled by index generation
    */
    $c_htmlSrcURL=$htmlURLPath;
    $c_htmlSrcFLD=$htmlSrcPath;
    $c_sections=$sectionname;
    $c_url="/docs/";
    $c_url.=substr($fullcolpath, strlen($db_path));
    if ($sectionname!="") $c_url.="/".$sectionname;
    $c_url.="/".$docname.".".$docext;
    if ( next_cn_number($basename,$c_id)!=0 ){
        unlink($htmlfile);
        rename($docpath, $full_imp_path);
        return(1);
    }
    $c_dateadded=date("Y-m-d H:i:s");
    $c_htmlfilesize="";
    $c_doctext="";
    /*
    ** Get the tags to be processed
    */
    $vtitle       = remove_v($_POST["title"]);
    $vcreator     = remove_v($_POST["creator"]);
    $vsubject     = remove_v($_POST["subject"]);
    $vdescription = remove_v($_POST["description"]);
    $vpublisher   = remove_v($_POST["publisher"]);
    $vcontributor = remove_v($_POST["contributor"]);
    $vdate        = remove_v($_POST["date"]);
    $vtype        = remove_v($_POST["type"]);
    $vformat      = remove_v($_POST["format"]);
    $videntifier  = remove_v($_POST["identifier"]);
    $vsource      = remove_v($_POST["source"]);
    $vlanguage    = remove_v($_POST["language"]);
    $vrelation    = remove_v($_POST["relation"]);
    $vcoverage    = remove_v($_POST["coverage"]);
    $vrights      = remove_v($_POST["rights"]);
    $vhtmlSrcURL  = remove_v($_POST["htmlSrcURL"]);
    $vhtmlSrcFLD  = remove_v($_POST["htmlSrcFLD"]);
    $vsections    = remove_v($_POST["sections"]);
    $vurl         = remove_v($_POST["url"]);
    $vid          = remove_v($_POST["id"]);
    $vdateadded   = remove_v($_POST["dateadded"]);
    $vhtmlfilesize= remove_v($_POST["htmlfilesize"]);
    $vdoctext     = remove_v($_POST["doctext"]);
    /*
    ** Construct the proc file with metadata for mx
    ** Note that the commandline has limitations (length,allowed character) so a file is better
    */
    $fpproc=fopen($procfile,"w");
    $fields="'";
    if (($c_title!="")       and ($vtitle!=""))       $fields.="<".$vtitle.">".$c_title."</".$vtitle.">";
    if (($c_creator!="")     and ($vcreator!=""))     $fields.="<".$vcreator.">".$c_creator."</".$vcreator.">";
    if (($c_subject!="")     and ($vsubject!=""))     $fields.="<".$vsubject.">".$c_subject."</".$vsubject.">";
    if (($c_description!="") and ($vdescription!="")) $fields.="<".$vdescription.">".$c_description."</".$vdescription.">";
    if (($c_publisher!="")   and ($vpublisher!=""))   $fields.="<".$vpublisher.">".$c_publisher."</".$vpublisher.">";
    if (($c_contributor!="") and ($vcontributor!="")) $fields.="<".$vcontributor.">".$c_contributor."</".$vcontributor.">";
    if (($c_date!="")        and ($vdate!=""))        $fields.="<".$vdate.">".$c_date."</".$vdate.">";
    if (($c_type!="")        and ($vtype!=""))        $fields.="<".$vtype.">".$c_type."</".$vtype.">";
    if (($c_format!="")      and ($vformat!=""))      $fields.="<".$vformat.">".$c_format."</".$vformat.">";
    if (($c_identifier!="")  and ($videntifier!=""))  $fields.="<".$videntifier.">".$c_identifier."</".$videntifier.">";
    if (($c_source!="")      and ($vsource!=""))      $fields.="<".$vsource.">".$c_source."</".$vsource.">";
    if (($c_language!="")    and ($vlanguage!=""))    $fields.="<".$vlanguage.">".$c_language."</".$vlanguage.">";
    if (($c_relation!="")    and ($vrelation!=""))    $fields.="<".$vrelation.">".$c_relation."</".$vrelation.">";
    if (($c_coverage!="")    and ($vcoverage!=""))    $fields.="<".$vcoverage.">".$c_coverage."</".$vcoverage.">";
    if (($c_rights!="")      and ($vrights!=""))      $fields.="<".$vrights.">".$c_rights."</".$vrights.">";
    if (($c_htmlSrcURL!="")  and ($vhtmlSrcURL!=""))  $fields.="<".$vhtmlSrcURL.">".$c_htmlSrcURL."</".$vhtmlSrcURL.">";
    if (($c_htmlSrcFLD!="")  and ($vhtmlSrcFLD!=""))  $fields.="<".$vhtmlSrcFLD.">".$c_htmlSrcFLD."</".$vhtmlSrcFLD.">";
    if (($c_sections!="")    and ($vsections!=""))    $fields.="<".$vsections.">".$c_sections."</".$vsections.">";
    if (($c_url!="")         and ($vurl!=""))         $fields.="<".$vurl.">".$c_url."</".$vurl.">";
    if (($c_id!="")          and ($vid!=""))          $fields.="<".$vid.">".$c_id."</".$vid.">";
    if (($c_dateadded!="")   and ($vdateadded!=""))   $fields.="<".$vdateadded.">".$c_dateadded."</".$vdateadded.">";
    if (($c_htmlfilesize!="")and ($vhtmlfilesize!=""))$fields.="<".$vhtmlfilesize.">".$c_htmlfilesize."</".$vhtmlfilesize.">";
    if (($c_doctext!="")     and ($vdoctext!=""))     $fields.="<".$vdoctext.">".$c_doctext."</".$vdoctext.">";
    $fields.="'";
    fwrite($fpproc,$fields);
    fclose($fpproc);
    /*
    ** run mx to create the record
    */
    $mxcommand= $mx_path." null proc=@".$procfile. " append=".$db_path.$basename."/data/".$basename. " count=1 now -all 2>&1";
    $mxpretty=str_replace("<","&lt;",$mxcommand);
    $mxpretty=str_replace(">","&gt;",$mxpretty);
    echo "<li>".$msgstr['procesar'].": ".$mxpretty."</li>";
    ob_flush();flush();
    exec( $mxcommand, $output, $status);
    if ($status!=0) {
        echo "<div style='color:red'><b>".$msgstr["fatal"]."<br>";
        for ($i=0; $i<count($output);$i++) {
            echo $output[$i]."<br>";
        }
        echo "</b></div>";
        if (file_exists($htmlfile) ) unlink($htmlfile);
        //if (file_exists($procfile) ) unlink($procfile);
        rename($docpath, $full_imp_path);
        return(1);
    } else {
        echo ("<li style='color:green;font-weight:bold'>&rArr; ".$msgstr["dd_record_created"]);
        echo (": <i>".$docname.".".$docext."</i></li>");
        ob_flush();flush();
    }
    if (file_exists($htmlfile) ) rename($htmlfile,$htmlSrcPath);
    if (file_exists($procfile) ) unlink($procfile);

    return(0);
}
// ====== next_cn_number ============================
function next_cn_number($basename, &$cn){
/*
** Returns the next control number.
** The control number is administrated in <basename>/data/control_number.cn
** This file is created if it does not exist.
**
** In : $basename = Short database name
** Out: $cn       = Next control number or "" in case of errors
**
** Return : 0=OK, 1=NOT-OK
*/
global $db_path,$max_cn_length, $msgstr;
    $cn="";
    $retval=0;
    $archivo=$db_path.$basename."/data/control_number.cn";
    $archivobak=$db_path.$basename."/data/control_number.bak";
    // ensure that a .cn file exists
	if (!file_exists($archivo)){
        $fp=@fopen($archivo,"w");
        if ($fp===false) {
            $contents_error= error_get_last();
            echo "<div style='color:red'><b>".$msgstr["fatal"].": &rarr; </b>".$contents_error["message"]."<br>";
            echo "&rarr; ".$msgstr["dd_error_init_cnfile"]."</div>";
            return(1);
        }
        fwrite($fp,"0");
        fclose($fp);
    }
    // Read the cn number from the .cn file and increment it
    $fp=file($archivo);
    $cn=implode("",$fp);
    $cn=$cn+1;
    // Remove an existing .bak file and make the current file the .bak
    if (file_exists($archivobak)) unlink($archivobak);
    rename($archivo,$archivobak);
    // Write a new .cn file
    $fp=@fopen($archivo,"w");
    if ($fp===false) {
        $contents_error= error_get_last();
        echo "<div style='color:red'><b>".$msgstr["fatal"].": &rarr; </b>".$contents_error["message"]."<br>";
        echo "&rarr; ".$msgstr["dd_error_next_cnfile"]."</div>";
        return(1);
    }
    fwrite($fp,$cn);
    fclose($fp);
    if (isset($max_cn_length)) $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
    return($retval);
}
// ====== remove_v =============================
function remove_v($field) {
    $field=trim($field);
    if (isset($field[0])) {
        if (($field[0]=='v') or ($field[0]=='V')) {
            $field=str_replace( 'v','',strtolower($field));
        }
    }
    return $field;
}
// ====== secondsToTime =============================
/* 
** In : $s  = Seconds
** returns string <hours>:<minutes>:<seconds>
*/
function secondsToTime($s) {
    round($s);
    $h = floor($s / 3600);
    $s -= $h * 3600;
    $m = floor($s / 60);
    $s -= $m * 60;
    return $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s);
}
// ====== split_path =============================
function split_path($full_path, &$filename, &$sectionname){
/* 
** In : $full_path  = Full filename in ABCDImportRepo
** Out: $filename   = The filename (last part of the name)
** Out: $sectionname= The section (optional subdirectories)
** returns always 0 (OK)
*/
    global $coluplfull;
    $path=substr($full_path,strlen($coluplfull)+1);
    $slashpos=strrpos($path,'/',0);
    if ($slashpos==false) {
        $filename=$path;
        $sectionname="";
        return(0);
    } else {
        $sectionname=substr($path,0,$slashpos);
        $filename=substr($path, $slashpos+1 );
    }
    return(0);
}
// ======================= End functions/End =====
