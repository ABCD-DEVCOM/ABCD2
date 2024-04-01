<?php
/* Modifications
2021-02-09 fho4abcd Original name for dhtmlX.js
2021-11-25 fho4abcd Validate tags on int value, not on string (e.g. 1==001->error) + improve html
2024-04-01 fho4abcd More error messages. Improve layout,translations. Move dhtmlXGrid images to /assets. Remove unused code
*/
/* See https://docs.dhtmlx.com/api__dhtmlxgrid_addrow.html
*/
session_start();
include("../common/get_post.php");
include ("../config.php");

$lang=$_SESSION["lang"];

include("../lang/admin.php");// for indexes in institutionalinfo
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["permiso"]) and !isset($arrHttp["moodle"])){
	header("Location: ../common/error_page.php") ;
	die;
}
if (!isset($arrHttp["moodle"])){
	if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
	if ($arrHttp["Opcion"]!="new"){
		if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."CENTRAL_MODIFYDEF"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."CENTRAL_ALL"])){
			 header("Location: ../common/error_page.php") ;
			 die;
		}
	}else{
		if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CENTRAL_CRDB"])){
			header("Location: ../common/error_page.php") ;
			die;
		}
	}
}
if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
if ($arrHttp["Opcion"]=="new"){
	$fp=file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".mst");
	if ($fp){
		echo "<h1>".$msgstr["dbexists"]."</h1>";
		die;
	}
	//OJO ARREGLAR ESTO PARA QUE SALGA LA DESCRIPCIÓN
	if (isset($arrHttp["desc"])) $_SESSION["DESC"]=$arrHttp["desc"];
	echo "<script>Opcion='new'</script>\n";
}
	include("fdt_include.php");
	include("../common/header.php");

?>
<body>

	<link rel="stylesheet" type="text/css" href="/assets/css/dhtmlXGrid.css">
	<script  src="../dataentry/js/dhtml_grid/dhtmlX.js"></script>
 	<script  src="../dataentry/js/lr_trim.js"></script>
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

function AgregarFila(ixfila,Option){
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

	linkr="<a href=javascript:EditarFila(\""+ixf+"\","+ixf+")><font size=1>"+ref+"</a>";
	pick="<a href=javascript:Picklist(\"\","+ixf+")><font size=1>browse</a>";
	mygrid.addRow((new Date()).valueOf(),[linkr,'','','','','','','','','','','','','',pick,'','','','','','','','','','','',''],ixfila)
	mygrid.selectRow(ixfila);
}

function EditarFila(Fila,id){
   	Fila=mygrid.getRowIndex(mygrid.getSelectedId())
   	tipoC=mygrid.cells2(Fila,1).getValue()
   	tagC=mygrid.cells2(Fila,2).getValue()
   	switch (tipoC){
   		case "MF":  //Campo fijo Marc
   			msgwin=window.open("","WinRow","menu=0,scrollbars=yes,resizable,width=600,status")
	    	document.MFedit.tag.value=tagC
	    	document.MFedit.submit()
	    	msgwin.focus()
   			break
   		case "LDR": // Leader Marc
   			break
   		default:
	    	cols=mygrid.getColumnCount()
	    	VC=''
	    	for (j=1;j<cols;j++){
	    		cell=mygrid.cells2(Fila,j).getValue()
				if (j!=14) VC=VC+cell+'|'
	    	}
	    	document.rowedit.ValorCapturado.value=VC
	    	document.rowedit.row.value=Fila
	    	msgwin=window.open("","WinRow","menu=0,scrollbars=yes,resizable,width=600,status")
	    	document.rowedit.submit()
	    	msgwin.focus()
   	}
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
			document.edit_picklist.pl_type.value="<?php if(isset($arrHttp["type"])) echo $arrHttp["type"]?>"
			document.edit_picklist.picklist.value=pl_name
			document.edit_picklist.row.value=fila
			document.edit_picklist.type.value=pl_type
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
	msgwin=window.open(Url,"PL","menu=0,scrollbars,resizable")
	if (Url=="") document.edit_picklist.submit()
	msgwin.focus()
}
function Actualizar(){
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	VC=""
	for (i=0;i<rows;i++){
		if (Trim(mygrid.cells2(i,1).getValue())!=""){
			if (VC!="") VC=VC+"\n"
			for (j=1;j<cols;j++){
				cell=mygrid.cells2(i,j).getValue()
				if (j!=14) VC=VC+cell+'|'
			}
		}
	}
	document.forma1.ValorCapturado.value=VC
	document.forma1.submit()
	return
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
function EncabezarFilas(Rows){
	//Display heading rows
   	msgwin.document.writeln("<tr>")
   	if (Rows!="") msgwin.document.writeln("<td rowspan=2></td>")// cell for the row number
  	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=white><?php echo $msgstr["type"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["tag"]?></td>")
  	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=white><?php echo $msgstr["title"]?></td><td rowspan=2 align=center bgcolor=white>I</td><td rowspan=2 align=center bgcolor=white>R</td><td rowspan=2 align=center  bgcolor=white><?php echo $msgstr["subfields"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["preliteral"]?></td>")
  	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=white><?php echo $msgstr["inputtype"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["rows"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["cols"]?></td>")
  	msgwin.document.writeln("<td colspan=6 align=center bgcolor=white><?php echo $msgstr["picklist"]?></td>")

	msgwin.document.writeln("<td bgcolor=white rowspan=2><?php echo $msgstr["help"]?></td>")
	msgwin.document.writeln("<td bgcolor=white rowspan=2><?php echo $msgstr["url_help"]?></td><td bgcolor=white rowspan=2><?php echo $msgstr["link_fdt"]?></td><td bgcolor=white rowspan=2><?php echo $msgstr["mandatory"]?></td><td bgcolor=white rowspan=2><?php echo $msgstr["field_validation"]?></td><td bgcolor=white rowspan=2><?php echo $msgstr["pattern"]?></td>")
	msgwin.document.writeln("<tr>")
	msgwin.document.writeln("<td align=center bgcolor=white><?php echo $msgstr["type"]?></td><td bgcolor=white><?php echo $msgstr["name"]?></td><td bgcolor=white><?php echo $msgstr["prefix"]?></td><td bgcolor=white><?php echo $msgstr["pft"]?></td>")
	msgwin.document.writeln("<td bgcolor=white><?php echo $msgstr["listas"]?></td><td bgcolor=white><?php echo $msgstr["extractas"]?></td>")
}
function Validate(Opcion){
	var width = screen.availWidth;
    var height = screen.availHeight
	msgwin=window.open("","Fdt","width="+width+", height="+height+" resizable=yes, scrollbars=yes, menu=yes")
    msgwin.document.writeln("<html>")
    msgwin.document.writeln("<style>BODY{font-size: 8pt;}")
    msgwin.document.writeln("TD{font-family:arial; font-size:8pt;}")
    msgwin.document.writeln("</style>")
	msgwin.document.writeln("<body><table bgcolor=#F5F5F5>")
	EncabezarFilas("row")
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	msg=""
	fdt_tag=""
	mainentry=0
	displayTag=" <?php echo $msgstr["tag"]?>"+": "
	displayRow=" <?php echo $msgstr["fdtrow"]?>"+": "

	for (i=0;i<rows;i++){
		irow=i+1
		fila=""
		in_type=""
		pl_type=""
		pl_name=""
		pl_prefix=""
		pl_format=""
		pl_display=""
		cell=""
		displayRowfull=displayRow+irow

		for (j=1;j<cols;j++){   // Se verifica que la línea no esté en blanco
			cell=""
			if (j!=14) {
				cell=Trim(mygrid.cells2(i,j).getValue())
				if(cell=="undefined") cell=""
				if (cell=="0") cell=""
				fila+=cell
			}
		}
        Leader=""
		if (Trim(fila)!=""){
			msgwin.document.writeln("<tr><td>"+irow+"</td>")
			cell_colums=""
			cell_rows=""
			for (j=1;j<cols;j++){
				if (j!=14){// why this exception?
        			cell=Trim(mygrid.cells2(i,j).getValue())
                	if (cell=="undefined") cell=""
					switch (j){
						case 1: // Record Type. Shown as "type name(shortcut)"
							cell_type=cell
							if (cell!=""){
								cell=field_type[cell]
                               	cell=cell+" ("+cell_type+")"
                            }
                            if (cell_type=="LDR") Leader="S"

							break
						case 2: // Tag
							cell_tag=cell
                            displayTagfull=displayTag+cell_tag+" &rarr; "
							break
						case 3: // Titel/description
							cell_desc=cell
							break
						case 4:	// Principle entry
							cell_index=cell
							if (cell==1) mainentry++
						case 5:	// Repeatable
							if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
							}
							break
						case 6:	//Subfields
							cell_subc=cell
							break
						case 7:	//Preliterals
							cell_delim=cell
							break
						case 8: // Entry type/Input type
							in_type=cell
							displayIn_type=""
							if (cell!=""){
								cell=input_type[cell]
                               	cell=cell+" ("+in_type+")"
								displayIn_type=cell+" &rarr; "
                            }
							break
						case 9: //rows
							cell_rows=cell
							break
						case 10:	// columns
							cell_columns=cell
							break
						case 11:	// Picklist type
							if (Trim(cell)!="") {
								pl_type=cell
								cell=pick_type[cell]
      						}
							break
						case 12:	// Picklist name
							pl_name=cell
							break
						case 13:	// Picklist prefix
							pl_prefix=cell
							break
							// case 14 is excluded from the loop
						case 15:	// Display format(PFT)
							pl_format=cell
							break
						case 16:	// Display as
							pl_display=cell
							break;
       					case 17:	// Extract as
       						cell=""
             				break
                 		case 18:	//Help
                 			if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
							}
							break
						case 19:	// Help URL
							url_help=cell
							break;
						case 20:	// Link FDT
                 			if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
							}
							break
						case 21:	// Req?
                 			if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
							}
							break
						case 22:	// Field validation (is a picklist)
							if (cell!=""){
								cell=validation[cell]
                               	cell=cell+" ("+cell_type+")"
                            }
                            break
        				case 23:	// Validation pattern
							cell_pattern=cell
							break
					}
					// Display the cell
					msgwin.document.write("<td bgcolor=white>"+ cell+"&nbsp;</td>")
				}
			} // end of loop over columns in the current row
			// Check of all entries in the current row that require checking
			if (cell_type!="L" && cell_type!="MF" && cell_type!="LDR"){       //Todos los campos deben poseer descripcion menos el tipo L y el tipo MF
				if (cell_desc==""){
					msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["misfdttitle"]?>"+"<br>"
				}
			}
			if (cell_type=="H" || cell_type=="L" ||cell_type=="S"  || cell_type=="LDR"){  //Estos campos no requieren tag
				if (cell_tag!="" && cell_tag<1){
					msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["tagnoreq"]?>"+" "+cell_type+"<br>"
				}
			}else{
				if (cell_tag==""){
					msg+=displayRowfull+" &rarr; <?php echo $msgstr["tagreq"]?>"+" '"+cell_type+"'<br>"
				}
				if (cell_tag!="") {
					if (IsNumeric(cell_tag)==false){
						msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["invtag"]?>"+"<br>"
					} else {
                        tt= parseInt(cell_tag )
                        if (tt<1 || tt>999){
                            msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["invtag"]?>"+"<br>"
                        }
                        if (fdt_tag.indexOf("|"+tt+"|")==-1){
                            fdt_tag+="|"+tt+"|"
                        }else{
                            msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["duptag"]?>"+"<br>"
                        }
                    }
              	}
			}
			if (cell_type=="S"){    // se determina que el subcampo esté precedido por un tipo T o por TB  o por M
				res=false
    			for (ix=i-1;ix>=0;ix--){
					type=mygrid.cells2(ix,1).getValue()
     				if (type=="T" || type=="TB" || type=="M" || type=="LDR"){
						res=true
						ix=-1
					}else{
						if (type!="S")ix=-1
					}
				}
				if (res==false){
					msg+=displayRowfull+displayTagfull +" <?php echo $msgstr["sfgroup"]?>"+"<br>"
				}
			}
			if (cell_type=="T"){
				tag_subc=cell_tag
				if (cell_subc==""){
					msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["missubf"]?>"+"<br>"
				}else{
					ix=i+1
					type=mygrid.cells2(ix,1).getValue()
					if (type!="S" && FDT=="S" ){
						msg+=displayRowfull+displayTagfull + " <?php echo $msgstr["missubfge"]?>"+"<br>"
					}
				}
				ixsc=0
				for (ix=i+1;ix<rows;ix++){
					type=mygrid.cells2(ix,1).getValue()
					if (type=="S"){
						ixsc=ixsc+1
					}else{
						ix=rows+99
					}
				}
				nsc=cell_subc.length

 				if (nsc!=ixsc){
 					//alert(nsc+"  "+ixsc)
					msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["sfcounterr"]?>" +"<br>"
				}
			}
		    switch (pl_type){   // se valida la consistencia de los datos del picklist asignado al campo
				case "XT":
					msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["notimplemented"]?>"+"<br>"
					break
				case "D":
				case "T":
					if (pl_type=="T" && pl_format=="" && pl_display=="" && pl_prefix=="")
						break
					if (pl_format==""){
						msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["misextformat"]?>"+"<br>"
					}
					if (pl_display=="" && pl_format==""){
						msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["misdispformat"]?>"+"<br>"
					}
					i_type=Trim(mygrid.cells2(i,8).getValue())
					if (i_type!="X"  && i_type!="RO" && i_type!="TB" && i_type!="COMBO" && i_type!="COMBORO" && i_type!="SRO" && i_type !="MRO"){
						msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["invinputype"]?>"+"<br>"
					}
					break;
				case "P":
					if (pl_name==""){
						msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["insplname"]?>"+"<br>"
					}
					i_type=Trim(mygrid.cells2(i,8).getValue())
					if (i_type !="C" && i_type!="R" &&  i_type!="COMBO" && i_type!="COMBORO" && i_type!="S" && i_type!="SRO" && i_type!="M" && i_type!="MRO")
					break
			}
		}
		// Se valida si los campos tipo COMBO, COMBORO, SRO, MRO, C, R tienen asignada una picklits
		i_type=Trim(mygrid.cells2(i,8).getValue())
		if (i_type=="C" || i_type=="R" || i_type=="COMBO" || i_type=="COMBORO" || i_type=="SRO" || i_type =="MRO" ||i_type=="S" || i_type=="M"){
			if (pl_type=="")
				msg+=displayRowfull+displayTagfull+" <?php echo $msgstr["picklist"]. " ".$msgstr["missing"]?>"+"<br>"
		}
		// Check the value of "rows"
		if (in_type=="OD"){
			if (cell_rows=="" || IsNumeric(cell_rows)==false || Number(cell_rows)<=0){
				msg+=displayRowfull+displayTagfull+displayIn_type+ " <?php echo $msgstr["fdterr_int_req_od"]?>"+"<br>"
			}
		} else if (in_type=="A" || in_type=="M" || in_type=="T" || in_type=="X") {
			if (cell_rows!="" && (IsNumeric(cell_rows)==false || Number(cell_rows)<0)){
				// This requires further investigation. There exists FDT's with value 1.5 and possibly 1/5
				msg+=displayRowfull+displayTagfull+displayIn_type+ " <?php echo $msgstr["fdterr_noint"]?>"+"<br>"
			}
		}

	} // end loop over Rows
	
	msgwin.document.writeln("</table>")
	if (mainentry>1){
		msg+="<?php echo $msgstr["errmainentry"]?>"
	}
	
	// Display the error messages or "no errors"
	if (msg!=""){
		msgwin.document.writeln('<p><a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/fdt_err.html target=_blank><?php echo $msgstr["err_fdt"]?></a>&nbsp; &nbsp;')
    	msgwin.document.writeln('<a href=../documentacion/edit.php?archivo=<?php echo $_SESSION["lang"]?>/fdt_err.html target=_blank>edit help file</a>')
		msgwin.document.writeln("<p style='color:red'>"+msg)
		msgwin.focus()
	}else{
		msgwin.document.writeln("<p><?php echo $msgstr["noerrors"]?>")
		msgwin.focus()
	}

	if (Opcion=="Actualizar"){
		if (msg=="") {
			msgwin.close()
			return true
        }else{
			msgwin.document.writeln("<h4><?php echo $msgstr["fdterr"]?></h4>")
			msgwin.focus()
			alert("<?php echo $msgstr["fdterr"]?>!!!")
		}
	}
	msgwin.document.writeln("</body></html>")
	msgwin.document.close()
	msgwin.focus()
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
	EncabezarFilas("")
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	top_row=rows
	for (i=0;i<top_row;i++){
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

<div id="loading">
  <img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading..." />
</div>
<script>
document.getElementById('loading').style.display='block';
</script>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
}?>
<form>
<?php
	unset($fp);
	$link_fdt="";
	$link_fdt="S";
	if ($arrHttp["Opcion"]=="new"){

		if (!isset($_SESSION["FDT"])){
			$fp=array();
			for ($i=0;$i<20;$i++){
				$fp[$i]='|||||||||||||||||||||||';
			}

      	}else{
			$fp=explode("\n",$_SESSION["FDT"]);
			$fp[]='||||||||||||||||||||||||||||||||||||||||||||||';
			$fp[]='||||||||||||||||||||||||||||||||||||||||||||||';
		}
		$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
		if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		$xarch=$arrHttp["base"].".fdt";
	}else{
        if (isset($arrHttp["type"]) and $arrHttp["type"]=="bd"){
        	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
			if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
        	$xarch=$arrHttp["base"].".fdt";

		}else{
			if (isset($arrHttp["fmt_name"])) {
				$arrHttp["type"]=$arrHttp["fmt_name"].".fmt"; //EDIT A DATAENTRY WORKSHEET, ELSE EDIT A MARC FIXED FIELD FDT
				$link_fdt="S";
			}
			if (isset($arrHttp["Fixed_field"])){
				$arrHttp["type"]=$arrHttp["fdt_name"];
			}
            $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["type"];
			if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["type"];
			$xarch=$arrHttp["type"];
		}
		unset($fp);
		if (file_exists($archivo))	$fp=file($archivo);
 		//echo "tope=20\n";
	}
	echo "<div class=\"sectionInfo\">
		<div class=\"breadcrumb\">";
  //	echo $msgstr["bd"].": ". $arrHttp["base"]."<br>";
	if (isset($arrHttp["fmt_desc"])) {
      	echo $msgstr["fmt"];
    }else{
       	echo $msgstr["fdt"];
    }

	echo ": ".$xarch;
	if (isset($arrHttp["fmt_desc"])) echo " (".$arrHttp["fmt_desc"].")";

	echo "</div><div class=\"actions\">";
	if (!isset($arrHttp["moodle"])){
		if ($arrHttp["Opcion"]=="new"){
			if (isset($arrHttp["encabezado"])){
				$backtoscript = "../common/inicio.php?reinicio=s";
				include "../common/inc_back.php";
			}else{
				$backtoscript = "menu_creardb.php";
				include "../common/inc_back.php";				
			}
		} else {
			if (isset($arrHttp["encabezado"])) {
				$encabezado="&encabezado=s";
			} else {
				$encabezado="";
			}
			if (isset($arrHttp["Fixed_field"])){
				$backtoscript = "fixed_marc.php?base=". $arrHttp["base"].$encabezado;
				include "../common/inc_back.php";
			} else {
				if (!isset($arrHttp["ventana"])) {	
					$backtoscript = "menu_modificardb.php?base=". $arrHttp["base"].$encabezado;
					include "../common/inc_back.php";
				} else { 
					$backtoscript = "javascript:self.close()";
					include "../common/inc_back.php";
				}
			}
		}
		include "../common/inc_home.php";
	}//isset($arrHttp["moodle"]
		?>
				</div>
				<div class="spacer">&#160;</div>
		</div>

<?php 
$ayuda = "fdt.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
		<div class="formContent">
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')"><?php echo $msgstr["addrowbef"]?></a>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')"><?php echo $msgstr["addrowaf"]?></a>
			<a class="bt bt-red" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['double_click']?></span>
	
<div class="row">
<table  style="width:100%; height:300px;" id="tblToGrid" class="dhtmlxGrid">
<?php
echo "<tr>";
foreach ($rows_title as $cell){
	echo "<td>".$cell."</td>\n";
}
echo "</tr>";

$nfilas=0;
$i=-1;
if (isset($fp)){
	$t=array();
	foreach ($fp as $value){
		$value=trim($value);
		if (trim($value)!=""){
			echo "\n<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";

			$nfilas=$nfilas+1;
			$value.="|||||||||||||||||||||" ;
			$t=explode("|",$value);
   			switch ($t[0]){
             	case "OD":
              		$t[0]="F" ;
              		$t[7]="OD";
                	break;
                case "OC":
                     $t[0]="F";
                     $t[7]="OC";
                	break;
                case "ISO":
                     $t[0]="F";
                     $t[7]="ISO";
                	break;
                case "DC":
                    $t[0]="F";
                  	$t[7]="DC";
              		break;
             	case "AI":
                    $t[0]="F";
                  	$t[7]="AI";
              		break;
      		}
			$i=$i+1;
			$irow=$i+1;
			$linkr="<a href='javascript:EditarFila(\"".$irow."\",$i)'><font size=1>$irow</font></a>";
			echo "<td type=\"link\">$linkr</td>";
			if ($t[0]=="F" or $t[0]=="S"){
				if (trim($t[7])=="") $t[7]="X";
			}
			$pick="";
			for ($ix=0;$ix<21;$ix++) if (!isset($t[$ix])) $t[$ix]="";
			if (trim($t[0])!="H" and trim($t[0])!="L"){
				if ($t[10]=="")
					$pick="<a href='javascript:Picklist(\"".$t[1].".tab\",$i)'><font size=1>browse</font></a>";
				else
		    		$pick="<a href='javascript:Picklist(\"".$t[10]."\",$i)'><font size=1>browse</font></a>";
			}
			$irow=$i+1;
			$linkr="<a href='javascript:EditarFila(\"".$irow."\",$i)'><font size=1>$irow</font></a>";
			if (!isset($t[16])) $t[16]="";
			$ixt=-1;
			//"link,coro,ed,ed,ch,ch,ed,ed,coro,ed,ed,coro,ed,ed,link,ed,ed,ed,ch,ed,ch,ch,coro,ed"
			foreach ($t as $fila) {
   				//$fila=trim($fila);
       			$ixt=$ixt+1;
       			if ($ixt>21) break;        //NUMERO DE COLUMNAS QUE TIENE LA FDT
       			if ($ixt==16 or $ixt==18 or $ixt==19)
       				$align=" align=center";
       			else
       				$align="";

           		switch($ixt){
                   	case 0:
                   	   	echo "<td $align type=\"coro\">";
                   		echo $fila;
                   		$FT[$i]=$fila;
                   		break;
                   	case 3:
                   		echo "<td $align type=\"ch\">";
                   		echo $fila;
                   		$IN[$i]=$fila;
                   		break;
                   	case 4:
                   		echo "<td $align type=\"ch\">";
                   		echo $fila;
                   		$RE[$i]=$fila;
                   		break;
                   	case 7:
                   		echo "<td $align type=\"coro\">";
                   		echo $fila;
                   		$IT[$i]=$fila;
                   		break;
                   	case 10:
                   		echo "<td $align type=\"coro\">";
                   		echo $fila;
                   		$PL[$i]=$fila;
                   		break;
                   	case 13:
                   		echo "<td $align type=\"link\">";
                   		if ($pick=="")$pick="&nbsp;";
                   		echo $pick;
                   		if ($fila=="") $fila="&nbsp;";
                   		echo"</td><td type=\"ed\">$fila";
                   		break;
                   	case 16:
                   	    echo "<td $align type=\"ch\">";
                   	    $HP[$i]=$fila;
                   	    echo $fila;
                   	    break;
                   	case 18:
                   		echo "<td $align type=\"ch\">";
                   		$LKF[$i]=$fila;
                   		break;
                   	case 19:
                   		echo "<td $align type=\"ch\">";
                   		$MANDATORY[$i]=$fila;
                   		break;
                   	case 20:
                   		echo "<td $align type=\"coro\">";
                   		$VAL[$i]=$fila;
                   		break;
                   	default:
                   		echo "<td $align type=\"edtxt\">";
                   		 if ($fila=="") $fila="&nbsp;";
                   		 echo $fila;
                   		 break;
				}
				echo "</td>";
			}
			echo " </tr>";
		}
	}
}
?>
	</table>
</div>
<?php
// Error message if no file found. Happens only in erroneous situations but saves a lot of investigations.
if (!isset($fp)) echo "<p style='color:red'>".$msgstr["file"].": ".$archivo." &rarr; ".$msgstr["ne"]."</p>";
?>		
	<a class="bt bt-blue" href=javascript:Test()><?php echo $msgstr["test"]?></a>
	<a class="bt bt-blue" href=javascript:List()><?php echo $msgstr["list"]?></a>
	<a class="bt bt-blue" href=javascript:Validate()><?php echo $msgstr["validate"]?></a>
	<?php
	if (!isset($arrHttp["moodle"]))
		echo "<a class='bt bt-green' href=javascript:Enviar()>". $msgstr["update"]."</a>";?>

<script>
	var mygrid = new dhtmlXGridFromTable('tblToGrid');
	mygrid.setImagePath("/assets/images/dhtml_grid/imgs/");
	mygrid.setColTypes("link,coro,ed,ed,ch,ch,ed,ed,coro,ed,ed,coro,ed,ed,link,ed,ed,edtxt,ch,ed,ch,ch,coro,ed");
	mygrid.getCombo(11).put("","");
	mygrid.getCombo(1).put("","");
	mygrid.getCombo(8).put("","");
	mygrid.getCombo(22).put("","");
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
	<?php
	foreach ($field_type as $key=>$value) echo "mygrid.getCombo(1).put(\"".$key."\",\"".$value."\")\n";
	foreach ($input_type as $key=>$value) echo "mygrid.getCombo(8).put(\"".$key."\",\"".$value."\")\n";
	foreach ($pick_type as $key=>$value) echo "mygrid.getCombo(11).put(\"".$key."\",\"".$value."\")\n";
	foreach ($validation as $key=>$value) echo "mygrid.getCombo(22).put(\"".$key."\",\"".$value."\")\n";
  	if (!isset($arrHttp["encabezado"]))
    	echo  "mygrid.enableAutoHeigth(true,270)\n";
    else
        echo  "mygrid.enableAutoHeigth(true,300)\n";

    for ($ix=0;$ix<$nfilas;$ix++){
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
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
    mygrid.attachHeader("#rspan,<?php echo $msgstr["field_prop"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,<?php echo $msgstr["dataentry"]?>,#cspan,#cspan,<?php echo $msgstr["picklist"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan");
	mygrid.enableColumnAutoSize(true)
	mygrid.setColWidth(0,35)	//fdt row
	mygrid.setColWidth(1,80)	//type
	mygrid.setColWidth(2,35)	//tag
	mygrid.setColWidth(3,150)	//title
	mygrid.setColWidth(4,23)	//i:principal entry
	mygrid.setColWidth(5,23)	//repetible
	mygrid.setColWidth(6,60)	//subfields
	mygrid.setColWidth(7,2)    	//columnas a eliminar
    mygrid.setColWidth(8,120)	//input type
    mygrid.setColWidth(9,40)	//rows
    mygrid.setColWidth(10,35)	//cols
    mygrid.setColWidth(11,50)	//type
    mygrid.setColWidth(12,70)	//Name
    mygrid.setColWidth(13,45)	//prefix

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
<br><br>
</div></div>
</form>
<form name=forma1 action=fdt_update.php method=post>
<?php if (isset($arrHttp["fmt_name"])){
	echo "<input type=hidden name=fmt_name value=".$arrHttp["fmt_name"].">\n";
}
	if (isset($arrHttp["fmt_desc"])) echo "<input type=hidden name=fmt_desc value=\"".$arrHttp["fmt_desc"]."\">\n";
    if (isset($arrHttp["UNICODE"]))  echo "<input type=hidden name=UNICODE value=\"".$arrHttp["UNICODE"]."\">\n";
    if (isset($arrHttp["CISIS_VERSION"]))  echo "<input type=hidden name=CISIS_VERSION value=\"".$arrHttp["CISIS_VERSION"]."\">\n";
?>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=archivo value=<?php echo $xarch?>>
<?php if (isset( $arrHttp["ventana"])) echo "<input type=hidden name=ventana value=". $arrHttp["ventana"].">\n";
      if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>\n";
	  if (isset($arrHttp["Fixed_field"]))  echo "<input type=hidden name=Fixed_field value=".$arrHttp["Fixed_field"].">\n";
	  if (isset($arrHttp["cisis"]))  echo "<input type=hidden name=cisis value=".$arrHttp["cisis"].">\n";
	  if (isset($arrHttp["dcimport"]))  echo "<input type=hidden name=dcimport value=".$arrHttp["dcimport"].">\n";
?>

</form>
<form name=rowedit action=fdt_rowedit.php method=post target=WinRow>
<input type=hidden name=ValorCapturado>
<input type=hidden name=row>
<?php if (isset($arrHttp["UNICODE"]))  echo "<input type=hidden name=UNICODE value=\"".$arrHttp["UNICODE"]."\">\n"; ?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
</form>
<form name=MFedit action=fdt.php method=post target=WinRow>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php if (isset($arrHttp["UNICODE"]))  echo "<input type=hidden name=UNICODE value=\"".$arrHttp["UNICODE"]."\">\n"; ?>
<input type=hidden name=tag>
</form>
<form name=edit_picklist method=post target=PL action=picklist.php>
<?php if (isset($arrHttp["UNICODE"]))  echo "<input type=hidden name=UNICODE value=\"".$arrHttp["UNICODE"]."\">\n"; ?>
<input type=hidden name=base>
<input type=hidden name=pl_type>
<input type=hidden name=picklist>
<input type=hidden name=row>
<input type=hidden name=type>
</form>
<script>
<?php
$xar=explode(".",$xarch);
if (strtoupper($xar[0])==strtoupper($arrHttp["base"]))
	echo "FDT='S'";
else
	echo "FDT='N'";
?>

document.getElementById('loading').style.display='none';
</script>

<?php include ("../common/footer.php");?>

