<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      rs03.php
 * @desc:      Reservas con objetos asignados ya vencidos
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
if (!isset($arrHttp["code"])) $arrHttp["code"]="rs03";
if (!isset($arrHttp["base"])) $arrHttp["base"]="reserve";
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";  //die;
if (!isset($arrHttp["vp"])) $arrHttp["vp"]="";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../reserve/reserves_read.php");

$bd=$arrHttp["base"];
$Nombre=$msgstr[$arrHttp["code"]];

function LlamarWxis($IsisScript,$query){global $db_path,$Wxis,$wxisUrl,$xWxis;
	include("../common/wxis_llamar.php");
	return $contenido;}

function LeerBasesDat($db_path){
global $ix_nb,$base_sel;
	$fp=file($db_path."bases.dat");
	$bases_p=array();
	foreach ($fp as $value){
		$value=trim($value);
		if (trim($value)!=""){
			$v=explode('|',$value);
			if (isset($v[2])){
				if ($v[2]=="Y"){
					$ix_nb=$ix_nb+1;
					$bases_p[$v[0]]=$v[0];
				}
			}
		}
	}
	return $bases_p;
}

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;
}

// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function LocalizarCopiasLoanObjects($control_number,$prestamos){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$politica;
    $Expresion="CN_".$arrHttp["base"]."_".$control_number;
	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";

	$Expresion=urlencode($Expresion);
	$formato_ex="(if p(v959) then v959^i,'||',v959^o/ fi)";
    // control number||database||inventory||main||branch||type||volume||tome
	$formato_obj=urlencode($formato_ex);
	$query = "&Opcion=disponibilidad&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=".$Expresion."&Pft=$formato_obj";
	include("../common/wxis_llamar.php");
	$total=0;
	$copies_title=array();
	$item="";
    $prestados=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=trim(substr($linea,8));
			}else{
				$l=explode('||',$linea);
				if (count($l)>0){
					if (isset($prestamos[$l[0]])){
						$f_dev= $prestamos[$l[0]];
						if ($f_dev!="")
							$prestados=$prestados+1;
					}else{
						$f_dev="";
					}
					$copies_title[]="<tr><td bgcolor=white>".$l[0]."</td><td bgcolor=white>".$l[1]."</td><td bgcolor=white>$f_dev</td></tr>\n";
				}
			}
		}
	}
	return array($copies_title,$prestados);
}


function LocalizarCopias($base,$control_number,$prestamos){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$politica,$msgstr,$lang_db;
	//SE LEE EL PREFIJO PARA EXTRAER EL NUMERO DE CONTROL DE LA BASE DE DATOS
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/loans_conf.tab";
	if (!file_exists($archivo)){
		echo $msgstr["falta"]."$db_path ".$base."/loans/".$_SESSION["lang"]."/loans_conf.tab";
		die;
	}else{
		$fp=file($archivo);
		foreach ($fp as $value){
			if (trim($value)!=""){
				$ix=strpos($value," ");
				$tag=trim(substr($value,0,$ix));
				switch($tag){
					case "IN": $prefix_in=trim(substr($value,$ix));
						break;
					case "NC": $prefix_cn=trim(substr($value,$ix));
						break;
				}
			}
		}
	}
	$pft_totalitems=LeerPft("loans_inventorynumber.pft",$base);
	$pft_typeofr=LeerPft("loans_typeofobject.pft",$base);
    $Expresion=$prefix_cn.$control_number;
	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$query = "&Opcion=disponibilidad&base=$base&cipar=$db_path"."par/$base".".par&Expresion=".$Expresion."&Pft=($pft_totalitems'||'".$pft_typeofr."/)/";
	include("../common/wxis_llamar.php");
	$total=0;
	$copies_title=array();
	$item="";
    $prestados=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=trim(substr($linea,8));
			}else{
				$l=explode('||',$linea);
				if (isset($prestamos[$l[0]])){
					$f_dev= $prestamos[$l[0]];
					if ($f_dev!=""){						$prestados=$prestados+1;					}
				}else{
					$f_dev="";
				}
				$copies_title[]="<tr><td bgcolor=white>".$l[0]."</td><td bgcolor=white>".$l[1]."</td><td bgcolor=white>$f_dev</td></tr>\n";
			}
		}
	}
	return array($copies_title,$prestados) ;
}


function LocalizarTransacciones($control_number,$prefijo){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$msgstr,$tr_prestamos;
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
	$query = "&Expresion=".$prefijo."_P_".$control_number."&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	foreach ($contenido as $linea){		if (trim($linea)!=""){
			$lp=explode('^',$linea);
			$prestamos[$lp[0]]=$lp[4];
        }
	}
	return $prestamos;
}

function BuscarEjemplaresDisponibles($base,$Control,$copies){global $arrHttp;	$prestamos=LocalizarTransacciones ($Control,"TC");
	switch ($copies){
		case "S":
			// SE DETERMINA LA DISPONIBILIDAD DE LOS EJEMPLARES DESDE LOANOBJECTS
			$items=LocalizarCopiasLoanobjects($Control,$prestamos);
			$disponibles=$items[0];
			$prestados=$items[1];
			break;
		case "N":
			// SE DETERMINA LA DISPONIBILIDAD DE LOS EJEMPLARES DESDE EL CATÁLOGO
			$items=LocalizarCopias($base,$Control,$prestamos);
			$disponibles=$items[0];
			$prestados=$items[1];
			break;
	}
	foreach ($items[0] as $value)
		echo $value;

    return count($disponibles)- $prestados;}

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

//SE LEE EL ARCHIVO BASES.DAT PARA SABER CUÁLES BASES DE DATOS SE ADMINISTRAN A TRAVÉS DE LOANOBJECTS
$lo_database=LeerBasesDat($db_path);

//SE LEE EL NÚMERO DE CONTROL DE LAS RESERVAS VIGENTES
$rows_title="tit_reserve_01.tab";
$rows=$db_path."reserve/pfts/".$_SESSION["lang"]."/".$rows_title;
if (!file_exists($rows)){
	$rows=$db_path."reserve/pfts/".$lang_db."/".$rows_title;
}
$data="";
$ixcols=0;
if (!file_exists($rows)){
	$msgerr= $rows. " ** ".$msgstr["falta"];
}else{	$fp=file($rows);
	foreach ($fp as $value){		if (trim($value)!=""){			$t=explode("|",$value);
			foreach($t as $head){				$ixcols++;
				echo "<td>$head</td>";
			}
			break;
		}	}
	echo "<td>".$msgstr["vence"]."</td>"."<td>".$msgstr["suspen"]."</td>"."<td>".$msgstr["multas"]."</td><td></td><tr>";
    $ixcols=$ixcols+6;
}
$Disp_format="reserve_01.pft";
$Pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Disp_format;
if (!file_exists($Pft)){
	$Pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$Disp_format;
}
if (!file_exists($Pft)){
	$msgerr= $Disp_format. " ** ".$msgstr["falta"];
}
$Sort="V15,v20";
$Pft="v15`$$$`V20`$$$`V10 `$$$`V40".'`$$$`f(mfn,1,0)`$$$`,@'.$Pft;
$query = "&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=ST_3&Opcion=buscar&Formato=".$Pft;
if ($Sort==""){
	$IsisScript=$xWxis."imprime.xis";
}else{
	$query.='&sortkey='.urlencode($Sort);
	$IsisScript=$xWxis."sort.xis";
}
$contenido=LlamarWxis($IsisScript,$query);

$key_comp="";
foreach ($contenido as $value){	$value=trim($value);	if ($value!=""){		$v=explode('$$$',$value);
		//SE LEEN LA BASE DE DATOS Y EL NÚMERO DE CONTROL PARA UBICAR EL TÍTULO Y DETERMINAR LOS EJEMPPLARES DISPONIBLES
		$bd=$v[0];
		$Control_no=$v[1];
		$arrHttp["usuario"]=$v[2];
		$fecha_anulacion=$v[3];
		if ($fecha_anulacion>date("Ymd")) continue;
		if ($bd.$Control_no!=$key_comp){
			if ($key_comp!=""){			}
			$key_comp=$bd.$Control_no;
		}
		$Mfn=$v[4];
		//SE LEEN LOS PRESTAMOS PENDIENTES DEL USUARIO PARA EXTRAER LA FECHA DE DEVOLUCION
		$query = "&Expresion=TRU_P_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Pft=V40/";
		$IsisScript=$xWxis."cipres_usuario.xis";
		$pp=LlamarWxis($IsisScript,$query);
		$vencidos=0;
		foreach ($pp as $prestamo)  {
			$prestamo=trim($prestamo);
			if ($prestamo!=""){
				if ($prestamo<date("Ymd")){
					$vencidos=$vencidos+1;
				}
			}
		}
		//SE LEEN LAS SUSPENSIONES DEL USUARIO
		$Expresion="(TR_S_".$arrHttp["usuario"]." or TR_M_".$arrHttp["usuario"].") and ST_0";
		$query = "&Expresion=$Expresion&base=suspml&cipar=$db_path"."par/suspml.par&Pft=v1'|',v60/";
		$IsisScript=$xWxis."cipres_usuario.xis";
		$total_multa=0;
		$total_susp=0;
		$sm=LlamarWxis($IsisScript,$query);
		foreach ($sm as $suspml)  {
			$suspm=trim($suspml);
			if ($suspml!=""){
				$vdate=explode('|',$suspml);
				switch ($vdate[0]){
					case "S":
						if ($vdate[1]>date("Ymd"))
							$total_susp=$total_susp+1;
						break;
					case "M":
						$total_multa=$total_multa+1;
						break;
				}
			}
		}
		$reservas=explode("|",$v[5]);
		if ($fecha_anulacion<date("Ymd")){		}
		foreach ($reservas as $rr){
			echo "<td bgcolor=white valign=top>$rr</td>";		}
		echo "<td bgcolor=white valign=top width=10 align=center>" ;
		if ($vencidos==0) $vencidos="";
		if ($total_susp==0) $total_susp="";
		if ($total_multa==0) $total_multa="";
		echo "$vencidos</td><td bgcolor=white valign=top width=10 align=center>$total_susp</td><td bgcolor=white valign=top align=center>$total_multa</td>";
		echo "</td>";
		echo "<td bgcolor=white nowrap valign=top><a href=javascript:DeleteReserve(".$Mfn.")><img src=../dataentry/img/toolbarDelete.png alt='".$msgstr["delete"]."' title='".$msgstr["delete"]."'></a>";
		echo "&nbsp;<a href=javascript:CancelReserve(".$Mfn.")><img src=../dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";
		echo "</td>";
		echo "</tr>";
	}}
if ($key_comp!=""){
	echo "</form>";
}
?>
</table>
</div></div>
</body>

</html>

<form name=reservas method=post action=../reserve/delete_reserve.php>
<input type=hidden name=Mfn_reserve>
<input type=hidden name=Accion>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<input type=hidden name=retorno value="../output_circulation/rs03.php">
<?php if (isset($arrHttp["reserve"])) echo "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";?>
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
function  AssignReserve(Mfn){
	document.reservas.Accion.value="assign"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}


</script>

