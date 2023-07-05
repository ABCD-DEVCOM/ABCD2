<?php
/*
** Process Ignore fieldnumbers table. Create new table or update exieting table
** Checks and actuale file actions are done in z3950_conversion_update.php
**
20230705 fho4abcd created new
*/
session_start();
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$backtoscript="../dbadmin/z3950_conf.php";
$db=$arrHttp["base"];
include("../common/header.php");
if (!isset($arrHttp["Opcion"])) {
    $arrHttp["Opcion"]="new";
}

?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
function Enviar(){
	if (Trim(document.ign.Table.value)=="" || Trim(document.ign.descr.value)==""){
		alert("<?php echo $msgstr["z3950_ignmiss"]?>")
		return
	}
	document.ign.target=""
	document.ign.action="z3950_conversion_update.php"
	document.ign.submit()

}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["z3950"].": ".$msgstr["z3950_ign"]." (".$arrHttp["base"].")" ?>
	</div>

	<div class="actions">
    <?php
    $savescript="javascript:Enviar()";
	include "../common/inc_save.php";
	include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayuda="z3950_conf.html"; include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<form name=ign  method=post onsubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=filesTableFile value=<?php echo $arrHttp["filesTableFile"]?>>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>	
<input type=hidden name=Type value="ignore">	
<?php
$ignfields="";
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="edit" ){
	$archivo=$db_path.$arrHttp["base"]."/def/".$arrHttp["Table"];
	if (file_exists($archivo)){
		$fp=file($archivo);
		foreach ($fp as $value){
            $value=trim($value);
            if ($ignfields=="" && $value!="" ) {
                $ignfields=$value;
            } else if ($value!="") {
                $ignfields.="|".trim($value);
        	}
		}
	}
}
?>
<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1 >
    <tr><th colspan=2 style="text-align:center"><?php echo $msgstr["z3950_ign"]?></th></tr>
    <tr><td ><?php echo $msgstr["z3950_ignnumbers"]?>&nbsp;&nbsp;"|"<br><font color=blue>
             <?php echo $msgstr["example"]?>&nbsp;&nbsp;3018|001|042|440</font></td>
        <td><input type=text name=ignfields size=80 value="<?php echo $ignfields?>" ></td>
    </tr>
</table>
<table>
<tr><td><?php echo $msgstr["z3950_igntbname"]?>:</td>
    <td><input type=text name=Table size=30 value="<?php if (isset($arrHttp["Table"])) echo $arrHttp["Table"]?>" >
</tr>
<tr><td><?php echo $msgstr["description"]?>:</td>
    <td><input type=text name=descr size=30 value="<?php if (isset($arrHttp["descr"])) echo$arrHttp["descr"]?>" >
</tr>
</table>
<br><?php include "../common/inc_save.php"?> &nbsp;  &nbsp;
<a href='<?php echo $backtoscript."?base=".$arrHttp["base"]?>' class="bt bt-red" title='<?php echo $msgstr["cancel"]?>'>
    <i class="fas fa-backspace"></i>&nbsp;<?php echo $msgstr["cancel"]?></a>

</form>
</div>
</div>
<?php include("../common/footer.php")?>
