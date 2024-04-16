<?php
/*
2024-04-14 fho4abcd Created by extract of code from fdt.php and fdt_short_a.php
2024-04-16 fho4abcd Improve indent
*/
/*
** Script common and equal for fdt processing:setup of grid
*/
?>
<script>
	var mygrid = new dhtmlXGridFromTable('tblToGrid');
	mygrid.setImagePath("/assets/images/dhtml_grid/imgs/");
	mygrid.setColTypes("link,coro,ed,ed,ch,ch,ed,ed,coro,ed,ed,coro,ed,ed,link,ed,ed,edtxt,ch,ed,ch,ch,coro,ed");
	// set first value of selection lists to blank
	mygrid.getCombo(1).put("","");	//type
	mygrid.getCombo(8).put("","");	//input type
	mygrid.getCombo(11).put("","");	//Picklist type
	mygrid.getCombo(22).put("","");	//field validation
	<?php
	// load selection list values
	foreach ($field_type as $key=>$value) echo "mygrid.getCombo(1).put(\"".$key."\",\"".$value."\")\n";
	foreach ($input_type as $key=>$value) echo "mygrid.getCombo(8).put(\"".$key."\",\"".$value."\")\n";
	foreach ($pick_type as $key=>$value) echo "mygrid.getCombo(11).put(\"".$key."\",\"".$value."\")\n";
	foreach ($validation as $key=>$value) echo "mygrid.getCombo(22).put(\"".$key."\",\"".$value."\")\n";
	if (!isset($arrHttp["encabezado"]))
		echo  "mygrid.enableAutoHeigth(true,270)\n";
	else
		echo  "mygrid.enableAutoHeigth(true,300)\n";

	for ($ix=0;$ix<$nfilas;$ix++){
		echo "mygrid.cells2($ix,0).setAttribute('title','".$msgstr["fdt_clrec"]."')\n";
		if (isset($FT[$ix])) echo "mygrid.cells2($ix,1).setValue('".$FT[$ix]."')\n";

		if (isset($IN[$ix]))
			echo "mygrid.cells2($ix,4).setValue('".$IN[$ix]."')\n";
		else
			echo "mygrid.cells2($ix,4).setValue('0')\n";

		if (isset($RE[$ix]))
			echo "mygrid.cells2($ix,5).setValue('".$RE[$ix]."')\n";
		else
			echo "mygrid.cells2($ix,5).setValue(true)\n";

		echo "mygrid.cells2($ix,8).setValue('".$IT[$ix]."')\n";
		echo "mygrid.cells2($ix,11).setValue('".$PL[$ix]."')\n";
		echo "mygrid.cells2($ix,14).setAttribute('title','".$msgstr["fdt_clpl"]."')\n";
		if (isset($HP[$ix])){
			echo "mygrid.cells2($ix,18).setValue('".$HP[$ix]."')\n";
		}else{
			echo "mygrid.cells2($ix,18).setValue('0')\n";
		}
		if (isset($LKF[$ix]))
			echo "mygrid.cells2($ix,20).setValue('".$LKF[$ix]."')\n";
		else
			echo "mygrid.cells2($ix,20).setValue('0')\n";
		if (isset($MANDATORY[$ix]))
			echo "mygrid.cells2($ix,21).setValue('".$MANDATORY[$ix]."')\n";
		else
			echo "mygrid.cells2($ix,21).setValue('0')\n";
		if (isset($VAL[$ix]))
			echo "mygrid.cells2($ix,22).setValue('".$VAL[$ix]."')\n";
		else
			echo "mygrid.cells2($ix,22).setValue('0')\n";
	}
	?>
	mygrid.clearSelection()
	mygrid.setSizes();
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
	mygrid.attachHeader("#rspan,<?php echo $msgstr["field_prop"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,<?php echo $msgstr["dataentry"]?>,#cspan,#cspan,<?php echo $msgstr["picklist"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan");
	mygrid.enableColumnAutoSize(true)
	mygrid.setColWidth(0,35)	//fdt row
	mygrid.setColWidth(1,80)	//type
	mygrid.setColWidth(2,35)	//tag
	mygrid.setColWidth(3,150)	//title
	mygrid.setColWidth(4,23)	//i:principal entry
	mygrid.setColWidth(5,23)	//repetible
	mygrid.setColWidth(6,60)	//subfields
	mygrid.setColWidth(7,2)    	//preliterals column is not used here
	mygrid.setColWidth(8,120)	//input type
	mygrid.setColWidth(9,40)	//rows
	mygrid.setColWidth(10,35)	//cols
	mygrid.setColWidth(11,50)	//Picklist type
	mygrid.setColWidth(12,70)	//Name
	mygrid.setColWidth(13,45)	//prefix, 14=detail,15=listas,16=extractas,17=defaultvalue

	mygrid.setColWidth(18,45)	//help
	mygrid.setColWidth(19,80)	//help URL
	mygrid.setColWidth(20,45)	//link fdt
	mygrid.setColWidth(21,45)	//req?
	mygrid.setColWidth(22,110)	//field validation
	mygrid.setColWidth(23,90)	//pattern
	//mygrid.setColAlign("left,left,left,center,center,center,left,left,left,left,left,left,left,left,left,left,left,left,center,left,center,center,left,left")
	mygrid.setColSorting("")
	//mygrid.enableAutoWidth(true);  // do not set: scroll bar disappears
</script>
