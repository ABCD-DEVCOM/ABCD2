<?php
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
include("../lang/dbadmin.php");
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body onunload=win.close()>";
include("../common/institutional_info.php");
$base=$arrHttp["base"];
$bd=$db_path.$base;

//                        echo "base=" .$arrHttp["base"]." <BR>";
//                        echo "unicode=$unicode<BR>";
//echo "Cisis version : ".$cisis_ver."<BR>";
//echo "mx_path : ".$mx_path."<BR>";



echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";

	echo "<a href=\"../dbadmin/menu_mantenimiento.php?base=".$arrHttp["base"]."&encabezado=S\" class=\"defaultButton backButton\">";
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

<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: utilities/vmx_fullinv.php";

?>
</font>
</div>

<div class="middle form">
	<div class="formContent">
<form name=maintenance action='' method='post' onsubmit='OpenWindows();'>
<table cellspacing=5 align=center>
	<tr>
		<td>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
             <br>

          
			<?php


if(isset($_POST['fst'])) $fst=$_POST['fst'];
if(isset($fst))
{
if (file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".stw"))
{
	$stw=" stw=@".$db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".stw";
}
else
	if (file_exists($db_path."stw.tab"))
		$stw=" stw=@".$db_path."stw.tab";
	else
		$stw="";

if (!file_exists($cisis_path)){
	echo $cisis_path.": ".$msgstr["misfile"];
	die;
}
$uctab="";
$actab="";
$cipar="";
//$m=0;
//echo "actab=$db_path".$arrHttp["base"]."/data/isisactab_utf8.tab";die;

//echo "dbpath=$db_path";//die;
if (file_exists($db_path.$arrHttp["base"]."/data/cipar.par")){      // priority always given to cipar.par for specific db if existing but it should be complete
	$cipar=" cipar=".$db_path.$arrHttp["base"]."/data/cipar.par";//  echo $cipar; die;
	$uctab="isisuc.tab";
	$actab="isisac.tab";
}else{
if ($unicode=="utf8")
{
//echo "UNICODE=$unicode<BR>";
	if (file_exists($db_path.$arrHttp["base"]."/data/isisactab_utf8.tab"))     //priority for specific UTF8 actab
	$actab=$db_path.$arrHttp["base"]."/data/isisactab_utf8.tab";
        else
        if (file_exists($db_path."isisactab_utf8.tab"))
        $actab=$db_path."isisactab_utf8.tab";                                     // alternatively use general UTF8 actab
	else
        echo "<font color=red> ACTAB not available ! <BR> </font>";

	if (file_exists($db_path.$arrHttp["base"]."/data/isisuctab_utf8.tab"))    // priority for specific UTF8 uctab
        $uctab=$db_path.$arrHttp["base"]."/data/isisuctab_utf8.tab";
        else
        if (file_exists($db_path."isisuctab_utf8.tab"))
        $actab=$db_path."isisuctab_utf8.tab";                                     // alternatively use general UTF8 actab
	else
        echo "<font color=red> UCTAB not available ! <BR> </font>";
}
else{         //ANSI modus
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
        if ($actab=="")  $actab="ansi";          // last resort:  use internal actab
     }
}

$parameters= "<br>";
$parameters.= "database: ".$bd."/data/".$base."<br>";
$parameters.= "fst: @".$bd."/data/".$base.".fst<br>";
$parameters.= "mx: $mx_path"." <a href=mx_test.php target=test onclick=OpenWindow()>Test</a><br>";
if ($stw!="") $parameters.= "stw: $stw<br>";
if ($uctab!="") $parameters.= "uctab: $uctab<br>";
if ($actab!="") $parameters.= "actab: $actab<br>";
if (isset($_POST['m'])) $m=$_POST['m']; else $m="";
if (isset($_POST['s'])) $s=$_POST['s']; else $s="";
if (isset($_POST['ftt']) AND strval($_POST['ftt'])>0) $ftt='v'.$_POST['ftt']; else $ftt="v96";

if($m<>"") $m_var="/m"; else $m_var="";
//if($s<>"" ) $s_var="\"proc='Gload/99=/var/opt/ABCD/bases/dubcore/collection/ABCDSourceRepo/'v96\" \"proc='Ghtmlgizmo,99'\""; else $m_var="";
// dropped part  \"proc=`d99<99 99 99>`,v99,`</99>`\"       //AND strval(v997)<999555
if($s<>"" ) $s_var="\"proc='Gload/9876='$ftt\" \"proc='Ghtmlgizmo,9876'\""; else $s_var="";
$strINV=$mx_path." $cipar ".$bd."/data/".$base. " fst=@".$bd."/data/".$fst." ".$s_var." uctab=$uctab actab=$actab $stw fullinv".$m_var."=".$bd."/data/".$base." -all now tell=100";
//echo "strINV=$strINV<BR>"; die;
exec($strINV, $output,$t);
$straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";

}

			if($straux!="")
			{
			echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br><hr>";
		 // echo "Query: $strINV"."</font><br>";
echo ("<h3>Process Result: <br>Process Finished OK</h3><br>");
}
else
echo ("<h2>Output: <font color='red'><br>Process NOT EXECUTED</font></h2><br>"."<font face=courier size=2>".$parameters."<br>Command line: $strINV<br><hr>");
if($base=="")
{
echo"NO database selected";
}

}     // if isset $fst
else
{
echo "<h2>Please adjust the following parameters and press 'START'</h2><br>";
echo "<font size='2'>Select FST </font><select name='fst'>";
$handle=opendir($bd."/data/");
while ($file = readdir($handle)) {
if ($file != "." && $file != ".." && (strpos($file,".fst",strlen($file)-4))||strpos($file,".FST",strlen($file)-4)) {
echo "<option value='$file'>$file</option>";
}}
echo "</select><br><br>";
echo "<font size='2'>Use /m parameter </font><input type='checkbox' name='m'><br><br>";
echo "<font size='2'>strip HTML-tags </font><input type='checkbox' name='s'";
echo "<font size='2'> in field-tag :  </font><input type='text' name='ftt' size='3'<br><br>";
echo "<br><input type='submit' value='START'>";
}

?></li>


			</ul>

		</td>
</table></form>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>

</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>";
?>

