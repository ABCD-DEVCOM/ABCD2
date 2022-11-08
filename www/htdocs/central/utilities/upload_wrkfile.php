<?php
/* Modifications
20210516 fho4abcd Created from upload_myfile.php
20210914 fho4abcd Improved error message display&handling in case of upload errors
20211215 fho4abcd Backbutton by included file
20211216 fho4abcd Backbutton by included file improved
20220201 fho4abcd Repair upload, translate strings, new style buttons, improve back
*/
/*
** Upload a file from the users environment into the working area of the ABCD base
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
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$contents_error= error_get_last();
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
$backtoscript=$backtoscript."?backtoscript=".$backtoscript;
$inframe=1;                      // The default runs in a frame
$uplwrk_cnfcnt=0;
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["uplwrk_cnfcnt"])) $uplwrk_cnfcnt=$arrHttp["uplwrk_cnfcnt"];
if ( !isset($arrHttp["base"])) $arrHttp["base"]=""; // In case of upload errors destroying this option
$wrk="wrk";
$wrkfull=$db_path.$wrk;
$OK=" &rarr; OK";
$NOT_OK=" &rarr; <b><font color=red>NOT OK</font></b>";
?>
<body>
<script language=javascript src="../dataentry/js/lr_trim.js"></script>
<script language=javascript>
var win
function Upload(){
	document.uplwrk_continuar.uplwrk_cnfcnt.value='2';
	document.getElementById('preloader').style.visibility='visible'
	document.uplwrk_continuar.submit()
}
function Reselect(){
	document.uplwrk_continuar.uplwrk_cnfcnt.value='0';
    document.uplwrk_continuar.action='../utilities/upload_wrkfile.php?&backtoscript=<?php echo $backtoscript?>'
	document.getElementById('preloader').style.visibility='visible'
	document.uplwrk_continuar.submit()
}
function Continue(){
    document.uplwrk_continuar.action='<?php echo $backtoscript;?>'
	document.uplwrk_continuar.submit()
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1 or $arrHttp["base"]=="") include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["mantenimiento"].": ".$msgstr["uploadfile"];?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
    <?php if ($inframe!=1) include "../common/inc_home.php";?>
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
    <div align=center><h3><?php echo $msgstr["uploadfile"] ?></h3>

<?php
if ($uplwrk_cnfcnt<=0) {  /* - First screen: Select the iso file -*/
?>
    <form name=uplwrk_continuar action='../utilities/upload_wrkfile.php' method=POST enctype='multipart/form-data'>
    <?php
            if (isset($arrHttp["backtoscript_org"]))
                echo "<input type=hidden name=backtoscript_org value='".$arrHttp["backtoscript_org"]."' >";
    ?>
    <input type=hidden name=base value='<?php echo $arrHttp["base"];?>'>
    <input type=hidden name=uplwrk_cnfcnt value=''>
    <input type=hidden name=inframe value='<?php echo $inframe?>'>
    <input type=hidden name=backtoscript value='<?php echo $backtoscript?>'>
    <table bgcolor=#eeeeee>
        <tr>
            <td><?php echo $msgstr["storein"];?></td>
            <td>&nbsp;<?php echo $wrk;?></td>
        </tr>
         <tr>
            <td><?php echo $msgstr["upload_overwrite"]?></td>
            <td><input type=checkbox name=overwrite></td>
        </tr>
       <tr>
            <td><?php echo $msgstr["selfile"]."(s) ";?></td>
            <td><input name=userfile[] type=file size=50 multiple></td>
        </tr>
    </table>
    <br>
        <a href="javascript:Upload()" class="bt bt-blue" title='<?php echo $msgstr["subir"]?>'>
        <i class="fas fa-file-upload"></i>&nbsp;<?php echo $msgstr["subir"];?></a>
    </form>
<?php
    // Check that wrk exists and is writable
    if ( !file_exists($wrkfull) ) {
        echo $NOT_OK." : ".$wrkfull." ".$msgstr["ne"];
        die;
    } else if (!is_dir($wrkfull) ) {
        echo $NOT_OK." : ".$wrkfull." is not a folder";
        die;
    } else if (!is_writable($wrkfull) ) {
        echo $NOT_OK." : Folder ".$wrkfull." is not writable";
        die;
    }
}
else if ($uplwrk_cnfcnt==2)
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
        ?>
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=4 >
        <tr><th><?php echo $msgstr["archivo"];?></th>
            <th><?php echo $msgstr["type"];?></th>
            <th><?php echo $msgstr["upload_size"];?></th>
            <th><?php echo $msgstr["upload_status"];?></th>
        </tr>
        <?php
        $numerrors=0;
        for ($i = 0; $i < $filecount; $i++) {
            $uploaderror=$myfiles["error"][$i];
            $uploaderrortxt="";
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            // sanitation done twice (see rest of code)
            $selname=basename($myfiles["name"][$i]);
            if ($selname!="") {
            $savname =  str_replace(" ", "_",strtolower($selname));
            $savname =  str_replace("%", "_", $savname);
            $savname =  str_replace("&", "_", $savname);
            $savname =  str_replace("'", "_", $savname);
            $savname =  str_replace("\"", "_", $savname);
            if ( file_exists($wrkfull."/".$savname) ) {
                if ( isset($arrHttp["overwrite"])  ) {
                    $uploaderrortxt.="<font color=blue>";
                } else {
                    $numerrors++;
                    $uploaderrortxt.="<font color=red>";
                }
                $uploaderrortxt.="Duplicate.";
                $uploaderrortxt.="</font>";
            }
            }
            if ( $uploaderror!=0 ) {
                $numerrors++;
                $uploaderrortxt.="<font color=red>";
                $uploaderrortxt.=$phpFileUploadErrors[$uploaderror];
                $uploaderrortxt.="</font>";
            }
            ?>
            <tr><td bgcolor=white><?php echo $myfiles["name"][$i];?></td>
                <td bgcolor=white><?php echo $myfiles["type"][$i];?></td>
                <td bgcolor=white align=right><?php echo number_format($myfiles["size"][$i],0,',','.');?></td>
                <td bgcolor=white align=right><?php echo $uploaderrortxt;?></td>
            </tr>
            <?php
        }
        echo "</table><br>";
        if ( $numerrors>0) {
            echo "<div><font color=red><b>$numerrors error(s). Upload incomplete</b></font></div><br>";
        }
        echo "<div><font color=blue>Moving files to $wrk...</font><br>";
        $moved=0;
        for ($i = 0; $i < $filecount; $i++) {
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            // sanitation must match with sanitation above
            $selname = basename($myfiles["name"][$i]);
            $savname =  str_replace(" ", "_",strtolower($selname));
            $savname =  str_replace("%", "_", $savname);
            $savname =  str_replace("&", "_", $savname);
            $savname =  str_replace("'", "_", $savname);
            $savname =  str_replace("\"", "_", $savname);
            // Remove possible duplicate first (if allowed)
            if ( file_exists($wrkfull."/".$savname)  and isset($arrHttp["overwrite"])) {
                $result=@unlink($wrkfull."/".$savname);
                if ($result==false) {
                    $contents_error= error_get_last();
                    echo $NOT_OK." : ".$contents_error["message"]."<br>";
                }
            }
            if ( !file_exists($wrkfull."/".$savname) ) {
                if ($myfiles["error"][$i] == UPLOAD_ERR_OK) {
                    $tmp_name = $myfiles["tmp_name"][$i];
                    $result=@move_uploaded_file($tmp_name, "$wrkfull/$savname");
                    if ($result==false) {
                        $contents_error= error_get_last();
                        echo $NOT_OK." : ".$contents_error["message"]."<br>";
                    } else {
                        echo $msgstr["saved"].": $selname &nbsp;&rarr;&nbsp; $wrk/$savname<br>";
                        $moved++;
                    }
                }
            }
        }
         echo "</div><div><font color=blue>$moved files moved</font><br></div>";
        ?>
        <div><br>
        <form name=uplwrk_continuar action='../utilities/upload_wrkfile.php' method=POST>
    <?php
            if (isset($arrHttp["backtoscript_org"]))
                echo "<input type=hidden name=backtoscript_org value='".$arrHttp["backtoscript_org"]."' >";
    ?>
            <input type=hidden name=base value='<?php echo $arrHttp["base"];?>'>
            <input type=hidden name=uplwrk_cnfcnt value=''>
            <input type=hidden name=inframe value='<?php echo $inframe?>'>
            <a href="javascript:Reselect()" class="bt bt-gray" title='<?php echo $msgstr["selfile"]?>'>
                <i class="fas fa-arrow-alt-circle-left"></i>&nbsp;<?php echo $msgstr["selfile"];?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="javascript:Continue()" class="bt bt-green" title='<?php echo $msgstr["continuar"]?>'>
                <i class="fas fa-forward"></i>&nbsp;<?php echo $msgstr["continuar"];?></a>
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
?>
