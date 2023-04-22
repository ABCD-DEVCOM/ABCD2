<?php

/* Modifications
2021-02-03 guilda execute in  opac/config  the option Statment, renovation and reserve -> Web renovation.
2021-02-03 guilda Check the url and paths are OK, $CentralHttp defined in central/config_opac.php specifies the url to be used to access the ABCD central/circulation module.
2021-02-03 guilda In this way the same scripts used in central are used in the opac
*/


include ("tope_config.php");
$wiki_help="OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";
include "../../common/inc_div-helper.php";

?>

<div class="middle form">
   <h3><?php echo $msgstr["WEBRESERVATION"];?>
	</h3>
	<div class="formContent">

<div id="page">


<form name=reserva method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>

    <?php

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
foreach ($fp as $value){
	$value=trim($value);
	if ($value!=""){
		$x=explode('=',$value);
		$syspar_array[$x[0]]=$x[1];
	}
}
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
if (!is_dir($db_path."reserve/pfts/".$_REQUEST["lang"])){
	echo "<font color=red><strong>",$msgstr["miss_folder"]." ".$db_path."reserve/pfts/".$_REQUEST["lang"];
}

if (is_dir($db_path."reserve/pfts/".$_REQUEST["lang"])){
	echo "<strong>opac_reserve_h.txt</strong><p>";
	echo "<xmp>";
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
			echo mb_convert_encoding($value,'UTF-8', 'ISO-8859-1');;
		else
			echo $value;
	}
    echo "</xmp><p>";
    echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=submit name=formating value=\"".$msgstr["save"]." ".$msgstr["pft_res"]." ".$msgstr["in"]." ";
    echo $db_path."reserve/pfts/".$_REQUEST["lang"]."\">";
    echo "<form>\n";
	//if (!file_exists($db_path."reserve/pfts/".$_REQUEST["lang"]))
}
*/


echo "<h4>".$msgstr["minf_reservations"]." <a href=http://wiki.abcdonline.info target=_blank><font color=blue>wiki.abcdonline.info</font></a></h4>";

?>

</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>