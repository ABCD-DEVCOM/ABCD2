<?php
include("../common/get_post.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($arrHttp["desde"]) or isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva"){

}
IF (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ABCD") {
	$session["login"]="WEB";
	$session["permiso"]="WEB";
}else{
	session_start();
	if (!isset($_SESSION["permiso"])){
		header("Location: ../common/error_page.php") ;
	}
}
if (!isset($desde_opac)) include("../config.php");
if (isset($Actual_path))  $db_path=$Actual_path ;

if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="IAH_RESERVA"){

	$_SESSION["login"]="IAH";
	$_SESSION["lang"]="es";
	$script_php="../circulation/opac_statment_ex.php";

	if (isset($logo_opac)) { echo "<img src=".$logo_opac.">"; 
}else{
	if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva"){
		include("../common/header.php");
		// RESERVA DESDE EL SISTEMA DE PRESTAMOS

		if (!isset($_SESSION["permiso"])){
			header("Location: ../common/error_page.php");
		}
		$script_php="../circulation/estado_de_cuenta.php";
		if (!isset($_SESSION["login"])) die;
		if (!isset($_SESSION["lang"])) $_SESSION["lang"]="en";
		include("../common/institutional_info.php");
	}
}
}

if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="orbita") {
	$_SESSION["lang"]=$_REQUEST["lang"];
	$lang=$_REQUEST["lang"];
	$session["login"]="WEB";
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
if (isset($arrHttp["usuario_reserva"])) $arrHttp["usuario"]=$arrHttp["usuario_reserva"];
if (!isset($arrHttp["db"]) and isset($arrHttp["base"])) $arrHttp["db"]=$arrHttp["base"];
$arrHttp["reserve_ex"]="S";


include("../lang/admin.php");
include("../lang/prestamo.php");
include("../circulation/loan_configuration.php");



if (isset($arrHttp["base"])) $arrHttp["db"]=$arrHttp["base"];
include("../circulation/leer_pft.php");
//include("../circulation/databases_configure_read.php");
//SE LEE LA CONFIGURACION LAS POLITICAS DE PRESTAMO
include("../circulation/loanobjects_read.php");
include("../circulation/fecha_de_devolucion.php");
//Calendario de días feriados
include("../circulation/calendario_read.php");
//Horario de la biblioteca, unidades de multa, moneda
include("../circulation/locales_read.php");
//Log de transacciones
include("../circulation/grabar_log.php");

//SE LEE LA TABLA DE TIPOS DE USUARIOS
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	echo $msgstr["missing"].": ".$msgstr["usertype"];
	die;
}
$ix=0;
foreach ($fp as $value) {
	if (trim($value)!=""){
		$value.="||";
		$Ti=explode('|',$value);
		$user_type[strtoupper($Ti[0])]=$value;
  	}
}

//SE DETERMINA EL ESTADO DE CUENTA DE LAS RESERVAS DEL USUARIO
function ReadUsersReservations($user_code){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;
	$Expresion="CU_".$user_code." and (ST_0 or ST_3)";
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$Pft="v10'|'v15'|'v20'|'v30,'|',v130'|',v200,'|',v1,'|',v40/";
	$query = "&Opcion=disponibilidad&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=".$Expresion."&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$user_reserves=array();
	$total_reserves=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (trim($linea)!="" and substr($linea,0,8)!='$$TOTAL:'){
			$l=explode('|',$linea);
			if (trim($l[4])=="" and trim($l[5])=="" ){
				if ($l[7]!="" and $l[7]<date("Ymd")) continue;
				$total_reserves=$total_reserves+1;
				if (isset($arrHttp["base"]) and $l[1]==$arrHttp["base"] or !isset($arrHttp["base"]))
					$user_reserves[$l[2]]=$l[3];
			}

		}
	}
	return array($user_reserves,$total_reserves);
}



// Se localiza el número de control en la base de datos bibliográfica
function ReadCatalographicRecord($control_number,$db){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$prefix_cn,$lang_db,$permitir_reserva;
	$Expresion=$prefix_cn.$control_number;
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj="";
	$formato_reserva=$db_path."$db/loans/".$_SESSION["lang"]."/pft_reserve.pft";
	$permitir_reserva="S";
	if (file_exists($formato_reserva)){
		$formato_obj=$formato_reserva;
		$query = "&Opcion=disponibilidad&base=". strtolower($db)."&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=@$formato_obj";
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea){
			if (trim($linea)=="NO"){
				$permitir_reserva="N";
				break;
			}
		}
	}
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) {
		$formato_obj=$db_path."$db/loans/".$lang_db."/loans_display.pft";
	}
	$query = "&Opcion=disponibilidad&base=". strtolower($db)."&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=@$formato_obj";
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
	return $titulo;
}

function ActualizarRegistro($arrHttp,$value,$type_user,$referencia,$fecha_anulacion){
global $db_path,$Wxis,$wxisUrl,$xWxis,$msgstr,$session;
    if (isset($session)){
    	$login=$session["login"];
    }else{
    	$login=$_SESSION["login"];
    }
	$ValorCapturado ="<1 0>"."0"."</1>";
	$ValorCapturado.="<10 0>".$arrHttp["usuario"]."</10>";
	$ValorCapturado.="<12 0>".$type_user."</12>";
	$ValorCapturado.="<15 0>".$arrHttp["base"]."</15>";
	$ValorCapturado.="<20 0>".$value."</20>";
	$ValorCapturado.="<30 0>".date("Ymd")."</30>";
	$ValorCapturado.="<31 0>".date("H:i:s")."</31>";
	$ValorCapturado.="<32 0>".$login."</32>";
	$ValorCapturado.="<40 0>".$fecha_anulacion."</40>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."crear_registro.xis";
	$Pft="v10'|'v12'|'v15'|'v20'|'v30'|'v31'|'v32'|',v40";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$login."&Pft=$Pft&ValorCapturado=".$ValorCapturado;
	//Se graba el log de prestamos
	if (file_exists($db_path."logtrans/data/logtrans.mst")){
		$datos_trans["BD"]=$arrHttp["base"];
		$datos_trans["NUM_CONTROL"]=$value;
		$datos_trans["CODIGO_USUARIO"]=$arrHttp["usuario"];
		$datos_trans["TIPO_USUARIO"]=$type_user;
		$ValorCapturado=GrabarLog("D",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
        $query.="&logtrans=".$ValorCapturado;
	}
	$contenido=array();
	include("../common/wxis_llamar.php");
	foreach ($contenido as $res){
		$r=explode('|',$res);
		$cn=$r[2];
	   	if (trim($res)!=""){
	   		echo "$referencia<strong><font color=red>".$msgstr["reserved"]."</font></strong><hr>";
	   	}else{
	   		echo "$referencia<strong><font color=red>".$msgstr["notreserved"]."</font></strong><hr>";
	   	}
	}

}

function Regresar(){
global $arrHttp,$msgstr;
	echo "<form name=regresar action=buscar_integrada.php method=post>\n";
	foreach ($arrHttp as $var=>$value){
		 echo "<input type=hidden name=$var value=\"".$value."\">\n";
	}
	echo "<input type=submit value=".$msgstr["back"].">\n";
	echo "</form>";
}

include("../circulation/scripts_circulation.php");

?>
</head>
<body <?php if (isset($BG_web)) echo $BG_web?>>
<?php if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva"){
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["reserve"]?>
	</div>
	<div class="actions">
	 <?php include("../circulation/submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulacion/reserva.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulacion/reserva.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reserve/reservar_ex.php" ?></font>
</div>
<?php } ?>
<div class="middle form">
	<div class="formContent">
<?php
$ec_output="";
// se lee la configuración de la base de datos de usuarios
include("../circulation/borrowers_configure_read.php");
# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$uskey=$t[0];

//Se obtiene el código, tipo y vigencia del usuario
$formato=$pft_uskey.'\'$$\''.$pft_ustype.'\'$$\''.$pft_usvig;
$formato=urlencode($formato);
$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path"."par/users.par&Pft=$formato";
$contenido="";
$IsisScript=$xWxis."cipres_usuario.xis";
include("../common/wxis_llamar.php");
$user="";
$nmulta=0;
$msgsusp="";
$vig="";

foreach ($contenido as $linea){
	$linea=trim($linea);
	if ($linea!="")  $user.=$linea;
}

if (trim($user)==""){
	echo "<h4>".$msgstr["userne"]."</h4>";
	Regresar() ;
	die;
}
$reservas_permitidas=0;
$u=explode('$$',$user);
$type_user=strtoupper($u[1]);
$vigency_user=$u[2];
//SE VERIFICA SI EL USUARIO EXISTE Y SI NO TIENE SANCIONES O ATRASOS
include("../circulation/ec_include.php");
echo $ec_output;
$cont="S";
$x_user=$user_type[$type_user];
$x_u=explode('|',$x_user);
if (isset($x_u[3]) and trim($x_u[3])!="" )
	$reservas_permitidas=$x_u[3];
else
	$reservas_permitidas=3;
//SANCIONES PENDIENTES
if ($nsusp>0 || $nmulta>0) {
	echo "<font color=red><strong>".$msgstr["pending_sanctions"]."</strong></font>";
	$cont="N";
}

//PRESTAMOS ATRASADOS
if ($nv>0){
	echo "<font color=red><strong>".$msgstr["useroverdued"]."</strong></font>";
	$cont="N";
}

//SE REVISA LA VIGENCIA DEL USUARIO
if ($vigency_user!=""){
	if ($vigency_user<date('Ymd')){
		echo "<font color=red><strong>".$msgstr["limituserdate"]."</strong></font>";
		$cont="N";
	}
}

$ur=ReadUsersReservations($arrHttp["usuario"]);
//var_dump($ur);
if (isset($arrHttp["items_por_reservar"])){
	$x=explode('|',$arrHttp["items_por_reservar"]);
	$arrHttp["reservados"]="";
	foreach ($x as $value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('_',$value);
			$arrHttp["reservados"].=$v[2].";;".$v[1].'|';
			$arrHttp["base"]=$v[1];

        }
	}
}

//echo "<pre>";print_r($ur);echo "</pre>";

//RESERVAS PENDIENTES

$user_reservations=$ur[0];
$total_reservas=$ur[1];

$reservas_procesadas=0;
if ($cont=="S" and isset($arrHttp["reservados"])){
	echo "<br><br>";
	$por_reservar=explode('|',$arrHttp["reservados"]);

	//YA LO TIENE PRESTADO
	$reservados=array();
	$noreservados=array();

	foreach ($por_reservar as $pr){
		$continuar="";
		if (trim($pr)!=""){
			$ppr_0=explode(';;',$pr);
			$control_number=$ppr_0[0];
			if (isset($ppr_0[1])) {
				$arrHttp["base"]=$ppr_0[1];
				$arrHttp["db"]=$arrHttp["base"];
			}
			require_once("../circulation/databases_configure_read.php");
			$permitir_reserva="";
			$salida_catalogo="($control_number) ".ReadCatalographicRecord($control_number,$arrHttp["base"]);
			$aceptar="S";

			if ($permitir_reserva=="N"){
				echo $salida_catalogo."<font color=red>".$control_number." ".$msgstr["cannot_be_reserved"]."</font><hr>";
				$continuar="N";
				continue;
			}
			foreach ($prestamos as $value) {
				$p=explode('^',$value);
				if ($control_number==$p[1]){
					$aceptar="N";
					break;
				}
			}
			if ($aceptar=="S")
				$reservados[]=trim($pr);
			else{
				echo "$salida_catalogo<font color=red style=line-height:30px> ".$msgstr["duploan"]."</font><hr>";
				$continuar="N";
			}
			if (count($reservados)>0 and $continuar==""){
    	        $cont="N";
				if (count($user_reservations)>0){
				//SE DETERMINA SI YA EL USUARIO TIENE UNA RESERVA DE ESE TITULO
					if (isset($user_reservations[$control_number])){
						echo "<br>". $salida_catalogo;
						echo "<font color=red>".$msgstr["yareservado"]." (";
						$f=$user_reservations[$control_number];
						if ($config_date_format=="DD/MM/YY")
							echo substr($f,6,2).'-'.substr($f,4,2).'-'.substr($f,0,4);
						else
							echo substr($f,4,2).'-'.substr($f,6,2).'-'.substr($f,0,4);
						echo ")</font><hr>";
					}else{
						$cont="S";
					}
				}else{
					$cont="S";
				}
				if ($cont=="S"){
					$reservas_procesadas=$reservas_procesadas+1;

					if ($reservas_permitidas-($total_reservas+1)<0){
						echo "<br>". $salida_catalogo;
						echo "<font color=red>".$msgstr["no_more_reservations"]."</font><hr>";
					}else{
			        	ActualizarRegistro($arrHttp,$control_number,$type_user,$salida_catalogo,"");
						$total_reservas=$total_reservas +1;
					}
				}
			}
		}
	}
}
if (!isset($arrHttp["vienede"]) or (isset($arrHttp["vienede"]) and $arrHttp["vienede"]!="orbita" )){
	include ("reserves_read.php");
	$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"]);
	$user_reserves=$reserves_arr[0];
	if (trim($user_reserves)!=""){
		if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="IAH_RESERVA"){
			echo "<p><strong><font color=darkred>".$msgstr["reserves"]."</font></strong><br>".$msgstr["reserves_confirm"];
		}else{
			echo "<p><strong><font color=darkred>".$msgstr["reserves"]."</font></strong><br>".$user_reserves;
		}
	}
}
?>
   </div>
</div>

<?php
	if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="orbita") Regresar();
	if (!isset($arrHttp["vienede"]) or (isset($arrHttp["vienede"]) and $arrHttp["vienede"]!="IAH_RESERVA") and $arrHttp["vienede"]!="orbita"){
		include("../common/footer.php");
	}else{
	//	echo "<p>";
	//	echo "&nbsp; &nbsp;<input type=button name=cerrar value='".$msgstr["cerrar"]."' onclick=javascript:self.close()>";

	}
?>