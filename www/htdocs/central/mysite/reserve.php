<?php

  require_once ("../config.php");
  require_once('../../isisws/nusoap.php');



  /*if (isset($arrHttp["lang"])){
	$_SESSION["lang"]=$arrHttp["lang"];
	$lang=$arrHttp["lang"];
  }else{
  	if (!isset($_SESSION["lang"]))
      $_SESSION["lang"]=$lang;
  } */

 session_start();
 $lang=$_SESSION["lang"];
 require_once ("../lang/mysite.php");
 require_once("../lang/lang.php");
 
      $myresult=$msgstr["failed_operation"];
      $legend="";
      $image="mysite/img/flag.png";
      $success = false;
 
 if ($EmpWeb=="Y")
{
//USING the Emweb Module 

 if (!isset($_SESSION["permiso"])) die;

     //Invocación al web-service

      $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
      $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
      $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
      $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
      $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
      $client = new nusoap_client($empwebservicetranslocation, false,
          						$proxyhost, $proxyport, $proxyusername, $proxypassword);

      $err = $client->getError();
      if ($err) {
          	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
          	echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
          	exit();
      }

      $user = new soapval('userId','',$_REQUEST["userId"]);
      $record = new soapval('recordId','',$_REQUEST["recordId"]);
      $volume= new soapval('volumeId','',$_REQUEST["volumeId"]);
      $category = new soapval('objectCategory','',$_REQUEST["objectCategory"]);
      $userdb = new soapval('userDb','',$_REQUEST["db"]);
      $objdb = new soapval('objectDb','',$empwebserviceobjectsdb);
      $library = new soapval('objectLocation','',$_REQUEST["library"]);
      //$from = new soapval('startDate','','20090322131211');

      $param1 = array ( "name" => "operatorLocation" );
      $myparam1 = new soapval ('param','',$_REQUEST["library"],'http://kalio.net/empweb/engine/trans/v1',false,$param1);

      $param1 = array ( "name" => "operatorId" );
      $myparam2 = new soapval ('param','','mysite',false,false,$param1);

      //$param1 = array ( "name" => "acceptEndDate" );
      //$myparam3 = new soapval ('param','','20090323131211',false,false,$param1);

      $myparams = new soapval ('params','',array($myparam1,$myparam2));
      $myextension = new soapval ('transactionExtras','',$myparams,'','');


      $params = array ($user,$record,$volume,$category,$userdb,$objdb,$library,$from,$myextension);

      //print_r($params);
      // Acá obtengo los datos generales
      $result = $client->call('waitSingle', $params, 'http://kalio.net/empweb/engine/trans/v1' , '');

      //echo "Databse". $_REQUEST["db"];
      //print_r($result);


      //print_r($result);

      for ($i=0;$i<sizeof($result['transactionResult']['processResult']);$i++)
      {
        if (sizeof($result['transactionResult']['processResult'][$i]['msg'])>0)
        {
           //Aca hay que internacionalizar
           //print_r($result['transactionResult']['processResult'][$i]['msg']['text'][1]);
           $intermedio = $result['transactionResult']['processResult'][$i]['msg']['text'];
           if (is_array($intermedio))
           {
             $auxi="";
             foreach ($intermedio as $mensaje)
             {
               if ($mensaje["!lang"]==$lang)
                 $legend=$mensaje["!"];
               else if ($mensaje["!lang"]=="en")
                 $auxi=$mensaje["!"];
             }

             if (strlen($legend)==0)
                $legend=$auxi;
           }
           else
            $legend=$intermedio;
        }


        if (sizeof($result['transactionResult']['processResult'][$i]['result'])>0)
        {
          //print_r($result['transactionResult']['processResult'][$i]['result']);
          //Aca esta el resultado definitivo de la transaccion
          $success=true;

        }
      }




      $resultbuff=serialize($result);
      include_once("legends.php");

}
else
{
//USING the Central Module
$converter_path=$cisis_path."mx";
$user = $_REQUEST["userId"];
$copy = $_REQUEST["recordId"];
$copytype = $_REQUEST["objectCategory"];  
$usertype = $_REQUEST["usertype"];
$mydatabase=$_REQUEST["database"];

//Get the document type
$objtype="";
$fp=file($db_path."circulation/def/".$lang."/items.tab");
foreach ($fp as $value)
{
$value=trim($value);
$val=explode('|',$value);
if (trim($val[1])==trim($copytype))
	{
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
foreach ($fp as $value)
{
$val=explode('|',$value);
if ((trim(strtoupper($val[0]))==trim(strtoupper($copytype))) and (trim($val[1])==trim($usertype)))
	{
		$LoanPolicy=$value;							
	}
}
$splitpolicies=explode("|",$LoanPolicy);
$allowreserve=$splitpolicies[11];
$loanterm=$splitpolicies[5];
$loanlong=$splitpolicies[3];
$date="";
if ($loanterm=='H') $date=date("Ymd h:i:s"); else $date=date("Ymd");
if ($allowreserve=="Y") 
{
//Check for user suspensions
$mxs=$converter_path." ".$db_path."suspml/data/suspml \"pft=if v20='".$user."' then if v1='S' then if v10='0' then mfn, fi fi fi\" now";
exec($mxs,$outmxs,$banderamxs);
$textoutmx="";
for ($i = 0; $i < count($outmxs); $i++) {
$textoutmx.=substr($outmxs[$i], 0);
}
if ($textoutmx=='')
{
//Check for user fines
$mxm=$converter_path." ".$db_path."suspml/data/suspml \"pft=if v20='".$user."' then if v1='M' then if v10='0' then mfn, fi fi fi\" now";
exec($mxm,$outmxm,$banderamxm);
$textoutmxm="";
for ($i = 0; $i < count($outmxm); $i++) {
$textoutmxm.=substr($outmxm[$i], 0);
}
if ($textoutmxm=='')
{
//Check for the document been reserved
$mxrv=$converter_path." ".$db_path."reserve/data/reserve \"pft=if v15='".$mydatabase."' then if v20='".$copy."' then if v1='0' then mfn, fi fi fi\" now";
exec($mxrv,$outmxrv,$banderamxrv);
$textoutmxrv="";
for ($i = 0; $i < count($outmxrv); $i++) {
$textoutmxrv.=substr($outmxrv[$i], 0);
}
if ($textoutmxrv=='')
{
//Check for loansoverdues
$outmxl=array();
if ($loanterm=='H')
{
//Take the date and time of return
//Search the trans database
$mxl=$converter_path." ".$db_path."trans/data/trans \"pft=if v20='".$user."' then if v1='P' then v40,' ',v45'+~+', fi fi\" now";
exec($mxl,$outmxl,$banderamxl);
}
else
{
//Take the date of return
$mxl=$converter_path." ".$db_path."trans/data/trans \"pft=if v20='".$user."' then if v1='P' then v40,'+~+', fi fi\" now";
exec($mxl,$outmxl,$banderamxl);
}
$textoutmx="";
for ($i = 0; $i < count($outmxl); $i++) {
$textoutmx.=substr($outmxl[$i], 0);
}
$loansflag=0;
$splittxt=explode("+~+",$textoutmx);
foreach($splittxt as $onedate)
{
if ($onedate!='') if ($date>$onedate) $loansflag=1;
}
if ($loansflag==0)
{
$date=date("Ymd");
$time=date("h:i:s");
//Place the reserve
$mxa=$converter_path." null \"proc='<1>0</1><10>".$user."</10><12>".$usertype."</12><15>".$mydatabase."</15><20>".$copy."</20><30>".$date."</30><31>".$time."</31>'\" append=".$db_path."reserve/data/reserve count=1 now";
exec($mxa,$outmxa,$banderamxa);

}
else
{
//The loan is overdue
$legend=$msgstr["loanoverduer"];
}
}
else
{
//The document is reserved
$legend=$msgstr["documentreservedr"];
}
}
else
{
//The user has fines
$legend=$msgstr["user_fined"];
}
}
else
{
//The user has suspensions
$legend=$msgstr["user_suspended"];
}
}
else
{
//The user can not reserve
$legend=$msgstr["notallowreserve"];
} 
	  
 
	     
if (strlen($legend)==0) $success=true;
}


      if ($success)
      {
            $myresult=$msgstr["success_operation"];
            if (strlen($legend)>0)
                $image="mysite/img/important.png";
            else
                $image="mysite/img/clean.png";

      }


      echo "<div><table><tr>";
      echo "<td width=180><img src='".$image."' /></td>";
      echo "<td><h2>".utf8_encode($myresult)."</h2></td></tr><tr><td colspan=2><h3>".utf8_encode($legend)."</h3></td>";
      echo "</tr></table></div>";

      //echo $client->request;




      //print_r ($result);

?>