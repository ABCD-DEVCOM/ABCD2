<?php
$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tesaurus.rel");
$term_tag="";
$refer_tag="";
$term_prefix="";
foreach ($fp as $value){
	$value=trim($value);

	if ($value!=""){		//echo "$value<br>";
		if (substr($value,0,6)=="PREFIX"){
			$term_prefix=trim(substr($value,6));
			continue;
		}
		if (substr($value,0,4)=="TERM"){
			$term_tag=trim(substr($value,4));
			continue;
		}
		if (substr($value,0,3)=="REF"){
			$refer_tag=trim(substr($value,3));
			continue;
		}
		$value=preg_replace('/\s\s+/',' ',$value);
		$v=explode(" ",$value);
		$rels[$v[1]]["name"]=$v[0];
		$rels[$v[1]]["tag"]=$v[1];
		$rels[$v[1]]["rel_name"]=$v[3];
		$rels[$v[1]]["rel_tag"]=$v[2];
		$rels[$v[2]]["name"]=$v[3];
		$rels[$v[2]]["tag"]=$v[2];
		$rels[$v[2]]["rel_name"]=$v[0];
		$rels[$v[2]]["rel_tag"]=$v[1];
	}
}


?>
