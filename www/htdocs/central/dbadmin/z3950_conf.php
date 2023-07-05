<?php
/* Modifications
20210711 fho4abcd Rewrite: Improve html&layout, div-helper
20211216 fho4abcd Backbutton by included file
20220108 fho4abcd Improve layout&text
20220124 fho4abcd Ensure current database is present at exit
20220929 fho4abcd Improve layout, new style buttons, add error messages if yaz not loaded or servers db not present
20230430 fho4abcd Add inframe for several URL's
20230705 fho4abcd Add code to create/edit/delete an ignore file to specify fields to ignore
20230705 fho4abcd cnvfile (file with table of actual filenames) by parameter
*/

/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conf.php
 * @desc:      Configure Z39.50 client
 * @author:    Guilda Ascencio
 * @since:     20091203
*/
session_start();
include("../common/get_post.php");
include ("../config.php");

include("../lang/dbadmin.php");
include("../lang/admin.php");

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$sep='|';
$db=explode($sep,$arrHttp["base"]);
$db=$db[0];
$arrHttp["base"]=$db;
if(!isset($arrHttp["cipar"])) $arrHttp["cipar"]=$db.".par";
$ciparamp="&amp;cipar=".$arrHttp["cipar"];
$tabCnvFiles="/def/z3950.cnv";
$tabIgnFiles="/def/z3950_ignfld.cnv";

include("../common/header.php");
?>
<body>
<script>
function Edit(){
	if  (document.forma1.cnv.selectedIndex<1){
		alert('<?php echo $msgstr["selcnvtb"]?>')
		return
	}
	document.enviar.action="z3950_conversion.php";
	document.enviar.Table.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].value
	document.enviar.descr.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].text
    document.enviar.filesTableFile.value="<?php echo $tabCnvFiles?>"
	document.enviar.Opcion.value="edit"
	document.enviar.submit()
}
function Delete(){
	if  (document.forma1.cnv.selectedIndex<1){
		alert('<?php echo $msgstr["selcnvtb"]?>')
		return
	}
	document.enviar.action="z3950_conversion_delete.php";
	document.enviar.Table.value=document.forma1.cnv.options[document.forma1.cnv.selectedIndex].value
    document.enviar.filesTableFile.value="<?php echo $tabCnvFiles?>"
	document.enviar.Opcion.value="delete"
	document.enviar.submit()
}
function EditIgn(){
	if  (document.forma1.ign.selectedIndex<1){
		alert('<?php echo $msgstr["z3950_selingtb"]?>')
		return
	}
	document.enviar.action="z3950_ignore.php";
	document.enviar.Table.value=document.forma1.ign.options[document.forma1.ign.selectedIndex].value
	document.enviar.descr.value=document.forma1.ign.options[document.forma1.ign.selectedIndex].text
    document.enviar.filesTableFile.value="<?php echo $tabIgnFiles?>"
	document.enviar.Opcion.value="edit"
	document.enviar.submit()
}
function DeleteIgn(){
	if  (document.forma1.ign.selectedIndex<1){
		alert('<?php echo $msgstr["z3950_selingtb"]?>')
		return
	}
	document.enviar.action="z3950_conversion_delete.php";
	document.enviar.Table.value=document.forma1.ign.options[document.forma1.ign.selectedIndex].value
    document.enviar.filesTableFile.value="<?php echo $tabIgnFiles?>"
	document.enviar.Opcion.value="delete"
	document.enviar.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["z3950"]." (".$db.")" ?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>

<div class="middle form">
<div class="formContent">
<?php
$error=0;
$serversfolder=$db_path."servers";
if ( !file_exists($serversfolder)) {
    $error++;
    echo "<font color=red><b>".$msgstr["missing_serversdb"]." ".$msgstr["folderne"].": ".$serversfolder."</b></font><br>";
}
if (!extension_loaded('yaz') || !function_exists('yaz_connect')) {
    $error++;
    echo "<font color=red><b>".$msgstr["z3950_yaz_missing"]."</b></font><br>\n";
}

?>
<form name=forma1>
<table>
    <tr><td>
        <a class="bt bt-blue" href='../dataentry/browse.php?base=servers&return=../dbadmin/z3950_conf.php|base=<?php echo $db?>'><?php echo $msgstr["z3950_servers"]?></a><br><br>
    </td></tr>
    <tr><td>
        <h4><?php echo $msgstr["z3950_cnv"]?></h4>
        </td><td>
        <table>
            <tr>
            <td>
                <a class="bt bt-green"
                    href='z3950_conversion.php?base=<?php echo $db?>&filesTableFile=<?php echo $tabCnvFiles?>'>
                    <i class="far fa-plus-square"></i> &nbsp;<?php echo $msgstr["z3950_new_table"]?></a>
            </td>
            <tr><td>
            <?php
            if (file_exists($db_path.$db.$tabCnvFiles)){
                $fp=file($db_path.$db.$tabCnvFiles);
                ?>
                <select name=cnv>
                    <option value=''>
                    <?php
                    foreach ($fp as $var=>$value){
                        $o=explode('|',$value);
                        echo "<option value='".$o[0]."'>".$o[1]."\n";
                    }
                    ?>
                </select> &nbsp;
                <a class="bt bt-green" href=javascript:Edit()><i class="far fa-edit"></i> &nbsp;<?php echo $msgstr["edit"]?></a>
                <a class="bt bt-red" href=javascript:Delete()><i class="fas fa-trash"></i> &nbsp;<?php echo $msgstr["delete"]?></a>
                <?php
            }
            ?>
            </td></tr><tr>
            <td>
                <a class="bt bt-gray" href='z3950_diacritics_edit.php?base=<?php echo $db?>&inframe=0'><?php echo $msgstr["z3950_diacritics"]?></a>
            </td>
            </tr>
        </table>
        </td>
    </tr>
    <tr><td>
        <h4><?php echo $msgstr["z3950_fld_ignore"]?>
        </td><td>
        <table>
            <tr>
            <td>
                <a class="bt bt-green"
                href='z3950_ignore.php?base=<?php echo $db?>&filesTableFile=<?php echo $tabIgnFiles?>'>
                    <i class="far fa-plus-square"></i> &nbsp;<?php echo $msgstr["z3950_fld_new"]?></a>
            </td>
            <tr><td>
            <?php
            if (file_exists($db_path.$db.$tabIgnFiles)){
                $fp=file($db_path.$db.$tabIgnFiles);
                ?>
                <select name=ign>
                    <option value=''>
                    <?php
                    foreach ($fp as $var=>$value){
                        $o=explode('|',$value);
                        if (count($o)==2) echo "<option value='".$o[0]."'>".$o[1]."\n";
                    }
                    ?>
                </select> &nbsp;
                <a class="bt bt-green" href=javascript:EditIgn()><i class="far fa-edit"></i> &nbsp;<?php echo $msgstr["edit"]?></a>
                <a class="bt bt-red" href=javascript:DeleteIgn()><i class="fas fa-trash"></i> &nbsp;<?php echo $msgstr["delete"]?></a>
                <?php
            }
            ?>
            </td>
            </tr>
        </table>
        </td>
    </tr>
    <tr><td>
        <a class="bt bt-blue" href='../dataentry/z3950.php?base=<?php echo $db.$ciparamp?>&test=Y&Opcion=test&inframe=0&backtoscript=../dbadmin/z3950_conf.php' >
            <?php echo $msgstr["test"].": ". $msgstr["catz3950"];?></a>
    </td></tr>
</table>
</form>
</div>
</div>
<form name=enviar method=post>
<input type=hidden name=base value=<?php echo $db?>>
<input type=hidden name=Opcion>
<input type=hidden name=Table>
<input type=hidden name=filesTableFile >
<input type=hidden name=descr>
</form>
<?php include("../common/footer.php")?>
