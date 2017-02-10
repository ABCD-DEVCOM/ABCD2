<!-- save search expression style -->
<style>
	#headerDiv, #contentDiv {
	float: right;
	width: 510px;
	}
	#titleText {
	float: right;
	font-size: 1.2em;
	font-weight: bold;
	margin: 5px 10px;
	}
	headerDiv {
	background-color: #ffffff;
	color: #000000;
	}
	contentDiv {
	background-color: #FFE694;
	}
	myContent {
	margin: 5px 10px;
	}
	headerDiv a {
	float: left;
	margin: 10px 10px 5px 5px;
	}
	headerDiv a:hover {
	color: #;
	}
</style>

<style type="text/css">
#wrapper {
	text-align:left;
	margin:0 auto;
	width:100%;
	xmin-height:10px;
	xborder:1px solid #ccc;
	padding:0px;
}


a {

	cursor:pointer;
}


#myvar {
	border:1px solid #ccc;
	background:#ffffff;
	padding:2px;
}
input,textarea {
    border: 1px solid #CCCCCC;
    -webkit-box-shadow:
      inset 0 0 4px  rgba(0,0,0,0.1),
            0 0 4px rgba(0,0,0,0.1);
    -moz-box-shadow:
      inset 0 0 4px  rgba(0,0,0,0.1),
            0 0 4px rgba(0,0,0,0.1);
    box-shadow:
      inset 0 0 4px  rgba(0,0,0,0.1),
            0 0 4px rgba(0,0,0,0.1);
    padding: 2px;
    background: rgba(255,255,255,0.5);
    margin: 0 0 0px 0;
}
</style>

<!-- Estilos para el tooltip -->
<style type="text/css">
a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;}
a.tooltip span { z-index:10;display:none; padding:14px 20px; margin-top:-30px; margin-left:28px; line-height:16px; }
a.tooltip:hover span{ display:inline; position:absolute; color:#111; border:1px solid #DCA; background:#eeeeee;}
.callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;} /*CSS3 extras*/
a.tooltip span { border-radius:4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; -moz-box-shadow: 5px 5px 8px #CCC; -webkit-box-shadow: 5px 5px 8px #CCC; box-shadow: 5px 5px 8px #CCC; }
</style>

<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="../dataentry/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script type="text/javascript" src="../dataentry/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script type="text/javascript" src="../dataentry/calendar/lang/calendar-<?php echo $_SESSION["lang"]?>.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="../dataentry/calendar/calendar-setup.js"></script>

<script language=javascript src=../dataentry/js/campos.js?<?php echo time(); ?>></script>
<script language=Javascript src=../dataentry/js/windowdhtml.js></script>
<script language=Javascript src=../dataentry/js/lr_trim.js></script>
<script language=Javascript src=../dataentry/js/password_check.js?<?php echo time(); ?>></script>
<script language=javascript src=../dataentry/fckeditor.js></script>



<script src="../ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="../dataentry/js/textcounter.js?<?php echo time(); ?>"></script>

<?php if (file_exists("../dataentry/js/".$arrHttp["base"].".js"))
	echo "<script language=javascript src=".$arrHttp["base"].".js></script>\n";

?>

<script>
<?php
	if (isset($SECURE_PASSWORD_LEVEL))
		echo "secure_password_level='$SECURE_PASSWORD_LEVEL'\n";
	if (isset($SECURE_PASSWORD_LENGTH))
		echo "secure_password_length='$SECURE_PASSWORD_LENGTH'\n";
?>
var score=0
tag_password=""
mandatory_password=""
var max_l=new Array()
function switchMenu(obj,ixsec) {
	var el = document.getElementById(obj);
	if ( el.style.display != "none" ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}

	function toggle(showHideDiv, switchTextDiv) {
		var ele = document.getElementById(showHideDiv);
		var text = document.getElementById(switchTextDiv);
		if(ele.style.display == "block") {
	    	ele.style.display = "none";
	  	}
		else {
			ele.style.display = "block";
		}
	}
	function GuardarBusqueda(){
		Descripcion=document.forma1.Descripcion.value
		if (Trim(Descripcion)==""){
			alert("<?php echo $msgstr["errsave"]?>")
			return
		}
		document.guardar.Descripcion.value=Descripcion
		var winl = (screen.width-300)/2;
		var wint = (screen.height-200)/2;
		document.guardar.Expresion.value='<?php if (isset($arrHttp["Expresion"])) echo $arrHttp["Expresion"]?>'
		msgwin=window.open("","guardar","menu=no,status=yes,width=300, height=200,left="+winl+",top="+wint)
		msgwin.focus()
		document.guardar.submit()
	}
</script>

<script language=javascript>

Tab_val=Array()
xEliminar=""
url_indice=""
ira=""
Ctrl_activo=""
ValorCapturado=""
Val_text=""

	function DateToIso(From,To){
		if (Trim(From)=="") {			To.value=""
			return		}
        d=new Array()
		d[0]=""
		d[1]=""
		d[2]=""
        if (From.indexOf('-')>1){
			d=From.split('-')
		}else{
			if (From.indexOf('/')>1){
				d=From.split('/')
			}else{
				iso=From
				return
			}
		}
		<?php echo "dateformat=\"$config_date_format\"\n" ?>

		if (dateformat=="DD/MM/YY"){
			iso=d[2]+d[1]+d[0]
		}else{
			iso=d[2]+d[0]+d[1]
		}
		To.value=iso
	}

	function EliminarRegistro(){
		Mfn=document.forma1.Mfn.value
		if (Mfn=="New"){
			alert("<?php echo $msgstr["confirmnew"]?>")
			return
		}
		if (xEliminar==""){
			alert("<?php echo $msgstr["confirmdel"]?>")
			xEliminar="1"
		}else{
			xEliminar=""
			if (top.window.frames.length>1) top.xeditar="";
			document.forma1.Opcion.value='eliminar'
			document.forma1.submit()
		}
	}


	function EnviarDocumento(){
		msgwin=window.open("","Resultado")
		a=editor_getHTML('Body')
		msgwin.focus()
		document.Enviar.documento.value=a
		document.Enviar.submit()
	}

<?php
echo "
function CancelarActualizacion(){
";
if (!isset($arrHttp["encabezado"])){
	if (!isset($arrHttp["ventana"])){
		if (isset($arrHttp["capturar"])){
			echo "self.document.close()
                  self.document.writeln('')
				top.xeditar=\"\"\n";
		}else{
		 echo "
			top.xeditar=\"\"
			top.mfn=top.mfn-1
			top.Menu(\"proximo\")
			top.ApagarEdicion()\n";
		}
	}else{
		echo "self.close()\n";
	}


}else{
	echo 'self.location.href="browse.php"';
}
	echo  "}";
?>
function AlmacenarTerminoEnCampo(){
	alert(Ctrl_activo.name)
}

function AbrirVentana(Nombre){	msgwin=window.open("",Nombre,"width=800,height=600,scrollbars,resizable")
	msgwin.focus()}

function ConfirmarAccion(url,target){	if (confirm('<?php echo $msgstr["seguro"] ?>?')){		msgwin=window.open(url,target,"width=800,height=600,scrollbars,resizable")
		msgwin.focus()	}}

function DesplegarArchivo(Tag){

	Ctrl=eval("document.forma1."+Tag+".value")
	img="../../../bases/<?php echo $arrHttp["base"]?>/"+Ctrl
	msgimg=window.open(img,"")
}

function ChangeSeq(ix,prefix){
	msgwin=window.open("","CHANGE","width=400, height=200, scrollbars=yes")
	msgwin.document.writeln("<b><?php echo $msgstr["bd"]."</b>: ". $arrHttp["base"]?>")
	msgwin.document.writeln("<form name=cn method=post action=../dataentry/changeseq.php>")
	msgwin.document.writeln("<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>")
	msgwin.document.writeln("<input type=hidden name=prefix value="+prefix+">")
	msgwin.document.writeln("<input type=hidden name=tag value="+ix+">")
	msgwin.document.writeln("new control number <input type=text size=20 name=cn value=''>")
	msgwin.document.writeln("<input type=submit value=send>")
	msgwin.document.writeln("</form>")
	msgwin.focus()
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
				if (campo.type=="text" || campo.type=="textarea" ){
					Val_text+=campo.value
				}else{
					switch (campo.type){
						case "password":
							pass=Trim(document.forma1.confirm.value)
							campo.value=Trim(campo.value)
							if (campo.value==""){
								alert("<?php echo $msgstr["falta"].": ".$msgstr["password"]?>")
								return false
							}
							if (pass!=campo.value){
								alert("<?php echo $msgstr["passconfirm"]?>")
								return false
							}
							Val_text+=Trim(campo.value)
							break
						case "radio":
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
										Ctrl.options[ixsel].selected=false
									}else{
										ValorCapturado=ValorCapturado+"\n"+nombre+"_"+Ctrl.options[ixsel].value;
										Ctrl.options[ixsel].selected=false
								}
							}
							break
					}
				}
			}
			if (campo.id=="O" && campo.value==""){
				if(Msg=="") {
					Separador="<?php echo $msgstr["specvalue"]?>: "
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
	return true
}

function EnviarForma(){	if (tag_password!=""){		Ctrl=eval("document.forma1."+tag_password)		if (Ctrl.value!=document.forma1.confirm.value){			alert("<?php echo $msgstr["passconfirm"]?>")
			return		}
		res=VerificarPassword(tag_password)
		pwd=document.getElementById(tag_password);

		if (!res && (secure_password_level!="" || secure_password_length!="")){
			if (Trim(pwd.value)!="" || mandatory_password==1){
				alert('<?php echo $msgstr["pass_error"]." ".$msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
				if ($SECURE_PASSWORD_LENGTH>0) echo ". ". $msgstr["pass_format_1"]. " ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"];?>')
			    return
			}
		}
	}	if (fdt_validation=='Y'){		mensaje=ValidarCampos_FDT()
		if (mensaje!=""){			alert(mensaje)
			enviar=false
			return		}
	}
	enviar=true
	Msg=""
	Separador=""
	var Repetibles=new Array();
    enviar=FormarValorCapturado()
    if (enviar==false)return
	if (ValorCapturado+Val_text==""){
		alert("<?php echo $msgstr["specvalue"]?>")
		return
	}
	document.forma1.Opcion.value='actualizar'
	<?php if (!isset($arrHttp["ventana"]) and !isset($arrHttp["encabezado"])) {
		echo "if (top.window.frames.length>1){
			         top.ApagarEdicion()
			         document.forma1.db_copies.value=top.db_copies  //DETECT IF THE DATABASE MANAGE COPIES
			         top.xeditar=\"\"
		}
		";
	}
	?>
	document.forma1.action="../dataentry/fmt.php"
	document.forma1.submit()
}

function EnviarValoresPorDefecto(){
	enviar=true
	Msg=""
	Separador=""
	var Repetibles=new Array();
    FormarValorCapturado()
	document.forma1.action="default_update.php"
	document.forma1.submit()
}

function CapturarRegistro(){
	top.basecap="<?php if (isset($arrHttp["basecap"])) echo $arrHttp["basecap"]?>"
	top.ciparcap="<?php if (isset($arrHttp["ciparcap"])) echo $arrHttp["ciparcap"]?>"
	top.base="<?php echo $arrHttp["base"]?>"
	top.cipar="<?php echo $arrHttp["cipar"]?>"
	top.Mfn="<?php if (isset($arrHttp["Mfn"]))echo $arrHttp["Mfn"]?>"

	top.CapturarRegistro()


}

	function LlenarTabla(Tabla,Llenar){
		ix=Tabla.selectedIndex-1
		TT=eval('document.forma1.tag'+Llenar)
		valores=TT.length
		for (i=0;i<valores;i++) TT.remove(0)
		variable=eval("tab"+Llenar+"["+ix+"]")
		for (i=0;i<variable.length;i++){
			TT.options[i+1]=new Option(variable[i],variable[i])
		}
	}

	function Ayuda (tag) {
		tagx=String(tag)

		url="<?php echo "../documentacion/ayuda_db.php?base=".$arrHttp["base"]?>&campo=tag_"+tagx+".html"
		msgwin=window.open(url,"Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=600,height=400,top=100,left=100")
		msgwin.focus()
	}


	function EditarArchivo(Tag,Bd,Cipar){
		msgwin=window.open("fckeditor_edit.php?base=traduc&Tag="+Tag+"&archivo="+eval("document.forma1."+Tag+".value"),"Upload","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
		msgwin.focus()
	}

	function AbrirTesauro(Tag){		Url="../tesaurus/index.php?base=<?php echo $arrHttp["base"]?>&Tag="+Tag
		myleft=screen.width-450
		msgwin=window.open(Url,"Tesauro","width=450, height=530,  scrollbars, status, resizable location=no, left="+myleft)
		msgwin.focus()	}

	function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		if (Prefijo.indexOf("[")!=-1){
			p=Prefijo.split("[")
			xlen=p[1].length
			p[1]=p[1].substring(0,xlen-1)
			Sub_Prefijo=eval("document.forma1.tag"+p[1])
			if (Sub_Prefijo.value==""){				alert("Debe especificar el contenido del campo 100")
				return			}
			Prefijo=p[0]+Sub_Prefijo.value+"-"
		}
		baseactiva="<?php echo $arrHttp["base"]?>"
		lang="<?php echo $_SESSION["lang"]?>"
	    document.forma1.Indice.value=xI
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    myleft=screen.width-600
		url_indice="../dataentry/capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato+"&subcampos="+Subc+"&baseactiva="+baseactiva
		msgwin=window.open(url_indice,"Indice","width=650, height=530,  scrollbars, status, resizable location=no, left="+myleft)
		msgwin.focus()
		return
	}

	function AbrirIndice(ira){
		url_indice=url_indice+ira
	    ancho=screen.width-500-20

		msgwin=window.open(url_indice,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=500,height=600,top=20,left="+ancho)
		msgwin.focus()
	}

	function EnviarArchivo(Tag){
		document.enviararchivo.Tag.value=Tag
		document.enviararchivo.storein.value=top.img_dir
		msgwin=window.open("","Upload","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=180,top=100,left=5");
		msgwin.focus()  ;
		document.enviararchivo.submit()
	}

function NuevaBusqueda(){
	if (Trim(document.forma1.nueva_b.value)!=""){		str=document.forma1.nueva_b.value;
		var res = str.replace(/"/g,"")
		top.Expresion=res
		top.Menu("ejecutarbusqueda")	}}
function CopiarHtml(Tag,Tipo,Mfn){         //tipo B=External HTM
		msgwin=window.open("","Upload","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=180,top=100,left=5");
		msgwin.document.close();
		msgwin.document.writeln("<html><title><?php echo $msgstr["uploadfile"]?></title><body link=black vlink=black bgcolor=white>\n");
		msgwin.document.writeln("<form name=upload action=upload_html.php method=POST enctype=multipart/form-data>\n");
		msgwin.document.writeln("<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>\n");
		msgwin.document.writeln("<input type=hidden name=Tag value="+Tag+">")
		msgwin.document.writeln("<input type=hidden name=Tipo value="+Tipo+">")
		msgwin.document.writeln("<input type=hidden name=Mfn value="+Mfn+">")
		msgwin.document.writeln("<br>");
		msgwin.document.writeln("<table width=100%>");
		msgwin.document.writeln("<tr><td class=menusec1><?php echo $msgstr["archivo"]?></td>\n");
		msgwin.document.writeln("<tr><td><input name=userfile[] type=file size=50></td></td>\n");
		msgwin.document.writeln("</table>\n");
		msgwin.document.writeln("  <input type=submit value='<?php echo $msgstr["uploadfile"]?>'>\n");
		msgwin.document.writeln("</form>\n");
		msgwin.document.writeln("</body>\n");
		msgwin.document.writeln("</html>\n");
		msgwin.focus()  ;
	}

function Undelete(Mfn){	top.Menu("editar")}

function SetFckeditor(Ctrl,html){
    var oEditor = FCKeditorAPI.GetInstance(Ctrl) ;

	// Check the active editing mode.
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		// Insert the desired HTML.
		oEditor.InsertHtml( html ) ;
	}
	else
		alert( 'You must be on WYSIWYG mode!' ) ;


}



</script>


<SCRIPT language="javascript">
		tagOrg=""
		subcOrg=""
		function Organizar(tag,subC){
			tagOrg=tag
			subcOrg=subC			document.getElementById('loading').style.display='block';			tableID="id_"+tag
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var valores=new Array()
            for (irow=0;irow<rowCount-2;irow++){            	valores[irow]=""            	if (subC.length>0){
	            	for (i=0;i<subC.length;i++){	            		sc="_"+subC.substr(i,1)	          	        newName="tag"+tag+"_"+irow+sc
	          	        Ctrl=eval("document.forma1."+newName)
	          	        switch (Ctrl.type){
		            		case "text":
		            			valores[irow]+=Ctrl.value+'|$|'
		            			break;
		            		case "textarea":
		            			valores[irow]+=Ctrl.value+'|$|'
		            			break;
		            		case "checkbox":
		              			valores[irow]+=Ctrl.checked+'|$|';
		                 		break;
		                 	 case "select-one":
		                   		valores[irow]+=Ctrl.selectedIndex+'|$|'
		                     	break;
		                     case "radio":
		                        valores[irow]+=Ctrl.checked+'|$|'
		                 		break;
			            }
	            	}
	          	}
                var Sel = document.getElementById("reorg");
				var newOpt =Sel.appendChild(document.createElement('option'));
				x=valores[irow].split('|$|')
				optText=""
				ixvLength=x.length
				for (iv=0;iv<ixvLength;iv++){					if (Trim(x[iv])!=""){						optText+="^"+subC.substr(iv,1)+x[iv]					}				}
    			newOpt.text = optText
    			newOpt.value = valores[irow];
            }		}

		function OrganizarSalir(accion){			var Sel = document.getElementById("reorg");			switch (accion){				case "cancelar":
					Sel.options.length=0
					document.getElementById('loading').style.display='none';
					break
				case "aceptar":
					tag=tagOrg
					subC=subcOrg
					rowCount=Sel.length
					for (irow=0;irow<rowCount;irow++){
		            	valor=Sel.options[irow].value
		            	vv=valor.split('|$|')
			            for (i=0;i<subC.length;i++){
			            	sc="_"+subC.substr(i,1)
			          	    Name="tag"+tag+"_"+irow+sc
			          	    Ctrl=eval("document.forma1."+Name)
		          	        switch (Ctrl.type){
			            		case "text":
			           				Ctrl.value=vv[i]
			            			break;
			            		case "textarea":
			            			Ctrl.value=vv[i]
			            			break;
			            		case "checkbox":
			              			Ctrl.checked=vv[i];
			                 		break;
			                 	 case "select-one":
			                   		Ctrl.selectedIndex=vv[i]
			                     	break;
			                     case "radio":
			                        Ctrl.checked=vv[i]
			                 		break;
				            }
		            	}
		          	}
					Sel.options.length=0
					document.getElementById('loading').style.display='none';
					break			}		}
		function RowClean(linea,subC){			t=linea.split("_");
			tag=t[0]
			row=t[1];
			if (subC.length>0){
	            for (i=0;i<subC.length;i++){
	            	sc=""
	                if (subC!="")
	                	sc="_"+subC.substr(i,1)
	            	newName="tag"+tag+"_"+row+sc
	            	Ctrl=eval("document.forma1."+newName)
	            	switch (Ctrl.type){
	            		case "text":
	            			Ctrl.value=""
	            			break;
	            		case "textarea":
	            			Ctrl.value=""
	            			mlt=tag+"_0"+sc
	            			text_counter=eval("document.forma1.rem"+tag+"_"+nfilas+sc)
	            			if (text_counter){
                               text_counter.value=max_l[mlt]
	            			}
	            			break;
	            		case "checkbox":
	              			Ctrl.checked = false;
	                 		break;
	                 	 case "select-one":
	                   		Ctrl.selectedIndex = 0;
	                     	break;
	                     case "radio":
	                        Ctrl.checked = false;
	                 		break;
		            }
		       	}
			}
		}

        function addRow(tableID,subC,accion,valdef) {        	vd=valdef.split("$$$")
        	va_def=new Array()
        	for (xvd in vd){        		ll0=vd[xvd]
        		if (Trim(ll0)!=""){        			vd1=ll0.split("|")
        			va_def[vd1[0]]=vd1[1]
        		}        	}
            tag=tableID
            tableID="id_"+tag
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            if (subC==""){
            	initRow=0
            	nfilas=rowCount
            }else{
            	initRow=2
            	nfilas=rowCount-2
            }
            var colCount = table.rows[initRow].cells.length;
            for(var i=0; i<colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.vAlign = 'top';
                newcell.setAttribute("bgColor","#FFFFFF");
                newcell.innerHTML = table.rows[initRow].cells[i].innerHTML;
                sc=""
                if (subC!="")
                	sc="_"+subC.substr(i,1)
                oldName=tag+"_0"+sc
                newName=tag+"_"+nfilas+sc
                celda=newcell.innerHTML
                while (celda.indexOf(oldName) != -1){
                	celda=celda.replace(oldName,newName)
                }
                if (celda.indexOf("Javascript:DateToIso(")!=-1){                	celda=celda.replace("_0_","_"+nfilas+"_")                }

                newcell.innerHTML=celda
            }
            if (subC.length>0){
	            for (i=0;i<subC.length;i++){
	            	sc=""
	                if (subC!="")
	                	sc="_"+subC.substr(i,1)
	                	lsc=subC.substr(i,1)
	            	newName="tag"+tag+"_"+nfilas+sc
	            	Ctrl=eval("document.forma1."+newName)
                    if (accion=="add"){
		            	switch (Ctrl.type){
		            		case "text":
		            			if (lsc in va_def)
		            				Ctrl.value=va_def[lsc]
		          				else
		            				Ctrl.value=""
		            			break;
		            		case "textarea":
		            			if (lsc in va_def)
		            				Ctrl.value=va_def[lsc]
		          				else
		            				Ctrl.value=""
		            			mlt=tag+"_0"+sc
		            			text_counter=eval("document.forma1.rem"+tag+"_"+nfilas+sc)
		            			if (text_counter){
	                               text_counter.value=max_l[mlt]
		            			}
		            			break;
		            		case "checkbox":
		              			Ctrl.checked = false;
		                 		break;
		                 	 case "select-one":
		                   		Ctrl.selectedIndex = 0;
		                     	break;
		                     case "radio":
		                        Ctrl.checked = false;
		                 		break;

		            	}
		       		}else{
		       			prev_val=nfilas-1
		       			oldName="tag"+tag+"_"+prev_val+sc
	            		Ctrl_new=eval("document.forma1."+newName)
	            		Ctrl_old=eval("document.forma1."+oldName)
	            		switch (Ctrl.type){
		            		case "text":
		            			Ctrl_new.value=Ctrl_old.value
		            			break;
		            		case "textarea":
		            			Ctrl_new.value=Ctrl_old.value
		            			//mlt=tag+"_0"+sc
		            			//text_counter=eval("document.forma1.rem"+tag+"_"+nfilas+sc)
		            			//if (text_counter){
	                            //   text_counter.value=max_l[mlt]
		            			//}
		            			break;
		            		case "checkbox":
		              			Ctrl_new.checked = Ctrl_old.checked;
		                 		break;
		                 	 case "select-one":
		                   		Ctrl_new.selectedIndex = Ctrl_old.selectedIndex;
		                     	break;
		                     case "radio":
		                        Ctrl_new.checked = Ctrl_old.checked;
		                 		break;
		            	}
		       		}
	            }
			}else{
				newName="tag"+tag+"_"+nfilas
	            Ctrl=eval("document.forma1."+newName)
	            Ctrl.value=""
			}

        }

        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }

            }
            }catch(e) {
                alert(e);
            }
        }

function AgregarOperador(tag){	Ctrl=eval("document.forma1."+tag)	Ctrl.value='<?php echo $_SESSION['login']?>'}

function AgregarFecha(tag){
	Ctrl=eval("document.forma1."+tag)
	Ctrl.value='<?php echo date('Ymd')?>'
}

function CalendarSetup(i_inputField,i_ifFormat,i_button,i_align,i_singleClick){	Calendar.setup({
		inputField     :    i_inputField,     // id of the input field
		ifFormat       :    i_ifFormat,
		button         :    i_button,  // trigger for the calendar (button ID)
		align          :    i_align,           // alignment (defaults to \"Bl\")
		singleClick    :    true
							  });}

    </SCRIPT>

<script type="text/javascript">

function RefrescarPicklist(tabla,Ctrl,valor){	ValorOpcion=valor
	document.refrescarpicklist.picklist.value=tabla
	document.refrescarpicklist.Ctrl.value=Ctrl
	document.refrescarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=20,height=10,scrollbars, resizable")
	document.refrescarpicklist.submit()
	msgwin.focus()
}

function AgregarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor	document.agregarpicklist.picklist.value=tabla
	document.agregarpicklist.Ctrl.value=Ctrl
	document.agregarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=600,height=500,scrollbars, resizable")
	document.agregarpicklist.submit()
	msgwin.focus()}

//SE ACTUALIZA EL SELECT CON LA TABLA ACTUALIADA
ValorTabla=""
SelectName=""
ValorOpcion=""
function AsignarTabla(){
	opciones=ValorTabla.split('$$$$')
	var Sel = document.getElementById(SelectName);
	Sel.options.length = 0;
	var newOpt =Sel.appendChild(document.createElement('option'));
    newOpt.text = "";
    newOpt.value = " ";
	for (x in opciones){
		op=opciones[x].split('|')
		if (op[0]=="")
			op[0]=op[1]
		if (op[1]=="")
			op[1]=op[0]		var newOpt =Sel.appendChild(document.createElement('option'));
    	newOpt.text = op[1];
    	newOpt.value = op[0];
    	if (op[0]==ValorOpcion)
    		newOpt.selected=true	}
}

function SeleccionarRegistro(Mfn){	if (document.forma1.chkmfn.checked){		if (top.RegistrosSeleccionados.indexOf('|'+Mfn+'-')==-1){
			top.RegistrosSeleccionados+='|'+Mfn+"-"
		}
	}else{
		top.RegistrosSeleccionados=top.RegistrosSeleccionados.replace('|'+Mfn+'-','')	}
}

//MANEJO DEL COMBOBOX
// This is the function that refreshes the list after a keypress.
// The maximum number to show can be limited to improve performance with
// huge lists (1000s of entries).
// The function clears the list, and then does a linear search through the
// globally defined array and adds the matches back to the list.

function handleKeyUp(maxNumToShow,SelectName,InputName,FunctionList)
{
    var selectObj, textObj, functionListLength;
    var i, searchPattern, numShown;
    // Set references to the form elements
    selectObj = SelectName;
    textObj = InputName;
    // Remember the function list length for loop speedup
    functionListLength = FunctionList.length;
	searchPattern = textObj.value;
    // Create a regulare expression
    re = new RegExp(searchPattern,"gi");
    // Clear the options list
    selectObj.length = 0;

    // Loop through the array and re-add matching options
    numShown = 0;
    for(i = 0; i < functionListLength; i++)
    {
        if(FunctionList[i].search(re) != -1)
        {
            selectObj[numShown] = new Option(FunctionList[i],"");
            numShown++;
        }
        // Stop when the number to show is reached
        if(numShown == maxNumToShow)
        {
            break;
        }
    }
    // When options list whittled to one, select that entry
    if(selectObj.length == 1)
    {
        selectObj.options[0].selected = true;
    }
}

function handleSelectClick(SelectName,InputName,Repetible){
	ix=SelectName.selectedIndex
	switch (Repetible){
		case 0:
			InputName.value=SelectName.options[ix].text
			break;
		case 1:
			termino=SelectName.options[ix].text+'\n'
			if (InputName.value.indexOf(termino)!=-1){
				return
			}
			InputName.value+=SelectName.options[ix].text+'\n'
	}

}

function DeleteText(SelectName,tag){
	var originalText = document.getElementById(tag).value;
	ix=SelectName.selectedIndex
	var selectedText = SelectName.options[ix].text;
	newText=originalText.replace(selectedText+'\n',"")
	document.getElementById(tag).value = newText
}

function Limpiar(Ctrl){
	Ctrl.value=""
}


</script>


<BODY>
<span id="toolTipBox" width="200"></span>
<?php
if (isset($arrHttp["encabezado"])){
// Si se está creando un registro desde el script browse.php
	if ($arrHttp["Opcion"]=="ver"){
		include("../common/institutional_info.php");
		echo "<div class=\"sectionInfo\">
				<div class=\"breadcrumb\">
				</div>";
		echo "<div class=\"actions\">
			<a href=\"$retorno$return\" class=\"defaultButton backButton\">
				<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
				<span><strong>".$msgstr["back"]."</strong></span>
			</a>
		</div>
		<div class=\"spacer\">&#160;</div>
		</div>";
	}else{
		if (!isset($fmt_test)){

			include("../common/institutional_info.php");
			echo "<div class=\"sectionInfo\">
				<div class=\"breadcrumb\">
					";

				if ($arrHttp["Mfn"]=="New") echo "<h3>". $msgstr["newoper"]."</h3>\n";
				echo "</div>
				<div class=\"actions\">
					<a href=javascript:EnviarForma() class=\"defaultButton saveButton\">
						<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
						<span><strong>".$msgstr["m_guardar"]."</strong></span>
					</a>
					<a href=\"$retorno$return\" class=\"defaultButton cancelButton\">
						<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
						<span><strong>".$msgstr["cancelar"]."</strong></span>
					</a>
				</div>
				<div class=\"spacer\">&#160;</div>
			</div>
			";
		}
	}
}

?>
<a name=INICIO></a>
<form name=enviararchivo action=upload_file.php method=post target=Upload>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=Tag>
	<input type=hidden name=storein>
</form>

<form name=agregarpicklist action=../dbadmin/picklist_edit.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>

<form name=refrescarpicklist action=../dbadmin/picklist_refresh.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>

<form name=guardar action=busqueda_guardar.php method=post target=guardar>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=Expresion value="<?php echo urlencode($arrHttp["Expresion"])?>">
	<input type=hidden name=Descripcion value="">
</form>

<form name=campos method=post action=campos.php target=EditC>
<input type=hidden name=tag>
<input type=hidden name=base>
<input type=hidden name=is_marc>
<input type=hidden name=SubC>
</form>

<form method=post name=forma1 action=fmt.php onSubmit="javascript:return false" id=forma1>


<input type=hidden name=db_copies>
<input type=hidden name=IsisScript value=ingreso.xis>
<?php if (isset($arrHttp["toolbar_record"]))
	echo "<input type=hidden name=toolbar_record value=".$arrHttp["toolbar_record"].">\n"; ?>
<?php if (isset($arrHttp["footer"]))
	echo "<input type=hidden name=footer value=".$arrHttp["footer"].">\n"; ?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
<input type=hidden name=wks value=<?php if (isset($arrHttp["wks"]))  echo $arrHttp["wks"]?>>
<?php
if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
if ($arrHttp["Opcion"]=="capturar" || $arrHttp["Opcion"]=="nuevo"){
	$a="crear";
}else{
	$a=$arrHttp["Opcion"];
}


echo "<input type=hidden name=Opcion value=\"$a\">\n";
$pft_a="";
if (isset($arrHttp["encabezado"])) {
	 echo "<input type=hidden name=encabezado value=s>\n";
	 $arrHttp["Formato"]=$arrHttp["base"];
}
if (isset($arrHttp["from"]))
	echo "<input type=hidden name=from value=".$arrHttp["from"].">\n";
?>

<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=ver value=S>
<input type=hidden name=ventana value="<?php if (isset($arrHttp["ventana"]))echo $arrHttp["ventana"]?>">
<?php
if (isset($arrHttp["retorno"])){
	echo "<input type=hidden name=retorno value=".$arrHttp["retorno"].">\n";
}
if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
if (isset($arrHttp["status"])){
	echo "<input type=hidden name=return value=".$arrHttp["status"].">\n";
}
?>
<input type=hidden name=valor value="">
<input type=hidden name=occur value="">
<input type=hidden name=conte value="">
<input type=hidden name=NoVar value="">
<input type=hidden name=SubC value="">
<input type=hidden name=ep value="">
<input type=hidden name=Occ value="">
<input type=hidden name=NombreC value="">
<input type=hidden name=TagActivo value="">
<input type=hidden name=Repetible value="">
<input type=hidden name=Formato_ex value="">