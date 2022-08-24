<?php
foreach ($_REQUEST as $var=>$value){
		if (stripos($value,"script")!==false){
			$value=str_replace(' ','',$value);
			if (stripos($value,"<script>")!==false ){
				unset($_REQUEST[$var]);
				die;
			}
			if (stripos($value,'--!>')!==false) die;
		}
	}
?>