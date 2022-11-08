<form name="admin"  method="post">
	<input type="hidden" name=encabezado value=s>
	<input type="hidden" name=retorno value="../common/inicio.php">
	<input type="hidden" name=modulo value=catalog>
	<input type="hidden" name=screen_width>
	<input type="hidden" name=base value="<?php echo $arrHttp["base"]?>">
</form>


<script type="text/javascript">
	function CambiarBaseAdministrador(Modulo){
	    switch(Modulo){
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":
				document.admin.action="menu_mantenimiento.php";
                break;
   			case "estructuras":
				document.admin.action="menu_modificardb.php";
                break;
    		case "reportes":
				document.admin.action="pft.php";
                break;
    		case "stats":
				document.admin.action="../statistics/tables_generate.php";
    			break;
	    }
		document.admin.submit();
	}	
</script>

<div class="toolbar-dataentry" >

		<a class="bt-tool" href="javascript:CambiarBaseAdministrador('toolbar')" title="<?php echo $msgstr["dataentry"]?>">
			<img src="../../assets/svg/catalog/ic_fluent_form_new_24_regular.svg">
		</a>

		<a class="bt-tool" href="javascript:CambiarBaseAdministrador('reportes')" title="<?php echo $msgstr["r_reportes"]?>">
			<img src="../../assets/svg/catalog/ic_fluent_print_24_regular.svg">
		</a>

		<a class="bt-tool" href="javascript:CambiarBaseAdministrador('utilitarios')" title="<?php echo $msgstr["maintenance"]?>">
			<img src="../../assets/svg/catalog/ic_fluent_toolbox_24_regular.svg">
		</a>

		<a class="bt-tool" href="javascript:CambiarBaseAdministrador('estructuras')" title="<?php echo $msgstr["updbdef"]?>">
			<img src="../../assets/svg/catalog/ic_fluent_content_settings_24_regular.svg">
		</a>


		<a class="bt-tool" href="../common/inicio.php?base=<?php echo $arrHttp["base"];?>&modulo=catalog">
			<img src="../../assets/svg/catalog/ic_fluent_home_24_regular.svg">
		</a>
</div>
