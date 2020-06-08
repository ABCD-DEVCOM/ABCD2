<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      situacion_de_un_objeto_db_ex.php
 * @desc:      Shows the status of the items of an bibliographic record when the items are defined inside the bilbiographic record
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
// Situación de un objeto
if (!isset($_SESSION["permiso"])){	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/situacion_de_un_objeto_db_ex.php";if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["ecta"]="Y";
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

include("../reserve/reserves_read.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["db"])){	$b=explode("|",$arrHttp["db"]);
	$arrHttp["base"]=$b[0];}
if (isset($arrHttp["inventory_sel"]))
	$Opcion="inventario";
else
	$Opcion="control";
include("leer_pft.php");
include("borrowers_configure_read.php");
include("calendario_read.php");
include("locales_read.php");


// Se localiza el número de control en la base de datos de objetos  de préstamo
function ReadControlNumber($control_number,$Opcion,$db,$prefix_cn,$pft_cn){
global $db_path,$Wxis,$xWxis,$wxisUrl,$lang_db,$msgstr;

	//Read the FDT of the database for extracting the prefix used for indexing the control number
//	echo $control_number;
    $Expresion=$prefix_cn.$control_number;
	//se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=$pft_cn";
	include("../common/wxis_llamar.php");
	$total=0;
	$titulo="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=substr($linea,8);
			}else{				return $linea;
				break;			}
		}
	}
}

// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function ReadCatalographicRecord($control_number,$Opcion,$db,$prefix_in,$tit_tabla,$Pft,$kardex){
global $db_path,$Wxis,$xWxis,$wxisUrl,$lang_db,$pft_in,$msgstr,$config_date_format,$lista_control_no;
    $inventarios_show="";
    $Expresion=$prefix_in.$control_number;

    //se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."$db/loans/".$lang_db."/loans_display.pft";
	$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Formato=$formato_obj";
	include("../common/wxis_llamar.php");
	$total=0;
	$titulo="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (substr($linea,0,8)=='$$TOTAL:'){
			$total=trim(substr($linea,8));
		}else{
			echo $linea."\n";
		}

	}
	if ($total==0){		echo "<font color=darkred>$control_number ".$msgstr["catalognotfound"]."</font><p>";
		return;	}
	//SE LEEN LOS ITEMS
	if ($kardex=="S"){		//$Pft_Kardex="v1,|_A:|v17,|V:|v18,|N:|v19";
		$Expresion='KARDEX_P_'.$control_number;		$query="&Opcion=disponibilidad&base=trans&cipar=$db_path"."par/trans.par&Expresion=".$Expresion."&Pft=$Pft";	}else{
		$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Pft=$Pft";
	}
	include("../common/wxis_llamar.php");
	$total=0;
	echo "<table bgcolor=#dddddd cellpadding=5>";
	//para imprimir el encabezado
	foreach ($tit_tabla as $linea)  echo "<td align=center><strong>$linea</strong></td>";
	$cols=count($tit_tabla);
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (trim($linea)!=""){			if (substr($linea,0,8)=='$$TOTAL:'){
				$total=trim(substr($linea,8));
			}else{
				$lista_control_no=ShowItems($linea,$lista_control_no,$Opcion,$cols);
			}
		}

	}
	return $inventarios_show;
}

Function ShowItems($item,$lista_inv,$Opcion,$cols){
global $config_date_format;
	echo "<tr>";
	$it=explode('|',$item);
	$ixt=0;
	$inv=$it[0];
	foreach ($it as $val){		$ixt=$ixt+1;
		echo "<td bgcolor=white>";
		echo $val;
		echo "</td>";
	}
	if($ixt<$cols){
		for ($i=$ixt;$i<$cols;$i++)
			echo "<td bgcolor=white> </td>";
	}
	$lista_inv.=";".$inv.";";
    return $lista_inv;
}



// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------
include("../common/header.php");
include("../common/institutional_info.php");
include("../circulation/scripts_circulation.php");
?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["ecobj"]?>
	</div>
	<div class="actions">
		<a href="situacion_de_un_objeto.php?base=<?php echo $arrHttp["base"]?>&encabezado=s" class="defaultButton backButton">
			<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
			<span><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/situacion_de_un_objeto.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/situacion_de_un_objeto.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: situacion_de_un_objeto_db_ex.php</font>\n";

echo "
	</div>
<div class=\"middle form\">
	<div class=\"formContent\">";

//GET THE INFORMATION OF THE DATABASE SELECTED
$arrHttp["db_orig"]=$arrHttp["db"];
$b=explode('|',$arrHttp["db"]);
$catalog_db=$b[0];
$pref_in=$b[2];
$pft_in=$b[3];
$pref_cn=$b[4];
$kardex="";
if (isset($b[6])){	$b[6]=trim(strtoupper($b[6]));
	if ($b[6]=="KARDEX") $kardex="S";}
$arrHttp["db"]=$catalog_db;
require_once("databases_configure_read.php");
$pft_in=str_replace("/"," ",$pft_in);
$pft_in=str_replace("\n"," ",$pft_in);
if (isset($_SESSION["library"])) $pft_in=str_replace('#library#',$_SESSION['library'],$pft_in);
if (isset($arrHttp["inventory_sel"])){	$arrHttp["inventory"]=urldecode($arrHttp["inventory_sel"]);
	$Opc="INV";}else{
	$arrHttp["inventory"]=$arrHttp["control"];
	$Opc="CTRL";
}
//SE LEE EL FORMATO DE LOS ENCABEZADOS
// se lee la configuración de la base de datos de usuarios
# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$uskey=$t[0];
$tag_uskey=LeerPft("loans_uskey.pft","users");;

$archivo=$db_path."$catalog_db/pfts/".$_SESSION["lang"]."/sob_h.txt";
$tit_tabla="";
$Pft="";
if (file_exists($archivo)) {
	$tit_tabla=file($archivo);
}else{
	$tit_tabla[]=$msgstr["inventory"];
	$tit_tabla[]=$msgstr["usercode"];
	$tit_tabla[]=$msgstr["devdate"];
}
//SE LEE EL FORMATO DE LOS REGISTROS
$archivo=$db_path."$catalog_db/pfts/".$_SESSION["lang"]."/sob.pft";
if (file_exists($archivo)){
    $fp=file($archivo);
    foreach ($fp as $value) $Pft.=$value." ";
}

if ($Pft==""){
	if ($kardex=="S"){		$Pft="(v95,| Año:|v17,| Volumen:|v18,| Número:|v19,'|', v20,ref(['users']l(['users']'$uskey'v20 ),' - 'v30),'|',";	}else{		$Pft="($pft_in,'|',ref(['trans']l(['trans'],'TR_P_'$pft_in),v20, ref(['users']l(['users']'$uskey'v20 ),' - 'v30),'|',";	}


   	switch (substr($config_date_format,0,2)){
	    case "DD":
	    	$Pft.= "v40*6.2,'/',v40*4.2,'/',v40.4";
	    	break;
	    default:
	    	$Pft.= "v40*4.2,'/',v40*6.2,'/',v40.4";
	    	break;
	}
	if ($kardex=="S"){		$Pft.= ",/)" ;	}else{		$Pft.= "),/)" ;	}

}
$Pft=urlencode($Pft);
$lista_control_no="";
$codigos=explode("\n",$arrHttp["inventory"]);

foreach ($codigos as $cod_inv){
	$cod_inv=trim($cod_inv);
	if ($cod_inv=="")continue;
	if ($Opc=="INV"){		if (isset($_SESSION["library"])) $cod_inv=$_SESSION["library"]."_".$cod_inv;	}
	if (strpos($lista_control_no,";".$cod_inv.";")!==false)
		continue;
	if ($Opcion=="inventario"){		$ejemp=ReadCatalographicRecord($cod_inv,$Opcion,$catalog_db,$pref_in,$tit_tabla,$Pft,$kardex);
		$pref=$pref_in;
	}else{		$ejemp=ReadCatalographicRecord($cod_inv,$Opcion,$catalog_db,$pref_cn,$tit_tabla,$Pft,$kardex);
		$pref=$pref_cn;	}
	echo "</table>";
	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
		$control_no=ReadControlNumber($cod_inv,$Opcion,$catalog_db,$pref,$pft_nc);
		$reserves_arr=ReservesRead("CN_".$catalog_db."_".$control_no);
		$reserves_user=$reserves_arr[0];
		if ($reserves_user!="")
			echo $reserves_user."<p>";

		echo "<p>";
	}
}
echo "<p>";
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";
?>
