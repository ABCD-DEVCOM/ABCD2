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

include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/profile.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
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
//VERIFICA SI ESTA MARCADO ALL PARA TODAS LAS BASES DE DATOS PARA TAMBIEN MARCAR LA CASILLA DE NIVEL SUPERIOR
function CheckAll(){	ixnum_db=0;
	ixchk_db=0;
	ixALL=0;
	for (db in datab){
	   ixnum_db=ixnum_db+1		ctrl=eval("document.profile.db_"+db)		if (ctrl.checked)
			ixchk_db=ixchk_db+1
		ctrl=eval("document.profile."+db+"_CENTRAL_ALL")
		if (ctrl.checked)
			ixALL=ixALL+1
	}
	if (ixALL==ixnum_db && ixchk_db==ixnum_db){
		document.profile.db_ALL.checked=true
	}}

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
		if (c[1]=="pft" || c[1]=="fmt" || c[2]=="ALL"){			if (c[2]=="ALL"){
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
<form name=profile action=profile_save.php onsubmit="javascript:return false" method=post>
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

function NewProfile($profile){global $db_path,$msgstr,$lang_db,$profiles_path;
	$fprofile=file("profiles.tab");
	$module="CENTRAL";
	foreach ($fprofile as $p){		$p=trim($p);
		if ($p=="[CIRCULATION]"){
			$module="CIRC";
		}else{			if ($p=="[ACQUISITIONS]"){				$module="ACQ";			}else{
				if ($p=="[ADMINISTRATION]"){					$module="ADM";				}else{
					$p=trim($p);
					if ($p!=""){						$p_el=explode("=",$p);
						$profile_usr[$module."_".$p_el[0]]="";
						$profile_general[$module][$p_el[0]]=$p;
					}
				}			}		}	}
//	echo "<pre>".print_r($profile_usr)."</pre>";die;
	if ($profile!=""){
		$fprofile=file($db_path."par/profiles/".$profile);
		foreach ($fprofile as $p){			$p=trim($p);
			if ($p!=""){				$p_el=explode("=",$p);
				$profile_usr[$p_el[0]]=$p_el[1];
			}
		}	}
//	echo "<xmp>";
//	print_r($profile_usr);
//	echo "</xmp>";//die;
	echo "<table>";
	echo "<tr><td>".$msgstr["PROFILENAME"]."</td><td><input type=text name=profilename size=15 value=\"";
	if (isset($profile_usr["profilename"])) echo $profile_usr["profilename"];
	echo "\"></td>";
	echo "<tr><td>".$msgstr["PROFILEDESC"]."</td><td><input type=text name=profiledesc size=80 value=\"";
	if (isset($profile_usr["profiledesc"])) echo $profile_usr["profiledesc"];
	echo "\"></td>";
	echo "</table>";
	$fp=file($db_path."bases.dat");
//	echo "<div style=\"position:relative;overflow:auto;height:300px;border-style:double;\">";
 	$inicio="S";
 	$bases_dat=array();
 	$select_db= "<select name=select_db
 	onchange=\"javascript:window.location.hash=this.options[this.selectedIndex].value\">\n<option></option>\n";
 	foreach($fp as $dbs){ 		$dbs=trim($dbs);
		if ($dbs!=""){
			$dd=explode('|',$dbs);
			$dbn=$dd[0];
			$select_db.= "<option value=".$dbn.">".$dd[1]." ($dbn)</option>\n";
		} 	}
 	$select_db.= "</select>\n";
	foreach ($fp as $dbs){
		$dbs=trim($dbs);
		if ($dbs!=""){			$dd=explode('|',$dbs);
			$dbn=$dd[0];
			if ($dd[0]!="acces" ){				echo "<a name=$dbn><table bgcolor=#cccccc class=listTable>";
				echo "<th width=33%>".$msgstr["DATABASES"]." ".$select_db."</th><th width=33%>".$msgstr["DISPLAYFORMAT"]."</th><th width=33%>".$msgstr["WORKSHEET"]."</TH>";
				if ($inicio=="S"){					$inicio="N";

					echo "<tr><td bgcolor=white colspan=3><input type=checkbox name=db_ALL value=ALL onclick=AllDatabases()><strong><font color=darkred size=+1>".$msgstr["ALL"]."</font></strong></td>";				}
                $bases_dat[$dbn]=$dbn;				echo "<tr><td valign=top bgcolor=white><input type=checkbox name=db_".$dbn." value=".$dbn;
				if (isset($profile_usr["db_".$dbn])) echo " checked";
				echo "><strong><font color=darkred>".$dd[1]." (".$dbn.")</font></strong></td>\n";
				echo "<td bgcolor=white valign=top>";
				$file=$db_path.$dbn."/pfts/".$_SESSION["lang"]."/formatos.dat";
				if (!file_exists($file)){					$file=$db_path.$dbn."/pfts/".$lang_db."/formatos.dat";				}
				$checked="";
				if (isset($profile_usr[$dbn."_pft_ALL"])) $checked=" checked";
				echo "<input type=checkbox name=".$dbn."_pft_ALL $checked>".$msgstr["ALL"]."<br>\n";
				if (file_exists($file)){
					$pft=file($file);
					foreach($pft as $val){						$val=trim($val);
						if ($val!=""){							$p=explode('|',$val);
							$checked="";
							if (isset($profile_usr[$dbn."_pft_".$p[0]])) $checked=" checked";
							echo "<input type=checkbox name=".$dbn."_pft_".$p[0]." value=".$p[0]." $checked";
							echo " onclick=document.profile.".$dbn."_pft_ALL.checked=false";
							echo ">".$p[1]." (".$p[0].")<br>\n";						}
					}
				}else{					echo "&nbsp;";				}
				echo "</td>";
				echo "<td bgcolor=white valign=top>";
				$file=$db_path.$dd[0]."/def/".$_SESSION["lang"]."/formatos.wks";
				if (!file_exists($file)){
					$file=$db_path.$dd[0]."/def/".$lang_db."/formatos.wks";
				}
				$checked="";
				if (isset($profile_usr[$dbn."_fmt_ALL"])) $checked=" checked";
				echo "<input type=checkbox name=".$dbn."_fmt_ALL $checked";
				echo ">".$msgstr["ALL"]."<br>\n";
				if (file_exists($file)){
					$pft=file($file);
					foreach($pft as $val){
						$val=trim($val);
						if ($val!=""){
							$p=explode('|',$val);
							$checked="";
							if (isset($profile_usr[$dbn."_fmt_".$p[0]])) $checked=" checked";
							echo "<input type=checkbox name=".$dbn."_fmt_".$p[0]." value=".$p[0]." $checked";
							echo " onclick=document.profile.".$dbn."_fmt_ALL.checked=false";
							echo ">".$p[1]." (".$p[0].")<br>\n";
						}
					}
				}else{					echo   "&nbsp";				}
				echo "</td>";
				echo "</table>";
				echo "<table width=100%><td valign=top colspan=3 align=left>\n";
				echo "<strong>".$msgstr["PERMISSIONS"].": ".$msgstr["DATAENTRY"]." ($dbn)</strong>\n";
		        $i=3;
		        $j=0;
				foreach ($profile_usr as $key=>$value){					$value=trim($value);
					if (substr($key,0,7)=="CENTRAL"){
						$k=explode("_",$key);
						//SE FILTRAN LOS PERMISOS QUE ANTES ESTABAN LIGADOS A LA BASE DE DATOS Y QUE AHORA PERTENECEN A ADMINISTRACION
						if ($k[1]=="CRDB" or $k[1]=="TRANSLATE"  or $k[1]=="USRADM" or $k[1]=="EDHLPSYS" ){
							continue;						}
						if ($i>2){
							echo "<tr>";
							$i=0;
						}

						$perm=$k[1];
						$i++;
						echo "<td width=33%>";
						echo "<input type=checkbox name=$dbn"."_".$key." value=Y";
						if (isset($profile_usr[$dbn."_".$key])) echo " checked";
						if ($j!=0){							echo " onclick=document.profile.$dbn"."_CENTRAL_ALL.checked=false";						}else{						}
						$j=1;
						echo ">".$msgstr[$k[1]]."</td>\n";
					}
				}
				echo "</table>";
				echo "<br><br>";
			}
		}	}

//	echo "</div>";
	$general=array("ADMINISTRATION","ADM","CIRCULATION","ACQUISITIONS");
	foreach ($general as $key){

		$bgcolor="";
		if (isset($msgstr[$key])) {			$bgcolor=" bgcolor=darkred";
			echo "<br><br>";
			echo "<table width=100%><tr height=5><th valign=top colspan=3 $bgcolor >\n";
			echo "<font color=white size=3>".$msgstr["PERMISSIONS"].": ".$msgstr[$key];
		}else{			echo "<table width=100%>";		}
		$modulo="ADM";
		switch($key){			case "ADMINISTRATION":
				$modulo="CENTRAL";
				break;
			case "CIRCULATION":
				$modulo="CIRC";
				break;
			case "ACQUISITIONS":
				$modulo="ACQ";
				break;		}
		$i=0;
		$j=0;
		$onclick="";
		$field="";
		$adm="";
		if (isset($profile_general[$modulo])){
			foreach ($profile_general[$modulo] as $usr_p=>$val){
	            $mod=$modulo;				if ($mod=="ADM" and $usr_p=="ALL") {
					$adm="Y";
					$field="ALL";
					$j=1;
					continue;				}else{					$adm="";				}				if ($modulo=="ADM" )$mod="CENTRAL";
				$i=$i+1;
				if ($i==1){
					echo "<tr>";
				}
				if ($j==0) $field=$usr_p;
				if ($j==1 ) {
					$onclick= "onclick=document.profile.$mod"."_".$field.".checked=false";
				}
				$j=1;
				$checked="";
				if (isset($profile_usr[$mod."_".$usr_p]) and $profile_usr[$mod."_".$usr_p]=="Y") $checked=" checked";
				echo "<td width=33%><input type=checkbox name=$mod"."_".$usr_p." $checked $onclick value=Y>".$msgstr[$usr_p]."</td>\n";
				$onclick="";
				if ($i>2){
					$i=0;
					echo "</tr>";
				}
			}
		}
		echo "</table>";
	}
	echo "</td></table>";
	echo "\n<script>\n";
	echo "datab= new Array()\n";
	foreach ($bases_dat as $value)
		echo "datab['$value']='$value'\n";
	echo "CheckAll()\n";
	echo "</script>\n";}
?>

