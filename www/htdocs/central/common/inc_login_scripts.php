<?php
/* Modifications
2025-02-18 fho4abcd created by copy the functions from inicio.php
2025-02-18 fho4abcd formatted, return also user if validation fails
*/
if (isset($_SESSION["HOME"])) {
	$retorno = $_SESSION["HOME"];
} elseif (isset($def['LOGIN_ERROR_PAGE'])) {
	$retorno=$def['LOGIN_ERROR_PAGE'];
} else {
	if (file_exists("../../index.php")){
		$retorno="../../index.php";
	} else {
		$retorno="../../index_abcd.php";
	}
}

function LeerRegistro() {
// la variable $llave permite retornar alguna marca que esté en el formato de salida
// identificada entre $$LLAVE= .....$$
	$llave_pft="";
	global $llamada, $valortag,$maxmfn,$arrHttp,$OS,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl,$MD5,$actparfolder;
	$ic=-1;
	//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
	$tag= "";
	$IsisScript=$xWxis."login.xis";
	$pass=$arrHttp["password"];
	if (!isset($MD5) or  $MD5!=0){
		$pass=md5($pass);
	}
	if ($actparfolder=="/")$actparfolder="acces/"; // initial value can be empty
	$query = "&base=acces&cipar=$db_path".$actparfolder."acces.par&login=".$arrHttp["login"];
	include("wxis_llamar.php");
	$llave_ret="";
	foreach ($contenido as $linea){
	 	if ($ic==-1){
			$ic=1;
	 		$pos=strpos($linea, '##LLAVE=');
			if (is_integer($pos)) {
				$llave_pft=substr($linea,$pos+8);
				$ll=explode('|',$llave_pft);
				if ($ll[0]==$pass){
					$llave_ret=$llave_pft;
					$valortag=array();
				} 
			}
		}else{
			$linea=trim($linea);
			$pos=strpos($linea, " ");
			if (is_integer($pos)) {
				$tag=trim(substr($linea,0,$pos));
				//
				//El formato ALL envía un <br> al final de cada línea y hay que quitarselo
				//
				$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));
				if (!isset($valortag[$tag])) $valortag[$tag]=$linea;
			}
		}
	}
	return $llave_ret;

}
function VerificarUsuario(){
	Global $arrHttp,$valortag,$Path,$xWxis,$session_id,$Permiso,$msgstr,$db_path,$nombre,$Per;
	Global $adm_login,$adm_password,$retorno;
 	$llave=LeerRegistro();
 	if ($llave!=""){
  		$res=explode('|',$llave);
  		$userid=$res[0];

  		$_SESSION["mfn_admin"]=$res[1];
  		$mfn=$res[1];
  		$nombre=$res[2];
		$arrHttp["Mfn"]=$mfn;
  		$Permiso="|";
  		$Per="";
  		$value=$valortag[40];
  		if (isset($valortag[60]))
  			$fecha=$valortag[60];
  		else
  			$fecha="";
  		$today=date("Ymd");
  		if (trim($fecha)!=""){
  			if ($today>$fecha){
  				header("Location: ".$retorno."?login=N");
  				die;
  			}
  		}
  		//$value=substr($value,2);
  		$ix0=strpos($value,'^');
  		$ix0=$ix0+2;
  		$ix=strpos($value,'^',$ix0);
  		$Perfil=substr($value,$ix0,$ix-$ix0);
		if (!file_exists($db_path."par/profiles/".$Perfil)){
			echo "missing ". $db_path."par/profiles/".$Perfil;
			die;
		}
		$profile=file($db_path."par/profiles/".$Perfil);
		unset($_SESSION["profile"]);
		unset($_SESSION["permiso"]);
		unset($_SESSION["login"]);
		$_SESSION["profile"]=$Perfil;
		$_SESSION["login"]=$arrHttp["login"];
		foreach ($profile as $value){
			$value=trim($value);
			if ($value!=""){
				$key=explode("=",$value);
				$_SESSION["permiso"][$key[0]]=$key[1];
			}
		}
		if (isset($valortag[70])){
			$library=$valortag[70];
			$_SESSION["library"]=$library;
		}else{
			unset ($_SESSION["library"]);
		}
 	}else{
		// This is the emergency login
 		if ($arrHttp["login"]==$adm_login and $arrHttp["password"]==$adm_password){
 			$Perfil="adm";
			$nombre="!!Emergency/Emergencia!!"; // The displayed name of the emergency user
 			unset($_SESSION["profile"]);
			unset($_SESSION["permiso"]);
			unset($_SESSION["login"]);
			if (!file_exists($db_path."par/profiles/".$Perfil)){
				echo "Missing file: ". $db_path."par/profiles/".$Perfil."<br>";
				echo "The emergency user needs administrator privileges";
				die;
			}
			$profile=file($db_path."par/profiles/".$Perfil);
			$_SESSION["profile"]=$Perfil;
			$_SESSION["login"]=$arrHttp["login"];
			foreach ($profile as $value){
				$value=trim($value);
				if ($value!=""){
					$key=explode("=",$value);
					$_SESSION["permiso"][$key[0]]=$key[1];
				}
			}
		}else{
			echo "<script>\n";
			echo "self.location.href=\"".$retorno."?login=N&user=".$arrHttp["login"]."\";\n";
			echo "</script>\n";
			die;
		}
 	}
}
?>