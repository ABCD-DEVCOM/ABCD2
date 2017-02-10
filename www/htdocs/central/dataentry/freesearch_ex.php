<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!="")
	$arrHttp["Opcion"]="buscar";
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
include("../config.php");


include("../lang/soporte.php");
include("../lang/admin.php");
set_time_limit(0);


include("leer_fdt.php");

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global  $arrHttp,$xWxis;

function WxisLLamar($IsisScript,$query){global $Wxis,$xWxis,$db_path;
	include("../common/wxis_llamar.php");
	return $contenido;}

function GenerarSalida($Mfn,$count,$Pft,$sel_mfn){
global $arrHttp,$xWxis,$db_path;	$query="&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Mfn=$Mfn&count=$count";
  	if ($Pft=="") $Pft=$arrHttp["search"].'#';
	$query.="&Formato=".urlencode($Pft.'/')."&Opcion=rango";
	$contenido="";
	$IsisScript=$xWxis."act_tabla.xis";
	$contenido=WxisLlamar($IsisScript,$query);
	$nfilas=0;
	$Actualizar="";
	$ixcuenta=0;
	foreach ($contenido as $linea){
		if (trim($linea)=="") continue;
		$xcampos=explode('|',$linea);
   		$linea=$xcampos[0];
   		$linea=explode('$$',$linea);
   		$cuenta=explode(":",$linea[1]);
   		$cuenta=$cuenta[1];
   		$valor=$xcampos[2];
     	$ixcuenta=$ixcuenta+1;
   		if ($arrHttp["tipob"]=="pft" and trim($valor)!=""){

           	echo "<tr>";
           	echo "<td bgcolor=white valign=top>";
			echo "<input type=checkbox name=sel_mfn  value=".$xcampos[1]." onclick=SelecReg(this)";
			if (isset($sel_mfn[$xcampos[1]])) echo " checked";
			echo "></td>";

			echo "<td bgcolor=white valign=top>".$cuenta."/".$arrHttp["total"]."</td>";
			echo "<td bgcolor=white valign=top>".$xcampos[1]."</td>";
			echo "<td bgcolor=white valign=top>";
			echo $xcampos[2];
			echo "</td>";
   		}else{
	   		if (stristr($valor,$arrHttp["search"])!==false){
	   			$val=explode('____$$$',$valor);
	   			echo "<tr>";
	   			echo "<td bgcolor=white valign=top>";
				echo "<input type=checkbox name=sel_mfn  value=".$xcampos[2]." onclick=SelecReg(this)";
				if (isset($sel_mfn[$xcampos[1]])) echo " checked";
				echo "></td>";
				echo "<td bgcolor=white valign=top>".$cuenta."/".$arrHttp["total"]."</td>";
	   			echo "<td bgcolor=white valign=top>".$xcampos[1]."</td><td bgcolor=white valign=top>";
	   			//flush();
	   			//ob_flush();
	   			foreach ($val as $cont) {
	   				$ixc=stripos($cont,$arrHttp["search"]);
	   				if ($ixc!==false){
						$ixter=strlen($arrHttp["search"]);
	   					$cont=substr($cont,0,$ixc)."<font color=red>".substr($cont,$ixc,$ixter)."</font>".substr($cont,$ixter+$ixc);
	   				}
					echo $cont."<br>";
				}
				echo "</td>";
    		}
		}
		flush();
		ob_flush();
	}
	flush();
	ob_flush();
}
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//



//foreach ($arrHttp as $val=>$value) echo "$val=$value<br>";
include ("../common/header.php");
?>
<script>
RegistrosSeleccionados=top.RegistrosSeleccionados

function CheckAll(){	len=document.tabla.sel_mfn.length
	if (document.tabla.chkall.checked){		for (i=0;i<len;i++){			document.tabla.sel_mfn[i].checked=true
			top.SeleccionarRegistro(document.tabla.sel_mfn[i])		}	}else{		for (i=0;i<len;i++){
			Mfn=document.tabla.sel_mfn[i].value
			if (RegistrosSeleccionados.indexOf("_"+Mfn+"_")==-1)
				document.tabla.sel_mfn[i].checked=false
		}	}}

function SelecReg(Ctrl){
	top.SeleccionarRegistro(Ctrl)}

function Presentar(Mfn){	url="leer_all.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["base"]?>.par&Mfn="+Mfn+"&count=1"
	msgwin=window.open(url,"SEE","width=400,height=400,resizable,scrollbars")
	msgwin.focus()}
function EnviarForma(){	if ((Trim(document.forma1.from.value)=="" || Trim(document.forma1.to.value)=="") && Trim(document.forma1.Expresion.value)=="" && Trim(document.forma1.seleccionados.value)==""){
		alert("<?php echo $msgstr["cg_selrecords"]?>")
		return  false
	}
	if (Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!="") {
		if (Trim(document.forma1.from.value)=="" || (document.forma1.to.value)==""){
			alert("<?php echo $msgstr["cg_selrecords"]?>")
			return false
		}
		if (document.forma1.to.value>top.maxmfn || document.forma1.from.value>top.maxmfn || document.forma1.to.value<=0
		    || document.forma1.from.value<=0 ||  document.forma1.from.value>document.forma1.to.value ){
			alert("<?php echo $msgstr["numfr"]?>")
			return false
		}
	}
	if ((Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!="") && Trim(document.forma1.Expresion.value)!=""){
		alert("<?php echo $msgstr["cg_selrecords"]?>")
		return false
	}}

</script>

<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["m_busquedalibre"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">

	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/freesearch.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/freesearch.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp; &nbsp; <a href=\"http://abcdwiki.net/wiki/es/index.php?title=B%C3%BAsquedas#B.C3.BAsqueda_Libre\" target=_blank>abcdwiki</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/freesearch_ex.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	<form name=tabla>
	";

$base =$arrHttp["base"];
$cipar =$arrHttp["cipar"];
//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";//die;
// se lee el archivo mm.fdt
if (!isset($_SESSION["login"])){
  	echo $msgstr["menu_noau"];
  	die;
}
if (!isset($arrHttp["nuevo"])) {
    $arrHttp["nuevo"]="";
}
$Fdt=LeerFdt($base);
$Pft="";
if (isset($arrHttp["fields"])){	if ($arrHttp["fields"]=="ALL"){		foreach ($Fdt as $tag=>$linea){			if (trim($linea)!=""){
				$t=explode('|',$linea);
				if ($t[0]!="S" and $t[0]!="H" and $t[0]!="L" and $t[0]!="LDR"){
		  			if (trim($t[1])!="")
		  				$Pft.="(if p(v".$t[1].") then '".$t[1]." 'v".$t[1]."'____$$$' fi),";
		  		}
			}
		}
	}else{		$t=explode(';',$arrHttp["fields"]);
		foreach ($t as $value){			if (trim($value)!="" and trim($value)!="ALL"){				$Pft.="(if p(v".$value.") then '".$value."= 'v".$value."'____$$$' fi),";			}		}	}
}
$Pft=str_replace('/','<br>',$Pft);
$IxMfn=0;
if (!isset($arrHttp["from"])){
	$desde=1;
}else{
	$desde=$arrHttp["from"];
}
if (isset($arrHttp["to"])){
	$count=$arrHttp["to"];
    $arrHttp["count"]=$count;
    if ($arrHttp["count"]>50) $arrHttp["count"]=50;
}else{
	if (isset($arrHttp["count"])){
		$hasta=$desde+$arrHttp["count"]-1;
	}
}
if(!isset($arrHttp["count"]))
	$arrHttp["count"]=50;
if (isset($arrHttp["to"]))
	$total=$arrHttp["to"];
if (isset($arrHttp["total"]))
	$total=$arrHttp["total"];
$count=$arrHttp["count"];
//if ($count>$total) $count=$arrHttp["total"];
//echo $arrHttp["anterior"];


	echo "<center><div style=\"width:700px;border-style:solid;border-width:1px; text-align: left;\">";
	if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]!="buscar" or !isset($arrHttp["Opcion"])){		echo $msgstr["cg_from"].": ".$arrHttp["from"]." &nbsp; &nbsp; ".$msgstr["cg_to"].": ";
		if (isset($arrHttp["to"]))
			echo $arrHttp["to"];
		else
			echo $total;
		echo "<br>";	}
	if (isset($arrHttp["Expresion"])){
		echo $msgstr["cg_search"].": ".$arrHttp["Expresion"]."<br>";	}
	echo "<strong>".$msgstr["cg_locate"].": ".$arrHttp["search"]."</strong>";
	echo "</div>";
?>
<center>
<table bgcolor=#cccccc cellspacing=1 border=0 cellpadding=5>
<tr><td bgcolor=white align=center><input type=checkbox name=chkall onclick=CheckAll()></td><td bgcolor=white align=center> </td><td bgcolor=white align=center>Mfn</td><td bgcolor=white align=center>
    </td>
</tr>

<?php
$arr_mfn=array();
$sel_mfn=array();
if (isset($arrHttp["seleccionados"])){
	$Mfn=explode(',',$arrHttp["seleccionados"]);
	foreach ($Mfn as $m){
		$m=trim($m);
		if ($m!="" and is_numeric($m) and $m>0)
			$sel_mfn[$m]=$m;
	}
}
if (!isset($arrHttp["Expresion"])){
	//se construye el rango de Mfn's a procesar
	if (isset($arrHttp["seleccionados"]) and !isset($arrHttp["from"])){		$Mfn=explode(',',$arrHttp["seleccionados"]);
		foreach ($Mfn as $m){			$m=trim($m);			if ($m!="" and is_numeric($m) and $m>0)
				$arr_mfn[$m]=$m;		}
		$total=count($arr_mfn);
		$Opcion="seleccion";	}else{		if (!isset($arrHttp["to"])){			$arrHttp["to"]=$arrHttp["from"]+$arrHttp["count"]-1;		}
		for ($ix=$desde;$ix<=$arrHttp["to"];$ix++){			$arr_mfn[$ix]=$ix;		}
		$Opcion="rango";
	}
}else{

	$query="&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"];
	$query.="&Expresion=".urlencode(stripslashes($arrHttp["Expresion"]))."&Opcion=".$arrHttp["Opcion"];
	$query.="&from=$desde&Mfn=$desde&count=$count";

	if ($arrHttp["tipob"]=="pft"){
	    $arrHttp["search"]=str_replace('/','<br>',$arrHttp["search"]);
		$query.='&Formato='.urlencode($arrHttp["search"].'#');
	}else{
		$query.="&Formato=".urlencode($Pft);
	}
	$IsisScript=$xWxis."act_tabla.xis";
	include("../common/wxis_llamar.php");
	$ix=0;
	foreach ($contenido as $value){
		if (trim($value)!="") {			$ix++;
			$val=explode('|',$value);
			$pos=explode('$$',$val[0]);
				$total=$pos[2];


			$cont="";
			if ($arrHttp["tipob"]=="string"){            	if (stristr($value,$arrHttp["search"])!==false){
		   			$vv=explode('____$$$',$value);
		   			foreach ($vv as $conseguido) {
		   				$salida=explode('|',$conseguido);
		   				if (isset($salida[2])){
			   				$salida=$salida[2];
			   				$ixc=stripos($salida,$arrHttp["search"]);
			   				if ($ixc!==false){
								$ixter=strlen($arrHttp["search"]);
			   					$cont.=substr($salida,0,$ixc)."<font color=red>".substr($salida,$ixc,$ixter)."</font>".substr($salida,$ixter+$ixc);
			   				}
						}
					}
				}			}
			if ($arrHttp["tipob"]=="pft" or $cont!=""){				if (isset($val[1])){
				if (!isset($arr_msg[$val[1]])){
					if (isset($val[2]) and trim($val[2])!=""){						$arr_mfn[$val[1]]=$val[1];
						$arr_msg[$val[1]]=$val[2];
						if ($cont!="") $arr_msg[$val[1]]=$cont;
					}				}else{
					$arr_mfn[$val[1]]=$val[1];
					$arr_msg[$val[1]]=$cont;
				}
				}
			}		}	}

	$Opcion="busqueda";
}echo $msgstr["registros"]."=$total";
$tope=count($arr_mfn);

$cuenta=$desde-1;

if (isset($arrHttp["Expresion"])){
	foreach ($arr_mfn as $Mfn){
		$cuenta=$cuenta+1;		echo "<tr>";
		echo "<td bgcolor=white valign=top>";
		echo "<input type=checkbox name=sel_mfn  value=$Mfn onclick=SelecReg(this)";
		if (isset($sel_mfn[$Mfn])) echo " checked";
		echo "></td>";

		echo "<td bgcolor=white valign=top>".$cuenta."/";
		if ($Opcion=="seleccion") echo $tope;
		if ($Opcion=="busqueda")  echo $total;
		echo "</td>";
		echo "<td bgcolor=white valign=top>".$Mfn."</td>";
		if ($Opcion!="seleccion") echo "<td bgcolor=white valign=top>".$arr_msg[$Mfn]."</td>";
	}}else{

	if ($Opcion=="seleccion"){
		$arrHttp["total"]=count($arr_mfn);		foreach ($arr_mfn as $Mfn){        	GenerarSalida($Mfn,1,$Pft,$sel_mfn);		}	}else{		if (!isset($arrHttp["total"])) $arrHttp["total"]=$arrHttp["to"];		$tope=count($arr_mfn);
		$IxMfn=$IxMfn+1;
		$cuenta=$cuenta+1;
		if (isset($arrHttp["count"]))
			$count=$arrHttp["count"];
		else
			$count=$arrHttp["to"]-$arrHttp["from"]+1;
        GenerarSalida($arrHttp["from"],$count,$Pft,$sel_mfn);


	}
}

echo "</table>";

switch ($Opcion){
  	case "rango":
  		//$arrHttp["from"]=$Mfn+1;
  		break;
	case "busqueda":
		echo "<br><div style=\"width=700;border-style:solid;border-width:1px \"><font size=1 face=arial>Expresion: ".stripslashes($arrHttp["Expresion"])."<br></div>";
		break;
}
foreach ($arrHttp as $var=>$value){	if ($var!="from" and $var!="to")		echo "<input type=hidden name=$var value=\"$value\">\n";}
if ($Opcion=="rango" or $Opcion=="busqueda"){
	$hasta=$desde+$count;
	if ($hasta>=$total){		$hasta=1;	}

	echo "<p><font face=arial size=1>
	Próximo registro:<input type=text size=5 name=from value='".$hasta."'>,
	procesar <input type=text size=5 name=count value=".$count."> registros más
	<p><input type=submit value=\"".$msgstr["continuar"]."\" onclick=EnviarForma() ><br>";
}
echo "<input type=hidden name=total value=$total>\n";
?>
</td>
</form>
</table>

<p>
</div>
</div>
<?php include("../common/footer.php")?>
</body>
</html>
<script>
	Ctrl=document.tabla.sel_mfn
	for (i=0;i<Ctrl.length;i++){
		C_Mfn="_"+Ctrl[i].value+"_"
		if (RegistrosSeleccionados.indexOf(C_Mfn)==-1){			Ctrl[i].checked=false		}else{			Ctrl[i].checked=true		}	}

</script>
