<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";
//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";

?>

<form name=reserva method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>
<div id="page">
	<p>
    <h3>
    <?php
    echo $msgstr["WEBRESERVATION"]." &nbsp;";
    include("wiki_help.php");
/*
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	echo "<p><h4>".$msgstr["save"]." ".$msgstr["pft_res"]." ".$msgstr["in"]." ";
    echo $db_path."reserve/pfts/".$_REQUEST["lang"]."</h4>";
	echo "<p><strong>opac_reserve_h.txt</strong>";
	$fp=fopen($_REQUEST["db_path"]."reserve/pfts/".$_REQUEST["lang"]."/opac_reserve_h.txt","w");
	fwrite($fp,$msgstr["tit_nc"]."\n") ;
	fwrite($fp,$msgstr["tit_tit"]."\n");
	fwrite($fp,$msgstr["tit_rdate"]."\n");
	fwrite($fp,$msgstr["tit_wait"]."\n");
	fwrite($fp,$msgstr["tit_fcan"]."\n");
	fwrite($fp,$msgstr["tit_fpres"]."\n");
	fwrite($fp,$msgstr["tit_status"]."\n");
	fclose($fp);
	echo " ".$msgstr["updated"];
	echo "<p><strong>opac_reserve.pft</strong>";
	$fin=file("opac_reserve.pft");
	$fp=fopen($_REQUEST["db_path"]."reserve/pfts/".$_REQUEST["lang"]."/opac_reserve.pft","w");
	foreach ($fin as $value){
		fwrite($fp,$value);
	}
	fclose($fp);
	echo " ".$msgstr["updated"];
	die;
}
*/
$fp=file($db_path."/par/syspar.par");
foreach ($fp as $value){	$value=trim($value);
	if ($value!=""){		$x=explode('=',$value);
		$syspar_array[$x[0]]=$x[1];	}}
echo "<p>".$msgstr["ONLINESTATMENT"];
if (!isset($ONLINESTATMENT) or $ONLINESTATMENT!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";

echo "<p>".$msgstr["WEBRESERVATION"];
if (!isset($WEBRESERVATION) or $WEBRESERVATION!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";

echo "<H3><font color=red>".$msgstr["ols_required"]."</font></h3><p>";

if (!is_dir($db_path."reserve"))
	echo "<br><font color=red>".$msgstr["missing"]." ".$msgstr["reservations_db"]." (reserve)</font>";
if (!file_exists($db_path."par/reserve.par")){
	echo "<br><font color=red>".$msgstr["missing"]." "."reserve.par</font>";
}
/*echo "<p><h3>".$msgstr["pft_res"]." (reserve database)</h3>";
if (!is_dir($db_path."reserve/pfts/".$_REQUEST["lang"])){	echo "<font color=red><strong>",$msgstr["miss_folder"]." ".$db_path."reserve/pfts/".$_REQUEST["lang"];
}

if (is_dir($db_path."reserve/pfts/".$_REQUEST["lang"])){
	echo "<strong>opac_reserve_h.txt</strong><p>";	echo "<xmp>";
	echo $msgstr["tit_nc"]."\n";
	echo $msgstr["tit_tit"]."\n";
	echo $msgstr["tit_rdate"]."\n";
	echo $msgstr["tit_wait"]."\n";
	echo $msgstr["tit_fcan"]."\n";
	echo $msgstr["tit_fpres"]."\n";
	echo $msgstr["tit_status"]."\n";
	echo "</xmp>";
	echo "<hr>";
	echo "<strong>opac_reserve.pft</strong><p>";
	$fp=file("opac_reserve.pft");
	echo "<xmp>";
	foreach ($fp as $value){
		if ($charset=="UTF-8")
			echo utf8_encode($value);
		else
			echo $value;
	}
    echo "</xmp><p>";
    echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=submit name=formating value=\"".$msgstr["save"]." ".$msgstr["pft_res"]." ".$msgstr["in"]." ";
    echo $db_path."reserve/pfts/".$_REQUEST["lang"]."\">";
    echo "<form>\n";	//if (!file_exists($db_path."reserve/pfts/".$_REQUEST["lang"]))}
*/


echo "<h4>".$msgstr["minf_reservations"]." <a href=http://wiki.abcdonline.info target=_blank><font color=blue>wiki.abcdonline.info</font></a></h4>";

?>