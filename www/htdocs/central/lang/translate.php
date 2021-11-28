<?php
/* Modified
20210521 fho4abcd Replaced helper code fragment by included file
20210521 fho4abcd Rewritten: use correct encoding for translation
20121128 fho4abcd Translations with quotes are now shown correct
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
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
// unset a possible database:encoding may be different from langauage file
if (isset($_REQUEST["base"])) $_REQUEST["base"]="";

include("../common/get_post.php");
include("../config.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/

$lang=$_SESSION["lang"];
$table=$arrHttp["table"];
$backtoscript="../dbadmin/menu_traducir.php"; // The default return script
// The default characterset is of the selected database or system default
$selcharset=$charset;
$guessstatus="basesdef";
// Try to guess from the language code and the actual code as existed at the time this script was written
// The future is UTF-8, but we have currently some ISO langauges
$curstat["en"]="ISO-8859-1";
$curstat["es"]="ISO-8859-1";
$curstat["fr"]="ISO-8859-1";
$curstat["pt"]="ISO-8859-1";
$curstat["am"]="UTF-8";
if ( isset($curstat[$lang]) ) {
    $selcharset=$curstat[$lang];
    $guessstatus="lang";
}
// And a manual selected code overrules all guesses.
if (isset($arrHttp["selcharset"])){
    $guessstatus="manual";
    $selcharset=$arrHttp["selcharset"];
}
$charset=$selcharset;
// read the language files after setting of the selected characterset
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../common/header.php");// The header tells the browser the selected characterset
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
        <a href="javascript:Enviar()" class="defaultButton saveButton">
            <img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
            <span><strong><?php echo $msgstr["m_guardar"]?></strong></span>
        </a>
        <a href='<?php echo $backtoscript;?>' class="defaultButton backButton">
            <img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
            <span><strong><?php echo $msgstr["regresar"]?></strong></span>
        </a>
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
                    // This is not productione mode: no code conversion of character substitution
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
</body>
</html>
