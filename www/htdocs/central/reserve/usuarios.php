<?php
session_start();
if (!isset($_SESSION["login"])){	echo "La sesión expiró o Ud. no tiene permiso para entrar en este módulo";
	die;}
include("../common/get_post.php");
include("../config.php");
$usuarios_re=Array();
echo $db_path."  ".$_SESSION["lang"];
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
$ixusers_re=-1;
if (file_exists($archivo)){	$fp=file($archivo);
	foreach ($fp as $linea){		$ixusers_re++;		$usuarios_re[]=$linea;	}}
$users_tab=array();
$col_size=array();
$i=0;
$ixFdt=-1;
include("../common/header.php");
?>
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

function DrawElement(ixE,sel_ind){
	xhtml="<tr><td bgcolor=white align=center valign=top><select name=sel_text style='width:150px'>\n<option></option>"
	option=fields.split('||')
	ixact=0
	for (var opt in option){		ixact++
		o=option[opt].split('$$$')
		xhtml+="<option value=\""+o[0]+"\""
		if (sel_ind>-1){			if (ixact==sel_ind) xhtml+=" selected"		}
		xhtml+=">"+o[1]+"</option>\n";
	}
	xhtml+="</select>";
	xhtml+="&nbsp;<a href=javascript:DeleteElement("+ixE+") class=boton>Eliminar</a></td></tr>"
    return xhtml
}

function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table width=800 class=listTable border=0>"
	Ctrl=eval("document.stats.sel_text")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.stats.sel_text[ix].selectedIndex=0
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_seltext=document.stats.sel_text[i].selectedIndex
				ixE++
				html=DrawElement(ixE,Ctrl_seltext)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec+"</table>"
	}

}



function AddElement(){
	seccion=returnObjById( "rows" )
	html="<table width=400 class=listTable border=0>"
	Ctrl=eval("document.stats.sel_text")
	if (Ctrl){
		if (Ctrl.length){
			ixLength=Ctrl.length
			last=ixLength-1
	        if (!ixLength) ixLength=1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	ixSel=document.stats.sel_text[ia].selectedIndex
			    	xhtm=DrawElement(ia,ixSel)
			    	html+=xhtm
			    }
		    }
		 }
	 }else{
		ia=0
	 }
	nuevo=DrawElement(ia,-1)
	seccion.innerHTML = html+nuevo+"</table>"
}

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA
function Guardar(){
	ValorCapturado=""
	total=document.stats.sel_text.length
	for (i=0;i<total;i++){		ix_sel=document.stats.sel_text[i].selectedIndex
		if (ix_sel>0){			op_1=document.stats.sel_text[i].options[ix_sel].value
			ValorCapturado+=op_1+"\n"		}
	}
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()
}

</script>
<?
//SE FORMA LA LISTA CON LOS TIPOS DE USUARIO
echo "<script>\n";
$fields="";
foreach ($usuarios_re as $linea){	if (trim($linea)!=""){		$fields.=trim($linea)."||";	}}
echo "fields=\"$fields\"\n";
echo "</script>\n</head>\n";
echo "<body>";
echo "<form name=stats method=post>";
echo "<br><Center><span class=titulo1>Administracion de políticas de reserva</span>
<p>Seleccione los tipos de usuario que tienen acceso al servicio de reserva";
echo "<div id=rows>";
//SE CREA EL SELECT CON LOS TIPOS DE USUARIO DEFINIDOS Y YA EXISTENTES
echo $ixusers_re;
echo "<table width=400>";
$ix=-1;

if (count($usuarios_re)>0){
	for ($i=0;$i<=$ixusers_re;$i++) {
		reset($usuarios_re);
		echo "<tr><td bgcolor=white align=center valign=top><select name=sel_text style='width:150px'><option></option>\n";		foreach ($usuarios_re as $value) {			$value=trim($value);
			if ($value!=""){
				$ix++;
				$total=$ix;

				$o=explode('|',$value);
				$xselected="";
				if ($o[0]==$value)
					$xselected=" selected";
				echo "<option value=\"".$o[0]."\" $xselected>".$o[1]."</option>\n";
			}
		}
		echo "</select>";
	}
}
if ($ix<1){
 		$ix++;
 		$total++;
 		for ($ix=$ix;$ix<2;$ix++){
		 	echo "<tr><td bgcolor=white align=center valign=top><select name=sel_text style='width:150px' ><option></option>\n";
		 	$f=explode('||',$fields);
			foreach ($f as $opt) {
				$o=explode('|',$opt);
				echo "<option value=\"".$o[0]."\" >".$o[1]."</option>\n";
			}
		 	echo "</select>";
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
		<a href="javascript:Guardar()" class=boton>Guardar</a>
	</td>
	<td align=center>
		<a href=inicio.php?Opcion=continuar  class=boton>Menú</a>
	</td>
</table>
</form>
<form name=enviar method=post action=usuarios_guardar.php>
<input type=hidden name=ValorCapturado>
</center>
</html>