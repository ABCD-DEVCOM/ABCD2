<?php

function ReProcesarPrestamo($usuario,$inventario,$signatura,$item,$usrtype,$copies,$ppres,$prefix_in,$prefix_cn,$mfn_reserva,$codusuario_reserva,$tr,$user_data) {
global $db_path,$Wxis,$wxisUrl,$xWxis,$pr_loan,$pft_storobj,$recibo_arr,$recibo_list,$arrHttp,$actparfolder,$login,$politica;
	$item_data=explode('||',$item);
	$nc=$item_data[0];                  // Control number of the object
	$bib_db=$item_data[1];
	$arrHttp["db"]=$bib_db;
	$item="$pft_storobj";
	// Read the bibliographic database that contains the object using the control mumber extracted from the copy
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	if ($copies=="Y"){
		$Expresion="CN_".$nc;
	}else{
		//SE LEE EL PREFIJO A UTILIZAR PARA LOCALIZAR EL OBJETO A TRAVÉS DE SU NÚMERO DE INVENTARIO
		$Expresion=$prefix_cn.$nc;
	}
    $bib_db=strtolower($bib_db);
	$query = "&Opcion=disponibilidad&base=".$bib_db."&cipar=".$db_path.$actparfolder.$bib_db.".par&Expresion=".$Expresion."&Pft=".urlencode($item);
	include("../common/wxis_llamar.php");
	$obj="";
	foreach ($contenido as $value){
		$value=trim($value);
		if (trim($value)!="")
			$obj.=$value;
	}
	$objeto=explode('$$',$obj);
	$obj=explode('|',$ppres);
	$fp=date("Ymd h:i A");
	// DEVOLUTION DATE

	if ($tr<=0){
		if (trim($obj[4])=="") $obj[4]=2 ;
		$fd=FechaDevolucion($obj[4],$obj[5],"");    //lapso reserva
	}else{
		if (isset($arrHttp["date"])){
			$fd=$arrHttp["date"].date(" h:i A");;
		}else{
			if (isset($arrHttp["lpn"])){
				$fd=FechaDevolucion($arrHttp["lpn"],$obj[5],"");
			}else{
				if ($obj[5]=="F")  // la fecha de devolución fijada en la política
					$fd=$obj[16]." 24:00";
				else
					$fd=FechaDevolucion($obj[3],$obj[5],"");    //lapso normal
	       }
	    }
	}
	$ix=strpos($fp," ");
	$diap=trim(substr($fp,0,$ix));
	$horap=trim(substr($fp,$ix));
	$ix=strpos($fd," ");

	$diad=trim(substr($fd,0,$ix));
	$horad=trim(substr($fd,$ix));
    if (isset($obj[16]) and $obj[16]!=""){
    	if ($diad>$obj[16])
    		$diad=$obj[16];
    }
	$ValorCapturado="<1 0>P</1>";
	$ValorCapturado.="<10 0>".trim($inventario)."</10>";	// INVENTORY NUMBER
	if (isset($item_data[6])) $ValorCapturado.="<12 0>".$item_data[6]."</12>";         	// VOLUME
	if (isset($item_data[7])) $ValorCapturado.="<15 0>".$item_data[7]."</15>";          // TOME
	if (isset($arrHttp["year"]))    $ValorCapturado.="<17 0>".$arrHttp["year"]."</17>";       // AÑO REVISTA
	if (isset($arrHttp["volumen"])) $ValorCapturado.="<18 0>".$arrHttp["volumen"]."</18>";    // VOLUMEN REVISTA
	if (isset($arrHttp["numero"]))  $ValorCapturado.="<19 0>".$arrHttp["numero"]."</19>";     // NUMERO REVISTA
	$ValorCapturado.="<20 0>".$usuario."</20>";
	$ValorCapturado.="<30 0>".$diap."</30>";
	//if ($obj[5]=="H")
	$ValorCapturado.="<35 0>".$horap."</35>";
	$ValorCapturado.="<40 0>".$diad."</40>";
	if ($obj[5]=="H") {
		$ValorCapturado.="<45 0>".$horad."</45>";
	}else{
		$ValorCapturado.="<45 0></45>";
	}
	$ValorCapturado.="<70 0>".$usrtype."</70>";
	if (isset($arrHttp["using_pol"])){
		$pp=explode('|',$arrHttp["using_pol"]);
		$item_data[5]=$pp[0];
	}
	$ValorCapturado.="<80 0>".$item_data[5]."</80>";

	foreach ($politica as $obj_fine){
		foreach ($obj_fine as $value){
			$o=explode('|',$value);
			if (strtoupper($o[1])==strtoupper($usrtype) and  $item_data[5]==
			strtoupper($o[0])) $ValorCapturado.="<85 0>".$value."</85>";
			//$ValorCapturado.="<85 0>".$o[7]."</85>";
		}
}

	
	$ValorCapturado.="<95 0>".$item_data[0]."</95>";                   // Control number of the object
	$ValorCapturado.="<98 0>".$item_data[1]."</98>";             			// Database name
	if ( $signatura!="") $ValorCapturado.="<90 0>".$signatura."</90>";
	$ValorCapturado.="<100 0>".$objeto[0]."</100>";
	if (isset($_SESSION["library"])) $ValorCapturado.="<150 0>".$_SESSION["library"]."</150>";
	$ValorCapturado.="<400 0>".$ppres."</400>";
	if (isset($item_data[8]))  // Información complementaria del item
		$ValorCapturado.="<410 0>".$item_data["8"]."</410>";
	if (trim($user_data)!="")
		$ValorCapturado.="<420 0>".$user_data."</420>"; //informacion complementaria del usuario
	$ValorCapturado.="<120 0>^a".$login."^b".date("Ymd h:i A")."^tP</120>";
	if (isset($arrHttp["comments"]))
		$ValorCapturado.="<300 0>".$arrHttp["comments"]."</300>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."crear_registro.xis";
	$Formato="";
	$recibo="";
	if (isset($recibo_list["pr_loan"])){
		if (file_exists($db_path."trans/pfts/".$_SESSION['lang']."/r_loan.pft")){
			$Formato=$db_path."trans/pfts/".$_SESSION['lang']."/r_loan";
		}else{
			if (file_exists($db_path."trans/pfts/".$_SESSION['lang']."/r_loan.pft")){
				$Formato=$db_path."trans/pfts/".$_SESSION['lang']."/r_loan";
			}
		}
	}
	if ($Formato!="") {
		$Formato="&Formato=$Formato";
		$Pft="mfn/";
	}
	$query = "&base=trans&cipar=$db_path".$actparfolder."trans.par&login=".$login."$Formato&ValorCapturado=".$ValorCapturado;



	//Se graba el log de prestamos
	if (file_exists($db_path."logtrans/data/logtrans.mst")){

		$datos_trans["BD"]=$item_data[1];
		$datos_trans["NUM_CONTROL"]=$item_data[0];
		$datos_trans["NUM_INVENTARIO"]=trim($inventario);
		$datos_trans["TIPO_OBJETO"]=$item_data[5];
		$datos_trans["CODIGO_USUARIO"]=$usuario;
		$datos_trans["TIPO_USUARIO"]=$usrtype;
		$datos_trans["FECHA_PROGRAMADA"]=$diad;
		$ValorCapturado=GrabarLog("A",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
        if ($ValorCapturado!="") {
			$query.="&logtrans=".$ValorCapturado;
		}
		
	}

	if ($codusuario_reserva!="" and $codusuario_reserva==$usuario){
		$res=ActualizarReserva($diap,$horap);
	    $query.=$res."&Mfn_reserva=$mfn_reserva";
	    if (file_exists($db_path."logtrans/data/logtrans.mst")){   //LOG DE TRANSACCIONES CON RESERVA ATENDIDA
			$datos_trans["BD"]=$item_data[1];
			$datos_trans["NUM_CONTROL"]=$item_data[0];
			$datos_trans["NUM_INVENTARIO"]=trim($inventario);
			$datos_trans["TIPO_OBJETO"]=$item_data[5];
			$datos_trans["CODIGO_USUARIO"]=$usuario;
			$datos_trans["TIPO_USUARIO"]=$usrtype;
			$ValorCapturado=GrabarLog("F",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"",$login);
			if ($ValorCapturado!="") $query.="&logtrans_1=".$ValorCapturado;
		}

	}
	include("../common/wxis_llamar.php");
	//foreach ($contenido as $value)  echo "$value<br>"; die;

    $recibo="";
	if ($Formato!="") {
		foreach ($contenido as $r){
			$recibo.=trim($r);
		}
		$recibo_arr[]=$recibo;
		//ImprimirRecibo($recibo);
	}
	$fechas=array($diad,$horad);
	return $fechas;
}