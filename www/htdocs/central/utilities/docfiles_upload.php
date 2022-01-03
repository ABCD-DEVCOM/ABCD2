<?php
/* Modifications
20210807 fho4abcd Created from upload_myfile.php
20210914 fho4abcd Improved error message display&handling in case of upload errors
20211105 fho4abcd No filename sanitation: will be done by import script (admin may upload via backdoor, so import must do it again)
20211111 fho4abcd set locale (required by basename)
20211215 fho4abcd Backbutton by included file
20211230 fho4abcd new names standard subfolders
*/
/*
** Upload a file from the users environment into the digital document area of ABCD
** This area is specified in dr_path.def in parameter COLLECTION and has structure
** .../<collection>/ImportRepo/[<section>/]<uploaded_doc>
**                 /SourceRepo/[<section>/]<converted_doc>.html
**                 /DocRepo/[<section>/][<subsection>/]<imported_doc>
** This upload function loads in ImportRepo and ImportRepo/<section>
** <section> may be a tree of subfolders.
** COLLECTION must exist. The other folders are created by this script if necessary
** Further processing of the file is done by other functions
** The "multiple" keyword is html5 (support by firefox&chrome&...)
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
$contents_error= error_get_last();
$backtoscript="../dataentry/inicio_main.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$upldoc_cnfcnt=0;
if ( isset($arrHttp["backtoscript"]))  $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))       $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["upldoc_cnfcnt"])) $upldoc_cnfcnt=$arrHttp["upldoc_cnfcnt"];
if ( !isset($arrHttp["base"])) $arrHttp["base"]=""; // In case of upload errors destroying this option
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;
?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script language=javascript>
var win
function Upload(){
	document.upldoc_continuar.upldoc_cnfcnt.value='2';
	document.getElementById('preloader').style.visibility='visible'
	document.upldoc_continuar.submit()
}
function Reselect(){
	document.upldoc_continuar.upldoc_cnfcnt.value='0';
    document.upldoc_continuar.action='../utilities/docfiles_upload.php?&backtoscript=<?php echo $backtoscript?>'
	document.getElementById('preloader').style.visibility='visible'
	document.upldoc_continuar.submit()
}
function Cancel(){
    document.upldoc_continuar.action='<?php echo $backtourl;?>'
	document.upldoc_continuar.submit()
}
function DocfilesImport(){
    document.upldoc_continuar.action='../utilities/docfiles_import.php?&backtoscript=<?php echo $backtoscript?>'
	document.getElementById('preloader').style.visibility='visible'
	document.upldoc_continuar.submit()
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1 or $arrHttp["base"]=="") include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["mantenimiento"].": ".$msgstr["dd_upload"];?>
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
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <?php
    if ($contents_error!="") {
        echo "<br><b style='color:red'>".$msgstr["fatal"].": &rarr; </b>".$contents_error["message"];
        echo "<br>".$msgstr["upload_conf_errmsg"];
        echo "<br>-- ".$msgstr["upload_exceed"]." 'post_max_size' (= ".ini_get('post_max_size').") ?";
        echo "<br>-- ".$msgstr["upload_exceed"]." 'upload_max_filesize' (= ".ini_get('upload_max_filesize').") ?";
        echo "<br>-- ".$msgstr["upload_exceed"]." 'max_file_uploads' (= ".ini_get('max_file_uploads').") ?";
        echo "<br><br><b style='color:red'>".$msgstr["upload_logout"]."</b>";
        echo "</div></div>";
        die;
    }
    ?>
    <div align=center><h3><?php echo $msgstr["dd_upload"] ?></h3>

<?php
// Set collection related parameters and create folders if not present
include "../utilities/inc_coll_chk_init.php";


/* ----- First screen: Select the doc file -*/
if ($upldoc_cnfcnt<=0) {
    // Populate the section list
    // Sections are subfolders of the collection, recursive and without the standard foldernames
    include "../utilities/inc_list-folder.php";
    $fileList=array();
    $retval = list_folder("folders", $fullcolpath, $fileList);
    if ($retval!=0) die;
    // Construct the html datalist, used as dropdown for the input of a section
    echo "<datalist id='sections'>";
    for ($i=0; $i<count($fileList);$i++){
        $section=$fileList[$i];
        // strip leading path + slash, so we have only the sub(/sub..) folder name
        $section=substr($section,strlen($fullcolpath)+1);
        echo "<option>".$section."</option>";
    }
    echo "</datalist>";
?>
    <form name=upldoc_continuar action='../utilities/docfiles_upload.php' method=POST enctype='multipart/form-data'>
    <input type=hidden name=base value='<?php echo $arrHttp["base"];?>'>
    <input type=hidden name=upldoc_cnfcnt value=''>
    <input type=hidden name=inframe value='<?php echo $inframe?>'>
    <input type=hidden name=backtoscript value='<?php echo $backtoscript?>'>
    <table bgcolor=#eeeeee>
        <tr>
            <td><?php echo $msgstr["storein"];?></td>
            <td>&nbsp;<?php echo $colupl;?></td>
        </tr>
        <tr>
            <td><?php echo $msgstr["dd_section"];?></td>
            <td><input name='section' type="text" list="sections" style="background-color:white" title='<?php echo $msgstr["dd_sectionhlp"]?>'><td>
        </tr>
         <tr>
            <td><?php echo $msgstr["dd_overwrite"];?></td>
            <td><input type=checkbox name=overwrite></td>
        </tr>
       <tr>
            <td><?php echo $msgstr["selfile"]."(s) ";?></td>
            <td><input name=userfile[] type=file size=50 multiple></td>
        </tr>
    </table>
    <br>
    <input type=submit value=<?php echo $msgstr["subir"];?> onclick=Upload()>
    </form>
<?php
}
/* ----- Second screen: Process uploaded files -*/
else if ($upldoc_cnfcnt==2)
{
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    $filecount=0;
    if (isset($_FILES['userfile'])) $myfiles = $_FILES['userfile'];
    if (isset($myfiles)) $filecount = count($myfiles["name"]);
    if ( $filecount>0 ) { // if no files uploaded the first entry gives error 4
        // The destination in the collection is ABCDImportRepo or a subfolder indicated by the section
        // If a section is specified the name must be valid folder name and this subfolder must be created
        $section="";
        $fullsectionpath=$coluplfull;
        if( isset($arrHttp["section"]) && $arrHttp["section"]!="" ) {
            $section=$arrHttp["section"];
            $section=rtrim($section,"/ ");
            $section=ltrim($section,"/ ");
            $section=str_replace(" ","_",$section);
            $fullsectionpath=$coluplfull."/".$section;
            if (! file_exists($fullsectionpath)) {
                $result=@mkdir($fullsectionpath,0700,true);
                if ($result === false ) {
                    $file_get_contents_error= error_get_last();
                    $err_mkdir="&rarr; ".$file_get_contents_error["message"];
                    echo "<div style='font-weight:bold;color:red'>".$msgstr["dd_sectionfoldererr"]." '".$fullsectionpath."' ".$err_mkdir."</div>";
                    die;
                }
            }
        }

        ?>
        <!--<table  bgcolor=#e7e7e7 cellspacing=1 cellpadding=4 border=0>-->
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=4 >
            <tr><th><?php echo $msgstr["archivo"];?></th>
                <th><?php echo $msgstr["type"];?></th>
                <th><?php echo $msgstr["dd_size"];?></th>
                <th><?php echo $msgstr["dd_status"];?></th>
            </tr>
<?php
        $numerrors=0;
        $orglocale=setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C.UTF-8');
        for ($i = 0; $i < $filecount; $i++) {
            $uploaderror=$myfiles["error"][$i];
            $uploaderrortxt="";
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            // but not done here (done again in import)
            $selname=basename($myfiles["name"][$i]);
            if ($selname!="") {
                if ( file_exists($coluplfull."/".$selname) ) {
                    if ( isset($arrHttp["overwrite"])  ) {
                        $uploaderrortxt.="<span style='color:blue'>";
                    } else {
                        $numerrors++;
                        $uploaderrortxt.="<span style='color:red'>";
                    }
                    $uploaderrortxt.=$msgstr["dd_duplicate"];
                    $uploaderrortxt.="</span>";
                }
            }
            if ( $uploaderror!=0 ) {
                $numerrors++;
                $uploaderrortxt.="<span style='color:red'>";
                $uploaderrortxt.=$phpFileUploadErrors[$uploaderror];
                $uploaderrortxt.="</span>";
            }
            ?>
            <tr><td bgcolor=white><?php echo $myfiles["name"][$i];?></td>
                <td bgcolor=white><?php echo $myfiles["type"][$i];?></td>
                <td align=right bgcolor=white><?php echo number_format($myfiles["size"][$i],0,',','.');?></td>
                <td align=right bgcolor=white><?php echo $uploaderrortxt;?></td>
            </tr>
<?php
        }
        setlocale(LC_CTYPE, $orglocale);
        ?>
        </table><br>
        <?php
        if ( $numerrors>0) {
            echo "<div style='color:red'><b>$numerrors error(s). Upload incomplete</b></div><br>";
        }
        // Files are uploaded in the temp folder of the server and must be moved to the collection
        // In the subfolder given by the section
        ?>
        <div style='color:blue'><?php echo $msgstr["dd_movingfiles"]." ".$colupl." ..."?><br></div>
        <div>
        <?php
        $moved=0;
        $orglocale=setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C.UTF-8');
        for ($i = 0; $i < $filecount; $i++) {
            $movemsg="";
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            // sanitation must match with sanitation above
            $selname = basename($myfiles["name"][$i]);
            // Remove possible duplicate first (if allowed)
            if ( file_exists($fullsectionpath."/".$selname)  and isset($arrHttp["overwrite"])) {
                $result=@unlink($fullsectionpath."/".$selname);
                if ($result==false) {
                    $contents_error= error_get_last();
                    $movemsg.= "<span style='color:red'>";
                    $movemsg.= $msgstr["dd_notok"]." : ".$contents_error["message"];
                    $movemsg.= "<br></span>";
                }
            }
            if ( !file_exists($fullsectionpath."/".$selname) ) {
                if ($myfiles["error"][$i] == UPLOAD_ERR_OK) {
                    $tmp_name = $myfiles["tmp_name"][$i];
                    $result=@move_uploaded_file($tmp_name, "$fullsectionpath/$selname");
                    if ($result==false) {
                        $contents_error= error_get_last();
                        $movemsg.=  "<span style='color:red'>";
                        $movemsg.= $msgstr["dd_notok"]." : ".$contents_error["message"];
                        $movemsg.=  "<br></span>";
                    } else {
                        $movemsg.= "$tmp_name &nbsp;&rarr;&nbsp; $colupl/$section/$selname";
                        $movemsg.= "<br>";
                        $moved++;
                    }
                }
            }
            if ($movemsg!="") {
            ?>
                <span><?php echo $movemsg;?></span>
            <?php
            }
        }
        setlocale(LC_CTYPE, $orglocale);
        ?>
        </div>
        <div style='color:blue'><?php echo $moved." ".$msgstr["dd_filesmoved"]?> <br></div>
        <div><br>
        <form name=upldoc_continuar action='../utilities/docfiles_upload.php' method=POST>
            <input type=hidden name=base value='<?php echo $arrHttp["base"];?>'>
            <input type=hidden name=upldoc_cnfcnt value=''>
            <input type=hidden name=inframe value='<?php echo $inframe?>'>
            <input type=button value='<?php echo $msgstr["selfile"];?>' onclick=Reselect()>
            &nbsp;&nbsp;&nbsp;
            <input type=button value='<?php echo $msgstr["cancel"];?>' onclick=Cancel()>
            &nbsp;&nbsp;&nbsp;
            <?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;
            <input type=button value='<?php echo $msgstr["dd_batchimport"];?>' onclick=DocfilesImport()>
        </form>
        </div>
        <?php
    }
}
?>
</div>
</div>
</div>
<?php
include "../common/footer.php";

