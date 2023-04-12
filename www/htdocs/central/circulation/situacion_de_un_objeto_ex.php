<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org/
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      situacion_de_un_objeto_ex.php
 * @desc:      Shows the status of the items of an bibliographic record when the items are defined in the loanobjects database
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
*/
session_start();
// Situación de un objeto
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["ecta"]="Y";
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("leer_pft.php");
include("borrowers_configure_read.php");

include("loanobjects_read.php");
include("calendario_read.php");
include("locales_read.php");

include("../reserve/reserves_read.php");

function LocalizarLoanobjects($cn,$Opcion){
global $db_path,$Wxis,$xWxis,$wxisUrl,$config_date_format,$actparfolder;
	//$Expresion=trim($prefix_in).$arrHttp["inventory"];
    $Expresion="CN_".$cn;
    $Pft="";
    $archivo=$db_path."loanobjects/pfts/".$_SESSION["lang"]."/sob.pft";
    if (file_exists($archivo)){
    	$fp=file($archivo);
    	foreach ($fp as $value) $Pft.=$value." ";
    }
    if ($Pft==""){
    	$Pft="(if P(v959) then v1[1]'|'v10[1]'|'v959^i,'|',v959^l,'|',v959^b,'|',v959^v,'|',v959^t,'|',v959^o,'| ',ref(['trans']l(['trans'],'TR_P_'v959^i),v20, ref(['users']l(['users']'CO_'v20),' - 'v30),'|',";
    	switch (substr($config_date_format,0,2)){
		    case "DD":
		    case "d":
		    	$Pft.= "v40*6.2,'/',v40*4.2,'/',v40.4";
		    	break;
		    default:
		    	$Pft.= "v40*4.2,'/',v40*6.2,'/',v40.4";
		    	break;
		}
		$Pft.= "),/ fi),/" ;
	}
	$formato_ex=$Pft;
	//se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj=urlencode($formato_ex);
	$query = "&Opcion=disponibilidad&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=".$Expresion."&Pft=$formato_ex";
	include("../common/wxis_llamar.php");
	$loanobjects=array();
	$ix=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!="" and substr($linea,0,8)!='$$TOTAL:')
			$loanobjects[]=$linea;

	}
	return $loanobjects;
}


function LocalizarCopias($inventory,$Opcion){
global $db_path,$Wxis,$wxisUrl,$xWxis;
	$copies=array();
    $IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
    $formato_ex="v1'|'v10'|'v30'|',v200^a,|-|v200^b/";
   	$formato_obj=urlencode($formato_ex);
   	$Expresion="";
	if ($Opcion=="inventario"){
		// SE LOCALIZA EL NÚMERO DE CONTROL A PARTIR DEL NÚMERO DE INVENTARIO, PARA CONSTRUIR LA EXPRESION PARA RECUPERAR TODAS LAS COPIAS
    	$Expresion="IN_".$inventory;
   		$Expresion=urlencode($Expresion);

		$query = "&Opcion=disponibilidad&base=copies&cipar=$db_path"."par/copies.par&Expresion=".$Expresion."&Pft=$formato_ex";
		include("../common/wxis_llamar.php");
		$nc="";
        foreach ($contenido as $linea){
        	if ($linea!="" and substr($linea,0,8)!='$$TOTAL:'){
				$t=explode('|',$linea);
				if ($nc=="") $nc=$t[1]."_".$t[0];
				break;
			}
        }
        if ($nc==""){  //se obtiene el número de control desde loanobjects
        	$Expresion="IN_".$inventory;
   			$Expresion=urlencode($Expresion);
			$query = "&Opcion=disponibilidad&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=".$Expresion."&Pft=$formato_ex";
			include("../common/wxis_llamar.php");
			$nc="";
        	foreach ($contenido as $linea){
        		if ($linea!="" and substr($linea,0,8)!='$$TOTAL:'){
					$t=explode('|',$linea);
					$nc=$t[1]."_".$t[0];
					break;
				}
        	}
        }
        $Expresion="CN_".$nc;
    }else{
    	$Expresion="CN_".$inventory;
    	$nc=$inventory;
    }
    $formato_ex="v1'|'v10'|'v30'|',v200^a,|-|v200^b/";
	//se ubican las copias del título
	$Expresion=urlencode($Expresion);
	$query = "&Opcion=disponibilidad&base=copies&cipar=$db_path"."par/copies.par&Expresion=".$Expresion."&Pft=$formato_ex";
	include("../common/wxis_llamar.php");
	$ix=0;
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if ($linea!="" and substr($linea,0,8)!='$$TOTAL:'){
			$t=explode('|',$linea);
			$copies[$t[2]][0]=$linea;
		}
	}

    $loanobjects=LocalizarLoanobjects($nc,$Opcion);
    $encontrado="";
    foreach ($loanobjects as $linea){
    	if (trim($linea)!="" and substr($linea,0,8)!='$$TOTAL:'){
    		$t=explode('|',$linea);
    		$ninv=$t[2];
    		if (isset($copies[$ninv][0])){
    			$copies[$ninv][1]=$linea;
    		}else{
    			$copies[$ninv][0]=$linea;
    			$copies[$ninv][1]="*";
    		}
    	}

    }

	return $copies;
}




// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function ReadCatalographicRecord($control_number,$db){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_in,$pft_nc,$pft_typeofr,$titulo,$prefix_in,$multa,$lang_db;

	//Read the FDT of the database for extracting the prefix used for indexing the control number
//	echo $control_number;
    $Expresion="CN_".$control_number;
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
		if (substr($linea,0,8)=='$$TOTAL:')
			$total=trim(substr($linea,8));
		else
			$titulo.=$linea."\n";
	}
	return $total;
}



// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------
include("../common/header.php");
$reserves=0;
?>


<?php
if (isset($arrHttp["inventory_sel"]))
	$Opcion="inventario";
else
	$Opcion="control";
$disp=0;
$lista_control_no="";
// se busca el título para ver el total de ejemplares y los ejemplares prestados
$arrHttp["Opcion"]="disponibilidad";
if (isset($arrHttp["inventory_sel"]))
	$arrHttp["inventory"]=urldecode($arrHttp["inventory_sel"]);
else
	$arrHttp["inventory"]=$arrHttp["control"];
$codigos=explode("\n",$arrHttp["inventory"]);
$archivo=$db_path."loanobjects/pfts/".$_SESSION["lang"]."/sob_h.txt";
$tit_tabla="";
if (file_exists($archivo)) {
	$fp=file($archivo);
	foreach ($fp as $value) {
		if($tit_tabla=="")
		  	$tit_tabla.=$value;
		else
			$tit_tabla.='$$$'.$value;
	}
}else{
	$tit_tabla=$msgstr["inventory"].'$$$'.$msgstr["main_lib"].'$$$'.$msgstr["branch_lib"].'$$$'.$msgstr["volume"].'$$$'.$msgstr["tome"].'$$$'.$msgstr["typeofitems"].'$$$'.$msgstr["usercode"].'$$$'.$msgstr["devdate"];
}
$t_obj=explode('$$$',$tit_tabla);
$ncols_tit=count($t_obj);

foreach ($codigos as $cod_inv){
	$mensaje="";
	$cod_inv=trim($cod_inv);
	if ($cod_inv=="")continue;
	if (strpos($lista_control_no,";".$cod_inv.";")!==false)
		continue;
	$lista_control_no.=";".$cod_inv.";";
	$ejemp=LocalizarCopias($cod_inv,$Opcion);

	if (count($ejemp)==0){
		echo $cod_inv. "  **".$msgstr["ctrlnumno"];
	}else{
		$primera_vez="S";
		foreach ($ejemp as $eje){
			$tit=$eje[0];
       		if (trim($tit)!=""){
				$t=explode('|',$tit);
				$catalog_db=strtolower($t[1]);
				$control_no=$t[0];
				If (trim($catalog_db)!="" and $primera_vez=="S"){
					$primera_vez="N";
					$arrHttp["db"]=$catalog_db;
					require_once("databases_configure_read.php");
					$total=ReadCatalographicRecord($control_no,$catalog_db);
					if ($total>1){
						echo "<font color=red>".$msgstr["dupctrl"]."</font><p>";
                    }
					echo '<font color=darkblue><strong>'.$msgstr["bd"].": ". $catalog_db.". ".$msgstr["control_n"].": ".$control_no."</strong></font><br>";
					echo $titulo;

					if ($total==0){
						echo "<font color=red>".$msgstr["catalognotfound"]."</font><p>";
					}
					echo "<table class='table striped w100'><tr>";
					foreach ($t_obj as $val)
						echo "<th>".$val."</th>";

				}
				echo "</tr>";
				$lista_control_no.=ShowItems($eje,$codigos,$Opcion,$lista_control_no,$ncols_tit);
			}
		}
		echo "</table>";
		if ($mensaje=="S")
			echo "<font color=red>(*) ".$msgstr["copy_ncop"]."</font>";

		$reserves_arr=ReservesRead("CN_".strtoupper($catalog_db)."_".$control_no,"N");
		$reserves_user=$reserves_arr[0];
		if ($reserves_user!="")
			echo "<p><strong>".$msgstr["reserves"]."</strong><br>".$reserves_user."<p>";
		echo "<p>";
	}
}

Function ShowItems($item,$codigos,$Opcion,$lista_control_no,$cols){
global $msgstr,$mensaje;
	$lista_inv="";
	if (isset($item[1])){
		$nota="";
		if ($item[1]=="*") {
			$item[1]=$item[0];
			$nota="<font color=red> (*) </font>";
			$mensaje="S";
		}
		$l1=explode('|',$item[1]);
		//$l1=explode('$$$',$l[2]);
		$inv=$l1[2];
		echo "<tr>";
		$ixt=0;
		$ixcols=0;
		foreach ($l1 as $value){

			$ixcols=$ixcols+1;
			if ($ixcols>2){
				$ixt=$ixt+1;
	            echo "<td valign=top>";
	            if ($value=="")
	            	echo "&nbsp;";
	          	else
	            	echo $value;
	            echo "$nota </td>";
	            $nota="";
	         }

		}
		if($ixt<$cols){
			for ($i=$ixt;$i<$cols;$i++)
				echo "<td>&nbsp;</td>";
		}
		$lista_inv.=";".$inv.";";
    }else{
	    if (isset($item[0])){
	    	$l=explode('|',$item[0]);
			echo "<tr>";
			echo "<td>".$l[2]."</td>";
			echo "<td colspan=$cols-1>";
			echo $msgstr["copy_nlo"]." (".$l[3].")";
			echo "</td>";
    	}
    }
    return $lista_inv;
}

?>
<form name="reservas" method="post" action="../reserve/delete_reserve.php">
	<input type="hidden" name="Mfn_reserve">
	<input type="hidden" name="Accion">
<?php
if (isset($arrHttp["db_orig"]))
	echo "<input type=hidden name=db value=".$arrHttp["db_orig"].">\n";
if (isset($arrHttp["control"]))
	echo "<input type=hidden name=control value=".$arrHttp["control"].">\n";
else
	if (isset($arrHttp["inventory"]))
		echo "<input type=hidden name=inventory value=".$arrHttp["inventory"].">\n";
if (isset($arrHttp["inventory_sel"]))
	echo "<input type=hidden name=inventory_sel value=".$arrHttp["inventory_sel"].">\n";
?>

	<input type="hidden" name="retorno" value="../circulation/situacion_de_un_objeto_ex.php">
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

function AlertReserve(Mfn){
	alert("<?php echo $msgstr["cancel_and_assign"]?>")
	return
}
</script>