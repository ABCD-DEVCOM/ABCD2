<?php
/* Modifications
2021-02-08 fho4abcd. Remove code in comment & languaje->language
2021-02-09 fho4abcd Original name for dhtmlX.js
2024-04-01 fho4abcd css to /assets + new look (incl translations)+improve table functonality+add div-helper
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

include("../lang/dbadmin.php");;

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["modulo"])){
	switch ($arrHttp["modulo"]){
		case "catalogacion":
			$file="camposbusqueda.tab";
			break;
		case "prestamo":
			$file="busquedaprestamo.tab";
			break;
	}
}
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$file;
//if (!file_exists($archivo)) $archivo= $db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
if (file_exists($archivo)){
	$arrHttp["Opcion"]="update";
}else{
	$arrHttp["Opcion"]="new";
}
include("../common/header.php");
?>
<body>
	<link rel="stylesheet" type="text/css" href="/assets/css/dhtmlXGrid.css">
	<script  src="../dataentry/js/dhtml_grid/dhtmlX.js"></script>
 	<script  src="../dataentry/js/lr_trim.js"></script>
	<script>
		Opcion="<?php echo $arrHttp["Opcion"]?>"
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
	</script>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["advsearch"]." - ".$arrHttp["modulo"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php
	$backtoscript = "menu_modificardb.php?base=". $arrHttp["base"].$encabezado;
	include "../common/inc_back.php";
    include("../common/inc_home.php");
?>
</div>
<div class="spacer">&#160;</div>
</div>
<?php
$ayuda = "asearch_schema.html";
include "../common/inc_div-helper.php";
?>

<div class="middle form">
	<div class="formContent">


<form name=advancedsearch>
<table width=100% border=0>
	<tr>
   	<td width=50% valign=top border=0>
   		<table width=100%>
	        <tr>
			<td>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId()),'BEFORE')"><?php echo $msgstr["addrowbef"]?></a>
			<a class="bt bt-blue" href="javascript:void(0)" onclick="AgregarFila(mygrid.getRowIndex(mygrid.getSelectedId())+1,'AFTER')"><?php echo $msgstr["addrowaf"]?></a>
			<a class="bt bt-red" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['double_click']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_sort']?></span><br>
			<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr['picklist_move']?></span><br>
			</td>
			</tr><tr>
				<td valign=top>
					<div id="gridbox" width="100" height="100px" style="left:0;top:0;background-color:white;"></div>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp; &nbsp;
					<?php echo "<a class='bt bt-green' href=javascript:Enviar()>". $msgstr["update"]."</a>";?>
	 			</td>
			</tr>
		</table>
	</td>
	<td valign=top width=50%>
		<iframe id="cframe" src="fst_leer.php?base=<?php echo $arrHttp["base"]?>" width=100% height=450 scrolling=yes name=fdt></iframe>
	</td>
</table>
<script>
	mygrid = new dhtmlXGridObject('gridbox');

	mygrid.setHeader("<?php echo $msgstr["fn"]?>, Fst Id, <?php echo $msgstr["prefix"]?>");
	mygrid.setInitWidths("360,50,50")
	mygrid.setColAlign("left,left,left")
	mygrid.setColTypes("ed,ed,ed");
	mygrid.setColSorting("str,int,str")
    mygrid.enableAutoHeigth(true,400);
	mygrid.enableAutoWidth(true);
    mygrid.enableDragAndDrop(true);

	mygrid.init();
	if (Opcion=="new")  {
		for (i=0;i<10;i++){
			id=(new Date()).valueOf()+i
			mygrid.addRow(id,['','',''],i)
        }

	}else{

<?php
	if ($arrHttp["Opcion"]=="update"){
		$fp=file($archivo);
		$t=array();
		?>
		index=-1;
		<?php
		foreach ($fp as $value){
			if (trim($value)!=""){
				$value=str_replace("'","\'",$value);
				$t=explode('|',$value);
				?>
				index++;
				/*first parameter must be unique, also for fast processors*/
				mygrid.addRow((new Date()).valueOf()+index,['<?php echo $t[0]?>','<?php echo $t[1]?>','<?php echo $t[2]?>'],index)	
				<?php
			}
		}
   }
?> }
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
