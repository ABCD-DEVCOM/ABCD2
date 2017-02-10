var Accion=""

function LimpiarForma(){	for (i=0;i<document.forma1.elements.length;i++){
        tipo=document.forma1.elements[i].type
        if (tipo=="text"){

        	nombre=document.forma1.elements[i].id
        	Ctrl=document.getElementById(nombre)
        	Ctrl.value=""
         }
 	}}

function AgregarOcurrencia(){

  Redraw("","")

  Accion="Agregar"

}

function EliminarOcurrencia(){
   	n1=document.forma1.lista.selectedIndex
	if (n1==-1) {
		alert("Debe seleccionar la ocurrencia que va a eliminar")
		return
	}
	document.forma1.lista.options[document.forma1.lista.selectedIndex]=null
	document.forma1.lista.size=document.forma1.lista.options.length
	Redraw("","")
	Accion="Agregar"
}

function AbrirIndiceMarc(xI,Prefijo,Separa,db,cipar,tag){
	document.forma1.Indice.value=xI
	Separa="&delimitador="+Separa
	Prefijo=Prefijo+Separa+"&tagfst="+tag
	ancho=screen.width-500-20

	msgwin=window.open("../php/capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&prefijo="+Prefijo+"&Tag=tag"+tag,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=500,height=600,top=20,left="+ancho)
	msgwin.focus()
}



function ActualizarForma() {
   	AceptarCambios()
	variable=""
	if (document.forma1.lista.length>0){
   		variable=document.forma1.lista.options[0].value
   		for (n1=1; n1<document.forma1.lista.length; n1++){
   			campo=document.forma1.lista.options[n1].value
   			if (campo!="")
   				if (variable=="")
   					variable=document.forma1.lista.options[n1].value
   				else
       				variable=variable+"\n"+document.forma1.lista.options[n1].value
   		}
	}
	a=eval("window.opener.document.forma1."+TagCampo)
  	a.value=variable
   //alert(a[0].rows)

   self.close()
}

function AceptarCambios(){
	if (Accion=="Agregar"){
		j=document.forma1.lista.length
   	}else{
      	j=document.forma1.lista.selectedIndex
	}
   	seleccion=""
   	m=-1
   	for (i=0;i<document.forma1.elements.length;i++){
        tipo=document.forma1.elements[i].type
        switch (tipo){        	case "text":
        		m++
	        	nombre=document.forma1.elements[i].id
	        	subc_act=nombre.substr(1,1)
	        	valor=document.forma1.elements[i].value
	        	if (is_marc=="S" && m<2 && (subc_act==1 || subc_act==2)){
	        		if (Trim(valor)=="") valor=" "
	        		seleccion+=valor
	        	}else{
	        		if (Trim(valor)!=""){
						if (valor.indexOf('^')==-1)
							if (subc_act!="-")
								seleccion+="^"+subc_act+valor
							else
								seleccion+=valor
						else
							seleccion+=valor
					}
	        	}
	        	break
	      	case "select-one":
	        	nombre=document.forma1.elements[i].id
	        	if (nombre=="" || nombre.substr(0,1)!="t") break
	        	subc_act=nombre.substr(1,1)
	        	m++
	        	if  (document.forma1.elements[i].selectedIndex==-1)
	        		valor=" "
	        	else
	        		valor=document.forma1.elements[i].options[document.forma1.elements[i].selectedIndex].value
	        	document.forma1.elements[i].selectedIndex=-1
	        	if (is_marc=="S" && m<2 && (subc_act==1 || subc_act==2)){
	        		if (Trim(valor)=="") valor=" "
	        		seleccion+=valor
	        	}else{
	        		if (Trim(valor)!=""){
						if (valor.indexOf('^')==-1)
							seleccion+="^"+subc_act+valor
						else
							seleccion+=valor
					}
	        	}

	      		break        }
 	}
	if (Accion=="Agregar" ) {
       if (Trim(seleccion)!=""){
       		var option0 = new Option(seleccion,seleccion)
       		document.forma1.lista.options[j]=option0
       		document.forma1.lista.options[j].selected=true
       		document.forma1.lista.selectedIndex=j
       	}
       Accion=""
   	}else {
		if (j>=0){

      		document.forma1.lista.options[j].value=seleccion
      		document.forma1.lista.options[j].text=seleccion
        }
	}
	if (Trim(seleccion)!="") document.forma1.lista.size=document.forma1.lista.options.length
	LimpiarForma()
	Accion="Agregar"
}


function DeterminaSubC(xSC,xseleccion) {
    xx=""
	if (xSC==" "){
		ixpos=xseleccion.indexOf("^")
		xx=xx+xseleccion.substr(0,ixpos)
		return xx
	}
    ixpos=xseleccion.indexOf("^"+xSC)
    while (ixpos>=0){
        ixpos1=0
        if (xx=="")
           {xseleccion=xseleccion.substr(ixpos+2)}
        else
           {xx=xx+"^"+xSC
           xseleccion=xseleccion.substr(ixpos+2)}
        ixpos1=xseleccion.indexOf("^",ixpos1)
        if (ixpos1<=0) {ixpos1=xseleccion.length+1}
        xx=xx+xseleccion.substr(0,ixpos1)
        ixpos=xseleccion.indexOf("^"+xSC)
     }
     return xx
}


function TerminoSeleccionado(){
	Accion=""
    xxs=SubCampos[0].split('|')
    j=document.forma1.lista.selectedIndex
	if (j!=-1) {
		seleccion=(document.forma1.lista.options[j].value)
		if (xxs[5]=='-' && seleccion!="")  seleccion="^-"+seleccion
	}else{
		seleccion=""
	}
	Redraw(seleccion,"")
}

