<?php
/* Modifications
2021-02-08 fho4abcd Remove code in comment
2021-02-09 fho4abcd Original name for dhtmlX.js
2022-02-02 fho4abcd back button, div-helper
2024-04-01 fho4abcd css from /assets, remove wrong imagepath (was not used)
2024-04-22 fho4abcd return title info,Improve buttons
2025-08-24 fho4abcd Allow correct edit from dataentry: send "desde" also to save script.
2025-08-24 fho4abcd Show message if the file is missing
*/
/* See https://docs.dhtmlx.com/api__dhtmlxgrid_addrow.html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value)echo "$var=$value<br>";

include("../common/header.php");
?>
<body>
<?php
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
}
if (strpos($arrHttp["picklist"],'../')!==false){
	echo "<h1>invalid pick list name</h1>";die;
}
?>
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
	}
	function Cancelar(){
		document.cancelar.submit()
	}
	function Enviar(){
		cols=mygrid.getColumnCount()
		rows=mygrid.getRowsNum()
		VC=""
		for (i=0;i<rows;i++){
			lineat=""
			for (j=0;j<cols;j++){
				cell=mygrid.cells2(i,j).getValue()
				if (cell.indexOf('|')!=-1){
					fila=i+1
					columna=j+1
					alert("<?php echo $msgstr['invalpipe']?> "+fila+", <?php echo $msgstr['incolumn']?> "+columna)
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
<link rel="stylesheet" type="text/css" href="/assets/css/dhtmlXGrid.css">

<script  src="../dataentry/js/dhtml_grid/dhtmlX.js"></script>
<script  src="../dataentry/js/lr_trim.js"></script>

<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["picklist"]. ": " . $arrHttp["base"]." - ".$arrHttp["picklist"]?>
    </div>
    <div class="actions">
    <?php
    if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="fixed_marc"){
        // This thread is in a "normal" window
        $backtoscript="fixed_marc.php?base=".$arrHttp["base"].$encabezado;
        include "../common/inc_back.php";
        include "../common/inc_home.php";
    }else{
        // This thread is in a pop-up window
        // The close button is large but does only close.
        if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="dataentry"){
            include "../common/inc_close.php";
	} else {
            echo "<a class='bt bt-red' href=javascript:Cancelar()>". $msgstr["cancel"]."</a>";
	}
    }
    echo "<a class='bt bt-green' href=javascript:Enviar()>". $msgstr["save"]."</a>";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="picklist_tab.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
	<table width="100%">
        <tr>
		<td>
			<b><?php echo $msgstr["picklistname"].": " .$arrHttp["picklist"]?></b> &nbsp; &nbsp;
		</td>
        </tr><tr>
		<td>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')"><?php echo $msgstr["addrowbef"]?></a>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')"><?php echo $msgstr["addrowaf"]?></a>
			<a class="bt bt-red" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['double_click']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_sort']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_move']?></span><br>
		</td>
	</tr><tr>
		<td>
			<div id="gridbox" xwidth="780px" height="200px" style="background-color:white;overflow:hidden"></div>
		</td>
	</tr>
	</table>
<script>
	<?php echo "type=\"".$arrHttp["picklist"]."\"\n"?>
	mygrid = new dhtmlXGridObject('gridbox');
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
	mygrid.enableAutoWidth(true);
	mygrid.enableDragAndDrop(true);
	mygrid.init();
	index=-1;
<?php
	if (file_exists($archivo)){
		$fp=file($archivo);
		$t=array();
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$value=str_replace("'","\'",$value);
				$t=explode('|',$value);
				if (!isset($t[1])) $t[1]="";
				if (!isset($t[2])) $t[2]="";
				if (!isset($t[2]) and $arrHttp["picklist"]=="ldr_06.tab") $t[2]="";
				$t[0]=trim($t[0]);
				$t[1]=trim($t[1]);
				$t[2]=trim($t[2]);
				?>
				index++;
				/*first parameter must be unique, also for fast processors*/
				mygrid.addRow((new Date()).valueOf()+index,['<?php echo $t[0]?>','<?php echo $t[1]?>','<?php echo $t[2]?>'],index)
				<?php
			}
		}
	}else{
		/* no message here as it is hidden in the grid processing*/
 	}
?>
	mygrid.clearSelection()
	mygrid.setSizes();
    </script>
<br><br>

<form name=forma2 action=picklist_save.php method=post onsubmit="return false">
<input type=hidden name=ValorCapturado>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=picklist value="<?php echo $arrHttp["picklist"]?>">
<input type=hidden name=row value=<?php if (isset($arrHttp["row"])) echo $arrHttp["row"]?>>
<input type=hidden name=title value="<?php if (isset($arrHttp["title"])) echo $arrHttp["title"]?>">
<input type=hidden name=desde value="<?php if (isset($arrHttp["desde"])) echo $arrHttp["desde"]?>">
<input type=hidden name=tag value="<?php if (isset($arrHttp["tag"])) echo $arrHttp["tag"]?>">
<input type=hidden name=subfield value="<?php if (isset($arrHttp["subfield"])) echo $arrHttp["subfield"]?>">
<?php
if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=".$arrHttp["encabezado"].">\n";
?>
</form>
<form name=cancelar method=post target=PL action=picklist.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=picklist value="<?php echo $arrHttp["picklist"]?>">
<input type=hidden name=row value=<?php if (isset($arrHttp["row"])) echo $arrHttp["row"]?>>
<input type=hidden name=title value="<?php if (isset($arrHttp["title"])) echo $arrHttp["title"]?>">
<input type=hidden name=tag value="<?php if (isset($arrHttp["tag"])) echo $arrHttp["tag"]?>">
<input type=hidden name=subfield value="<?php if (isset($arrHttp["subfield"])) echo $arrHttp["subfield"]?>">
</form>
<?php
if (!file_exists($archivo)){
	echo "<span class=\"bt-disabled\"><i class=\"fas fa-info-circle\"></i></span>&nbsp;";
	echo $msgstr["emptytablenofile"]." ".$archivo."<br>";
}
?>
</div>
</div>
<?php include("../common/footer.php"); ?>
