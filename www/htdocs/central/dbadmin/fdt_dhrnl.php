<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
if ($arrHttp["Opcion"]=="new"){	$fp=file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".mst");
	if ($fp){		echo "<h1>".$msgstr["dbexists"]."</h1>";
		die;
	}
	//OJO ARREGLAR ESTO PARA QUE SALGA LA DESCRIPCIÓN
	if (isset($arrHttp["desc"])) $_SESSION["DESC"]=$arrHttp["desc"];
	echo "<script>Opcion='new'</script>\n";
}
	include("fdt_include.php");
	include("../common/header.php");

if ($arrHttp["Opcion"]!="new"){?>
<SCRIPT LANGUAGE="JavaScript">
	var width = 300;
    var height = 80;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height + ",status=no,resizable=no,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
    progress = window.open("", "progressbar", windowFeatures);

	progress.document.writeln("<html><title>FDT</title><body bgcolor=#cccccc>");
	progress.document.writeln("<font face=arial><h6><?php echo $msgstr["leyendo"]." ".$msgstr["fdt"].". ".$msgstr["wait"]." ..."?>")
    progress.document.writeln("</body></html>")
    progress.document.close()

</script>
<?php }
?>
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid.css">
	<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid_skins.css">
	<script  src="../dataentry/js/dhtml_grid/dhtmlXCommon.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGridCell.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_drag.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_excell_link.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_start.js"></script>
 	<script  src="../dataentry/js/lr_trim.js"></script>

	<script languaje=javascript>
	field_type=Array()
	input_type=Array()
	pick_type=Array()
<?php foreach ($field_type as $key=>$value) echo "field_type['$key']='$value'\n";
  foreach ($input_type as $key=>$value) echo "input_type['$key']='$value'\n";
  foreach ($pick_type as $key=>$value) echo "pick_type['$key']='$value'\n";
?>
	pl_type=""
	Opcion="<?php echo $arrHttp["Opcion"]?>"
	valor=""
	prefix=""
	list=""
	extract=""
	fila=""
	columna=12

    function AsignarFila(){
		mygrid.cells2(fila,columna).setValue(valor)
		mygrid.cells2(fila,13).setValue(prefix)
		mygrid.cells2(fila,15).setValue(list)
		mygrid.cells2(fila,16).setValue(extract)
	//	closeit()
	}


	function Asignar(){		mygrid.cells2(fila,columna).setValue(valor)
		mygrid.cells2(fila,13).setValue(prefix)
		mygrid.cells2(fila,15).setValue(list)
		mygrid.cells2(fila,16).setValue(extract)
	//	closeit()	}

	function switchDiv(div_id)
{
  var style_sheet = getStyleObject(div_id);
  if (style_sheet)
  {
 //   hideAll();
    changeObjectVisibility(div_id, "hidden");
  }
  else
  {
    alert("sorry, this only works in browsers that do Dynamic HTML");
  }
}

var DHTML = (document.getElementById || document.all || document.layers);

function getObj(name){
  if (document.getElementById)
  {
  	this.obj = document.getElementById(name);
	this.style = document.getElementById(name).style;
  }
  else if (document.all)
  {
	this.obj = document.all[name];
	this.style = document.all[name].style;
  }
  else if (document.layers)
  {
   	this.obj = document.layers[name];
   	this.style = document.layers[name];
  }
}


function EditarFila(Fila,id){
   	Fila=mygrid.getRowIndex(mygrid.getSelectedId())
   	tipoC=mygrid.cells2(Fila,1).getValue()
   	tagC=mygrid.cells2(Fila,2).getValue()
   	switch (tipoC){   		case "MF":  //Campo fijo Marc
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
	if (pl_type==""){		alert("<?php echo $msgstr["selpltype"]?>")
		return	}
	switch (pl_type){		case "P":
			Url="picklist.php?base=<?php echo $arrHttp["base"]?>&picklist="+pl_name+"&row="+fila+"&pl_type=<?php if(isset($arrHttp["type"])) echo $arrHttp["type"]?>"
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
  			break	}
	Url+="&type="+pl_type
	msgwin=window.open(Url,"PL","menu=0,scrollbars,resizable")
	msgwin.focus()
}

function Actualizar(){
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	VC=""
	for (i=0;i<rows-1;i++){
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

function Test(){	msgwin=window.open("","Test")
	msgwin.document.close()	document.forma1.action="../dataentry/fdt_test.php";
	document.forma1.target="Test";
	msgwin.focus()
	Actualizar()}

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

function EncabezarFilas(Rows){   	msgwin.document.writeln("<tr>")
   	if (Rows!="") msgwin.document.writeln("<td rowspan=2></td>")
  	msgwin.document.writeln("<td rowspan=2 align=center bgcolor=white><?php echo $msgstr["type"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["tag"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["title"]?></td><td rowspan=2 align=center bgcolor=white>I</td><td rowspan=2 align=center bgcolor=white>R</td><td rowspan=2 align=center  bgcolor=white><?php echo $msgstr["subfields"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["preliteral"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["inputtype"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["rows"]?></td><td rowspan=2 align=center bgcolor=white><?php echo $msgstr["cols"]?></td><td colspan=5 align=center bgcolor=white><?php echo $msgstr["picklist"]?></td>")
   	msgwin.document.writeln("<td  colspan=3 bgcolor=white></td>")
	msgwin.document.writeln("<tr><td align=center bgcolor=white><?php echo $msgstr["type"]?></td><td bgcolor=white><?php echo $msgstr["name"]?></td><td bgcolor=white><?php echo $msgstr["prefix"]?></td><td bgcolor=white><?php echo $msgstr["pft"]?></td><td bgcolor=white><?php echo $msgstr["extractas"]?></td><td bgcolor=white></td><td bgcolor=white><?php echo $msgstr["help"]?></td><td bgcolor=white></td>")}

function Validate(Opcion){	msgwin=window.open("","Fdt")
    msgwin.document.writeln("<html>")
    msgwin.document.writeln("<style>BODY{font-family: 'Trebuchet MS', Arial, Verdana, Helvetica; font-size: 8pt;}")
    msgwin.document.writeln("TD{font-family:arial; font-size:8pt;}")
    msgwin.document.writeln("</style>")
	msgwin.document.writeln("<body><table bgcolor=#CCCCCC>")
	EncabezarFilas("row")
	cols=mygrid.getColumnCount()
	rows=mygrid.getRowsNum()
	msg=""
	fdt_tag=""
	mainentry=0
	for (i=0;i<rows-1;i++){
		irow=i+1
		fila=""
		pl_type=""
		pl_name=""
		pl_prefix=""
		pl_format=""
		pl_display=""
		cell=""
		for (j=1;j<cols;j++){   // Se verifica que la línea no esté en blanco
			cell=""
			if (j!=14) {				cell=Trim(mygrid.cells2(i,j).getValue())
				if(cell=="undefined") cell=""
				if (cell=="0") cell=""
				fila+=cell
			}
		}
        Leader=""
		if (Trim(fila)!=""){
			msgwin.document.writeln("<tr><td>"+irow+"</td>")
			for (j=1;j<cols;j++){
				if (j!=14){
        			cell=Trim(mygrid.cells2(i,j).getValue())
                	if (cell=="undefined") cell=""
					switch (j){
						case 1:
							cell_type=cell
							if (cell!=""){
								cell=field_type[cell]
                               	cell=cell+" ("+cell_type+")"
                            }
                            if (cell_type=="LDR") Leader="S"
							break
						case 2:
							cell_tag=cell
                            if (cell!="")tag_subc=cell
							break
						case 3:
							cell_desc=cell
							break
						case 4:
							cell_index=cell
							if (cell==1) mainentry++
						case 5:
							if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
							}
							break
						case 6:
							cell_subc=cell
							break
						case 7:
							cell_delim=cell
							break
						case 8:
							if (cell!="") cell=input_type[cell]
							break
						case 11:
							if (Trim(cell)!="") {
								pl_type=cell
								cell=pick_type[cell]
      						}
							break
						case 12:
							pl_name=cell
							break
						case 13:
							pl_prefix=cell
							break
						case 15:
							pl_format=cell
							break
						case 16:
							pl_display=cell
							break;
       					case 17:
       						cell=""
             				break
                 		case 18:
                 			if (cell!=""){
								if (cell==1)
									cell="true"
								else
									cell=""
								}
								break
						case 19:
							url_help=cell
					}
					msgwin.document.write("<td bgcolor=white>"+ cell+"&nbsp;</td>")
				}
			}
			if (cell_type!="L" && cell_type!="MF" && cell_type!="LDR"){       //Todos los campos deben poseer descripcion menos el tipo L y el tipo MF
				if (cell_desc==""){
					msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["misdesc"]?>"+"<br>"
				}
			}
			if (cell_type=="H" || cell_type=="L" ||cell_type=="S"  || cell_type=="LDR"){  //Estos campos no requieren tag
				if (cell_tag!="" && cell_tag<1000){
					msg+="row: "+irow+" Tag: "+cell_tag+" <?php echo $msgstr["tagnoreq"]?>"+"<br>"
				}
			}else{
				if (cell_tag==""){
					msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["tagreq"]?>"+"<br>"
				}
				if (cell_tag!="") {
                    if (fdt_tag.indexOf("|"+cell_tag+"|")==-1){
						fdt_tag+="|"+cell_tag+"|"
					}else{
						msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["duptag"]?>"+"<br>"
					}
					if (IsNumeric(cell_tag)==false){
						msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["invtag"]?>"+"<br>"
					}
					tt= parseInt(cell_tag )
					if (tt<1 || tt>999){
						msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["invtag"]?>"+"<br>"
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
				msg+="row: "+irow+" Tag: "+cell_tag +" <?php echo $msgstr["sfgroup"]?>"+"<br>"
			}
			if (cell_type=="T"){
				tag_subc=cell_tag
				if (cell_subc==""){
					msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["missubf"]?>"+"<br>"
				}else{
					ix=i+1
					type=mygrid.cells2(ix,1).getValue()
					if (type!="S" && FDT=="S" ){
						msg+="row: "+irow+" Tag: "+cell_tag + " <?php echo $msgstr["missubfge"]?>"+"<br>"
					}
				}
				ixsc=0
				for (ix=i+1;ix<rows-1;ix++){
					type=mygrid.cells2(ix,1).getValue()
					if (type=="S"){
						ixsc++
					}else{
						ix=rows+99
					}
				}
				nsc=cell_subc.length
				if (nsc!=ixsc && FDT=="S"){
					msg+="row: "+irow+" Tag: "+cell_tag+" <?php echo $msgstr["sfcounterr"]?>" +"<br>"
				}
			}
		    switch (pl_type){   // se valida la consistencia de los datos del picklist asignado al campo
				case "xT":
					msg+="row: "+irow+" Tag: "+tag_subc+" <?php echo $msgstr["notimplemented"]?>"+"<br>"
					break
				case "D":
					if (pl_format==""){
						msg+="row: "+irow+" Tag: "+tag_subc+" <?php echo $msgstr["misextformat"]?>"+"<br>"
					}
					if (pl_display=="" && pl_format==""){
						msg+="row: "+irow+" Tag: "+tag_subc+" <?php echo $msgstr["misdispformat"]?>"+"<br>"
					}
					i_type=Trim(mygrid.cells2(i,8).getValue())
					if (i_type!="X"  && i_type!="RO"){
						msg+="row: "+irow+" Tag: "+tag_subc+" <?php echo $msgstr["invinputype"]?>"+"<br>"
					}
					break;
				case "P":
					if (pl_name==""){
						msg+="row: "+irow+" Tag: "+tag_subc+" <?php echo $msgstr["insplname"]?>"+"<br>"
					}
					break
				}
			}
		}
	}
	msgwin.document.writeln("</table>")
	if (mainentry>1){		msg+="<?php echo $msgstr["errmainentry"]?>"	}
	if (msg!=""){
		msgwin.document.writeln('<p><a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/fdt_err.html target=_blank><?php echo $msgstr["err_fdt"]?></a>&nbsp &nbsp;')
    	msgwin.document.writeln('<a href=../documentacion/edit.php?archivo=<?php echo $_SESSION["lang"]?>/fdt_err.html target=_blank>edit help file</a>')
		msgwin.document.writeln("<p>"+msg)
		msgwin.focus()
	}else{		msgwin.document.writeln("<p><?php echo $msgstr["noerrors"]?>")
		msgwin.focus()
	}

	if (Opcion=="Actualizar"){
		if (msg=="") {
			msgwin.close()			return true
        }else{
			msgwin.document.writeln("<h4><?php echo $msgstr["fdterr"]?></h4>")
			msgwin.focus()
			alert("<?php echo $msgstr["fdterr"]?>!!!")
		}
	}
	msgwin.document.writeln("</body></html>")
	msgwin.focus()}

function List(){
	msgwin=window.open("","Fdt","")
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
	top_row=rows-2
	for (i=0;i<top_row;i++){
		if (Trim(mygrid.cells2(i,1).getValue())!=""){
			msgwin.document.writeln("<tr>")
			for (j=1;j<cols;j++){
				if (j!=14){
					cell=mygrid.cells2(i,j).getValue()
					switch (j){						case 1:
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
	if (ret){		<?php if ($arrHttp["Opcion"]=="new")
			echo  "document.forma1.action=\"fdt_new.php\"\n";
		else
		    echo  "document.forma1.action=\"fdt_update.php\"\n";
		?>
		document.forma1.target="";
		Actualizar()
	}
}

function doBeforeRowDeleted(rowId){
	VC=""
	for (j=0;j<3;j++){
		cell=mygrid.cells(rowId,j).getValue()
		VC=VC+cell
	}
	if (VC=="")
		return true
	else
		return confirm("Are you sure you want to delete row");
}

function doOnRowSelected(id){
}

function doOnCellEdit(stage,rowId,cellInd){
    if (stage==2){
		if (cellInd==11){
			cell=mygrid.cells(rowId,11).getValue()
			if (Trim(cell)==""){
				mygrid.cells2(i,11).setValue("")
				mygrid.cells2(i,12).setValue("")
				mygrid.cells2(i,13).setValue("")
				mygrid.cells2(i,14).setValue("")
				mygrid.cells2(i,15).setValue("")
			}else{
				tag=mygrid.cells(rowId,1).getValue()
				tag+=".tab"
				i=mygrid.getRowIndex(rowId)
                url="<a href=javascript:Picklist('"+tag+"',i)><font size=1>browse</a>"
                mygrid.cells2(i,14).setValue(url)
			}
		}
	}
	return true
}
</script>

<body>
<?php
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
}?>

<form>
<?php
	unset($fp);
	if ($arrHttp["Opcion"]=="new"){
		if (!isset($_SESSION["FDT"])){
			$fp=array();
			for ($i=0;$i<20;$i++){
				$fp[$i]='||||||||||||||||||';
			}
			$tope=20;

      	}else{
			$fp=explode("\n",$_SESSION["FDT"]);
		}
		$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
		if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		$xarch=$arrHttp["base"].".fdt";
	}else{
        if ($arrHttp["type"]=="bd"){
        	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
			if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
        	$xarch=$arrHttp["base"].".fdt";

		}else{
			if (isset($arrHttp["fmt_name"])) {				$arrHttp["type"]=$arrHttp["fmt_name"].".fmt"; //EDIT A DATAENTRY WORKSHEET, ELSE EDIT A MARC FIXED FIELD FDT			}
			if (isset($arrHttp["Fixed_field"])){
				$arrHttp["type"]=$arrHttp["fdt_name"];			}
            $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["type"];
			if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["type"];
			$xarch=$arrHttp["type"];
		}		unset($fp);
		if (file_exists($archivo))	$fp=file($archivo);
 		//echo "tope=20\n";
	}	echo "<div class=\"sectionInfo\">
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
	if ($arrHttp["Opcion"]=="new"){		if (isset($arrHttp["encabezado"])){
			echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">";
		}else{			 echo "<a href=menu_creardb.php class=\"defaultButton cancelButton\">";		}	}else{		if (isset($arrHttp["encabezado"]))
			$encabezado="&encabezado=s";
		else
			$encabezado="";
		if (isset($arrHttp["Fixed_field"])){			echo "<a href=fixed_marc.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton cancelButton\">";		}else{
			if (!isset($arrHttp["ventana"]))
				echo "<a href=menu_modificardb.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton cancelButton\">";
			else
				echo "<a href=\"javascript:self.close()\" class=\"defaultButton cancelButton\">";
		}
	}
	echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/fdt.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/fdt.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: fdt.php";
?>
</font>
	</div>
	<div class="middle form">
		<div class="formContent">
			<a href="javascript:void(0)" onclick="mygrid.addRow((new Date()).valueOf(),['','','','','','','','','','','','','','','','','','',''],mygrid.getRowIndex(mygrid.getSelectedId()))"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>

	<table  style="width:100%; height:200" id=tblToGrid class="dhtmlxGrid">
<?php
echo "<tr>";
foreach ($rows_title as $cell) echo "<td>$cell</td>\n";
echo "</tr>";


	$nfilas=0;
	$i=-1;
	if (isset($fp)){
		$t=array();
		foreach ($fp as $value){
			$value=trim($value);
			if (trim($value)!=""){				echo "\n<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
				$nfilas=$nfilas+1;
				$value.="||||||||||||" ;
				$t=explode("|",$value);

		//		echo "i=$i\n";
				$i=$i+1;
				$irow=$i+1;
				$linkr="<a href=javascript:EditarFila(\"".$irow."\",$i)><font size=1>$irow</a>";
				echo "<td>$linkr</td>";
				if ($t[0]=="F" or $t[0]=="S"){
					if (trim($t[7])=="") $t[7]="X";
				}
				$pick="";
				for ($ix=0;$ix<20;$ix++) if (!isset($t[$ix])) $t[$ix]="";
				if (trim($t[0])!="H" and trim($t[0])!="L"){
					if ($t[10]=="")
						$pick="<a href=javascript:Picklist(\"".$t[1].".tab\",$i)><font size=1>browse</a>";
					else
			    		$pick="<a href=javascript:Picklist(\"".$t[10]."\",$i)><font size=1>browse</a>";
				}
				$irow=$i+1;
				$linkr="<a href=javascript:EditarFila(\"".$irow."\",$i)><font size=1>$irow</a>";
				if (!isset($t[16])) $t[16]="";
				$ixt=-1;
				foreach ($t as $fila) {
    				$fila=trim($fila);
        			$ixt=$ixt+1;
        			if ($ixt>19) break;
           			echo "<td>";
                        switch($ixt){
                        	case 0:
                        		echo $fila;
                        		$FT[$i]=$fila;
                        		break;

                        	case 3:
                        		echo $fila;
                        		$IN[$i]=$fila;
                        		break;
                        	case 4:
                        		echo $fila;
                        		$RE[$i]=$fila;
                        		break;
                        	case 16:
                                echo $fila;
                        		$HP[$i]=$fila;
                        		break;
                        	case 7:
                        		echo $fila;
                        		$IT[$i]=$fila;
                        		break;
                        	case 10:
                        		echo $fila;
                        		$PL[$i]=$fila;
                        		break;
                        	case 13:
                        		if ($pick=="")$pick="&nbsp;";
                        		echo $pick;
                        		if ($fila=="") $fila="&nbsp;";
                        		echo"</td><td>$fila";
                        		break;
                        	default:
                        		 if ($fila=="") $fila="&nbsp;";
								echo $fila;
						}
					echo "</td>";
				}
				echo " </tr>";
			}
		}
	}
?>

	</table>
	<a href=javascript:Test()><?php echo $msgstr["test"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:List()><?php echo $msgstr["list"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:Validate()><?php echo $msgstr["validate"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;

<script>

    var mygrid = new dhtmlXGridFromTable('tblToGrid');

   // mygrid.setSkin("light");
   // mygrid.enableMultiline(true);

	mygrid.setImagePath("../imgs/");

//	mygrid.setInitWidths("20,150,30,150,100,100,80,80,100,30,30,45,100,40,40,100,100,100,40,40")
//mygrid.setInitWidths("*,*,*,*,*,*,*,*,*,*,*,*,*,*,*,*,*,*,*,*")
	mygrid.setColAlign("left,left,left,left,center,center,left,left,left,left,left,left,left,left,left,left,left,left,center,left")
	mygrid.setColTypes("link,coro,ed,ed,ch,ch,ed,ed,coro,ed,ed,coro,ed,ed,link,ed,ed,ed,ch,ed");
	mygrid.getCombo(11).put("","");
	mygrid.getCombo(1).put("","");
	mygrid.getCombo(8).put("","");
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
<?php if ($arrHttp["Opcion"]!="new") echo "progress.window.close()\n";?>
<?php foreach ($field_type as $key=>$value) echo "mygrid.getCombo(1).put(\"".$key."\",\"".$value."\")\n";
  foreach ($input_type as $key=>$value) echo "mygrid.getCombo(8).put(\"".$key."\",\"".$value."\")\n";
  foreach ($pick_type as $key=>$value) echo "mygrid.getCombo(11).put(\"".$key."\",\"".$value."\")\n";
  	if (!isset($arrHttp["encabezado"]))
    	echo  "mygrid.enableAutoHeigth(true,270)\n";
    else
        echo  "mygrid.enableAutoHeigth(true,300)\n";
?>
 	mygrid.setOnBeforeRowDeletedHandler(doBeforeRowDeleted);
 	mygrid.setOnEditCellHandler(doOnCellEdit);
 	mygrid.setColSorting("")
 	mygrid.enableAutoWidth(true);
    <?php
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
    	if (isset($HP[$ix])){    		echo "mygrid.cells2($ix,18).setValue('".$HP[$ix]."')\n";
    	}else{
    	    echo "mygrid.cells2($ix,18).setValue('0')\n";
        }
    }?>

    i=<?php echo $nfilas."\n"?>
    tope=10
	i++
	for (j=i;j<i+tope;j++){
		linkr="<a href=javascript:EditarFila("+j+",i)><font size=1>"+j+"</a>";
		mygrid.addRow((new Date()).valueOf(),[linkr,'','','','','','','','','','','','','','','','','','',''],j)
	}


	mygrid.clearSelection()
    mygrid.setSizes();
    mygrid.setColWidth(1,60)
    mygrid.setColWidth(8,80)
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
    mygrid.attachHeader("#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,<?php echo $msgstr["dataentry"]?>,#cspan,#cspan,<?php echo $msgstr["picklist"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,#rspan,#rspan");

	mygrid.enableColumnAutoSize(true)
	mygrid.setColWidth(0,25)
	mygrid.setColWidth(1,80)
	mygrid.setColWidth(2,40)
	mygrid.setColWidth(6,60)
	mygrid.setColWidth(7,60)
    mygrid.setColWidth(8,80)
    mygrid.setColWidth(9,25)
    mygrid.setColWidth(10,25)
    mygrid.setColWidth(11,50)
    mygrid.setColWidth(12,70)
    mygrid.setColWidth(13,40)
    mygrid.setColWidth(19,80)

</script>
<br><br>
</form>
<form name=forma1 action=fdt_update.php method=post>
<?php if (isset($arrHttp["fmt_name"])){	echo "<input type=hidden name=fmt_name value=".$arrHttp["fmt_name"].">\n";
}
	if (isset($arrHttp["fmt_desc"])) echo "<input type=hidden name=fmt_desc value=".$arrHttp["fmt_desc"].">\n";
?>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=archivo value=<?php echo $xarch?>>
<?php if (isset( $arrHttp["ventana"])) echo "<input type=hidden name=ventana value=". $arrHttp["ventana"].">"?>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
<?php if (isset($arrHttp["Fixed_field"]))  echo "<input type=hidden name=Fixed_field value=".$arrHttp["Fixed_field"].">"; ?>
</form>
<form name=rowedit action=fdt_rowedit.php method=post target=WinRow>
<input type=hidden name=ValorCapturado>
<input type=hidden name=row>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
</form>
<form name=MFedit action=fdt.php method=post target=WinRow>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=tag>
</form>
</div>
</div>
<?php include ("../common/footer.php");?>
</body>
</html>
<script>
<?php
$xar=explode(".",$xarch);
if (strtoupper($xar[0])==strtoupper($arrHttp["base"]))
	echo "FDT='S'";
else
	echo "FDT='N'";
?>
</script>
