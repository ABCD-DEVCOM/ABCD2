<?php
/* Modifications
20210702 fho4abcd Created new
20210802 fho4abcd Make Show file work the first time
20211214 fho4abcd Backbutton by included file
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
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
$inframe=0;                      // The default runs not in a frame
$confirmcount=0;
$isofile="";
$isofilefdt="";
$fullfdtfile="";
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["isofile"]))      $isofile=$arrHttp["isofile"];
if ( isset($arrHttp["isofilefdt"]))   $isofilefdt=$arrHttp["isofilefdt"];
if ( isset($arrHttp["fullfdtfile"]))  $fullfdtfile=$arrHttp["fullfdtfile"];
$base=$arrHttp["base"];
$bd=$db_path.$base;
$wrk="wrk";
$wrkfull=$db_path.$wrk;
$fullisoname=$wrkfull."/".$isofile;
$fullisonamefdt=$wrkfull."/".$isofilefdt;
$convertisomsg=$msgstr["matchisofdt"];
$cnvexe=$cgibin_path."isofile_match_with_fdt".$exe_ext;
$scriptaction="matchisofdt";
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
    document.initform.backtoscript.value='../utilities/match_iso_with_fdt.php'
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
    document.continuar.backtoscript.value='../utilities/match_iso_with_fdt.php'
	document.continuar.action='../utilities/mx_show_iso.php?&storein='+folder+
                              '&copyname='+iso+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function ActivarMx2(folder,iso){
    document.continuar2.storein.value=folder
    document.continuar2.copyname.value=iso
    document.continuar2.backtoscript.value='../utilities/match_iso_with_fdt.php'
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
        echo $msgstr["maintenance"]." &rarr; ".$msgstr["matchisofdt"];
?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
    <div align=center ><h4><?php echo $convertisomsg?></h4></div>
    <?php if ($confirmcount==0) { ?>
    <div align=center style='color:blue;'><?php echo $msgstr["isodef"];?><br><br>
                                          <?php echo $msgstr["isomatchfdtscript"];?></div><br>
    <?php } ?>
    <div align=center>
<?php
//==================
include "inc_show_work.php";
//==================
if ($confirmcount==1) {  /* - Second screen: Present a menu with parameters -*/
    // The test button gives the $cnvexe to the test window
    $testbutton=
    '<a href="test_cnvrt.php?cnvexe='.$cnvexe.'" target=testshow onclick=OpenWindow()>'.$msgstr["test"]." ".$msgstr["match"].' </a>';
    // determine the fdt file
    $fullfdtfile=$db_path.$arrHttp["base"]."/def/$lang/$base.fdt";
    // Construct an output filename
    $isofilefdt=substr_replace($file_value,"_fdt_$base.iso",-4);
    ?>
    <table  cellspacing=5>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
        <tr>
            <td><?php echo $file_label;?></td><td><?php echo $file_value;?></td>
        </tr>
         <tr>
            <td><?php echo $target_file_label;?></td><td><?php echo $isofilefdt;?></td>
        </tr>
         <tr>
            <td><?php echo $msgstr["fdt"];?></td><td><?php echo $fullfdtfile;?></td>
        </tr>
   </table><br>
    <?php
    // Create a form
    ?>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <form name=continuar  method=post >
        <input type=hidden name=isofilefdt value='<?php echo $isofilefdt;?>'>
        <input type=hidden name=fullfdtfile value='<?php echo $fullfdtfile;?>'>
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
              <td><input type=button value='<?php echo $msgstr["start"];?>' onclick=Confirmar()></td>
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
            <td><?php echo $target_file_label;?></td><td><?php echo $isofilefdt;?></td>
        </tr>
         <tr>
            <td><?php echo $msgstr["fdt"];?></td><td><?php echo $fullfdtfile;?></td>
        </tr>
    </table><hr>
    <?php
    if (isset($arrHttp["feedbacklevel"])) {
        $feedback="-f ".$arrHttp["feedbacklevel"];
    }
    $strINV=$cnvexe." -i $fullisoname  -o $fullisonamefdt -d $fullfdtfile $feedback 2>&1";
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
            <input type=hidden name=archivo value='<?php echo $fullisonamefdt;?>'>
            <input type=hidden name=isofilefdt value='<?php echo $isofilefdt;?>'>
            <input type=hidden name=charset_menu_val value='<?php echo $charset;?>'>
            <?php
            foreach ($_REQUEST as $var=>$value){
                if ( $var!= "deleteiso" ){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
            <input type=button name=mxread value='<?php echo $msgstr["mx_dbread"];?>' onclick="ActivarMx2(<?php echo "'$wrk'"?>,<?php echo "'$isofilefdt'"?>)">
        </form>
    </td>
    <td align=center>
        <form name=download action="../utilities/download.php">
            <input type=hidden name=archivo value="<?php echo $isofilefdt ?>">
        </form>
        <h3><?php echo $isofilefdt ?>: &nbsp; <?php echo $msgstr["okactualizado"] ?> <br>
            <a href=javascript:Download()> <?php echo $msgstr["download"]?></a>
        </h3>
    </td>
    </tr></table>
 
<?php
}
echo "</div></div></div>";
include("../common/footer.php");
?>


