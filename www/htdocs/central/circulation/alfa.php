<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      alpa.php
 * @desc:      Alphabetic list of an selected field for capturing the record
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
global $REQUEST_METHOD, $HTTP_POST_VARS, $HTTP_GET_VARS;
session_start();
include("../common/get_post.php");
include ("../config.php");
$fp=file($db_path.$arrHttp["base"]."/".$arrHttp["base"].".fdt");
foreach($fp as $value) {	$f=explode('|',$value);
	if ($f[3]==1){		if (substr($f[13],0,1)!="@")			$arrHttp["formato_e"]=$f[13]."'$$$'f(mfn,1,0)";
		else
			$arrHttp["formato_e"]=$f[13];	}}
$arrHttp["formato_e"]=stripslashes($arrHttp["formato_e"]);
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (!isset($arrHttp["tagfst"])) $arrHttp["tagfst"]="";
if (!isset($arrHttp["delimitador"]))$arrHttp["delimitador"]="";
if (!isset($arrHttp["Tag"]))$arrHttp["Tag"]="";
if (!isset($arrHttp["prefijo"]))$arrHttp["prefijo"]="";
if (!isset($arrHttp["capturar"]))$arrHttp["capturar"]="";
if (!isset($arrHttp["capturar"]))$arrHttp["capturar"]="";
if (!isset($arrHttp["pref"]))$arrHttp["pref"]=$arrHttp["prefijo"];
  	$query = "?xx=".$arrHttp["base"] ."&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=autoridades"."&tagfst=".$arrHttp["tagfst"]."&prefijo=".$arrHttp["prefijo"]."&pref=".$arrHttp["pref"]."&formato_e=".urlencode($arrHttp["formato_e"]);
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='.$query);
	$contenido="";

	exec("\"".$Wxis."\" IsisScript=$xWxis/ifp.xis ",$contenido);
	//foreach ($contenido as $value) echo "$value<br>";
	$contenido = array_unique ($contenido);
	echo "<html>
		<Title>Lista alfabética</title>
		<link rel=stylesheet href=../css/styles.css type=text/css>
		<script languaje=Javascript>
		document.onkeypress =
  			function (evt) {
    			var c = document.layers ? evt.which
            		: document.all ? event.keyCode
            		: evt.keyCode;
    			return true;
  		}
		var nav4 = window.Event ? true : false;

		function codes(e) {
  			if (nav4) // Navigator 4.0x
    			var whichCode = e.which

			else // Internet Explorer 4.0x
    			if (e.type == 'keypress') // the user entered a character
     				 var whichCode = e.keyCode
    			else
      				var whichCode = e.button;
  			if (e.type == 'keypress' && whichCode==13)
				IrA()
  			else
				if (whichCode==13) IrA()
		}
		\n";
	echo "Separa=\"".$arrHttp["delimitador"]."\"\n";
	echo "Tag=\"".$arrHttp["Tag"]."\"\n";
	echo "Prefijo=\"".$arrHttp["prefijo"]."\"\n";
?>
	function ObtenerTerminos(){		Seleccion=""
		icuenta=0
		i=document.Lista.autoridades.selectedIndex
		for (i=0;i<document.Lista.autoridades.options.length; i++){
			if (document.Lista.autoridades.options[i].selected){
				icuenta=icuenta+1
				if (Seleccion=="")
					Seleccion=document.Lista.autoridades.options[i].value
				else
					Seleccion=Seleccion+Separa+document.Lista.autoridades.options[i].value
			}

		}
		if (Seleccion!=""){

			db="<?php echo $arrHttp["base"]?>"
			pref="<?php echo $arrHttp["pref"]?>"
    		cipar="<?php echo $arrHttp["cipar"]?>"
 <?
 			if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]!=""){ 				echo "top.xeditar=\"S\"\n";
				echo 'parent.main.location="fmt.php?xx=xx&base='.$_SESSION["base"]."&cipar=".$_SESSION["cipar"].'&basecap="+db+"&ciparcap="+cipar+"&Mfn="+Seleccion+"&Opcion=captura_bd&ver=S&capturar=S"'."\n";
			}else{
				echo 'window.opener.top.main.location.href="fmt.php?cc=xx&base="+db+"&cipar="+cipar+"&Mfn="+Seleccion+"&Opcion=leer&ver=S&Formato=ALL"+db'."\n";
			}
?>
		}
	}

function Continuar(){
	i=document.Lista.autoridades.length-1
	a=document.Lista.autoridades[i].text
	AbrirIndice(a)
}

function IrA(ixj){
	a=document.Lista.ira.value
	AbrirIndice(a)
}

<?
echo "function AbrirIndice(Termino){
    	db='".$arrHttp["base"]."'
    	cipar='".$arrHttp["cipar"]."'

		Pref='".$arrHttp["pref"]."'
		Prefijo=Pref+Termino
		capturar='".$arrHttp["capturar"]."'

		if (capturar!='') capturar='&capturar='+capturar

		self.location.href='alfa.php?&opcion=autoridades&base='+db+'&cipar='+cipar+'&pref='+Pref+'&prefijo='+Prefijo+capturar+'&formato_e=".urlencode($arrHttp["formato_e"])."'
	}

</script>\n";
?>
	<body bgcolor=#ffffff LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0",MARGINHEIGHT=0 onblur=self.close()>

	<center>
	<table cellpadding=0 cellspacing=0 border=2 width=100% height=80%>
	<form method=post name=Lista onSubmit="javascript:return false">

	<td  bgcolor=gold width=5% align=center><font size=1 face="verdana"><?php for ($i=65;$i<91;$i++ ) echo "<a href=javascript:AbrirIndice('".chr($i)."')>".chr($i)."</a><br>"?></td>
	<td width=95% valign=top>
	<Select name=autoridades multiple size=30 style="width:450px; height=100%" onchange=ObtenerTerminos()>
<?

	foreach ($contenido as $linea){
		if (trim($linea)!=""){
			$f=explode('$$$',$linea);

		//	if (substr($f[1],0,strlen($arrHttp["pref"]))!=$arrHttp["pref"]) break;
			echo "<option value=".$f[1].">".$f[0];
		}
	}

?>
	</select></td>

	</table>
	<table cellpadding=0 cellspacing=0 border=0 width=100%  height=20% bgcolor=gold>
		<td valign=top><a href=Javascript:Continuar()><img src=img/b_continuar.gif border=0></a></td>
		<td valign=top class=menusec2>Ir a: <input type=text name=ira size=15 value="" onKeyPress="codes(event)" ><a href=Javascript:IrA()><img src=img/b_ir.gif border=0 align=ABSBOTTOM></a></td>
	</table>
	</form></body></html>
