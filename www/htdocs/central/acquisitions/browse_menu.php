<?php
/* Modifications
20210310 fho4abcd html compliant
*/
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>

<div class="toolbar-dataentry" >

	<a class="bt-tool" href="overview.php" title="<?php echo $msgstr["new"]?>">
		<img src="../../assets/svg/acq/ic_fluent_eye_show_24_regular.svg">
	</a>


	<a class="bt-tool" href="suggestions_new.php?base=suggestions&amp;cipar=suggestions.par&amp;Opcion=crear&amp;ventana=S&amp;encabezado=s&amp;retorno=<?php echo urlencode("../acquisitions/suggestions.php")?>" title="<?php echo $msgstr["new"]?>">
		<img src="../../assets/svg/acq/ic_fluent_person_chat_24_regular.svg">
	</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
		<a class="bt-tool" href="browse.php?base=suggestions&Expresion=STA_0" title="<?php echo $msgstr["approve"]." / ". $msgstr["reject"]?>">
			<img src="../../assets/svg/acq/ic_fluent_document_checkmark_24_regular.svg">
		</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
		<a class="bt-tool" href="browse.php?base=suggestions&Expresion=STA_1" title="<?php echo $msgstr["bidding"]?>">
			<img src="../../assets/svg/acq/ic_fluent_money_calculator_24_regular.svg">
			
		</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
		<a class="bt-tool" href="decision.php?base=suggestions&amp;sort=DA" title="<?php echo $msgstr["decision"]?>">
			<img src="../../assets/svg/acq/ic_fluent_cart_24_regular.svg">
		</a>
<?php }?>



     <!-- FORM PRINT -->
    <form name="print" method="post" action="../dataentry/print.php" >
        <input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>" >
        <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]?>.par" >
        <input type="hidden" name="tipof" value="CT">
        <input type="hidden" name="print_content" value="<?php echo $breadcrumb;?>">
    <?php
    if (isset($arrHttp["Expresion"])){
        $Expresion=str_replace("%2A","*",$Expresion);
        echo '<input type="hidden" name="Expresion" value="'.$Expresion.'">';
        }

    ?>
        <input type="hidden" name=headings value="<?php echo $arrHttp["headings"];?>">
        <input type="hidden" name="pft" value="<?php echo $Formato_html;?>">
        <input type="hidden" name="vp" value="S">
        <a href="#" class="bt-tool" onclick="EnviarForma('P')" title="<?php echo $msgstr["Print"]?>">
             <img src="../../assets/svg/browse/ic_fluent_print_24_regular.svg">
        </a>
     </form>
     <!-- ./FORM PRINT -->

    <!-- FORM XLS -->
    <form name="spreadsheet" method="post" action="../dataentry/print.php" >
        <input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>" >
        <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]?>.par" >
        <input type="hidden" name="tipof" value="CT">
    <?php
    if (isset($arrHttp["Expresion"])){
        $Expresion=str_replace("%2A","*",$Expresion);
        echo '<input type="hidden" name="Expresion" value="'.$Expresion.'">';
        }

    ?>
        <input type="hidden" name=headings value="<?php echo $arrHttp["headings"];?>">
        <input type="hidden" name="print_content" value="<?php echo $breadcrumb;?>">
        <input type="hidden" name="pft" value="<?php echo $Formato_html;?>">
        <input type="hidden" name="vp" value="TB">
        <a class="bt-tool" onclick="document.spreadsheet.submit" title="<?php echo $msgstr["wsproc"]?>">
            <img src="../../assets/svg/browse/file_excel_outline_icon_139604.svg">
        </a>
     </form>  
     <!-- ./FORM XLS -->














<?php include("sendto.php")?>
		<a class="bt-tool" href="../common/inicio.php?reinicio=s&amp;modulo=acquisitions" title="Menu">
			<img src="../../assets/svg/circ/ic_fluent_home_24_regular.svg">
		</a>


</div>