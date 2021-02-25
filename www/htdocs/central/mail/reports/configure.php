<?php
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf";
$msg_err="";
if (!file_exists($archivo)){
	 $msg_err= " ".$msgstr["barcode_conf"]." (".$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf".")";
}else{
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value=="" or substr($value,1,2)=='//') continue;
		$v=explode('=',$value);
		if (trim($v[1])!=""){
			switch ($v[0]){
				case "pref_classification_number":
					$pref_classification=$v[1];
					break;
				case "format_classification_number":
					$fe_classification=$v[1];
					break;
				case "base_classification_number":
					$base_classificacion=$v[1];
				case "pref_control_number":
					$pref_control=$v[1];
					break;
				case "format_control_number":
					$fe_control=$v[1];
					break;
				case "base_control_number":
					$base_control=$v[1];
				case "pref_inventory_number":
					$pref_inventory=$v[1];
					break;
				case "format_inventory_number":
					$fe_inventory=$v[1];
					break;
				case "base_inventory_number":
					$base_inventory=$v[1];
				case "copies":
					$copies=$v[1];
			}
		}
	}
	if ($copies=="Y"){
		if (!isset($base_inventory)) $base_inventory="copies";
		if (!isset($fe_inventory))   $fe_inventory="if size(v30)<6 then `0`v30 else v30 fi`$$$`if size(v30)<6 then `0`v30 else v30 fi";
		if (!isset($pref_inventory)) $pref_inventory="INS_";
		if (!isset($base_control))   $base_control=$base_inventory;
		if (!isset($fe_control))     $fe_control="replace(f(val(v1),7,0),` `,`0`)`$$$`replace(f(val(v1),7,0),` `,`0`)";
		if (!isset($pref_control))   $pref_control="CNS_".strtoupper($arrHttp["base"]."_");
		if (!isset($base_date))      $base_date=$base_inventory;
		if (!isset($fe_date))        $fe_date="v85";
		if (!isset($pref_date))      $pref_date="FE_";
	}
	$base_classification=$arrHttp["base"];
}
?>
