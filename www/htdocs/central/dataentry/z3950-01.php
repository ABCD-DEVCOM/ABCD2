<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950-01.php
 * @desc:      Get records from the z3950 server
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
error_reporting(E_ALL & ~E_NOTICE);

include("../config.php");
include("../lang/admin.php");
include("../common/get_post.php");

if (isset($arrHttp["cnvtab"]) ) {
	$_SESSION["cnvtab"] = $arrHttp["cnvtab"];
}else{
	unset($_SESSION["cnvtab"]);
}

//get the conversion table from marc-8 to ansi
$file=$db_path."cnv/marc-8_to_ansi.tab";
$marc8=array ();
$ansi=array();
if (file_exists($file)){	$fp=file($file);
	foreach ($fp as $value){		$ar=explode(" ",$value);
		$marc8[]=trim($ar[0]);
		$ansi[]=trim($ar[1]);	}}
unset($fp);
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";

	set_time_limit (120);
    $term = $arrHttp['term'];
    $field = $arrHttp['field'];
    $addr =$arrHttp['host'];
	$addrhost=explode("\n",$addr);
	$intentos= $arrHttp['reintentar'];
	$isbn=explode("\n",$arrHttp['isbn_l']);
	$expr_isbn="";
	$i=0;
	foreach ($isbn as $linea) {
		if (trim($linea)!="") $expr_isbn="@or ".$expr_isbn." @attr 1=7 ".$linea." ";
	}
    $expr_isbn=trim($expr_isbn);
	if ($expr_isbn!="")$expr_isbn=substr($expr_isbn,4);
//	echo "Expresion= ".$expr_isbn."-";
$jhost=-1;
$host=Array();
	foreach ($addrhost as $linea){

		$jhost=$jhost+1;
		$i=strpos($linea,"^");
		$host[$jhost]=substr($linea,0,$i);
		$linea=substr($linea,$i+2);
		$i=strpos($linea,"^");
		$syntax=substr($linea,0,$i);
		$linea=substr($linea,$i+2);
		$element=substr($linea,0,strlen($linea));
	}
    $number = $arrHttp['number'];
    $start = $arrHttp['start'];
    if(!empty($term)) {
        $term = stripslashes($term);
//        echo ' Expresión de búsqueda: ' . htmlspecialchars($term);
    }
    include("../common/header.php");
?>
    <title>Z39.50
	</title>
	<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script languaje=javascript>
		function Transmitir(ixT){
			var Cuenta
			var Opcion="<?php echo $arrHttp["Opcion"]?>"
			var Mfn=<?php if (isset($arrHttp["Mfn"])) echo $arrHttp["Mfn"]?>  //COPY TO AN EXISTENT RECORD
   			Seq="xx"
   			campo=document.z3950.marc[ixT].value
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
			if (Opcion=="edit"){				loc="z3950_copy.php?userid=g&Opcion=capturar&ver=N&Mfn="+Mfn+"&base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["cipar"]?>&Opcion_z="+Opcion
				loc=loc+"&ValorCapturado="+campo+cnvtab
       			window.opener.top.main.location=loc
       			document.z3950.marc[ixT].value=""
				window.opener.top.main.focus()			}else{
				loc="z3950_copy.php?userid=g&Opcion=capturar&ver=N&Mfn=New&base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["cipar"]?>&Opcion_z="+Opcion
				loc=loc+"&ValorCapturado="+campo+cnvtab
       			window.opener.top.main.location=loc
       			document.z3950.marc[ixT].value=""
				window.opener.top.main.focus()
			}
   		}
   </script>
  </head>
<body >
<div class="middle form">
		<div class="formContent">
Host: <?php echo $host[0]?>
<form method="get" name=z3950>


<?php
    $fieldmap["Todos los campos"] = "@attr 1=1016";
    $fieldmap["Título"] = "@attr 1=4";
    $fieldmap["Autor"] = "@attr 1=1003";
    $fieldmap["ISBN"] = "@attr 1=7";
    $fieldmap["ISSN"] = "@attr 1=8";
    $fieldmap["EDITORIAL"] = "";
    $fieldmap["Resumen"] = "@attr 1=62";

    reset ($fieldmap);
  //  if (empty($syntax)) $syntax = "usmarc";
        $syntaxar["SUTRS"] = "sutrs";
        $syntaxar["USMARC"] = "usmarc";
        $syntaxar["GRS-1"] = "grs-1";
		$syntaxar["OPAC"] = "opac";

?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/z3950-01.html"?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 <?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/z3950-01.html target=_blank>".$msgstr["edhlp"]."</a>";
 echo "&nbsp; &nbsp; Script: z3950.php" ?></font>
</div>
<table width="100%" cellspacing="0" cellpadding="3" border="0" bgcolor="#4E617C">
<?php
function print_structured_record($ar) {
    reset($ar);
    while(list($key,list($tagpath,$data))=each($ar)) {
        echo $tagpath . $data . "<br>\n";
    }

}

function print_marc_record($ar) {
global $marc8,$ansi;
    reset($ar);
    $nl = "";
    while(list($key,list($tagpath,$data))=each($ar)) {
     	$data=str_replace($marc8,$ansi,$data);
        if (preg_match("/^\(3,([^)]*)\)\(3,@\)$/",$tagpath,$res)) {
            echo $res[1] . ' ' . htmlspecialchars($data) . "\n";
        } elseif (preg_match("/^\(3,([^)]*)\)\(3,([^)]*)\)$/",$tagpath,$res)) {
            echo $nl;
            $nl = "";
            echo $res[1] . ' ' . $res[2]; //ereg_replace(" ", "_", $res[2]);
        } elseif (preg_match("/^\(3,([^)]*)\)\(3,([^)]*)\)\(3,([^)]*)\)$/",$tagpath,$res)) {
            echo '^' . $res[3] . htmlspecialchars($data) . "";
            $nl="\n";
        }
    }
    echo $nl;
}


$max_hits = 0;
$num_hosts = count($host);
if ((!empty($term)||$expr_isbn!="") && $num_hosts > 0)
{
	$fullquery="";

    if (empty($start)) $start = 1;
    if (empty($number)) $number = 10;
	if(!empty($term)){
    	$nterm = str_replace('"', "", $term);
    	$oterm = str_replace('\\', "",  $nterm);
    	$oterm = str_replace('?', "",  $oterm);
    	$oterm = str_replace('$', "",  $oterm);
    	if (strcmp($oterm,$nterm)) {
        	$trunc_right="@attr 6=1";
    	} else {
        	$trunc_right="";
    	}
    	$fullquery = $fieldmap[$field] . $trunc_right . ' "' . $oterm . '"';
	}
	if ($fullquery!="" && $expr_isbn!=""){
		$fullquery="@or ".$expr_isbn ." " .$fullquery;
	}else{
		if ($expr_isbn!="") $fullquery=$expr_isbn;
	}
//    $options=array("proxy"=>"localhots");
    $options=array();
	for ($reintentar=0;$reintentar<=$intentos;$reintentar++){
    	for ($i = 0; $i < $num_hosts; $i++) {
        	$id = yaz_connect($host[$i],$options);
        	$ids[$i] = $id;
        	if ($id <= 0) continue;
        	if (!yaz_search($id,"rpn",$fullquery)) {
            	echo $msgstr["expr_err"].'<br>';
				$reintentar=999;
            	break;
        	}
        	if ($number > 1) {
            	yaz_element($id,$element);
        	} else {
            	yaz_element($id,"F");
        	}
        	yaz_syntax($id,$syntax);
        	yaz_range($id,$start,$number);
    	}

    	$res=yaz_wait();
    	//echo $res;
    	$host_url= "term=" . urlencode($term) . "&field=";
    	$host_url.= urlencode($field) . "&";
    	$host_url.= "element=$element&syntax=$syntax";
   		for ($i = 0; $i < $num_hosts; $i++){
        	$id = $ids[$i];
        	if ($id <= 0) continue;
        	$error = yaz_error($id);
        	$errno = yaz_errno($id);
        	$addinfo = yaz_addinfo($id);
        	echo '<tr>';
        	$attempt=$reintentar+1;
        	if ($errno)
        	{
            	echo '<td align="center">';
             	echo '<table cellspacing="0" cellpadding="2" width="97%" border="0"><tr><td>';
				echo $msgstr["attempt"].": $attempt &nbsp; ";
          //   	echo "$host[$i] &nbsp; ";

            	echo "Error: $error (code $errno) $addinfo";
            	echo "</td></tr></table>\n";
            	echo "</td></tr>";
        	} else {
            	echo '<td align="center">';
           		echo '<table cellspacing="0" cellpadding="2" width="97%" border="0"><tr><td>';
           		$hits = yaz_hits($id);
           		if ($hits > $max_hits) {
               		$max_hits = $hits;
           		}

				echo $msgstr["attempt"].": $attempt<br>";
           		echo $msgstr["registros"]." <b>$hits</b> ";
				$reintentar=999;
           		echo "</td></tr></table>\n";
   	        	echo "</td></tr>";
       	    	$end = $start + $number;
				$ixreg=-1;
           		for ($pos = $start; $pos < $end; $pos++) {

               		$rec = yaz_record($id,$pos,"string; charset=marc-8,xISO-8859-1");
               		$ar = yaz_record($id,$pos,"array; charset=marc-8,xISO-8859-1");
               	//	$ar = yaz_record($id,$pos,"array");
               //		$rec = yaz_record($id,$pos,"string");
               	//	$rec=$ar[0];
               //	echo "<xmp>$rec</xmp>";
               		$recStatus=substr($rec,5,1);
               		$typeOfrec=substr($rec,6,1);
               		$bibloLevel=substr($rec,7,1);
               		$encodingLevel=substr($rec,17,1);
               		$descriptive=substr($rec,19,1);
               	//	$syntax = yaz_record($id,$pos,"syntax");
               		if (empty($rec) && !is_array($ar)) {
                   		continue;
               		}
               		echo '<tr><td align="center"><table cellspacing="0" cellpadding="2" width="97%"  border="0" bgcolor="#000000">';
               		echo "\n";
               		echo '<tr><td align="center"><table cellspacing="0" cellpadding="0" width="100%" border="0" bgcolor="#ffffff">';
               		echo "\n";
               		echo '<tr><td width="4%" align="left" valign="top">';
               		echo "\n";
					$ixreg=$ixreg+1;
					echo "$pos/$max_hits<br>";
               		if (is_array($ar)){
                   		if ($syntax == "GRS-1") {                    		print_structured_record($ar);
                   		} else {
							echo '<table cellspacing="0" cellpadding="2" border="0"><tr><td align="center" class=td>';
							echo '<a href="javascript:Transmitir('.$ixreg.')"><img src=img/capturar.gif border=0 alt="Copy to the database"></a>';

           		  			echo '</td></tr></table></td><td width="96%">';
               				echo '<table cellspacing="3"><tr><td>';
							echo '<textarea cols=100% rows=20 name=marc>';
							echo "3005 $recStatus\n";
							echo "3006 $typeOfrec\n";
							echo "3007 $bibloLevel\n";
							echo "3017 $encodingLevel\n";
							echo "3019 $descriptive\n";
                    		print_marc_record($ar);
                    	//	echo htmlspecialchars($rec);
							echo '</textarea>';
							echo "</td></tr></table></td></tr>";
                   		}
               		} else {
                   		if ($syntax == "XML") {
                       		$rec = htmlspecialchars($rec);
                   		}
                   		$br_rec = ereg_replace("\n", "<br>\n", $rec);
                   		echo "3006 $typeOfrec\n".$br_rec;
               		}

               		echo "</table></td></tr></table>\n";
				}
			}
        }
    }
}
echo '</tr><tr><td align="center">';
echo '<table cellspacing="0" cellpadding="2" width="97%" border="0" bgcolor=white><tr><td>';

if ($max_hits > 0)
{
    for ($i = 0; $i < $num_hosts; $i++)
    {
        $host_url .= '&' . urlencode("host") . '=';
        $host_url .= urlencode($host[$i]);
    }
    $prev_start = $start - $number;
    $i = 1;
    echo '&nbsp;';
    $tope=0;
    while ($i < $max_hits  && $number > 1) {
        echo '&nbsp;';
        if ($start != $i) {
            echo '<a href=z3950-01.php?';
            echo "start=$i&number=$number&reintentar=$intentos&";
            echo $host_url."^s$syntax^f$element";
            if (isset($_SESSION["cnvtab"])) echo "&cnvtab=".$_SESSION["cnvtab"];
            echo '&base='.$arrHttp["base"]."&cipar=".$arrHttp["base"].'.par>';
        }
        $j = $i + $number - 1;
        if ($j > $max_hits)
        {
            $j = $max_hits;
        }
        echo "$i-$j";
        if ($start != $i) {
            echo '</a>';
        }
        $tope=$tope+1;
        if ($tope>10){        	echo "<br>";
        	$tope=0;        }
        $i += $number;
    }
}

echo '</td></tr></table></td></tr>';
?>
</table>
</td></tr>
</table>
<input type=hidden name=marc>
</form>
</div></div>
</body>
</html>
