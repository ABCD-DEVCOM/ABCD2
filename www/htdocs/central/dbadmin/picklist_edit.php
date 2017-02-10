<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value)echo "$var=$value<br>";

//echo $archivo;
include("../common/header.php");
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
if (!isset($arrHttp["picklist"])){
	echo "<h4>".$msgstr["missing"]."  ".$msgstr["picklistname"]."<p>".$msgstr["edfdt"]."</h4>";
	echo "<input type=button name=close value=".$msgstr["close"]." onclick=self.close()>";
	die;
}
if (strpos($arrHttp["picklist"],"%path_database%")===false){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"];
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["picklist"];
}else{
	$archivo=str_replace("%path_database%",$db_path,$arrHttp["picklist"]);
}?>
<script>

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
		mygrid.addRow((new Date()).valueOf(),['','',''],ixfila)

	}

	function Cancelar(){		document.cancelar.submit()	}

	function Enviar(){
		cols=mygrid.getColumnCount()
		rows=mygrid.getRowsNum()
		VC=""
		for (i=0;i<rows;i++){			lineat=""
			for (j=0;j<cols;j++){
				cell=mygrid.cells2(i,j).getValue()
				if (cell.indexOf('|')!=-1){
					fila=i+1
					columna=j+1
					alert("caracter inválido | en la fila "+fila+" columna "+columna)
					return
				}
				if (j==0)
					lineat=cell
	            else
					lineat=lineat+'|'+cell
			}
			if (lineat!="|" && lineat!="||"){
				if (VC=="")
					VC=lineat
				else
					VC+="\n"+lineat
			}
		}
		document.forma2.ValorCapturado.value=VC
		document.forma2.submit()
	}
</script>


	<link rel="STYLESHEET" type="text/css" href="../dataentry/js/dhtml_grid/dhtmlXGrid.css">

	<!--script  src="../dataentry/js/dhtml_grid/dhtmlxcommon.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlxgrid.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlxgridCell.js"></script-->
	<script  src="../dataentry/js/dhtml_grid/dhtmlx.js"></script>
 	<script  src="../dataentry/js/lr_trim.js"></script>
<?php
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["picklist"]. ": " . $arrHttp["base"]." - ".$arrHttp["picklist"]."
			</div>
			<div class=\"actions\">

	";
if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="fixed_marc"){
	echo "<a href=\"fixed_marc.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
}else{	if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="dataentry"){       echo "<a href=javascript:self.close() class=\"defaultButton cancelButton\">";	}else	 	echo "<a href=\"javascript:Cancelar()\" class=\"defaultButton cancelButton\">";}

echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>";
echo "<a href=\"javascript:Enviar()\" class=\"defaultButton saveButton\">";
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["save"]."</strong></span>
				</a>";
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>

<div class=\"helper\">
<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: picklist_edit.php" ;


?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
	<table width="100%">

        <tr>
        	<td>
        		<b><?php echo $msgstr["picklistname"].": " .$arrHttp["picklist"]?></b> &nbsp; &nbsp;
        </td>
        <tr>
		<td>
			<a href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')"><?php echo $msgstr["addrowaf"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>
			<br><strong><font color=darkred><?php echo $msgstr["dragdrop"];?></font>
            <br><strong><font color=darkred><?php echo $msgstr["multiselect"];?></font>
		<br>
		</td>
		<tr>
			<td>
				<div id="gridbox" xwidth="780px" height="200px" style="background-color:white;overflow:hidden"></div>
			</td>

		</tr>
		<tr>
			<td>
 			</td>
		</tr>
	</table>
<script>
	<?php echo "type=\"".$arrHttp["picklist"]."\"\n"?>
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("../dataentry/js/dhtml_grid/imgs/");
	switch (type){
     	case "ldr_06.tab":
			mygrid.setHeader("Code, Term, Fixed field structure");
			mygrid.setInitWidths("70,380,100")
			mygrid.setColAlign("left,left,left")
			mygrid.setColTypes("ed,ed,ed");
			mygrid.setColSorting("str,str,str")
			break
		case "%path_database%circulation/def/<?php echo $lang?>/typeofusers.tab":
			mygrid.setHeader("Code, Term,<?php echo $msgstr["tit_np"]?>");
			mygrid.setInitWidths("70,280,50")
			mygrid.setColAlign("left,left,right")
			mygrid.setColTypes("ed,ed,ed");
			mygrid.setColSorting("str,str,num")
			break
		default:
		    mygrid.setHeader("Code, Term");
			mygrid.setInitWidths("70,280")
			mygrid.setColAlign("left,left")
			mygrid.setColTypes("ed,ed");
			mygrid.setColSorting("str,str")
			break
    }
    mygrid.enableAutoHeigth(true,300);

	//mygrid.enableLightMouseNavigation(true);
	mygrid.enableMultiselect(true);
	mygrid.enableAutoWidth(true);
    mygrid.enableDragAndDrop(true);
	mygrid.init();
<?php
	if (file_exists($archivo)){
		$fp=file($archivo);
		$i=-1;
		$t=array();
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$value=str_replace("'","\'",$value);
				$t=explode('|',$value);
				if (!isset($t[1])) $t[1]="";
				if (!isset($t[2])) $t[2]="";
				$i=$i+1;
				echo "i=$i\n";
                if (!isset($t[2]) and $arrHttp["picklist"]=="ldr_06.tab") $t[2]="";
				echo "mygrid.addRow((new Date()).valueOf(),['".trim($t[0])."','".trim($t[1])."','".trim($t[2])."'],i)\n";
			}
		}
	}else{
 	}
?>



	mygrid.clearSelection()
	mygrid.setSizes();
    </script>
<br><br>
</form>
<form name=forma2 action=picklist_save.php method=post onsubmit="return false">
<input type=hidden name=ValorCapturado>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=picklist value=<?php echo $arrHttp["picklist"]?>>
<input type=hidden name=row value=<?php echo $arrHttp["row"]?>>
<?php if (isset($arrHttp["desde"])) echo "<input type=hidden name=desde value=".$arrHttp["desde"].">\n";
if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=".$arrHttp["encabezado"].">\n";
if (isset($arrHttp["Ctrl"])) echo "<input type=hidden name=Ctrl value=".$arrHttp["Ctrl"].">\n";
?>
</form>
<form name=cancelar method=post target=PL action=picklist.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=pl_type value=<?php if (isset($arrHttp["pl_type"])) echo $arrHttp["pl_type"]?>>
<input type=hidden name=picklist value="<?php echo $arrHttp["picklist"]?>">
<input type=hidden name=row value=<?php if (isset($arrHttp["row"])) echo $arrHttp["row"]?>>
<input type=hidden name=type value=<?php if (isset($arrHttp["type"])) echo $arrHttp["type"]?>>
<input type=hidden name=desde vallue=<?php if (isset($arrHttp["desde"])) echo $arrHttp["desde"]?>>
</form>
</div>
</div>
<?php include("../common/footer.php"); ?>
