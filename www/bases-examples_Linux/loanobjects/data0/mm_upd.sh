mx /var/opt/ABCD/bases/loanobjects/data/loanobjects "proc=if mfn=1 then  'd959', '<959>^i11123^lMC^bAGR^oLO</959>''<959>^i22245^lMC^bMED^oLO</959>',fi,\" copy=loanobjects now -all

$MyRecord=$MyNewRecord;
$MyNewRecord="";
$pos = strpos ($MyRecord, "^");
if ($pos === false) $MyRecord=""; else $MyRecord = substr ($MyRecord, $pos,-2);
$listmyrecord=explode("|",$MyRecord);
for($i=0; $i<count($listmyrecord); $i++)
if ($listmyrecord[$i]!="") $MyNewRecord.="<959>".$listmyrecord[$i]."<~959>";
$MyRecord=str_replace ("~", '/', $MyNewRecord);
$mx=$converter_path." ".$db_path."loanobjects/data/loanobjects \"proc=if mfn=".$Mfn." then  'd959', '".$MyRecord."',fi,\" copy=".$db_path."loanobjects/data/loanobjects now -all";
//echo "<br>mx=".$mx;
//die;
exec($mx,$outmx,$banderamx);