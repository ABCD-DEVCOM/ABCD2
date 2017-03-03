<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure.php
 * @desc:      Input the configuration of the borrowers (users) database
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
include("../lang/dbadmin.php");
include("../lang/prestamo.php");
include("leer_pft.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>"; die;

// SE LEE LOS PARÁMETROS DE CONFIGURACIÓN
if (isset($arrHttp["db_inven"])){
//IF NO LOANOBJECTS READ THE PFT FOR EXTRACTING THEN INVENTORY NUMBER AND THE TYPE OF RECORD
	$bd_sel=$arrHttp["db_inven"];
	$d=explode('|',$arrHttp["db_inven"]);
	$arrHttp["base"]=strtolower($d[0]);
	$arrHttp["db_inven"]=strtolower($d[0]);
	$pft_nc=LeerPft("loans_cn.pft",$d[0]);
	$pft_nc=str_replace("/"," ",$pft_nc);
	$pft_typeofrec=LeerPft("loans_typeofobject.pft",$d[0]);
	$pft_typeofrec=str_replace("/"," ",$pft_typeofrec);
	$pft_typeofrec=str_replace("\n"," ",$pft_typeofrec);
	$pft_typeofrec=trim($pft_typeofrec);
	if (substr($pft_typeofrec,0,1)=="(")
		$pft_typeofrec=substr($pft_typeofrec,1);
	if (substr($pft_typeofrec,strlen($pft_typeofrec)-1,1)==")")
		$pft_typeofrec=substr($pft_typeofrec,0,strlen($pft_typeofrec)-1);
	$ixpni=strpos($pft_typeofrec,'~');
	if ($ixpni>0){
		$tofr1=substr($pft_typeofrec,0,$ixpni);
		$tofr2=substr($pft_typeofrec,$ixpni+1);
	}
	$pft_ni=LeerPft("loans_inventorynumber.pft",$d[0]);
	$pft_ni=str_replace("/"," ",$pft_ni);
	$pft_ni=str_replace("\n"," ",$pft_ni);
	$ixpni=strpos($pft_ni,'~');
	if ($ixpni>0){
		$nvi1=substr($pft_ni,0,$ixpni);
		if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
		$formato_ex="('||".$d[0]."||',$nvi1,'||||||',".$tofr1.",'||||||'/)";

		$nvi1=substr($pft_ni,$ixpni+1);
		if (isset($_SESSION["library"])) $nvi1=str_replace('#library#',$_SESSION['library'],$nvi1);
		$formato_ex.=",('||".$d[0]."||',$nvi1,'||||||',".$tofr2.",'||||||'/)";
		$formato_ex=$pft_nc.",".$formato_ex;
	}else{
		if (isset($_SESSION["library"])) $pft_ni=str_replace('#library#',$_SESSION['library'],$pft_ni);
		$formato_ex="$pft_nc,('||".$d[0]."||',$pft_ni,'||||||',".$pft_typeofrec.",'||||||'/)";
	}
	if (isset($_SESSION["library"])) $formato_ex=str_replace('#v5000#',"'".$_SESSION["library"]."'",$formato_ex);
}else{
	$arrHttp["base"]="loanobjects";
	$formato_ex="(v1[1]'||'v10[1],'||',v959^i,'||',v959^l,'||',v959^b,'||',v959^o,'||',v959^v,'||',v959^t,'||'/)";
   // control number||database||inventory||main||branch||type||volume||tome
}
$formato_obj=urlencode($formato_ex);
//
if (isset($bd_sel)){
	$dbi=explode('|',$bd_sel);
	if ($dbi[0]!="loanobjects"){
		$from_copies="N";
		$x=explode('|',$bd_sel);
    	$var=LeerPft("loans_conf.tab",$x[0]);
		$prefix_in=trim($x[2]);
	}else{
		$prefix_in="IN_";
		$from_copies="Y";
	}
}else{
	$prefix_in="IN_";
	$from_copies="Y";
}
if (isset($arrHttp["Opcion"])){
	if ( $arrHttp["Opcion"]=="reservar")
		$msg_1=$msgstr["reserve"];
	else
		if ($arrHttp["Opcion"]=="prestar") $msg_1=$msgstr["loan"];
}




function wxisLLamar($query,$base,$IsisScript){global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;	include("../common/wxis_llamar.php");
	return $contenido;}

function ProcesarPrestamo($usercode,$inventory,$referencia,$typeofuser,$typeofloan,$control_number,$db){
global $db_path;
	$ValorCapturado="<1 0>X</1>";
	$ValorCapturado.="<10 0>".trim($inventory)."</10>";	// INVENTORY NUMBER
	if (isset($item_data[6])) $ValorCapturado.="<12 0>".$item_data[6]."</12>";         	// VOLUME
	if (isset($item_data[7])) $ValorCapturado.="<15 0>".$item_data[7]."</15>";          // TOME
	if (isset($arrHttp["year"]))    $ValorCapturado.="<17 0>".$arrHttp["year"]."</17>";       // AÑO REVISTA
	if (isset($arrHttp["volumen"])) $ValorCapturado.="<18 0>".$arrHttp["volumen"]."</18>";    // VOLUMEN REVISTA
	if (isset($arrHttp["numero"]))  $ValorCapturado.="<19 0>".$arrHttp["numero"]."</19>";     // NUMERO REVISTA
	$ValorCapturado.="<20 0>".$usercode."</20>";
	$ValorCapturado.="<30 0>".date("Ymd")."</30>";
	//if ($obj[5]=="H")
	$ValorCapturado.="<35 0>".date("h:i A")."</35>";
	$ValorCapturado.="<40 0>".date("Ymd")."</40>";
	$ValorCapturado.="<45 0>".date("h:i A")."</45>";
	$ValorCapturado.="<70 0>".$typeofuser."</70>";
	$ValorCapturado.="<80 0>".$typeofloan."</80>";
	$ValorCapturado.="<95 0>".$control_number."</95>";                   // Control number of the object
	$ValorCapturado.="<98 0>".$db."</98>";             			// Database name
	$ValorCapturado.="<100 0>".$referencia."</100>";
	if (isset($_SESSION["library"])) $ValorCapturado.="<150 0>".$_SESSION["library"]."</150>";
	$ValorCapturado.="<120 0>^a".$_SESSION["login"]."^b".date("Ymd h:i A")."</120>";
	$ValorCapturado=urlencode($ValorCapturado);
    $query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."&Pft=mfn/&ValorCapturado=".$ValorCapturado;
    $contenido= wxisLLamar($query,"trans","crear_registro.xis");
    return $contenido;}

function LocalizarInventario($inventory){
global $db_path,$arrHttp,$pft_totalitems,$pft_ni,$copies_title,$prefix_in,$formato_obj;
    $Expresion=$prefix_in.$inventory;
	// Se extraen las variables necesarias para extraer la información del título al cual pertenece el ejemplar
	// se toman de databases_configure_read.php
	// pft_totalitems= pft para extraer el número total de ejemplares del título
	// pft_in= pft para extraer el número de inventario
	// pft_nc= pft para extraer el número de clasificación
	// pft_typeofr= pft para extraer el tipo de registro

	//READ LOANOBJECT DATABASE TO GET THE RECORD WITH THE ITEMS OF THE TITLE
	$Expresion=urlencode($Expresion);
	if (isset($arrHttp["db_inven"])){
		$dbi=explode('|',$arrHttp["db_inven"]);
		$dbi_base=$dbi[0];
	}else{		$dbi_base="loanobjects";	}
	$query = "&Opcion=disponibilidad&base=$dbi_base&cipar=$db_path"."par/$dbi_base.par&Expresion=".$Expresion."&Pft=$formato_obj";
	$contenido=wxisLlamar($query,$dbi_base,"loans/prestamo_disponibilidad.xis");
	$total=0;
	$copies_title=array();
	$item="";
    $cno="";
    $tto="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=trim(substr($linea,8));
			}else{
				$t=explode('||',$linea);
				if ($t[0]!="" ) $cno=$t[0];
				if ($t[5]!="")  $tto=$t[5];
				if ($t[0]=="" ) $t[0]=$cno;
				if ($t[5]=="")  $t[5]=$tto;
				$linea="";
				foreach ($t as $value){
					$linea.=trim($value)."||";
				}
				if (strtoupper($inventory)==strtoupper(trim($t[2]))) $item=$linea;
				$copies_title[]=$linea;
			}
		}
	}
	$ret=array($total,$item);
	return $ret ;
}


function ReadCatalographicRecord($control_number,$db,$inventory){
global $Expresion,$db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_ni,$pft_nc,$pft_typeofr,$titulo,$prefix_in,$prefix_cn,$multa,$pft_storobj,$lang_db;
	//Read the FDT of the database for extracting the prefix used for indexing the control number
//	echo $control_number;
	$pft_typeofr=str_replace('~',',',$pft_typeofr);
	if (isset($arrHttp["db_inven"])){
		$dbi=explode("|",$arrHttp["db_inven"]);
	}else{
		$dbi[0]="loanobjects";
	}

	if (isset($arrHttp["db_inven"]) and $dbi[0]!="loanobjects"){

		$Expresion=trim($prefix_cn).trim($control_number);
	}else{
	    $Expresion="CN_".trim($control_number);
	}
	if ($control_number=="")
		$Expresion=$prefix_in.$inventory;
//    echo $Expresion;
	// Se extraen las variables necesarias para extraer la información del título al cual pertenece el ejemplar
	// se toman de databases_configure_read.php
	// pft_totalitems= pft para extraer el número total de ejemplares del título
	// pft_in= pft para extraer el número de inventario
	// pft_nc= pft para extraer el número de clasificación
	// pft_typeofr= pft para extraer el tipo de registro

	$formato_ex="'||'".$pft_nc."'||'".$pft_typeofr."'###',";
	//se ubica el título en la base de datos de objetos de préstamo
	$Expresion=urlencode($Expresion);
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$db. "/loans/".$lang_db."/loans_display.pft";
	//$formato_obj.=", /".urlencode($formato_ex).urlencode($pft_storobj);
    $formato_obj.=urlencode(", /".$formato_ex.$pft_storobj);
	$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=@$formato_obj";
	$contenido=wxisLlamar($query,$db,"loans/prestamo_disponibilidad.xis");
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
	return $total;
}


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$archivo=$db_path."/circulation/def/".$_SESSION["lang"]."/sala.tab";
if (!file_exists($archivo)) $archivo=$db_path."/circulation/def/".$lang_db."/sala.tab";
$fp=file_exists($archivo);
$sala=array();
if ($fp){
	$fp=file($archivo);
	foreach ($fp as $value){		$value=trim($value);
		if ($value!=""){			$v=explode('=',$value);
			$sala[$v[0]]=$v[1];		}
	}
}

include("../common/header.php");
?>
<style>
	td{		font-size:12px;	}
</style>
<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".$msgstr["sala"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"sala.php\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
				echo "
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/sala.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/sala.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=Pr%C3%A9stamo_en_sala target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/sala_configure.php </font>";
echo "</div>
		<div class=\"middle form\">
			<div class=\"formContent\"> ";
echo "\n<table bgcolor=#CCCCCC cellpadding=5 >";
echo "<td>".$msgstr["inventory"]."</td><td>".$msgstr["control_n"]."</td><td>".$msgstr["reference"]."</td><td></td></tr>";
$invent=explode("\n",trim(urldecode($arrHttp["inventory"])));
foreach ($invent as $arrHttp["inventory"]){
   	$arrHttp["inventory"]=trim($arrHttp["inventory"]);
   	if ($arrHttp["inventory"]=="") continue;
   	$cont="Y";
   	echo "<tr><td bgcolor=white>".$arrHttp["inventory"]."</td>";
   	if (isset($_SESSION["library"])) $arrHttp["inventory"]=$_SESSION["library"]."_".$arrHttp["inventory"];
	//Se ubica el ejemplar en la base de datos de objeto
	$res=LocalizarInventario($arrHttp["inventory"]);
	$total=$res[0];
	$item=$res[1];
	if ($total==0){
		echo "<td bgcolor=white valign=top></td><td bgcolor=white valign=top></td><td bgcolor=white><font color=red>".$msgstr["copynoexists"]."</font></td>";
		$cont="N";
	}else{
	//se extrae la información del número de control del título y la base de datos catalográfica a la cual pertenece
		$tt=explode('||',$item);
		$control_number=$tt[0];
		$catalog_db=strtolower($tt[1]);
   		$tipo_obj=trim($tt[5]);      //Tipo de objeto
// se lee la configuración de la base de datos de objetos de préstamos
		$arrHttp["db"]="$catalog_db";
		echo "<td bgcolor=white valign=top align=center>$control_number  ($catalog_db)</td>";
        require_once("databases_configure_read.php");
		$ref_cat=ReadCatalographicRecord($control_number,$catalog_db,$arrHttp["inventory"]);
		if ($ref_cat==0){      //The catalographic record is not found
			echo "<td  bgcolor=white valign=top></td><td  bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["catalognotfound"]." ($catalog_db)</font></td>";
			$cont="N";
		}
		if ($ref_cat>1){      //More than one catalographic record
			echo "<td  bgcolor=white valign=top></td><td  bgcolor=white valign=top></td><td  bgcolor=white valign=top><font color=red>".$msgstr["dupctrl"]." ($catalog_db)</font></td>";
			$cont="N";
		}
		if ($cont=="Y"){
			$tt=explode('###',trim($titulo));
			$obj_store=$tt[1];
			$tt=explode('||',$tt[0]);
			$titulo=$tt[0];
			     //signatura topográfica
			$resultado=ProcesarPrestamo($sala["usercode"],$arrHttp["inventory"],$obj_store,$sala["typeofuser"],$sala["typeofloan"],$control_number,$catalog_db);
			$resul=implode("\n",$resultado);
			echo  "<td bgcolor=white valign=top>$titulo</td><td bgcolor=white valign=top>".$msgstr["updated"]." $resul</td>";
		}
	}
}
echo "</table></span>";
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>