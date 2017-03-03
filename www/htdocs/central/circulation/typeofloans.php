<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
include("../lang/dbadmin.php");
include("../config.php");
$arrHttp=Array();
foreach ($HTTP_GET_VARS as $var => $value) {
 	if (trim($value)!="") $arrHttp[$var]=$value;
 }
if (count($arrHttp)==0){
 	foreach ($HTTP_POST_VARS as $var => $value) {
  		$arrHttp[$var]=$value;
 	}
}

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
$rows_title=array();
$rows_title[0]="Tipo de préstamo";
$rows_title[1]="Descripción";
$rows_title[2]="Tipo de usuario";
$rows_title[3]="Lapso del préstamo";
$rows_title[4]="Unidad: Horas/días";
$rows_title[5]="No. de renovaciones";
$rows_title[6]="Multa por día de atraso";
$rows_title[7]="Dias de suspensión por día de atraso";
$rows_title[8]="En Reserva<br>Multa por día de atraso";
$rows_title[9]="En reserva<br>Dias de suspensión por día de atraso";

if (file_exists($db_path."users/def/usuarios.tab")){
	$fp=file($db_path."users/def/usuarios.tab");
}else{
	$fp[$i]='|||||||||||';

}
foreach ($fp as $value){
	if (trim($value)!=""){
		$t=explode('|',$value);
		$type_users[$t[0]]=$t[1];
	}
}
include("../common/header.php");
?>
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid.css">
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid_skins.css">
<script  src="../js/dhtml_grid/dhtmlXCommon.js"></script>
<script  src="../js/dhtml_grid/dhtmlXGrid.js"></script>
<script  src="../js/dhtml_grid/dhtmlXGridCell.js"></script>
<script  src="../js/dhtml_grid/dhtmlXGrid_drag.js"></script>
<script  src="../js/dhtml_grid/dhtmlXGrid_excell_link.js"></script>
<script  src="../js/dhtml_grid/dhtmlXGrid_start.js"></script>
<script  src="../js/lr_trim.js"></script>
<script>
	function Enviar(){
		ret=Validate("Actualizar")
		if (ret){
			<?php /*if ($arrHttp["Opcion"]=="new")
				echo  "document.forma1.action=\"fdt_new.php\"\n";
			else
			    echo  "document.forma1.action=\"fdt_update.php\"\n";
			*/ ?>
			document.forma1.target="";
			Actualizar()
		}
	}
	function Validate(Accion){	}
	function Actualizar(){	}
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
	function doOnCellEdit(stage,rowId,cellInd){
/*	    if (stage==2){
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
		}*/
		return true
	}

</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["typeofloans"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"middle form\">
			<div class=\"formContent\">
        		<a href=../../documentacion/".$_SESSION["lang"]."/typeofloans.html target=_blank><img src=../dataentry/img/about.gif border=0 align=middle>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	 echo "<a href=../../documentacion/edit.php?archivo=../". $_SESSION["lang"]."/typeofloans.html target=_blank>".$msgstr["edhlp"]."</a> &nbsp; &nbsp; Script: typeofloans.php";
echo "<font color=white>&nbsp; &nbsp; Script: typeofloans.php</font>\n";
?>
		<br>
			<a href="javascript:void(0)" onclick="mygrid.addRow((new Date()).valueOf(),['','','','','','','','','','','','','','','','','','',''],mygrid.getRowIndex(mygrid.getSelectedId()))"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>

	<table  style="width:98%; height:400" id=tblToGrid class="dhtmlxGrid">
<?php
	echo "<tr>";
	foreach ($rows_title as $cell) echo "<td>$cell</td>\n";
  	echo "</tr>";

	unset($fp);
	if (file_exists($db_path."users/def/typeofloans.tab")){
		$fp=file($db_path."users/def/typeofloans.tab");
	}else{		$fp=array();
		for ($i=0;$i<20;$i++){
			$fp[$i]='|||||||||';
		}
		$tope=20;	}
	$nfilas=0;
	$i=-1;
	$t=array();
	foreach ($fp as $value){
	    $nfilas=$nfilas+1;
		echo "\n<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
		$value=trim($value);
		if (trim($value)!=""){
			$t=explode("|",$value);
			foreach ($t as $l){				if ($l=="") $l="&nbsp;";			 	echo "<td>$l</td>";
			}
		}
	    echo " </tr>";
	}

?>

	</table>
	<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<a href=configure_menu.php?encabezado=s><?php echo $msgstr["cancel"]?></a>
<script>

    nfilas=<?php echo $nfilas."\n"?>
    var mygrid = new dhtmlXGridFromTable('tblToGrid');

    mygrid.setSkin("modern");
	mygrid.setImagePath("../imgs/");
	mygrid.setInitWidths("30,30,30,30,30,30,30,30,30,30")
	mygrid.setColAlign("left,left,center,left,left,left,left,left,left,left")
	mygrid.setColTypes("ed,ed,coro,ed,ed,ed,ed,ed,ed,ed");
	mygrid.getCombo(2).put("","");
<?php foreach ($type_users as $key=>$value) echo "mygrid.getCombo(2).put(\"".$key."\",\"".$value."\")\n";
?>
    mygrid.enableAutoHeigth(true,350);
 	mygrid.setOnBeforeRowDeletedHandler(doBeforeRowDeleted);
 	mygrid.setOnEditCellHandler(doOnCellEdit);
 	mygrid.setColSorting("")

	nfilas++
	for (j=nfilas;j<nfilas+10;j++){
		mygrid.addRow((new Date()).valueOf(),['','','','','','','','','',''],j)
	}

	mygrid.clearSelection()
	mygrid.setSizes();
	mygrid.setColWidth(2,60)
	mygrid.setColWidth(3,60)
	mygrid.setColWidth(4,60)
	mygrid.setColWidth(5,60)
	mygrid.setColWidth(6,60)
</script>
<br><br>
</form>
<form name=forma1 action=fdt_update.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=>
<input type=hidden name=base value=users>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
</form>



<?php

echo "</div>";
include("../common/footer.php");
echo "</body></html>" ;

?>