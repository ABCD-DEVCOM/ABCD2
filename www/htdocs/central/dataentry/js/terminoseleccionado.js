/*
20250401 fho4abcd repaired mixed line-endings, improved indent, removed unused functions
20250401 fho4abcd Improved functionality+removed Accion: no more need for value agregar
*/
function LimpiarForma(){
    for (i=0;i<document.forma1.elements.length;i++){
	tipo=document.forma1.elements[i].type
        if (tipo=="text"){
        	nombre=document.forma1.elements[i].id
        	Ctrl=document.getElementById(nombre)
        	Ctrl.value=""
	}
    }
}

function AgregarOcurrencia(){
	j=document.forma1.lista.length
	// create a new empty option to show that a new occurrence will be created
	var option0 = new Option("","")
	document.forma1.lista.options[j]=option0
	document.forma1.lista.options[j].selected=true
	document.forma1.lista.selectedIndex=j

	Redraw("","")
}

function EliminarOcurrencia(){
   	selectedIndex=document.forma1.lista.selectedIndex
	if (selectedIndex==-1) {
		alert("Debe seleccionar la ocurrencia que va a eliminar")
		return
	}
	length=document.forma1.lista.options.length
	if ( length>1) {
		document.forma1.lista.options[selectedIndex]=null
		document.forma1.lista.size=document.forma1.lista.options.length
	} else {
		document.forma1.lista.options[0].innerHTML=""
		document.forma1.lista.options[0].value=""
	}
	document.forma1.lista.options[0].selected=true
	Redraw(document.forma1.lista.options[0].value,"")
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
    j=document.forma1.lista.selectedIndex
    seleccion=""
    m=-1
    for (i=0;i<document.forma1.elements.length;i++){
        tipo=document.forma1.elements[i].type
        switch (tipo){
        	case "text":
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
	        	if  (document.forma1.elements[i].selectedIndex==-1) {
	        		valor=" "
	        	} else {
	        		valor=document.forma1.elements[i].options[document.forma1.elements[i].selectedIndex].value
			}
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
	      		break
        }
    }
    if (j>=0){
      	document.forma1.lista.options[j].value=seleccion
      	document.forma1.lista.options[j].text=seleccion
    }
    if (Trim(seleccion)!="") document.forma1.lista.size=document.forma1.lista.options.length
    LimpiarForma()
    Redraw(seleccion,"")
}

function TerminoSeleccionado(){
	xxs=SubCampos[0].split('|')
	j=document.forma1.lista.selectedIndex
	if (j!=-1) {
		seleccion=(document.forma1.lista.options[j].value)
		if (xxs[5]=='-' && seleccion!="")  seleccion="^-"+seleccion
	}else{
		seleccion=""
	}
       	document.forma1.lista.options[j].selected=true
	Redraw(seleccion,"")
}

