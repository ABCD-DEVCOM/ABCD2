<?php
$SITENAME='http://www.askapache.com';
 
$CODES = array(array('100','101','102'),
array('200','201','202','203','204','205','206','207'),
array('300','301','302','303','304','305','306','307'),
array('400','401','402','403','404','405','406','407','408','409','410','411','412','413',
'414','415','416','417','418','419','420','421','422','423','424','425','426'),
array('500','501','502','503','504','505','506','507','508','509','510'));
 
$TMPSAVETO='/temp/'.time().'.txt';
 
# if file exists then delete it
if(is_file($TMPSAVETO))unlink($TMPSAVETO);
 
foreach($CODES as $keyd => $res)
{
foreach($res as $key)
{
$ch = curl_init("$SITENAME/e/$key");
$fp = fopen ($TMPSAVETO, "a");
curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION ,1);
curl_setopt ($ch, CURLOPT_HEADER ,1);
curl_exec ($ch);
curl_close ($ch);
fclose ($fp);
}
}
$OUT='';
ob_start();
header ("Content-Type: text/plain;");
readfile($TMPSAVETO);
$OUT=ob_get_clean();
echo $OUT;
unlink($TMPSAVETO);
exit;
?>