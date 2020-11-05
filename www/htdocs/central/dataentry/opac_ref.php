<html>

<head>
  <title></title>
</head>

<body>

<?php

$db_path="/bases_abcd/bef/";
function WxisLLamar($db_path,$query){    $err_wxis="";
	$wxisUrl="http://localhost:9090/cgi-bin/wxis.exe";	$xWxis="/abcd/www/htdocs/central/dataentry/wxis/";
	$IsisScript=$xWxis."buscar.xis";
	$query.="&path_db=".$db_path;
	if (!isset($IsisScript)) $IsisScript="";
	$url="IsisScript=$IsisScript$query&cttype=s";
	if (file_exists($db_path."par/syspar.par"))
       	$url.="&syspar=$db_path"."par/syspar.par";
	parse_str($url, $arr_url);
	$postdata = http_build_query($arr_url);
	$opts = array('http' =>
    			array(
       					'method'  => 'POST',
       					'header'  => 'Content-type: application/x-www-form-urlencoded',
       					'content' => $postdata
        	     )
				);
	$context = stream_context_create($opts);
	$result=file_get_contents($wxisUrl,false, $context);
    $con=explode("\n",$result);
    $ix=0;
    $contenido=array();
    foreach ($con as $value) {
      	if (substr($value,0,4)=="WXIS"){
      		$err_wxis.=$value."<br>";
       	}
       	$contenido[]=$value;
    }
    if ($err_wxis!="") echo "<font color=red size=+1>$err_wxis</font>";
	return $contenido;}
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";


$db_path=$_REQUEST["db_path"];
$query = "&cipar=".$_REQUEST["db_path"]."/par/".$_REQUEST["cipar"]. "&Expresion=".$_REQUEST["Expresion"]."&Opcion=buscar&base=".$_REQUEST["base"]."&Formato=".$_REQUEST["Formato"]."&prologo=NNN&count=90000";
$registro="";
$contenido=WxisLLamar($db_path,$query);
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
if (file_exists("$db_path".$_REQUEST["base"]."/pfts/es/"."ref_head.tab")){
	$fp=file("$db_path".$_REQUEST["base"]."/pfts/es/"."ref_head.tab");
	foreach($fp as $value) echo "$value";}else{	echo "Falta definir el encabezado de la tabla en ref_head.tab";
}

echo $registro;
echo "</table>";
?>

</body>

</html>