<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
global $arrHttp;
include("../common/get_post.php");
include("../config.php");


if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");
?>
<html>
<head>


<script>
	function LeerOperador(){
		Mfn=document.menu.oper.options[document.menu.oper.selectedIndex].value
		if (Mfn=="") return

		msgwin=window.open("../dataentry/fmt.php?Opcion=leer&base=acces&cipar=acces.par&Mfn="+Mfn+"&ver=N&ventana=S","acces","width=750,height=600,menubar=0,scrollbars=1")
		msgwin.focus()
	}
	function NuevoOperador(){
		msgwin=window.open("../dataentry/fmt.php?Opcion=leer&base=acces&cipar=acces.par&Mfn=New&ver=N&ventana=S","acces","width=750,height=600,menubar=0,scrollbars=1")
		msgwin.focus()
	}
</script>
<body>
<?
	echo "
	<form name=menu>
	";
	$query = "&base=acces&cipar=$db_path"."par/acces.par&from=1&Opcion=leertodo";
	$IsisScript=$xWxis."auditoria.xis";
	$xWxis."auditoria.xis "
	$ic=-1;
	foreach($contenido as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			if (trim(substr($linea,0,4))=="mfn="){
				$ic=$ic+1;
				$ix=strpos($linea,'<');
				if ($ix===false){
				}else{
					$linea=substr($linea,0,$ix);
				}
				$valortag[$ic][0]=substr($linea,4);

  			}else{
	    		$pos=strpos($linea, " ");
    			if (is_integer($pos)) {
     				$tag=trim(substr($linea,0,$pos));
////El formato ALL envía un <br> al final de cada línea y hay que quitarselo
//
    				$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));
					if ($tag==1002){
	 					$maxmfn=$linea;
					}else{
     					if (!isset($valortag[$ic][$tag])){
      						$valortag[$ic][$tag]=$linea;
     					}else{
     	 					$valortag[$ic][$tag]=$valortag[$ic][$tag]."\n".$linea;
     					}
    				}
   				}
  			}
 		}
	}
	echo "<center><p><br><br><font face=verdana><h4>Actualizar operadores</h4><Table border=1 cellpadding=5>
		<tr><td class=menusec2>
	Actualizar Operador:<select name=oper onChange=LeerOperador()><option value=''></option>";
	foreach ($valortag as $value) echo "<option value=".$value[0].">".$value[10]."\n";
	echo "</select></td>
	<tr><td class=menusec2><a href=javascript:NuevoOperador()>Definir nuevo operador</a></td>
	</table>";

echo "</form>";

?>