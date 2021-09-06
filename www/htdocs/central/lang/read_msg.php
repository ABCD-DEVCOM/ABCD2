<?php
/* Modifications
20210430 fho4abcd Encode only the value, not the key (used by the code)
20210430 fho4abcd Encode to UTF-8 only for UTF-8 and if the value is not UTF-8
20210430 fho4abcd Optimize flow: coding activities only if the key is not present in $msgstr
20210521 fho4abcd Language 00 located in central/lang
*/
/*
Function:
    Read a message file into associative array $msgstr
    Requires $msg_tab for the message file name
    Requires $msg_path, $db_path, $_SESSION["lang"] to select the file location
    Requires $charset for ISO-8859-1/UTF-8 selection
Usage: include "read_msg.php"
Fileformat: lines with <key>=<message>
*/
/* Comments on coding issues
- Strings may contain " and ' characters.
  When present " confuses current javascript encoding. ' is not tested extensively but can fail
  Conversion into html codes &#34;/&quot; and &#39;/&apos; can solve this
  Effect on display: shows these strings in html:OK, in javascript alerts:NOTOK
  In order to be safe: Conversion applied. Replacement is UTF-8 safe

- A html page (or frame if used) can contain only 1 character encoding.
  == developer conflict: The database can be in code X and the language files in code Y

- ISO   language files can be used for ISO databases
- UTF-8 language files can be used for UTF-8 databases.
- ISO   language files can be converted to UTF-8 for working with UTF-8 databases
  The reverse is practically impossible

- ABCD has currently no option to enforce a language encoding driven by database encoding

- Files do not have an indicator of their encoding (and may use mixed encodings).
  A user indicator (like a filename with suffix "utf8") is not (yet) trusted in this code release
*/
if (isset($msg_path) and $msg_path!="")
	$path=$msg_path;
else
	$path=$db_path;

// Process the language specific file
$a=$path."lang/".$_SESSION["lang"]."/$msg_tab";
if (file_exists($a)) {
	$fp=file($a);
	foreach($fp as $var=>$value){
        if (trim($value)!="") {
            $m=explode('=',$value,2);
            $key=trim($m[0]);
            if (!isset($msgstr[$key]) and isset($m[1]) and trim($m[1]!="")) {
                $value=$m[1];
                $value=str_replace('"','&quot;',$value);
                $value=str_replace("'",'&apos;',$value);
                if ($charset=="UTF-8") {
                    if (!mb_check_encoding($value,'UTF-8')) {
                        $value=mb_convert_encoding($value,'UTF-8','ISO-8859-1');
                    }
                }
                $msgstr[$key]=trim($value);
            }
        }
	}
}
// Process the fallback file (language 00)
// Fullpath is used to get correct error message if missing
$a=dirname(__FILE__)."/00/$msg_tab";
if (file_exists($a)) {
	$fp=file($a);
	foreach($fp as $var=>$value){
		if (trim($value)!="") {
			$m=explode('=',$value,2);
			$key=trim($m[0]);
            if (!isset($msgstr[$key]) and isset($m[1]) and trim($m[1]!="")) {
                $value=$m[1];
                $value=str_replace('"','&quot;',$value);
                $value=str_replace("'",'&apos;',$value);
                if ($charset=="UTF-8") {
                    if (!mb_check_encoding($value,'UTF-8')) {
                        $value=mb_convert_encoding($value,'UTF-8','ISO-8859-1');
                    }
                }
                $msgstr[$key]=trim($value);
            }
		}
	}
} else {
    // issue an error message. This is in the top area, maybe before any other output
    $langerrormessage="<body><div><font color=red>";
    $langerrormessage.="Fallback language table <b>$a</b> not present";
    $langerrormessage.="</font></div>";
    echo $langerrormessage;
}
    
?>