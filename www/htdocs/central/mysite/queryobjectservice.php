<?php

require_once('../../isisws/nusoap.php');
require_once ("../config.php");

if ($EmpWeb=="Y")
{
//USING the Emweb Module 
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
$client = new nusoap_client($empwebservicequerylocation, false,
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	exit();
}


$params = array('queryParam'=>array("query"=> array('recordId'=>$_REQUEST["id"])), 'database' =>$empwebserviceobjectsdb);
$result = $client->call('searchObjects', $params, 'http://kalio.net/empweb/engine/query/v1' , '');
$objeto = $result[queryResult][databaseResult][result][modsCollection][mods];
echo utf8_encode($objeto["titleInfo"]["title"].$objeto["name"][0]["namePart"]);
}
else
{
//USING the Central Module
$converter_path=$cisis_path."mx";
$splittxt=explode(" ",$_REQUEST["id"]);
$base=$splittxt[0];
$recordid=$splittxt[1];
$result="";
if ($base=="trans")
{
$mx=$converter_path." ".$db_path."trans/data/trans \"pft=if mfn=".$recordid." then v100^a, fi \" now";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}
$result=$textoutmx;
}
if ($base=="reserve")
{
//Get the CN
$mx=$converter_path." ".$db_path."reserve/data/reserve \"pft=if mfn=".$recordid." then v15,'|',v20, fi \" now";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}
$splittxt=explode("|",$textoutmx);
$database=$splittxt[0];
$cn=$splittxt[1];

//CN
$CnTag="";
$fp=file($db_path.$database."/data/".$database.".fst");
$fieldstags="";$PftQuery="";$flagt=0;
foreach ($fp as $value)
{
$value=trim($value);
$b4=strlen($value);
$cadmod=str_replace("CN_","",$value);
$aftr=strlen($cadmod);
if($b4>$aftr)
{
$val=explode(' ',$value);
$pos=strpos($fieldstags,$val[0]);
if ($pos === false) 
{
$posp=strpos($val[2],'^');
if ($posp === false) $fieldstags.=$val[0].'|';
else
{
$flagt=1;
$ptxt=explode('^',$val[2]);
$posv=strpos(strtolower($ptxt[0]),'v');
$abuscar=substr(strtolower($ptxt[0]),$posv);
$abuscar.='^'.$ptxt[1][0];
$posbuc=strpos($fieldstags,$abuscar);
if ($posbuc === false) $fieldstags.=$abuscar.'|';
}}}}

$CNtags=explode('|',$fieldstags);
foreach ($CNtags as $onecn)
{
if ($onecn!='') 
if ($flagt==1) $PftQuery.=$onecn.",'|',"; else $PftQuery.='v'.$onecn.",'|',";
}
if ($flagt==1) $PftQuery=substr($PftQuery,0,-4);
$cntxt=explode(",'|',",$PftQuery);
$CnTag=$cntxt[0];
//Title
$fieldstags="";$PftQuery="";$flagt=0;
foreach ($fp as $value)
{
$value=trim($value);
$b4=strlen($value);
$cadmod=str_replace("TI_","",$value);
$aftr=strlen($cadmod);
if($b4>$aftr)
{
$val=explode(' ',$value);
$pos=strpos($fieldstags,$val[0]);
if ($pos === false) 
{
$posp=strpos($val[2],'^');
if ($posp === false) $fieldstags.=$val[0].'|';
else
{
$flagt=1;
$ptxt=explode('^',$val[2]);
$posv=strpos(strtolower($ptxt[0]),'v');
$abuscar=substr(strtolower($ptxt[0]),$posv);
$abuscar.='^'.$ptxt[1][0];
$posbuc=strpos($fieldstags,$abuscar);
if ($posbuc === false) $fieldstags.=$abuscar.'|';
}}}}

$Titstags=explode('|',$fieldstags);
foreach ($Titstags as $tit)
{
if ($tit!='') 
if ($flagt==1) $PftQuery.=$tit.",'|',"; else $PftQuery.='v'.$tit.",'|',";
}
if ($flagt==1) $PftQuery=substr($PftQuery,0,-4);
$mxti=$converter_path." ".$db_path.$database."/data/".$database." \"pft=if ".$CnTag."='".$cn."' then ".$PftQuery." fi\" now";
exec($mxti,$outmxti,$banderamxti);
$textoutmx="";
for ($i = 0; $i < count($outmxti); $i++) {
$textoutmx.=substr($outmxti[$i], 0);
}
$splittxttit=explode("|",$textoutmx);
foreach ($splittxttit as $onetit)
{
if ($onetit!='') $result.=$onetit." ";
}
}
echo utf8_encode($result);
}



?>