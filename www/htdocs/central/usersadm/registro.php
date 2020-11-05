<?php
session_start();

include ("../config.php");

include("../lang/dbadmin.php");

include("../lang/admin.php");
$Permiso=$_SESSION["permiso"];
if (strpos($Permiso,'adm')===false and strpos($Permiso,'dbadm')===false){
	echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
	die;
}

include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
		<div class="sectionInfo">
			<div class="breadcrumb">
				<h3>New User</h3>
			</div>
			<div class="actions">
				<a href="fdtDB_admSys.htm" class="defaultButton saveButton">
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["m_guardar"]?></strong></span>
				</a>
				<a href="listaUsers_AdmSys.htm" class="defaultButton cancelButton">
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["cancelar"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="middle form">
			<div class="formContent">
				<div id="formRow01" class="formRow">
					<label for="field01"><strong><?php echo $msgstr["username"]?></strong></label>
					<div class="frDataFields">
						<input type="text" name="tag10" id="tag10" value="" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow01').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow01').className = 'formRow';" />
					</div>
				</div>
				<div id="formRow02" class="formRow">
					<label for="field02"><strong><?php echo $msgstr["userid"]?></strong></label>
					<div class="frDataFields">
						<input type="text" name="tag20" id="tag20" value="" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow02').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow02').className = 'formRow';" />
					</div>
				</div>
				<div id="formRow03" class="formRow">
					<label for="field03"><strong><?php echo $msgstr["password"]?></strong></label>
					<div class="frDataFields">
						<input type="text" name="tag30" id="tag30" value="" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow03').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow03').className = 'formRow';" />
					</div>
				</div>
				<div id="formRow04" class="formRow">
				<label for="field04"><strong><?php echo $msgstr["rights"]?></strong></label>
					<div class="frDataFields">
						<input type="text" name="tag40" id="tag40" value="" class="textEntry singleTextEntry" onfocus="this.className = 'textEntry singleTextEntry textEntryFocus';document.getElementById('formRow04').className = 'formRow formRowFocus';" onblur="this.className = 'textEntry singleTextEntry';document.getElementById('formRow04').className = 'formRow';" />
					</div>
				</div>
				<div id="formRow3" class="formRow formRowFocus">
					<label for="field3"><strong><?php echo $msgstr["database"]?></strong></label>
					<div class="frDataFields">
<?php
echo "<table>";
echo "<th align=center>".$msgstr["username"]."</th><th>".$msgstr["rights"]."</th>";
$fpdb=file($db_path."bases.dat");
$fpper_db=file($db_path."acces/def/permisosdb.tab");
for ($i=0;$i<8;$i++){	echo "<tr><td>";
	echo "<select name=\"tag100_a\" id=\"tag100_a\" class=\"textEntry\">\n
	<option></option>";	foreach ($fpdb as $value) {		$d=explode('|',$value);
		echo "<option value=".$d[0].">".$d[1]."</option>";
	}
	echo "</select></td>
	";
	echo "<td><select name=\"tag100_b\" id=\"tag100_b\" class=\"textEntry\">\n
	<option></option>";
	foreach ($fpper_db as $value) {
		$d=explode('|',$value);
		echo "<option value=".$d[0].">".$d[1]."</option>";
	}
	echo "</select></td>";}
?>

</table>
					</div>
					<div class="spacer">&#160;</div>
				</div>

			</div>
		</div>
<?php
include("../common/footer.php")?>
	</body>
</html>