<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. Improve html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
$backtoscript="../dbadmin/menu_modificardb.php";
?>
<script>
	function SendForm(wks){
		check=""
		for (i=0;i<document.validation.format.length;i++){
			if (document.validation.format[i].checked)  check=document.validation.format[i].value
		}
		if (check==""){
			alert("select one type of format")
			return
		}
		document.forma1.format.value=check
		document.forma1.wks.value=wks
		document.forma1.submit()

	}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["recval"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="recval.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
unset($fp);
$tr=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($tr))  $tr=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
if (file_exists($tr)) $fp=file($tr);
?>
<div style='text-align:center'>
<form name=validation>
<h3>
<input type=radio name=format value=recval> <?php echo $msgstr["recval"]?>&nbsp;
<input type=radio name=format value=beginf> <?php echo $msgstr["beginf"]?>&nbsp;
<input type=radio name=format value=endf> <?php echo $msgstr["endf"]?></h3>
<table align=center>
<tr><th><?php echo $msgstr["select"]." ".$msgstr["typeofr"]?></th></tr>
<?php
$ix=0;
$tr="";
$nr="";
if (isset($fp)){
	foreach($fp as $value){
		$value=trim($value);
		if ($value!=""){
			if ($ix==0){
				$ttm=explode(" ",$value);
				$tl=trim($ttm[0]);
				if (isset($ttm[1])) $nr=trim($ttm[1]);
				$ix=1;
			}else{
				$ttm=explode('|',$value);
				echo "<tr><td><a href='javascript:SendForm(\"".urlencode($value)."\")'>".$ttm[3]."</a></td>\n";
			}
		}
	}
}
echo "<tr><td><a href='javascript:SendForm(\"\")'>".$msgstr["1recval"]."</a></td>\n";
?>
</table>
</form>
<form name=forma1 action=recval.php method=post>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <?php if ($encabezado=="&encabezado=s")
        echo "<input type=hidden name=encabezado value=s>\n";
    ?>
    <input type=hidden name=wks>
    <input type=hidden name=format value="">
</form>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>
