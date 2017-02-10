<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      calendario_ver.php
 * @desc:      Shows the calendar
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
function calcula_numero_dia_semana($dia,$mes,$ano){
	$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
	if ($numerodiasemana == 0)
		$numerodiasemana = 6;
	else
		$numerodiasemana--;
	return $numerodiasemana;
}
//Funcion que verifica si el dia es feriado//
function dia_feri($dia,$mes){global $db_path,$lang_db;
	$file =$db_path."circulation/def/".$_SESSION["lang"]."/feriados.tab";
	if (!file_exists($file) ) $file =$db_path."circulation/def/".$lang_db."/feriados.tab";
	$arreglo=file($file);
	$arreglo2 = $arreglo[$mes];
	$tferi = " ";
	$arreglo2 = substr($arreglo[$mes],$dia-1,1);
	if($arreglo2=="F"){
			$tferi="CHECKED";
	}

	return $tferi;
}
//funcion que devuelve el último día de un mes y año dados
function ultimoDia($mes,$ano){
    $ultimo_dia=28;
    while (checkdate($mes,$ultimo_dia + 1,$ano)){
       $ultimo_dia=$ultimo_dia+1;
    }
    return $ultimo_dia;
}


function mostrar_calendario($mes,$ano){
global $arrHttp,$msgstr;

	echo"<form name=tabla  method=post action=calendario.php>";
	echo "<input type=hidden name=cadena value=''>";

	echo "<input type=hidden name=mes value=''>";
	echo "<input type=hidden name=ano value=''>";
	echo "<input type=hidden name=mes_guarda value=".$mes.">";
	echo "<input type=hidden name=lista value=Calendario>";
	echo "<input type=hidden name=Opcion>";

	//tomo el nombre del mes que hay que imprimir
	$nombre_mes=$msgstr["m".$mes];
	echo "<center><br><font class=td5a> &nbsp; &nbsp;  &nbsp; &nbsp; ".$msgstr["holydays"]."&nbsp; &nbsp;  &nbsp; &nbsp; </font><br>";
	//construyo la cabecera de la tabla
    echo "<table width=200 cellspacing=3 cellpadding=2 border=0><tr><td colspan=7 align=center class=tit>";
	echo "<table width=100% cellspacing=2 cellpadding=2 border=0><tr><td align=center class=tit2>";
	//calculo el mes y ano del mes anterior
	$mes_anterior = $mes - 1;
	$ano_anterior = $ano;
	if ($mes_anterior==0){
		$ano_anterior--;
		$mes_anterior=12;
	}
	echo "<input type=hidden name=mes_ante value=".$mes_anterior.">";
	echo "<input type=hidden name=ano_ante value=".$ano_anterior.">";
	echo "<input type=button name=anterior value='&lt;&lt;' onClick=JavaScript:Dias_Fe(1)></td>";
	   echo "<td align=center class=tit2>$nombre_mes $ano</td>";
	   echo "<td align=center class=tit2>";
	//calculo el mes y ano del mes siguiente
	$mes_siguiente = $mes + 1;
	$ano_siguiente = $ano;
	if ($mes_siguiente==13){
		$ano_siguiente=$ano_siguiente+1;
		$mes_siguiente=1;
	}
	echo "<input type=hidden name=mes_sig value=".$mes_siguiente.">";
	echo "<input type=hidden name=ano_sig value=".$ano_siguiente.">";
	echo "<input type=button name=siguiente value='&gt;&gt;' onClick=JavaScript:Dias_Fe(2)></td></tr></table></td></tr>";
	echo '	<tr>
			    <td width=14% align=center class=altn>'.$msgstr["d1"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d2"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d3"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d4"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d5"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d6"].'</td>
			    <td width=14% align=center class=altn>'.$msgstr["d7"].'</td>
			</tr>';

	//Variable para llevar la cuenta del dia actual
	$dia_actual = 1;

	//calculo el numero del dia de la semana del primer dia
	$numero_dia = calcula_numero_dia_semana(1,$mes,$ano);
	//echo "Numero del dia de demana del primer: $numero_dia <br>";

	//calculo el último dia del mes
	$ultimo_dia = ultimoDia($mes,$ano);

	//escribo la primera fila de la semana
	echo "<tr>";
	for ($i=0;$i<7;$i++){
		if ($i < $numero_dia){
			//si el dia de la semana i es menor que el numero del primer dia de la semana no pongo nada en la celda
			echo "<td bgcolor=#B0D1EF> &nbsp;</td>";
		} else {
			echo "<td align=center bgcolor=#B0D1EF class=td><INPUT type=checkbox name=dias ".dia_feri($dia_actual,$mes).">$dia_actual</td>";
			$dia_actual=$dia_actual+1;
		}
	}
	echo "</tr>";

	//recorro todos los demás días hasta el final del mes
	$numero_dia = 0;
	while ($dia_actual <= $ultimo_dia){
		//si estamos a principio de la semana escribo el <TR>
		if ($numero_dia == 0)
			echo "<tr>";
		echo "<td align=center bgcolor=#B0D1EF class=td><INPUT type=checkbox name=dias ".dia_feri($dia_actual,$mes).">$dia_actual</td>";
		$dia_actual=$dia_actual+1;
		$numero_dia=$numero_dia+1;
		//si es el uñtimo de la semana, me pongo al principio de la semana y escribo el </tr>
		if ($numero_dia == 7){
			$numero_dia = 0;
			echo "</tr>";
		}
	}

	//compruebo que celdas me faltan por escribir vacias de la última semana del mes
	for ($i=$numero_dia;$i<7;$i++){
		echo "<td></td>";
	}

	echo "</tr>";
	echo "</table>";
	echo "</form>";
}

function formularioCalendario($mes,$ano){
global $msgstr;
echo '
	<table align="center" cellspacing="2" cellpadding="2" border="0">
	<tr><form action="index.php" method="POST">';
echo '
    <td align="center" valign="top">
		".$msgstr["mes"].": <br>
		<select name=nuevo_mes>
		<option value="1"';
if ($mes==1)
 echo "selected";
echo'>'.$msgstr["m01"].'
		<option value="2" ';
if ($mes==2)
	echo "selected";
echo'>'.$msgstr["m02"].'
		<option value="3" ';
if ($mes==3)
	echo "selected";
echo'>'.$msgstr["m03"].'
		<option value="4" ';
if ($mes==4)
	echo "selected";
echo '>'.$msgstr["m04"].'
		<option value="5" ';
if ($mes==5)
		echo "selected";
echo '>'.$msgstr["m05"].'
		<option value="6" ';
if ($mes==6)
	echo "selected";
echo '>'.$msgstr["m06"].'
		<option value="7" ';
if ($mes==7)
	echo "selected";
echo '>'.$msgstr["m07"].'
		<option value="8" ';
if ($mes==8)
	echo "selected";
echo '>'.$msgstr["m08"].'
		<option value="9" ';
if ($mes==9)
	echo "selected";
echo '>'.$msgstr["m09"].'
		<option value="10" ';
if ($mes==10)
	echo "selected";
echo '>'.$msgstr["m10"].'
		<option value="11" ';
if ($mes==11)
	echo "selected";
echo '>'.$msgsr['m11'].'
		<option value="12" ';
if ($mes==12)
    echo "selected";
echo '>'.$msgstr["m12"].'

		</select>
		</td>';
echo '
	    <td align="center" valign="top">
		'.$msgstr["ano"].': <br>
		<select name=nuevo_ano>
		<option value="2000" ';
if ($ano==2000)
   echo "selected";
echo' >2000
		<option value="2001" ';
if ($ano==2001)
 echo "selected";
echo '>2001
		<option value="2002" ';
if ($ano==2002)
   echo "selected";
echo '>2002
		<option value="2003" ';
if ($ano==2003)
   echo "selected" ;
echo '>2003
		<option value="2004" ';
if ($ano==2004)
   echo "selected" ;
echo '>2004
	</select>
		</td>';
echo '
	</tr>
	<tr>
	    <td colspan="2" align="center"><input type="Submit" value="IR A"></td>
	</tr>
	</table><br>

	<br>

	</form>';
}

function Calendario($tipo_lis){
global $arrHttp,$db_path;

	$mes_guarda="";
	$mes=$arrHttp["mes"];
	$cadena=$arrHttp["cadena"];
	if (isset($arrHttp["mes_guarda"])) $mes_guarda = $arrHttp["mes_guarda"];
	$ano =$arrHttp["ano"];
	$txtnuevo=" ";
	$arreglo=$db_path."circulation/def/".$_SESSION["lang"]."/".$tipo_lis;
	if (!file_exists($arreglo))  $arreglo=$db_path."circulation/def/".$lang_db."/".$tipo_lis;
	$arreglo = file($arreglo);
	$max=count($arreglo);
	$txtnuevo  = $arreglo[0];
	for ($i=1;$i<13;$i++){
		if ($mes_guarda==$i){
		  	if (trim($cadena)<>""){
		  		$arreglo2 = explode("|",$cadena);
				$tco = 0;
				for($k=0;$k<31;$k++){
		  	   		for ($j=0; $j < count($arreglo2);$j++){
			        	$tco = $k+1;
				   		if ($arreglo2[$j] == $tco){
							 $tvalor="F";
							 break;
						}else{
							 $tvalor=" ";
						}

			   		}
					$txtnuevo .=$tvalor;
		  		}
            	$txtnuevo .="\n";
		  	}else{
		  		$txtnuevo .= str_repeat(" ",31)."\n";
		  	}
		}else{
			  $txtnuevo .=$arreglo[$i];
		}
	}

	//echo $txtnuevo."<br>";//
	$Tabre = fopen($db_path."circulation/def/".$_SESSION["lang"]."/feriados.tab", "w+");//
	fwrite($Tabre,$txtnuevo);
	fclose($Tabre);
	$cadena=" ";


	if ($mes=="" and $ano==""){
		$tiempo_actual = time();
		$mes = date("n", $tiempo_actual);
		$ano = date("Y", $tiempo_actual);
	}
	//else {//
	//	$mes = $nuevo_mes;//
	//	$ano = $nuevo_ano;//
	//}//


	if (!isset($arrHttp["Opcion"])){
		echo"<center>";
		mostrar_calendario($mes,$ano);
		echo"</center>";
	}else{
		header("Location:configure_menu.php?encabezado=s");
	}


//formularioCalendario($mes,$ano);//

}