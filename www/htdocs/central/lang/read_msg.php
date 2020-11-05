<?php
if (isset($msg_path) and $msg_path!="")
	$path=$msg_path;
else
	$path=$db_path;
$a=$path."lang/".$_SESSION["lang"]."/$msg_tab";
//if (!file_exists($a)){//	 echo $a. " no existe";
//	 die;
//}
if (file_exists($a)) {
	$fp=file($a);
	foreach($fp as $var=>$value){
		if (trim($value)!="") {			$value=str_replace('"','&#34;',$value);
			$value=str_replace("'",'&#39;',$value);
			//echo $charset;
			if ($charset=="UTF-8" and strpos($_SESSION["lang"],"_utf8")===false )
				$value=utf8_encode($value);
			$m=explode('=',$value,2);
			$m[0]=trim($m[0]);
			if (!isset($msgstr[$m[0]]))$msgstr[$m[0]]=trim($m[1]);
		}
	}
}

$a=$path."/lang/00/$msg_tab";
if (file_exists($a)) {
	$fp=file($a);
	foreach($fp as $var=>$value){
		if (trim($value)!="") {
			if ($charset=="UTF-8" and strpos($_SESSION["lang"],"_utf8")===false)
				$value=utf8_encode($value);			$value=str_replace('"','&#34;',$value);
			$value=str_replace("'",'&#39;',$value);
			$m=explode('=',$value,2);
			$m[0]=trim($m[0]);
			if (!isset($msgstr[$m[0]])) $msgstr[$m[0]]=trim($m[1]);
		}
	}
}
?>