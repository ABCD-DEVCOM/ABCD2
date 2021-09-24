<div class="toolbar-dataentry" >
		<a class="bt-tool" href=order.php?sort=PV title="<?php echo $msgstr["generateorder"]?>">
			<img src="../../assets/svg/acq/ic_fluent_table_add_24_regular.svg">
		</a>
		<a class="bt-tool" href=pending_order.php?sort=PV title="<?php echo $msgstr["pendingorder"]?>">
			<img src="../../assets/svg/acq/ic_fluent_document_bullet_list_clock_24_regular.svg">
		</a>
		<a class="bt-tool" href=receive_order.php?base=suggestions&sort=DA title="<?php echo $msgstr["receiving"]?>">
			<img src="../../assets/svg/acq/ic_fluent_receipt_add_24_regular.svg">
		</a>
<?php include("sendto.php")?>

		<a class="bt-tool" href="../common/inicio.php?reinicio=s&modulo=acquisitions" title="Menu">
			<img src="../../assets/svg/circ/ic_fluent_home_24_regular.svg">
		</a>



</div>