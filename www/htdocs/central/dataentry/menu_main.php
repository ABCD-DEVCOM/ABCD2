<?php
/* Modifications
2021-01-05 fho4abcd Modified comment for button with incorrect reference. This restores button bar.
2021-05-03 fho4abcd Correct header. Ensures that encoding fits with db encoding+header with DOCTYPE
2021-05-03 fho4abcd Rewrite html: standardized & improved layout
2021-08-02 fho4abcd Import PDF in menu bar
2021-08-29 fho4abcd Modified Import PDF into Upload Document
2021-12-08 fho4abcd Quick search layout + some translations + translation/modify edit pft button+removed some dividers.Code layout more readable
2023-01-19 fho4abcd Menu "default" to buttons + removed unused size parameters
2023-01-20 fho4abcd Use better buttons for "default".
2023-01-27 fho4abcd Layout improvements+more titles. Moved code for field dropdown to inline
2023-01-29 fho4abcd quick fix to make browse by menu work again
2023-02-03 fho4abcd Improve browse by, add code for selected records
2024-04-02 fho4abcd More translations, layout
2024-06-06 fho4abcd Free search->Search, result in list
2025-02-12 rogercgui Check if the.fst file exists before trying to open it
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
$db=$arrHttp["base"];


// Check if the.fst file exists before trying to open it
$fst_path = $db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst";
if (file_exists($fst_path)) {
  $fst_file = file($fst_path);

  $prefix_W="";
  foreach ($fst_file as $value){
      if (trim($value)!=""){
          $fst=trim($value);
      }
  }
} else {
  echo "<h4>".$msgstr["misfile"]." ".$fst_path."</h4>";
}


?>

<body class="toolbar-dataentry">
<script>permiso='<?php echo $_SESSION["permiso"]["profilename"]?>'</script>

<script>
Ctrl_activo=""
lang='<?php echo $_SESSION["lang"]?>'
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13){
       switch (Ctrl_activo){
       		case "blibre":
       			Buscar("TW_")
       			break
       		default:
       			top.Menu('ira')
       			break
       }
	}
    return true;
  };

function FocoEn(Ctrl){
	Ctrl_activo=Ctrl
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
			if (Trim(p[term])!=""){
				if (Expr=="")
					Expr=Prefijo+p[term]
				else
					Expr+=" and "+Prefijo+p[term]
			}
		}
	}else{
		Expr=Prefijo+EB
	}
	top.Expresion=Expr;
	top.Menu("ejecutarbusqueda")
}
function AbrirAyuda(){
	msgwin=window.open("../documentacion/ayuda.php?help="+lang+"/dataentry_toolbar.html","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
    msgwin.focus()
}

function EditarFormato(){
	i=document.forma1.formato.selectedIndex
	if (i==-1){
	}else{
	  	pft=document.forma1.formato.options[i].value
	  	descripcion=document.forma1.formato.options[i].text
		if (pft!='ALL') {
			document.editpft.base.value=top.base
			document.editpft.cipar.value=top.base+".par";
			document.editpft.archivo.value=pft
			document.editpft.descripcion.value=descripcion
			msgwin=window.open("","editpft","width=800, height=400, scrollbars, resizable")
			document.editpft.submit()
			msgwin.focus()
		}else{

		}
	}
}

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
<form name=forma1 onsubmit="return false" method=post>
<script language="JavaScript" type="text/javascript" src="js/dhtmlXProtobar.js?<?php echo time();?>"></script>
<script language="JavaScript" type="text/javascript" src="js/dhtmlXToolbar.js?<?php echo time();?>"></script>
<script language="JavaScript" type="text/javascript" src="js/dhtmlXCommon.js?<?php echo time();?>"></script>
<script language="JavaScript" type="text/javascript" src="js/lr_trim.js?<?php echo time();?>"></script>

<!--SETS UP THE DATA ENTRY TOOLBAR-->
<table class="toolbar-dataentry" >
    <tr> <!-- row with cells for the toolbar top row-->
        <td class="ph-10">
        <!-- goto record -->
        <label><?php echo $msgstr["m_ir"]?></label>
        <input type=text  name=ir_a size=15 value=''
			title='<?php echo $msgstr["m_typerecno"]." &rarr; ".$msgstr["src_enter"]?>'
			onfocus="FocoEn('ira')" onClick="javascript:this.value=''" >
		<td class="ph-10">
        <!-- quick search -->
		<?php
        // Create the label + dropdown + icon for the quick serach
        if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab")){
            $fpb=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab");
            ?>
			<label for="blibre"><?php echo $msgstr["m_searchby"]?></label>
            <select id=blibre name=blibre onchange="document.forma1.busqueda_palabras.value=''" title='<?php echo $msgstr["selcampob"];?>'>
            <?php
            foreach ($fpb as $value){
                if (trim($value)!=""){
                    $y=explode('|',$value);
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
                    ?>
                    <option value="<?php echo trim($y[2])?>" ><?php echo trim($y[0]);?></option>
                    <?php
                }
            }
            unset($fpb);
            ?>
            </select>
            <a class='btn-toolbar-blue' href="javascript:Diccionario()">
                <i class='fab fa-searchengin' title="<?php echo $msgstr["m_quicksrcwith"]?>"></i>
            </a>
			<input style="width:30%" type="text"  name="busqueda_palabras" onfocus="FocoEn('blibre')" value=''
				title="<?php echo $msgstr["m_enterterms"];?>">
            <?php
        }
        ?>
		</td>
		<td class="ph-10">
        <div class="GenerarWks">	
            <label><?php echo $msgstr["displaypft"]?> </label>
            <select name=formato onChange="Javascript:GenerarDespliegue()">
            </select>
            <?php
            if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
                isset($_SESSION["permiso"]["CENTRAL_EDPFT"]) or
                isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or
                isset($_SESSION["permiso"][$db."_CENTRAL_EDPFT"])){
                ?>
                <a class="btn-toolbar-blue" href="javascript:EditarFormato()">
                    <i class="fas fa-edit" alt="edit display format" title="<?php echo $msgstr["m_editdispform"];?>"></i>
                </a>
            <?php } ?>
        </div>
        </td>
    </tr>
    <tr><!-- row and cell with toolbar object + worksheet select-->
        <td class="ph-10" colspan=3>
            <div id="toolbarBox" style="position:relative"></div>
            <div class="GenerarWks">
                <label><?php echo $msgstr["fmt"]?> </label>
                <select name="wks" onChange="Javascript:GenerarWks()"></select>
            </div>
        </td>
    </tr>
</table>



<script>
    //horizontal toolbar
    toolbar=new dhtmlXToolbarObject("toolbarBox","400","24","ABCD");
    toolbar.setOnClickHandler(onButtonClick);
    toolbar.addItem(new dhtmlXImageButtonObject('../../assets/svg/catalog/ic_fluent_arrow_previous_24_regular.svg',24,24,1,'0_primero','<?php echo $msgstr["m_primero"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('../../assets/svg/catalog/ic_fluent_ios_arrow_left_24_regular.svg',24,24,2,'0_anterior','<?php echo $msgstr["m_anterior"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('../../assets/svg/catalog/ic_fluent_ios_arrow_right_24_regular.svg',24,24,3,'0_siguiente','<?php echo $msgstr["m_siguiente"]?>'))
    toolbar.addItem(new dhtmlXImageButtonObject('../../assets/svg/catalog/ic_fluent_arrow_next_24_regular.svg',24,24,4,'0_ultimo','<?php echo $msgstr["m_ultimo"]?>'))
    selectobj=new dhtmlXSelectButtonObject('browseby',
        'mfn,search,selected_records,undo_selected',
        'Mfn,<?php echo $msgstr["busqueda"]?>,<?php echo $msgstr["selected_records"]?>,<?php echo $msgstr["undo_selected"]?>',
        'browse',120,100,'<?php echo $msgstr["browse"]?>')
        toolbar.addItem(selectobj)
    selectobj.setSelected('mfn')
    toolbar.addItem(new dhtmlXToolbarDividerXObject('div_1'))
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_search_24_regular.svg","24","24",5,"1_buscar","<?php echo $msgstr["m_buscar"]?>"))
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_clipboard_search_24_regular.svg","24","24",5,"search_history","<?php echo $msgstr["m_history"]?>"))

    <?php if (isset($tesaurus)) {
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_notebook_24_regular.svg","24","24",5,"tesaurus","<?php echo $msgstr["m_tesaurussrc"]?>"))
    <?php }?>
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_database_search_24_regular.svg","24","24",5,"1_busquedalibre","<?php echo $msgstr["freesearch_title"]?>"))
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_book_search_24_regular.svg","24","24",6,"1_alfa","<?php echo $msgstr["m_indiceaz"]?>"))
    toolbar.addItem(new dhtmlXToolbarDividerXObject('div_2'))

    <?php
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_CREC"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_CREC"])) {
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_document_add_24_regular.svg","24","24",7,"2_nuevo","<?php echo $msgstr["m_crear"]?>"))
    <?php }
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_CAPTURE"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_CAPTURE"])){
    ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_document_copy_24_regular.svg","24","24",9,"2_capturar","<?php echo $msgstr["m_capturar"]?>"))
    <?php }
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_CREC"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_CREC"])) {
            //CHECK IF THE DATABASE ACCEPT IMPORT documents
            $collection="";
            if (isset($def_db["COLLECTION"]))         $collection=trim($def_db["COLLECTION"]);
            if ($collection!=""){
            ?>
            toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_arrow_upload_24_regular.svg","24","24",7,"2_nuevoDoc","<?php echo $msgstr["dd_upload"]?>"))
    <?php } }
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_Z3950CAT"])){
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_arrow_download_24_regular.svg","24","24",19,"2_z3950","<?php echo $msgstr["m_z3950"]?>"))
    <?php }
        ?>
        toolbar.addItem(new dhtmlXToolbarDividerXObject('div_3'))
    <?php
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_VALDEF"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_VALDEF"])){
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_book_template_24_regular.svg","24","24",13,"editdv","<?php echo $msgstr["editar"].' '.$msgstr["valdef"]?>"))
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_book_trace_template_24_regular.svg","24","24",13,"deletedv","<?php echo $msgstr["eliminar"].' '.$msgstr["valdef"]?>"))
        toolbar.addItem(new dhtmlXToolbarDividerXObject('div_4'))
    <?php }
        if ((isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) or
            isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_BARCODE"]))
            and (isset($_SESSION["BARCODE"])or isset($_SESSION["BARCODE_SIMPLE"]))){
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_barcode_scanner_24_regular.svg","24","24",13,"barcode","<?php echo "barcode"?>"))
    <?php }
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
            isset($_SESSION["permiso"]["CENTRAL_PREC"]) or
            isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])  or
            isset($_SESSION["permiso"][$db."_CENTRAL_PREC"])){
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_print_24_regular.svg","24","24",12,"3_imprimir","<?php echo $msgstr["m_reportes"]?>"))
        /*toolbar.addItem(new dhtmlXImageButtonObject("img/mail_p.png","26","24",14,"email","<?php echo $msgstr["m_email"]?>"))*/
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
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_toolbox_24_regular.svg","20","20",13,"config","<?php echo $msgstr["mantenimiento"]?>"))
    <?php }?>
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_arrow_sync_24_regular.svg","20","20",14,"refresh_db","<?php echo $msgstr["refresh_db"]?>"))
    toolbar.addItem(new dhtmlXToolbarDividerXObject('div_5'))

    <?php $select="";
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_STATGEN"])  or isset($_SESSION["permiso"]["CENTRAL_STATCONF"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])   or isset($_SESSION["permiso"][$db."_CENTRAL_STATGEN"])  or isset($_SESSION["permiso"][$db."_CENTRAL_STATCONF"])){
        ?>
        toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_data_usage_24_regular.svg","20","20",13,"stats","<?php echo $msgstr["estadisticas"]?>"))
    <?php }?>
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_question_circle_24_regular.svg","20","20",14,"5_ayuda","<?php echo $msgstr["m_ayuda"]?>"))
    toolbar.addItem(new dhtmlXImageButtonObject("../../assets/svg/catalog/ic_fluent_home_24_regular.svg","20","20",14,"home","<?php echo $msgstr["inicio"]?>"))
    toolbar.showBar();

	function onButtonClick(itemId,itemValue){
		switch (itemId){
			case "browseby":
				switch (itemValue){
					case "mfn":
						top.browseby="mfn"
						top.mfn=top.Mfn_Search -1
						if (top.mfn<=0) top.mfn=1
						top.Menu("proximo")
						break
					case "search":
						if (top.Expresion==""){
							alert("<?php echo $msgstr["faltaexpr"]?>")
							var item=top.menu.toolbar.getItem('browseby');
							item.selElement.options[0].selected =true
							top.browseby="mfn"
							top.Menu("proximo")
							return
						}
						top.browseby="search"
						top.mfn=top.Search_pos -1
						if (top.mfn<=0) top.mfn=1
						top.Menu("proximo")
						break
					case "selected_records":
						if (top.RegistrosSeleccionados==""){
							alert("<?php echo $msgstr["no_sel_records"]?>")
							var item=top.menu.toolbar.getItem('browseby');
							item.selElement.options[0].selected =true
							top.browseby="mfn"
							top.Menu("proximo")
							return
						}
						top.browseby="selected_records"
						top.Listar_pos=top.Listar_pos-1
						if (top.Listar_pos<-1) top.Listar_pos=-1
						top.Menu("proximo")
						break
					case "undo_selected":
						if(top.RegistrosSeleccionados=="") {
							alert("<?php echo $msgstr["s_no_mfn"]." ".$msgstr["bmfn"];?>");
						} else {
							top.RegistrosSeleccionados=""
							alert("<?php echo $msgstr["s_mfn_cleared"]." ".$msgstr["bmfn"];?>");
						}
						var item=top.menu.toolbar.getItem('browseby');
						item.selElement.options[0].selected =true
						top.browseby="mfn"
						top.Menu("proximo")
				}
				break
			case "editdv":
				top.Menu('editdv')
				break;
			case "deletedv":
				top.Menu('deletedv')
				break;
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
			case "2_nuevoDoc":
				top.Menu("importarDoc")
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

	}else{
		echo "document.forma1.formato.options.length=0\n";
	}
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
	if (isset($_SESSION["permiso"][$db."_fmt_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) ){
		echo "if (top.ModuloActivo==\"catalog\") top.menu.document.forma1.wks.options[0]=new Option('','')\n";
		$i=0;
	}


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
}else{
	if (!isset($arrHttp["reload"]))
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

