<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["conf_level"])) unset($_REQUEST["conf_level"]);
include ("tope_config.php");

$wiki_help="OPAC-ABCD_Detalles_de_la_configuraci%C3%B3n#Men.C3.BA_de_configuraci.C3.B3n";

?>

<script>
	function EnviarCopia(){
		if (document.copiar_a.lang_to.options[document.copiar_a.lang_to.selectedIndex].value=="<?php echo $lang?>"){
			alert("<?php echo $msgstr["sel_o_l"]?>")
			return false
		}
		if (document.copiar_a.replace_a[0].checked || document.copiar_a.replace_a[1].checked ){
			document.copiar_a.submit()
		}else{
			alert("<?php echo $msgstr["missing"]." ".$msgstr["sustituir_archivos"];?>")
			return false
		}
	}
</script>
<?php
if (!isset($_REQUEST["db_path"])){
	$_REQUEST["db_path"]=$db_path;
	$_REQUEST["db_path_desc"]="$db_path";
}
if (isset($_REQUEST["db_path"])) {
	$_SESSION["db_path"]=$_REQUEST["db_path"];
	$_SESSION["db_path_desc"]=$_REQUEST["db_path"];
}
if (isset($lang)) $_SESSION["lang"]=$lang;


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; die;

function LeerRegistro() {
// la variable $llave permite retornar alguna marca que esté en el formato de salida
// identificada entre $$LLAVE= .....$$

$llave_pft="";
global $llamada, $valortag,$maxmfn,$OS,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl,$MD5,$ABCD_path,$CentralPath;
    $ic=-1;
	$tag= "";
	$IsisScript=$xWxis."login.xis";
	$pass=$_REQUEST["password"];
	if (isset($MD5) and $MD5==1){
		$pass=md5($pass);
	}
	$query = "&base=acces&cipar=$db_path"."par/acces.par"."&login=".$_REQUEST["login"]."&password=".$pass;
	include("../../common/wxis_llamar.php");
	 foreach ($contenido as $linea){
	 	if ($ic==-1){
	    	$ic=1;
	    	$pos=strpos($linea, '##LLAVE=');
	    	if (is_integer($pos)) {
	     		$llave_pft=substr($linea,$pos+8);
	     		$pos=strpos($llave_pft, '##');
	     		$llave_pft=substr($llave_pft,0,$pos);
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
	return $llave_pft;

}

function VerificarUsuario(){
Global $valortag,$Path,$xWxis,$session_id,$Permiso,$msgstr,$db_path,$nombre,$Per,$adm_login,$adm_password;
 	$llave=LeerRegistro();
 	if ($llave!=""){
  		$res=explode('|',$llave);
  		$userid=$res[0];
  		$_SESSION["mfn_admin"]=$res[1];
  		$mfn=$res[1];
  		$nombre=$res[2];
		$_REQUEST["Mfn"]=$mfn;
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
  				session_destroy();
  				header("Location: index.php");
  				die;
  			}
  		}
  		$ix0=strpos($value,'^');
  		$ix0=$ix0+2;
  		$ix=strpos($value,'^',$ix0);
  		$Perfil=substr($value,$ix0,$ix-$ix0);
    	if (!file_exists($db_path."par/profiles/".$Perfil)){
    		echo "missing ". $db_path."par/profiles/".$Perfil;
    		session_destroy();
    		die;
    	}
    	$profile=file($db_path."par/profiles/".$Perfil);
    	unset($_SESSION["profile"]);
    	unset($_SESSION["permiso"]);
    	unset($_SESSION["login"]);
    	$_SESSION["profile"]=$Perfil;
    	$_SESSION["login"]=$_REQUEST["login"];
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
 		if ($_REQUEST["login"]==$adm_login and $_REQUEST["password"]==$adm_password){
 			$Perfil="adm";
 			unset($_SESSION["profile"]);
    		unset($_SESSION["permiso"]);
    		unset($_SESSION["login"]);
 			$profile=file($db_path."par/profiles/".$Perfil);
    		$_SESSION["profile"]=$Perfil;
    		$_SESSION["login"]=$_REQUEST["login"];
    		foreach ($profile as $value){
    			$value=trim($value);

    			if ($value!=""){
    				$key=explode("=",$value);
    				$_SESSION["permiso"][$key[0]]=$key[1];

    			}
    		}
    	}else{

  			session_destroy();
  			?>
  			<form name=error method=post action=index.php>
				<input type=hidden name=invaliduser value="Invalid login">
			</form>
 			<script>
 				document.error.submit()
 			</script>;
            <?php
  			die;
  		}
 	}
}


/////////////////////////////////////////////////////////////////////

	if (isset($_REQUEST["login"])){
		VerificarUsuario();
		$_SESSION["lang"]=$lang;
		$_SESSION["login"]=$_REQUEST["login"];
		$_SESSION["password"]=$_REQUEST["password"];
		$_SESSION["nombre"]=$nombre;

	}
	if (!isset($_SESSION["permiso"])){
		session_destroy();
		//$msg=$msgstr["invalidright"]." ".$msgstr[$_REQUEST["startas"]];
		echo "
		<html>
		<body>
		<form name=err_msg action=index.php method=post>
		<input type=hidden name=error value=\"$msg\">
		";
		echo "
		</form>
		<script>
			document.error.submit()
		</script>
		</body>
		</html>
		";
    	session_destroy();
    	die;
    }
	$Permiso=$_SESSION["permiso"];

	include "../../common/inc_div-helper.php";
?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">

			<?php include("menu_bar.php");?>
	</div>
	<div class="formContent col-9 m-2">
	</div>
</div> 
<?php include ("../../common/footer.php"); ?>

<form name=forma1 method=post>
<?php if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}?>
<input type="hidden" name="base">
<input type="hidden" name="lang" value="<?php echo $lang;?>">
<input type="hidden" name="db_path" value="<?php echo $_REQUEST["db_path"]?>">
</form>