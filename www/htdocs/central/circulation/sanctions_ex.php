<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      sanctions_ex.php
 * @desc:      Stores suspenctions and fines
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
////////////////////////////////////////////////////////////////////////////////////
//  Register suspensions and fines to a user
///////////////////////////////////////////////////////////////////////////////////
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
include("fecha_de_devolucion.php");


///////////////////////////////////////////////////////////////////////////////////////////



$valortag = Array();
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

// ------------------------------------------------------

include("../common/header.php");
?>
<script  src="../dataentry/js/lr_trim.js"></script>
<script>

document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13)
		self.location.href='prestar.php?encabezado=s'
    return true;
  };

function ColocarFecha(){// si es una suspensión, se coloca la fecha a partir del vencimiento de la última suspensión
// si es una multa, se coloca la fecha del día
	ix=document.sanctions.type.selectedIndex
	if (ix<1){		alert("<?php echo $msgstr["missst"]?>")
		return	}
	type=document.sanctions.type.options[ix].value
	switch(type){		case "S":
			document.sanctions.date.value=fecha_susp
			break
		case "M":
		case "N":
			document.sanctions.date.value=fecha_dia
			break	}
	document.sanctions.units.focus()
}

function EnviarForma(){	ix=document.sanctions.type.selectedIndex
	if (ix<1){
		alert("<?php echo $msgstr["missst"]?>")
		return
	}
	if (Trim(document.sanctions.date.value=="")){
		alert("<?php echo $msgstr["missdt"]?>")
		return
	}	if (Trim(document.sanctions.units.value)=="" && (document.sanctions.type.options[ix].value=="M" || document.sanctions.type.options[ix].value=="S") ){		alert("<?php echo $msgstr["missper"]?>")
		return	}
	if (Trim(document.sanctions.reason.value)==""){		alert("<?php echo $msgstr["missreason"]?>")
		return	}
	document.sanctions.submit();}

</script>
<?php

echo "<body>";
 include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suspend"]."/".$msgstr["fine"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/sanctions.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/sanctions.html target=_blank>".$msgstr["edhlp"]."</a>";
echo  "<font color=white>&nbsp; &nbsp; Script: sanctions_ex.php </font>";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<form name=sanctions method=post action=sanctions_update.php onSubmit="return false">
<?php
// se presenta la  información del usuario
	$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp.pft";
    if (!isset($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/loans_usdisp.pft";
   	$query = "&Expresion=CO_".$arrHttp["usuario"]."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		echo $linea."\n";
	}
	include("sanctions_read.php");//se incluye el procedimiento para leer las sanciones
	$fecha_exp="";
	$fecha_dia=PrepararFechaSanciones(date("Ymd"));
	$fecha_exp=$fecha_dia;
	if (count($susp)>0 and $AC_SUSP=="Y"){          // se determina el vencimiento de la última sanción		$sancion=$susp[count($susp)-1];
		$p=explode("|",$sancion);
		if ($p[6]>$fecha_dia){
			$exp_date=mktime(0,0,0,substr($p[6],4,2),substr($p[6],6,2)+1,substr($p[6],0,4));
			$exp_date=date("Ymd",$exp_date);
			$fecha_exp=PrepararFechaSanciones($exp_date);
		}
	}
//se determina la fecha de la próxima suspensión en base al vencimiento de la última suspensión
	echo "<script>\n";
	echo "fecha_dia='".$fecha_dia."'\n";
	echo "fecha_susp='".$fecha_exp."'";
	echo "\n</script>\n";
?>
<table>
		<td>
			<strong><?php echo $msgstr["sanctiontype"]?></strong>
		</td>
		<td>
			<select name="type" value="" class="textEntry" onchange=ColocarFecha()>
			<option value="">
<?php
$file=$db_path."suspml/def/".$_SESSION["lang"]."/sanctions.tab";
if (!file_exists($file)) $file=$db_path."suspml/def/".$lang_db."/sanctions.tab";
$fp=file($file);
foreach ($fp as $value) {	$val=explode('|',$value);
	echo "<option value='".$val[0]."'>".$val[1]."\n";}
?>
			</select>
        </td>
	<tr>
   		<td>
           	<strong><?php echo $msgstr["date"]?></strong>
     	</td>
     	<td>
<!-- Se coloca la fecha de expiración a partir de la fecha de la última suspensión -->
     		<input type="text" name="date" value="" size=10 ONFOCUS="this.blur()"/>
		</td>
	<tr>
		<td>
           	<strong><?php echo $msgstr["fines_days"]?></strong>
     	</td>
     	<td>
     		<input type="text" name="units" size=3 value=""  />
		</td>
	<tr>
		<td>
           	<strong><?php echo $msgstr["reason"]?></strong>
     	</td>
     	<td>
     		<input type="text" name="reason" size=100 value=""  />
		</td>
	<tr>
		<td>
           	<strong><?php echo $msgstr["comments"]?></strong>
     	</td>
     	<td>
     		<input type="text" name="comments" size=100 value=""  />
		</td>
	<tr>
		<td colspan=2>
			<input type="submit" name="update" value="<?php echo $msgstr["update"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>
        </td>
</table>
<?php
echo "<input type=hidden name=usuario value=".$arrHttp["usuario"].">\n";
echo "</form>";
echo "<form name=devolver action=devolver_ex.php>
<input type=hidden name=searchExpr>
<input type=hidden name=usuario value=".$arrHttp["usuario"].">
<input type=hidden name=vienede value=ecta>
</form>
</div></div>
";



include("../common/footer.php")
?>
</body>
</html>
