<?php
/* Modifications
20210418 fho4abcd Created as replacement for all iso import functions.
20210421 fho4abcd Show iso files with mx_show_iso
20210421 fho4abcd No error if an inspected file has no extension
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
function Seleccionar(iso){
    document.continuar.isofile.value=iso;
    document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function ActivarMx(folder,iso){
    document.continuar.backtoscript.value='../utilities/vmx_import_iso.php'
	document.continuar.action='../utilities/mx_show_iso.php?&storein='+folder+
                              '&copyname='+iso+'&backtoscript_org=<?php echo $backtoscript?>'
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
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
    <div align=center ><h3><?php echo $importisomsg?></h3></div>
    <div align=center>
<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
include ("../common/inc_get-dblongname.php");
include ("../common/inc_get-dbinfo.php");
$dbmsg_label=$msgstr["database"].":";
$dbmsg_value=$arrHttp["dblongname"]." (".$base.") &rarr; ";
$dbmsg_value.="<b><font color=darkred>".$msgstr["maxmfn"].": ".$arrHttp["MAXMFN"]."</font></b>";
$file_label=$msgstr["archivo"].": ";
$file_value=$wrk."/".$isofile;

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the iso file -*/
    ?>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr>
    </table>
    <?php
    // Get the list of iso files in the working folder
    clearstatcache();
    $file_array = Array();
    $handle = opendir($wrkfull);
	while (($file = readdir($handle))!== false) {
        $info = pathinfo($file);
        if (is_file($wrkfull."/".$file) and isset($info["extension"])and $info["extension"] == "iso") {
            if ( isset($arrHttp["deleteiso"]) and $file==$arrHttp["deleteiso"]) {
                //delete the file
                unlink ($wrkfull."/".$file);
                echo "<div>".$msgstr["archivo"]." ".$file." ".$msgstr["deleted"]."</div>";
            } else {
                $file_array[]=$file;
            }
        }
	}
	closedir($handle);
	if (count($file_array)>=0){
        sort ($file_array);
        reset ($file_array);
        $selimg="img src='../dataentry/img/aceptar.gif' alt='" .$msgstr["selformat"]."' title='".$msgstr["selformat"]."'";
        $selimg=htmlentities($selimg);
        $delimg="img src='../dataentry/img/barDelete.png' alt='" .$msgstr["eliminar"]."' title='".$msgstr["eliminar"]."'";
        $delimg=htmlentities($delimg);
        $lisimg="img src='../dataentry/img/preview.gif' alt='" .$msgstr["ver"]."' title='".$msgstr["ver"]."'";
        $lisimg=htmlentities($lisimg);
        // Create a form with all necessary info
        // Show the list of iso files in /wrk
        ?>
        <form name=continuar  method=post >
            <input type=hidden name=confirmcount value=0>
            <input type=hidden name=deleteiso value=0>
            <input type=hidden name=isofile value=0>
            <?php
            if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
            if ( !isset($arrHttp["inframe"]))      echo "<input type=hidden name=\"inframe\" value=\"".$inframe."\">";
            foreach ($_REQUEST as $var=>$value){
                if ( $var!= "deleteiso" ){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
        </form>

        <h4><?php echo $msgstr["seleccionar"]." ".$msgstr["cnv_iso"]?> </h4>
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=4>
        <tr>
            <th><?php echo $msgstr["archivo"]?> </th>
            <th><?php echo $msgstr["ver"]?> </th>
            <th><?php echo $msgstr["eliminar"]?> </th>
            <th><?php echo $msgstr["seleccionar"]?> </th>
       </tr>
        <?php
        foreach ($file_array as $file) {
            $filemsg="<b>".$file."</b><br>";
            $filemsg.="&rarr; ".$msgstr["filemod"].": ".date("Y-m-d H:i:s", filemtime($wrkfull."/".$file));
            $filemsg.=", Size: ".number_format(filesize($wrkfull."/".$file),0,',','.');
        ?> 
        <tr>
            <td bgcolor=white><?php echo $filemsg?></td>
            <td bgcolor=white><a href="javascript:ActivarMx(<?php echo "'$wrk'"?>,<?php echo "'$file'"?>)"> <<?php echo $lisimg?>> </a></td>
            <td bgcolor=white><a href="javascript:Eliminar('<?php echo $file?>')"> <<?php echo $delimg?>> </a></td>
            <td bgcolor=white><a href="javascript:Seleccionar('<?php echo $file?>')"> <<?php echo $selimg?>> </a></td>
        </tr>
        <?php
        }
        echo "</table>";
    }
} else if ($confirmcount==1) {  /* - Second screen: Present a menu with parameters -*/
    ?>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr><tr>
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
              Please adjust the following parameters and press 'START'
              </th>
          </tr><tr>
              <td><?php echo $msgstr["deldb"]?></td>
              <td><input type=checkbox name=delrec></td>
              <td><font color=blue>Unchecked = Append records</font></td>
          </tr><tr>
              <td></td><td><input type=button value='START' onclick=Confirmar()></td><td></td>
         </tr>       
        </table>
    </form>
    <?php
} else {  /* - Last screen: execution and result -*/
    $file_label=$msgstr["archivo"].": ";
    $file_value=$wrk."/".$isofile;
    ?>
    <table  cellspacing=5>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr><tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
    </table><hr>
    <?php
    //importing iso
    if (isset($arrHttp["delrec"]))
		$accion=" create";
	else
		$accion=" append";

    $strINV=$mx_path." iso=$fullisoname $accion=".$db_path.$base."/data/".$base." isotag1=3000 -all now 2>&1";
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo "<br>Command line: $strINV<br>";
        echo ("<h3>Import process result: OK</h3>");
        echo "$straux";
    } else {
        echo "<br>Command line: $strINV<br>";
        echo ("<h3><font color='red'><br>Import process NOT EXECUTED or FAILED</font></h3>");
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

