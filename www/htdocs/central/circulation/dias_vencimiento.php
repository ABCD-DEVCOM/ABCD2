<?php
function DiasVencimiento($dev){
global $feriados,$locales,$notrabaja,$config_date_format;
	$d=0;
    $df=0;
    $diaFeriado="F";
    $dia_sem="F";
    $today=date("Ymd");
    $total_days=0;
    // se determinan los días feriados
    $ii=0;
    while ($dev<$today){

    	$ii=$ii+1;
    	if ($ii>5000) {
    		echo "check script fecha_devolucion.php";
    		die;
    	}
    	$total_days=$total_days+1;
    	$dev_date=strtotime($dev."+1 days");
    	$fdev=date("Y-m-d",$dev_date);
    	$f=explode('-',$fdev);
     	$dev=date("Ymd",$dev_date);
    	$mes=$f[1];
    	$dia=$f[2];
    	if (isset($feriados[$mes*1]) and substr($feriados[$mes*1],$dia-1,1)=="F"){
    		$diaFeriado="F";
    		$df=$df+1;
    		$dia_sem="";
    	}else{
    		$diaFeriado="";
    		// se determina cuáles dias no trabaja la biblioteca
    		$dia_sem=date("w",$dev_date);
    		if (!isset($locales[$dia_sem]["from"])) {
    			$df=$df+1;
    			$dia_sem="F";
    		}else{
    		}
    	}
    }
    $lapso=$total_days-$df;
	return $lapso;

}


?>
