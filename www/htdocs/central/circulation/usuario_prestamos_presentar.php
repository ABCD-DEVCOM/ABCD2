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
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
if (isset($arrHttp["error"])){	$msg_error_0=$arrHttp["error"];
	unset($arrHttp["error"]);}
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/usuario_prestamos_presentar.php";
//echo $script_php;
//date_default_timezone_set('UTC');
$debug="";

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";

if (isset($arrHttp["db_inven"])){	$dbinv=explode('|',$arrHttp["db_inven"]);
	$_SESSION["loans_dbinven"]=$dbinv[0];}
include("../config.php");
//include("../config_loans.php");              // BORRADO EL 07/03/2013

$lang=$_SESSION["lang"];
//require_once ("../common/ldap.php");
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
$recibo_arr=array();

//Se averiguan los recibos que hay que imprimir
$recibo_list=array();
$Formato="";

if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst")){
		$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst";
	}else{
		if (file_exists($db_path."trans/pfts/".$lang_db."/receipts.lst")){
			$Formato=$db_path."trans/pfts/".$lang_db."/receipts.lst";
		}
	}
if ($Formato!=""){	$fp=file($Formato);
	foreach ($fp as $value){		if (trim($value)!=""){			$value=trim($value);
			$recibo_list[$value]=$value;		}	}}

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
				foreach ($copies_title as $cop){					$c=explode('||',$cop);
					$comp_01=$c[2];
					if (isset($c[6]))
						$comp_01.=" ".$c[6];
					if (isset($c[7]))
						$comp_01.=" ".$c[7];
					if (strtoupper($nc_us[10])==strtoupper($user)){    //SE VERFICA SI LA COPIA ESTÁ EN PODER DEL USUARIO

						if (strtoupper($comp_01)==strtoupper($comp) and $obj[14]!="Y"){
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

function Disponibilidad($control_number,$catalog_db,$items_prestados,$prefix_cn,$copies,$pft_ni){global $xWxis,$Wxis,$db_path,$msgstr,$wxisUrl;
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
		$ni_pft=explode('~',$pft_ni);
		$pft_ni="(".$ni_pft[0]."/)";
		if (isset($ni_pft[1]) and trim($ni_pft[1])!="")
			$pft_ni.="(".$ni_pft[1]."/)";

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
	return $disponibilidad;}

function LocalizarReservas($control_number,$catalog_db,$usuario,$items_prestados,$prefix_cn,$copies,$pft_ni) {
global $xWxis,$Wxis,$db_path,$msgstr,$wxisUrl;

// SE DETERMINA EL NUMERO DE EJEMPLARES DISPONIBLES
	$disponibilidad=Disponibilidad($control_number,$catalog_db,$items_prestados,$prefix_cn,$copies,$pft_ni);
// SE LEE LAS RESERVAS
	$IsisScript=$xWxis."cipres_usuario.xis";
	// Mfn
	// 10:codigo de usuario
	// 30:Fecha reserva
	// 31:Hora de reserva
	// 40:Fecha límite de retiro
	// 60:Fecha de asignacion de la reserva
	// 130:Fecha de cancelación de la reserva
	// 200:Fecha en que se ejecutó la reserva y se prestó el item al usuario
	// 1: Situación de la reserva
	$Pft=urlencode("f(mfn,6,0)'|'v10'|'v30'|'v31'|'v40'|'v60'|'v130'|'v200,'|',v1/");
	$Expresion=urlencode("CN_".$catalog_db."_".$control_number." AND (ST_3 or ST_0)");
	$query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=$Expresion&Pft=$Pft";
	include("../common/wxis_llamar.php");

	$reservas=array();
	$reservas_3=array();
	$reservas_0=array();
	foreach ($contenido as $value){		$value=trim($value);
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


//DETERMINAMOS SI EL USUARIO ESTÁ EN LA COLA DE RESERVAS EN ESPERA Y SI ESTÁ LE ASIGNAMOS EL PRESTAMO
	$ixcola_3=0;
	$ixcola_0=0;
	$ixcola=0;
	$tr=$disponibilidad - (count($reservas_3)+count($reservas_0));
	$encontrado_3="N";
	$encontrado_0="N";

 	if (count($reservas_3)>0){
 		foreach ($reservas_3 as $value){
 			if (trim($value)!=""){
 				$ixcola_3=$ixcola_3+1; 				$v=explode('|',$value);
 				if ($usuario==$v[1]) {
 					$mfn_3=$v[0];
 					$usuario_3=$v[1]; 					$encontrado_3="S";
 					break; 				} 			} 		} 	}
//SI SE ENCONTRÓ EN LA COLA DE RESERVAS EN ESPERA
	if ($encontrado_3=="S"){
// SI ES EL PRIMERO DE LA COLA O NO ES EL PRIMERO PERO HAY SUFICIENTE EJEMPLARES PARA ATENDER LA COLA DE RESERVA
// SE LE CONCEDE EL PRESTAMO
		if ($ixcola_3==1 or ($disponibilidad-$ixcola_3)>=0){			return array("continuar",$mfn_3,$usuario_3,$tr);		}else{			return array("no_continuar",0,0,$disponibilidad);		}
	}

// VEMOS SI EL USUARIO ESTÁ EN LA COLA DE RESERVAS PENDIENTES
	foreach ($reservas_0 as $value){		if (trim($value)!=""){			$ixcola_0=$ixcola_0+1;
			$v=explode('|',$value);
			if ($usuario==$v[1]){				$encontrado_0="S";
				$mfn_0=$v[0];
 				$usuario_0=$v[1];
			}		}	}

//SI ESTA EN LA COLA DE RESERVAS PENDIENTES Y HAY SUFICIENTES EJEMPLARES DISPONIBLES
// PARA SU LUGAR COLA DE RESERVAS SE LE DA EL PRESTAMO
	if ($encontrado_0=="S"){
		$cola=$ixcola_0+$ixcola_3;
		if ($disponibilidad>0){
			return array("continuar",$mfn_0,$usuario_0,$tr);
		}
	}

//SI NO ESTA EN LA COLA DE RESERVAS PENDIENTES Y HAY SUFICIENTES EJEMPLARES DISPONIBLES
// PARA ATENDERLA COLA DE RESERVAS SE LE DA EL PRESTAMO
	if ($encontrado_0=="N"){		$cola=$ixcola_0+$ixcola_3;		if ($disponibilidad-$cola>0){			return array("continuar",0,0,$tr);		}	}


}

function ActualizarReserva($diap,$horap){
global $db_path,$lang_db;
	$ValorCapturado ="d1d200d201d202<1 0>4</1>";	$ValorCapturado.="<200 0>$diap</200><201 0>$horap</201><202 0>".$_SESSION["login"]."</202>";
	$ValorCapturado=urlencode($ValorCapturado);
	if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/reserve.pft")){
		$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/reserve";
	}else{
		if (file_exists($db_path."reserve/pfts/".$lang_db."/reserve.pft")){
			$Formato=$db_path."reserve/pfts/".$lang_db."/reserve";
		}
	}
	$Formato="&Formato_reserva=$Formato";
	$query = "&reserva=".$ValorCapturado."$Formato";

	return $query;
}

function ProcesarPrestamo($usuario,$inventario,$signatura,$item,$usrtype,$copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva,$codusuario_reserva,$tr,$user_data){
global $db_path,$Wxis,$wxisUrl,$xWxis,$pr_loan,$pft_storobj,$recibo_arr,$recibo_list,$arrHttp;
	$item_data=explode('||',$item);
	$nc=$item_data[0];                  // Control number of the object
	$bib_db=$item_data[1];
	$arrHttp["db"]=$bib_db;
	$item="$pft_storobj";
	// Read the bibliographic database that contains the object using the control mumber extracted from the copy
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	if ($copies=="Y"){
		$Expresion="CN_".$nc;
	}else{
		//SE LEE EL PREFIJO A UTILIZAR PARA LOCALIZAR EL OBJETO A TRAVÉS DE SU NÚMERO DE INVENTARIO
		$Expresion=$prefix_cn.$nc;
	}
    $bib_db=strtolower($bib_db);
	$query = "&Opcion=disponibilidad&base=$bib_db&cipar=$db_path"."par/$bib_db.par&Expresion=".$Expresion."&Pft=".urlencode($item);
	include("../common/wxis_llamar.php");
	$obj="";
	foreach ($contenido as $value){
		$value=trim($value);
		if (trim($value)!="")
			$obj.=$value;
	}
	$objeto=explode('$$',$obj);
	$obj=explode('|',$ppres);
	$fp=date("Ymd h:i A");	// DEVOLUTION DATE

	if ($tr<=0){		if (trim($obj[4])=="") $obj[4]=2 ;
		$fd=FechaDevolucion($obj[4],$obj[5],"");    //lapso reserva
	}else{		if (isset($arrHttp["date"])){			$fd=$arrHttp["date"].date(" h:i A");;		}else{			if (isset($arrHttp["lpn"])){
				$fd=FechaDevolucion($arrHttp["lpn"],$obj[5],"");
			}else{				if ($obj[5]=="F")  // la fecha de devolución fijada en la política
					$fd=$obj[16]." 24:00";
				else
					$fd=FechaDevolucion($obj[3],$obj[5],"");    //lapso normal
	       }
	    }
	}
	$ix=strpos($fp," ");
	$diap=trim(substr($fp,0,$ix));
	$horap=trim(substr($fp,$ix));
	$ix=strpos($fd," ");

	$diad=trim(substr($fd,0,$ix));
	$horad=trim(substr($fd,$ix));
    if (isset($obj[16]) and $obj[16]!=""){
    	if ($diad>$obj[16])
    		$diad=$obj[16];    }
	$ValorCapturado="<1 0>P</1>";
	$ValorCapturado.="<10 0>".trim($inventario)."</10>";	// INVENTORY NUMBER
	if (isset($item_data[6])) $ValorCapturado.="<12 0>".$item_data[6]."</12>";         	// VOLUME
	if (isset($item_data[7])) $ValorCapturado.="<15 0>".$item_data[7]."</15>";          // TOME
	if (isset($arrHttp["year"]))    $ValorCapturado.="<17 0>".$arrHttp["year"]."</17>";       // AÑO REVISTA
	if (isset($arrHttp["volumen"])) $ValorCapturado.="<18 0>".$arrHttp["volumen"]."</18>";    // VOLUMEN REVISTA
	if (isset($arrHttp["numero"]))  $ValorCapturado.="<19 0>".$arrHttp["numero"]."</19>";     // NUMERO REVISTA
	$ValorCapturado.="<20 0>".$usuario."</20>";
	$ValorCapturado.="<30 0>".$diap."</30>";
	//if ($obj[5]=="H")
	$ValorCapturado.="<35 0>".$horap."</35>";
	$ValorCapturado.="<40 0>".$diad."</40>";
	if ($obj[5]=="H")
		$ValorCapturado.="<45 0>".$horad."</45>";
	else
		$horad="";
	$ValorCapturado.="<70 0>".$usrtype."</70>";
	if (isset($arrHttp["using_pol"])){		$pp=explode('|',$arrHttp["using_pol"]);
		$item_data[5]=$pp[0];	}
	$ValorCapturado.="<80 0>".$item_data[5]."</80>";
	$ValorCapturado.="<95 0>".$item_data[0]."</95>";                   // Control number of the object
	$ValorCapturado.="<98 0>".$item_data[1]."</98>";             			// Database name
	if ( $signatura!="") $ValorCapturado.="<90 0>".$signatura."</90>";
	$ValorCapturado.="<100 0>".$objeto[0]."</100>";
	if (isset($_SESSION["library"])) $ValorCapturado.="<150 0>".$_SESSION["library"]."</150>";
	$ValorCapturado.="<400 0>".$ppres."</400>";
	if (isset($item_data[8]))  // Información complementaria del item
		$ValorCapturado.="<410 0>".$item_data["8"]."</410>";
	if (trim($user_data)!="")
		$ValorCapturado.="<420 0>".$user_data."</420>"; //informacion complementaria del usuario
	$ValorCapturado.="<120 0>^a".$_SESSION["login"]."^b".date("Ymd h:i A")."^tP</120>";
	if (isset($arrHttp["comments"]))
		$ValorCapturado.="<300 0>".$arrHttp["comments"]."</300>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."crear_registro.xis";
	$Formato="";
	$recibo="";
	if (isset($recibo_list["pr_loan"])){
		if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/r_loan.pft")){
			$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/r_loan";
		}else{
			if (file_exists($db_path."trans/pfts/".$lang_db."/r_loan.pft")){
				$Formato=$db_path."trans/pfts/".$lang_db."/r_loan";
			}
		}
	}
	if ($Formato!="") {		$Formato="&Formato=$Formato";
		$Pft="mfn/";	}
	$query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."$Formato&ValorCapturado=".$ValorCapturado;

	//Se graba el log de prestamos
	if (file_exists($db_path."logtrans/data/logtrans.mst")){

		$datos_trans["BD"]=$item_data[1];
		$datos_trans["NUM_CONTROL"]=$item_data[0];
		$datos_trans["NUM_INVENTARIO"]=trim($inventario);
		$datos_trans["TIPO_OBJETO"]=$item_data[5];
		$datos_trans["CODIGO_USUARIO"]=$usuario;
		$datos_trans["TIPO_USUARIO"]=$usrtype;
		$datos_trans["FECHA_PROGRAMADA"]=$diad;
		$ValorCapturado=GrabarLog("A",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
        if ($ValorCapturado!="") $query.="&logtrans=".$ValorCapturado;
	}
	if ($codusuario_reserva!="" and $codusuario_reserva==$usuario){
		$res=ActualizarReserva($diap,$horap);
	    $query.=$res."&Mfn_reserva=$mfn_reserva";
	    if (file_exists($db_path."logtrans/data/logtrans.mst")){   //LOG DE TRANSACCIONES CON RESERVA ATENDIDA
			$datos_trans["BD"]=$item_data[1];
			$datos_trans["NUM_CONTROL"]=$item_data[0];
			$datos_trans["NUM_INVENTARIO"]=trim($inventario);
			$datos_trans["TIPO_OBJETO"]=$item_data[5];
			$datos_trans["CODIGO_USUARIO"]=$usuario;
			$datos_trans["TIPO_USUARIO"]=$usrtype;
			$ValorCapturado=GrabarLog("F",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"");
			if ($ValorCapturado!="") $query.="&logtrans_1=".$ValorCapturado;
		}

	}
	include("../common/wxis_llamar.php");
	//foreach ($contenido as $value)  echo "$value<br>"; die;

    $recibo="";
	if ($Formato!="") {		foreach ($contenido as $r){
			$recibo.=trim($r);		}		$recibo_arr[]=$recibo;
		//ImprimirRecibo($recibo);	}
	$fechas=array($diad,$horad);
	return $fechas;}


// Se localiza el número de control en la base de datos bibliográfica
function ReadCatalographicRecord($control_number,$db,$inventory){
global $Expresion,$db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_ni,$pft_nc,$pft_typeofr,$titulo,$prefix_in,$prefix_cn,$multa,$pft_storobj,$lang_db;
	//Read the FDT of the database for extracting the prefix used for indexing the control number
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
		if (substr($pft_typeofrec,0,1)=="(")
			$pft_typeofrec=substr($pft_typeofrec,1);
        if (substr($pft_typeofrec,strlen($pft_typeofrec)-1,1)==")")
			$pft_typeofrec=substr($pft_typeofrec,0,strlen($pft_typeofrec)-1);
		$pft_typeofrec=trim($pft_typeofrec);
	//SE SACAN LOS FORMATOS DE LOS DIFERENTES TIPOS DE REGISTRO DE LOS CAMPOS DE INVENTARIO
		$ixpni=strpos($pft_typeofrec,'~');
		if ($ixpni>0){
			$tofr1=substr($pft_typeofrec,0,$ixpni);
			$tofr2=substr($pft_typeofrec,$ixpni+1);
		}
		$pft_inf_add=LeerPft("item_inf_add.pft",$d[0]);
		$pft_inf_add=str_replace("/"," ",$pft_inf_add);
		$pft_inf_add=str_replace("\n"," ",$pft_inf_add);
		$inf_add=explode('~',$pft_inf_add);
		$pft_nc=LeerPft("loans_cn.pft",$d[0]);
		$pft_nc=str_replace("/"," ",$pft_nc);
		$pft_item_inf_add=LeerPft("item_inf_add.pft",$d[0]);
		$pft_item_inf_add=str_replace("/"," ",$pft_item_inf_add);
		$pft_ni=LeerPft("loans_inventorynumber.pft",$d[0]);
		$pft_ni=str_replace("/"," ",$pft_ni);
		$pft_ni=str_replace("\n"," ",$pft_ni);
		$ixpni=strpos($pft_ni,'~');
		if ($ixpni>0){
			$nvi1=substr($pft_ni,0,$ixpni);
			if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
			$formato_ex="('||".$d[0]."||',$nvi1,'||||||',".$tofr1.",'||||||'";
            if (isset($inf_add[0])) $formato_ex.=$inf_add[0];
			$formato_ex.="/)";
			$nvi1=substr($pft_ni,$ixpni+1);
			if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
			$formato_ex.=",('||".$d[0]."||',$nvi1,'||||||',".$tofr2.",'||||||'";
			if (isset($inf_add[1])) $formato_ex.=$inf_add[1];
			$formato_ex.="/)";
			$formato_ex=$pft_nc.",".$formato_ex;
		}else{
			if (isset($_SESSION["library"])) $pft_ni=str_replace('#library#',$_SESSION['library'],$pft_ni);
			$formato_ex="$pft_nc,('||".$d[0]."||',$pft_ni,'||||||',".$pft_typeofrec.",'||||||'$pft_item_inf_add/)";
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
	if (isset($arrHttp["year"]) or isset($arrHttp["volumen"])){
		$query.="_";
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

// ARE THE COPIES IN THE COPIES DATABASE OR IN THE BIBLIOGRAPHIC DATABASE?

if (isset($arrHttp["db_inven"])){	if (isset($arrHttp["copies"]))
		$from_copies=$arrHttp["copies"];
	else
		$from_copies="N";	$dbi=explode('|',$arrHttp["db_inven"]);
	if ($dbi[0]!="loanobjects"){

		$x=explode('|',$arrHttp["db_inven"]);
    	$var=LeerPft("loans_conf.tab",$x[0]);
		$prefix_in=trim($x[2]);
	}else{
		$prefix_in="IN_";
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
$prestamos=array();
$cont="";
$np=0;
$nv=0;
include("ec_include.php");  //se incluye el procedimiento para leer el usuario y los préstamos pendientes
if ($nsusp!=0 or $nmulta!=0) {	$cont="N";
	unset($arrHttp["inventory"]);}
if (count($prestamos)>0) {	$ec_output.= "<strong><a href=javascript:DevolverRenovar('D')>".$msgstr["return"]."</a> | <a href=javascript:DevolverRenovar('R')>".$msgstr["renew"]."</a>";
	if (isset($ASK_LPN) AND $ASK_LPN=="Y"){		$ec_output.=" ".$msgstr["days"]."<input type=text name=lpn size=4>";	}
	$ec_output.= "</strong><p>";
}

if (isset($arrHttp["usuario"])){
	//Se obtiene el código, tipo y vigencia del usuario
	$formato=$pft_uskey.'\'$$\''.$pft_ustype.'\'$$\''.$pft_usvig.'\'$$\''.$pft_usmore;
	$formato=urlencode($formato);
	$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path"."par/users.par&Pft=$formato";
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$user="";
	$msgsusp="";
	$vig="";

	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!="")  $user.=$linea;
	}
}else{	$user="";}

if (trim($user)==""){	ProduceOutput("<h4>".$msgstr["userne"]."</h4>","");
	die;
}else{

	 if(isset($use_ldap) and $use_ldap){
	  if(!Exist($arrHttp["usuario"]) )
      {

		  ProduceOutput("<h4>".$msgstr["ldapExi"]."</h4>","");
		  die;
       }
     }

    $arrHttp["ecta"]="S";
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
//if ($nv>0 and isset($arrHttp["inventory"])){
//	$ec_output.= "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
//	ProduceOutput($ec_output,"");
//	die;
//}
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
    		$tipo_us=$userdata[1];
    		$userdata[1]=trim(strtoupper($userdata[1]));
            if (isset($arrHttp["using_pol"])){            	$ppres=$arrHttp["using_pol"];
            	$o=explode("|",$ppres);
            	$using_pol=$o[0]." - ".$o[1];
            	$tipo_obj=$o[0];            }
			if (isset($politica[$tipo_obj][$userdata[1]])){	    		$ppres=$politica[$tipo_obj][$userdata[1]];
	    		$using_pol=$tipo_obj." - " .$userdata[1];
			}
			if (trim($ppres)==""){				if (isset($politica[0][$userdata[1]])) {					$ppres=$politica[0][$userdata[1]];
					$using_pol="0 - " .$userdata[1];				}
			}
			if (trim($ppres)==""){
				if (isset($politica[$tipo_obj][0])){
	    			$ppres=$politica[$tipo_obj][0];
	    			$using_pol=$tipo_obj." - 0" ;
	  			}
			}
			if (trim($ppres)==""){
				if (isset($politica["0"]["0"])){
					$ppres=$politica["0"]["0"];
					$using_pol="0 - 0";
				}
			}
			$obj=explode('|',$ppres);
			if ($obj[11]=="")
				$allow_reservation="N";
			else
				$allow_reservation="Y";
			$fechal_usuario="";
			$fechal_objeto="";
			if (!isset($obj[2]))
			    $total_prestamos_politica=0;
			else
				$total_prestamos_politica=$obj[2];
			if (trim($total_prestamos_politica)=="") $total_prestamos_politica=99999;
			if (isset($obj[15])){
				$fechal_usuario=$obj[15];
				$fecha_d=date("Ymd");
				if (trim($fechal_usuario)!=""){
					if ($fecha_d>$fechal_usuario){						$este_prestamo.= "fecha límite del usuario ";
						$norenovar="S";
						$cont="N";
						//die;					}
				}
			}
/*
			if (isset($obj[15])){				$fechal_objeto=$obj[16];
				if (trim($fechal_objeto)!="" and $obj[5]!="F"){
					if ($fecha_d>$fechal_objeto){
						$este_prestamo.= "fecha límite del objeto ";
						$cont="N";
						$este_prestamo.="<hr>";
					}
				}
			}
*/
			//SE VERIFICA SI EL USUARIO TIENE PRÉSTAMOS VENCIDOS
            if ($nv>0 and isset($arrHttp["inventory"]) and $obj[12]!="Y" and $obj[13]!="Y"){
				$este_prestamo.= "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
				$cont="N";
			}
			//Se verifica si el usuario puede recibir más préstamos en total
			//SE ASIGNA EL TOTAL DE PRESTAMOS QUE PUEDE RECIBIR UN USUARIO  SEGUN EL TIPO DE OBJETO  (calculado en loanobjects_read.php)
			if (isset($tipo_u[$userdata[1]]))
				$tprestamos_p=$tipo_u[$userdata[1]];
			else
				$tprestamos_p=99999;
			if (trim($tprestamos_p)=="")    $tprestamos_p=99999;
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
					if (isset($arrHttp["comments"]))
		    			$titulo.=" <font color=darkred>".$arrHttp["comments"]."</font>";
					$signatura=$tt[1];     //signatura topográfica
		    		$este_prestamo.= "<td bgcolor=white valign=top>$titulo</td>";
		    		$este_prestamo.= "<td bgcolor=white valign=top>";
		    		if (trim($ppres)==""){
						//$debug="Y";
						$este_prestamo.=$msgstr["nopolicy"]." ".$tipo_obj."-".$userdata[1]."<td bgcolor=white></td>";
                        $grabar="N";
					}else{
						$este_prestamo.= $msgstr["policy"].": ". $using_pol;
						$grabar="Y";
					}
					$este_prestamo.="</td>";

	// se verifica si el ejemplar está prestado
					$tr_prestamos=LocalizarTransacciones($arrHttp["inventory"],"TR",$catalog_db);
					$Opcion="";
					$msg="";
					$msg_1="";
					$lapso=$obj[3];
					if (trim($lapso)=="0"){
						$msg=$msgstr["not_avail_loan"];
						$msg.= "<font color=red>".$msgstr["not_avail_loan"]."</font><br>";
						$cont="N";
					}else{
						if (count($tr_prestamos)>0){   // Si ya existe una transacción de préstamo para ese número de inventario, el ejemplar está prestado
							$cont="N";
							$msg.="<font color=red>".$msgstr["itemloaned"]."<br></font>";
	        			}
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
	        				$tr=0;
	        				//SE LOCALIZA SI EL TITULO ESTÁ RESERVADO
	        				if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){         //para ver si tiene activado el módulo de reservas se lee desde el abcd.def
	        					$reservado=LocalizarReservas($control_number,$catalog_db,$arrHttp["usuario"],$items_prestados,$prefix_cn,$from_copies,$pft_ni);
	        					//echo "<pre>";print_r($reservado); die;
	        					$mfn_reserva=$reservado[1];
	        					if (isset($reservado[3])) $tr=$reservado[3];
	        					if(isset($reservado[2]))
	        						$codusuario_reserva=$reservado[2];
	        					else
	        						$codusuario_reserva="";
	        				}else{	        					$reservado=array("continuar",0);
	        					$mfn_reserva=0;
	        					$codusuario_reserva="";
	        					$tr=1;	        				}
	        				if (!isset($total_politica[$tipo_obj])) $total_politica[$tipo_obj]=0;
	        				if ($reservado[0]=="continuar"){
	        					//echo  "<p>np:".$np. " total_prestamos_usuario: $tprestamos_p total_prestamos_politica: ". $total_prestamos_politica ."  total_politica[$tipo_obj]: ". $total_politica[$tipo_obj]."<br>";
	        					if ($np<$tprestamos_p and $total_politica[$tipo_obj]< $total_prestamos_politica ){
	        						$total_politica[$tipo_obj]=$total_politica[$tipo_obj]+1;
	        						$np=$np+1;
	        						$xnum_p=$xnum_p+1;
	        						$prestamos_este=$prestamos_este+1;
									$ec_output.="$xnum_p. <input type=checkbox name=chkPr_".$xnum_p." value=0  id='".$arrHttp["inventory"]."'>";
	  								$ec_output.= "<input type=hidden name=politica value=\"".$ppres."\"> \n";
	  							}else{
	  								$grabar="N";
	  								$msg="<font color=red>".$msgstr["nomoreloans"]."</font>";
	  							}
	  						}else{	  							if ($allow_reservation=="Y"){
	  								$grabar="N";
	  								$msg="<font color=red><a href='javascript:ShowReservations(\"CN_".$catalog_db."_"."$control_number\",\"$catalog_db\")'>".$msgstr["reserved_other_user"]."</a></font>";
	  								//echo $msg;
	  							}
	  						}

  						}
						$este_prestamo.="</td>";
						$ec_output.=$este_prestamo;
						$Opcion="prestar";
						$msg_1=$msgstr["loan"];
						if ($grabar=="Y"){							if (isset($userdata[3])) {								$us_more=$userdata[3];							}else{								$us_more="";							}							$devolucion=ProcesarPrestamo($arrHttp["usuario"],$arrHttp["inventory"],$signatura,$item,$tipo_us,$from_copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva,$codusuario_reserva,$tr,$us_more);

							if ($mfn_reserva!=0){
                                if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
									$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"]);
									$reserves_user=$reserves_arr[0];
								}else{									$reserves_user="";								}							}
						}else{							$devolucion=array();
						}
						$ec_output.="<td bgcolor=white valign=top >$msg";

						if (count($devolucion)>0) {
							if (substr($config_date_format,0,2)=="DD"){								$ec_output.=substr($devolucion[0],6,2)."/".substr($devolucion[0],4,2)."/".substr($devolucion[0],0,4);							}else{								$ec_output.=substr($devolucion[0],4,2)."/".substr($devolucion[0],6,2)."/".substr($devolucion[0],0,4);							}
							$ec_output.=" ".$devolucion[1];
							if ($codusuario_reserva!="" and $codusuario_reserva==$arrHttp["usuario"]) $ec_output.=" <font color=red><br>".$msgstr["rs04"]." <!--a href=\"javascript:EnviarCorreo('".$arrHttp["usuario"]."','"."'".$arrHttp["inventory"]."')\"><img src=../dataentry/img/toolbarMail.png></a--> </font>";
						}
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

function ProduceOutput($ec_output,$reservas){global $msgstr,$msg_error_0,$arrHttp,$signatura,$msg_1,$cont,$institution_name,$lang_db,$copies_title,$link_u,$recibo_arr,$db_path,$Wxis,$xWxis,$wxisUrl,$script_php;global $prestamos_este,$xnum_p,$reserve_active,$nmulta,$nsusp,$cisis_ver,$css_name,$logo,$ILL,$meta_encoding;
	include("../common/header.php");    echo "<body>";
 	include("../common/institutional_info.php");
 	include("../circulation/scripts_circulation.php");
// 	if ($recibo!=""){// 		$recibo="&recibo=$recibo";
// 		$link_u.=$recibo;// 	}
?>

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
	echo "<font color=white>&nbsp; &nbsp; Script: usuarios_prestamos_presentar.php </font>
		</div>";
// prestar, reservar o renovar
?>
<div class="middle form">
	<div class="formContent">
<form name=ecta>
<?php
	if ($xnum_p=="") $xnum_p=0;
	$ec_output.= "</form>";
	$ec_output.="<script>
		np=$xnum_p
		</script>\n";
	$ec_output.= "<form name=devolver action=devolver_ex.php method=post>
	<input type=hidden name=searchExpr>
	<input type=hidden name=usuario value=".$arrHttp["usuario"].">
	<input type=hidden name=vienede value=ecta>
	<input type=hidden name=lpn>\n";
	if (isset($arrHttp["reserve"])) $ec_output.= "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";
	$ec_output.= "</form>
	<form name=solvencia action=solvencia.php method=post target=solvencia>
	<input type=hidden name=usuario value=\"".$arrHttp["usuario"]."\">
	</form>

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
	if ($reservas !=""){		echo "<P><font color=red><strong>".$msgstr["total_copies"].": ".count($copies_title).". ".$msgstr["item_reserved"]."</strong></font><br>";
		echo $reservas ;	}

	if (isset($arrHttp["prestado"]) and $arrHttp["prestado"]=="S"){
		if (isset($arrHttp["resultado"])){
			$inven=explode(';',$arrHttp["resultado"]);
			foreach ($inven as $inventario){				echo "<p><font color=red>". $inventario." ".$msgstr["item"].": ".$msgstr["loaned"]." </font>";
				if (isset($arrHttp["policy"])){					$p=explode('|',$arrHttp["policy"]);
					echo $msgstr["policy"].": " . $p[0] ." - ". $p[1];				}
			}
		}
	}
	if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S"){		if (isset($arrHttp["resultado"]) and isset($arrHttp["rec_dev"])){			$inven=explode(';',$arrHttp["rec_dev"]);
			foreach ($inven as $inventario){				if (trim($inventario)!=""){
					$Mfn=trim($inventario);
					echo "<p><font color=red>". $inventario." ".$msgstr["item"].": ".$msgstr["returned"]." </font>";
					$Formato="v10,' ',mdl,v100'<br>'";
					$Formato="&Pft=$Formato";
					$IsisScript=$xWxis."leer_mfnrange.xis";
					$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
					include("../common/wxis_llamar.php");
					foreach ($contenido as $value){
						echo $value;
					}
				}
			}
		}
	}

//SE VERIFICA SI ALGUNO DE LOS EJEMPLARES DEVUELTOS ESTÁ RESERVADO
	if (isset($arrHttp["lista_control"])) {
		$rn=explode(";",$arrHttp["lista_control"]);
		$res=array();
		foreach ($rn as $value){
			if (trim($value)!=""){
				if (!isset($res[$value]))
					$res[$value]=1;
				else
					$res[$value]=$res[$value]+1;
			}
		}

		if (count($res)>0){
			$Expresion="";
			foreach ($res as $key=> $value){
				if ($Expresion==""){
					$Expresion=$key;
				}else{
					$Expresion.="+".$key;
				}
			}
			if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
				$reserves_arr= ReservesRead($Expresion);
				$reserves_title=$reserves_arr[0];
				if ($reserves_title!=""){
					echo "<!--p><hr><strong>".$msgstr["reserves"]." <font color=red>(title)</font></strong><br-->";
					echo $reserves_title."<p>";
				}
			}
		}
	}

	if (isset($arrHttp["renovado"]) and $arrHttp["renovado"]=="S"){		if (isset($arrHttp["resultado"])){			$inven=explode(';',$arrHttp["resultado"]);
			foreach ($inven as $inventario){
				if (trim($inventario)!="")
					echo "<p><font color=red>".$msgstr["item"]." ". $inventario." </font>";
			}		}
	}else{	}

//SE IMPRIMEN LOS RECIBOS DE PRÉSTAMOS
	if (count($recibo_arr)>0) {
		ImprimirRecibo($recibo_arr);
	}

//SE IMPRIMEN LOS RECIBOS DE DEVOLUCION
	if (isset($arrHttp["rec_dev"])){		$Mfn_rec=$arrHttp["rec_dev"];
		$fs="r_return";		$r=explode(";",$Mfn_rec);
		$rec_salida=array();

		foreach ($r as $Mfn){
			if ($Mfn!=""){
				$Formato="";
				if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/$fs.pft")){
					$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/$fs";
				}else{
					if (file_exists($db_path."trans/pfts/".$lang_db."/$fs.pft")){
						$Formato=$db_path."trans/pfts/".$lang_db."/$fs";
					}
				}
				if ($Formato!="") {
                	$Formato="&Formato=$Formato";
					$IsisScript=$xWxis."leer_mfnrange.xis";
					$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
					include("../common/wxis_llamar.php");
					$recibo="";
					foreach ($contenido as $value){
						$recibo.=trim($value);
					}
					$rec_salida[]=$recibo;
				}
			}
		}
		if (count($rec_salida)>0) {
			ImprimirRecibo($rec_salida);
		}
	}
	if ($xnum_p==0 and $nmulta==0 and $nsusp==0){
		if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/r_solvency.pft"))
			echo "<a href=javascript:ImprimirSolvencia('".$arrHttp["usuario"]."')>".$msgstr["solvencia"]."</a>";
	}
?>

<?php
if (isset($arrHttp["reservaWeb"]) and $arrHttp["reservaWeb"]=="xY"){	echo "<form method=post action=../output_circulation/rsweb.php>\n";
	echo "<input type=hidden name=base value=reserve>\n";
	echo "<input type=hidden name=code value=actives_web>\n";
    echo "<input type=hidden name=name value=rsweb>\n";
    echo "<input type=hidden name=retorno value=../circulation/estado_de_cuenta.php>\n";
    echo "<input type=hidden name=reserva value=S>\n";
    echo "<input type=hidden name=reservaWeb value=Y>\n";
    echo "<p><input type=submit name=rsv_p value=\"Reservas web\" style='font-size:27px;border-radius:20px;background color:#cccccc; font-color=black'\"><p>";    echo "</form>";
}
echo "</div></div>\n";
include("../common/footer.php");?>
</body>
</html>

<?php
	if (isset($msg_error_0)){		echo "<script>
		alert('".$msg_error_0."')
		</script>
		";
		unset($arrHttp["error"]);
		unset($msg_error_0);
	}
}  //END FUNCTION PRODUCEOUTPUT



function ImprimirRecibo($recibo_arr){	$salida="";
	foreach ($recibo_arr as $Recibo){		$salida=$salida.$Recibo;
	}
	$salida=str_replace('/','\/',$salida);
?>
<script>
	msgwin=window.open("","recibo","width=400, height=300, scrollbars, resizable")
	msgwin.document.write("<?php echo $salida?>")
	msgwin.document.close()
	msgwin.focus()
	msgwin.print()
	msgwin.close()
</script>
<?php
}

?>
<form name=reservacion method=post action="../reserve/reservar_ex.php">
<input type=hidden name=encabezado  value="s">
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<?php if (isset($arrHttp["reserve"])) echo "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";
      if (isset($arrHttp["base"]))  echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
	  if (isset($control_number))   {	  		echo "<input type=hidden name=Expresion value=$Expresion".">\n";
     	 	echo "<input type=hidden name=control_number value=$control_number".">\n";
     }?>
</form>


<form name=busqueda action=../reserve/buscar.php method=post>
<input type=hidden name=base>
<input type=hidden name=desde value=reserva>
<input type=hidden name=count value=1>
<input type=hidden name=cipar>
<input type=hidden name=Opcion value=formab>
<input type=hidden name=copies value=<?php if (isset($copies)) echo $copies ?>>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>

</form>

