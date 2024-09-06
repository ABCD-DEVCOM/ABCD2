<?php 
/**************** Modifications ****************

2022-03-23 rogercgui change the folder /par to the variable $actparfolder


***********************************************/

include("../../central/config_opac.php");

$mostrar_libre="N";
include("../head.php");


//foreach ($_REQUEST as $var=>$value)  echo "$var=$value<br>";

$fp=file($db_path."/opac_conf/correo.ini");

foreach ($fp as $key=>$value){
	$value=trim($value);
	if ($value!=""){
		$x=explode('=',$value);
		$ini[$x[0]]=$x[1];
	}
}
$Expresion="";
$icuenta=0;
$desde=0;
//$acc=explode("|",$_REQUEST["seleccion"]);
//$accion=$acc[0];
$enviados=0;
$list=explode('|',$_REQUEST["cookie"]);
$contador=0;
$ix=0;
$Total_No=0;
$items_por_reservar="";
foreach ($list as $value){
	$value=trim($value);
	if ($value!="")	{
		$x=explode('_=',$value);
		$seleccion[$x[1]][]=$x[2];
	}
}
$mensaje="";

foreach ($seleccion as $base=>$value){
	$archivo=$db_path.$base."/opac/".$_REQUEST["lang"]."/".$base."_formatos.dat";
    $fp=file($archivo);
    $primeravez="S";
    foreach ($fp as $ff){
    	$ff=trim($ff);
    	if ($ff!=""){
    		$ff_arr=explode('|',$ff);
    		if (isset($ff_arr[2]) and $ff_arr[2]=="Y"){
    			$fconsolidado=$ff_arr[0];
    			break;
    		}else{
    			if ($primeravez=="S"){
    				$primeravez="N";
    				$fconsolidado=$ff_arr[0];
    			}
    		}
    	}
    }
	$fconsolidado=str_replace(".pft","",$fconsolidado);
	$Pft="@".$fconsolidado.".pft,'<hr>'";
    foreach ($value as $mfn_X){
		$Mfn="'$mfn_X'";
		$contador=$contador+1;
		$query = "&base=".$base."&cipar=".$db_path.$actparfolder."/".$base.".par&Mfn=".$Mfn."&Formato=".$Pft."&Opcion=buscar&lang=".$_REQUEST["lang"];
	//echo "$query<br>";
		$resultado=wxisLlamar($base,$query,$xWxis."opac/imprime_sel.xis");
		foreach($resultado as $contenido) $mensaje.=$contenido;
		
	}
}

echo "<h3>".$msgstr["front_mail_sent"]." ".date("d-m-y h:m")."</h3>";

//foreach ($_REQUEST as $key=>$value)  echo "$key=$value<br>";//die;

if (!isset($ini["FROM"]) or trim($ini["FROM"])=="")
   $ini["FROM"]=trim($_REQUEST["email"]);

if (isset($_REQUEST["name"])) {
	$name=$_REQUEST["name"];
} else {
	$name=$msgstr["front_user_request"];
}

if (!empty($ini["TEST"])){
	$to=$ini["TEST"];
}else{
	$to=$_REQUEST["email"];
}

$name=$msgstr["front_user_request"];
$body=$msgstr["front_user_request_by"].": <br>";
$body.=$_REQUEST["email"]."<br>";

if (isset($_REQUEST["comentario"])) $body.=nl2br(urldecode($_REQUEST["comentario"]));

$body.="<p>"."Seleccionados:<br>".$mensaje;
echo $body;

$mail="";

if (isset($ini["PHPMAILER"]) and $ini["PHPMAILER"]=="phpmailer"){
	SendMail($mail,$to,$name,$body,$ini);
}else{
	SendPhpMail($to,$name,$body,$ini);
}
flush();
?>

<form name="regresar" action="../buscar_integrada.php" method="post">
	<?php
		foreach ($_REQUEST as $key=>$value){
			echo "<input type=hidden name=$key value=\"$value\">\n";
		}
	?>
	<input type="submit" name="regresar_btn" class="btn btn-primary" value="<?php echo $msgstr["back"];?>">
</form>


<?php include($Web_Dir."views/footer.php");?>

