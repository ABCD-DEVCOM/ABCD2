<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      usuario_prestamos_presentar.php
 * @desc:      Analyzes the user and item for establishing the loan policy
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
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";//die;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/ask_policy.php";
//echo $script_php;
//date_default_timezone_set('UTC');
$debug="";

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";

if (isset($arrHttp["db_inven"])){	$dbinv=explode('|',$arrHttp["db_inven"]);
	$_SESSION["loans_dbinven"]=$dbinv[0];}
include("../config.php");
//include("../config_loans.php");              // BORRADO EL 07/03/2013

$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("fecha_de_devolucion.php");
include ('../dataentry/leerregistroisispft.php');
require_once("../circulation/grabar_log.php");
include("leer_pft.php");

//Calendario de días feriados
include("calendario_read.php");

//Horario de la biblioteca, unidades de multa, moneda
include("locales_read.php");

// se leen las politicas de préstamo y la tabla de tipos de usuario
include("loanobjects_read.php");

// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");

# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$uskey=$t[0];

include("../reserve/reserves_read.php");
if (isset($arrHttp["reserve"])){	include("../reserve/seleccionar_bd.php");}

$valortag = Array();

$ec_output="" ;

function PrestamoMismoObjeto($control_number,$user,$base_origen){
global $copies_title,$msgstr,$obj;
	$msg="";	$tr_prestamos=LocalizarTransacciones($control_number,"ON",$base_origen);
	$items_prestados=count($tr_prestamos);
	if ($items_prestados>0){
		foreach($tr_prestamos as $value){
			if (trim($value)!=""){
				$nc_us=explode('^',$value);
		   		$pi=$nc_us[0];                                   //GET INVENTORY NUMBER OF THE LOANED OBJECT
		   		$pv=$nc_us[14];                                  //GET THE VOLUME OF THE LOANED OBJECT
		   		$pt=$nc_us[15];                                  //GET THE TOME OF THE LOANED OBJECT
				$comp=$pi." ".$pv." ".$pt;
				foreach ($copies_title as $cop){
					$c=explode('||',$cop);
					$comp_01=$c[2];
					if (isset($c[6]))
						$comp_01.=" ".$c[6];
					if (isset($c[7]))
						$comp_01.=" ".$c[7];
					if ($nc_us[10]==$user){    //SE VERFICA SI LA COPIA ESTÁ EN PODER DEL USUARIO
						if ($comp_01==$comp and $obj[14]!="Y"){
							if ($msg=="")
								$msg= $msgstr["duploan"];
							else
								$msg.="<br>".$msgstr["duploan"];
						}
					}
				}
			}
	    }

	}
	return array($msg,$items_prestados);}

function LocalizarReservas($control_number,$catalog_db,$usuario,$items_prestados,$prefix_cn,$copies,$pft_ni) {
global $xWxis,$Wxis,$db_path,$msgstr,$wxisUrl;
	$IsisScript=$xWxis."cipres_usuario.xis";
	// Mfn
	// 10:codigo de usuario
	// 30:Fecha reserva
	// 31:Hora de reserva
	// 40:Fecha límite de retiro
	// 60:Fecha de asignacion de la reserva
	// 130:Fecha de cancelación de la reserva
	// 200:Fecha en que se ejecutó la reserva y se prestó el item al usuario
	$Pft=urlencode("f(mfn,6,0)'|'v10'|'v30'|'v31'|'v40'|'v60'|'v130'|'v200,'|',v1/");
	$Expresion=urlencode("CN_".$catalog_db."_".$control_number." AND (ST_3 or ST_0)");
	$query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=$Expresion&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$reservas=array();
	$reservas_3=array();
	$reservas_0=array();
	foreach ($contenido as $value){
		$value=trim($value);
		if ($value!=""){
			$r=explode('|',$value);
			$Mfn=$r[0];
			$fecha_reserva=$r[2];
			$hora_reserva=$r[3];
			$fecha_cancelacion=$r[6];  //Fecha en la cual el operador canceló la reserva
			$fecha_limite=$r[4];      //Fecha hasta la cual la reserva asignada está disponible
			$fecha_asignacion=$r[5];  //Fecha en la cual se asignó la reserva
			$fecha_prestamo=$r[7];    //Fecha en la cual se prestó el objeto reservado
			$status=$r[8];
			//SE BUSCAN LAS RESERVAS ASIGNADAS
			if ($fecha_cancelacion!=""  or $fecha_prestamo!="") continue;
			if ($fecha_limite!=""){
				if ($fecha_limite<date("Ymd")) continue;
			}
			if ($status==3){				$reservas_3[$fecha_asignacion." ".$Mfn]=$value;
			}else{				$reservas_0[$fecha_reserva." ".$hora_reserva." ".$Mfn]=$value;
			}
			//$reservas[$fecha_reserva." ".$hora_reserva." ".$Mfn]=$value;  //Total de rservas
		}
	}
	ksort($reservas_3);
	ksort($reservas_0);
	$Cod_usuario=0;
	$value="";
	//echo "<xmp>";var_dump($reservas_3);var_dump($reservas_0);echo "</xmp>";//die;

	//SI NO HAY RESERVAS ASIGNADAS O RESERVAS PEDIENTES LE ASIGNAMOS EL PRESTAMO
	if (count($reservas_3)==0 and count($reservas_0)==0){
		return array("continuar",0);
	}

	//VEMOS SI EL USUARIO ES EL PRIMERO DE LA COLA DE RESERVAS ASIGNADAS
	//SI NO HAY RESERVAS ASIGNADAS VERIFICAMOS SI ES EL PRIMERO DE LA COLA DE RESERVAS PENDIENTES
 	if (count($reservas_3)>0){ 		$value=array_shift(array_slice($reservas_3, 0, 1));
 	}else{		if (count($reservas_0)>0){ 			$value=array_shift(array_slice($reservas_0, 0, 1));
 		} 	}
	if ($value!=""){		$v=explode('|',$value);
		if ($usuario==$v[1])			return array("continuar",$v[0]);	}

	//DETERMINAMOS EL TOTAL DE EJEMPLARES QUE TIENE EL TITULO
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	if ($copies=="Y"){
		$Expresion="CN_".$catalog_db."_".$control_number;
		$catalog_db="loanobjects";
		$pft_ni="(v959/)";
	}else{
		//SE LEE EL PREFIJO A UTILIZAR PARA LOCALIZAR EL OBJETO A TRAVÉS DE SU NÚMERO DE INVENTARIO
		$Expresion=$prefix_cn.$control_number;
		$catalog_db=strtolower($catalog_db);
		$pft_ni="(".$pft_ni."/)";
	}
	$query = "&Opcion=disponibilidad&base=$catalog_db&cipar=$db_path"."par/$catalog_db.par&Expresion=".$Expresion."&Pft=".urlencode($pft_ni);
	include("../common/wxis_llamar.php");
	$obj=array();
	foreach ($contenido as $value){
		$value=trim($value);
		if (trim($value)!="" and substr($value,0,8)!='$$TOTAL:')
			$obj[]=$value;
	}
	$disponibilidad=count($obj)-$items_prestados;
    //echo "Total ejemplares: ".count($obj)."  prestados ".$items_prestados;die;
	//SI HAY EJEMPLARES DISPONIBLES VEMOS SI SE LE PUEDE PRESTAR AL USUARIO PORQUE ESTÁ EN ALGUN LUGAR LA COLA DE RESERVAS ASIGNADAS
	if ($disponibilidad-1>0){		foreach ($reservas_3 as $value){			 if (trim($value)!=""){			 	$r=explode('|',$value);
					if ($r[1]==$usuario){
						return array("continuar",$r[0]);
				}			 }		}	}

	//SI HAY EJEMPLARES DISPONIBLES VEMOS SI SE LE PUEDE PRESTAR AL USUARIO PORQUE ESTÁ EN ALGUN LUGAR LA COLA DE RESERVAS PENDIENTES
	if ($disponibilidad-1>0){
		foreach ($reservas_0 as $value){
			 if (trim($value)!=""){
			 	$r=explode('|',$value);
					if ($r[1]==$usuario){
						return array("continuar",$r[0]);
				}
			 }
		}
	}

	//SI EL USUARIO NO ESTÁ EN NINGUNA DE LAS COLAS DE RESERVA
	//SE LE RESTA A LA DISPONIBILIDAD LAS RESERVAS ASIGNADAS Y LAS RESERVAS PENDIENTES

	$disponibilidad=$disponibilidad-count($reservas_3)-count($reservas_0);

	//SI QUEDAN EJEMPLARES DISPONIBLES, SE LE DA EL PRÉSTAMO AL USUARIO
	//echo ($disponibilidad);die;
	if ($disponibilidad>0){		return array("continuar",0);	}
	return array("no_continuar",0);
}


// Se localiza el número de control en la base de datos bibliográfica
function ReadCatalographicRecord($control_number,$db,$inventory){
global $Expresion,$db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_ni,$pft_nc,$pft_typeofr,$titulo,$prefix_in,$prefix_cn,$multa,$pft_storobj,$lang_db;
	//Read the FDT of the database for extracting the prefix used for indexing the control number
//	echo $control_number;
	$pft_typeofr=str_replace('~',',',$pft_typeofr);
	if (isset($arrHttp["db_inven"])){		$dbi=explode("|",$arrHttp["db_inven"]);
	}else{		$dbi[0]="loanobjects";
	}

	if (isset($arrHttp["db_inven"]) and $dbi[0]!="loanobjects"){

		$Expresion=trim($prefix_cn).trim($control_number);
	}else{
	    $Expresion="CN_".trim($control_number);
	}
	if ($control_number=="")		$Expresion=$prefix_in.$inventory;
//    echo $Expresion;
	// Se extraen las variables necesarias para extraer la información del título al cual pertenece el ejemplar
	// se toman de databases_configure_read.php
	// pft_totalitems= pft para extraer el número total de ejemplares del título
	// pft_in= pft para extraer el número de inventario
	// pft_nc= pft para extraer el número de clasificación
	// pft_typeofr= pft para extraer el tipo de registro

	$formato_ex="'||'".$pft_nc."'||'".$pft_typeofr."'###',";
	//se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$db. "/loans/".$lang_db."/loans_display.pft";
	//$formato_obj.=", /".urlencode($formato_ex).urlencode($pft_storobj);
    $formato_obj.=urlencode(", /".$formato_ex.$pft_storobj);
	$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=@$formato_obj";
	include("../common/wxis_llamar.php");
	$total=0;
	$titulo="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (trim($linea)!=""){
			if (substr($linea,0,8)=='$$TOTAL:')
				$total=trim(substr($linea,8));
			else
				$titulo.=$linea."\n";
		}
	}
	return $total;
}

// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function LocalizarInventario($inventory){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_ni,$pft_nc,$pft_typeofr,$copies_title,$prefix_in,$multa;
    $Expresion=$prefix_in.$inventory;
	// Se extraen las variables necesarias para extraer la información del título al cual pertenece el ejemplar
	// se toman de databases_configure_read.php
	// pft_totalitems= pft para extraer el número total de ejemplares del título
	// pft_in= pft para extraer el número de inventario
	// pft_nc= pft para extraer el número de clasificación
	// pft_typeofr= pft para extraer el tipo de registro

	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";

	$Expresion=urlencode($Expresion);
	if (isset($arrHttp["db_inven"])){		$dbi=explode('|',$arrHttp["db_inven"]);
		$dbi_base=$dbi[0];	}
	if (isset($arrHttp["db_inven"]) and $dbi_base!="loanobjects"){
	//IF NO LOANOBJECTS READ THE PFT FOR EXTRACTING THEN INVENTORY NUMBER AND THE TYPE OF RECORD		$d=explode('|',$arrHttp["db_inven"]);
		$arrHttp["base"]=strtolower($d[0]);
		$arrHttp["db_inven"]=strtolower($d[0]);
		$pft_typeofrec=LeerPft("loans_typeofobject.pft",$d[0]);
		$pft_typeofrec=str_replace("/"," ",$pft_typeofrec);
		$pft_typeofrec=str_replace("\n"," ",$pft_typeofrec);
		$pft_typeofrec=trim($pft_typeofrec);
	//SE SACAN LOS FORMATOS DE LOS DIFERENTES TIPOS DE REGISTRO DE LOS CAMPOS DE INVENTARIO
		$ixpni=strpos($pft_typeofrec,'~');
		if ($ixpni>0){
			$tofr1=substr($pft_typeofrec,0,$ixpni);
			$tofr2=substr($pft_typeofrec,$ixpni+1);
		}
		$pft_nc=LeerPft("loans_cn.pft",$d[0]);
		$pft_nc=str_replace("/"," ",$pft_nc);
		$pft_ni=LeerPft("loans_inventorynumber.pft",$d[0]);
		$pft_ni=str_replace("/"," ",$pft_ni);
		$pft_ni=str_replace("\n"," ",$pft_ni);
		$ixpni=strpos($pft_ni,'~');
		if ($ixpni>0){
			$nvi1=substr($pft_ni,0,$ixpni);
			if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
			$formato_ex="('||".$d[0]."||',$nvi1,'||||||',".$tofr1.",'||||||'/)";

			$nvi1=substr($pft_ni,$ixpni+1);
			if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
			$formato_ex.=",('||".$d[0]."||',$nvi1,'||||||',".$tofr2.",'||||||'/)";
			$formato_ex=$pft_nc.",".$formato_ex;
		}else{
			if (isset($_SESSION["library"])) $pft_ni=str_replace('#library#',$_SESSION['library'],$pft_ni);
			$formato_ex="$pft_nc,('||".$d[0]."||',$pft_ni,'||||||',".$pft_typeofrec.",'||||||'/)";
		}
		if (isset($_SESSION["library"])) $formato_ex=str_replace('#v5000#',"'".$_SESSION["library"]."'",$formato_ex);
	}else{		$arrHttp["base"]="loanobjects";
		$formato_ex="(v1[1]'||'v10[1],'||',v959^i,'||',v959^l,'||',v959^b,'||',v959^o,'||',v959^v,'||',v959^t,'||'/)";
    // control number||database||inventory||main||branch||type||volume||tome	}
	$formato_obj=urlencode($formato_ex);
	$query = "&Opcion=disponibilidad&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Expresion=".$Expresion."&Pft=$formato_obj";
	include("../common/wxis_llamar.php");
	$total=0;
	$copies_title=array();
	$item="";
    $cno="";
    $tto="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=trim(substr($linea,8));
			}else{
				$t=explode('||',$linea);
				if ($t[0]!="" ) $cno=$t[0];
				if ($t[5]!="")  $tto=$t[5];
				if ($t[0]=="" ) $t[0]=$cno;
				if ($t[5]=="")  $t[5]=$tto;
				$linea="";
				foreach ($t as $value){					$linea.=trim($value)."||";				}
				if (strtoupper($inventory)==strtoupper(trim($t[2]))) $item=$linea;

				$copies_title[]=$linea;
			}
		}
	}
	//echo $item;
	$ret=array($total,$item);
	//echo"**" .$total." - ".$item;   die;
	return $ret ;
}

//se busca el numero de control en el archivo de transacciones para ver si el usuario tiene otro ejemplar prestado
function LocalizarTransacciones($control_number,$prefijo,$base_origen){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$msgstr;
	$tr_prestamos=array();
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
	$query = "&Expresion=".$prefijo."_P_".$control_number;
	if (isset($arrHttp["year"]) or isset($arrHttp["volumen"])){		$query.="_";
		if (isset($arrHttp["year"])) $query.="A:".$arrHttp["year"];
		if (isset($arrHttp["volumen"])) $query.="V:".$arrHttp["volumen"];
		if (isset($arrHttp["numero"])) $query.="N:".$arrHttp["numero"];
	}

	$query.="&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	foreach ($contenido as $linea){
		if (trim($linea)!=""){
			$l=explode('^',$linea);
			if (isset($l[13])){
				if ($base_origen==$l[13])
					$tr_prestamos[]=$linea;
			}else{				$tr_prestamos[]=$linea;			}        }
	}
	return $tr_prestamos;
}


// ------------------------------------------------------
// INICIO DEL PROCESO
//--------------------------------------------------------------
///////////////////////////////////////////////////////////////////////////////////////////


//foreach ($arrHttp as $var => $value) echo "$var = $value<br>"; die;

// ARE THE COPIES IN THE COPIES DATABASE OR IN THE BIBLIOGRAPHIC DATABASE?

if (isset($arrHttp["db_inven"])){	$dbi=explode('|',$arrHttp["db_inven"]);
	if ($dbi[0]!="loanobjects"){
		$from_copies="N";
		$x=explode('|',$arrHttp["db_inven"]);
    	$var=LeerPft("loans_conf.tab",$x[0]);
		$prefix_in=trim($x[2]);
	}else{
		$prefix_in="IN_";
		$from_copies="Y";
	}
}else{	$prefix_in="IN_";
	$from_copies="Y";}
if (isset($arrHttp["Opcion"])){
	if ( $arrHttp["Opcion"]=="reservar")
		$msg_1=$msgstr["reserve"];
	else
		if ($arrHttp["Opcion"]=="prestar") $msg_1=$msgstr["loan"];
}



$link_u="";
if (isset($arrHttp["usuario"])) $link_u="&usuario=".$arrHttp["usuario"];
if (isset($arrHttp["inventory"])) $presentar_reservas="N";
$nmulta=0;
$nsusp=0;
$cont="";
$np=0;
$nv=0;
include("ec_include.php");  //se incluye el procedimiento para leer el usuario y los préstamos pendientes
if ($nmulta!=0 or $nsusp!=0) {	$cont="N";
	//echo $nmulta."  *** $nsusp"; die;
	unset($arrHttp["inventory"]);}
if (count($prestamos)>0) $ec_output.= "<strong><a href=javascript:DevolverRenovar('D')>".$msgstr["return"]."</a> | <a href=javascript:DevolverRenovar('R')>".$msgstr["renew"]."</a></strong><p>";

//Se obtiene el código, tipo y vigencia del usuario
$formato=$pft_uskey.'\'$$\''.$pft_ustype.'\'$$\''.$pft_usvig;
$formato=urlencode($formato);
$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path"."par/users.par&Pft=$formato";
$contenido="";
$IsisScript=$xWxis."cipres_usuario.xis";
include("../common/wxis_llamar.php");
$user="";
$msgsusp="";
$vig="";

foreach ($contenido as $linea){	$linea=trim($linea);
	if ($linea!="")  $user.=$linea;
}

if (trim($user)==""){	ProduceOutput("<h4>".$msgstr["userne"]."</h4>","");
	die;
}else{
    if (isset($arrHttp["ecta"])){    	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){      //para ver si tiene activado el módulo de reservas. Se lee desde el abcd.def
			$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"]);
			$reserves_user=$reserves_arr[0];
		}else{			$reserves_user="";		}
	}else
		$reserves_user="";
	if ($nsusp>0 or $nmulta>0) {		 $msgsusp= "pending_sanctions";
		 $vig="N";	}else{	//Se analiza la vigencia del usuario
		$userdata=explode('$$',$user);
	    if (trim($userdata[2])!=""){	    	if ($userdata[2]<date("Ymd")){	    		$msgsusp= "limituserdata";
				$vig="N";	    	}    	}
    }}
$ec_output.= "\n
<script>
  Vigencia='$vig'
  np=$np
  nv=$nv
</script>\n";
if ($msgsusp!=""){	$ec_output.="<font color=red><h3>**".$msgstr[$msgsusp]."</h3></font>";
	if ($reserves_user!="")
		$ec_output.="<p><strong>".$msgstr["reserves"]."</strong><br>".$reserves_user."<p>";
	ProduceOutput($ec_output,"");
	die;}
//OJO AGREGARLE AL TIPO DE USUARIO SI SE LE PUEDEN PRESTAR CUANDO ESTÁ VENCIDO
if ($nv>0 and isset($arrHttp["inventory"])){
	$ec_output.= "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
	ProduceOutput($ec_output,"");
	die;
}
//Se verifica si puede recibir más préstamos
if ($np>=$tipo_u[strtoupper($userdata[1])] and trim($tipo_u[strtoupper($userdata[1])])!="" ){
	$ec_output.= "<font color=red><h3>".$msgstr["allowloans"].": ".$tipo_u[strtoupper($userdata[1])].". ".$msgstr["nomoreloans"]."</h3></font>";
	ProduceOutput($ec_output,"");
	die;
}

//////////////////////////////////////////////////////////////////
// Si viene desde la opción de prestar, se localiza el número de inventario solicitado

$xnum_p=$np;
$prestamos_este=0;

if (isset($arrHttp["inventory"]) and $vig=="" and !isset($arrHttp["prestado"]) and !isset($arrHttp["renovado"]) and !isset($arrHttp["devuelto"])){

	$ec_output.="<table width=100% bgcolor=#cccccc><td></td>
		<td width=50 align=center><strong>".$msgstr["inventory"]."</strong></td><td width=50 align=center><strong>".$msgstr["control_n"]."<strong></td><td align=center><strong>".$msgstr["reference"]."<strong></td><td align=center><strong>".$msgstr["typeofitems"]."</strong></td><td align=center><strong>".$msgstr["devdate"]."</td>\n";

    $invent=explode("\n",trim(urldecode($arrHttp["inventory"])));
    $primera_vez="";
    foreach ($invent as $arrHttp["inventory"]){
    	$arrHttp["inventory"]=trim($arrHttp["inventory"]);
    	if ($arrHttp["inventory"]=="") continue;
    	$cont="Y";
    	/*if (isset($inventory_numeric) and $inventory_numeric =="Y"){
    		$i=0;
    		while (substr($arrHttp["inventory"],$i,1)=="0"){
    			$i++;
    			$arrHttp["inventory"]=substr($arrHttp["inventory"],$i,1);
    		}
    	}
    	$arrHttp["inventory"]=trim($arrHttp["inventory"]);
    	*/
    	if (isset($_SESSION["library"])) $arrHttp["inventory"]=$_SESSION["library"]."_".$arrHttp["inventory"];
    	$ec_output.="<tr>";
    	$este_prestamo="";
        $este_prestamo.= "<td bgcolor=white valign=top align=center><font color=red>".$arrHttp["inventory"]."</font></td>";
	//Se ubica el ejemplar en la base de datos de objeto
		$res=LocalizarInventario($arrHttp["inventory"]);
		$total=$res[0];
		$item=$res[1];
		if ($total==0){
			$este_prestamo.= "<td bgcolor=white valign=top></td><td bgcolor=white></td><td  bgcolor=white valign=top></td><td bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["copynoexists"]."</font></td>";
			$cont="N";
			$ec_output.="<td bgcolor=white></td>".$este_prestamo;
 			//ProduceOutput($ec_output,"");
		}else{
		//se extrae la información del número de control del título y la base de datos catalográfica a la cual pertenece
			$tt=explode('||',$item);
			$control_number=$tt[0];

			$catalog_db=strtolower($tt[1]);
    		$tipo_obj=trim($tt[5]);      //Tipo de objeto

// se lee la configuración de la base de datos de objetos de préstamos
			$arrHttp["db"]="$catalog_db";
			$este_prestamo.="<td bgcolor=white valign=top align=center>$control_number  ($catalog_db)</td>";
            require_once("databases_configure_read.php");
			$ppres="";
    		$tipo_obj=trim(strtoupper($tipo_obj));
    		$userdata[1]=trim(strtoupper($userdata[1]));
            $pol=array();
            if ($tipo_obj==""){
            	$select_policy= "<select name=using_pol>";
	    		foreach ($politica as $objeto){
	    			foreach ($objeto as $value){
	    				$o=explode('|',$value);
	    				if (strtoupper($o[1])==strtoupper($userdata[1]))
	    					$select_policy.="<Option value='$value'>".$tipo_item[strtoupper($o[0])]." (".$o[0].")"."</option>\n";
	    			}
	    		}
	    		$select_policy.= "</select>\n";
	    		$select_policy.=" <input type=button name=prestar value=\"".$msgstr["loan"]."\" onclick=Javascript:Prestar()>";
            }else{            	$select_policy="$tipo_obj";            }
			$fechal_usuario="";
			$fechal_objeto="";
			//SE VERIFICA SI EL USUARIO TIENE PRÉSTAMOS VENCIDOS
            if ($nv>0 and isset($arrHttp["inventory"]) and $obj[12]!="Y" and $obj[13]!="Y"){
				$este_prestamo.= "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
				$cont="N";
			}
			//Se verifica si el usuario puede recibir más préstamos en total
			//SE ASIGNA EL TOTAL DE PRESTAMOS QUE PUEDE RECIBIR UN USUARIO  SEGUN EL TIPO DE OBJETO  (calculado en loanobjects_read.php)
			if ($cont=="Y"){
		// Se localiza el registro catalográfico utilizando los datos anteriores
				$ref_cat=ReadCatalographicRecord($control_number,$catalog_db,$arrHttp["inventory"]);

	 			if ($ref_cat==0){      //The catalographic record is not found
	 				$este_prestamo.= "<td  bgcolor=white valign=top></td><td  bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["catalognotfound"]." ($catalog_db)</font></td>";
					$cont="N";
	 			}
	 			if ($ref_cat>1){      //More than one catalographic record

	 				$este_prestamo.= "<td  bgcolor=white valign=top></td><td  bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["dupctrl"]." ($catalog_db)</font></td>";
					$cont="N";
	 			}
	 			if ($cont=="Y"){
		 			$tt=explode('###',trim($titulo));
		    		$obj_store=$tt[1];
					$tt=explode('||',$tt[0]);
					$titulo=$tt[0];
					if (isset($arrHttp["year"]))    $titulo.=" Año:".$arrHttp["year"];
					if (isset($arrHttp["volumen"])) $titulo.=" Volumen:".$arrHttp["volumen"];
					if (isset($arrHttp["numero"]))  $titulo.=" Número:".$arrHttp["numero"];
					if (isset($arrHttp["comments"]))
		    			$titulo.=" <font color=darkred>".$arrHttp["comments"]."</font>";
					$signatura=$tt[1];     //signatura topográfica
		    		$este_prestamo.= "<td bgcolor=white valign=top>$titulo</td>";
		    		$este_prestamo.= "<td bgcolor=white valign=top>";
		    		$grabar="Y";
					$este_prestamo.="</td>";

	// se verifica si el ejemplar está prestado
					$tr_prestamos=LocalizarTransacciones($arrHttp["inventory"],"TR",$catalog_db);
					$Opcion="";
					$msg="";
					$msg_1="";
					if (count($tr_prestamos)>0){   // Si ya existe una transacción de préstamo para ese número de inventario, el ejemplar está prestado
						$cont="N";
						$msg.="<font color=red>".$msgstr["itemloaned"]."<br></font>";
	        		}
					//SE VERIFICA SI EL USUARIO YA TIENE UN MISMO EJEMPLAR, VOLUMEN Y TOMO DE ESE TÍTULO Y SI SE LE PERMITE O NO
					$var=PrestamoMismoObjeto($control_number,$arrHttp["usuario"],$catalog_db);
					$msg_1=$var[0];
					$items_prestados=$var[1];
					if ($msg_1!=""){
	        			$cont="N";
	        			$msg.="<font color=red>".$msg_1."</font>";
	        		}
	        		if ($msg!="")
	        			$este_prestamo.="<td bgcolor=white valign=top>".$msg."</td>";
	        		if ($cont=="Y"){
	        			$msg="";
	        			$ec_output.="<td bgcolor=white valign=top>";	        			if ($grabar=="Y"){
	        				//SE LOCALIZA SI EL TITULO ESTÁ RESERVADO
	        				if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){         //para ver si tiene activado el módulo de reservas se lee desde el abcd.def
	        					$reservado=LocalizarReservas($control_number,$catalog_db,$arrHttp["usuario"],$items_prestados,$prefix_cn,$from_copies,$pft_ni);
	        					$mfn_reserva=$reservado[1];
	        				}else{	        					$reservado=array("continuar",0);
	        					$mfn_reserva=0;	        				}

	        				//echo "mfnreserva: ".$mfn_reserva;
	        				if ($reservado[0]=="continuar"){
	        					//echo  "<p>np:".$np. " total_prestamos_usuario: $tprestamos_p total_prestamos_politica: ". $total_prestamos_politica ."  total_politica[$tipo_obj]: ". $total_politica[$tipo_obj]."<br>";
	  						}

  						}
						$este_prestamo.="</td>";
						$ec_output.=$este_prestamo;
						$Opcion="prestar";
						$msg_1=$msgstr["loan"];
						if ($grabar=="Y"){							//$devolucion=ProcesarPrestamo($arrHttp["usuario"],$arrHttp["inventory"],$signatura,$item,$userdata[1],$from_copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva);

						}else{							$devolucion=array();
						}
						$ec_output.="<td bgcolor=white valign=top >$msg";
                        $ec_output.=$select_policy;

						$ec_output.="</td><td bgcolor=white valign=top ></td> ";
	           		}else{	           			$ec_output.="<td bgcolor=white></td>".$este_prestamo;	           		}
				} else{					$ec_output.="<td bgcolor=white></td>".$este_prestamo;				}
			}else{				$ec_output.="<td bgcolor=white></td>".$este_prestamo;			}
		}
	}
	$ec_output.="</table>";


}

if ($prestamos_este>0) $ec_output.= "<strong><a href=javascript:DevolverRenovar('D')>".$msgstr["return"]."</a></strong>\n";
if ($reserves_user!="")
	$ec_output.="<p><!--strong>".$msgstr["reserves"]." <font color=red>(user)</font></strong><br -->".$reserves_user."<p>";
ProduceOutput($ec_output,"");

function ProduceOutput($ec_output,$reservas){global $msgstr,$arrHttp,$signatura,$msg_1,$cont,$institution_name,$lang_db,$copies_title,$link_u,$recibo_arr,$db_path,$Wxis,$xWxis,$wxisUrl,$script_php,$logo,$css_name;global $prestamos_este,$xnum_p,$reserve_active;
	include("../common/header.php");    echo "<body>";
 	include("../common/institutional_info.php");
 	include("../circulation/scripts_circulation.php");
?>
<script>
function Prestar(){
	document.ecta.action="usuario_prestamos_presentar.php"	document.ecta.submit()	return}
</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php
echo "<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/loan.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/loan.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/ask_policy.php </font>
	</div>";
?>
<div class="middle form">
	<div class="formContent">
<form name=ecta action=usuario_prestamo_presentar.php method=post>

<?php
foreach ($_REQUEST as $var=>$value){	echo "<input type=hidden name=$var value=\"$value\">\n";}
if ($xnum_p=="") $xnum_p=0;
$ec_output.= "</form>";
$ec_output.="<script>
		np=$xnum_p
		</script>\n";
$ec_output.= "<form name=devolver action=devolver_ex.php method=post>
<input type=hidden name=inventory>
<input type=hidden name=searchExpr>
<input type=hidden name=usuario value=".$arrHttp["usuario"].">
<input type=hidden name=vienede value=ecta>\n";
if (isset($arrHttp["reserve"])) $ec_output.= "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";
$ec_output.= "</form>
<form name=multas action=multas_eliminar_ex.php method=post>
<input type=hidden name=Accion>
<input type=hidden name=usuario value=".$arrHttp["usuario"].">
<input type=hidden name=Tipo>
<input type=hidden name=Mfn value=\"\">";
if (isset($arrHttp["reserve"])) $ec_output.= "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";
$ec_output.= "</form>
<br>
";
echo $ec_output;
if ($reservas !=""){	echo "<P><font color=red><strong>".$msgstr["total_copies"].": ".count($copies_title).". ".$msgstr["item_reserved"]."</strong></font><br>";
	echo $reservas ;}
}
?>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>


