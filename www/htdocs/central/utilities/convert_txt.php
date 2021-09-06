<?php
/* Modified
20210524 fho4abcd Created from 3 convert**.php modules
20210524 fho4abcd Replaced helper code fragment by included file
20210524 fho4abcd Move html tags, php code indented and reordered
20210524 fho4abcd Only files of current database, Preview result, Only rewrite if modified, Error checks
20210524 fho4abcd Check with correct charactersets and correct detection order.
20210524 fho4abcd Files with UTF-8-BOM are recognized. Empty files also allowed (=ascii->no conversion)
*/
/*
** This file can be used to convert the encoding of several text files in a folder and subfolders
** Conversion is not necessary for strict ANSI files (equal in ISO and UTF-8)
** The intrinsic functionality allows any folder.
** In practice the target folders are limited in order to protect the user from unintentional actions.
** This script supports
**  - conversion of textfiles in the database folder and
**  - conversion of language tables for the current language
** Required html variables for this purpose:
** - $arrHttp["targetcode"] : The target encoding: UTF-8 or ISO-8859-1
** - $arrHtpp["function"]  : values: "database","language". 
** - $arrHtpp["base"] : Only for function database: the active database name
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
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../lang/lang.php");
/*
** Set default for the return script
*/
$backtoscript="../dbadmin/menu_mantenimiento.php";
$base="";
$function="";
$targetcode="";
$targetfolder="";
$confirmcount=0;
$extcount=0;
if ( isset($arrHttp["function"]))     $function=$arrHttp["function"];
if ( isset($arrHttp["targetcode"]))   $targetcode=$arrHttp["targetcode"];
if ( isset($arrHttp["base"]))         $base=$arrHttp["base"];
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["extcount"]))     $extcount=$arrHttp["extcount"];
?>
<body onunload=win.close()>
<script src=../dataentry/js/lr_trim.js></script>
<script>
var win
function Preview(){
	document.continuar.confirmcount.value++;
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit()
}

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
win=window.open(mypage,myname,settings);}

</script>

<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php 
        $detail="";
        if ($function=="database") $detail=$base;
        if ($function=="language") $detail=$lang;
        echo $msgstr["maintenance"]." &rarr; ".$msgstr["convert"]." &rarr; ".$detail;
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
<?php include "../common/inc_div-helper.php";
// Check valid values of controlling parameters and set folder to check
if ( $targetcode=="" or ($targetcode!="UTF-8" and $targetcode!="ISO-8859-1") ) {
    echo "<div style='color:red'>Error: Targetcode  '$targetcode' is invalid</div>";
    die;
}
if ($function=="database" ) {
    // check required other option
    if ($base=="") {
        echo "<div style='color:red'>Error: Function $function requires database by parameter 'base'</div>";
        die;
    }
    include "../common/inc_get-dblongname.php";
    $targetfolder=$db_path.$base;
} else if ($function=="language") {
    // Determine the folder of the languages
    if (isset($msg_path) and $msg_path!=""){
        $languageroot=$msg_path;
    } else {
        $languageroot=$db_path;
    }
    $targetfolder=$languageroot."lang/".$lang;
} else {
    echo "<div style='color:red'>Error: Function '$function' must be 'database' or 'langauge'</div>";
    die;
}
if ($targetcode=="UTF-8") {
    $sourcecode="ISO-8859-1";
    $topmsg=$msgstr["convert_txtutf"];
    if ($function=="language") $topmsg=$msgstr["convert_langutf"];
} elseif ($targetcode=="ISO-8859-1") {
    $sourcecode="UTF-8"; 
    $topmsg=$msgstr["convert_txtiso"];
    if ($function=="language") $topmsg=$msgstr["convert_langiso"];
} else {
    echo "<div style='color:red'>Error: Targetcode '$targetcode' must be 'UTF-8' or 'ISO-8859-1'</div>";
    die;
}

// The detection order. Not the default PHP (is too simple)
// Order is important: UTF must be before ISO !!
// No way to distinguish mechanically ISO and Windows-1252
$ary[] = "ASCII";
$ary[] = "UTF-8";
$ary[] = "ISO-8859-1";
mb_detect_order($ary);
// The images to use. Note that < and > fail
$cnvimg="img src='../dataentry/img/setsearch.gif' alt='" .$msgstr["convertclick"]."' title='".$msgstr["convertclick"]."'";
$noaimg="img src='../dataentry/img/noaction.png' alt='" .$msgstr["noaction"]."' title='".$msgstr["noaction"]."'";
$errimg="img src='../dataentry/img/delete_record.gif' alt='" .$msgstr["fatal"]."' title='".$msgstr["fatal"]."'";
$donimg="img src='../dataentry/img/recordvalidation_p.gif' alt='" .$msgstr["okactualizado"]."' title='".$msgstr["okactualizado"]."'";

?>

<div class="middle form">
	<div class="formContent">
    <div align=center ><h4><?php echo $topmsg?></h4></div>
    <div align=center>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
     <table cellspacing=2 cellpadding=2  bgcolor=#eeeeee  >
        <tr bgcolor=white>
            <?php if ($function=="database") { ?>
            <td><?php echo $msgstr["dbn"];?>:</td>
            <td><?php echo $base." (".$arrHttp["dblongname"].")";?></td>
            <?php } else { ?>
            <td><?php echo $msgstr["lang"];?>:</td>
            <td><?php echo $msgstr[$lang];?></td>
            <?php } ?>
        </tr>
        <tr bgcolor=white>
            <td><?php echo $msgstr["folder_name"];?>:</td>
            <td><?php echo $targetfolder;?></td>
        </tr>
        <tr bgcolor=white>
            <td><?php echo $msgstr["detectorder"];?>:</td>
            <td><?php echo implode(", ", mb_detect_order());?></td>
        </tr>
    </table>
    <br>
<?php
// Get an iterator for this folder. Throws an execption when folder does not exist
$iterator  = new RecursiveDirectoryIterator($targetfolder);

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the extensions -*/
    ?>
    <form name=continuar  method=post >
        <input type=hidden name=confirmcount value=0>
        <?php
        if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
        foreach ($_REQUEST as $var=>$value){
            // some values may contain quotes or other "non-standard" values
            $value=htmlspecialchars($value);
            echo "<input type=hidden name=$var value=\"$value\">\n";
        }
        ?>
        <table cellspacing=1 cellpadding=4>
            <tr bgcolor=#eeeeee>
                <th colspan=9 align=center bgcolor=#e7e7e7><?php echo $msgstr["extensions"];?></th>
            </tr>
            <tr>
                <td>def  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="def"  checked></td>
                <td>fdt  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="fdt"  checked></td>
                <td>fmt  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="fmt"  checked></td>
                <td>fst  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="fst"  checked></td>
                <td>html <input type="checkbox" name="ext<?php echo ++$extcount?>" value="html" checked></td>
                <td>pft  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="pft"  checked></td>
                <td>stw  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="stw"  checked></td>
                <td>tab  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="tab"  checked></td>
                <td>xml  <input type="checkbox" name="ext<?php echo ++$extcount?>" value="xml"  checked></td>
            </tr>
            </table>
        <br/>
        <input type=hidden name=extcount value="<?php echo $extcount?>" >
        <input type="submit" value="<?php echo $msgstr["preview"];?>" onclick="javascript:Preview();"/>
    </form>
    <?php
} else if ($confirmcount>0) {  /* - Second screen (=1)(preview) & third screen (=2)(conversion)-*/
    $numconverted=0;
    $numerrors=0;
    // A table with all files with the selected extensions
    ?>
    <table cellspacing=1 cellpadding=1>
        <tr bgcolor=#eeeeee><th><?php echo $msgstr["extension"];?></th>
            <th><?php echo $msgstr["archivo"];?></th>
            <th><?php echo $msgstr["code"];?></th>
            <th><?php echo $msgstr["convertq"];?></th>
        </tr>
    <?php
    for ($i=1; $i<=$extcount;$i++){
        $extensionname= "ext".$i;
        $extension="-";// default no extension set
        if ( isset($arrHttp[$extensionname]) ) {
            $extension=$arrHttp[$extensionname];
        }
        foreach(new RecursiveIteratorIterator($iterator) as $fileInfo) {
            $explode = explode('.', $fileInfo);
            $arrayPop = array_pop($explode);
            $curext = strtolower($arrayPop);
            if ( $curext==$extension) {
                $file     = $fileInfo->getRealPath();
                $contents = file_get_contents($file);
                $encoding = mb_detect_encoding($contents,null , true);
                $picture=$noaimg;
                $errmsg="";
                if ( $encoding!=$targetcode and $encoding!="ASCII") {
                    // Only source needs conversion
                    if ( $confirmcount==1 ) { // this is the preview
                        // The preview shows only the icon
                        $picture=$cnvimg;
                        $href ="convert_txt_test.php?file=".$file;
                        $href.="&encoding=".$encoding;
                        $href.="&targetcode=".$targetcode;
                        $picture="a href='".$href."' target='testshow' onclick=OpenWindow()> <".$cnvimg.">".$msgstr["preview"]."</a";
                    } else {// this is the real conversion
                        $contents=@mb_convert_encoding($contents,$targetcode,$encoding);
                        if ($contents===false ) {
                            $contents_error= error_get_last();
                            $numerrors++;
                            if ($contents_error!="") {
                                $errmsg="<br><font color=red>".$contents_error["message"]."</font>";
                            }
                            $picture=$errimg;
                        } else{ 
                            $result=@file_put_contents( $file,$contents);                   
                            if ($result===false ) {
                                $contents_error= error_get_last();
                                $numerrors++;
                                if ($contents_error!="") {
                                    $errmsg="<br><font color=red>".$contents_error["message"]."</font>";
                                }
                                $picture=$errimg;
                            } else {
                                $numconverted++;
                                $encoding=$targetcode;
                                $picture=$donimg;
                            }
                        }
                    }
                }
?>
        <tr>
            <td align=center><?php echo $curext;?></td>
            <td><?php echo $file;?></td>
            <td align=center><?php echo $encoding;?></td>
            <td align=center>
                <<?php echo $picture?>>
                <?php echo $errmsg;?>
            </td>
        </tr>
<?php
            } // end file with correct extension
        } // end iteration
    } // end loop extensions
    echo "</table>";
    // Display a button to convert (screen 1) or the result of the conversion (screen 2)
    if ( $confirmcount==1 ) {
        echo "<form name=continuar  method=post >";
        foreach ($_REQUEST as $var=>$value){
            // some values may contain quotes or other "non-standard" values
            $value=htmlspecialchars($value);
            echo "<input type=hidden name=$var value=\"$value\">\n";
        }
        ?>
        <input type="submit" value="<?php echo $topmsg;?>" onclick="javascript:Preview();"/>
        </form>
        <?php
    } else {
        echo "<div><br><b>".$msgstr["converted"].": ".$numconverted."<br>Failed: ".$numerrors."</b></div>";
    }
}
echo "</div></div></div>";
include("../common/footer.php");
?>
</body></html>
