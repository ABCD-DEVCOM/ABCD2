<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      renovar_ex.php
 * @desc:      Renews a loan
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
if (isset($_SESSION["DB_PATH"]))
	$arrHttp["DB_PATH"]=$_SESSION["DB_PATH"];
if (!isset($_SESSION["login"])) $_SESSION["login"] ="web";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";die;
include("../config.php");
if (!isset($arrHttp["vienede"]) or $arrHttp["vienede"]!="ecta_web" ){
	if (!isset($_SESSION["permiso"])){
		header("Location: ../common/error_page.php") ;
	}
}
if (isset($arrHttp["DB_PATH"])) $db_path=$arrHttp["DB_PATH"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (isset($arrHttp["lang"])) $_SESSION["lang"]=$arrHttp["lang"];
//die;

$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

include("fecha_de_devolucion.php");
// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");
# Se lee el prefijo y el formato para extraer el código de usuario
include("leer_pft.php");
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$uskey=$t[0];

require_once("../circulation/grabar_log.php");

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
		//echo "$linea<br>";		if (trim($linea)!=""){
			$l=explode('^',$linea);
			if (isset($l[13])){
				if ($base_origen==$l[13])
					$tr_prestamos[]=$linea;
			}else{
				$tr_prestamos[]=$linea;
			}
        }
	}
	return $tr_prestamos;
}

function compareDate ($FechaP,$lapso_p=""){
global $locales,$config_date_format;
//Se convierte la fecha a formato ISO (yyyymmaa) utilizando el formato de fecha local
	$ixTime=strpos($FechaP," ");
	$exp_date=substr($FechaP,0,4)."-".substr($FechaP,4,2)."-".substr($FechaP,6,2);
	if ($lapso_p=="H") {
		$exp_date.=substr($FechaP,$ixTime);
		$todays_date = date("Y-m-d h:i A");
	}else{
		$todays_date = date("Y-m-d");
	}
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	return $diff;


}//end Compare Date

function Reservado($Ctrl,$bd){global $xWxis,$Wxis,$wxisUrl,$db_path;
	$Expresion="(ST_0 or ST_3) and CN_".$bd."_$Ctrl";
	$IsisScript=$xWxis."cipres_usuario.xis";
	$Pft="v1,'|',v10,'|',v15,'|',v20,'|',v40/";
	$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/tbreserve.pft";
	$query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=$Expresion&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$cuenta=0;
	//SE OBTIENE EL NÚMERO DE RESERVAS
	foreach ($contenido as $value) {
		if (trim($value)!=""){			$v=explode('|',$value);			if ($v[0]=="3"){				if ($v[4]!="" and $v[4]<date("Ymd")){					continue;				}			}
			$cuenta=$cuenta+1;
		}	}
    return $cuenta;}

//Se ubica el ejemplar prestado en la base de datos de transacciones
$items=explode('$$',$arrHttp["searchExpr"]);

$resultado="";
foreach ($items as $num_inv){	$num_inv=trim($num_inv);
	if ($num_inv!=""){
		$inventario="TR_P_".$num_inv;
		if (!isset($arrHttp["base"])) $arrHttp["base"]="trans";
		//EL CAMPO 81 TIENE EL TIPO DE OBJETO DE LA CONVERSIÓN DESDE PRESTA
		$Formato="v10'|$'v20'|$'v30'|$'v35'|$'v40'|$'v45'|$'v70'|$'if p(v81) then v81 else v80 fi'|$'v100,'|$'f(nocc(v200),1,0)'|$'v400,'|$'v95,'|$'v98";
		//Se agrega el formato para obtener el total de ejemplares prestados
		$Formato.="'|$'f(npost(['trans']'ON_P_'v95'_'v98),1,0)/";
		$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&count=1&Expresion=".$inventario."&Pft=$Formato";
		$contenido="";
		$IsisScript=$xWxis."buscar_ingreso.xis";
		include("../common/wxis_llamar.php");
		$Total=0;
		foreach ($contenido as $linea){
			$linea=trim($linea);
			if ($linea!="") {
				$l=explode('|$',$linea);
				if (substr($linea,0,6)=="[MFN:]"){					$Mfn=trim(substr($linea,6));				}else{					if (substr($linea,0,8)=="[TOTAL:]"){						$Total=trim(substr($linea,8));					}else{						$prestamo=$linea;					}
				}
			}
		}

		$errores="";
	//echo "Mfn=$Mfn<p>" ;
		if ($Total<=0){			$error="&error=".$msgstr["notloaned"];
			$resultado.=";".$num_inv." ".$msgstr["notloaned"];		}else{
	// se extrae la información del ejemplar a devolver

			$p=explode('|$',$prestamo);
			$cod_usuario=$p[1];
			$inventario=$p[0];
			$fecha_p=$p[2];
			$hora_p=$p[3];
			$fecha_d=$p[4];
			$hora_d=$p[5];
			$tipo_usuario=$p[6];
			$tipo_objeto=$p[7];
			$referencia=$p[8];
			$no_renova=$p[9];         // Número de renovaciones procesadas
			$ppres=$p[10];            //Loan policy
			$num_ctrl=$p[11];         // Número de control
			$catalog_db=$p[12];           // Nombre de la base de datos
			$total_prestados=$p[13];  //Total de ejemplares prestados por número de control
			$arrHttp["usuario"]=$cod_usuario;
            include_once("sanctions_read.php");
	// se lee la política de préstamos
			include_once("loanobjects_read.php");
	// se lee el calendario
			include_once("calendario_read.php");
	// se lee la configuración local
			include_once("locales_read.php");
            $conf_db=file($db_path.$catalog_db."/loans/".$_SESSION["lang"]."/loans_conf.tab");
            foreach ($conf_db as $value) {            	if (substr($value,0,2)=="NC")
            		$prefix_cn=trim(substr($value,3));            }
			//Se obtiene el código, tipo y vigencia del usuario
			$formato=$pft_uskey.'\'$$\''.$pft_ustype.'\'$$\''.$pft_usvig;
			$formato=urlencode($formato);
			$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path"."par/users.par&Pft=$formato";
			$contenido="";
			$IsisScript=$xWxis."cipres_usuario.xis";
			include("../common/wxis_llamar.php");
			//foreach ($contenido as $value) echo "$value<br>";die;

	//se determina la política a aplicar
			if ($ppres==""){
				if (isset($politica[$tipo_objeto][$tipo_usuario])){
	    			$ppres=$politica[$tipo_objeto][$tipo_usuario];
				}
				if (trim($ppres)==""){
					if (isset($politica[0][$tipo_usuario])) {
						$ppres=$politica[0][$tipo_usuario];
					}
				}
				if (trim($ppres)==""){
					if (isset($politica[$tipo_usuario][0])){
	    				$ppres=$politica[$tipo_usuario][0];
	  				}
				}
				if (trim($ppres)==""){
					if (isset($politica["0"]["0"])){
						$ppres=$politica["0"]["0"];
					}
				}
			}
			$p=explode('|',$ppres);
			$lapso=$p[3];
			$lapso_reserva=$p[4];
			$unidad=$p[5];
			$renewed="S";
			//se verifica si el objeto admite más renovaciones

			if ($p[6]!=""){
				if ($no_renova>=$p[6]){
					$error="&error=".$msgstr["nomorenew"];
					$resultado.=";".$num_inv."  ".$msgstr["nomorenew"];
					$renewed="N";
					Regresar($error);
					continue;				}
            }
//se verifica la fecha límite del usuario
			if (trim($p[15])!=""){
				if ($p[15]<date("Ymd")){					$error="&error=".$msgstr["limituserdate"].". ".$p[15]."  ".$msgstr["nomorenew"];
					$resultado.=";".$num_inv." *** ".$msgstr["limituserdate"].". ".$p[15]."  ".", ".$msgstr["nomorenew"];
					$renewed="N";
					//echo $resultado;die;
					Regresar($error);
					continue;
				}
			}
// se verifica la fecha límite del objeto
			if (trim($p[16])!=""){
				if ($p[16]<date("Ymd")){
					$error="&error=".$msgstr["limitobjectdate"];
					$resultado.=";".$num_inv."  ".$msgstr["limitobjectdate"].", ".$msgstr["nomorenew"];
					$renewed="N";
					//echo $resultado;die;
					Regresar($error);
					continue;
				}
			}
// se verifica si el titulo no está reservado

			if (!isset($reserve_active) or (isset($reserve_active) and $reserve_active!="N")){
//DETERMINAMOS EL TOTAL DE EJEMPLARES QUE TIENE EL TITULO
				$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
				$base_catalogo="";
				if (file_exists($db_path."loans.dat"))					$copies="N";
				else
					$copies="Y";
				if ($copies=="Y"){
					$Expresion="CN_".$catalog_db."_".$num_ctrl;
					$base_catalogo=$catalog_db;
					$catalog_db="loanobjects";
					$pft_ni="(v959/)";
				}else{
					//SE LEE EL PREFIJO A UTILIZAR PARA LOCALIZAR EL OBJETO A TRAVÉS DE SU NÚMERO DE INVENTARIO
					$Expresion=$prefix_cn.$num_ctrl;
					$catalog_db=strtolower($catalog_db);
					$pft_ni=LeerPft("loans_inventorynumber.pft",$catalog_db);
					$pft_ni=str_replace("/"," ",$pft_ni);
					$pft_ni=str_replace("\n"," ",$pft_ni);
					if (isset($_SESSION["library"])) $pft_ni=str_replace('#library#',$_SESSION['library'],$pft_ni);
					$pft_ni="(".$pft_ni."/)";
				}
				$query = "&Opcion=disponibilidad&base=$catalog_db&cipar=$db_path"."par/$catalog_db.par&Expresion=".$Expresion."&Pft=".urlencode($pft_ni);
				include("../common/wxis_llamar.php");
				$obj=array();
				foreach ($contenido as $value){					$value=trim($value);
					if (trim($value)!="" and substr($value,0,8)!='$$TOTAL:')
						$obj[]=$value;
				}
				if ($catalog_db=="loanobjects") $catalog_db=$base_catalogo;
				//Se determinan los items prestados
				$tr_prestamos=LocalizarTransacciones($num_ctrl,"ON",$catalog_db);
				$items_prestados=count($tr_prestamos);
				$lista_espera=Reservado($num_ctrl,$catalog_db);
                //echo $lista_espera;
				if ($lista_espera>0)
					$disponibilidad=0;
                else
					$disponibilidad=count($obj)-($items_prestados-1)-$lista_espera;
				//echo "<br> $items_prestados ".$disponibilidad; die;
				if ($disponibilidad<=0){					$error="&error=".$msgstr["reservednorenew"];
					$resultado.=";".$num_inv."  ".$msgstr["reservednorenew"];
					$renewed="N";
					//echo $resultado;die;
					Regresar($error);
					continue;				}
			}
// Se calcula si hay atraso en la fecha de devolución
			$atraso=compareDate($fecha_d,$lapso);
			if ($atraso<0){
				if ($p[13]!="Y"){  // se verifica si la política permite renovar cuando está atrasado					$error="&error=".$msgstr["loanoverdued"];
					$resultado.=";".$num_inv."  ".$msgstr["loanoverdued"]."  ";
					$renewed="N";
					Regresar($error);
					continue;
				}
			}

            $nsusp=0;
            $nmulta=0;
            $arrHttp["usuario"]=$cod_usuario;
            include_once("sanctions_read.php");
            if ($nsusp>0 or $nmulta>0){            	$error="&error=".$msgstr["pending_sanctions"];
            	$resultado.=";".$num_inv." ".$msgstr["pending_sanctions"];
            	$renewed="N";
            	Regresar($error);
            	continue;
            }
// se verifica si tiene reservas
			if ($renewed=="S"){
	// Se pasa la fecha de préstamo y devolución anteriores al campo 200
				$f_ant="^a".$fecha_p."^b".$hora_p."^c".$fecha_d."^d".$hora_p."^e".$_SESSION["login"];
	//se calcula la nueva fecha de devolución

				$fecha_pres=date("Ymd h:i:s A");
				$ixpos=strpos($fecha_pres," ");
				$hora_d=trim(substr($fecha_pres,$ixpos));
				$fecha_pres=trim(substr($fecha_pres,0,$ixpos));
				if (isset($arrHttp["lpn"]))
					$fecha_dev=FechaDevolucion($arrHttp["lpn"],$unidad,"");
				else
					$fecha_dev=FechaDevolucion($lapso,$unidad,"");
				$ixp=strpos($fecha_dev," ");
				if ($ixp>0){
					$fecha_d=trim(substr($fecha_dev,0,$ixp));
				}

				$ValorCapturado="d30d35d40d45";
				$ValorCapturado.="<30 0>".$fecha_pres."</30>";
				$ValorCapturado.="<35 0>".$hora_d."</35>";
				$ValorCapturado.="<40 0>".$fecha_d."</40>";
				$ValorCapturado.="<45 0>".$hora_d."</45>";
				$ValorCapturado.="<200 0>".$f_ant."</200>";
				$ValorCapturado=urlencode($ValorCapturado);
				$IsisScript=$xWxis."actualizar_registro.xis";
				$Formato="";
				$query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
				$resultado.=";".$num_inv." ".$msgstr["renewed"];
				if (file_exists($db_path."logtrans/data/logtrans.mst")){

					$datos_trans["BD"]=$bd_obj;
					$datos_trans["NUM_CONTROL"]=$num_ctrl;
					$datos_trans["NUM_INVENTARIO"]=trim($inventario);
					$datos_trans["TIPO_OBJETO"]=$tipo_objeto;
					$datos_trans["CODIGO_USUARIO"]=$cod_usuario;
					$datos_trans["TIPO_USUARIO"]=$tipo_usuario;
					$datos_trans["FECHA_DEVOLUCION"]=$fecha_d;
					$ValorCapturado=GrabarLog("C",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
                    if ($ValorCapturado!="") $query.="&logtrans=".$ValorCapturado;
				}
				include ("../common/wxis_llamar.php");
			}
		}
	}
}
$cu="";
$recibo="";


if (isset($arrHttp["usuario"]))
	$cu="&usuario=".$arrHttp["usuario"];
else
	$cu="&usuario=$cod_usuario";
if (isset($arrHttp["reserve"])){	$reserve="&reserve=\"S\"";
}else{	$reserve="";}
if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web"){    header("Location: opac_statment_ex.php?usuario=$cod_usuario$error&vienede=ecta_web&lang=$lang&resultado=".urlencode($resultado));
    die;
}header("Location: usuario_prestamos_presentar.php?renovado=S&encabezado=s&resultado=".urlencode($resultado)."$cu&rec_dev=$Mfn_rec"."&inventario=".$arrHttp["searchExpr"].$reserve);
die;

function Regresar($error){global $arrHttp,$cod_usuario,$db_path,$lang;
    if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web"){    	header("Location: opac_statment_ex.php?usuario=$cod_usuario$error&vienede=ecta_web&DB_PATH=$db_path&lang=$lang");
    	die;    }
}






?>