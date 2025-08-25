<?php
/*
2024-04-14 fho4abcd Created by extract of code from fdt.php and fdt_short_a.php
2024-04-16 fho4abcd Increase row link font, improve indent. Error if no row selected. Smaller picklist window
2024-04-16 fho4abcd Add function AsignarDbPicklistValues (was removed by accident)
2024-04-22 fho4abcd Correct pl_type, send also title of field, Add function AsignarTxtPicklistValues (was removed by accident)
2025-02-09 fho4abcd bgcolor in HeadRowsForValidate set to LightBlue
2025-02-11 fho4abcd replace browse by translated message
2025-08-24 fho4abcd Add tagnumber and subfield for edit text table
*/
/*
** Scripts common and equal for fdt processing
*/
?>
<script>
field_type=Array()
input_type=Array()
pick_type=Array()
validation=Array()
<?php
	foreach ($field_type as $key=>$value) echo "field_type['$key']='$value'\n";
	foreach ($input_type as $key=>$value) echo "input_type['$key']='$value'\n";
	foreach ($pick_type as $key=>$value) echo "pick_type['$key']='$value'\n";
	foreach ($validation as $key=>$value) echo "validation['$key']='$value'\n";
?>
pl_type=""
Opcion="<?php echo $arrHttp["Opcion"]?>"
valor=""
prefix=""
list=""
extract=""
fila=""
columna=12

//functions
function AddRow(ixfila,Option){
	if (CheckRowSelection()==false) return;
	switch (Option){
		case "BEFORE":
			ixf=mygrid.getRowsNum()+1
			ref=ixf
			break
		case "AFTER":
			ixf=mygrid.getRowsNum()+2
			ref=ixf-1
			break
		default:
			ixf=mygrid.getRowsNum()+2
			break
	}
	linkr="<a href=javascript:EditRow(\""+ixf+"\","+ixf+")>"+ref+"</a>";
	pick="<a href=javascript:Picklist(\"\","+ixf+")><font size=1>"+"<?php echo $msgstr["edit"]?>"+"</a>";
	mygrid.addRow((new Date()).valueOf(),[linkr,'','','','','','','','','','','','','',pick,'','','','','','','','','','','',''],ixfila)
	mygrid.selectRow(ixfila);
}
// function used by picklist.php. Must reside here
function AsignarTxtPicklistValues(){
	mygrid.cells2(fila,columna).setValue(valor)
	mygrid.cells2(fila,13).setValue("")
	mygrid.cells2(fila,15).setValue("")
	mygrid.cells2(fila,16).setValue("")
}
// function used by picklist_db.php. Must reside here
function AsignarDbPicklistValues(){
	mygrid.cells2(fila,columna).setValue(valor)
	mygrid.cells2(fila,13).setValue(prefix)
	mygrid.cells2(fila,15).setValue(list)
	mygrid.cells2(fila,16).setValue(extract)
}
function CheckRowSelection() {
	var checkid=mygrid.getSelectedRowId();
	if (checkid==null || IsNumeric(checkid)==false) {
		alert("<?php echo $msgstr["fdt_selrow"]?>")
		return false;
	}
	return true;
}
function Picklist(name,row,base){
	prefix=""
	valor=""
	fila=mygrid.getRowIndex(mygrid.getSelectedId())
	pl_type=mygrid.cells2(fila,11).getValue()
	pl_name=mygrid.cells2(fila,12).getValue()
	if (pl_type==""){
		alert("<?php echo $msgstr["selpltype"]?>")
		return
	}
	switch (pl_type){
		case "P":
			Url=""
			document.edit_picklist.base.value="<?php echo $arrHttp["base"]?>"
			document.edit_picklist.pl_type.value=pl_type
			document.edit_picklist.picklist.value=pl_name
			document.edit_picklist.row.value=fila
			document.edit_picklist.title.value=mygrid.cells2(fila,3).getValue()
			document.edit_picklist.tag.value=mygrid.cells2(fila,2).getValue()
			document.edit_picklist.subfield.value=mygrid.cells2(fila,6).getValue()
			//Url="picklist.php?base=&picklist="+pl_name+"&row="+fila+"&pl_type="
			break
		case "D":
			dbsel=mygrid.cells2(fila,12).getValue()
			if (Trim(dbsel)=="") dbsel="<?php echo $arrHttp["base"]?>"
			prefix=mygrid.cells2(fila,13).getValue()
			list=mygrid.cells2(fila,15).getValue()
			extract=mygrid.cells2(fila,16).getValue()
			Url="picklist_db.php?base=<?php echo $arrHttp["base"]?>&picklist="+name+"&row="+fila+"&dbsel="+dbsel+"&prefix="+prefix+"&list="+list+"&extract="+extract
			break
		case "T":
			break
	}
	if (Url!="") Url+="&type="+pl_type
	var width = window.screen.availWidth/2;
	var arglist="menu=0,scrollbars,resizable,width="+width;
	msgwin=window.open(Url,"PL",arglist)
	if (Url=="") document.edit_picklist.submit()
	msgwin.focus()
}
function Test(){
	msgwin=window.open("","Test","width=800,height=600,resizable,scrollbars")
	msgwin.document.close()
	document.forma1.action="../dataentry/fdt_test.php";
	document.forma1.target="Test";
	msgwin.focus()
	Actualizar()
}
function IsNumeric(sText){
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;
	for (itag = 0; itag < sText.length && IsNumber == true; itag++){
		Char = sText.charAt(itag);
		if (ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	return IsNumber;
}
function HeadRowsForValidate(Rows){
	//Display heading rows for the validation
	msgwin.document.writeln("<tr>")
	if (Rows!="") msgwin.document.writeln("<td rowspan=2></td>")// cell for the row number
	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["type"]?></td><td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["tag"]?></td>")
	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["title"]?></td><td rowspan=2 align=center bgcolor=LightBlue>I</td><td rowspan=2 align=center bgcolor=LightBlue>R</td><td rowspan=2 align=center  bgcolor=LightBlue><?php echo $msgstr["subfields"]?></td><td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["preliteral"]?></td>")
	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["inputtype"]?></td><td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["rows"]?></td><td rowspan=2 align=center bgcolor=LightBlue><?php echo $msgstr["cols"]?></td>")
	msgwin.document.writeln("<td colspan=6 align=center bgcolor=LightBlue><?php echo $msgstr["picklist"]?></td>")

	msgwin.document.writeln("<td bgcolor=LightBlue rowspan=2><?php echo $msgstr["help"]?></td>")
	msgwin.document.writeln("<td bgcolor=LightBlue rowspan=2><?php echo $msgstr["url_help"]?></td><td bgcolor=LightBlue rowspan=2><?php echo $msgstr["link_fdt"]?></td><td bgcolor=LightBlue rowspan=2><?php echo $msgstr["mandatory"]?></td><td bgcolor=LightBlue rowspan=2><?php echo $msgstr["field_validation"]?></td><td bgcolor=LightBlue rowspan=2><?php echo $msgstr["pattern"]?></td>")
	msgwin.document.writeln("<tr>")
	msgwin.document.writeln("<td align=center bgcolor=LightBlue><?php echo $msgstr["type"]?></td><td bgcolor=LightBlue><?php echo $msgstr["name"]?></td><td bgcolor=LightBlue><?php echo $msgstr["prefix"]?></td><td bgcolor=LightBlue><?php echo $msgstr["pft"]?></td>")
	msgwin.document.writeln("<td bgcolor=LightBlue><?php echo $msgstr["listas"]?></td><td bgcolor=LightBlue><?php echo $msgstr["extractas"]?></td>")
}
function List(){
	var width = screen.availWidth;
	var height = screen.availHeight
	msgwin=window.open("","Fdt","width="+width+", height="+height+" resizable=yes, scrollbars=yes, menu=yes")
	msgwin.document.close()
	msgwin.document.writeln("<html>")
	msgwin.document.writeln("<style>BODY{font-family: 'Trebuchet MS', Arial, Verdana, Helvetica; font-size: 8pt;}")
	msgwin.document.writeln("TD{font-family:arial; font-size:8pt;}")
	msgwin.document.writeln("</style>")
	msgwin.document.writeln("<body>")
	msgwin.document.writeln("<table bgcolor=#CCCCCC>")
	HeadRowsForValidate("")
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	for (i=0;i<rows;i++){
		if (Trim(mygrid.cells2(i,1).getValue())!=""){
			msgwin.document.writeln("<tr>")
			for (j=1;j<cols;j++){
				if (j!=14){
					cell=mygrid.cells2(i,j).getValue()
					switch (j){
						case 1:
							if (Trim(cell)!="") cell=field_type[cell]+" ("+cell+")"
							break
						case 4:
						case 5:
							if (cell==1)
								cell="true"
							else
								cell=""
							break
						case 8:
							if (Trim(cell)!="") cell=input_type[cell]+" ("+cell+")"
							break
						case 11:
							if (Trim(cell)!="") cell=pick_type[cell]+" ("+cell+")"
							break
						case 17:
							cell=""
							break
						case 18:
							if (cell==1)
								cell="true"
							else
								cell=""
							break
						case 19:
							if (cell==1)
								cell="true"
							else
								cell=""
							break
						case 20:
							if (cell==1)
								cell="true"
							else
								cell=""
							break
						case 21:
							if (cell==1)
								cell="true"
							else
								cell=""
							break
						case 22:
							if (Trim(cell)!="") cell=validation[cell]+" ("+cell+")"
							break
						case 23:
							break
					}
					msgwin.document.write("<td bgcolor=white>"+cell+"&nbsp;</td>")
				}
			}
		}
	}
	msgwin.document.writeln("</table>")
	msgwin.document.writeln("</body></html>");

	msgwin.document.close()
	msgwin.focus()
	return
}
function Enviar(){
	ret=Validate("Actualizar")
	if (ret){
		<?php if ($arrHttp["Opcion"]=="new")
			echo  "document.forma1.action=\"fdt_new.php\"\n";
		else
		    echo  "document.forma1.action=\"fdt_update.php\"\n";
		?>
		document.forma1.target="";
		Actualizar()
	}
}
</script>
