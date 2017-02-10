<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      show_reservations.php
 * @desc:      Display reservations of a title
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
$debug="";
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";  //die;
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../reserve/reserves_read.php");
include("../common/header.php");
if (!isset($arrHttp["submenu"]))
	include("../common/institutional_info.php");

?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["reserve"];


		?>
	</div>
	<div class="actions">
<?php if (!isset($arrHttp["submenu"])) include("../circulation/submenu_prestamo.php");?>

	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reserva.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reserva.html target=_blank>".$msgstr["edhlp"]."</a>";?>
<font color=white>&nbsp; &nbsp; Script: reserve/show_reservations.php</font>
	</div>
<div class="middle form">
		<div class="formContent">
<?php
$reserves_arr= ReservesRead($arrHttp["key"]);
echo $reserves_arr[0];
?>
</div></div>
</body>

</html>
<form name=reservas method=post action=../reserve/delete_reserve.php>
<input type=hidden name=Mfn_reserve>
<input type=hidden name=Accion>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<input type=hidden name=retorno value="../circulation/usuario_prestamos_presentar.php">
<?php if (isset($arrHttp["reserve"])) echo "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";?>
</form>
<script>
function  DeleteReserve(Mfn){
	document.reservas.Accion.value="delete"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}
function  CancelReserve(Mfn){
	document.reservas.Accion.value="cancel"
	document.reservas.Mfn_reserve.value=Mfn
	document.reservas.submit()
}
</script>