<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");;

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["modulo"])){	switch ($arrHttp["modulo"]){		case "catalogacion":
			$file="camposbusqueda.tab";
			break;
		case "prestamo":
			$file="busquedaprestamo.tab";
			break;
	}}
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$file;
if (!file_exists($archivo)) $archivo= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
if (file_exists($archivo)){
	$arrHttp["Opcion"]="update";
}else{
	$arrHttp["Opcion"]="new";
}
include("../common/header.php");


?>
	<link rel="STYLESHEET" type="text/css" href="../dataentry/js/dhtml_grid/dhtmlXGrid.css">

	<!--script  src="../dataentry/js/dhtml_grid/dhtmlxcommon.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlxgrid.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlxgridCell.js"></script-->
	<script  src="../dataentry/js/dhtml_grid/dhtmlx.js"></script>
 	<script  src="../dataentry/js/lr_trim.js"></script>
	<script languaje=javascript>
		pl_type=""
		Opcion="<?php echo $arrHttp["Opcion"]?>"
		valor=""
		prefix=""
		fila=""
		columna=11

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

		function Asignar(){
			mygrid.cells2(fila,columna).setValue(valor)
			mygrid.cells2(fila,12).setValue(prefix)
			closeit()
		}
		function Capturar_Grid(){
			cols=mygrid.getColumnCount()
			rows=mygrid.getRowsNum()
			VC=""
			for (i=0;i<rows;i++){
				if (Trim(mygrid.cells2(i,0).getValue())!=""){
					if (VC!="") VC=VC+"\n"
					for (j=0;j<cols;j++){
						cell=mygrid.cells2(i,j).getValue()
						if (j!=13) VC=VC+cell+'|'
					}
				}
			}
			return VC

		}


		function Enviar(){

			document.forma1.txt.value=Capturar_Grid()
			document.forma1.submit()
		}

		function Test(){
			if (Trim(document.fst.Mfn.value)==""){
				alert("<?php echo $msgstr["mismfn"]?>")
				return
			}
			msgwin=window.open("","FST_Test")
			msgwin.document.close()
			msgwin.focus()
			document.test.Mfn.value=document.fst.Mfn.value
			document.test.ValorCapturado.value=Capturar_Grid()
			document.test.submit()

		}
	</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["advsearch"]." - ".$arrHttp["modulo"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["cancel"]?></strong></span>
</a>
</div>
<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/asearch_schema.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/asearch_schema.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: advancedsearch.php";
?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">


<form name=advancedsearch>
<table width=100% border=0>
   	<td width=40% valign=top border=0>
   		<table width=100%>
	        <tr>
			<td>
				<a href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')"><?php echo $msgstr["addrowaf"]?></a>
				&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()">Remove Selected Row</a>
			<!--	&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick=Organize()>Organize FST</a><br> -->
			</td>
			<td></td>
			<tr>
				<td valign=top>
					<div id="gridbox" width="300" height="400px" style="left:0;top:0;background-color:white;overflow:hidden"></div>
				</td>

			</tr>
			<tr>
				<td>
					&nbsp; &nbsp; <a href=javascript:Enviar()>Update</a>  &nbsp; &nbsp;
					<?php if (!isset($arrHttp["encabezado"]))
						echo "<a href=menu_modificardb.php?base=".$arrHttp["base"].$msgstr["cancel"]."</a>\n";
						?>
	 			</td>
			</tr>
		</table>
	</td>
	<td valign=top width=60%>
<iframe id="cframe" src="fst_leer.php?base=<?php echo $arrHttp["base"]?>" width=100% height=450 scrolling=yes name=fdt></iframe>
	</td>
</table>
<script>
	mygrid = new dhtmlXGridObject('gridbox');

	mygrid.setImagePath("../dataentry/js/dhtml_grid/imgs/");

	mygrid.setHeader("<?php echo $msgstr["fn"]?>, Fst Id, <?php echo $msgstr["prefix"]?>");
	mygrid.setInitWidths("360,50,50")
	mygrid.setColAlign("left,left,left")
	mygrid.setColTypes("ed,ed,ed");
    mygrid.enableAutoHeigth(true,400);

    mygrid.enableDragAndDrop(true);
	//mygrid.enableLightMouseNavigation(true);
	mygrid.enableMultiselect(true);

	mygrid.init();
	if (Opcion=="new")  {		for (i=0;i<30;i++){
			id=(new Date()).valueOf()
			mygrid.addRow(id,['','',''],i)
        }

	}else{
<?php
	if ($arrHttp["Opcion"]=="update"){
		$fp=file($archivo);
		$i=-1;
		$t=array();
		foreach ($fp as $value){
			if (trim($value)!=""){
				$t=explode('|',$value);
				$i=$i+1;
				echo "i=$i\n
				id=(new Date()).valueOf()
				mygrid.addRow(id,['".trim($t[0])."','".trim($t[1])."','".trim($t[2])."'],i)\n
				mygrid.setRowTextStyle( id,\"font-family:courier new;font-size:12px;\")\n ";
			}		}
   }
?> }
/*
	i++
	for (j=i;j<i+10;j++){
		mygrid.addRow((new Date()).valueOf(),['','',''],j)
	}
*/

	mygrid.clearSelection()
	mygrid.setSizes();
</script>
<br><br>
</form>
<form name=forma1 action=advancedsearch_update.php method=post>
<input type=hidden name=txt>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=archivo value='<?php echo $file?>'>
<?php if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=S>\n ";

?>
</form>

</div></div>
<?php include("../common/footer.php")?>
</body>
</html>
