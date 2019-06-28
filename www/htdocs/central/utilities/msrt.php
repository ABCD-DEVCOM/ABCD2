<?php 
/**
 * @program:   ABCD - ABCD-Central 
 * @copyright:  Copyright (C) 2015 UO - VLIR/UOS
 * @file:      msrt.php
 * @desc:      sorting master file
 * @author:    Marino Borrero Sánchez, Cuba. marinoborrero@gmail.com
 * @since:     20192704
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
include("../config.php");
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body onunload=win.close()>";
include("../common/institutional_info.php");
var_dump($arrHttp);//die;
if (isset($arrHttp["selected_base"])) $base=$arrHttp["selected_base"]; else if (isset($arrHttp["base"])) $base=$arrHttp["base"];
$bd=$db_path.$base;
                    echo "base=$base   bd=$bd<BR>";

//if (file_exists($db."/dr_path.def")){
//$drb=file($bd."/dr_path.def");
//foreach ($drb as $value){
//	$value=trim($value);
//	if (trim($value)!=""){
//		if (substr($value,0,12)=="CISIS_VERSION"){
//			$cisis_version=trim(substr($value,9));
//	        }
//	if (substr($value,0,5)=="UNICODE"){
//		$unicode=trim(substr($value,10));
//		}
//       	}
//    }
//}
///$cisis_path=$cisis_path.$unicode.$cisis_version;
//echo "cisispath=$cisis_path<BR>"; die;


echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $base ."
			</div>
			<div class=\"actions\">

	";


//if (isset($_GET['selected_base']))
echo "<a href=\"menu_extra.php?encabezado=S\" class=\"defaultButton backButton\">";
//base=".$_GET['selected_base']."&encabezado=S\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
	?>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: utilities/msrt.php";

?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<?php
// start file
	
	if(isset($_GET["keylen"],$_GET["key"]))
	{
    if(strlen($_GET["key"])>1){
	$mmfn="";
	$rev="";
	if(isset($_GET["mmfn"])){
	$mmfn=" -mfn";	
	}
	if(isset($_GET["rev"])){
	$rev=' "'."f(999999-val(mfn),6,0)".'"';
}	
    	
//    $path=$bd.$_GET['selected_base']."/data/".$_GET['selected_base'];
$path=$bd."/data/".$base;
//    echo "path=$path<BR>";die;
	$cmd=$cisis_path."msrt".$exe_ext." ".$path." ".$_GET["keylen"]." ".$_GET["key"].$rev.$mmfn;
echo "cmd=$cmd<BR>";
	$exec=exec($cmd, $output,$t);
	if($t==0){
		echo "<strong>Process finished OK</strong>";
	}
	else{
		echo "<strong>ERROR</strong>";
	
	}
	}
	}
	else{
		echo "<strong>Please enter length of sort key, the PFT for sorting, keep MFNs (on/off) and sort reversed (on/off)</strong>";
	}
	?>
	    
<iframe id="iframe_proc" src="proc.html" width="128" height="128" marginheight="0" marginwidth="0" noresize scrolling="No" frameborder="0" style="display:none;"> 
</iframe>
<div id="see_config" style="<?php echo $style_config;?>">
<form id="config" name="config" method="get" action="">
<table>
<tr>
<td>
Database <strong><?php echo $base;?></strong><input type="hidden" id="selected_base" name="selected_base" value="<?php echo $base;?>">
</td>
<td>
Keylength <input type="number"  name="keylen" placeholder="20"/>
</td>
<td>
Key <input type="text"  name="key" value="" placeholder="v245">
</td>
<td>
-MFN <input type="checkbox" name="mmfn"/>
</td>

<td>
Reverse <input type="checkbox" name="rev"/>
</td>
</tr>
</table>
<hr/>
<input type="submit" value="Sort" onclick="javascript:show_proc();"/>
</form>
</div>
</div>
</div>
<script>
function check_vars_base()
{
	
		alert('base');
	
}
function check_vars_htdocs()
{
	
		document.getElementById('base_chk').checked=false;
	
	
}
function show_proc()
{
	document.getElementById('iframe_proc').style="display:block";
	document.getElementById('see_config').style="display:none";
}
document.getElementById("loader").style.display='none';
</script>
<?php
include("../common/footer.php");
?>
