<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      usuario_prestamos_prestar.php
 * @desc:      Save the loan transaction in the trans database
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
$nv=0;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");

include("fecha_de_devolucion.php");

///////////////////////////////////////////////////////////////////////////////////////////
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
//die;
$archivo="";
$pr_loan="";
$pr_return="";
$pr_fine="";
$pr_statment="";
$pr_solvency="";
if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst")){
	$archivo=$db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst";
}else{
	if (file_exists($db_path."trans/pfts/".$lang_db."/receipts.lst"))
		$archivo=$db_path."trans/pfts/".$lang_db."/receipts.lst";
}
if ($archivo!=""){
	$fp=file($archivo);
	foreach ($fp as $value){		$value=trim($value);		$v=explode('|',$value);
		switch($v[0]){
			case "pr_loan":
				$pr_loan=$v[1];
				break;
			case "pr_return":
				$pr_return=$v[1];
				break;
			case "pr_fine":
				$pr_fine=$v[1];
				break;
			case "pr_statment":
				$pr_statment=$v[1];
				break;
			case "pr_solvency":
				$pr_solvency=$v[1];
				break;
		}
	}
}

$item_data=explode('||',$arrHttp["item"]);
$nc=$item_data[0];                  // Control number of the object
$bib_db=$item_data[1];
$arrHttp["db"]=$bib_db;             // Name of the bibliographic database
unset($fp);

include("leer_pft.php");
// se lee la configuración de la base de datos de objetos de préstamos
include("databases_configure_read.php");
// se lee la configuración local
include("calendario_read.php");
include("locales_read.php");
// se leen las politicas de préstamo
include("loanobjects_read.php");
// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");

$valortag = Array();

include ('../dataentry/leerregistroisispft.php');


//READ THE POLICY
	$archivo=$db_path."/circulation/def/".$_SESSION["lang"]."/items.tab";
	if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/items.tab";
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			if (!isset($t[1])) $t[1]=$t[0];
			$type_items[$t[0]]=$t[1];
		}
	}
// se lee la información del los ejemplares del título : no. de inventario, tipo de registro, formato para almacenar en préstamos
	$item=str_replace("(","",$pft_in);
	$item=str_replace(")","",$item);
//	$item="(if $item='".trim($ejemplar)."' then $item '\$\$' $pft_typeofr fi)'\$\$'$pft_storobj";
    $item="$item '\$\$' $pft_typeofr '\$\$'$pft_storobj";
	// Read the bibliographic database that contains the object using the control mumber extracted from the copy
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	if ($arrHttp["copies"]=="Y"){
		$Expresion="CN_".$nc;
	}else{
		//SE LEE EL PREFIJO A UTILIZAR PARA LOCALIZAR EL OBJETO A TRAVÉS DE SU NÚMERO DE INVENTARIO
		$Expresion=$prefix_in.$nc;
	}
	$query = "&Opcion=disponibilidad&base=$bib_db&cipar=$db_path"."par/$bib_db.par&Expresion=".$Expresion."&Pft=".urlencode($item);
	#echo $query;
	include("../common/wxis_llamar.php");
	$obj="";
	foreach ($contenido as $value){
		$value=trim($value);		if (trim($value)!="")
			$obj.=$value;
	}
	#die;
	$objeto=explode('$$',$obj);
	$i=-1;
//GET THE POLICY ACORDING TO THE TYPE OF OBJECT AND THE TYPE OF USER
	//$ob=$politica[$item_data[5]][trim($arrHttp["usrtype"])];
	$ob=$arrHttp["policy"];

	$obj=explode('|',$ob);
	$fp=date("Ymd h:i A");

// DEVOLUTION DATE
	$fd=FechaDevolucion($obj[3],$obj[5],"");
//	echo "<br>Fecha de devolución: ".$fd;
//	die;

	$ix=strpos($fp," ");
	$diap=trim(substr($fp,0,$ix));
	$horap=trim(substr($fp,$ix));
	$ix=strpos($fd," ");
	$diad=trim(substr($fd,0,$ix));
	$horad=trim(substr($fd,$ix));

	$ValorCapturado="0001P\n";
	$ValorCapturado.="0010".trim($arrHttp["inventario"])."\n";	// INVENTORY NUMBER
	$ValorCapturado.="0012".$item_data[6]."\n";         	// VOLUME
	$ValorCapturado.="0015".$item_data[7]."\n";             // TOME
	$ValorCapturado.="0020".$arrHttp["usuario"]."\n";
	$ValorCapturado.="0030".$diap."\n";
	#if ($obj[5]=="H")
	$ValorCapturado.="0035".$horap."\n";
	$ValorCapturado.="0040".$diad."\n";
	#if ($obj[5]=="H")
	$ValorCapturado.="0045".$horad."\n";
	$ValorCapturado.="0070".$arrHttp["usrtype"]."\n";
	$ValorCapturado.="0080".$item_data[5]."\n";
	$ValorCapturado.="0095".$item_data[0]."\n";                   // Control number of the object
	$ValorCapturado.="0098".$item_data[1]."\n";             			// Database name
	if (isset($arrHttp["signatura"])and $arrHttp["signatura"]!="") $ValorCapturado.="0090".$arrHttp["signatura"]."\n";
	$ValorCapturado.="0100".$objeto[2]."\n";
	$ValorCapturado.="0400".$arrHttp["policy"]."\n";
	$ValorCapturado.="0120^a".$_SESSION["login"]."^b".date("Ymd H:i:s");
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."crear_registro.xis";
	$Formato="";
	$recibo="";
	if ($pr_loan!=""){
		if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/".$pr_loan.".pft")){
			$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/".$pr_loan;
		}else{
			if (file_exists($db_path."trans/pfts/".$lang_db."/".$pr_loan.".pft")){
				$Formato=$db_path."trans/pfts/".$lang_db."/".$pr_loan;
			}
		}
		if ($Formato!="") $Formato="&Formato=$Formato";
	}
	$query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."$Formato&Mfn=&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
	$recibo=implode(" ",$contenido);
	if(trim($recibo)!=""){		$recibo="&recibo=$recibo";	}
	if (file_exists($db_path."logtrans/data/logtrans.mst")){
		require_once("../circulation/grabar_log.php");
		$datos_trans["BD"]=$item_data[1];
		$datos_trans["NUM_CONTROL"]=$item_data[0];
		$datos_trans["NUM_INVENTARIO"]=trim($arrHttp["inventario"]);
		$datos_trans["TIPO_OBJETO"]=$item_data[5];
		$datos_trans["CODIGO_USUARIO"]=$arrHttp["usuario"];
		$datos_trans["TIPO_USUARIO"]=$arrHttp["usrtype"];
		$datos_trans["FECHA_DEVOLUCION"]=$diad;
		GrabarLog("A",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path);

	}
    header("Location: usuario_prestamos_presentar.php?prestado=S&show=Y&base=users&usuario=".$arrHttp["usuario"]."$recibo&inventario=".trim($arrHttp["inventario"])."&policy=".urlencode($arrHttp["policy"]));

