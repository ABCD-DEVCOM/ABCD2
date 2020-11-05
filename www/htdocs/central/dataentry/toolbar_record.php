<?php

//echo $arrHttp["ventana"];
if (!isset($fmt_test) and !isset($arrHttp["ventana"])){	echo "<div class=\"helper\" style=\"height:23px\">\n" ;
	if (isset($default_values)){
		echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/valdef.html target=_blank>".$msgstr["m_ayuda"]."</a>&nbsp &nbsp;";
	    if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/valdef.html target=_blank>". $msgstr["edhlp"]."</a>";
	}else{
		if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
			echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/copy_record.html target=_blank>".$msgstr["m_ayuda"]."</a>&nbsp &nbsp;";
	    	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/copy_record.html target=_blank>". $msgstr["edhlp"]."</a>";
		}else{
			echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/dataentry.html target=_blank>".$msgstr["m_ayuda"]."</a>&nbsp &nbsp;";
	    	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/dataentry.html target=_blank>". $msgstr["edhlp"]."</a>";
	  	}
	}
	echo "&nbsp; &nbsp; <a href='http://abcdwiki.net/wiki/es/index.php?title=Entrada_de_datos' target=_blank>abcdwiki.net</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/fmt.php  (page-encoding: $charset)</font>
	</div>";
}

?>

	<div class="middle form">
		<div class="formContent">

<?php if (!isset($arrHttp["ventana"])){?><script language ="javascript" type="text/javascript">


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
<div id="myDiv" style="position:absolute; top:0px; left:50%;" >

<table bgcolor=#bbbbbb>
<td>
<?php
//CHECK IF THE DATABASE ACCEPT IMPORT pdf
	$pdf="";
  	if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
		$def_tool = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
		if (isset($def_tool["IMPORTPDF"]))
			$pdf=trim($def_tool["IMPORTPDF"]);
	}

//CHECK IF THERE IS A VALIDATION FORMAT
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".val";
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".val";
	if (file_exists($archivo)){
		$rec_validation="S";
	}
	$db=$arrHttp["base"];
    if (!isset($arrHttp["encabezado"])){        if (isset($arrHttp["toolbar_record"]) and strtoupper($arrHttp["toolbar_record"])=="N") $_SESSION["TOOLBAR_RECORD"]="N";
	 	switch ($arrHttp["Opcion"]){
			case "ver":
			case "leer":
			case "cancelar":
			case "actualizar":
			case "buscar":
			case "presentar_captura":
			case "dup_record":
				if (isset($_SESSION["TOOBAL_RECORD"]) and $_SESSION["TOOLBAR_RECORD"]=="N"){					unset( $_SESSION["TOOLBAR_RECORD"]);
					break;				}
				echo "				<input type=checkbox name=sel_mfn id=sel_mfn onclick=top.SeleccionarRegistro(this) value=".$arrHttp["Mfn"].">";
				if (isset($_SESSION["permiso"]["CENTRAL_EDREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_EDREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) {					echo " &nbsp;<a href=\"javascript:top.Menu('editar')\" title=\"".$msgstr["m_editar"]."\"><img src=img/toolbarEdit.png alt=\"".$msgstr["m_editar"]."\" style=\"border:0;\"></a>  &nbsp;\n";
				    if ($pdf=="Y") {
				    	echo " &nbsp;<a href=\"javascript:top.Menu('editar_HTML')\" title=\"IMPORT DOC\">";
				    	echo "<img src=img/import.gif alt=\"".$msgstr["m_editar"]."\" style=\"border:0;\"></a>";
				    	echo "  &nbsp;\n";
				    	//echo " &nbsp;<a href=\"javascript:top.Menu('pdf2Txt')\" title=\"CONVERT PDF TO TEXT\">";
				    	//echo "<img src=img/pdf2text.png alt=\"".$msgstr["m_editar"]."\" style=\"border:0;\"></a>";
				    	//echo "  &nbsp;\n";
					}
				}
				if (isset($_SESSION["permiso"]["CENTRAL_CREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_CREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) {					echo " &nbsp;<a href=\"javascript:top.Menu('dup_record')\" title=\"".$msgstr["m_copyrec"]."\"><img src=img/toolbarCopy.png alt=\"".$msgstr["m_copyrec"]."\" style=\"border:0;\"></a>  &nbsp;\n";
				}
				echo " &nbsp;<a href=\"javascript:top.Menu('same')\" title=\"".$msgstr["refresh_db"]."\"><img src=img/refresh0.gif alt=\"".$msgstr["refresh_record"]."\" title=\"".$msgstr["refresh_record"]."\" style=\"border:0;\"></a>  &nbsp;\n";

				if (isset($_SESSION["permiso"]["CENTRAL_DELREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_DELREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) echo "<a href=\"javascript:top.Menu('eliminar')\" title=\"".$msgstr["m_eliminar"]."\"><img src=img/toolbarDelete.png alt=\"".$msgstr["m_eliminar"]."\" style=\"border:0;\"></a> &nbsp;\n";
				if (isset($_SESSION["permiso"]["CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"][$db."_CENTRAL_Z3950CAT"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])) echo "<a href=\"javascript:top.Menu('edit_Z3950')\" title=\"Z39.50\"><img src=img/z3950.png alt=\"Z39.50\" style=\"border:0;\"></a>\n";
				if (isset($_SESSION["permiso"]["CENTRAL_EDREC"])  or isset($_SESSION["permiso"][$db."_CENTRAL_EDREC"]) or isset($_SESSION["permiso"]["CENTRAL_CREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
					if (isset($rec_validation)) echo "<a href='javascript:top.Menu(\"recvalidation\")' title=\"".$msgstr["rval"]."\"><img src=img/recordvalidation_p.gif alt=\"".$msgstr["rval"]."\" style=\"border:0;\"></a> &nbsp;\n";
				if (isset($arrHttp["db_copies"]) and $arrHttp["db_copies"]!=""){					if (isset($_SESSION["permiso"]["CENTRAL_ADDCOP"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ADDCOP"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){  //THE DATABASES HAS COPIES DATABASE
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"addcopies\")' title='".$msgstr["m_addcopies"]."'><img src=img/db_add.png alt='".$msgstr["m_addcopies"]."' border=0></a> &nbsp;\n";
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"editdelcopies\")' title='".$msgstr["m_editdelcopies"]."'><img src=img/database_edit.png alt='".$msgstr["m_editdelcopies"]."' border=0></a> &nbsp;\n";				    }
					if (isset($_SESSION["permiso"]["CENTRAL_ADDLO"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ADDLO"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]))
						echo "<a href='javascript:top.toolbarEnabled=\"\";top.Menu(\"addloanobjects\")' title='".$msgstr["addloansdb"]."'><img src=img/add.gif alt='".$msgstr["addloansdb"]."' border=0></a> \n";
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
				if ($OpcionDeEntrada!="captura_bd"){					if (isset($arrHttp["toolbar_record"]) and strtoupper($arrHttp["toolbar_record"])=="N"){                        echo " &nbsp; <a href='javascript:top.Menu(\"cancelar\")' title=\"".$msgstr["m_cancelar"]."\"><img src=img/toolbarCancelEdit.png alt='".$msgstr["m_cancelar"]."' border=1><a> &nbsp; \n";					}else{
				   		echo " &nbsp; <a href='javascript:top.Menu(\"cancelar\")' title=\"".$msgstr["m_cancelar"]."\"><img src=img/toolbarCancelEdit.png alt='".$msgstr["m_cancelar"]."' border=1><a> &nbsp; \n";
					}
					echo "<a href='javascript:EnviarForma()' title=\"".$msgstr["m_guardar"]."\"><img src=img/toolbarSave.png alt=\"".$msgstr["m_guardar"]."\"><a> &nbsp; \n";
					if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tesaurus.rel"))
						echo "<a href=javascript:RelacionesInversas('check') title=\"".$msgstr["tes_chkinvrel"]."\"><img src=img/import.gif alt=\"".$msgstr["tes_chkinvrel"]."\"></a>\n";
				}
	//          echo "<input type=button name=capturar value=\"".$msgstr["m_capturar"]."\">\n";
	//			echo "<input type=button name=capturar value=\"".$msgstr["m_z3950"]."\">\n";
				break;
		}
	}
	echo "</td></table></div>\n";
}
    if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){

    	//$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
    	echo "<a href=javascript:toggle('Expresion','')><img src=../dataentry/img/defaultButton_list.png border=0 align=middle><font face=arial style=font-size:10px>".$msgstr["expresion"]."</a>";
    	echo "<div id=Expresion style=\"display:none; hide:block\"><textarea name=nueva_b cols=150 rows=1>".stripslashes($arrHttp["Expresion"])."</textarea> <a href=javascript:NuevaBusqueda()>".$msgstr["buscar"]."</a> <a href=javascript:top.Menu('refinar')>". $msgstr["refine"]."</a>
    	 &nbsp; ";
    	 InsertarEnlaces($arrHttp['base']);
    	 echo "</font>";
    	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])){
    ?>
    		<div id=headerDiv_1 style="headerDiv">
	    	<div id=titleText_1 class=titleText> <a id=myHeader_1 style="myHeader" href="javascript:toggle('contentDiv_1','myHeader_1');" ><?php echo $msgstr["savesearch"]?></a></div>
			<div id=contentDiv_1 style="display:none; hide:block">
     		<?php echo $msgstr["r_desc"]?>: <input type=text name=Descripcion size=40>
     			&nbsp; &nbsp; <input type=button value="<?php echo $msgstr["savesearch"]?>" onclick=GuardarBusqueda()>
			</div></div>
			</div>
 <?php
 		}else{ 			echo "</div><p>"; 		}
 		echo "</font>";
    }

//    echo $arrHttp["Opcion"];
?>
<script>
	if (top.browseby=="search")
		select_Mfn='_'+top.Mfn_Search+'_'
	else
		select_Mfn='_'+top.mfn+'_'
	if (top.RegistrosSeleccionados.indexOf(select_Mfn)!=-1){		Ctrl=top.main.document.getElementById("sel_mfn")
		if (Ctrl.checked)
			Ctrl.checked=false
		else
			Ctrl.checked=true
	}
</script>

