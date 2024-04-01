<?php
/* Modifications
2021-02-08 fho4abcd Remove code in comment & languaje->language
2021-02-09 fho4abcd Original name for dhtmlX.js
2022-01-20 fho4abcd div-helper+ cancel button
2024-03-28 fho4abcd stylesheet from assets + new look
*/
/* See https://docs.dhtmlx.com/api__dhtmlxgrid_addrow.html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
	die;
}
include("../common/get_post.php");
include ("../config.php");
if (isset($_SESSION["UNICODE"])) {
	IF ($_SESSION["UNICODE"]==1)
		$meta_encoding="UTF-8";
	else
		$meta_encoding="ISO-8859-1";
}

$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

if (file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst")){
	$arrHttp["Opcion"]="update";
}else{
	$arrHttp["Opcion"]="new";
}
if ($arrHttp["Opcion"]!="new"){
	if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."CENTRAL_MODIFYDEF"])  and !isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_MODIFYDEF"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])){
		 header("Location: ../common/error_page.php") ;
		 die;
	}
}else{
	if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CENTRAL_CRDB"]) and !isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_CRDB"])){
		header("Location: ../common/error_page.php") ;
		die;
	}
}
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";
include("../common/header.php");
?>
	<link rel="stylesheet" type="text/css" href="/assets/css/dhtmlXGrid.css">

	<script src="../dataentry/js/dhtml_grid/dhtmlX.js"></script>
        <script src="../dataentry/js/lr_trim.js"></script>
        <script>
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
						if (j!=13) VC=VC+cell+' '
					}
				}
			}
			return VC
		}
		function Enviar(){
            <?php if ($arrHttp["Opcion"]=="new") echo "document.forma1.action.value='pft.php'\n"?>
			document.forma1.ValorCapturado.value=Capturar_Grid()
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
}
echo "<form name=fst method=post>";
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["fst"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">";
if ($arrHttp["Opcion"]=="new"){
    $backtoscript="../dbadmin/fdt.php?Opcion=new";
    $backtocancelscript="../dbadmin/menu_creardb.php.php";
    include "../common/inc_back.php";
    include "../common/inc_cancel.php";
}else{
    $backtoscript="../dbadmin/menu_modificardb.php";
    include "../common/inc_back.php";
    include("../common/inc_home.php");
}

?>
</div><div class="spacer">&#160;</div></div>
<?php include "../common/inc_div-helper.php"; ?>

<div class="middle form">
	<div class="formContent">

<div class="row">
<table width=100% border=0>
	<tr>
		<td width="50%">
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')">
			<?php echo $msgstr["addrowbef"]?>
			</a>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')">	
				<?php echo $msgstr["addrowaf"]?>
			</a>
			<a class="bt bt-red" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()">
				<?php echo $msgstr["remselrow"]?>
			</a><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['double_click']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_sort']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_move']?></span><br>
			
			<div id="gridbox" width="650px" height="250px" style="left:0;top:0;background-color:white;overflow:hidden"></div>
			<?php if ($arrHttp["Opcion"]!="new"){ ?>
				<label><?php echo $msgstr["testmfn"];?></label>
				<input type="text" size="5" name="Mfn">
					<a class="bt bt-blue" href="javascript:Test()">
						<?php echo $msgstr["test"];?>
					</a>
			<?php
			}
			?>
			<a class="bt bt-green" href="javascript:Enviar()"><?php echo $msgstr["update"]?></a>
		</td>
		<td width="50%">
			<iframe id="cframe" src="fdt_leer.php?Opcion=<?php echo $arrHttp["Opcion"]?>&base=<?php echo $arrHttp["base"]?>" width=100% height=450 scrolling=yes name=fdt></iframe>
		</td>
	</tr>
</table>




</div>

<script>
	mygrid = new dhtmlXGridObject('gridbox');

	mygrid.setImagePath("/assets/images/dhtml_grid/imgs/");

	mygrid.setHeader("<?php echo $msgstr["id"]?>,<?php echo $msgstr["intec"]?> ,<?php echo $msgstr["formate"]?>");
	mygrid.setInitWidths("40,100,500")
	mygrid.setColAlign("left,left,left")
	mygrid.setColTypes("ed,coro,ed");
	mygrid.getCombo(1).put("","");
	mygrid.getCombo(1).put("0","<?php echo $msgstr["fst_0"]?>");
	mygrid.getCombo(1).put("1","<?php echo $msgstr["fst_1"]?>");
	mygrid.getCombo(1).put("2","<?php echo $msgstr["fst_2"]?>");
	mygrid.getCombo(1).put("3","<?php echo $msgstr["fst_3"]?>");
	mygrid.getCombo(1).put("4","<?php echo $msgstr["fst_4"]?>");
	mygrid.getCombo(1).put("5","<?php echo $msgstr["fst_5"]?>");
	mygrid.getCombo(1).put("6","<?php echo $msgstr["fst_6"]?>");
	mygrid.getCombo(1).put("7","<?php echo $msgstr["fst_7"]?>");
	mygrid.getCombo(1).put("8","<?php echo $msgstr["fst_8"]?>");
	mygrid.setColSorting("int,int,str")
    mygrid.enableAutoHeigth(true,400);
	mygrid.enableAutoWidth(true);

    mygrid.enableDragAndDrop(true);
	mygrid.init();
<?php
	unset($fp);
	if ($arrHttp["Opcion"]=="update"){
		$fp=file($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst");
		$t=array();
	}else{
		if (isset($_SESSION["FST"])){
            $_SESSION["FST"].="\n";
			$fp=explode("\n",$_SESSION["FST"]);
		}
	}
	?>
	index=-1;
	<?php
	if (isset($fp)){
		foreach ($fp as $value){
			if (trim($value)!=""){
				$ix=strpos($value," ");
				$t[0]=trim(substr($value,0,$ix));
				$value=trim(substr($value,$ix));
				$ix=strpos($value," ");
				$t[1]=trim(substr($value,0,$ix));
				$t2=htmlspecialchars_decode (trim(substr($value,$ix+1)));
				$t[2]=str_replace("'","\'",trim(substr($value,$ix+1)));
				?>
				index++;
				/*first parameter must be unique, also for fast processors*/
				mygrid.addRow((new Date()).valueOf()+index,['<?php echo $t[0]?>','<?php echo $t[1]?>','<?php echo $t[2]?>'],index)	
				<?php
			}
		}
   }
?>
	mygrid.clearSelection()
	mygrid.setSizes();
</script>


</form>
	<form name="forma1" action="fst_update.php" method="post">
		<input type="hidden" name="ValorCapturado">
		<input type="hidden" name="desc">
		<input type="hidden" name="Opcion" value="<?php echo $arrHttp["Opcion"]?>">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
		<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
	</form>

	<form name="test" action="fst_test.php" method="post" target="FST_Test">
		<input type="hidden" name="ValorCapturado">
		<input type="hidden" name="desc">
		<input type="hidden" name="Mfn">
		<input type="hidden" name="Opcion" value="<?php echo $arrHttp["Opcion"]?>">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
	</form>

	</div>
</div>

<?php
include("../common/footer.php");
?>