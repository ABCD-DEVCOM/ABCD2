<?php
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
		if (substr($value,0,8)!="[TOTAL:]" and substr($value,0,6)!="[MFN:]")
			$salida.=$value;
	}
	return $salida;
}

function ColocarTitulos($base){
global $db_path,$lang_db,$arrHttp;
	$salida= "\n<table bgcolor=#cccccc width=100%>\n";
	$tit_cols=0;
	// se lee la tabla con los títulos de las columnas
	$archivo="";
	if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="IAH_RESERVA"  or (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web")){
		if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/opac_reserve_h.txt")){
			$archivo=$db_path."reserve/pfts/".$_SESSION["lang"]."/opac_reserve_h.txt";
		}
	}
	if ($archivo==""){		if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr_h.txt")){
			$archivo=$db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr_h.txt";
		}
	}
	if ($archivo!=""){		$fp=file($archivo);
		foreach ($fp as $value){
			$value=trim($value);
			if (trim($value)!=""){
				$tit_cols=$tit_cols+1;
				$salida.= "<td><strong>$value</strong></td>";
			}
		}
	}else{
		$archivo=$db_path.$base."/pfts/".$_SESSION["lang"]."/tit_reserve_01.tab";   //ESTO SE HACE PARA EL CASO DE QUE EL ARCHIVO DE TITULOS VENGA EN tit_reserve.tab, POR  COMPATIILIDAD CON LA VERSIÓN ANTERIOR		if (!file_exists($archivo))
			$archivo=$db_path.$base."/pfts/".$lang_db."/tit_reserve_01.tab";
		if (file_exists($archivo)){
			$fp=file($archivo);
			$titulo=implode("\n",$fp);
			$fp=explode("|",$titulo);
			foreach ($fp as $value){
				$value=trim($value);
				if (trim($value)!=""){					$tit_cols=$tit_cols+1;
					$salida.= "<td><strong>$value</strong></td>";
				}
			}
		}
	}
	if (!isset($arrHttp["desde"]) or (isset($arrHttp["desde"]) and $arrHttp["desde"]!="IAH_RESERVA")){		$salida.= "<td class=\"action\" bgcolor=white>&nbsp;</td></tr>\n";
	}
	return $salida;
}

function PrintReservations($usuario,$accion="S",$status=" and (ST_0 or ST_3)",$Opciones=""){
global $xWxis,$Wxis,$wxisUrl,$db_path,$msgstr,$arrHttp,$reservas_u_cn,$config_date_format,$reservas_activas,$cuenta;

	$reservas_u="";	$Expresion=urlencode($usuario.$status);
	$IsisScript=$xWxis."cipres_usuario.xis";
	$Formato="";
	if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="IAH_RESERVA" or (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web")){		if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/opac_reserve.pft")){
			$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/opac_reserve.pft";
		}
	}
	if ($Formato==""){
		if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr.pft")){
			$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr.pft";
		}
	}
	if ($Formato!=""){
		$Formato=urlencode("f(mfn,1,0)'|'v40'|'v10,'|'v30'|'v130,'|',v200'|',v15'|',v20,'$|$',@$Formato");
		//v40 fecha hasta la cual se espera una reserva asignada
		//v10 código del usuario
		//v30 Fecha de la reserva
		//v130 Fecha de cancelación
		//v200 Fecha en la cual se procesó el préstamo
		//v15 Base de datos
		//v20 Número de control
	}else{
		$Formato=$db_path."reserve/pfts/".$_SESSION["lang"]."/reserve_01.pft";
		if (!file_exists($Formato)){
			$Formato=$db_path."reserve/pfts/".$lang_db."/reserve_01.pft";
		}
		$Formato=urlencode("f(mfn,1,0)'|'v40'|'v10,'|'v30'|'v130,'|',v200'|',v15'|',v20,'$|$',@$Formato") ;
	}
	//echo urldecode($Formato)."<p>";
    $query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=$Expresion&Pft=$Formato";
    include("../common/wxis_llamar.php");
	foreach ($contenido as $value) {		$value=trim($value);
		if ($value!=""){			$val=explode('$|$',$value);
			$vv=explode('|',$val[0]);
			$mfn=$vv[0];
			$fecha_hasta=$vv[1];
			$usuario_reserva=$vv[2];
			$base_datos=$vv[6];
			$no_control=$vv[7];
			if ($fecha_hasta!="" and $fecha_hasta<date("Ymd")) continue;
			$reservas_activas=$reservas_activas+1;
			$value=$val[1];
			$r=explode('|',$value);
			$cuenta=$cuenta+1;
			if ($cuenta==1){
				$reservas_u=ColocarTitulos("reserve");
			}
			$reservas_u.= "<tr>\n";
			foreach ($r as $linea){
   				if ($linea=="#REFER#"){
					$reservas_u.="<td  bgcolor=white valign=top>";
					$reservas_u.=MostrarRegistroCatalografico($base_datos,$no_control);
				}else{
					$reservas_u.="<td  bgcolor=white valign=top nowrap>";
					$reservas_u.=$linea;
				}
                $reservas_u.="</td>";
			}
			if (!isset($arrHttp["desde"]) or (isset($arrHttp["desde"]) and $arrHttp["desde"]!="IAH_RESERVA")){
				$reservas_u.="<td  bgcolor=white valign=top nowrap>";
				if ((isset($arrHttp["ecta"]) and $arrHttp["ecta"])=="Y"  and $fecha_hasta!=""){                    $reservas_u.="&nbsp;<a href=javascript:AlertReserve(".$mfn.",'','')><img src=../dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";				}else{
			    	if (isset($vv[4]) and trim($vv[4])==""){
			    		if ($accion=="S"){
				    		$reservas_u.="&nbsp;<a href=javascript:CancelReserve(".$mfn.",'','')><img src=../dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";
			 			}
			  		}else{
			  			if ($vv[4]!="" and $vv[4]<date("Ymd") and $vv[5]!="")
			    			$reservas_u.=$msgstr["reserve_canceled"];
			    	}
				}
			    if ($accion=="S" and ($Opciones=="")){
				    if (trim($fecha_hasta)!="" ) $reservas_u.="&nbsp;<a href=\"javascript:SendMail('assigned',".$mfn.")\"><img src=../dataentry/img/mail_p.png alt='".$msgstr["mail_send"]."' title='".$msgstr["mail_send"]."'></a>";
		    	    If (!isset($arrHttp["desde"])) $reservas_u.= "&nbsp; <a href=\"javascript:PrintReserve('assigned',".$mfn.")\"><img src=../dataentry/img/toolbarPrint.png></a>";
				}
				$reservas_u.= "</td>\n";
			}
			$reservas_u_cn.="|".$usuario_reserva;

		}
	}
	if ($reservas_u!="")  $reservas_u.="</table>\n";
	return $reservas_u;}

function ReservesRead($usuario,$accion="S",$status=" and (ST_0 or ST_3)",$Opciones=""){
global $xWxis,$Wxis,$wxisUrl,$db_path,$msgstr,$arrHttp,$reservas_u_cn,$config_date_format,$reservas_activas,$cuenta;
	$reservas_u="";
	$cuenta=0;
	$reservas_u_cn="";
	$reservas_activas=0;
	$reservas_u=PrintReservations($usuario,$accion," and ST_3",$Opciones);
	if ($reservas_u!="")
		$reservas_u=$msgstr["rs02"].$reservas_u;
	$cuenta=0;
	$reservas_xx=PrintReservations($usuario,$accion," and ST_0",$Opciones);
	if ($reservas_xx!="")
		$reservas_u.="<p>".$msgstr["rs01"].$reservas_xx;


	return array($reservas_u,$reservas_activas);
}

?>
