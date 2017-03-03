<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      reservar_inicio_a.php
 * @desc:      Reads the user and its statment to determine if the user can reserve
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
include("../common/get_post.php");
include("../config.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../common/header.php");
echo "<body>\n";
include("../common/institutional_info.php");

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["reserve"];
		  if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") echo " - ".$msgstr["users"].": ".$arrHttp["usuario"];
		?>
	</div>
	<div class="actions">
		<?php include("../circulation/submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/reserve.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/reserve.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reserve/reserve_inicio_a.php </font>
	</div>";
?>
<div class="middle form">
		<div class="formContent">
<table width=100%>
<td>
<?php
$ec_output="";
include("../circulation/leer_pft.php");
include("../circulation/locales_read.php");
include("../circulation/calendario_read.php");
require_once ("../circulation/fecha_de_devolucion.php");
// se lee la configuración de la base de datos de usuarios

//SE LOCALIZA EL USUARIO Y  LOS PRÉSTAMOS PENDIENTES
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
$nsusp=0;
$msgsusp="";
$vig="";
foreach ($contenido as $linea){
	$linea=trim($linea);
	if ($linea!="")  $user.=$linea;
}
if (trim($user)==""){
	echo "<h4>".$msgstr["userne"]."</h4>";
	die;
}else{
	if ($nsusp>0) {
		 $msgsusp= "pending_sanctions";
		 $vig="N";
	}else{
	//Se analiza la vigencia del usuario
		$userdata=explode('$$',$user);
	    if (trim($userdata[2])!=""){
	    	if ($userdata[2]<date("Ymd")){
	    		$msgsusp= "limituserdata";
				$vig="N";
	    	}
    	}
    }
}


include("../circulation/ec_include.php");
if (trim($ec_output))
if ($nv>0){
	print "<font color=red><h3>Tiene préstamos vencidos. No puede reservar</h3></font>";

}
echo $ec_output;
$ec_output="";
$reservas_vencidas="";
if ($nv >0) {	echo "<br>";
	echo $reserva_output;
	die;}
if ($reservas_vencidas=="S"){	echo "<br>" ;
	echo "<font color=red><h3>Tiene reservas vencidas. No puede reservar</h3></font>";
}
