<?php
/* Modifications
20210607 fho4abcd Created new (from vmx_import_iso)
20210609 fho4abcd Added explanation message+ bug in confirmcount
*/
global $arrHttp;
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
// Set the characterset explicitly to UTF because output will be shown in UTF-8
$charset="UTF-8";
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
/*
** Old code might not send specific info.
** Set defaults for the return script,frame info and more
*/
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
$inframe=0;                      // The default runs not in a frame
$confirmcount=0;
$isofile="";
$isofileutf="";
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["isofile"]))      $isofile=$arrHttp["isofile"];
if ( isset($arrHttp["isofileutf"]))   $isofileutf=$arrHttp["isofileutf"];
$base=$arrHttp["base"];
$bd=$db_path.$base;
$wrk="wrk";
$wrkfull=$db_path.$wrk;
$fullisoname=$wrkfull."/".$isofile;
$fullisonameutf=$wrkfull."/".$isofileutf;
$convertisomsg=$msgstr["cnv_iso2utf"];
$cnvexe=$cgibin_path."isofile_iso_to_utf".$exe_ext;
$scriptaction="cnviso2utf";
$target_file_label=$msgstr["targetfile"].": ";

?>
<body>
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
var win
function Download(){
	document.download.submit()
}
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit()
}
function Upload(){
    document.initform.backtoscript.value='../utilities/cnv_iso_2_utf.php'
	document.initform.action='../utilities/upload_wrkfile.php?&backtoscript_org=<?php echo $backtoscript?>'
	document.initform.submit()
}

function Seleccionar(iso){
    document.continuar.isofile.value=iso;
    document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function ActivarMx(folder,iso){
    document.continuar.backtoscript.value='../utilities/cnv_iso_2_utf.php'
	document.continuar.action='../utilities/mx_show_iso.php?&storein='+folder+
                              '&copyname='+iso+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function ActivarMx2(folder,iso){
    document.continuar2.backtoscript.value='../utilities/cnv_iso_2_utf.php'
	document.continuar2.action='../utilities/mx_show_iso.php?&storein='+folder+
                              '&copyname='+iso+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar2.submit()
}
function Eliminar(iso){
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+iso)==true){
	    document.continuar.deleteiso.value=iso
        document.continuar.submit()
	}
}
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
win=window.open(mypage,myname,settings);}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";

?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php 
        echo $msgstr["maintenance"]." &rarr; ISO&harr;UTF-8 &rarr;".$convertisomsg;
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
    <div align=center ><h4><?php echo $convertisomsg?></h4></div>
    <?php if ($confirmcount==0) { ?>
    <div align=center style='color:blue;'><?php echo $msgstr["isodef"];?><br><br>
                                          <?php echo $msgstr["isodescnvscript"];?></div><br>
    <?php } ?>
    <div align=center>
<?php
//==================
include "inc_show_work.php";
//==================
if ($confirmcount==1) {  /* - Second screen: Present a menu with parameters -*/
    // The test button gives the $cnvexe to the test window
    $testbutton=
    '<a href="test_cnvrt.php?cnvexe='.$cnvexe.'" target=testshow onclick=OpenWindow()>'.$msgstr["test"]." ".$msgstr["convert"].' </a>';

    // Construct an output filename
    $isofileutf=substr_replace($file_value,"_utf.iso",-4);
    ?>
    <table  cellspacing=5>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
        <tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
         <tr>
            <td><?php echo $target_file_label;?></td><td><?php echo $isofileutf;?></td>
        </tr>
   </table><br>
    <?php
    // Create a form
    ?>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <form name=continuar  method=post >
        <input type=hidden name=isofileutf value='<?php echo $isofileutf;?>'>
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
          </tr>
          <tr>
              <td><?php echo $msgstr["convert"]." ISO-8859-1";?></td>
              <td><input type=checkbox name=cnvrtiso checked></td>
              <td></td>
          </tr>
          <tr>
              <td><?php echo $msgstr["convert"]." Windows-1252 (".$msgstr["delta"].")";?></td>
              <td><input type=checkbox name=cnvrtwin checked></td>
              <td style='color:blue'> <?php echo $msgstr["recommended"];?></td>
          </tr>
          <tr>
              <td><?php echo $msgstr["feedback"];?></td>
              <td><select name=feedbacklevel>
                    <option value='0' >0</option>
                    <option value='1' selected>1</option>
                    <option value='2' >2</option>
                    <option value='3' >3</option>
                  </select>
              </td>
              <td style='color:blue'> <?php echo $msgstr["warnmuchoutput"];?></td>
          </tr>
          <tr>
              <td></td>
              <td><input type=button value='START' onclick=Confirmar()></td>
              <td><?php echo "$testbutton" ?></td>
         </tr>       
        </table>
    </form>
    <?php
} else if($confirmcount>1){  /* - Last screen: execution and result -*/
    $file_label=$msgstr["archivo"].": ";
    $file_value=$isofile;
    ?>
    <table  cellspacing=5>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
        <tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
         <tr>
            <td><?php echo $target_file_label;?></td><td><?php echo $isofileutf;?></td>
        </tr>
    </table><hr>
    <?php
    //converting iso: create commandline
    if ( isset($arrHttp["cnvrtiso"]) && isset($arrHttp["cnvrtwin"]) ) {
        $conversion="-c iw";
    } else if ( isset($arrHttp["cnvrtiso"]) ) {
        $conversion="-c i";
    } else if ( isset($arrHttp["cnvrtiso"]) ) {
        $conversion="-c w";
    } else {
        $conversion="";
    }
    if (isset($arrHttp["feedbacklevel"])) {
        $feedback="-f ".$arrHttp["feedbacklevel"];
    }
    $strINV=$cnvexe." -i $fullisoname  -o $fullisonameutf $conversion $feedback 2>&1";
    //Execute command
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    echo "<br>".$msgstr["commandline"].": $strINV<br>";
    if($status==0) {
        echo ("<h3>".$msgstr["processok"]."</h3>");
        $auxcolor="style='color:darkgreen'";
     } else {
        $auxcolor="style='color:red'";
        echo ("<h3 ".$auxcolor."><br>".$msgstr["processfailed"]."</h3>");
    }
    // show the process output in a table to get it left adjusted
    ?>
    <table cellpadding=5 cellspacing=0 border=1><tr>
        <td <?php echo $auxcolor;?>>
            <?php
            echo "$straux";
            ?>
        </td></tr>
    </table>
    <hr>
    <br>
    <table cellspacing=20><tr><td>
        <form name=continuar2  method=post >
            <input type=hidden name=archivo value='<?php echo $fullisonameutf;?>'>
            <input type=hidden name=isofileutf value='<?php echo $isofileutf;?>'>
            <input type=hidden name=charset_menu_val value='UTF-8'>
            <?php
            foreach ($_REQUEST as $var=>$value){
                if ( $var!= "deleteiso" ){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
            <input type=button name=mxread value='<?php echo $msgstr["mx_dbread"];?>' onclick="ActivarMx2(<?php echo "'$wrk'"?>,<?php echo "'$isofileutf'"?>)">
        </form>
    </td>
    <td align=center>
        <form name=download action="../utilities/download.php">
            <input type=hidden name=archivo value="<?php echo $isofileutf ?>">
        </form>
        <h3><?php echo $isofileutf ?>: &nbsp; <?php echo $msgstr["okactualizado"] ?> <br>
            <a href=javascript:Download()> <?php echo $msgstr["download"]?></a>
        </h3>
    </td>
    </tr></table>
 
<?php
}
echo "</div></div></div>";
include("../common/footer.php");
?>
</body></html>

