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
$tag=array();
$pft=array();
//USE THE NAME OF THE ENTRY FORMAT FOR CONNECTING THE VALIDATION FORMAT.
//IF NOT FOUND THEN USE THE DEFAULT VALIDATION FORMAT (DBN.VAL)
$rec_validation="";
$fatal="N";
if (file_exists($file_val)){
	$fp = file($file_val);
	$fp_str=implode('$%|%$',$fp);
	$fp=explode('###',$fp_str);
	$ix_fatal=-1;
	foreach($fp as $value){
		$value=str_replace('$%|%$',' ',$value);
		$value=trim($value);
		if ($value!="") {
			$ix=strpos($value,':');
			if ($ix===false){

			}else{
				$tag_val=substr($value,0,$ix);
				$value=substr($value,$ix+1).'$$|$$';
				$v=explode('$$|$$',$value);
				if (substr(trim($v[0]),0,1)=="@"){
					$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($v[0],1));
					if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($v[0],1));
					$v[0]="@".$pft_file;
					echo "pft_file=$pft_file";
					$rec_validation.= "'$tag_val:  '  ,".$v[0]." ,, mpl '$$$$',";
				}else{
					$rec_validation.= "'$tag_val:  ',".$v[0].",mpl '$$$$',";
				}
				$ix_fatal=$ix_fatal+1;
				if (isset($v[1]))
					$err[$ix_fatal]=trim($v[1]);
				else
					$err[$ix_fatal]="N";
			}
		}
	}
//	echo $rec_validation;
	$formato=urlencode($rec_validation);
	if ($arrHttp["Mfn"]=="New")
		$Mfn_val=0;
	else
		$Mfn_val=$arrHttp["Mfn"];

	$VC_val=urlencode("<3333 0>".$Mfn_val."</3333>".$ValorCapturado);
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&ValorCapturado=".$VC_val;
	$IsisScript=$xWxis."z3950_cnv.xis";
	include("../common/wxis_llamar.php");
	$recval_pft="";
	$res=implode("\n",$contenido);
	$linea=explode('$$$$',$res);

	$ix_fatal=-1;
	foreach ($linea as $v_value){
		$v_value=trim($v_value);
		$ix_fatal=$ix_fatal+1;
		if ($v_value!=""){
			$v_ix=strpos($v_value,':');
			$v_tag=substr($v_value,0,$v_ix);
			$v_res=substr($v_value,$v_ix+1);
			if (trim($v_res)!=""){
				$output.="<tr><td valign=top>$v_tag</td><td valign=top>".nl2br($v_res)."</td>";
				if (isset($err[$ix_fatal])and $err[$ix_fatal]=="true"){
					$output.=  "<td valign=top><font color=darkred>".$msgstr["fatal"]."</td>";
					$fatal="Y";
				}else{
					$output.=  "<td>&nbsp;</td>";
				}
			}
	    }
	}
	if (trim($output)!="") {		$output="<table bgcolor=#dddddd>".$output. "</table>";	}
}else{
	$output="";
	$fatal="";
}
?>