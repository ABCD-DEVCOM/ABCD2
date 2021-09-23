<?php
/* Modifications
20210310 fho4abcd html compliant
*/
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>

<div class="toolbar-dataentry" >

	<a class="bt-tool" href="suggestions_new.php?base=suggestions&amp;cipar=suggestions.par&amp;Opcion=crear&amp;ventana=S&amp;encabezado=s&amp;retorno=<?php echo urlencode("../acquisitions/suggestions.php")?>" title="<?php echo $msgstr["new"]?>">
		<img src="../../assets/svg/acq/ic_fluent_person_chat_24_regular.svg">
	</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
		<a class="bt-tool" href="suggestions_status.php?base=suggestions&amp;sort=TI" title="<?php echo $msgstr["approve"]." / ". $msgstr["reject"]?>">
			<img src="../../assets/svg/acq/ic_fluent_document_checkmark_24_regular.svg">
		</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
		<a class="bt-tool" href="bidding.php?base=suggestions&amp;sort=DA" title="<?php echo $msgstr["bidding"]?>">
			<img src="../../assets/svg/acq/ic_fluent_money_calculator_24_regular.svg">
			
		</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
		<a class="bt-tool" href="decision.php?base=suggestions&amp;sort=DA" title="<?php echo $msgstr["decision"]?>">
			<img src="../../assets/svg/acq/ic_fluent_cart_24_regular.svg">
		</a>
<?php }?>

<?php include("sendto.php")?>
		<a class="bt-tool" href="../common/inicio.php?reinicio=s&amp;modulo=acquisitions" title="Menu">
			<img src="../../assets/svg/circ/ic_fluent_home_24_regular.svg">
		</a>


</div>