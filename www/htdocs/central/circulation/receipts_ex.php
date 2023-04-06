<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/prestamo.php");

include("../common/header.php");
include("../common/institutional_info.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";//die;
$pft_val["pr_loan"]="r_loan.pft";
$pft_val["pr_return"]="r_return.pft";
$pft_val["pr_fine"]="r_fine.pft";
$pft_val["pr_statment"]="r_statment.pft";
$pft_val["pr_solvency"]="r_solvency.pft";
$ayuda="receipts.html";
$fp=fopen($db_path."trans/pfts/".$_SESSION["lang"]."/receipts.lst","w");
$error=array();
$activated=array();
foreach ($arrHttp as $var=>$value){
	if (substr($var,0,2)=="pr"){
		$pft=$value;
		if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/$pft")){
			$res=fwrite($fp,"$var\n");
			$activated[$var]=$value;
		}else{
			$error[$var]=$value ;
		}
	}
}
fclose($fp);
?>


<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["receipts"]?>
	</div>
	<div class="actions">
<?php
    $backtoscript="receipts.php?base=trans";
    include "../common/inc_back.php";

?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"; ?>


<div class="middle form">
	<div class="formContent">

	<h3><?php echo $msgstr["receipts"];?></h3>
	<form name=receipts action=receipts_ex.php method=post onsubmit="return false">

	<table cellpadding=10>
		<tr>
			<td>
				<?php echo $msgstr["loan"];?>
			</td>
			<td>
				<?php if (isset($activated["pr_loan"])){ ?>
					<i class="fas fa-check-square color-green"></i>
				<?php } else { ?>
				<?php if (isset($error["pr_loan"])) 
					echo "<span class='color-red'>".$msgstr["falta"]." ".$pft_val["pr_loan"]."</span>";
					} ?>
			</td>
		<tr>
			<td>
				<?php echo $msgstr["return"];?>
			</td>
			<td>
				<?php if (isset($activated["pr_return"])){ ?>
					<i class="fas fa-check-square color-green"></i>
				<?php } else { ?>
				<?php if (isset($error["pr_return"])) 
					echo "<span class='color-red'>".$msgstr["falta"]." ".$pft_val["pr_return"]."</span>";
					} ?>
			</td>
		<tr>
			<td>
				<?php echo $msgstr["fine"];?>
			</td>
			<td>

			<?php if (isset($activated["pr_fine"])){ ?>
				<i class="fas fa-check-square color-green"></i>
				<?php } else { ?>
				<?php  if (isset($error["pr_fine"])) echo "<span class='color-red'>".$msgstr["falta"]." ".$pft_val["pr_fine"]."</span>";
			}
			?>
		</td>
	<tr>
		<td>
			<?php echo $msgstr["statment"];?>
		</td>
		<td>
		<?php if (isset($activated["pr_statment"])){ ?>
			<i class="fas fa-check-square color-green"></i>
		<?php } else { ?>
		<?php if (isset($error["pr_statment"])) echo "<span class='color-red'>".$msgstr["falta"]." ".$pft_val["pr_statment"]."</span>";
}
?>
		</td>
	<tr>
		<td>
			<?php echo $msgstr["solvency"];?>
		</td>
		<td>
		<?php if (isset($activated["pr_solvency"])){ ?>
			<i class="fas fa-check-square color-green"></i>
		<?php } else { ?>
	
		<?php if (isset($error["pr_solvency"])) echo "<span class='color-red'>".$msgstr["falta"]." ".$pft_val["pr_solvency"]."</span>";
}
?>		
		</td>
		</tr>
	</table>
    </form>
	</div>
</div>


<?php include("../common/footer.php"); ?>