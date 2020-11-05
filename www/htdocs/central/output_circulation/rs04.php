<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      rs04.php
 * @desc:      Reservas atendidas
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

//date_default_timezone_set('UTC');
$debug="";
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";  //die;
if (!isset($arrHttp["vp"])) $arrHttp["vp"]="";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../reserve/reserves_read.php");

$bd=$arrHttp["base"];
$Nombre=$msgstr[$arrHttp["code"]];

function MostrarRegistroCatalografico($dbname,$CN){
global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db;
	$pref_cn="";
	$archivo=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$dbname."/loans/".$lang_db."/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$t=explode(" ",trim($value));
			if ($t[0]=="NC")
				$pref_cn=$t[1];
		}
	}
	if ($pref_cn=="") $pref_cn="CN_";
	$Expresion=$pref_cn.$CN;
	$formato_obj=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$dbname."/loans/".$lang_db."/loans_display.pft";
	$arrHttp["count"]="";
	$Formato=$formato_obj;
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=$dbname&cipar=$db_path"."par/".$dbname.".par&Expresion=".$Expresion."&Formato=$formato_obj";
	include("../common/wxis_llamar.php");
	$salida="";
	foreach ($contenido as $value){
		if (substr($value,0,8)!="[TOTAL:]")
			$salida.=$value;
	}
	$salida="(".$CN.") ".$salida;
	return $salida;
}

function LlamarWxis($IsisScript,$query){global $db_path,$Wxis,$wxisUrl,$xWxis;
	include("../common/wxis_llamar.php");
	return $contenido;}
include("../common/header.php");
include("../common/institutional_info.php");

?>
	<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="../circulation/estado_de_cuenta.php?reserve=S" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
<div class="middle form">
	<div class="formContent">
<?php
echo "<H3>$Nombre ";
echo "<br>".$msgstr["o_issued"].": ".date("d-m-Y")."</h3>";
echo "<p><table border=0 width=80% bgcolor=#cccccc>";
//SE LEEN LAS RESERVAS VIGENTES
$rows_title="tit_reserve.tab";
$rows=$db_path."reserve/pfts/".$_SESSION["lang"]."/".$rows_title;
if (!file_exists($rows)){
	$rows=$db_path."reserve/pfts/".$lang_db."/".$rows_title;
}
$data="";
if (!file_exists($rows)){
	$msgerr= $rows. " ** ".$msgstr["falta"];
}else{	$fp=file($rows);
	foreach ($fp as $value){		if (trim($value)!=""){			$t=explode("|",$value);
			foreach($t as $head){
				echo "<td>$head</td>";
			}
			break;
		}	}
}
$Disp_format="tbreserve.pft";
$Pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Disp_format;
if (!file_exists($Pft)){
	$Pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$Disp_format;
}
if (!file_exists($Pft)){
	$msgerr= $Disp_format. " ** ".$msgstr["falta"];
}
$Sort="ref(['users']l(['users']'CO_'v10),v30,)";
$Pft='@'.$Pft;
$query = "&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=ST_4&Opcion=buscar&Formato=".$Pft;
if ($Sort==""){
	$IsisScript=$xWxis."imprime.xis";
}else{
	$query.='&sortkey='.urlencode($Sort);
	$IsisScript=$xWxis."sort.xis";
}
$contenido=LlamarWxis($IsisScript,$query);

foreach ($contenido as $value){
	$value=trim($value);	if ($value!=""){
		$r=explode("|",$value);
		echo  "<tr>\n";
				echo  "<td  bgcolor=white valign=top width=80>".$r[4]."</td>"; //codigo usuario
				echo  "<td  bgcolor=white valign=top width=20>".$r[5]."</td>"; //tipo usuario
				echo  "<td  bgcolor=white valign=top width=100>".$r[6]."</td>";//nombre
				echo  "<td  bgcolor=white valign=top width=50>".$r[7]."-".$r[8]."</td>"; //base de datos
				echo "<td  bgcolor=white valign=top width=300> ";              //referencia
		        echo MostrarRegistroCatalografico($r[7],$r[8]);
		        echo "</td>";
			    echo "<td  bgcolor=white valign=top nowrap>";  //fecha reserva
			    echo $r[9];
			    echo "</td>";
			    echo  "<td  bgcolor=white valign=top>".$r[10]."</td>"; //Operador
			    echo  "<td  bgcolor=white valign=top nowrap>".$r[11]."</td>"; //lapso
			    echo  "<td  bgcolor=white valign=top nowrap>";
			    echo $r[12];
				echo "</td>";
			    echo  "<td  bgcolor=white valign=top nowrap>";
			    echo $r[13];
			    echo "</td>";
			    echo  "<td  bgcolor=white valign=top>"; //status
			    echo $r[14];
				echo "</td>";
				echo "</tr>";

	}}

?>
</table>
</div></div>
</body>

</html>

<form name=reservas method=post action=../reserve/delete_reserve.php>
<input type=hidden name=Mfn_reserve>
<input type=hidden name=Accion>
<input type=hidden name=retorno value="<?php echo "../output_circulation/rs02.php";?>">
<?php foreach ($arrHttp as $var=>$value)
	echo "<input type=hidden name=$var value=\"$value\">\n";
?>
</form>
<script>
function  DeleteReserve(Mfn){	document.reservas.Accion.value="delete"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}
function  CancelReserve(Mfn){
	document.reservas.Accion.value="cancel"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}


</script>

