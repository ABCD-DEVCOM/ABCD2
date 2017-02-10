<?php

// Globales.
//set_time_limit (0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
include("../lang/dbadmin.php");

function InicializarBd(){
global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
 	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=".$arrHttp["Opcion"];
 	$IsisScript=$xWxis.$arrHttp["IsisScript"];
 	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
	 	if ($linea=="OK"){	 		echo "<h4>".$arrHttp["base"]." ".$msgstr["init"]."</h4>";	 	}
 	}
}

function VerStatus(){
	global $arrHttp,$xWxis,$wxisUrl,$OS,$db_path,$Wxis;
	$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
 	$IsisScript=$xWxis."administrar.xis";
 	include("../common/wxis_llamar.php");
 	$ix=-1;
	foreach($contenido as $linea) {
		if (trim($linea)!=""){
			$ix=$ix+1;
			if ($ix>0) {
	  			$a=explode(":",$linea);
	  			$tag[$a[0]]=$a[1];
			}
		}
	}
	return $tag;
}

function Footer(){	echo "</div></div>";
	include("../common/footer.php");
	echo "</body></html>";
	die;}



$encabezado="";
if (isset($arrHttp["encabezado"])) $encabezado="&encabezado=s";
include("../common/header.php");
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["maintenance"]." " .$msgstr["database"].": ".$arrHttp["base"]."</h5>"?>
			</div>

			<div class="actions">
<?php echo "<a href=\"menu_mantenimiento.php?reinicio=s&base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php }
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";
echo "<font size=1> &nbsp; &nbsp; Script: dbadmin/administrar_ex.php</font><br>";
switch ($arrHttp["Opcion"]) {
    case "inicializar":
    	if (!file_exists($db_path.$arrHttp["base"])){    		echo "<h3>".$arrHttp["base"].": ".$msgstr["folderne"]."</h3>";
    		Footer();    	}
    	if (!file_exists($db_path."par/".$arrHttp["base"].".par")){
    		echo "<h3>"."par/".$arrHttp["base"].".par: ".$msgstr["ne"]."</h3>";
    		Footer();
    	}
    	$protected="N";
		if (file_exists($db_path.$arrHttp["base"]."/protect_status.def")){
			$fp=file($db_path.$arrHttp["base"]."/protect_status.def");
			foreach ($fp as $value){
				$value=trim($value);
				if ($value=="PROTECTED"){
					echo "<h4>".$msgstr["protect_active"]."</h4>";
					$protected="Y";
				}
			}
		}
		if ($protected=="N"){
    		$arrHttp["IsisScript"]="administrar.xis";
    		$tag=VerStatus();
			if (!isset($arrHttp["borrar"])){
				if ($tag["BD"]!="N"){
					echo "<br><span class=td><h4>".$arrHttp["base"]."<br><font color=red>".$msgstr["bdexiste"]."</font><br>".$tag["MAXMFN"]." ".$msgstr["registros"]."<BR>";
					echo "<script>
						if (confirm(\"".$msgstr["elregistros"]." ??\")==true){
							borrarBd=true
						}else{
							borrarBd=false
						}
						if (borrarBd==true){
							if (confirm(\"".$msgstr["seguro"]." ??\")==true){
								borrarBd=true
							}else{
								borrarBd=false
							}
						}
						if (borrarBd==true)
							self.location=\"administrar_ex.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&Opcion=inicializar&borrar=true$encabezado\"
						</script>";
				}else{

					InicializarBd();
					$arrHttp["Opcion"]="unlockbd";
				}
			}else{
				$arrHttp["IsisScript"]="administrar.xis";
				InicializarBd();
				$fp=fopen($db_path."par/".$arrHttp["base"].".par","r");
				if (!$fp){
					echo $arrHttp["base"].".par"." ".$msgstr["falta"];
					die;
				}
				$fp=file($db_path."par/".$arrHttp["base"].".par");
				foreach($fp as $value){
					$ixpos=strpos($value,'=');
					if ($ixpos===false){
					}else{
						if (substr($value,0,$ixpos)==$arrHttp["base"].".*"){
							$path=trim(substr($value,$ixpos+1));
							$ixpos=strrpos($path, '/');
							$path=substr($path,0,$ixpos)."/";
	//						echo "<p>$path<p>";
							break;
						}
					}
				}
				$arrHttp["Opcion"]="unlockbd";
			}
		}
		break;
	case "fullinv":

		$contenido=VerStatus();
		$arrHttp["IsisScript"]="fullinv.xis";
		MostrarPft();
		break;
	case "unlockbd":
		$contenido=VerStatus();
		echo "<p><span class=td>";
		foreach ($contenido as $value) echo "<dd>$value<br>";
		$arrHttp["IsisScript"]="administrar.xis";
		MostrarPft();
		break;
	case "listar":

	case "unlock":
		$contenido=VerStatus();
		$arrHttp["IsisScript"]="administrar.xis";
		echo "<p><span class=td>";
		MostrarPft();
		break;


}
if (!isset($arrHttp["encabezado"])){
	if ($arrHttp["Opcion"]!="fullinv")
 		echo "<p><center><a href=index.php?base=".$arrHttp["base"]." class=boton> &nbsp; &nbsp; Menu &nbsp; &nbsp; </a>";
}
?>
