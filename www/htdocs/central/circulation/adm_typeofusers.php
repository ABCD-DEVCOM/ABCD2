<?php
/* Modifications
2021-02-09 fho4abcd Original name for dhtmlX.js
2024-04-01 fho4abcd stylesheet from assets + setImagePath + redesign to remove the mix of html and dhtmlx script
*/
/* See https://docs.dhtmlx.com/api__dhtmlxgrid_addrow.html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

include("../common/header.php");
?>
<body>
<link rel="stylesheet" type="text/css" href="/assets/css/dhtmlXGrid.css">
<script src="../dataentry/js/dhtml_grid/dhtmlX.js"></script>
<script src="../dataentry/js/lr_trim.js"></script>
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
		mygrid.addRow((new Date()).valueOf(),['','',''],ixfila)
       	mygrid.selectRow(ixfila);
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
		document.forma1.ValorCapturado.value=Capturar_Grid()
		document.forma1.submit()
	}
</script>

<?php
$encabezado="";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["typeofusers"];?>
	</div>
	<div class="actions">
<?php
	$ayuda="/circulation/loans_typeofusers.html";
    $backtocancelscript="configure_menu.php?encabezado=s";
	$savescript="javascript:Enviar()";
    include "../common/inc_cancel.php";
    include "../common/inc_save.php";
?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
	<br>
		<a class="bt bt-blue mb-2" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')">
			<?php echo $msgstr["addrowbef"]?>
		</a>
		<a class="bt bt-blue mb-2" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')">
			<?php echo $msgstr["addrowaf"]?>
		</a>
		<a class="bt bt-red mb-2" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()">
			<?php echo $msgstr["remselrow"]?>
		</a><br>
	<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['double_click']?></span><br>
	<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_sort']?></span><br>
	<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_move']?></span><br>
<?php

	unset($fp);
	$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
	if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$fp=array();
		for ($i=0;$i<10;$i++){
			$fp[$i]='|||||';
		}
	}
?>
	<!-- A div that serves as container for the grid Object. Siz is not very important -->
	<div id="gridbox" xwidth="100px" height="100px" style="background-color:white;"></div>
	<script>
    var mygrid = new dhtmlXGridObject('gridbox');

	mygrid.setImagePath("/assets/images/dhtml_grid/imgs/");
	mygrid.setHeader(
		"<?php echo $msgstr["usertype"];?>,<?php echo $msgstr["description"]?>,<?php echo $msgstr["tit_np"]?>,<?php echo $msgstr["web_reserve"]?>");
	mygrid.setInitWidths("100,200,50,50")
	mygrid.setColAlign("left,left,justify,center")
	mygrid.setColTypes("ed,ed,ed,ed");
    mygrid.enableAutoWidth(true);
    mygrid.enableAutoHeight(true,800);
 	mygrid.setColSorting("str,str,int,int")
    mygrid.enableDragAndDrop(true);
	mygrid.init();
	index=-1;
	<?php
	$t=array();
	foreach ($fp as $value){
		$value=trim($value);
		$value.="||||";
		if (trim($value)!=""){
			$value=str_replace("'","\'",$value);
			$t=explode("|",$value);
			if (!isset($t[0])) $t[0]="";
			$t[0]=trim($t[0]);
			$t[1]=trim($t[1]);
			$t[2]=trim($t[2]);
			$t[3]=trim($t[3]);
			?>
			index++;
			/*first parameter must be unique, also for fast processors*/
			mygrid.addRow((new Date()).valueOf()+index,['<?php echo $t[0]?>','<?php echo $t[1]?>','<?php echo $t[2]?>','<?php echo $t[3]?>'],index)
			<?php
		}
	}
	?>
	mygrid.clearSelection()
	mygrid.setColWidth(2,80)
	mygrid.setColWidth(3,80)
	mygrid.setSizes();
</script>
<br><br>
</form>
<form name=forma1 action=typeofusers_update.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=>
<input type=hidden name=base value=users>
</form>



<?php

echo "</div></div></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>
