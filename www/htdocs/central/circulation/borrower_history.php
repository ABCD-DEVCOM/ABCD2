<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrower_history.php
 * @desc:      Ask for the borrower for showing the transactions history
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
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");

$arrHttp["base"]="users";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
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

//se lee la configuración del usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$prefijo_codigo=$t[0];
if (isset($t[1]))
	$prefijo_nombre=$t[1];
else
	$prefijo_nombre="";
if (isset($t[2]))
	$formato_nombre=$t[2];
else
	$formato_nombre="";
if ($prefijo_codigo=="") $prefijo_codigo="CO_";
if ($prefijo_nombre=="") $prefijo_nombre="NO_";
if ($formato_nombre=="") $formato_nombre="v30";
# Se lee el formato para extraer el código de usuario
$codigo=LeerPft("loans_uskey.pft","users");
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }

function EnviarForma(Proceso){	if (Trim(document.usersearch.code.value)=="" ){		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]?>")
		return	}
	document.EnviarFrm.usuario.value=document.usersearch.usercode.value
	document.EnviarFrm.action="borrower_history_ex.php"
	document.EnviarFrm.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
		msgwin.focus()
}

function AbrirIndice(TipoI,Ctrl){

	switch (TipoI){
		case "U":
			db="users"
			Formato="<?php echo trim($formato_nombre)?>,`$$$`,<?php echo str_replace("'","`",trim($codigo))?>"
			prefijo="<?php echo trim($prefijo_nombre)?>"
			AbrirIndiceAlfabetico(Ctrl,"<?php echo trim($prefijo_nombre)?>","","","users","users.par","30",1,"0",Formato)
			break
	}
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
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/loans/borrower_history.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/loans/borrower_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: borrower_history.php</font>\n";
?>
	</div>
<div class="middle list">
	<div class="searchBox">
	<form name=usersearch action="" method=post onsubmit="javascript:return false">
	<input type=hidden name=Indice>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td><td>
		<input type="text" name="usercode" id="code" value="<?php if (isset($arrHttp["usuario"])) echo $arrHttp["usuario"]?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="index" value="<?php echo $msgstr["list"]?>" class="submit" onClick="javascript:AbrirIndice('U',document.usersearch.usercode)" />
		<input type="button" name="buscar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma('U')"/>
		</td></table>
	</form>
	</div>
	<div class=\"spacer\">&#160;</div>
	<dd>
		<?php echo $msgstr["clic_en"]." <i>".$msgstr["search"]."</i> ".$msgstr["para_c"]?>
</div>
<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=inventory>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){	echo "
	<script>
	alert('".$arrHttp["inventory"].": El número de inventario no está prestado')
	</script>
	";}
?>