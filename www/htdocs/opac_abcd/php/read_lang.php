<?php
if (isset($msg_path) and $msg_path!="")	$path=$msg_path;else	$path=$db_path;$a=$path."lang/00/opac.tab";
iF (!isset($msgstr["menu_1"])) $msgstr["menu_1"]="LogOut";
iF (!isset($msgstr["menu_2"])) $msgstr["menu_2"]="General";
if (file_exists($a)) {	$fp=file($a);	foreach($fp as $var=>$value){		if (trim($value)!="") {			$value=str_replace('"',"'",$value);
			//$value=str_replace("'","'",$value);			$m=explode('=',$value,2);			$m[0]=trim($m[0]);			if (!isset($msgstr[$m[0]])) $msgstr[$m[0]]=trim($m[1]);		}	}}
$a=$path."/lang/".$_REQUEST["lang"]."/opac.tab";
if (file_exists($a)) {	$fp=file($a);	foreach($fp as $var=>$value){		if (trim($value)!="") {			$value=str_replace('"',"'",$value);			//$value=str_replace("'","'",$value);			$m=explode('=',$value,2);			$m[0]=trim($m[0]);
			if ($charset=="UTF-8")
            	$m[1]=utf8_encode($m[1]);			$msgstr[$m[0]]=trim($m[1]);		}	}}
?>