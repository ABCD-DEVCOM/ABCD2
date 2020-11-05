<?php
header('Content-Type: text/html; charset=utf-8');


function decode_code($code)
{
    return preg_replace_callback('@\\\(x)?([0-9a-f]{2,3})@',
        function ($m) {
            if ($m[1]) {
                $hex = substr($m[2], 0, 2);
                $unhex = chr(hexdec($hex));
                if (strlen($m[2]) > 2) {
                    $unhex .= substr($m[2], 2);
                }
                return $unhex;
            } else {
                return chr(octdec($m[2]));
            }
        }, $code);
}

$fp=file("/bases/alfabeto_utf8.tab");
//echo "<table>";
$alfabeto=array();
$comp="";

foreach($fp as $value){	if (substr($value,0,1)=='#')continue;
	$value=trim($value);
	if ($value!=""){
		$c=explode('#',$value);
        if (strpos($c[1],'->')>0){
        	$charset="LATIN";
        }else{        	$cc=explode(" ",trim($c[1]));
        	$charset=$cc[0];        }
        if ($charset!=$comp){        	$comp=$charset;        }
		$chd=explode('=',$c[0]);
		$low=explode(' ',trim($chd[1]));
		$cn="";
		for ($i=0;$i<count($low);$i++){			$cn=$cn."\x".dechex($low[$i]);		}
		if (trim($c[1])!=""){
			//echo "<tr><td>";
			//echo $c[1]//."</td><td>";
			$char=decode_code($cn);
			if (!isset($alfabeto[$comp][$char]))
				$alfabeto[$comp][$char]=$char;
		}
	}}
foreach ($alfabeto as $charset=>$value) {	echo "<h1>$charset</h1>";
	$file_al=fopen("/bases/indice_alfa_utf8_".$charset.".tab","w");
	foreach($value as $letra){		if (trim($letra)!=""){			echo "$letra &nbsp; ";
		  	fwrite($file_al,$letra."\n");
		}
	}
	fclose($file_al);}
?>
