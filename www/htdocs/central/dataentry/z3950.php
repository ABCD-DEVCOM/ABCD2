<?php
/* Modifications
2021-07-11 fh04abcd Rewrite: Improve html, header, div-helper, undefined indexes, add error message
2022-01-06 fho4abcd backbuttun via included file
2022-01-08 fho4abcd add home button
20220713 fho4abcd Use $actparfolder as location for .par files
20220929 fho4abcd Error message if yaz not loaded or server db not present. Remove close button
20230418 fho4abcd Unicode improvements, improve second search field. Clean pop-up before search
*/
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950.php
 * @desc:      Search form for z3950 record importing
 * @author:    Guilda Ascencio
 * @since:     20091203
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
/*
** Old code might not send specific info.
** Set defaults for the return script and frame info
*/
$backtoscript="../dataentry/inicio_base.php"; // The default return script
$inframe=1;                      // The default runs in a frame
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];

include("../common/header.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
?>
<body>
<script language="JavaScript" type="text/javascript" src=js/lr_trim.js></script>
<script language=javascript>
function Isbn(){
 	ixdb="HOST"+document.z39.host.selectedIndex

	ix1=document.z39.isbn.length
	listaI=""
	for (i=0;i<ix1;i++){
		if (document.z39.isbn[i].value!=""){
			if (listaI==""){
				listaI=document.z39.isbn[i].value
			}else{
				listaI=listaI+"\n"+document.z39.isbn[i].value
			}
		}
	}
	if (Trim(document.z39.term.value)=="" && Trim(document.z39.term1.value)=="" && listaI==""){
 		alert("<?php echo $msgstr["z3950_srch_empty"]?>")
 		return
 	}
 	document.z39.isbn_l.value=listaI
 	<?php if (!isset($arrHttp["desde"])){?>
    msgwin=window.open("","z3950","width=750, height=600, scrollbars, resizable, menubar=no, toolbar=no, status=yes")
    msgwin.document.getElementsByTagName('body')[0].innerHTML = '<div>'+'<?php echo $msgstr["z3950_yaz_wait"];?>'+'</div>';
	document.z39.target="z3950"
	document.z39.submit()
	msgwin.focus()
 	<?php }else{
 		echo "document.z39.submit()\n";
 	}
 	?>
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php
        if (isset($arrHttp["test"])) echo $msgstr["test"].": ";
        echo $msgstr["catz3950"];
?>
	</div>
	<div class="actions">
    <?php
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
include ("../common/inc_get-dbinfo.php");// sets MAXMFN
?>

<div class="middle form">
<div class="formContent">
<div align=center>
<h4><?php
    if (isset($arrHttp["test"])) echo $msgstr["test"].": ";
    echo $msgstr["catz3950"]
    ?>
</h4>
<?php
$error=0;
$serversfolder=$db_path."servers";
if ( !file_exists($serversfolder)) {
    $error++;
    echo "<font color=red><b>".$msgstr["missing_serversdb"]." ".$msgstr["folderne"].": ".$serversfolder."</b></font><br>";
}
if (!extension_loaded('yaz') || !function_exists('yaz_connect')) {
    $error++;
    echo "<font color=red><b>".$msgstr["z3950_yaz_missing"]."</b></font><br>";
}

// query for the hosts here so any error will be displayed
$loc_actparfolder=$actparfolder;
if ($actparfolder!="par/") {
    // recompute $actparfolder for the database servers
    $loc_actparfolder="servers/";
}

// Variables $charset, $unicode, $cisis_ver are modified by the call to wxis_llamar.php
$targetdb_charset=$charset;
$Pft="v1'|'v2'|'v3'|'v4'|'v5/";
$query = "&base=servers&cipar=".$db_path.$loc_actparfolder."servers.par&from=1&Formato=$Pft&Opcion=rango";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
if ($err_wxis!=""){
    echo "<font color=red size=+1>";
    echo "Check existence and configuration of database 'servers'<br>";
    echo "&rarr; dr_path.def &nbsp;&nbsp;&rarr;  ".$loc_actparfolder."servers.par<br>";
    echo "</font>";
}
?>

<form method="post" action=z3950-01.php
    <?php if (!isset($arrHttp["desde"])) echo "  target=z3950 "?> onSubmit="javascript:return false" name=z39 >
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
    <table  border=0 cellpadding=0 cellspacing=0>
        <tr>
        <td class=td bgcolor=lightgrey>
            <?php echo $msgstr["connectto"]?>:
        </td>
        <td class=td>
            <select name="host">
            <?php
            foreach ($contenido as $value) {
                if ($value!="") {
                    $s=explode('|',$value);
                    if($s[0]!=""){
                    if ($targetdb_charset=="UTF-8") {
                        if (!mb_check_encoding($s[0],'UTF-8')) {
                            $s[0]=mb_convert_encoding($s[0],'UTF-8','ISO-8859-1');
                        }
                    }
                    echo "<option value=".$s[1].":".$s[2]."/".$s[3]."^susmarc^f".$s[4].">".$s[0]."\n";
                    }
                }
            }
            ?>
			</select>
        </td>
        </tr>
        <?php
        // File def/z3950,cnv contains the name and filename of specific conversion tables
        $archivo=$db_path.$arrHttp["base"]."/def/z3950.cnv";
        if (file_exists($archivo)){
            ?><tr><td bgcolor=lightgrey><?php
            echo $msgstr["z3950_cnv_table"].": ";
            ?></td><td>
            <select name=cnvtab>
                <option></option>"
                <?php
                $selected=" selected";
                $fp=file($archivo);
                foreach ($fp as $value){
                    $v=explode('|',$value);
                    echo "<option value='".$v[0]."' $selected>".$v[1]."\n";
                    $selected="";
                }
                ?>
            </select>
            </td></tr><?php
        }
        ?>
		<tr>
		<td class=td><?php echo $msgstr["z3950_search"]?>:
		</td>
		<td>
			<input type="text" size="50" name="term" value=""
                placeholder="<?php echo $msgstr["z3970_srch_inwords"]?>"
                title="<?php echo $msgstr["z3970_srch_inwild"]?>">&nbsp;
			<?php echo $msgstr["z3950_in"]?>&nbsp;
			<select name="field">
				<option value="Todos los campos"><?php echo $msgstr["z3950_all"]?>
				<option value="Titulo"><?php echo $msgstr["z3950_title"]?>
				<option value="Autor"><?php echo $msgstr["z3950_auth"]?>
				<option value="ISBN"><?php echo $msgstr["z3950_isbn"]?>
				<option value="ISSN"><?php echo $msgstr["z3950_issn"]?>
				<option value="Resumen"><?php echo $msgstr["z3950_abstract"]?>
			</select>
		</td>
		</tr>
		<tr>
		<td class=td style="text-align: right"><?php echo $msgstr["z3950_and"]?>
		</td>
		<td>
			<input type="text" size="50" name="term1" value=""
                placeholder="<?php echo $msgstr["z3970_srch_inwords"]?>"
                title="<?php echo $msgstr["z3970_srch_inwild"]?>">&nbsp;
			<?php echo $msgstr["z3950_in"]?>&nbsp;
			<select name="field1">
				<option value="Todos los campos"><?php echo $msgstr["z3950_all"]?>
				<option value="Titulo"><?php echo $msgstr["z3950_title"]?>
				<option value="Autor"><?php echo $msgstr["z3950_auth"]?>
				<option value="ISBN"><?php echo $msgstr["z3950_isbn"]?>
				<option value="ISSN"><?php echo $msgstr["z3950_issn"]?>
				<option value="Resumen"><?php echo $msgstr["z3950_abstract"]?>
			</select>
		</td>
		</tr>
	</table>
	<table width=600>
        <tr>
		<td colspan=5 bgcolor=linen class=td> &nbsp; <?php echo $msgstr["z3950_srch_isbn"]?></td>
        </tr>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>
		<td align=center><input type=text size=15 name=isbn value=""></td>

	</table>
<input type=hidden name=isbn_l value="">
<br>
<?php echo $msgstr["show"]?> &nbsp;<input type=text name=number value="10" size=4> <?php echo $msgstr["registros"]?>.&nbsp; &nbsp; &nbsp; 
    <?php echo $msgstr["z3950_retray"]?> <input type=text name=reintentar value="10" size=2> <?php echo $msgstr["z3950_times"]?>
<br><br>
<a class="bt bt-green" type="button" name="action" onclick=Isbn()><i class="fas fa-search"></i>  <?php echo $msgstr["busqueda"]?></a>
<input type=hidden name=start value="1">&nbsp; &nbsp;
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>

<?php
if (isset($arrHttp["Mfn"])) echo "<input type=hidden name=Mfn value=".$arrHttp["Mfn"].">\n"; //COPY TO AN EXISTENT RECORD
if (isset($arrHttp["test"])){
	echo "<input type=hidden name=test value=Y>\n";

}
?>
</form>
</div>

</div>
</div>
<?php include ("../common/footer.php")?>