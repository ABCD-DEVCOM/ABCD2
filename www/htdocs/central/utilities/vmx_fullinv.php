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
*/
/**
 * @program:   ABCD - ABCD-Central
 * @copyright:  Copyright (C) 2015 UO - VLIR/UOS
 * @file:      vmx_fullinv.php
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
/*
** Old code might not send specific info.
** Set defaults for the return script and frame info
*/
$backtoscript="../dataentry/administrar.php"; // The default return script
$inframe=1;                      // The default runs in a frame
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
?>
<body onunload=win.close()>
<script src=../dataentry/js/lr_trim.js></script>
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
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
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
win=window.open(mypage,myname,settings);}
</script>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
    <div align=center ><h3><?php echo $msgstr["mnt_gli"]?></h3></div>
<?php
// Ensure that the parameter file exists
$ciparfile=$arrHttp["base"].".par";
$fullciparpath=$db_path."par/".$ciparfile;
if (!file_exists($fullciparpath)){
    echo "<h3><font color=red>".$fullciparpath.": Does not exist</font></h3>";
}
// The test button gives the mx_path to the test window
// The show button gives the content of the parameter file
$testbutton=
'<a href="mx_test.php?mx_path='.$mx_path.'" target=testshow onclick=OpenWindow()>Test MX</a>';
$showbutton=
'<a href="show_par_file.php?par_file='.$fullciparpath.'" target=testshow onclick=OpenWindow()>Show &lt;dbn&gt;.par</a>';

if(isset($_REQUEST['fst'])) $fst=$_REQUEST['fst'];
if(!isset($fst)) { // The form sets the fst: the first action of this php
?>
    <form name=maintenance action='' method='post' onsubmit='OpenWindows();'>
        <input type=hidden name=backtoscript value="<?php echo $backtoscript ?>">
        <input type=hidden name=inframe value="<?php echo $inframe ?>">
    <table cellspacing=5 align=center>
	  <tr> <th colspan=3>
		  <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
          Please adjust the following parameters and press 'START'
          </th></tr>
      <tr><td>Select FST </td>
           <td>
    <?php
    echo "<select name='fst'>";
    $handle=opendir($bd."/data/");
    while ($file = readdir($handle)) {
        if ($file != "." && $file != ".." && (strpos($file,".fst")||strpos($file,".FST"))) {
            echo "<option value='$file'>$file</option>";
        }
    }
    echo "</select>"
    ?>
    </td><td></td></tr>
    <tr> <td>Use /m parameter</td>
         <td><input type='checkbox' name='m'></td>
         <td><font color=red>Warning: do not check this parameter if you<br>are using picklists with type DB in the FDT</font></td>
    </tr>
    <tr> <td>Show execution info</td>
         <td><input type='checkbox' name='tell'>
         <td><select name='tellnumber'>
             <option value="10000000">Minimal</option>
             <option value='1000'>every 1000 records</option>
             <option value='100'>every &nbsp;100 records</option>
             <option value='10'>every &nbsp;&nbsp;10 records</option>
             <option value='1'>all records (!!)</option>
        </select></td>
    </tr>
    <tr> <td></td><td><input type='submit' value='START'></td>
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
        $actab="";
        $uctab="";
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
            $stwat="stw=@".$stw;
        }
    }
    $parameters= "<br>";
    $parameters.= "database: ".$bd."/data/".$base."<br>";
    $parameters.= "fst&nbsp;&nbsp;: @".$bd."/data/".$base.".fst<br>";
    $parameters.= "mx&nbsp;&nbsp;&nbsp;: $mx_path<br>";
    if ($stw  !="") $parameters.= "stw&nbsp;&nbsp;: @$stw<br>";
    if ($uctab!="") $parameters.= "uctab: $uctab<br>";
    if ($actab!="") $parameters.= "actab: $actab<br>";
    $parameters.= " &nbsp; ".$testbutton;
    $parameters.= " &nbsp; ".$showbutton."<br>";

    // Process /m parameter
    unset($m);
    if (isset($_POST['m'])) $m=$_POST['m'];
    $m_var="";
    if(isset($m)) $m_var="/m";
    //process tell parameter
    $tellvar="";
    $tellnumbervar="";
    unset ($tell);
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
    // Create command.
    // Note that mx does not extract uctab/actab from cipar: explicitly specified here
    $strINV=$mx_path." ".$bd."/data/".$base. " fst=@".$bd."/data/".$fst." uctab=$uctab actab=$actab $stwat fullinv".$m_var."=".$bd."/data/".$base." -all now ".$tellvar." 2>&1";

    // execute the command
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br></font><hr>";
        echo ("<h3>Process Result: <br>Process Finished OK</h3>");
        echo "$straux";
    } else {
        echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br></font><hr>";
        echo ("<h3><font color='red'><br>Process NOT EXECUTED or FAILED</font></h3><hr>");
        echo "<font color='red'>".$straux."</font>";
   }
}

?>

</div></div>

<?php
include("../common/footer.php");
?>
</body></html>
