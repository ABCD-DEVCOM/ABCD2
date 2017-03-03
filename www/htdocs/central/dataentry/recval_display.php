<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      recval_diplay.php
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
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");


//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";

$tag=array();
$pft=array();

include("leerregistroisis.php");
$maxmfn=0;
$arrHttp["Opcion"]="leer";
$arrHttp["Formato"]="ALL";
$res=LeerRegistro($arrHttp["base"],$arrHttp["base"].".par",$arrHttp["Mfn"],$maxmfn,$arrHttp["Opcion"],"","","");

//READ THE FILE WITH THE TYPE OR RECORDS, IF ANY
unset ($tm);
$tor="";
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab")){
	$tor=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
}else{
	if (file_exists($db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab"))
		$tor=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
}
// $tl and $nr are the tags where the type of record is stored
$tl="";
$nr="";
if ($tor!=""){
	$fp = file($tor);
	$ix=0;
	$tm[]="";
	foreach ($fp as $linea){		$linea=trim($linea);
		if ($linea!=""){
			if ($ix==0){
				$ij=strpos($linea," ");
				if ($ij===false) {
					$tl=$linea;
				}else{
					$tl=trim(substr($linea,0,$ij));
					$nr=trim(substr($linea,$ij));
				}

				$ix=1;
			}else{
				$tm[]=trim($linea);
			}
		}

	}
}
if ($tl!="") $tl=strtolower($valortag[$tl]);
if ($nr!="") $nr=strtolower($valortag[$nr]);
if ($tl!="") {	$pftval=$tl."_".$nr."_".$arrHttp["base"].".val";
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pftval;
	if (!file_exists($archivo))		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$pftval;
	if (!file_exists($archivo)){		$pftval=$arrHttp["base"].".val";
		$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pftval;	}

}else{	$pftval=$arrHttp["base"].".val";
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pftval;}
if (!file_exists($archivo))  $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$pftval;
//echo $arrHttp["base"]."/def/".$lang_db."/".$pftval."<br>";
$rec_validation="";

if (file_exists($archivo)){
	$fp = file($archivo);
	$fp_str=implode('$%|%$',$fp);
	if ($fp_str=="") die;
	$fp=explode('###',$fp_str);
	$ix_fatal=-1;
	foreach($fp as $value){
		$value=str_replace('$%|%$',' ',$value);		$value=trim($value);
		if ($value!="") {
			$ix=strpos($value,':');
			if ($ix===false){

			}else{
				$tag_val=substr($value,0,$ix);
				$value=substr($value,$ix+1);
				$v=explode('$$|$$',$value);
				if (substr(trim($v[0]),0,1)=="@"){
					$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($v[0],1));
					if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($v[0],1));
					$v[0]="@".$pft_file;
					$rec_validation.= "'$tag_val:  '  ,".$v[0]." ,, mpl '$$$$',";
				}else{
					$rec_validation.= "'$tag_val:  ',".$v[0].",mpl '$$$$',";
				}
				$ix_fatal=$ix_fatal+1;
				if (isset($v[1])) $err[$ix_fatal]=$v[1];
			}
		}
	}
//	echo $rec_validation;

}
if ($rec_validation==""){	echo "<h4>".$msgstr["recvalempty"]."</H4>";
	die;}
$formato=urlencode($rec_validation);
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&proc=<3333>R</3333>";
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
?>
<html>
<title><?php echo $msgstr["rval"]?></title>

<body>
<?

echo "<span class=title>".$msgstr["rval"]." ($pftval)</span>";
echo " <font size=1 face=arial> &nbsp; &nbsp; Script: dataentry/recval_display.php</font>";
echo "<P>";
$recval_pft="";
$res=implode("\n",$contenido);
$linea=explode('$$$$',$res);
echo "<table>";
$ix_fatal=-1;
$ixerror=0;
foreach ($linea as $v_value){	$v_value=trim($v_value);
	$ix_fatal=$ix_fatal+1;
	if ($v_value!=""){
		$v_ix=strpos($v_value,':');
		$v_tag=substr($v_value,0,$v_ix);
		$v_res=substr($v_value,$v_ix+1);
		if (trim($v_res)!=""){
			$ixerror=$ixerror+1;
			echo "<tr><td valign=top>$v_tag</td><td valign=top>".nl2br($v_res)."</td>";
			if (isset($err[$ix_fatal])and $err[$ix_fatal]=="true"){
				echo  "<td valign=top><font color=darkred>".$msgstr["fatal"]."</td>";
			}else{
				echo  "<td>&nbsp;</td>";
			}
		}
    }
}

echo "</table>";
echo "<span class=textbody03>";
if ($ixerror==0) echo "<font color=red>No errors</font><p>" ;
echo nl2br($recval_pft);
echo "<p><a href=javascript:self.close()>close window</a><br><br>";
echo "</body>
</html>";
?>