<?php
/*
20220203 fho4abcd Only back & div-helper modified. This script is currently not used but might be usefull after Improvment
*/
set_time_limit(0);
session_start();

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["login"])){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
?>
<body >
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>

<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        Analizar contenido de base de datos
    </div>
    <div class="actions">
        <?php
        include "../common/inc_back.php";
        ?>
    </div>
	<div class="spacer">&#160;</div>
	</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle">
<div class="formContent" >
<form name=generar method=post>
<input type=hidden name=ok value=ok>
<?php if (!isset($_REQUEST["ok"]))
		Ask_Confirmation();
	  else
	  	AnalizarBaseDeDatos($arrHttp["base"]);
?>
</form>
</div>
</div>
<?php
include("../common/footer.php");

//================= functions ==============
function Ask_Confirmation(){
	echo "<div style='margin: 20px 40px 10px 200px; width:400px '>";
	echo "Este proceso analiza el contenido de una base de datos para determinar qué campos y subcampos se están utilizando.  Puede tardar varios minutos por lo que no debe presionar ninguna tecla hasta obtener el mensaje
	 que indique que el proceso ha terminado\n";
	 echo "";
	 echo "<p>";
	 echo "<input type=submit value=continuar onclick=document.generar.ok.value='OK'>";
	 echo "</div>";
}


function AnalizarBaseDeDatos($base){
global $db_path;

    $resultado=array();
	echo "Leyendo la base de datos  para extraer los campos<p>";
	$IsisScript="administrar.xis";
	$query = "&base=".$base . "&cipar=$db_path"."par/".$base.".par&Opcion=status";
    $contenido=WxisLlamar($IsisScript,$base,$query);
    $ix=-1;
    foreach($contenido as $linea) {
		$ix=$ix+1;
		if ($ix>0) {
			if (trim($linea)!=""){
		   		$a=explode(":",$linea);
		   		if (isset($a[1])) $tag[$a[0]]=$a[1];
		  	}
		}
	}
	$MaxMfn=$tag["MAXMFN"];
	echo "Total registros a procesar: $MaxMfn<p>";
	flush();
    ob_flush();
	$IsisScript="leer_mfnrange.xis";
	//$MaxMfn=100;
	for ($mfn=1;$mfn<$MaxMfn;$mfn++){
		echo "$mfn<br>";
		$query="&base=$base&cipar=$db_path"."par/".$base.".par&Pft=ALL&from=$mfn&to=$mfn";
		$contenido=WxisLlamar($IsisScript,$base,$query);
		foreach ($contenido as $value){
			$value=trim($value);
			if ($value!=""){
				if (substr($value,0,4)!='mfn='){
					$pos=strpos($value," ");
					$tag=substr($value,0,$pos);
					if (isset($resultado[$tag]["tag"])){
	                     $resultado[$tag]["cuenta"]=$resultado[$tag]["cuenta"]+1;
					}else{
						$resultado[$tag]["tag"]=$tag;
						$resultado[$tag]["indicadores"]="";
						$resultado[$tag]["subc"]="";
						$resultado[$tag]["cuenta"]=1;
					}
					$ix=strpos($value,'®');
	           		$value=substr($value,$ix+1);

	           		$ix=strpos($value,'^');
	           		//echo "$ix / $value";
	           		if ($ix===false) continue;
	           		$indicadores="";
	           		if ($ix==2){
	           			$resultado[$tag]["indicadores"]="S";
	           			$indicadores="S";
	           		}
	           		$value=substr($value,$ix);
	           		$v=explode('^',$value);
	           		if (count($v)>1){
	                	foreach ($v as $subc){

		                	$sc=substr($subc,0,1);
		                	if (isset($resultado[$tag]["subc"])){
		                		if (strpos($resultado[$tag]["subc"],$sc)===false)
		                			$resultado[$tag]["subc"].=$sc;
		                	}else{
		                		$resultado[$tag]["subc"]=$sc;
		                	}
		                }
		            }
					//echo "** $tag=".$value;
					//echo "<xmp>";print_r($v);echo "</xmp>";
					flush();
	    			ob_flush();
				}

			}
		}
	}
	echo "<table border=1 cellpadding=5><th>Tag</th><th>Indicadores</th><th>Subcampos</th><th>Contador</th>";
	ksort($resultado);
	foreach ($resultado as $value){
		echo "<tr><td>".$value["tag"]."</td>";
		echo "<td>".$value["indicadores"]."</td>";
		echo "<td>".$value["subc"]."</td>";
		echo "<td>".$value["cuenta"]."</td>";
		echo "</tr>";
	}
    echo "</table>";

    echo "\n<script>alert('Fin del Proceso')</script>\n";
}

function WxisLlamar($IsisScript,$base,$query){
global $db_path,$Wxis,$xWxis,$wxisUrl;
	$IsisScript=$xWxis.$IsisScript;
	INCLUDE ("../common/wxis_llamar.php");
	return $contenido;
}
?>