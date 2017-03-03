<?php
include("../common/get_post.php");
if (!isset($arrHttp["desde"]) or isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva"){
	session_start();
	if (!isset($_SESSION["permiso"])){
		header("Location: ../common/error_page.php") ;
	}
}else{
	$_SESSION["login"]="WEB";
	$_SESSION["permiso"]="WEB";
};

include("../config.php");
if (isset($arrHttp["DB_PATH"]))  $db_path=$arrHttp["DB_PATH"] ;

if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="IAH_RESERVA"){

	$_SESSION["login"]="IAH";
	$_SESSION["lang"]="es";
	$script_php="../circulation/opac_statment_ex.php";
?>
	<style>
	BODY {
		background: <?php echo $def["BG_WEB"]?>;
		font-family: "Trebuchet MS", Arial, Verdana, Helvetica;
		font-size: 10pt;
		color: #000;
	}
	td{
		font-family:arial;
		font-size:10px;
	}
	th{
		font-family:arial;
		font-size:10px;
	}
	</style>
<?php
	if (isset($logo_opac))echo "<img src=".$logo_opac.">";
}else{
	include("../common/header.php");
	// RESERVA DESDE EL SISTEMA DE PRESTAMOS

	if (!isset($_SESSION["permiso"])){
		header("Location: ../common/error_page.php") ;
	}
	$script_php="../circulation/estado_de_cuenta.php";
	if (!isset($_SESSION["login"])) die;
	if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
	include("../common/institutional_info.php");
}

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
if (isset($arrHttp["usuario_reserva"])) $arrHttp["usuario"]=$arrHttp["usuario_reserva"];
if (!isset($arrHttp["db"])) $arrHttp["db"]=$arrHttp["base"];
$arrHttp["reserve_ex"]="S";


include("../lang/admin.php");
include("../lang/prestamo.php");
include("../circulation/loan_configuration.php");



if (isset($arrHttp["base"])) $arrHttp["db"]=$arrHttp["base"];
include("../circulation/leer_pft.php");
include("../circulation/databases_configure_read.php");
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
	$Expresion="CU_".$user_code;
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$Pft="v10'|'v15'|'v20'|'v30,'|',v130'|',v200/";
	$query = "&Opcion=disponibilidad&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=".$Expresion."&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$user_reserves=array();
	$total_reserves=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (trim($linea)!="" and substr($linea,0,8)!='$$TOTAL:'){
			$l=explode('|',$linea);
			if (trim($l[4])=="" and trim($l[5])=="" ){
				$total_reserves=$total_reserves+1;
				if ($l[1]==$arrHttp["base"])
					$user_reserves[$l[2]]=$l[3];
			}

		}
	}
	return array($user_reserves,$total_reserves);
}



// Se localiza el número de control en la base de datos bibliográfica
function ReadCatalographicRecord($control_number,$db){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$prefix_cn,$lang_db;
	$Expresion=$prefix_cn.$control_number;
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."$db/loans/".$lang_db."/loans_display.pft";
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
global $db_path,$Wxis,$wxisUrl,$xWxis,$msgstr;

	$ValorCapturado ="<1 0>"."0"."</1>";
	$ValorCapturado.="<10 0>".$arrHttp["usuario"]."</10>";
	$ValorCapturado.="<12 0>".$type_user."</12>";
	$ValorCapturado.="<15 0>".$arrHttp["base"]."</15>";
	$ValorCapturado.="<20 0>".$value."</20>";
	$ValorCapturado.="<30 0>".date("Ymd")."</30>";
	$ValorCapturado.="<31 0>".date("H:i:s")."</31>";
	$ValorCapturado.="<32 0>".$_SESSION["login"]."</32>";
	$ValorCapturado.="<40 0>".$fecha_anulacion."</40>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."crear_registro.xis";
	$Pft="v10'|'v12'|'v15'|'v20'|'v30'|'v31'|'v32'|',v40";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Pft=$Pft&ValorCapturado=".$ValorCapturado;
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
	   		//echo "<strong><font color=red>".$msgstr["reserved"]."</font></strong><hr>";
	   	}else{
	   		echo "$referencia<strong><font color=red>".$msgstr["notreserved"]."</font></strong><hr>";
	   	}
	}

}

function Regresar(){
global $arrHttp,$msgstr;
	echo "<form name=regresar action=buscar.php method=post>\n";
	foreach ($arrHttp as $var=>$value){
		echo "<input type=hidden name=$var value=\"".$value."\">\n";
	}
	echo "<input type=hidden name=Opcion value=buscar_en_este>\n";
	echo "<input type=hidden name=desde value=reserve>\n";
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
    echo "<input type=hidden name=cipar value=".$arrHttp["cipar"].">\n";
	echo "<input type=submit value=".$msgstr["back"].">\n";
	echo "</form>";
}

include("../circulation/scripts_circulation.php");

?>
</head>
<body <?php echo $BG_web?>>
<?php if (!isset($arrHttp["desde"]) or (isset($arrHttp["desde"]) and $arrHttp["desde"]!="IAH_RESERVA")){
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
$u=explode('$$',$user);
$type_user=strtoupper($u[1]);
$vigency_user=$u[2];
//SE VERIFICA SI EL USUARIO EXISTE Y SI NO TIENE SANCIONES O ATRASOS
include("../circulation/ec_include.php");
echo $ec_output;
$cont="S";

//SANCIONES PENDIENTES
if ($nsusp>0 || $nmulta>0) {
	echo "<font color=red><h3>".$msgstr["pending_sanctions"]."</h3></font>";
	$cont="N";
}

//PRESTAMOS ATRASADOS
if ($nv>0){
	echo "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
	$cont="N";
}

//SE REVISA LA VIGENCIA DEL USUARIO
if ($vigency_user!=""){
	if ($vigency_user<date('Ymd')){
		echo "<font color=red><h3>".$msgstr["limituserdate"]."</h3></font>";
		$cont="N";
	}
}

//SE VERIFICA SI EL USUARIO PUEDE RESERVAR
$continuar="N";
$reservas_permitidas="";
if (isset($user_type[$type_user])){
	$ut=explode('|',$user_type[$type_user]);
	if (isset($ut[5])) $espera=$ut[5];
	if (isset($ut[4]) and ($ut[4]>0  or trim($ut[4])=="")){
		$reservas_permitidas=trim($ut[4]);
		if ($reservas_permitidas=="") $reservas_permitidas=99999;
		$continuar="Y";
	}else{
		$continuar="N";
		$reservas_permitidas=0;
	}
}
if ($continuar=="N"){
	echo "<font color=red><h3>".$msgstr["reservations_not_allowed"]."</h3></font>";
	$cont="N";
}
//RESERVAS PENDIENTES
$ur=ReadUsersReservations($arrHttp["usuario"]);
$user_reservations=$ur[0];
$total_reservas=$ur[1];
//SE VERIFICA SI EL USUARIO HA ALCANZADO EL LÍMITE DE RESERVAS PERMITIDAS
if ($reservas_permitidas!=""){
	if ($reservas_permitidas-$total_reservas<=0){
		echo "<font color=red><h3>".$msgstr["no_more_reservations"]."</h3></font>";
		$cont="N";
	}
}


if ($cont=="S" and isset($arrHttp["reservados"])){
	$por_reservar=explode('|',$arrHttp["reservados"]);
	//YA LO TIENE PRESTADO
	$reservados=array();
	$noreservados=array();
	foreach ($por_reservar as $pr){
		if (trim($pr)!=""){
			$salida_catalogo="($pr) ".ReadCatalographicRecord($pr,$arrHttp["base"]);
			$aceptar="S";
			foreach ($prestamos as $value) {
				$p=explode('^',$value);
				if ($pr==$p[1]){
					$aceptar="N";
					break;
				}
			}
			if ($aceptar=="S")
				$reservados[]=trim($pr);
			else
				echo "$salida_catalogo<font color=red>".$pr." ".$msgstr["duploan"]."</font><hr>";
		}
	}
	if (count($reservados)>0){
		foreach ($reservados as $control_number){
			$salida_catalogo="($control_number) ".ReadCatalographicRecord($control_number,$arrHttp["base"]);
            $cont="N";
			if (count($user_reservations>0)){
				//SE DETERMINA SI YA EL USUARIO TIENE UNA RESERVA DE ESE TITULO
				if (isset($user_reservations[$control_number])){
					echo $salida_catalogo;
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
				if ($reservas_permitidas-$total_reservas<=0){
					echo "<font color=red><h3>".$msgstr["no_more_reservations"]."</h3></font>";
				}else{
			        ActualizarRegistro($arrHttp,$control_number,$type_user,$salida_catalogo,"");
					$total_reservas=$total_reservas +1;
				}

			}
		}
	}
}

include ("reserves_read.php");
$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"]);
$user_reserves=$reserves_arr[0];
if (trim($user_reserves)!="")
	if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="IAH_RESERVA"){
		echo "<p><strong><font color=darkred>".$msgstr["reserves"]."</font></strong><br>".$msgstr["reserves_confirm"];
	}else{
		echo "<p><strong><font color=darkred>".$msgstr["reserves"]."</font></strong><br>".$user_reserves;
	}
?>


   </div>
</div>
<?php
	if (!isset($arrHttp["desde"]) or (isset($arrHttp["desde"]) and $arrHttp["desde"]!="IAH_RESERVA")){
		include("../common/footer.php");
	}else{
		echo "<p>";
		echo "&nbsp; &nbsp;<input type=button name=cerrar value='".$msgstr["cerrar"]."' onclick=javascript:self.close()>";

	}
?>
</body>
</html>

