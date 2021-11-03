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
var win;
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
}
function OpenWindows() {
    NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
    win.focus()
}
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);
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
<?php 
        echo $msgstr["maintenance"].": ".$arrHttp["base"];
?>
	</div>
	<div class="actions">
<?php
        $backtourl=$backtoscript."?base=".$arrHttp["base"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
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
    echo "<h3><font color=red>".$fullciparpath.": does not exist</font></h3>";
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
    <form name=maintenance action='' method='post' onsubmit='OpenWindows();'>
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

    <tr> <td><?php echo $msgstr["useslashm"];?></td>
         <td><input type='checkbox' name='slashm'></td>
         <td><font color=red><?php echo $msgstr["warnforslashm"];?></font></td>
    </tr>

    <tr> <td><?php echo $msgstr["incremental"];?></td>
         <td><input type='checkbox' name='incr'></td>
         <td><font color=blue><?php echo $msgstr["warnforincr"];?></font></td>
    </tr>

    <?php if ($htmlfiletag!="") { ?>
    <tr> <td><?php echo $msgstr["striphtml"];?></td>
         <td><select name='ftt[]' multiple size='2'>
                <option value='<?php echo $htmlfiletag;?>' selected><?php echo $htmlfileTitle." (v".$htmlfiletag.")";?></option>
                <option value='' ></option>
             </select>
         </td>
         <td><font color=blue><?php echo $msgstr["warnforstrip"]."<br>".$msgstr["sourceis"]." ".$msgstr["dd_documents"];?></font></td>
    </tr>
    <?php } ?>
    <?php if (count($htmlTags)>0) {?>
    <tr> <td><?php echo $msgstr["striphtml"];?></td>
         <td><select name='fdttag[]' multiple size='<?php echo count($htmlTags)+1;?>'>
                <?php for ($i=0;$i<count($htmlTags);$i++) {?>
                <option value='<?php echo $htmlTags[$i];?>' selected><?php echo $htmlTitles[$i]." (v".$htmlTags[$i].")";?></option>
                <?php }?>
                <option value='' ></option>
             </select>
          </td>
         <td><font color=blue><?php echo $msgstr["warnforstrip"]."<br>".$msgstr["sourceis"]." FDT";?></font></td>
    </tr>
    <?php } ?>

    <tr><td colspan=3><hr></td></tr>
    <tr><td></td>
        <td><input type='submit' value='<?php echo $msgstr["ejecutar"];?>' title='<?php echo $msgstr["cg_execute"];?>'></td>
        <td><?php echo "$testbutton" ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "$showbutton" ?></td>
    </tr></table></form>


<?php
} else {
    if (!file_exists($cisis_path)){
        echo $cisis_path.": ".$msgstr["misfile"];
        die;
    }
    // Read parameters from par/<basename>.par file.
    // Ensure that the parameter file exists
    $fullciparpath=$db_path."par/".$arrHttp["base"].".par";
    if (!file_exists($fullciparpath)){
        echo "<h3><font color=red>".$fullciparpath.": Does not exist</font></h3>";
    }
    $def_cipar = parse_ini_file($fullciparpath);
    // Default for parameters $actab and $uctab and $stw
    // Note that $actab and $uctab can be valid for ansi, but never for utf-8
    $actab="ansi";
    $uctab="ansi";
    $stw="";
    $stwat="";
    if ($unicode=="utf8"){
        $actab="";  // what about defining it here as 'isisactab_utf8.tab'?
        $uctab="";  // what about defining it here as 'isisuctab_utf8.tab'?
    }
    // Get parameters $actab and $uctab and STW from the .par file.
    // Replace %path_database% by actual value
    // No need to test for existance isisac.tab and isisuc.tab: done by mx
    // WXIS does not allow non-existing stw files. So here we do the same test
    if (isset($def_cipar["isisac.tab"]))$actab=str_replace("%path_database%",$db_path,$def_cipar["isisac.tab"]);
    if (isset($def_cipar["isisuc.tab"]))$uctab=str_replace("%path_database%",$db_path,$def_cipar["isisuc.tab"]);
    if (isset($def_cipar["STW"])){
        $stwfile=str_replace("%path_database%",$db_path,$def_cipar["STW"]);
        if (file_exists($stwfile)) {
            $stw=$stwfile;
            $stwat=" stw=@".$stw;
        }
    }
    // process the entry for the gizmo
    $htmlgizmopar="";
    if ( $htmlfiletag!="") {
        $htmlgizmopar="<span style='color:red'>".$msgstr["error_gizmospec"]." ".$db_path."par/".$base.".par</span>";
        if (isset($def_cipar["htmlgizmo.*"])) {
            $htmlgizmopar=$def_cipar["htmlgizmo.*"];
            $htmlgizmopar1=str_replace("%path_database%",$db_path,$htmlgizmopar);
            if ($htmlgizmopar1!=$def_cipar["htmlgizmo.*"]) {
                $htmlgizmopar="<span style='color:red'>".$msgstr["error_gizmofp"]."</span>";
            }
        }   
    }
    $parameters= "<br>";
    $parameters.= $msgstr["database"]." : ".$bd."/data/".$base."<br>";
    if ($htmlgizmopar!="") $parameters.= "htmlgizmo: $htmlgizmopar<br>";
    $parameters.= "fst&nbsp;&nbsp;: @".$bd."/data/".$base.".fst<br>";
    if ($stw  !="") $parameters.= "stw&nbsp;&nbsp;: @$stw<br>";
    if ($uctab!="") $parameters.= "uctab: $uctab<br>";
    if ($actab!="") $parameters.= "actab: $actab<br>";
    $parameters.= "mx&nbsp;&nbsp;&nbsp;: $mx_path<br>";
    $parameters.= " &nbsp; ".$testbutton;
    $parameters.= " &nbsp; ".$showbutton."<br>";
    // Check that actab and uctab exist (mx gives a bad warning or crashes)
    $numerr=0;
    if ($actab!="" and $actab!="ansi" ) {
        if ( !is_readable($actab) ) {
            echo "<div style='color:red'>".$actab." <b>".$msgstr["notreadable"]."</b></div>";
            echo "<div>".$showbutton."</div>";
            $numerr++;
        }
    }
    if ($uctab!="" and $uctab!="ansi" ) {
        if ( !is_readable($uctab) ) {
            echo "<div style='color:red'>".$uctab." <b>".$msgstr["notreadable"]."</b></div>";
            echo "<div>".$showbutton."</div>";
            $numerr++;
        }
    }

    // Process slashm parameter for omitting positions in postings
    $slashm_var="";
    if (isset($_POST['slashm']) AND strlen($_POST['slashm'])>0) $slashm_var="/m";

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
    */
    $strip_var="";
    if (strlen($htmlfiletag)>0) {
        // The extra quotes surroundig the procs are required for the linux version
        $strip_var.="\"proc='Gload/9876='v".$htmlfiletag."\"";
        $parameters.=$msgstr["load_htmldata"]." ".$htmlfiletag." &rarr; 9876<br>";
    }
    /*
    ** Strip the html tags from the selected fields
    ** Process ftt & fdttag parameters for stripping HTML with gizmo
    ** ftt & fdttag are arrays. Both come from multiselect
    */
    // Digital documents uses the hidden field for the html content
    if (isset($_POST['ftt'])) {
        $taglist=$_POST['ftt'];
        $ftt=$taglist[0];
        if (strlen($ftt)>0) {
            $strip_var.=" \"proc='Ghtmlgizmo,9876'\"";
            $parameters.=$msgstr["striphtml"].": 9876<br>";
        }
    }
    // The fields from the FDT are processed with their own tag
    if (isset($_POST['fdttag']) ) {
        $taglist=$_POST['fdttag'];
        foreach ( $taglist as $tag) {
            if (strlen($tag)>0) {
                $strip_var.=" \"proc='Ghtmlgizmo,".$tag."'\"";
                $parameters.=$msgstr["striphtml"].": ".$tag."<br>";
            }
        }
    }

    // Create command.
    // Note that mx does not extract uctab/actab from cipar: explicitly specified here
    $strINV =$mx_path.' db='.$bd."/data/".$base. " fst=@".$bd."/data/".$fst;
    $strINV.=" cipar=".$fullciparpath;
    $strINV.=" ".$strip_var;
    $strINV.=" uctab=".$uctab." actab=".$actab;
    $strINV.=" ".$stwat;
    $strINV.=" ".$incr_var."=".$bd."/data/".$base." -all now ".$tellvar." 2>&1";
    // execute the command
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo "<font face=courier size=2>".$parameters."<br>".$msgstr["commandline"].": $strINV<br></font><hr>";
        echo ("<h3>".$msgstr["processok"]."</h3>");
        echo "$straux";
    } else {
        echo "<font face=courier size=2>".$parameters."<br>".$msgstr["commandline"].": $strINV<br></font><hr>";
        echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3><hr>");
        echo "<font color='red'>".$straux."</font>";
        if (strpos($straux,"fatal: recread/check/base")>0) {
            echo "<div style='color:blue'>".$msgstr["possiblecause"]." :<br>";
            echo "<b>htmlgizmo.mst</b> ".$msgstr["isnotcreated"]." <b>".$mx_path."</b><br>";
            echo $msgstr["isismustmatch"]."</div>";
        }
   }
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
** Read the configuration data and determine the tag for "htmlSrcFLD"
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
    $metadataConfig="docfiles_metadataconfig.tab";
    $metadataConfigFull=$fullcolpath."/".$metadataConfig;
    if (!file_exists($metadataConfigFull)) return(0);
    $fp=file($metadataConfigFull);
    foreach ($fp as $value){
        $value=trim($value);
        if (trim($value)!=""){
            $table=explode("|",$value);
            if ($table[0]=="htmlSrcFLD" AND isset($table[1]) AND strlen($table[1])>0) {
                $htmlfiletag=$table[1];
                // the values in the table have a leading "v"
                if (($htmlfiletag[0]=='v') or ($htmlfiletag[0]=='V')) {
                    $htmlfiletag=str_replace( 'v','',strtolower($htmlfiletag));
                }
                return(0);
            }
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
    $htmlfileTitle=$msgstr["dd_term_htmlSrcFLD"];
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