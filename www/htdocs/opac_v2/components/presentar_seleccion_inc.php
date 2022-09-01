<?php
/**************** Modifications ****************
2022-03-23 rogercgui change the folder /par to the variable $actparfolder
***********************************************/

$desde=1;
$count="";
$accion="";
$list=explode('|',$_REQUEST["cookie"]);
$contador=0;
$Total_No=0;
$items_por_reservar="";
foreach ($list as $value){
	$value=trim($value);
	if ($value!="")	{
		$x=explode('_',$value);
		$seleccion[$x[1]][$x[2]]=$x[2];
        if (!isset($xml_base[$x[1]])){
        	$xml_base[$x[1]]="c_".$x[1]."_".$x[2];
        } else {
        	$xml_base[$x[1]].="|c_".$x[1]."_".$x[2];
        }
	}
}
foreach ($seleccion as $base=>$value){
	echo '<div class="card card-body mb-2"> <h3>';
	if (file_exists($db_path.$base."/pfts/dcxml.pft") or file_exists($db_path.$base."/pfts/marcxml.pft")){
		echo "<a class='bt' href=javascript:SendToXML(\"".$xml_base[$base]."\")>XML</a>&nbsp; &nbsp;";
	}
	echo $bd_list[$base]["descripcion"]." ($base)</h3></div>";
	$lista_mfn="";
	/*foreach ($value as $mfn){
		if ($lista_mfn=="")
			$lista_mfn="'$mfn'";
		else
			$lista_mfn.="/,'$mfn'";
	}*/
	foreach ($value as $mfn){
		echo '<div class="card card-body mb-2">';
		$lista_mfn="'$mfn'";
		$contador=$contador+1;
 		$salida=PresentarRegistros($base,$db_path,$lista_mfn);
 		//var_dump($salida);
		//Se determinan las reservas que ya tiene el título
		$msg_rsvr=$salida[1];
		$no_control=$salida[2];
		$items_por_reservar.="c_".$base."_".$no_control.'|';
		if ($msg_rsvr=='NO') {
			$Total_No=$Total_No+1;
			$_REQUEST["cookie"]=str_replace($item,'',$_REQUEST["cookie"]);
		}
    	if ($msg_rsvr!="NO" and isset($WEBRESERVATION) and $WEBRESERVATION=="Y"){
			$ract=DeterminarReservasActivas($db_path,$x[1],$lang,$msgstr,$mfn);
			$nreserv=0;
			foreach ($ract as $xx) {
				$xx=trim($xx);
				if ($xx!=""){
					if (substr($xx,0,8)=="[TOTAL:]") continue;
					$nreserv=$nreserv+1;
				}
			}
			if ($nreserv>0){
				echo "<br><font color=blue><strong>Este titulo tiene $nreserv reserva(s) pendiente(s)</strong></font><br>";
			}
		}

		echo $salida[0];
		echo '</div>';
	}
}

echo "<form method=post name=forma1 action=buscar_integrada.php onSubmit=\"Javascript:return false\">\n";
	$ix=0;
	if (isset($_REQUEST["Pft"]) and trim($_REQUEST["Pft"])!=""){
		$Formato=$_REQUEST["Pft"];
	} else {
		$Formato="opac_print";
	}
echo "<input type=hidden name=existencias>\n";
echo "</form> ";

echo "<form name=regresar action=buscar_integrada.php method=post>";
foreach ($_REQUEST as $key=>$value){
	echo "<input type=hidden name=$key value=\"$value\">\n";
}
echo "</form>";
echo "<script>\n";
echo "items_por_reservar=\"".$items_por_reservar."\"\n";
echo "</script>\n";
?>
