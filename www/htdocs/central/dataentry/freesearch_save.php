<?php
/*
20240509 fho4abcd Created
20240523 fho4abcd Changed save parameters
20240528 fho4abcd Changed save parameter
20240610 fho4abcd Forbidden characters in description+ increase length of description
** Handles the manipulation of freesearch saved parameters.
** Requires "freesearch_save_inc.php" to handle related file manipulation.
** Major function:
** Option=	""			Create new parameterset. Requests Description
** Option=	"save"		Saves new parameter set based on Description
** Option=	"delete"	Requests to select an existing parameterset
** Option=	"deletesav"	Saves parametersets without selected parameterset
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
if (!isset($arrHttp["Option"])) $arrHttp["Option"]="";
?>
<body>
<script src="js/lr_trim.js"></script>
<script>
function EnviarForma(){
	document.forma1.description.value=Trim(document.forma1.description.value)
	if (document.forma1.description.value=="" && document.forma1.SavParams.value==""){
		alert("<?php echo $msgstr["freesearch_selp"]." - ".$msgstr["freesearch_paror"]." ".$msgstr["freesearch_pardes"];?>")
		return
	}
	const specialChars = /["\\|<>]/;
	if ( specialChars.test(document.forma1.description.value)){
		alert("<?php echo $msgstr["freesearch_illch"].':'?>" + " \" \\ | < >")
		return
	}
	document.forma1.submit()
}
function EnviarFormadel(){
	if (document.delparam.SavParams.value==""){
		alert("<?php echo $msgstr["freesearch_selp"];?>")
		return
	}
	document.delparam.submit()
}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php
		if ($arrHttp["Option"]=="delete") {
			echo $msgstr["freesearch_del"].": ".$arrHttp["base"];
		} else {
			echo $msgstr["freesearch_save"].": ".$arrHttp["base"];
		}
		?>
	</div>
	<div class="actions">
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
if ($arrHttp["Option"]==""){
	/* This option is the first step in saving a parameterset. The caller sends only parameters, no Option*/
	include("freesearch_save_inc.php");
	$Savparam_arr=array();
	Freesearch_table_file("Read",$Savparam_arr);
	?>
	<form name=forma1 method=post action=freesearch_save.php>
	<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
	<input type=hidden name=cipar value="<?php echo $arrHttp["cipar"]?>">
	<input type=hidden name=Option value=save>
	<?php
	if(isset($arrHttp["Expresion"])&& trim($arrHttp["Expresion"])!="") echo '<input type=hidden name=Expresion value="'.urlencode($arrHttp["Expresion"]).'">';
	if(isset($arrHttp["sorttag"])&& trim($arrHttp["sorttag"])!="") echo '<input type=hidden name=sorttag value="'.$arrHttp["sorttag"].'">';
	if(isset($arrHttp["sortdir"])&& trim($arrHttp["sortdir"])!="") echo '<input type=hidden name=sortdir value="'.$arrHttp["sortdir"].'">';
	if(isset($arrHttp["search"])&& trim($arrHttp["search"])!="") echo '<input type=hidden name=search value="'.urlencode($arrHttp["search"]).'">';
	if(isset($arrHttp["omitrec"])&& trim($arrHttp["omitrec"])!="") echo '<input type=hidden name=omitrec value="'.$arrHttp["omitrec"].'">';
	if(isset($arrHttp["omitfld"])&& trim($arrHttp["omitfld"])!="") echo '<input type=hidden name=omitfld value="'.$arrHttp["omitfld"].'">';
	if(isset($arrHttp["pftstr"])&& trim($arrHttp["pftstr"])!="") echo '<input type=hidden name=pftstr value="'.urlencode($arrHttp["pftstr"]).'">';
	if(isset($arrHttp["fields"])&& trim($arrHttp["fields"])!="") echo '<input type=hidden name=fields value="'.urlencode($arrHttp["fields"]).'">';
	if(isset($arrHttp["repeat_ind"])) echo '<input type=hidden name=repeat_ind value="'.$arrHttp["repeat_ind"].'">';
	if(isset($arrHttp["title_ind"])) echo '<input type=hidden name=title_ind value="'.$arrHttp["title_ind"].'">';
	?>
	<table>
	<tr><td><?php echo $msgstr["freesearch_use"]?></td>
		<td><select name=SavParams size=1">
				<option></option>
				<?php
				foreach($Savparam_arr as $value){
					$savarr=explode('|',$value);
					?><option value="<?php echo $savarr[0]?>"> <?php echo $savarr[0]?></option>
					<?php
				}
				?>
			</select>
		</td>
	<tr><td style="text-align:center"><?php echo $msgstr["freesearch_paror"]?></td></tr>
	<tr><td><?php echo $msgstr["freesearch_pardes"]?></td>
		<td><input type=text name=description maxlength=50 size=50></td>
	<tr><td></td><td align=center>
		<a href="javascript:EnviarForma()" class="bt bt-green">
		 <i class="far fa-save"></i> &nbsp; <?php echo $msgstr["freesearch_save"]?></a></td>
	</table>
	</form>
<?php
} elseif($arrHttp["Option"]=="save") {
	include("freesearch_save_inc.php");
	$Savparam_arr=array();
	Freesearch_table_file("Read",$Savparam_arr);
	$numerrors=0;
	$oldkey="";
	if (isset($arrHttp["SavParams"])) $oldkey=$arrHttp["SavParams"];
	if ($oldkey!="") {
		unset($Savparam_arr[$oldkey]);
		echo "<h2>".$msgstr["freesearch_repl"].":<br><span  style='color:blue'>".$oldkey."</span></h2>";
		$newkey=$oldkey;
	} else if (isset($arrHttp["description"])) {
		$newkey=trim($arrHttp["description"]);
		if ( array_key_exists($newkey,$Savparam_arr)==true){
			echo "<h2 style='color:red'>".$msgstr["freesearch_parexis"]."</h2>";
			$numerrors++;
		}
	} else {
		echo "programming error";
		$numerrors++;
	}
	if ($numerrors==0) {
		$savedurl="";
		foreach($arrHttp as $var=>$value){
			if ($var!="Option" && $var!="description"){
				if ($savedurl!="") $savedurl.="&";
				$savedurl.=$var."=".urlencode(urldecode($value));
			}
		}
		$Savparam_arr[$newkey]=$newkey."|".$savedurl;
		Freesearch_table_file("Write",$Savparam_arr);
		}
	?>
	<a href="javascript:self.close()" class="bt bt-gray">
		 <i class="far fa-window-close"></i> &nbsp; <?php echo $msgstr["cerrar"]?></a>
	<?php

} elseif($arrHttp["Option"]=="delete") {
	include("freesearch_save_inc.php");
	$Savparam_arr=array();
	Freesearch_table_file("Read",$Savparam_arr);
	?>
	<table>
	<tr><td><?php echo $msgstr["freesearch_selp"]?></td>
		<td>
		<form name=delparam method=post action=freesearch_save.php>
		<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
		<input type=hidden name=cipar value="<?php echo $arrHttp["cipar"]?>">
		<input type=hidden name=Option value=deletesave>
		<select name=SavParams size=1>
			<option></option>
			<?php
			foreach($Savparam_arr as $value){
				$savarr=explode('|',$value);
				?><option value="<?php echo $savarr[0]."|".$savarr[1];?>"> <?php echo $savarr[0]?></option>
				<?php
			}
			?>
		</select>
		</td>
	<tr><td></td>
		<td align=center>
		<a href="javascript:EnviarFormadel()" class="bt bt-red">
			<i class="fas fa-trash"></i> &nbsp; <?php echo $msgstr["freesearch_del"]?></a> &nbsp;
		<a href="javascript:self.close()" class="bt bt-gray">
			<i class="far fa-window-close"></i> &nbsp; <?php echo $msgstr["cerrar"]?></a>
		</td>
	</table>
	</form>
	<?php
} elseif($arrHttp["Option"]=="deletesave") {
	include("freesearch_save_inc.php");
	$Savparam_arr=array();
	Freesearch_table_file("Read",$Savparam_arr);
	$delparamarr=explode("|",$arrHttp["SavParams"]);
	unset($Savparam_arr[$delparamarr[0]]);
	Freesearch_table_file("Write",$Savparam_arr);
	?>
	<a href="javascript:self.close()" class="bt bt-gray">
		 <i class="far fa-window-close"></i> &nbsp; <?php echo $msgstr["cerrar"]?></a>
	<?php
}
?>
</body></html>