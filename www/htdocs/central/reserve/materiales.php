<?php
session_start();
if (!isset($_SESSION["login"])){	echo "La sesión expiró o Ud. no tiene permiso para entrar en este módulo";
	die;}
include("../common/get_post.php");
include("../config.php");
$materiales_re=Array();
if (file_exists($db_path."/reserva/tablas/materiales.tab")){	$fp=file($db_path."/reserva/tablas/materiales.tab");
	foreach ($fp as $linea){		$materiales_re[]=$linea;	}}
$i=0;
$ixFdt=-1;
?>
<html>
	<head>
		<title>ABCD</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Language" content="pt-br" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
		<link rel="stylesheet" rev="stylesheet" href="../common/css/styles.css" type="text/css" media="screen"/>
        <script src=../common/js/lr_trim.js></script>
<script languaje=javascript>

//LLEVA LA CUENTA DE VARIABLES AGREGADAS A LA LISTA
ix=-1
total=0

//PARA AGREGAR NUEVAS VARIABLES A LA LISTA
function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function DrawElement(ixE,val_cod,val_desc){
	xhtml="<tr><td bgcolor=white align=center valign=top>"
	xhtml+="<span class=etiqueta>Código:</span> <input type=text name=codigo size=20 value=\""+val_cod+"\">"
	xhtml+=" <span class=etiqueta>Descripción:</span> <input type=text name=descripcion size=50 value=\""+val_desc+"\">"
	xhtml+="\n";
	xhtml+="&nbsp;<a href=javascript:DeleteElement("+ixE+") class=boton>Eliminar</a></td></tr>"
    return xhtml
}

function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table width=800 class=listTable border=0>"
	Ctrl=eval("document.stats.codigo")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.stats.codigo[ix].value=""
		document.stats.descripcion[ix].value=""
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_cod=document.stats.codigo[i].value
				Ctrl_desc=document.stats.descripcion[i].value
				ixE++
				html=DrawElement(ixE,Ctrl_cod,Ctrl_desc)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec+"</table>"
	}

}



function AddElement(){
	seccion=returnObjById( "rows" )
	html="<table border=0>"
	Ctrl=eval("document.stats.codigo")
	if (Ctrl){
		if (Ctrl.length){
			ixLength=Ctrl.length
			last=ixLength-1
	        if (!ixLength) ixLength=1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	val_codigo=document.stats.codigo[ia].value
			    	val_descripcion=document.stats.descripcion[ia].value
			    	xhtm=DrawElement(ia,val_codigo,val_descripcion)
			    	html+=xhtm
			    }
		    }
		 }
	 }else{
		ia=0
	 }
	nuevo=DrawElement(ia,"","")
	seccion.innerHTML = html+nuevo+"</table>"
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA
function Guardar(){
	ValorCapturado=""
	total=document.stats.codigo.length
	for (i=0;i<total;i++){		val_cod=Trim(document.stats.codigo[i].value)
		val_desc=Trim(document.stats.descripcion[i].value)
		if (val_cod=="" && val_desc==""){			continue		}else{			if (val_cod=="" || val_desc==""){				alert("Debe indicar el tipo de material y la descripción")
				return			}		}
		ValorCapturado+=val_cod+"|"+val_desc+"\n"	}
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()
}

</script>
<?
//SE FORMA LA LISTA CON LOS TIPOS DE USUARIO
echo "<script>\n";
$fields="";
foreach ($materiales_re as $linea){	$x=explode('|',$linea);
	$fields.=trim($x[0])."|".trim($x[1])."||";
}
echo "fields=\"$fields\"\n";
echo "</script>\n</head>\n";
echo "<body>";
echo "<form name=stats method=post>";
echo "<br><Center><span class=titulo1>Administracion de políticas de reserva</span>
<p>Indique los tipos de material que se pueden reservar";
echo "<div id=rows>";
//SE CREA EL SELECT CON LOS TIPOS DE USUARIO DEFINIDOS Y YA EXISTENTES
echo "<table>";
$ix=-1;
if (count($materiales_re)>0){
	foreach ($materiales_re as $value) {		$value=trim($value);
		if ($value!=""){
			$ix++;
			$total=$ix;
			echo "<tr><td bgcolor=white align=center valign=top>\n";
			$o=explode('|',$value);
			echo "<span class=etiqueta>Código:</span> <input name=codigo size=20 value=\"".$o[0]."\">";
			echo " <span class=etiqueta>Descripción:</span> <input type=text size=50 name=descripcion value=\"".$o[1]."\">";
			echo "&nbsp;<a href=javascript:DeleteElement(".$ix.") class=boton>Eliminar</a></td></tr>\n";
		}
	}

}
if ($ix<1){
 		$ix++;
 		$total++;
 		for ($ix=$ix;$ix<2;$ix++){
		 	echo "<tr><td bgcolor=white align=center valign=top>";
			echo "<span class=etiqueta>Código: </span><input name=codigo size=20 value=\"\">";
			echo " <span class=etiqueta>Descripción:</span> <input type=text size=50 name=descripcion value=\"\">";
		 	echo "&nbsp;<a href=javascript:DeleteElement(".$ix.") class=boton>Eliminar</a></td></tr>\n";
	   	}
	}
?>
</table>
</div>
<p>
<table width=500>
	<td align=center>
		<a href="javascript:AddElement('rows')" class=boton>Agregar</a>
	</td>
	<td align=center>
		<a href="javascript:Guardar() class=boton>Guardar</a>
	</td>
	<td align=center>
		<a href=inicio.php?Opcion=continuar class=boton>Menú</a>
	</td>
</table>
</form>
<form name=enviar method=post action=materiales_guardar.php>
<input type=hidden name=ValorCapturado>
</center>
</html>