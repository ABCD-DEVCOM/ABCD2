<?php

// rutina para almacenar los préstamos otorgados,las renovaciones y las devoluciones


$valortag = Array();
$arrHttp=Array();

function PresentarLista($Prefijo,$tagfst){
global $arrHttp;
	$xpre=$arrHttp["prefijo"];
	$arrHttp["IsisScript"]="ifp.xis";
//	$arrHttp["Opcion"]="lista_usuarios";
	$arrHttp["prefijo"]=$Prefijo;
	if (isset($arrHttp["llave"])) $arrHttp["prefijo"].=$arrHttp["llave"];

	$arrHttp["tagfst"]=$tagfst;

	echo "<html>";
	echo "<head>";
	echo "<link rel=stylesheet href=../css/styles.css type=text/css>\n";
?>
<script language=javascript>
	window.opener.top.menu.document.Prestamo.cod_usuario.value=""
	window.opener.top.menu.document.Prestamo.inventario.value=""
function LeerUsuario(Codigo){
	window.opener.top.menu.document.Prestamo.cod_usuario.value=Codigo
	document.formasearch.Expresion.value=Codigo
	document.formasearch.usuario.value=Codigo
   	document.formasearch.submit()
	self.close()
}

function IrA(){
	llave=document.formasearch.Alfa.value
	llave=llave.replace(" ","+")
	loc="prestamos.php?Opcion=<?php echo $arrHttp["Opcion"]."&userid=".$arrHttp["userid"]."&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]?>&prefijo=<?php echo $arrHttp["prefijo"]?>&LastKey=<?php echo $arrHttp["prefijo"]?>"+llave
	self.location.href=loc
}
</script>


</head>
<body bgcolor=white>
<?php
	echo "<FORM METHOD=Post action=prestamo_presentar.php name=formasearch";
	if ($arrHttp["Opcion"]== "reservar" ){
		echo " target=_new>";
		echo "<input type=hidden name=Formato value=r>";
	}else{
		echo " target=main>";
	}
	echo "<input type=hidden name=IsisScript value=cipres.xis>";

	echo "<input type=hidden name=base value=users>";
	echo "<input type=hidden name=cipar value=".$arrHttp["cipar"].">";
	echo "<input type=hidden name=userid value=".$arrHttp["userid"].">";
	echo "<input type=hidden name=from value=1>";
	echo "<input type=hidden name=to value=25>";
	echo "<input type=hidden name=Expresion value=\"\">";
	if ($arrHttp["Opcion"]=="reservar"){
		echo "<input type=hidden name=Opcion value=\"reservar\">";
	}else{
		echo "<input type=hidden name=Opcion value=\"prestamousuario\">";
	}
	echo "<input type=hidden name=usuario value=\"\">";


	echo "<span class=td2>";
//	echo "<dd>Ir a: <input type=text name=Alfa value=''>
//		<a href=javascript:IrA()><img src=img/buscarlupa.gif border=0></a><p>

//		<dd><table><td>";

 	$IsisScript="wxis/".$arrHttp["IsisScript"];
 	$tags=array_keys($arrHttp);
 	$query = "?xx=&";
 	foreach ($tags as $linea){
  		if ($linea!="IsisScript"){
   			$query.=$linea."=". $arrHttp[$linea]."&";
  		}
 	}
// 	echo $query;
 	putenv('REQUEST_METHOD=GET');
 	putenv('QUERY_STRING='.$query);
 	$contenido="";
 	if (stristr($OS,"unix")==true){
  		$llamar="./wxis.exe";
 	}else{
  		$llamar="wxis.exe";
 	}
 	$llamar.=" IsisScript=".$IsisScript;
 	exec($llamar,$contenido);

	 foreach ($contenido as $linea){
	   	if (substr($linea,0,9)=='$$ULTIMO='){
		     $ultimaKey=trim(substr($linea,9));
		     if ($ultimaKey==$arrHttp["prefijo"]) echo "<b>Fin de la lista</b>";
		}else{
  			echo "$linea\n";
  		}
 	}


	echo "</table>
		 <p><dd><a href=prestamos.php?Opcion=".$arrHttp["Opcion"]."&userid=".$arrHttp["userid"]."&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&prefijo=$xpre&LastKey=".str_replace(" ","+",$ultimaKey).">Continuar</a>";
		echo "</form>
		</td></table>";
}


// ------------------------------------------------------

include("../common/get_post.php");

//foreach ($arrHttp as $var => $value )		echo "$var = $value<br>";


	$devolver=false;
	switch ($arrHttp["Opcion"]){
		case "localiza_titulo":
			PresentarLista($arrHttp["prefijo"],"800");
			break;
		case "reservar":
			PresentarLista($arrHttp["prefijo"],"30");
			break;
		case "localiza_usuario":
			PresentarLista($arrHttp["prefijo"],"30");
			break;
		case "renovar":
		case "devolver":
			$trans=explode("|", $arrHttp["transacciones"]);
			foreach($trans as $linea){
				if (trim($linea)<>""){
					$Mfn=trim($linea);
					$arrHttp["Opcion"]="devolver";
					$query = "?xx=  "."&base=presta" ."&cipar=cipres.par&Mfn=" .$Mfn. "&Opcion=".$arrHttp["Opcion"]."&userid=".$arrHttp["userid"];
					$script=$xWxis."cipres.xis ";
//					echo $query."<br>";
					putenv('REQUEST_METHOD=GET');
					putenv('QUERY_STRING='.$query);
					$contenido="";
					if (stristr($OS,"win")==false){
						exec("./wxis.exe IsisScript=".$script,$contenido);
					}else{
						exec("wxis.exe IsisScript=".$script,$contenido);
					}

					header("Location: prestamo_presentar.php/"); /* Redirect browser */
					exit;
				}
			}

// se presenta el estado de cuenta del usuario

			$arrHttp["Opcion"]="buscar_cipres";
   			$query = "?xx=  &usuario=".$Expresion."&base=users" ."&cipar=".$arrHttp["cipar"]."&userid=".$arrHttp["userid"]."&Expresion=".$arrHttp["usuario"]."&from=" . "&Opcion=".$arrHttp["Opcion"]."&Path=".$arrHttp["Path"];
			putenv('REQUEST_METHOD=GET');
			putenv('QUERY_STRING='.$query);
			$contenido="";
			if (stristr($OS,"win")==false){
				exec("./wxis.exe IsisScript=wxis/cipres.xis ",$contenido);
			}else{
				exec("wxis.exe IsisScript=wxis/cipres.xis",$contenido);
			}
			foreach ($contenido as $linea){
				echo "$linea\n";
			}
			chdir ($diractivo);
			break;
		case "prestar" :	//grabar o devuelve el préstamo y presentar los resultados al usuario
			if($devolver){
				$arrHttp["Opcion"]="devolver";
				$query = "?xx=  "."&base=presta" ."&cipar=".$arrHttp["cipar"]."&userid=".$arrHttp["userid"]."&Mfn=" .$arrHttp["Mfn"]. "&Opcion=".$arrHttp["Opcion"]."&Path=".$arrHttp["Path"];
				$script="cipres.xis ";
			}else{
// se graba el préstamo
				$arrHttp["Opcion"]="crear";
				$ValorCapturado="800"."^n".$arrHttp["inven"].$arrHttp["datoslibro"]."^p".$arrHttp["fpreiso"]."^h".$arrHttp["fdeviso"]."\n";
				$ValorCapturado.="001P\n"."020".$arrHttp["usuario"];
				$ValorCapturado=urlencode($ValorCapturado);
				$expresion_1=$arrHttp["usuario"];
				$expresion_2=$arrHttp["Expresion"];
   				$query = "?xx=  "."&base=presta" ."&cipar=".$arrHttp["cipar"]."&userid=".$arrHttp["userid"]."&from=" . "&Opcion=".$arrHttp["Opcion"]."&Path=".$arrHttp["Path"]."&ValorCapturado=".$ValorCapturado;
				$script="ingreso.xis ";
			}
			putenv('REQUEST_METHOD=GET');
			putenv('QUERY_STRING='.$query);
			$contenido="";

// Ruta al directorio donde se encuentra wwwisis
			$diractivo=getcwd();
			chdir ($pathwxis);

			if (stristr($OS,"win")==false){
				exec("./wxis.exe IsisScript=".$script,$contenido);
			}else{
				exec("wxis.exe IsisScript=".$script,$contenido);
			}
			foreach ($contenido as $linea){
				echo "$linea\n";
			}

// se presenta el estado de cuenta del usuario

			$arrHttp["Opcion"]="buscar_cipres";
			$arrHttp["Expresion"]=$expresion_1;
   			$query = "?xx=  "."&base=users" ."&cipar=".$arrHttp["cipar"]."&userid=".$arrHttp["userid"]."&usuario=".$expresion_1."&Expresion=".$expresion_1."&from=" . "&Opcion=".$arrHttp["Opcion"]."&Path=".$arrHttp["Path"];
			putenv('REQUEST_METHOD=GET');
			putenv('QUERY_STRING='.$query);
			$contenido="";
			if (stristr($OS,"win")==false){
				exec("./wxis.exe IsisScript=cipres.xis ",$contenido);
			}else{
				exec("wxis.exe IsisScript=cipres.xis ",$contenido);
			}
			foreach ($contenido as $linea){
				echo "$linea\n";
			}
			chdir ($diractivo);
			break;
	}

echo "<p><font color=#666666>prestamos.php<br>";
?>