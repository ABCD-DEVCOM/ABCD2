<?php

//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["letra"])) $_REQUEST["letra"]=urldecode($_REQUEST["letra"]);
//echo ($_REQUEST["letra"]);
function BuscarClavesLargas($Termino,$base){

global $Formato,$xWxis,$Wxis,$db_path,$Prefijo,$last,$terminos,$postings,$bd_list;
return;
	$T=explode('$#$',$Termino);
	$Termino_busqueda=$T[0];
	$letra=str_replace($Prefijo,"",$Termino_busqueda);
	$IsisScript=$xWxis."opac/alfabetico.xis";
	$Opcion=$_REQUEST["Opcion"];
	if (isset($_REQUEST["cipar"])){		$cipar=$_REQUEST["cipar"];
	}else{
		$cipar=$base;	}
	$query = "&base=".$base ."&cipar=$db_path"."par/".$cipar.".par"."&Opcion=$Opcion&prefijo=$Prefijo"."&letra=".$letra."&posting=ALL&to=$Prefijo$letra";

	$contenido="";
	$contenido=wxisLLamar($base,$query,$IsisScript);
	$cuenta=0;
	//echo "<p>Buscar Claves Largas $Termino<p>";
	$cuenta=0;
	foreach ($contenido as $t ){		//echo "$t<br>";
		if (substr($t,0,7)=='$$Last=') {
			continue;
		}
		$cuenta=$cuenta+1;		$t=trim($t);
		$ter=explode('$$$',$t);
        $pos=explode('||',$ter[0]);
		$key=str_replace('$#$','',$ter[1]);
		//$key=trim($key);
        $cant=0;
		if (isset($pos[1]))
			$cant=$pos[1];
		if (!isset($terminos[$key])){
			$terminos[$key]=$t;
			$postings[$key]=$cant;
		}else{
			if (strlen($key)<60)
				$postings[$key]=$postings[$key]+$cant;
		}
		if (strlen($key)>60) return;
	}
	//echo "<strong>=====</strong><br>";
}
// FIN BUSCAR CLAVES LARGAS //




	if (isset($_REQUEST["diccio"])) {
	    $base=$_REQUEST["diccio"];
	}else{
	}
$ixbases=-1;
$mayorclave="";
$primerTermino="";
$nlin=-1;
if (!isset($_REQUEST["letra"])) $_REQUEST["letra"]="";
$lastkey=array();
$firstkey=array();
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
$cuenta=0;
$postings=array();
$keys_rec=array();
$last="";
if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){	foreach ($bd_list as $base=>$value){		if (!isset($_REQUEST["modo"]) or $_REQUEST["modo"]!="integrado"){
			if ($_REQUEST["base"]!="")
				if ($base!=$_REQUEST["base"]) continue;		}
//		echo "<h1>$base</h1>";    	$IsisScript=$xWxis."opac/alfabetico.xis";
		$Opcion=$_REQUEST["Opcion"];
    	$letra=$_REQUEST["letra"];
   		if (isset($_REQUEST["cipar"]) and $_REQUEST["cipar"]!=""){
			$cipar=$_REQUEST["cipar"];
		}else{
			$cipar=$base;
		}
		$letra=urlencode(substr($letra,0,50));

		$query = "&base=".$base ."&cipar=$db_path"."par/".$cipar.".par"."&Opcion=$Opcion&prefijo=$Prefijo"."&letra=$letra"."&posting=".$_REQUEST["posting"];
		$query.="&count=200";
		$contenido=wxisLLamar($base,$query,$IsisScript);

		$j=-1;
		$ultimo="";
		$primero="";
		$cuenta=0;
		foreach ($contenido as $t){			if (substr($t,0,6)=='$$Last') continue;
			$cuenta=$cuenta+1;
//            echo "$cuenta - $t<br>";
			$tx=explode('|$$$|',$t);
			if (!isset($tx[1])) $tx[1]=$tx[0];
			if (substr($tx[1],0,strlen($_REQUEST["prefijo"]))!=$_REQUEST["prefijo"]) {
	            break;
			}else{
				//echo $t."<br>";
				if (!isset($firstkey[$base])) $firstkey[$base]=$tx[1];
				$lastkey[$base]=$tx[1];
			}
		}
		//echo "<h4>$cuenta</h4>";
	}
	//echo "<xmp>";print_r($firstkey);echo "</xmp>";echo "<xmp>";print_r($lastkey);echo "</xmp>";
	$first="";
	$last="";
	foreach ($firstkey as $key=>$value){		if ($first==""){
			$first=$value;
		}else{			if ($value<$first) $first=$value;		}	}
	foreach ($lastkey as $key=>$value){
	//if ( $value<$first) continue;
		if ($last==""){
			$last=$value;
		}else{
			if ($value<$last) $last=$value;
		}
	}
//	echo "<xmp>";print_r($first);echo "</xmp>";echo "<xmp>";print_r($last);echo "</xmp>";
	$letra=substr($first,0,strlen($_REQUEST["prefijo"]));
}

$keys_rec=array();

foreach ($bd_list as $base=>$value){
	if ((!isset($_REQUEST["modo"]) or $_REQUEST["modo"]!="integrado")){
		if ($_REQUEST["base"]!="")
			if ($base!=$_REQUEST["base"]) continue;
	}
   	$IsisScript=$xWxis."opac/alfabetico.xis";
	$Opcion=$_REQUEST["Opcion"];
	if (isset($_REQUEST["cipar"]) and $_REQUEST["cipar"]!=""){
		$cipar=$_REQUEST["cipar"];
	}else{
		$cipar=$base;
	}
	$letra=substr($_REQUEST["letra"],0,50);
	$query = "&base=".$base ."&cipar=$db_path"."par/".$cipar.".par"."&Opcion=$Opcion&prefijo=$Prefijo"."&letra=$letra"."&posting=".$_REQUEST["posting"];
	if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado")
		//$query.="&to=$last";
		$query.="&count=200";
	else
		$query.="&count=200";
	$resultado=wxisLLamar($base,$query,$IsisScript);
	$cuenta=0;
	foreach ($resultado as $t){		//echo $t."<br>";
		if (trim($t)=="") continue;
         $cuenta=$cuenta+1;
		if (substr($t,0,7)=='$$Last=') {
			continue;

		}else{
			$tx=explode('|$$|',$t);
			if (isset($tx[1])){
				$key=explode('$$$',$tx[1]);
				if (substr($key[1],0,strlen($_REQUEST["prefijo"]))!=$_REQUEST["prefijo"]) {					continue;				}
				//echo"**". $tx[1]."<br>";
				if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){					if (isset($key[1]) and $last==""){						$keys_rec[$key[1]]=$t;					}else{
						if (isset($key[1]) and $key[1]<$last and $last!="") {							echo "-----entro-----";
							$keys_rec[$key[1]]=$t;						}
					}
				}else{					   $keys_rec[$key[1]]=$t;				}
			}
		}
	}
	//echo "<h1>$cuenta</h1>";
}

ksort($keys_rec);
$terminos=$keys_rec;
//foreach ($terminos as $key) echo "$key<br>";die;
