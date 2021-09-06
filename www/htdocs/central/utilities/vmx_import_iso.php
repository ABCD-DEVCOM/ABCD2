<?php
/* Modifications
20210418 fho4abcd Created as replacement for all iso import functions.
20210421 fho4abcd Show iso files with mx_show_iso
20210421 fho4abcd No error if an inspected file has no extension
20210426 fho4abcd Check line endings
20210516 fho4abcd Add upload button
20210526 fho4abcd Detect non-executable working folder. Show number of found files
20210527 fho4abcd bug repair: is_executable does not work for windows folders
20210605 fh04abcd Remove isotag1=3000 from command to avoid creation of extra fields. Translations
20210624 fho4abcd Import only if second screen was executed (and not immediately during list presentation)
20210802 fho4abcd Make Show file work the first time
*/
global $arrHttp;
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
/*
** Old code might not send specific info.
** Set defaults for the return script,frame info and more
*/
$backtoscript="../dataentry/administrar.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$confirmcount=0;
$isofile="";
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["isofile"]))      $isofile=$arrHttp["isofile"];
$base=$arrHttp["base"];
$bd=$db_path.$base;
$wrk="wrk";
$wrkfull=$db_path.$wrk;
$fullisoname=$wrkfull."/".$isofile;
$importisomsg=$msgstr["cnv_import"]." ISO ".$msgstr["archivo"];
$scriptaction="importiso";
?>
<body >
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
var win
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit()
}
function Upload(){
    document.initform.backtoscript.value='../utilities/vmx_import_iso.php'
	document.initform.action='../utilities/upload_wrkfile.php?&backtoscript_org=<?php echo $backtoscript?>'
	document.initform.submit()
}

function Seleccionar(iso){
    document.continuar.isofile.value=iso;
    document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function ActivarMx(folder,iso){
    document.continuar.storein.value=folder
    document.continuar.copyname.value=iso
    document.continuar.backtoscript.value='../utilities/vmx_import_iso.php'
	document.continuar.action='../utilities/mx_show_iso.php?'+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function Eliminar(iso){
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+iso)==true){
	    document.continuar.deleteiso.value=iso
        document.continuar.submit()
	}
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";

?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php 
        echo $msgstr["maintenance"]." &rarr; ".$msgstr["cnv_export"]."/".$msgstr["cnv_import"].": ".$arrHttp["base"];
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
    <div align=center ><h4><?php echo $importisomsg?></h4></div>
    <div align=center>
<?php
//===================
include "inc_show_work.php";
//===================
if ($confirmcount==1) {  /* - Second screen: Present a menu with parameters -*/
    // Check that the lineends fit with the current OS (mx requirement)
    include "inc_check-line-end.php";
    if ( check_line_end($fullisoname)!=0) die; // cannot continue
    ?>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
        <tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
    </table><br>
    <?php
    // Create a form
    ?>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <form name=continuar  method=post >
        <?php
        foreach ($_REQUEST as $var=>$value){
            if ( $var!= "deleteiso" ){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
        ?>
        <table cellspacing=5 align=center>
          <tr> <th colspan=3>
              <?php echo $msgstr["adjustparms"];?>
              </th>
          </tr><tr>
              <td><?php echo $msgstr["deldb"]?></td>
              <td><input type=checkbox name=delrec></td>
              <td><font color=blue><?php echo $msgstr["unch_append"]?></font></td>
          </tr><tr>
              <td></td><td><input type=button value='START' onclick=Confirmar()></td><td></td>
         </tr>       
        </table>
    </form>
    <?php
} else if ($confirmcount>1){  /* - Last screen: execution and result -*/
    $file_label=$msgstr["archivo"].": ";
    $file_value=$isofile;
    ?>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
        <tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
    </table><hr>
    <?php
    //importing iso
    if (isset($arrHttp["delrec"]))
		$accion=" create";
	else
		$accion=" append";

    $strINV=$mx_path." iso=$fullisoname $accion=".$db_path.$base."/data/".$base."  -all now 2>&1";
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    echo "<br>".$msgstr["commandline"].": $strINV<br>";
    if($status==0) {
        echo ("<h3>".$msgstr["import_process_ok"]."</h3>");
        echo "$straux";
    } else {
        echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3>");
        echo "<font color='red'>".$straux."</font>";
    }
    get_dbinfo();
    $dbmsg_value=$arrHttp["dblongname"]." (".$base.") &rarr; ";
    $dbmsg_value.="<b><font color=darkred>".$msgstr["maxmfn"].": ".$arrHttp["MAXMFN"]."</font></b>";
    ?>
    <hr>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr>
    </table>
    <?php
}
echo "</div></div></div>";
include("../common/footer.php");
?>
</body></html>

