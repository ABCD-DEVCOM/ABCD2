<?php
/* Modifications
2021-07-18 fho4abcd Rewrite: Improve html, header, div-helper, undefined indexes, add error messages
2023-04-18 fho4abcd Moved script to improve debugging.Improve link to stylesheet. Add translation+Standard Doctype
2023-04-18 fho4abcd Removed hostarray
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
global $marc8,$ansi;
    $retchar="\n";
    if ($inhtml==1) $retchar="<br>";
    reset($ar);
    $nl = "";
    $arcount=count($ar);
    for ( $i=0;$i<$arcount;$i++ ){
        $tagpath=$ar[$i][0];
        $data="";
        if (isset($ar[$i][1])) $data=$ar[$i][1];
     	$data=str_replace($marc8,$ansi,$data);
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

//get the conversion table from marc-8 to ansi
$file=$db_path."cnv/marc-8_to_ansi.tab";
$marc8=array ();
$ansi=array();
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $value){
		$ar=explode(" ",$value);
		$marc8[]=trim($ar[0]);
		$ansi[]=trim($ar[1]);
	}
}
unset($fp);

set_time_limit (120);// Yaz has its own limits. This is a crude fallback.
if(!isset($arrHttp['Opcion']) ) $arrHttp['Opcion']="";
$field = $arrHttp['field'];
$field1 = $arrHttp['field1'];
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

// Map the form selection values to z3950 search attributes
// See http://www.loc.gov/z3950/agency/defns/bib1.html
$fieldmap["Todos los campos"] = "@attr 1=1016"; // Bib-1 Use Attributes: Any
$fieldmap["Titulo"]           = "@attr 1=4";    // Bib-1 Use Attributes: Title
$fieldmap["Autor"]            = "@attr 1=1003"; // Bib-1 Use Attributes: Author
$fieldmap["ISBN"]             = "@attr 1=7";    // Bib-1 Use Attributes: ISBN
$fieldmap["ISSN"]             = "@attr 1=8";    // Bib-1 Use Attributes: ISSN
$fieldmap["Resumen"]          = "@attr 1=62";   // Bib-1 Use Attributes: Abstract
reset ($fieldmap);
//  if (empty($syntax)) $syntax = "usmarc";
$syntaxar["SUTRS"] = "sutrs";
$syntaxar["USMARC"] = "usmarc";
$syntaxar["GRS-1"] = "grs-1";
$syntaxar["OPAC"] = "opac";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" >
    <title>Z39.50</title>
    <link rel="stylesheet" rev="stylesheet" href="/assets/css/template.css?<?php echo time(); ?>" type="text/css" media="screen"/>
    <link href="/assets/css/all.min.css" rel="stylesheet"> 
  </head>
<body>

<?php include "../common/inc_div-helper.php";?>
<div class="middle form">

<?php
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

?>
<table border=0>
<tr>
    <td><?php echo $msgstr["z3950_server"];?></td><td>&rarr; </td><td><?php echo $host_spec;?></td>
</tr><tr>
    <td><?php echo $msgstr["z3950_yaz_syntax"];?></td><td>&rarr; </td><td><?php echo $syntax;?></td>
</tr><tr>
    <td><?php echo $msgstr["z3950_yaz_search"];?></td><td>&rarr; </td><td><?php echo $fullquery;?></td>
</tr>
</table>
<form method="get" name=z3950>
<table  cellspacing="0" cellpadding="3" border="0" bgcolor=--abcd-teal width=100%>
<?php
// $options=array("proxy"=>"localhost");
// $options may contain "charset" => ISO-8859-1, UTF-8, UTF-16.
// Most Z39.50 servers do not support this feature (is ignored).
// Many servers use the ISO-8859-1 encoding for queries and messages. MARC21/USMARC records are not affected by this setting. 
$options=array(); // 
//$options["charset"]="UTF-8";
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
    //echo $res;
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
        if ($errno==10007)$reintentar=$intentos;
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
        $ixreg=-1;
        for ($pos = $start; $pos < $end && $pos<=$max_hits; $pos++) {
            //$rec = yaz_record($id,$pos,"string; charset=marc-8,ISO-8859-1");var_dump($rec);echo "<br><br>";
            //$rec = yaz_record($id,$pos,"string; charset=marc-8,UTF-8");var_dump($rec);echo "<br><br>";
            //$ar = yaz_record($id,$pos,"array;");
            $rec = yaz_record($id,$pos,"string; charset=marc-8,xISO-8859-1");
            $ar = yaz_record($id,$pos,"array; charset=marc-8,xISO-8859-1");
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
            <tr><td align="left" valign="top">
            <?php
            $ixreg=$ixreg+1;
            echo "$pos/$max_hits<br><br><br>";
            if (is_array($ar)){
                if ($syntax == "GRS-1") {
                    print_structured_record($ar);
                } else {
                    // Show a button to copy the data
                    echo '<a href="javascript:Transmitir('.$ixreg.')">';
                    echo '<img src=img/capturar.gif border=0 alt="'.$msgstr["z3950_copytodb"].'" title="'.$msgstr["z3950_copytodb"].'"></a>';
                    echo '</td><td>';
                    // The textarea is required for copy of the data
                    // The textarea width does not react well on widening the window: hidden attribute
                    echo '<textarea cols=100% rows=20 name=marc hidden>';
                    echo "3005 $recStatus\n";
                    echo "3006 $typeOfrec\n";
                    echo "3007 $bibloLevel\n";
                    echo "3017 $encodingLevel\n";
                    echo "3019 $descriptive\n";
                    print_marc_record($ar);
                    echo '</textarea>';
                    // This is the html of the textarea : more readable
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
<tr><td align="center" bgcolor=white>
<?php
if ($max_hits > 0) {
    $host_url = "term=".urlencode($term);
    $host_url.= "&field=".urlencode($field);
    $host_url.= "&element=$element";
    $host_url.= "&syntax=$syntax";
    $host_url.= '&' . urlencode("host") . '=';
    $host_url.= urlencode($host_spec);
    $prev_start = $start - $number;
    $i = 1;
    echo '&nbsp;';
    $tope=0;
    while ($i < $max_hits  && $number > 1) {
        echo '&nbsp;';
        if ($start != $i) {
            $url = "z3950-01.php";
            $url.= "?start=".$i."&number=".$number."&reintentar=".$intentos;
            $url.= "&".$host_url."^s".$syntax."^f".$element;
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
		function Transmitir(ixT){
			var Cuenta
			var Opcion="<?php echo $arrHttp["Opcion"]?>"
			var Mfn=<?php if (isset($arrHttp["Mfn"])) echo $arrHttp["Mfn"]?>  //COPY TO AN EXISTENT RECORD
   			Seq="xx"
   			campo=document.z3950.marc[ixT].value; alert(campo);
    		if (campo=="") {
    			alert("<?php echo $msgstr["r_selreg"]?>")
           		return
      		}
       		re = /\$/gi;
	       	campo=campo.replace(re,"^")
    		i=campo.indexOf("\n"+"  ",0)
			while (i>0){
				campo=campo.substr(0,i-1)+campo.substr(i+2)
	      		i=campo.indexOf("\n"+"  ",0)
			}
			campo=escape(campo)
			cnvtab=""
			<?php if (isset($_SESSION["cnvtab"]))
			echo "\ncnvtab='&cnvtab=".urlencode($_SESSION["cnvtab"])."'\n";
			?>
			if (Opcion=="edit"){
				loc="z3950_copy.php?userid=g&Opcion=capturar&ver=N&Mfn="+Mfn+"&base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["cipar"]?>&Opcion_z="+Opcion
				loc=loc+"&ValorCapturado="+campo+cnvtab
       			window.opener.top.main.location=loc
       			document.z3950.marc[ixT].value=""
				window.opener.top.main.focus()
			}else if(Opcion=="new"){
				loc="z3950_copy.php?userid=g&Opcion=capturar&ver=N&Mfn=New&base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["cipar"]?>&Opcion_z="+Opcion
				loc=loc+"&ValorCapturado="+campo+cnvtab
       			window.opener.top.main.location=loc
       			document.z3950.marc[ixT].value=""
				window.opener.top.main.focus()
			} else {
                alert ( "<?php echo $msgstr["z3950_test"] ?>"+Opcion )
            }
   		}
   </script>
</body>
</html>
