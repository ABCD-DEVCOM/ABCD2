<?php
session_start();
if (!isset($_SESSION["permiso"])){
	//header("Location: ../common/error_page.php") ;
}
include ("../config.php");
$lang="es";

include("../lang/dbadmin.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
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
	if ($arrHttp["Opcion"]=="new"){
		if (isset($arrHttp["encabezado"])){
			echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">";
		}else{
			 echo "<a href=menu_creardb.php class=\"defaultButton cancelButton\">";
		}
	}else{
		if (isset($arrHttp["encabezado"]))
			$encabezado="&encabezado=s";
		else
			$encabezado="";
		if (isset($arrHttp["Fixed_field"])){
			echo "<a href=fixed_marc.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton cancelButton\">";
		}else{
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

	<a href=javascript:Test()><?php echo $msgstr["test"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:List()><?php echo $msgstr["list"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:Validate()><?php echo $msgstr["validate"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;

?>


<link rel="STYLESHEET" type="text/css" href="../dataentry/js/dhtml_grid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="../dataentry/js/dhtml_grid/codebase/skins/dhtmlxgrid_dhx_blue.css">
<script  src="../dataentry/js/dhtml_grid/codebase/dhtmlxcommon.js"></script>
<script  src="../dataentry/js/dhtml_grid/codebase/dhtmlxgrid.js"></script>
<script  src="../dataentry/js/dhtml_grid/codebase/dhtmlxgridcell.js"></script>
<script  src="../dataentry/js/dhtml_grid/codebase/excells/dhtmlxgrid_excell_link.js"></script>
<style>
.even{
    background-color:#E6E6FA;
}
.uneven{
    background-color:#F0F8FF;
}
</style>


<div id="gridbox" style="width:100%;height:270px;background-color:white;"></div>
<script>


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

function doOnEditCell(stage, id, index) {
    var ind = mygrid.getRowIndex(id);
    if ((index == 5) && (stage == 0))
    //start edit Shipping column;
    {
        var combo = mygrid.getCombo(5);
        if (ind % 2 == 1) {
            //for even rows;
            combo.save();
            //save initial state;
            combo.remove(1);
            combo.remove(2);
            combo.remove(3);
        } else {
            combo.save();
            //save initial state;
            combo.remove(4);
            combo.remove(5);
            combo.remove(6);
        }
    }
    if ((index == 5) && (stage == 2))
    //for finishing edit;
    mygrid.getCombo(5).restore();
    //restore combo state;
    return true;
}
<?php
$archivo="/bases_abcd/bases/biblo/def/es/biblo.fdt";
$fp=file($archivo);
$titulos="";
foreach ($rows_title as $cell){	$titulos.=$cell.",";
}?>
mygrid = new dhtmlXGridObject('gridbox');
mygrid.setImagePath("../dataentry/js/dhtml_grid/codebase/imgs/");
mygrid.attachHeader("#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,<?php echo $msgstr["dataentry"]?>,#cspan,#cspan,<?php echo $msgstr["picklist"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,#rspan,#rspan");
mygrid.setHeader("<?php echo $titulos ?>");
mygrid.setInitWidths("25,80,40,100,20,20,80,25,25,30,30,45,100,40,40,100,100,100,40,40")
mygrid.setColAlign("left,left,left,left,center,center,left,left,left,left,left,left,left,left,left,left,left,left,center,left")
mygrid.setColTypes("link,coro,ed,ed,ch,ch,ed,ed,coro,ed,ed,coro,ed,ed,ed,ed,ed,ed,ch,ed");
mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
mygrid.getCombo(1).put(2, 2);
mygrid.getCombo(1).put("guilda", "persona autorizada");
mygrid.setSkin("dhx_skyblue");

mygrid.init();


mygrid.clearSelection()
    mygrid.setSizes();
    mygrid.setColWidth(1,60)
    mygrid.setColWidth(8,80)
	mygrid.enableResizing("true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true");
   // mygrid.attachHeader("#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,#rspan,<?php echo $msgstr["dataentry"]?>,#cspan,#cspan,<?php echo $msgstr["picklist"]?>,#cspan,#cspan,#cspan,#cspan,#cspan,#rspan,#rspan,#rspan");

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
tope=10
	i=1
	for (j=i;j<i+tope;j++){
		linkr=j+"^a href=javascript:EditarFila("+j+",i)";
		var newId = (new Date()).valueOf();
		mygrid.addRow(newId,[linkr,'','','','','','','','','','','','','','','','','','',''])
	}
<?php foreach ($field_type as $key=>$value) echo "mygrid.getCombo(1).put(\"".$key."\",\"".$value."\")\n";
  foreach ($input_type as $key=>$value) echo "mygrid.getCombo(8).put(\"".$key."\",\"".$value."\")\n";
  foreach ($pick_type as $key=>$value) echo "mygrid.getCombo(11).put(\"".$key."\",\"".$value."\")\n";
  	if (!isset($arrHttp["encabezado"]))
    	echo  "mygrid.enableAutoHeigth(true,270)\n";
    else
        echo  "mygrid.enableAutoHeigth(true,300)\n";
?>

</script>



