<?php
$copies="";
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf";
$msg_err="";
if (!file_exists($archivo)){
	 $msg_err= " ".$msgstr["barcode_conf"]." (".$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf".")";
}else{
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value=="") continue;
		if ($value=="" or substr($value,1,2)=='//') continue;
		$v=explode('=',$value,2);
		$v[1]=trim($v[1]);
		if ($v[1]!=""){
			switch ($v[0]){
				case "classification_number_pref":
					$classification_number_pref=$v[1];
					break;
				case "classification_number_format":
					$classification_number_format=$v[1];
					break;
				case "control_number_pref":
					$control_number_pref=$v[1];
					break;
				case "control_number_format":
					$control_number_format=$v[1];
					break;
				case "inventory_number_pref":
					$inventory_number_pref=$v[1];
					break;
				case "inventory_number_format":
					$inventory_number_format=$v[1];
					break;
				case "inventory_number_display":
					$inventory_number_display=$v[1];
					break;
				case "barcode_format":
					$barcode_format=$v[1];
					break;
				case "copies":
					$copies=$v[1];
			}
		}
	}
	if (isset($copies) and $copies=="Y"){
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
}
?>
