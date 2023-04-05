<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure.php
 * @desc:      Input the configuration of the borrowers (users) database
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
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

function LeerPft($pft_name){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;
}



$arrHttp["base"]="users";

$uskey="";
$archivo=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_uskey.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/loans/".$lang_db."/loans_uskey.tab";
$fp=file_exists($archivo);
$ix=0;
$uskey="";
$usname="";
$uspft="";
if ($fp){
	$fp=file($archivo);
	foreach ($fp as $value){
		$ix++;
		$value=trim($value);
		switch ($ix){
			case 1:
				$uskey=$value;
		       	break;
		 	case 2:
		 		$usname=$value;
		 		break;
			case 3:
				$uspft=$value;
				break;
		}
	}
}

$pft_uskey=LeerPft("loans_uskey.pft");
$pft_ustype=LeerPft("loans_ustype.pft");
$pft_usvig=LeerPft("loans_usvig.pft");
$pft_usdisp=LeerPft("loans_usdisp.pft");
$pft_usmore=LeerPft("loans_usmore.pft");

include("../common/header.php");
?>
<script>
function Guardar(){
	ix=document.forma1.base.selectedIndex
	if (ix<1){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	document.forma1.action="borrowers_configure_update.php"
	document.forma1.target="_self";
    document.forma1.submit()
}

function Test(){
	if (document.forma1.Mfn.value==""){
		alert("<?php echo $msgstr["test_mfn_err"]?>")
		return
	}
    msgwin_t=window.open("","TestPft","")
    msgwin_t.focus()
	document.forma1.action="borrowers_configure_test.php"
	document.forma1.target="TestPft";
	document.forma1.submit()
}
</script>
</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["sourcedb"].". ".$msgstr["loan"].". ".$msgstr["configure"];?>
	</div>
	<div class="actions">
<?php
	$ayuda="/circulation/loans_borrowers_configure.html";
    $backtocancelscript="configure_menu.php?encabezado=s";
	$savescript="javascript:Guardar()";
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
				<h4><?php echo $msgstr["database"].": ".$arrHttp["base"];?>
					<a class="bt bt-default" href="../dbadmin/fst_leer.php?base=<?php echo $arrHttp["base"];?>" target="_blank">Open FST</a>
					<a class="bt bt-default" href="../dbadmin/fdt_leer.php?base=<?php echo $arrHttp["base"];?>" target="_blank">Open FDT</a>
				</h4>

				<form name="forma1" action="borrowers_configure.php" method="post">
					<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">

					<table>
						<tr>
							<td valign="top">
								<label>1. <?php echo $msgstr["uskey"];?> (loans_uskey.tab)</label>
							</td>
							<td valign=top>
								<input type="text" name="uskey" value="<?php echo $uskey;?>">
							</td>
						</tr>
						<tr>
							<td valign="top">
								<label>2. <?php echo $msgstr["usname"];?> (loans_uskey.tab)</label>
							</td>
							<td valign="top">
								<input type="text" name="usname" value="<?php echo $usname;?>">
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>3. <?php echo $msgstr["uspft"];?> (loans_uskey.tab)</label>
							</td>
							<td valign=top>
								<input type="text" name="uspft" value="<?php echo $uspft;?>">
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>4. <?php echo $msgstr["pft_uskey"];?> (loans_uskey.pft)</label>
							</td>
							<td valign=top>
								<textarea rows="2" cols="80" name="pft_uskey"><?php echo $pft_uskey;?></textarea>
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>5. <?php echo $msgstr["pft_ustype"];?> (loans_ustype.pft)</label>
							</td>
							<td valign=top>
								<textarea rows="2" cols="80" name="pft_ustype"><?php echo $pft_ustype;?></textarea>
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>6. <?php echo $msgstr["pft_usvig"];?> (loans_usvig.pft)</label>
							</td>
							<td valign=top>
								<textarea rows="2" cols="80" name="pft_usvig"><?php echo $pft_usvig;?></textarea>
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>7. <?php echo $msgstr["pft_usdisp"];?> (loans_usdisp.pft)</label>
							</td>
							<td valign=top>
								<textarea rows="6" cols="80" name="pft_usdisp"><?php echo $pft_usdisp;?></textarea>
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label>8. <?php echo $msgstr["pft_usmore"];?> (loans_usmore.pft)</label>
							</td>
							<td valign=top>
								<textarea rows="6" cols="80" name="pft_usmore"><?php echo $pft_usmore;?></textarea>
							</td>
						</tr>
					</table>


					<a class="bt bt-default" href="javascript:Test()"><?php echo $msgstr["test"];?></a>
					<label>Mfn:</label> 
					<input type="text" name="Mfn" size="10">
		</form>
	</div>

</div>

<?php include("../common/footer.php"); ?>