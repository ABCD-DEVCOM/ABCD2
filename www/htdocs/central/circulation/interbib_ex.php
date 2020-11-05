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
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";die;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/interbib_ex.php";
//echo $script_php;
//date_default_timezone_set('UTC');
$debug="";

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";

if (isset($arrHttp["db_inven"])){	$dbinv=explode('|',$arrHttp["db_inven"]);
	$_SESSION["loans_dbinven"]=$dbinv[0];}
include("../config.php");
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


function ProcesarPrestamo($usuario,$inventario,$signatura,$item,$usrtype,$copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva,$codusuario_reserva,$tr,$user_data,$agreement){
global $db_path,$Wxis,$wxisUrl,$xWxis,$pr_loan,$pft_storobj,$recibo_arr,$recibo_list,$arrHttp,$ILL;
	$item_data=explode('||',$item);
	$nc=$inventario;                  // Control number of the object
	$bib_db=$_REQUEST["base"];
	$arrHttp["db"]=$bib_db;
	$obj=explode('|',$ppres);
	$fp=date("Ymd h:i A");	// DEVOLUTION DATE

	if ($tr<=0){		if (trim($obj[4])=="") $obj[4]=2 ;
		$fd=FechaDevolucion($obj[4],$obj[5],"");    //lapso reserva
	}else{		if (isset($arrHttp["date"])){			$fd=$arrHttp["date"].date(" h:i A");;		}else{			if (isset($arrHttp["lpn"])){
				$fd=FechaDevolucion($arrHttp["lpn"],$obj[5],"");
			}else{
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

	$ValorCapturado="<1 0>P</1>";
	$ValorCapturado.="<10 0>$ILL-".trim($inventario)."</10>";	// INVENTORY NUMBER
	$ValorCapturado.="<20 0>".$usuario."</20>";
	$ValorCapturado.="<30 0>".$diap."</30>";
	$ValorCapturado.="<35 0>".$horap."</35>";
	$ValorCapturado.="<40 0>".$diad."</40>";
	if ($obj[5]=="H")
		$ValorCapturado.="<45 0>".$horad."</45>";
	else
		$horad="";
	$ValorCapturado.="<70 0>".$usrtype."</70>";
	if (isset($arrHttp["using_pol"])){		$pp=explode('|',$arrHttp["using_pol"]);
		$item_data[5]=$pp[0];	}
	$ValorCapturado.="<80 0>$ILL</80>";
	$ValorCapturado.="<95 0>$ILL-".trim($inventario)."</95>";
	$ValorCapturado.="<98 0>".$_REQUEST["base"]."</98>";             			// Database name
	if ( $signatura!="") $ValorCapturado.="<90 0>".$signatura."</90>";
	if ( $agreement!="") $ValorCapturado.="<430 0>".$agreement."</430>";
	$ValorCapturado.="<100 0>".$item."</100>";
	if (isset($_SESSION["library"])) $ValorCapturado.="<150 0>".$_SESSION["library"]."</150>";
	$ValorCapturado.="<400 0>".$ppres."</400>";
	if (isset($item_data[8]))  // Información complementaria del item
		$ValorCapturado.="<410 0>".$item_data["8"]."</410>";
	if (trim($user_data)!="")
		$ValorCapturado.="<420 0>".$user_data."</420>"; //informacion complementaria del usuario
	$ValorCapturado.="<120 0>^a".$_SESSION["login"]."^b".date("Ymd h:i A")."</120>";
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
	include("../common/wxis_llamar.php");
    $recibo="";
	if ($Formato!="") {		foreach ($contenido as $r){
			$recibo.=trim($r);		}		$recibo_arr[]=$recibo;
	}
	$fechas=array($diad,$horad);
	return $fechas;}



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

if (trim($user)==""){	ProduceOutput("<h4>".$msgstr["userne"]."</h4>","");
	die;
}else{

	 if($use_ldap){
	  if(!Exist($arrHttp["usuario"]) )
      {

		  ProduceOutput("<h4>".$msgstr["ldapExi"]."</h4>","");
		  die;
       }
     }

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
    	if (isset($_SESSION["library"])) $arrHttp["inventory"]=$_SESSION["library"]."_".$arrHttp["inventory"];
    	$ec_output.="<tr>";
    	$este_prestamo="";
        $este_prestamo.= "<td bgcolor=white valign=top align=center><font color=red>$ILL-".$arrHttp["inventory"]."</font></td>";
	//Se ubica el ejemplar en la base de datos de objeto
		//$res=LocalizarInventario($arrHttp["inventory"]);
		$total=1;
		$item="";
		if ($total==0){
			$este_prestamo.= "<td bgcolor=white valign=top></td><td bgcolor=white></td><td  bgcolor=white valign=top></td><td bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["copynoexists"]."</font></td>";
			$cont="N";
			$ec_output.="<td bgcolor=white></td>".$este_prestamo;
 			//ProduceOutput($ec_output,"");
		}else{
		//se extrae la información del número de control del título y la base de datos catalográfica a la cual pertenece
			$control_number="";

			$catalog_db=$arrHttp["base"];
    		$tipo_obj=trim($ILL);      //Tipo de objeto
// se lee la configuración de la base de datos de objetos de préstamos
			$arrHttp["db"]="$catalog_db";
			$este_prestamo.="<td bgcolor=white valign=top align=center></td>";
            require_once("databases_configure_read.php");
			$ppres="";
    		$tipo_obj=trim(strtoupper($tipo_obj));
    		$tipo_us=$userdata[1];
    		$userdata[1]=trim(strtoupper($userdata[1]));
            if (isset($arrHttp["using_pol"])){            	$ppres=$arrHttp["using_pol"];
            	$o=explode("|",$ppres);
            	$using_pol=$o[0]." - ".$o[1];
            	$tipo_obj=$o[0];            }
			if (isset($politica[$tipo_obj][$userdata[1]])){
	    		$ppres=$politica[$tipo_obj][$userdata[1]];
	    		$using_pol=$tipo_obj." - " .$userdata[1];
			}
			if (trim($ppres)==""){
				if (isset($politica[$tipo_obj][0])){
	    			$ppres=$politica[$tipo_obj][0];
	    			$using_pol=$tipo_obj." - 0" ;
	  			}
			}
			if (trim($ppres)==""){
				if (isset($politica[0][$userdata[1]])) {					$ppres=$politica[0][$userdata[1]];
					$using_pol="0 - " .$userdata[1];				}
			}

			if (trim($ppres)==""){
				if (isset($politica["0"]["0"])){
					$ppres=$politica["0"]["0"];
					$using_pol="0 - 0";
				}
			}
			$obj=explode('|',$ppres);
			$allow_reservation="N";
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
			if (isset($obj[15])){				$fechal_objeto=$obj[16];
				if (trim($fechal_objeto)!=""){
					if ($fecha_d>$fechal_objeto){
						$este_prestamo.= "fecha límite del objeto ";
						$cont="N";
						$este_prestamo.="<hr>";
					}
				}
			}

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

	 			if ($cont=="Y"){
		    		$obj_store="^a".$_REQUEST["tag100_a"]."^b".$_REQUEST["tag100_b"];
					$titulo=$_REQUEST["tag100_b"];
					if (isset($arrHttp["comments"]))
		    			$titulo.=" <font color=darkred>".$arrHttp["comments"]."</font>";
					$signatura=$arrHttp["inventory"];     //signatura topográfica
		    		$este_prestamo.= "<td bgcolor=white valign=top>$titulo</td>";
		    		$este_prestamo.= "<td bgcolor=white valign=top>";
		    		if (trim($ppres)==""){
						//$debug="Y";
						$este_prestamo.=$msgstr["nopolicy"]." ".$tipo_obj."-".$userdata[1]."<td bgcolor=white></td>";
                        $grabar="N";
					}else{						$este_prestamo.=str_replace('|',",",$_REQUEST["agreement"])."<br>";
						$este_prestamo.= $msgstr["policy"].": ". $using_pol;
						$grabar="Y";
					}
					$este_prestamo.="</td>";
	// se verifica si el ejemplar está prestado
	        		if ($cont=="Y"){
	        			$msg="";
	        			$ec_output.="<td bgcolor=white valign=top>";	        			if ($grabar=="Y"){
	       					$reservado=array("continuar",0);
        					$mfn_reserva=0;
        					$codusuario_reserva="";
        					$tr=1;	        				if (!isset($total_politica[$tipo_obj])) $total_politica[$tipo_obj]=0;
	        				if ($reservado[0]=="continuar"){
	        					//echo  "<p>np:".$np. " total_prestamos_usuario: $tprestamos_p total_prestamos_politica: ". $total_prestamos_politica ."  total_politica[$tipo_obj]: ". $total_politica[$tipo_obj]."<br>";
	        					if ($np<$tprestamos_p and $total_politica[$tipo_obj]< $total_prestamos_politica ){
	        						$total_politica[$tipo_obj]=$total_politica[$tipo_obj]+1;
	        						$np=$np+1;
	        						$xnum_p=$xnum_p+1;
	        						$prestamos_este=$prestamos_este+1;
									$ec_output.="$xnum_p. <input type=checkbox name=chkPr_".$xnum_p." value=0  id='$ILL-".$arrHttp["inventory"]."'>";
	  								$ec_output.= "<input type=hidden name=politica value=\"".$ppres."\"> \n";

	  							}else{
	  								$grabar="N";
	  								$msg="<font color=red>".$msgstr["nomoreloans"]."</font>";
	  							}
	  						}else{	  						}

  						}
						$este_prestamo.="</td>";
						$ec_output.=$este_prestamo;
						$Opcion="prestar";
						$msg_1=$msgstr["loan"];
						if ($grabar=="Y"){							if (isset($userdata[3])) {								$us_more=$userdata[3];							}else{								$us_more="";							}
							$a=explode('|',$arrHttp["agreement"]);
							$agreement='^a'.$a[0].'^b'.$a[1];							$devolucion=ProcesarPrestamo($arrHttp["usuario"],$arrHttp["inventory"],$arrHttp["inventory"],$obj_store,$tipo_us,$from_copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva,$codusuario_reserva,$tr,$us_more,$agreement);

						}else{							$devolucion=array();
						}
						$ec_output.="<td bgcolor=white valign=top >$msg";

						if (count($devolucion)>0) {
							if (substr($config_date_format,0,2)=="DD"){								$ec_output.=substr($devolucion[0],6,2)."/".substr($devolucion[0],4,2)."/".substr($devolucion[0],0,4);							}else{								$ec_output.=substr($devolucion[0],4,2)."/".substr($devolucion[0],6,2)."/".substr($devolucion[0],0,4);							}
							$ec_output.=" ".$devolucion[1];
							if ($codusuario_reserva!="" and $codusuario_reserva==$arrHttp["usuario"]) $ec_output.=" <font color=red><br>".$msgstr["rs04"]."</font>";
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

function ProduceOutput($ec_output,$reservas){global $msgstr,$arrHttp,$signatura,$msg_1,$cont,$institution_name,$lang_db,$copies_title,$link_u,$recibo_arr,$db_path,$Wxis,$xWxis,$wxisUrl,$script_php;global $prestamos_este,$xnum_p,$reserve_active,$nmulta,$nsusp,$cisis_ver,$css_name,$logo,$ILL;
	include("../common/header.php");    echo "<body>";
 	include("../common/institutional_info.php");
 	include("../circulation/scripts_circulation.php");
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
if ($reservas !=""){	echo "<P><font color=red><strong>".$msgstr["total_copies"].": ".count($copies_title).". ".$msgstr["item_reserved"]."</strong></font><br>";
	echo $reservas ;}

if (isset($arrHttp["prestado"]) and $arrHttp["prestado"]=="S"){
	if (isset($arrHttp["resultado"])){
		$inven=explode(';',$arrHttp["resultado"]);
		foreach ($inven as $inventario){			echo "<p><font color=red>". $inventario." ".$msgstr["item"].": ".$msgstr["loaned"]." </font>";
			if (isset($arrHttp["policy"])){				$p=explode('|',$arrHttp["policy"]);
				echo $msgstr["policy"].": " . $p[0] ." - ". $p[1];			}
		}
	}
}
if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S"){	if (isset($arrHttp["resultado"]) and isset($arrHttp["rec_dev"])){		$inven=explode(';',$arrHttp["rec_dev"]);
		foreach ($inven as $inventario){			if (trim($inventario)!=""){
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

if (isset($arrHttp["renovado"]) and $arrHttp["renovado"]=="S"){	if (isset($arrHttp["resultado"])){		$inven=explode(';',$arrHttp["resultado"]);
		foreach ($inven as $inventario){
			if (trim($inventario)!="")
				echo "<p><font color=red>".$msgstr["item"]." ". $inventario." </font>";
		}	}
}else{}

//SE IMPRIMEN LOS RECIBOS DE PRÉSTAMOS
if (count($recibo_arr)>0) {
	ImprimirRecibo($recibo_arr);
}

//SE IMPRIMEN LOS RECIBOS DE DEVOLUCION
if (isset($arrHttp["rec_dev"])){	$Mfn_rec=$arrHttp["rec_dev"];
	$fs="r_return";	$r=explode(";",$Mfn_rec);
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
</div></div>
<?php
include("../common/footer.php");?>
</body>
</html>

<?php
if (isset($arrHttp["error"])){
	echo "<script>
	alert('".$arrHttp["error"]."')
	</script>
	";
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

