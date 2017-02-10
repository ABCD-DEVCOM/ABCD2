<?php

function LeerArchivosConfiguracion($Base){
//
//Lectura de la configuración de los archivos del usuario
//
//Prefijo para localizar el número de inventario y el número de clasificación

	$uskey="";
	$archivo=$db_path.$base."/def/loans_uskey.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$value=trim($value);
    		if ($value!="")$uskey=$value;
		}
	}
//Formato para extraer el código del usuario
	$pft_uskey="@".$db_path.$base."/def/loans_uskey.pft";
//Formato para extraer el tipo de usuario
	$pft_ustype="@".$db_path.$base."/def/loans_ustype.pft";
//Formato para extraer la vigencia del usuario
	$pft_usvig="@".$db_path.$base."/def/loans_usvig.pft";
//Formato para desplegar la información del usuario
	$pft_usdisp="@".$db_path.$base."/def/loans_usdisp.pft";

//
// Parámetros requeridos para configurar la base de datos con los objetos de préstamo
//
	$archivo=$db_path.$base."/def/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){

			$ix=strpos($value," ");
			$tag=trim(substr($value,0,$ix));
			switch($tag){
				case "IN": $prefix_in=substr($value,$ix);
					break;
				case "NC": $prefix_nc=substr($value,$ix);
			}
		}
	}
    $pft_totalitems="@".$db_path.$base."/def/loans_totalitems.pft";  //Total items
	$pft_in="@".$db_path.$base."/def/loans_inventorynumber.pft";     //Número de inventario
	$pft_nc="@".$db_path.$base."/def/loans_cn.pft";                 //Número de clasificación
	$pft_dispobj="@".$db_path.$base."/def/loans_display.pft";        //Visualizar el registro
	$pft_storobj="@".$db_path.$base."/def/loans_store.pft";          //almacenar el registro
	$pft_loandisp="@".$db_path.$base."/def/loans_show.pft";         //Mostrar el registro desde préstamos
	$pft_typeofr="@".$db_path.$base."/def/loans_typeofobject.pft";  //Obtener el tipo de objeto
}
?>