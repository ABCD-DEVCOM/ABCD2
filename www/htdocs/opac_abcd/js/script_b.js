accion=""

function showhide(what,what2){
	var what = document.getElementById(what);
	if (what.style.display=="none"){
		what.style.display="inline";
		if (arguments.length>1){			what2.src="../images/buttonm.gif"
		}
	}else{
		what.style.display="none"
		if (arguments.length>1){
			what2.src="../images/buttonp.gif"
		}
		//document.getElementById(what2).src=Open.src
	}
}

function ProximaPagina(pagina,registro){	document.continuar.desde.value=registro
	document.continuar.pagina.value=pagina
	document.continuar.submit()}

function VerExistencias(base,kardex,inventario_r,inventario_k){	document.continuar.existencias.value=base+"|"+kardex+"|"+inventario_r+"|"+inventario_k
	document.continuar.action="existencias.php"
	document.continuar.submit()}


function BuscarBase(base){
	document.buscar.action="buscar_integrada.php"
	document.buscar.base.value=base
	document.buscar.desde.value=1
	document.buscar.count.value=25
	document.buscar.resaltar.value="S"
	document.buscar.Expresion.value=Expresion
	document.buscar.Opcion.value="integrada"
	document.buscar.submit()

}

function ProximaBase(base){
	document.buscar.action="buscar_integrada.php"
	document.buscar.desde.value=1
	document.buscar.base.value=base
	document.buscar.pagina.value=1
	document.buscar.facetas.value=""
	document.buscar.Formato.value=""
	document.buscar.submit()
}

function CambiarFormato(){	Ctrl=document.getElementById("cambio_Pft")	ix=Ctrl.selectedIndex
	Formato=Ctrl.options[ix].value
	document.continuar.Formato.value=Formato
	document.continuar.desde.value=1
	document.continuar.submit()
}

 function AbrirIndice(Letra){
  	document.diccionario.IR_A.value=Letra
  	NavegarDiccionario(this,3)
  }

function ObtenerTerminos(desde){
	Expresion=""
	Ctrl=eval("document.diccionario."+desde)	ix=Ctrl.options.length
	if (Opcion=='libre')
		delimitador='"'
	else
		delimitador='"'
	for (i=0;i<ix;i++){
		if (Ctrl.options[i].selected || desde=="TerminosSeleccionados"){
			if (Expresion=="")
				Expresion=delimitador+Ctrl.options[i].value+delimitador
			else
				Expresion+=" "+delimitador+Ctrl.options[i].value+delimitador
		}
	}
	return Expresion
}


function CancelarDiccionario(retorno){
	switch (retorno){		case 'A':
			document.diccionario.action="avanzada.php"
			document.diccionario.submit()
			break
		case 'B':
			document.diccionario.action="otras_busquedas.php"
			document.diccionario.submit()
			break;
		case 'C':
			document.diccionario.action="avanzada.php"
			document.diccionario.submit()
			break
		case 'D':
			document.diccionario.action="buscar_integrada.php"
			document.diccionario.submit()
			break
		default:
			document.diccionario.action=retorno
			document.diccionario.submit()	}
}

function EjecutarBusquedaDiccionario(Accion){
	Expresion=""
	Seleccionados=ObtenerTerminos("TerminosSeleccionados")
	if (Seleccionados==""){
		alert(msgstr["sel_term"])
		return false
	}
	Expresion=Seleccionados
	document.diccionario.Seleccionados.value=Expresion;
	switch (Accion){
		case 0:
			document.diccionario.Opcion.value="buscar_diccionario"
			document.diccionario.Sub_Expresion.value=Expresion;
			document.diccionario.action="buscar_integrada.php"
			break
		case 1:
			document.diccionario.action="buscar_integrada.php"
			break
		case 2:
			document.diccionario.action="avanzada.php"
			break	}
	document.diccionario.submit()
}

function NavegarDiccionario(F,desde){	Seleccionados=""
 	Seleccionados=ObtenerTerminos("TerminosSeleccionados")
 	if (Seleccionados!=""){ 		document.diccionario.Seleccionados.value=Seleccionados
 	}
	switch (desde){
		case 4:
/* Más términos */
			document.diccionario.Navegacion.value="mas terminos"
			document.diccionario.submit()
			break
		case 3:
/* Ir a */
			document.diccionario.Navegacion.value="ir a"
			document.diccionario.LastKey.value=document.diccionario.IR_A.value
			document.diccionario.submit()
			break
	}
}



function BuscarPalabrasSide(){
	if (Trim(document.side.Expresion.value)=="")
		return
	document.side.submit()
}

function BuscarPalabrasTope(){
	if (Trim(document.SearchTope.Expresion.value)=="")
		return
	document.SearchTope.submit()
}

function Buscar(Ctrl){
	ix=Ctrl.selectedIndex
	document.buscar.Expresion.value=Ctrl.options[ix].value
	document.buscar.desde.value=1
	document.buscar.action="buscar_integrada.php"
	document.buscar.submit()
	Ctrl.selectedIndex=0
}

function CRUZARD(Prefijo,Termino,base){
	document.buscar.Expresion.value=""
	document.buscar.action="buscar_integrada.php"
	//document.buscar.base.value=""
	document.buscar.desde.value=1
	document.buscar.count.value=25
	document.buscar.resaltar.value="S"
	document.buscar.Opcion.value="detalle"
	document.buscar.prefijo.value=Prefijo
	document.buscar.Sub_Expresion.value=Termino
	document.buscar.submit()}

//BUSQUEDA AVANZADA

Expresion=""
Operadores=""
Campos=""
function LimpiarBusqueda() {
  for (i=0; i<document.forma1.camp.length; i++){
      document.forma1.Sub_Expresiones[i].value=""
      }
}

function BusquedaAvanzada(){
	document.diccio.action="avanzada.php"
    document.diccio.Opcion.value="integrada"
	document.diccio.submit()
}


function DiccionarioLibre(Nivel){
	ix=document.getElementById(document.libre.coleccion)
	if (ix!=null){
		Ctrl=document.libre.coleccion
		ixc=Ctrl.length
		colec=""
		if (ixc){			for (i=0;i<ixc;i++){				if (Ctrl[i].checked){					colec=Ctrl[i].value
					break				}
			}		}

		if (colec!=""){			document.diccio_libre.coleccion.value=colec
		}
	}
	if (document.getElementById('and').checked)
		document.diccio_libre.alcance.value=document.getElementById('and').value
	else
		document.diccio_libre.alcance.value=document.getElementById('or').value
	document.diccio_libre.submit()}

function Diccionario(jx){
    j=document.forma1.Sub_Expresiones.length
    if (j==undefined)
    	j=document.forma1.camp.selectedIndex
    else
		j=document.forma1.camp[jx].selectedIndex

	a=dt[j]
	diccio=a.split('|')
	nombrec=diccio[0]
	prefijo=diccio[2]
	ArmarBusqueda()
	document.diccio.Sub_Expresion.value=Expresion
	document.diccio.Campos.value=Campos
	document.diccio.Operadores.value=Operadores
	document.diccio.campo.value=escape(nombrec)
	document.diccio.prefijo.value=prefijo
	document.diccio.Diccio.value=jx
	document.diccio.submit()

}

function ArmarBusqueda(){    Expresion=""
	Operadores=""
	Campos=""
	se = document.getElementById('tag900_0_n');
	j=document.forma1.Sub_Expresiones.length
	if (j==undefined){
		Expresion=document.forma1.Sub_Expresiones.value
		ixSel=document.forma1.camp.selectedIndex
		cc=document.forma1.camp.options[ixSel].value
		Campos=cc
		Operadores=""
		return	}
	for (i=0;i<j;i++){
		if (document.forma1.Sub_Expresiones[i].value=="") document.forma1.Sub_Expresiones[i].value=" "
		if (Expresion==""){
			Expresion=document.forma1.Sub_Expresiones[i].value+" ~~~ "
		}else{
			Expresion=Expresion+document.forma1.Sub_Expresiones[i].value+" ~~~ "
		}

		ixSel=document.forma1.camp[i].selectedIndex
		cc=document.forma1.camp[i].options[ixSel].value
		if (Campos==""){
			Campos=cc
		}else{
			Campos=Campos+" ~~~ "+cc
		}
		if (i<j-1){			icampo=document.getElementById('oper_'+i)
			if (icampo.type=="select-one"){
				ixSel=document.forma1.oper[i].selectedIndex
				cc=document.forma1.oper[i].options[ixSel].value
				if (Operadores==""){
					Operadores=cc
				}else{
					Operadores=Operadores+" ~~~ "+cc
				}
			}
		}
	}}

function PrepararExpresion(Destino){
//	AbrirVentanaResultados()

	ArmarBusqueda()
	if (Expresion==""){
		alert(msgstr["miss_se"])
		return
	}else{
		document.diccio.Campos.value=Campos
	}
	var mensajes = document.getElementById("mensajes");
	mensajes.innerHTML="<img src=../images/loading.gif>"
	document.diccio.Sub_Expresion.value=Expresion
	document.diccio.Operadores.value=Operadores
	document.diccio.action="buscar_integrada.php"
	document.diccio.submit()
}

//GALERIA DE IMAGENES

function Presentacion(base,Expresion,Pagina,Formato){
	if (document.getElementById("desde")){
		desde=document.continuar.desde.value-document.continuar.count.value
		if (desde<=0) desde=1
		document.buscar.desde.value=desde
	}
	document.buscar.base.value=base
	document.buscar.pagina.value=Pagina
	switch (Formato){		case "galeria":
			document.buscar.action="slide_integrada.php";
			break
		case "ficha":
			document.buscar.action="buscar_integrada.php";
			break	}
	//document.buscar.Opcion.value="integrada"
	document.buscar.Expresion.value=Expresion
	document.buscar.submit()

}

var i = 0;
iactual=0;
var image = new Array();
var link= new Array();
var titulo= new Array()
var ficha=new Array()

var k = image.length-1;

/*
function ProximaImagen(){
	iactual=iactual+1
	if (iactual>=image.length) iactual=0
	swapImage(iactual)

}

function AnteriorImagen(){
	iactual=iactual-1
	if (iactual<0) iactual=0
	swapImage(iactual)

}

function swapImage(i){
	iactual=i;
	var el = document.getElementById("mydiv");
	el.innerHTML=titulo[i];
	var img = document.getElementById("slide");
	img.src= image[i];
	var a = document.getElementById("link");
	a.href= link[i];
	var gal = document.getElementById("galeria");
	gal.innerHTML=ficha[i];
}
*/

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else  {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

addLoadEvent(function() {
		//swapImage(0);
	}
);

function ActivarIndice(titulo,columnas,Opcion,count,posting,prefijo,base){	document.activarindice.titulo.value=titulo
	document.activarindice.columnas.value=columnas
	document.activarindice.Opcion.value=Opcion
	document.activarindice.count.value=count
	document.activarindice.posting.value=posting
	document.activarindice.prefijo.value=prefijo
	document.activarindice.base.value=base
	document.activarindice.submit()}

function ValidarUsuario(){
	if (Trim(document.estado_de_cuenta.usuario.value)==""){		alert("Debe ingresar su código de usuario")
		return	}
	document.estado_de_cuenta.submit()}

/* Marcado y presentación de registros*/
function getCookie(cname) {
    var name = cname+"=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function Seleccionar(Ctrl){
	cookie=getCookie('ORBITA')
	if (Ctrl.checked){
		if (cookie!=""){
		    c=cookie+"|"			if (c.indexOf(Ctrl.name+"|")==-1)				cookie=cookie+"|"+Ctrl.name		}else{			cookie=Ctrl.name		}
	}else{
		sel=Ctrl.name+"|"
		c=cookie+"|"
		n=c.indexOf(sel)
		if (n!=-1){			cookie=cookie.substr(0,n)+ cookie.substr(n+sel.length)		}
	}
	document.cookie="ORBITA="+cookie
	Ctrl=document.getElementById("cookie_div")
	Ctrl.style.display="inline-block"
}

function delCookie(){
	for (var i = 0; i < document.continuar.elements.length; i++){
    	element = document.continuar.elements[i];
    	switch (element.type){
      	case 'checkbox':
      		element.checked=false
        	break;
  		}
	}
  	document.cookie =  'ORBITA=;';
	alert (msgstr["no_rsel"])
	Ctrl=document.getElementById("cookie_div")
	Ctrl.style.display="none"

}


function showCookie(cname){	cookie=getCookie(cname)
	if (cookie==""){		alert(msgstr["rsel_no"])
		return	}
	alert(document.buscar.lang.value)
    document.buscar.action="presentar_seleccion.php"
	document.buscar.cookie.value=cookie

	document.buscar.submit()}

function SendTo(Accion,Data){
	switch (Accion){		case "word":
			document.buscar.action="sendtoword.php"
			break
		case "print_one":
			document.buscar.action="presentar_seleccion.php"
			break
		case "mail_one":
			document.buscar.action="presentar_seleccion.php"
			break
		case "reserve_one":
		    if (WEBRESERVATION!="Y"){		    	alert(msgstr["reserv_no"])
		    	return
		    }
			document.buscar.action="presentar_seleccion.php"
			break
		case "xml":
			document.buscar.action="sendtoxml.php"
			document.buscar.target="_blank"
			break	}
    document.buscar.Accion.value=Accion
	document.buscar.cookie.value=Data
	document.buscar.submit()
}

function ChangeLanguage(){
	var lang = document.getElementById("lang");
	langcode=lang.options[lang.selectedIndex].value
	for (i=0;i<document.forms.length;i++){		document.forms[i].lang.value=langcode	}

	document.changelanguage.action=actualScript
	document.changelanguage.submit()
}

function openNavFacetas() {
  document.getElementById("SidenavFacetas").style.width = "200px";
}

function closeNavFacetas() {
  document.getElementById("SidenavFacetas").style.width = "0";
}

function openNav() {
	if (document.getElementById("page").style.marginLeft == "250px"){
		closeNav()
		return
	}
    document.getElementById("sidebar").style.width = "250px";
    document.getElementById("sidebar").style.marginLeft = "0px";
    document.getElementById("page").style.marginLeft = "250px";
    document.getElementById("page").style.width = "80%";
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    document.getElementById("sidebar").style.marginLeft = "-30px";
    document.getElementById("page").style.marginLeft = "0px"
    document.getElementById("page").style.width = "95%";
}

function Facetas(Expresion){	document.buscar.facetas.value=Expresion
	document.buscar.submit()}

function SolicitarPrestamo(CN,Base,otro){	document.buscar.action="../prestamos/prestamos.php"
	document.buscar.cookie.value=CN
	document.buscar.submit()

}