<?php
/* Modifications
2021-07-18 fho4abcd Rewrite: Improve html, header, div-helper, undefined indexes, add error messages
2023-04-18 fho4abcd Moved script to improve debugging.Improve link to stylesheet. Add translation+Standard Doctype
2023-04-18 fho4abcd Removed hostarray
2023-04-30 fho4abcd Improve for UTF-8, add processing for field1 and trailing $ (wildcard)+ other functional improvements
2023-07-04 fho4abcd Replace marc-8 substition code (not dependent on sequence in the file)
2023-07-04 fho4abcd Improve marc-8 substitution code, attempt to use authentication
2023-07-05 fho4abcd Add ignore fields table
*/

/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950-01.php
 * @desc:      Get records from the z3950 server
 * @author:    Guilda Ascencio
 * @since:     20091203
*/
session_start();
/* =========== functions =========== */
function print_structured_record($ar) {
    reset($ar);
    while(list($key,list($tagpath,$data))=each($ar)) {
        echo $tagpath . $data . "<br>\n";
    }
}
/* --------------------------------- */
function print_marc_record($ar, $inhtml=0) {
global $marc8,$ansi,$charset,$htmlchar,$htmlentity, $usemarc8;
    $retchar="\n";
    if ($inhtml==1) $retchar="<br>";
    reset($ar);
    $nl = "";
    $arcount=count($ar);
    $marc8_count=count($marc8);
    for ( $i=0;$i<$arcount;$i++ ){
        $tagpath=$ar[$i][0];
        if (substr($tagpath,0,7)=="(3,825)") continue;
        if (substr($tagpath,0,7)=="(3,852)") continue;
        if (substr($tagpath,0,7)=="(3,926)") continue;
        if (substr($tagpath,0,7)=="(3,956)") continue;
        $dataorg="";
        if (isset($ar[$i][1])) $dataorg=$ar[$i][1];
     	// Convert marc-8 to ANSI (~latin-1 or whatever the table defines)
        $datalength=strlen($dataorg);
        $data="";
        $pos=0;
        while ($pos < $datalength) {
            $byte=substr($dataorg,$pos,1);// Note that values<127 are only there for 3 position codes
            $hit=0; // set to -1 to get all codes without translation
            if ($usemarc8=='none') $hit=-1;
            // check first the 3 position codes
            if ($hit==0 && $pos<$datalength-2){
                $marc8_str=substr($dataorg,$pos,3);
                for ($marc8_index=0; $marc8_index<$marc8_count && $hit==0; $marc8_index++) {
                    if ($marc8_str == $marc8[$marc8_index]) {
                        $hit=1;
                        $pos=$pos+strlen($marc8_str);
                        $data.=$ansi[$marc8_index];
                    }
                }
            }
            // check next the 2 position codes
            if ($hit==0 && $pos<$datalength-1) {
                $marc8_str=substr($dataorg,$pos,2);
                for ($marc8_index=0; $marc8_index<$marc8_count && $hit==0; $marc8_index++) {
                    if ($marc8_str == $marc8[$marc8_index]) {
                        $hit=1;
                        $pos=$pos+strlen($marc8_str);
                        $data.=$ansi[$marc8_index];
                    }
                }
            }
            // Check the single position codes
            if ($hit==0) {
                for ($marc8_index=0; $marc8_index<$marc8_count && $hit==0; $marc8_index++) {
                    if ($byte == $marc8[$marc8_index]) {
                        $hit=1;
                        $pos++;
                        $data.=$ansi[$marc8_index];
                    }
                }
            }
            if ($hit<=0) {
                $pos++;
                $data.=$byte;
            }
        }
        // Convert some critical html entities
     	$data=str_replace($htmlchar,$htmlentity,$data);
        // Convert to UTF-8 if required
        if ($charset=="UTF-8") $data=mb_convert_encoding($data,"UTF-8","ISO-8859-1");
        // Show the result
        if (preg_match("/^\(3,([^)]*)\)\(3,@\)$/",$tagpath,$res)) {
            echo $res[1] . ' ' . $data . $retchar;
        } elseif (preg_match("/^\(3,([^)]*)\)\(3,([^)]*)\)$/",$tagpath,$res)) {
            echo $nl;
            $nl = "";
            echo $res[1] . ' ' . $res[2]; //ereg_replace(" ", "_", $res[2]);
        } elseif (preg_match("/^\(3,([^)]*)\)\(3,([^)]*)\)\(3,([^)]*)\)$/",$tagpath,$res)) {
            echo '^' . $res[3] . $data . "";
            $nl=$retchar;
        }
    }
    echo $nl;
}
/* --------------------------------- */
function conv_term_to_query ( $term, $field ) {
    global $fieldmap;
    // Converts a query string into a Bib-1 query string
    // A $ as last character indicates that the rest of the string is arbitrary
    // An empty term returns ""
    if ( empty($term)) return "";
    $trunc="";
    if (substr($term,-1)=="$") $trunc="@attr 5=1"; // Bib-1 Truncation Attribute=right Truncation
    $term = stripslashes($term);
    $term = str_replace('"', "", $term);
    $term = str_replace('\\', "", $term);
    $term = str_replace('?', "",  $term);
    $term = str_replace('$', "",  $term);
    if ( empty($term)) return "";
    if (!empty($trunc)) {
        $retval = $fieldmap[$field].' '.$trunc.' "'.$term.'"';
    } else {
        $retval = $fieldmap[$field].' "'.$term.'"';
    }
    return $retval;
}
/* =========== end functions =========== */

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//error_reporting(E_ALL & ~E_NOTICE);

include("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
if (isset($arrHttp["cnvtab"]) ) {
	$_SESSION["cnvtab"] = $arrHttp["cnvtab"];
}else{
	unset($_SESSION["cnvtab"]);
}
if (isset($arrHttp["igntab"]) ) {
	$_SESSION["igntab"] = $arrHttp["igntab"];
}else{
	unset($_SESSION["igntab"]);
}


set_time_limit (120);// Yaz has its own limits. This is a crude fallback.
if(!isset($arrHttp['Opcion']) ) $arrHttp['Opcion']="";
$field="";
if (isset($arrHttp['field']))$field = $arrHttp['field'];
$field1="";
if (isset($arrHttp['field1']))$field1 = $arrHttp['field1'];

// get the host specification and unwrap it (hostspec^syntax^felement)
$host_string=$arrHttp['host'];
$i=strpos($host_string,"^");
$host_spec=substr($host_string,0,$i);
$host_string=substr($host_string,$i+2);
$i=strpos($host_string,"^");
$syntax=substr($host_string,0,$i);
$host_string=substr($host_string,$i+2);
$element=substr($host_string,0,strlen($host_string));
//echo "host=".$host_spec."<br>syntax=".$syntax."<br>elemnt=".$element."<br>";$element="";
$usemarc8='none';
if (isset($arrHttp['usemarc8']) && $arrHttp['usemarc8']=='on') $usemarc8='on';
$intentos= $arrHttp['reintentar'];
$isbn="";
$expr_isbn="";
if (isset($arrHttp['isbn_l'])) {
    $isbn=explode("\n",$arrHttp['isbn_l']);
    $i=0;
    foreach ($isbn as $linea) {
        if (trim($linea)!="") $expr_isbn="@or ".$expr_isbn." @attr 1=7 ".$linea." ";
    }
    $expr_isbn=trim($expr_isbn);
}
if ($expr_isbn!="") $expr_isbn=substr($expr_isbn,4);
//	echo "Expresion= ".$expr_isbn."-";
$number = $arrHttp['number'];
$start = $arrHttp['start'];
$term="";
if(isset($arrHttp['term'])) $term = $arrHttp['term'];
$term1="";
if(isset($arrHttp['term1'])) $term1 = $arrHttp['term1'];
// Characterset hassle
$charset_conversion="raw"; // Any other conversion results in errors

// Map the form selection values to z3950 search attributes
// See http://www.loc.gov/z3950/agency/defns/bib1.html
$fieldmap["Todos los campos"] = "@attr 1=1016"; // Bib-1 Use Attributes: Any
$fieldmap["Titulo"]           = "@attr 1=4";    // Bib-1 Use Attributes: Title
$fieldmap["Autor"]            = "@attr 1=1003"; // Bib-1 Use Attributes: Author
$fieldmap["ISBN"]             = "@attr 1=7";    // Bib-1 Use Attributes: ISBN
$fieldmap["ISSN"]             = "@attr 1=8";    // Bib-1 Use Attributes: ISSN
$fieldmap["Resumen"]          = "@attr 1=62";   // Bib-1 Use Attributes: Abstract
reset ($fieldmap);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>" >
    <title>Z39.50</title>
    <link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css" media="screen"/>
    <link href="/assets/css/all.min.css" rel="stylesheet"> 
</head>
<body>

<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<?php
// Get the conversion table from marc-8 to ansi
// Used by print_marc_record
$file=$db_path."cnv/marc-8_to_ansi.tab";
$marc8=array();
$ansi=array();
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $value){
		$ar=explode(" ",$value);
        if (count($ar)==2) {
            $marc8[]=trim($ar[0]);
            $ansi[]=trim($ar[1]);
        } else if (count($ar)==1) {
            $marc8[]=trim($ar[0]);
            $ansi[]="";
        }
	}
}
unset($fp);
if ( count($marc8)==0 ) {
    echo "<p style='color:red'>".$msgstr["archivo"]." ".$file." ".$msgstr["z3950_diafile_err"]."</p>";
}
// Create arrays for html entity conversion.
// Reason: function htmlentities fails in case of unknown characters
// Used by print_marc_record
$htmlchar=array();
$htmlentity=array();
$htmlchar[]="&"; $htmlentity[]="&amp;";
$htmlchar[]="<"; $htmlentity[]="&lt;";
$htmlchar[]=">"; $htmlentity[]="&gt;";

$max_hits = 0;
if ( empty($term) && empty($term1) && $expr_isbn=="") {
    ?>
    <p><font color=red><?php echo $msgstr["z3950_srch_empty1"];?></font></p>
    </body>
    </html>
    <?php
    die;    
}

$queryterm = conv_term_to_query ( $term,  $field );
$queryterm1= conv_term_to_query ( $term1, $field1 );
if ($queryterm!="" and $queryterm1!= "" ) {
    $fullquery="@and ".$queryterm." ".$queryterm1;
} else {
    $fullquery=$queryterm.$queryterm1;
}
if ($fullquery!="" && $expr_isbn!=""){
    $fullquery="@and ".$expr_isbn ." " .$fullquery;
}else{
    if ($expr_isbn!="") $fullquery=$expr_isbn;
}
if (empty($start)) $start = 1;
if (empty($number)) $number = 10;
// $options=array("proxy"=>"localhost");
// $options may contain "charset" => ISO-8859-1, UTF-8, UTF-16.
// Most Z39.50 servers do not support this feature (is ignored).
// Many servers use the ISO-8859-1 encoding for queries and messages. MARC21/USMARC records are not affected by this setting. 
$options=array();
//$options[]="user=z39";
//$options[]="password=z39";

?>
<table border=0>
<tr>
    <td><?php echo $msgstr["z3950_server"];?></td><td>&rarr; </td><td><?php echo $host_spec;?></td>
</tr><tr>
    <td><?php echo $msgstr["z3950_yaz_syntax"];?></td><td>&rarr; </td><td><?php echo $syntax;?></td>
</tr><tr>
    <td><?php echo $msgstr["z3950_yaz_search"];?></td><td>&rarr; </td><td><?php echo $fullquery;?></td>
</tr><tr>
    <td><?php echo $msgstr["z3950_yaz_cnvchr"];?></td><td>&rarr; </td>
    <td><?php echo str_replace(","," &rArr; ",$charset_conversion);?>
        <?php if ($usemarc8=="on") echo " &rArr; ".$msgstr["z3950_diacrituse"];?></td>
</tr>
</table>

<form method="get" name=z3950>
<table  cellspacing="0" cellpadding="3" border="0" bgcolor=--abcd-teal width=100%>
<?php
$id=null;
for ($reintentar=0;$reintentar<$intentos;$reintentar++){
    if ($id!=null) yaz_close($id);
    $id = yaz_connect($host_spec,$options);
    if ($id == null || $id==0) {
        echo "<font color=red><b>".$msgstr["z3950_con_fail"]." ".$host_spec."</b></font><br>";;
        continue;
    }
    if (empty($fullquery)) {
        echo "<font color=red><b>".$msgstr["z3950_srch_empty1"].'</b></font><br>';
        $reintentar=$intentos;
        break;
    }
    if (!yaz_search($id,"rpn",$fullquery)) {
        echo "<font color=red><b>".$msgstr["expr_err"].'</b></font><br>';
        $reintentar=$intentos;
        break;
    }
    // yaz_element specifies the elementset. Most servers support F (for full records) and B (for brief records).
    // Tests revealed that most servers fail or do not react on it
    //if ($number > 1) {$element="B";
    //    yaz_element($id,$element);
    //} else {
    //    yaz_element($id,"F");
    //}
    yaz_syntax($id,$syntax);  // no return code
    yaz_range($id,$start,$number); // no return code
    $res=yaz_wait();
    $error = yaz_error($id);
    $errno = yaz_errno($id);
    $addinfo = yaz_addinfo($id);
    echo '<tr>';
    $attempt=$reintentar+1;
    if ($errno) {
        echo '<td align="center">';
        echo '<table cellspacing="0" cellpadding="2"  border="0" width=100% ><tr><td>';
        echo $msgstr["attempt"].": $attempt &nbsp; ";
        echo "Error: $error (code $errno) $addinfo";
        echo "</td></tr></table>\n";
        echo "</td></tr>";
        if ($errno==10007 ||$errno==10004)$reintentar=$intentos;
    } else {
        echo '<td align="center">';
        $hits = yaz_hits($id);
        if ($hits > $max_hits) {
            $max_hits = $hits;
        }

        echo $msgstr["attempt"].": $attempt<br>";
        echo $msgstr["registros"]." <b>$hits</b> ";
        $reintentar=999;
        echo "</td></tr>";
        $end = $start + $number;
        $ixreg=0;
        for ($pos = $start; $pos < $end && $pos<=$max_hits; $pos++) {
            $rec = yaz_record($id,$pos,"string; charset=".$charset_conversion);
            $ar = yaz_record($id,$pos,"array; charset=".$charset_conversion);
            $recStatus=substr($rec,5,1);
            $typeOfrec=substr($rec,6,1);
            $bibloLevel=substr($rec,7,1);
            $encodingLevel=substr($rec,17,1);
            $descriptive=substr($rec,19,1);
            //$syntax = yaz_record($id,$pos,"syntax");
            if (empty($rec) && !is_array($ar)) {
                continue;
            }
            ?>
            <tr><td align="center">
            <table cellspacing="0" cellpadding="2" width="97%"  border="0" bgcolor="#ffffff">
            <tr><td align="left" valign="top" >
            <?php
            echo "$pos/$max_hits<br><br><br>";
            if (is_array($ar)){
                if ($syntax == "GRS-1") {
                    print_structured_record($ar);
                } else {
                    if ($ixreg==0) {
                        // add dummy to enforce an array of text area's
                        echo '<textarea name=marc hidden>empty</textarea>';
                    }
                    $ixreg=$ixreg+1;
                    // Show a button to copy the data
                    ?>
                    <a href="javascript:Transmitir('<?php echo $ixreg;?>','<?php echo $charset;?>')"
                    >
                    <img src=img/capturar.gif border=0 alt="<?php echo $msgstr["z3950_copytodb"]?>"
                        title="<?php echo$msgstr["z3950_copytodb"]?>"
                        id="cpbutton_<?php echo $ixreg;?>"></a>
                    </td><td>
                    <?php 
                    // The textarea is required for copy of the data
                    // The number of characters is near to unlimited
                    // The textarea width does not react well on widening the window: it is a hidden attribute
                    echo '<textarea cols=100% rows=20 name=marc hidden>';
                    echo "3005 $recStatus\n";
                    echo "3006 $typeOfrec\n";
                    echo "3007 $bibloLevel\n";
                    echo "3017 $encodingLevel\n";
                    echo "3019 $descriptive\n";
                    print_marc_record($ar);
                    echo '</textarea>';
                    // This is the html of the textarea : more readable and reacts better on widening.
                    echo "3005 $recStatus<br>";
                    echo "3006 $typeOfrec<br>";
                    echo "3007 $bibloLevel<br>";
                    echo "3017 $encodingLevel<br>";
                    echo "3019 $descriptive<br>";
                    print_marc_record($ar,"1");
                }
            } else {
                if ($syntax == "XML") {
                    $rec = htmlspecialchars($rec);
                }
                $br_rec = ereg_replace("\n", "<br>\n", $rec);
                echo "3006 $typeOfrec\n".$br_rec;
            }
            ?>
            </td></tr>
            </table>
            <?php
        } // end for loop
    }
    yaz_close($id);
    $id=null;
}
?>
</tr>
<tr><td align="center" bgcolor=white>&nbsp;
<?php
if ($max_hits > 0) {
    $host_url = "Opcion=".$arrHttp["Opcion"] ;
    $host_url.= "&term=".urlencode($term)."&field=".urlencode($field);
    $host_url.= "&term1=".urlencode($term1)."&field1=".urlencode($field1);
    $host_url.= "&".urlencode("host")."=".urlencode($host_spec);
    $prev_start = $start - $number;
    $i = 1;
    $tope=0;
    while ($i <= $max_hits  && $number > 1) {
        echo '&nbsp;';
        if ($start != $i) {
            $url = "z3950-01.php";
            $url.= "?start=".$i."&number=".$number."&reintentar=".$intentos;
            $url.= "&".$host_url."^s".$syntax."^f".$element;
            $url.= "&usemarc8=".$usemarc8;
            if (isset($_SESSION["cnvtab"])) $url.= "&cnvtab=".$_SESSION["cnvtab"];
            $url.= "&base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par";
            ?>
            <a href='<?php echo $url;?>'>
            <?php
        }
        $j = $i + $number - 1;
        if ($j > $max_hits) {
            $j = $max_hits;
        }
        echo "$i-$j";
        if ($start != $i) {
            echo "</a>";
        }
        $tope=$tope+1;
        if ($tope>10) {
        	echo "<br>";
        	$tope=0;
        }
        $i += $number;
    }
}
?>
</td></tr>
</table>
</form>
</div>
<script language=javascript>
    function Transmitir(ixT, charset){
        var Cuenta
        var Opcion="<?php echo $arrHttp["Opcion"]?>"
        var Mfn=<?php if (isset($arrHttp["Mfn"])) echo $arrHttp["Mfn"]?>  //COPY TO AN EXISTENT RECORD
        campo=document.z3950.marc[ixT].value;
        if (campo=="") {
            alert("<?php echo $msgstr["z3950_empty"]?>")
            return
        }
        re = /\$/gi;
        campo=campo.replace(re,"^")
        i=campo.indexOf("\n"+"  ",0)
        while (i>0){
            campo=campo.substr(0,i-1)+campo.substr(i+2)
            i=campo.indexOf("\n"+"  ",0)
        }
        if (charset=="UTF-8") {
            campo=encodeURIComponent (campo)
        } else {
            campo=escape(campo)/* escape is deprecated. new function required*/
        }
        cnvtab=""
        igntab=""
        <?php if (isset($_SESSION["cnvtab"]))
        echo "\ncnvtab='&cnvtab=".urlencode($_SESSION["cnvtab"])."'\n";
        if (isset($_SESSION["igntab"]))
        echo "\nigntab='&igntab=".urlencode($_SESSION["igntab"])."'\n";
        ?>
        var x = document.getElementById("cpbutton_"+[ixT]);
        x.style.backgroundColor='green';/* indicates already processed */
        loc="z3950_copy.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["cipar"]?>"
        loc=loc+"&ValorCapturado="+campo+cnvtab+igntab
        if (Opcion=="edit"){
            loc=loc+"&Mfn="+Mfn
            window.opener.top.main.location=loc
            window.opener.top.main.focus()
        }else if(Opcion=="new"){
            loc=loc+"&Mfn=New"
            window.opener.top.main.location=loc
            window.opener.top.main.focus()
        } else {
            alert ( "<?php echo $msgstr["z3950_test"] ?>"+Opcion )
        }
    }
</script>
</body>
</html>
