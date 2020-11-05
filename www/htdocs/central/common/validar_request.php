<?php
foreach ($_REQUEST as $var=>$value){	if (stripos($value,"script")!==false){
		$value=str_replace(' ','',$value);
		if (stripos($value,"<script>")!==false  ){
			unset($_REQUEST[$var]);
			die;
		}
	}
	if (stripos($value,">")!==false and $var!="ValorCapturado" and $var!="pftedit") die;
	/*if ($var=="base"){		$fp=file("../data/bases.dat");
		$encontrado="N";
		foreach ($fp as $x){			if (stripos($x,$value.'|')!==false){				$encontrado="S";			}		}
		if ($encontrado=="N") die;	} */
}
?>