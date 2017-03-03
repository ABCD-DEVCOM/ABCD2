<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      typeofrecs.php
 * @desc:
 * @author:    Guilda Ascencio
 * @since:     20091203
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
session_start();
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
require_once ("../lang/admin.php");
echo "<body>";
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/typeofrecs.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/typeofrecs.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: typeofrecs.php</font>";
	echo "</div>\n";

//READ THE DATAENTRY WORKSHEET TO DETERMINE THE AVAILABILITY FOR THE OPERATOR
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks")){
	$fp = file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks");
}else{
	if (file_exists($db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks"))
		$fp = file($db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks");
}
$i=0;
$wks_p=array();
if (isset($fp)) {
	foreach($fp as $linea){
		if (trim($linea)!="") {
			$linea=trim($linea);
			$l=explode('|',$linea);
			$cod=trim($l[0]);
			$nom=trim($l[1]);
			if (isset($_SESSION["permiso"][$arrHttp["base"]."_fmt_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_fmt_".$cod] )
						or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])){
				$i=$i+1;
				$wks_p[$cod]="Y";
			}
		}
	}
}

$tr=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";

if (!file_exists($tr))  $tr=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
$fp=file($tr);

?>
<div class="middle form">
			<div class="formContent">
<center>
<h3><?php echo $msgstr["typeofr"]?></h3>
<table>
<?php
$ix=0;
$tr="";
$nr="";
foreach($fp as $value){
	$value=trim($value);
	if ($value!=""){
		if ($ix==0){  				//THE FIRST LINE MUST CONTAIN THE TAGS THAT DEFINES THE TYPE OF RECORD AND BIBLIOGRAPHIC LEVEL			$ttm=explode(" ",$value);			$tl=trim($ttm[0]);
			if (isset($ttm[1])) $nr=trim($ttm[1]);
			$ix=1;		}else{
			$ttm=explode('|',$value);
			$cod=$ttm[0];
			$ipos=strpos($cod,".");
			$cod=substr($cod,0,$ipos);
            if (isset($wks_p[$cod]))
				echo "<tr><td><a href=\"javascript:top.wks='".$value."|$tl|$nr';top.Menu('crear')\">".$ttm[3]."</a></td>\n";
		}
	}
}
?>
</table>
</div>
</div>
</body></html>
