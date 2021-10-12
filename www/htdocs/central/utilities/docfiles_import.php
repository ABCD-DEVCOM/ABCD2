<?php
/* Modifications
20210807 fho4abcd Created from several docbatchimport.php files
20210831 fho4abcd Improved URL fields
20210903 fho4abcd Moved configuration code to separate files.
20210929 fho4abcd Delete .proc file+ get html file size&db record size+split record
20211007 fho4abcd Search tika's, add tika selection+chunk size in menu+improved name cleaunup+proc file with pid
20211011 fho4abcd Tika uses stdin/stdout. Set locale to UTF-8 (required for function pathinfo. Improve filename sanitation
20211012 fho4abcd Error message if import subfolder not writable+ short timestamp for filenames>5 characters
**
** The field-id's in this file have a default, but can be configured
** Effect is that this code can be used for databases with other field-id's
** Note that this module is not aware of the actual database fdt,fst,...
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
$splittarget=80;
if ( isset($arrHttp["backtoscript"]))  $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))       $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["impdoc_cnfcnt"])) $impdoc_cnfcnt=$arrHttp["impdoc_cnfcnt"];
if ( isset($arrHttp["splittarget"]))   $splittarget=$arrHttp["splittarget"];
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;
/*
** The maximum recordsize is given in cisis.h by variable MAXMFRL
** We have 3 cisis versions in ABCD
** - empty = 16-60: max recordsize=   32767 (linux+windows)
** - ffi          : max recordsize= 1048576 (linux+windows, indexing methods for more static databases)
** - bigisis      : max recordsize= 1048576 (linux, no images compiled for windows (at the time this code is written)
*/
$isis_record_size=32767; // This also for 16-60
if ($cisis_ver=="ffi")     $isis_record_size=1048576;
if ($cisis_ver=="bigisis") $isis_record_size=1048576;

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
var win;
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
}
function Eliminar(docfile,filename){
    /* docfile is the fullpath, filename is the user friendly name */
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+filename)==true){
	    document.continuar.deletedocfile.value=docfile
        document.continuar.impdoc_cnfcnt.value=1;
        document.continuar.submit()
	}
}
function Reselect(){
	document.continuar.upldoc_cnfcnt.value='0';
    document.continuar.action='../utilities/docfiles_upload.php?&backtoscript=<?php echo $backtoscript?>'
	document.continuar.submit()
}

function SetImportOptions(){
    document.continuar.impdoc_cnfcnt.value=2;
    document.continuar.submit()
}
function Import(){
    document.continuar.impdoc_cnfcnt.value=3;
    document.continuar.submit()
}
function Invert(){
    document.continuar.action='../utilities/vmx_fullinv.php?&backtoscript=<?php echo $backtoscript?>&fstfile=fulltext.fst';
    document.continuar.impdoc_cnfcnt.value=4;
    document.continuar.submit()
}
function ShowDetails(){
    document.getElementById('importactiondiv').style.display='inherit'
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
    <div align=center><h3><?php echo $msgstr["dd_batchimport"] ?></h3>
<?php
// Set collection related parameters and create folders if not present
include "../utilities/inc_coll_chk_init.php";
// The function to list a folder and initial parameters
include "../utilities/inc_list-folder.php";
$fileList=array();
$skipNames=array($metadataConfig);
// Include configuration functions
include "inc_coll_read_cfg.php";

/* =======================================================================
/* ----- First screen: Give info and check existence of uploaded files -*/
if ($impdoc_cnfcnt<=1) {
    echo "<p>".$msgstr["dd_imp_init"]."</p>";
    // If this is the first time that this code runs: Read the configuration file
    if ($impdoc_cnfcnt==0) {
        $actualField=array();
        $retval= read_dd_cfg("operate", $metadataConfigFull, $metadataMapCnt,$actualField );
        if ($retval!=0) die;
    }
    echo "<h3>".$msgstr["dd_imp_step"]." ".($impdoc_cnfcnt+1).": ".$msgstr["dd_imp_step_check_files"]."</h3>";
    // If the request was to delete a file (second and subsequent runs)
    if ( isset($arrHttp["deletedocfile"]) && $arrHttp["deletedocfile"]!="")  {
        //delete the file
        $delindex=$arrHttp["deletedocfile"];
        $retval = list_folder("files", $coluplfull, $skipNames, $fileList);
        if ($retval!=0) die;
        sort($fileList);
        $numfiles=count($fileList);
        if ($numfiles>0 && $delindex<$numfiles) {
            if (unlink ($fileList[$delindex])===true){
                echo "<div>".$msgstr["archivo"]." ".$fileList[$delindex]." ".$msgstr["deleted"]."</div>";
            }
        }
        $fileList=[];
    }

    // List all files in the upload folder
    $retval = list_folder("files", $coluplfull, $skipNames, $fileList);
    if ($retval!=0) die;
    $numfiles=count($fileList);
    if ($numfiles==0) {
        echo "<p style='color:red'>".$msgstr["dd_imp_nofiles"].$colupl."<p>";
    } else {
        echo "<p style='color:blue'>".$numfiles." ".$msgstr["dd_imp_numfiles"].$colupl."</p>";
        // build a table with filename, section and delete option
        sort($fileList);
        ?>
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=1>
        <tr>
            <th><?php echo $msgstr["archivo"]?> </th>
            <th><?php echo $msgstr["dd_section"]?> </th>
        </tr>
        <?php
        for ( $index=0;$index<$numfiles;$index++) {
            split_path($fileList[$index], $filename, $sectionname);
            /*
            ** Note that the delete button works on the index in the list
            ** Parameters with embedded quotes result in js errors, so the quote is removed from the shown name
            ** The user won't notice this normally or think of a strange error
            */
        ?> 
        <tr>
            <td bgcolor=white><?php echo $filename?></td>
            <td bgcolor=white><?php echo $sectionname?></td>
            <td><button class="button_browse delete" type="button"
                onclick='javascript:Eliminar("<?php echo $index?>","<?php echo str_replace("'"," ",$filename)?>")'
                alt="<?php echo $msgstr['eliminar']?>" title="<?php echo $msgstr['eliminar'].":".$fileList[$index]?>">
                <i class="far fa-trash-alt"> <?php echo $msgstr['eliminar']?></i></button></td>
        </tr>
        <?php
        }
        echo "</table>";
    }
    // Create a form
    ?>
    <form name=continuar  method=post >
        <input type=hidden name=impdoc_cnfcnt>
        <input type=hidden name=deletedocfile>
        <input type=hidden name=upldoc_cnfcnt>
        <?php
        foreach ($_REQUEST as $var=>$value){
            if ( $var!= "deletedocfile" && $var!="impdoc_cnfcnt" && $var!="upldoc_cnfcnt"){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
        // The first run adds the map configuration
        if ($impdoc_cnfcnt==0) {
            for ($i=0;$i<$metadataMapCnt;$i++) {
                echo "<input type=hidden name=".$actualField[$i]["term"]." value='".$actualField[$i]["field"]."'>\n";
            }
        }
        ?>
        <br>
        <input type=button value='<?php echo $msgstr["dd_upload"];?>' onclick=Reselect()>
        
        <?php if ($numfiles>0 ) {
            // Display continuation button only if any files are present
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
            <input type=button value='<?php echo $msgstr["dd_imp_options"];?>' onclick=SetImportOptions()>
        <?php } ?>
    </form>
    <?php
}
/* =======================================================================
/* ----- Second screen: Set import options -*/
else if ($impdoc_cnfcnt==2) {
    echo "<h3>".$msgstr["dd_imp_step"]." 2: ".$msgstr["dd_imp_step_options"]."</h3>";
    $pretty_cisis_recsize=number_format($isis_record_size/1024,0,",",".")." Kb";
    // Find all tika jars
    $tikanamepattern="*tika*.jar";
    $tikajars=glob($cgibin_path.$tikanamepattern);
    if (sizeof($tikajars)==0 OR $tikajars===false) {
        echo "<p style='color:red'>".$msgstr["dd_imp_notika1"]."<br>";
        echo $msgstr["dd_imp_tikasrc"]." &rarr;<b>".$tikanamepattern."</b>&larr;<br>";
        echo $msgstr["dd_imp_tikadown"]." <a href='https://tika.apache.org/download.html'>Download Apache Tika</a><br>";
        echo $msgstr["dd_imp_tikainst"]." ".$cgibin_path."</p>";
        die;
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
        <div style="color:green"><?php echo $msgstr["dd_optionmsg"];?></div>
        <table cellspacing=2 cellpadding=2>
        <tr>
            <td><?php echo $msgstr["dd_addtimestamp"];?></td>
            <td><input type=checkbox id=addtimestamp name="addtimestamp" value=1 checked></td>
            <td style='color:blue'><?php echo $msgstr["dd_imp_unique"];?></td>
        </tr><tr>
            <td><?php echo $msgstr["dd_truncfilename"];?></td>
            <td><select name=truncsize id=truncsize>
                    <option value=""   ><?php echo $msgstr["dd_imp_nolimit"];?></option>
                    <option value="90" >&nbsp;90 <?php echo $msgstr["dd_imp_chars"];?></option>
                    <option value="60" >&nbsp;60 <?php echo $msgstr["dd_imp_chars"];?></option>
                    <option value="30" selected>&nbsp;30 <?php echo $msgstr["dd_imp_chars"];?></option>
                    <option value="0"  >&nbsp;&nbsp;0 <?php echo $msgstr["dd_imp_chars"];?></option>
                </select>
            </td>
            <td style='color:blue'><?php echo $msgstr["dd_truncmsg"];?></td>
        </tr><tr><td colspan=3>&nbsp;</td>
        </tr><tr>
            <td><?php echo $msgstr["dd_imp_tikajar"];?></td>
            <td><select name=tikajar id=tikajar>
                <?php
                $tikatags="";
                $numtags=0;
                foreach( $tikajars as $fulltikapath) {
                    $tikajar = substr($fulltikapath, strlen($cgibin_path));
                    echo "<option value=$tikajar>$tikajar</option>";
                    // tikatags is part of the URL to test the found tikas
                    if ($numtags>0) $tikatags.="&";
                    $tikatags.="tikajar".$numtags."=".$tikajar;
                    $numtags++;
                }
                ?>  
                </select>
            </td>
            <td style='color:blue'><?php
                $testbutton='<a href="test_tika.php?'.$tikatags.'"  target=testshow onclick=OpenWindow()>'.$msgstr["dd_imp_tikaver"].'</a>';
                echo "$testbutton"."<br>".$msgstr["dd_imp_tikasrc"]." &rarr;<b>".$tikanamepattern."</b>&larr;<br>";
                ?>
            </td>
        </tr><tr>
            <td><?php echo $msgstr["dd_textformat"];?></td>
            <td><select name=textmode id=textmode>
                    <option value="m"><?php echo $msgstr["dd_tmode_meta"];?></option>
                    <option value="t"><?php echo $msgstr["dd_tmode_text"];?></option>
                    <option value="h" selected><?php echo $msgstr["dd_tmode_html"];?></option>
                    <option value="x"><?php echo $msgstr["dd_tmode_xhtml"];?></option>
                </select>
            </td>
        </tr><tr>
            <td><?php echo $msgstr["dd_imp_splittarget"];?></td>
            <td><input name='splittarget' type=number min=1 max=100 value=<?php echo $splittarget;?> ></td>
            <td style='color:blue'><?php echo $msgstr["dd_imp_splitperc"]." (".$pretty_cisis_recsize.")";?></td>
        </tr>
        </table>
        <br>
        <?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
        <input type=button value='<?php echo $msgstr["dd_imp_exec"];?>' onclick=Import()>
    </form>
    <?php   
}
/* =======================================================================
/* ----- Third screen: Actual import -*/
else if ($impdoc_cnfcnt==3) {
    echo "<h3>".$msgstr["dd_imp_step"]." 3: ".$msgstr["dd_imp_step_exec"]."</h3>";
    $retval=0;
    $addtimestamp=$arrHttp["addtimestamp"];
    $tikajar=$arrHttp["tikajar"];
    $textmode=$arrHttp["textmode"];
    $truncsize="";
    if (isset($arrHttp["truncsize"])) $truncsize=$arrHttp["truncsize"];
    $starttime = microtime(true);
    // List all files in the upload folder
    // The content is checked in the initial screen
    $retval = list_folder("files", $coluplfull, $skipNames, $fileList);
    if ($retval==0) {
        $numfiles=count($fileList);
        $numfilesOK=0;
        $numrecsOK=0;
        /*
        ** Before the import:
        ** Open a progress bar/loading gift + show the number of files to do
        ** Open a div for all imports
        */
        ?>
        <div id=progresdiv>
        <table width="850">
          <tr>
            <td style="font-size:12px" height="30"><!-- Progress bar holder -->
                <div id="progress" style="width:800px;border:1px solid #ccc;">&nbsp;</div>
            </td>
          </tr>
          <tr>
            <td style="font-size:12px" height="30"><!-- Progress information -->
                <div id="information" style="width"><?php echo $msgstr["dd_imp_toimport"]." ".$numfiles;?></div>
            </td>
          </tr>
        </table>
        </div>
        <div id=importactiondiv align=left>
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
            $retval=import_action($fileList[$i], $addtimestamp, $truncsize, $tikajar, $textmode, $splittarget,
                                  $arrHttp["base"], $numrecsOK);
            ob_flush();flush();
            $processed=$i;
            if ($retval==0) {
                $numfilesOK++;
                $processed=$i+1;
            }
            ?>
            </ul>
            <?php
            //Update the progress bar/loading gift
            $percent = intval($processed/$numfiles * 100)."%";
            $inner1='<div style="width:'.$percent.';background-color:#364c6c;"><div style="color:white" align=center>'.$percent.'</div></div>';
            $inner2=$processed." ".$msgstr["dd_imp_processed"]." ".$numfiles." ".$msgstr["dd_imp_files"];
            ?>
            <script language="javascript">
              document.getElementById("progress").innerHTML='<?php echo $inner1?>';
              document.getElementById("information").innerHTML='<?php echo $inner2?>';
              </script>
            <?php
            ob_flush();flush();
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
        </script>
        <br>
        <table style=color:blue  cellspacing=1 cellpadding=4>
        <tr><td><?php echo $msgstr["dd_imp_importok"]?></td>
            <td><?php echo $numfilesOK?></td>
            <td></td>
        </tr>
        <tr><td><?php echo $msgstr["dd_imp_numrec"]?></td>
            <td><?php echo $numrecsOK?></td>
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
// ======================================================
// This the end of main script. Only functions follow now
//
// =========================== Functions ================
//  - import_action : imports an uploaded file
//  - next_cn_number: returns the next control number
//  - convert_name  : returns sanitized filename
//  - convert_field : returns sanitized mx field
//  - secondsToTime : return H:mm:ss
//  - split_path    : returns the "section" of the filename in ABCDImportRepo
//  - split_html    : splits an html file into smaller files and returns the number of parts.
//
// ====== import_action =============================
function import_action($full_imp_path, $addtimestamp, $truncsize, $tikajar, $textmode, $splittarget, $basename, &$numrecsOK) {
/*
** Imports the given file in ABCDImportRepo/... into the collection
** The metadata of this file is stored in an ABCD record.
** Normally a new record
**
** In: $full_imp_path = Full filename in <collection>/ABCDImportRepo/...
** In: $addtimestamp  = Indicator to add a timestamp to the filename (0/1)
** In: $truncsize     = Number of characters in core file name (""=unlimited)
** In: $tikajar       = Name of actual tika jar in cgi-bin
** In: $textmode      = Indicator for tika: m=meta, t=text, h=html, x=xhtml
** IN: $splittarget   = Percentage of recordsize as target of the split chunk size..
** In: $basename      = short name of the database (e.g. dubcore)
** Other variables via 'Global'.
** Return : 0=OK, 1=NOT-OK
*/
global $cisis_ver, $cgibin_path, $db_path, $fullcolpath, $msgstr, $mx_path,$isis_record_size;
    $retval=1;
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
    ** Modify the filename. Name and extension 
    ** - Replace characters to enable usage in url (name+ext)
    ** - Split in name and extension (more extensions will be created)
    ** - Add timestamp for uniqueness (only name)
    ** - Truncate excessive long names(only name)
    */
    if ( convert_name($orgfilename, $addtimestamp, $truncsize, $docname, $docext) !=0 ) return(1);
    if ( convert_field($orgfilename, $def_c_source) !=0 ) return(1);
    /*
    ** - Construct the name of the tika generated target (html) file
    */
    $tikafile    = $db_path."wrk/".$docname.'.html';
    /*
    ** - Construct the name of the mx proc input file.
    **   Use pid because mx does not like utf characters in this filename
    **   Always add a timestamp because the pid is the server pid, not unique for this run
    */
    $procfile    = getmypid()."_".date("ymdHis");//add always timestamp!!
    $procfile    = $db_path."wrk/".$procfile.'.proc';
    /*
    ** Move the uploaded file to the collection
    */
    $docpath=$destpath.$docname;
    if ($docext!="") $docpath.=".".$docext;
    echo "<li>Moving $orgfilename to $docpath</li>";
    if (@rename($full_imp_path, $docpath)===false){
        $contents_error= error_get_last();
        echo "<div style='color:red'><b>".$msgstr["fatal"].": &rarr; </b>".$contents_error["message"]."<br>";
        echo "&rarr; ".$msgstr["dd_error_moveto"]."</div>";
        $orglocale=setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C.UTF-8');
        $importdir=dirname($full_imp_path);
        setlocale(LC_CTYPE, $orglocale);
        if (!is_writable($importdir) ) {
            echo "<div style='font-weight:bold;color:red'>&rarr; '".$importdir."' ".$msgstr["dd_nowrite"]."</div>";
        }
        return(1);
    }
    /*
    ** Construct & execute the tika command to detect the metadata
    ** option -r: For JSON, XML and XHTML outputs, adds newlines and whitespace, for better readability
    ** Read from stdin so tika will not complain about the filename (or filename encoding).
    ** Using < in the command implies that the log message must contain &lt; in stead of <
    */
    $tikacommand='java -jar '.$cgibin_path.$tikajar.' -r -'.$textmode.' <'.$docpath.' 2>&1 >'.$tikafile;
    $tikashowcmd='java -jar '.$cgibin_path.$tikajar.' -r -'.$textmode.' &lt;'.$docpath.' 2>&1 >'.$tikafile;
    echo "<li>".$msgstr['procesar'].": ".$tikashowcmd."</li>";
    ob_flush();flush();
    exec( $tikacommand, $output, $status);
    if ($status!=0) {
        echo "<div style='color:red'><b>".$msgstr["fatal"]."<br>";
        for ($i=0; $i<count($output);$i++) {
            echo $output[$i]."<br>";
        }
        echo "</b></div>";
        if (file_exists($tikafile) ) unlink($tikafile);
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
    echo "<li>".$msgstr["dd_detect_meta"]." ".$tikafile."</li>";
    ob_flush();flush();
    $metatab=array();
    $metatab=get_meta_tags($tikafile);
    if ($metatab===false) {
        echo "<div style='color:red'>".$msgstr["dd_error_get_meta"]." (".$tikafile.")</div>";
        unlink($tikafile);
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
    ** - c_htmlSrcURL  : computed after split
    ** - c_htmlSrcFLD  : computed after split
    ** - c_sections    : by the section name
    ** - c_url         : by /docs/<collection>/<sectionname>/<docname>.<doc_ext>
    ** - c_id          : by next_cn_number
    ** - c_dateadded   : by current data&time
    ** - c_htmlfilesize: computed after split
    ** - c_doctext     : filled by index generation
    */
    $c_sections=$sectionname;
    $c_url="/docs/";
    $c_url.=substr($fullcolpath, strlen($db_path));
    if ($sectionname!="") $c_url.="/".$sectionname;
    $c_url.="/".$docname;
    if ($docext!="") $c_url.=".".$docext;
    if ( next_cn_number($basename,$c_id)!=0 ){
        unlink($tikafile);
        rename($docpath, $full_imp_path);
        return(1);
    }
    $c_dateadded=date("Y-m-d H:i:s");
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
    ** The generated file may be too large for the current database
    ** Next function call will split this file and return a list of files to be imported
    */
    $split_files=Array();
    if ( split_html($tikafile,$textmode,$c_title, $splittarget, $split_files)!=0 ) {
        unlink($tikafile);
        rename($docpath, $full_imp_path);
        return(1);
    }
    for ($ix=0; $ix<sizeof($split_files); $ix++ ) {
        $act_split_file=$split_files[$ix];
        /*
        ** Construct the proc file with metadata for mx
        ** Note that the commandline has limitations (length,allowed character) so a file is better
        */
        $fpproc=fopen($procfile,"w");
        $fields="'";
        if (($c_title!="")       and ($vtitle!=""))       $fields.="<".$vtitle.">".$c_title."</".$vtitle.">".PHP_EOL;
        if (($c_creator!="")     and ($vcreator!=""))     $fields.="<".$vcreator.">".$c_creator."</".$vcreator.">".PHP_EOL;
        if (($c_subject!="")     and ($vsubject!=""))     $fields.="<".$vsubject.">".$c_subject."</".$vsubject.">".PHP_EOL;
        if (($c_description!="") and ($vdescription!="")) $fields.="<".$vdescription.">".$c_description."</".$vdescription.">".PHP_EOL;
        if (($c_publisher!="")   and ($vpublisher!=""))   $fields.="<".$vpublisher.">".$c_publisher."</".$vpublisher.">".PHP_EOL;
        if (($c_contributor!="") and ($vcontributor!="")) $fields.="<".$vcontributor.">".$c_contributor."</".$vcontributor.">".PHP_EOL;
        if (($c_date!="")        and ($vdate!=""))        $fields.="<".$vdate.">".$c_date."</".$vdate.">".PHP_EOL;
        if (($c_type!="")        and ($vtype!=""))        $fields.="<".$vtype.">".$c_type."</".$vtype.">".PHP_EOL;
        if (($c_format!="")      and ($vformat!=""))      $fields.="<".$vformat.">".$c_format."</".$vformat.">".PHP_EOL;
        if (($c_identifier!="")  and ($videntifier!=""))  $fields.="<".$videntifier.">".$c_identifier."</".$videntifier.">".PHP_EOL;
        if (($c_source!="")      and ($vsource!=""))      $fields.="<".$vsource.">".$c_source."</".$vsource.">".PHP_EOL;
        if (($c_language!="")    and ($vlanguage!=""))    $fields.="<".$vlanguage.">".$c_language."</".$vlanguage.">".PHP_EOL;
        if (($c_relation!="")    and ($vrelation!=""))    $fields.="<".$vrelation.">".$c_relation."</".$vrelation.">".PHP_EOL;
        if (($c_coverage!="")    and ($vcoverage!=""))    $fields.="<".$vcoverage.">".$c_coverage."</".$vcoverage.">".PHP_EOL;
        if (($c_rights!="")      and ($vrights!=""))      $fields.="<".$vrights.">".$c_rights."</".$vrights.">".PHP_EOL;
        // some variables are dependent on the actual processed file
        $c_htmlfilesize= filesize($act_split_file);
        $htmlfilesec   = substr($act_split_file, strlen($db_path."wrk/"));
        $htmlSrcPath   = $fullcolpath."/ABCDSourceRepo/".$htmlfilesec;
        $htmlURLPath   = "/docs/".substr($htmlSrcPath, strlen($db_path));
        $c_htmlSrcURL  = $htmlURLPath;
        $c_htmlSrcFLD  = $htmlSrcPath;

        if (($c_htmlSrcURL!="")  and ($vhtmlSrcURL!=""))  $fields.="<".$vhtmlSrcURL.">".$c_htmlSrcURL."</".$vhtmlSrcURL.">".PHP_EOL;
        if (($c_htmlSrcFLD!="")  and ($vhtmlSrcFLD!=""))  $fields.="<".$vhtmlSrcFLD.">".$c_htmlSrcFLD."</".$vhtmlSrcFLD.">".PHP_EOL;
        if (($c_sections!="")    and ($vsections!=""))    $fields.="<".$vsections.">".$c_sections."</".$vsections.">".PHP_EOL;
        if (($c_url!="")         and ($vurl!=""))         $fields.="<".$vurl.">".$c_url."</".$vurl.">".PHP_EOL;
        if (($c_id!="")          and ($vid!=""))          $fields.="<".$vid.">".$c_id."</".$vid.">".PHP_EOL;
        if (($c_dateadded!="")   and ($vdateadded!=""))   $fields.="<".$vdateadded.">".$c_dateadded."</".$vdateadded.">".PHP_EOL;
        if (($c_htmlfilesize!="")and ($vhtmlfilesize!=""))$fields.="<".$vhtmlfilesize.">".$c_htmlfilesize."</".$vhtmlfilesize.">".PHP_EOL;
        if (($c_doctext!="")     and ($vdoctext!=""))     $fields.="<".$vdoctext.">".$c_doctext."</".$vdoctext.">".PHP_EOL;
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
            if (file_exists($act_split_file) ) unlink($act_split_file);
            if (file_exists($procfile) ) unlink($procfile);
            rename($docpath, $full_imp_path);
            return(1);
        } else {
            echo ("<li style='color:green;font-weight:bold'>&rArr; ".$msgstr["dd_record_created"]);
            echo (": <i>".$docname.".".$docext."</i></li>");
            ob_flush();flush();
        }
        if (file_exists($act_split_file) ) rename($act_split_file,$htmlSrcPath);
        if (file_exists($procfile) ) unlink($procfile);
        $numrecsOK++;
    }

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
// ======= convert_field =====================================
/*
** Converts the content of a database field in such a way that
** mx accepts it in a proc (file)
** Characters "'", "<", ">" are replaced by a space
**
** In : $orgtext = original text with malicious text
** Out: $cnvtext = converted text
*/
function convert_field($orgtext, &$cnvtext){
    global $msgstr;
    $cnvtext="";
    if ($orgtext=="") return 0;
    /*
    ** Detect most probable filename encoding:
    ** Set the detection order. Not the default PHP (is too simple)
    ** Order is important: UTF must be before ISO !!
    ** No way to distinguish mechanically ISO and Windows-1252
    */
    $ary[] = "ASCII";
    $ary[] = "UTF-8";
    $ary[] = "ISO-8859-1";
    mb_detect_order($ary);
    $name_encoding = mb_detect_encoding($orgtext,null,true);
    if ($name_encoding===false) {
        echo "<div style='color:red'>".$msgstr["dd_fielderrenc"]." &rarr;".$orgtext."&larr;</div>";
        return 1;
    }
    $cnvtext = mb_ereg_replace("[']","&quot;",$orgtext);
    $cnvtext = mb_ereg_replace("[<]","&lt;",$cnvtext);
    $cnvtext = mb_ereg_replace("[>]","&gt;",$cnvtext);
    return 0;
}
// ====== convert_name =============================
/*
** Extracts a filename and extension from a path and convert these names
** so they will be valid in windows AND linux
** 
** - Names in lowercase to be valid for windows/linux (and exports/imports)
** - Replace characters to enable usage in url and windows/linux filename restrictions
** - Add timestamp for uniqueness (only for the filename)
** - Truncate excessive long names(only for the filename)
**
** In  : $fullpath     = Full or partial filename
** In  : $addtimestamp = 0:no stamp, 1: add stamp
** In  : $truncsize    = Number of characters in base name (""=unlimited)
** Out : $filename     = PATHINFO_FILENAME  (processed)
** Out : $extension    = PATHINFO_EXTENSION (processed)
**
** Return : 0=OK, 1=NOT-OK
*/
function convert_name($fullpath, $addtimestamp, $truncsize, &$filename, &$extension){
    global $msgstr;
    $filename="";
    $extension="";
    if ($fullpath=="") return 0;
    $time_sep="__";
    $replacechar= "_";
    /*
    ** Detect most probable filename encoding:
    ** Set the detection order. Not the default PHP (is too simple)
    ** Order is important: UTF must be before ISO !!
    ** No way to distinguish mechanically ISO and Windows-1252
    */
    $ary[] = "ASCII";
    $ary[] = "UTF-8";
    $ary[] = "ISO-8859-1";
    mb_detect_order($ary);
    $name_encoding = mb_detect_encoding($fullpath,null,true);
    if ($name_encoding===false) {
        echo "<div style='color:red'>".$msgstr["dd_filnamerrenc"]." &rarr;".$fullpath."&larr;</div>";
        return 1;
    }
    /*
    ** Filename cleanup is necessary to cope with restrictions:
    **  - It should be possible to use the name in an url
    **  - It should be possible to move information from windows to linux and vv.
    ** Cleanup of the name : to lower case
    */
    $fullpath =  mb_strtolower($fullpath,$name_encoding);
    /*
    ** Note that filenames may occur in the
    ** - "path component"of the URI  : Requires name_encoding or substitution
    ** - "query component" of the URI: This can be encoded by PHP function: htmlspecialchars. No action here
    ** From rfc 3986: "reserved" characters. Protected from normalization and 
    ** safe to be used for delimiting data subcomponents within a URI
    ** - reserved gen-delims/sub-delims            ==> : / ? # [ ] @ ! $ & ' ( ) * + , ; =
    ** - windows filename restrictions             ==>   / ?                     *         " \ < > |
    ** - linux filename restrictions               ==>   /
    ** Other characters that upset this script. (Marked !! if general filename rules also advise against usage)
    ** !!space upsets uri check in tika            ==>
    ** - Circumflex Accent upsets redirect(windows)==> ^
    ** !!Backtick upsets redirect (Linux)          ==> `
    ** !!Percent upsets (links,redirect)           ==> %
    ** ==> None of the characters above should appear in filenames
    ** From rfc 3986: unreserved chars    ==> A-Z a-z 0-9 - . _ ~
    */
    // Replace gen-delims/subdelims
    $fullpath = mb_ereg_replace("[:/\?#\[\]@!$&'\(\)\*\+,;=]",$replacechar,$fullpath);
    // Replace windows restrictions (includes Linux)
    $fullpath = mb_ereg_replace("[\"\\<>\|]",$replacechar,$fullpath);
    // Replace space
    $fullpath = mb_ereg_replace(" ",$replacechar,$fullpath);
    // Replace Circumflex accent
    $fullpath = mb_ereg_replace("\^",$replacechar,$fullpath);
    // Replace backtick
    $fullpath = mb_ereg_replace("\`",$replacechar,$fullpath);
    // Replace %. Percent encoded space is done extra. Others not
    $fullpath = mb_ereg_replace("%20",$replacechar,$fullpath);
    $fullpath = mb_ereg_replace("%",$replacechar,$fullpath);
  
    // Replace all non-unreserved : No. Gives wrong effect !
    //$fullpath = mb_ereg_replace("[^a-z0-9\-._~]","-",$fullpath);echo "4&rarr;".$fullpath."<br>";
    /*
    ** Function path_info is used to extract the desired components.
    ** Function is locale aware: to parse a path with multibyte characters, the matching locale must be set
    */
    $orglocale=setlocale(LC_CTYPE, 0);
    setlocale(LC_CTYPE, 'C.'.$name_encoding);
    $path_parts  = pathinfo($fullpath);
    setlocale(LC_CTYPE, $orglocale);
    $filename     = $path_parts['filename'];
    if (isset($path_parts['extension'])) $extension = $path_parts['extension'];
    
    // truncate before adding the timestamp 
    if ( $truncsize!="" ) {
        $itruncsize=intval($truncsize);
        if( mb_strlen($filename,$name_encoding)> $itruncsize) {
            $filename=mb_substr($filename,0,$itruncsize,$name_encoding);
        }
    }
    if ($addtimestamp==1) {
        // Add timestamp. Time is in seconds, date is larger but readable
        // Time format = "ymdHis" (default, always a unique filename even if truncated to 0)
        // Time format = "His" if filename >5 characters. Assumed sufficient uniqueness
        $timeformat="ymdHis";
        if( mb_strlen($filename,$name_encoding)>5)$timeformat="His";
        $filename=$filename.$time_sep.date($timeformat);
    }
    return(0);
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
** IN : $full_path  = Full filename in ABCDImportRepo
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
// ====== split_html =============================
function split_html($tikafile, $textmode, $c_title, $splittarget, &$split_files) {
/*
** Splits the given (html) file into smaller parts
** Controlled by the database recordsize.
** In : $tikafile   = Source file name generated by tika
** In : $textmode   = Indicator for tika: m=meta, t=text, h=html, x=xhtml
** In : $c_title    = Title extracted by tika. May be ""
** In : $isis_record_size = maximum size of isisrecord
** IN : $splittarget= Percentage of recordsize as target of the split chunk size..
** Out: $split_files= Array with the names of the resulting files
*/
    global $cisis_ver, $msgstr, $isis_record_size;
    /*
    ** Before creating the database record the html filesize & database recordsize are shown
    */
    $c_htmlfilesize=filesize($tikafile);
    $pretty_cisis_recsize=number_format($isis_record_size/1024,2,",",".")." Kb";
    $pretty_html_filesize=number_format($c_htmlfilesize/1024,2,",",".")." Kb";
    echo "<li>".$msgstr["dd_htmlfilesize"]." ".$pretty_html_filesize.". ".$msgstr["dd_recordsize"]." ".$pretty_cisis_recsize."</li>";
    ob_flush();flush();
    $maxsize     = $isis_record_size*$splittarget/100; //splittarget is a percentage
    if ($maxsize<1000) {// Just in case  a corrupt value is supplied
        echo "<span style='color:red'>PROGRAM ERROR:variable maxsize=$maxsize : too small to be credible</span>";die;
    }
    if (intval($c_htmlfilesize) < $maxsize) {
        // no split required
        $split_files[]=$tikafile;
        return(0);
    }
    /*
    ** Split the file into chunks
    ** Set variables required during the split
    */
    $path_parts  = pathinfo($tikafile);
    $chunkfixfil = $path_parts['dirname'].'/'.$path_parts['filename'].'_'; // filename without chunknr
    $chunkfixext = '.'.$path_parts['extension'];
    $chunknr     = 1;
    $chunkisopen = false;
    $chunkexceed = false;
    $partsheader = "<table style='color:green;font-size:150%;font-weight:bold;' border=1 width=100%>";
    $partsheader.= "<tr><td>".$msgstr["dd_partnr"];
    $partstrailer= "</td></tr></table><br>";
    $pretty_targetsize=number_format($maxsize/1024,2,",",".")." Kb";
    echo "<li>".$msgstr["dd_splitting"]."&nbsp;".$pretty_targetsize."</li>";
    ob_flush();flush();
    
    if(($handle = fopen($tikafile, "r"))===false) {
        return(1);
    }
    while (!feof($handle)) { // main loop over all lines of the source file
        if ( !$chunkexceed    ) $thisline = fgets($handle); // get line contents 
        // Some lines can be skipped
        if ( $thisline==""    ) continue; //skip empty line
        if ( $thisline=="\n"  ) continue; //skip empty line
        if ( $thisline=="\r\n") continue; //skip empty line
        if ( strpos($thisline,"<html")      !==false) continue; //skip html tag
        if ( strpos($thisline,"<meta name=")!==false) continue; //tika generates many of these, valid ones already processed before
        // Some lines need adjustment for html
        if ( $textmode=='h') {
            $thisline = str_ireplace('<p/>' , '<br>', $thisline);//tika generates invalid tag <p/> (windows)
            $thisline = preg_replace('/\t/' , ' '   , $thisline);//tika keeps too much spaces (linux,windows)
            $thisline = preg_replace('/  +/', ' '   , $thisline);//tika keeps too much spaces (linux,windows)
        }
        // Check if a file is opne to write to
        if ( $chunkisopen==false ) {
            // open the chunkfile and write a header
            $chunkactfile= $chunkfixfil.$chunknr.$chunkfixext;
            $chunkhandle = fopen($chunkactfile, "w");
            $split_files[]=$chunkactfile;
            $chunkisopen = true;
            $chunksize   = 0;
            $chunksize+=fwrite($chunkhandle,"<!DOCTYPE HTML>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,"<html>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,"<header>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,"<title>".$c_title." #".$chunknr."</title>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,"</header>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,"<body>".PHP_EOL);
            $chunksize+=fwrite($chunkhandle,$partsheader."&nbsp;".$chunknr.$partstrailer.PHP_EOL);
            $chunknr++;
        }
        // If the chunksize approaches the limit. Take care if over the safety limit
        if ($chunksize > $maxsize) {
            // Check for exceeding the recordsize
            $thislinelen  = strlen($thisline);
            $chunkexceed  = false;
            if ( ($chunksize + $thislinelen) >= $isis_record_size){
                $chunkexceed=true;
            }
            // Check for  "</div>" at the end of the line
            $thistestline = trim($thisline,PHP_EOL);
            $divendfound  = false;
            if (strlen($thistestline)>=6){
                $divendfound = stripos($thistestline,"</div>",-6);
            }
            /*
            ** Close the file if there is a good reason
            ** Over recordsize OR Text mode is "t"  OR </div> found
            */
            if ($chunkexceed OR $textmode=='t' OR $divendfound!==false) {
                // write the current line before closing the chunk if there is space left
                if (!$chunkexceed) {
                    $chunksize+=fwrite($chunkhandle,$thisline);
                }
                fclose($chunkhandle);
                $chunkisopen=false;
                $pretty_filesize=number_format(filesize($chunkactfile)/1024,2,",",".")." Kb";
                echo "<li>".$msgstr["dd_partnr"]." ".($chunknr-1)." ".$msgstr["dd_size"]." ".$pretty_filesize."</li>";
                ob_flush();flush();
                continue;
            }
        }
        $chunksize+=fwrite($chunkhandle,$thisline);
        $chunkexceed=false;
    }
    $pretty_filesize=number_format(filesize($chunkactfile)/1024,2,",",".")." Kb";
    echo "<li>".$msgstr["dd_partnr"]." ".($chunknr-1)." ".$msgstr["dd_size"]." ".$pretty_filesize."</li>";
    ob_flush();flush();
    fclose($handle);
    unlink($tikafile); // original no longer needed
    return(0);
}
// ======================= End functions/End =====
