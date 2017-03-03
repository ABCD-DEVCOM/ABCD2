<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      reserve_inicio.php
 * @desc:      Ask for the user code and database for initiating the reservation process
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


if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>"; //die;
include("../common/header.php");

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;
}

function SeleccionarBaseDeDatos($db_path,$msgstr){
global $copies,$ix_nb,$base_sel;
	$sel_base="N";
	$ix_nb=-1;
	$base_sel="";
	if (file_exists($db_path."loans.dat")){
		$copies="N";
		$bases_p=SeleccionarLoansDat($db_path,$msgstr);
	}else{
		$copies="S";
		$bases_p=SeleccionarBasesDat($db_path,$msgstr);
	}
	return $bases_p;
}

function SeleccionarLoansDat($db_path,$msgstr){
global $ix_nb,$base_sel;
	$fp=file($db_path."loans.dat");
	foreach ($fp as $value){
		if (trim($value)!=""){
			$ix_nb=$ix_nb+1;
			$value=trim($value);
			$bases_p[]=$value;
			$v=explode('|',$value);
			$base_sel=$v[0];
		}
	}
	return $bases_p;
}

function SeleccionarBasesDat($db_path,$msgstr){
global $ix_nb,$base_sel;
	$fp=file($db_path."bases.dat");
	$bases_p=array();
	foreach ($fp as $value){
		$value=trim($value);
		if (trim($value)!=""){
			$v=explode('|',$value);
			if (isset($v[2])){
				if ($v[2]=="Y"){
					$ix_nb=$ix_nb+1;
					$bases_p[]=$v;
					$base_sel=$v[0];
				}
			}
		}
	}
	return $bases_p;
}
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>


function EnviarForma(){
	if (Trim(document.forma1.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]?>")
		return
	}
    document.forma1.submit()}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"
<?php
# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$codigo=LeerPft("loans_uskey.pft","users");
?>
	Separa=""
	Formato="<?php if (isset($t[2]))  echo trim($t[2]); else echo 'v30';?>,`$$$`,<?php echo str_replace("'","`",$codigo)?>"
    Prefijo=Separa+"&prefijo=<?php if (isset($t[1])) echo trim($t[1]); else echo 'NO_';?>"
    ancho=200
	url_indice="../circulation/capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
	msgwin=window.open(url_indice,"Indice","width=480, height=450,left=300,scrollbars")
	msgwin.focus()
}

</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
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
echo "<font color=white>&nbsp; &nbsp; Script: reserve/reserve_inicio.php </font>
	</div>";
// prestar, reservar o renovar
?>


<form name=forma1 action=reserve_inicio_a.php method=post onsubmit="javascript:return false">
<input type=hidden name=Opcion value=formab>
<input type=hidden name=encabezado>
<div class="middle list">
	<div class="searchBox">
<?php
//READ BASES.DAT TO FIND THE DATABASES CONNECTED WITH THE CIRCULATION MODULE, IF NOT WORKING WITH COPIES DATABASES


$bases_p=SeleccionarBaseDeDatos($db_path,$msgstr);
echo "\n<script>copies='$copies'</script>\n";
?>
	<input type=hidden name=Opcion value=formab>
	<table width=100% border=0>
		<td width=150>
			<label for="dataBases">
			<strong><?php echo $msgstr["basedatos"]?></strong>
			</label>
		</td><td>
			<select name=base>
		<?php
		foreach ($bases_p as $value){
			$v=explode("|",$value);
			echo "<option value=".$v[0].">".$v[1]."</option>\n";
		}
		?>
			</select>
	   </td></tr>
		<tr>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td>
		<td>
		<input type="text" name="usuario" id="usuario" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry'; "
<?php
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
	echo "value=\"".$arrHttp["usuario"]."\"";
?>
 onclick="document.forma1.usuario.value=''"
/>
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('U',document.forma1.usuario)"/>
		<input type="submit" name="prestar" value="<?php echo $msgstr["reserve"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>

		</td></table>
        <?php echo $msgstr["clic_en"]." <i>[".$msgstr["reserve"]."]</i> ".$msgstr["para_c"]?>

	</div>
	</div>
</div>

</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>