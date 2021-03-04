<?php
/* Modifications
20210304 fho4abcd Replaced helper code fragment by included file
20210304 fho4abcd Move html tags, php code indented and reordered
20210204 fho4abcd Send mx executable to test button. Test button also on first form
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
?>
<body onunload=win.close()>
<script src=../dataentry/js/lr_trim.js></script>
<?php
include("../common/institutional_info.php");
$base=$arrHttp["base"];
$bd=$db_path.$base;

echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";

	echo "<a href=\"../dbadmin/menu_mantenimiento.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
	echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";

?>
<script>
var win;
function OpenWindow(){
	msgwin=window.open("","test","width=800,height=200");
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
// The test button gives the mx_path to the test window
$testbutton='<a href="mx_test.php?mx_path='.$mx_path.'" target=test onclick=OpenWindow()>Test MX</a>';

if(isset($_REQUEST['fst'])) $fst=$_REQUEST['fst'];
if(!isset($fst)) { // The form sets the fst: the first action of this php
?>
    <form name=maintenance action='' method='post' onsubmit='OpenWindows();'>
    <table cellspacing=5 align=center>
	  <tr>
		<td>
		  <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
          <h2>Please adjust the following parameters and press 'START'</h2>
          <br>
    <?php
    echo "<font size='2'>Select FST </font><select name='fst'>";
    $handle=opendir($bd."/data/");
    while ($file = readdir($handle)) {
        if ($file != "." && $file != ".." && (strpos($file,".fst")||strpos($file,".FST"))) {
            echo "<option value='$file'>$file</option>";
        }
    }
    echo "</select>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$testbutton";
    ?>
    <br><br>
    <font size='2'>Use /m parameter </font><input type='checkbox' name='m'>
    <font color=red>Warning: do not check this parameter if you are using picklists type DB in the FDT</font>
    <br><br>
    <input type='submit' value='START'>
    </td>
    </table></form>


<?php
} else {
    if (file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".stw")) {
        $stw=" stw=@".$db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".stw";
    }else{
        if (file_exists($db_path."stw.tab"))
            $stw=" stw=@".$db_path."stw.tab";
        else
            $stw="";
    }
    if (!file_exists($cisis_path)){
        echo $cisis_path.": ".$msgstr["misfile"];
        die;
    }
    $uctab="";
    $actab="";
    $cipar="";
    if (file_exists($db_path."cipar.par")){
        $cipar=$db_path."cipar.par";
        $uctab="isisuc.tab";
        $actab="isisac.tab";
    }else{
        if (file_exists($db_path.$arrHttp["base"]."/data/isisuc.tab")){
            $uctab=$db_path.$arrHttp["base"]."/data/isisuc.tab";
        }else{
            if (file_exists($db_path."isisuc.tab"))
                $uctab=$db_path."isisuc.tab";
        }
        if ($uctab=="")  $uctab="ansi";


        if (file_exists($db_path.$arrHttp["base"]."/data/isisac.tab")){
            $actab=$db_path.$arrHttp["base"]."/data/isisac.tab";
        }else{
            if (file_exists($db_path."isisuc.tab"))
                $actab=$db_path."isisac.tab";
        }
        if ($actab=="")  $actab="ansi";
    }

    if ($unicode=="utf8"){
        if (file_exists($db_path."isisactab_utf8.tab"))
            $actab=$db_path."isisactab_utf8.tab";

        if (file_exists($db_path."isisuctab_utf8.tab"))
            $uctab=$db_path."isisuctab_utf8.tab";
    }
    $parameters= "<br>";
    $parameters.= "database: ".$bd."/data/".$base."<br>";
    $parameters.= "fst: @".$bd."/data/".$base.".fst<br>";
    $parameters.= "mx: $mx_path  ".$testbutton."<br>";
    if ($stw!="") $parameters.= "stw: $stw<br>";
    if ($uctab!="") $parameters.= "uctab: $uctab<br>";
    if ($uctab!="") $parameters.= "actab: $actab<br>";
    unset($m);
    if (isset($_POST['m'])) $m=$_POST['m'];
    $m_var="";
    if(isset($m)) $m_var="/m";

    $strINV=$mx_path." ".$bd."/data/".$base. "$cipar fst=@".$bd."/data/".$fst." uctab=$uctab actab=$actab $stw fullinv".$m_var."=".$bd."/data/".$base." -all now tell=100";
    // execute the command
    exec($strINV, $output,$t);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }

    if($straux!="") {
        echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br></font><hr>";
        echo ("<h3>Process Result: <br>Process Finished OK</h3>");
    } else {
        echo ("<h2>Output: <font color='red'><br>Process NOT EXECUTED</font></h2><br>"."<font face=courier size=2>".$parameters."<br>Command line: $strINV</font><hr>");
    }
}

?>

</div></div>

<?php
include("../common/footer.php");
?>
</body></html>
