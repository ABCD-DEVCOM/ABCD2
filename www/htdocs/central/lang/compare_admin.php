<?php
/* Modified
20210520 fho4abcd Replaced helper code fragment by included file
20210520 fho4abcd Rewritten: use language table for languages to compare+error detection+show ghost entries+mark empty entries
20210521 fho4abcd line-ends
*/
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) and !isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

$lang=$_SESSION["lang"];
$charset="UTF-8";
include("../common/header.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/lang.php");
$table=$_GET["table"];
$backtoscript="../dbadmin/menu_traducir.php?encabezado=s"; // The default return script
?>
<body>
<?php
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["compare_trans"].": ".$table ?>
    </div>
    <div class="actions">
        <a href='<?php echo $backtoscript;?>' class="defaultButton backButton">
            <img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
            <span><strong><?php echo $msgstr["regresar"]?></strong></span>
        </a>
    </div>
    <div class="spacer">&#160;</div>
</div>

<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
    <div class="formContent">
        <div align=center><h4><?php echo $msgstr["r_tabla"].": ".$table;?></h4></div>
<?php
// get the language table file
include "../common/inc_get-langtab.php";
$langtabfile=get_langtab();
$langtabcontent=file($langtabfile);
// Create anarry with language codes
foreach ($langtabcontent as $var=>$langline) {
    if ( trim($langline!="")) {
        $ll=explode('=',$langline,2);
        $langkey=trim($ll[0]);
        if ( $langkey!="" and $langkey!="00" and isset($ll[1]) and trim($ll[1]!="") ) {
            $langstr=$ll[1];
            $lang_cod[$langkey]=$langkey;
        }
    }
}
/*
** Read the fallback table.
** This gives the message key and the value given by the programmer
** The information is stored in a multidimensional array
** First  "column" : "code": the key of the message (part before the "=")
** Second "column" : "00"  : the string of the message (part after the "=")
*/
$a=dirname(__FILE__)."/00/$table";
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

// Determine the folder of the languages
if (isset($msg_path) and $msg_path!="")
	$languageroot=$msg_path;
else
	$languageroot=$db_path;

/*
** Read all language dependent files for this table
** The information is stored in the multidimensional array initiated above
** Only messages with a key defined in column "code" is entered
** Column n : "language code" :the string of the message (part after the "=")
*/
foreach ($lang_cod as $var=>$langkey) {
    // construct the name of the language dependent table
    $langfile=$languageroot."lang/".$langkey."/".$table;
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
                    // Production mode: convert to UTF-8 if necessary
                    if (!mb_check_encoding($tabmsg,'UTF-8')) {
                        $tabmsg=mb_convert_encoding($tabmsg,'UTF-8','ISO-8859-1');
                    }
                    if (isset($msgstrarr[$tabkey]["code"])) {
                        $msgstrarr[$tabkey][$langkey]=$tabmsg;
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
}
// Display the table. First a heading row
?>
<table border=1 cellspacing=0 cellpadding=4>
    <tr  bgcolor=#eeeeee>
        <th><?php echo $msgstr["validation_U"];?></th>
        <th>00</th>
        <?php
        foreach ( $lang_cod as $var=>$langkey) {
            $msg=$msgstr["$langkey"];
            echo "<th>$msg</th>";
        }
        ?>
    </tr>
    <?php
    // Display other table rows
    // Encoding is solved durin table creation
    foreach ($msgstrarr as $var=>$msgarr){
        echo "<tr >";
        echo "<td style='color:darkred'>".$msgarr["code"]."</td>";
        echo "<td style='color:blue'>".$msgarr["00"]."</td>";
        foreach ($lang_cod as $var=>$langkey) {
            if (isset($msgarr[$langkey]) and $msgarr[$langkey]!="") {
                echo "<td style='font-size:12px'>";
                echo $msgarr[$langkey];
                echo "</td>";
            } else {
                // Mark empty field
                echo "<td bgcolor=#FFD800/>";
            }
        }
        echo "</tr>";
    }
?>
</table>
<br>
<a href="#top"><?php echo $msgstr["up"] ?> <img src='/central/dataentry/img/up2.gif'></a>
</div></div>
<?php
include("../common/footer.php");
?>
</body></html>


