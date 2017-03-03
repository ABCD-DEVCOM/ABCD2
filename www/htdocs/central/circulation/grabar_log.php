<?php
function GrabarLog($movimiento,$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,$accion=""){
	if (file_exists($db_path."logtrans/data/logtrans.mst")){		$IsisScript=$xWxis."actualizar.xis";
		$ValorCapturado="<1 0>$movimiento</1>";
		$ValorCapturado.="<20 0>".date("Y/m/d")."</20>";
		$ValorCapturado.="<30 0>".date("h:i:s")."</30>";
		$ValorCapturado.="<40 0>".$_SESSION["login"]."</40>";
		if (isset($datos_trans["BD"]))
			$ValorCapturado.="<10 0>".$datos_trans["BD"]."</10>";
		if (isset($datos_trans["NUM_CONTROL"]))
			$ValorCapturado.= "<100 0>".$datos_trans["NUM_CONTROL"]."</100>";
		if (isset($datos_trans["NUM_INVENTARIO"]))
			$ValorCapturado.= "<110 0>".$datos_trans["NUM_INVENTARIO"]."</110>";
		if (isset($datos_trans["TIPO_OBJETO"]))
			$ValorCapturado.= "<120 0>".$datos_trans["TIPO_OBJETO"]."</120>";
		if (isset($datos_trans["CODIGO_USUARIO"]))
			$ValorCapturado.= "<200 0>".$datos_trans["CODIGO_USUARIO"]."</200>";
		if (isset($datos_trans["TIPO_USUARIO"]))
			$ValorCapturado.= "<210 0>".$datos_trans["TIPO_USUARIO"]."</210>";
		if (isset($datos_trans["FECHA_DEVOLUCION"]))
			$ValorCapturado.= "<300 0>".$datos_trans["FECHA_PROGRAMADA"]."</300>";
		if (isset($datos_trans["ATRASO"]))
			$ValorCapturado.= "<310 0>".$datos_trans["ATRASO"]."</310>";
		if (isset($datos_trans["DIAS_SUSPENSION"]))
			$ValorCapturado.= "<320 0>".$datos_trans["DIAS_SUSPENSION"]."</320>";
		if (isset($datos_trans["U_MULTA"]))
			$ValorCapturado.= "<330 0>".$datos_trans["U_MULTA"]."</330>";
		if (isset($datos_trans["MONTO_MULTA"]))
			$ValorCapturado.= "<340 0>".$datos_trans["MONTO_MULTA"]."</340>";
		$ValorCapturado=urlencode($ValorCapturado);
		if ($accion=="RETORNAR"){
			return $ValorCapturado;
		}else{
			//echo $ValorCapturado;die;
			$query="&Mfn=New&Opcion=crear&base=logtrans&cipar=$db_path"."par/logtrans.par&login=".$_SESSION["login"]."&ValorCapturado=$ValorCapturado";
			include("../common/wxis_llamar.php");
		}
			//foreach ($contenido as $value) echo "$value<br>";die;
   }else{   		return "";   }

}
?>
