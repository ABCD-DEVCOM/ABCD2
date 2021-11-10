<?php
/* Modifications
2021-03-02 fho4abcd Replaced helper code fragment by included file
2021-08-29 fho4abcd Removed document import (the code made a new record)
2021-08-29 fho4abcd Restored edit button. lineends
*/

//echo $arrHttp["ventana"];
if (!isset($fmt_test) and !isset($arrHttp["ventana"])){
	if (isset($default_values)){
        $ayuda = "valdef.html";
	}else{
		if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
            $ayuda = "copy_record.html";
		}else{
            $ayuda = "dataentry.html";
	  	}
	}
    $wiki_help="Entrada_de_datos";
    include "../common/inc_div-helper.php";
}
?>

	<div class="middle form">
		<div class="formContent">

<?php if (!isset($arrHttp["ventana"])){
?>
<script language ="javascript" type="text/javascript">


function scrollingDetector(){

if (navigator.appName == "Microsoft Internet Explorer")

{

//alert(document.documentElement.scrollTop);

document.getElementById("myDiv").style.top = document.documentElement.scrollTop;

}



 // For FireFox

else{ document.getElementById("myDiv").style.top = window.pageYOffset + "px";      }



}



function startScrollingDetector()

{

setInterval("scrollingDetector()",1000);

}
startScrollingDetector()


</script>
<div id="myDiv" style="position:absolute; top:0px; right: 0;" >

<table class="toolbar-edit-dataentry">
<tr>	
<td>
<?php

//CHECK IF THERE IS A VALIDATION FORMAT
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".val";
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".val";
	if (file_exists($archivo)){
		$rec_validation="S";
	}
	$db=$arrHttp["base"];
    if (!isset($arrHttp["encabezado"])){
        if (isset($arrHttp["toolbar_record"]) and strtoupper($arrHttp["toolbar_record"])=="N") $_SESSION["TOOLBAR_RECORD"]="N";
	 	switch ($arrHttp["Opcion"]){
			case "ver":
			case "leer":
			case "cancelar":
			case "actualizar":
			case "buscar":
			case "presentar_captura":
			case "dup_record":
				if (isset($_SESSION["TOOLBAR_RECORD"]) and $_SESSION["TOOLBAR_RECORD"]=="N"){
					unset( $_SESSION["TOOLBAR_RECORD"]);
					break;
				}
?>

 
<label class="check_sec">
  <input type="checkbox" name="sel_mfn" id="sel_mfn" onclick="top.SeleccionarRegistro(this)" value="<?php echo $arrHttp["Mfn"];?>">
  <span class="checkmark"></span>
</label>


<?php
                if (isset($_SESSION["permiso"]["CENTRAL_EDREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_EDREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) {
					echo " &nbsp;<a href=\"javascript:top.Menu('editar')\" title=\"".$msgstr["m_editar"]."\"><img src='../../assets/svg/catalog/ic_fluent_document_edit_24_regular.svg' alt=\"".$msgstr["m_editar"]."\" style=\"border:0;\"></a>  &nbsp;\n";
                }
				if (isset($_SESSION["permiso"]["CENTRAL_CREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_CREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) {
					echo " &nbsp;<a href=\"javascript:top.Menu('dup_record')\" title=\"".$msgstr["m_copyrec"]."\"><img src='../../assets/svg/catalog/ic_fluent_save_copy_24_regular.svg' alt=\"".$msgstr["m_copyrec"]."\" style=\"border:0;\"></a>  &nbsp;\n";
				}
				echo " &nbsp;<a href=\"javascript:top.Menu('same')\" title=\"".$msgstr["refresh_db"]."\"><img src='../../assets/svg/catalog/ic_fluent_arrow_sync_circle_24_regular.svg' alt=\"".$msgstr["refresh_record"]."\" title=\"".$msgstr["refresh_record"]."\" style=\"border:0;\"></a>  &nbsp;\n";

				if (isset($_SESSION["permiso"]["CENTRAL_DELREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_DELREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) 
					echo "<a href=\"javascript:top.Menu('eliminar')\" title=\"".$msgstr["m_eliminar"]."\"><img src='../../assets/svg/catalog/ic_fluent_delete_dismiss_24_regular.svg' alt=\"".$msgstr["m_eliminar"]."\" style=\"border:0;\"></a> &nbsp;\n";
				if (isset($_SESSION["permiso"]["CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"][$db."_CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) 
					echo "<a href=\"javascript:top.Menu('edit_Z3950')\" title=\"Z39.50\"><img src='../../assets/svg/catalog/ic_fluent_arrow_download_24_regular.svg' alt=\"Z39.50\" style=\"border:0;\"></a>\n";
				if (isset($_SESSION["permiso"]["CENTRAL_EDREC"])  or isset($_SESSION["permiso"][$db."_CENTRAL_EDREC"]) or isset($_SESSION["permiso"]["CENTRAL_CREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
					if (isset($rec_validation)) 
						echo "<a href='javascript:top.Menu(\"recvalidation\")' title=\"".$msgstr["rval"]."\"><img src='../../assets/svg/catalog/ic_fluent_calendar_checkmark_24_regular.svg' alt=\"".$msgstr["rval"]."\" style=\"border:0;\"></a> &nbsp;\n";
				if (isset($arrHttp["db_copies"]) and $arrHttp["db_copies"]!=""){
					if (isset($_SESSION["permiso"]["CENTRAL_ADDCOP"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ADDCOP"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){  //THE DATABASES HAS COPIES DATABASE
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"addcopies\")' title='".$msgstr["m_addcopies"]."'><img src='../../assets/svg/catalog/ic_fluent_collections_add_24_regular.svg' alt='".$msgstr["m_addcopies"]."' border=0></a> &nbsp;\n";
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"editdelcopies\")' title='".$msgstr["m_editdelcopies"]."'><img src='../../assets/svg/catalog/ic_fluent_collections_24_regular.svg' alt='".$msgstr["m_editdelcopies"]."' border=0></a> &nbsp;\n";
				    }
					if (isset($_SESSION["permiso"]["CENTRAL_ADDLO"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ADDLO"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]))
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"addloanobjects\")' title='".$msgstr["addloansdb"]."'><img src='../../assets/svg/catalog/ic_fluent_reading_list_add_24_regular.svg' alt='".$msgstr["addloansdb"]."' border=0></a> \n";
				}
				if ((isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) or
	    			 isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_BARCODE"]))
	    			 and (isset($barcode1reg))){
        				echo " &nbsp;<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"barcode_this\")' title='"."Código de barras"."'><img src=img/barcode.png alt='"."Código de barras"."' border=0></a> \n";
				}
				echo " &nbsp;";
				break;
			case "editar":
			case "capturar":
			case "crear":
			case "reintentar":
				if ($OpcionDeEntrada!="captura_bd"){
					if (isset($arrHttp["toolbar_record"]) and strtoupper($arrHttp["toolbar_record"])=="N"){
                        echo " &nbsp; <a href='javascript:top.Menu(\"cancelar\")' title=\"".$msgstr["m_cancelar"]."\"><img src=img/toolbarCancelEdit.png alt='".$msgstr["m_cancelar"]."' border=1><a> &nbsp; \n";
					}else{
				   		echo " &nbsp; <a href='javascript:top.Menu(\"cancelar\")' title=\"".$msgstr["m_cancelar"]."\"><img src='../../assets/svg/catalog/ic_fluent_pane_close_24_regular.svg' alt='".$msgstr["m_cancelar"]."'  border=1><a>\n";
					}
					echo "<a href='javascript:EnviarForma()' title=\"".$msgstr["m_guardar"]."\"><img src='../../assets/svg/catalog/ic_fluent_document_save_24_regular.svg' alt=\"".$msgstr["m_guardar"]."\"><a> &nbsp; \n";
					if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tesaurus.rel"))
						echo "<a href=javascript:RelacionesInversas('check') title=\"".$msgstr["tes_chkinvrel"]."\"><img src=img/import.gif alt=\"".$msgstr["tes_chkinvrel"]."\"></a>\n";
				}
	//          echo "<input type=button name=capturar value=\"".$msgstr["m_capturar"]."\">\n";
	//			echo "<input type=button name=capturar value=\"".$msgstr["m_z3950"]."\">\n";
				break;
		}
	}
	echo "</td></tr></table></div>\n";
}
    if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
    	//$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
?>

	<a class="button_browse show" href="javascript:toggle('Expresion','')">
		<i class="fas fa-search"></i>
			<?php echo $msgstr["expresion"];?>
		</a>
    	<div id="Expresion" style="display:none; padding: 10px;">
    		<textarea name="nueva_b" id="nueva_b" cols="130" rows="1"><?php echo stripslashes($arrHttp["Expresion"]);?></textarea> 
    		<a class="button_browse edit" href="javascript:NuevaBusqueda()"><i class="fas fa-search"></i> <?php echo $msgstr["buscar"];?></a> 
    		<a class="button_browse show" href="javascript:top.Menu('refinar')"><i class="fas fa-search-plus"></i> <?php echo $msgstr["refine"];?></a>

    	 <?php echo InsertarEnlaces($arrHttp['base']);
    	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])){
    	?>
    		<div id="headerDiv_1">
	    	<div id="titleText_1" class="titleText"> 
	    		<a class="button_browse edit" id="myHeader_1" href="javascript:toggle('contentDiv_1','myHeader_1');" >
	    			<i class="far fa-save"></i> <?php echo $msgstr["savesearch"]?>
	    		</a>
	    	</div>
			<div id="contentDiv_1" style="display:none;">
     		<?php echo $msgstr["r_desc"]?>: <input type=text name=Descripcion size=40>
     			&nbsp; &nbsp; <input type=button value="<?php echo $msgstr["savesearch"]?>" onclick=GuardarBusqueda()>
			</div></div>
			</div>
 <?php
 		}else{
 			echo "</div>";
 		}
    }

//    echo $arrHttp["Opcion"];
?>
<script>
	if (top.browseby=="search")
		select_Mfn='_'+top.Mfn_Search+'_'
	else
		select_Mfn='_'+top.mfn+'_'
	if (top.RegistrosSeleccionados.indexOf(select_Mfn)!=-1){
		Ctrl=top.main.document.getElementById("sel_mfn")
		if (Ctrl.checked)
			Ctrl.checked=false
		else
			Ctrl.checked=true
	}
</script>

