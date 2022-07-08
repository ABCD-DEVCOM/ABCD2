<?php
/* Modifications
2021-06-14 fho4abcd Do not set/get password in/from $_SESSION 
*/

global $Permiso, $arrHttp,$valortag,$nombre,$userid,$db,$vectorAbrev;
$arrHttp=Array();
session_start();
require_once ("../../central/config.php");
require_once('../../isisws/nusoap.php');
require_once ("../../central/common/ldap.php");

$converter_path=$cisis_path."mx";
//echo "converter_path=".$converter_path."<BR>";

$page="";
if (isset($_REQUEST['GET']))
	$page = $_REQUEST['GET'];
else
	if (isset($_REQUEST['POST'])) $page = $_REQUEST['POST'];

//if (!(preg_match('^[a-z_./]*$', $page) && !preg_match("\\.\\.", $page))) {
	// Abort the script
//	die("Invalid request");
//}
$valortag = Array();


function LeerRegistro() {

// la variable $llave permite retornar alguna marca que est� en el formato de salida
// identificada entre $$LLAVE= .....$$

$llave_pft="";
$myllave ="";
global $llamada,$valortag,$maxmfn,$arrHttp,$OS,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl,$empwebservicequerylocation,$empwebserviceusersdb,$db,$EmpWeb,$MD5,$converter_path,$vectorAbrev;
if ($EmpWeb=="1") {
//USING the Emweb Module to login to MySite module
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


      $params = array('queryParam'=>array("query"=> array('login'=>$arrHttp["login"])), 'database' =>$empwebserviceusersdb);
      $result = $client->call('searchUsers', $params, 'http://kalio.net/empweb/engine/query/v1' , '');

      //print_r($result);
      //die;

      //Esto se ha complejizado con el asunto de la incorporaci�n de mas de una base de datos

      if (is_array($result['queryResult']['databaseResult']['result']['userCollection']))
      {
        $vectoruno = $result['queryResult']['databaseResult']['result']['userCollection'];

        if (is_array($vectoruno['user']))
        {
          //Hay una sola base y ah� est� el usuario
          $myuser = $vectoruno['user'];
          $db = $empwebserviceusersdb;
        }
        else if (is_array($vectoruno[0]))
        {
          // hay un vector de dbnames, hay que encontrar en cual de ellos est� el user, si est� en mas de uno
          // joderse, se toma el primero
          foreach ($vectoruno as $elementos)
          {
            if (is_array($elementos['user']))
            {
              $myuser = $elementos['user'];
              $db = $elementos['!dbname'];
            }
          }

        }

        // Con el myuser recuperado me fijo si es que el passwd coincide

        if (($myuser['password']==$arrHttp["password"]) &&  (strlen($arrHttp["password"])>3)) {
              $vectorAbrev=$myuser;
              //print_r($vectorAbrev);
              //die;
              $myllave = $vectorAbrev['id']."|";
              $myllave .= "1|";
              $myllave .= $vectorAbrev['name']."|";
              $valortag[40] = "\n";
        }


      }

} else {
	//echo "Central Loans used<BR>";  die;
	//USING the Central Module to login to MySite module
	//Get the user and pass
	
	$checkuser=$arrHttp["login"];
	if ($MD5==0) {
		$checkpass=$arrHttp["password"];
	}else{
		$checkpass=md5($arrHttp["password"]);
	}

	//Search the users database
	$mx=$converter_path." ".$db_path."users/data/users \"pft=if v600='".$checkuser."' then if v610='".$checkpass."' then v20,'|',v30,'|',v10,'|',v10^a,'|',v10^b,'|',v18,'|',v620 fi,fi\" now";

	//echo "mxcommand=$mx<BR>";
	//mxcommand=/ABCD2/www/cgi-bin_Windows/ansi/mx /ABCD2/www/bases-examples_Windows/users/data/users "pft=if v600='rosa' then if v610='rosa' then v20,'|',v30,'|',v10,'|',v10^a,'|',v10^b,'|',v18,'|',v620 fi,fi" now
	//die;

	$outmx=array();
	exec($mx,$outmx,$banderamx);
	$textoutmx="";

	for ($i = 0; $i < count($outmx); $i++) {
		$textoutmx.=substr($outmx[$i], 0); 
	} if ($textoutmx!="") {
		$splittxt=explode("|",$textoutmx);
	//	$myuser = var_dump($checkuser);
		$db = "users";
		$myllave = $splittxt[0]."|";
		$myllave .= "1|";
		$myllave .= $splittxt[1]."|";
		//echo "<h1>".$myllave."</h1>";
		$valortag[40] = $splittxt[2]."\n";
		$vectorAbrev['id']=$splittxt[0];
		$vectorAbrev['name']=$splittxt[1];
		$vectorAbrev['userClass']=$splittxt[4]."(".$splittxt[3].")";
		$vectorAbrev['expirationDate']=$splittxt[5];
		$vectorAbrev['photo']=$splittxt[6];
		$currentdatem=date("Ymd");
	} elseif (
		$currentdatem>$splittxt[5]) {
		$myllave="";
	}
}
//echo "myllave=$myllave<BR>";
	  return $myllave;

}// END LeerRegistro()

function VerificarUsuario(){
Global $arrHttp,$valortag,$Path,$xWxis,$session_id,$Permiso,$msgstr,$db_path,$nombre,$userid,$lang;
 	$llave=LeerRegistro();
//echo "llave = $llave<BR>";
 	if ($llave!=""){
  		$res=explode('|',trim($llave));
  		$userid=$res[0];
  		$_SESSION["mfn_admin"]=$res[1];
  		$mfn=$res[1];
  		$nombre=$res[2];
		$arrHttp["Mfn"]=$mfn;
  		$Permiso="|";
  		$P=explode("\n",$valortag[40]);
  		foreach ($P as $value){
  			$value=substr($value,2);
  			$ix=strpos($value,'^');
    		$Permiso.=substr($value,0,$ix)."|";
    	}		
 	}else{ 
		if ($arrHttp["id"]!="") echo "<script>
 		self.location.href=\"../indexmysite.php?id=".$arrHttp["id"]."&cdb=".$arrHttp["cdb"]."&login=N&lang=".$lang."\";
 		</script>";
		else
		echo "<script>
 		self.location.href=\"../indexmysite.php?login=N&lang=".$lang."\";
 		</script>";
  		die;
 	}
}



function ActualizarRegistro($variablesD,$opcion,$mfn){
$tabla = Array();

global $vars,$cipar,$from,$base,$ValorCapturado,$arrHttp,$ver,$valortag,$fdt,$tagisis,$cn,$msgstr,$tm,$lang_db,$MD5;
global $xtl,$xnr,$Mfn,$FdtHtml,$xWxis,$variables,$db_path,$Wxis,$default_values,$rec_validation,$wxisUrl,$validar,$tm;
global $max_cn_length;

	$variables_org=$variablesD;
	$ValorCapturado="";
	$VC="";
	
	//OJO
	$arrHttp["base"] = "users";
	$cipar = $arrHttp["base"].".par";
	
	
	
	if (isset($variablesD)){
	
		foreach ($variablesD as $key => $lin){
			$key=trim(substr($key,3));
			$k=$key;
			$ixPos=strpos($key,"_");
			if (!$ixPos===false) {
		    	$key=substr($key,0,$ixPos-1);
			}
			if (trim($key)!=""){
				if (strlen($key)==1) $key="000".$key;
				if (strlen($key)==2) $key="00".$key;
				if (strlen($key)==3) $key="0".$key;
				$lin=stripslashes($lin);
				$campo=array();
    			if ($dataentry!="xA")
						$campo=explode("\n",$lin);
					else
				$campo[]=str_replace("\n","",$lin);
				foreach($campo as $lin){
					$VC.=$k." ".$lin."\n";
					$ValorCapturado.=$key.$lin."\n";
					
				}
			}
		}
	}
	
	
	$valc=explode("\n",$ValorCapturado);
	
 	$ValorCapturado="";
 	$Eliminar="";
 	foreach ($valc as $v){
 		$v=trim($v);
		
 		if (trim(substr($v,0,4))!=""){
 		   $Eliminar.="d".substr($v,0,4);
		  
 		   if (trim(substr($v,4))!="")
				 $ValorCapturado.="<".substr($v,0,4)." 0>".substr($v,4)."</".substr($v,0,4).">";
		}
 	}
	
	$x=isset($default_values);
	$fatal_cn="";
	$fatal="";
	$error="";
	
            unset($validar);
					
			$file_val="";
			
			if ($file_val=="" or !file_exists($file_val)){
				$file_val=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".val";
				if (!file_exists($file_val))  $file_val=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".val";
			}
			
			
 	
 		$ValorCapturado=urlencode($Eliminar.$ValorCapturado);
 	
	
	
	$IsisScript=$xWxis."actualizar.xis";
	
	if (file_exists($db_path."$base/data/stw.tab"))
		$stw="&stw=".$db_path."$base/data/stw.tab";
	else
		if (file_exists($db_path."stw.tab"))
			$stw="&stw=".$db_path."stw.tab";
		else
			$stw="";
			
 
	
  	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$cipar."&login=".$arrHttp["login"]."&Mfn=" .$mfn."&Opcion=".$opcion."$stw&ValorCapturado=".$ValorCapturado;
  	

	include("../../central/common/wxis_llamar.php");
   
}

function Session($llave){
 Global $arrHttp,$valortag,$Path,$xWxis,$Permiso,$msgstr,$db_path,$nombre,$userid,$lang;
 echo "<h1>".$res[2]."</h1>";
       
        $res=split("\|",$llave);
		$mfn=$res[2];
		$userid=$res[1];
  		$_SESSION["mfn_admin"]=$res[2];
  		$mfn=$res[2];
  		$nombre=$res[3];
		$arrHttp["Mfn"]=$mfn;
  		$Permiso="|";
  		$P=explode("\n",$valortag[40]);
  		
		foreach ($P as $value){
		    
  			$value=substr($value,2);			
  			$ix=strpos($value,'^');
    		$Permiso.=substr($value,0,$ix)."|";
			
    	}
		
}

function LeerRegistroLDAP() {

// la variable $llave permite retornar alguna marca que est� en el formato de salida
// identificada entre $$LLAVE= .....$$

$llave_pft="";
$myllave ="";
global $llamada,$valortag,$maxmfn,$arrHttp,$OS,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl,$empwebservicequerylocation,$empwebserviceusersdb,$db,$EmpWeb,$MD5,$converter_path,$vectorAbrev;

$checkuser=$arrHttp["login"];

//Search the users database
$mx=$converter_path." ".$db_path."users/data/users \"pft=if v600='".$checkuser."' then mfn,'|',v20,'|',v30,'|',v10,'|',v10^a,'|',v10^b,'|',v18 fi\" now";

$outmx=array();
exec($mx,$outmx,$banderamx);
$textoutmx="";


for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}


if ($textoutmx!="")
{
$splittxt=explode("|",$textoutmx);
$myuser = $checkuser;
//OJO
$db = "users";
$myllave = $splittxt[0]."|";
$myllave .= $splittxt[1]."|";
$myllave .= "1|";
$myllave .= $splittxt[2]."|";
$valortag[40] = $splittxt[3]."\n";
$vectorAbrev['id']=$splittxt[1];
$vectorAbrev['name']=$splittxt[2];
$vectorAbrev['userClass']=$splittxt[5]."(".$splittxt[4].")";
$vectorAbrev['expirationDate']=$splittxt[6];
$currentdatem=date("Ymd");
if ($splittxt[6]!="") if ($currentdatem>$splittxt[6]) $myllave="";
}

    
	 return $myllave;

}

function VerificarUsuarioLDAP(){
    Global $arrHttp,$valortag,$Path,$xWxis,$session_id,$Permiso,$msgstr,$db_path,$nombre,$Per,$adm_login,$adm_password,$MD5,$lang,$ldap_usr_dom;
 	$variablesD = array();
	$login = false;
	$checkpass="";
	$checkpass  = ($MD5==0)? $arrHttp["password"]: md5($arrHttp["password"]);
	
	$login = false;
	try {
					if(Auth($arrHttp["login"], $arrHttp["password"],false))
					{	   
						$llave= LeerRegistroLDAP();
					   
						if($llave != ""){
									
							$variablesD["tag610"]=$checkpass;
							$mfn=explode("|",$llave);
							 
							ActualizarRegistro($variablesD,"actualizar",$mfn[0]);
							Session($llave);			
							$login = true;
							
						 }
						 else
							 {
								
                                $variablesD["tag20"]=$arrHttp["login"];									
								$variablesD["tag30"]=$arrHttp["login"];		
								$variablesD["tag160"]=$arrHttp["login"].$ldap_usr_dom;
								$variablesD["tag600"]=$arrHttp["login"];
								$variablesD["tag610"]=$checkpass;
								
								ActualizarRegistro($variablesD,"crear","New");
								Session("#|".$variablesD["tag600"]."|1|".$variablesD["tag600"]."|");								 
								$login = true;
								
							 }
					}
					else
						{
							$llave=LeerRegistro();
							if($llave != ""){
									Session($llave);
									$login = true;
								}  		   
						}
					
	 
	  } catch (Exception $e) {
         echo $e->getMessage();
		 exit;
     }
	 
	    if(!$login)
	    {
		  echo "<script>
 		  self.location.href=\"../indexmysite.php?login=N&lang=".$lang."\";
 		  </script>";
  		  die;
		}
	  
}

/////
/////   INICIO DEL PROGRAMA
/////


$query="";
include("../../central/common/get_post.php");

//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";die;


if (isset($arrHttp["lang"])){
	$_SESSION["lang"]=$arrHttp["lang"];
	$lang=$arrHttp["lang"];
}else{
	if (!isset($_SESSION["lang"]))
    $_SESSION["lang"]=$lang;
}

require_once("../../central/lang/mysite.php");
require_once("../../central/lang/lang.php");



if (isset($arrHttp["action"])) {
    if ($arrHttp["action"]!='clear')
    {
      $_SESSION["action"]=$arrHttp["action"];
      $_SESSION["recordId"]=$arrHttp["recordId"];
    }
    else
    {
      $_SESSION["action"]="";
      $_SESSION["recordId"]="";
    }
	if ($arrHttp["action"]=='gotosite')
    {
	$arrHttp["login"]=$_SESSION["login"];
	}
}





//if (!$_SESSION["userid"] || !$_SESSION["permiso"]=="mysite".$_SESSION["userid"]) {

      	if (isset($arrHttp["reinicio"])){
      		$arrHttp["login"]=$_SESSION["login"];
      		$arrHttp["startas"]=$_SESSION["permiso"];
      		$arrHttp["lang"]=$_SESSION["lang"];
            $arrHttp["db"]=$_SESSION["db"];

      	}	
		
        if($use_ldap) {		
		    VerificarUsuarioLDAP();
		} else	{ 
      	    VerificarUsuario();		
		}
      

      	$_SESSION["lang"]=$arrHttp["lang"];
		if (!empty($arrHttp["id"])) {
		$_SESSION["action"]='reserve';
		$_SESSION["recordId"]=$arrHttp["id"];
		$_SESSION["cdb"]=$arrHttp["cdb"];
		} else {
        $_SESSION["userid"]=$userid;
      	$_SESSION["login"]=$arrHttp["login"];
      	$_SESSION["permiso"]="mysite".$userid;
      	$_SESSION["nombre"]=$nombre;
        $_SESSION["db"]=$db;
		}

//}

?>


<script>
	document.cookie = "user=<?php echo $arrHttp["login"]?>; expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/";
</script>


<?php
	//print_r ($msgstr);
include("homepagemysite.php");

?>