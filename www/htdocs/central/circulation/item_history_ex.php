<?php
session_start();
// Situación de un objeto
if (!isset($_SESSION["login"])){	echo "Session expired" ;
//	die;
}if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$Opcion_leida=$arrHttp["Opcion"];


include("leer_pft.php");
include("borrowers_configure_read.php");
$arrHttp["base"]="biblo/loans/";

include("loanobjects_read.php");
include("calendario_read.php");
include("locales_read.php");


function LocalizarInventario($inventory){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$cn,$db,$item,$multa;

	//$Expresion=trim($prefix_in).$arrHttp["inventory"];
    $Expresion="IN_".$inventory;
	$formato_ex="v1'||'v10'||',(v959^i,'$$$ ',v959^l,'$$$ ',v959^b,'$$$ ',v959^o,'$$$ ',v959^v,'$$$ ',v959^t'###'),/";
	//se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj="";
	$formato_obj.=urlencode($formato_ex);
	$query = "&Opcion=disponibilidad&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=".$Expresion."&Pft=$formato_ex";
	include("../common/wxis_llamar.php");
	$total=0;
	$tit_cat=array();
	$ix=0;
	$cont=implode('',$contenido);
	$s=explode('||',$cont);
	$cn=$s[0];                       //CONTROL NUMBER
	$db=$s[1];                       //DATABASE
	$contenido=explode('###',$s[2]);
	foreach ($contenido as $linea){		echo "$linea<br>";
		if (substr($linea,0,8)=='$$TOTAL:')
			$total=trim(substr($linea,8));
		else
			$l=explode('###',$linea);
			foreach ($l as $it){
				$i=explode('$$$',$it);
//				echo "--".$i[0]."=".$inventory."<br>";				if ($i[0]==$inventory)  {					$item=$it;
					break;				}
			}


	}

	return $total;
}


// Se localiza el número de inventario en la base de datos de objetos  de préstamo
function ReadCatalographicRecord($control_number,$db){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$pft_totalitems,$pft_in,$pft_nc,$pft_typeofr,$titulo,$prefix_in,$multa;

	//Read the FDT of the database for extracting the prefix used for indexing the control number
//	echo $control_number;
    $Expresion="CN_".$control_number;
	//se ubica el título en la base de datos de objetos de préstamo
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj=$db_path."$db/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."$db/loans/".$lang_db."/loans_display.pft";
	$query = "&Opcion=disponibilidad&base=$db&cipar=$db_path"."par/$db.par&Expresion=".$Expresion."&Formato=$formato_obj";
	include("../common/wxis_llamar.php");
	$total=0;
	$titulo="";
	foreach ($contenido as $linea){
		$linea=trim($linea);
		if (substr($linea,0,8)=='$$TOTAL:')
			$total=trim(substr($linea,8));
		else
			$titulo.=$linea."\n";
	}
	return $total;
}



function ListarPrestamo($Expresion){
//se ubican todas las copias disponibles para verificar si están prestadasglobal $xWxis,$arrHttp,$db_path,$wxisUrl,$Wxis;
	$IsisScript=$xWxis."loans/prestamo_disponibilidad.xis";
	$Expresion=urlencode($Expresion);
	$formato_obj="v20'$$$'v30,'###'" ;
 	$query = "&Opcion=".$arrHttp["Opcion"]."&base=trans&cipar=$db_path"."par/trans.par&Expresion=".$Expresion."&Pft=$formato_obj&desde=".$arrHttp["desde"]."&cuenta=10";
    include("../common/wxis_llamar.php");
	return $contenido;
}
include("fecha_de_devolucion.php");


// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------
include("../common/header.php");
include("../common/institutional_info.php");
?>
<script>
function EnviarForma(Opcion){	eliminar=""	if (Opcion==0){		document.continuar.submit()	}else{		for (i=0; i<document.objeto.elements.length;i++){			if (document.objeto.elements[i].type=="checkbox"){				if (document.objeto.elements[i].checked) eliminar+=document.objeto.elements[i].value+"|"			}		}
		if (eliminar==""){			alert("debe seleccionar las reservas que va a eliminar")
			return		}else{
			alert(eliminar)			document.continuar.action="reservas_eliminar_ex.php"
			document.continuar.reservas.value=eliminar
			document.continuar.submit()		}	}}
</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["ecobj"]?>
	</div>
	<div class="actions">
		<a href="item_history.php?&encabezado=s" class="defaultButton backButton">
			<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
			<span><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/item_history.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/item_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: item_history_ex.php</font>\n";

echo "
	</div>
<div class=\"middle form\">
	<div class=\"formContent\">";

// se lee la tabla de tipos de objeto
unset($fp);
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/items.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/items.tab";
$fp=file($archivo);
foreach ($fp as $value){
	$value=trim($value);
	if ($value!=""){
		$t=explode('|',$value);
		if (!isset($t[1])) $t[1]=$t[0];
		$type_items[$t[0]]=$t[1];
	}
}

$disp=0;
// se busca el título para ver el total de ejemplares y los ejemplares prestados
$arrHttp["Opcion"]="disponibilidad";
$total=LocalizarInventario($arrHttp["inventory"]);
if ($total==0){	echo $msgstr["copynoexists"];
	die;}
$arrHttp["db"]=$db;
$arrHttp["code"]=$cn;
require_once("databases_configure_read.php");
$total=ReadCatalographicRecord($arrHttp["code"],$catalog_db);
if ($total>1){	echo "<font color=red>".$msgstr["dupctrl"]."</font><p>";}
echo '<font color=darkblue><strong>'.$msgstr["bd"].": ". $catalog_db.". ".$msgstr["control_n"].": ".$arrHttp["code"]."</strong></font><br>";
echo $titulo;
echo "<table bgcolor=#dddddd cellpadding=5>
	<th></th>
	<th>".$msgstr["inventory"]."</th>
	<th>".$msgstr["volume"]."</th>
	<th>".$msgstr["tome"]."</th>
	<th>".$msgstr["typeofitems"]."</th>
	<th>".$msgstr["usercode"]."</th>
	<th>".$msgstr["devdate"]."</th>";
if (trim($val)!="") ShowItems($item);echo "</table>";
$Expresion="CN_".$arrHttp["code"];
echo "<p>";

Function ShowItems($item){

	$l=explode('$$$',$item);
	echo "<tr><td bgcolor=white></td>";
	echo "<td bgcolor=white>".$l[0]."</td>";
	echo "<td bgcolor=white>".$l[4]."</td>";
	echo "<td bgcolor=white>".$l[5]."</td>";
	echo "<td bgcolor=white>".$l[3]."</td>";
    $Expresion="TR_P_".$l[0];
    $cont=ListarPrestamo($Expresion);
    $cont=implode("",$cont);
    if (substr($cont,0,8)!='$$TOTAL:'){
    	$cont=explode('###',$cont);
    	$c=explode('$$$',$cont[0]);
    	echo "<td bgcolor=white>".$c[0]."</td><td bgcolor=white>".$c[1]."</td>";
    }else{    	echo "<td bgcolor=white>&nbsp;</td><td bgcolor=white>&nbsp;</td>";    }

}
$hasta=$arrHttp["desde"]+10;
echo "<form name=continuar action=situacion_de_un_objeto_ex.php onsubmit='return false'>\n";
if (isset($arrHttp["Expresion"])){	echo "<input type=hidden name=Expresion value=\"".$arrHttp["Expresion"]."\">";
}else{	echo "<input type=hidden name=code value=\"".$arrHttp["code"]."\">";}echo "<input type=hidden name=Opcion value=".$Opcion_leida.">
<input type=hidden name=base value=".$arrHttp["base"].">
<input type=hidden name=reservas>
<input type=hidden name=desde value=";
if ($ref==$total) $hasta=1;
echo $hasta.">";
if ($reserves>0)
	"<center><input type=submit value='".$msgstr["delreserve"]."' onclick=EnviarForma(1)> &nbsp; &nbsp;<!--<input type=submit value=continuar onclick=EnviarForma(0)>--></center>
</form>";
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";

function Reservas($signatura){global $db_path,$Wxis,$xWxis,$wxisUrl,$msgstr;
// se presenta la lista de reserva
	$reserva=array();
	$query = "&Expresion=TR_".$signatura."&base=reserva&cipar=$db_path"."par/reserva.par&Pft=v10'|'v20'|'v30'|'v40'|'v50'|'v60'|'f(mfn,1,0)/";
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$reserva=array();
	foreach ($contenido as $linea){
		if (trim($linea!="")){
			$reserva[]=$linea;
		}
	}
 	if (count($reserva)>0){ 		echo "<h5>".$msgstr["reservas"]."</h5>";
		echo "<table class=\"listTable\">";
		echo "<tr><th>Eliminar</th><th>".$msgstr["users"]."</th><th>".$msgstr["signature"]."</th><th>".$msgstr["r_date"]."</th><th>".$msgstr["typeofitems"]  ."</th>";
		foreach ($reserva as $linea){			$t=explode('|',$linea);
			$dif= compareDate ($t[3]);
			$fuente="";
			$mora="0";
			if ($dif<0) {
				$nv=$nv+1;
				$mora=abs($dif/(60*60*24));    //cuenta de préstamos vencidos
			    $fuente="<font color=red>";
			}
			echo "<tr>";
			echo "<td bgcolor=white align=center><input type=checkbox name=chk_".$t[6]." value=".$t[6];
			if ($mora!=0) echo " checked";
			echo "></td>";
			echo "<td bgcolor=white align=center><xa href=usuario_prestamos_presentar.php?usuario=".$t[0]." target=_blank>".$t[0]."</a><td bgcolor=white align=center>".$t[1]."<td bgcolor=white align=center>$fuente".$t[3]."<td bgcolor=white align=center>".$t[5]."</td>";
		}
		echo "</table>";
	}
	return count($reserva);
}


function EjemplaresPrestados($inventory){
global $db_path,$Wxis,$wxisUrl,$xWxis;	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
    if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
   	$query = "&Expresion=TR_P_".$inventory."&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	foreach ($contenido as $linea){
		$prestamos[]=$linea;
	}
	$nv=0;   //número de préstamos vencidos
	$np=0;   //Total libros en poder del usuario
	if (count($prestamos)>0) {

		foreach ($prestamos as $linea) {
			$p=explode('^',$linea);
			$np=$np+1;
			$dif= compareDate ($p[9]);
			$fuente="";
			$mora="0";
			if ($dif<0) {
				$nv=$nv+1;
				$mora=abs($dif/(60*60*24));    //cuenta de préstamos vencidos
			    $fuente="<font color=red>";
			}
			echo "<td  bgcolor=white valign=top><xa href=usuario_prestamos_presentar.php?usuario=".$p[10]." target=_blank>";
			echo $p[10];
			echo "</a></td>

				<td bgcolor=white align=center valign=top><xa href=VerPolitica('".$p[3]."','".$p[6]."')>". $p[3]. "</a></td><td bgcolor=white nowrap align=center valign=top>".$p[4]."</td><td nowrap bgcolor=white align=center valign=top>$fuente".$p[5]."</td><td align=center bgcolor=white valign=top>".$mora."</td></tr>";

		}
//		echo "</table></dd><br>";
        echo "<script>
		np=$np
		nv=$nv
		</script>\n";
	}
}
?>