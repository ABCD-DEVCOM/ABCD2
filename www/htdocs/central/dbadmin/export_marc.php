<html>

<head>
  <title></title>
</head>

<body>
<?php
session_start();
include ("../config.php");
// se lee el archivo dbn.fdt
$base="marc";
$archivo="$db_path$base/def/".$_SESSION["lang"]."/$base.fdt";
$fp= file($archivo);
$fdt=array();
foreach ($fp as $value){	$v=explode('|',$value);
    if ($v[0]=="F" or $v[0]=="M5" or $v[0]=="T" or $v[0]=="M")
		$fdt[$v[1]]=$v[1];}
$Pft=fopen("$db_path$base/pfts/".$_SESSION["lang"]."/export_"."$base.pft","w");
$formato="'<XMP>',e1:=0,e2:=0,\n";
$vars="";
foreach ($fdt as $key=>$value){
	$p="e1:=e1+nocc(v$key), e2:=e2+size(v$key),\n";
	$formato.=$p."\n";
    $vars.="(|=".str_pad($key, 3, '0', STR_PAD_LEFT)." |v$key/)\n";}
$formato.="'Directorio: 'f(e1,1,0)'  Longitud de los campos: 'f(e2,1,0)/";
$formato.="'=LDR 'replace(f(e1*4+e2,5,0),' ','0')" ;
$formato.='" "N3005,v3005," "N3006,v3006," "N3007,v3007," "N3008,v3008," "N3009,v3009," "N3010,v3010," "N3011,v3011," "N3012,v3012," "N3013,v3013," "N3014,v3014," "N3015,v3015," "N3016,v3016," "N3017,v3017\'**\''."\n";
$formato.=$vars;
echo "<xmp>".$formato."</xmp>";
fwrite($Pft,$formato."'</XMP>'");
fclose($Pft);
?>

</body>

</html>