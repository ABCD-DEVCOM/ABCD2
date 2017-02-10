<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      profile_edit.php
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
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/header.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/profile.php");

echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
function returnObjById( id ){
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function DeleteProfile(Profile){	if (confirm("<?PHP echo $msgstr["DELETE"]?> "+Profile))
		self.location.href="profile_edit.php?profile="+Profile+"&Opcion=delete&encabezado=<?php echo $encabezado?>"
}

function AllDatabases(){
	ixdb=document.profile.elements.length
	for (id=0;id<ixdb;id++){		ctrl=document.profile.elements[id].name
		if (ctrl.substr(0,3)=="db_") {
			if (document.profile.db_ALL.checked){				document.profile.elements[id].checked=true
			}else{
				document.profile.elements[id].checked=false
			}		}
		c=ctrl.split("_")
		if (c[1]=="pft" || c[1]=="fmt"){			if (c[2]=="ALL"){
				if (document.profile.db_ALL.checked){
					document.profile.elements[id].checked=true
				}else{
					document.profile.elements[id].checked=false
				}
			}		}
	}}

function AllPermissions(){
	ixdb=document.profile.elements.length
	for (id=0;id<ixdb;id++){
		ctrl=document.profile.elements[id].name

		if (ctrl.substr(0,7)=="CENTRAL") {
			if (document.profile.CENTRAL_ALL.checked)
				document.profile.elements[id].checked=true
			else
				document.profile.elements[id].checked=false
		}
	}
}

function AllPermissionsCirculation(){
	ixdb=document.profile.elements.length
	for (id=0;id<ixdb;id++){
		ctrl=document.profile.elements[id].name

		if (ctrl.substr(0,4)=="CIRC") {
			if (document.profile.CIRC_CIRCALL.checked)
				document.profile.elements[id].checked=true
			else
				document.profile.elements[id].checked=false
		}
	}
}

function AllPermissionsAcquisitions(){
	ixdb=document.profile.elements.length
	for (id=0;id<ixdb;id++){
		ctrl=document.profile.elements[id].name

		if (ctrl.substr(0,3)=="ACQ") {
			if (document.profile.ACQ_ACQALL.checked)
				document.profile.elements[id].checked=true
			else
				document.profile.elements[id].checked=false
		}
	}
}
function ValidateName(Name){
	bool=  /^[a-z][\w]+$/i.test(Name)
 	if (bool){
        return true
   	}else {
      	return false
   	}
}

function SendForm(){
	Name=Trim(document.profile.profilename.value)
	re=/  /gi
	Name=Name.replace(re,' ')
	re=/ /gi
	Name=Name.replace(re,'_')
	document.profile.profilename.value=Name	if (Name==""){		alert("<?php echo $msgstr["MISSPROFNAME"]?>")
		return	}
	if (!ValidateName(Name)){
		alert("<?php echo $msgstr["INVPROFNAME"]?>")
		return
	}
	if (Trim(document.profile.profiledesc.value)==""){
		alert("<?php echo $msgstr["MISSPROFDESC"]?>")
		return
	}
    document.profile.submit()}
</script>

<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["PROFILES"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"users_adm.php?xx=s"."$encabezado\" class=\"defaultButton backButton\">";?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" /></a>
<?php if (isset($arrHttp["Opcion"])and $arrHttp["Opcion"]!="delete"){	  echo "<a href=\"javascript:SendForm()\" class=\"defaultButton saveButton\">";?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["SAVE"]?></strong></span></a>
<?php } ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/profiles.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp; &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/profiles.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/profile_edit.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<form name=profile action=profile_save.php onsubmit="javascript:return false" >
<?php
if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=S>\n";
if (!isset($arrHttp["Opcion"])){	DisplayProfiles();}else{	switch ($arrHttp["Opcion"]){		case "edit":
			EditProfile();
			break;
		case "new":
			NewProfile("");
			break;
		case "delete":
			DeleteProfile();
			break;	}}


echo "</form></div>
</div>
</center>";
include("../common/footer.php");
echo "</body></html>\n";



function DisplayProfiles(){global $db_path,$msgstr,$encabezado;
	echo "<table>";
	$fp=file($db_path."par/profiles/profiles.lst");
	foreach ($fp as $val){
		$val=trim($val);
		if ($val!=""){
			$p=explode('|',$val);
			if ($p[0]!="adm"){
				echo "<tr><td>".$p[1]." (".$p[0].")</td><td><a href=profile_edit.php?profile=".$p[0]."$encabezado&Opcion=edit>".$msgstr["EDIT"]."</A> | ";
				echo "<a href=javascript:DeleteProfile(\"".$p[0]."\")>".$msgstr["delete"]."</A></td>";
			}
		}
	}
	echo "</table>\n";
	echo "<a href=profile_edit.php?Opcion=new&encabezado=s>".$msgstr["new"]."</a>";}

function DeleteProfile(){global $db_path,$msgstr,$lang_db,$arrHttp,$xWxis,$wxisUrl,$Wxis;
// READ ACCES DATABASE AND FIND IF THE PROFILE IS IN USE
	$IsisScript=$xWxis."leer_mfnrange.xis";
	$query = "&base=acces&cipar=$db_path"."par/acces.par"."&Pft=v40^a/";
	include("../common/wxis_llamar.php");
	 foreach ($contenido as $linea){	 	if (trim($linea)==$arrHttp["profile"]){	 		echo "<h2>".$msgstr["INUSE"]."<h2>";
	 		return;	 	}
	}
    $fp=file($db_path."par/profiles/profiles.lst");
    $new=fopen($db_path."par/profiles/profiles.lst","w");
    foreach ($fp as $prof){    	$p=explode('|',$prof);
    	if ($p[0]!=trim($arrHttp["profile"]))
    		$res=fwrite($new,$prof);    }
    fclose($new);
    $res=unlink($db_path."par/profiles/".$arrHttp["profile"]);
	if ($res==0){
		echo $arrHttp["profile"].": The file could not be deleted";
	}else{
		echo "<h2>".$arrHttp["profile"]." ".$msgstr["deleted"]."</h2>";
	}
}

function EditProfile(){global $db_path,$msgstr,$lang_db,$arrHttp;
    $fp=file($db_path."par/profiles/".$arrHttp["profile"]);
    NewProfile($arrHttp["profile"]);}

function NewProfile($profile){global $db_path,$msgstr,$lang_db;
	$fprofile=file($db_path."par/profiles/profiles.tab");
	if (!$fprofile) {		echo $msgstr["NOTAB"];
		die;	}
	$dataentry=1;  //Esto se hace para compatibilizar con el archivo antiguo de perfiles que no decia '[DATAENTRY]' en la primera entrada
	foreach ($fprofile as $p){		$p=trim($p);

		if ($p=="" or substr($p,0,2)=="//") continue;
		switch ($p){			case "[CIRCULATION]":
				$module="CIRC";
				break;
			case "[ACQUISITIONS]":
				$module="ACQ";
				break;
			case "[DATAENTRY]":
				$module="DATAENTRY";
				break;
			case "[ADMINISTRATION]":
				$module="ADMI";
				break;
			default:
				if ($dataentry==1){					$dataentry=0;
					$module="DATAENTRY";
				}
		}
		if (substr($p,0,1)!="["){
			$p=trim($p);
			$p_el=explode("=",$p);
			$profile_usr[$module][$p_el[0]]=$p_el[1];
		}
	}
	if ($profile!=""){
		$fprofile=file($db_path."par/profiles/".$profile);
		foreach ($fprofile as $p){			$p=trim($p);
            if ($p=="[ADMINISTRATION]" or $p=="[CIRCULATION]" or  $p=="[ACQUISITIONS]"){            	$global_perms="S";            }
            if (!isset($global_perms)){
				if ($p!=""){					$p_el=explode("=",$p);
					if ($p_el[0]=="profilename"){						$profile_usr["profilename"][]=$p_el[1];
						continue;					}
					if ($p_el[0]=="profiledesc"){
						$profile_usr["profiledesc"][]=$p_el[1];
						continue;
					}

					if (substr($p,0,10)=="[DATABASE]"){						$base="S";
						$dataentry="N";
						continue;					}else{						if (substr($p,0,11)=="[DATAENTRY]"){							$base="N";
							$dataentry="S";
							continue;						}					}
					if ($base=="S"){						$dbn=$p_el[1];
						$base="";					}

					$profile_usr[$dbn][$p_el[0]]=$p_el[1];
				}
			}
		}	}
//	echo "<pre>";
//	print_r($profile_usr);echo "</pre>";
	echo "<table>";
	echo "<tr><td>".$msgstr["PROFILENAME"]."</td><td><input type=text name=profilename size=15 value=\"";
	if (isset($profile_usr["profilename"][0])) echo $profile_usr["profilename"][0];
	echo "\"></td>";
	echo "<tr><td>".$msgstr["PROFILEDESC"]."</td><td><input type=text name=profiledesc size=80 value=\"";
	if (isset($profile_usr["profiledesc"][0])) echo $profile_usr["profiledesc"][0];
	echo "\"></td>";
	echo "<tr><td><font size=+1>".$msgstr["PERMISSIONS"].": ".$msgstr["DATABASES"]."</td>";
	echo "</table>";
	$fp=file($db_path."bases.dat");
	echo "<div style=\"position:relative;overflow:auto;height:400px;border-style:double;\">";
    echo "<table bgcolor=#cccccc class=listTable>";
    echo "<td><input type=checkbox name=db_ALL value=Y><font size=+1 color=darkred> ".$msgstr["ALL"]."</font></td>";
    echo "</table>";
	foreach ($fp as $dbs){
		$dbs=trim($dbs);
		if ($dbs!=""){			$dd=explode('|',$dbs);
			if ($dd[0]!="acces" and $dd[0]!="suggestions" and $dd[0]!="purchaseorder"
			    and $dd[0]!="loanobjects" and $dd[0]!="suspml" and $dd[0]!="trans" and $dd[0]!="reserve"){				$dbn=$dd[0];
				echo "<table bgcolor=#cccccc class=listTable>";
				echo "<th>".$msgstr["DATABASES"]."</th><th>".$msgstr["DISPLAYFORMAT"]."</th><th>".$msgstr["WORKSHEET"]."</TH>";
				echo "<tr><td valign=top bgcolor=white width=33%><h2><input type=checkbox name=".$dbn."_db value=".$dbn;
				if (isset($profile_usr[$dbn][$dbn."_db"])) echo " checked";
				echo " onclick=document.profile.db_ALL.checked=false";
				echo "><font color=darkred>".$dd[1]." (".$dbn.")</font></h2></td>\n";
				echo "<td bgcolor=white valign=top width=33%>";
				$file=$db_path.$dbn."/pfts/".$_SESSION["lang"]."/formatos.dat";
				if (!file_exists($file)){					$file=$db_path.$dbn."/pfts/".$lang_db."/formatos.dat";				}
				$checked="";
				if (isset($profile_usr[$dbn][$dbn."_pft_ALL"])) $checked=" checked";
				echo "<input type=checkbox name=".$dbn."_pft_ALL $checked>".$msgstr["ALL"]."<br>\n";
				if (file_exists($file)){
					$pft=file($file);
					foreach($pft as $val){						$val=trim($val);
						if ($val!=""){							$p=explode('|',$val);
							$checked="";
							if (isset($profile_usr[$dbn][$dbn."_pft_".$p[0]])) $checked=" checked";
							echo "<input type=checkbox name=".$dbn."_pft_".$p[0]." value=".$p[0]." $checked onclick=document.profile.".$dbn."_pft_ALL.checked=false>".$p[1]." (".$p[0].")<br>\n";						}
					}
				}else{					echo "&nbsp;";				}
				echo "</td>";
				echo "<td bgcolor=white valign=top width=33%>";
				$file=$db_path.$dd[0]."/def/".$_SESSION["lang"]."/formatos.wks";
				if (!file_exists($file)){
					$file=$db_path.$dd[0]."/def/".$lang_db."/formatos.wks";
				}
				$checked="";
				if (isset($profile_usr[$dbn][$dbn."_fmt_ALL"])) $checked=" checked";
				echo "<input type=checkbox name=".$dbn."_fmt_ALL $checked>".$msgstr["ALL"]."<br>\n";
				if (file_exists($file)){
					$pft=file($file);
					foreach($pft as $val){
						$val=trim($val);
						if ($val!=""){
							$p=explode('|',$val);
							$checked="";
							if (isset($profile_usr[$dbn][$dbn."_fmt_".$p[0]])) $checked=" checked";
							echo "<input type=checkbox name=".$dbn."_fmt_".$p[0]." value=".$p[0]." $checked onclick=document.profile.".$dbn."_fmt_ALL.checked=false>".$p[1]." (".$p[0].")<br>\n";
						}
					}
				}else{					echo   "&nbsp";				}
				echo "</td>";
				echo "</table>";
                echo "<table class=listTable><td valign=top colspan=3 align=left>";
				echo "<strong>".$msgstr["PERMISSIONS"].": ".$msgstr["DATAENTRY"]." ($dbn)</strong>";
                $i=0;
                $j=0;
				foreach ($profile_usr["DATAENTRY"] as $key=>$usr_p){					if ($j==0) {						$field=$key;
						$checked="";					}
					$i=$i+1;
					if ($i==1){
						echo "<tr>";
					}
					if ($j==1){						$checked=" onclick=document.profile.".$dbn."_".$field.".checked=false";					}
					echo "<td width=33%><input type=checkbox name=$dbn"."_".$key;
					if (isset($profile_usr[$dbn][$key]) and $profile_usr[$dbn][$key]=="Y") echo " value=Y checked";
					echo $checked.">".$msgstr[$key]."</td>\n";
					$j=1;
					if ($i>2){
						$i=0;
						echo "</tr>";
					}
				}
				echo "</table>";
			}
		}
	}
	echo "</div>";
	$general=array("ADMINISTRATION","CIRCULATION","ACQUISITIONS");
	foreach ($general as $key){		echo "<P><table class=listTable><th valign=top colspan=3 align=left>\n";
		echo $msgstr["PERMISSIONS"].": ".$msgstr[$key];
		$i=0;
		$j=0;
		$onclick="";
		$field="";
		foreach ($profile_usr[$key] as $usr_p=>$val){			$i=$i+1;
			if ($i==1){
				echo "<tr>";
			}
			if ($j==0) $field=$usr_p;
			if ($j==1) {				$onclick= "onclick=document.profile.$key"."_".$field.".checked=false";
			}
			$j=1;
			echo "<td width=33%><input type=checkbox name=$key"."_".$usr_p." $onclick>".$msgstr[$usr_p]."</td>\n";
			$onclick="";
			if ($i>2){
				$i=0;
				echo "</tr>";
			}
		}
		echo "</table>";	}
}

?>

