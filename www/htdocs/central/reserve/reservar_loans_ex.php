<?php
session_start();
// RESERVA DESDE EL SISTEMA DE PRESTAMOS
include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

include("../config.php");
include("../lang/prestamo.php");
include("../common/header.php");
include("../common/institutional_info.php");
include("../circulation/leer_pft.php");
// se lee la configuración de la base de datos de usuarios
include("../circulation/borrowers_configure_read.php");

function MostrarRegistroCatalografico($CN){global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db;
	$dbname=$arrHttp["base"];
	$pref_cn="";
	$archivo=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$dbname."/loans/".$lang_db."/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$t=explode(" ",trim($value));
			if ($t[0]=="NC")
				$pref_cn=$t[1];
		}
	}
	if ($pref_cn=="") $pref_cn="CN_";
	$Expresion=$pref_cn.$CN;
	$formato_obj=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$dbname."/loans/".$lang_db."/loans_display.pft";
	$arrHttp["count"]="";
	$Formato=$formato_obj;
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$dbname.".par&Expresion=".$Expresion."&Formato=$formato_obj";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $value){
		if (substr($value,0,8)!="[TOTAL:]")			echo $value."\n";	}
}

function ColocarTitulos($base){global $db_path,$lang_db;
	echo "<table>";	// se lee la tabla con los títulos de las columnas
	$archivo=$db_path.$base."/pfts/".$_SESSION["lang"]."/tbtit.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/pfts/".$lang_db."/tbtit.tab";
	if (file_exists($archivo)){
		$fp=file($archivo);
		foreach ($fp as $value){
			$value=trim($value);
			if (trim($value)!=""){
				$t=explode('|',$value);
				foreach ($t as $rot) echo "<th>$rot</th>";
			}
		}
	}
	echo "<th class=\"action\">&nbsp;</th></tr>";}

function Reservar($usuario,$NC){
global $xWxis,$Wxis,$wxisUrl,$db_path,$msgstr;
	echo "<hr>";
	MostrarRegistroCatalografico($NC);
//SE DETERMINA SI EL USUARIO NO TIENE YA RESERVADO ESE OBJETO
	$IsisScript=$xWxis."cipres_usuario.xis";
	$query="&base=reserve&cipar=$db_path"."par/reserve.par&Expresion=CU_".$usuario."&Pft=v10'|'v15'|',v20'|'v30/";
	include("../common/wxis_llamar.php");
	$num_reservas=0;
	$yareservado="N";
	echo $msgstr["reserves"];
	foreach ($contenido as $value) {
		if ($num_reservas==0){
		    ColocarTitulos("reserva");
		}
		echo "<table>";
		$value=trim($value);
		$num_reservas++;
		$r=explode('|',$value);
		echo "<tr>";
		$ixl=-1;
		foreach ($r as $linea) {			echo "<td>";
			$ixl++;
			switch ($ixl){				case 0:
					echo $r[0]."=".$NC;
				    if ($r[0]==$NC){
						echo "<strong><font color=red>**</font></strong>";
						$yareservado="S";
	   		 		}
					MostrarRegistroCatalografico($r[0]);
					break;
				case 3:
					$linea=$r[3];
				    $linea=substr($linea,6,2)."-".substr($linea,4,2)."-".substr($linea,0,4);
				default;
					echo $r[$ixl];			}

			echo "</td>";
	    }
	}

	if ($num_reservas !=0) echo "</table>";
	if ($yareservado=="S"){
		echo "<strong><font color=red>** El título solicitado ya está reservado por ese usuario</font></strong>";
		"<p><a href=javascript:self.close>Cerrar</a>";
		return;
	}
	if ($num_reservas>=2){
		print "No se permiten más de 2 reservas";
		"<p><a href=javascript:self.close>Cerrar</a>";
		return;
	}
	$ValorCapturado="<10 0>".$usuario."</10><20 0>".$signatura."</20><30 0>".date('Ymd')."</30>";
	$IsisScript=$xWxis."actualizar.xis";
  	$query = "&base=reserva&cipar=reserva.par&login".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='."?xx=".$query);
	$contenido="";
	exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
	foreach ($contenido as $linea){
		if (substr($linea,0,4)=="MFN:") {
	    	$arrHttp["Mfn"]=trim(substr($linea,4));
		}else{
			if (trim($linea!="")) $salida.= $linea."\n";
		}
	}
	print "<span class=titulo1>Reserva realizada</span>";
}



# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$uskey=$t[0];
$ec_output="" ;
?>
<script>
function Enviar(){	Codigo=Trim(document.reserva.codigo.value)
	if (Codigo==""){		alert("Debe especificar su código de usuario")
		return	}
	document.reserva.submit()}
</script>
</head>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["reserve"]?>
	</div>
	<div class="actions">
<?php
	include("../circulation/submenu_prestamo.php");
 	echo "<a href=\"buscar.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&count=1&Opcion=buscar_en_este&Expresion=".$arrHttp["Expresion"]."\" class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
		<?php ?>

	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulacion/reserva.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulacion/reserva.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reserve/reservar_loans_ex.php" ?></font>
</div>
<div class="middle form">
	<div class="formContent">
	<form name=inventorysearch target=reservar_loans_ex.php method=post>
	<input type=hidden name=cn value=<?php echo $arrHttp["cn"]?>>
	<input type=hidden name=Expresion value=<?php echo $arrHttp["Expresion"]?>>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
$nmulta=0;
$cont="";
$np=0;

// se presenta la  información del usuario
$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp.pft";
if (!file_exists($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/loans_usdisp.pft";
$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
$contenido="";
$IsisScript=$xWxis."cipres_usuario.xis";
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){
	echo $linea."\n";
}
//SE VERIFICA SI TIENE PRÉSTAMOS PENDIENTES
$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
$Pft="v40/";
$query = "&Expresion=TRU_P_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Pft=".$Pft;
$IsisScript=$xWxis."cipres_usuario.xis";
include("../common/wxis_llamar.php");
$prestamos=array();
foreach ($contenido as $linea){
	if (trim($linea)!="")
		$prestamos[]=$linea;
}
$nv=0;   //número de préstamos vencidos
$np=0;   //Total libros en poder del usuario
$cont="";
$fecha=date("Ymd");
if (count($prestamos)>0) {
	foreach ($prestamos as $pre){		echo " fecha de vencimiento:" .$pre;		$np++;		if ($pre<$fecha)
			$nv++;	}
}
echo "<h4>".$msgstr["loaned"].": ". $np."<br>";
echo "<p>".$msgstr["vence"].": $nv</h4>";
if ($nv!=0){	echo "<font color=red><h3>".$msgstr["useroverdued"]."</h3></font>";
	$cont="N";}
if ($cont!="N"){	$resultado=Reservar($arrHttp["usuario"],$arrHttp["cn"]);}
?>




   </div>
</div>
<?php
	include("../common/footer.php");
?>
</body>
</html>