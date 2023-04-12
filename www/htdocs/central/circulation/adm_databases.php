<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org
 * @file:      adm_databases.php
 * @desc:      Select the bibliographic database to be configured
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   2.2
 *
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
<script>
function Continuar(){
	ix=document.forma1.base.selectedIndex
	if (ix<1){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
    document.forma1.submit()
}
function Deshabilitar(){
	ix=document.forma1.base.selectedIndex
	if (ix<1){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	document.forma1.action="disable_db.php"
    document.forma1.submit()
}
</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
?>

<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["sourcedb"];?>
	</div>
	<div class="actions">
<?php
	$ayuda="/circulation/loans_databases.html";
    $backtoscript="configure_menu.php?encabezado=s";
    include "../common/inc_back.php";

?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>

		<div class="middle form">
			<div class="formContent">
<?php
$_loans_dat=$db_path."loans.dat";
if (file_exists($_loans_dat)){
	$loans_dat=" checked";
}else{
	$loans_dat="";
}
?>

<form name="forma1" action="databases_configure.php" >
<!--
<h3><?php echo $msgstr["loan_option"];?></h3>
<input type=radio name=loan_option value=copies><?php echo $msgstr["with_copies"];?>
<input type=radio name=loan_option value=nocopies $loans_dat><?php echo $msgstr["no_copies"];?>
<hr>
-->

<h3><?php echo $msgstr["seldbdoc"];?></h3>

<table class="w-10">
	<td valign=top>
	<label>
		<?php echo $msgstr["database"];?>
	</label>
<select name="base">
<option value=""></option>

<?php
$fp=file($db_path."bases.dat");
$bases_p=array();
$ya_elegida="";
foreach ($fp as $value){
	$value=trim($value);
	if ($value!=""){
		$b=explode('|',$value);
		if ($b[0]=="trans" or $b[0]=="suspml" or $b[0]=="copies" or $b[0]=="users" or $b[0]=="reserve" or $b[0]=="suggestions" or $b[0]=="purchaseorder" or $b[0]=="loanobjects"){
		}else{
			$archivo="";
			if (!isset($b[2])) $b[2]="N";
			echo "<option value=".$b[0]."|".$b[2],">".$b[1]."\n";
			if (file_exists($db_path.$b[0]."/loans/".$_SESSION["lang"]."/loans_display.pft")){
				if ($ya_elegida=="")
					$ya_elegida= $b[1]." (".$b[0].")<br>";
				else
					$ya_elegida.= $b[1]." (".$b[0].")<br>";
			}
		}
	}
}
?>
	</select>
</td>

<td valign="top">
	<h3><?php echo $msgstr["alreadysel"];?>:</h3> 
<?php echo $ya_elegida;?>
</td>
<tr>
	<td valign=top align=right>
		<a class="bt bt-green" href="javascript:Continuar()"><?php echo $msgstr["continue"];?></a>
		<a class="bt bt-default" href="javascript:Deshabilitar()"><?php echo $msgstr["disable"];?></a>
	</td>
</table>
</form>
</div>
</div>

<?php include("../common/footer.php");?>