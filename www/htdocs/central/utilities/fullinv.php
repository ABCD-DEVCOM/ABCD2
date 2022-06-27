<?php
/* Modifications
20210304 fho4abcd Replaced helper code fragment by included file
20210304 fho4abcd Move html tags, php code indented and reordered
20210304 fho4abcd Send mx executable to test button. Test button also on first form
20210305 fho4abcd Check process status. Catch error output. Menu as real table. Menu option to control number of standard messages
20210316 fho4abcd Work inside/ouside frame, improved backbutton
20210317 fho4abcd Show correct heading and backbutton for second invocation (was not corect from menu_mantenimiento)
20210409 fho4abcd Read actab,uctab,stw from .par file (no fixed files, equal to incremental update procedure)
20210409          The stw file comes from tag STW (present in many .par files).
20210527 fho4abcd Check existence and permissions uctab&actab. Translations
20210923 fho4abcd option to specify fstfile by URL
20211018 eds added created from vmx_fullinv.php+options for stripHTML, incremental indexing
20211101 fho4abcd Check for digital document+use cipar for gizmo+form layout+defaults to enable processing of "normal" databases
20211103 fho4abcd Enable gizmo for htmlfields+hint if gizmo is wrong+simplify interface
20211108 fho4abcd Show parameters and commandline before processing,replaced wait pop-up by "working". Slashm default checked.
20211110 fho4abcd Reordered commandline parameters, add extra flush at end of page 
20211111 fho4abcd Location of metadataConfig in database root. Allow comment lines
20211122 fho4abcd test actab/uctab/stw files from dbn.par-> <dbpath>/<base>/data -> <dbpath>. + small enhancements
20211123 fho4abcd Show error if lineendings of stw files are not correct (most mx exe's require this)
20211202 fho4abcd Incremental not for Digdoc.Set /m dependent on DigDoc (remove from menu).Tag selection menu from dropdown to checkboxes.
20211202          Improved check and messages for gizmo. Check that tag 9876 is in FST
20211215 fho4abcd Backbutton by included file
20220103 fho4abcd Use relative path for digital documents in stead of full path,othe config file name
20220108 fho4abcd Add home button
20220117 fho4abcd Add blue message if /m is used
20220620 fho4abcd Accept charset=utf-8
*/
/**
 * @desc:      Create database index
 * @author:    Marino Borrero Sánchez, Cuba. marinoborrero@gmail.com
 * @since:     20140203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/importdoc.php");
/*
** Old code might not send specific info.
** Set defaults for the return script and frame info
*/
$backtoscript="../dataentry/administrar.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$presetfstfile="";               // No default fst file
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["fstfile"]))      $presetfstfile=$arrHttp["fstfile"];
?>
<body onunload=win.close()>
<script src=../dataentry/js/lr_trim.js></script>
<script>
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
}
function RemoveSpan(id){
    var workingspan = document.getElementById(id);
    workingspan.remove();
}
</script>

<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
$base=$arrHttp["base"];
$bd=$db_path.$base;

?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["maintenance"].": ".$arrHttp["base"];?>
	</div>
	<div class="actions">
    <?php
    include "../common/inc_back.php";
    include("../common/inc_home.php");
    ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
    <div align=center ><h3><?php echo $msgstr["mnt_gli"]?></h3></div>
<?php
// Ensure that the parameter file exists
$ciparfile=$arrHttp["base"].".par";
$fullciparpath=$db_path."par/".$ciparfile;
if (!file_exists($fullciparpath)){
    echo "<h3 style='color:red'>".$fullciparpath.": ".$msgstr["notreadable"]."</h3>";
}

// Read Digital document data to determine the tag pointing to the html file
// No error if no digital document collection or tag found
get_htmlfiletag($htmlfiletag);

// Read the fdt to determine tags with HTML content
get_htmltags($htmlfiletag,$htmlfileTitle,$htmlTitles,$htmlTags);

// The test button gives the mx_path to the test window
// The show button gives the content of the parameter file
$testbutton=
'<a href="mx_test.php?mx_path='.$mx_path.'" target=testshow onclick=OpenWindow()>'.$msgstr["test"].' MX</a>';
$showbutton=
'<a href="show_par_file.php?par_file='.$fullciparpath.'" target=testshow onclick=OpenWindow()>'.$msgstr["show"].' &lt;dbn&gt;.par</a>';

if(isset($_REQUEST['fst'])) $fst=$_REQUEST['fst'];
if(!isset($fst)) { // The form sets the fst: the first action of this php
?>
    <form name=maintenance action='' method='post' accept-charset=utf-8>
        <input type=hidden name=backtoscript value="<?php echo $backtoscript ?>">
        <input type=hidden name=inframe value="<?php echo $inframe ?>">
    <table cellspacing=5 align=center>
	  <tr> <th colspan=3>
		  <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
          <?php echo $msgstr["adjustparms"];?>
          </th></tr>
      <tr><td><?php echo $msgstr["select"];?> FST </td>
           <td>
    <?php
    echo "<select name='fst'>";

    $handle=opendir($bd."/data/");
    while ($file = readdir($handle)) {
        if ($file != "." && $file != ".." && (strpos($file,".fst")||strpos($file,".FST"))) {
            if ( $file==$presetfstfile) {
                echo "<option selected value='$file'>$file</option>";
            } else {
                echo "<option value='$file'>$file</option>";
            }
        }
    }
    echo "</select>"
    ?>
    </td><td></td></tr>
    <tr> <td><?php echo $msgstr["showexecinfo"];?></td>
         <td><input type='checkbox' name='tell'>
         <td><select name='tellnumber'>
             <option value="10000000"><?php echo $msgstr["minimal"];?></option>
             <option value='1000'><?php echo $msgstr["every"];?> 1000 <?php echo $msgstr["records"];?></option>
             <option value='100'><?php echo $msgstr["every"];?> &nbsp;100 <?php echo $msgstr["records"];?></option>
             <option value='10'><?php echo $msgstr["every"];?> &nbsp;&nbsp;10 <?php echo $msgstr["records"];?></option>
             <option value='1'><?php echo $msgstr["allrecords"];?></option>
        </select></td>
    </tr>

    <?php if ($htmlfiletag=="") { ?>
    <tr> <td><?php echo $msgstr["incremental"];?></td>
         <td><input type='checkbox' name='incr'></td>
         <td></td>
    </tr>
   <?php } ?>

    <?php if ($htmlfiletag!="") { ?>
    <tr><td><?php echo $msgstr["striphtml"];?></td>
        <td>
            <input type='checkbox' name='<?php echo $htmlfiletag;?>' checked> <?php echo $htmlfileTitle." (v".$htmlfiletag.")";?>
        </td>
        <td><font color=blue><?php echo $msgstr["sourceis"]." ".$msgstr["dd_documents"];?></font></td>
    </tr>
    <?php } ?>
    <?php for ($i=0;$i<count($htmlTags);$i++) {?>
    <tr><td><?php echo $msgstr["striphtml"];?></td>
        <td>
            <input type='checkbox' name='<?php echo $htmlTags[$i];?>' checked> <?php echo $htmlTitles[$i]." (v".$htmlTags[$i].")";?>
        </td>
        <td><font color=blue><?php echo $msgstr["sourceis"]." FDT";?></font></td>
    </tr>
    <?php } ?>

    <tr><td colspan=3><hr></td></tr>
    <tr><td></td>
        <td><input type='submit' value='<?php echo $msgstr["ejecutar"];?>' title='<?php echo $msgstr["cg_execute"];?>'></td>
        <td><?php echo "$testbutton" ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "$showbutton" ?></td>
    </tr></table></form>


<?php
} else {
    // This is the second part of this script. The fst is set by the menu
    if (!file_exists($cisis_path)){
        echo $cisis_path.": ".$msgstr["misfile"];
        die;
    }
    // Default for parameters $actab and $uctab and $stw
    $actab="";
    $uctab="";
    $stw="";
    $stwat="";
    // Default filenames for actab/uctab dependent on unicode.
    // These names are defined by history
    $actabdeffile="isisac.tab";
    $uctabdeffile="isisuc.tab";
    if ($unicode=="utf8"){
        $actabdeffile="isisactab_utf8.tab";
        $uctabdeffile="isisuctab_utf8.tab";
    }
    /*
    ** Read parameters from par/<basename>.par file.
    ** The existence of the file is already checked at script start : error message here only an if to prevent many errors
    */
    $fullciparpath=$db_path."par/".$arrHttp["base"].".par";
    if (file_exists($fullciparpath)){
        $def_cipar = parse_ini_file($fullciparpath);
        /*
        ** Get parameters $actab and $uctab and $stw from the .par file.
        ** Replace %path_database% by actual value
        ** The best keywords are actab/uctab but for historical reasons we check first isisac.tab/isisuc.tab
        ** The best keyword for stw is "stw" but for historical reasons we check first STW
        */
        if (isset($def_cipar["isisac.tab"]))$actab=str_replace("%path_database%",$db_path,$def_cipar["isisac.tab"]);
        if (isset($def_cipar["isisuc.tab"]))$uctab=str_replace("%path_database%",$db_path,$def_cipar["isisuc.tab"]);
        if (isset($def_cipar["actab"]))     $actab=str_replace("%path_database%",$db_path,$def_cipar["actab"]);
        if (isset($def_cipar["uctab"]))     $uctab=str_replace("%path_database%",$db_path,$def_cipar["uctab"]);
        if (isset($def_cipar["STW"]))       $stw=str_replace("%path_database%",$db_path,$def_cipar["STW"]);
        if (isset($def_cipar["stw"]))       $stw=str_replace("%path_database%",$db_path,$def_cipar["stw"]);
        /*
        ** Show a non-fatal error if these files do not exist
        */
        if ($actab!="" and !is_readable($actab) ) {
            echo "<div style='color:red'>".$actab." <b>".$msgstr["notreadable"]."</b></div>";
            $actab="";
        }
        if ($uctab!="" and !is_readable($uctab) ) {
            echo "<div style='color:red'>".$uctab." <b>".$msgstr["notreadable"]."</b></div>";
            $uctab="";
        }
        if ($stw!="" and !is_readable($stw) ) {
            echo "<div style='color:red'>".$stw." <b>".$msgstr["notreadable"]."</b></div>";
            $stw="";
        }
    }
    /*
    ** If actab/uctab/stw still empty try the default file in bases/data
    */
    if ($actab=="") {
        $actab=$db_path.$base."/data/".$actabdeffile;
        if (!is_readable($actab) ) {
            echo "<div >".$actab." ".$msgstr["notreadable"]."</div>";
            $actab="";
        }
    }
    if ($uctab=="") {
        $uctab=$db_path.$base."/data/".$uctabdeffile;
        if (!is_readable($uctab) ) {
            echo "<div >".$uctab." ".$msgstr["notreadable"]."</div>";
            $uctab="";
        }
    }
    if ( $stw=="") {
        $stw=$db_path.$base."/data/".$base.".stw";
        if (!is_readable($stw) ) {
            echo "<div >".$stw." ".$msgstr["notreadable"]."</div>";
            $stw="";
        }
    }
    /*
    ** If actab/uctab still empty try the default file in bases
    */
    if ($actab=="") {
        $actab=$db_path.$actabdeffile;
        if (!is_readable($actab) ) {
            echo "<div >".$actab." ".$msgstr["notreadable"]."</div>";
            $actab="";
        }
    }
    if ($uctab=="") {
        $uctab=$db_path.$uctabdeffile;
        if (!is_readable($uctab) ) {
            echo "<div >".$uctab." ".$msgstr["notreadable"]."</div>";
            $uctab="";
        }
    }
    /*
    ** If actab/uctab still empty set ansi
    */
    if ($actab=="") $actab="ansi";
    if ($uctab=="") $uctab="ansi";

    /*
    ** Determine if the gizmo is required
    */
    $gizmorequired=0;
    if ( $htmlfiletag!="") $gizmorequired=1;
    for ($i=0;$i<count($htmlTags);$i++){
        $tag=$htmlTags[$i];
        if (isset($_POST[$tag]) AND strlen($_POST[$tag])>0 ) $gizmorequired=1;
    }
    /*
    ** Process the entry for the gizmo
    */
    $htmlgizmopar="";
    if ( $gizmorequired==1) {
        $htmlgizmoexample ="<br><span style='color:blue'>&nbsp;&nbsp;".$msgstr["examplefor"]." par/".$base.".par &rArr;&nbsp;htmlgizmo.*=";
        $htmlgizmoexample.=$db_path.$base."/data/htmlgizmo.*</span>";
        if (isset($def_cipar["htmlgizmo.*"])) {
            // The .par exists and there is a gizmo entry
            $htmlgizmopar=$def_cipar["htmlgizmo.*"];
            // Check that %path_database% is not used
            $htmlgizmopar1=str_replace("%path_database%",$db_path,$htmlgizmopar);
            if ($htmlgizmopar1!=$def_cipar["htmlgizmo.*"]) {
                $htmlgizmopar="<span style='color:red'>".$msgstr["error_gizmofp"]."</span>";
                $htmlgizmopar.=$htmlgizmoexample;
            }
            // Check that the gizmo mst exists
            else {
                $htmlgizmomst=str_replace(".*",".mst",$htmlgizmopar,$count);
                if ($count==0 OR !file_exists($htmlgizmomst) ) {
                    $htmlgizmopar="<span style='color:red'>".$msgstr["error_gizmodb"]."</span>";
                    $htmlgizmopar.=$htmlgizmoexample;
                }
            }
        } else {
            // The .par does not exist or has no gizmo entry
            $htmlgizmopar="<span style='color:red'>".$msgstr["error_gizmospec"]." ".$db_path."par/".$base.".par</span>";
            $htmlgizmopar.=$htmlgizmoexample;
        }
    }
    $parameters= "<br>";
    $parameters.= $msgstr["database"]." : ".$bd."/data/".$base."<br>";
    if ($htmlgizmopar!="") $parameters.= "htmlgizmo: $htmlgizmopar<br>";
    $parameters.= "fst&nbsp;&nbsp;: @".$bd."/data/".$base.".fst<br>";
    if ($stw  !="") $parameters.= "stw&nbsp;&nbsp;: @$stw<br>";
    if ($actab!="") $parameters.= "actab: $actab<br>";
    if ($uctab!="") $parameters.= "uctab: $uctab<br>";
    $parameters.= "mx&nbsp;&nbsp;&nbsp;: $mx_path<br>";
    $parameters.= " &nbsp; ".$testbutton;
    $parameters.= " &nbsp; ".$showbutton."<br>";

    /*
    ** Process slashm parameter for omitting positions in postings
    ** Not controlled by the menu: Must be set for Digital documents and omitted for all others
    */    
    $slashm_var="";
    if ($htmlfiletag!="") $slashm_var="/m";
    //$slashm_var="/m";
    if ($slashm_var!="") {
        echo "<div style='color:blue'>".$msgstr['inv_slashm']."</div>";
    }
    // Process incr parameter : incremental or full inversion
    $incr_var="";
    if (isset($_POST['incr']) AND strlen($_POST['incr'])>0) $incr_var=" ifupd"; else $incr_var="fullinv".$slashm_var;

    //process tell parameter
    unset ($tell);
    $tellvar="";
    $tellnumbervar="";
    if (isset($_POST['tell'])) $tell=$_POST['tell'];
    if(isset($tell)){
        $tellvar="tell=";
        //process tellnumber parameter
        unset ($tellnumber);
        if (isset($_POST['tellnumber'])) $tellnumber=$_POST['tellnumber'];
        $tellnumbervar="1000000";
        if(isset($tellnumber)) $tellnumbervar=$tellnumber;
    }
    $tellvar.=$tellnumbervar;

    /*
    ** Processing for Digital Documents
    ** The htmlfiletag parameter defines in which field the HTML-file name for Gload is stored.
    ** The HTML filename is an URL: it starts with /docs/.. The load procedure requires a full path
    ** The fst should contain parameter 9876
    */
    $strip_var="";
    if ($htmlfiletag!="") {
        // The extra quotes surrounding the procs are required for the linux version
        $strip_var.='"'."proc='Gload/9876='replace(v".$htmlfiletag.",'/docs/','$db_path')".'"';
        $parameters.=$msgstr["load_htmldata"]." ".$htmlfiletag." &rarr; 9876<br>";
        $fullfst=$bd."/data/".$fst;
        $fstcontent=file_get_contents($fullfst);
        if ( stripos($fstcontent,"v9876") === false) {
            echo "<div style='color:red'>FST ".$fst." ".$msgstr["doesnotcontaintag"]." v9876. ".$msgstr["invertincomplete"]."</div>";
            echo "<div style='color:blue'>".$msgstr["invertloads"]." v".$htmlfiletag." ".$msgstr["intotag"]." v9876</div>";
        }
    }
    /*
    ** Strip the html tags from the selected fields
    ** Controlled by checkboxes
    */
    // Digital documents
    if (isset($_POST[$htmlfiletag]) AND strlen($_POST[$htmlfiletag])>0 ) {
        $strip_var.=" \"proc='Ghtmlgizmo,9876'\"";
        $parameters.=$msgstr["striphtml"].": 9876<br>";
    }
    // The fields from the FDT are processed with their own tag
    for ($i=0;$i<count($htmlTags);$i++){
        $tag=$htmlTags[$i];
        if (isset($_POST[$tag]) AND strlen($_POST[$tag])>0 ) {
            $strip_var.=" \"proc='Ghtmlgizmo,".$tag."'\"";
            $parameters.=$msgstr["striphtml"].": ".$tag."<br>";
        }
    }
    // Check that the lineends fit with the current OS (mx requirement for stw files)
    include "inc_check-line-end.php";
    if ( $stw!="" ) {
        $result=check_line_end($stw);
    }
    echo "<br>";
    /*
    ** Create command for mx.
    ** Note that mx may extract uctab/actab from cipar:
    ** In case cipar uses alternative keywords an explicit value is necessary. Also if the command if copy/pasted
    ** If the internal tables are used actab/uctab are not set: unicode exe's generate an error, ansi exe's don't care
    */
    $strINV =$mx_path;
    $strINV.=" cipar=".$fullciparpath;
    $strINV.=" db=".$bd."/data/".$base;
    $strINV.=" fst=@".$bd."/data/".$fst;
    $strINV.=" ".$strip_var;
    if ($actab!="ansi") $strINV.=" actab=".$actab;
    if ($uctab!="ansi") $strINV.=" uctab=".$uctab;
    if ($stw!="") $strINV.=" stw=@".$stw;
    $strINV.=" ".$incr_var."=".$bd."/data/".$base." -all now ".$tellvar." 2>&1";
    // Show the execution parameters
    //echo "<font face=courier size=2>".$parameters."<br>".$msgstr["commandline"].": $strINV<br></font><hr>";
    ?>
    <font face=courier size=2><?php echo $parameters?><br>
          <?php echo $msgstr["commandline"]?>: <?php echo $strINV?><br></font>
    <hr>
    <span id="working" style="color:red"><b>.... <?php echo $msgstr["system_working"]?> ....</span>
    <?php
    ob_flush();flush();

    // execute the command
    exec($strINV, $output,$status);
    ?>
    <script> RemoveSpan("working");</script>
    <?php
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo ("<h3>".$msgstr["processok"]."</h3>");
        echo "$straux";
    } else {
         echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3><hr>");
        echo "<font color='red'>".$straux."</font>";
        if (strpos($straux,"fatal: recread/check/base")>0) {
            echo "<div style='color:blue'>".$msgstr["possiblecause"]." :<br>";
            echo "<b>htmlgizmo.mst</b> ".$msgstr["isnotcreated"]." <b>".$mx_path."</b><br>";
            echo $msgstr["isismustmatch"]."</div>";
        }
   }
    ob_flush();flush();
}

?>

</div></div>

<?php
include("../common/footer.php");
// ======================================================
// This the end of main script. Only functions follow now
// =========================== Functions ================
//  - get_htmlfiletag   : returns the tag for the html file for digital documents
//  - get_htmltags      : returns the tags with html content from the FDT
//
// ====== get_htmlfiletag =============================
/*
** Check if there is a collection for this database
** Read the configuration data and determine the tag for "htmlSrcURL"
** If nothing is found the returned tag value is empty.
**
** Return : 0=OK, 1=NOT-OK
*/
function get_htmlfiletag(&$htmlfiletag) {
    global $msgstr,$arrHttp, $db_path, $def_db;
    $htmlfiletag="";
    if ( !isset($def_db["COLLECTION"])) return(0);
    $fullcolpath=$def_db["COLLECTION"];
    $fullcolpath=str_replace("%path_database%",$db_path,$fullcolpath);
    $fullcolpath=rtrim($fullcolpath,"/ ");
    if (!file_exists($fullcolpath)) return(0);
    $tagConfig="docfiles_tagconfig.tab";
    $tagConfigFull=$fullcolpath."/".$tagConfig;
    if (!file_exists($tagConfigFull)) return(0);
    $fp=file($tagConfigFull);
    foreach ($fp as $value){
        $value=trim($value);
        // Lines with // and lines with # are skipped
        // Lines that cannot contain valid information are skipped
        if ( strlen($value)<4 ) continue;
        if ( stripos($value,'//') !== false ) continue;
        if ( stripos($value, '#') !== false ) continue;
        $table=explode("|",$value);
        if ($table[0]=="htmlSrcURL" AND isset($table[1]) AND strlen($table[1])>0) {
            $htmlfiletag=$table[1];
            // the values in the table have a leading "v"
            if (($htmlfiletag[0]=='v') or ($htmlfiletag[0]=='V')) {
                $htmlfiletag=str_replace( 'v','',strtolower($htmlfiletag));
            }
            return(0);
        }
    }
    return(0);
}
// ====== get_htmltags =============================
/*
** Reads the current FDT and returns:
** - The Title of the supplied tag for the digitral document html file
** - The Titles and Tags of all fields with Input Type=HTML Area
** Return : 0=OK, 1=NOT-OK
*/
function get_htmltags($htmlfiletag,&$htmlfileTitle,&$htmlTitles,&$htmlTags) {
    global $msgstr,$arrHttp, $db_path, $lang_db;
    $tagindex=1;
    $titleindex=2;
    $inputtypeindex=7;
    $htmlfileTitle=$msgstr["dd_term_htmlSrcURL"];
    $htmlTitles=array();
    $htmlTags=array();
    // Open the language dependent fdt and if not present the default language fdt
    $fdtfile=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
    if (!file_exists($fdtfile)) $fdtfile=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
    $fp=file($fdtfile);
    foreach ($fp as $value){
        $value=trim($value);
        if (trim($value)!=""){
            $table=explode("|",$value);
            if ($table[$inputtypeindex]=="A") {
                $htmlTags[]=$table[$tagindex];
                $htmlTitles[]=$table[$titleindex];
            }
            if ($table[$tagindex]==$htmlfiletag) {
                $htmlfileTitle=$table[$titleindex];
            }
        }
    }
    return(0);
}
// ======================= End functions/End =====