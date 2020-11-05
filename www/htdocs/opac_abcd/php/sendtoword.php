<?php
$mostrar_menu="N";
include("config_opac.php");
//header('Content-Type: text/html; charset=".$charset."');
//foreach ($_REQUEST as $key=>$value) echo "$key=$value<br>";//DIE;
include("leer_bases.php");

$desde=1;
$count="";
function wxisLlamar($base,$query,$IsisScript){
	global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}
if (isset($_REQUEST["sendto"]) and trim($_REQUEST["sendto"])!="")
	$_REQUEST["cookie"]=$_REQUEST["sendto"] ;
$list=explode("|",$_REQUEST["cookie"]);
$seleccion=array();
$primeravez="S";



$filename="abcdOpac_word.doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".rand().".doc");
header("Pragma: no-cache");
header("Expires: 0");
//header("Content-Type: application/vnd.ms-word; charset=utf-8");
//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//header("content-disposition: attachment;filename=$filename");
$ix=0;
$contador=0;
$control_entrada=0;
foreach ($list as $value){
	$value=trim($value);
	if ($value!="")	{
		$x=explode('_',$value);
		$seleccion[$x[1]][]=$x[2];
	}
}

	echo "<html>";
  	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$charset\">";
  	echo "<body>";
foreach ($seleccion as $base=>$value){
	echo "<hr style=\"border: 5px solid #cccccc;border-radius: 5px;\">";
	echo "<h3>".$bd_list[$base]["descripcion"]." ($base)</h3><br><br>";
	$lista_mfn="";
	foreach ($value as $mfn){		if ($lista_mfn=="")
			$lista_mfn="'$mfn'";
		else
			$lista_mfn.="/,'$mfn'";
	}
	$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$base."_formatos.dat";
    $fp=file($archivo);
    $primeravez="S";
    foreach ($fp as $ff){
    	$ff=trim($ff);
    	if ($ff!=""){
    		$ff_arr=explode('|',$ff);
    		if (isset($ff_arr[2]) and $ff_arr[2]=="Y"){
    			$fconsolidado=$ff_arr[0];
    			break;
    		}else{
    			if ($primeravez=="S"){
    				$primeravez="N";
    				$fconsolidado=$ff_arr[0];
    			}
    		}
    	}
    }
	$query = "&base=".$base."&cipar=$db_path"."par/$base".".par&Mfn=$lista_mfn&Formato=@$fconsolidado.pft&lang=".$_REQUEST["lang"];
	$resultado=wxisLlamar($base,$query,$xWxis."opac/imprime_sel.xis");

	foreach($resultado as $salida)  {		$salida=trim($salida);
		if (substr($salida,0,8)=="[TOTAL:]") continue;
		echo $salida;	}
	echo "<br><br>";

}
	echo "</body>";
	echo "</html>" ;

?>


