<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
global $Permiso;

$valortag = Array();
$arrHttp=Array();
global $arrHttp,$xFormato,$xFormatoFinal,$xFormatoRelacion,$valortag,$nombre;
include("../common/get_post.php");
require_once ("../config.php");

if (!isset($_SESSION["lang"])) $_SESSION["lang"]= $lang;
include ("../../lang/en/admin.php");
include ("../../lang/en/soporte.php");
include ("../../lang/".$_SESSION["lang"]."/admin.php");
include ("../../lang/".$_SESSION["lang"]."/soporte.php");
$arrHttp["lang"]=$_SESSION["lang"];
$arrHttp["login"]=$_SESSION["login"];
$arrHttp["password"]=$_SESSION["password"];
$arrHttp["startas"]=$_SESSION["permiso"];
function LeerRegistro() {

// en la variable $arrHttp vienen los parámetros que se le van a pasar al script .xis
// el índice IsisScript contiene el nombre del script .xis que va a ser invocado

// la variable $llave permite retornar alguna marca que esté en el formato de salida
// identificada entre $$LLAVE= .....$$

 $llave_pft="";
 global $llamada, $valortag,$maxmfn,$arrHttp,$OS,$Bases,$xWxis,$Wxis,$wxisUrl,$Mfn,$db_path;
 $IsisScript=$xWxis."/login.xis";
 $query = "?xx=&base=acces&cipar=$db_path"."par/acces.par"."&login=".$_SESSION["login"]."&password=".$_SESSION["password"];
 putenv('REQUEST_METHOD=GET');
 putenv('QUERY_STRING='.$query);
 $contenido="";

 exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
 $ic=-1;
 $tag= "";
 foreach ($contenido as $linea){
 	if ($ic==-1){    	$ic=1;
    	$pos=strpos($linea, '##LLAVE=');
    	if (is_integer($pos)) {
     		$llave_pft=substr($linea,$pos+8);
     		$pos=strpos($llave_pft, '##');
     		$llave_pft=substr($llave_pft,0,$pos);
		}
	}else{
		$linea=trim($linea);
		$pos=strpos($linea, " ");
		if (is_integer($pos)) {
			$tag=trim(substr($linea,0,$pos));
//
//El formato ALL envía un <br> al final de cada línea y hay que quitarselo
//

			if ($tag==100 or $tag==40){
				$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));
				if (isset($valortag[$tag])){
					$valortag[$tag].=$linea."\n";
				}else {
					$valortag[$tag]=$linea."\n";
				}
			}

		}
	}

}
return $llave_pft;
}

function VerificarUsuario(){
Global $arrHttp,$valortag,$Path,$xWxis,$session_id,$Permiso,$msgstr,$db_path,$nombre;
 	$llave=LeerRegistro();
 	if ($llave!=""){
  		$res=explode('|',$llave);
  		$userid=$res[0];
  		$_SESSION["mfn_admin"]=$res[1];
  		$mfn=$res[1];
  		$nombre=$res[2];
		$arrHttp["Mfn"]=$mfn;
  		$Permiso="|";
  		$P=explode("\n",$valortag[40]);
  		foreach ($P as $value){  			$value=substr($value,2);
  			$ix=strpos($value,'^');
    		$Permiso.=substr($value,0,$ix)."|";
    	}
 	}else{ 		echo "<script>
 		self.location.href=\"../../index.php?login=N\";
 		</script>";
  		die;
 	}
}

/////
/////   INICIO DEL PROGRAMA
/////


$query="";

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

	if (isset($arrHttp["lang"])) $_SESSION["lang"]=$arrHttp["lang"];
	include ("../../lang/".$_SESSION["lang"]."/admin.php");
	if (!isset($_SESSION["Expresion"])) $_SESSION["Expresion"]="";
	if (!isset($arrHttp["cambiolang"])){
		VerificarUsuario();
		$_SESSION["lang"]=$arrHttp["lang"];
		$_SESSION["login"]=$arrHttp["login"];
		$_SESSION["password"]=$arrHttp["password"];
		$_SESSION["permiso"]=$arrHttp["startas"];
		$_SESSION["nombre"]=$nombre;

		if (strpos($Permiso,'|'.$arrHttp["startas"].'|')===false){
    		echo "<h3>".$nombre."<p>".$msgstr["invalidright"]." ".$msgstr[$arrHttp["startas"]]."</h3>";
    		session_destroy();
    		die;
    	}
    }	$Permiso=$_SESSION["permiso"];	if (trim($Permiso)==""){		echo "Missing user rights";
		session_destroy();
		die;	}

	$bases=explode("\n",$valortag[100]);
	$arrHttp["base"]=$bases[0];
	$arrHttp["cipar"]=$arrHttp["base"].".par";
	$NombreBase="";
	$arrHttp["Opcion"]="STATUS";
	$arrHttp["IsisScript"]="control.xis";
	$llave=LeerRegistro();
	$stat=explode('|',$llave);
	$llave=substr($stat[2],7);
	echo "<HTML><title>ABCD</title>
				<head>
				<script languaje=javascript>
				self.resizeTo(screen.width,screen.height);
				var listabases=Array()
				var browseby=\"mfn\"

				var Expresion=\"\"
                var typeofrecord=''
				var mfn=0
				var maxmfn=0
				var Mfn_Search=0
				var Max_Search=0
				var Search_pos=0
				var db_permiso=''
				var NombreBase=''
				var ix_basesel=0
				var ix_langsel=0
				var Marc=''
				var base=''
				var cipar=''
				var Formato='ALL'
				var Permiso=\"$Permiso\"
				var tl=''
				var nr=''
				var xeliminar=0
				var xeditar=''
				var ModuloActivo=\"catalog\"
				var CG_actual=''
				var CG_nuevo=''
				var prefijo_indice=\"\"
				var formato_indice=\"\"
				ValorCapturado=''
				var NombreBaseCopiarde=''
				var wks=\"\"
				buscar=''
				lang='".$_SESSION["lang"]."'
				ep=''
				ConFormato=true
				Capturando=''
				function ActivarFormato(Ctrl){

					if (xeditar=='S'){
						alert('".$msgstr["aoc"]."')
						Ctrl.checked=!Ctrl.checked
						return
					}else{
						if (Ctrl.checked){
							ConFormato=true
						}else{
							ConFormato=false
						}
						if (mfn>0){
							mfn=mfn-1
							Menu('proximo')
						}
					}
				}
				function AbrirVentanaAyuda(){
					insWindow = window.open('ayudas/'+lang+'ayuda.html', 'Ayuda', 'location=no,width=700,height=550,scrollbars=yes,top=10,left=100,resizable');
					insWindow.focus()
				}
				function BrowseBySearch(){				}
			";

?>

function ApagarEdicion(){	top.menu.toolbar.hideButtons('2_editar');
	top.menu.toolbar.hideButtons('4_cancelar')
	top.menu.toolbar.hideButtons('4_guardar')
	top.menu.toolbar.hideButtons('4_eliminar')
	var item=top.menu.toolbar.getItem("0_primero"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("0_anterior"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("0_siguiente"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("0_ultimo"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("select"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("1_buscar"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("1_alfa"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("2_nuevo"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("2_capturar"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("2_z3950"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("2_editar"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("defaultval"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("3_imprimir"); //get item object by
	item.enable();
	var item=top.menu.toolbar.getItem("config"); //get item object by
	item.enable();
}

function PrenderEdicion(){	top.menu.toolbar.showButtons('2_editar');
	if (xeditar=="S"){
		top.menu.toolbar.showButtons('4_cancelar')
		top.menu.toolbar.showButtons('4_guardar')
		var item=top.menu.toolbar.getItem("0_primero"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("0_anterior"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("0_siguiente"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("0_ultimo"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("select"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("1_buscar"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("1_alfa"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("2_nuevo"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("2_capturar"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("2_z3950"); //get item object by
		item.disable(); //disable
		var item=top.menu.toolbar.getItem("2_editar"); //get item object by
		item.disable();
		var item=top.menu.toolbar.getItem("defaultval"); //get item object by
		item.disable();
		var item=top.menu.toolbar.getItem("3_imprimir"); //get item object by
		item.disable();
		var item=top.menu.toolbar.getItem("config"); //get item object by
		item.disable();
	}
	top.menu.toolbar.showButtons('4_eliminar')	if (Expresion!=""){		var item=top.menu.toolbar.getItem("select"); //get item object by id
		item.enable(); //enable	}
}

function ApagarCreacion(){	var item=top.menu.toolbar.getItem("select"); //get item object by id
	item.disable(); //disable}

function TipoDeRegistro(){	top.main.document.writeln("<html><body style='font-size:10px;font-family:arial'>")
	top.main.document.writeln("<center><br><br>")
	top.main.document.writeln("<h4>Seleccione el tipo de registro</h4><table>")
	tr=typeofrecord.split('$$$')
	ix=tr.length
	for (i=0;i<ix;i++){
		if (i>0){
			linea=tr[i].split('|')

			top.main.document.writeln("<tr><td><a href=\"javascript:top.wks='"+linea[0]+"';top.Menu('crear')\"><span style='font-size:10px;font-family:arial'>"+linea[3]+"</span></a></td>")
		}	}
	top.main.document.writeln("</table>")}

function Permisos(){	return true}

function ValidarIrA(){
  	xmfn=top.menu.document.forma1.ir_a.value

	var strValidChars = "0123456789";
   	if (xmfn.length == 0 || xmfn==0){
		alert("<?php echo $msgstr["especificarnr"]?>")
		return false
	}
	blnResult=true
   	//  test strString consists of valid characters listed above
   	for (i = 0; i < xmfn.length; i++){
    	strChar = xmfn.charAt(i);
    	if (strValidChars.indexOf(strChar) == -1){
    		blnResult = false;
    	}
    }
	if (blnResult==false){
		alert("<?php echo $msgstr["especificarvaln"]?>")
		return false
	}
	if (xmfn>maxmfn){
	  	alert("<?php echo $msgstr["numfr"]?>")
	  	return false
	}
	return xmfn
}

function Menu(Opcion){
    switch (Opcion){
		case "cancelar":
		case "actualizar":
		case "buscar":
	 	 ApagarEdicion()
		case "editar":
	  	break;
	}

	if (Opcion!="eliminar") xeliminar=0
	if (base=="" && Opcion!="administrar" &&Opcion !="database"){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	listabases[base]+='|'
	lb=listabases[base].split('|')
	Marc=lb[1];
	Capturando=''

    if (xeditar=="S" && Opcion!="cancelar" && Opcion!="eliminar" ){
     	alert("<?php echo $msgstr["aoc"]?>")
  		return
 	}
 	if (Opcion=="tabla" || Opcion=="ira"){

	 	xmfn=top.menu.document.forma1.ir_a.value
		if (xmfn=="")  {
		 	top.menu.document.forma1.ir_a.value=1
		}else{
		  	t=xmfn.split("/")
			top.menu.document.forma1.ir_a.value=t[0]
		}

	}
	works=""
	if (wks!="") works="&wks="+wks
    if (Opcion!="actualizar" && Opcion!="editar" && Opcion!="eliminar") xeditar=""

 	if (Opcion!="eliminar") xeliminar=0
	ix=top.encabezado.document.OpcionesMenu.formato.selectedIndex
	if (ix==-1) ix=0

	Formato=top.encabezado.document.OpcionesMenu.formato.options[ix].value
	FormatoActual="&Formato="+Formato+"&Diferido=N"
	if (browseby=="search"){
		tope=Max_Search

	}else{
		tope=maxmfn
	}
	switch (Opcion) {		case "editdv":
			top.main.location.href="default_edit.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			top.xeditar="valdef"
			break
		case "deletedv":
			top.main.location.href="default_delete.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			break
		case "recvalidation":
			if (mfn==0 && Mfn_Search==0){
  				alert("<?php echo $msgstr["selmod"]?>")
  				return
  			}
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
  			url="recval_display.php?&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit
  			recvalwin=window.open(url,"recval","width=350,height=300,resizable,scrollbars")
  			recvalwin.focus()
			break;		case "ejecutarbusqueda":
			Mfn_Search=1
			mfn=1

			top.main.document.location="fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from=1&ver=N"+FormatoActual+works

			break;
		case "administrar":
			top.main.location="administrar.php?base="+base+"&cipar="+cipar
			break;
		case "copiar_archivo":
			top.main.document.location="copiar_archivo.php?&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'imprimir':
  		 	top.main.document.location="../dbadmin/pft.php?Modulo=dataentry&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'global':
  		 	top.main.document.location="c_global.php?&base="+base+"&cipar="+cipar
			return;
  	  		break
		case 'tabla':
			xmfn=top.menu.document.forma1.ir_a.value
			res=ValidarIrA()
			mfn=Number(xmfn)
  			if (res){
   				Opcion="tabla"

  		 		top.main.document.location.href="actualizarportabla.php?Opcion=tabla&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=N"+FormatoActual+works
   				buscar=""
   			}
  	  		break
		case 'alfa':
			formato_ix=formato_indice+"'$$$'f(mfn,1,0)"
	    	Prefijo="&prefijo="+prefijo_indice+"&formato_e="+ formato_ix
			var width = screen.width-500
			url="alfa.php?opcion=autoridades&base="+base+"&cipar="+cipar+Prefijo
			msgwin=window.open(url,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=500,height=425,top=50,left="+width)
    		msgwin.focus()
			return
			break
  		case 'ayuda':
    		AbrirVentanaAyuda()
   			break
		case 'z3950' :
            Expresion=""
            Desplegar="N"
            xError="S"
            top.main.location.href="z3950.php?base="+base+"&cipar="+cipar+FormatoActual
            break
		case 'capturar_bd' :
			Capturando='S'
            Expresion=""
            Desplegar="N"
            xError="S"
            formato_ix=escape(formato_indice+"'$$$'f(mfn,1,0)" )
			width=screen.width
			msgwin=window.open("capturar_main.php?base="+base+"&cipar="+cipar+"&formato_e="+formato_ix+"&prefijo="+prefijo_indice+"&formatoactual="+FormatoActual+"&fc=cap&html=ayuda_captura.html","capturar")
			msgwin.focus()
//			parent.main.location.href="capturar_main.php?base="+base+"&cipar="+cipar+"&formato_e="+formato_indice+FormatoActual+"&fc=cap&html=ayuda_captura.html"
           	break
  		case 'proximo':

			if (mfn<=0) mfn=0
   			mfn++
   			if (mfn>tope) mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'anterior':
   			if (mfn<=0) mfn=1
   			if (mfn>1) mfn=mfn-1
   			Opcion="leer"
   			buscar=""
            if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'primero':
   			mfn=1
   			buscar=""
   			Opcion="leer"
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'ultimo':
   			mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break

  		case 'eliminar':
			if (mfn==0){
				alert("<?php echo $msgstr["seleliminar"]?>")
				return
			}
   			if (xeliminar==0){
    			alert("<?php echo $msgstr["confirmdel"]?>")
    			xeliminar=xeliminar+1
   			}else{
				if (xeditar=="S")
					Mfn_p=top.main.document.forma1.Mfn.value
				else
					if (browseby=="search")
						Mfn_p=Mfn_Search
					else
						Mfn_p=mfn

				if (Mfn_p=="New"){
					alert("<?php echo $msgstr["cancelnuevo"]?>")
					return
				}
				if (Mfn_p==0){
					alert("<?php echo $msgstr["seleliminar"]?>")
					return
				}
				if (xeliminar==""){
					alert("<?php echo $msgstr["confirmdel"]?>")
					xeliminar="1"
				}else{
					xeliminar=""
					xeditar=""
					top.main.document.location="fmt.php?Opcion=eliminar&base="+base+"&cipar="+cipar+"&Mfn="+Mfn_p+"&ver=N"+FormatoActual+works

				}
			}
			return
   			break
  		case 'ira':
  		  	xmfn=ValidarIrA()
			buscar=""
  			if (xmfn){
	  			if (ConFormato==true){
            		Opcion="ver"
        		}else{
         			Opcion="leer"
     			}
				mfn=xmfn
  		 	}
  			break
 		}

 //		if (Opcion!="buscar" &&Opcion != "ejecutarbusqueda" &&Opcion != "administrar" && Opcion !="database" && Opcion!="nuevo" && buscar!="" && Opcion!="otrabd" && Opcion!="capturar_bd" && Opcion!="cancelar" &&Opcion!="administrar" &&Opcion!="imprimir" ){
 // 			alert(Opcion)
 // 			alert("<?php echo $msgstr["selmod"]?>")
  //			return
// 		}

		if (Opcion=="editar"){

  			if (mfn==0 && Mfn_Search==0){
  				alert("<?php echo $msgstr["selmod"]?>")
  				return
  			}
  			xeditar="S"
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
  		 	top.main.document.location="fmt.php?Opcion=leer&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit+"&ver=N"+FormatoActual+works
  		 	return
  		}

		if (Opcion=="ver"){
  			top.main.document.location="fmt.php?Opcion=ver&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual
  			return
  		}
		if (Opcion=="leer" || Opcion=="cancelar"){
  			if (ConFormato==true){
            	Opcion="ver"
        	}else{
         		Opcion="leer"
     		}

            if (mfn<=0) mfn=1
            if (browseby=="mfn"){
  		 		top.main.document.location.href="fmt.php?Opcion="+Opcion+"&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+works
  			}else{
  				if (Opcion=="cancelar")mfn=Search_pos
  				top.main.document.location.href="fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from="+mfn+FormatoActual  			}
  			return
  		}


  		if (Opcion=="nuevo" || Opcion=="crear"){


			tipom=""
			if (typeofrecord!="" && Opcion=="nuevo"){				top.main.document.close()
				TipoDeRegistro()			}else{
			    xeditar="S"
	 			top.main.document.location="fmt.php?Opcion=nuevo&base="+base+"&cipar="+cipar+"&Mfn=New&ver=N"+FormatoActual+"&tipom="+tipom+works
	 		}
  			return
  		}

  		if (Opcion=="actualizar"){
  			if (xeditar!="S"){
  				alert('<?php echo $msgstr["menu_edit"]?>')
    			return
  			}

  			xeditar=''
  			top.main.document.forma1.Opcion.value="actualizar"
  			top.main.document.forma1.submit()
  		}

 		if (Opcion=="buscar"){
  			top.buscar='S'
			top.main.document.location="buscar.php?Opcion=formab&prologo=prologoact&desde=dataentry&base="+base+"&cipar="+cipar+FormatoActual
  			return
  		}

  		if (Opcion=="cancelar")
     			ApagarEdicion()
     		else
     			PrenderEdicion()

	}

function Unload(){
	self.location.href="unload.php"
	alert("Fin de Sesión")
}

</script>

</head>

<frameset rows=120,40,* cols=* border=0>
   <frame name=encabezado src=../dataentry/menubases.php?Opcion=Menu_o&base=acces&cipar=cipar.par&Mfn=<?php echo $arrHttp["Mfn"]?>  MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no FRAMEBORDER=NO>\n";
   <frame name=menu  src="index.php" scrolling=no frameborder=NO  marginheight=0   MARGINWIDTH=0 >
   <frame name=main src="homepage.htm" scrolling=yes frameborder=no marginheight=2   MARGINWIDTH=0 >
</frameset>
</HTML>

