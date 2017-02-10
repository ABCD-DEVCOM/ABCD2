/* Coloca en variables de la forma el campo en proceso */

var NombreC
var TagCampo
var url_H

function checkKey (field, evt,Tsg,ix) {
/* 	f1  = 112
	f2  = 113
	f3  = 114
	f4  = 115
	f5  = 116
	f6  = 117
	f7  = 118
	f8  = 119
	f9  = 120
	f10 = 121
	f11 = 122
	f12 = 123
	arrow-left  = 37
	arrow-up    = 38
	arrow-right = 39
	arrow-down  = 40
*/

  var keyCode =
    document.layers ? evt.which :
    document.all ? event.keyCode :
    document.getElementById ? evt.keyCode : 0;
  var r = '';
  switch (keyCode){
  	case 18:      //Tecla Alt
		{Campos(eval("document.forma1."+field.name),0)
		return
		}
	case 113:
		{a=field.name
		Ayuda(a.substr(3))
		return false}
  }
  return true
/*
  if (keyCode == 39)
    r += 'arrow right';
  else if (keyCode == 40)
    r += 'arrow down'
  else if (keyCode == 38)
    r += 'arrow up';
  else if (keyCode == 37)
    r += 'arrow left';
  else if (keyCode == 112)
  		Ayuda(field.name)
  r += ' ' + keyCode;
  window.status = r;
  return true; */
}

function Campos(Tag,i,Formato,Repetible,Url_help,Wks) {
	url_H=Url_help
	NombreC=Tag
    Eti=Tag.name
	TagCampo=Eti.substr(3)
	Eti="eti"+TagCampo
	s=eval(Tag).value
	Etq=eval("document.forma1."+Eti)
	NombreC=Etq[0].value
    document.forma1.valor.value=s
    document.forma1.occur.value=1
	document.forma1.conte.value=Tag.value   /*Valores[i]*/
	document.forma1.NoVar.value=i
    document.forma1.TagActivo.value=Tag.name
    document.forma1.Repetible.value=Repetible
    document.forma1.Formato_ex.value=Formato
    wks=""
    if (document.forma1.wks.value!="")
        wks="&wks="+document.forma1.wks.value
	a=""
    for (lk=1;lk<=Etq.length-1;lk++){
		s=Etq[lk].value
		if (s!=""){
        	if (lk==0)
           		{a=s}
        	else
           		{a=a+"\n"+s}
		}
    }
    document.forma1.SubC.value=a
    base=top.base
    document.campos.base.value=base
    document.campos.is_marc.value=is_marc
    document.campos.SubC.value=a
    document.campos.tag.value=TagCampo
   	msgwin=window.open("","EditC","status=yes,resizable=yes,toolbar=false,menu=no,scrollbars=yes,width=800,height=500,top=50,left=0")
 	msgwin.focus()
 	document.campos.submit()


}

function CampoFijo(Tag,i,Formato,Base,Help,Tml,tipol,nivelr){
	Ctrl=eval("document.forma1.tag"+tipol)
	ix=Ctrl.selectedIndex
	if (ix<1) {
		alert("Please select a type of record")
		return
	}
	Formato=Ctrl.options[ix].value
	NombreC=Tag.name
    Eti=Tag.name
	TagCampo=Eti.substr(3)
	Eti="eti"+TagCampo
	s=eval(Tag).value
	Etq=eval("document.forma1."+Eti)
    document.forma1.valor.value=s
    document.forma1.occur.value=1
	document.forma1.conte.value=Tag.value   /*Valores[i]*/
	document.forma1.NoVar.value=i
    document.forma1.TagActivo.value=NombreC

    document.forma1.Formato_ex.value=Formato
	a=""
    for (lk=1;lk<=Etq.length-1;lk++){
		s=Etq[lk].value
		if (s!=""){
        	if (lk==0)
           		{a=s}
        	else
           		{a=a+"\n"+s}
		}
    }
    document.forma1.SubC.value=a
    msgwin=window.open("campofijo.php?formato="+Formato+"&base="+Base+"&Tag="+NombreC+"&tm="+Tml,"Window1" ,"status=yes,resizable=yes,toolbar=false,menu=no,scrollbars=yes,width=800,height=500,top=50,left=0")
    msgwin.focus()


}