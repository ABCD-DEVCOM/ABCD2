<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");
include("../common/header.php");
include("../common/institutional_info.php");
$ayuda="receipts.html";
$archivo="";
$pr_loan="r_loan.pft";
$pr_return="r_return.pft";
$pr_fine="r_fine.pft";
$pr_statment="r_statment.pft";
$pr_solvency="r_solvency.pft";
$chk_loan="";
$chk_return="";
$chk_fine="";
$chk_statment="";
$chk_solvency="";
if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst")){
	$archivo=$db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst";
}else{
	if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst"))
		$archivo=$db_path."trans/pfts/".$lang_db."/receipts.lst";
}
if ($archivo!=""){
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		switch($value){
			case "pr_loan":
				$chk_loan=" checked";
				break;
			case "pr_return":
				$chk_return=" checked";
				break;
			case "pr_fine":
				$chk_fine=" checked";
				break;
			case "pr_statment":
				$chk_statment=" checked";
				break;
			case "pr_solvency":
				$chk_solvency=" checked";
				break;
		}
	}
}
?>
<script  language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script>
function CheckName(fn,Ctrl){
	res= /^[a-z][\w]+$/i.test(fn)
	if (res==false){
		alert("<?php echo $msgstr["errfilename"]?>");
		Ctrl.focus()
		return false
	}
}
function Guardar(){

	document.receipts.submit()
}

function Editar(Pft){
	ix=Pft.indexOf(".pft")
	Pft=Pft.substr(0,ix)
	switch (Pft){
		case "r_fine":
			document.editar.base.value="suspml"
			document.editar.cipar.value="suspml.par"
			break
		default:
			document.editar.base.value="trans"
			document.editar.cipar.value="trans.par"
			break
	}
	msgwin=window.open("","editar","width=600,height=600,resizable,scrollbars")
	document.editar.archivo.value=Pft
	document.editar.submit()
	msgwin.focus()
}

</script>


<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["receipts"]?>
	</div>
	<div class="actions">
<?php
	$ayuda="/circulation/loans_typeofusers.html";
    $backtocancelscript="configure_menu.php?encabezado=s";
	$savescript="javascript:Guardar()";
	include "../common/inc_save.php";
    include "../common/inc_cancel.php";


?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"; ?>



<div class="middle form">
	<div class="formContent">

	<h3><?php echo $msgstr["receipts_select"];?></h3>

	<form name="receipts" action="receipts_ex.php" method="post">
	<table class="table striped">


	<tr>
		<td><?php echo $msgstr["loan"];?></td>
		<td>
			<input type="checkbox" name="pr_loan" value="<?php echo $pr_loan;?>" <?php echo $chk_loan;?> >
			<?php echo $pr_loan;?>
		<td>
			<a class="bt bt-blue" href="javascript:Editar('<?php echo $pr_loan;?>')">
				<i class="fas fa-edit"></i> <?php echo $msgstr["edit"];?>
			</a>
		</td>
	<tr>
		<td>
			<?php echo $msgstr["return"];?>
		</td>
		<td>
			<input type="checkbox" name="pr_return" value='<?php echo $pr_return;?>' <?php echo $chk_return;?>>
			<?php echo $pr_return;?>
		</td>
		<td>
			<a class="bt bt-blue" href=javascript:Editar('<?php echo $pr_return;?>')>
				<i class="fas fa-edit"></i> <?php echo $msgstr["edit"];?></a>
		</td>
	
	<tr>
		<td>
			<?php echo $msgstr["fine"];?>
		</td>
		<td>
			<input type="checkbox" name="pr_fine" value='<?php echo $pr_fine;?>' <?php echo $chk_fine;?>>
			<?php echo $pr_fine;?>
		</td>
		<td>
			<a class="bt bt-blue" href=javascript:Editar('<?php echo $pr_fine;?>')>
				<i class="fas fa-edit"></i> <?php echo $msgstr["edit"];?>
			</a>
		</td>
	<tr>
		<td>
			<?php echo $msgstr["statment"];?>
		</td>
		<td>
			<input type="checkbox" name="pr_statment" value='<?php echo $pr_statment;?>' <?php echo $chk_statment;?> > 
			<label><?php echo $pr_statment;?></label>
		</td>
		<td>
			<a class="bt bt-blue" href=javascript:Editar('<?php echo $pr_statment;?>')>
				<i class="fas fa-edit"></i> <?php echo $msgstr["edit"];?>
			</a>
		</td>
	<tr>
		<td>
			<?php echo $msgstr["solvency"];?>
		</td>
		<td>
			<input type="checkbox" name="pr_solvency" value='<?php echo $pr_solvency;?>' <?php echo $chk_solvency;?> >
			<label><?php echo $pr_solvency;?></label>
		</td>
		<td>
			<a class="bt bt-blue" href="javascript:Editar('<?php echo $pr_solvency;?>')">
				<i class="fas fa-edit"></i> <?php echo $msgstr["edit"];?>
			</a>
	</td>
	</table>
    </form>
	</div>
</div>


<?php include("../common/footer.php"); ?>


<form name=editar action=../dbadmin/leertxt.php target=editar method=post>
<input type=hidden name=base value=trans>
<input type=hidden name=cipar value=trans.par>
<input type=hidden name=archivo>
<input type=hidden name=desde value=recibos>
</form>

