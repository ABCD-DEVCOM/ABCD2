<?php
/* Modified
20210521 fho4abcd Replaced helper code fragment by included file
20210521 fho4abcd Rewritten: use correct encoding for translation
20121128 fho4abcd Translations with quotes are now shown correct
20220123 fho4abcd buttons
20250204 fho4abcd Improve UTF-8 display
*/
/*
** The encoding of the translated messages must match with the entered text
** This is not intuitive (keyboard and copy paste from unknown encodings)
** This script tries to set the best guessed encoding. But user may override this
** Note that it is possible to copy/past UTF-8 text into ISO:
**  the system changes this to &1234; (for amharic which is clearly not possible in ISO)
**  the system changes this to ISO (for traduções which is possible in ISO)
*/
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) and !isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
// config sets variables from abcd.def, the interesting parameters for this script:
// $unicode, $charset, $meta_encoding, $lang (from $_REQUEST["lang"])
include("../config.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$table=$arrHttp["table"];
$backtoscript="../dbadmin/menu_traducir.php"; // The default return script
$savescript="javascript:Enviar()"; // The save action

include("../common/inc_nodb_lang.php");

// read the language files after setting of the selected characterset
include("../common/header.php");// The header tells the browser the selected characterset
include("../lang/dbadmin.php");
include("../lang/admin.php");
$guessed=$msgstr["undefined"];
if ($guessstatus=="basesdef") $guessed=$msgstr["basesdef"];
if ($guessstatus=="lang")     $guessed=$msgstr["lang"]." ".$lang;
if ($guessstatus=="manual")   $guessed=$msgstr["manualset"];

?>
<body>
<script>
function Enviar(){
	document.forma1.submit()
}
function doReload(selectvalue){
    document.continuar.selcharset.value=selectvalue
	document.continuar.submit();
}

</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["traducir"].": ".$arrHttp["table"]?>
    </div>
    <div class="actions">
        <?php include "../common/inc_save.php"?>
        <?php include "../common/inc_back.php"?>
        <?php include "../common/inc_home.php"?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
$ichecked="";
$uchecked="";
if ( $selcharset=="UTF-8")
    $uchecked="selected";
else
    $ichecked="selected";

?>
<div class="middle form">
<?php
if ($table==""){
	echo $msgstr["errsellang"]."<p><a href=javascript:history.back()>".$msgstr["regresar"]."</a>";
	die;
}
?>
<div class="formContent">
    <a name="top"></a>
    <div align=center><h3><?php echo $msgstr["translate"]." ".$lang."/".$table ?></h3>
    <form name=continuar action=translate.php method=post>
        <table style=text-align:right cellspacing=1 cellpadding=4>
        <tr  style=text-align:center bgcolor=#e7e7e7>
            <th colspan=2 ><?php echo $msgstr["code"]?></th>
            <th><?php echo $msgstr["r_desde"]?></th>
        </tr>
        <tr><td><?php echo $msgstr["show"]." ".$table." in";?></td>
            <td><select name=selcharset  id="selcharset" onchange="doReload(this.value)">
                    <option value='ISO-8859-1' <?php echo $ichecked;?> >ISO-8859-1</option>
                    <option value='UTF-8' <?php echo $uchecked;?> >UTF-8</option>
                </select>
            </td>
            <td style="color:blue"> <?php echo $guessed;?> </td>
        </tr>
        </table>
        <input type=hidden name="table" value="<?php echo $table;?>">
        <input type=hidden name="lang" value="<?php echo $lang;?>">
    </form>
</div>
<br>
<div class="formContent">
<?php


/*
** Read the fallback table.
** This gives the message key and the value given by the programmer
** The information is stored in a multidimensional array
** First  "column" : "code": the key of the message (part before the "=")
** Second "column" : "00"  : the string of the message (part after the "=")
*/
$a=dirname(__FILE__)."/../lang/00/$table";
$file=file($a);
foreach ($file as $var=>$value){
    if (trim($value)!=""){
        $m=explode('=',$value,2);
        $key=trim($m[0]);
        if ( $key!="" and  isset($m[1]) and trim($m[1]!="")) {
            $value=$m[1];
            $msgstrarr[$key]["code"]=$key;
            $msgstrarr[$key]["00"]=$value;
        }
	}
}

if (isset($msg_path) and $msg_path!="")
	$languageroot=$msg_path;
else
	$languageroot=$db_path;

/*
** Read the language dependent file for this table
** The information is stored in the multidimensional array initiated above
** Only messages with a key defined in column "code" is entered
** Column 3 : "language code" :the string of the message (part after the "=")
** First construct the name of the language dependent table
*/
$langfile=$languageroot."lang/".$lang."/".$table;
if (file_exists($langfile)) {
    $tabcontent=file($langfile);
    // Convert the file into an array
    foreach ( $tabcontent as $var=>$tabline ) {
        if ( trim($tabline!="")) {
            $tl=explode('=',$tabline,2);
            $tabkey=trim($tl[0]);
            if ( $tabkey!="" ) {
                $tabmsg="";
                if ( isset($tl[1])) {
                    $tabmsg=$tl[1];
                }
                if (isset($msgstrarr[$tabkey]["code"])) {
                    // Convert the code to UTF-8 if necessary
		    if ($selcharset=="UTF-8") {
                        if (!mb_check_encoding($tabmsg,'UTF-8')) {
                            $tabmsg=mb_convert_encoding($tabmsg,'UTF-8','ISO-8859-1');
                        }
                    }
                    $msgstrarr[$tabkey][$lang]=$tabmsg;
                } else {
                    // error message if the key is not in the fallback table
                    echo "<div><font color=red>".$msgstr["ghostkey"]." &rarr;<b> ".$tabkey."</b> &larr; in ".$langfile."<br></font></div>";
                }
            }
        }
    }
} else {
    // error message if language file for this table does not exist
    echo "<div><font color=red>".$msgstr["notfound"].": ".$langfile."<br></font></div>";
}

?>
<form method=post action=translate_update.php name=forma1>
<input type=hidden name=lang value="<?php echo $lang;?>">
<input type=hidden name=table value="<?php echo $table;?>">
<table >
    <tr  bgcolor=#eeeeee>
        <th><?php echo $msgstr["validation_U"];?></th>
        <th>00</th>
        <th><?php echo $msgstr["transtext"];?></th>
    </tr>
    <?php
    // Display other table rows
    // Encoding is solved durin table creation
    foreach ($msgstrarr as $var=>$msgarr){
        echo "<tr >";
        echo "<td style='color:darkred'>".$msgarr["code"]."</td>";
        echo "<td style='color:blue'>".$msgarr["00"]."</td>";
        $value="";
        if ( isset($msgarr[$lang])) $value=$msgarr[$lang];
        $msgname="msg_".$msgarr["code"];
        ?>
        <td width=75%><input type=text style='width:100%' name=<?php echo $msgname;?> value="<?php echo str_replace("\"","&quot;",$value);?>"></td>
        </tr>
        <?php
     }
?> 

</table>
</form>
<br>
<a href="#top"><?php echo $msgstr["up"] ?> <img src='/central/dataentry/img/up2.gif'></a>

</div></div>
<?php echo include("../common/footer.php")?>

