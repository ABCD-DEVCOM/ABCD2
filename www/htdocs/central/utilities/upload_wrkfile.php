<?php
/* Modifications
20210516 fho4abcd Created from upload_myfile.php
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
$inframe=1;                      // The default runs in a frame
$uplwrk_cnfcnt=0;
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["uplwrk_cnfcnt"])) $uplwrk_cnfcnt=$arrHttp["uplwrk_cnfcnt"];
$wrk="wrk";
$wrkfull=$db_path.$wrk;
$OK=" &rarr; OK";
$NOT_OK=" &rarr; <b><font color=red>NOT OK</font></b>";
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;
if (isset($arrHttp["backtoscript_org"]))
    $backtourl.="&backtoscript=".$arrHttp["backtoscript_org"];
?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
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
    document.uplwrk_continuar.action='<?php echo $backtourl;?>'
	document.uplwrk_continuar.submit()
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php   echo $msgstr["mantenimiento"].": ".$msgstr["uploadfile"];
        if ($contents_error!="") {
            echo "<br><b><font color=red>".$msgstr["fatal"].": &rarr; </font></b>".$contents_error["message"];
            echo "<br>May be a configuration error for file uploads. ";
            echo "Check log files and php.ini ";
            echo "<br>-- Exceeded 'post_max_size' (= ".ini_get('post_max_size')." ) ?";
            echo "<br>-- Exceeded 'upload_max_filesize' (= ".ini_get('upload_max_filesize')." ) ?";
            echo "<br>-- Exceeded 'max_file_uploads' (= ".ini_get('max_file_uploads')." ) ?";
            die;
        }
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
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
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
            <td>Overwrite existing file?</td>
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
        <table  bgcolor=#e7e7e7 cellspacing=1 cellpadding=4 border=1>
        <tr><th><?php echo $msgstr["archivo"];?></th>
            <th><?php echo $msgstr["type"];?></th>
            <th>Size</th>
            <th>Status</th>
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
            <tr><td><?php echo $myfiles["name"][$i];?></td>
                <td><?php echo $myfiles["type"][$i];?></td>
                <td align=right><?php echo number_format($myfiles["size"][$i],0,',','.');?></td>
                <td align=right><?php echo $uploaderrortxt;?></td>
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
            <input type=button value='<?php echo $msgstr["selfile"];?>' onclick=Reselect()>
            &nbsp;&nbsp;&nbsp;
            <input type=button value='<?php echo $msgstr["continuar"];?>' onclick=Continue()>
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
</body>
</html>