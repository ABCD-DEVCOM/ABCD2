<?php

  require_once ("../central/config.php");
  require_once('../isisws/nusoap.php');

  session_start();
  $lang=$_SESSION["lang"];

  require_once ("../central/lang/mysite.php");
  require_once("../central/lang/lang.php");
 
 $myresult=$msgstr["failed_operation"];
 $legend="";$image="img/flag.png";
 $success = false;


//USING the Central Module
$converter_path=$cisis_path."mx";
$copyid=$_REQUEST["copyId"];
$userid=$_REQUEST["userId"];
$copytype=$_REQUEST["copytype"];
$usertype=$_REQUEST["usertype"];
$loanid=$_REQUEST["loanid"];
$cantrenewals=$_REQUEST["cantrenewals"];
$suspensions=$_REQUEST["suspensions"];
$fines=$_REQUEST["fines"];
$endDate=$_REQUEST["endatev"];

//Get the loanid
$splittxt=explode(" ",$loanid);
$loanid=$splittxt[1];
//Get the document type
$objtype="";

$fp=file($db_path."circulation/def/".$lang."/items.tab");

foreach ($fp as $value) {
$value=trim($value);
$val=explode('|',$value);
if (trim($val[1])==trim($copytype)) {
		$objtype=$val[0];							
	}
}

$copytype=$objtype;
//Get the user type
$splittxt=explode("(",$usertype);
$usertype=substr($splittxt[1],0,-1);
//Geting the loan policy
$LoanPolicy="";

$fp=file($db_path."circulation/def/".$lang."/typeofitems.tab");

foreach ($fp as $value) {

$val=explode('|',$value);

$LoanPolicy = $value;




if ((trim(strtoupper($val[0]))==trim(strtoupper($copytype))) and (trim($val[1])==trim($usertype))) {
		$LoanPolicy=$value;
						
	}
}

$splitpolicies=explode("|",$LoanPolicy);
$allowrenewals=$splitpolicies[6];
$loanterm=$splitpolicies[5];
$loanlong=$splitpolicies[3];
$date="";

if ($loanterm=='H') {
  $date=date("Ymd h:i:s"); 
} else {
  $date=date("Ymd");
} 
//If the loan is not overdue
//if ($date<$endDate) {
//Check if the user is allow to renewal
//if ($allowrenewals>0) {
//Check if the user does not exceed the renewal limit
//if ($cantrenewals<$allowrenewals) {
//Check if the user does not have suspensions
//if ($suspensions==0) {
//Check if the user does not have fines
//if ($fines==0) {
//Check if the document is reserved
//Get the database and the CN from the trans database
$mx=$converter_path." ".$db_path."trans/data/trans \"pft=v98,'+-+',v95\" from=".$loanid." count=1 now";
//echo "<h1>".$mx."</h1>";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}
$splittxt=explode("+-+",$textoutmx);
$db=$splittxt[0];
$cn=$splittxt[1];
//Cehck if the db-cn is reserve in the reserve database
$mxr=$converter_path." ".$db_path."reserve/data/reserve \"pft=if v1='0' then if v20='".$cn."' then if v15='".$db."' then mfn,'+-+', fi fi fi\" now";
exec($mxr,$outmxr,$banderamxr);
$textoutmx="";
for ($i = 0; $i < count($outmxr); $i++) {
$textoutmx.=substr($outmxr[$i], 0);
}
$splittxt=explode("+-+",$textoutmx);
//If the document is not reserved
//if ($splittxt[0]=="") {
//Do the renewal
//echo $loanterm;
$time="";$timeto="";$dateto="";
if ($loanterm=="H") {
  $date=date("Ymd");
  $time=date("h:i:s");
  $timeto=date("Ymd h:i:s",strtotime("+$loanlong hours"));
  $splittxt=explode(" ",$timeto);
  $dateto=$splittxt[0];
  $timeto=$splittxt[1];
} else {
  $dateto=date("Ymd",strtotime("+$loanlong days"));
}

$mxa=$converter_path." ".$db_path."trans/data/trans \"proc='<200>^a".$date."^b".$time."^c".$dateto."^d".$timeto."^e".$userid."<"."/200>'\" from=".$loanid." count=1 copy=".$db_path."trans/data/trans now";
//echo "<h1>".$mxa."</h1>";
exec($mxa,$outmxa,$banderamxa);
//} else {
//The document is reserved
//$legend=$msgstr["documentreserved"];
//}
//} 
//else {
//The user has fines
//$legend=$msgstr["user_fined"];
//}
//} 
//else {
//The user has suspensions
//$legend=$msgstr["user_suspended"];
//}
//}
//else {
//The user had reached the renewal limit
//$legend=$msgstr["renewallimitreached"];
//}
//} 
//else {
//The user can not renewal
//$legend=$msgstr["notallowrenewals"];
//}

//} 
//else {
//The loan is overdue
//$legend=$msgstr["loanoverdue"];
//}



if (strlen($legend)==0) $success=true;



      if ($success) {
            $myresult=$msgstr["success_operation"];
            if (strlen($legend)>0)
                $image="img/important.png";
            else
                $image="img/clean.png";

      }


      echo "<div><table><tr>";
      echo "<td width=180><img src='".$image."' /></td>";
      echo "<td><h2>".utf8_encode($myresult)."</h2></td></tr><tr><td colspan=2><h3>".utf8_encode($legend)."</h3></td>";
      echo "</tr></table></div>";


?>