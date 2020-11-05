<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");
include("../config.php");
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$meta_encoding\" />\n";
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
echo "<script>permiso='".$_SESSION["permiso"]["profilename"]."'</script>";
//include("../common/header.php");
$db=$arrHttp["base"];
?>

<script>
Ctrl_activo=""
lang='<?php echo $_SESSION["lang"]?>'
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13){
       switch (Ctrl_activo){       		case "blibre":
       			Buscar("TW_")
       			break
       		default:
       			top.Menu('ira')
       			break       }
	}

    return true;
  };

function FocoEn(Ctrl){	Ctrl_activo=Ctrl
}

function Diccionario(){

	ix=document.forma1.blibre.selectedIndex
	Prefijo=document.forma1.blibre.options[ix].value
	p=Prefijo.split('|')
	prefijo=p[0]
	nombrec=document.forma1.blibre.options[ix].text
	msgwin=window.open("","Diccionario","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,height=500,width=700")
	msgwin.focus()
	i=document.forma1.formato.selectedIndex
	document.diccio.Formato.value=document.forma1.formato.options[i].value
	document.diccio.campo.value=escape(nombrec)
	document.diccio.prefijo.value=prefijo
	document.diccio.id.value=p[1]
	document.diccio.Diccio.value="document.forma1.busqueda_palabras"
	document.diccio.submit()

}

function Buscar(Prefijo){

	ix=document.forma1.blibre.selectedIndex
	Prefijo=document.forma1.blibre.options[ix].value
	EB=Trim(document.forma1.busqueda_palabras.value)
	if (EB=="")
		return
	Expr=""
	p=Prefijo.split('|')
	Prefijo=p[0]
	if (p[1]=="W"){
		EB=EB.replace(/,/g,' ')
	    EB=EB.replace(/\./g,' ')
    	EB=EB.replace(/-/g,' ')
		EB=EB.replace(/  /g,' ')
		p=EB.split(" ")
		for (term in p){
			if (Trim(p[term])!=""){				if (Expr=="")
					Expr=Prefijo+p[term]
				else
					Expr+=" and "+Prefijo+p[term]
			}		}
	}else{		Expr=Prefijo+EB	}
	top.Expresion=Expr;
	top.Menu("ejecutarbusqueda")}
function AbrirAyuda(){
	msgwin=window.open("../documentacion/ayuda.php?help="+lang+"/dataentry_toolbar.html","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
		msgwin.focus()

}

function AyudaBusqueda(){	msgwin=window.open("http://abcdwiki.net/wiki/es/index.php?title=B%C3%BAsquedas","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
	msgwin.focus()}

function EditarFormato(){
	i=document.forma1.formato.selectedIndex
	if (i==-1){
	}else{
	  	pft=document.forma1.formato.options[i].value
	  	descripcion=document.forma1.formato.options[i].text
		if (pft!='ALL') {			document.editpft.base.value=top.base
			document.editpft.cipar.value=top.base+".par";
			document.editpft.archivo.value=pft
			document.editpft.descripcion.value=descripcion			msgwin=window.open("","editpft","width=800, height=400, scrollbars, resizable")
			document.editpft.submit()
			msgwin.focus()
		}else{

		}
	}}

function GenerarDespliegue(){
	base=top.base
	if (base==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	if(top.xeditar=="S"){
		alert("<?php echo $msgstr["aoc"]?>")

		return
	}
	i=document.forma1.formato.selectedIndex
	if (i==-1){
	}else{
	  	pft=document.forma1.formato.options[i].value
		if (pft!='ALL') {
		}else{
		}
	}
	top.Menu('same')
}

function GenerarWks(){
	base=top.base
	if (base==""){
		alert("<?php echo $msgstr["seldb"]?>")

	}
	if(top.xeditar=="S"){
		alert("<?php echo $msgstr["aoc"]?>")


	}
	i=document.forma1.wks.selectedIndex
	if (i==-1){
		top.wks=""
	}else{
	  	top.wks=document.forma1.wks.options[i].value
	}
}


</script>
</head>
<body bgcolor=#EDF3F3 text=#000000 LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 >
<form name=forma1 onsubmit="return false" method=post>
<link rel="STYLESHEET" type="text/css" href="js/dhtmlXToolbar.css">
<script language="JavaScript" type="text/javascript" src="js/dhtmlXProtobar.js"></script>
<script language="JavaScript" type="text/javascript" src="js/dhtmlXToolbar.js"></script>
<script language="JavaScript" type="text/javascript" src="js/dhtmlXCommon.js"></script>
<script language="JavaScript" type="text/javascript" src="js/lr_trim.js"></script>
<?php if (isset($_SESSION["screen_width"])){	      	$SW=$_SESSION["screen_width"];
	      	$TH=48;   	  	 }else{   	  	 	$SW=1200;
   	  	 	$TH=90;
   	  	 }
		if (isset($FRAME_2H) and $FRAME_2H!="") $TH=$FRAME_2H;
   ?>
<table width=100% bgcolor=#d4d0c8 cellpadding=0 cellspacing=0 border=0 height=<?php echo $TH?>>
	<td  valign=middle><font style="font-size:10px;font-family:arial;">&nbsp; &nbsp; <?php echo $msgstr["m_ir"]?>:<br>
		&nbsp; &nbsp; <input type=text  name=ir_a size=15 value='' onfocus="FocoEn('ira')" onClick="javascript:this.value=''" style="font-size:10px;font-family:arial">
   	</td>
   	<?php
   		$fst_file=file($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst");
   		$prefix_W="";
   		foreach ($fst_file as $value){
   			if (trim($value)!=""){
   				$fst[]=trim($value);

   			}
   		}
   		$pal="";
   	    if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab")){
	   		$fpb=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab");

	   		$pal="<select name=blibre onchange=\"document.forma1.busqueda_palabras.value='';\" style=\"width:190px\">";
	   		foreach ($fpb as $value){
	   			if (trim($value)!=""){	   				$y=explode('|',$value);
					$y[2]=trim($y[2]);
	   				foreach ($fst as $linea){
	   					if (stripos($linea,$y[2])>0){
	   						$y[2]=$y[2].'|';
	   						$linea=str_replace("  "," ",$linea);
	   						$it=explode(" ",$linea);
	   						if ($it[1]==8)
	   							$y[2].='W';
	   						break;
	   					}

	   				}
	   				$pal.="<option value=".trim($y[2]).">".trim($y[0]);
	   			}

	   		}
	   		$pal.="</select><a href=javascript:Diccionario()><img src=img/search.gif valign=ABSBOTTOM></a>";
	   		unset($fpb);
	  	}
   	?>
   	<td  valign=middle style=line-height:20px><font style="font-size:10px;font-family:arial">
   	<?php echo $msgstr["buscar"]." ".$pal;
   	if ($SW<1200 or $TH>48)
   		echo "&nbsp; &nbsp; ";
   	else
   		echo "<br>";
   	?>
   	<input type=text  name=busqueda_palabras onfocus="FocoEn('blibre')" size=40 value='' style="font-size:10px;font-family:arial">
   	<a href=Javascript:AyudaBusqueda()><img src=img/question.gif valign=bottom textalign=bottom></a>

   	</td>
   	<td width=5>&nbsp; </td>
   	<?php 	if ($SW<1200 or $TH>48)
				echo "<tr><td valign=center colspan=3>";
		   	else
		   		echo "<td valign=center>";
	?>
		   <div id="toolbarBox" style="height:30;position:relative"></div></td>
    <td align=right>
       	<table cellspacing=0 cellpadding=0>

			<?php if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
       		    	  isset($_SESSION["permiso"]["CENTRAL_EDPFT"]) or
        			  isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or
	    			  isset($_SESSION["permiso"][$db."_CENTRAL_EDPFT"])){	    	?>
	    	<td rowspan=2 valign=top>
	    	         <a href=javascript:EditarFormato()><img src=img/barEdit.png alt="edit display format" title="edit display format" border=0></a>
	    	</td>
       		<?php } ?>
       		<td align=right>
       		          <font style="font-size:7pt"><?php echo $msgstr["displaypft"]?>:</td>

			<td><select name=formato onChange=Javascript:GenerarDespliegue()  style="width:90;font-size:8pt;font-family:arial narrow">
				<option></option>
				</select>
			</td>
	  	 <tr><td align=right><font style="font-size:7pt"><?php echo $msgstr["fmt"]?>:&nbsp; </td><td>
				<select name=wks onChange=Javascript:GenerarWks() style="width:90;font-size:8pt;font-family:arial narrow">
					<option></option>
				</select>
			</td>
		</table>
	</td>
	<td width=3>&nbsp;</td>
</table>
<script>

	//horisontal toolbar
	toolbar=new dhtmlXToolbarObject("toolbarBox","400","24","ABCD");
	toolbar.setOnClickHandler(onButtonClick);
	toolbar.addItem(new dhtmlXImageButtonObject('img/barArrowLeft2.png',18,24,1,'0_primero','<?php echo $msgstr["m_primero"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('img/barArrowLeft.png',18,24,2,'0_anterior','<?php echo $msgstr["m_anterior"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('img/barArrowRight.png',18,24,3,'0_siguiente','<?php echo $msgstr["m_siguiente"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('img/barArrowRight2.png',18,24,4,'0_ultimo','<?php echo $msgstr["m_ultimo"]?>'))
    toolbar.addItem(new dhtmlXSelectButtonObject('select',',mfn,search,selected_records,undo_selected','<?php echo $msgstr["browse"]?>,Mfn,<?php echo $msgstr["busqueda"]?>,<?php echo $msgstr["selected_records"]?>,<?php echo $msgstr["undo_selected"]?>','browse',100,100,''))
   //	toolbar.addItem(new dhtmlXSelectButtonObject('select',',mfn,search','<?php echo $msgstr["browse"]?>,Mfn,<?php echo $msgstr["busqueda"]?>','browse',100,100,''))
    toolbar.addItem(new dhtmlXToolbarDividerXObject('div_1'))
    toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarSearch.png","20","20",5,"1_buscar","<?php echo $msgstr["m_buscar"]?>"))
    toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarSearchHistory.png","20","20",5,"search_history","<?php echo $msgstr["m_history"]?>"))

   <?php if (isset($tesaurus)) {?>
   	 toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarTesaurus.gif","20","20",5,"tesaurus","<?php echo $msgstr["m_tesaurus"]?>"))
	<?php }?>
	 toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarfreesearch.jpg","20","20",5,"1_busquedalibre","<?php echo $msgstr["m_busquedalibre"]?>"))
	toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarOrder.png","20","20",6,"1_alfa","<?php echo $msgstr["m_indice"]?>"))
	toolbar.addItem(new dhtmlXToolbarDividerXObject('div_2'))
	<?php

	//CHECK IF THE DATABASE ACCEPT IMPORT pdf
	$pdf="";
  	if (isset($def["IMPORTPDF"]))
		$pdf=trim($def["IMPORTPDF"]);
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_CREC"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_CREC"])) {	?>		toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarNew.png","16","16",7,"2_nuevo","<?php echo $msgstr["m_crear"]?>"))
	<?php
		if ($pdf=="Y"){
    ?>
		toolbar.addItem(new dhtmlXImageButtonObject("img/import.gif","16","16",7,"2_nuevoHTML","<?php echo "IMPORT DOC"?>"))

	<?php } }
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_CAPTURE"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_CAPTURE"])){
	?>
		toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarCopy.png","18","24",9,"2_capturar","<?php echo $msgstr["m_capturar"]?>"))
	<?php }
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_Z3950CAT"])){
	?>
		toolbar.addItem(new dhtmlXImageButtonObject("img/z3950.png","18","16",19,"2_z3950","<?php echo $msgstr["m_z3950"]?>"))
	<?php }
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_VALDEF"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_VALDEF"])){
	?>
		toolbar.addItem(new dhtmlXToolbarDividerXObject('xedit'))
		toolbar.addItem(new dhtmlXSelectButtonObject('defaultval',',editdv,deletedv','<?php echo $msgstr["valdef"]?>,<?php echo $msgstr["editar"]?>,<?php echo $msgstr["eliminar"]?>','',80,80,''))
		toolbar.addItem(new dhtmlXToolbarDividerXObject('div_5'))
	<?php }
	if ((isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_BARCODE"]))
	    and (isset($_SESSION["BARCODE"])or isset($_SESSION["BARCODE_SIMPLE"]))){
	?>

	toolbar.addItem(new dhtmlXImageButtonObject("img/barcode.png","20","24",13,"barcode","<?php echo "barcode"?>"))
	<?php
	}
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
	    isset($_SESSION["permiso"]["CENTRAL_PREC"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or
	    isset($_SESSION["permiso"][$db."_CENTRAL_PREC"])){
	?>
		toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarPrint.png","20","24",12,"3_imprimir","<?php echo $msgstr["m_reportes"]?>"))
		//toolbar.addItem(new dhtmlXImageButtonObject("img/mail_p.png","26","24",14,"email","<?php echo $msgstr["m_email"]?>"))
	<?php }
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"])      or
	    isset($_SESSION["permiso"]["CENTRAL_UTILS"])    or
	    isset($_SESSION["permiso"]["CENTRAL_IMPEX"])    or
	    isset($_SESSION["permiso"]["CENTRAL_GLOBC"])    or
	    isset($_SESSION["permiso"]["CENTRAL_IMPORT"])   or
	    isset($_SESSION["permiso"]["CENTRAL_EXPORT"])   or
	    isset($_SESSION["permiso"]["CENTRAL_COPYDB"])   or
	    isset($_SESSION["permiso"]["CENTRAL_UNLOCKDB"]) or
	    isset($_SESSION["permiso"]["CENTRAL_LISTBKREC"])   or
	    isset($_SESSION["permiso"]["CENTRAL_UNLOCKDBREC"]) or
	    isset($_SESSION["permiso"]["CENTRAL_FULLINV"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])    or
	    isset($_SESSION["permiso"][$db."_CENTRAL_UTILS"])  or
	    isset($_SESSION["permiso"][$db."_CENTRAL_IMPEX"])  or
	    isset($_SESSION["permiso"][$db."_CENTRAL_GLOBC"])  or
	    isset($_SESSION["permiso"][$db."_CENTRAL_IMPORT"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_EXPORT"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_COPYDB"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDB"])  or
	    isset($_SESSION["permiso"][$db."_CENTRAL_LISTBKREC"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_FULLINV"]) or
	    isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDBREC"])
	    ){
	?>

		toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarTool.png","20","24",13,"config","<?php echo $msgstr["mantenimiento"]?>"))
	<?php }?>
	toolbar.addItem(new dhtmlXImageButtonObject("img/refresh0.gif","20","24",14,"refresh_db","<?php echo $msgstr["refresh_db"]?>"))
	toolbar.addItem(new dhtmlXToolbarDividerXObject('div_5'))

<?php $select="";
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_STATGEN"])  or isset($_SESSION["permiso"]["CENTRAL_STATCONF"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])   or isset($_SESSION["permiso"][$db."_CENTRAL_STATGEN"])  or isset($_SESSION["permiso"][$db."_CENTRAL_STATCONF"])){
?>
	toolbar.addItem(new dhtmlXImageButtonObject("img/grafico.gif","24","24",13,"stats","<?php echo $msgstr["estadisticas"]?>"))
<?PHP }?>
	toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarHelp.png","16","24",14,"5_ayuda","<?php echo $msgstr["m_ayuda"]?>"))
	toolbar.addItem(new dhtmlXToolbarDividerXObject('div_6'))

	toolbar.addItem(new dhtmlXImageButtonObject("img/toolbarHome.png","16","24",14,"home","<?php echo $msgstr["inicio"]?>"))
	toolbar.showBar();
	function onButtonClick(itemId,itemValue){
		switch (itemId){
			<?php echo $select;?>
			case "select":
				switch (itemValue){
					case "mfn":
						top.browseby="mfn"
						top.mfn=top.Mfn_Search -1
						top.maxmfn=999999999
						if (top.mfn<=0) top.mfn=1
						top.Menu("proximo")
						break
					case "search":
						if (top.Expresion==""){
							alert("<?php echo $msgstr["faltaexpr"]?>")
							var item=top.menu.toolbar.getItem('select');
    						item.selElement.options[0].selected =true
							return
						}
						top.browseby="search"
						top.mfn=top.Search_pos -1
						if (top.mfn<=0) top.mfn=1
						top.Menu("proximo")
						break
					case "selected_records":
						if (top.RegistrosSeleccionados==""){							alert("<?php echo $msgstr["no_sel_records"]?>")
							var item=top.menu.toolbar.getItem('select');
    						item.selElement.options[0].selected =true
							return						}
						top.browseby="selected_records"
						top.Listar_pos=top.Listar_pos-1
						if (top.Listar_pos<-1) top.Listar_pos=-1
						top.Menu("proximo")
						break
					case "undo_selected":
						top.RegistrosSeleccionados=""
						alert("Ya no hay registros seleccionados")
						top.browseby="mfn"

						top.Listar_pos=-1
				}
				break
			case "defaultval":
				top.Menu(itemValue)
				var item=top.menu.toolbar.getItem('defaultval');
				item.selElement.options[0].selected =true
				break
			case "database":
				top.Menu('database')
				break;
			case "b_lang":
				top.location.href="inicio_main.php?Opcion=admin&lang="+itemValue+"&cipar=bases.par&cambiolang=S"
				return;
			case "config":
				top.Menu('administrar')
				break;
			case "0_ir":
				top.Menu('ira')
				break
			case "0_primero":
				top.Menu('primero')
				break
			case "0_anterior":
				top.Menu('anterior')
				break
			case "0_siguiente":
				top.Menu('proximo')
				break
			case "0_ultimo":
				top.Menu('ultimo')
				break
			case "1_alfa":
				top.Menu('alfa')
				break
			case "1_buscar":
				top.Menu('buscar')
				break
			case "1_tabla":
				top.Menu('tabla')
				break
			case "1_busquedalibre":
				top.Menu('busquedalibre')
				break
			case "2_nuevo":
				top.Menu('nuevo')
				break
			case "2_nuevoHTML":
				top.Menu("importarHTML")
				break
			case "2_editar":
				top.Menu('editar')
				break
			case "2_z3950":
				top.Menu('z3950')
				break
			case "2_capturar":
				top.Menu('capturar_bd')
				break
			case "4_eliminar":
				top.Menu('eliminar')
				break
			case "4_guardar":
				if (top.xeditar!="S"){
  					alert("<?php echo $msgstr["menu_edit"]?>")
    				return
  				}
				top.main.EnviarForma()
				break
			case "4_cancelar":
				if (top.xeditar!="S" && top.xeditar!="valdef"){
  					alert("<?php echo $msgstr["menu_canc"]?>")
    				return
  				}
				top.Menu('cancelar')
				break
			case "addcopies":
			    top.Menu('addcopies')
			    break
			case "5_ayuda":
				AbrirAyuda()
				break
			case "3_cglobal":
				top.Menu('global')
				break
			case "3_imprimir":
				top.Menu('imprimir')
				break
			case "stats":
				top.Menu('stats')
				break;
			case "refresh_db":
				top.Menu('refresh_db')
				break
			case "barcode":
				top.Menu('barcode')
				break;
			case "home":
				top.Menu('home')
                break;
    		case "search_history":
    			top.SearchHistory()
    			break;
    		case "tesaurus":
    			top.Tesaurus()
    			break;
    		case "email":
    			top.Mail()
    			break
		}
	};


</script>

	</form>
	<script>
		top.ModuloActivo="catalog"

	</script>
<script>
<?php
unset($fp);
if (isset($arrHttp["base"])){
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat")){
		$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat");
	}else{
		if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat")){
			$fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat");
		}
	}
	$i=-1;
	if (isset($fp)) {
		foreach($fp as $linea){
			if (trim($linea)!="") {
				$linea=trim($linea);
				$ll=explode('|',$linea);
				$cod=$ll[0];
				$nom=$ll[1];
				if (isset($_SESSION["permiso"][$db."_pft_ALL"]) or isset($_SESSION["permiso"][$db."_pft_".$ll[0]])
						or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
					$i=$i+1;
					echo "if (top.ModuloActivo==\"catalog\") top.menu.document.forma1.formato.options[$i]=new Option('$nom','$cod')\n";
				}
			}
		}

	}else{		echo "document.forma1.formato.options.length=0\n";	}
	$i=$i+1;
	if (isset($_SESSION["permiso"][$db."_pft_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])

	){
		echo "document.forma1.formato.options[$i]=new Option('".$msgstr["all"]."','')\n";
		echo "document.forma1.formato.options[$i+1]=new Option('".$msgstr["noformat"]."','ALL')\n";
	}
	unset($fp);
	//Se leen las hojas de entrada disponibles
	if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks")){
		$fp = file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks");
	}else{
		if (file_exists($db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks"))
			$fp = file($db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks");
	}
	$i=-1;
	if (isset($_SESSION["permiso"][$db."_fmt_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) ){		echo "if (top.ModuloActivo==\"catalog\") top.menu.document.forma1.wks.options[0]=new Option('','')\n";
		$i=0;	}


	$wks_p=array();
	$wks_p=array();
	if (isset($fp)) {
		foreach($fp as $linea){
			if (trim($linea)!="") {
				$linea=trim($linea);
				$l=explode('|',$linea);
				$cod=trim($l[0]);
				$nom=trim($l[1]);
				if (isset($_SESSION["permiso"][$db."_fmt_ALL"]) or isset($_SESSION["permiso"][$db."_fmt_".$cod])
						or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
					$i=$i+1;
					$wks_p[$cod]="Y";
					echo "if (top.ModuloActivo==\"catalog\") top.menu.document.forma1.wks.options[$i]=new Option('$nom','$cod')\n";
				}
			}
		}
	}
	$i=$i+1;
}

//Se lee la tabla de tipos de registro
unset($fp);
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab")){
	$fp = file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab");
}else{
	if (file_exists($db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab"))
		$fp = file($db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab");
}
$i=0;
$typeofr="";
if (isset($fp)) {
	foreach($fp as $linea){
           if ($i==0){
           	$l=explode(" ",$linea);
           	echo "top.tl='".trim($l[0])."'\n";
           	if (isset($l[1]))
           		echo "top.nr='".trim($l[1])."'\n";
           	else
           	    echo "top.nr=''\n";
           	$i=1;
           }else{
			if (trim($linea)!="") {
				$l=explode('|',$linea);
				$cod=$l[0];
				$ix=strpos($cod,".");
				$cod=substr($cod,0,$ix);
				if (isset($wks_p[$cod]))
					$typeofr.=trim($linea)."$$$";
    		}
		}
	}
	echo "top.typeofrecord=\"$typeofr\"\n";
}else{
	echo "top.typeofrecord=\"\"\n";
}
if (isset($arrHttp["inicio"]) and $arrHttp["inicio"]=="s"){
	echo 'top.main.location.href="inicio_base.php?inicio=s&base="+top.base+"&cipar="+top.base+".par&per="+top.db_permiso';
}else{	if (!isset($arrHttp["reload"]))
		echo "url=top.main.location.href
	top.main.location.href=url\n";
}
?>
</script>
<form name=editpft method=post action=../dbadmin/leertxt.php target=editpft>
<input type=hidden name=desde value=dataentry>
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=archivo>
<input type=hidden name=descripcion>
</form>
<form name=diccio method=post action=../dataentry/diccionario.php target=Diccionario>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Formato value="">
<input type=hidden name=Opcion value=diccionario>
<input type=hidden name=prefijo value="">
<input type=hidden name=campo value="">
<input type=hidden name=id value="">
<input type=hidden name=Diccio value="">
<input type=hidden name=Decode value="">
<input type=hidden name=toolbar value="Y">
<input type=hidden name=desde value=dataentry><input type=hidden name=prologo value=prologoact>
</form>

</body>
</html>

