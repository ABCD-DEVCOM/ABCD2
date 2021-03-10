<?php
/* Modifications
20210310 fho4abcd html compliant
*/
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
		<a href="suggestions_new.php?base=suggestions&amp;cipar=suggestions.par&amp;Opcion=crear&amp;ventana=S&amp;encabezado=s&amp;retorno=<?php echo urlencode("../acquisitions/suggestions.php")?>"><strong>
			<?php echo $msgstr["new"]?></strong></a> |
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
		<a href="suggestions_status.php?base=suggestions&amp;sort=TI"><strong>
			<?php echo $msgstr["approve"]." / ". $msgstr["reject"]?></strong></a> |
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
		<a href="bidding.php?base=suggestions&amp;sort=DA"><strong>
			<?php echo $msgstr["bidding"]?></strong></a> |
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
		<a href="decision.php?base=suggestions&amp;sort=DA"><strong>
			<?php echo $msgstr["decision"]?></strong></a> |
<?php }?>


		<a href="../common/inicio.php?reinicio=s&amp;modulo=acquisitions"><strong>
			<?php echo "Menu"?></strong></a> &nbsp; &nbsp; &nbsp;

		<p>


<?php include("sendto.php")?>
