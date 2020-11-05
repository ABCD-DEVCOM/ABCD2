<?php  session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "<xmp>$var=$value</xmp>";
include("../config.php");

include ("../lang/admin.php");
include("../common/header.php");

//if (!isset($arrHttp["is_marc"]))   $arrHttp["is_marc"]="";

$fp=explode("\n",$arrHttp["SubC"]);
$subc="";
foreach ($fp as $linea){
	$linea=trim($linea);
	if (trim($linea)!=""){
		$l=explode('|',$linea);
		$subc.=$l[5];
	}
}
//echo $subc;
$ix=-1;
echo "<script>\n";
$base=$arrHttp["base"];
if (!isset($arrHttp["is_marc"]))  $arrHttp["is_marc"]="N";
if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$base."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$base."_ACTPICKLIST"])){
    echo "act_picklist='Y'\n";
}else{
    echo "act_picklist='N'\n";
}
echo "is_marc='".$arrHttp["is_marc"]."'\n";
echo "PickList=new Array()\n";
echo "NamePickList=new Array()\n";
echo "SubCampos=new Array()\n";
foreach ($fp as $linea){	$linea=trim($linea);
	//echo $linea."<br>";	if (trim($linea)!=""){
		$l=explode('|',$linea);
		$ix=$ix+1;
		if ($l[0]=="S") {			$ind_sc=$ix;
	        $Ind="";
	        if ($ind_sc<2 and $arrHttp["is_marc"]=="S"){
	           	if (substr($subc,$ind_sc,1)==1 or substr($subc,$ind_sc,1)==2)
	           		$Ind="I";
	        }
	        $key=$Ind.substr($subc,$ind_sc,1);
			if (trim($l[11])!=""){
				echo "NamePickList['".$key."']='".$l[11]."'\n";
				PickList($key,$l[11]);			}else{
				$l=$ix-1;
				echo "PickList['".$key."']=''\n";			}
			echo "SubCampos['$key']='$key'\n";		}else{		}	}}
echo "mod_picklist=\"".$msgstr["mod_picklist"]."\"\n";
echo "reload_picklist=\"".$msgstr["reload_picklist"]."\"\n";
?>
function RefrescarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.refrescarpicklist.picklist.value=tabla
	document.refrescarpicklist.Ctrl.value=Ctrl
	document.refrescarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=20,height=10,scrollbars, resizable")
	document.refrescarpicklist.submit()
	msgwin.focus()
}

function AgregarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.agregarpicklist.picklist.value=tabla
	document.agregarpicklist.Ctrl.value=Ctrl
	document.agregarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=600,height=500,scrollbars, resizable")
	document.agregarpicklist.submit()
	msgwin.focus()
}

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
			op[1]=op[0]
		var newOpt =Sel.appendChild(document.createElement('option'));
    	newOpt.text = op[1];
    	newOpt.value = op[0];
    	if (op[0]==ValorOpcion)
    		newOpt.selected=true
	}
}

function EnviarArchivo(Tag,subc){

		msgwin=window.open("","Upload","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=180,top=100,left=5");
		msgwin.document.close();
		msgwin.document.writeln("<html><title><?php echo $msgstr["uploadfile"]?></title><body link=black vlink=black bgcolor=white>\n");
		msgwin.document.writeln("<form name=upload action=upload_img.php method=POST enctype=multipart/form-data>\n");
		msgwin.document.writeln("<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>\n");
		msgwin.document.writeln("<input type=hidden name=Tag value="+Tag+">")
		msgwin.document.writeln("<input type=hidden name=subc value=\""+subc+"\">")
		msgwin.document.writeln("  <?php echo $msgstr["storein"]?>: <input type=text name=storein size=40 value=\"\" onfocus=blur()>\n");
		msgwin.document.writeln(" <a href=dirs_explorer.php?Opcion=explorar&base=<?php echo $arrHttp["base"]?>&tag="+Tag+" target=_blank>explorar</a>")
		msgwin.document.writeln("<br>");
		msgwin.document.writeln("<table width=100%>");
		msgwin.document.writeln("<tr><td class=menusec1><?php echo $msgstr["archivo"]?></td><td class=menusec1></td>\n");
		msgwin.document.writeln("<tr><td><input name=userfile[] type=file size=50></td><td></td>\n");
		msgwin.document.writeln("</table>\n");
		msgwin.document.writeln("  <input type=submit value='<?php echo $msgstr["uploadfile"]?>'>\n");
		msgwin.document.writeln("</form>\n");
		msgwin.document.writeln("</body>\n");
		msgwin.document.writeln("</html>\n");
		msgwin.focus()  ;
	}

<?php
echo "</script>\n";

?>
<STYLE type=text/css>TABLE {	BACKGROUND-COLOR: #ffffff; FONT-FAMILY: Verdana, Helvetica, Arial; FONT-SIZE: 8pt}BODY {	FONT-FAMILY: Verdana, Helvetica, Arial; FONT-SIZE: 8pt}
input 		{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}select 		{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}textarea	{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}text		{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}checkbox	{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}</STYLE></head><script language="JavaScript" type="text/javascript" src=js/terminoseleccionado.js?<?php echo time(); ?>></SCRIPT><script language="JavaScript" type="text/javascript" src=js/lr_trim.js></SCRIPT><script language=javascript>
	base=window.opener.top.base
	url_indice=""
	Ctrl_activo=""
	function getElement(psID) {	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}
	function AbrirIndiceAlfabetico(xI,Prefijo,SubC,Separa,db,cipar,tag,Formato){		Ctrl_activo=getElement(xI)
	    document.forma1.Indice.value=xI
	    Separa="&delimitador="+Separa	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+xI+Prefijo+"&indice="+xI+"&repetible=0"+"&Formato="+Formato+"&postings=10&sfe=s"  		msgwin=window.open(url_indice,"indice","width=600, height=520,resizable, scrollbar")
  		msgwin.focus()    	return

	}
function AbrirTesauro(Tag,base){
		Url="../tesaurus/index.php?base="+base+"&Tag="+Tag
		myleft=screen.width-450
		msgwin=window.open(Url,"Tesauro","width=450, height=530,  scrollbars, status, resizable location=no, left="+myleft)
		msgwin.focus()
	}

	function AbrirIndice(ira){		url_indice=url_indice+ira	    ancho=screen.width-500-20		msgwin=window.open(url_indice,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=520,top=20,left="+ancho)		msgwin.focus()	}

	function Ayuda(tag,help){

		if (help!=""){			url=help		}else{

			url="../documentacion/ayuda_db.php?&base="+base+"&campo=tag_"+tag+".html"
		}
		msgwin=window.open(url,"Ayuda","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=400,top=100,left=100")
		msgwin.focus()	}

</script><body>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/assist_sc.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
	<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/assist_sc.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: campos.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
<body link=black vlink=black bgcolor=white>

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
<form name=forma1>

<input type=hidden name=tagcampo><input type=hidden name=occur><input type=hidden name=ep><input type=hidden name=NoVar><input type=hidden name=Indice value=""><input type=hidden name=base><input type=hidden name=cipar>
<input type=hidden name=Formato>
<input type=hidden name=Repetible><input type=hidden name=Indice>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class=td2>    <tr>
    	<td>			<script language="JavaScript" type="text/javascript" src=js/editarocurrencias.js?<?php echo time(); ?>></SCRIPT>
		</td>
	<tr>
		<td id="asubc">
		</td>	<tr>		<td><br>		<!--	<font size=1>Use los símbolos <img src=../img/add.gif> y <img src=../img/delete.gif> para agregar o eliminar ocurrencias respectivamente.            Cuando agregue una ocurrencia, la misma se adicionará al menú de selección cuando haga clic sobre <img src=../img/aceptar.gif alt='Aceptar estos cambios' border=0 height=15>.			Al terminar la edición del campo, haga clic sobre <img src=../img/pasaraldocumento.gif alt='Pasar al registro' border=0 height=15> para actualizar el formulario de ingreso.			Si no desea pasar los cambios al formulario, haga clic sobre <img src=../img/cancelar.gif alt='cancelar la edición del campo' border=0 height=15>-->		</td></table><br><center><table width=200 bgcolor=#FFFFFF border=0 cellspacing=5>	<td align=center>		<a href=javascript:AceptarCambios()><img src=img/aceptar.gif  border=0><br><?php echo $msgstr["aceptar"]?></a>	</td>	<td align=center><a href=javascript:ActualizarForma()><img src=img/pasaraldocumento.gif  border=0><br><?php echo $msgstr["actualizar"]?></a>	</td>
	<td align=center>
		<a href="javascript:self.close()"><img src=img/cancelar.gif  border=0><br><?php echo $msgstr["cancelar"]?></a>
	</td></table><script language=javascript>
  	if (Occ>0) {  		TerminoSeleccionado()
  	}else{
  		Redraw("")  	}</script></form>
</center>
</div>
</div>
<?php include("../common/footer.php")?><p></body></html>
<?php
// ===============================================
function PickList($ix,$file){
global $db_path,$lang_db,$arrHttp;
	$Options="";	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$file;
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$file;
	$fp=array();
	if (file_exists($archivo)){		$fp=file($archivo);
		$Options="";
		foreach ($fp as $value) {			$value=rtrim($value);
			if ($value!=""){				$Options.=$value.'$$$$';			}		}	}else{		$Options='$$$$';	}
	echo "PickList['$ix']='".str_replace("'","&#39;",$Options)."'\n";}
?>

