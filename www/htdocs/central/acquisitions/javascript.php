<script src=../dataentry/js/lr_trim.js></script>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="../dataentry/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script type="text/javascript" src="../dataentry/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script type="text/javascript" src="../dataentry/calendar/lang/calendar-en.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="../dataentry/calendar/calendar-setup.js"></script>

<script>



function Show(Db,Key){
	msgwin=window.open("../dataentry/show.php?base="+Db+"&Expresion="+Key,"","width=600, height=600, resizable, scrollbars")
	msgwin.focus
}

function DateToIso(From,To){
	d=From.split('/')
	<?php echo "dateformat=\"$config_date_format\"\n" ?>
	if (dateformat="DD/MM/YY"){
		iso=d[2]+d[1]+d[0]
	} else {
		iso=d[2]+d[0]+d[1]
	}
	To.value=iso
}

function ChangeSeq(ix,prefix) {
	msgwin=window.open("","CHANGE","width=400, height=200, scrollbars=yes")
	msgwin.document.writeln("<b><?php echo $msgstr["database"]."</b>: ". $arrHttp["base"]?>")
	msgwin.document.writeln("<form name=cn method=post action=../dataentry/changeseq.php>")
	msgwin.document.writeln("<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>")
	msgwin.document.writeln("<input type=hidden name=prefix value="+prefix+">")
	msgwin.document.writeln("<input type=hidden name=tag value="+ix+">")
	msgwin.document.writeln("new control number <input type=text size=20 name=cn value=''>")
	msgwin.document.writeln("<input type=submit value=send>")
	msgwin.document.writeln("</form>")
	msgwin.document.close()
	msgwin.focus()
}

function EnviarForma() {
	enviar=Validar()
	if (enviar=="N") return
	Msg=""
	Separador=""
	var Repetibles=new Array();
    FormarValorCapturado()
	if (ValorCapturado+Val_text==""){
			alert("nodata")
			return
	}
	document.forma1.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){

	Ctrl_activo=xI
	if (db=="")  db="<?php echo $arrHttp["base"]?>"
	lang="<?php echo $_SESSION["lang"]?>"
    document.forma1.Indice.value=xI
    Separa="&delimitador="+Separa
    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
    ancho=200
    myleft=screen.width-480
	url_indice="../dataentry/capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
	msgwin=window.open(url_indice,"Indice","width=480, height=500,  scrollbars, status, resizable location=no, left="+myleft)
	msgwin.focus()
	return
}

function FormarValorCapturado(){
	j=document.forma1.elements.length-1
	ValorCapturado=""
	VC=new Array()
	Val_text=""
	for (i=0;i<=j;i++){
		campo=document.forma1.elements[i]
		nombre=campo.name
		id=campo.id
		if (campo.value!=""){
			if (nombre.substr(0,3)=="tag"){
				if (campo.type=="text" || campo.type=="textarea"){
					Val_text+=campo.value
				}else{
					switch (campo.type){
						case "checkbox":
							if (campo.checked){
								if (VC[nombre]=="undefined"){
									VC[nombre]="S";
									ValorCapturado= nombre+"_"+campo.value+"\n";
								}else{
									ValorCapturado=ValorCapturado+"\n"+nombre+"_"+campo.value
								}
								campo.checked=false
							}
							break
						case "select":
						case "select-one":
							break;
						case "select-multiple":
							Ctrl=eval("document.forma1."+nombre)
							for (ixsel=0;ixsel<Ctrl.length;ixsel++)
								if (Ctrl.options[ixsel].selected){
									if (VC[nombre]=="undefined"){
										VC[nombre]="S";
										ValorCapturado=nombre+"_" +Ctrl.options[ixsel].value;
									}else{
										ValorCapturado=ValorCapturado+"\n"+nombre+"_"+Ctrl.options[ixsel].value;
								}
							}
							break
					}
				}
			}
			if (campo.id=="O" && campo.value==""){
				if(Msg=="") {
					Separador="Debe llenar el campo: "
				}else{
					Separador=", "
				}
				Msg=Msg+Separador+NomList[i]
				enviar=false
			}
		}else{
			if (nombre.substr(0,3)=="eti") 	campo.value=""
		}
	}
	document.forma1.check_select.value=ValorCapturado
}
//Ajax funtion to declare an XMLHttpRequest object
function getXMLHTTPRequest() {
try {
req = new XMLHttpRequest();
} catch(err1) {
  try {
  req = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (err2) {
    try {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (err3) {
      req = false;
    }
  }
}
return req;
}
 var http = getXMLHTTPRequest();


function CheckInventoryDup(invnumber,type){
  if (http.readyState == 4 || http.readyState == 0)  	{
  var myurl = 'check_dup_copies.php';//define la url
  myRand = parseInt(Math.random()*999999999999999);// es para que la info no vaya a la cache sino al servidor
  var modurl = myurl+"?invnum="+invnumber+"&rand="+myRand;//crea la nueva url
  http.open("GET", modurl);//define tipo de convercion
  http.onreadystatechange = function(){ ResponseCheckInventoryDup(type);}//es lo que queremos q se ejecute
  http.send(null);//se ejecuta la funcion
  }
  else
    setTimeout('CheckInventoryDup('+invnumber+','+type+')', 1000);
}

function ResponseCheckInventoryDup(type) {
if (http.readyState == 4)
	  if(http.status == 200) {
		  if (http.responseText!="") {
		   if (type==2) {
		    document.getElementById("INVA").value=http.responseText;

		    if (http.responseText==(document.forma1.Mfn.value+'~') || http.responseText=="~") {
		       document.getElementById("INE").style.display='none';
		     } else {
		       document.getElementById("INE").innerHTML='</br><?php echo $msgstr["errSCopy"];?></br></br></br>';
		       document.getElementById("INE").style.display='block';
		     }
		   } else {
		     if (http.responseText=="~") {
			 document.getElementById("INE").style.display='none';
			 document.getElementById("INVA").value=http.responseText;
			 } else {
		       document.getElementById("INE").innerHTML='</br><?php echo $msgstr["errSCopy"];?></br></br></br>';
			   document.getElementById("INVA").value=http.responseText;
		       document.getElementById("INE").style.display='block';
		     }
		   }
	      } else {
		   alert("Ha ocurrido un error: "+http.statusText);
		  }
        }
}

function DoRemoveFromLoUpdatingStatus(Db,Cn,Inv,Mfn){
 if (http.readyState == 4 || http.readyState == 0)
  	{
  var myurl = 'copies_lo_update.php';//define la url
  myRand = parseInt(Math.random()*999999999999999);// es para que la info no vaya a la cache sino al servidor
  var modurl = myurl+"?db="+Db+"&cn="+Cn+"&in="+Inv+"&mfn="+Mfn+"&rand="+myRand;//crea la nueva url
  http.open("GET", modurl);//define tipo de convercion
  http.onreadystatechange = function(){ResponseDoRemoveFromLoUpdatingStatus(Mfn);}//es lo que queremos q se ejecute
  http.send(null);//se ejecuta la funcion
  }
  else
    setTimeout('DoRemoveFromLoUpdatingStatus('+Db+','+Cn+','+Inv+','+Mfn+')', 1000);
}

function ResponseDoRemoveFromLoUpdatingStatus(Mfn) {
if (http.readyState == 4)
	  if(http.status == 200)
	    {
		  if (http.responseText=="") {
		   DoRemove(Mfn);
		  }
		  else
		  {
		   alert("Ha ocurrido un error: "+http.statusText);
		  }
        }
}

</script>