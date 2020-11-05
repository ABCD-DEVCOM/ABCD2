<?php
Function ABCD_Ref($linea,$registro){
global $db_path,$lang_db,$xWxis;
echo "$linea<br>";	$ref=substr($linea,6);
	$f=explode(",",$ref);
	$bd_ref=trim($f[0]);
	$pft_ref=trim($f[1]);
	$a=$db_path.$bd_ref."/pfts/".$_SESSION["lang"]."/".$pft_ref;
	if (!file_exists($a)){
		$a=$db_path.$bd_ref."/pfts/".$lang_db."/".$pft_ref;
  	}
	$pft_ref=$a;
	echo $a;
	$expr_ref=trim($f[2]);
	$ixp=strpos($expr_ref,'_');
	if ($ixp>0){
		$pref_rel=trim(substr($expr_ref,0,$ixp+1));
		$expr_ref=trim(substr($expr_ref,$ixp+1));
		$b_rel=explode('$$',$expr_ref);
		$expr_ref="";
		foreach ($b_rel as $xx){
			$xxy=$pref_rel.$xx;
			if ($expr_ref==""){
				$expr_ref=$xxy;
			}else{
				$expr_ref.=' or '.$xxy;
			}
		}
	}
	$reverse="";
	if (isset($f[3]))
		$reverse="ON";
	$IsisScript=$xWxis."buscar.xis";
	$query = "&cipar=$db_path"."par/".$bd_ref. ".par&Expresion=".$expr_ref."&Opcion=buscar&base=".$bd_ref."&Formato=$pft_ref&prologo=NNN&count=90000";
 	if ($reverse!=""){
		$query.="&reverse=On";
	}
	$debug_x=1;
	include("../common/wxis_llamar.php");
	$ixcuenta=0;
	foreach($contenido as $linea_alt) {
		if (trim($linea_alt)!=""){
			$ll=explode('|^',$linea_alt);
			if (isset($ll[1])){
				$ixcuenta=$ixcuenta+1;
				$SS[trim($ll[1])."-$ixcuenta"]=$ll[0];
			}else{
				$registro.= "$linea_alt\n";
			}
		}
	}
	if (isset($SS) and count($SS)>0){
		ksort($SS);
		foreach ($SS as $linea_alt)
			$registro.= "$linea_alt\n";
	}
    return ($registro);
}
?>