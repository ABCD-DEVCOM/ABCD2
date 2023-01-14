<div class="toolbar-dataentry" >

<?php
if (!isset($link_u)) $link_u="";
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_LOAN"])){
?>
	<a class="bt-tool" href="../circulation/prestar.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["loan"]?>">
		<img src="../../assets/svg/circ/ic_fluent_arrow_routing_24_regular.svg">
	</a>
	
<?php if (isset($ILL) and $ILL!=""){ ?>
	
	<a class="bt-tool" href="../circulation/interbib.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["r_ill"]?>">
		<img src="../../assets/svg/circ/ic_fluent_library_24_regular.svg">
	</a>
	
<?php
		}
}



if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RENEW"])){
?>

		<a class="bt-tool" href="../circulation/renovar.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["renew"]?>">
			<img src="../../assets/svg/circ/ic_fluent_arrow_sync_24_regular.svg">
		</a>

<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RETURN"])){
?>
		<a class="bt-tool" href="../circulation/devolver.php?encabezado=s" title="<?php echo $msgstr["return"]?>">
			<img src="../../assets/svg/circ/ic_fluent_arrow_wrap_20_filled.svg">
		</a>

<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RESERVE"])){
	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
?>
		<a class="bt-tool" href="../circulation/estado_de_cuenta.php?encabezado=s&reserve=S<?php echo $link_u?>" title="<?php echo $msgstr["reserve"]?>">
			<img src="../../assets/svg/circ/ic_fluent_book_clock_24_regular.svg">
		</a>

<?php } }
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SALA"])){
?>     
		<a class="bt-tool" href="../circulation/sala.php" title="<?php echo $msgstr["sala"]?>">
			<img src="../../assets/svg/circ/ic_fluent_key_24_regular.svg">
		</a>
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SUSPEND"])){
?>
		<a class="bt-tool" href="../circulation/sanctions.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["suspend"]."/".$msgstr["fine"]?>">
			<img src="../../assets/svg/circ/ic_fluent_person_money_24_regular.svg">
		</a>
<?php }?>
		<a class="bt-tool" href="../circulation/estado_de_cuenta.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["statment"]?>">
			<img src="../../assets/svg/circ/ic_fluent_person_accounts_24_regular.svg">
		</a>

		<a class="bt-tool" href="../circulation/situacion_de_un_objeto.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["ecobj"]?>">
			<img src="../../assets/svg/circ/ic_fluent_book_question_mark_24_regular.svg">
		</a>

		<a class="bt-tool" href="../circulation/item_history.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["item_history"]?>">
			<img src="../../assets/svg/circ/ic_fluent_book_pulse_24_regular.svg">
		</a>

		<a class="bt-tool" href="../circulation/borrower_history.php?encabezado=s<?php echo $link_u?>" title="<?php echo $msgstr["bo_history"]?>">
			<img src="../../assets/svg/circ/ic_fluent_person_accounts_24_regular.svg">
		</a>
		<a class="bt-tool" href="../common/inicio.php?reinicio=s&modulo=loan">
			<img src="../../assets/svg/circ/ic_fluent_home_24_regular.svg">
		</a>

		<span title="<?php echo date_default_timezone_get();?>" class="bt-hour">
		<?php 
		global $config_date_format;
		$newDate = date($config_date_format, strtotime(date('Ymd')));
		echo $newDate." - ".date('h:i A');?>
		</span>

</div>
