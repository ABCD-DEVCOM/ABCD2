<?php
function MostrarRegistroCatalografico($dbname,$CN){
global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db,$CentralPath;
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
	if (isset($CentralPath))
    	include($CentralPath."common/wxis_llamar.php");
    else
    	include("../common/wxis_llamar.php");
	$salida="";
	foreach ($contenido as $value){
		if (substr($value,0,8)!="[TOTAL:]" and substr($value,0,6)!="[MFN:]")
			$salida.=$value;
	}
	return $salida;
}

function ColocarTitulos($base){
global $db_path,$lang_db,$arrHttp,$desde_opac,$msgstr;
	$salida= "\n<table bgcolor=#cccccc width=100%>\n";
	$tit_cols=0;
	// se lee la tabla con los títulos de las columnas
	$archivo="";

	//if (isset($arrHttp["vienede"]) and ($arrHttp["vienede"]=="IAH_RESERVA" or $arrHttp["vienede"]=="orbita")){
	if (isset($desde_opac) and $desde_opac=="Y"){		$fp=array($msgstr["tit_nc"],$msgstr["tit_tit"],$msgstr["tit_rdate"],$msgstr["tit_wait"],$msgstr["tit_fcan"],$msgstr["tit_fpres"],$msgstr["tit_status"]);
	}else{
		if ($archivo==""){			if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr_h.txt")){
				$archivo=$db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr_h.txt";
				$fp=file($archivo);
			}else{				$fp=array($msgstr["tit_nc"],$msgstr["tit_tit"],$msgstr["tit_rdate"],$msgstr["tit_wait"],$msgstr["tit_fcan"],$msgstr["tit_fpres"],$msgstr["tit_status"]);
			}
		}
	}
	$cuenta_s=0;
	echo "<p>";
	foreach ($fp as $value){
		$value=trim($value);
		if (trim($value)!=""){
			$cuenta_s=$cuenta_s+1;
			if (isset($desde_opac) and $desde_opac=="Y")
				if ($cuenta_s<2 or $cuenta_s>4) continue;
			$tit_cols=$tit_cols+1;
			$salida.= "<td><strong> $value</strong></td>";
		}
	}
	if (!isset($arrHttp["vienede"]) or ($arrHttp["vienede"]!="IAH_RESERVA" and $arrHttp["vienede"]!="orbita")){		$salida.= "<td class=\"action\" bgcolor=white>&nbsp;</td></tr>\n";
	}
	return $salida;
}

function PrintReservations($usuario,$accion="S",$status=" and (ST_0 or ST_3)",$Opciones=""){
global $xWxis,$Wxis,$wxisUrl,$db_path,$msgstr,$arrHttp,$reservas_u_cn,$config_date_format,$reservas_activas,$cuenta,$desde_opac,$Web_dir,$CentralHttp,$delete;
global $CentralPath;

	$reservas_u="";
	$Formato="";
	$Pft="";	$Expresion=urlencode($usuario.$status);
	$IsisScript=$xWxis."cipres_usuario.xis";
	if (isset($desde_opac) and $desde_opac=="Y"){		$Formato="v15' - 'v20'|',                                                                       /*BD y No. de control del objeto reservado */
'#REFER#','|'                                                                         /*Para insertar en este lugar la referencia bibliográfica*/
v30*6.2,\"/\"v30*4.2,\"/\"v30.4,' 'v31, '  'v32,'|'                                       /*Fecha, hora y operdor de la reserva*/
if v1='0' or v1='3' then if p(v40) and v40<mid(date,0,8) then,'<font color=red>' fi,
fi, v60*6.2,\"/\"v60*4.2,\"/\"v60.4 '-', v40*6.2,\"/\"v40*4.2,\"/\"v40.4,'|',                 /*Fecha desde-hasta espera*/
v130*6.2,\"/\"v130*4.2,\"/\"v130.4'|',                                                    /*Fecha de cancelación por el usuario o por un operador*/
v200*6.2,\"/\"v200*4.2,\"/\"v200.4,'|',                                                   /*Fecha en que se procesó el préstamo*/
v1/    ";

	}else{
		if (file_exists($db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr.pft")){
			$Formato="@".$db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr.pft";
		}else{			echo $msgstr["falta"]." ".$db_path."reserve/pfts/".$_SESSION["lang"]."/rsvr.pft";
			die;		}
	}
	$Formato=urlencode("f(mfn,1,0)'|'v40'|'v10,'|'v30'|'v130,'|',v200'|',v15'|',v20,'$|$',$Formato");
		//v40 fecha hasta la cual se espera una reserva asignada
		//v10 código del usuario
		//v30 Fecha de la reserva
		//v130 Fecha de cancelación
		//v200 Fecha en la cual se procesó el préstamo
		//v15 Base de datos
		//v20 Número de control
    $query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=$Expresion&Pft=$Formato";
    if (isset($CentralPath))
    	include($CentralPath."common/wxis_llamar.php");
    else
    	include("../common/wxis_llamar.php");
	foreach ($contenido as $value) {
		$value=trim($value);
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
			$cuenta_s=0;
			foreach ($r as $linea){
				$cuenta_s=$cuenta_s+1;
   				if ($linea=="#REFER#"){
					$reservas_u.="<td  bgcolor=white valign=top>";
					$reservas_u.=MostrarRegistroCatalografico($base_datos,$no_control);
				}else{					if (isset($desde_opac) and $desde_opac=="Y")
						if ($cuenta_s<2 or $cuenta_s>4) continue;
					$reservas_u.="<td  bgcolor=white valign=top nowrap>";
					$reservas_u.=$linea;
				}
                $reservas_u.="</td>";
			}
			if (isset($CentralHttp))
				$img_url=$CentralHttp."/central/";
			else
				$img_url="../";
			//if (!isset($arrHttp["vienede"]) or ($arrHttp["vienede"]!="IAH_RESERVA" or $arrHttp["vienede"]!="orbita")){
				$reservas_u.="<td  bgcolor=white valign=top nowrap>";
	 			if ((isset($arrHttp["vienede"]) and $arrHttp["vienede"])!="orbita"  and $fecha_hasta!=""){                    $reservas_u.="&nbsp;<a href=javascript:AlertReserve(".$mfn.",'','')><img src=$img_url"."dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";				}else{
			    	if (isset($vv[4]) and trim($vv[4])==""){			    		if (isset($delete) and $delete =="N") $accion="N";
			    		if (isset($_REQUEST["mostrar_reserva"]) and $_REQUEST["mostrar_reserva"]=="parcial")
			    			$accion="N";
			    		if ($accion=="S" and (!isset($arrHttp["vienede"]) or $arrHttp["vienede"]=="ecta_web")){
				    		$reservas_u.="&nbsp;<a href=javascript:CancelReserve(".$mfn.",'','')><img src=$img_url"."dataentry/img/toolbarCancelEdit.png alt='".$msgstr["cancel"]."' title='".$msgstr["cancel"]."'></a>";
			 			}
			  		}else{
			  			if ($vv[4]!="" and $vv[4]<date("Ymd") and $vv[5]!="")
			    			$reservas_u.=$msgstr["reserve_canceled"];
			    	}
				}
			    if ($accion=="S" and ($Opciones=="")){
				    if (trim($fecha_hasta)!="" ) $reservas_u.="&nbsp;<a href=\"javascript:SendMail('assigned',".$mfn.")\"><img src=../dataentry/img/mail_p.png alt='".$msgstr["mail_send"]."' title='".$msgstr["mail_send"]."'></a>";
		    	    If (!isset($arrHttp["vienede"])) $reservas_u.= "&nbsp; <a href=\"javascript:PrintReserve('assigned',".$mfn.")\"><img src=../dataentry/img/toolbarPrint.png></a>";
				}
				$reservas_u.= "</td>\n";
			//}
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
		$reservas_u.="<p><strong><font color=darkred>".$msgstr["rs01"]."</font></strong>".$reservas_xx;


	return array($reservas_u,$reservas_activas);
}

?>
