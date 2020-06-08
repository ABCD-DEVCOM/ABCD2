<?php 
include("../config.php");
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path."mx";
$db=$_GET["db"];
$cn=$_GET["cn"];
$in=$_GET["in"];
$mfnc=$_GET["mfn"];
//Update copy status to removed
$MyNewRecord="<200>^a4^bRemoved<~200>";
$MyRecord=str_replace ("~", '/', $MyNewRecord);
$mx1=$converter_path." ".$db_path."copies/data/copies \"proc=if mfn=".$mfnc." then  'd200', '".$MyRecord."',fi,\" copy=".$db_path."copies/data/copies now -all";
exec($mx1,$outmx1,$banderamx1);
//End of Update copy status to removed


//Search for the record data in the loaobjects database 
	$Expresion="CN_".$db."_".$cn;
	$IsisScript= $xWxis."buscar_ingreso.xis";
	$Pft="v1'|',v10'|',(v959'|')/";
	$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=$Expresion&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$Mfn="";$Total="";$MyRecord="";
	foreach ($contenido as $linea){	
		if (trim($linea)!=""){
			if (substr($linea,0,6)=="[MFN:]") $Mfn=substr($linea,6);
			if (substr($linea,0,8)=="[TOTAL:]") $Total=substr($linea,8);
			if (substr($linea,0,6)!="[MFN:]" and substr($linea,0,8)!="[TOTAL:]") $MyRecord=$linea;
		}
	}
//End of Search for the record data in the loaobjects database 
//Delete the Copy from the loanobject database
if ($Total==1){
$MyNewRecord="";
$listmyrecord=explode("|",$MyRecord);
for($i=0; $i<count($listmyrecord); $i++){
if ($listmyrecord[$i]!="")	{
$listalinea=explode("^",$listmyrecord[$i]);
if ($listalinea[1]!='i'.$in) $MyNewRecord.="|".$listmyrecord[$i];
}}
$MyRecord=$MyNewRecord;
$MyNewRecord="";
$pos = strpos ($MyRecord, "^");
if ($pos === false) $MyRecord=""; else $MyRecord = substr ($MyRecord, $pos,-2);
$listmyrecord=explode("|",$MyRecord);
for($i=0; $i<count($listmyrecord); $i++) 
if ($listmyrecord[$i]!="") $MyNewRecord.="<959>".$listmyrecord[$i]."<~959>";
$MyRecord=str_replace ("~", '/', $MyNewRecord);
$mx=$converter_path." ".$db_path."loanobjects/data/loanobjects \"proc='d959', '".$MyRecord."'\" from=".$mfnc." count=1 copy=".$db_path."loanobjects/data/loanobjects now -all";
exec($mx,$outmx,$banderamx);
$mxinv=$converter_path." ".$db_path."loanobjects/data/loanobjects fst=@".$db_path."loanobjects/data/loanobjects.fst fullinv=".$db_path."loanobjects/data/loanobjects now -all";
exec($mxinv, $outputmxinv,$banderamxinv);
 }//End of if ($Total==1)
//End of Delete the Copy from the loanobject database

?>