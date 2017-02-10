<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      browse.php
 * @desc:      Browse the loan's databases
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
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$script_php="../circulation/buscar.php";
if (!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$arrHttp["base"].".par";
$arrHttp["Target"]="reserve";
$arrHttp["desde"]="reserve";
include ("../config.php");
include("../lang/dbadmin.php");

include("../lang/admin.php");
include("../lang/prestamo.php");


$Permiso=$_SESSION["permiso"];

include("../common/header.php");
include("../common/institutional_info.php");
include("../dataentry/formulariodebusqueda.php");
include("../reserve/reserves_read.php");
//SE LEE LA CONFIGURACION LAS POLITICAS DE PRESTAMO
include("../circulation/loanobjects_read.php");
include("../circulation/borrowers_configure_read.php");

$reserves_u_cn="";

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

//se busca el numero de control en el archivo de transacciones para ver si el usuario tiene otro ejemplar prestado
function LocalizarTransacciones($control_number,$prefijo){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;
	$formato_obj="v10'$$$',v98'$$$',v20'$$$',v40'$$$',v300/";
	//Número de inventario
	//base de datos
	//Fecha de devolucion
	//comentarios
	$query = "&Expresion=".$prefijo."_P_".$control_number."&base=trans&cipar=$db_path"."par/trans.par&Pft=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();

	foreach ($contenido as $linea){
		if (trim($linea)!=""){
			$lp=explode('$$$',$linea);
			if ($arrHttp["base"]==$lp[1]){				//Se determina si el préstamo corresponde a la base de datos desde la cual se busca
				$prestamos[$lp[0]]=$linea;
			}

        }
	}
	return $prestamos;
}

// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function LocalizarCopiasLoanObjects($control_number){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$politica,$msgstr;
    $Expresion="CN_".$arrHttp["base"]."_".$control_number;
	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);

	$formato_ex="v1'||'v10'||'v30'||',v200^a,|-|v200^b/";
	$formato_obj=urlencode($formato_ex);
	//se ubican las copias del título
	$Expresion=urlencode($Expresion);
	$query = "&Opcion=disponibilidad&base=copies&cipar=$db_path"."par/copies.par&Expresion=".$Expresion."&Pft=$formato_ex";
	include("../common/wxis_llamar.php");
	$ix=0;
	$copies=array();
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!="" and substr($linea,0,8)!='$$TOTAL:'){
			$t=explode('||',$linea);
			$copies[$t[2]][0]=$linea;
		}
	}
	$formato_ex="(if P(v959) then v1[1]'||'v10[1]'||'v959^i,'$$$ ',v959^l,'$$$ ',v959^b,'$$$ ',v959^o,'$$$ ',v959^v,'$$$ ',v959^t/ fi)";
	$formato_obj=urlencode($formato_ex);
	$query = "&Opcion=disponibilidad&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=".$Expresion."&Pft=$formato_obj";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){		if (trim($linea)!="" and substr($linea,0,8)!='$$TOTAL:'){
    		$t=explode('||',$linea);
    		$i=explode('$$',$t[2]);
    		$ninv=$i[0];
    		if (isset($copies[$ninv][0])){
    			$copies[$ninv][1]=$linea;
    		}else{
    			$copies[$ninv][0]=$ninv.'||||||No está en copias';
    			$copies[$ninv][1]=$linea;
    		}
		}
	}
	return $copies;
}


function LocalizarCopias($control_number){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$politica,$msgstr,$lang_db;
	//SE LEE EL PREFIJO PARA EXTRAER EL NUMERO DE CONTROL DE LA BASE DE DATOS
	$archivo=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/loans/".$lang_db."/loans_conf.tab";
	if (!file_exists($archivo)){
		echo $msgstr["falta"]." ".$arrHttp["db"]."/loans/".$_SESSION["lang"]."/loans_conf.tab";
		die;
	}else{
		$fp=file($archivo);
		foreach ($fp as $value){
			if (trim($value)!=""){
				$ix=strpos($value," ");
				$tag=trim(substr($value,0,$ix));
				switch($tag){
					case "IN": $prefix_in=trim(substr($value,$ix));
						break;
					case "NC": $prefix_cn=trim(substr($value,$ix));
						break;
				}
			}
		}
	}
	$pft_totalitems=LeerPft("loans_inventorynumber.pft",$arrHttp["base"]);
	if (isset($_SESSION["library"])) $pft_totalitems=str_replace('#library#',$_SESSION['library'],$pft_totalitems);
	$pft_typeofr=LeerPft("loans_typeofobject.pft",$arrHttp["base"]);
	$pft_typeofr=trim($pft_typeofr);
	if (substr($pft_typeofr,0,1)=="("){		$pft_typeofr=substr($pft_typeofr,1);	}
	if (substr($pft_typeofr,strlen($pft_typeofr)-1,1)==")"){
		$pft_typeofr=substr($pft_typeofr,0,strlen($pft_typeofr)-1);
	}
    $Expresion=$prefix_cn.$control_number;
	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$ixpni=strpos($pft_typeofrec,'~');
	$tofr1="";$tofr2="";
	if ($ixpni>0){
		$tofr1=substr($pft_typeofrec,0,$ixpni);
		$tofr2=substr($pft_typeofrec,$ixpni+1);
		$pft_typeofr=$tofr1;
	}
	$Pft="($pft_totalitems'||'".$pft_typeofr."/)/";
	if ($tofr2!="")
		$Pft.=",('||'".$tofr2."/)/";
	$query = "&Opcion=disponibilidad&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Expresion=".$Expresion."&Pft=($pft_totalitems'||'".$pft_typeofr."/)/";
	include("../common/wxis_llamar.php");
	$total=0;
	$copias=array();
	$item="";
    $items_reserve=0;

	foreach ($contenido as $linea){		if (substr($linea,0,4)=='WXIS') {			echo "<xmp>loans_inventorynumber.pft  /  loans_typeofobject.pft\n";			$Pft="($pft_totalitems'||'".$pft_typeofr."/)/\n";
			echo "$Pft";			echo "**$linea</xmp><br>";
			die;		}		$linea=trim($linea);
		if ($linea!=""){
			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=substr($linea,8);
			}else{
				$l=explode('||',$linea);
				$copias[$l[0]][1]=$linea;
			}
		}
	}
	return ($copias) ;
}


//SE VERIFICA SI EL TITULO ESTA DISPONIBLE PARA RESERVA
function Disponibilidad($control_n,$copies){
global $msgstr;	// SE DETERMINA SI HAY EJEMPLARES PRESTADOS
		if ($control_n=="") {		echo "<h4>".$msgstr["falta"]." ".$msgstr["control_n"]."</h4>";die;	}
	$disponibles=0;
	$items=array();
	//SE DETERMINA LOS EJEMPLARES EXISTENTES
	switch ($copies){		case "Y":
			// SE DETERMINA LA DISPONIBILIDAD DE LOS EJEMPLARES DESDE LOANOBJECTS
			$items=LocalizarCopiasLoanobjects($control_n);
			break;
		case "N":
			// SE DETERMINA LA DISPONIBILIDAD DE LOS EJEMPLARES DESDE EL CATÁLOGO
			$items=LocalizarCopias($control_n);
			break;	}
	//$disponibles=Cantidad de items que se pueden reservar; $prestamos[0]=arreglo con los ejemplares prestados;
	//$items[0]=Ejemplares obtenidos formateados
	return $items;
}

function Reservas($cn,$base){global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db,$config_date_format,$reservas_u_cn;
    //Se determina si el usuario no tiene prestado un ejemplar del título que desea reservar
	$reserves_arr=ReservesRead("CN_".$base."_".$cn);
	$output=$reserves_arr[0];

	if ($output!="")
		$output= "<br><strong><font color=darkred>".$msgstr["reserves"].": </font></strong><br>".$output;
	return array($output,$reserves_arr[1]);}

function MostrarResultados($contenido){global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db,$Expresion,$copies,$reservas_u_cn,$reserve_active;
	$con="";
	$ix=0;
	foreach ($contenido as $value) $con.=$value;
	$registro=explode('####',$con);
	foreach ($registro as $linea){		if (trim($linea)!="") {			$lin=explode('$$$$',$linea);
			$msgerr="";
			$reservas_activas=0;
			$output="";
			if (isset($lin[1])){
				if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
					$reserves_arr=Reservas($lin[1],$arrHttp["base"]);
					$output=$reserves_arr[0];
               	 	$reservas_activas=$reserves_arr[1];
				}
				$items=Disponibilidad($lin[1],$arrHttp["copies"]);
				$prestamos=LocalizarTransacciones($lin[1],"ON");
				echo $lin[0];
				echo "<table bgcolor=#dddddd cellpadding=5>
						<th>".$msgstr["inventory"]."</th>
						<th>".$msgstr["volume"]."</th>
						<th>".$msgstr["tome"]."</th>
						<th>".$msgstr["typeofitems"]."</th>
						<th>".$msgstr["usercode"]."</th>
						<th>".$msgstr["devdate"]."</th>
						<th>".$msgstr["status"]."</th>
						<th>".$msgstr["comments"]."</th>";
				foreach ($items as $itx){
					ShowItems($itx,$prestamos);				}
				echo "</table>";
				echo $output;
				echo "<hr>";
			}

		}
	}


	echo "</form>";

	echo "<input type=button value='".$msgstr["back"]."' onclick=document.regresar.submit()>";
}

Function ShowItems($item,$prestamos){
global $config_date_format,$arrHttp;
	$comentarios="";
	$status="";
	if (isset($item[1])){		switch ($arrHttp["copies"]){
			case "Y":
				$l=explode('$$$',$item[1]);
				$l1=explode('||',$l[0]);
				$inv=$l1[2];
				echo "<tr>";
				echo "<td bgcolor=white>";
				echo $inv."</td>";
				echo "<td bgcolor=white>".$l[4]."</td>";
				echo "<td bgcolor=white>".$l[5]."</td>";
				echo "<td bgcolor=white>".$l[3]."</td>";
    	    	$status=$l[5];
				break;
			case "N":
				$l1=explode('||',$item[1]);
				$inv=$l1[0];
				echo "<tr>";
				echo "<td bgcolor=white>";
				echo $inv."</td>";
				echo "<td bgcolor=white>&nbsp;</td>";
				echo "<td bgcolor=white>&nbsp;</td>";
				echo "<td bgcolor=white>".$l1[1]."</td>";
	        	$status="";
				break;
			}

    }else{
	    if (isset($item[0])){
	    	$l=explode('||',$item[0]);
	    	$inv=$l[2];
	    	echo "<tr><td bgcolor=white>".$l[2]."</td>";
	    	echo "<td bgcolor=white>&nbsp;</td>";
	    	echo "<td bgcolor=white>&nbsp;</td>";
	    	echo "<td bgcolor=white>&nbsp;</td>";
	    	$status=$l[3];

		}
	}
	if (isset($prestamos[$inv])){		$p=explode('$$$',$prestamos[$inv]);
		echo "<td bgcolor=white>".$p[2]."</td>";
		echo "<td bgcolor=white>";
		$date = new DateTime($p[3]);
	    switch (substr($config_date_format,0,2)){
	    	case "DD":
	    		echo $date->format("d/m/Y");
	    		break;
	    	default:
	    		echo $date->format("m/d/Y");
	    		break;
	    }
	    echo "</td>";
	    $comentarios=$p[4];	}else{		echo "<td bgcolor=white>&nbsp;</td>";
	    echo "<td bgcolor=white>&nbsp;</td>";	}
	echo "<td bgcolor=white>";
	if (isset($item[0])) {		$l=explode('||',$item[0]);
		echo $l[3];	}
	echo "</td>";
	echo "<td bgcolor=white>$comentarios</td>";

}



function EjecutarBusqueda(){
global $arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db,$Expresion;

	$formato_cn=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_cn.pft";
	if (!file_exists($formato_cn)) $formato_cn=$db_path.$arrHttp["base"]."/loans/$lang_db/loans_cn.pft";
	$fp=file($formato_cn);
	$Pft_cn="";
	foreach ($fp as $value){		$value=trim($value);
		if ($value!="")
			$Pft_cn.=$value;
	}
	$formato_obj=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$arrHttp["base"]."/loans/".$lang_db."/loans_display.pft";
	$fp=file($formato_obj);
	$Pft="";
	foreach ($fp as $value){		$Pft.=$value;	}
	$Pft=$Pft."'$$$$'".$Pft_cn."'####'";
	$Pft=urlencode($Pft);
 	$arrHttp["Formato"]=$formato_obj;
	$vienede=$arrHttp["Opcion"];
	if ($arrHttp["Opcion"]!="continuar" and $arrHttp["Opcion"]!="buscar_en_este"){
		$Expresion=PrepararBusqueda();
	}else{
		$Expresion=urldecode($arrHttp["Expresion"]);
	 	$Expresion=stripslashes($Expresion);
		$arrHttp["Opcion"]="busquedalibre";
	}
	//echo $Expresion;
	$Expresion=urlencode(trim($Expresion));
	if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
	if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]=1;
	$arrHttp["count"]="";
	if (!isset($arrHttp["Formato"]))$arrHttp["Formato"]="ALL";
	$Formato=$arrHttp["Formato"];
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Expresion=".$Expresion."&Opcion=".$arrHttp["Opcion"]."&count=".$arrHttp["count"]."&Mfn=".$arrHttp["Mfn"]."&Pft=$Pft";
	include("../common/wxis_llamar.php");
	MostrarResultados($contenido);

}


// Prepara la fórmula de búsqueda cuando viene de la búsqueda avanzada

function PrepararBusqueda(){
global $arrHttp,$matriz_c,$camposbusqueda;

	if (!isset($arrHttp["Campos"])) $arrHttp["Campos"]="";
	$expresion=explode(" ~~~ ",$arrHttp["Expresion"]);
	$campos=explode(" ~~~ ",$arrHttp["Campos"]);
	if (isset($arrHttp["Operadores"])){
		$operadores=explode(" ~~~ ",$arrHttp["Operadores"]);
	}
	if (isset($arrHttp["Prefijos"])){
		$prefijos=explode(" ~~~ ",$arrHttp["Prefijos"]);
	}
	// se analiza cada sub-expresion para preparar la fórmula de búsqueda
	$nse=-1;
	for ($i=0;$i<count($expresion);$i++){
		$expresion[$i]=trim(stripslashes($expresion[$i]));
		if ($expresion[$i]!=""){

			$cb=$matriz_c[$prefijos[$i]];
			$cb=explode('|',$cb);
			$pref=trim($cb[2]);
			$pref1='"'.$pref;
			if (substr(strtoupper($expresion[$i]),0,strlen($pref1))==strtoupper($pref1) or substr(strtoupper($expresion[$i]),0,strlen($pref))==strtoupper($pref)){

			}else{

				$expresion[$i]=$pref.$expresion[$i];
			}
			$formula=str_replace("  "," ",$expresion[$i]);
			$subex=Array();
			if (trim($campos[$i])!="" and trim($campos[$i])!="---"){
				$id="/(".trim($campos[$i]).")";
			}else{
				$id="";
			}
			$xor="¬or¬$pref";
			$xand="¬and¬$pref";

			$formula=stripslashes($formula);
			while (is_integer(strpos($formula,'"'))){
				$nse=$nse+1;
				$pos1=strpos($formula,'"');
				$xpos=$pos1+1;
				$pos2=strpos($formula,'"',$xpos);
				$subex[$nse]=trim(substr($formula,$xpos,$pos2-$xpos));
				if ($pos1==0){
					$formula="{".$nse."}".substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1-1)."{".$nse."}".substr($formula,$pos2+1);
				}
			}
			$formula=str_replace (" {", "{", $formula);
			$formula=str_replace (" or ", $xor, $formula);
			$formula=str_replace ("+", $xor, $formula);
			$formula=str_replace (" and ", $xand, $formula);
			$formula=str_replace ("*", $xand, $formula);
			$formula=str_replace ('\"', '"', $formula);
		//	if (substr($formula,0,strlen($pref))!=$pref)
		//		$formula=$pref.$formula;
			while (is_integer(strpos($formula,"{"))){
				$pos1=strpos($formula,"{");
				$pos2=strpos($formula,"}");
				$ix=substr($formula,$pos1+1,$pos2-$pos1-1);
				if ($pos1==0){
					$formula=$subex[$ix].substr($formula,$pos2+1);
				}else{
					$formula=substr($formula,0,$pos1)." ".$subex[$ix]." ".substr($formula,$pos2+1);
				}
			}

			$formula=str_replace ("¬", " ", $formula);
//			if (substr($formula,0,strlen($pref))!=$pref) $formula=$pref.$formula;
			$expresion[$i]=trim($formula);
		}
	}
	$formulabusqueda="";
	for ($i=0;$i<count($expresion);$i++){
		if (trim($expresion[$i])!=""){
			$formulabusqueda=$formulabusqueda." (".$expresion[$i].") ";
			$resto="";
			for ($j=$i+1;$j<count($expresion);$j++){
				$resto=$resto.trim($expresion[$j]);
			}
			if (trim($resto)!="") $formulabusqueda=$formulabusqueda." ".$operadores[$i];
		}
	}
	return $formulabusqueda;

}
include("../circulation/scripts_circulation.php");
?>
<script>

function AbrirIndice(xI){
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


function Enviar(){	ix=document.seleccionar.bd.selectedIndex	if (ix>0){		base=document.seleccionar.bd.options[ix].value
		document.busqueda.base.value=base
		document.busqueda.cipar.value=base+".par"
		document.busqueda.copies.value=copies
		document.busqueda.submit()	} else{		alert("<?php echo $msgstr["seldb"]?>")
		return	}}
</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["ecobj"];
		if (isset($arrHttp["base"]))
			echo " - ".$arrHttp["base"];
		else
			echo " - ".$base_sel;
		?>
	</div>
	<div class="actions">
<?php include("../circulation/submenu_prestamo.php");?>

	</div>
	<div class="spacer">&#160;</div>
</div>
<?php if (!isset($arrHttp["base"])){?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reserva.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reserva.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reserve/buscar.php</font>
	</div>";
 }
if ($arrHttp["Opcion"]!="formab")
	echo "<div class=\"middle form\">
		<div class=\"formContent\">";



if (!isset($arrHttp["base"])){	if ($ix_nb==0){		$arrHttp["base"]=$base_sel;
		$arrHttp["cipar"]=$base_sel.".par";
	$arrHttp["Opcion"]="formab";
		$arrHttp["copies"]=$copies;
		$arrHttp["desde"]="reserva";
		$arrHttp["count"]=1;	}else{

		echo "\n<script>copies='$copies'</script>\n";		?>  }
		<form name=seleccionar>
		<input type=hidden name=Opcion value=formab>
		<table width=100% border=0>
			<td width=150>
				<label for="dataBases">
				<strong><?php echo $msgstr["basedatos"]?></strong>
				</label>
				</td><td>
				<select name=bd onchange=Enviar()>
				<option></option>
		<?php
		foreach ($bases_p as $value){
			$v=explode('|',$value);
			echo "<option value=".$v[0].">".$v[1]."</option>\n";
		}
		echo "</select>
		      </table>
		      </form>";	}
}
if (!isset($arrHttp["base"])){}else{
	$a= $db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/busquedaprestamo.tab";
	$fp=file_exists($a);
	if (!$fp){
		$a= $db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
		$fp=file_exists($a);
		if (!$fp){
			$a= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
			$fp=file_exists($a);
			if (!$fp){
				echo "<br><br><h4><center>".$msgstr["faltacamposbusqueda"]."</h4>";
				die;
			}
		}
	}
	$fp = fopen ($a, "r");
	$fp = file($a);
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
	        $camposbusqueda[]= $linea;
			$t=explode('|',$linea);
			$pref=$t[2];
			$matriz_c[$pref]=$linea;
		}
	}
	switch ($arrHttp["Opcion"]){		case "formab":
		    $arrHttp["Opcion"]="buscar";

			DibujarFormaBusqueda();
			?>
<form name=basedatos action=situacion_de_un_objeto.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=copies value=<?php echo $arrHttp["copies"]?>>
<input type=hidden name=ecta value=Y>
<input type=hidden name=count value=1>
<input type=hidden name=Opcion value=formab>

</form><?php
			die;
			break;
		case "buscar":
		case "buscar_en_este":
			$arrHttp["Expresion"]=urldecode($arrHttp["Expresion"]);
			EjecutarBusqueda();
			break;

		}

}
echo "</div></div>";
if ($arrHttp["Opcion"]!="formab") include("../common/footer.php");
?>




<form name=busqueda action=buscar.php method=post>
<input type=hidden name=base>
<input type=hidden name=desde value=reserva>
<input type=hidden name=count value=1>
<input type=hidden name=cipar>
<input type=hidden name=Opcion value=formab>
<input type=hidden name=copies value=<?php echo $arrHttp["copies"]?>>
</form>

<form name=regresar action=buscar.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=copies value=<?php echo $arrHttp["copies"]?>>
<input type=hidden name=ecta value=Y>
<input type=hidden name=count value=1>
<input type=hidden name=Opcion value=formab>
</form>


</body>
</Html>


