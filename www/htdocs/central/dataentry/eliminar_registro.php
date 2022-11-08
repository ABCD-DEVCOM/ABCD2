<?php
/*
20220715 fho4abcd Use $actparfolder as location for .par files + repair undefined variable + return errors to browse
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
require_once("../config.php");
$lang=$_SESSION["lang"];

require_once ("../lang/admin.php");
if (file_exists("../lang/msgusr.php"))
	require_once ("../lang/msgusr.php");

include ("verificar_eliminacion.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
//die;
//SE VERIFICA SI HAY FORMATO DE VALIDACION DE LA ELIMINACION
$archivo=$db_path.$arrHttp["base"]."/pfts/recdel_val";

$verify="";
if (file_exists($archivo.".pft")){
	$verify="Y";
}else{
    $archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/recdel_val";
    if (file_exists($archivo.".pft")){
		$verify="Y";
	}else{
		$archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/recdel_val";
       	if (file_exists($archivo.".pft")){
			$verify="Y";
		}
	}
}
$err_del="";
$res="";
if ($verify=="Y") $res=VerificarEliminacion($archivo);
if ($res==""){
	$query = "&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&Opcion=eliminar";
	$IsisScript=$xWxis."eliminarregistro.xis";
	include("../common/wxis_llamar.php");
    if ($err_wxis!="") $err_del="&error=".urlencode($_SERVER['PHP_SELF']." :<br><br>".$err_wxis);
}else{	$err_del="&error=".urlencode($res);;}
$encabezado="";
if (isset($arrHttp["encabezado"]))
	$encabezado="?encabezado=s";
else
	$encabezado="?" ;
if ($arrHttp["base"]=="users") $retorno="loans";
if ($arrHttp["base"]=="acces") $retorno="usersadm";
if (isset($arrHttp["retorno"])){
	if (isset($arrHttp["Expresion"])) $arrHttp["retorno"].="&Expresion=".$arrHttp["Expresion"];
	if (isset($arrHttp["from"])) $arrHttp["retorno"].="&from=".$arrHttp["from"].$err_del;
	header("Location:".$arrHttp["retorno"]);
	die;
}else{
	$retorno="../dataentry/browse.php";
	header("Location:$retorno$encabezado"."&base=".$arrHttp["base"]."&return="."&from=".$arrHttp["from"].$err_del);
}


?>